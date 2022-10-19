<!DOCTYPE html>
<html>
<head>
	<title>Rekamedis Pasien</title>
	<style type="text/css">
		table {
			/* border-style: double; */
			/* border-width: 3px; */
			/* border-color: white; */
            border-collapse: collapse;
		}
		table tr .text2 {
			text-align: right;
			font-size: 13px;
		}
		table tr .text {
			text-align: center;
			font-size: 13px;
		}
		table tr td {
			font-size: 13px;
		}

	</style>
</head>
<body>
	<center>
		<table width=100%>
			<tr>
				<td>
                    <!-- <img src="LOGO.jpg" width="90" height="90"> -->
                </td>
				<td>
				<center>
					<font size="5"><b>KLINIK PRATAMA</b></font><br>
					<font size="5"><b>Universitas Langlangbuana - Bandung<b></font><br>
					<font size="2"><i>Jalan Karapitan No. 116, Kota Bandung Jawa Barat, Indonesia 40261</i></font>
				</center>
				</td>
			</tr>
			<tr>
				<td colspan="2"><hr></td>
			</tr>
		</table>
		<table width="100%">
			<tr class="text2">
				<center>
					<font size="5"><b>Laporan Rekamedis Pasien<b></font><br>
				</center>
			</tr>
			<tr><p style="text-align: Left;">Nama: {{$rekamedis->nama}}</p></tr>
		</table>
		<br>
		<table border="1px solid black" width=100%>
        <thead>
            <tr>
                <td>No</td>
                <td>Tgl Pemriksaan</td>
                <td>BB</td>
				<td>TB</td>
				<td>Tensi</td>
                <td>Anamnesi</td>
                <td>Keluhan</td>
            </tr>
        </thead>
        @foreach($data as $value)
        <tbody>
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$value->tgl}}</td>
                <td>{{$value->bb}}</td>
				<td>{{$value->tb}}</td>
				<td>{{$value->tensi}}</td>
				<td>{{$value->anamnesis}}</td>
				<td>{{$value->keluhan}}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
	</center>
</body>
</html>