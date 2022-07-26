@extends('dashboard.master')

@section('main-content')


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> مجموعة الميزانية العمومية </li>
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


    <div class="card shadow mb-4 font-main">
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left"> مجموعة الميزانية العمومية </h6>
            <a href="{{ route('accounts.balanceSheetGroup.create') }}" class="btn  font-main btn-primary btn-sm float-right"
                data-toggle="tooltip" data-placement="bottom" title="Add Branches"><i class="fas fa-plus"
                    style="font-size: 10px"></i> اضافة </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{-- <table class="table table-bordered" id="branches-dataTable" dir="rtl" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center font-main">
                            <th> {{ __('pos.Num') }} </th>
                            <th> {{ __('pos.nameBranch') }} </th>
                            <th> {{ __('pos.city') }} </th>
                            <th> {{ __('pos.Region') }} </th>
                            <th> {{ __('pos.addess') }} </th>
                            <th> {{ __('pos.phone') }} </th>
                            <th> {{ __('pos.edit') }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($branches as $branche)
                            <tr class="text-center font-main">
                                <td>{{ $branche->id }}</td>
                                <td>{{ $branche->namear }}</td>
                                <td>{{ $branche->city }}</td>
                                <td>{{ $branche->region }}</td>
                                <td>{{ $branche->address }}</td>
                                <td>{{ $branche->phone }}</td>
                                <td>
                                    <a href="{{ route('branches.edit', $branche->id) }}"
                                        class="btn btn-primary btn-sm float-left mr-1"
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                        data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{ route('branches.destroy', [$branche->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn" data-id={{ $branche->id }}
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                                <div class="modal fade" id="delModalCustomer{{ $branche->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="#delModalCustomer{{ $branche->id }}Label"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="#delModalCustomer{{ $branche->id }}Label">
                                                    Delete user </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post"
                                                    action="{{ route('customers.destroy', $branche->id) }}">
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
                <span style="float:right">{{ $branches->links() }}</span> --}}
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
        // $('#branches-dataTable').DataTable({
        //     "columnDefs": [{
        //         "orderable": false,
        //         "targets": [6, 7]
        //     }]
        // });
        $(document).ready(function() {
            $('#branches-dataTable').DataTable();
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
