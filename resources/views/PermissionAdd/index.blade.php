@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> اذن اضافة </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left font-main"> Salles Returned </h6>
                <a href="{{ route('permission_add.create') }}" class="{{ $orders->add == 0 ? 'd-none' : '' }} btn btn-primary font-main btn-sm float-right"
                    data-toggle="tooltip" data-placement="bottom" title="Add Purchases">
                    <i class="fas fa-plus" style="font-size: 10px"></i> اضافة
                </a>
            </div>








            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="salesInvoice-dataTable" dir="rtl" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th> No </th>
                                <th> التاريخ </th>
                                <th> المصدر </th>
                                <th> رقم المصدر </th>
                                <th> العميل </th>
                                {{-- <th> المبلغ المدفوع </th>
                            <th> طريقة الدفع </th> --}}
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody class="bodyTableSales">
                            @foreach ($Invoices as $Invoice)
                                <tr class="text-center font-main">
                                    <td>{{ $Invoice->num }}</td>
                                    <td>{{ $Invoice->created_at }}</td>
                                    <td>{{ $Invoice->source }}</td>
                                    <td>{{ $Invoice->source_num }}</td>
                                    <td>
                                        @if ($customers->find($Invoice->customerId))
                                            {{ $customers->find($Invoice->customerId)->name }}
                                        @else
                                            {{ $suppliers->find($Invoice->customerId)->name }}
                                        @endif
                                    </td>
                                    {{-- <td>
                                    {{ $Invoice->netTotal }}
                                </td>
                                <td> كاش </td> --}}
                                    {{-- <td>

                                    <form method="POST" action="{{ route('permission_add.delete', [$Invoice->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn" data-id={{ $Invoice->id }}
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td> --}}
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
