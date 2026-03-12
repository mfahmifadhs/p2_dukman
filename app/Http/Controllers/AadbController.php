<?php

namespace App\Http\Controllers;

use App\Models\Aadb;
use App\Models\AadbKategori;
use App\Models\AadbKondisi;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AadbController extends Controller
{
    public function index(Request $request)
    {
        $data     = Aadb::orderBy('id_aadb', 'asc');
        $user     = Auth::user();

        $uker         = $request->uker;
        $kategori     = $request->kategori;
        $kondisi      = $request->kondisi;
        $status       = $request->status;
        $listUker     = UnitKerja::where('utama_id', 46593)->get();
        $listKategori = AadbKategori::where('status', 'true')->orderBy('nama_kategori', 'asc')->get();
        $listKondisi  = AadbKondisi::get();

        if ($user->role_id == 4) {
            $data = $data->where('uker_id', $user->pegawai->uker_id)->count();
        } else {
            $data = $data->count();
        }

        return view('pages.aadb.show', compact('kategori', 'data', 'uker', 'kondisi', 'status', 'listUker', 'listKategori', 'listKondisi'));
    }

    public function detail($id)
    {
        $data = Aadb::where('id_aadb', $id)->first();
        return view('pages.aadb.detail', compact('data'));
    }

    public function create()
    {
        $uker     = UnitKerja::where('utama_id', '46593')->get();
        $kategori = AadbKategori::where('status', 'true')->get();
        $kondisi  = AadbKondisi::get();
        return view('pages.aadb.create', compact('uker', 'kategori', 'kondisi'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = $file->getClientOriginalName();
            $request->foto->move(public_path('dist/img/foto_aadb'), $fileName);
        }

        $id_aadb = Aadb::withTrashed()->count() + 1;
        $tambah  = new Aadb();
        $tambah->id_aadb           = $id_aadb;
        $tambah->uker_id           = $request->uker;
        $tambah->kategori_id       = $request->kategori;
        $tambah->nup               = $request->nup;
        $tambah->jenis_aadb        = $request->jenis;
        $tambah->kualifikasi       = $request->kualifikasi;
        $tambah->merk_tipe         = $request->merktipe;
        $tambah->no_polisi         = $request->nopolisi;
        $tambah->no_bpkp           = $request->nobpkp;
        $tambah->tanggal_perolehan = $request->tanggal;
        $tambah->nilai_perolehan   = (int)str_replace('.', '', $request->nilai);
        $tambah->kondisi_id        = $request->kondisi;
        $tambah->keterangan        = $request->keterangan;
        $tambah->foto_barang       = $fileName ?? null;
        $tambah->status            = $request->status;
        $tambah->save();

        return redirect()->route('aadb.detail', $id_aadb)->with('success', 'Berhasil Menambah');
    }

    public function edit($id)
    {
        $uker     = UnitKerja::where('utama_id', '46595')->get();
        $kategori = AadbKategori::where('status', 'true')->get();
        $kondisi  = AadbKondisi::get();
        $data     = Aadb::where('id_aadb', $id)->first();
        return view('pages.aadb.edit', compact('id', 'uker', 'kategori', 'kondisi', 'data'));
    }

    public function update(Request $request, $id)
    {
        $data = Aadb::where('id_aadb', $id)->first();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = $file->getClientOriginalName();
            $request->foto->move(public_path('dist/img/foto_aadb'), $fileName);
        }

        Aadb::where('id_aadb', $id)->update([
            'uker_id'           => $request->uker,
            'kategori_id'       => $request->kategori,
            'nup'               => $request->nup,
            'jenis_aadb'        => $request->jenis,
            'kualifikasi'       => $request->kualifikasi,
            'merk_tipe'         => $request->merktipe,
            'no_polisi'         => $request->nopolisi,
            'no_bpkb'           => $request->nobpkb,
            'tanggal_perolehan' => $request->tanggal,
            'nilai_perolehan'   => (int)str_replace('.', '', $request->nilai),
            'nilai_alokasi'     => (int)str_replace('.', '', $request->alokasi),
            'kondisi_id'        => $request->kondisi,
            'keterangan'        => $request->keterangan,
            'foto_barang'       => $fileName ?? $data->foto_barang,
            'status'            => $request->status
        ]);

        return redirect()->route('aadb.detail', $id)->with('success', 'Berhasil Menyimpan');
    }

    public function select(Request $request)
    {
        $role         = Auth::user()->role_id;
        $uker         = $request->uker;
        $kategori     = $request->kategori;
        $status       = $request->status;
        $kondisi      = $request->kondisi;
        $search       = $request->search;

        $data     = Aadb::orderBy('id_aadb', 'asc')->orderBy('status', 'desc');
        $no       = 1;
        $response = [];

        if ($role == 4) {
            $data = $data->where('uker_id', Auth::user()->pegawai->uker_id);
        }

        if ($uker || $kategori || $kondisi || $status || $search) {
            if ($uker) {
                $res = $data->whereHas('uker', function ($query) use ($uker) {
                    $query->where('id_unit_kerja', $uker);
                });
            }

            if ($kategori) {
                $res = $data->where('kategori_id', $kategori);
            }

            if ($kondisi) {
                $res = $data->where('kondisi_id', $kondisi);
            }

            if ($status) {
                $res = $data->where('status', $status);
            }

            if ($search) {
                $res = $data->where('merk_tipe', 'like', '%' . $search . '%');
            }

            $result = $res->get();
        } else {
            $result = $data->get();
        }

        foreach ($result as $row) {
            $aksi   = '';
            $status = '';

            if ($row->foto_barang) {
                $foto = '<img src="' . asset('dist/img/foto_aadb/' . $row->foto_barang) . '" class="img-fluid" alt="">';
            } else {
                $foto = '<img src="https://cdn-icons-png.flaticon.com/128/7571/7571054.png" class="img-fluid" alt="">';
            }

            $aksi .= '
                <a href="' . route('aadb.detail', $row->id_aadb) . '" class="btn btn-default btn-xs bg-primary rounded border-dark">
                    <i class="fas fa-info-circle p-1" style="font-size: 12px;"></i>
                </a>
            ';

            if ($row->status == 'true') {
                $status = '<i class="fas fa-check-circle text-success"></i>';
            } else {
                $status = '<i class="fas fa-times-circle text-danger"></i>';
            }

            $response[] = [
                'no'          => $no,
                'id'          => $row->id_aadb,
                'aksi'        => $aksi,
                'foto'        => $foto,
                'fileFoto'    => $row->foto_barang,
                'uker'        => $row->uker->unit_kerja,
                'kategori'    => $row->kategori->nama_kategori,
                'jenis'       => $row->jenis_aadb,
                'kualifikasi' => $row->kualifikasi,
                'merktipe'    => $row->merk_tipe,
                'deskripsi'   => $row->deskripsi,
                'nopolisi'    => $row->no_polisi,
                'nobpkp'      => $row->no_bpkp,
                'tanggal'     => $row->tanggal_perolehan,
                'alokasi'     => 'Rp' . number_format($row->nilai_alokasi, 0, '.'),
                'realisasi'   => 'Rp',
                'keterangan'  => $row->keterangan ?? '',
                'status'      => $status,
                'kondisi'     => $row->kondisi->nama_kondisi
            ];

            $no++;
        }

        return response()->json($response);
    }
}
