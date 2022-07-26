<!DOCTYPE html>
<html lang="ar">

<?php echo $__env->make('dashboard.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>

        /* Preloader */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999999999;
            width: 100%;
            height: 100%;
            background-color: #fff;
            overflow: hidden;
        }
        .hiden-pre-load {
            display: none !important;
        }

        .preloader-inner {
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .preloader-icon {
            width: 100px;
            height: 100px;
            display: inline-block;
            padding: 0px;
        }

</style>
<body id="page-top">
    <?php
        $lang = LaravelLocalization::getCurrentLocale();
    ?>

        <!-- Preloader -->
        <div class="preloader">

            <div class="preloader-inner">
                <div class="preloader-icon">
                    <img src="<?php echo e(asset('/loadig.svg')); ?>" alt="">
                </div>
            </div>
        </div>
        <!-- End Preloader -->

    <!-- Page Wrapper -->
    <div id="wrapper" class="<?php echo e($lang == "ar" ? "flex-row-reverse" : ""); ?>" >

        <!-- Sidebar -->
        <?php echo $__env->make('dashboard.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php echo $__env->make('dashboard.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <!-- End of Topbar -->


                <!-- Begin Page Content -->
                <?php echo $__env->yieldContent('main-content'); ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <?php echo $__env->make('dashboard.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


</body>

</html>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/dashboard/master.blade.php ENDPATH**/ ?>