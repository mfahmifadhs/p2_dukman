<?php

namespace App\Http\Controllers;

use App\Mail\mailToken;
use App\Models\Aadb;
use App\Models\Atk;
use App\Models\AtkKategori;
use App\Models\AtkKeranjang;
use App\Models\AtkStok;
use App\Models\AtkStokDetail;
use App\Models\Bmhp;
use App\Models\BmhpKategori;
use App\Models\BmhpKeranjang;
use App\Models\Form;
use App\Models\GdnPerbaikan;
use App\Models\UnitKerja;
use App\Models\User;
use App\Models\Usulan;
use App\Models\UsulanAtk;
use App\Models\UsulanBbm;
use App\Models\UsulanBmhp;
use App\Models\UsulanDetail;
use App\Models\UsulanServis;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Str;
use Auth;
use Illuminate\Support\Facades\Mail;

class UsulanController extends Controller
{
    public function show(Request $request, $id)
    {
        $user = Auth::user();
        $role = Auth::user()->role_id;
        $data = Usulan::orderBy('id_usulan', 'desc');
        $listUker = UnitKerja::get();

        $form   = Form::where('kode_form', $id)->first();
        $formId = $request->form;
        $bulan  = $request->bulan;
        $tahun  = $request->tahun;
        $uker   = $request->uker;
        $status = $request->status;

        if ($role == 4) {
            $data = $data->where('user_id', $user->id)->count();
        } else {
            $data = $data->count();
        }

        return view('pages.usulan.show', compact('form', 'formId', 'bulan', 'tahun', 'uker', 'status', 'data', 'uker', 'listUker'));
    }

    public function detail($id)
    {
        $data = Usulan::where('id_usulan', $id)->first();
        return view('pages.usulan.detail', compact('data'));
    }

