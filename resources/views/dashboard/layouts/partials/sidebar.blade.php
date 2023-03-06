<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('atlantis') }}/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info text-capitalize">
                    <a data-toggle="collapse" href="#" aria-expanded="true">
                        <span>
                            {{ Auth::user()->name }}
                            <span class="user-level"><i class="fas fa-circle text-success"></i>
                                {{ Auth::user()->role }}</span>
                        </span>
                    </a>
                </div>
            </div>
            <ul class="nav nav-success">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">NAVIGATIONS</h4>
                </li>
                <li class="nav-item {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">KELOLA INSTANSI</h4>
                </li>
                <li class="nav-item {{ request()->segment(2) == 'tentang-kami' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.tentang_kami.index') }}">
                        <i class="fas fa-info-circle"></i>
                        <p>Tentang Kami</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">KELOLA BERITA</h4>
                </li>
                <li class="nav-item {{ request()->segment(2) == 'berita' ? 'active' : '' }}">
                    <a href="{{ route('dashboard.berita.index') }}">
                        <i class="fas fa-newspaper"></i>
                        <p>Berita</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
