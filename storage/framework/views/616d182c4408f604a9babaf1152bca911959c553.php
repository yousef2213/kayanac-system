<?php $__env->startSection('main-content'); ?>
    <div class="container-fluid px-5">
        <div class="row">
            <nav aria-label="breadcrumb" class="">
                <ol class="breadcrumb justify-content-end font-main p-2">
                    <li class="breadcrumb-item active" aria-current="page"> تقرير قائمة المركز المالي </li>
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
        </div>
    </div>

    <div class="container-fluid px-5">
        <div class="row font-main">
            <div class="col-12 mx-auto">
                <form action="" dir="rtl">
                    <div class="row text-right">
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for=""> الفروع </label>
                                <select class="form-control chosen-select" id="select-branches">
                                    <option value="0"> كل الفروع </option>
                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branche): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($branche->id); ?>"><?php echo e($branche->namear); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row text-right">
                        <div class="col-6 mx-auto">
                            <div class="form-group my-3">
                                <label for="">من تاريخ</label>
                                <input type="datetime-local" class="form-control" name="from" id="date-from">
                            </div>
                        </div>
                        <div class="col-6 mx-auto">
                            <div class="form-group my-3">
                                <label for="">الي تاريخ</label>
                                <input type="datetime-local" class="form-control" name="to" id="date-to">
                            </div>
                        </div>
                    </div>
                    <div class="text-right my-4">
                        <button class="btn btn-primary px-5" onclick="Show(event, '<?php echo e(csrf_token()); ?>')"> عرض </button>
                    </div>
                </form>
            </div>
        </div>


        <div class="row">
            <div class="col-12">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-striped table-hover" id="badget-dataTable" dir="rtl"
                            width="100%">
                            <thead>
                                <tr class="text-center font-main" style="border: 0 !important">
                                    <th colspan="2" style="border: 1px solid #000"> الحسابات </th>
                                    <th colspan="2" style="border: 1px solid #000"> الارصدة </th>
                                </tr>
                                <tr class="text-center font-main">
                                    <th style="border: 1px solid #000"> رقم الحساب </th>
                                    <th style="border: 1px solid #000"> اسم الحساب </th>
                                    <th style="border: 1px solid #000"> مدين </th>
                                    <th style="border: 1px solid #000"> دائن </th>
                                </tr>
                            </thead>
                            <tbody class="badgets"></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <tbody class="badgetsCalculation d-none"></tbody>


    <div class="badgetsTest d-none"></div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('boot5/bootstrap.min.css')); ?>">
    <style>
        .chosen-single {
            height: 35px !important;
        }

    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('boot5/bootstrap.min.js')); ?>"></script>
    <script>
        let UpdatedList = [];
        let UpdatedItems = [];
        let item;

        const Show = (event, csrf) => {
            event.preventDefault();
            let branch = $("#select-branches").val();
            let from = $("#date-from").val();
            let to = $("#date-to").val();
            let data = {
                _token: csrf,
                branch,
                from,
                to
            };
            let ele = document.querySelector(".badgets");
            $.ajax({
                type: "POST",
                url: "/erp/public/financialCenter/filter",
                data,
                success: function(res) {
                    let data = [...res.list2, ...res.list1];
                    if (data.length != 0) {
                        FormatData(res);
                    } else {
                        $('.badgets').html('');
                        swal("لا يوجد بيانات");
                    }
                }
            });
        };


        const FormatData = res => {
            $('.badgets').html('<span></span>');
            let total_debtor = 0;
            let total_creditor = 0;
            UpdatedList = []
            UpdatedItems = []
            let data = [...res.list2, ...res.list1];
            let lists = [...res.first];

            data.forEach(option => {
                let debtor = document.querySelectorAll(`.deb1-${option.account_id}`);
                let creditor = document.querySelectorAll(`.cer1-${option.account_id}`);
                if (debtor.length != 0 || creditor.length != 0) {
                    let obj = UpdatedList.find(ele => ele.account_id == option.account_id);
                    obj.debtor += option.debtor;
                    obj.creditor += option.creditor;
                    document.querySelector(`.deb1-${option.account_id}`).innerHTML = +(+document.querySelector(
                        `.deb1-${option.account_id}`).innerHTML + option.debtor).toFixed(3);
                    document.querySelector(`.cer1-${option.account_id}`).innerHTML = +(+document.querySelector(
                        `.cer1-${option.account_id}`).innerHTML + option.creditor).toFixed(3);

                } else {
                    UpdatedList.push(option);
                    item = `<tr class="text-center font-main">
                                <td style="border: 1px solid #000"> ${option.account_id} </td>
                                <td style="border: 1px solid #000"> ${option.account_name} </td>
                                <td  style="border: 1px solid #000" class="deb1-${option.account_id}"> ${+option.debtor.toFixed(3)} </td>
                                <td style="border: 1px solid #000" class="cer1-${option.account_id}"> ${+option.creditor.toFixed(3) } </td>
                            </tr>
                        `
                    $('.badgetsTest').append(item);
                }
            });

            lists.forEach(option => {
                let debtor = document.querySelectorAll(`.deb-${option.account_id}`);
                let creditor = document.querySelectorAll(`.cer-${option.account_id}`);
                if (debtor.length != 0 || creditor.length != 0) {
                    let obj = UpdatedItems.find(ele => ele.account_id == option.account_id);
                    obj.debtor += option.debtor;
                    obj.creditor += option.creditor;
                    document.querySelector(`.deb-${option.account_id}`).innerHTML = +(+document.querySelector(
                        `.deb-${option.account_id}`).innerHTML + option.debtor).toFixed(3);
                    document.querySelector(`.cer-${option.account_id}`).innerHTML = +(+document.querySelector(
                        `.cer-${option.account_id}`).innerHTML + option.creditor).toFixed(3);

                } else {
                    UpdatedItems.push(option);
                    item = `<tr class="text-center font-main">
                                <td style="border: 1px solid #000"> ${option.account_id} </td>
                                <td style="border: 1px solid #000"> ${option.account_name} </td>
                                <td  style="border: 1px solid #000" class="deb-${option.account_id}"> ${+option.debtor.toFixed(3)} </td>
                                <td style="border: 1px solid #000" class="cer-${option.account_id}"> ${+option.creditor.toFixed(3) } </td>
                            </tr>
                        `
                    $('.badgets').append(item);
                }
            });


            UpdatedList.forEach(el => {
                total_debtor += el.debtor;
                total_creditor += el.creditor;
            });
            let newTotal = +total_creditor - +total_debtor;

            let netTotalRow = `
                    <tr class="text-center font-main">
                        <td style="border: 1px solid #000" colspan="2"> صافي الربح </td>
                        <td style="border: 1px solid #000" class="text-success"> ${newTotal > 0 ? newTotal : 0} </td>
                        <td style="border: 1px solid #000" class="text-danger"> ${newTotal < 0 ? Math.abs(newTotal) : 0} </td>
                    </tr>`;
            $('.badgets').append(netTotalRow);

            let total_debtor2 = 0;
            let total_creditor2 = 0;
            UpdatedItems.forEach(el => {
                total_debtor2 += el.debtor;
                total_creditor2 += el.creditor;
            });
            let item2 = `
                    <tr class="text-center font-main">
                        <td style="border: 1px solid #000" colspan="2"> الاجمالي </td>
                        <td style="border: 1px solid #000" class="text-success"> ${+total_debtor2.toFixed(3)} </td>
                        <td style="border: 1px solid #000" class="text-danger"> ${+total_creditor2.toFixed(3)} </td>
                    </tr>`;
            $('.badgets').append(item2);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/FinancialCenter/index.blade.php ENDPATH**/ ?>