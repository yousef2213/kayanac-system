<?php $__env->startSection('main-content'); ?>

    <div class="container-fluid font-main">
        <div class="row">
            <div class="col-12 px-5 mx-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end font-main">
                        <li class="breadcrumb-item active" aria-current="page"> اضافة فرع </li>
                        <li class="breadcrumb-item"><a href="/erp/public/branches"> الفروع </a></li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                    </ol>
                </nav>
            </div>

            <div class="col-12 px-5 py-4">

                <div class="company text-right font-ar">
                    <div class="col-12 mx-auto px-0">
                        <form dir="rtl" method="POST" autocomplete="off" action="<?php echo e(route('branches.store')); ?>">
                            <?php echo e(csrf_field()); ?>


                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>الاسم بالعربي</label>
                                    <input type="text" autocomplete="off" name="namear" value="<?php echo e(old('namear')); ?>"
                                        class="form-control" />
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
                                <div class="col-12 col-md-6 mx-auto">
                                    <label> الاسم بالانجليزي </label>
                                    <input type="text" autocomplete="off" name="nameen" value="<?php echo e(old('nameen')); ?>"
                                        class="form-control" />
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <div class="form-group">
                                        <label for="status" class="col-form-label">الشركة</label>
                                        <select autocomplete="off" name="companyId" disabled class="form-control">
                                            <?php $__currentLoopData = $companys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($company->id); ?>">
                                                    <?php echo e($company->companyNameAr); ?> </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>المدينة</label>
                                    <input type="text" autocomplete="off" name="city" value="<?php echo e(old('city')); ?>"
                                        class="form-control" />
                                </div>

                            </div>

                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <label> كود النشاط </label>
                                    <input type="number" step="0.1" name="code_activite" value="<?php echo e(old('code_activite')); ?>"
                                        class="form-control" />
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <label> Activity Code </label>
                                    <input type="number" step="0.1" name="activite_code" value="<?php echo e(old('activite_code')); ?>"
                                        class="form-control" />
                                </div>
                            </div>

                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <label> المنطقة </label>
                                    <input autocomplete="off" type="text" name="region" value="<?php echo e(old('region')); ?>"
                                        class="form-control" />
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <label> الدولة </label>
                                    <input autocomplete="off" type="text" name="country" value="<?php echo e(old('country')); ?>"
                                        class="form-control" />
                                </div>
                            </div>

                            <div class="row py-2">
                                <div class="col-12 col-md-6">
                                    <label> هاتف </label>
                                    <input autocomplete="off" type="number" value="<?php echo e(old('phone')); ?>" name="phone"
                                        class="form-control" />
                                    <?php $__errorArgs = ['phone'];
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

                                <div class="col-12 col-md-6">
                                    <label> العنوان </label>
                                    <input autocomplete="off" type="text" value="<?php echo e(old('address')); ?>" name="address"
                                        class="form-control" />
                                    <?php $__errorArgs = ['address'];
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
                            <div class="submiting d-flex mt-4">
                                <button type="submit" class="btn btn-primary mx-2 px-4"> حفظ </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('boot5/bootstrap.min.css')); ?>" rel="stylesheet">
    <style>
        .nav-tabs>.nav-item>.nav-link.active {
            background: #1cc88a !important;
            color: #fff !important;
            font-weight: 800
        }

    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>

    <script src="<?php echo e(asset('boot5/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('boot5/bootstrap.bundle.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/branches/create.blade.php ENDPATH**/ ?>