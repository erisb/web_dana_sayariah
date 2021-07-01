<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="/admin/dashboard"><img src="/admin/images/logo.png" alt="Logo"></a>
                <a class="navbar-brand hidden" href="/admin/dashboard"><img src="/admin/images/logo2.png" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{route('admin.dashboard')}}"> <i class="menu-icon fa fa-dashboard"></i>Panel Kendali </a>
                    </li>
                    <h3 class="menu-title">Pengelolaan</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Pengelolaan Pendana</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-laptop"></i><a href="{{route('admin.investor.verif')}}">Verifikasi Pendana</a></li>
                            <li><i class="menu-icon fa fa-laptop"></i><a href="{{route('admin.investor.manage')}}">Data Pendana</a></li>
                            <li><i class="menu-icon fa fa-laptop"></i><a href="{{route('admin.addInvestor')}}">Tambah Pendana</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Pengelolaan Proyek</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="fa fa-table"></i><a href="{{route('admin.proyek.create')}}">Buat Proyek</a></li>
                                <li><i class="fa fa-table"></i><a href="{{route('admin.proyek.manage')}}">Atur Proyek</a></li>
                                <li><i class="fa fa-table"></i><a href="{{route('admin.proyek.mutasi')}}">Mutasi Proyek</a></li>
                                <li><i class="fa fa-table"></i><a href="{{route('admin.proyek.finish')}}">Proyek Selesai</a></li>
                            </ul>
                        </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Pengelolaan Marketer</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-th"></i><a href="{{route('admin.marketer.manage')}}">Atur Marketer</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="{{route('admin.marketer.mutasi')}}">Mutasi Marketer</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('admin.proyek.payout')}}"><i class="menu-icon fa fa-table"></i>Pengelolaan Imbal Hasil</a>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Pengelolaan Gambar</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li>
                                    <i class="menu-icon fa fa-th"></i><a href="{{route('admin.manage_carousel')}}"></i>Pengelolaan Karosel</a>
                            </li>
                            <li>
                                    <i class="menu-icon fa fa-th"></i><a href="{{route('admin.manage.penghargaan')}}">Pengelolaan Penghargaan</a>
                            </li>
                            <li>
                                    <i class="menu-icon fa fa-th"></i><a href="{{route('admin.manage.khazanah')}}">Pengelolaan Khazanah</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('admin.e_coll_bni')}}"> <i class="menu-icon ti-email"></i>Data <span style="font-style: italic;"> E Collection</span> BNI</a>
                    </li>
                    <li>
                        <a href="{{route('admin.converter')}}"> <i class="menu-icon ti-email"></i>Convert CSV to JSON</a>
                    </li>
                    {{-- add new nav --}}
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Expor Laporan</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-table"></i><a href="{{route('admin.proyek.proyek_eksport_manage')}}">Expor Proyek</a></li>
                        </ul>
                    </li>
                    {{-- end new nav --}}
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon ti-email"></i>News</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon ti-email"></i><a href="{{route('admin.news')}}">Create News</a></li>
                            <li><i class="menu-icon ti-email"></i><a href="{{route('admin.listNews')}}">List News</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('admin.manage')}}"> <i class="menu-icon ti-email"></i>Manage Admin</a>
                    </li>
                    <li>
                        <a href="{{route('admin.edit_menu')}}"> <i class="menu-icon ti-email"></i>Manage Menu</a>
                    </li>
                   
                    <h3 class="menu-title">Request</h3><!-- /.menu-title -->

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon ti-email"></i>Messagging</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon ti-email"></i><a href="{{route('admin.broadcast')}}">Broadcast</a></li>
                            <li><i class="menu-icon ti-email"></i><a href="{{route('admin.singleMail')}}">Send Email</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon ti-email"></i>Penarikan Dana</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon ti-email"></i><a href="{{route('admin.investor.requestwithdraw')}}">Requested</a></li>
                            <li><i class="menu-icon ti-email"></i><a href="{{route('admin.investor.paidwithdraw')}}">Paid </a></li>
                            <li><i class="menu-icon ti-email"></i><a href="{{route('admin.investor.failedwithdraw')}}">Fail </a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->