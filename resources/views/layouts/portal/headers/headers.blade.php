<header id="header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyStartAt': 45, 'stickySetTop': '-45px', 'stickyChangeLogo': true}">
    <div class="header-body">
        <div class="header-container container">
            <div class="header-row">
                <div class="header-column">
                    <div class="header-row">
                        <div class="header-logo">
                            <a href="{{ route('prt.home.index') }}">
                                <img alt="SIMEGAL" width="200" height="70" data-sticky-width="150" data-sticky-height="55" data-sticky-top="32" src="{{ asset('assets-portal/dist/img/logo-color.png') }}">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="header-column justify-content-end">
                    <div class="header-row pt-3">
                        <nav class="header-nav-top">
                            <ul class="nav nav-pills">
                                <li class="nav-item nav-item-anim-icon d-none d-md-block">
                                    <a class="nav-link" target="_BLANK" href="{!! $setup->google_maps !!}"><i class="fas fa-map-marker"></i> Kantor</a>
                                </li>
                                <li class="nav-item nav-item-anim-icon d-none d-md-block">
                                    <a class="nav-link" href="tel:{{ $setup->no_telp }}"><i class="fas fa-phone"></i> {{ $setup->no_telp }}</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="header-nav-features">
                            <div class="header-nav-feature header-nav-features-search d-inline-flex">
                                <a href="#" class="header-nav-features-toggle text-decoration-none" data-focus="headerSearch" aria-label="Search"><i class="fas fa-search header-nav-top-icon"></i></a>
                                <div class="header-nav-features-dropdown header-nav-features-dropdown-mobile-fixed" id="headerTopSearchDropdown">
                                    <form role="search" action="{{ route('prt.q.index') }}" method="get">
                                        <div class="simple-search input-group">
                                            <input class="form-control text-1" id="headerSearch" name="q" type="search" value="" placeholder="Search..." autocomplete="0ff" maxlength="300" required>
                                            <button class="btn" type="submit" aria-label="Search">
                                                <i class="fas fa-search header-nav-top-icon"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-row">
                        <div class="header-nav pt-1">
                            <div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1">
                                <nav class="collapse">
                                    <ul class="nav nav-pills" id="mainNav">
                                        <li class="dropdown">
                                            <a class="dropdown-item" href="{{ route('prt.home.index') }}">
                                                Beranda
                                            </a>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-item" href="{{ route('prt.post.index', ['berita']) }}">
                                                Berita
                                            </a>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-item dropdown-toggle" href="#">
                                                Layanan
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('prt.page.index', ['layanan-tera-tera-ulang']) }}">
                                                        Tera / Tera Ulang
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-item dropdown-toggle" href="#">
                                                Media
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('prt.media.unduh.tags') }}">
                                                        Unduhan
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('prt.media.gallery.index') }}">
                                                        Galeri
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('prt.media.video.index') }}">
                                                        Video
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a class="dropdown-item dropdown-toggle" href="#">
                                                Informasi
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('prt.page.index', ['tentang-kami']) }}">
                                                        Tentang Kami
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('prt.page.index', ['kontak-kami']) }}">
                                                        Kontak Kami
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('prt.page.index', ['faq']) }}">
                                                        Frequently Asked Questions
                                                    </a>
                                                </li>
                                                <li>
                                                    <a target="_BLANK" class="dropdown-item" href="{!! $setup->link_survey !!}">
                                                        Survey Kepuasan
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        @if (\Auth::check())
                                            <li class="dropdown">
                                                <a class="dropdown-item dropdown-toggle" href="#">
                                                    Akun
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('auth.home') }}">
                                                            Dashboard
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('prt.lgn.logout') }}">
                                                            Logout
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @else
                                            <li class="dropdown">
                                                <a class="dropdown-item dropdown-toggle" href="#">
                                                    Akun
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('prt.lgn.index') }}">
                                                            Login
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('prt.reg.index') }}">
                                                            Register
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                            <ul class="header-social-icons social-icons d-none d-sm-block">
                                @foreach ($sosmed as $item)
                                    @if ($item->sosmed == 'Facebook')
                                        <li class="social-icons-facebook"><a href="{!! $item->url !!}" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                    @elseif($item->sosmed == 'Twitter')
                                        <li class="social-icons-twitter"><a href="{!! $item->url !!}" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                    @elseif($item->sosmed == 'Instagram')
                                        <li class="social-icons-instagram"><a href="{!! $item->url !!}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                    @elseif($item->sosmed == 'YouTube')
                                        <li class="social-icons-youtube"><a href="{!! $item->url !!}" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a></li>
                                    @endif
                                @endforeach
                            </ul>
                            <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
