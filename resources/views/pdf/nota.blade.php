<html>
<head>
<title>Faktur Pembayaran</title>
<style>
#tabel
{
font-size:15px;
border-collapse:collapse;
}
#tabel  td
{
padding-left:5px;
border: 1px solid black;
}
</style>
</head>
<!-- <body style='font-family:tahoma; font-size:8pt;' onload="javascript:window.print()"> -->
<body>
<center>
<table style='width:550px; font-size:8pt; font-family:calibri; border-collapse: collapse;' border = '0'>
<td width='70%' align='left' style='padding-right:80px; vertical-align:top'>
<span style='font-size:12pt'><b>Klinik Pratama Unla</b></span></br>
Jl Karapitan No 116, Bandung - Jawa Barat</br>
Telp : -
</td>
<td style='vertical-align:top' width='30%' align='left'>
<b><span style='font-size:12pt'>FAKTUR PEMBAYARAN</span></b></br>
No Trans. : 4</br>
Tanggal :06 Januari 2016</br>
</td>
</table>
<table style='width:550px; font-size:8pt; font-family:calibri; border-collapse: collapse;' border = '0'>
<td width='70%' align='left' style='padding-right:80px; vertical-align:top'>
Nama Pasien : {{$data->nama}}</br>
Alamat : {{$data->alamat}}
</td>
<td style='vertical-align:top' width='30%' align='left'>
No Telp : {{$data->no_hp}}
</td>
</table>
<table cellspacing='0' style='width:550px; font-size:8pt; font-family:calibri;  border-collapse: collapse;' border='1'>
 
<tr align='center'>
    <td width='10%'>No</td>
    <td width='20%'>Nama</td>
    <td width='16%'>Harga</td>
    <td width='4%'>Qty</td>
    <td width='16%'>Total Harga</td>
</tr>
<tr>
    <td colspan="5">Obat</td>
</tr>
@php
    $hargaObat = 0;
@endphp
@foreach($resep as $obat)
@php
    $hargaObat = $obat->jumlah * $obat->harga;
@endphp
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$obat->nama}}</td>
    <td>{{$obat->harga}}</td>
    <td>{{$obat->jumlah}}</td>
    <td style='text-align:right'>Rp {{$hargaObat}}</td>
</tr>
@endforeach
<tr>
    <td colspan="5">Tindakan</td>
</tr>
@foreach($tindakan as $tindakans)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$tindakans->description}}</td>
    <td>{{$tindakans->harga}}</td>
    <td>1</td>
    <td style='text-align:right'>{{$tindakans->harga}}</td>
</tr>
@endforeach
<tr>
<td colspan = '4'><div style='text-align:right'>Total Yang Harus Di Bayar Adalah : </div></td>
<td style='text-align:right'>Rp {{$data->total_bayar}}</td>
</tr>
<tr>
<td colspan = '4'><div style='text-align:right'>Cash : </div></td>
<td style='text-align:right'>Rp {{$data->jumlah_bayar}}</td>
</tr>
<tr>
    @php
        $kembalian = $data->jumlah_bayar - $data->total_bayar;
    @endphp
<td colspan = '4'><div style='text-align:right'>Kembalian : </div></td><td style='text-align:right'>Rp {{$kembalian}}</td>
</tr>
<!-- <tr>
<td colspan = '5'><div style='text-align:right'>DP : </div></td>
<td style='text-align:right'>Rp0,00</td>
</tr>
<tr>
<td colspan = '5'><div style='text-align:right'>Sisa : </div></td>
<td style='text-align:right'>Rp0,00</td></tr>
</table> -->
 
<!-- <table style='width:650; font-size:7pt;' cellspacing='2'>
<tr>
<td align='center'>Diterima Oleh,</br></br><u>(............)</u></td>
<td style='border:1px solid black; padding:5px; text-align:left; width:30%'></td>
<td align='center'>TTD,</br></br><u>(...........)</u></td>
</tr>
</table> -->
</center>
</body>
</html>