<?php $__env->startSection('main-content'); ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة حساب </li>
            <li class="breadcrumb-item"><a href="/erp/public/accounts"> الحسابات </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>


    <?php if(\Session::has('success')): ?>
        <div class="alert alert-success">
            <ul style="list-style: none;text-align: right">
                <li class="font-main text-right"><?php echo \Session::get('success'); ?></li>
            </ul>
        </div>
    <?php endif; ?>
    <?php if(\Session::has('error')): ?>
        <div class="alert alert-danger">
            <ul style="list-style: none;text-align: right">
                <li class="font-main text-right"><?php echo \Session::get('error'); ?></li>
            </ul>
        </div>
    <?php endif; ?>
    <?php if(\Session::has('msg')): ?>
        <div class="alert alert-success">
            <ul style="list-style: none;text-align: right">
                <li class="font-main text-right"><?php echo \Session::get('msg'); ?></li>
            </ul>
        </div>
    <?php endif; ?>

    <div class="company text-right font-ar">
        <div class="container-fluid py-4 font-main">
            <div class="row mx-0">
                <div class="col-12 mx-auto px-0">
                    <form dir="rtl" method="POST" autocomplete="off" action="<?php echo e(route('accounts.store')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <div class="row py-2">
                            <div class="col-12 col-md-6 mx-auto">
                                <label> اسم الحساب بالعربي </label>
                                <input type="text" autocomplete="off" name="namear" value="<?php echo e(old('namear')); ?>"
                                    class="form-control" />
                                <?php $__errorArgs = ['namear'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"> البيانات مطلوبة </span>

                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <label> الاسم الحساب بالانجليزي </label>
                                <input type="text" autocomplete="off" name="nameen" value="<?php echo e(old('nameen')); ?>"
                                    class="form-control" />
                                <?php $__errorArgs = ['nameen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"> البيانات مطلوبة </span>

                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="balance_sheet" class="col-form-label">مجموعة الميزانية العمومية </label>
                                    <select autocomplete="off" name="balance_sheet" class="form-control">
                                        <option value="0"> --- </option>
                                        <option value="1"> قايمة دخل </option>
                                        <option value="2"> ميزانية </option>
                                    </select>
                                </div>
                                <?php $__errorArgs = ['balance_sheet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"> البيانات مطلوبة </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>



                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="acount" class="col-form-label"> نوع الحساب </label>
                                    <select autocomplete="off" name="acount" id="acountId" onchange="getAccounts(event)"
                                        class="form-control">
                                        <option value="0"> --- </option>
                                        <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($account->id); ?>"> <?php echo e($account->namear); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 d-none parent_2_idParent">
                                <div class="form-group">
                                    <label for="parent_2_id" class="col-form-label"> اختر الحساب </label>
                                    <select autocomplete="off" name="parent_2_id" id="parent_2_id"
                                        onchange="getAccounts2(event)" class="form-control">
                                        <option value="0"> --- </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 d-none parent_3_idParent">
                                <div class="form-group">
                                    <label for="parent_3_id" class="col-form-label"> اختر الحساب </label>
                                    <select autocomplete="off" name="parent_3_id" id="parent_3_id"
                                        onchange="getAccounts3(event)" class="form-control">
                                        <option value="0"> --- </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 d-none parent_4_idParent">
                                <div class="form-group">
                                    <label for="parent_4_id" class="col-form-label"> اختر الحساب </label>
                                    <select autocomplete="off" name="parent_4_id" id="parent_4_id" class="form-control">
                                        <option value="0"> --- </option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="status" class="col-form-label">الحالة</label>
                                    <select autocomplete="off" onchange="handelType(event)" name="type"
                                        class="form-control">
                                        <option value=""> -- </option>
                                        <option value="1"> parent </option>
                                        <option value="2"> child </option>
                                    </select>
                                </div>
                                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"> البيانات مطلوبة </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                        </div>






                        <div class="submiting d-flex mt-4">
                            <button type="submit" class="btn btn-primary mx-2 px-4 font-main px-4"> حفظ </button>
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
        });

        handelType = event => {
            // let val = event.target.value;
            // let type = document.querySelector('.accountType');
            // if (val == 2) {
            //     type.classList.remove('d-none');
            // } else {
            //     type.classList.add('d-none');
            // }
        }

        getAccounts = async (event) => {
            let request = await fetch(`/erp/public/accounts/getaccounts/${event.target.value}`);
            let data = await request.json();
            let item = '';
            let parent = $('.parent_2_idParent');
            item += `<option value="0"> -- </option>`;
            if (data.length > 0) {
                parent.toggleClass('d-none')
                data.forEach(element => {
                    item += `<option value="${element.id}"> ${element.namear} </option>`;
                });
                $('#parent_2_id').html(item)
            } else {
                item = `<option value="0"> -- </option>`;
                $('#parent_2_id').html(item)
            }
        }
        getAccounts2 = async (event) => {
            let id = $('#acountId').val();
            let request = await fetch(`/erp/public/accounts/getaccounts/2/${id}/${event.target.value}`);
            let data = await request.json();
            let item = '';
            let parent = $('.parent_3_idParent');
            item += `<option let parent = $('.parent_2_idParent');on value="0"> -- </option>`;
            if (data.length > 0) {
                parent.toggleClass('d-none')
                data.forEach(element => {
                    item += `<option value="${element.id}"> ${element.namear} </option>`;
                });
                $('#parent_3_id').html(item)
            } else {
                item = `<option value="0"> -- </option>`;
                $('#parent_3_id').html(item)
            }
        }
        getAccounts3 = async (event) => {
            let id1 = $('#acountId').val();
            let id2 = $('#parent_2_id').val();
            let request = await fetch(`/erp/public/accounts/getaccounts/3/${id1}/${id2}/${event.target.value}`);
            let data = await request.json();
            let parent = $('.parent_4_idParent');
            let item = '';
            item += `<option value="0"> -- </option>`;
            if (data.length > 0) {
                parent.toggleClass('d-none')
                data.forEach(element => {
                    item += `<option value="${element.id}"> ${element.namear} </option>`;
                });
                $('#parent_4_id').html(item)
            } else {
                item = `<option value="0"> -- </option>`;
                $('#parent_4_id').html(item)
            }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/Accounts/create.blade.php ENDPATH**/ ?>