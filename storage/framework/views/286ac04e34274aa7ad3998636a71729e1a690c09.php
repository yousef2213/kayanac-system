<?php $__env->startSection('main-content'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة امر بيع </li>
            <li class="breadcrumb-item"><a href="/home">الرئيسية</a></li>
        </ol>
    </nav>



    <div class="card">
        <h5 class="card-header">Add Invoice</h5>
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="<?php echo e(route('sell-order.store')); ?>" autocomplete="off"
                enctype="multipart/form-data">
                <input type="hidden" name="list[]" id="hidenValue">

                <?php echo e(csrf_field()); ?>



                <div class="row py-2 text-right">
                    <div class="col-12 col-md-6 mx-auto my-2">
                        <label> رقم الفاتورة </label>
                        <input type="text" autocomplete="off" disabled value="<?php echo e($id); ?>" name="id"
                            class="form-control" />
                    </div>
                    <div class="col-12 col-md-6 mx-auto my-2">
                        <label> تاريخ الفاتورة </label>
                        <input type="datetime-local" autocomplete="off" name="dateInvoice" class="form-control"
                            id="dateInvoice" />
                    </div>

                    <div class="col-12 col-md-6 mx-auto my-2">
                        <label> العميل </label>
                        <select name="customerId" class="form-control chosen-select" tabindex="4" dir="rtl">
                            <?php $__currentLoopData = $customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value=<?php echo e($supplier->id); ?>> <?php echo e($supplier->name); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 mx-auto my-2">
                        <label> مركز التكلفة </label>
                        <select name="costCenter" class="form-control chosen-select" tabindex="4" dir="rtl">
                            <option value=<?php echo e(null); ?>> --- </option>
                            <?php $__currentLoopData = $costCenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costCenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value=<?php echo e($costCenter->id); ?>> <?php echo e($costCenter->namear); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 mx-auto my-2">
                        <label class="col-form-label">الفرع</label>
                        <select name="branchId" class="form-control chosen-select" tabindex="4" dir="rtl">
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branche): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value=<?php echo e($branche->id); ?>> <?php echo e($branche->namear); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 my-2">
                        <label> نوع الدفع </label>
                        <select name="payment" class="form-control" tabindex="4" dir="rtl">
                            <option value="1"> كاش </option>
                            <option value="2"> اجل </option>
                        </select>
                    </div>
                </div>



                <div class="col-12 px-0">



                    <table class="table table-striped table-bordered mt-5">
                        <thead class="btn-primary">
                            <tr>
                                <th> المخزن </th>
                                <th> الصنف </th>
                                <th> الوحدة </th>
                                <th class="td-style"> الكمية </th>
                                <th class="td-style"> السعر </th>
                                <th class="td-style"> الخصم % </th>
                                <th class="td-style"> الاجمالي بعد الخصم </th>
                                <th class="td-style"> قيمة مضافة % </th>
                                <th class="td-style"> قيمة ضريبة </th>
                                <th class="td-style"> الاجمالي </th>
                                <th class="td-style"> الوصف </th>
                                <th class="td-style">
                                    <button class="btn btn-success" type="button" onclick="addRow()"> + </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="bodys">

                        </tbody>
                    </table>
                </div>

                <div class="col-12 col-md-4 my-4">
                    <table class="table table-border">
                        <thead class="text-center">
                            <tr>
                                <th colspan="2" style="font-size: 15px">اجماليات</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td colspan="1" style="font-size: 15px"> اجمالي الفاتورة </td>
                                <td colspan="1" style="font-size: 15px" class="safe">00</td>
                            </tr>
                            <?php if($company->tax_source != 0): ?>
                                <tr>
                                    <td style="font-size: 15px"> ضريبة خصم المنبع % </td>
                                    <td style="font-size: 15px" class="text-center" class="da">
                                        <input type="number" name="taxSource" onkeyup="handelTax(event)"
                                            class="form-control text-center d-inline-block" style="width: 100px" step="0.1">
                                        <input type="hidden" name="taxSourceValue"
                                            class="form-control text-center d-inline-block" id="taxSourceValue"
                                            style="width: 100px" step="0.1">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 15px"> قيمة ضريبة المنبع </td>
                                    <td style="font-size: 15px" class="tax_value">00</td>
                                </tr>
                            <?php endif; ?>

                            <tr>
                                <td style="font-size: 15px"> قيمة ضريبة المضافة </td>
                                <td style="font-size: 15px" class="tax_value_plus">00</td>
                            </tr>

                            <tr>
                                <td style="font-size: 15px"> صافي الفاتورة </td>
                                <td style="font-size: 15px" class="nettotal_inovice">00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="form-group mb-3 text-right">
                    <button class="btn btn-success" type="submit" onclick="onSubmit(event)"> Submit </button>
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

        th {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
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
        let total_invoice = 0;

        let Rows = [];
        let itemList = <?php echo json_encode($itemsList->toArray()); ?>;

        const addRow = () => {
            let id = IDGenertaor();
            Rows.push({
                id
            });
            let item = `
                <tr class="Item-${id}">
                    <td class="px-0">
                        <select name="storeId" onchange="handelStore(event,'${id}')" id="select-state" class="form-control chosen-select">
                            <option value="null"> -- </option>
                            <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value=<?php echo e($store->id); ?>> <?php echo e($store->namear); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
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
                        <input type="number" name="qtn" onkeyup="handelQtn(event,'${id}')" class="form-control qtn-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="price" onkeyup="handelPrice(event,'${id}')" class="form-control price-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="discount" onkeyup="handelDiscount(event,'${id}')" class="form-control dis-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" disabled name="total" onchange="handelTotal(event,'${id}')" value="0" class="form-control thetotal total-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="added" onkeyup="handelAdded(event,'${id}')" value="0" class="form-control added-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" disabled name="taxRate" onkeyup="handeltaxRate(event,'${id}')" value="0" class="form-control rate-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" disabled onkeyup="handelNetTotal(event,'${id}')" value="0" class="form-control nettotal-${id}" />
                    </td>

                    <td class="px-0">
                        <input type="text" onkeyup="handelDescription(event,'${id}')" class="form-control descr-${id}" />
                    </td>

                    <td>
                        <button class="btn btn-danger"onclick="DeleteRow('${id}')" type="button"> - </button>
                    </td>
                </tr>
                `;
            $('#bodys').append(item);
        }

        const handelStore = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.storeId = event.target.value;
        }
        const handelDescription = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.description = event.target.value;
        }
        const handelItem = (event, id, name) => {
            let item = Rows.find(el => el.id == id);
            item.itemId = event.target.value;
            let items = <?php echo json_encode($items->toArray()); ?>;
            $(`#span-${id}`).html(items.find(item => item.id == event.target.value).namear)

            $.ajax({
                type: 'GET',
                url: "/erp/public/getUnits/" + event.target.value,
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                },
                success: function(data = []) {
                    $(`#units-${id}`).html('');
                    let obj = {
                        id: null,
                        namear: '---'
                    };
                    data = [obj, ...data];
                    let units = data.map(unit => `<option value="${unit.id}"> ${unit.namear} </option>`);
                    $(`#units-${id}`).html(units);
                }
            });
        }
        const handelQtn = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.qtn = event.target.value;
            Calc(id, event.target.value);
        }
        const handelPrice = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.price = event.target.value;
            Calc(id, event.target.value);
        }
        const handelDiscount = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.discount = event.target.value;
            Calc(id, event.target.value);
        }
        const handelTotal = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.total = event.target.value;
        }
        const handelAdded = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.added = event.target.value;
            CalcRate(id)
            getTotal()
            handelTax()
        }
        const handeltaxRate = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.taxRate = event.target.value;
        }
        const handelNetTotal = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.netTotal = event.target.value;
        }
        const handelUnit = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.unitId = event.target.value;
        }
        const onSubmit = (event) => {
            event.preventDefault();
            $('#hidenValue').val(JSON.stringify(Rows))
            $taxV = $('.tax_value').html();
            $('#taxSourceValue').val(+$taxV);
            $('form').submit();
        }
        let IDGenertaor = function() {
            return '_' + Math.random().toString(36).substr(2, 10);
        };

        let Calc = (id) => {
            let price = $(`.price-${id}`).val();
            let qtn = $(`.qtn-${id}`).val();
            let discount = $(`.dis-${id}`).val();
            let discountValue = (discount * (+qtn * +price)) / 100;
            let total = (+qtn * +price) - discountValue;
            total = +total.toFixed(2);
            $(`.total-${id}`).val(total);
            CalcRate(id)
            getTotal(id)
        }

        function getTotal() {
            let total = 0;
            let taxs = 0;
            Rows.forEach(item => {
                total += +item.qtn * +item.price || 0
                taxs += +item.value || 0
            });

            let taxSource = $('.tax_value').html();

            $('.safe').text(+total.toFixed(2));
            $('.tax_value_plus').html(+taxs.toFixed(2));
            let safeTotal = (+taxs + +total) - +taxSource;
            $('.nettotal_inovice').html(safeTotal);
        }

        function handelTax(event) {
            let total = $('.safe').html();
            let val = event.target.value;

            let tax = 0;
            if (+val != 0) {
                tax = (+total * +val) / 100;
                $('.tax_value').html(+tax);

            } else {
                $('.tax_value').html(0);
            }
            getTotal()
        }

        let CalcRate = (id) => {
            let added = $(`.added-${id}`).val();
            let total = $(`.total-${id}`).val();

            let value = (total * added) / 100;
            value = +value.toFixed(4);
            $(`.rate-${id}`).val(value);
            let item = Rows.find(el => el.id == id);
            item.value = value;

            let rateVal = $(`.rate-${id}`).val();

            let nettotal = +total + +rateVal;
            nettotal = +nettotal.toFixed(4);
            $(`.nettotal-${id}`).val(nettotal);
        }

        let DeleteRow = id => {
            Rows = Rows.filter(el => el.id !== id);
            $(`.Item-${id}`).remove();
        }
    </script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/Salles/SellOrder/create.blade.php ENDPATH**/ ?>