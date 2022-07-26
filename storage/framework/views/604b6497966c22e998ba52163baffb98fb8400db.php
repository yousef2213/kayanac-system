<div class="row">
    <div class="col-12 py-5">
        <div class="accordion font-main" id="SystemParentSide">
            <?php $__currentLoopData = $childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($child->name != 'تقارير المشتريات' && $child->name != 'تقييم المخزون' && $child->name != 'ارصدة الاصناف' && $child->name != 'النظام' && $child->name != 'المخازن' && $child->name != 'المبيعات' && $child->name != 'المشتريات' && $child->name != 'كارت الصنف'): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="<?php echo e($child->page_name); ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#<?php echo e($child->page_name); ?>Manual" aria-expanded="false"
                                aria-controls="<?php echo e($child->page_name); ?>Manual">
                                <div class="form-group p-0 m-0">
                                    <label for="<?php echo e($child->page_name); ?>It" class="font-main font-weight-bold mr-2">
                                        <?php echo e($child->name); ?> </label>
                                </div>
                            </button>
                        </h2>

                        <div id="<?php echo e($child->page_name); ?>Manual" class="accordion-collapse collapse"
                            aria-labelledby="<?php echo e($child->page_name); ?>" data-bs-parent="#SystemParentSide">
                            <div class="accordion-body">

                                
                                <div
                                    class="<?php echo e($child->page_name == 'TsCompany' ? 'd-none' : ''); ?> form-group d-flex align-items-center">
                                    <input type="checkbox" class="<?php echo e($child->page_name == 'الشركة' ? 'd-none' : ''); ?>"
                                        onchange="handelValuePermision(event,'add-hidden-<?php echo e($child->id); ?>')"
                                        id="side-<?php echo e($child->id); ?>"
                                        <?php echo e($orders->where('power_name', $child->page_name)->first()->add == 1 ? 'checked' : ''); ?> />
                                    <label for="side-<?php echo e($child->id); ?>"
                                        class="font-main font-weight-bold mr-2">اضافة</label>
                                    <input type="hidden" id="add-hidden-<?php echo e($child->id); ?>"
                                        value="<?php echo e($orders->where('power_name', $child->page_name)->first()->add); ?>"
                                        name="add-<?php echo e($child->page_name); ?>" />
                                </div>

                                
                                <div
                                    class="<?php echo e($child->page_name == 'TsAccountsGuide' ? 'd-none' : ''); ?> <?php echo e($child->page_name == 'TsOrderCashing' ? 'd-none' : ''); ?> <?php echo e($child->page_name == 'TsOrderAdd' ? 'd-none' : ''); ?> form-group d-flex align-items-center">
                                    <input type="checkbox" id="sideedit-<?php echo e($child->id); ?>"
                                        onchange="handelValuePermision(event,'edit-hidden-<?php echo e($child->id); ?>')"
                                        <?php echo e($orders->where('power_name', $child->page_name)->first()->edit == 1 ? 'checked' : ''); ?> />
                                    <label for="sideedit-<?php echo e($child->id); ?>" class="font-main font-weight-bold mr-2">
                                        تعديل </label>
                                    <input type="hidden" id="edit-hidden-<?php echo e($child->id); ?>"
                                        value="<?php echo e($orders->where('power_name', $child->page_name)->first()->edit); ?>"
                                        name="edit-<?php echo e($child->page_name); ?>" />
                                </div>

                                
                                
                                <div
                                    class="<?php echo e($child->page_name == 'TsAccountsGuide' ? 'd-none' : ''); ?> <?php echo e($child->page_name == 'TsOrderCashing' ? 'd-none' : ''); ?> <?php echo e($child->page_name == 'TsOrderAdd' ? 'd-none' : ''); ?> <?php echo e($child->page_name == 'TsCompany' ? 'd-none' : ''); ?> form-group d-flex align-items-center">
                                    <input type="checkbox" id="sidedel-<?php echo e($child->id); ?>"
                                        onchange="handelValuePermision(event,'del-hidden-<?php echo e($child->id); ?>')"
                                        <?php echo e($orders->where('power_name', $child->page_name)->first()->delete == 1 ? 'checked' : ''); ?> />
                                    <label for="sidedel-<?php echo e($child->id); ?>" class="font-main font-weight-bold mr-2">
                                        حذف
                                    </label>
                                    <input type="hidden" id="del-hidden-<?php echo e($child->id); ?>"
                                        value="<?php echo e($orders->where('power_name', $child->page_name)->first()->delete); ?>"
                                        name="delete-<?php echo e($child->page_name); ?>" />
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <hr>
            <hr>
        </div>
    </div>
</div>
<script>
    const handelValuePermision = (event, id) => {
        if (event.target.checked) {
            document.getElementById(id).value = 1;
            event.target.value = 1;
        } else {
            document.getElementById(id).value = 0;
            event.target.value = 0;
        }
    }
</script>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/users/sidePermision.blade.php ENDPATH**/ ?>