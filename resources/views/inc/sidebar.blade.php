<link href="{{url('assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{url('plugins/font-icons/fontawesome/css/regular.css')}}">
<link rel="stylesheet" href="{{url('plugins/font-icons/fontawesome/css/fontawesome.css')}}">

<style>
/*FAB*/
    .fontawesome .icon-section {
        padding: 30px;
    }
    .fontawesome .icon-section h4 {
        color: #3b3f5c;
        font-size: 17px;
        font-weight: 600;
        margin: 0;
        margin-bottom: 16px;
    }
    .fontawesome .icon-content-container {
        padding: 0 16px;
        width: 86%;
        margin: 0 auto;
        border: 1px solid #bfc9d4;
        border-radius: 6px;
    }
    .fontawesome .icon-section p.fs-text {
        padding-bottom: 30px;
        margin-bottom: 30px;
    }
    .fontawesome .icon-container { cursor: pointer; }
    .fontawesome .icon-container i {
        font-size: 20px;
        color: #3b3f5c;
        vertical-align: middle;
        margin-right: 10px;
    }
    .fontawesome .icon-container:hover i { color: #4361ee; }
    .fontawesome .icon-container span { color: #888ea8; display: none; }
    .fontawesome .icon-container:hover span { color: #4361ee; }
    .fontawesome .icon-link {
        color: #4361ee;
        font-weight: 600;
        font-size: 14px;
    }
</style>

<div class="sidebar-wrapper sidebar-theme">
    
    <nav id="sidebar">
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            
            <li class="menu">
                <a href="" class="dropdown-toggle">
                    <div class="icon-container" >
                        <i class="far fa-calendar-alt"></i>
                        <span class="icon-name">Beranda</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="#app" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Daftar Kunjungan</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="app" data-parent="#accordionExample">
                    <li>
                        <a href="apps_chat.html"> Rawat Inap </a>
                    </li>
                    <li>
                        <a href="apps_mailbox.html"> Rawat   </a>
                    </li>
                    <li>
                        <a href="apps_todoList.html"> Rawat Darurat (IGD) </a>
                    </li>                            
                </ul>
            </li>

            <li class="menu">
                <a href="#components" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span>Keuangan</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="components" data-parent="#accordionExample">
                    <li>
                        <a href="component_tabs.html"> Kasir Umum </a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="#elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>Regis Trasi</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="elements" data-parent="#accordionExample">
                    <li>
                        <a href="element_alerts.html"> Rawat Jalan </a>
                    </li>
                    <li>
                        <a href="element_avatar.html"> Rawat Inap </a>
                    </li>
                    <li>
                        <a href="element_badges.html"> Rawat Darurat (IGD) </a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="#instalasi" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                        <span>Instalasi Penunjang</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="instalasi" data-parent="#accordionExample">
                    <li>
                        <a href="apps_chat.html"> Laboratorium </a>
                    </li>
                    <li>
                        <a href="apps_mailbox.html"> Radiologi   </a>
                    </li>
                    <li>
                        <a href="apps_todoList.html"> Rehabilitasi Medik </a>
                    </li>
                    <li>
                        <a href="apps_todoList.html"> Operasi </a>
                    </li>   
                    <li>
                        <a href="apps_todoList.html"> Insenerator </a>
                    </li>
                    <li>
                        <a href="apps_todoList.html"> UTDRS </a>
                    </li>
                    <li>
                        <a href="apps_todoList.html"> Kamar Jenazah </a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="#farmasi" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>Farmasi & Logistik</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="farmasi" data-parent="#accordionExample">
                    <li>
                        <a href="element_alerts.html">  </a>
                    </li>
                    <li>
                        <a href="element_avatar.html"> Rawat Inap </a>
                    </li>
                    <li>
                        <a href="element_badges.html"> Rawat Darurat (IGD) </a>
                    </li>
                </ul>
            </li>

            <li>
                <a>Admin Area</a>
            </li>
            
            <li class="menu">
                <a href="table_basic.html" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                        <span>Daftar Pasien</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="table_basic.html" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                        <span>Daftar Pegawai</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="table_basic.html" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                        <span>Daftar Tarif</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="#poliklinik" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>Poliklinik/Ruangan</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="poliklinik" data-parent="#accordionExample">
                    <li>
                        <a href="element_badges.html"> Poliklinik </a>
                    </li>
                    <li>
                        <a href="element_badges.html"> Ruangan </a>
                    </li>
                    <li>
                        <a href="element_badges.html"> Kamar </a>
                    </li>
                    <li>
                        <a href="element_badges.html"> Ranjang </a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="#datatables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span>Master Data</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="datatables" data-parent="#accordionExample">
                    <li>
                        <a href="table_dt_basic.html"> Daftar Agama </a>
                    </li>
                    <li>
                        <a href="table_dt_striped_table.html"> Daftar Cara Bayar </a>
                    </li>
                    <li>
                        <a href="table_dt_ordering_sorting.html"> Daftar Gizi </a>
                    </li>
                    <li>
                        <a href="table_dt_multi-column_ordering.html"> Daftar Insenerator </a>
                    </li>
                    <li>
                        <a href="table_dt_multiple_tables.html"> Daftar Kasus</a>
                    </li>
                    <li>
                        <a href="table_dt_alternative_pagination.html"> Daftar Kegiatan</a>
                    </li>
                    <li>
                        <a href="table_dt_custom.html"> Daftar Oksigen </a>
                    </li>
                    <li>
                        <a href="table_dt_range_search.html"> Daftar Pekerjaan </a>
                    </li>
                    <li>
                        <a href="table_dt_html5.html"> Daftar Pemerikasaan Umum </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Daftar Pendidikan </a>
                    </li>
                    <li>
                        <a href="table_dt_miscellaneous.html"> Daftar Perawatan Khusus </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Daftar Penyakit </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Daftar Suku </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Daftar Tindakan </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Daftar Tindakan Operasi </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Daftar Tipe Diagnosa </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Daftar UTDRS </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Daftar Kecamatan </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Daftar Kota </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Jenis Identitas </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Jenis Logistik </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Jenis Poliklinik </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Jenis Registrasi </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Jenis Rujukan </a>
                    </li>
                    <li>
                        <a href="table_dt_live_dom_ordering.html"> Jenis Visite </a>
                    </li>
                </ul>
            </li>

            <li>
                <a>System</a>
            </li>

            <li class="menu">
                <a href="table_basic.html" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                        <span>Users</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="table_basic.html" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                        <span>Roles</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                <a href="table_basic.html" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                        <span>Activities</span>
                    </div>
                </a>
            </li>
        </ul>
        
    </nav>

</div>
<!--  END SIDEBAR  -->
        