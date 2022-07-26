@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> تعديل عرض سعر </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>



        <div class="card">
            <h5 class="card-header">Add Invoice</h5>
            <div class="card-body font-main">

                <form dir="rtl" method="post" action="{{ route('offer-price.update', $invocie->id) }}" autocomplete="off"
                    enctype="multipart/form-data">

                    <input type="hidden" name="list[]" id="hidenValue">

                    {{ csrf_field() }}
                    @method('PATCH')


                    <div class="row py-2 text-right">
                        <div class="col-12 col-md-6 mx-auto">
                            <label> رقم الفاتورة </label>
                            <input type="text" autocomplete="off" disabled value="{{ $invocie->id }}" name="id"
                                class="form-control" />
                        </div>
                        <div class="col-12 col-md-6 mx-auto">
                            <label> تاريخ الفاتورة </label>
                            <input type="datetime-local" autocomplete="off" value="{{ $invocie->created_at }}"
                                name="dateInvoice" class="form-control" />
                        </div>

                    </div>

                    <div class="row py-2 text-right">
                        <div class="col-12 col-md-6 mx-auto">
                            <label> العميل </label>
                            <select name="customerId" class="form-control chosen-select" tabindex="4" dir="rtl">
                                @foreach ($customers as $supplier)
                                    <option value={{ $supplier->id }}
                                        {{ $invocie->customerId == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 mx-auto">
                            <label class="col-form-label">الفرع</label>
                            <select name="branchId" class="form-control chosen-select" tabindex="4" dir="rtl">
                                @foreach ($branches as $branche)
                                    <option value={{ $branche->id }}
                                        {{ $invocie->branchId == $branche->id ? 'selected' : '' }}>
                                        {{ $branche->namear }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-6 my-2">
                            <label> مركز التكلفة </label>
                            <select name="costCenter" class="form-control chosen-select" tabindex="4" dir="rtl">
                                <option value={{ null }}> --- </option>
                                @foreach ($costCenters as $costCenter)
                                    <option value={{ $costCenter->id }}
                                        {{ $costCenter->id == $invocie->cost_center ? 'selected' : '' }}>
                                        {{ $costCenter->namear }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label> نوع الدفع </label>
                            <select name="payment" class="form-control" tabindex="4" dir="rtl">
                                <option value="1" {{ $invocie->status == '3' ? 'selected' : '' }}> كاش </option>
                                <option value="2" {{ $invocie->status == 2 ? 'selected' : '' }}> اجل </option>
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
                                <?php
                                $total = 0;
                                $discounts = 0;
                                $taxs = 0;
                                $total1 = 0;
                                $total2 = 0;
                                ?>

                                <?php
                                $totalVoice = 0;
                                $totalTax = 0;
                                $totalNet = 0;
                                ?>
                                @foreach ($invoiceList as $invoiceItem)
                                    <?php
                                    $totalVoice += $invoiceItem->total;
                                    $totalTax += $invoiceItem->value;
                                    $totalNet += $invoiceItem->nettotal;
                                    ?>
                                    <?php
                                    $total += $invoiceItem->qtn * $invoiceItem->price;
                                    $total1 += $invoiceItem->total;
                                    $total2 += $invoiceItem->value;
                                    $discounts += $invoiceItem->discountValue;
                                    $taxs += $invoiceItem->value;
                                    ?>
                                    <tr class="Item-{{ $invoiceItem->id }}">
                                        <input type="hidden" name="listUpdate[{{ $invoiceItem->id }}][id]"
                                            value="{{ $invoiceItem->id }}">

                                        <td class="px-0">
                                            <select name="listUpdate[{{ $invoiceItem->id }}][storeId]"
                                                onchange="handelStore(event,'{{ $invoiceItem->id }}')"
                                                class="form-control chosen-select">
                                                <option value="null"> --- </option>
                                                @foreach ($stores as $store)
                                                    <option value={{ $store->id }}
                                                        {{ $invoiceItem->storeId == $store->id ? 'selected' : '' }}>
                                                        {{ $store->namear }} </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-0">
                                            <select name="listUpdate[{{ $invoiceItem->id }}][itemId]"
                                                onchange="handelItem(event,'{{ $invoiceItem->id }}')"
                                                class="form-control chosen-select">
                                                @foreach ($items as $item)
                                                    <option value={{ $item->id }}
                                                        {{ $invoiceItem->item_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->namear }} </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-0">
                                            <select name="listUpdate[{{ $invoiceItem->id }}][unitId]"
                                                onchange="handelUnit(event,'{{ $invoiceItem->id }}')"
                                                class="form-control chosen-select">
                                                @foreach ($units as $unit)
                                                    <option value={{ $unit->id }}
                                                        {{ $invoiceItem->unit_id == $unit->id || $invoiceItem->unitId == $unit->id ? 'selected' : '' }}>
                                                        {{ $unit->namear }} </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-0">
                                            <input type="number" name="listUpdate[{{ $invoiceItem->id }}][qtn]"
                                                onkeyup="handelQtn(event,'{{ $invoiceItem->id }}')"
                                                class="form-control qtn-{{ $invoiceItem->id }}"
                                                value="{{ $invoiceItem->qtn }}" />
                                        </td>
                                        <td class="px-0">
                                            <input type="number" name="listUpdate[{{ $invoiceItem->id }}][price]"
                                                onkeyup="handelPrice(event,'{{ $invoiceItem->id }}')"
                                                class="form-control price-{{ $invoiceItem->id }}"
                                                value="{{ $invoiceItem->price }}" />
                                        </td>
                                        <td class="px-0">
                                            <input type="number" name="listUpdate[{{ $invoiceItem->id }}][discount]"
                                                onkeyup="handelDiscount(event,'{{ $invoiceItem->id }}')"
                                                class="form-control dis-{{ $invoiceItem->id }}"
                                                value="{{ $invoiceItem->discountRate }}" />
                                        </td>
                                        <td class="px-0">

                                            <input type="number" disabled
                                                name="listUpdate[{{ $invoiceItem->id }}][total]"
                                                onchange="handelTotal(event,'{{ $invoiceItem->id }}')"
                                                class="form-control total-{{ $invoiceItem->id }}"
                                                value="{{ $invoiceItem->total - $invoiceItem->discountValue }}" />
                                        </td>
                                        <td class="px-0">
                                            <input type="number" name="listUpdate[{{ $invoiceItem->id }}][added]"
                                                onkeyup="handelAdded(event,'{{ $invoiceItem->id }}')"
                                                class="form-control added-{{ $invoiceItem->id }}"
                                                value="{{ $invoiceItem->rate }}" />
                                        </td>
                                        <td class="px-0">
                                            <input type="number" disabled
                                                name="listUpdate[{{ $invoiceItem->id }}][value]"
                                                onkeyup="handeltaxRate(event,'{{ $invoiceItem->id }}')"
                                                class="form-control rate-{{ $invoiceItem->id }}"
                                                value="{{ $invoiceItem->value }}" />
                                        </td>
                                        <td class="px-0">
                                            <input type="number" disabled
                                                name="listUpdate[{{ $invoiceItem->id }}][nettotal]"
                                                onkeyup="handelNetTotal(event,'{{ $invoiceItem->id }}')"
                                                class="form-control nettotal-{{ $invoiceItem->id }}"
                                                value="{{ $invoiceItem->nettotal }}" />
                                        </td>

                                        <td class="px-0">
                                            <input type="number" disabled
                                                name="listUpdate[{{ $invoiceItem->id }}][description]"
                                                onkeyup="handelNetTotal(event,'{{ $invoiceItem->id }}')"
                                                class="form-control description-{{ $invoiceItem->id }}"
                                                value="{{ $invoiceItem->description }}" />
                                        </td>

                                        <td>
                                            <button class="btn btn-danger"
                                                onclick="DeleteRowDB('{{ $invoiceItem->id }}')" type="button"> -
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
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
                                    <td colspan="1" style="font-size: 15px" class="safe"> {{ $totalVoice }}
                                    </td>
                                </tr>
                                @if ($company->tax_source != 0)
                                    <tr>
                                        <td style="font-size: 15px"> ضريبة خصم المنبع % </td>
                                        <td style="font-size: 15px" class="text-center" class="da">
                                            <input type="number" name="taxSource" onkeyup="handelTax(event)"
                                                class="form-control text-center d-inline-block"
                                                value="{{ $invocie->taxSource }}" style="width: 100px" id="taxSource"
                                                step="0.1">
                                            <input type="hidden" name="taxSourceValue"
                                                class="form-control text-center d-inline-block" id="taxSourceValue"
                                                style="width: 100px" step="0.1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 15px"> قيمة ضريبة المنبع </td>
                                        <td style="font-size: 15px" class="tax_value">
                                            {{ ($totalVoice * $invocie->taxSource) / 100 }}</td>
                                    </tr>
                                @endif

                                <tr>
                                    <td style="font-size: 15px"> قيمة ضريبة المضافة </td>
                                    <td style="font-size: 15px" class="tax_value_plus"> {{ $totalTax }} </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 15px"> اجمالي </td>
                                    <td style="font-size: 15px" class="nettotal_inovice">
                                        {{ $total - $discounts + $taxs - $invocie->taxSouceValue }} </td>
                                </tr>

                                <tr>
                                    <td style="font-size: 15px"> قيمة الخصم الاضافي </td>
                                    <td style="font-size: 15px" class="text-center" class="da">
                                        <input type="number" name="discountAdded" onkeyup="handelDiscountAdded(event)"
                                            class="form-control text-center d-inline-block disAded"
                                            value="{{ $invocie->discount_added }}" style="width: 100px" step="0.1">
                                        <input type="hidden" name="" class="form-control text-center d-inline-block" id=""
                                            style="width: 100px" step="0.1">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 15px"> الصافي النهائي </td>
                                    <td style="font-size: 15px" class="ended"> {{ $invocie->netTotal }} </td>
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
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('boot5/bootstrap.min.css') }}">
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
@endpush
@push('scripts')

    <script>
        let total_invoice = 0;
        let date = new Date();
        let year = date.getFullYear();
        let month = date.getMonth();
        let day = date.getDay();
        let hours = date.getHours();
        let minutes = date.getMinutes();
        let seconds = date.getSeconds();
        let Rows = [];
        let itemList = {!! json_encode($invoiceList->toArray()) !!};
        Rows = itemList;
        const addRow = () => {
            let id = IDGenertaor();
            Rows.push({
                id
            });
            let item = `
            <tr class="Item-${id}">
                <td class="px-0">
                    <select name="storeId" onchange="handelStore(event,'${id}')" class="form-control chosen-select">
                        <option value="null"> -- </option>
                        @foreach ($stores as $store)
                            <option value={{ $store->id }}> {{ $store->namear }} </option>
                        @endforeach
                    </select>
                </td>
                <td class="px-0">
                    <input list="itemId" class="form-control" onchange="handelItem(event,'${id}')">
                    <datalist id="itemId">
                        @foreach ($items as $item)
                            <option value={{ $item->id }}> {{ $item->namear }} </option>
                        @endforeach
                    </datalist>
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
        const handelItem = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.itemId = event.target.value;
            $.ajax({
                type: 'GET',
                url: "/erp/public/getUnits/" + event.target.value,
                data: {
                    _token: "{{ csrf_token() }}",
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
            handelTax()
        }
        const handelPrice = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.price = event.target.value;
            Calc(id, event.target.value);
            handelTax()
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
            $taxV = $('.tax_value').html();
            $('#taxSourceValue').val(+$taxV);
            Rows.forEach(item => {
                if (!item.itemId) item.itemId = item.item_id;
                if (!item.item_id) item.item_id = item.itemId;

                if (!item.unitId) item.unitId = item.unit_id;
                if (!item.unit_id) item.unit_id = item.unitId;
                if (!item.discount) item.discount = item.discountRate;
                item.isNew = !Number.isInteger(item.id);
            });
            $('#hidenValue').val(JSON.stringify(Rows))
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
            let item = Rows.find(el => el.id == id);
            item.discountValue = discountValue;
            total = +total.toFixed(2);
            $(`.total-${id}`).val(total);
            CalcRate(id)
            getTotal(id)
        }

        function getTotal() {
            let total = 0;
            let taxs = 0;
            let disv = 0;
            Rows.forEach(item => {
                total += +item.qtn * +item.price || 0
                taxs += +item.value || 0
                disv += +item.discountValue
            });

            let taxSource = $('.tax_value').html();

            $('.safe').text(+total.toFixed(2));
            $('.tax_value_plus').html(+taxs.toFixed(2));
            let safeTotal = (+taxs + +total) - +taxSource - disv;
            $('.nettotal_inovice').html(safeTotal);
        }

        function handelDiscountAdded(event) {
            let total = $('.nettotal_inovice').html();
            let val = event.target.value;
            $('.ended').html(+(total - val).toFixed(4))
            getTotal()
        }

        function handelTax(event) {
            let total = $('.safe').html();
            let val = event ? event.target.value : $('#taxSource').val();

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


        let Check = () => {
            let all = [...$('select')];
            all.forEach(item => {
                item.classList.add('chosen');
            })
        }
    </script>
    <script>
        let DeleteRowDB = async (id) => {
            swal("هل انت متاكد من حذف هذا السطر").then(res => {
                if (res) {
                    fetch('/erp/public/offer-price/deleteRow/' + id).then(response => response.json())
                        .then(data => {
                            if (data.status == 200) {
                                Rows = Rows.filter(el => el.id != id);
                                $(`.Item-${data.id}`).remove();
                                getTotal()
                                handelTax()
                            }
                        });
                }
            })
        }
    </script>

@endpush
