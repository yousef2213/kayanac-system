<?php $__env->startSection('main-content'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة مجموعة </li>
            <li class="breadcrumb-item"><a href="/erp/public/items/categories-of-items"> مجموعة الاصناف </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>
    <div class="card">
        <h5 class="card-header"> Add Group </h5>
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="<?php echo e(route('item.index.category.add')); ?>" autocomplete="off"
                enctype="multipart/form-data">

                <?php echo e(csrf_field()); ?>


                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
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
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
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
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label"> نوع المجموعة </label>
                            <select name="group_type" class="form-control chosen-select" onchange="handelGroup(event)"
                                tabindex="4" dir="rtl">
                                <option value="0"> --- </option>
                                <option value="1"> رئيسية </option>
                                <option value="0"> متفرعة </option>
                            </select>
                            <?php $__errorArgs = ['group_type'];
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
                    <div class="col-12 col-md-6 main d-none">
                        <div class="form-group text-right">
                            <label class="col-form-label"> المجموعة الرئيسية </label>
                            <select name="group_main" class="form-control mainId" dir="rtl">
                                <option value="0"> --- </option>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"> <?php echo e($item->namear); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['group_main'];
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
                    
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
    <style>
        .chosen-single {
            height: 35px !important;
        }

    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        const handelGroup = event => {
            let val = event.target.value;
            if (val == 1) {
                document.querySelector('.main').classList.add('d-none')
            } else {
                document.querySelector('.main').classList.remove('d-none')
                document.querySelector('.mainId').value = 0
            }
            console.log(event.target.value);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/Items/category.blade.php ENDPATH**/ ?>