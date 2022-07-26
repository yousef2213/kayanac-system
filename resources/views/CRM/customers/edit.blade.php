@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> تعديل عميل </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>



        <div class="company text-right font-ar">
            <div class="container-fluid py-4">
                <div class="row mx-0 font-main">
                    <div class="col-12 mx-auto px-0">
                        <form dir="rtl" method="post" action="{{ route('crm-customers.update', $custom->id) }}">
                            {{ csrf_field() }}
                            @method('PATCH')

                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>الكود</label>
                                    <input type="number" disabled value="{{ $custom->code }}" class="form-control" />
                                </div>
                                <div class="col-12 col-md-6 mx-auto">

                                    <div class="form-group">
                                        <label for="status" class="col-form-label">المجموعة</label>
                                        <select name="group" class="form-control">
                                            <option value="0" {{ $custom->group == '0' ? 'selected' : '' }}>---</option>
                                            <option value="1" {{ $custom->group == '1' ? 'selected' : '' }}>مجموعة رئيسية
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                            </div>

                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>الاسم بالعربي</label>
                                    <input type="text" name="namear" value="{{ $custom->name }}" class="form-control" />
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>الاسم بالانجليزي</label>
                                    <input type="text" name="nameen" value="{{ $custom->name }}" class="form-control" />
                                </div>
                            </div>


                            <div class="row py-2 font-main">
                                <div class="col-12 col-md-6 mx-auto">
                                    <div class="form-group">
                                        <label class="col-form-label">المندوب</label>
                                        <select name="employee" class="form-control chosen-select">
                                            @foreach ($employees as $employee)
                                                <option value={{ $employee->id }}> {{ $employee->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mx-auto py-2">
                                    <label> رقم التسجيل بضريبة القيمة المضافة </label>
                                    <input type="number" name="numRegister" value="{{ $custom->VATRegistration }}"
                                        class="form-control" />
                                </div>
                                <div class="col-12 col-md-6 mx-auto py-2">
                                    <label>تلفون</label>
                                    <input type="number" name="phone" value="{{ $custom->phone }}"
                                        class="form-control" />
                                </div>
                                <div class="col-12 col-md-6 py-2">
                                    <label>رقم الهوية</label>
                                    <input type="number" name="IdentificationNumber"
                                        value="{{ $custom->IdentificationNumber }}" class="form-control" />
                                </div>

                                <div class="col-12 col-md-6 py-2">
                                    <label> العنوان </label>
                                    <input autocomplete="off" type="text" value="{{ $custom->address }}" name="address"
                                        class="form-control" />
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="submiting d-flex mt-4">
                                <button type="submit" class="btn btn-primary mx-2 px-4 font-main"> تعديل </button>
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
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script>
        $('#user-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [6, 7]
            }]
        });

        // Sweet alert

        function deleteData(id) {

        }
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            })
        })
    </script>
@endpush
