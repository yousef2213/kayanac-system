<style>
    .about-alert {
        position: fixed;
        right: 10px;
        top: 60px
    }

    .btn-lang {
        color: #ddd;

    }

</style>
<?php $permision = DB::table('powers')
    ->where('user_id', auth()->user()->id)
    ->first(); ?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link  rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <div class="about-alert" style="z-index: 999">
        @if (session()->has('backUp'))
            <div class="alert alert-success font-main">
                {{ session()->get('backUp') }}
            </div>
        @endif
        @if (session()->has('msg'))
            <div class="alert alert-success font-main">
                {{ session()->get('msg') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger font-main">
                {{ session()->get('error') }}
            </div>
        @endif
    </div>
    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <li
            class="btn btn-sm btn-primary btn-lang text-light font-main align-self-center {{ $localeCode == LaravelLocalization::getCurrentLocale() ? 'd-none' : '' }}">
            <a rel="alternate" hreflang="{{ $localeCode }}" class="text-light"
                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                {{ $properties['native'] }}
            </a>
        </li>
    @endforeach
    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>



    <div>
        <div class="">
            <div class="clock-container">
                <div class="clock">
                    <div class="needle hour"></div>
                    <div class="needle minute"></div>
                    <div class="needle second"></div>
                    <div class="center-point"></div>
                </div>

                <div class="time" style="color: #888"></div>
                <div class="date"></div>
            </div>
        </div>
    </div>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>




        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="{{ route('clearCash') }}" data-toggle="tooltip"
                data-placement="bottom" title="clear cash" role="button">
                <i class="fa fa-history"></i>
            </a>
        </li>

        {{-- Home page --}}
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="{{ route('home') }}" data-toggle="tooltip"
                data-placement="bottom" title="home" role="button">
                <i class="fas fa-home fa-fw"></i>
            </a>
        </li>





        @if ($permision->TsBackup == 1)
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="{{ route('back-up') }}" {{-- onclick="backUp()" --}}
                    data-toggle="tooltip" data-placement="bottom" title="BackUp" role="button">
                    <i class="fa fa-download"></i>
                </a>
            </li>
        @endif


        <?php
        $company = DB::table('compaines')->find(1);
        ?>

        @if ($permision->TsPos == 1)
            <!-- Nav Item - Alerts -->
            @if ($company->restaurant == 1)
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="{{ route('pos') }}" data-toggle="tooltip"
                        data-placement="bottom" title="POS" role="button">
                        <i class="fas fa-cart-plus"></i>
                    </a>
                </li>
            @else
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="{{ route('casher.index') }}" data-toggle="tooltip"
                        data-placement="bottom" title="POS" role="button">
                        <i class="fas fa-cart-plus"></i>
                    </a>
                </li>
            @endif
        @endif


        <div class="topbar-divider d-none d-sm-block"></div>





        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                data-target="#profile" aria-expanded="true" aria-haspopup="true" aria-expanded="false"
                aria-controls="profile">
                @auth
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth()->user()->name }}</span>
                @else
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Log in </span>
                @endauth

            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" id="profile"
                aria-labelledby="userDropdown">
                <a class="dropdown-item font-main" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> تسجيل الخروج
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>

    </ul>

</nav>
<script>
    function sendAlertOpen() {
        $.ajax({
            type: 'GET',
            url: "/erp/public/open-shift",
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {}
        });
    }

    function backUp() {
        document.querySelector('.preloader').classList.remove("hiden-pre-load");
        $.ajax({
            type: 'GET',
            url: "/erp/public/back-up",
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                document.querySelector('.preloader').classList.add("hiden-pre-load");
            }
        });
    }
</script>
