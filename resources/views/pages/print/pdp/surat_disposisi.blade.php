<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kartu Penerus Disposisi - {{ $perusahaan->nama_perusahaan }} - {{ date('Y-m-d H:i:s') }}</title>

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
            <img src="{{ \CID::logoApps() }}" alt="">
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
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="10px">a.</td>
                    <td width="200px">Tgl dan No. Order</td>
                    <td width="5px">:</td>
                    <td>{{ \CID::tglBlnThn(date('Y-m-d')) }}</td>
                    <td>{{ $data->nomor_order }}</td>
                </tr>
                <tr>
                    <td>b.</td>
                    <td>Status</td>
                    <td>:</td>
                    <td colspan="2">{{ $jenis_pengujian }}</td>
                </tr>
                <tr>
                    <td>c.</td>
                    <td>Nama Pemohon</td>
                    <td>:</td>
                    <td colspan="2">{{ $perusahaan->nama_perusahaan }}</td>
                </tr>
                <tr>
                    <td>d.</td>
                    <td>Alamat Pemohon</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $alamatDefault->alamat }}, {{ isset($alamatDefault->rt) ? 'RT. ' . $alamatDefault->rt . ', ' : '' }}
                        {{ isset($alamatDefault->rw) ? 'RW. ' . $alamatDefault->rw . ', ' : '' }}
                        {{ \Str::title($alamatDefault->Desa->name) }}, {{ \Str::title($alamatDefault->Kecamatan->name) }},
                        {{ \Str::title($alamatDefault->Kabupaten->name) }}, {{ \Str::title($alamatDefault->Provinsi->name) }}{{ isset($alamatDefault->kode_pos) ? ', ' . $alamatDefault->kode_pos . '.' : '.' }}
                    </td>
                </tr>
                <tr>
                    <td>e.</td>
                    <td>Jenis UTTP</td>
                    <td>:</td>
                    <td colspan="2">
                        @isset($data->RelPdpInstrumen)
                            @php
                                $juttp = [];
                            @endphp
                            @foreach ($data->RelPdpInstrumenOrder as $item)
                                @php
                                    $juttp[] = $item->RelMasterInstrumenDaftarItemUttp->RelMasterInstrumenJenisUttp->nama_jenis_uttp;
                                @endphp
                            @endforeach
                            @php
                                $filteredData = array_unique($juttp);
                                $cJuttp = count($filteredData);
                            @endphp
                            @for ($i = 0; $i < $cJuttp; $i++)
                                <p style="margin:0px;padding:0px;margin-bottom:2px;">{{ $filteredData[$i] }}</p>
                            @endfor
                        @endisset
                    </td>
                </tr>
                <tr>
                    <td>f.</td>
                    <td>Jumlah UTTP</td>
                    <td>:</td>
                    <td colspan="2">
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
                    <td>g.</td>
                    <td>Lokasi Peneraan</td>
                    <td>:</td>
                    <td colspan="2">
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
                    <td>h.</td>
                    <td>Contact Person Vendor</td>
                    <td>:</td>
                    <td colspan="2">
                        -
                    </td>
                </tr>
                <tr>
                    <td>i.</td>
                    <td>Contact Person (PT/CV/Perorangan)</td>
                    <td>:</td>
                    <td colspan="2">
                        <p style="margin:0px;padding:0px;margin-bottom:2px;"><strong>Nama PIC:</strong> {{ $perusahaan->nama_pic }}</p>
                        <p style="margin:0px;padding:0px;margin-bottom:2px;"><strong>Kontak 1:</strong> {{ $perusahaan->no_telp_1 }}</p>
                        @isset($perusahaan->no_telp_2)
                            <p style="margin:0px;padding:0px;margin-bottom:2px;"><strong>Kontak 2:</strong> {{ $perusahaan->no_telp_2 }}</p>
                        @endisset
                    </td>
                </tr>
                <tr>
                    <td>j.</td>
                    <td>Email</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $perusahaan->email }}
                    </td>
                </tr>
                <tr>
                    <td>k.</td>
                    <td>Nomor Surat Permohonan</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $permohonan->nomor_surat_permohonan }}
                    </td>
                </tr>
                <tr>
                    <td>l.</td>
                    <td>Tanggal Surat Permohonan</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ \CID::tglBlnThn($permohonan->tanggal_permohonan) }}
                    </td>
                </tr>
            </table>

            <br><br>

            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <td colspan="2" style="text-align: center; font-size: 18px;"><strong>KARTU PENERUS DISPOSISI</strong></td>
                </tr>
                <tr>
                    <td style="text-align: center" width="50%">INSTRUKSI / INFORMASI</td>
                    <td style="text-align: center">DITERUSKAN KEPADA</td>
                </tr>
                <tr>
                    <td>
                        <ol>
                            <li>Proses permohonan TERA/TERA ULANG dan ikuti semua prosedur dan peraturan yang berlaku.</li>
                            <li>Laporkan hasilnya dan harus dapat dipertanggungjawabkan.</li>
                        </ol>
                    </td>
                    <td style="vertical-align: top">
                        <ol>
                            <li>Laksanakan sesuai disposisi Kepala Bidang.</li>
                            <li>Laporkan hasilnya sesuai aturan yang berlaku.</li>
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center">
                        Contact Person PT/Vendor: {{ $perusahaan->nama_pic }} / {{ $perusahaan->nama_perusahaan }} <br>
                        Kontak 1: {{ $perusahaan->no_telp_1 }} @isset($perusahaan->no_telp_2)
                            / Kontak 2: {{ $perusahaan->no_telp_2 }}
                        @endisset
                    </td>
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td width="50%" style="text-align: center; vertical-align: top;">
                        Sesudah digunakan segera dikembalikan.
                    </td>
                    <td width="50%">
                        <ol style="margin-top: 0px;">
                            <li>Kepada bawahan "instruksi" dan atau "informasi"</li>
                            <li>Kepada atasan "informasi" dan coret "instruksi"</li>
                        </ol>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
