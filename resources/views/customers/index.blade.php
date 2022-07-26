@extends('dashboard.master')

@section('main-content')
    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main p-2">
                <li class="breadcrumb-item active" aria-current="page"> {{ __('pos.customers') }} </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">{{ __('pos.main') }}</a></li>
            </ol>
        </nav>
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul style="list-style: none;text-align: right">
                    <li class="font-main text-right">{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif



        <div class="card shadow mb-4">
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left font-main"> {{ __('pos.customers') }} </h6>
                <a href="{{ route('customers.create') }}" class="btn {{ $orders->add == 0 ? 'd-none' : '' }} font-main btn-primary btn-sm float-right"
                    data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"
                        style="font-size: 10px"></i> {{ __('pos.addCustomer') }} </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="user-dataTable" dir="rtl" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th> {{ __('pos.Num') }} </th>
                                <th>{{ __('pos.name') }}</th>
                                <th>{{ __('pos.deleg') }}</th>
                                <th>{{ __('pos.group') }}</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr class="text-center font-main">
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->delegName }}</td>
                                    <td>{{ $customer->group }}</td>

                                    <td class="text-center">
                                        <a href="{{ route('customers.edit', $customer->id) }}"
                                            class="{{ $orders->edit == 0 ? 'd-none' : '' }} btn btn-primary btn-sm float-left mr-1" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" class="{{ $orders->delete == 0 ? 'd-none' : '' }}" action="{{ route('customers.destroy', [$customer->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $customer->id }}
                                                data-toggle="tooltip" data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span style="float:right">{{ $customers->links() }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('boot5/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    {{-- <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

    </style> --}}
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script> --}}
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
