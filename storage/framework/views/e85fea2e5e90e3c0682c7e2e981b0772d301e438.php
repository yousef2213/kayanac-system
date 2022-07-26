<?php if(count($itemChild->FourList) > 0): ?>
    <div class="accordion text-right font-main" id="fourAcount">
        <?php $__currentLoopData = $itemChild->FourList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $four): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($four->parent != 1): ?>
                <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                    <span class="mx-1"><?php echo e($four->namear); ?> </span>
                    <span class="mx-1"> <i class="fas fa-file"></i> </span>
                </a>
            <?php else: ?>
                <div class="card cardContriner">
                    <div class="card-header" id="fourChild-<?php echo e($four->id); ?>">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-right font-weight-bold" type="button"
                                data-toggle="collapse" data-target="#accountFourLast-<?php echo e($four->id); ?>"
                                aria-expanded="true" aria-controls="accountFourLast-<?php echo e($four->id); ?>">
                                <span class="mx-2"> <?php echo e($four->namear); ?> </span>
                                <span> <i class="fas fa-folder"></i> </span>
                            </button>
                        </h2>
                    </div>

                    <div id="accountFourLast-<?php echo e($four->id); ?>" class="collapse"
                        aria-labelledby="fourChild-<?php echo e($four->id); ?>" data-parent="#fourAcount">
                        <div class="card-body">
                            <?php echo $__env->make('Accounts.last4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/Accounts/last2.blade.php ENDPATH**/ ?>