    public function select(Request $request, $id)
    {
        $role    = Auth::user()->role_id;
        $bulan   = $request->bulan;
        $tahun   = $request->tahun;
        $uker    = $request->uker;
        $status  = $request->status;
        $form    = $request->formId;

        $aksi    = $request->aksi;
        $id      = $request->id;
        $data    = Usulan::orderBy('status_persetujuan', 'asc')->orderBy('status_proses', 'asc')->orderBy('tanggal_usulan', 'desc')
            ->join('t_form', 'id_form', 'form_id')
            ->where('kode_form', $id);
        $no       = 1;
        $response = [];

        if ($form || $bulan || $tahun || $uker || $status) {
            if ($form) {
                $res = $data->where('form_id', $form);
            }

            if ($bulan) {
                $res = $data->whereMonth('tanggal_usulan', $bulan);
            }

            if ($tahun) {
                $res = $data->whereYear('tanggal_usulan', $tahun);
            }

            if ($uker) {
                $res = $data->whereHas('user.pegawai', function ($query) use ($uker) {
                    $query->where('uker_id', $uker);
                });
            }

            if ($status == 'verif') {
                $res = $data->whereNull('status_persetujuan');
            }

            if ($status == 'false') {
                $res = $data->where('status_persetujuan', $status);
            }

            if ($status == 'proses' || $status == 'selesai') {
                $res = $data->where('status_proses', $status);
            }

            $result = $res;
        } else if ($aksi == 'status_proses_id') {
            $result = $data->where($aksi, $id);
        } else if ($aksi == 'status_pengajuan_id') {
            $result = $data->where($aksi, $id);
        } else {
            $result = $data;
        }

        if ($role == 4) {
            $result = $result->where('user_id', Auth::user()->id)->get();
        } else {
            $result = $result->get();
        }

        foreach ($result as $row) {

            if ($row->status_persetujuan == 'true') {
                $status = '<span class="badge badge-success p-1 w-100"><i class="fas fa-check-circle"></i> Setuju</span>';
            } else if ($row->status_persetujuan == 'false') {
                $status = '<span class="badge badge-danger p-1 w-100"><i class="fas fa-times-circle"></i> Tolak</span>';
            } else if (!$row->otp_1) {
                $status = '<span class="badge badge-danger p-1 w-100"><i class="fas fa-exclamation-circle"></i> Verif</span>';
            } else {
                $status = '<span class="badge badge-warning p-1 w-100"><i class="fas fa-clock"></i> Pending</span>';
            }

            if ($row->status_proses == 'proses') {
                $proses = '<span class="badge badge-warning p-1 w-100"><i class="fas fa-clock"></i> Proses</span>';
            } else if ($row->status_proses == 'selesai') {
                $proses = '<span class="badge badge-success p-1 w-100"><i class="fas fa-check-circle"></i> Selesai</span>';
            } else {
                $proses = '';
            }

            $aksi = '';


            $aksi .= '
                <a href="' . route('usulan.detail', $row->id_usulan) . '" class="btn btn-default btn-xs bg-primary rounded border-dark">
                    <i class="fas fa-info-circle p-1" style="font-size: 12px;"></i>
                </a>';

            if (Auth::user()->akses_id == 1 && !$row->status_persetujuan) {
                $aksi .= '
                    <a href="' . route('usulan.verif', $row->id_usulan) . '" class="btn btn-default btn-xs bg-warning rounded border-dark">
                        <i class="fas fa-file-signature p-1" style="font-size: 12px;"></i>
                    </a>';
            }

            if ((in_array(Auth::user()->akses_id, [2, 3]) || Auth::user()->id == 25) && $row->status_proses == 'proses') {
                $aksi .= '
                    <a href="' . route('usulan.proses', $row->id_usulan) . '" class="btn btn-default btn-xs bg-warning rounded border-dark">
                        <i class="fas fa-file-import p-1" style="font-size: 12px;"></i>
                    </a>';
            }

            if ($row->form_id == 3 || $row->form_id == 6) {
                $hal = $row->keterangan;
            } else if ($row->form_id == 5) {
                $hal = 'Permintaan BBM ' . Carbon::parse($row->tanggal_selesai)->isoFormat('MMMM Y');
            } else if ($row->form_id == 4) {
                $hal = $row->detailServis->map(function ($item) {
                    return Str::limit(' ' . $item->uraian, 150);
                });
            } else {
                $hal = $row->detail->map(function ($item) {
                    return Str::limit(' ' . $item->judul, 150);
                });
            }

            $response[] = [
                'no'        => $no,
                'id'        => $row->id_usulan,
                'aksi'      => $aksi,
                'kode'      => $row->kode_usulan,
                'tanggal'   => Carbon::parse($row->tanggal_usulan)->isoFormat('DD MMM Y'),
                'uker'      => ucwords(strtolower($row->user?->pegawai->uker->unit_kerja)),
                'nosurat'   => $row->nomor_usulan ?? '-',
                'totalItem' => $row->detail->count(),
                'hal'       => $hal,
                'deskripsi' => $row->detail->map(function ($item) {
                    return $item->uraian . ', ' . $item->keterangan;
                }),
                'status'     => $status . '<br>' . $proses
            ];

            $no++;
        }

        return response()->json($response);
    }

    // ===========================================================
    //                            VERIF
    // ===========================================================

