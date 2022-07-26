<?php $__env->startSection('main-content'); ?>
    <div class="container py-5">
        <div class="row pb-4">
            <div class="col-12 text-right px-3">
                <h5 class="font-main p-0 m-0"> تجميع الاصناف </h5>
                <div class="line"> </div>
            </div>
        </div>
        <div class="row flex-row-reverse">
            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="<?php echo e(route('items-collection.index')); ?>"
                        class="report font-main d-flex justify-content-center align-items-center"> تكوين الاصناف </a>
                </div>
            </div>


            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="<?php echo e(route('assembly.index')); ?>"
                        class="report font-main d-flex justify-content-center align-items-center">
                        تجميع الاصناف
                    </a>
                </div>
            </div>


        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('boot5/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/reports/reports-account.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('boot5/bootstrap.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/ItemsCollection/main.blade.php ENDPATH**/ ?>