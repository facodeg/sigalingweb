<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <!-- Brand Logo Light -->
    <a href="index.html" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="index.html" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo">
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
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="p-3 text-white leftbar-user">
            <a href="#" class="d-flex align-items-center text-reset">
                <div class="flex-shrink-0">
                    <img src="{{ auth()->user()->anggota && auth()->user()->anggota->upload_foto_diri ? Storage::url(auth()->user()->anggota->upload_foto_diri) : asset('assets/images/users/avatar-1.jpg') }}"
                        alt="user-image" height="42" class="shadow rounded-circle">
                </div>
                <div class="flex-grow-1 ms-2">
                    <span class="fw-semibold fs-15 d-block">{{ auth()->user()->name }}</span>
                    <span class="fs-13">{{ auth()->user()->role }}</span>
                </div>
                <div class="ms-auto">
                    <i class="ri-arrow-right-s-fill fs-20"></i>
                </div>
            </a>
        </div>

        <!-- Sidebar -left -->
        {{-- <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="p-3 text-white leftbar-user">
            <a href="pages-profile.html" class="d-flex align-items-center text-reset">
                <div class="flex-shrink-0">
                    <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image" height="42"
                        class="shadow rounded-circle">
                </div>
                <div class="flex-grow-1 ms-2">
                    <span class="fw-semibold fs-15 d-block">{{ auth()->user()->name }}</span>
                    <span class="fs-13">{{ auth()->user()->role }}</span>
                </div>
                <div class="ms-auto">
                    <i class="ri-arrow-right-s-fill fs-20"></i>
                </div>
            </a>
        </div> --}}

        <!--- Sidemenu -->


        <ul class="side-nav">


            @if (auth()->user()->role == 'admin')
                <li class="side-nav-item">
                    <a href="{{ route('home') }}" class="side-nav-link">
                        <i class="ri-dashboard-2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                {{-- <li
                    class="side-nav-item {{ Request::is('dashboard-koperasi') || Request::is('simpanan_wajib*') || Request::is('angsuran*') || Request::is('whatsapp*') || Request::is('pinjaman*') || Request::is('anggotas*') ? 'menuitem-active' : '' }}">
                    <a data-bs-toggle="collapse" href="#koperasi" aria-expanded="false" aria-controls="sidebarPages"
                        class="side-nav-link">
                        <i class="ri-layout-fill"></i>
                        <span>Koperasi</span>
                        <span class="menu-arrow"></span>
                    </a>
                </li> --}}



                {{-- <div class="collapse {{ Request::is('dashboard-koperasi') || Request::is('limitpinjaman*') || Request::is('simpanan_wajib*') || Request::is('whatsapp*') || Request::is('angsuran*') || Request::is('pinjaman*') || Request::is('anggotas*') || Request::is('apiwhatsapp*') ? 'show' : '' }}"
                    id="koperasi">

                    <li class="mt-1 side-nav-title"> Dashboard</li>

                    <li class='{{ Request::is('dashboard.koperasi') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('dashboard.koperasi') }}" class="side-nav-link">
                            <i class="ri-building-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="mt-1 side-nav-title"> Data Anggota</li>

                    <li class='{{ Request::is('anggotas*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('anggotas.index') }}" class="side-nav-link">
                            <i class="ri-group-fill"></i>
                            <span>Anggota</span>
                        </a>
                    </li>




                    <li class='{{ Request::is('konfirmasi*') ? 'menuitem-active' : '' }} side-nav-item'>
                        <a href="{{ route('konfirmasi.index') }}" class="side-nav-link">
                            <i class="ri-user-add-fill"></i>
                            <span>Pendaftaran</span>

                            @if (Request::is('konfirmasi') || Request::is('admin/home'))
                                <span class="badge bg-success ms-2">{{ $totalProses }}</span>
                            @endif

                            <!-- Menampilkan jumlah total anggota 'Proses' -->
                        </a>
                    </li>

                    <li class="mt-1 side-nav-title"> Transaksi</li>

                    <li class='{{ Request::is('limitpinjaman*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('limitpinjaman.index') }}" class="side-nav-link">
                            <i class="ri-bank-card-line"></i>
                            <span>Limit Pinjaman</span>

                        </a>
                    </li>

                    <li class='{{ Request::is('pinjaman*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('pinjaman.index') }}" class="side-nav-link">
                            <i class="ri-money-dollar-circle-line"></i>
                            <span>Pinjaman</span>

                            @if (Request::is('konfirmasi') || Request::is('admin/home') || Request::is('pinjaman'))
                                <span class="badge bg-success ms-2">{{ $totalajuanpinjaman }}</span>
                            @endif

                        </a>
                    </li>

                    <li class='{{ Request::is('angsuran*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('angsuran.index') }}" class="side-nav-link">
                            <i class="ri-exchange-funds-line"></i>
                            <span>Angsuran</span>
                        </a>
                    </li>

                    <li class='{{ Request::is('simpanan_wajib*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('simpanan_wajib.index') }}" class="side-nav-link">
                            <i class="ri-save-line"></i>
                            <span>Simpanan</span>
                        </a>
                    </li>

                    <li class="mt-1 side-nav-title"> WhatsApp</li>

                    <li class='{{ Request::is('whatsapp*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('whatsapp.index') }}" class="side-nav-link">
                            <i class="ri-whatsapp-line"></i>
                            <span>WhatsApp</span>
                        </a>
                    </li>

                    <li class="mt-1 side-nav-title"> API WhatsApp</li>

                    <li class='{{ Request::is('apiwhatsapp*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('apiwhatsapp.index') }}" class="side-nav-link">
                            <i class="ri-whatsapp-line"></i>
                            <span>API WhatsApp</span>
                        </a>
                    </li>

                </div> --}}

                <li
                    class="side-nav-item {{ Request::is('pendidikan*') || Request::is('surat_praktek_satu*') ? 'menuitem-active' : '' }}">
                    <a data-bs-toggle="collapse" href="#kepegawaian" class="side-nav-link" aria-expanded="false">
                        <i class="ri-parent-fill"></i>
                        <span>Kepegawaian</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse" id="kepegawaian">
                        <ul class="side-nav-second-level">
                            <li class="{{ Request::is('pendidikan*') ? 'menuitem-active' : '' }}">
                                <a href="{{ route('pendidikan.index') }}">
                                    <i class="ri-time-line"></i>
                                    <span>Pendidikan</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('surat_praktek_satu*') ? 'menuitem-active' : '' }}">
                                <a href="{{ route('surat_praktek_satu.index') }}">
                                    <i class="ri-file-list-3-line"></i>
                                    <span>Pembuatan Surat</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>




                {{-- <li class="side-nav-item">
                        <a href="{{ route('izins.index') }}" class="side-nav-link">
                            <i class="ri-calendar-todo-line"></i>
                            <span>Izin</span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('notes.index') }}" class="side-nav-link">
                            <i class="ri-notes-line"></i>
                            <span>Catatan</span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('pegawais.index') }}" class="side-nav-link">
                            <i class="ri-user-line"></i>
                            <span>Pegawai</span>
                        </a>
                    </li>

                    <li class="mt-1 side-nav-title"> Pengaturan</li>


                    <li class="side-nav-item">
                        <a href="{{ route('users.index') }}" class="side-nav-link">
                            <i class="ri-user-add-line"></i>
                            <span>Akun Pegawai</span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('companies.show', 1) }}" class="side-nav-link">
                            <i class="ri-building-line"></i>
                            <span>Perusahaan</span>
                        </a>
                    </li>

                    <li class="mt-1 side-nav-title"> Laporan</li>


                    <li class="side-nav-item">
                        <a href="{{ route('reports.monthly') }}" class="side-nav-link">
                            <i class="ri-calendar-check-line"></i>
                            <span>Laporan Presensi Bulanan</span>
                        </a>
                    </li> --}}



    </div>

    {{-- <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarPOS" aria-expanded="false" aria-controls="sidebarPages"
                        class="side-nav-link">
                        <i class="ri-store-fill"></i>
                        <span>Point of Sale</span>
                        <span class="menu-arrow"></span>
                    </a>
                </li>
                <div class="collapse {{ Request::is('pemasok*') || Request::is('kategori*') || Request::is('units*') || Request::is('merek*') || Request::is('barang*') || Request::is('pembelian*') || Request::is('stok*') ? 'show' : '' }} "
                    id="sidebarPOS">

                    <li class="mt-1 side-nav-title"> Barang</li>

                    <li class='{{ Request::is('kategori*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('kategori.index') }}" class="side-nav-link">
                            <i class="ri-price-tag-line"></i>
                            <span>Kategori</span>
                        </a>
                    </li>
                    <li class='{{ Request::is('units*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('units.index') }}" class="side-nav-link">
                            <i class="ri-edit-box-line"></i>
                            <span>Units</span>
                        </a>
                    </li>
                    <li class='{{ Request::is('merek*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('merek.index') }}" class="side-nav-link">
                            <i class="ri-price-tag-3-line"></i>
                            <span>Merek</span>
                        </a>
                    </li>
                    <li class='{{ Request::is('barang*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('barang.index') }}" class="side-nav-link">
                            <i class="ri-gift-line"></i>
                            <span>Barang</span>
                        </a>
                    </li>
                    <!-- Tambahkan stok disini -->
                    <li class='{{ Request::is('stok*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('stok.index') }}" class="side-nav-link">
                            <i class="ri-stack-line"></i>
                            <span>Stok</span>
                        </a>
                    </li>

                    <li class="mt-1 side-nav-title"> Transaksi</li>

                    <li class='{{ Request::is('pembelian*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('pembelian.index') }}" class="side-nav-link">
                            <i class="ri-shopping-cart-line"></i>
                            <span>Pembelian</span>
                        </a>
                    </li>
                    <li class="side-nav-item">
                        <a href="#" class="side-nav-link">
                            <i class="ri-bar-chart-line"></i>
                            <span>Penjualan</span>
                        </a>
                    </li>
                    <li class="mt-1 side-nav-title"> Administrasi</li>
                    <li class="side-nav-item">
                        <a href="#" class="side-nav-link">
                            <i class="ri-user-line"></i>
                            <span>Pelanggan</span>
                        </a>
                    </li>
                    <li class='{{ Request::is('pemasok*') ? 'menuitem-active' : '' }}' class="side-nav-item">
                        <a href="{{ route('pemasok.index') }}" class="side-nav-link">
                            <i class="ri-store-2-line"></i>
                            <span>Pemasok</span>
                        </a>
                    </li>
                    <li class="mt-1 side-nav-title"> Keuangan</li>

                    <li class="side-nav-item">
                        <a href="#" class="side-nav-link">
                            <i class="ri-calculator-line"></i>
                            <span>Akuntansi</span>
                        </a>
                    </li>
                </div>

                </li> --}}
    @endif

    @if (auth()->user()->role == 'anggota')



        <li class="side-nav-item {{ Request::is('peranggota/home') ? 'menuitem-active' : '' }}">
            <a href="{{ route('home') }}" class="side-nav-link">
                <i class="ri-dashboard-2-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="mt-1 side-nav-title"> Transaksi</li>
        @if ($anggota->status == 'aktif')
            <li class="side-nav-item" class='{{ Request::is('anggotas/perbarui*') ? 'menuitem-active' : '' }}'>
                <a href="{{ route('anggotas.perbarui') }}" class="side-nav-link">
                    <i class="ri-edit-box-fill"></i>
                    <span>Perbarui Data </span>
                </a>
            </li>
            <li class="side-nav-item" class='{{ Request::is('anggota*') ? 'menuitem-active' : '' }}'>
                <a href="{{ route('anggota.index') }}" class="side-nav-link">
                    <i class="ri-group-fill"></i>
                    <span>Profil</span>
                </a>
            </li>
            <li class="side-nav-item" class='{{ Request::is('pengajuanpinjaman*') ? 'menuitem-active' : '' }}'>
                <a href="{{ route('pengajuanpinjaman.index') }}" class="side-nav-link">
                    <i class="ri-money-dollar-circle-fill"></i>
                    <span>Pinjaman</span>
                </a>
            </li>
            <li class="side-nav-item" class='{{ Request::is('user/*/edit-password') ? 'menuitem-active' : '' }}'>
                <a href="{{ route('koperasi.anggota.edit-password', ['id' => auth()->user()->id]) }}"
                    class="side-nav-link">
                    <i class="ri-lock-password-fill"></i>
                    <span>Ubah Password</span>
                </a>
            </li>
        @endif
    @endif

    {{-- @if (auth()->user()->role == 'koperasi')
                <li class="side-nav-item">
                    <a href="{{ route('home') }}" class="side-nav-link">
                        <i class="ri-dashboard-2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="mt-1 side-nav-title"> Data Anggota</li>

                <li class="side-nav-item {{ Request::is('anggotas*') ? 'menuitem-active' : '' }}">
                    <a href="{{ route('anggotas.index') }}" class="side-nav-link">
                        <i class="ri-group-fill"></i>
                        <span>Anggota</span>
                    </a>
                </li>

                <li class="side-nav-item" class='{{ Request::is('konfirmasi*') ? 'menuitem-active' : '' }} '>
                    <a href="{{ route('konfirmasi.index') }}" class="side-nav-link">
                        <i class="ri-user-add-fill"></i>
                        <span>Pendaftaran</span>
                        @if (Request::is('konfirmasi') || Request::is('koperasi/home'))
                            <span class="badge bg-success ms-2">{{ $totalProses }}</span>
                        @endif
                    </a>
                </li>

                <li class="mt-1 side-nav-title"> Transaksi</li>

                <li class='side-nav-item {{ Request::is('pinjaman*') ? 'menuitem-active' : '' }}'>
                    <a href="{{ route('pinjaman.index') }}" class="side-nav-link">
                        <i class="ri-money-dollar-circle-line"></i>
                        <span>Pinjaman</span>
                        @if (Request::is('konfirmasi') || Request::is('koperasi/home') || Request::is('pinjaman'))
                            <span class="badge bg-success ms-2">{{ $totalajuanpinjaman }}</span>
                        @endif
                    </a>
                </li>

                <li class='side-nav-item {{ Request::is('angsuran*') ? 'menuitem-active' : '' }}'>
                    <a href="{{ route('angsuran.index') }}" class="side-nav-link">
                        <i class="ri-exchange-funds-line"></i>
                        <span>Angsuran</span>
                    </a>
                </li>

                <li class='side-nav-item {{ Request::is('simpanan_wajib*') ? 'menuitem-active' : '' }}'>
                    <a href="{{ route('simpanan_wajib.index') }}" class="side-nav-link">
                        <i class="ri-save-line"></i>
                        <span>Simpanan</span>
                    </a>
                </li>

                <!-- Tambahan Menu untuk Limit Pinjaman -->
                <li class="mt-1 side-nav-title"> Limit Pinjaman</li>

                <li class='side-nav-item {{ Request::is('limitpinjaman*') ? 'menuitem-active' : '' }}'>
                    <a href="{{ route('limitpinjaman.index') }}" class="side-nav-link">
                        <i class="ri-bank-card-line"></i>
                        <span>Limit Pinjaman</span>

                    </a>
                </li>
            @endif --}}


    </ul>
    <div class="clearfix"></div>
</div> <!-- end .h-100 -->
</div> <!-- end .leftside-menu -->
