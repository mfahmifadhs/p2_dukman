<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }

        .header img {
            width: 100%;
            background-color: blue;
        }

        .title {
            text-align: center;
            margin-top: 10px;
        }

        .title h2 {
            margin: 0;
        }

        .title h3 {
            margin: 0;
            font-weight: normal;
        }

        .info {
            margin-top: 25px;
        }

        .info table {
            width: 100%;
        }

        .info td {
            vertical-align: top;
            padding: 2px;
        }

        .line {
            border-top: 3px solid black;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        table.table {
            width: 100%;
            border-collapse: collapse;
        }

        table.table th,
        table.table td {
            border: 1px solid black;
            padding: 6px;
        }

        table.table th {
            text-align: center;
        }

        .center {
            text-align: center;
        }

        .ttd {
            margin-top: 40px;
        }

        .ttd-table {
            width: 100%;
        }

        .ttd-table td {
            width: 50%;
            vertical-align: top;
        }

        .qr {
            margin-top: 12px;
            margin-bottom: 12px;
        }

        .qr img {
            width: 80px;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ base_path('public/dist/img/header-'.$data->pegawai->uker->utama_id.'.png') }}" width="100%">
    </div>

    <div class="title">
        <h2>NOTA DINAS</h2>
        <h3>Nomor {{ $data->nomor_usulan }}</h3>
    </div>

    <div class="info">
        <table>

            <tr>
                <td width="80">Yth.</td>
                <td>: Ketua Tim Kerja Dukungan Manajemen Setditjen P2</td>
            </tr>

            <tr>
                <td>Dari</td>
                <td>: {{ $data->pegawai->jabatan->jabatan }} {{ $data->pegawai->tim_kerja }} {{ $data->pegawai->uker->unit_kerja }}</td>
            </tr>

            <tr>
                <td>Hal</td>
                <td>: Permintaan {{ $data->form->nama_form }}</td>
            </tr>

            <tr>
                <td>Tanggal</td>
                <td>: {{ Carbon\Carbon::parse($data->tanggal_usulan)->isoFormat('DD MMMM Y') }}</td>
            </tr>

        </table>
    </div>

    <div class="line"></div>

    <p style="text-align:justify">
        &nbsp;&nbsp;&nbsp;&nbsp;
        Sehubungan dengan kebutuhan Alat Tulis Kantor (ATK)
        {{ $data->pegawai->tim_kerja.' '.$data->pegawai->uker->unit_kerja }},
        bersama ini kami sampaikan permintaan sebagai berikut.
    </p>


    @if (in_array($data->form_id,[3,6]))

    <table class="table">

        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Barang</th>
                <th>Keterangan</th>
                <th width="15%">Jumlah</th>
            </tr>
        </thead>

        <tbody>

            @if ($data->form_id == 3)

            @foreach ($data->detailAtk as $row)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $row->atk->nama_barang }}</td>
                <td>{{ $row->keterangan }}</td>
                <td class="center">{{ $row->jumlah }} {{ $row->satuan->nama_satuan }}</td>
            </tr>
            @endforeach

            @endif


            @if ($data->form_id == 6)

            @foreach ($data->detailBmhp as $row)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $row->bmhp->nama_barang }}</td>
                <td>{{ $row->keterangan }}</td>
                <td class="center">{{ $row->jumlah }} {{ $row->satuan->nama_satuan }}</td>
            </tr>
            @endforeach

            @endif

        </tbody>
    </table>

    @endif


    <p style="margin-top:15px">
        &nbsp;&nbsp;&nbsp;&nbsp;
        Atas perhatian dan bantuan Saudara, diucapkan terima kasih.
    </p>


    <div class="ttd">

        <table class="ttd-table">

            <tr>

                <td>

                    <p>Pengusul,</p>
                    <p>{{ $data->pegawai->jabatan->jabatan.' '.$data->pegawai->tim_kerja }} <br> {{ $data->pegawai->uker->unit_kerja }}</p>

                    <div class="qr">
                        <img src="{{ \App\Helpers\QrCodeHelper::generateQrCode('https://siporsat.kemkes.go.id/surat/'. $data->otp_1 .'/'. $data->kode_usulan) }}" width="80" style="padding: 10vh 0;">
                    </div>

                    <p>{{ $data->pegawai->nama_pegawai }}</p>

                </td>


                @if ($data->status_persetujuan == 'true')

                <td>
                    <p>Disetujui,</p>
                    <p>{{ $data->verif->jabatan->jabatan.' '.$data->verif->tim_kerja }} <br> Setditjen P2</p>

                    <div class="qr">
                        <img src="{{ \App\Helpers\QrCodeHelper::generateQrCode('https://siporsat.kemkes.go.id/surat/'. $data->otp_2 .'/'. $data->kode_usulan) }}" width="80" style="padding: 10vh 0;">
                    </div>

                    <p>{{ $data->verif->nama_pegawai }}</p>

                </td>

                @endif

            </tr>

        </table>

    </div>

</body>

</html>