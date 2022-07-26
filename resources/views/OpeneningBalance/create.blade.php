@extends('dashboard.master')

@section('main-content')
   <div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة رصيد افتتاحي </li>
            <li class="breadcrumb-item"><a href="/erp/public/ItemsPurchases"> المخازن </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>


    <div class="card">
        <h5 class="card-header">Add Balance</h5>
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="{{ route('opening_balance.store') }}" autocomplete="off"
                enctype="multipart/form-data">
                <input type="hidden" name="list[]" id="hidenValue">

                {{ csrf_field() }}


                <div class="row py-2 text-right">
                    <div class="col-12 col-md-6">
                        <label> المخزن </label>
                        <select name="store_id" class="form-control chosen-select" tabindex="4" dir="rtl">
                            @foreach ($stores as $store)
                                <option value={{ $store->id }}> {{ $store->namear }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>




                <div class="col-12 px-0">
                    <table class="table table-striped table-bordered mt-5">
                        <thead class="btn-primary">
                            <tr>
                                <th> الصنف </th>
                                <th> الوحدة </th>
                                <th class="td-style"> الكمية </th>
                                <th class="td-style"> سعر التكلفة </th>
                                <th class="td-style"> الخصم % </th>
                                {{-- <th class="td-style"> الاجمالي بعد الخصم </th> --}}
                                {{-- <th class="td-style"> قيمة مضافة % </th> --}}
                                {{-- <th class="td-style"> قيمة ضريبة </th> --}}
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
    <link href="{{ asset('boot5/bootstrap.min.css') }}" rel="stylesheet">
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

        const addRow = () => {
            let id = IDGenertaor();
            Rows.push({
                id
            });
            let item = `
                <tr class="Item-${id}">
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
                        <input type="number" name="qtn" step="0.1" value="0" onkeyup="handelQtn(event,'${id}')" class="form-control qtn-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="price" step="0.1" value="0" onkeyup="handelPrice(event,'${id}')" class="form-control price-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="discount" step="0.1" value="0" onkeyup="handelDiscount(event,'${id}')" class="form-control dis-${id}" />
                    </td>

                    <td class="px-0">
                        <input type="number" disabled onkeyup="handelNetTotal(event,'${id}')" class="form-control nettotal-${id}" />
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
            $(`.nettotal-${id}`).val(total);
            CalcRate(id)

        }

        let CalcRate = (id) => {
            // let added = $(`.added-${id}`).val();
            // let total = $(`.nettotal-${id}`).val();

            // let value = (total * added) / 100;
            // $(`.rate-${id}`).val(value);

            // let rateVal = $(`.rate-${id}`).val();

            // let nettotal = +total + +rateVal;
            // $(`.nettotal-${id}`).val(total);
        }

        let DeleteRow = id => {
            Rows = Rows.filter(el => el.id !== id);
            $(`.Item-${id}`).remove();
        }
    </script>


@endpush

{{--
<td class="px-0">
    <input type="number" disabled name="total" step="0.1" onchange="handelTotal(event,'${id}')" value="0" class="form-control total-${id}" />
</td>
<td class="px-0">
    <input type="number" name="added" step="0.1" onkeyup="handelAdded(event,'${id}')" value="0" class="form-control added-${id}" />
</td>
<td class="px-0">
    <input type="number" disabled step="0.1" name="taxRate" onkeyup="handeltaxRate(event,'${id}')" value="0" class="form-control rate-${id}" />
</td> --}}
