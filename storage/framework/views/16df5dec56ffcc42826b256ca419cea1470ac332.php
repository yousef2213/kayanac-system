<div class="row">
    <div class="col-12 py-5">
        <div class="accordion font-main" id="SystemParent">

            <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="<?php echo e($parent->page_name); ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#<?php echo e($parent->page_name); ?>Manual" aria-expanded="false" aria-controls="<?php echo e($parent->page_name); ?>Manual">
                                <div class="form-group p-0 m-0">
                                    <label for="<?php echo e($parent->page_name); ?>It" class="font-main font-weight-bold mr-2"> <?php echo e($parent->name); ?> </label>
                                    <input type="checkbox" name="<?php echo e($parent->page_name); ?>" id="<?php echo e($parent->page_name); ?>It" onchange="handelValue(event)" value="0" />
                                </div>
                            </button>
                        </h2>
                        <div id="<?php echo e($parent->page_name); ?>Manual" class="accordion-collapse collapse" aria-labelledby="<?php echo e($parent->page_name); ?>"
                            data-bs-parent="#SystemParent">
                            <div class="accordion-body">
                                <?php $__currentLoopData = $childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($child->parent_id == $parent->id): ?>
                                        <div class="form-group">
                                            <label for="<?php echo e($child->id); ?>" class="font-main font-weight-bold mr-2"> <?php echo e($child->name); ?> </label>
                                            <input type="checkbox" id="<?php echo e($child->id); ?>" onchange="handelValue(event)" name="<?php echo e($child->page_name); ?>" value="0" />
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <hr>
            <hr>

            

        </div>
    </div>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/users/power.blade.php ENDPATH**/ ?>