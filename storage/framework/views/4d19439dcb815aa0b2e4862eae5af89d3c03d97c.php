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
        <?php if(session()->has('backUp')): ?>
            <div class="alert alert-success font-main">
                <?php echo e(session()->get('backUp')); ?>

            </div>
        <?php endif; ?>
        <?php if(session()->has('msg')): ?>
            <div class="alert alert-success font-main">
                <?php echo e(session()->get('msg')); ?>

            </div>
        <?php endif; ?>

        <?php if(session()->has('error')): ?>
            <div class="alert alert-danger font-main">
                <?php echo e(session()->get('error')); ?>

            </div>
        <?php endif; ?>
    </div>
    <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li
            class="btn btn-sm btn-primary btn-lang text-light font-main align-self-center <?php echo e($localeCode == LaravelLocalization::getCurrentLocale() ? 'd-none' : ''); ?>">
            <a rel="alternate" hreflang="<?php echo e($localeCode); ?>" class="text-light"
                href="<?php echo e(LaravelLocalization::getLocalizedURL($localeCode, null, [], true)); ?>">
                <?php echo e($properties['native']); ?>

            </a>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <a class="nav-link dropdown-toggle" href="<?php echo e(route('clearCash')); ?>" data-toggle="tooltip"
                data-placement="bottom" title="clear cash" role="button">
                <i class="fa fa-history"></i>
            </a>
        </li>

        
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="<?php echo e(route('home')); ?>" data-toggle="tooltip"
                data-placement="bottom" title="home" role="button">
                <i class="fas fa-home fa-fw"></i>
            </a>
        </li>





        <?php if($permision->TsBackup == 1): ?>
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="<?php echo e(route('back-up')); ?>" 
                    data-toggle="tooltip" data-placement="bottom" title="BackUp" role="button">
                    <i class="fa fa-download"></i>
                </a>
            </li>
        <?php endif; ?>


        <?php
        $company = DB::table('compaines')->find(1);
        ?>

        <?php if($permision->TsPos == 1): ?>
            <!-- Nav Item - Alerts -->
            <?php if($company->restaurant == 1): ?>
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="<?php echo e(route('pos')); ?>" data-toggle="tooltip"
                        data-placement="bottom" title="POS" role="button">
                        <i class="fas fa-cart-plus"></i>
                    </a>
                </li>
            <?php else: ?>
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="<?php echo e(route('casher.index')); ?>" data-toggle="tooltip"
                        data-placement="bottom" title="POS" role="button">
                        <i class="fas fa-cart-plus"></i>
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>


        <div class="topbar-divider d-none d-sm-block"></div>





        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                data-target="#profile" aria-expanded="true" aria-haspopup="true" aria-expanded="false"
                aria-controls="profile">
                <?php if(auth()->guard()->check()): ?>
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo e(Auth()->user()->name); ?></span>
                <?php else: ?>
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Log in </span>
                <?php endif; ?>

            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" id="profile"
                aria-labelledby="userDropdown">
                <a class="dropdown-item font-main" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> تسجيل الخروج
                </a>

                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
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
                _token: "<?php echo e(csrf_token()); ?>",
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
                _token: "<?php echo e(csrf_token()); ?>",
            },
            success: function(data) {
                document.querySelector('.preloader').classList.add("hiden-pre-load");
            }
        });
    }
</script>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/dashboard/header.blade.php ENDPATH**/ ?>