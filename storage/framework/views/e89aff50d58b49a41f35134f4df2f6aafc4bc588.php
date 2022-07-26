<div class="card">
    <h5 class="card-header font-main py-4 text-right">اضافة مستخدم جديد</h5>
    <div class="card-body">

        <div class="form-group">
            <label for="inputTitle" class="col-form-label"> الاسم </label>
            <input id="inputTitle" type="text" name="name" autocomplete="0" class="form-control text-right">
            <?php $__errorArgs = ['name'];
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

        <div class="form-group">
            <label for="inputEmail" class="col-form-label"> البريد الالكتروني </label>
            <input id="inputEmail" autocomplete="0" aria-autocomplete="0" type="text" name="email"
                class="form-control text-right">
            <?php $__errorArgs = ['email'];
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



        <div class="form-group">
            <label for="status" class="col-form-label"> الفروع </label>
            <select autocomplete="off" dir="rtl" name="barnchId" class="form-control barnchesSelect">
                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branche): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($branche->id); ?>"> <?php echo e($branche->namear); ?> </option>
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


        <label for="inputPassword" class="col-form-label"> كلمة المرور </label>
        <div class="input-group mb-3 flex-row-reverse">
            <div class="input-group-prepend">
                <button type="button" class="input-group-text" id="basic-addon1"> <i id="eyeId" class="fa fa-eye-slash"
                        aria-hidden="true"></i> </span>
            </div>
            <input id="inputPassword" type="password" name="password" value="<?php echo e(old('password')); ?>"
                class="form-control text-right">
            <?php $__errorArgs = ['password'];
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


        <label for="inputPasswordConfirm" class="col-form-label"> تاكيد كلمة المرور </label>

        <div class="input-group mb-3 flex-row-reverse">
            <div class="input-group-prepend">
                <button type="button" class="input-group-text" id="basic-addon2"> <i id="eyeId2" class="fa fa-eye-slash"
                        aria-hidden="true"></i> </span>
            </div>
            <input id="inputPasswordConfirm" type="password" name="password_confirmation"
                value="<?php echo e(old('password_confirmation')); ?>" class="form-control text-right">
            <?php $__errorArgs = ['password_confirmation'];
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




        <div class="form-group">
            <label for="role" class="col-form-label"> الصلاحيه </label>
            <select name="type"  dir="rtl" class="form-control">
                <option value="">---</option>
                <option value="3">مسؤل</option>
                <option value="1">مستخدم عادي</option>
            </select>
            <?php $__errorArgs = ['role'];
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
        <div class="form-group">
            <label for="status" dir="rtl" class="col-form-label"> الحالة </label>
            <select name="status" class="form-control">
                <option value="active">نشط</option>
                <option value="deactive">غير نشط</option>
            </select>
            <?php $__errorArgs = ['status'];
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
<?php /**PATH C:\xampp\htdocs\erp\resources\views/users/info_user.blade.php ENDPATH**/ ?>