<?php $__env->startSection('main-content'); ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb justify-content-end font-main">
        <li class="breadcrumb-item active" aria-current="page"> تعديل مخزن </li>
        <li class="breadcrumb-item"><a href="/erp/public/stores"> المخازن </a></li>
        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
    </ol>
</nav>



    <div class="card">
        <h5 class="card-header">Add Store</h5>
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="<?php echo e(route('stores.store')); ?>" autocomplete="off"
                enctype="multipart/form-data">

                <?php echo e(csrf_field()); ?>



                
                <div class="row py-2 text-right">
                    <div class="col-12 col-md-6 mx-auto">
                        <label>الاسم بالعربي</label>
                        <input type="text" autocomplete="off" name="namear" class="form-control"  />
                    </div>
                    <div class="col-12 col-md-6 mx-auto">
                        <label>الاسم بالانجليزي</label>
                        <input type="text" autocomplete="off"  name="nameen" class="form-control"  />
                    </div>
                </div>



                <div class="form-group text-right">
                    <label class="col-form-label">الفرع</label>
                    <select name="branchId[]" class="form-control chosen-select" multiple tabindex="4" dir="rtl">
                        <option value=<?php echo e(null); ?>> --- </option>
                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branche): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value=<?php echo e($branche->id); ?>> <?php echo e($branche->namear); ?> </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['branchId'];
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

                <div class="text-right my-3">
                    <div class="form-check form-check-inline align-self-center">
                        <input class="form-check-input" type="checkbox" checked name="active" id="activateion">
                        <label class="form-check-label mr-2" for="activateion">  تفعيل </label>
                    </div>
                </div>



                <div class="form-group mb-3 text-right">
                    <button type="reset" class="btn btn-warning"> Reset </button>
                    <button class="btn btn-success" type="submit"> Submit </button>
                </div>
            </form>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/stores/craete.blade.php ENDPATH**/ ?>