<header class="mb-5">
    <div class="header-top">
        <div class="container">
            <div class="logo">
                <a href={{ url('/') }}>
                    <img src={{ asset('logo-thata-png-col.png') }} style="width:60px;height:60px;"
                        alt="Logo Thata Ponsel" />
                </a>
            </div>
            <div class="header-top-right">
                <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                        role="img" class="iconify iconify--system-uicons" width="20" height="20"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                opacity=".3"></path>
                            <g transform="translate(-210 -1)">
                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                </path>
                            </g>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                        <label class="form-check-label"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                        </path>
                    </svg>
                </div>

                <div class="dropdown">
                    <a href="#" id="topbarUserDropdown"
                        class="user-dropdown d-flex align-items-center dropend dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">

                        @if (Auth::user()->getFirstMediaUrl('profile_photo'))
                            <div class="avatar avatar-md2 rounded-circle overflow-hidden me-2"
                                style="width: 40px; height: 40px; border: 2px solid #ccc;">
                                <img src="{{ Auth::user()->getFirstMediaUrl('profile_photo') }}"
                                    alt="{{ Auth::user()->name }}" class="rounded-circle"
                                    style="width: 40px; height: 40px; object-fit: cover;">
                            </div>
                        @else
                            <div class="me-2 rounded-circle overflow-hidden"
                                style="width: 40px; height: 40px; border: 2px solid #ccc;">
                                {!! Avatar::create(strtoupper(auth()->user()->name))->setDimension(36, 36)->setFontSize(14)->toSvg() !!}
                            </div>
                        @endif
                        <div class="text">
                            <h6 class="user-dropdown-name">{{ Auth::user()->shortName() }}</h6>
                            <p class="user-dropdown-status text-sm text-muted">
                                {{ Str::of(Auth::user()->getRoleNames()->first())->replace('_', ' ')->title() }}
                            </p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                        <li><a class="dropdown-item"
                                href="{{ route('profile', ['user' => Auth::user()->username]) }}">Profil
                                Saya</a></li>

                        <hr class="dropdown-divider" />

                        <li>
                            <a class="dropdown-item" href={{ route('logout') }}
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>

                <!-- Burger button responsive -->
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </div>
        </div>
    </div>
    <nav class="main-navbar">
        <div class="container">
            <ul>
                <li class="menu-item {{ request()->is('/') ? 'active font-bold' : '' }}">
                    <a href={{ route('dashboard') }} class="menu-link">
                        <span class="d-flex align-items-center">
                            <i class="bi bi-grid-fill" style="margin-top: -12px"></i>
                            Dashboard
                        </span>
                    </a>
                </li>

                <li class="menu-item has-sub {{ request()->is('master-data*') ? 'active font-bold' : '' }}">
                    <a href={{ route('master-data.index') }} class="menu-link">
                        <span class="d-flex align-items-center">
                            <i class="bi bi-database-fill" style="margin: -12px 4px 0 0;"></i>
                            Master Data
                        </span>
                    </a>

                    <div class="submenu">
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">
                                @if (!Auth::user()->hasRole('owner'))
                                    <li
                                        class="submenu-item {{ request()->is('master-data/pelanggan*') ? 'active font-bold' : '' }}">
                                        <a href={{ route('master-data.pelanggan.index') }}
                                            class="submenu-link">Pelanggan</a>
                                    </li>
                                @endif
                                @if (!Auth::user()->hasRole('agen'))
                                    <li
                                        class="submenu-item {{ request()->is('master-data/agent*') ? 'active font-bold' : '' }}">
                                        <a href={{ route('master-data.agent.index') }}
                                            class="submenu-link">{{ Auth::user()->hasRole('owner') ? 'User' : 'Agent' }}</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasRole(['super_admin', 'owner']))
                                    <li
                                        class="submenu-item {{ request()->is('master-data/toko-cabang*') ? 'active font-bold' : '' }}">
                                        <a href={{ route('master-data.toko-cabang.index') }} class="submenu-link">
                                            Toko Cabang
                                        </a>
                                    </li>
                                @endif
                                <li
                                    class="submenu-item {{ request()->is('master-data/barang*') ? 'active font-bold' : '' }}">
                                    <a href={{ route('master-data.barang.index') }} class="submenu-link">
                                        Data HP
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="menu-item {{ request()->is('stocks*') ? 'active font-bold' : '' }}">
                    <a href={{ route('stocks.index') }} class="menu-link">
                        <span class="d-flex align-items-center">
                            <i class="bi bi-box-seam" style="margin: -12px 4px 0 0;"></i>
                            Stok HP
                        </span>
                    </a>
                </li>

                <li class="menu-item {{ request()->is('penjualan*') ? 'active font-bold' : '' }}">
                    <a href={{ route('penjualan.index') }} class="menu-link">
                        <span class="d-flex align-items-center">
                            <i class="bi bi-cash-coin" style="margin: -8px 4px 0 0;"></i>
                            Transaksi Penjualan
                        </span>
                    </a>
                </li>

                @if (Auth::user()->hasRole(['super_admin', 'admin', 'owner']))
                    <li class="menu-item {{ request()->is('jasa-imei*') ? 'active font-bold' : '' }}">
                        <a href={{ route('jasa-imei.index') }} class="menu-link">
                            <span class="d-flex align-items-center">
                                <i class="bi bi-upc-scan" style="margin: -10px 6px 0 0;"></i>
                                Jasa IMEI
                            </span>
                        </a>
                    </li>

                    <li class="menu-item has-sub {{ request()->is('rekap*') ? 'active font-bold' : '' }}">
                        <a href="#" class="menu-link">
                            <span class="d-flex align-items-center">
                                <i class="bi bi-cash-coin" style="margin: -8px 4px 0 0;"></i>
                                Rekapan
                            </span>
                        </a>

                        <div class="submenu">
                            <div class="submenu-group-wrapper" style="width: 230px;">
                                <ul class="submenu-group">
                                    <li class="submenu-item {{ request()->is('rekap') ? 'active font-bold' : '' }}">
                                        <a href={{ route('rekap') }} class="submenu-link">
                                            Rekap Penjualan
                                        </a>
                                    </li>
                                    @if (Auth::user()->hasRole(['super_admin', 'owner', 'admin']))
                                        <li
                                            class="submenu-item {{ request()->is('rekap/agen') ? 'active font-bold' : '' }}">
                                            <a href={{ route('rekap.agen') }} class="submenu-link">
                                                Rekap Per Agen/Admin
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
