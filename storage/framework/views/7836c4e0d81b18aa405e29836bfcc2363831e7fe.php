<?php $__env->startSection('main-content'); ?>
    <?php if(\Session::has('success')): ?>
        <div class="alert alert-success">
            <ul style="list-style: none;text-align: right">
                <li class="font-main text-right"><?php echo \Session::get('success'); ?></li>
            </ul>
        </div>
    <?php endif; ?>



    <div class="container py-5 px-4">
        <div class="row">
            

            <div class="col-12 text-right">
                <div class="py-2">
                    <button class="btn btn-success font-main btnCheck" onclick="HereUpdate()">
                        هل يوجد تحديث جديد ؟
                    </button>
                </div>

                <div class="py-2 d-flex justify-content-end align-items-center">
                    <form method="POST" id="updaedDb" action="<?php echo e(route('download.db')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" class="filedb" name="fileName">
                        <input type="hidden" class="name" name="name">
                        <input type="hidden" class="versionDb" name="version">
                        <button type="button"
                            class="d-none badge_alert_danger btn  btn-success p-1 font-main m-0 badge badge-danger"></button>
                        <button type="submit"
                            class="d-none badge_alert_success btn btn-success p-1 font-main m-0 badge badge-success"
                            onclick="downloadVersion()"></button>
                    </form>
                    <button class="btn btn-success font-main btnCheckDb ml-2" onclick="UpdateDb()">
                        تحديث اخر نسخة للداتا بيز ؟
                    </button>
                </div>

                <p class="font-main d-block my-3 text-success d-none" id="Success">

                </p>

                <p class="font-main d-block my-3 text-danger d-none" id="Danger">
                    لا يوجد تحديث الان
                </p>

            </div>
            <hr>
            <div class="col-12 text-right d-none" id="FormSubmit">
                <form method="post" dir="rtl" action="<?php echo e(route('download.downloadFiles')); ?>" id="formSub">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="fileName" id="fileName">
                    <input type="hidden" name="version" id="version">
                    <div class="div col-12 text-right">
                        <span class="badge badge-pill badge-danger danger font-main px-4 d-none">Danger</span>
                        <span class="badge badge-pill badge-success success font-main px-4  d-none">succes</span>
                        <button class="btn btn-success Down font-main" id="Ver" type="submit"
                            onclick="UpdateFunction(event)">
                            تحميل التحديث الجديد
                        </button>
                        <button class="btn btn-success font-main" type="submit" onclick="UpdateFunction(event)">
                            تحديث النظام الان
                        </button>
                    </div>
                </form>
            </div>

        </div>




        
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('boot5/bootstrap.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        const CheckFunction = async () => {
            if (navigator.onLine) {
                document.querySelector('.preloader').classList.remove("hiden-pre-load");
                const req = await fetch('check-version');
                const {
                    status,
                    msg
                } = await req.json();
                if (status == 201) {
                    $('#Success').removeClass("d-none");
                    $('.btnCheck').attr("disabled", true);
                    $('#Ver').attr("disabled", true);
                    $('#Success').html(msg);
                    $('#FormSubmit').removeClass("d-none");
                }

                if (status == 205) {
                    $('#Success').removeClass("d-none");
                    $('.btnCheck').attr("disabled", true);
                    $('#Ver').attr("disabled", true);
                    $('#Success').html(msg);
                    $('#FormSubmit').removeClass("d-none");
                }
            }

        }

        const HereUpdate = async () => {
            if (navigator.onLine) {
                const req1 = await fetch('https://yousef-ayman.com/getLastVersion');
                const res1 = await req1.json();
                if (res1.status == 200) {
                    if (res1.data) {
                        const req = await fetch(`check-version/${res1.data.version}`);
                        const res = await req.json();
                        if (res.status == 200) {
                            $('#Success').removeClass("d-none");
                            $('#Success').html(" يوجد تحديث جديد هل تريد تحديث السيستم الان ؟");
                            $('.btnCheck').attr("disabled", true);
                            $('#FormSubmit').removeClass("d-none");
                        }
                        if (res.status == 202) {
                            $('#Danger').removeClass("d-none");
                        }
                        if (res.status == 201) {
                            $('#Success').removeClass("d-none");
                            $('#Success').html(res.msg);
                        }
                        if (res.status == 205) {
                            $('#Success').removeClass("d-none");
                            $('#Success').html(res.msg);
                            $('#FormSubmit').removeClass("d-none");
                            $('.Down').attr("disabled", true);
                        }
                    } else {
                        $('#Success').removeClass("d-none");
                        $('.btnCheck').attr("disabled", true);

                        $('#Success').html("انت علي اخر تحديث");
                    }


                }
            }
        }

        function UpdateFunction(event) {
            event.preventDefault();
            if (navigator.onLine) {
                document.querySelector('.preloader').classList.remove("hiden-pre-load");
                $.ajax({
                    type: 'GET',
                    url: "https://yousef-ayman.com/getLastVersion",
                    data: {
                        _token: "<?php echo e(csrf_token()); ?>",
                    },
                    success: function(data) {
                        document.querySelector('.preloader').classList.add("hiden-pre-load");
                        if (data.status == 200) {
                            downloadFileSystem(data.data.zip_file, data.data.version, data.data.name)
                        }
                    },
                    error: function(data) {
                        document.querySelector('.preloader').classList.add("hiden-pre-load");
                    }
                });
            }
        }

        const downloadFileSystem = (file, version, name) => {
            console.log({
                file,
                version,
                name
            });
            $('#name').val(name);
            $('#fileName').val(file);
            $('#version').val(version);
            $('form#formSub').submit();
        }
        // CheckFunction()
        if (navigator.onLine) {
            $('#Danger').addClass("d-none");
            $('#Danger').html("");
            HereUpdate()
        } else {
            $('.Down').attr("disabled", true);
            $('#Danger').removeClass("d-none");
            $('#Danger').html("انت غير متصل بالانترنت");
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/version/index.blade.php ENDPATH**/ ?>