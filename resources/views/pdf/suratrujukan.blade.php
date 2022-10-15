<!DOCTYPE html>
<html>

<head>
    <title>contoh surat pengunguman</title>
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
        <table>
            <!-- <tr>
				<td><img src="LOGO.jpg" width="90" height="90"></td>
				<td>
				<center>
					<font size="4">LEMBAGA PERATIKUM 2019</font><br>
					<font size="5"><b>SMK BAITUL HIKAH</b></font><br>
					<font size="2">Bidang Keahlian : Bisnis dan Menejemen - Teknologi informasi dan Komunikasi</font><br>
					<font size="2"><i>Jln Cut Nya'Dien No. 02 Kode Pos : 68173 Telp./Fax (0331)758005 Tempurejo Jember Jawa Timur</i></font>
				</center>
				</td>
			</tr> -->
            <!-- <tr>
				<td colspan="2"><hr></td>
			</tr> -->
            <!-- <table width="625">
			<tr>
				<td class="text2">Jember, 16 mei 2019</td>
			</tr>
		</table> -->
        </table>
        <table>
            <tr class="">
                <td>
                    <center>
                        <font size="4">Surat Rujukan</font><br>
                        <font size="3"><b>No. </b></font><br>
                    </center>
                </td>
                <td width="572">: -</td>
            </tr>
            <!-- <tr>
                <td>Perihal</td>
                <td width="564">: -</td>
            </tr> -->
        </table>
        <br>
        <table width="625">
            <tr>
                <td>
                    <font size="2">Kpd yth.<br>{{$data->rujukan}}<br>Di tempat</font>
                </td>
            </tr>
        </table>
        <br>
        <table width="625">
            <tr>
                <td>
                    <font size="2">Dengan Hormat.<br>Mohon untuk pemeriksaan dan pengobatan lebih lanjut terhadap pasien.</font>
                </td>
            </tr>
        </table>
        <br>
        </table>
        <table>
            <tr class="text2">
                <td>Nama</td>
                <td width="541">: {{$data->nama}}</td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td width="525">: {{$data->tgl_lahir}}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td width="525">: {{$data->jenis_kelamin}}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{$data->alamat}}</td>
            </tr>
        </table>
        <br>
        <table width="625">
            <tr>
                <td>
                    <font size="2">Dengan Anamnesis :<br>
                        <br>{{$data->anamnesis}}
                    </font>
                </td>
            </tr>
            <tr>
                <td>
                    <font size="2">Diagnosa Sementara :<br>
                        <br>{{$data->anamnesis}}
                    </font>
                </td>
            </tr>
            <tr>
                <td>
                    <font size="2">Demikian surat rujukan ini kami kirimkan & kami mohon balasa rujukan ini.
                        atas perhatian dan kerjasama yang diberikan. kami ucapkan terimkasih.
                    </font>
                </td>
            </tr>
        </table>
        <br>
        <table width="625">
            <tr>
                <td width="430"><br><br><br><br></td>
                <td class="text" align="center">Wali kelas<br><br><br><br>Bpk Fauzy.s.kom</td>
            </tr>
        </table>
    </center>
</body>

</html>