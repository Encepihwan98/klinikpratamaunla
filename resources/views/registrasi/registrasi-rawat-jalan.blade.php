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
                            <div class="col-lg-6 mt-1">
                                <h4>Registrasi Pasien Rawat Jalan</h4>
                            </div>
                            <div class="col-lg-6">
                                <h4 style="float: right;">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i> Pasien Baru
                                    </button>
                                </h4>    
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="continer">
                    <div class="col-lg-12 col-sm-12 mt-3">
                        <form method="post" class="ml-4 mr-4">
                            <div class="row">
                                <div class="form-group input-group-sm col-lg-4">
                                    <p class="font-weight-bold">Pasien</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <select class="form-control g_right" id="exampleFormControlSelect1">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
                                        <option>All</option>
                                    </select>
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Nomor Rekam Medis :</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="text" class="form-control" placeholder="Nomor Rekam Medis" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Nomor Identitas :</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="text" class="form-control" placeholder="Nomor Identitas" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                                </div>

                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Tempat, Tanggal Lahir:</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="text" class="form-control" placeholder="Tempat, Tanggal Lahir" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Alamat:</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="text" class="form-control" placeholder="Alamat" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Telepon/HP:</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="text" class="form-control" placeholder="Telepon/HP" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                                </div>
                            </div>
                            <hr/>
                            <div class="row mt-3">
                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Nomor Kunjungan:</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="text" class="form-control" placeholder="Nomor Kunjungan" aria-label="Small" aria-describedby="inputGroup-sizing-sm" disabled>
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Waktu Kunjungan:</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="date" class="form-control" placeholder="Waktu Kunjungan" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p class="font-weight-bold">Jenis Rujukan:</p>
                                    <select class="form-control g_right" id="exampleFormControlSelect1">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
                                        <option>All</option>
                                    </select>
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Nomor Rujukan:</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="text" class="form-control" placeholder="Nomor Kunjungan" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Asal Rujukan:</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="text" class="form-control" placeholder="Asal Kunjungan" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Tanggal Rujukan:</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="date" class="form-control" placeholder="Tanggal Rujukan" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>

                                <div class="form-group input-group-sm col-lg-4">
                                    <p class="font-weight-bold">Cara Pembayaran:</p>
                                    <select class="form-control g_right" id="exampleFormControlSelect1">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
                                        <option>All</option>
                                    </select>
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Nomor SJP:</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="date" class="form-control" placeholder="Nomor SJP" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Tanggal SJP:</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="date" class="form-control" placeholder="Tanggal SJP" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>

                                <div class="form-group input-group-sm col-lg-4">
                                    <p class="font-weight-bold">Penanggung Jawab:</p>
                                    <select class="form-control g_right" id="exampleFormControlSelect1">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
                                        <option>All</option>
                                    </select>
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p>Telp. Penanggung Jawab:</p>
                                    <label for="t-text" class="sr-only">Text</label>
                                    <input type="date" class="form-control" placeholder="Telp. Penanggung Jawab" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p class="font-weight-bold">Jenis Kasus:</p>
                                    <select class="form-control g_right" id="exampleFormControlSelect1">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
                                        <option>All</option>
                                    </select>
                                </div>

                                <div class="form-group input-group-sm col-lg-4">
                                    <p >Diagnosa Awal:</p>
                                    <select class="form-control g_right" id="exampleFormControlSelect1">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
                                        <option>All</option>
                                    </select>
                                </div>
                            </div>
                            <hr/>
                            <div class="row mt-3">
                                <div class="form-group input-group-sm col-lg-4">
                                    <p class="font-weight-bold">Jenis Registrasi:</p>
                                    <select class="form-control g_right" id="exampleFormControlSelect1">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
                                        <option>All</option>
                                    </select>
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p class="font-weight-bold">Poliklinik Tujuan:</p>
                                    <select class="form-control g_right" id="exampleFormControlSelect1">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
                                        <option>All</option>
                                    </select>
                                </div>
                                <div class="form-group input-group-sm col-lg-4">
                                    <p class="font-weight-bold">Jenis Kegiatan:</p>
                                    <select class="form-control g_right" id="exampleFormControlSelect1">
                                        <option>10</option>
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
                                        <option>All</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <div class="">
                                <button class="btn btn-sm btn-primary ml-4 mt-3 ml-3 mb-3">Simpan</button>
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