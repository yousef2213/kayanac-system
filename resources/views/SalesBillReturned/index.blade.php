@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main p-2">
                <li class="breadcrumb-item active" aria-current="page"> مرتجع المبيعات </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left font-main"> Salles Returned </h6>
                <a href="{{ route('SallesReturned.create') }}"
                    class="{{ $orders->add == 0 ? 'd-none' : '' }} btn btn-primary font-main btn-sm float-right"
                    data-toggle="tooltip" data-placement="bottom" title="Add Purchases">
                    <i class="fas fa-plus" style="font-size: 10px"></i> اضافة
                </a>
            </div>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="salesInvoice-dataTable" dir="rtl" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th> رقم الفاتورة </th>
                                <th> التاريخ </th>
                                <th> العميل </th>
                                <th> الصافي </th>
                                <th> طريقة الدفع </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="bodyTableSales">
                            @foreach ($Invoices as $Invoice)
                                <tr class="text-center font-main">
                                    <td>{{ $Invoice->id }}</td>
                                    <td>{{ $Invoice->created_at }}</td>
                                    <td>
                                        {{ $customers->find($Invoice->customerId)->name }}
                                    </td>
                                    <td>
                                        {{ $Invoice->netTotal }}
                                    </td>
                                    <td> كاش </td>
                                    <td>
                                        <a href="{{ route('SallesReturned.edit', $Invoice->id) }}"
                                            class="btn btn-primary btn-sm float-left mr-1 {{ $orders->edit == 0 ? 'd-none' : '' }}"
                                            data-toggle="tooltip" title="edit" data-placement="bottom"><i
                                                class="fas fa-edit"></i></a>
                                        <form method="POST" class="{{ $orders->delete == 0 ? 'd-none' : '' }}"
                                            action="{{ route('SallesReturned.delete', [$Invoice->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $Invoice->id }}
                                                data-toggle="tooltip" data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                    <div class="modal fade" id="delModal{{ $Invoice->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="#delModal{{ $Invoice->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="#delModal{{ $Invoice->id }}Label"> Delete
                                                        item </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post"
                                                        action="{{ route('SallesReturned.delete', $Invoice->id) }}">
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

                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src=" {{ asset('js/sweetalert.min.js') }} "></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#salesInvoice-dataTable').DataTable();
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
