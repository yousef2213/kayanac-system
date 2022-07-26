@extends('dashboard.master')

@section('main-content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة قيد </li>
            <li class="breadcrumb-item"><a href="/erp/public/daily_restrictions"> القيود اليومية </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>

    @if (\Session::has('faild'))
        <div class="alert alert-danger">
            <ul style="list-style: none;text-align: right">
                <li class="font-main text-right">{!! \Session::get('faild') !!}</li>
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="{{ route('daily.update', $invoice->id) }}" autocomplete="off"
                enctype="multipart/form-data">
                <input type="hidden" name="list[]" id="hidenValue">

                {{ csrf_field() }}


                <div class="row py-2 text-right">
                    <div class="col-12 col-md-6 mx-auto">
                        <label> رقم القيد </label>
                        <input type="text" autocomplete="off" disabled name="id" value="{{ $invoice->id }}"
                            class="form-control" />
                    </div>
                    <div class="col-12 col-md-6 mx-auto">
                        <label> التاريخ </label>
                        <input type="datetime-local" autocomplete="off" name="date" class="form-control" />
                    </div>
                </div>

                <div class="row py-2 text-right">
                    <div class="col-12 col-md-6 mx-auto">
                        <label class="col-form-label">الفرع</label>
                        <select name="branshId" class="form-control chosen-select" dir="rtl">
                            @foreach ($branches as $branche)
                                <option value={{ $branche->id }}
                                    {{ $branche->id == $invoice->branshId ? 'selected' : '' }}> {{ $branche->namear }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 mx-auto">
                        <label> مستند </label>
                        <input type="text" autocomplete="off" name="document" value="{{ $invoice->document }}"
                            class="form-control" />
                    </div>
                </div>

                <div class="row py-2 text-right">
                    <div class="col-12 col-md-6">
                        <label> وصف </label>
                        <textarea name="description" class="form-control" cols="20"
                            rows="5"> {{ $invoice->description }} </textarea>
                    </div>

                    <div class="col-12 col-md-4">
                        <table class="table table-border">
                            <thead class="text-center">
                                <tr>
                                    <th colspan="2" style="font-size: 15px">اجماليات</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td colspan="1" style="font-size: 15px"> اجمالي المدين </td>
                                    <td colspan="1" style="font-size: 15px" class="md"> {{ $invoice->debtor }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 15px"> اجمالي الدائن </td>
                                    <td style="font-size: 15px" class="da"> {{ $invoice->creditor }} </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 15px"> الفرق </td>
                                    <td style="font-size: 15px" class="def">
                                        {{ $invoice->debtor - $invoice->creditor }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="col-12 px-0">



                    <table class="table table-striped table-bordered mt-5">
                        <thead class="btn-primary">
                            <tr>
                                <th style="width: 300px"> اسم الحساب </th>
                                <th> مدين </th>
                                <th> دائن </th>
                                <th> بيان </th>
                                <th>
                                    <button class="btn btn-success" type="button" onclick="addRow()"> + </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="bodys">
                            @foreach ($invoices as $invoiceItem)
                                <tr class="Item-{{ $invoiceItem->id }}">
                                    <td class="px-0">
                                        <select class="form-control chosen-select w-100"
                                            onchange="handelAccount(event,'{{ $invoiceItem->id }}')">
                                            <option value="null"> --- </option>
                                            @foreach ($accounts as $account)
                                                <option value={{ $account->account_id }}
                                                    {{ $account->account_id == $invoiceItem->account_id ? 'selected' : '' }}>
                                                    {{ $account->name }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-0">
                                        <input type="number" name="debtor"
                                            onkeyup="handeldebtor(event,'{{ $invoiceItem->id }}')"
                                            value="{{ $invoiceItem->debtor }}"
                                            class="form-control debtor-{{ $invoiceItem->id }}" />
                                    </td>
                                    <td class="px-0">
                                        <input type="number" name="creditor"
                                            onkeyup="handelcreditor(event,'{{ $invoiceItem->id }}')"
                                            value="{{ $invoiceItem->creditor }}"
                                            class="form-control creditor-{{ $invoiceItem->id }}" />
                                    </td>
                                    <td class="px-0">
                                        <input type="text" name="desc"
                                            onkeyup="handeldesc(event,'{{ $invoiceItem->id }}')"
                                            value="{{ $invoiceItem->description }}"
                                            class="form-control dis-{{ $invoiceItem->id }}" />
                                    </td>

                                    <td>
                                        <button class="btn btn-danger" onclick="DeleteRowDB('{{ $invoiceItem->id }}')"
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
        let Rows = {!! json_encode($invoices->toArray()) !!};;

        const addRow = () => {
            let id = IDGenertaor();
            Rows.push({
                id
            });
            let item = `
                <tr class="Item-${id}">
                    <td class="px-0">
                        <input list="accounts" class="form-control" name="account_id" onchange="handelAccount(event,'${id}')" >
                            <datalist id="accounts">
                                @foreach ($accounts as $account)
                                    <option value={{ $account->account_id }}> {{ $account->name }} </option>
                                @endforeach
                            </datalist>

                    </td>
                    <td class="px-0">
                        <input type="number" name="debtor" onkeyup="handeldebtor(event,'${id}')"  value="0" class="form-control debtor-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="creditor" onkeyup="handelcreditor(event,'${id}')" value="0" class="form-control creditor-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="text" name="desc" onkeyup="handeldesc(event,'${id}')"  class="form-control dis-${id}" />
                    </td>

                    <td>
                        <button class="btn btn-danger"onclick="DeleteRow('${id}')" type="button"> - </button>
                    </td>
                </tr>
                `;
            $('#bodys').append(item);
        }

        const handelAccount = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.account_id = event.target.value;
        }
        const handelItem = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.itemId = event.target.value;
        }
        const handeldebtor = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.debtor = event.target.value;
            Calc(id, event.target.value);
        }
        const handelcreditor = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.creditor = event.target.value;
            Calc(id, event.target.value);
        }
        const handeldesc = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.description = event.target.value;
        }
        const handelTotal = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.desc = event.target.value;
        }

        const onSubmit = (event) => {
            event.preventDefault();
            Rows.forEach(item => {
                item.isNew = !Number.isInteger(item.id);
            });
            $('#hidenValue').val(JSON.stringify(Rows))
            $('form').submit()
        }
        let IDGenertaor = function() {
            return '_' + Math.random().toString(36).substr(2, 10);
        };
        let Calc = (id) => {
            getTotal()
        }

        function getTotal() {
            let totalMd = 0;
            let totalDa = 0;
            Rows.forEach(item => {
                totalMd += +item.debtor || 0
                totalDa += +item.creditor || 0
            });
            $('.md').text(Number(totalMd).toFixed(2));
            $('.da').text(Number(totalDa).toFixed(2));
            $('.def').text(Number(totalMd - totalDa).toFixed(2));
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
    </script>
      <script>
        let DeleteRowDB = async (id) => {
            swal("هل انت متاكد من حذف هذا السطر").then(res => {
                if (res) {
                    fetch('/erp/public/daily_restrictions/deleteRow/' + id).then(response => response.json())
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
