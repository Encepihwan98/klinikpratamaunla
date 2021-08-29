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
                            <h4>Poli Klinik Mata</h4>    
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
                            <button class="btn btn-warning mr-2 btn-sm ml-2">Pasien Pulang/Selesai</button>    
                        </div>
                    </div>
                </div>
                <br>

                <div id="tabsSimple" class="col-lg-12 col-12">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Simple Tabs</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area simple-tab">
                            <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#penunjang" role="tab" aria-controls="home" aria-selected="true">Penunjang</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active " id="diagnosa-tab" data-toggle="tab" href="#diagnosa" role="tab" aria-controls="contact" aria-selected="false">Diagnosa</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tindakan-tab" data-toggle="tab" href="#tindakan" role="tab" aria-controls="contact" aria-selected="false">Tindakan/Pemeriksaan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="umum-tab" data-toggle="tab" href="#umum" role="tab" aria-controls="contact" aria-selected="false">Pemeriksaan Umum</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="resep-tab" data-toggle="tab" href="#resep" role="tab" aria-controls="contact" aria-selected="false">Resep</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="simpletabContent">
                                <div class="tab-pane fade " id="penunjang" role="tabpanel" aria-labelledby="home-tab">
                                   @include('perawatan.rawat-jalan.input.penunjang')
                                </div>
                                <div class="tab-pane fade show active" id="diagnosa" role="tabpanel" aria-labelledby="diagnosa-tab">
                                    <p class="">
                                        @include('perawatan.rawat-jalan.input.diagnosa')
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="tindakan" role="tabpanel" aria-labelledby="tindakan-tab">
                                    <p class="">
                                        @include('perawatan.rawat-jalan.input.tindakan')
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="umum" role="tabpanel" aria-labelledby="umum-tab">
                                    <p class="">
                                        @include('perawatan.rawat-jalan.input.umum')
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="resep" role="tabpanel" aria-labelledby="resep-tab">
                                    <p class="">
                                        @include('perawatan.rawat-jalan.input.resep')
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

            </div>
        </div>
    </div>
</div> 
@endsection

@section('script')
    <script src="{{url('assets/js/scrollspyNav.js')}}"></script>
    <script src="{{url('plugins/highlight/highlight.pack.js')}}"></script>
@endscript