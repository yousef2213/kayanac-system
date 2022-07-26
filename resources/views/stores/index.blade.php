@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> المخازن </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left font-main"> Stores </h6>
                <a href="{{ route('stores.create') }}" class="{{ $orders->add == 0 ? 'd-none' : '' }} btn btn-primary font-main btn-sm float-right"
                    data-toggle="tooltip" data-placement="bottom" title="Add User">
                    <i class="fas fa-plus" style="font-size: 10px"></i> اضافة مخزن </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="users-dataTable" dir="rtl" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th>م</th>
                                <th> الاسم </th>
                                <th> الفرع </th>
                                <th> نشط </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stores as $store)
                                <tr class="text-center font-main">
                                    <td>{{ $store->id }}</td>
                                    <td>{{ $store->namear }}</td>
                                    <td>
                                        @foreach ($branches as $branche)
                                            @if ($branche->id == $store->branchId)
                                                {{ $branche->namear }}
                                            @endif
                                        @endforeach
                                        {{-- {{ $store->branchId }} --}}
                                    </td>
                                    <td>
                                        @if ($store->active == '1')
                                            نشط
                                        @endif
                                        @if ($store->active == '0')
                                            غير نشط
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('stores.edit', $store->id) }}"
                                            class="btn {{ $orders->edit == 0 ? 'd-none' : '' }} btn-primary btn-sm float-left mr-1" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" class="{{ $orders->delete == 0 ? 'd-none' : '' }}" action="{{ route('stores.destroy', [$store->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $store->id }} data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                    <div class="modal fade" id="delModal{{ $store->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="#delModal{{ $store->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="#delModal{{ $store->id }}Label">
                                                        Delete store </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('unit.destroy', $store->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger"
                                                            style="margin:auto; text-align:center">Parmanent delete
                                                            user</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span style="float:right">{{ $stores->links() }}</span>
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
