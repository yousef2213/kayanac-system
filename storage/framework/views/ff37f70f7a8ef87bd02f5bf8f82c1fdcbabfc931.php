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
                <form method="post" dir="rtl" action="<?php echo e(route('assembly.store')); ?>" autocomplete="off"
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
                                <label class="col-form-label">الاصناف </label>
                                <select name="itemId" class="form-control chosen-select" onchange="handelItemBasic(event)">
                                    <option value=<?php echo e(null); ?>> --- </option>
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value=<?php echo e($item->id); ?>> <?php echo e($item->namear); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label">المخزن </label>
                                <select name="storeId" class="form-control chosen-select" onchange="handelItemBasic(event)">
                                    <option value=<?php echo e(null); ?>> --- </option>
                                    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value=<?php echo e($store->id); ?>> <?php echo e($store->namear); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label">مكونات الاصناف </label>
                                <select class="form-control chosen-select" onchange="handelItem(event)">
                                    <option value=<?php echo e(null); ?>> --- </option>
                                    <?php $__currentLoopData = $itemsCreate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value=<?php echo e($item->id); ?>> <?php echo e($item->namear); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label"> الكمية </label>
                                <input type="number" name="qttn" step="0.1" class="form-control" >
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
                                    <th class="td-style py-1">
                                        <button class="btn btn-success" type="button"> ... </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="bodysItemsCollection">

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

        const addRow = (res, check) => {

            if (check) {
                $('#bodysItemsCollection').html('');
                res.list.forEach(row => {
                    let id = IDGenertaor();
                    console.log(row);
                    Rows.push({
                        id,
                        isNew: false,
                        itemId: row.itemId,
                        unitId: row.unitId,
                        qtn: row.qtn,
                    });
                    let balacne = row.balance ? row.balance.qtn : 0;

                    let item = `
                        <tr class="Item-${id}">
                            <td class="px-0">
                                <input type="text" name="item" disabled class="form-control item-${id}" value="${row.item_name}" />
                            </td>

                            <td class="px-0">
                                <select name="unit_id" onchange="handelUnit(event,'${id}')" class="form-control chosen-select">
                                    <option value="null"> --- </option>
                                    ${row.units.map(item => ` <option value='${item.unitId}' ${item.unitId == row.unitId ? "selected" : ""} > ${item.unit_name} </option> ` )}
                                </select>
                            </td>



                            <td class="px-0">
                                <input type="number" name="balacne"  disabled value=${balacne / row.packing} class="form-control balacne-${id} text-center" />
                            </td>

                            <td class="px-0">
                                <input type="number" name="qtn"  value=${row.qtn} onkeyup="handelQtn(event,'${id}')" class="form-control qtn-${id} text-center" />
                            </td>


                            <td class="px-0">
                                <input type="number" name="cost" disabled value=${row.cost} onkeyup="handelCost(event,'${id}')" class="form-control cost-${id} text-center" />
                            </td>

                            <td>
                                <button class="btn btn-danger"onclick="DeleteRow('${id}')" type="button"> - </button>
                            </td>
                        </tr>
                `
                    $('#bodysItemsCollection').append(item);

                })

            } else {
                let id = IDGenertaor();
                Rows.push({
                    isNew: true,
                    id
                });
                let row = Rows.find(el => el.id == id);
                row.itemId = res.item.id;
                let item = `
                <tr class="Item-${id}">

                    <td class="px-0">
                        <input type="text" name="item" disabled class="form-control item-${id}" value="${res.item.namear}" />
                    </td>
                    <td class="px-0">
                        <select name="unit_id" onchange="handelUnit(event,'${id}')" class="form-control chosen-select">
                            <option value="null"> --- </option>
                            ${res.list.map(row => ` <option value='${row.unitId}'> ${row.unit_name} </option> ` )}
                        </select>
                    </td>
                    <td class="px-0"></td>

                    <td class="px-0">
                        <input type="number" name="qtn" onkeyup="handelQtn(event,'${id}')" class="form-control qtn-${id}" />
                    </td>

                    <td class="px-0"></td>

                    <td>
                        <button class="btn btn-danger"onclick="DeleteRow('${id}')" type="button"> - </button>
                    </td>
                </tr>
                `;
                $('#bodysItemsCollection').append(item);
            }

        }


        const handelItemBasic = async (event) => {
            const req = await fetch("/erp/public/get-item-assembly/" + event.target.value);
            const res = await req.json();
            addRow(res, true)
        }





        const handelItem = async (event) => {
            const req = await fetch("/erp/public/get-item-collection/" + event.target.value);
            const res = await req.json();
            addRow(res, false)
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/ItemsCollection/assembly/create.blade.php ENDPATH**/ ?>