<?php $__env->startSection('main-content'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة مركز تكلفة </li>
            <li class="breadcrumb-item"><a href="/erp/public/cost_centers"> مراكز التكلفة </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>
    <div class="card">
        <h5 class="card-header"> Add Group </h5>
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="<?php echo e(route('cost_centers.store')); ?>" autocomplete="off"
                enctype="multipart/form-data">

                <?php echo e(csrf_field()); ?>


                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">الاسم بالعربي</label>
                            <input type="text" name="namear" value="<?php echo e(old('namear')); ?>" class="form-control">
                            <?php $__errorArgs = ['namear'];
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
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">الاسم بالانجليزي</label>
                            <input type="text" name="nameen" value="<?php echo e(old('nameen')); ?>" class="form-control">
                            <?php $__errorArgs = ['nameen'];
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

                    <div class="col-12 col-md-6 group1">
                        <div class="form-group text-right">
                            <label class="col-form-label"> اسم المجموعة 1 </label>
                            <select name="group1" class="form-control group1V  chosen-select" onchange="handelGroup2(event)"
                                dir="rtl">
                                <option value="0"> --- </option>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"> <?php echo e($item->namear); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['group_main'];
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

                    <div class="col-12 col-md-6 group2 d-none">
                        <div class="form-group text-right">
                            <label class="col-form-label"> اسم المجموعة 2 </label>
                            <select name="group2" class="form-control" id="group2V" onchange="handelGroup3(event)"
                                dir="rtl">
                                <option value="0"> --- </option>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"> <?php echo e($item->namear); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['group_main'];
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

                    <div class="col-12 col-md-6 group3 d-none">
                        <div class="form-group text-right">
                            <label class="col-form-label"> اسم المجموعة 3 </label>
                            <select name="group3" class="form-control" id="group3V" onchange="handelGroup4(event)"
                                dir="rtl">
                                <option value="0"> --- </option>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"> <?php echo e($item->namear); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['group_main'];
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

                    <div class="col-12 col-md-6 group4 d-none">
                        <div class="form-group text-right">
                            <label class="col-form-label"> اسم المجموعة 4 </label>
                            <select name="group4" class="form-control" id="group4V" dir="rtl">
                                <option value="0"> --- </option>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"> <?php echo e($item->namear); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['group_main'];
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

                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label"> نوع مركز التكلفة </label>
                            <select name="group_type" class="form-control chosen-select">
                                <option value="0"> --- </option>
                                <option value="1"> رئيسي </option>
                                <option value="0"> متفرع </option>
                            </select>
                            <?php $__errorArgs = ['group_type'];
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


                </div>


                <hr>

                <div class="form-group mb-3 text-right">
                    
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
    <style>
        .chosen-single {
            height: 35px !important;
        }

    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        let id1 = 0;
        let id2 = 0;
        let id3 = 0;
        let id4 = 0;
        const handelGroup = event => {
            let val = event.target.value;
            if (val == 1) {
                document.querySelector('.group1').classList.add('d-none')
            } else {
                document.querySelector('.group1').classList.remove('d-none')
                document.querySelector('.group1V').value = 0
            }
        }
        const handelGroup2 = (event) => {
            let val = event.target.value;
            id1 = val;
            console.log(val);
            let parent = $('.group2');
            fetch(`/erp/public/cost_centers/getGroups/${val}`)
                .then(response => response.json())
                .then(data => {
                    let item = '';
                    item += `<option value="986869"> -- </option>`;
                    if (data.length > 0) {
                        parent.removeClass('d-none')
                        data.forEach(element => {
                            item += `<option value="${element.id}"> ${element.namear} </option>`;
                        });
                        $('#group2V').html(item)
                    } else {
                        parent.addClass('d-none')
                        item = `<option value="986869"> -- </option>`;
                        $('#group2V').html(item)
                    }
                }).catch(e => {
                    parent.addClass('d-none')
                    item = `<option value="986869"> -- </option>`;
                    $('#group3V').html(item)
                })
        }

        const handelGroup3 = event => {
            let val = event.target.value;
            console.log(val);
            id2 = val;
            let parent = $('.group3');

            fetch(`/erp/public/cost_centers/getGroups2/${id1}/${val}`)
                .then(response => response.json())
                .then(data => {
                    let item = '';
                    item += `<option value="986869"> -- </option>`;
                    if (data.length > 0) {
                        parent.removeClass('d-none')
                        data.forEach(element => {
                            item += `<option value="${element.id}"> ${element.namear} </option>`;
                        });
                        $('#group3V').html(item)
                    } else {
                        parent.addClass('d-none')
                        item = `<option value="986869"> -- </option>`;
                        $('#group3V').html(item)
                    }
                }).catch(e => {
                    parent.addClass('d-none')
                    item = `<option value="986869"> -- </option>`;
                    $('#group3V').html(item)
                })
        }
        const handelGroup4 = event => {
            let val = event.target.value;
            console.log(val);
            id3 = val;
            let parent = $('.group4');
            fetch(`/erp/public/cost_centers/getGroups3/${id1}/${id2}/${val}`)
                .then(response => response.json())
                .then(data => {
                    console.log("data is :",data);
                    let item = '';
                    item += `<option value="986869"> -- </option>`;
                    if (data.length > 0) {
                        parent.removeClass('d-none')
                        data.forEach(element => {
                            item += `<option value="${element.id}"> ${element.namear} </option>`;
                        });
                        $('#group4V').html(item)
                    } else {
                        parent.addClass('d-none')
                        item = `<option value="986869"> -- </option>`;
                        $('#group4V').html(item)
                    }
                }).catch(e => {
                    parent.addClass('d-none')
                    item = `<option value="986869"> -- </option>`;
                    $('#group4V').html(item)
                })
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/cost_centers/create.blade.php ENDPATH**/ ?>