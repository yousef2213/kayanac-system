@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main p-2">
                <li class="breadcrumb-item active" aria-current="page"> {{ __('pos.users') }} </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">{{ __('pos.main') }}</a></li>
            </ol>
        </nav>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left font-main">{{ __('pos.users') }}</h6>
                <a href="{{ route('users.create') }}"
                    class="{{ $orders->add == 0 ? 'd-none' : '' }} btn font-main btn-primary btn-sm float-right"
                    data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"
                        style="font-size: 10px"></i> {{ __('pos.addUser') }} </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="users-dataTable" dir="rtl" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th>م</th>
                                <th>{{ __('pos.name') }}</th>
                                <th>{{ __('pos.email') }}</th>
                                <th>{{ __('pos.validity') }} </th>
                                <th>{{ __('pos.status') }}</th>
                                <th style="max-width: 100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                @if ($user->name != 'super_erp' && $user->name != 'super_mostafa')
                                    <tr class="text-center font-main">
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->role == '1')
                                                مستخدم عادي
                                            @endif
                                            @if ($user->role == '3')
                                                مسؤل
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->status == 'active')
                                                <span class="badge badge-success">{{ $user->status }}</span>
                                            @else
                                                <span class="badge badge-warning">{{ $user->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @if (Auth::user()->role == 3)
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-primary btn-sm mx-2" data-toggle="tooltip"
                                                        title="edit" data-placement="bottom">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="{{ $orders->edit == 0 ? 'd-none' : '' }} btn btn-primary btn-sm mx-2"
                                                        data-toggle="tooltip" title="edit" data-placement="bottom">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif

                                                @if (Auth::user()->role == 3)
                                                    {{-- User Permision --}}
                                                    <a href="{{ route('users.permision', $user->id) }}"
                                                        class="btn btn-info btn-sm mx-2" data-toggle="tooltip"
                                                        title="permision" data-placement="bottom">
                                                        <i class="fa fa-user"></i>
                                                    </a>
                                                @endif

                                                @if (Auth::user()->role == 3)
                                                    <form method="POST"
                                                        action="{{ route('users.destroy', [$user->id]) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger mx-2 btn-sm dltBtn"
                                                            data-id={{ $user->id }} data-toggle="tooltip"
                                                            data-placement="bottom" title="Delete"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                @else
                                                    <form method="POST"
                                                        class="{{ $orders->delete == 0 ? 'd-none' : '' }}"
                                                        action="{{ route('users.destroy', [$user->id]) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger mx-2 btn-sm dltBtn"
                                                            data-id={{ $user->id }} data-toggle="tooltip"
                                                            data-placement="bottom" title="Delete"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <span style="float:right">{{ $users->links() }}</span>
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
