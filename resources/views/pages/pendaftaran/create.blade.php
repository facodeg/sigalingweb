<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Form Wizard | Jidox - Material Design Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

<!-- Theme Config Js -->
<script src="{{ asset('assets/js/config.js') }}"></script>

<!-- App CSS -->
<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

<!-- Icons CSS -->
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">


        <!-- ========== Topbar Start ========== -->
        <div class="navbar-custom">
            <div class="topbar container-fluid">
                <div class="gap-1 d-flex align-items-center gap-lg-2">

                    <!-- Topbar Brand Logo -->
                    <div class="logo-topbar">
                        <!-- Logo light -->
                        <a href="index.html" class="logo-light">
                            <span class="logo-lg">
                                <img src="assets/images/logo.png" alt="logo">
                            </span>
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="small logo">
                            </span>
                        </a>

                        <!-- Logo Dark -->
                        <a href="index.html" class="logo-dark">
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="dark logo">
                            </span>
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="small logo">
                            </span>
                        </a>
                    </div>

                    <!-- Sidebar Menu Toggle Button -->
                    <button class="button-toggle-menu">
                        <i class="ri-menu-2-fill"></i>
                    </button>

                    <!-- Horizontal Menu Toggle Button -->
                    <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>

                    <!-- Topbar Search Form -->

                </div>


            </div>
        </div>
        <!-- ========== Topbar End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- Brand Logo Light -->
            <a href="index.html" class="logo logo-light">
                <span class="logo-lg">
                    <img src="assets/images/logo.png" alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="small logo">
                </span>
            </a>

            <!-- Brand Logo Dark -->
            <a href="index.html" class="logo logo-dark">
                <span class="logo-lg">
                    <img src="assets/images/logo-dark.png" alt="dark logo">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo-sm.png" alt="small logo">
                </span>
            </a>

            <!-- Sidebar Hover Menu Toggle Button -->
            <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
                <i class="align-middle ri-checkbox-blank-circle-line"></i>
            </div>

            <!-- Full Sidebar Menu Close Button -->
            <div class="button-close-fullsidebar">
                <i class="align-middle ri-close-fill"></i>
            </div>

            <!-- Sidebar -left -->

        </div>
        <!-- ========== Left Sidebar End ========== -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div
                                class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                                <h4 class="page-title">Form Wizard</h4>
                                <ol class="m-0 breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Jidox</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                    <li class="breadcrumb-item active">Form Wizard</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->




                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-3 header-title">Wizard With Progress Bar</h4>

                                    <form action="{{ route('pendaftaran.store') }}" method="POST">
                                        @csrf
                                        <div id="progressbarwizard">
                                            <ul class="mb-3 nav nav-pills nav-justified form-wizard-header">
                                                <li class="nav-item">
                                                    <a href="#account-2" data-bs-toggle="tab"
                                                        class="py-1 nav-link rounded-0">
                                                        <i
                                                            class="align-middle ri-account-circle-line fw-normal fs-18 me-1"></i>
                                                        <span class="d-none d-sm-inline">Account</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#profile-tab-2" data-bs-toggle="tab"
                                                        class="py-1 nav-link rounded-0">
                                                        <i
                                                            class="align-middle ri-profile-line fw-normal fs-18 me-1"></i>
                                                        <span class="d-none d-sm-inline">Profile</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#finish-2" data-bs-toggle="tab"
                                                        class="py-1 nav-link rounded-0">
                                                        <i
                                                            class="align-middle ri-check-double-line fw-normal fs-18 me-1"></i>
                                                        <span class="d-none d-sm-inline">Finish</span>
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="mb-0 tab-content b-0">
                                                <div id="bar" class="mb-3 progress" style="height: 7px;">
                                                    <div
                                                        class="bar progress-bar progress-bar-striped progress-bar-animated bg-success">
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="account-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3 row">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="userName1">User name</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control"
                                                                        id="userName1" name="userName1"
                                                                        value="{{ old('userName1') }}">
                                                                    @error('userName1')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="password1">Password</label>
                                                                <div class="col-md-9">
                                                                    <input type="password" id="password1"
                                                                        name="password1" class="form-control">
                                                                    @error('password1')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="confirm1">Re Password</label>
                                                                <div class="col-md-9">
                                                                    <input type="password" id="confirm1"
                                                                        name="confirm1" class="form-control">
                                                                    @error('confirm1')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->

                                                    <ul class="mb-0 list-inline wizard">
                                                        <li class="next list-inline-item float-end">
                                                            <a href="javascript:void(0);" class="btn btn-info">Add
                                                                More Info <i class="ri-arrow-right-line ms-1"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="tab-pane" id="profile-tab-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3 row">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="name1">First name</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" id="name1"
                                                                        name="name1" class="form-control"
                                                                        value="{{ old('name1') }}">
                                                                    @error('name1')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="surname1">Last name</label>
                                                                <div class="col-md-9">
                                                                    <input type="text" id="surname1"
                                                                        name="surname1" class="form-control"
                                                                        value="{{ old('surname1') }}">
                                                                    @error('surname1')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-md-3 col-form-label"
                                                                    for="email1">Email</label>
                                                                <div class="col-md-9">
                                                                    <input type="email" id="email1"
                                                                        name="email1" class="form-control"
                                                                        value="{{ old('email1') }}">
                                                                    @error('email1')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                    <ul class="mb-0 pager wizard list-inline">
                                                        <li class="previous list-inline-item">
                                                            <button type="button" class="btn btn-light"><i
                                                                    class="ri-arrow-left-line me-1"></i> Back to
                                                                Account</button>
                                                        </li>
                                                        <li class="next list-inline-item float-end">
                                                            <button type="button" class="btn btn-info">Add More Info
                                                                <i class="ri-arrow-right-line ms-1"></i></button>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="tab-pane" id="finish-2">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="text-center">
                                                                <h2 class="mt-0"><i
                                                                        class="ri-check-double-line"></i></h2>
                                                                <h3 class="mt-0">Thank you!</h3>
                                                                <p class="mx-auto mb-2 w-75">Quisque nec turpis at urna
                                                                    dictum luctus. Suspendisse convallis dignissim eros
                                                                    at volutpat. In egestas mattis dui. Aliquam mattis
                                                                    dictum aliquet.</p>
                                                                <div class="mb-3">
                                                                    <div class="form-check d-inline-block">
                                                                        <input type="checkbox"
                                                                            class="form-check-input" id="customCheck3"
                                                                            name="terms">
                                                                        <label class="form-check-label"
                                                                            for="customCheck3">I agree with the Terms
                                                                            and Conditions</label>
                                                                    </div>
                                                                    @error('terms')
                                                                        <div class="text-danger">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                    <ul class="mt-1 mb-0 pager wizard list-inline">
                                                        <li class="previous list-inline-item">
                                                            <button type="button" class="btn btn-light"><i
                                                                    class="ri-arrow-left-line me-1"></i> Back to
                                                                Profile</button>
                                                        </li>
                                                        <li class="next list-inline-item float-end">
                                                            <button type="submit"
                                                                class="btn btn-info">Submit</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div> <!-- tab-content -->
                                        </div> <!-- end #progressbarwizard-->
                                    </form>
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->


                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Jidox - Coderthemes.com
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>


        </div>



    </div>

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/demo.form-wizard.js') }}"></script>





    <script>
        $(document).ready(function() {
            $('#progressbarwizard').bootstrapWizard({
                onTabShow: function(tab, navigation, index) {
                    var $total = navigation.find('li').length;
                    var $current = index + 1;
                    var $percent = ($current / $total) * 100;
                    $('#bar').css({
                        width: $percent + '%'
                    });
                }
            });
        });
    </script>

</body>

</html>
