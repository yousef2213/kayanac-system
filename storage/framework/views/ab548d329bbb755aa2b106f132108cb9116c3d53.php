<?php if(count($account->ParentChild) > 0): ?>
    <div class="accordion text-right font-main" id="accountsChildDrop">
        <?php if(count($account->ParentChild) > 0): ?>
            <?php $__currentLoopData = $account->ParentChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($child->parent == 1): ?>
                    <div class="card cardContriner">
                        <div class="card-header" id="accountchild-<?php echo e($child->id); ?>">
                            <h2 class="mb-0 d-flex">
                                <button class="btn btn-link btn-block text-right font-weight-bold" type="button"
                                    data-toggle="collapse" data-target="#accountOneChild-<?php echo e($child->id); ?>"
                                    aria-expanded="true" aria-controls="accountOneChild-<?php echo e($child->id); ?>">
                                    <span class="mx-2"> <?php echo e($child->namear); ?> </span>
                                    <span> <i class="fas fa-folder"></i> </span>
                                </button>
                                <a class="border-0" href="<?php echo e(route('accounts.edit', $child->id)); ?>">
                                    <span style="font-size: 16px;display: inline-block;padding-bottom: 13px;"> <i
                                            class="fas fa-edit"></i>
                                    </span>
                                </a>
                            </h2>
                        </div>

                        <div id="accountOneChild-<?php echo e($child->id); ?>" class="collapse"
                            aria-labelledby="accountchild-<?php echo e($child->id); ?>" data-parent="#accountsChildDrop">
                            <div class="card-body">
                                
                                <?php echo $__env->make('Accounts.last_component', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                
                                <?php if($child->id == 26): ?>
                                    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                                            <span class="mx-1"> تكلفة مبيعات <?php echo e($store->namear); ?> </span>
                                            <span class="mx-1"> <?php echo e($store->account_id); ?> </span>
                                            <span> <i class="fas fa-file"></i> </span>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                <?php elseif($child->parent == 0): ?>
                    <a href="#" class="d-inline-block px-3 my-2">
                        <span class="mx-2"><?php echo e($child->namear); ?> </span>
                        <span> <i class="fas fa-file"></i> </span>
                    </a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="col-10 mx-auto text-canter">
                <h4 class="text-center py-5"> لا يوجد حسابات </h4>
            </div>
        <?php endif; ?>


    </div>

<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/Accounts/child.blade.php ENDPATH**/ ?>