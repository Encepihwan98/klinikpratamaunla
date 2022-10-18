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
            height: 280px;
        }

        h3,
        h4,
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
        p{
            padding: 3px;
            font-weight: bold;
            margin-top: 0px;
            margin-bottom: 0px;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- <body style='font-family:tahoma; font-size:8pt;' onload="javascript:window.print()"> -->
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
                <table style="margin-top: 10px;" width="250px">
                    <tr>
                        <td>
                            <h4>No Pasien</h4>
                        </td>
                        <td style="margin-right: -10px;">:</td>
                        <td>
                            <h4>{{$id}}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>Nama</h4>
                        </td>
                        <td style="margin-right: -10px;">:</td>
                        <td>
                            <h4>{{$data->nama}}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>Tgl Lahir</h4>
                        </td>
                        <td style="margin-right: -10px;">:</td>
                        <td>
                            <h4>{{$data->tgl_lahir}}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>No Hp</h4>
                        </td>
                        <td style="margin-right: -10px;">:</td>
                        <td>
                            <h4>{{$data->no_hp}}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>Alamat</h4>
                        </td>
                        <td style="margin-right: -10px;">:</td>
                        <td>
                            <h4>{{$data->alamat}}</h4>
                        </td>
                    </tr>
                </table>
                <div class="border" style="margin-top: 5px;">
                    <p>Harap Dibawa Setiap Berobat</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>