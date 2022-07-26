<?php $__env->startSection('main-content'); ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> العملات </li>
            <li class="breadcrumb-item"><a href="/erp/public/home"><?php echo e(__('pos.main')); ?></a></li>
        </ol>
    </nav>

    <?php if(\Session::has('msg')): ?>
        <div class="alert alert-success">
            <ul style="list-style: none;text-align: right">
                <li class="font-main text-right"><?php echo \Session::get('msg'); ?></li>
            </ul>
        </div>
    <?php endif; ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 font-main">
            <h6 class="m-0 font-weight-bold text-primary float-left"> العملة</h6>
            <a href="<?php echo e(route('currencies.create')); ?>" class="btn  font-main btn-primary btn-sm float-right"
                data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"
                    style="font-size: 10px"></i> اضافة </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="users-dataTable" dir="rtl" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center font-main">
                            <th>num</th>
                            <th>العملة الكبير</th>
                            <th>العملة الصغري</th>
                            <th>سعر الصرف</th>
                            <th>افتراضي</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="text-center font-main">
                                <td><?php echo e($currency->id); ?></td>
                                <td><?php echo e($currency->bigar); ?></td>
                                <td><?php echo e($currency->smallar); ?></td>
                                <td><?php echo e($currency->rate); ?></td>
                                <td><?php echo e($currency->main == 1 ? 'العملة الافتراضية' : ''); ?></td>

                                <td>
                                    <a href="<?php echo e(route('currencies.edit', $currency->id)); ?>"
                                        class="btn btn-primary btn-sm float-left mr-1"
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                        data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    <?php if($currency->id != 1): ?>
                                        <form method="POST" action="<?php echo e(route('currencies.destroy', [$currency->id])); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('delete'); ?>
                                            <button class="btn btn-danger btn-sm dltBtn" data-id=<?php echo e($currency->id); ?>

                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    <?php endif; ?>

                                </td>
                                <div class="modal fade" id="delModal<?php echo e($currency->id); ?>" tabindex="-1" role="dialog"
                                    aria-labelledby="#delModal<?php echo e($currency->id); ?>Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="#delModal<?php echo e($currency->id); ?>Label"> Delete
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post"
                                                    action="<?php echo e(route('currencies.destroy', $currency->id)); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('delete'); ?>
                                                    <button type="submit" class="btn btn-danger"
                                                        style="margin:auto; text-align:center">Parmanent delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
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

        body {
            color: #555 !important
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/currencies/index.blade.php ENDPATH**/ ?>