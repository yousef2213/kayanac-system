@extends('dashboard.master')

@section('main-content')
    <div class="px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> اضافة امر شراء </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>

        @if (\Session::has('msg'))
            <div class="alert alert-success">
                <ul style="list-style: none;text-align: right">
                    <li class="font-main text-right">{!! \Session::get('msg') !!}</li>
                </ul>
            </div>
        @endif
        @if (\Session::has('error'))
            <div class="alert alert-danger">
                <ul style="list-style: none;text-align: right">
                    <li class="font-main text-right">{!! \Session::get('error') !!}</li>
                </ul>
            </div>
        @endif

        <div class="card">
            <h5 class="card-header">Add Invoice</h5>
            <div class="card-body font-main">
                <form method="post" dir="rtl" action="{{ route('purchase-order.store') }}" autocomplete="off"
                    enctype="multipart/form-data">
                    <input type="hidden" name="list[]" id="hidenValue">

                    {{ csrf_field() }}


                    <div class="row py-2 text-right">
                        <div class="col-12 col-md-6 mb-2">
                            <label> رقم الفاتورة </label>
                            <input type="text" autocomplete="off" disabled value="{{ $id }}" name="id"
                                class="form-control" />
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label> تاريخ الفاتورة </label>
                            <input type="datetime-local" autocomplete="off" name="dateInvoice" class="form-control" />
                        </div>

                        <div class="col-12 col-md-6 mb-2">
                            <label> المورد </label>
                            <select name="supplier" class="form-control chosen-select" tabindex="4" dir="rtl">
                                @foreach ($suppliers as $supplier)
                                    <option value={{ $supplier->id }}> {{ $supplier->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label> تاريخ التتبع </label>
                            <input type="datetime-local" autocomplete="off" name="date_follow" class="form-control" />
                        </div>

                        <div class="col-12 col-md-6 mb-2">
                            <label> رقم فاتورة المورد </label>
                            <input type="text" autocomplete="off" name="supplier_invoice" class="form-control" />
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label> نوع الدفع </label>
                            <select name="payment" class="form-control" tabindex="4" dir="rtl">
                                <option value="1"> كاش </option>
                                <option value="2"> اجل </option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 mb-2">
                            <label class="col-form-label">الفرع</label>
                            <select name="branchId" class="form-control chosen-select" tabindex="4" dir="rtl">
                                @foreach ($branches as $branche)
                                    <option value={{ $branche->id }}> {{ $branche->namear }} </option>
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
                                @if ($company->tax_source != 0)
                                    <tr>
                                        <td style="font-size: 15px"> ضريبة خصم المنبع % </td>
                                        <td style="font-size: 15px" class="text-center" class="da">
                                            <input type="number" name="taxSource" onkeyup="handelTax(event)"
                                                class="form-control text-center d-inline-block" style="width: 100px"
                                                step="0.1">
                                            <input type="hidden" name="taxSourceValue"
                                                class="form-control text-center d-inline-block" id="taxSourceValue"
                                                style="width: 100px" step="0.1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 15px"> قيمة ضريبة المنبع </td>
                                        <td style="font-size: 15px" class="tax_value">00</td>
                                    </tr>
                                @endif

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
                        <button type="reset" class="btn btn-warning"> Reset </button>
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
    <script src="{{ asset('boot5/bootstrap.min.js') }}"></script>
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
                        <input type="number" name="qtn" step="0.1" value="0" onkeyup="handelQtn(event,'${id}')" class="form-control qtn-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="price" step="0.1" value="0" onkeyup="handelPrice(event,'${id}')" class="form-control price-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="discount" step="0.1" value="0" onkeyup="handelDiscount(event,'${id}')" class="form-control dis-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" disabled name="total" step="0.1" onchange="handelTotal(event,'${id}')" value="0" class="form-control total-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="added" step="0.1" onkeyup="handelAdded(event,'${id}')" value="0" class="form-control added-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" disabled step="0.1" name="taxRate" onkeyup="handeltaxRate(event,'${id}')" value="0" class="form-control rate-${id}" />
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
            item.storeId = event.target.value;
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
            getTotal()
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
            total = +total.toFixed(2);

            $(`.total-${id}`).val(total);
            CalcRate(id)
            getTotal(id)

        }

        function getTotal() {
            let total = 0;
            let taxs = 0;
            Rows.forEach(item => {
                let discount = +item.discount || 0;
                let calc = +item.qtn * +item.price;
                let discountValue = (calc * discount) / 100 || 0;
                total += calc - discountValue;
                taxs += +item.value || 0
            });



            let taxSource = $('.tax_value').html();
            $('.safe').text(+total.toFixed(2));
            $('.tax_value_plus').html(+taxs.toFixed(2));
            let safeTotal = (+taxs + +total) - +taxSource;
            $('.nettotal_inovice').html(safeTotal);
        }

        function handelTax(event) {
            let val = event.target.value;
            let total = $('.safe').html();

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
            getTotal();
            handelTax()
        }
    </script>


@endpush
{{-- @foreach ($units as $unit)
    <option value={{ $unit->id }}> {{ $unit->namear }} </option>
@endforeach --}}