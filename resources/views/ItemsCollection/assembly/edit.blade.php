@extends('dashboard.master')

@section('main-content')
    <style>
        .chosen-container {
            height: 37px !important;
            width: 100% !important;
        }

    </style>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> تعديل صنف </li>
                <li class="breadcrumb-item"><a href="/erp/public/items"> الاصناف </a></li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>



        <div class="card">
            <h5 class="card-header">Update Item</h5>
            <div class="card-body font-main">
                <form method="post" dir="rtl" id="updaingForm" action="{{ route('items-collection.update', $item->id) }}"
                    autocomplete="off">
                    {{ csrf_field() }}
                    @method('PATCH')

                    <input type="hidden" name="list[]" id="hidenValue">

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label">الاصناف </label>
                                <select name="itemId" class="form-control chosen-select">
                                    <option value={{ null }}> --- </option>
                                    @foreach ($items as $product)
                                        <option value={{ $product->id }}
                                            {{ $item->itemId == $product->id ? 'selected' : '' }}>
                                            {{ $product->namear }} </option>
                                    @endforeach
                                </select>
                                @error('group')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                    </div>



                    <hr>

                    <table class="table text-center" dir="rtl">
                        <thead class="btn-primary">
                            <tr>
                                <th scope="col" class="py-1"> الصنف </th>
                                <th scope="col" class="py-1"> الوحدة </th>
                                <th scope="col" class="py-1"> الكمية </th>
                                <th class="td-style py-1">
                                    <button class="btn btn-success" type="button"> ... </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id=bodysItemsCollection>
                            @foreach ($list as $item)
                                <tr class="Item-{{ $item->id }}">
                                    <td class="px-0">
                                        <input type="text" disabled value="{{ $item->item_name }}"
                                            class="form-control packing-Edit-0">
                                    </td>
                                    <td class="px-0">
                                        <select name="unit_id" onchange="handelUnit(event,'{{ $item->id }}')"
                                            class="form-control chosen-select w-100">
                                            <option value="null"> --- </option>
                                            @foreach ($item->units as $unit)
                                                <option value='{{ $unit->unitId }}'
                                                    {{ $item->unitId == $unit->unitId ? 'selected' : '' }}>
                                                    {{ $unit->unit_name }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-0">
                                        <input type="text" onkeyup="handelQtn(event,'{{ $item->id }}')"
                                            value="{{ $item->qtn }}" class="form-control barcode-Edit-0">
                                    </td>

                                    <td class="px-0">
                                        <button type="button" class="btn btn-danger"
                                            onclick="DeleteRowDB({{ $item->id }})"> x </button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="form-group mb-3 text-right">
                        <button class="btn btn-success px-4" type="button" onclick="onSubmit(event)"> Update </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('boot5/bootstrap.min.css') }}">
@endpush

@push('scripts')
    <script>
        let Rows = {!! json_encode($list->toArray()) !!};
        const addRow = (res) => {
            let id = IDGenertaor();
            Rows.push({
                id
            });
            let row = Rows.find(el => el.id == id);
            row.itemId = res.item.id;
            let item = `
                <tr class="Item-${id}">

                    <td class="px-0">
                        <input type="text" name="item" disabled class="form-control item-${id}" value="${res.item.namear}" />
                    </td>

                    <td class="px-0">
                        <select name="unit_id" onchange="handelUnit(event,'${id}')" class="form-control chosen-select">
                            <option value="null"> --- </option>
                            ${res.list.map(row => ` <option value='${row.unitId}'> ${row.unit_name} </option> ` )}
                    </select>

                    </td>

                    <td class="px-0">
                        <input type="number" name="qtn" onkeyup="handelQtn(event,'${id}')" class="form-control qtn-${id}" />
                    </td>


                    <td>
                        <button class="btn btn-danger"onclick="DeleteRow('${id}')" type="button"> - </button>
                    </td>
                </tr>
                `;
            $('#bodysItemsCollection').append(item);
        }

        const handelItem = async (event) => {
            const req = await fetch("/erp/public/get-item-collection/" + event.target.value);
            const res = await req.json();
            addRow(res)
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
            Rows.forEach(item => {
                item.isNew = !Number.isInteger(item.id);
            });
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
    <script>
        let DeleteRowDB = async (id) => {
            swal("هل انت متاكد من حذف هذا السطر").then(res => {
                if (res) {
                    fetch('/erp/public/collection/deleteRow/' + id).then(response => response.json())
                        .then(data => {
                            if (data.status == 200) {
                                Rows = Rows.filter(el => el.id != id);
                                $(`.Item-${data.id}`).remove();
                            }
                        });
                }
            })
        }
    </script>
@endpush
