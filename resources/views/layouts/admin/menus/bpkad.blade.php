{{-- app-menu::begin --}}
<div class="app-menu navbar-menu">
    {{-- LOGO --}}
    <div class="navbar-brand-box">
        {{-- Dark Logo --}}
        <a href="{{ route('auth.home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/custom/favicon-raw.png') }}" alt="" height="35">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/custom/new_kapitasi_color.png') }}" alt="" height="45">
            </span>
        </a>
        {{-- Light Logo --}}
        <a href="{{ route('auth.home') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/custom/favicon-raw.png') }}" alt="" height="35">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/custom/new_kapitasi_light.png') }}" alt="" height="45">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                {{-- dashboard::begin --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('auth.home') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                {{-- dashboard::end --}}

                {{-- master::begin --}}
                <li class="menu-title"><i class="ri-more-line"></i> <span data-key="t-title-master">Master</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('mst.instansi.index') }}">
                        <i class="ri-home-gear-line"></i> <span data-key="t-instansi">Instansi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAdministrator" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAdministrator">
                        <i class="ri-user-settings-line"></i> <span data-key="t-administrator">Administrator</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAdministrator">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('mst.adm.index', [\CID::encode('DINKES')]) }}" class="nav-link" data-key="t-admin-dinkes">DINKES</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mst.adm.index', [\CID::encode('Puskesmas')]) }}" class="nav-link" data-key="t-admin-puskesmas">Puskesmas</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mst.adm.index', [\CID::encode('RSUD')]) }}" class="nav-link" data-key="t-admin-rsud">RSUD</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarElementPegawai" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarElementPegawai">
                        <i class="ri-body-scan-line"></i> <span data-key="t-element-pegawai">Element Pegawai</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarElementPegawai">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('mst.pangkat.index') }}" class="nav-link" data-key="t-pangkat-golongan">Pangkat / Golongan</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mst.jabatan.index') }}" class="nav-link" data-key="t-jabatan">Jabatan</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mst.pendidikan.index') }}" class="nav-link" data-key="t-pendidikan">Pendidikan</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mst.status.index') }}" class="nav-link" data-key="t-status-ketenagaan">Status Ketenagaan</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPengaturanKapitasi" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPengaturanKapitasi">
                        <i class="ri-wallet-line"></i> <span data-key="t-element-pengaturan-kapitasi">Pengaturan Kapitasi</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPengaturanKapitasi">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('mst.set.kapitasi.index', [\CID::encode('Puskesmas')]) }}" class="nav-link" data-key="t-pangkat-golongan">Puskesmas</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mst.set.kapitasi.index', [\CID::encode('RSUD')]) }}" class="nav-link" data-key="t-jabatan">RSUD</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('mst.set.iw.index') }}">
                        <i class="ri-hand-coin-line"></i> <span data-key="t-pengaturan-iw">Pengaturan IW</span>
                    </a>
                </li>
                {{-- master::end --}}

                {{-- pegawai::begin --}}
                <li class="menu-title"><i class="ri-more-line"></i> <span data-key="t-title-pegawai">Pegawai</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPegawai" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPegawai">
                        <i class="ri-team-line"></i> <span data-key="t-pegawai">Pegawai</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPegawai">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('pgw.index', [\CID::encode('Puskesmas')]) }}" class="nav-link" data-key="t-data-pegawai">Data Pegawai Puskesmas</a>
                                <a href="{{ route('pgw.index', [\CID::encode('RSUD')]) }}" class="nav-link" data-key="t-data-pegawai">Data Pegawai RSUD</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('mutasi.pgw.index') }}" class="nav-link" data-key="t-pegawai-mutasi">Data Mutasi Pegawai</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarKPA" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarKPA">
                        <i class="ri-user-2-line"></i> <span data-key="t-element-kpa">KPA</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarKPA">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('kpa.index', [\CID::encode('Puskesmas')]) }}" class="nav-link" data-key="t-pangkat-golongan">Puskesmas</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kpa.index', [\CID::encode('RSUD')]) }}" class="nav-link" data-key="t-jabatan">RSUD</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- pegawai::end --}}

                {{-- kapitasi::begin --}}
                <li class="menu-title"><i class="ri-more-line"></i> <span data-key="t-title-manajemen">Manajemen</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarKapitasi" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarKapitasi">
                        <i class="ri-exchange-dollar-line"></i> <span data-key="t-element-kapitasi">Kapitasi</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarKapitasi">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('kapitasi.index', [\CID::encode('Puskesmas')]) }}" class="nav-link" data-key="t-pangkat-golongan">Puskesmas</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('kapitasi.index', [\CID::encode('RSUD')]) }}" class="nav-link" data-key="t-jabatan">RSUD</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarIW" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarIW">
                        <i class="ri-coins-line"></i> <span data-key="t-element-iw">Iuran Wajib (IW)</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarIW">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('iw.index', [\CID::encode('Puskesmas')]) }}" class="nav-link" data-key="t-pangkat-golongan">Puskesmas</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('iw.index', [\CID::encode('RSUD')]) }}" class="nav-link" data-key="t-jabatan">RSUD</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- kapitasi::end --}}

                {{-- kapitasi::begin --}}
                <li class="menu-title"><i class="ri-more-line"></i> <span data-key="t-title-manajemen">Laporan</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarHistoryKapitasi" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarHistoryKapitasi">
                        <i class="ri-file-history-line"></i> <span data-key="t-arsip">History Kapitasi</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarHistoryKapitasi">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarHistoryKapitasiPuskesmas" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarHistoryKapitasiPuskesmas" data-key="t-level-1.2">
                                    Puskesmas
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarHistoryKapitasiPuskesmas">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('rekap.jaspel.index', [\CID::encode('Puskesmas')]) }}" class="nav-link" data-key="t-arsip-arsip">Rekapitulasi JasPel</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('rekap.jaspel.pgw.index', [\CID::encode('Puskesmas')]) }}" class="nav-link" data-key="t-arsip-iw">History Jaspel Pegawai</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarHistoryKapitasiRSUD" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarHistoryKapitasiRSUD" data-key="t-level-1.2">
                                    RSUD
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarHistoryKapitasiRSUD">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('rekap.jaspel.index', [\CID::encode('RSUD')]) }}" class="nav-link" data-key="t-arsip-arsip">Rekapitulasi JasPel</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('rekap.jaspel.pgw.index', [\CID::encode('RSUD')]) }}" class="nav-link" data-key="t-arsip-iw">History Jaspel Pegawai</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarHistoryIW" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarHistoryIW">
                        <i class="ri-file-history-line"></i> <span data-key="t-arsip">History IW</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarHistoryIW">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarHistoryIWPuskesmas" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarHistoryIWPuskesmas" data-key="t-level-1.2">
                                    Puskesmas
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarHistoryIWPuskesmas">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('rekap.iw.index', [\CID::encode('Puskesmas')]) }}" class="nav-link" data-key="t-arsip-arsip">Rekapitulasi IW</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('rekap.iw.pgw.index', [\CID::encode('Puskesmas')]) }}" class="nav-link" data-key="t-arsip-iw">History IW Pegawai</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarHistoryIWRSUD" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarHistoryIWRSUD" data-key="t-level-1.2">
                                    RSUD
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarHistoryIWRSUD">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('rekap.iw.index', [\CID::encode('RSUD')]) }}" class="nav-link" data-key="t-arsip-arsip">Rekapitulasi IW</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('rekap.iw.pgw.index', [\CID::encode('RSUD')]) }}" class="nav-link" data-key="t-arsip-iw">History IW Pegawai</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- kapitasi::end --}}
            </ul>
        </div>
        {{-- Sidebar --}}
    </div>

    <div class="sidebar-background"></div>
</div>
{{-- app-menu::end --}}
