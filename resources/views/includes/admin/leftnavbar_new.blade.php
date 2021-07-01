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
                        <a href="{{route('admin.dashboard')}}"> <i class="menu-icon fa fa-dashboard"></i>PANEL KENDALI </a>
                    </li>
                    <h3 class="menu-title">Pengelolaan</h3><!-- /.menu-title -->
                    {{-- {{ dd(array_values(session('cekMenu'))) }} --}}
                        @foreach(session('data_menu_utama') as $index => $all)
                            @if(array_search(session('data_menu_utama')[$index]['id'], array_column(session('data_menu_cabang'), 'parent','label')) != '')
                                <li class="menu-item-has-children dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>{{ session('data_menu_utama')[$index]['label'] }}</a>
                                        <ul class="sub-menu children dropdown-menu">
                                    
                                        @foreach(session('data_menu_cabang') as $index => $nested)
                                            @if($all['id'] == session('data_menu_cabang')[$index]['parent'])
                                                <li><i class="menu-icon fa fa-laptop"></i><a href="{{url(session('data_menu_cabang')[$index]['link'])}}">{{ session('data_menu_cabang')[$index]['label'] }}</a></li>
                                            @endif
                                        @endforeach
                                        </ul>
                                    
                                </li>
                            @elseif(in_array(session('data_menu_utama')[$index]['menu'], session('cekMenu')))
                                <li>
                                    <a href="{{url(session('data_menu_utama')[$index]['link'])}}"><i class="menu-icon fa fa-table"></i>{{ session('data_menu_utama')[$index]['label'] }}</a>
                                </li>
                            @endif
                        @endforeach
                    {{-- <li>
                        <a href="{{route('admin.edit_menu')}}"> <i class="menu-icon ti-email"></i>Pengelolaan Menu</a>
                    </li> --}}
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->