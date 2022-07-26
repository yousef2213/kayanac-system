@extends('dashboard.master')

@section('main-content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> تعديل فرع </li>
            <li class="breadcrumb-item"><a href="/erp/public/branches"> الفروع </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>
    <div class="company text-right font-ar">
        <div class="container-fluid py-4 font-main">
            <div class="row mx-0">
                <div class="col-12 col-md-10 mx-auto px-0">
                    <form dir="rtl" method="POST" action="{{ route('branches.update', $item->id) }}">
                        {{ csrf_field() }}
                        @method('PATCH')
                        <div class="row py-2">
                            <div class="col-12 col-md-6 mx-auto">
                                <label>الاسم بالعربي</label>
                                <input type="text" name="namear" value="{{ $item->namear }}" class="form-control" />
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <label> الاسم بالانجليزي </label>
                                <input type="text" name="nameen" value="{{ $item->nameen }}" class="form-control" />
                            </div>

                            <div class="col-12 col-md-6 mx-auto">
                                <div class="form-group">
                                    <label for="status" class="col-form-label">الشركة</label>
                                    <select name="companyId" class="form-control">
                                        <option value="0">---</option>
                                        @foreach ($companys as $company)
                                            <option value="{{ $company->id }}"
                                                {{ $company->id == $item->companyId ? 'selected' : '' }}>
                                                {{ $company->companyNameAr }} </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <label>المدينة</label>
                                <input type="text" name="city" value="{{ $item->city }}" class="form-control" />
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col-12 col-md-6 mx-auto">
                                <label> كود النشاط </label>
                                <input type="number" step="0.1" value="{{ $item->code_activite }}" name="code_activite"
                                    class="form-control" />
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <label> Activity Code </label>
                                <input type="number" step="0.1" value="{{ $item->activite_code }}" name="activite_code"
                                    class="form-control" />
                            </div>
                        </div>



                        <div class="row py-2">
                            <div class="col-12 col-md-6 mx-auto">
                                <label> المنطقة </label>
                                <input type="text" name="region" value="{{ $item->region }}" class="form-control" />
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <label> الدولة </label>
                                <input type="text" name="country" value="{{ $item->country }}" class="form-control" />
                            </div>
                        </div>

                        <div class="row py-2">
                            <div class="col-12 col-md-6">
                                <label> هاتف </label>
                                <input type="number" name="phone" value="{{ $item->phone }}" class="form-control" />
                            </div>
                            <div class="col-12 col-md-6">
                                <label> العنوان </label>
                                <input autocomplete="off" type="text" value="{{ $item->address }}" name="address"
                                    class="form-control" />

                            </div>

                        </div>






                        <div class="submiting d-flex mt-4">
                            <button type="submit" class="btn btn-primary mx-2 px-4"> تعديل </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
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
