<div class="card">
    <h5 class="card-header font-main py-4 text-right">اعدادات عامة</h5>
    <div class="card-body font-main text-right">


        <div class="form-group">
            <label class="col-form-label">اسم الشركة بالعربي</label>
            <input type="text" name="namear" class="form-control" value="<?php echo e($company->companyNameAr); ?>">
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
            <label class="col-form-label">اسم الشركة بالانجليزي</label>
            <input type="text" name="nameen" class="form-control" value="<?php echo e($company->companyNameEn); ?>">
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

        <div class="form-group">
            <label class="col-form-label"> الرقم الضريبي </label>
            <input type="text" name="taxNum" class="form-control" value="<?php echo e($company->taxNum); ?>">
            <?php $__errorArgs = ['taxNum'];
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
            <select name="negative_sale" class="form-control">
                <option value="0" <?php echo e($company->negative_sale == 0 ? 'selected' : ''); ?>>--</option>
                <option value="1" <?php echo e($company->negative_sale == 1 ? 'selected' : ''); ?>>البيع بالسالب</option>
            </select>
        </div>



        <div class="form-group">
            <label for="inputPassword" class="col-form-label">النشاط</label>
            <textarea name="active" class="form-control"><?php echo e($company->active); ?></textarea>
            <?php $__errorArgs = ['active'];
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
            <label class="col-form-label"> لوجو الشركة </label>
            <input type="file" name="logo" class="form-control">
            <?php $__errorArgs = ['logo'];
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
<?php /**PATH C:\xampp\htdocs\erp\resources\views/compines/globalSetting.blade.php ENDPATH**/ ?>