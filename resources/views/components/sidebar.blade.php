<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <!-- Brand Logo Light -->
    <div class="text-center mb-4">
        <!-- Logo Light (untuk latar gelap) -->
        <a href="{{ url('/') }}" class="logo d-none dark-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="img-fluid" style="max-height: 90px;">
        </a>

        <!-- Logo Dark (untuk latar terang) -->
        <a href="{{ url('/') }}" class="logo d-block">
            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="dark logo" class="img-fluid"
                style="max-height: 90px;">
        </a>


    </div>



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




                <li
                    class="side-nav-item
    {{ Request::is('pendidikan*') ||
    Request::is('surat_praktek_satu*') ||
    Request::is('pegawai*') ||
    Request::is('karyawan*') ||
    Request::is('riwayat_jabatan*') ||
    Request::is('riwayat_golongan*') ||
    Request::is('riwayat_sk*') ||
    Request::is('riwayat_mutasi*') ||
    Request::is('pendidikan_db*')
        ? 'menuitem-active'
        : '' }}">
                    <a data-bs-toggle="collapse" href="#adminKepegawaian" class="side-nav-link"
                        aria-expanded="{{ Request::is('pendidikan*') || Request::is('surat_praktek_satu*') || Request::is('pegawai*') || Request::is('karyawan*') || Request::is('riwayat_jabatan*') || Request::is('riwayat_golongan*') || Request::is('riwayat_sk*') || Request::is('riwayat_mutasi*') || Request::is('pendidikan_db*') ? 'true' : 'false' }}">
                        <i class="ri-parent-fill"></i>
                        <span>Admin Kepegawaian</span>
                        <span class="menu-arrow"></span>
                    </a>

                    <div class="collapse {{ Request::is('pendidikan*') || Request::is('surat_praktek_satu*') || Request::is('pegawai*') || Request::is('karyawan*') || Request::is('riwayat_jabatan*') || Request::is('riwayat_golongan*') || Request::is('riwayat_sk*') || Request::is('riwayat_mutasi*') || Request::is('pendidikan_db*') ? 'show' : '' }}"
                        id="adminKepegawaian">
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
                            <li class="{{ Request::is('permintaan-skk*') ? 'menuitem-active' : '' }}">
                                <a href="{{ route('skk.index') }}">
                                    <i class="ri-user-3-line"></i>
                                    <span>Permintaan SKK</span>
                                </a>
                            </li>


                            <li class="{{ Request::is('karyawan*') ? 'menuitem-active' : '' }}">
                                <a href="{{ route('karyawan.index') }}">
                                    <i class="ri-user-star-line"></i>
                                    <span>Karyawan</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('users*') ? 'menuitem-active' : '' }}">
                                <a href="{{ route('users.index') }}">
                                    <i class="ri-user-add-line"></i>
                                    <span>Akun Pegawai</span>
                                </a>
                            </li>

                            <!-- Submenu Kepegawaian -->
                            <li
                                class="
                {{ Request::is('karyawan*') ||
                Request::is('riwayat_jabatan*') ||
                Request::is('riwayat_golongan*') ||
                Request::is('riwayat_sk*') ||
                Request::is('riwayat_mutasi*') ||
                Request::is('pendidikan_db*')
                    ? 'menuitem-active'
                    : '' }}">
                                {{-- <a data-bs-toggle="collapse" href="#menuKepegawaian"
                                    aria-expanded="{{ Request::is('karyawan*') || Request::is('riwayat_jabatan*') || Request::is('riwayat_golongan*') || Request::is('riwayat_sk*') || Request::is('riwayat_mutasi*') || Request::is('pendidikan_db*') ? 'true' : 'false' }}">
                                    <i class="ri-parent-fill"></i>
                                    <span>Kepegawaian</span>
                                    <span class="menu-arrow"></span>
                                </a> --}}
                                <div class="collapse {{ Request::is('karyawan*') || Request::is('riwayat_jabatan*') || Request::is('riwayat_golongan*') || Request::is('riwayat_sk*') || Request::is('riwayat_mutasi*') || Request::is('pendidikan_db*') ? 'show' : '' }}"
                                    id="menuKepegawaian">
                                    <ul class="side-nav-second-level">

                                        {{-- <li class="{{ Request::is('riwayat_jabatan*') ? 'menuitem-active' : '' }}">
                                            <a href="{{ route('riwayat_jabatan.index') }}">
                                                <i class="ri-briefcase-line"></i>
                                                <span>Riwayat Jabatan</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('riwayat_golongan*') ? 'menuitem-active' : '' }}">
                                            <a href="{{ route('riwayat_golongan.index') }}">
                                                <i class="ri-bar-chart-box-line"></i>
                                                <span>Riwayat Golongan</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('riwayat_sk*') ? 'menuitem-active' : '' }}">
                                            <a href="{{ route('riwayat_sk.index') }}">
                                                <i class="ri-draft-line"></i>
                                                <span>Riwayat SK</span>
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('riwayat_mutasi*') ? 'menuitem-active' : '' }}">
                                            <a href="{{ route('riwayat_mutasi.index') }}">
                                                <i class="ri-exchange-line"></i>
                                                <span>Riwayat Mutasi</span>
                                            </a>
                                        </li> --}}

                                    </ul>
                                </div>
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
        <li class="side-nav-item {{ Request::is('pegawairsudl/home') ? 'menuitem-active' : '' }}">
            <a href="{{ route('home') }}" class="side-nav-link">
                <i class="ri-dashboard-2-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="mt-1 side-nav-title"> Pengaturan</li>


        <li class="side-nav-item" class='{{ Request::is('user/*/edit-password') ? 'menuitem-active' : '' }}'>
            <a href="{{ route('koperasi.anggota.edit-password', ['id' => auth()->user()->id]) }}"
                class="side-nav-link">
                <i class="ri-lock-password-fill"></i>
                <span>Ubah Password</span>
            </a>
        </li>
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
