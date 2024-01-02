<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Keterangan Retribusi - {{ $perusahaan->nama_perusahaan }} - {{ date('Y-m-d H:i:s') }}</title>

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
            font-size: 10px;
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
        <div class="content-table">
            <div style="border: 1px solid #000;">
                <table width="100%" cellpadding="1px" cellspacing="0">
                    <tr>
                        <td style="text-align: center; border-right: 1px solid #000;">PEMERINTAH KABUPATEN TANGERANG</td>
                        <td style="text-align: center; border-right: 1px solid #000;">SURAT KETETAPAN RETRIBUSI</td>
                        <td style="text-align: center;">No. Order</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; border-right: 1px solid #000;">DINAS PERINDUSTRIAN DAN PERDAGANGAN</td>
                        <td style="text-align: center; border-right: 1px solid #000;">(SKR)</td>
                        <td style="text-align: center;"></td>
                    </tr>
                    <tr>
                        <td style="text-align: center; border-right: 1px solid #000;">BIDANG METROLOGI LEGAL</td>
                        <td style="text-align: center; border-right: 1px solid #000;">Masa: {{ \CID::getBulanLetter(date('m')) }}</td>
                        <td style="text-align: center;">{{ $data->nomor_order }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; border-right: 1px solid #000;">Jl. Raya Kresek km. 0,1 Kel. Balaraja Kec. Balaraja Kab. Tangerang</td>
                        <td style="text-align: center; border-right: 1px solid #000;">Tahun: {{ date('Y') }}</td>
                        <td style="text-align: center;"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content-table" style="padding: 0px;">
            <div style="border: 1px solid #000; border-top: 0px; padding: 20px 0px;">
                <table cellpadding="2px" cellspacing="0">
                    <tr>
                        <td>-</td>
                        <td>Nama Perusahaan</td>
                        <td>:</td>
                        <td>{{ $perusahaan->nama_perusahaan }}</td>
                    </tr>
                    <tr>
                        <td>-</td>
                        <td>Nama Pemilik</td>
                        <td>:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>-</td>
                        <td>NIK Pemilik</td>
                        <td>:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>-</td>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ \CID::getAlamatPerusahaan($permohonan) }}</td>
                    </tr>
                    <tr>
                        <td>-</td>
                        <td>NPWP</td>
                        <td>:</td>
                        <td>{{ $perusahaan->npwp }}</td>
                    </tr>
                </table>
                <div>
                </div>
            </div>

            <div class="container" style="margin: 0px;">
                <div class="content-table" style="margin: 0px; padding-top: 0px;">
                    <div style="border: 1px solid #000; border-top: 0px; padding: 20px 10px;">
                        <table border="1" width="100%" cellpadding="2px" cellspacing="0">
                            <tr>
                                <td rowspan="3">Kode Rekening</td>
                                <td rowspan="3">Jenis Retribusi</td>
                                <td rowspan="3">Jumlah</td>
                                <td rowspan="3">Volume</td>
                                <td colspan="4">Retribusi</td>
                                <td colspan="2">Jumlah (Rp)</td>
                            </tr>
                            <tr>
                                <td colspan="2">Tera</td>
                                <td colspan="2">Tera Ulang</td>
                                <td rowspan="2">Pengujian/ Pengesahan</td>
                                <td rowspan="2">Penjustiran</td>
                            </tr>
                            <tr>
                                <td>Pengujian/ Pengesahan/ Pembatalan (Rp)</td>
                                <td>Penjustiran (Rp)</td>
                                <td>Pengujian/ Pengesahan (Rp)</td>
                                <td>Penjustiran (Rp)</td>
                            </tr>
                            @php
                                $total_uji = 0;
                                $total_justir = 0;
                            @endphp
                            @isset($data->RelPdpInstrumen)
                                @php
                                    $jmlPdpInstrumen = count($data->RelPdpInstrumen);
                                @endphp
                                <tr>
                                    <td style="vertical-align: center;" rowspan="{!! $jmlPdpInstrumen !!}">4.1.2.01.46</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @foreach ($data->RelPdpInstrumenOrder as $item)
                                    @php
                                        $retribusi_tera = $item->retribusi_tera;
                                        $retribusi_justir = $item->retribusi_justir;
                                        $total_uji += $retribusi_tera;
                                        $total_justir += $retribusi_justir;
                                    @endphp
                                    <tr>
                                        <td></td>
                                        <td style="font-size: 8px"><i>{{ $item->RelMasterInstrumenDaftarItemUttp->nama_instrumen }}<i></td>
                                        <td style="text-align: center">{{ $item->jumlah_unit }}</td>
                                        <td style="text-align: center">{{ $item->volume }} {{ $item->RelMasterInstrumenDaftarItemUttp->satuan }}</td>
                                        <td style="text-align: right">{{ $item->tipe_tera == 'baru' ? number_format($item->RelMasterInstrumenDaftarItemUttp->tera_baru_pengujian, 0) : '' }}</td>
                                        <td style="text-align: right">{{ $item->tipe_tera == 'baru' ? number_format($item->RelMasterInstrumenDaftarItemUttp->tera_baru_pejustiran, 0) : '' }}</td>
                                        <td style="text-align: right">{{ $item->tipe_tera == 'ulang' ? number_format($item->RelMasterInstrumenDaftarItemUttp->tera_ulang_pengujian, 0) : '' }}</td>
                                        <td style="text-align: right">{{ $item->tipe_tera == 'ulang' ? number_format($item->RelMasterInstrumenDaftarItemUttp->tera_ulang_pejustiran, 0) : '' }}</td>
                                        <td style="text-align: right">{{ number_format($retribusi_tera, 0) }}</td>
                                        <td style="text-align: right">{{ number_format($retribusi_justir, 0) }}</td>
                                    </tr>
                                @endforeach
                            @endisset
                            <tr>
                                <td colspan="8">Jumlah</td>
                                <td style="text-align: right;">{{ number_format($total_uji, 0, '', '.') }}</td>
                                <td style="text-align: right;">{{ number_format($total_justir, 0, '', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="8">Jumlah Total</td>
                                <td colspan="2" style="text-align: right;">{{ number_format($retribusi->total_retribusi, 0, '', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="10">Terbilang: <i>{{ ucwords(\CID::terbilang($retribusi->total_retribusi)) }} Rupiah</i></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="container" style="margin: 0px;">
                <div class="content-table" style="margin: 0px; padding-top: 0px;">
                    <div style="border: 1px solid #000; border-top: 0px; padding: 20px 10px;">
                        PERHATIAN:
                        <table width="100%" cellpadding="3px" cellspacing="0">
                            <tr>
                                <td valign="top">1.</td>
                                <td>Harap pembayaran dilakukan pada Bank BJB dengan kode bayar <strong>{{ $retribusi->kode_bayar_webr }}</strong>.</td>
                            </tr>
                            <tr>
                                <td valign="top">2.</td>
                                <td>Tarif Retribusi Tera/Tera Ulang berdasarkan Peraturan Daerah Kabupaten Tangerang No 4 Tahun 2011, Peraturan Bupati Tangerang Nomor 1 Tahun 2016, Peraturan Bupati Nomor 10 Tahun 2016, dan Peraturan Bupati Nomor 55 Tahun 2016.</td>
                            </tr>
                            <tr>
                                <td valign="top">3.</td>
                                <td>Pembarayan paling lambat 30 hari kalender sejak Surat Ketetapan Retribusi Daerah (SKRD) ini diterima.</td>
                            </tr>
                            <tr>
                                <td valign="top">4.</td>
                                <td>Wajib retribusi tidak membayar tepat pada waktunya atau kurang membayar dikenakan sanksi administrasi berupa bunga 2% (dua persen) setiap bulan dari retribusi yang terhutang atau kurang bayar.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="container" style="margin: 0px; margin-top: 40px">
                <div class="content-table" style="margin: 0px; padding-top: 0px;">
                    <table width="100%">
                        <tr>
                            <td width="33%"></td>
                            <td width="33%"></td>
                            <td width="33%" style="text-align: center">Balaraja, {{ date('d-m-Y', strtotime(explode(' ', $retribusi->tgl_skrd)[0])) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center">An. Kepala Dinas Perindustrian dan Perdagangan</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center">Kabupaten Tangerang</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center">Kepala Bidang Metrologi Legal</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="height: 50px;text-align:center;">
                                @php
                                    $urlTte = \route('cek.tte.skrd', [$enc_uuid]);
                                @endphp
                                {!! QrCode::size(70)->generate($urlTte) !!}
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center"><strong><u>IRWAN HENGKI, SH,. M.Si</u></strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center"><strong>Penata Tk. I (III/d)</strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: center">NIP. 197210102008011014</td>
                        </tr>
                    </table>
                </div>
            </div>
</body>

</html>
