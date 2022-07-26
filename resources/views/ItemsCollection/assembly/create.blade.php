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
                <form method="post" dir="rtl" action="{{ route('assembly.store') }}" autocomplete="off"
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
                                <label class="col-form-label">الاصناف </label>
                                <select name="itemId" class="form-control chosen-select" onchange="handelItemBasic(event)">
                                    <option value={{ null }}> --- </option>
                                    @foreach ($items as $item)
                                        <option value={{ $item->id }}> {{ $item->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label">المخزن </label>
                                <select name="storeId" class="form-control chosen-select" onchange="handelItemBasic(event)">
                                    <option value={{ null }}> --- </option>
                                    @foreach ($stores as $store)
                                        <option value={{ $store->id }}> {{ $store->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label">مكونات الاصناف </label>
                                <select class="form-control chosen-select" onchange="handelItem(event)">
                                    <option value={{ null }}> --- </option>
                                    @foreach ($itemsCreate as $item)
                                        <option value={{ $item->id }}> {{ $item->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label"> الكمية </label>
                                <input type="number" name="qttn" step="0.1" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label"> الوصف </label>
                                <textarea name="description" class="form-control" cols="5"></textarea>
                            </div>
                        </div>
                        {{-- <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label">مكونات الاصناف </label>
                                <select class="form-control chosen-select" onchange="handelItem(event)">
                                    <option value={{ null }}> --- </option>
                                    @foreach ($itemsCreate as $item)
                                        <option value={{ $item->id }}> {{ $item->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
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
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('boot5/bootstrap.min.css') }}">


    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
 --}}


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

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    $(function() {
       $('#datetimepicker').datetimepicker();
    });
</script> --}}


    <script>
        let Rows = [];

        const addRow = (res, check) => {

            if (check) {
                $('#bodysItemsCollection').html('');
                res.list.forEach(row => {
                    let id = IDGenertaor();
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
                let balacne = res.list.find(el => el.small != null).balance ? res.list.find(el => el.small != null).balance.qtn : 0;
                console.log(balacne);
                console.log(res);
                let item = `
                <tr class="Item-${id}">

                    <td class="px-0">
                        <input type="text" name="item" disabled class="form-control item-${id}" value="${res.item.namear}" />
                    </td>
                    <td class="px-0">
                        <select name="unit_id" onchange="handelUnit(event,'${id}')" class="form-control chosen-select">
                            <option value="null"> --- </option>
                            ${res.list.map(row => ` <option value='${row.unitId}' ${res.list.find(el => el.small != null).unitId == row.unitId ? "selected" : ""}> ${row.unit_name} </option> ` )}
                        </select>
                    </td>
                    <td class="px-0">
                        <input type="number" name="balacne"  disabled value=${balacne / res.list.find(el => el.small != null).packing} class="form-control balacne-${id} text-center" />
                    </td>

                    <td class="px-0">
                        <input type="number" name="qtn" onkeyup="handelQtn(event,'${id}')" class="form-control qtn-${id}" />
                    </td>

                    <td class="px-0">
                        <input type="number" name="cost" disabled value=${res.list.find(el => el.small != null).cost} onkeyup="handelCost(event,'${id}')" class="form-control cost-${id} text-center" />
                    </td>

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
@endpush