    public function verif(Request $request, $id)
    {
        $cekData = Usulan::where('id_usulan', $id)->first();

        if (!$request->all() && $cekData->status_persetujuan) {
            return redirect()->route('usulan.detail', $id)->with('failed', 'Permintaan tidak dapat di proses');
        }

        if (!$request->all()) {
            $data = Usulan::where('id_usulan', $id)->first();
            $form = $data->form->kode_form;
            return view('pages.usulan.verif', compact('id', 'data', 'form'));
        } else {
            $data = Usulan::with('form', 'user.pegawai.uker')->where('id_usulan', $id)->first();

            $otp3 = rand(111111, 999999);
            $tokenMail = Str::random(32);
            // $logMail = new LogMail();
            // $logMail->token   = $tokenMail;
            // $logMail->save();

            $dataMail = [
                'token' => $tokenMail,
                'nama'  => $data->user->pegawai->nama_pegawai,
                'uker'  => $data->user->pegawai->uker->unit_kerja,
                'otp'   => $otp3
            ];

            // Mail::to($data->user->email)->send(new mailToken($dataMail));

            if ($request->persetujuan == 'true') {
                $format = $this->nomorNaskah($request);
            }

            if ($data->form_id == 5) {
                $tanggal = $data->tanggal_selesai;
            } else {
                $tanggal = $request->tanggal_selesai;
            }

            Usulan::where('id_usulan', $id)->update([
                'verif_id'           => Auth::user()->pegawai_id,
                'nomor_usulan'       => $request->persetujuan == 'true' ? $format : null,
                'status_persetujuan' => $request->persetujuan,
                'status_proses'      => $request->persetujuan == 'true' ? 'proses' : null,
                'keterangan_tolak'   => $request->alasan_penolakan ?? null,
                'tanggal_selesai'    => $tanggal,
                'otp_2'              => $request->persetujuan == 'true' ? rand(111111, 999999) : null,
                'otp_3'              => $otp3,
                'tanggal_usulan'     => $data->tanggal_usulan
            ]);

            if ($data->form_id == 3) {
                UsulanAtk::where('usulan_id', $id)->update([
                    'status' => 'true'
                ]);
            }

            if ($data->form_id == 6) {
                UsulanBmhp::where('usulan_id', $id)->update([
                    'status' => 'true'
                ]);
            }

            return redirect()->route('usulan.detail', $id)->with('success', 'Berhasil Melakukan Verifikasi');
        }
    }

    // ===========================================================
    //                           CREATE
    // ===========================================================

    public function create($id)
    {
        if ($id == 'servis') {
            $uker = Auth::user()->pegawai->uker_id;
            $aadb = Aadb::where('uker_id', $uker)->where('status', 'true')->orderBy('merk_tipe', 'asc')->get();
            return view('pages.usulan.aadb.servis.create', compact('aadb'));
        }

        if ($id == 'bbm') {
            $uker = Auth::user()->pegawai->uker_id;
            $aadb = Aadb::where('uker_id', $uker)->where('status', 'true')->orderBy('kualifikasi', 'desc')->orderBy('kategori_id', 'asc')->get();
            return view('pages.usulan.aadb.bbm.create', compact('aadb'));
        }

        if ($id == 'pinjam') {
            $uker = Auth::user()->pegawai->uker_id;
            $aadb = Aadb::where('uker_id', $uker)->where('status', 'true')->orderBy('kualifikasi', 'desc')->orderBy('kategori_id', 'asc')->get();
            return view('pages.usulan.aadb.pinjam.create', compact('aadb'));
        }

        $gdn = GdnPerbaikan::orderBy('jenis_perbaikan', 'asc')->get();
        return view('pages.usulan.' . $id . '.create', compact('gdn'));
    }

