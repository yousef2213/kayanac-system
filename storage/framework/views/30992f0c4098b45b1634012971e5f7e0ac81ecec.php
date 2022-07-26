<?php $__env->startSection('main-content'); ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> تعديل فرع </li>
            <li class="breadcrumb-item"><a href="/erp/public/branches"> الفروع </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>
    <div class="company text-right font-ar">
        <div class="container-fluid py-4 font-main">
            <div class="row mx-0">
                <div class="col-12 col-md-10 mx-auto px-0">
                    <form dir="rtl" method="POST" action="<?php echo e(route('branches.update', $item->id)); ?>">
                        <?php echo e(csrf_field()); ?>

                        <?php echo method_field('PATCH'); ?>
                        <div class="row py-2">
                            <div class="col-12 col-md-6 mx-auto">
                                <label>الاسم بالعربي</label>
                                <input type="text" name="namear" value="<?php echo e($item->namear); ?>" class="form-control" />
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <label> الاسم بالانجليزي </label>
                                <input type="text" name="nameen" value="<?php echo e($item->nameen); ?>" class="form-control" />
                            </div>

                            <div class="col-12 col-md-6 mx-auto">
                                <div class="form-group">
                                    <label for="status" class="col-form-label">الشركة</label>
                                    <select name="companyId" class="form-control">
                                        <option value="0">---</option>
                                        <?php $__currentLoopData = $companys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($company->id); ?>"
                                                <?php echo e($company->id == $item->companyId ? 'selected' : ''); ?>>
                                                <?php echo e($company->companyNameAr); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <label>المدينة</label>
                                <input type="text" name="city" value="<?php echo e($item->city); ?>" class="form-control" />
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col-12 col-md-6 mx-auto">
                                <label> كود النشاط </label>
                                <input type="number" step="0.1" value="<?php echo e($item->code_activite); ?>" name="code_activite"
                                    class="form-control" />
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <label> Activity Code </label>
                                <input type="number" step="0.1" value="<?php echo e($item->activite_code); ?>" name="activite_code"
                                    class="form-control" />
                            </div>
                        </div>



                        <div class="row py-2">
                            <div class="col-12 col-md-6 mx-auto">
                                <label> المنطقة </label>
                                <input type="text" name="region" value="<?php echo e($item->region); ?>" class="form-control" />
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <label> الدولة </label>
                                <input type="text" name="country" value="<?php echo e($item->country); ?>" class="form-control" />
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col-12 col-md-6">
                                <label> هاتف </label>
                                <input type="number" name="phone" value="<?php echo e($item->phone); ?>" class="form-control" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label> العنوان </label>
                                <input autocomplete="off" type="text" value="<?php echo e($item->address); ?>" name="address"
                                    class="form-control" />

                            </div>

                        </div>






                        <div class="submiting d-flex mt-4">
                            <button type="submit" class="btn btn-primary mx-2 px-4"> تعديل </button>
                        </div>
                    </form>

                </div>
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
        $('#user-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [6, 7]
            }]
        });

        // Sweet alert

        function deleteData(id) {

        }
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/branches/edit.blade.php ENDPATH**/ ?>