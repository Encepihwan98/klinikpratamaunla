<!DOCTYPE html>
<html>
<head>
	<title>laporan Pasien</title>
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
					<font size="5"><b>Laporan Pasien<b></font><br>
				</center>
			</tr>
            <tr><p style="text-align: center;">Tanggal: {{$from}} s/d {{$to}}</p></tr>
		</table>
		<br>
		<table border="1px solid black" width=100%>
        <thead>
            <tr>
                <td>No</td>
                <td>Pasien ID</td>
                <td>Nama Pasien</td>
				<td>Jenis Kelamin</td>
                <td>Alamat</td>
                <td>Tgl</td>
				<td>Jenis Pembayaran</td>
            </tr>
        </thead>
        @foreach($data as $value)
        <tbody>
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$value->pasien_id}}</td>
                <td>{{$value->nama}}</td>
				<td>{{$value->jenis_kelamin}}</td>
				<td>{{$value->alamat}}</td>
				<td>{{$value->tgl}}</td>
				<td>{{$value->jenis_pembayaran}}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
	</center>
</body>
</html>