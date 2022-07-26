@extends('dashboard.master')

@section('main-content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"><a href="/erp/public/bond/create">اضافة سند</a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>



    <div class="card">
        <h5 class="card-header">Add Bond</h5>
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="{{ route('bond.store', $type) }}" autocomplete="off"
                enctype="multipart/form-data">
                <input type="hidden" name="list[]" id="hidenValue">

                {{ csrf_field() }}


                <div class="row py-2 text-right">
                    <div class="col-12 col-md-6 mx-auto">
                        <label> رقم الحركة </label>
                        <input type="text" autocomplete="off" disabled value="{{ $id }}" name="id"
                            class="form-control" />
                    </div>
                    <div class="col-12 col-md-6 mx-auto">
                        <label> تاريخ الفاتورة </label>
                        <input type="datetime-local" autocomplete="off" name="date" class="form-control" />
                    </div>
                </div>

                <div class="row py-2 text-right">
                    {{-- <div class="col-12 col-md-6 mx-auto">
                        <label> نوع السند </label>
                        <select name="type" class="form-control chosen-select" dir="rtl">
                            <option value="1"> سند قبض نقدي </option>
                            <option value="2"> سند قبض بنكي </option>
                            <option value="3"> سند صرف نقدي </option>
                            <option value="4"> سند صرف بنكي </option>
                        </select>
                    </div> --}}
                    <div class="col-12 col-md-6 mx-auto">
                        <label> اسم الصندوق </label>
                        <select name="account" class="form-control chosen-select" dir="rtl">
                            @foreach ($accounts as $account)
                                <option value={{ $account->account_id }}> {{ $account->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 mx-auto">
                        <label> الحالة </label>
                        <select name="status" class="form-control chosen-select" dir="rtl">
                            <option value="1">معتمد</option>
                            <option value="0">غير معتمد</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 ">
                        <label> الوصف </label>
                        <textarea name="description" id="" class="form-control" rows="3"></textarea>
                    </div>
                </div>


                <div class="col-12 px-0">


                    <table class="table table-striped table-bordered mt-5">
                        <thead class="btn-primary">
                            <tr>
                                <th> اسم الحساب </th>
                                <th> العملة </th>
                                <th> المبلغ </th>
                                <th> الوصف </th>
                                <th> المندوب </th>
                                <th> مركز التكلفة </th>
                                <th> الرصيد </th>
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
                        <input list="browsers" class="form-control" onchange="handelAccount(event,'${id}')">
                        <datalist id="browsers">
                            @foreach ($accounts as $account)
                                <option value={{ $account->account_id }}> {{ $account->name }} </option>
                            @endforeach
                        </datalist>
                    </td>
                    <td class="px-0">
                        <input list="currencies" class="form-control" onchange="handelCurrency(event,'${id}')">
                        <datalist id="currencies">
                            @foreach ($currencies as $currencie)
                                <option value={{ $currencie->id }}> {{ $currencie->bigar }} </option>
                            @endforeach
                        </datalist>
                    </td>
                    <td class="px-0">
                        <input type="number" name="amount" step="0.1" onkeyup="handelAmount(event,'${id}')" value="0" class="form-control price-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="text" name="desc" onkeyup="handelDesc(event,'${id}')" class="form-control qtn-${id}" />
                    </td>


                    <td class="px-0">
                        <input list="delegate" class="form-control" onchange="handelDelegate(event,'${id}')">
                        <datalist id="delegate">
                            @foreach ($employees as $employee)
                                <option value={{ $employee->id }}> {{ $employee->namear }} </option>
                            @endforeach
                        </datalist>
                    </td>
                    <td class="px-0">
                        <input list="costs" class="form-control" onchange="handelCosts(event,'${id}')">
                        <datalist id="costs">
                            @foreach ($costCenters as $cost)
                                <option value={{ $cost->id }}> {{ $cost->namear }} </option>
                            @endforeach
                        </datalist>
                    </td>

                    <td class="px-0">
                        <input type="number" name="balance" value="0" disabled class="form-control price-${id}" />
                    </td>


                    <td>
                        <button class="btn btn-danger"onclick="DeleteRow('${id}')" type="button"> - </button>
                    </td>
                </tr>
                `;
            $('#bodys').append(item);
            Check()
        }

        const handelAccount = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.account = event.target.value;
        }
        const handelCurrency = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.currency = event.target.value;
        }

        const handelCosts = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.cost_center = event.target.value;
        }
        const handelDelegate = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.delegate = event.target.value;
        }
        const handelAmount = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.amount = event.target.value;
        }
        const handelDesc = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.description = event.target.value;
        }
        const handelPrice = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.price = event.target.value;
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
            $(`.total-${id}`).val(total);
            CalcRate(id)

        }

        let CalcRate = (id) => {
            let added = $(`.added-${id}`).val();
            let total = $(`.total-${id}`).val();

            let value = (total * added) / 100;
            $(`.rate-${id}`).val(value);

            let rateVal = $(`.rate-${id}`).val();

            let nettotal = +total + +rateVal;
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
            console.log(all);
        }
    </script>
@endpush


{{-- <select name="account_id" onchange="handelAccount(event,'${id}')" class="form-control chosen-select">
    <option value="null"> --- </option>
    @foreach ($accounts as $account)
        <option value={{ $account->id }}> {{ $account->name }} </option>
    @endforeach
</select> --}}
