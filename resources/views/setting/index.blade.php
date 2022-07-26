@extends('dashboard.master')

@section('main-content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اعدادات الطابعة </li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>

    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul style="list-style: none;text-align: right">
                <li class="font-main text-right">{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif



    <div class="container">
        <div class="row">
            <div class="col-12 mx-auto font-main text-right py-4">
                <form method="POST" dir="rtl" action="{{ route('printer.setting.store') }}">

                    @csrf

                    <div class="form-group">
                        <label for=""> اسم طابعة الكاشير </label>
                        <input type="text" name="printcasher" value="{{ $setting->printcasher }}" class="form-control" />
                        @error('printcasher')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for=""> اسم طابعة المطبخ </label>
                        <input type="text" name="printkitchen" value="{{ $setting->printkitchen }}"
                            class="form-control" />
                        @error('printkitchen')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for=""> اسم طابعة التقارير </label>
                        <input type="text" name="printReports" value="{{ $setting->printReports }}"
                            class="form-control" />
                        @error('printReports')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-check my-4">
                        <input class="form-check-input" type="checkbox" {{ $company->printFront == 1 ? 'checked' : '' }}
                            name="printFront" id="defaultCheck1">
                        <label class="form-check-label mx-3" for="defaultCheck1">
                            الطباعة من الفرونت
                        </label>
                    </div>

                    <div class="form-check my-4">
                        <input class="form-check-input" type="checkbox" {{ $setting->print_qr == 1 ? 'checked' : '' }}
                            name="print_qr" id="print_qr">
                        <label class="form-check-label mx-3" for="print_qr">
                            طباعة qr
                        </label>
                    </div>

                    <button class="btn btn-success"> حفظ </button>
                </form>
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
        $(document).ready(function() {
            $('#users-dataTable').DataTable();
        });
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
