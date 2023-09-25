<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">home</i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('auth.home') }}">List Aplikasi</a></li>
                    <li><a href="{{ route('prt.apps.home.index') }}">Dashboard Portal</a></li>
                    <li><a target="_BLANK" href="{{ route('prt.home.index') }}">Portal Website</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                    <i class="material-symbols-outlined">dataset</i>
                    <span class="nav-text">Master Data</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('prt.apps.mst.tags.index') }}">Kategori</a></li>
                    <li><a href="{{ route('prt.apps.mst.sosmed.index') }}">Sosial Media</a></li>
                    <li><a href="{{ route('prt.apps.mst.setup.index') }}">Setup Portal</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('prt.apps.post.index') }}">
                    <i class="material-symbols-outlined">post_add</i>
                    <span class="nav-text">Postingan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('prt.apps.page.index') }}">
                    <i class="material-symbols-outlined">pages</i>
                    <span class="nav-text">Halaman</span>
                </a>
            </li>
            <li>
                <a href="{{ route('prt.apps.banner.index') }}">
                    <i class="material-symbols-outlined">compare</i>
                    <span class="nav-text">Banner</span>
                </a>
            </li>
            <li>
                <a href="{{ route('prt.apps.gallery.index') }}">
                    <i class="material-symbols-outlined">perm_media</i>
                    <span class="nav-text">Galeri</span>
                </a>
            </li>
            <li>
                <a href="{{ route('prt.apps.video.index') }}">
                    <i class="material-symbols-outlined">play_circle</i>
                    <span class="nav-text">Video</span>
                </a>
            </li>
            <li>
                <a href="{{ route('prt.apps.unduh.index') }}">
                    <i class="material-symbols-outlined">browser_updated</i>
                    <span class="nav-text">Unduhan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('prt.apps.pesan.index') }}">
                    <i class="material-symbols-outlined">mail</i>
                    <span class="nav-text">Kotak Masuk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('prt.apps.faq.index') }}">
                    <i class="material-symbols-outlined">quiz</i>
                    <span class="nav-text">FAQ</span>
                </a>
            </li>
            <li>
                <a href="{{ route('prt.apps.stat.index') }}">
                    <i class="material-symbols-outlined">query_stats</i>
                    <span class="nav-text">Statistik</span>
                </a>
            </li>
        </ul>
    </div>
</div>
