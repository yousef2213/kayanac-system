<?php $__env->startSection('main-content'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb justify-content-end font-main">
        <li class="breadcrumb-item active" aria-current="page"> اضافة طاولة </li>
        <li class="breadcrumb-item"><a href="/erp/public/tables"> الطاولات </a></li>
        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
    </ol>
</nav>


    <div class="card">
        <h5 class="card-header">Add Table</h5>
        <div class="card-body">
            <form method="post" action="<?php echo e(route('tables.store')); ?>" dir="rtl">

                <?php echo e(csrf_field()); ?>


                <div class="form-group text-right font-main">
                    <label class="col-form-label text-right ">رقم الطاولة</label>
                    <input  type="number" name="numTable" class="text-right form-control" value="<?php echo e(old('numTable')); ?>"
                        class="form-control">
                    <?php $__errorArgs = ['numTable'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>


                <div class="form-group mb-3 text-right">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/Tables/create.blade.php ENDPATH**/ ?>