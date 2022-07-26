<?php $__currentLoopData = $child->childList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemChild): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="accordion text-right font-main" id="fourAcountDrop">
        <?php if($itemChild->parent != 1): ?>
            <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                <span class="mx-2"><?php echo e($itemChild->namear); ?> </span>
                <span> <i class="fas fa-file"></i> </span>
            </a>
        <?php else: ?>
            <div class="card cardContriner">
                <div class="card-header" id="threeChild-<?php echo e($itemChild->id); ?>">
                    <h2 class="mb-0 d-flex">
                        <button class="btn btn-link btn-block text-right font-weight-bold" type="button"
                            data-toggle="collapse" data-target="#accountThreeLast-<?php echo e($itemChild->id); ?>"
                            aria-expanded="true" aria-controls="accountThreeLast-<?php echo e($itemChild->id); ?>">
                            <?php if($itemChild->id == 8): ?>
                                <span class="mx-2"> <?php echo e($itemChild->namear); ?></span>
                                <span> <i class="fas fa-folder text-success"></i> </span>
                            <?php elseif($itemChild->id == 21): ?>
                                <span class="mx-2"> <?php echo e($itemChild->namear); ?></span>
                                <span> <i class="fas fa-folder text-success"></i> </span>
                            <?php else: ?>
                                <span class="mx-2"> <?php echo e($itemChild->namear); ?></span>
                                <span> <i class="fas fa-folder"></i> </span>
                            <?php endif; ?>
                        </button>
                        <a class="border-0" href="<?php echo e(route('accounts.edit', $itemChild->id)); ?>">
                            <span style="font-size: 16px;display: inline-block;padding-bottom: 13px;"> <i
                                    class="fas fa-edit"></i>
                            </span>
                        </a>
                    </h2>
                </div>

                <div id="accountThreeLast-<?php echo e($itemChild->id); ?>" class="collapse"
                    aria-labelledby="threeChild-<?php echo e($itemChild->id); ?>" data-parent="#fourAcountDrop">
                    <div class="card-body">
                        <?php if($itemChild->id == 8): ?>
                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                                    <span class="mx-1"> <?php echo e($customer->name); ?> </span>
                                    <span class="mx-1"> <?php echo e($customer->account_id); ?> </span>
                                    <span> <i class="fas fa-file"></i> </span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php elseif($itemChild->id == 21): ?>
                            <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                                    <span class="mx-1"> <?php echo e($customer->name); ?> </span>
                                    <span class="mx-1"> <?php echo e($customer->account_id); ?> </span>
                                    <span> <i class="fas fa-file"></i> </span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php elseif($itemChild->id == 15): ?>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                                    <span class="mx-1"> <?php echo e($employee->namear); ?> </span>
                                    <span class="mx-1"> <?php echo e($employee->account_id); ?> </span>
                                    <span> <i class="fas fa-file"></i> </span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php elseif($itemChild->id == 11): ?>
                            <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                                    <span class="mx-1"> <?php echo e($store->namear); ?> </span>
                                    <span class="mx-1"> <?php echo e($store->account_id); ?> </span>
                                    <span> <i class="fas fa-file"></i> </span>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <?php echo $__env->make('Accounts.last2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/Accounts/last_component.blade.php ENDPATH**/ ?>