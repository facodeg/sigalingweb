<!--start header -->




<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="gap-1 d-flex align-items-center gap-lg-2">

            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                <!-- Logo light -->
                <!-- Logo Light -->
                <a href="{{ url('/') }}" class="logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo">
                    </span>
                </a>

                <!-- Logo Dark -->
                <a href="{{ url('/') }}" class="logo-dark">
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="dark logo">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo">
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
            <div class="app-search dropdown d-none d-lg-block">
                <form>
                    <div class="input-group">
                        <input type="search" class="form-control dropdown-toggle" placeholder="Search..."
                            id="top-search">
                        <span class="ri-search-line search-icon"></span>
                    </div>
                </form>

                <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">
                    <!-- item-->

                </div>
            </div>
        </div>

        <ul class="gap-3 topbar-menu d-flex align-items-center">
            <li class="dropdown d-lg-none">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i class="ri-search-line fs-22"></i>
                </a>
                <div class="p-0 dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">
                    <form class="p-3">
                        <input type="search" class="form-control" placeholder="Search ..."
                            aria-label="Recipient's username">
                    </form>
                </div>
            </li>



            {{-- <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i class="ri-notification-3-fill fs-22"></i>
                    <span class="noti-icon-badge">{{ $noteCount }}</span>
                    <!-- Menggunakan noti-icon-badge untuk menampilkan jumlah notifikasi -->
                </a>
                <div class="py-0 dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">
                    <div class="p-2 border border-dashed border-top-0 border-start-0 border-end-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 fs-16 fw-medium">Notification</h6>
                            </div>
                            <div class="col-auto">
                                <a href="javascript:void(0);" class="text-dark text-decoration-underline">
                                    <small>Clear All</small>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div style="max-height: 300px;" data-simplebar>
                        <h5 class="p-2 mb-0 text-muted fs-12 fw-bold text-uppercase">Today</h5>

                        @foreach ($noteData->take(8) as $note)
                            <!-- item -->
                            <a href="javascript:void(0);"
                                class="p-0 m-0 shadow-none dropdown-item notify-item unread-noti card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="notify-icon bg-primary">
                                                <i class="ri-message-3-line fs-18"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 text-truncate ms-2">
                                            <h5 class="noti-item-title fw-medium fs-14">{{ $note->title }} <small
                                                    class="fw-normal text-muted float-end ms-1">{{ $note->created_at->diffForHumans() }}</small>
                                            </h5>
                                            <small class="noti-item-subtitle text-muted">{{ $note->note }}</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                        <!-- Example for another notification type -->
                        <h5 class="p-2 mb-0 text-muted fs-12 fw-bold text-uppercase">Yesterday</h5>
                        @foreach ($izinData->where('is_approved', 0)->take(8) as $izin)
                            <!-- item -->
                            <a href="javascript:void(0);"
                                class="p-0 m-0 shadow-none dropdown-item notify-item read-noti card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="notify-icon">
                                                <img src="{{ asset('storage/izin/' . $izin->image) }}"
                                                    class="img-fluid rounded-circle" alt="user avatar">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 text-truncate ms-2">
                                            <h5 class="noti-item-title fw-medium fs-14">{{ $izin->user->name }} <small
                                                    class="fw-normal text-muted float-end ms-1">{{ $izin->created_at->diffForHumans() }}</small>
                                            </h5>
                                            <small class="noti-item-subtitle text-muted">{{ $izin->reason }}</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- All -->
                    <a href="javascript:void(0);"
                        class="py-2 text-center dropdown-item text-primary text-decoration-underline fw-bold notify-item border-top border-light">
                        View All
                    </a>
                </div>
            </li> --}}






            <li class="d-none d-sm-inline-block">
                <div class="nav-link" id="light-dark-mode">
                    <i class="ri-moon-fill fs-22"></i>
                </div>
            </li>


            <li class="d-none d-md-inline-block">
                <a class="nav-link" href="" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line fs-22"></i>
                </a>
            </li>

            <li class="dropdown me-md-2">
                <a class="px-2 nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="{{ auth()->user()->anggota && auth()->user()->anggota->upload_foto_diri ? Storage::url(auth()->user()->anggota->upload_foto_diri) : asset('assets/images/users/avatar-1.jpg') }}"
                            alt="user-image" width="32" class="rounded-circle">
                    </span>

                    <span class="gap-1 d-lg-flex flex-column d-none">
                        <h5 class="my-0">{{ auth()->user()->name }}</h5>
                        <h6 class="my-0 fw-normal">{{ auth()->user()->role }}</h6>
                    </span>
                </a>


                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <!-- item-->
                    {{-- <div class=" dropdown-header noti-title">
                        <h6 class="m-0 text-overflow">Welcome !</h6>
                    </div>


                    <a href="pages-profile.html" class="dropdown-item">
                        <i class="align-middle ri-account-circle-fill me-1"></i>
                        <span>My Account</span>
                    </a>


                    <a href="pages-profile.html" class="dropdown-item">
                        <i class="align-middle ri-settings-4-fill me-1"></i>
                        <span>Settings</span>
                    </a>


                    <a href="pages-faq.html" class="dropdown-item">
                        <i class="align-middle ri-customer-service-2-fill me-1"></i>
                        <span>Support</span>
                    </a> --}}


                    {{-- <a href="auth-lock-screen.html" class="dropdown-item">
                        <i class="align-middle ri-lock-password-fill me-1"></i>
                        <span>Lock Screen</span>
                    </a> --}}


                    <a href="#" class="dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-log-out-circle"></i>
                        <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </div>
            </li>
        </ul>
    </div>
</div>
<!--end header -->
<!--end header -->
