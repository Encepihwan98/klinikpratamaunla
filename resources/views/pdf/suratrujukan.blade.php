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
            <table width="100%">
                <tr>
                    <td class="text2">Bandung, {{date('d-m-Y')}}</td>
                </tr>
            </table>
        </table>
        <table>
            <tr>
                <td>Perihal</td>                
                <td>:</td>
                <td>Rujukan Pasien</td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td>
                    <font size="2">Kpd yth.<br>{{$data->rujukan}}<br>Di tempat</font>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td>
                    <font size="2">Dengan Hormat.<br>Bersama dengan ini saya merujuk pasien dengan</font>
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
                <td>Tanggal Lahir</td>
                <td width="">: {{$data->tgl_lahir}}</td>
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
                    <font size="2">Dengan Anamnesis :
                        <br>{{$data->anamnesis}}
                    </font>
                </td>
            </tr>
            <tr>
                <td>
                    <font size="2">Diagnosa Sementara :
                        <br>{{$data->anamnesis}}
                    </font>
                </td>
            </tr>
            <tr>
                <td>
                    <font size="2">Demikian surat rujukan ini kami buat
                        atas perhatian dan kerjasama yang diberikan, kami ucapkan terimakasih.
                    </font>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td width="410"><br><br><br><br></td>
                <td class="text" align="center">Pemeriksa<br><br><br><br><br>(Dr...................................)</td>
            </tr>
        </table>
    </center>
</body>

</html>