<div class="container">
    <!-- form -->
    <div class="row mt-4">
        <div class="col-lg-3 col-sm-3">
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
        <div class="col-lg-6 col-sm-6">
            <div class="input-group input-group-sm mb-4">
                <input type="text" class="form-control" placeholder="Serch" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-search"></i></span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-3">
            <button class="btn btn-primary btn-sm right" data-toggle="modal" data-target="#diagnosaModal">Tambah Data</button>
        </div>
    </div>
    <!-- end form -->
    <div class="widget-content widget-content-area">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="">Waktu <i class="fas fa-search"></i></th>
                        <th class="">Fasilitas <i class="fas fa-search"></i></th>
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
                                <li><a href="{{url('/rawat_jalan/view')}}" data-toggle="tooltip" data-placement="top" title="edit"><i class="fas fa-pencil"></i></a></li>
                                <li><a href="{{url('/rawat_jalan/view')}}" data-toggle="tooltip" data-placement="top" title="hapus"><i class="fas fa-trash"></i></a></li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="diagnosaModal" tabindex="-1" role="dialog" aria-labelledby="diagnosaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="diagnosaModalLabel">Diagnosa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="row">
                            <div class="form-group input-group-sm mb-12 col-lg-12">
                                <p class="dt">Penyakit :</p>
                                <select class="form-control g_right" id="exampleFormControlSelect1">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                    <option>All</option>
                                </select>
                            </div>

                            <div class="form-group input-group-sm mb-12 col-lg-12">
                                <p class="dt">Lama Menderita :</p>
                                <input type="text" class="form-control" placeholder="Lama Menderita" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>

                            <div class="form-group input-group-sm mb-6 col-lg-6">
                                <p>Kasus</p>
                                <select class="form-control g_right" id="exampleFormControlSelect1">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                    <option>All</option>
                                </select>
                            </div>
                            <div class="form-group input-group-sm mb-6 col-lg-6">
                                <p>Tipe</p>
                                <select class="form-control g_right" id="exampleFormControlSelect1">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                    <option>All</option>
                                </select>
                            </div>

                            <div class="form-group input-group-sm mb-12 col-lg-12">
                                <p>Petugas</p>
                                <select class="form-control g_right" id="exampleFormControlSelect1">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                    <option>All</option>
                                </select>
                            </div>

                            <div class="form-group input-group-sm mb-12 col-lg-12">
                                <p>Waktu Rujukan</p>
                                <label for="t-text" class="sr-only">Text</label>
                                <input type="date" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="button" class="btn btn-primary btn-sm">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>