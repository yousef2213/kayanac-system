<div class="card font-main">
    <h5 class="card-header">Edit User</h5>
    <div class="card-body text-right">
        <div class="form-group text-right">
            <label for="inputTitle" class="col-form-label">الاسم</label>
            <input id="inputTitle" type="text" autocomplete="0" aria-autocomplete="0" name="name"
                value="<?php echo e($user->name); ?>" class="form-control">
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

        <div class="form-group text-right">
            <label for="inputEmail" class="col-form-label">البريد الالكتروني</label>
            <input id="inputEmail" type="text" autocomplete="0" aria-autocomplete="0" name="email"
                value="<?php echo e($user->email); ?>" class="form-control">
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


        <label for="inputPassword" class="col-form-label"> كلمة المرور </label>
        <div class="input-group mb-3 flex-row-reverse">
            <div class="input-group-prepend">
                <button type="button" class="input-group-text" id="basic-addon1"> <i id="eyeId"
                        class="fa fa-eye-slash" aria-hidden="true"></i> </span>
            </div>
            <input id="inputPassword" type="password" name="password" class="form-control">
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
                <button type="button" class="input-group-text" id="basic-addon2"> <i id="eyeId2"
                        class="fa fa-eye-slash" aria-hidden="true"></i> </span>
            </div>
            <input id="inputPasswordConfirm" type="password" name="password_confirmation" class="form-control">
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




        <?php
            $roles = DB::table('users')
                ->select('role')
                ->where('id', $user->id)
                ->get();
        ?>
        <div class="form-group text-right">
            <label for="role" class="col-form-label">صلاحية</label>
            <select name="role" class="form-control">
                <option value="">---</option>
                <option value="3" <?php echo e($user->role == '3' ? 'selected' : ''); ?>>مسؤل</option>
                <option value="1" <?php echo e($user->role == '1' ? 'selected' : ''); ?>>مستخدم عادي</option>
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
        <div class="form-group text-right">
            <label for="status" class="col-form-label">الحالة</label>
            <select name="status" class="form-control">
                <option value="active" <?php echo e($user->status == 'active' ? 'selected' : ''); ?>> نشط </option>
                <option value="deactive" <?php echo e($user->status == 'deactive' ? 'selected' : ''); ?>> غير نشط </option>
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
<?php /**PATH C:\xampp\htdocs\erp\resources\views/users/edit_info.blade.php ENDPATH**/ ?>