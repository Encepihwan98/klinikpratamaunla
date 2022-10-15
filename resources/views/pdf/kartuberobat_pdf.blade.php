<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .row {
            margin: 10px;
        }

        .container {
            width: 400px;
            height: 300px;
        }

        h3,
        h5 {
            margin: 0px;
        }

        .center {
            text-align: center;
        }

        .border {
            border-style: solid;
        }

        .m {
            margin: 0px;
        }

        .kartu {
            text-align: center;
            font-weight: bold;
            background-color: black;
            color: white;
        }
    </style>
</head>
<!-- <body> -->
<body style='font-family:tahoma; font-size:8pt;' onload="javascript:window.print()">
    <div class="container border">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="center">KLINIK PRATAMA</h3>
                <h3 class="center">UNIVERSITAS LANGLANGBUANA</h3>
                <h5 class="center">Jl karapitan no 116</h5>
            </div>
            <div class="col-lg-12 m">
                <h4 class="kartu">Kartu Berobat</h4>
            </div>
            <div class="col-lg-12">
                <table border="1">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{$data->nama}}</td>
                    </tr>
                    <tr>
                        <td>Tgl Lahir</td>
                        <td>:</td>
                        <td>{{$data->tgl_lahir}}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{$data->alamat}}</td>
                    </tr>
                    <tr>
                        <td>
                            <p>Perhatian :</p>
                        </td>
                        <td>
                            <p>Setiap Berobat Harus di Bawa</p>
                        </td>
                    </tr>
                </table>
                <div class="">
                    <table>

                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>