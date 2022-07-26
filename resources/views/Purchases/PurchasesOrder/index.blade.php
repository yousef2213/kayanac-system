@extends('dashboard.master')

@section('main-content')
    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> امر شراء </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left font-main"> Purchases Order </h6>
                <a href="{{ route('purchase-order.create') }}" class="btn btn-primary font-main btn-sm float-right"
                    data-toggle="tooltip" data-placement="bottom" title="Add Purchases">
                    <i class="fas fa-plus" style="font-size: 10px"></i> اضافة
                </a>
            </div>
            <div class="card-body font-main">
                <div class="table-responsive">
                    <table class="table text-dark table-bordered" id="salesInvoice-dataTable" dir="rtl" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th> رقم الفاتورة </th>
                                <th> اسم المورد </th>
                                <th> رقم فاتورة المورد </th>
                                <th> فرع </th>
                                <th> تاريخ الفاتورة </th>
                                <th> تاريخ التتبع </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="bodyTableSales text-center">
                            @foreach ($purchases as $purchase)
                                <tr>
                                    <td>{{ $purchase->id }}</td>
                                    <td>{{ $suppliers->find($purchase->supplier)->name }}</td>
                                    <td> {{ $purchase->supplier_invoice }} </td>
                                    <td>{{ $branches->find($purchase->branchId)->namear }}</td>
                                    <td> {{ $purchase->dateInvoice }} </td>
                                    <td> {{ \Carbon\Carbon::parse($purchase->date_follow)->diffForHumans() }} </td>
                                    <td>
                                        <a href="{{ route('purchase-order.edit', $purchase->id) }}"
                                            class="btn btn-primary btn-sm float-left mr-1" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST"
                                            action="{{ route('purchase-order.destroy', [$purchase->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $purchase->id }}
                                                data-toggle="tooltip" data-placement="bottom" title="Delete"><i
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
@endsection

@push('styles')
    <link href="{{ asset('boot5/bootstrap.min.css') }}" rel="stylesheet">
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

        function filterDate(event) {
            event.preventDefault();
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