    public function store(Request $request, $id)
    {
        $akses = Auth::user()->akses_id;

        // INPUT STOK ATK ====================================================================
        if (!$request->pengusul && $akses == 3) {
            // return redirect()->route('atk-stok.store', http_build_query($request->all()));
            $id_stok = AtkStok::withTrashed()->count() + 1;

            $detail = $request->id_keranjang;
            foreach ($detail as $i => $keranjang_id) {
                $id_detail = AtkStokDetail::withTrashed()->count() + 1;
                $detail = new AtkStokDetail();
                $detail->id_detail  = $id_detail;
                $detail->stok_id    = $id_stok;
                $detail->atk_id     = $request->id_atk[$i];
                $detail->jumlah     = $request->jumlah[$i];
                $detail->created_at = Carbon::now();
                $detail->save();

                AtkKeranjang::where('id_keranjang', $keranjang_id)->delete();
            }

            $stok = new AtkStok();
            $stok->id_stok       = $id_stok;
            $stok->kode_stok     = strtoupper(Str::random(6));
            $stok->tanggal_beli  = $request->tanggal;
            $stok->keterangan    = $request->keterangan;
            $stok->created_at    = Carbon::now();
            $stok->save();

            return redirect()->route('atk-stok.detail', $id_stok)->with('success', 'Berhasil Menambahkan');
        }
        // =================================================================================

        if ($id == 'servis') {
            $request->validate([
                'file' => 'required|mimes:pdf|max:2048',
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('dist/file/dakung/servis'), $fileName);
            }

            $form = Form::where('id_form', 4)->first();
        } else if ($id == 'bbm') {
            $form = Form::where('id_form', 5)->first();
        } else {
            $form = Form::where('kode_form', $id)->first();
        }

        $kode = strtoupper(Str::random(6));
        $otp  = rand(111111, 999999);
        $verif = User::where('akses_id', 1)->first();
        $user  = User::where('id', $request->pengusul)->first();
        $id_usulan = Usulan::withTrashed()->count() + 1;

        $tambah = new Usulan();
        $tambah->id_usulan       = $id_usulan;
        $tambah->user_id         = $request->cito == 'true' ? $user->id : Auth::user()->id;
        $tambah->pegawai_id      = $request->cito == 'true' ? $user->pegawai_id : Auth::user()->pegawai_id;
        $tambah->form_id         = $form->id_form;
        $tambah->kode_usulan     = $kode;
        $tambah->tanggal_usulan  = $request->tanggal ?? Carbon::now();
        $tambah->file_pendukung  = $fileName ?? null;
        $tambah->keterangan      = !in_array($form->kode_form, ['ukt', 'gdn', 'aadb']) ? $request->keterangan : null;
        $tambah->otp_1           = $otp;
        $tambah->tanggal_selesai = $form->id_form == 5 ? Carbon::parse($request->bulan_permintaan . '-01') : null;
        $tambah->created_at      = Carbon::now();

        if ($request->cito == 'true') {
            $format = $this->nomorNaskah($request);

            $tambah->verif_id           = $verif->pegawai_id;
            $tambah->nomor_usulan       = $format;
            $tambah->nama_penerima      = $request->penerima;
            $tambah->status_persetujuan = 'true';
            $tambah->status_proses      = 'selesai';
            $tambah->tanggal_selesai    = $request->tanggal ?? Carbon::now();
            $tambah->otp_2              = $otp;
            $tambah->otp_3              = $otp;
            $tambah->otp_4              = $otp;
        }

        $tambah->save();

        if ($form->id_form == 1 || $form->id_form == 2) {
            $this->storeDetail($request, $id_usulan);
        }

        if ($form->id_form == 3) {
            $this->storeAtk($request, $id_usulan);
        }

        if ($form->id_form == 4) {
            $this->storeServis($request, $id_usulan);
        }

        if ($form->id_form == 5) {
            $this->storeBbm($request, $id_usulan);
        }

        if ($form->id_form == 6) {
            $this->storeBmhp($request, $id_usulan);
        }

        return redirect()->route('usulan.detail', $id_usulan)->with('success', 'Berhasil Menambahkan');
    }

    public function storeDetail(Request $request, $id)
    {
        $uraian = $request->uraian;
        foreach ($uraian as $i => $uraian) {
            $id_detail = UsulanDetail::withTrashed()->count() + 1;
            $detail = new UsulanDetail();
            $detail->id_detail   = $id_detail;
            $detail->usulan_id   = $id;
            $detail->kategori_id = $request->kategori[$i] ?? null;
            $detail->judul       = $request->judul[$i];
            $detail->uraian      = $uraian;
            $detail->keterangan  = $request->keterangan[$i];
            $detail->created_at  = Carbon::now();
            $detail->save();
        }

        return;
    }

    public function storeAtk(Request $request, $id)
    {
        $atk = $request->id_atk;
        foreach ($atk as $i => $atk_id) {
            $atkSelect = Atk::where('id_atk', $atk_id)->first();
            $id_detail = UsulanAtk::withTrashed()->count() + 1;
            $detail = new UsulanAtk();
            $detail->id_detail  = $id_detail;
            $detail->usulan_id  = $id;
            $detail->atk_id     = $atk_id;
            $detail->jumlah     = $request->jumlah[$i];
            $detail->satuan_id  = $atkSelect->satuan_id;
            $detail->harga      = $atkSelect->harga;
            $detail->jumlah     = $request->jumlah[$i];
            $detail->keterangan = $request->keterangan_permintaan[$i];
            $detail->created_at = Carbon::now();
            $detail->save();

            AtkKeranjang::where('id_keranjang', $request->id_keranjang[$i])->delete();
        }

        return;
    }

