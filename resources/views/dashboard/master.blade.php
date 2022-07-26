<!DOCTYPE html>
<html lang="ar">

@include('dashboard.head')

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
                    <img src="{{asset('/loadig.svg')}}" alt="">
                </div>
            </div>
        </div>
        <!-- End Preloader -->

    <!-- Page Wrapper -->
    <div id="wrapper" class="{{ $lang == "ar" ? "flex-row-reverse" : "" }}" >

        <!-- Sidebar -->
        @include('dashboard.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('dashboard.header')
                <!-- End of Topbar -->


                <!-- Begin Page Content -->
                @yield('main-content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            @include('dashboard.footer')


</body>

</html>
