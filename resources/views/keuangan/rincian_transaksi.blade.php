@extends('layouts.base')

@section('style')
    <link href="{{url('assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{url('assets/css/tables/table-basic.css')}}">
    <link href="{{url('assets/css/components/tabs-accordian/custom-tabs.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                            <div class="col-lg-6">
                                <h4>Nama Pasien</h4>
                            </div>
                            <div class="col-lg-6">
                                <h4 style="float: right;">Nomor Kunjungan : 098</h4>    
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="continer">
                    <div class="col-lg-12 col-sm-12 mt-3">
                        <form method="post" class="ml-3 mr-3">
                            <div class="row">
                                <div class="form-group input-group-sm mb-4 col-lg-3">
                                    <p>Pasien</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="text" class="form-control" placeholder="Serch" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="form-group input-group-sm mb-4 col-lg-3">
                                    <p>Tempat, Tanggal Lahir</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="text" class="form-control" placeholder="Serch" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="form-group input-group-sm mb-4 col-lg-3">
                                    <p>Umur</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="text" class="form-control" placeholder="Serch" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="form-group input-group-sm mb-4 col-lg-3">
                                    <p>Alamat</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="text" class="form-control" placeholder="Serch" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                            <div class="col-lg-6">
                                <h4>Rincian Transaksi</h4>
                            </div>
                            <div class="col-lg-6">
                                <h4 style="float: right;">
                                    <button class="btn btn-success btn-sm"><i class="fas fa-print"></i></button>
                                </h4>    
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="continer">
                    <div class="col-lg-12 col-sm-12 mt-3 mb-4">
                        <div class="widget-content widget-content-area ">
                            <div class="table-responsive ">
                                <table class="table table-bordered table-highlight-head mb-1">
                                    <thead>
                                        <!-- <tr>
                                            <th rowspan="2">Layanan</th>
                                            <th rowspan="2">Jumlah <i class="fas fa-search"></i></th>
                                            <th colspan="3">Tarif <i class="fas fa-search"></i></th>
                                            <th rowspan="2">Tangguangn <i class="fas fa-search"></i></th>
                                            <th rowspan="2">Total</th>
                                        </tr> -->
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold text-center"  rowspan="2">Layanan</td>
                                            <td class="font-weight-bold text-center" rowspan="2">Jumlah</td>
                                            <td class="font-weight-bold text-center" colspan="4">Tarif</td>
                                            <td class="font-weight-bold text-center" rowspan="2">Tangguangn</td>
                                            <td class="font-weight-bold text-center" rowspan="2">Total</td>
                                        </tr>
                                        <tr>
                                            <td>Saran</td>
                                            <td>Pelayanan</td>
                                            <td>BPH</td>
                                            <td>Total</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-center" colspan="8">Registrasi</td>
                                        </tr>
                                        <tr>
                                            <td>Unit Rawat Darurat</td>
                                            <td>1</td>
                                            <td>2500</td>
                                            <td>2000</td>
                                            <td>0</td>
                                            <td>4500</td>
                                            <td>0</td>
                                            <td>4500</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-center" colspan="8">IGD</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-center" colspan="8">Tindakan Pemeriksaan</td>
                                        </tr>
                                        <tr>
                                            <td>Kumbah Lambung</td>
                                            <td>1</td>
                                            <td>2500</td>
                                            <td>2000</td>
                                            <td>0</td>
                                            <td>4500</td>
                                            <td>0</td>
                                            <td>4500</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold text-center" colspan="7">Total</td>
                                            <td>12000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        
            </div>
        </div>
    </div>
</div> 
@endsection

@section('script')
    <script src="{{url('assets/js/scrollspyNav.js')}}"></script>
    <script src="{{url('plugins/highlight/highlight.pack.js')}}"></script>
@endscript