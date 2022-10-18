<!DOCTYPE html>
<html>

<head>
    <title>Surat Sehat</title>
    <style type="text/css">
        table {
            border-style: double;
            border-width: 3px;
            border-color: white;
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
        <table width="100%">
            <tr>
                <!-- <td><img src="LOGO.jpg" width="90" height="90"></td> -->
                <td>
                    <center>
                        <font size="4">KLINIK PRATAMA</font><br>
                        <font size="5"><b>UNIVERSITAS LANGLANGBUANA</b></font><br>
                        <font size="2"><i>Jln Karapitan No 116, Kota Bandung, 40264</i></font>
                    </center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>
        </table>
        <table width="100%">
			<tr class="text2">
				<center>
					<font size="5"><b>SURAT KETERANGAN SEHAT<b></font><br>
				</center>
			</tr>
		</table>
        <br>
        
        <br>
        <table width="100%">
            <tr>
                <td>
                    <font size="2">Yang bertanda tangan dibawah ini menerangkan bawah :</font>
                </td>
            </tr>
        </table>
        <br>
        </table>
        <table width="">
            <tr class="text2">
                <td>Nama</td>
                <td width="">: {{$data->nama}}</td>
            </tr>
            <tr>
                <td>Umur</td>
                <td width="">: {{$umur}}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td width="">: {{$data->jenis_kelamin}}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{$data->alamat}}</td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td>
                    <font size="2">Berdasarkan pemeriksaan fisik pada hari ini dalam keadaan SEHAT. Adapun surat kerengan sehat ini dimaksudkan
                        untuk keperluan : {{$keperluan}} <br>
                        Demikian kami sampaikan, agar dipergunakan sebagai mana mestinya.
                    </font>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td width="410"><br><br><br><br></td>
                <td class="text" align="center">Bandung, {{date('d-m-Y')}} <br>
                    Dokter Pemeriksa<br><br><br><br><br>(Dr...................................)</td>
            </tr>
        </table>
    </center>
</body>

</html>