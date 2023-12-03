<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Jalan - {{ $perusahaan->nama_perusahaan }} - {{ date('Y-m-d H:i:s') }}</title>

    <style>
        .logo {
            float: left;
            width: 20%;
            height: 60px;
            text-align: center;
        }

        .logo>img {
            width: 70px;
        }

        .header {
            float: left;
            width: 80%;
            height: auto;
            text-align: center;
            font-size: 18px;
            font-family: 'Times New Roman', 'Times', 'serif';
            font-weight: bold;
            line-height: 15px;
            margin-bottom: 10px;
        }

        .header>.address {
            width: 100%;
            font-size: 12px;
            font-weight: normal;
            line-height: 12px !important;
            margin-top: 5px;
        }

        .container {
            margin: 0 20px;
        }

        hr {
            height: 0px;
            margin: 1px;
        }

        .header-content {
            text-align: center;
            margin: 10px 0px 5px 0px;
            line-height: 16px;
            font-weight: bold;
            border: 1px solid black;
            font-size: 12px;
        }

        .content-table {
            overflow: auto;
            margin: 0 20px;
            padding-top: 10px;
            font-size: 12px;
            height: auto;
        }

        li {
            margin-bottom: 5px;
        }
    </style>

</head>

<body onload="window.print()" onfocus="window.close()">

    <div class="container">
        <div class="logo">
            <img src="{{ \CID::logoApps() }}" draggable="false">
        </div>

        <div class="header">
            <div>
                <div>PEMERINTAH KABUPATEN TANGERANG</div>
                <div>DINAS PERINDUSTRIAN DAN PERDAGANGAN</div>
                <div>BIDANG METROLOGI LEGAL</div>
            </div>
            <div class="address">
                <div>Jalan Raya Kresek km. 0.1, Kel.Balaraja, Kec.Balaraja</div>
                <div>Telp. (021) 2259 5154, Fax. (021) 599 0516</div>
                <div>TANGERANG - BANTEN</div>
                <div>KODE POS 15610</div>
            </div>
        </div>
        <hr>
        <hr>
    </div>


    <div class="container" style="margin-top:20px;">
        <div class="content-table">
            <table width="100%" border="1" cellpadding="5px" cellspacing="0">
                <tr>
                    <td colspan="6" style="text-align: center; font-size: 15px;">
                        <strong>
                            SURAT JALAN <br>
                            METROLOGI LEGAL KABUPATEN TANGERANG
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <td style="width:10px">a.</td>
                    <td>Tgl dan No. Order</td>
                    <td style="width:10px">:</td>
                    <td>{{ \CID::hariTgl($data->tanggal_peneraan) }}</td>
                    <td colspan="2">{{ $data->nomor_order }}</td>
                </tr>
                <tr>
                    <td>b.</td>
                    <td>Status</td>
                    <td>:</td>
                    <td colspan="3">{{ $jenis_pengujian }}</td>
                </tr>
                <tr>
                    <td>c.</td>
                    <td>Nama Pemohon</td>
                    <td>:</td>
                    <td colspan="3">{{ $perusahaan->nama_perusahaan }}</td>
                </tr>
                <tr>
                    <td>d.</td>
                    <td>Lokasi Peneraan</td>
                    <td>:</td>
                    <td colspan="3">
                        <h3 style="margin:0px;padding:0px;margin-bottom:2px;">{{ $permohonan->lokasi_peneraan }}</h3>
                        <div style="padding-left: 10px">
                            @if ($permohonan->lokasi_peneraan == 'Dalam Kantor Metrologi')
                                Bidang Metrologi Legal, Kec. Balaraja, Kabupaten Tangerang, Banten, 15610.
                            @else
                                {{ $alamat_peneraan->alamat }}, {{ isset($alamat_peneraan->rt) ? 'RT. ' . $alamat_peneraan->rt . ', ' : '' }}
                                {{ isset($alamat_peneraan->rw) ? 'RW. ' . $alamat_peneraan->rw . ', ' : '' }}
                                {{ \Str::title($alamat_peneraan->Desa->name) }}, {{ \Str::title($alamat_peneraan->Kecamatan->name) }},
                                {{ \Str::title($alamat_peneraan->Kabupaten->name) }}, {{ \Str::title($alamat_peneraan->Provinsi->name) }}{{ isset($alamat_peneraan->kode_pos) ? ', ' . $alamat_peneraan->kode_pos . '.' : '.' }}
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">e.</td>
                    <td style="vertical-align: top;">Jenis UTTP</td>
                    <td style="vertical-align: top;">:</td>
                    <td colspan="3">
                        @isset($data->RelPdpInstrumen)
                            @foreach ($data->RelPdpInstrumenOrder as $item)
                                @if ($item->jumlah_unit != 0)
                                    <p style="margin:0px;padding:0px;margin-bottom:2px;">
                                        {{ $item->jumlah_unit }} Unit {{ ucwords(strtolower($item->RelMasterInstrumenDaftarItemUttp->nama_instrumen)) }}
                                        @if ($item->RelMasterInstrumenDaftarItemUttp->RelMasterInstrumenJenisUttp->status_volume)
                                            Kapasitas {{ $item->volume }} {{ $item->RelMasterInstrumenDaftarItemUttp->satuan }}
                                        @endif
                                    </p>
                                @endif
                            @endforeach
                        @endisset
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align: center; font-size: 15px;">
                        <strong>
                            DATA SUPIR, KENDARAAN, & ALAT YANG DIBAWA
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>1.</td>
                    <td>Nama Supir</td>
                    <td>:</td>
                    <td colspan="3">{{ $data->nama_supir }}</td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Jenis Kendaraan</td>
                    <td>:</td>
                    <td>{{ $data->jenis_kendaraan }}</td>
                    <td colspan="2">Plat Nomor Kendaraan : {{ $data->plat_nomor_kendaraan }}</td>
                </tr>
                <tr>
                    <td valign="top">3.</td>
                    <td valign="top">Jenis Alat yang Dibawa</td>
                    <td valign="top">:</td>
                    <td colspan="2">
                        @isset($data->RelPdpAlat)
                            <h3 style="margin:0px;padding:0px;margin-bottom:2px;"><u>Alat Standar & Perlengkapannya</u></h3>
                            <ul>
                                @foreach ($data->RelPdpAlatOrder as $item)
                                    @if ($item->RelMasterKategoriKelompok->kategori == '1')
                                        <li>{{ $item->RelMasterKategoriKelompok->nama_kategori }} <br> {{ $item->jumlah_unit }} UNIT</li>
                                    @endif
                                @endforeach
                            </ul>
                            <h3 style="margin:0px;padding:0px;margin-bottom:2px;"><u>CTT</u></h3>
                            <ul>
                                @foreach ($data->RelPdpAlatOrder as $item)
                                    @if ($item->RelMasterKategoriKelompok->kategori == '2')
                                        <li>{{ $item->RelMasterKategoriKelompok->nama_kategori }} <br> {{ $item->jumlah_unit }} UNIT</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endisset
                    </td>
                    <td valign="top">Keterangan:</td>
                </tr>
            </table>
            <table width="100%" style="margin-top:40px;">
                <tr>
                    <td style="text-align: center" width="33%" valign="top">PEGAWAI BERHAK/PENERA</td>
                    <td rowspan="3" style="text-align: center" width="33%"><img src="{{ \CID::logoBPPK() }}" style="width:140px;"></td>
                    <td style="text-align: center" width="33%" valign="top">SUPIR</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: center" valign="bottom">
                        (
                        @for ($i = 0; $i < 30; $i++)
                            &nbsp;
                        @endfor
                        )
                    </td>
                    <td style="text-align: center" valign="bottom">
                        {{ $data->nama_supir }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
