<?php $__env->startSection('main-content'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة وحدة </li>
            <li class="breadcrumb-item"><a href="/erp/public/units"> الوحدات </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>

    <div class="card">
        <h5 class="card-header">Add Unit</h5>
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="<?php echo e(route('units.store')); ?>" autocomplete="off"
                enctype="multipart/form-data">

                <?php echo e(csrf_field()); ?>


                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-group w-50 text-right">
                        <label class="col-form-label">الاسم بالعربي</label>
                        <input type="text" name="namear" value="<?php echo e(old('namear')); ?>" class="form-control">
                        <?php $__errorArgs = ['namear'];
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

                    <div class="form-group w-50 text-right">
                        <label class="col-form-label">الاسم بالانجليزي</label>
                        <input type="text" name="nameen" value="<?php echo e(old('nameen')); ?>" class="form-control">
                        <?php $__errorArgs = ['nameen'];
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
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">الكود الضريبى</label>
                            <input type="text" name="tax_code"class="form-control">
                            <?php $__errorArgs = ['tax_code'];
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
                    </div>
                </div>

                <hr>

                <div class="form-group mb-3 text-right">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/Units/add.blade.php ENDPATH**/ ?>