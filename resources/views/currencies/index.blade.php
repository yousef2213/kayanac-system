@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main p-2">
                <li class="breadcrumb-item active" aria-current="page"> العملات </li>
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
                <h6 class="m-0 font-weight-bold text-primary float-left"> العملة</h6>
                <a href="{{ route('currencies.create') }}" class="btn {{ $orders->add == 0 ? 'd-none' : '' }} font-main btn-primary btn-sm float-right"
                    data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"
                        style="font-size: 10px"></i> اضافة </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="users-dataTable" dir="rtl" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th>num</th>
                                <th>العملة الكبير</th>
                                <th>العملة الصغري</th>
                                <th>سعر الصرف</th>
                                <th>افتراضي</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($currencies as $currency)
                                <tr class="text-center font-main">
                                    <td>{{ $currency->id }}</td>
                                    <td>{{ $currency->bigar }}</td>
                                    <td>{{ $currency->smallar }}</td>
                                    <td>{{ $currency->rate }}</td>
                                    <td>{{ $currency->main == 1 ? 'العملة الافتراضية' : '' }}</td>

                                    <td>
                                        <a href="{{ route('currencies.edit', $currency->id) }}"
                                            class="btn {{ $orders->edit == 0 ? 'd-none' : '' }} btn-primary btn-sm float-left mr-1" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        @if ($currency->id != 1)
                                            <form method="POST"
                                                action="{{ route('currencies.destroy', [$currency->id]) }}">
                                                @csrf
                                                @method('delete')
                                                <button class="btn {{ $orders->delete == 0 ? 'd-none' : '' }} btn-danger btn-sm dltBtn" data-id={{ $currency->id }}
                                                    data-toggle="tooltip" data-placement="bottom" title="Delete"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

        body {
            color: #555 !important
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
