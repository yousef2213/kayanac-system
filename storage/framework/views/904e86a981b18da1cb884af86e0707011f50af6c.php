<?php $__env->startSection('main-content'); ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="users-dataTable" dir="rtl" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center font-main">
                            <th>S.N</th>
                            <th> الحالة </th>
                            <th> تفعيل </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="text-center font-main">
                                <td><?php echo e($user->email); ?></td>

                                <td>
                                    <?php if($user->status == 0): ?>
                                        <span class="badge badge-warning"> غير مفعل </span>
                                    <?php elseif($user->status == 1): ?>
                                        <span class="badge badge-success">مفعل</span>
                                    <?php elseif($user->status == 4): ?>
                                        <span class="badge badge-warning"> تم ازالة السيستم </span>
                                    <?php endif; ?>


                                </td>
                                <td>
                                    <button class="btn btn-small btn-success" onclick="activeSystem('<?php echo e($user->id); ?>')">
                                        تفعيل
                                        السيستم
                                    </button>
                                </td>
                                
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
        const activeSystem = async (id) => {

            swal({
                title: "هل انت متاكد من تفعيل السيستم?",
                text: "سيتم تفعيل السيستم عند التاكيد للتفعيل!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(res => {
                if (res) {
                    fetch(`/erp/public/user-avtive/${id}`).then(resp => resp.json()).then(data => {
                        if (data.status == 200) {
                            swal('تم تفعيل السيستم بنجاح يا بية ')
                        }
                    })
                }
            })
        }
        const destroySystem = (id) => {
            swal({
                title: "هل انت متاكد من تدمير السيستم?",
                text: "سيتم تدمير السيستم عند التاكيد للطلب!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(res => {
                if (res) {
                    fetch(`/erp/public/user-destroy/${id}`).then(resp => resp.json()).then(data => {
                        if (data.status == 200) {
                            swal('تم تدمير السيستم بنجاح يا بية , ربنا ميجيب دمار ابدا ')
                        }
                    })
                }
            })

        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/dashboardUsers/index.blade.php ENDPATH**/ ?>