@extends('dashboard.master')

@section('main-content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> تعديل فاتورة </li>
            <li class="breadcrumb-item"><a href="/erp/public/ItemsPurchases"> مشتريات </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>



    <div class="card">
        <h5 class="card-header">Add Invoice</h5>
        <div class="card-body font-main">

            <form dir="rtl" method="post" action="{{ route('ItemsPurchases.update', $purchase->id) }}" autocomplete="off"
                enctype="multipart/form-data">

                <input type="hidden" name="list[]" id="hidenValue">

                {{ csrf_field() }}
                @method('PATCH')


                <div class="row py-2 text-right">
                    <div class="col-12 col-md-6 mx-auto">
                        <label> رقم الفاتورة </label>
                        <input type="text" autocomplete="off" disabled value="{{ $purchase->id }}" name="id"
                            class="form-control" />
                    </div>
                    <div class="col-12 col-md-6 mx-auto">
                        <label> تاريخ الفاتورة </label>
                        <input type="datetime-local" autocomplete="off" value="{{ $purchase->dateInvoice }}"
                            name="dateInvoice" class="form-control" />
                    </div>
                </div>

                <div class="row py-2 text-right">
                    <div class="col-12 col-md-6 mx-auto">
                        <label> المورد </label>
                        <select name="supplier" class="form-control chosen-select" tabindex="4" dir="rtl">
                            @foreach ($suppliers as $supplier)
                                <option value={{ $supplier->id }}
                                    {{ $purchase->supplier == $supplier->id ? 'selected' : '' }}> {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 mx-auto">
                        <label> رقم فاتورة المورد </label>
                        <input type="text" autocomplete="off" value="{{ $purchase->supplier_invoice }}"
                            name="supplier_invoice" class="form-control" />
                    </div>
                </div>

                <div class="row py-2 text-right">
                    <div class="col-12 col-md-6 mx-auto">
                        <label> نوع الدفع </label>
                        <select name="payment" class="form-control" tabindex="4" dir="rtl">
                            <option value="1" {{ $purchase->payment == '1' ? 'selected' : '' }}> كاش </option>
                            <option value="2" {{ $purchase->payment == '2' ? 'selected' : '' }}> اجل </option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 mx-auto">
                        <label class="col-form-label">الفرع</label>
                        <select name="branchId" class="form-control chosen-select" tabindex="4" dir="rtl">
                            @foreach ($branches as $branche)
                                <option value={{ $branche->id }}
                                    {{ $purchase->branchId == $branche->id ? 'selected' : '' }}>
                                    {{ $branche->namear }} </option>
                            @endforeach
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
                                <th class="td-style">
                                    <button class="btn btn-success" type="button" onclick="addRow()"> + </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="bodys">
                            @foreach ($purchaseList as $purchaseitem)
                                <tr class="Item-{{ $purchaseitem->id }}">
                                    <input type="hidden" name="listUpdate[{{ $purchaseitem->id }}][id]" value="{{ $purchaseitem->id }}">

                                    <td class="px-0">
                                        <select name="listUpdate[{{ $purchaseitem->id }}][storeId]" onchange="handelStore(event,'{{ $purchaseitem->id }}')" class="form-control chosen-select">
                                            <option value="null"> --- </option>
                                            @foreach ($stores as $store)
                                                <option value={{ $store->id }} {{ $purchaseitem->storeId == $store->id ? 'selected' : '' }}> {{ $store->namear }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-0">
                                        <select name="listUpdate[{{ $purchaseitem->id }}][itemId]" onchange="handelItem(event,'{{ $purchaseitem->id }}')" class="form-control chosen-select">
                                            @foreach ($items as $item)
                                                <option value={{ $item->id }} {{ $purchaseitem->itemId == $item->id ? 'selected' : '' }}> {{ $item->namear }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-0">
                                        <select name="listUpdate[{{ $purchaseitem->id }}][unitId]" onchange="handelUnit(event,'{{ $purchaseitem->id }}')" class="form-control chosen-select">
                                            @foreach ($units as $unit)
                                                <option value={{ $unit->id }} {{ $purchaseitem->unitId == $unit->id ? 'selected' : '' }}> {{ $unit->namear }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-0">
                                        <input type="number" name="listUpdate[{{ $purchaseitem->id }}][qtn]" onkeyup="handelQtn(event,'{{ $purchaseitem->id }}')" class="form-control qtn-{{ $purchaseitem->id }}" value="{{ $purchaseitem->qtn }}" />
                                    </td>
                                    <td class="px-0">
                                        <input type="number" name="listUpdate[{{ $purchaseitem->id }}][price]" onkeyup="handelPrice(event,'{{ $purchaseitem->id }}')" class="form-control price-{{ $purchaseitem->id }}" value="{{ $purchaseitem->price }}" />
                                    </td>
                                    <td class="px-0">
                                        <input type="number" name="listUpdate[{{ $purchaseitem->id }}][discount]" onkeyup="handelDiscount(event,'{{ $purchaseitem->id }}')" class="form-control dis-{{ $purchaseitem->id }}" value="{{ $purchaseitem->discountRate }}" />
                                    </td>
                                    <td class="px-0">
                                        <input type="number" disabled name="listUpdate[{{ $purchaseitem->id }}][total]" onchange="handelTotal(event,'{{ $purchaseitem->id }}')" class="form-control total-{{ $purchaseitem->id }}" value="{{ $purchaseitem->total - $purchaseitem->discountValue }}" />
                                    </td>
                                    <td class="px-0">
                                        <input type="number" name="listUpdate[{{ $purchaseitem->id }}][added]" onkeyup="handelAdded(event,'{{ $purchaseitem->id }}')" class="form-control added-{{ $purchaseitem->id }}" value="{{ $purchaseitem->rate }}" />
                                    </td>
                                    <td class="px-0">
                                        <input type="number" disabled name="listUpdate[{{ $purchaseitem->id }}][value]" onkeyup="handeltaxRate(event,'{{ $purchaseitem->id }}')" class="form-control rate-{{ $purchaseitem->id }}" value="{{ $purchaseitem->value }}" />
                                    </td>
                                    <td class="px-0">
                                        <input type="number" disabled  name="listUpdate[{{ $purchaseitem->id }}][nettotal]" onkeyup="handelNetTotal(event,'{{ $purchaseitem->id }}')" class="form-control nettotal-{{ $purchaseitem->id }}" value="{{ $purchaseitem->nettotal }}" />
                                    </td>

                                    <td>
                                        <button class="btn btn-danger" onclick="DeleteRow('{{ $purchaseitem->id }}')"
                                            type="button"> -
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
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


@endsection

@push('styles')
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
        let Rows = [];
        let itemList = {!! json_encode($itemsList->toArray()) !!};

        const addRow = () => {
            let id = IDGenertaor();
            Rows.push({
                id
            });
            let item = `
                <tr class="Item-${id}">
                    <td class="px-0">
                        <select name="storeId" onchange="handelStore(event,'${id}')" class="form-control chosen-select">
                            <option value="null"> --- </option>
                            @foreach ($stores as $store)
                                <option value={{ $store->id }}> {{ $store->namear }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-0">
                        <select name="itemId" onchange="handelItem(event,'${id}')" class="form-control chosen-select">
                            <option value="null"> --- </option>
                            @foreach ($items as $item)
                                <option value={{ $item->id }}> {{ $item->namear }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-0">
                        <select name="unitId" onchange="handelUnit(event,'${id}')" class="form-control chosen-select">
                            <option value="null"> --- </option>
                            @foreach ($units as $unit)
                                <option value={{ $unit->id }}> {{ $unit->namear }} </option>
                            @endforeach
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
                        <input type="number" disabled name="total" onchange="handelTotal(event,'${id}')" value="0" class="form-control total-${id}" />
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

                    <td>
                        <button class="btn btn-danger"onclick="DeleteRow('${id}')" type="button"> - </button>
                    </td>
                </tr>
                `;
            $('#bodys').append(item);
        }

        const handelStore = (event, id) => {
            let item = Rows.find(el => el.id == id);
            if (item) {
                item.storeId = event.target.value;
                Calc(id, event.target.value);
            } else {
                Calc(id, event.target.value);
            }
        }
        const handelItem = (event, id) => {
            let item = Rows.find(el => el.id == id);
            if (item) {
                item.itemId = event.target.value;
                Calc(id, event.target.value);
            } else {
                Calc(id, event.target.value);
            }
        }
        const handelQtn = (event, id) => {
            let item = Rows.find(el => el.id == id);
            if (item) {
                item.qtn = event.target.value;
                Calc(id, event.target.value);
            } else {
                Calc(id, event.target.value);
            }
        }
        const handelPrice = (event, id) => {
            let item = Rows.find(el => el.id == id);
            if (item) {
                item.price = event.target.value;
                Calc(id, event.target.value);
            } else {
                Calc(id, event.target.value);
            }
        }
        const handelDiscount = (event, id) => {
            let item = Rows.find(el => el.id == id);
            if (item) {
                item.discount = event.target.value;
                Calc(id, event.target.value);
            } else {
                Calc(id, event.target.value);
            }
        }
        const handelTotal = (event, id) => {
            let item = Rows.find(el => el.id == id);
            if (item) {
                item.total = event.target.value;
                Calc(id, event.target.value);
            } else {
                Calc(id, event.target.value);
            }
        }
        const handelAdded = (event, id) => {
            let item = Rows.find(el => el.id == id);
            if (item) {
                item.added = event.target.value;
                CalcRate(id, event.target.value);
            } else {
                CalcRate(id, event.target.value);
            }
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
            $('form').submit()
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
            $(`.total-${id}`).val(total);
            CalcRate(id)
        }

        let CalcRate = (id) => {
            let added = $(`.added-${id}`).val();
            let total = $(`.total-${id}`).val();

            let value = (total * added) / 100;
            value = value.toFixed(4)
            $(`.rate-${id}`).val(value  || 0);

            let rateVal = $(`.rate-${id}`).val();

            let nettotal = +total + +rateVal;
            nettotal = nettotal.toFixed(4);
            $(`.nettotal-${id}`).val(nettotal);
        }

        let DeleteRow = id => {
            Rows = Rows.filter(el => el.id !== id);
            $(`.Item-${id}`).remove();
        }
    </script>


@endpush
