<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
    <title>Eco AL Cleaning - Magazina</title>
    <link href="{{asset('assets/libs/flot/css/float-chart.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/extra-libs/multicheck/multicheck.css')}}">
    <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <link href="{{asset('css/toastr.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<div id="main-wrapper">
    <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header" data-logobg="skin5">

                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                <a class="navbar-brand" href="">
                    <b class="logo-icon p-l-10"></b>
                    <span class="logo-text">
                        <h3>Eco AL Cleaning</h3>
                    </span>
                </a>
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
            </div>
            <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                <ul class="navbar-nav float-left mr-auto">
                    <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-none d-md-block">Opsionet <i class="fa fa-angle-down"></i></span>
                            <span class="d-block d-md-none"><i class="fa fa-plus"></i></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('categories')}}">Kategorite</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('agents')}}">Agjenti</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('makinat')}}">Makinat</a>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav float-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../../assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated">

                            <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="left-sidebar" data-sidebarbg="skin5">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav" class="p-t-30">
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-card-details"></i><span class="hide-menu">MAGAZINA </span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            @foreach($categories as $category)
                                <li class="sidebar-item"><a href="{{route('magazina', ['category' => strtolower($category->emertimi)])}}" class="sidebar-link"><i class="mdi mdi-account-card-details"></i><span class="hide-menu"> {{$category->emertimi}} </span></a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('arka')}}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">ARKA</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('makina_produkte')}}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">MAKINAT</span></a></li>
                </ul>
            </nav>
        </div>
    </aside>
    <div class="page-wrapper">
        @yield('content')
    </div>
</div>
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
<script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{asset('assets/extra-libs/sparkline/sparkline.js')}}"></script>
<script src="{{asset('js/waves.js')}}"></script>
<script src="{{asset('js/sidebarmenu.js')}}"></script>
<script src="{{asset('js/custom.min.js')}}"></script>
<script src="{{asset('assets/extra-libs/multicheck/datatable-checkbox-init.js')}}"></script>
<script src="{{asset('assets/extra-libs/multicheck/jquery.multicheck.js')}}"></script>
<script src="{{asset('assets/extra-libs/DataTables/datatables.min.js')}}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script>
    $('#zero_config').DataTable();
    jQuery('.data_arka').datepicker();
</script>
@if (session()->has('data'))
    <script>
        var data = "{{session('data')['msg']}}";
        notifySuccess(data)
    </script>
@endif
@if ($errors->any())
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                var data = "{{ $error }}";
                notifyError(data)
            </script>
        @endforeach
    @endif
@endif
</body>

</html>
