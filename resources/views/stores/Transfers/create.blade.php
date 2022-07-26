@extends('dashboard.master')

@section('main-content')
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
                <form method="post" dir="rtl" action="{{ route('Transfers.store') }}" autocomplete="off"
                    enctype="multipart/form-data">
                    <input type="hidden" name="list[]" id="hidenValue">

                    {{ csrf_field() }}


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
                                    <option value={{ null }}> --- </option>
                                    @foreach ($branches as $branche)
                                        <option value={{ $branche->id }}> {{ $branche->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label">المخزن المحول منة </label>
                                <select name="storeId1" class="form-control  branches" id="storeId1">
                                    <option value={{ null }}> --- </option>

                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label"> المخزن المستلم </label>
                                <select name="storeId2" class="form-control ">
                                    <option value={{ null }}> --- </option>
                                    @foreach ($stores as $store)
                                        <option value={{ $store->id }}> {{ $store->namear }} </option>
                                    @endforeach
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
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('boot5/bootstrap.min.css') }}">

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
                    <td class="px-0 d-flex align-items-center">
                        <input list="itemId" style="width:40%" class="form-control" onchange="handelItem(event,'${id}','ss')">
                        <datalist id="itemId">
                            @foreach ($items as $item)
                                <option value={{ $item->id }} dataName={{ $item->namear }}> {{ $item->namear }} </option>
                            @endforeach
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
            let items = {!! json_encode($items->toArray()) !!};
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
                    _token: "{{ csrf_token() }}",
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
@endpush
{{-- <td class="px-0">
    <input type="text" disabled name="cost" class="form-control text-center cost-${id}" />
</td> --}}
