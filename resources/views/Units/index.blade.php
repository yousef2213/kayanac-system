@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> الوحدات </li>
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


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left font-main"> Units </h6>
                <a href="{{ route('units-add') }}" class="{{ $orders->add == 0 ? 'd-none' : '' }} btn btn-primary font-main btn-sm float-right"
                    data-toggle="tooltip" data-placement="bottom" title="Add User">
                    <i class="fas fa-plus" style="font-size: 10px"> </i> اضافة وحدة
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="users-dataTable" dir="rtl" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th>م</th>
                                <th>اسم الصنف</th>
                                <th> نشط </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $item)
                                <tr class="text-center font-main">
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->namear }}</td>
                                    <td>
                                        @if ($item->active == '1')
                                            نشط
                                        @endif
                                        @if ($item->active == '0')
                                            غير نشط
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('units.edit', $item->id) }}"
                                            class="{{ $orders->edit == 0 ? 'd-none' : '' }} btn btn-primary btn-sm float-left mr-1"data-toggle="tooltip"
                                            title="edit" data-placement="bottom">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" class="{{ $orders->delete == 0 ? 'd-none' : '' }}"
                                            action="{{ route('unit.destroy', [$item->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $item->id }}
                                                data-toggle="tooltip" data-placement="bottom" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
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
@endsection

@push('styles')
    <link href="{{ asset('boot5/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
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
