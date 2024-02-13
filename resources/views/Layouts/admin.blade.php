<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>Attendance | @yield('title')</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/simplebar.css') }}">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/feather.css') }}">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/app-light.css') }}" id="lightTheme" disabled>
    <link rel="stylesheet" href="{{ asset('assets/css/app-dark.css') }}" id="darkTheme">
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script> -->

</head>

<body class="vertical  dark rtl ">
    <x-toaster />
    <div class="wrapper">
        <nav class="topnav navbar navbar-light">
            <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
                <i class="fe fe-menu navbar-toggler-icon"></i>
            </button>
            <form class="form-inline mr-auto searchform text-muted">
                <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search" placeholder="Type something..." aria-label="Search">
            </form>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="dark">
                        <i class="fe fe-sun fe-16"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-shortcut">
                        <span class="fe fe-grid fe-16"></span>
                    </a>
                </li>
                <li class="nav-item nav-notif">
                    <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-notif">
                        <span class="fe fe-bell fe-16"></span>
                        <span class="dot dot-md bg-success"></span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar avatar-sm mt-2">
                            <img src="{{ asset('assets/assets/avatars/face-1.jpg') }}" alt="..." class="avatar-img rounded-circle">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activities</a>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout').submit()">Logout</a>
                        <form id="logout" action="{{ route('admin.logout') }}" method="post">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
            <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
                <i class="fe fe-x"><span class="sr-only"></span></i>
            </a>
            <nav class="vertnav navbar navbar-light">
                <!-- nav bar -->
                <div class="w-100 mb-4 d-flex">
                    <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                        <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 120 120" xml:space="preserve">
                            <g>
                                <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                                <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                                <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                            </g>
                        </svg>
                    </a>
                </div>
                <ul class="navbar-nav flex-fill w-100 mb-2">
                    <li class="nav-item dropdown">
                        <a href="./dashboard.html" class="nav-link">
                            <i class="fe fe-home fe-16"></i>
                            <span class="ml-3 item-text">لوحة التحكم</span><span class="sr-only">(current)</span>
                        </a>
                    </li>
                </ul>
                <p class="text-muted nav-heading mt-4 mb-1">
                    <span>أجزاء النظام</span>
                </p>
                <ul class="navbar-nav flex-fill w-100 mb-2">
                    <li class="nav-item dropdown">
                        <a href="#ui-elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                            <i class="fe fe-users fe-16"></i>
                            <span class="ml-3 item-text">المدرسين</span>
                        </a>
                        <ul class="collapse list-unstyled pl-4 w-100" id="ui-elements">
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="./instructors.html"><span class="ml-1 item-text">قائمة المدرسين</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Of Instructors -->

                        <li class="nav-item dropdown">
                            <a href="#employees" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                                <i class="fe fe-users fe-16"></i>
                                <span class="ml-3 item-text">الإداريين</span>
                            </a>
                            <ul class="collapse list-unstyled pl-4 w-100" id="employees">
                                <li class="nav-item">
                                    <a class="nav-link pl-3" href="{{ route('admin.employees.index') }}"><span class="ml-1 item-text">قائمة الإداريين</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">إضافة إداري جديد</span></a>
                                </li>
                            </ul>
                        </li>
                        <!-- End Of Employees -->

                    <li class="nav-item dropdown">
                        <a href="#attendance" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                            <i class="fe fe-check fe-16"></i>
                            <span class="ml-3 item-text">الحضور</span>
                        </a>
                        <ul class="collapse list-unstyled pl-4 w-100" id="attendance">
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="{{route('admin.teacher_attendence.index')}}"><span class="ml-1 item-text">تحضير المدرسين</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="./attendance.html"><span class="ml-1 item-text">تحضير الإداريين</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Of Attendance Table -->

