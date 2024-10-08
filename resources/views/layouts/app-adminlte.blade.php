@inject("branchs","App\Models\Branch")
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>رسالة | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
          href="{{asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/summernote/summernote-bs4.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- Bootstrap 4 RTL -->
{{--    <link rel="stylesheet" href="https://cdn.rtlc   ss.com/bootstrap/v4.2.1/css/bootstrap.min.css">--}}
<!-- Custom style for RTL -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/plugins/bootstrap-4.2.1-dist/css/rtl/bootstrap.min.css')}}">
{{--    <link rel="stylesheet" href="{{asset('build/assets/app-6c7380a2.css')}}">--}}

<!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('adminlte/plugins/toastr/toastr.min.css')}}">
    @livewireStyles
    @stack('style')
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">

    <!-- Navbar sidebar-mini sidebar-collapse -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            {{--            <li class="nav-item d-none d-sm-inline-block">--}}
            {{--                <a href="" class="nav-link">Home</a>--}}
            {{--            </li>--}}
            {{--            <li class="nav-item d-none d-sm-inline-block">--}}
            {{--                <a href="#" class="nav-link">Contact</a>--}}
            {{--            </li>--}}
        </ul>

        <!-- SEARCH FORM -->
    {{--        <form class="form-inline ml-3">--}}
    {{--            <div class="input-group input-group-sm">--}}
    {{--                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">--}}
    {{--                <div class="input-group-append">--}}
    {{--                    <button class="btn btn-navbar" type="submit">--}}
    {{--                        <i class="fas fa-search"></i>--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </form>--}}

    <!-- Right navbar links -->
        <ul class="navbar-nav mr-auto-navbav">

            @if(auth()->user()->role == 'superAdmin')

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-home"></i>
                        {{$branchs->find(session('branch_id'))->name}}
                        <span class="badge badge-warning navbar-badge"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                        <div class="dropdown-divider"></div>
                        @foreach($branchs->get() as $branch)
                            <a href="{{route('branch_change',$branch->id)}}" class="dropdown-item {{session('branch_id')==$branch->id ? 'bg-primary':''}}">
                                <i class="fa fa-home mr-2"></i> {{$branch->name}}
                            </a>
                            <div class="dropdown-divider"></div>
                        @endforeach
                    </div>
                </li>
            @endif


            <!-- Messages Dropdown Menu -->

            <!-- Notifications Dropdown Menu -->

            {{--                        <li class="nav-admin">--}}
            {{--                            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">--}}
            {{--                                <i class="fas fa-th-large"></i>--}}
            {{--                            </a>--}}
            {{--                        </li>--}}
            <li class="nav-admin {{(request()->is('links')? 'active' : "")}}">
                <a class="nav-link" href="{{route('user.links')}}">
                    <i class="fas fa-link"> روابط تهمك </i>
                </a>
            </li>
{{--            @if(auth()->user()->role == 'admin' or auth()->user()->role =='superAdmin'or auth()->user()->role =='supervisor')--}}
                @can('approval show')
                    <li class="nav-admin">
                        <a class="nav-link {{(request()->is('user/approval')? 'active' : "")}}"
                           href="{{route('approval')}}">
                            <i class="fas fa-th-large"> الموافقات </i>
                        </a>
                    </li>
                @endcan
{{--            @endif--}}


            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <img src="{{asset(auth()->user()->photo)}}" class="user-image img-circle elevation-2"
                         alt="User Image">
                    <span class="d-none d-md-inline">{{auth()->user()->name}}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="{{asset(auth()->user()->photo)}}" class="img-circle elevation-2" alt="User Image">

                        <p>
                            {{auth()->user()->name}} - {{auth()->user()->position?->name}}
                            <small> تم الانضمام منذ {{auth()->user()->join_date}}</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                {{--                    <li class="user-body">--}}
                {{--                        <div class="row">--}}
                {{--                            <div class="col-4 text-center">--}}
                {{--                                <a href="#">Followers</a>--}}
                {{--                            </div>--}}
                {{--                            <div class="col-4 text-center">--}}
                {{--                                <a href="#">Sales</a>--}}
                {{--                            </div>--}}
                {{--                            <div class="col-4 text-center">--}}
                {{--                                <a href="#">Friends</a>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                        <!-- /.row -->--}}
                {{--                    </li>--}}
                <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="{{route('profile.show')}}" class="btn btn-default btn-flat">صفحة شخصية</a>
                        <a href="#" class="btn btn-default btn-flat float-right" onclick="event.preventDefault();
                           $('#logout').submit();">خروج</a>
                        <form action="{{route('logout')}}" method="post" id="logout">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="{{asset('Resala-logo.png')}}" alt="Resala Logo"
                 class="brand-image elevation-3 bg-white"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">جمعية رسالة</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->

            @include('layouts.navigation-adminlte')
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if (isset($header))
                            <h1 class="m-0 text-dark">{{$header}}</h1>
                        @endif
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        {{--                        <ol class="breadcrumb float-sm-right">--}}
                        {{--                            <li class="breadcrumb-admin"><a href="#">Home</a></li>--}}
                        {{--                            <li class="breadcrumb-admin">Dashboard v1</li>--}}
                        {{--                        </ol>--}}
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                {{ $slot }}
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>2024 &copy; <a href="https://github.com/mohamedsabaawy" target="_blank">mohamed samy</a></strong>
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> beta
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

</div>
@livewireScripts
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 rtl -->
<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('adminlte/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('adminlte/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('adminlte/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/jqvmap/maps/jquery.vmap.world.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('adminlte/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('adminlte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('adminlte/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('adminlte/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('adminlte/dist/js/demo.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('adminlte/plugins/toastr/toastr.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('adminlte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

<script>
    window.addEventListener('close', event => {
        // alert('s sdfsdf ')
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000
        });

        $('#create-model').modal('hide');
        // $('#edit-branch').modal('hide');
        $('#delete-model').modal('hide');
        Toast.fire({
            type: 'success',
            title: 'تم الحفظ بنجاح'
        })
    })

</script>
<!-- date-range-picker -->
<script src="{{asset('adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
@stack('script')
</body>
</html>
