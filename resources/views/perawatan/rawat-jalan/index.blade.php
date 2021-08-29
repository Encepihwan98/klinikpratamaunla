@extends('layouts.base')
    <link rel="icon" type="image/x-icon" href="{{url('assets/img/favicon.ico')}}"/>
    <link rel="stylesheet" href="{{url('assets/css/tables/table-basic.css')}}">
@section('style')
    
@endsection

@section('content')
<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div id="basic" class="col-lg-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">                                
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Rawat Jalan Management</h4>    
                        </div>
                    </div>
                </div>
                <div class="container">
                    <!-- form -->
                    <div class="row mt-4">
                        <div class="col-lg-2 col-sm-2">
                            <div class="input-group input-group-sm mb-4">
                            <label for="tampilkan" class="p-1">Tampilkan : </label>
                                <select class="form-control g_right" id="exampleFormControlSelect1">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                    <option>All</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                            <div class="input-group input-group-sm mb-4">
                                <input type="text" class="form-control" placeholder="Serch" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-2">
                            <button class="btn btn-primary btn-sm right">Tambah Data</button>
                        </div>
                    </div>
                    <!-- end form -->
                    <div class="widget-content widget-content-area">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="">Name <i class="fas fa-search"></i></th>
                                        <th class="">Date <i class="fas fa-search"></i></th>
                                        <th class="">Sales <i class="fas fa-search"></i></th>
                                        <th class="text-center">Icons</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <p class="mb-0">Shaun Park</p>
                                        </td>
                                        <td>10/08/2020</td>
                                        <td>320</td>

                                        <td class="text-center">
                                            <ul class="table-controls">
                                                <li><a href="{{url('/rawat_jalan/view')}}" data-toggle="tooltip" data-placement="top" title="view"><i class="far fa-eye"></i></a></li>
                                                <!-- <li><a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Settings"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings text-primary"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></a> </li>
                                                <li><a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></li>
                                                <li><a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a></li> -->
                                            </ul>
                                        </td>
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
@endsection

@section('script')
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{url('assets/js/scrollspyNav.js')}}"></script>
@endsection