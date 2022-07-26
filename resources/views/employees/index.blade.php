@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end font-main p-2">
                        <li class="breadcrumb-item active" aria-current="page"> الموظفين </li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">{{ __('pos.main') }}</a></li>
                    </ol>
                </nav>

                @if (\Session::has('msg'))
                    <div class="alert alert-success">
                        <ul style="list-style: none;text-align: right">
                            <li class="font-main text-right">{!! \Session::get('msg') !!}</li>
                        </ul>
                    </div>
                @endif
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 font-main">
                        <h6 class="m-0 font-weight-bold text-primary float-left">الموظفين</h6>
                        <a href="{{ route('employees.create') }}" class="btn  font-main btn-primary btn-sm float-right"
                            data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"
                                style="font-size: 10px"></i> اضافة </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="users-dataTable" dir="rtl" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center font-main">
                                        <th>Num</th>
                                        <th>الاسم</th>
                                        <th>الفرع</th>
                                        <th>الوظيفة</th>
                                        <th>حالة</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        <tr class="text-center font-main">
                                            <td>{{ $employee->id }}</td>
                                            <td>{{ $employee->namear }}</td>
                                            <td>{{ $employee->barnch_name }}</td>
                                            <td>{{ $employee->occupation }}</td>
                                            <td>{{ $employee->status_type }}</td>

                                            <td>
                                                <a href="{{ route('employees.edit', $employee->id) }}"
                                                    class="btn btn-primary btn-sm float-left mr-1" data-toggle="tooltip"
                                                    title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                                <form method="POST"
                                                    action="{{ route('employees.destroy', [$employee->id]) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm dltBtn"
                                                        data-id={{ $employee->id }} data-toggle="tooltip"
                                                        data-placement="bottom" title="Delete"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('boot5/bootstrap.min.css') }}" rel="stylesheet">
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
