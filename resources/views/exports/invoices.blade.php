<h1>Laporan Tugas</h1>
@if (isset($start_date) && isset($end_date))
<p>Tanggal : {{ $start_date }} - {{ $end_date }}</p>
@else
<p>Tanggal : Semua</p>
@endif
<br>
<br>
<table style="">
    <thead>
    <tr >
        <th width="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black" >ID</th>
        <th widht="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black">Nama Tugas</th>
        <th widht="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black">Status</th>
        <th widht="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black">Tanggal</th>
        <th widht="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black">Keterangan</th>
        <th widht="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black">Nama Kandang</th>
        <th widht="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black">Jumlah Ternak</th>
        <th widht="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black">Jumlah Total Bebek</th>
        <th widht="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black">Jumlah Bebek Sehat</th>
        <th widht="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black">Jumlah Bebek Sakit</th>
        <th widht="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black">Jumlah Bebek Mati</th>
        <th widht="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black">Jumlah Telur</th>
        <th widht="200pt" align="center" style="font-size: 12pt; font-family: 'Times New Roman', Times, serif; font-weight: bold; border: 1px solid black">Jumlah Telur Rusak</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tugas as $item)
        <tr>
            <td  width="200pt" style="border: 1px solid black">{{ $item->id }}</td>
            <td  width="200pt" style="border: 1px solid black">{{ $item->nama_tugas }}</td>
            <td  width="200pt" style="border: 1px solid black">{{ $item->Status }}</td>
            <td  width="200pt" style="border: 1px solid black">{{ $item->tanggal }}</td>
            <td  width="200pt" style="border: 1px solid black">{{ $item->keterangan }}</td>
            <td  width="200pt" style="border: 1px solid black">{{ $item->kandang->name }}</td>
            <td  width="200pt" style="border: 1px solid black">{{ $item->kandang->jumlah_ternak }}</td>
            <td  width="200pt" style="border: 1px solid black">{{ $item->tugasKeadaanBebek->jumlah_total_bebek ?? "-" }}</td>
            <td  width="200pt" style="border: 1px solid black">{{ $item->tugasKeadaanBebek?->jumlah_bebek_sehat ?? "-" }}</td>
            <td  width="200pt" style="border: 1px solid black">{{ $item->tugasKeadaanBebek?->jumlah_bebek_sakit ?? "-" }}</td>
            <td  width="200pt" style="border: 1px solid black">{{ $item->tugasKeadaanBebek?->jumlah_bebek_mati ?? "-" }}</td>
            <td  width="200pt" style="border: 1px solid black">{{ $item->tugasTelur?->jumlah_telur ?? "-" }}</td>
            <td  width="200pt" style="border: 1px solid black">{{ $item->tugasTelur?->jumlah_telur_rusak ?? "-" }}</td>
        </tr>
    @endforeach
    </tbody>
</table>