    public function storeBmhp(Request $request, $id)
    {
        $bmhp = $request->id_bmhp;
        foreach ($bmhp as $i => $bmhp_id) {
            $bmhpSelect = Bmhp::where('id_bmhp', $bmhp_id)->first();
            $id_detail = UsulanBmhp::withTrashed()->count() + 1;
            $detail = new UsulanBmhp();
            $detail->id_detail  = $id_detail;
            $detail->usulan_id  = $id;
            $detail->bmhp_id    = $bmhp_id;
            $detail->jumlah     = $request->jumlah[$i];
            $detail->satuan_id  = $bmhpSelect->satuan_id;
            $detail->harga      = $bmhpSelect->harga;
            $detail->jumlah     = $request->jumlah[$i];
            $detail->keterangan = $request->keterangan_permintaan[$i];
            $detail->created_at = Carbon::now();
            $detail->save();

            BmhpKeranjang::where('id_keranjang', $request->id_keranjang[$i])->delete();
        }

        return;
    }

    public function storeServis(Request $request, $id)
    {
        $aadb = $request->aadb;
        foreach ($aadb as $i => $aadb_id) {
            $id_detail = UsulanServis::withTrashed()->count() + 1;
            $detail = new UsulanServis();
            $detail->id_detail   = $id_detail;
            $detail->usulan_id   = $id;
            $detail->aadb_id     = $aadb_id;
            $detail->uraian      = $request->uraian[$i];
            $detail->keterangan  = $request->keterangan[$i];
            $detail->created_at  = Carbon::now();
            $detail->save();
        }

        return;
    }

    public function storeBbm(Request $request, $id)
    {
        $aadb = $request->aadb;
        foreach ($aadb as $aadb_id) {
            $id_detail = UsulanBbm::withTrashed()->count() + 1;
            $detail = new UsulanBbm();
            $detail->id_detail   = $id_detail;
            $detail->usulan_id   = $id;
            $detail->aadb_id     = $aadb_id;
            $detail->save();
        }

        return;
    }

    public function nomorNaskah(Request $request)
    {
        $data     = Usulan::where('id_usulan', $request->usulan)->first();

        $dataForm = $request->form_id ?? $data->form_id;
        $pengusul = $request->pengusul ?? $data->user_id;
        $tanggal  = $request->tanggal ?? $data->tanggal_usulan;

        // 2/OUT/41/3/2025
        $form  = Form::where('id_form', $dataForm)->first();
        $user  = User::where('id', $pengusul)->first();
        $nomor = Usulan::where('form_id', $form->id_form)->where('status_persetujuan', 'true')->count() + 1;
        $uker  = UnitKerja::where('id_unit_kerja', $user->pegawai->uker_id)->first();
        $bulan = Carbon::parse($tanggal)->isoFormat('MM');
        $tahun = Carbon::parse($tanggal)->isoFormat('Y');

        if ($form->id_form == 3) {
            $format = $nomor . '/OUT/' . $uker->kode_atk . '/' . $bulan . '/' . $tahun;
        }

        if ($form->id_form != 3) {
            $nomor  = Usulan::whereHas('pegawai', function ($query) use ($user) {
                $query->where('status_persetujuan', 'true')->where('uker_id', $user->pegawai->uker_id)->whereYear('tanggal_usulan', Carbon::now()->format('Y'));
            })->count() + 1;
            $tahun = Carbon::now()->isoFormat('Y');

            $format = $form->klasifikasi . '/' . $uker->kode_surat . '/' . $nomor . '/' . $tahun;
        }

        // $klasifikasi = $form->klasifikasi;
        // $kodeSurat   = $user->pegawai->uker->kode_surat;
        // $nomorSurat  = Usulan::whereHas('pegawai', function ($query) use ($user) {
        //     $query->where('status_persetujuan', 'true')->where('uker_id', $user->pegawai->uker_id)->whereYear('tanggal_usulan', Carbon::now()->format('Y'));
        // })->count() + 1;
        // $tahunSurat = Carbon::now()->format('Y');
        // $format     = $klasifikasi . '/' . $kodeSurat . '/' . $nomorSurat . '/' . $tahunSurat;
        return $format;
    }

