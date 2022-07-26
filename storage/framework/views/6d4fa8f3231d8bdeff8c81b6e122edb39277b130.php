<?php $__env->startSection('main-content'); ?>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main p-2">
                <li class="breadcrumb-item active" aria-current="page"> <?php echo e(__('pos.users')); ?> </li>
                <li class="breadcrumb-item"><a href="/erp/public/home"><?php echo e(__('pos.main')); ?></a></li>
            </ol>
        </nav>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left font-main"><?php echo e(__('pos.users')); ?></h6>
                <a href="<?php echo e(route('users.create')); ?>"
                    class="<?php echo e($orders->add == 0 ? 'd-none' : ''); ?> btn font-main btn-primary btn-sm float-right"
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
                                <th style="max-width: 100px">Action</th>
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
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <?php if(Auth::user()->role == 3): ?>
                                                    <a href="<?php echo e(route('users.edit', $user->id)); ?>"
                                                        class="btn btn-primary btn-sm mx-2" data-toggle="tooltip"
                                                        title="edit" data-placement="bottom">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('users.edit', $user->id)); ?>"
                                                        class="<?php echo e($orders->edit == 0 ? 'd-none' : ''); ?> btn btn-primary btn-sm mx-2"
                                                        data-toggle="tooltip" title="edit" data-placement="bottom">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if(Auth::user()->role == 3): ?>
                                                    
                                                    <a href="<?php echo e(route('users.permision', $user->id)); ?>"
                                                        class="btn btn-info btn-sm mx-2" data-toggle="tooltip"
                                                        title="permision" data-placement="bottom">
                                                        <i class="fa fa-user"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if(Auth::user()->role == 3): ?>
                                                    <form method="POST"
                                                        action="<?php echo e(route('users.destroy', [$user->id])); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('delete'); ?>
                                                        <button class="btn btn-danger mx-2 btn-sm dltBtn"
                                                            data-id=<?php echo e($user->id); ?> data-toggle="tooltip"
                                                            data-placement="bottom" title="Delete"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                <?php else: ?>
                                                    <form method="POST"
                                                        class="<?php echo e($orders->delete == 0 ? 'd-none' : ''); ?>"
                                                        action="<?php echo e(route('users.destroy', [$user->id])); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('delete'); ?>
                                                        <button class="btn btn-danger mx-2 btn-sm dltBtn"
                                                            data-id=<?php echo e($user->id); ?> data-toggle="tooltip"
                                                            data-placement="bottom" title="Delete"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <span style="float:right"><?php echo e($users->links()); ?></span>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('boot5/bootstrap.min.css')); ?>" rel="stylesheet">
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
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            })
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/users/index.blade.php ENDPATH**/ ?>