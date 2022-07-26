<?php $__env->startSection('main-content'); ?>
    <div class="container py-5">
        <div class="row pb-4">
            <div class="col-12 text-right px-3">
                <h5 class="font-main p-0 m-0"> تقارير دليل الحسابات </h5>
                <div class="line"> </div>
            </div>
        </div>
        <div class="row flex-row-reverse">
            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="<?php echo e(route('account.statement')); ?>"
                        class="report font-main d-flex justify-content-center align-items-center">تقرير كشف حساب</a>
                </div>
            </div>


            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="<?php echo e(route('budget.index')); ?>"
                        class="report font-main d-flex justify-content-center align-items-center">
                        تقرير الميزانية
                    </a>
                </div>
            </div>



            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="<?php echo e(route('cost_centers_reports')); ?>"
                        class="report font-main d-flex justify-content-center align-items-center">
                        تقرير مراكز التكلفة
                    </a>
                </div>
            </div>



            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="<?php echo e(route('income_list')); ?>"
                        class="report font-main d-flex justify-content-center align-items-center">
                        تقرير قائمة الدخل
                    </a>
                </div>
            </div>

            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="<?php echo e(route('FinancialCenter.index')); ?>"
                        class="report font-main d-flex justify-content-center align-items-center">
                        تقرير قائمة المركز المالي
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/Accounts/reports/index.blade.php ENDPATH**/ ?>