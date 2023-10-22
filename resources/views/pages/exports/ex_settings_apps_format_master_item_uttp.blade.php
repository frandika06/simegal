@php
    $no = 1;
    $colspan = \count($data);
    $cssColWidth1 = 'width: 24char;';
    $cssHeader = 'font-size: 13px;font-weight: bold;text-align: left;padding: 5px;height: 24pt;vertical-align: center;border:2px solid #000000;';
    $cssThHeader1 = 'font-size:12px;font-weight: bold;text-align: center;height: 32pt;vertical-align: center;border:2px solid #000000;word-wrap: break-word;background: #fff000;';
    $cssTdBody1 = 'font-size:11px;text-align:left;height: 24pt;vertical-align: center;border:2px solid #000000;';
    $cssTdBody2 = 'font-size:11px;text-align:center;height: 24pt;vertical-align: center;border:2px solid #000000;';
    $cssTdFooter1 = 'font-size:12px;font-weight: bold;height: 28pt;vertical-align: center;border:2px solid #000000;background: #fff000;';
@endphp
{{-- DATA JASPEL --}}
<table>
    <thead>
        <tr>
            <td style="{{ $cssThHeader1 }} width:5char;">No.</td>
            <td style="{{ $cssThHeader1 }} width:35char;">ID (JANGAN DIUBAH-UBAH)</td>
            <td style="{{ $cssThHeader1 }} width:35char;">Nama Jenis UTTP</td>
            <td style="{{ $cssThHeader1 }} width:20char;">No. Urut</td>
            <td style="{{ $cssThHeader1 }} width:35char;">Nama Item</td>
            <td style="{{ $cssThHeader1 }} width:20char;">volume_from</td>
            <td style="{{ $cssThHeader1 }} width:20char;">volume_to</td>
            <td style="{{ $cssThHeader1 }} width:20char;">volume_per</td>
            <td style="{{ $cssThHeader1 }} width:20char;">satuan</td>
            <td style="{{ $cssThHeader1 }} width:20char;">tera_baru_pengujian</td>
            <td style="{{ $cssThHeader1 }} width:20char;">tera_baru_pejustiran</td>
            <td style="{{ $cssThHeader1 }} width:20char;">tera_ulang_pengujian</td>
            <td style="{{ $cssThHeader1 }} width:20char;">tera_ulang_pejustiran</td>
            <td style="{{ $cssThHeader1 }} width:20char;">tarif_per_jam</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            @for ($i = 1; $i < 5; $i++)
                <tr>
                    <td style="{{ $cssTdBody1 }}">{{ $no++ }}</td>
                    <td style="{{ $cssTdBody1 }}">{{ $item->uuid }}</td>
                    <td style="{{ $cssTdBody1 }}">{{ $item->nama_jenis_uttp }}</td>
                    <td style="{{ $cssTdBody1 }}">{{ $i }}</td>
                    <td style="{{ $cssTdBody1 }}">Masukkan Item</td>
                    <td style="{{ $cssTdBody1 }}">0</td>
                    <td style="{{ $cssTdBody1 }}">0</td>
                    <td style="{{ $cssTdBody1 }}">0</td>
                    <td style="{{ $cssTdBody1 }}">Satuan</td>
                    <td style="{{ $cssTdBody1 }}">0</td>
                    <td style="{{ $cssTdBody1 }}">0</td>
                    <td style="{{ $cssTdBody1 }}">0</td>
                    <td style="{{ $cssTdBody1 }}">0</td>
                    <td style="{{ $cssTdBody1 }}">0</td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
