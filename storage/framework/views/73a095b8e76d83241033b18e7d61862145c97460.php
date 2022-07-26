<?php $__env->startSection('main-content'); ?>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> تجميع الاصناف </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>



        <div class="card">
            <h5 class="card-header">Add Item</h5>
            <div class="card-body font-main">
                <form method="post" dir="rtl" action="<?php echo e(route('Transfers.store')); ?>" autocomplete="off"
                    enctype="multipart/form-data">
                    <input type="hidden" name="list[]" id="hidenValue">

                    <?php echo e(csrf_field()); ?>



                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label"> الرقم </label>
                                <input type="number" value="1" disabled class="form-control" name="qtn">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label"> التاريخ </label>
                                <input type="datetime-local" autocomplete="off" name="date" class="form-control" />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label"> الفرع </label>
                                <select name="branchId" class="form-control chosen-select" onchange="getStores(event)">
                                    <option value=<?php echo e(null); ?>> --- </option>
                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branche): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value=<?php echo e($branche->id); ?>> <?php echo e($branche->namear); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label">المخزن المحول منة </label>
                                <select name="storeId1" class="form-control  branches" id="storeId1">
                                    <option value=<?php echo e(null); ?>> --- </option>

                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label"> المخزن المستلم </label>
                                <select name="storeId2" class="form-control ">
                                    <option value=<?php echo e(null); ?>> --- </option>
                                    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value=<?php echo e($store->id); ?>> <?php echo e($store->namear); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label"> الوصف </label>
                                <textarea name="description" class="form-control" cols="5"></textarea>
                            </div>
                        </div>
                    </div>




                    <div class="col-12 px-0">

                        <table class="table table-striped table-bordered mt-5">
                            <thead class="btn-primary">
                                <tr>
                                    <th scope="col" class="py-1"> الصنف </th>
                                    <th scope="col" class="py-1"> الوحدة </th>
                                    <th scope="col" class="py-1"> الرصيد </th>
                                    <th scope="col" class="py-1"> الكمية </th>
                                    <th scope="col" class="py-1"> التكلفة </th>
                                    <th scope="col" class="py-1"> الوصف </th>
                                    <th class="td-style py-1">
                                        <button class="btn btn-success" type="button" onclick="addRow()"> + </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="TransformList">

                            </tbody>
                        </table>
                    </div>


                    <div class="form-group mb-3 text-right">
                        <button type="reset" class="btn btn-warning"> Reset </button>
                        <button class="btn btn-success" type="submit" onclick="onSubmit(event)"> Submit </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('boot5/bootstrap.min.css')); ?>">

    <style>
        .chosen-single {
            height: 35px !important;
        }

        body {
            color: #555
        }


        th,
        tr,
        td {
            text-align: center !important;
            font-size: 10px;
            vertical-align: middle !important
        }

        input[type=number]::-webkit-inner-spin-button {
            display: none;
        }

        .td-style {
            width: 90px
        }

    </style>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('scripts'); ?>
    <script>
        let Rows = [];

        const addRow = () => {
            let id = IDGenertaor();
            Rows.push({
                id
            });
            let item = `
                <tr class="Item-${id}">
                    <td class="px-0 d-flex align-items-center">
                        <input list="itemId" style="width:40%" class="form-control" onchange="handelItem(event,'${id}','ss')">
                        <datalist id="itemId">
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value=<?php echo e($item->id); ?> dataName=<?php echo e($item->namear); ?>> <?php echo e($item->namear); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </datalist>

                        <span id="span-${id}" class="d-inline-block" style="width:60%;font-size:15px"></span>
                    </td>
                    <td class="px-0">
                        <select name="unitId" onchange="handelUnit(event,'${id}')" class="form-control chosen-select" id="units-${id}">
                            <option value="null"> --- </option>

                        </select>
                    </td>
                    <td class="px-0">
                        <input type="text" disabled name="balance" class="form-control text-center balance-${id}" />
                    </td>

                    <td class="px-0">
                        <input type="number" name="qtn" onkeyup="handelQtn(event,'${id}')" value="0" class="form-control text-center qtn-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="text" disabled name="cost" class="form-control text-center cost-${id}" />
                    </td>

                    <td class="px-0">
                        <input type="text" onkeyup="handelDescription(event,'${id}')" class="form-control descr-${id}" />
                    </td>

                    <td>
                        <button class="btn btn-danger"onclick="DeleteRow('${id}')" type="button"> - </button>
                    </td>
                </tr>
                `;
            $('#TransformList').append(item);
        }




        const handelItem = (event, id, name) => {
            let item = Rows.find(el => el.id == id);
            item.itemId = event.target.value;
            let items = <?php echo json_encode($items->toArray()); ?>;
            $(`#span-${id}`).html(items.find(item => item.id == event.target.value).namear)
            let store = $('#storeId1').val();
            if (!store) {
                swal('تاكد من بيانات المخزن المحول منة')
            } else {
                $.ajax({
                    type: 'GET',
                    url: "/erp/public/getUnitsTransfers/" + event.target.value + "/" + store,
                    success: function(data = []) {
                        $(`#units-${id}`).html('');
                        let item = data.list[0];
                        $(`.cost-${id}`).val(item.av_price);
                        item.balance ? $(`.balance-${id}`).val(item.balance.qtn) : $(`.balance-${id}`).val(
                            0);
                        let obj = {
                            id: null,
                            namear: '---'
                        };
                        data = [obj, ...data.units];
                        let units = data.map(unit =>
                            `<option value="${unit.id}"> ${unit.namear} </option>`);
                        $(`#units-${id}`).html(units);
                    }
                });
            }

        }

        const getStores = (event, id, name) => {
            let branch = event.target.value;
            $.ajax({
                type: 'GET',
                url: "/erp/public/getStoresByBranch/" + event.target.value,
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    branch,
                },
                success: function(data = []) {
                    let obj = {
                        id: null,
                        namear: '---'
                    };
                    data = [obj, ...data];
                    let branches = data.map(row => `<option value="${row.id}"> ${row.namear} </option>`);
                    $(`.branches`).html(branches);
                }
            });
        }

        const handelUnit = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.unitId = event.target.value;
        }
        const handelQtn = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.qtn = event.target.value;
        }

        const onSubmit = (event) => {
            event.preventDefault();
            $('#hidenValue').val(JSON.stringify(Rows))
            $('form').submit()
        }
        let IDGenertaor = function() {
            return '_' + Math.random().toString(36).substr(2, 10);
        };

        let DeleteRow = id => {
            Rows = Rows.filter(el => el.id !== id);
            $(`.Item-${id}`).remove();
        }
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/stores/Transfers/create.blade.php ENDPATH**/ ?>