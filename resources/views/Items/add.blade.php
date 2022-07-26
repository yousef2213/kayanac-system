@extends('dashboard.master')

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-11 mx-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end font-main p-2">
                        <li class="breadcrumb-item active" aria-current="page"> اضافة صنف </li>
                        <li class="breadcrumb-item"><a href="/erp/public/items"> الاصناف </a></li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                    </ol>
                </nav>



                <div class="card">
                    <h5 class="card-header">Add Item</h5>
                    <div class="card-body font-main">
                        <form method="post" dir="rtl" action="{{ route('items.store') }}" autocomplete="off"
                            enctype="multipart/form-data">
                            <input type="hidden" name="list[]" id="hidenValue">

                            {{ csrf_field() }}


                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group text-right">
                                        <label class="col-form-label">الاسم بالعربي</label>
                                        <input type="text" name="namear" value="{{ old('namear') }}"
                                            class="form-control">
                                        @error('namear')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group text-right">
                                        <label class="col-form-label">الاسم بالانجليزي</label>
                                        <input type="text" name="nameen" value="{{ old('nameen') }}"
                                            class="form-control">
                                        @error('nameen')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group text-right">
                                        <label class="col-form-label">نوع التكويد</label>
                                        <select name="coding_type" class="form-control" dir="rtl">
                                            <option value={{ null }}> --- </option>
                                            <option value="EGS"> EGS </option>
                                            <option value="ES1"> ES1 </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group text-right">
                                        <label class="col-form-label"> CODE </label>
                                        <input type="text" name="code" class="form-control">
                                        @error('code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group text-right">
                                        <label class="col-form-label">المجموعة</label>
                                        <select name="group" class="form-control chosen-select" tabindex="4" dir="rtl">
                                            <option value={{ null }}> --- </option>
                                            @foreach ($groups as $item)
                                                <option value={{ $item->id }}> {{ $item->namear }} </option>
                                            @endforeach
                                        </select>
                                        @error('group')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    {{-- <div class="form-group text-right">
                                        <label class="col-form-label">قياس الكمية</label>
                                        <input type="text" name="quantityM" value="{{ old('quantityM') }}" class="form-control">
                                        @error('quantityM')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group text-right">
                                        <label class="col-form-label">نوع الصنف</label>
                                        <select name="item_type" class="form-control chosen-select" tabindex="4" dir="rtl">
                                            <option value="0"> --- </option>
                                            <option value="1" selected> مخزنى </option>
                                            <option value="2"> تصنيع </option>
                                            <option value="3"> خدمه </option>
                                        </select>
                                        @error('group')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group text-right">
                                        <label class="col-form-label">نسبة الضريبة</label>
                                        <input type="number" name="taxRate" value="{{ old('taxRate') }}"
                                            class="form-control">
                                        @error('taxRate')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group text-right">
                                        <label class="col-form-label"> عمولة المندوب </label>
                                        <input type="number" name="delegateC" value="{{ old('delegateC') }}"
                                            class="form-control">
                                        @error('delegateC')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-12 col-md-6">
                                    <div class="form-group text-right">
                                        <label class="col-form-label">بيان</label>
                                        <textarea name="description" value="{{ old('description') }}" class="form-control"></textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 text-right">
                                    <div class="form-check form-check-inline mt-5 text-right align-self-center">
                                        <input class="form-check-input" type="checkbox" name="priceWithTax"
                                            id="priceWithTax" value="1">
                                        <label class="form-check-label mr-2" for="priceWithTax"> السعر شامل الضريبة</label>
                                    </div>
                                </div>
                            </div>



                            <div class="col-12 px-0">

                                <table class="table table-striped table-bordered mt-5">
                                    <thead class="btn-primary">
                                        <tr>
                                            <th scope="col"> الوحدة </th>
                                            <th scope="col"> اصغر وحدة </th>
                                            <th scope="col"> التعبئة </th>
                                            <th scope="col"> باركود </th>
                                            <th scope="col"> السعر </th>
                                            <th scope="col"> مقدار الخصم </th>
                                            <th scope="col"> نسبة الخصم </th>
                                            <th scope="col"> السعر بعد الخصم </th>
                                            <th class="td-style">
                                                <button class="btn btn-success" type="button" onclick="addRow()"> +
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodysItems">

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
                    <td class="px-0">
                        <select name="unit_id" onchange="handelUnit(event,'${id}')" class="form-control chosen-select">
                            <option value="null"> --- </option>
                            @foreach ($units as $unit)
                                <option value={{ $unit->id }}> {{ $unit->namear }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-0">
                        <select name="samll_unit" onchange="handelSmallUnit(event,'${id}')" class="form-control chosen-select">
                            <option value="null"> --- </option>
                                <option value="1"> اصغر وحدة </option>
                        </select>
                    </td>

                    <td class="px-0">
                        <input type="number" name="packing" onkeyup="handelPacking(event,'${id}')" class="form-control qtn-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="barcode" onkeyup="handelBarcode(event,'${id}')" class="form-control price-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" step="0.1" name="price" onkeyup="handelPrice(event,'${id}')" class="form-control dis-${id}" />
                    </td>
                    <td class="px-0price
                    </td>
                    <td class="px-0">
                        <input type="number" step="0.1" name="discount_value" onkeyup="handelDiscountValue(event,'${id}')" value="0" class="form-control added-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" step="0.1"  name="discount_rate" onkeyup="handelDiscountRate(event,'${id}')" value="0" class="form-control rate-${id}" />
                    </td>
                       <td class="px-0">
                        <input type="number" step="0.1"  name="total" onkeyup="handelTotal(event,'${id}')" value="0" class="form-control rate-${id}" />
                    </td>
                    <td>
                        <button class="btn btn-danger"onclick="DeleteRow('${id}')" type="button"> - </button>
                    </td>
                </tr>
                `;
            $('#bodysItems').append(item);
        }

        const handelUnit = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.unit_id = event.target.value;
        }
        const handelSmallUnit = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.small_unit = event.target.value;
        }
        const handelBarcode = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.barcode = event.target.value;
        }
        const handelPacking = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.packing = event.target.value;
        }

        const handelPrice = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.price = event.target.value;
        }
        const handelTotal = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.total = event.target.value;
        }
        const handelDiscountValue = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.discount_value = event.target.value;
        }
        const handelDiscountRate = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.discount_rate = event.target.value;
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
