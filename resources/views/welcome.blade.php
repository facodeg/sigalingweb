<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">MHM</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
            <ul>
                <li class='{{ Request::is('home') ? 'mm-active' : '' }}'> <a href="{{ route('home') }}"><i
                            class='bx bx-radio-circle'></i>Presensi</a>
                </li>
                <li class='{{ Request::is('dashboard.koperasi') ? 'mm-active' : '' }}'> <a
                        href="{{ route('dashboard.koperasi') }}">
                        <i class='bx bx-radio-circle'></i>Koperasi</a>
                </li>
            </ul>
        </li>
        <li>
            <!-- Tambahkan kategori POS -->
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-box'></i>
                </div>
                <div class="menu-title">Koperasi</div>
            </a>
            <ul>
                <!-- Tambahkan item Anggota di sini -->
                <li class='{{ Request::is('anggotas*') ? 'mm-active' : '' }}'>
                    <a href="{{ route('anggotas.index') }}">
                        <div class="parent-icon"><i class="bx bx-group"></i></div>
                        <div class="menu-title">Anggota</div>
                    </a>
                </li>

                <li class='{{ Request::is('pinjaman*') ? 'mm-active' : '' }}'>
                    <a href="{{ route('pinjaman.index') }}">
                        <div class="parent-icon"><i class="bx bx-money"></i></div>
                        <div class="menu-title">Pinjaman</div>
                    </a>
                </li>

                <!-- Tambahkan item Angsuran di sini -->
                <li class='{{ Request::is('angsuran*') ? 'mm-active' : '' }}'>
                    <a href="{{ route('angsuran.index') }}">
                        <div class="parent-icon"><i class="bx bx-receipt"></i></div>
                        <div class="menu-title">Angsuran</div>
                    </a>
                </li>

                <!-- Tambahkan item Simpanan di sini -->
                <li class='{{ Request::is('simpanan_wajib*') ? 'mm-active' : '' }}'>
                    <a href="{{ route('simpanan_wajib.index') }}">
                        <div class="parent-icon"><i class="bx bx-save"></i></div>
                        <div class="menu-title">Simpanan</div>
                    </a>
                </li>
            </ul>
        </li>
        <li>

            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-task'></i>
                </div>
                <div class="menu-title">Kegiatan</div>
            </a>
            <ul>

                <li class='{{ Request::is('attendances*') ? 'mm-active' : '' }}'>
                    <a href="{{ route('attendances.index') }}">
                        <div class="parent-icon"><i class="bx bx-time-five"></i>
                        </div>
                        <div class="menu-title">Presensi</div>
                    </a>
                </li>

                <li class='{{ Request::is('izins*') ? 'mm-active' : '' }}'>
                    <a href="{{ route('izins.index') }}">
                        <div class="parent-icon"><i class="bx bx-calendar-minus"></i>
                        </div>
                        <div class="menu-title">Izin</div>
                    </a>
                </li>

                <li class='{{ Request::is('notes*') ? 'mm-active' : '' }}'>
                    <a href="{{ route('notes.index') }}">
                        <div class="parent-icon"><i class="bx bx-note"></i>
                        </div>
                        <div class="menu-title">Catatan</div>
                    </a>
                </li>

                <li class='{{ Request::is('pegawais*') ? 'mm-active' : '' }}'>
                    <a href="{{ route('pegawais.index') }}">
                        <div class="parent-icon"><i class="bx bx-user"></i>
                        </div>
                        <div class="menu-title">Pegawai</div>
                    </a>
                </li>

                <li class="menu-label">PENGATURAN</li>

                <li class='{{ Request::is('users*') ? 'mm-active' : '' }}'>
                    <a href="{{ route('users.index') }}">
                        <div class="parent-icon"><i class="bx bx-user-plus"></i>
                        </div>
                        <div class="menu-title">Akun Pegawai</div>
                    </a>
                </li>

                <li class='{{ Request::is('companies*') ? 'mm-active' : '' }}'>
                    <a href="{{ route('companies.show', 1) }}">
                        <div class="parent-icon"><i class="bx bx-building-house"></i>
                        </div>
                        <div class="menu-title">Perusahaan</div>
                    </a>
                </li>

                <li class="menu-label">Laporan</li>

                <li class='{{ Request::is('reports/monthly') ? 'mm-active' : '' }}'>
                    <a href="{{ route('reports.monthly') }}">
                        <div class="parent-icon"><i class="bx bx-calendar-check"></i></div>
                        <div class="menu-title">Laporan Presensi Bulanan</div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-store'></i>
                </div>
                <div class="menu-title">Point of Sale</div>
            </a>
            <ul>

                {{-- <li class='{{ Request::is('produk*') ? 'mm-active' : '' }}'>
            <a href="{{ route('produk.index') }}"> --}}
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bx bx-box"></i></div>
                        <div class="menu-title">Produk</div>
                    </a>
                    <ul>
                        <li class='{{ Request::is('kategori*') ? 'mm-active' : '' }}'>
                            <a href="{{ route('kategori.index') }}"><i class='bx bx-radio-circle'></i>Kategori</a>
                        </li>

                        <li class='{{ Request::is('units*') ? 'mm-active' : '' }}'>
                            <a href="{{ route('units.index') }}"><i class='bx bx-radio-circle'></i>Units</a>
                        </li>

                        <li class='{{ Request::is('merek*') ? 'mm-active' : '' }}'>
                            <a href="{{ route('merek.index') }}"><i class='bx bx-radio-circle'></i>Merek</a>
                        </li>

                        <li class='{{ Request::is('barang*') ? 'mm-active' : '' }}'>
                            <a href="{{ route('barang.index') }}"><i class='bx bx-radio-circle'></i>Barang</a>
                        </li>

                    </ul>
                </li>
                {{-- <li class='{{ Request::is('pembelian*') ? 'mm-active' : '' }}'>
            <a href="{{ route('pembelian.index') }}"> --}}
                {{-- <li class='{{ Request::is('pembelian*') ? 'mm-active' : '' }}'>
            <a href="{{ route('pembelian.index') }}"> --}}
                <li class='{{ Request::is('pembelian*') ? 'mm-active' : '' }}'>
                    <a href="{{ route('pembelian.index') }}">
                        <div class="parent-icon"><i class="bx bx-cart"></i></div>
                        <div class="menu-title">Pembelian</div>
                    </a>
                </li>
                {{-- <li class='{{ Request::is('penjualan*') ? 'mm-active' : '' }}'>
            <a href="{{ route('penjualan.index') }}"> --}}
                {{-- <li class='{{ Request::is('penjualan*') ? 'mm-active' : '' }}'>
            <a href="{{ route('penjualan.index') }}"> --}}
                <li>
                    <a href="#">
                        <div class="parent-icon"><i class="bx bx-trending-up"></i></div>
                        <div class="menu-title">Penjualan</div>
                    </a>
                </li>
                <li class='{{ Request::is('pemasok*') ? 'mm-active' : '' }}'>
                    <a href="{{ route('pemasok.index') }}">
                        <div class="parent-icon"><i class="bx bx-store"></i>
                        </div>
                        <div class="menu-title">Pemasok</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        {{-- <a href="{{ route('akuntansi.index') }}"> --}}
                        <div class="parent-icon"><i class="bx bx-calculator"></i></div>
                        <div class="menu-title">Akuntansi</div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        {{-- <a href="{{ route('pelanggan.index') }}"> --}}
                        <div class="parent-icon"><i class="bx bx-user-circle"></i></div>
                        <div class="menu-title">Pelanggan</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
