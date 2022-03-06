
@php
$menu = App\Http\Controllers\AuthCT::menuNavigation();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Famlink Admin - @yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('assets/img/icon.ico') }}" type="image/x-icon"/>
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["{{ asset('assets/css/fonts.min.css') }}"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">

                <a href="/admin/auth" class="logo">
                    <img src="{{ asset('assets/img/logo.svg')}}" alt="navbar brand" class="navbar-brand">
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->
            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

                <div class="container-fluid">
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg"><img src="{{ asset('assets/img/profile.jpg')}}" alt="image profile" class="avatar-img rounded"></div>
                                            <div class="u-text">
                                                <h4>{{Auth::user()->name}}</h4>
                                                <p class="text-muted">{{$menu['role']->name}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/admin/auth/{{Auth::user()->id}}">Account Setting</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/logout">Logout</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="modal fade" id="setting_modal" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">
                                    <span class="fw-mediumbold">
                                        Update
                                    </span>
                                    <span class="fw-light">
                                        Data
                                    </span>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="setting_form_ui" >
                                <input type="hidden" id="setting_binding_id" name="setting_binding_id" value="">
                                <div class="modal-body">
                                    <div class="card-body">
                                        <div class="form-group form-show-validation row">
                                            <label for="username">Username <span class="required-label">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="username" aria-label="username" aria-describedby="username-addon" id="setting_username" name="username" required>
                                            </div>
                                        </div>
                                        <div class="form-group form-show-validation row">
                                            <label for="email">Email <span class="required-label">*</span></label>
                                            <div class="input-group">
                                                <input type="email" class="form-control" placeholder="email" aria-label="email" aria-describedby="email-addon" id="setting_email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="form-group form-show-validation row">
                                            <label for="name">Nama Akun <span class="required-label">*</span></label>
                                            <input type="text" class="form-control" id="setting_name" name="name" placeholder="Masukan Nama Akun" required>
                                        </div>
                                        <div class="form-group form-show-validation row">
                                            <label for="password">Password <span class="required-label">*</span></label>
                                            <input type="password" class="form-control" id="setting_password" name="password" placeholder="Enter Password">
                                        </div>
                                        <div class="form-group form-show-validation row">
                                            <label for="confirmpassword">Confirm Password <span class="required-label">*</span></label>
                                            <input type="password" class="form-control" id="setting_confirmpassword" name="setting_confirmpassword" placeholder="Enter Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" id="setting_form_btn_update" class="btn btn-primary">Update</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">

            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="{{ asset('assets/img/profile.jpg')}}"  class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    {{Auth::user()->name}}
                                    <span class="user-level">{{$menu['role']->name}}</span>
                                    <span class="caret"></span>
                                </span>
                            </a>
                            <div class="clearfix"></div>

                            <div class="collapse in" id="collapseExample">
                                <ul class="nav">
                                    <li>
                                        <a href='/admin/auth/{{Auth::user()->id}}'>
                                            <span class="link-collapse">Account Setting</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href='/logout'>
                                            <span class="link-collapse">Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-primary">
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">MAIN MENU</h4>
                            @php
                            $menu = App\Http\Controllers\AuthCT::menuNavigation();
                            @endphp
                        </li>
                        @foreach ($menu['navigation'] as $item)
                        <li class="nav-item submenu">
                            <a data-toggle="collapse" href="#{{$item->id}}">
                                <i class="{{$item->icon}}"></i>
                                <p>{{$item->title}}</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="{{$item->id}}">
                                <ul class="nav nav-collapse">
                                    @foreach($item->data as $item_parent)
                                    <li>
                                        <a href="{{$item_parent->url}}">
                                            <span class="sub-item">{{$item_parent->title}}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-panel">
            @include('sweetalert::alert')
            @yield('content')
            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright ml-auto">
                        2022, made with <i class="fa fa-heart heart text-danger"></i> by <a href="#">FAMLINK INDONESIA</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>
    <!-- Bootstrap Toggle -->
    <script src="{{ asset('assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js')}}"></script>
    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
    <!-- Atlantis JS -->
    <script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
    {{-- sweetalert --}}
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
    <!-- Moment JS -->
    <script src="{{ asset('assets/js/plugin/moment/moment.min.js') }}"></script>
    <!-- Bootstrap Toggle -->
    <script src="{{ asset('assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <!-- DateTimePicker -->
    <script src="{{ asset('assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/js/plugin/select2/select2.full.min.js')}}"></script>
    <!-- jQuery Validation -->
    <script src="{{ asset('assets/js/plugin/jquery.validate/jquery.validate.min.js')}}"></script>
    <!-- summernote -->
    <script src="{{ asset('assets/js/plugin/summernote/summernote-bs4.min.js')}}"></script>
    <!-- chart.js -->
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>
    <!-- Base JS -->
    <script src="{{ asset('assets/js/base.js')}}"></script>
    <script>

    </script>
    @yield('js')
</body>
</html>
