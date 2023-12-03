<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Perintah - {{ $perusahaan->nama_perusahaan }} - {{ date('Y-m-d H:i:s') }}</title>

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
{{-- <body> --}}

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


    <div class="container" style="margin-top:5px;">
        <div class="content-table">
            <table width="100%">
                <tr>
                    <td style="text-align: center;"><strong>SURAT PERINTAH</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center;"><strong>Nomor:</strong> <span style="display:inline-block;min-width:140px;">&nbsp;</span></td>
                </tr>
            </table>

            <br><br>

            Yang bertanda tangan di bawah ini:

            <br><br>

            <table>
                <tr>
                    <td width="80px">Nama</td>
                    <td width="10px">:</td>
                    <td>IRWAN HENGKI, SH,. M.Si</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>197210102008011014</td>
                </tr>
                <tr>
                    <td>Pangkat/Gol</td>
                    <td>:</td>
                    <td>Penata Tk. I (III/d)</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>Kabid Metrologi Legal</td>
                </tr>
                <tr>
                    <td style="height:20px"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Dasar</td>
                    <td>:</td>
                    <td>Surat Permohonan Tera {{ $perusahaan->nama_perusahaan }}</td>
                </tr>
            </table>

            <br><br>

            Dengan ini memerintahkan kepada:

            <br><br>

            <table width="100%" border="1" cellpadding="5" cellspacing="0" style="font-size:11px;">
                <tr>
                    <th width="40px">No.</th>
                    <th>NAMA</th>
                    <th>NIP</th>
                    <th>JABATAN</th>
                </tr>
                @foreach ($data->RelPdpDataPetugas as $key => $item)
                    <tr>
                        <td style="text-align: center">{{ $key = $key + 1 }}</td>
                        <td>{{ $item->RelPegawai->nama_lengkap }}</td>
                        <td>{{ !is_null($item->RelPegawai->nip) ? $item->RelPegawai->nip : '-' }}</td>
                        <td>{{ $item->jabatan_petugas }}</td>
                    </tr>
                @endforeach
            </table>

            <br><br>

            Melaksanakan Pengujian Tera/Tera Ulang/BDKT {{ $perusahaan->nama_perusahaan }}, pada tanggal {{ \CID::tglBlnThn($data->tanggal_peneraan) }},
            yang beralamatkan di
            @if ($permohonan->lokasi_peneraan == 'Dalam Kantor Metrologi')
                Bidang Metrologi Legal, Kec. Balaraja, Kabupaten Tangerang, Banten, 15610.
            @else
                {{ $alamat_peneraan->alamat }}, {{ isset($alamat_peneraan->rt) ? 'RT. ' . $alamat_peneraan->rt . ', ' : '' }}
                {{ isset($alamat_peneraan->rw) ? 'RW. ' . $alamat_peneraan->rw . ', ' : '' }}
                {{ \Str::title($alamat_peneraan->Desa->name) }}, {{ \Str::title($alamat_peneraan->Kecamatan->name) }},
                {{ \Str::title($alamat_peneraan->Kabupaten->name) }}, {{ \Str::title($alamat_peneraan->Provinsi->name) }}{{ isset($alamat_peneraan->kode_pos) ? ', ' . $alamat_peneraan->kode_pos . '.' : '.' }}
            @endif
            <br><br>

            Demikian untuk dilaksanakan sebagaimana mestinya.

            <br><br><br><br>

            <table width="100%">
                <tr>
                    <td width="50%"></td>
                    <td style="text-align: center">Ditetapkan di: Tigaraksa</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center">Pada tanggal: {{ date('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td height="10px"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center">A.n Kepala Dinas Perindustrian dan Perdagangan <br> Kabupaten Tangerang <br> Kepala Bidang Metrologi Legal</td>
                </tr>
                <tr>
                    <td style="height: 50px"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center"><strong><u>IRWAN HENGKI, SH,. M.Si</u></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center">Penata Tk. I (III/d)</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center">NIP 197210102008011014</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