    // ===========================================================
    //                            EDIT
    // ===========================================================

    public function edit($id)
    {
        $data = Usulan::where('id_usulan', $id)->first();
        $form = $data->form->kode_form;
        $gdn  = GdnPerbaikan::orderBy('jenis_perbaikan', 'asc')->get();
        $kategori = AtkKategori::where('status', 'true')->get();

        if ($data->form_id == 4) {
            $uker = Auth::user()->pegawai->uker_id;
            $aadb = Aadb::where('uker_id', $uker)->where('status', 'true')->orderBy('merk_tipe', 'asc')->get();
            return view('pages.usulan.aadb.servis.edit', compact('id', 'aadb', 'data'));
        }

        if ($data->form_id == 5) {
            $usulan = Usulan::where('id_usulan', $id)->first();
            $aadb   = Aadb::where('uker_id', $usulan->user->pegawai->uker_id)->where('status', 'true')->orderBy('kualifikasi', 'desc')->orderBy('kategori_id', 'asc')->get();
            return view('pages.usulan.aadb.bbm.edit', compact('id', 'aadb', 'data'));
        }

        if ($data->form_id == 6) {
            $kategori = BmhpKategori::where('status', 'true')->get();
        }

        return view('pages.usulan.' . $form . '.edit', compact('id', 'data', 'gdn', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $usulan = Usulan::where('id_usulan', $id)->first();

        Usulan::where('id_usulan', $id)->update([
            'tanggal_usulan'  => $request->tanggal_usulan ?? $usulan->tanggal_usulan,
            'nama_penerima'   => $request->nama_penerima ?? $usulan->nama_penerima,
            'tanggal_selesai' => $request->tanggal_ambil ?? $usulan->tanggal_selesai,
            'keterangan'      => $request->keterangan ?? $usulan->keterangan
        ]);

        if (in_array($usulan->form_id, [1, 2])) {
            $judul = $request->judul;
            foreach ($judul as $i => $judul) {
                $id_detail = $request->id_detail[$i];
                if ($id_detail) {
                    UsulanDetail::where('id_detail', $id_detail)->update([
                        'usulan_id'   => $id,
                        'kategori_id' => $request->kategori[$i] ?? null,
                        'judul'       => $judul,
                        'uraian'      => $request->uraian[$i],
                        'keterangan'  => $request->keterangan_detail[$i],
                    ]);
                } else {
                    $id_detail = UsulanDetail::withTrashed()->count() + 1;
                    $detail = new UsulanDetail();
                    $detail->id_detail   = $id_detail;
                    $detail->usulan_id   = $id;
                    $detail->kategori_id = $request->kategori[$i] ?? null;
                    $detail->judul       = $request->judul[$i];
                    $detail->uraian      = $request->uraian[$i];
                    $detail->keterangan  = $request->keterangan_detail[$i];
                    $detail->created_at  = Carbon::now();
                    $detail->save();
                }
            }
        }

        if ($usulan->form_id == 4) {
            $aadb = $request->aadb;
            foreach ($aadb as $i => $aadb) {
                $id_detail = $request->id_detail[$i];
                if ($id_detail) {
                    UsulanServis::where('id_detail', $id_detail)->update([
                        'usulan_id'   => $id,
                        'aadb_id'     => $aadb,
                        'uraian'      => $request->uraian[$i] ?? null,
                        'keterangan'  => $request->keterangan_detail[$i] ?? null,
                    ]);
                } else {
                    $id_detail = UsulanServis::withTrashed()->count() + 1;
                    $detail = new UsulanServis();
                    $detail->id_detail   = $id_detail;
                    $detail->usulan_id   = $id;
                    $detail->aadb_id     = $aadb;
                    $detail->uraian      = $request->uraian[$i] ?? null;
                    $detail->keterangan  = $request->keterangan_detail[$i] ?? null;
                    $detail->save();
                }
            }
        }

        if ($usulan->form_id == 5) {
            $detail = $request->aadb;
            UsulanBbm::where('usulan_id', $id)->whereNotIn('aadb_id', $detail)->delete();

            foreach ($detail as $i => $aadb) {
                $cekAadb = UsulanBbm::where('usulan_id', $id)->where('aadb_id', $aadb)->first();
                if (!$cekAadb) {
                    $id_detail = UsulanBbm::withTrashed()->count() + 1;
                    $detail = new UsulanBbm();
                    $detail->id_detail   = $id_detail;
                    $detail->usulan_id   = $id;
                    $detail->aadb_id     = $aadb;
                    $detail->save();
                }
            }

            Usulan::where('id_usulan', $id)->update([
                'tanggal_selesai'   => Carbon::parse($request->bulan_permintaan . '-01'),
            ]);
        }

        if ($usulan->status_persetujuan == 'false') {
            Usulan::where('id_usulan', $id)->update([
                'status_persetujuan' => null,
                'keterangan_tolak'   => null
            ]);
        }

        return redirect()->route('usulan.detail', $id)->with('success', 'Berhasil Menyimpan');
    }

    // ===========================================================
    //                            DELETE
    // ===========================================================

    public function delete($id)
    {
        $data = Usulan::where('id_usulan', $id)->first();
        $form = $data->form->kode_form;

        if ($data->form_id == 3) {
            UsulanAtk::where('usulan_id', $id)->delete();
        } else {
            UsulanDetail::where('usulan_id', $id)->delete();
        }

        Usulan::where('id_usulan', $id)->delete();

        return redirect()->route('usulan', $form)->with('success', 'Berhasil Menghapus');
    }

    public function deleteItem($id)
    {
        $data = UsulanDetail::where('id_detail', $id)->first();
        UsulanDetail::where('id_detail', $id)->delete();

        return redirect()->route('usulan.edit', $data->usulan_id)->with('success', 'Berhasil Menghapus');
    }

    public function deleteServis($id)
    {
        $data = UsulanServis::where('id_detail', $id)->first();
        UsulanServis::where('id_detail', $id)->delete();

        return redirect()->route('usulan.edit', $data->usulan_id)->with('success', 'Berhasil Menghapus');
    }

    // ===========================================================
    //                            SURAT
    // ===========================================================

    public function surat($id, Request $request)
    {
        $data  = Usulan::where('id_usulan', $id)->first();
        $utama = $data->user->pegawai->uker->utama_id;
        $form  = $data->form->nama_form;

        $html = view('pages.usulan.surat', compact('data', 'utama', 'form'))->render();

        $mpdf = new Mpdf([
            'format' => 'A4',
            'orientation' => 'P'
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output(
            'surat_usulan.pdf',
            'D'
        ));
    }

    // ===========================================================
    //                            PROSES
    // ===========================================================

    public function proses(Request $request, $id)
    {
        $cekData = Usulan::where('id_usulan', $id)->first();

        if (!$request->all() && $cekData->status_proses != 'proses') {
            return redirect()->route('usulan.detail', $id)->with('failed', 'Permintaan tidak dapat di proses');
        }

        if ($cekData->form_id == 3 && Auth::user()->akses_id != 3) {
            return redirect()->route('usulan', 'atk')->with('failed', 'Tidak memiliki akses');
        }

        if (!$request->all()) {
            $data = Usulan::where('id_usulan', $id)->first();
            $form = $data->form->kode_form;
            return view('pages.usulan.proses', compact('id', 'data', 'form'));
        } else {
            $data = Usulan::with('form', 'user.pegawai.uker')->where('id_usulan', $id)->first();

            $otp = rand(111111, 999999);

            Usulan::where('id_usulan', $id)->update([
                'tanggal_selesai' => $request->tanggal_selesai,
                'nama_penerima'   => $request->penerima,
                'status_proses'   => $request->proses,
                'otp_4'           => $otp,
            ]);

            return redirect()->route('usulan.detail', $id)->with('success', 'Berhasil Melakukan Serah Terima');
        }
    }

    public function viewPdf($id)
    {
        $data = Usulan::where('id_usulan', $id)->first();

        return view('pages.usulan.pdf', compact('id', 'data'));
    }
}