<<<<<<< HEAD
                    <li class="nav-item dropdown">
                        <a href="#tables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                            <i class="fe fe-archive fe-16"></i>
                            <span class="ml-3 item-text">المعاملات</span>
                        </a>
                        <ul class="collapse list-unstyled pl-4 w-100" id="tables">
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">المدرسين (غياب وتأخير)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">الإداريين (غياب وتأخير)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="./sent-emails.html"><span class="ml-1 item-text">أرشيف المعاملات</span></a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Of Archive -->
=======
                        <li class="nav-item dropdown">
                            <a href="#teachers" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                                <i class="fe fe-archive fe-16"></i>
                                <span class="ml-3 item-text">معاملات المدرسين</span>
                            </a>
                            <ul class="collapse list-unstyled pl-4 w-100" id="teachers">
                                <li class="nav-item">
                                    <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">الغياب</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">التأخير</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pl-3" href="./sent-emails.html"><span class="ml-1 item-text">أرشيف المعاملات</span></a>
                                </li>
                            </ul>
                        </li>
                        <!-- End Of Archive -->

                        <li class="nav-item dropdown">
                            <a href="#employees-absence" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                                <i class="fe fe-archive fe-16"></i>
                                <span class="ml-3 item-text">معاملات الإداريين</span>
                            </a>
                            <ul class="collapse list-unstyled pl-4 w-100" id="employees-absence">
                                <li class="nav-item">
                                    <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">الغياب</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">التأخير</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link pl-3" href="./sent-emails.html"><span class="ml-1 item-text">أرشيف المعاملات</span></a>
                                </li>
                            </ul>
                        </li>
                        <!-- End Of Archive -->
>>>>>>> 551db68ae0fe0a65e9b08fb3e318fe439f17822c

                    <li class="nav-item dropdown">
                        <a href="#tables" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                            <i class="fe fe-archive fe-16"></i>
                            <span class="ml-3 item-text">معاملات المدرسين</span>
                        </a>
                        <ul class="collapse list-unstyled pl-4 w-100" id="tables">
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">غياب</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">تاخير</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="./sent-emails.html"><span class="ml-1 item-text">أرشيف المعاملات</span></a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="#charts" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                            <i class="fe fe-folder fe-16"></i>
                            <span class="ml-3 item-text">نماذج الإشعارات</span>
                        </a>
                        <ul class="collapse list-unstyled pl-4 w-100" id="charts">
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="./email-templates.html"><span class="ml-1 item-text">قائمة النماذج المتاحة بالنطام</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link pl-3" href="#"><span class="ml-1 item-text">إضافة نموذج جديد</span></a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Of Email Templates -->

                    <li class="nav-item w-100">
                        <a class="nav-link" href="./days.html">
                            <i class="fe fe-calendar fe-16"></i>
                            <span class="ml-3 item-text">جدول الأيام</span>
                        </a>
                    </li>
                    <!-- End Of Calender -->

                    <li class="nav-item w-100">
                        <a class="nav-link" href="./profile-settings.html">
                            <i class="fe fe-settings fe-16"></i>
                            <span class="ml-3 item-text">إعدادات الملف الشخصي</span>
                        </a>
                    </li>
                    <!-- End Of Calender -->

                    <li class="nav-item w-100">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout').submit()">
                            <i class="fe fe-power fe-16"></i>
                            <span class="ml-3 item-text">تسجيل الخروج</span>
                        </a>
                        <form id="logout" action="{{ route('admin.logout') }}" method="post">
                            @csrf
                        </form>
                    </li>
                    <!-- End Of Calender -->

                </ul>

            </nav>
        </aside>
        @yield('content')
    </div> <!-- .wrapper -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.stickOnScroll.js') }}"></script>
    <script src="{{ asset('assets/js/tinycolor-min.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('assets/js/d3.min.js') }}"></script>
    <script src="{{ asset('assets/js/topojson.min.js') }}"></script>
    <script src="{{ asset('assets/js/datamaps.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/datamaps-zoomto.js') }}"></script>
    <script src="{{ asset('assets/js/datamaps.custom.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.min.js') }}"></script>
    <script>
        /* defind global options */
        Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
        Chart.defaults.global.defaultFontColor = colors.mutedColor;
    </script>
    <script src="{{ asset('assets/js/gauge.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/apexcharts.custom.js') }}"></script>
    <script src="{{ asset('assets/js/apps.js') }}"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-56159088-1');
    </script>
<!-- Load DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Load DataTables Bootstrap 5 Integration -->
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    @yield('scripts')
</body>

</html>