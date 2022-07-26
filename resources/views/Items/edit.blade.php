@extends('dashboard.master')

@section('main-content')
    <style>
        .chosen-single {
            height: 37px !important;
        }

    </style>
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
            <form method="post" dir="rtl" id="updaingForm" action="{{ route('items.update', $item->id) }}"
                autocomplete="off">
                @csrf
                <input type="hidden" name="list[]" id="hidenUpdated">
                @method('PATCH')
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">الاسم بالعربي</label>
                            <input type="text" name="namear" value="{{ $item->namear }}" class="form-control">
                            @error('namear')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">الاسم بالانجليزي</label>
                            <input type="text" name="nameen" value="{{ $item->nameen }}" class="form-control">
                            @error('nameen')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">نوع التكويد</label>
                            <select name="coding_type" class="form-control">
                                <option value={{ null }}> --- </option>
                                <option value="EGS" {{ $item->coding_type == 'EGS' ? 'selected' : '' }}> EGS </option>
                                <option value="ES1" {{ $item->coding_type == 'ES1' ? 'selected' : '' }}> ES1 </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label"> CODE </label>
                            <input type="text" name="code" value="{{ $item->code }}" class="form-control">
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <?php
                        $groupsList = explode(',', $item->group);
                        ?>
                        <label class="col-form-label">المجموعة</label>
                        <select name="group" class="form-control chosen-select">
                            @foreach ($groups as $key => $element)
                                @if (in_array($element->id, $groupsList))
                                    <option value={{ $element->id }} selected> {{ $element->namear }} </option>
                                @else
                                    <option value={{ $element->id }}> {{ $element->namear }} </option>
                                @endif
                            @endforeach
                        </select>
                        @error('group')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">نوع الصنف</label>
                            <select name="item_type" class="form-control chosen-select">
                                <option value="0" {{ $item->item_type == '0' ? 'selected' : '' }}> --- </option>
                                <option value="1" {{ $item->item_type == '1' ? 'selected' : '' }}> مخزنى </option>
                                <option value="2" {{ $item->item_type == '2' ? 'selected' : '' }}> تصنيع </option>
                                <option value="3" {{ $item->item_type == '3' ? 'selected' : '' }}> خدمه </option>
                            </select>
                            @error('group')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">قياس الكمية</label>
                            <input type="text" name="quantityM" disabled value="{{ $item->quantityM }}"
                                class="form-control">
                            @error('quantityM')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">نسبة الضريبة</label>
                            <input type="number" name="taxRate" value="{{ $item->taxRate }}" class="form-control">
                            @error('taxRate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">

                        <div class="form-group text-right">
                            <label class="col-form-label">نسبة الضريبة</label>
                            <input type="number" name="taxRate" value="{{ $item->taxRate }}" class="form-control">
                            @error('taxRate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">بيان</label>
                            <textarea name="description" class="form-control"> {{ $item->description }} </textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6 text-right">

                        <div class="form-check form-check-inline text-right align-self-center">
                            <input class="form-check-input" type="checkbox"
                                {{ $item->priceWithTax == 1 ? 'checked' : '' }} name="priceWithTax" id="priceWithTax"
                                value="1">
                            <label class="form-check-label mr-2" for="priceWithTax"> السعر شامل الضريبة</label>
                        </div>
                    </div>

                </div>




                <hr>

                <table class="table text-center" dir="rtl">
                    <thead>
                        <tr>
                            <th scope="col"> الوحدات </th>
                            <th scope="col"> التعبئة </th>
                            <th scope="col"> باركود </th>
                            <th scope="col"> السعر </th>
                            <th scope="col"> مقدار الخصم </th>
                            <th scope="col"> نسبة الخصم </th>
                            <th scope="col"> السعر بعد الخصم </th>
                            <th scope="col">
                                <button type="button" class="btn btn-primary btn-first-add" onclick="addItemUnit(1)"> +
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id=bodyUnitsEdit>
                        @foreach ($list as $listItem)
                            @if ($listItem->itemId == $item->id)
                                <tr class="rowUpdate-{{ $listItem->id }}">
                                    <th>
                                        <select name="listUpdate[{{ $listItem->id }}][unit]" id="select-unit-item-0"
                                            class="form-control">
                                            <option value="null"> --- </option>
                                            @foreach ($units as $unit)
                                                <option value={{ $unit->id }}
                                                    {{ $listItem->unitId == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->namear }} </option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <input type="hidden" name="listUpdate[{{ $listItem->id }}][id]"
                                        value="{{ $listItem->id }}">
                                    <td>
                                        <input type="number" name="listUpdate[{{ $listItem->id }}][packing]"
                                            value="{{ $listItem->packing }}" class="form-control packing-Edit-0">
                                    </td>
                                    <td>
                                        <input type="text" name="listUpdate[{{ $listItem->id }}][barcode]"
                                            value="{{ $listItem->barcode }}" class="form-control barcode-Edit-0">
                                    </td>
                                    <td>
                                        <input type="text" name="listUpdate[{{ $listItem->id }}][price1]"
                                            value="{{ $listItem->price1 }}" class="form-control barcode-Edit-0">
                                    </td>
                                    {{-- <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#modalPrice-{{ $listItem->id }}"> السعر </button>
                                    </td> --}}

                                    <td>
                                        <input type="number" disabled class="form-control discountAmount-Edit-0">
                                    </td>
                                    <td>
                                        <input type="number" name="listUpdate[{{ $listItem->id }}][discountPercentage]"
                                            value="{{ $listItem->discountPercentage }}"
                                            class="form-control discountPercentage-Edit-0">
                                    </td>
                                    <td>
                                        <input type="number" name="listUpdate[{{ $listItem->id }}][priceAfterDiscount]"
                                            value="{{ $listItem->priceAfterDiscount }}"
                                            class="form-control priceAfterDiscount-Edit-0">
                                    </td>
                                    <td class="d-flex">
                                        <button type="button" disabled class="btn btn-danger"
                                            onclick="DeleteRow({{ $listItem->id }})"> x </button>
                                    </td>


                                    <div class="modal fade" id="modalPrice-{{ $listItem->id }}" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"> اسعار الصنف </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group text-right">
                                                        <label class="col-form-label"> السعر 1</label>
                                                        <input type="number"
                                                            name="listUpdate[{{ $listItem->id }}][price1]" min="0"
                                                            step="0.1" value="{{ $listItem->price1 }}"
                                                            class="form-control price1-0">
                                                        @error('price1')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group text-right">
                                                        <label class="col-form-label"> السعر 2</label>
                                                        <input type="number"
                                                            name="listUpdate[{{ $listItem->id }}][price2]" min="0"
                                                            step="0.1" value="{{ $listItem->price2 }}"
                                                            class="form-control price2-0">
                                                        @error('price2')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group text-right">
                                                        <label class="col-form-label"> السعر 3</label>
                                                        <input type="number"
                                                            name="listUpdate[{{ $listItem->id }}][price3]" min="0"
                                                            step="0.1" value="{{ $listItem->price3 }}"
                                                            class="form-control price3-0">
                                                        @error('price3')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group text-right">
                                                        <label class="col-form-label"> السعر 4</label>
                                                        <input type="number"
                                                            name="listUpdate[{{ $listItem->id }}][price4]" min="0"
                                                            step="0.1" value="{{ $listItem->price4 }}"
                                                            class="form-control price4-0">
                                                        @error('price4')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group text-right">
                                                        <label class="col-form-label"> السعر 5</label>
                                                        <input type="number"
                                                            name="listUpdate[{{ $listItem->id }}][price5]" min="0"
                                                            step="0.1" value="{{ $listItem->price5 }}"
                                                            class="form-control price5-0">
                                                        @error('price5')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <div class="form-group mb-3 text-right">
                    <button class="btn btn-success px-4" type="button" onclick="clickFun(event)"> Update </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            color: #555
        }

    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });

        let listUnits = [];


        let num = 1;


        function clickFun(event) {
            event.preventDefault();
            $('form#updaingForm').submit();
        }

        function addItemUnit(idx) {
            console.log(idx);
            let unit = $(`#select-unit-item-${idx}`).val();
            let packing = $(`.packing-${idx}`).val();
            let barcode = $(`.barcode-${idx}`).val();
            let price1 = $(`.price1-${idx}`).val();
            let price2 = $(`.price2-${idx}`).val();
            let price3 = $(`.price3-${idx}`).val();
            let price4 = $(`.price4-${idx}`).val();
            let price5 = $(`.price5-${idx}`).val();
            let discountAmount = $(`.discountAmount-${idx}`).val();
            let discountPercentage = $(`.discountPercentage-${idx}`).val();
            let priceAfterDiscount = $(`.priceAfterDiscount-${idx}`).val();
            let obj = {
                unit,
                packing,
                barcode,
                price1,
                price2,
                price3,
                price4,
                price5,
                discountAmount,
                discountPercentage,
                priceAfterDiscount
            };

            listUnits.push(obj);
            $('#hidenUpdated').val(JSON.stringify(listUnits))
            num += 1;



            let modalHtml = `
                    <div class="modal fade" id="modalPrice${num}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" > اسعار الصنف</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group text-right">
                                        <label class="col-form-label"> السعر 1</label>
                                        <input type="number" name="price1" min="0" step="0.1" class="form-control price1-${num}">
                                    </div>
                                    <div class="form-group text-right">
                                        <label class="col-form-label"> السعر 2</label>
                                        <input type="number" name="price2" min="0" step="0.1" class="form-control price2-${num}">
                                    </div>
                                    <div class="form-group text-right">
                                        <label class="col-form-label"> السعر 3</label>
                                        <input type="number" name="price3" min="0" step="0.1" class="form-control price3-${num}">
                                    </div>
                                    <div class="form-group text-right">
                                        <label class="col-form-label"> السعر 4</label>
                                        <input type="number" name="price4" min="0" step="0.1" class="form-control price4-${num}">
                                    </div>
                                    <div class="form-group text-right">
                                        <label class="col-form-label"> السعر 5</label>
                                        <input type="number" name="price5" min="0" step="0.1" class="form-control price5-${num}">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                `
            $('#bodyUnitsEdit').append(modalHtml);

            let row = `
                <tr  id="row${num}">
                    <th>
                        <select name="unit" id="select-unit-item-${num}" class="form-control">
                            <option value="null"> --- </option>
                            @foreach ($units as $unit)
                                <option value={{ $unit->id }}> {{ $unit->namear }} </option>
                            @endforeach
                        </select>
                    </th>
                    <td>
                        <input type="number" name="packing" class="form-control packing-${num}">
                    </td>
                    <td>
                        <input type="text" name="barcode" class="form-control barcode-${num}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-price-${num}" data-toggle="modal" data-target="#modalPrice${num}"> السعر </button>
                    </td>
                    <td>
                        <input type="number" disabled name="discountAmount" class="form-control discountAmount-${num}">
                    </td>
                    <td>
                        <input type="number" name="discountPercentage" class="form-control discountPercentage-${num}">
                    </td>
                    <td>
                        <input type="number" name="priceAfterDiscount" class="form-control priceAfterDiscount-${num}">
                    </td>
                    <td class="d-flex">
                        <button type="button" class="btn btn-primary" onclick="addItemUnit(${num})" > + </button>
                        <button type="button" class="btn btn-danger" onclick="DeleteRow(${num})"> x </button>
                    </td>
                </tr>
                `
            $('#bodyUnitsEdit').append(row);
        }


        function submitList(event) {
            event.preventDefault();
            let namear = $('[name=namear]').val();
            let nameen = $('[name=nameen]').val();
            let group = $('[name=group]').val();
            let quantityM = $('[name=quantityM]').val();
            let taxRate = $('[name=taxRate]').val();
            let priceWithTax = $('[name=priceWithTax]').val();
            let description = $('[name=description]').val();
            let img = $('[name=img]');

            $.ajax({
                method: 'post',
                url: "items/store",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: 123
                },
                success: function(data) {
                    console.log(data);
                }
            });
        }



        // done version
        function DeleteRow(id) {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: 'post',
                            url: "/itemlist/delete",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            },
                            success: function(data) {
                                if (data.status == 200) {
                                    swal("Removed Done!");
                                    window.location.reload();
                                    $(`.rowUpdate-${id}`).remove();
                                }

                            }
                        });
                    } else {
                        swal("Your data is safe!");
                    }
                });
            // $(`#row${id}`).remove();

        }

        function DeleteRowAdded(id) {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $(`#row${id}`).remove()
                    } else {
                        swal("Your data is safe!");
                    }
                });
            // $(`#row${id}`).remove();

        }
    </script>
@endpush
