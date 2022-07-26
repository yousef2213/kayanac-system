<div class="row">
    <div class="col-12 py-5">
        <div class="accordion font-main" id="SystemParent">

            <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($parent->page_name != 'TsReports' && $parent->page_name != 'TsSettings' && $parent->page_name != 'TsPrintSetting'): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="<?php echo e($parent->page_name); ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#<?php echo e($parent->page_name); ?>Manual" aria-expanded="false"
                                aria-controls="<?php echo e($parent->page_name); ?>Manual">
                                <div class="form-group p-0 m-0">
                                    <input type="checkbox" name="<?php echo e($parent->page_name); ?>"
                                        <?php echo e($power[$parent->page_name] == 1 ? 'checked' : ''); ?>

                                        id="<?php echo e($parent->page_name); ?>It" onchange="handelValue(event)"
                                        value="<?php echo e($power[$parent->page_name]); ?>" />

                                    <label for="<?php echo e($parent->page_name); ?>It" class="font-main font-weight-bold mr-2">
                                        <?php echo e($parent->name); ?> </label>
                                </div>
                            </button>
                        </h2>
                        <div id="<?php echo e($parent->page_name); ?>Manual" class="accordion-collapse collapse"
                            aria-labelledby="<?php echo e($parent->page_name); ?>" data-bs-parent="#SystemParent">
                            <div class="accordion-body">
                                <?php $__currentLoopData = $childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($child->parent_id == $parent->id): ?>
                                        <div class="form-group d-flex align-items-center">
                                            <input type="checkbox" id="<?php echo e($child->id); ?>"
                                                <?php echo e($power[$child->page_name] == 1 ? 'checked' : ''); ?>

                                                onchange="handelValue(event)" name="<?php echo e($child->page_name); ?>"
                                                value="<?php echo e($power[$child->page_name]); ?>" />
                                            <label for="<?php echo e($child->id); ?>" class="font-main font-weight-bold mr-2">
                                                <?php echo e($child->name); ?> </label>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



            <div class="accordion-item">
                <h2 class="accordion-header" id="POSS">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#POSSManual" aria-expanded="false" aria-controls="POSSManual">
                        <div class="form-group p-0 m-0">
                            
                            <p class="font-main ">نقاط البيع</p>
                        </div>
                    </button>
                </h2>
                <div id="POSSManual" class="accordion-collapse collapse" aria-labelledby="POSS"
                    data-bs-parent="#SystemParent">
                    <div class="accordion-body">
                        <div class="form-group d-flex align-items-center">
                            <input type="checkbox" id="TsPos" <?php echo e($power['TsPos'] == 1 ? 'checked' : ''); ?>

                                onchange="handelValue(event)" name="TsPos" value="<?php echo e($power['TsPos']); ?>" />
                            <label for="TsPos" class="font-main font-weight-bold mr-2">
                                فتح نقاط البيع (ايقون) </label>
                        </div>

                    </div>
                </div>
            </div>

            <hr>
            <hr>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/users/power_edit.blade.php ENDPATH**/ ?>