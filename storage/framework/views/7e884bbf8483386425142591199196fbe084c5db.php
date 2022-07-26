<?php $__env->startSection('main-content'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> <?php echo e(__('pos.users')); ?> </li>
            <li class="breadcrumb-item"><a href="/home"> صلاحيات </a></li>
        </ol>
    </nav>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left"><?php echo e(__('pos.users')); ?></h6>
            <a href="<?php echo e(route('users.create')); ?>" class="btn  font-main btn-primary btn-sm float-right"
                data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"
                    style="font-size: 10px"></i> <?php echo e(__('pos.addUser')); ?> </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="users-dataTable" dir="rtl" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center font-main">
                            <th>م</th>
                            <th><?php echo e(__('pos.name')); ?></th>
                            <th><?php echo e(__('pos.email')); ?></th>
                            <th><?php echo e(__('pos.validity')); ?> </th>
                            <th><?php echo e(__('pos.status')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($user->name != 'super_erp' && $user->name != 'super_mostafa'): ?>
                                <tr class="text-center font-main">
                                    <td><?php echo e($key + 1); ?></td>
                                    <td><?php echo e($user->name); ?></td>
                                    <td><?php echo e($user->email); ?></td>
                                    <td>
                                        <?php if($user->role == '1'): ?>
                                            مستخدم عادي
                                        <?php endif; ?>
                                        <?php if($user->role == '3'): ?>
                                            مسؤل
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($user->status == 'active'): ?>
                                            <span class="badge badge-success"><?php echo e($user->status); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-warning"><?php echo e($user->status); ?></span>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- Page level plugins -->
    <script src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo e(asset('backend/js/demo/datatables-demo.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#users-dataTable').DataTable();
        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/users/permision.blade.php ENDPATH**/ ?>