@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main p-2">
                <li class="breadcrumb-item active" aria-current="page"> رصيد افتتاحي للحسابات </li>
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


        <div class="row">
            <div class="col-12 col-md-6 font-main"></div>
            <div class="col-12 col-md-6 font-main">
                <table class="table table-border">
                    <thead class="text-center">
                        <tr>
                            <th colspan="2" style="font-size: 15px">اجماليات</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <td colspan="1" style="font-size: 15px"> اجمالي المدين </td>
                            <td colspan="1" style="font-size: 15px" class="md text-success">
                                {{ isset($invoice) ? $invoice->debtor : 0 }} </td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px"> اجمالي الدائن </td>
                            <td style="font-size: 15px" class="da text-danger">
                                {{ isset($invoice) ? $invoice->creditor : 0 }} </td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px"> الفرق </td>
                            <td style="font-size: 15px" class="def">
                                {{ isset($invoice) ? $invoice->debtor - $invoice->creditor : 0 }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left font-main"> رصيد افتتاحي </h6>
                @if ($show == 1)
                    <a href="{{ route('opening_balance_accounts.create') }}"
                        class="btn btn-primary font-main btn-sm float-right {{ $orders->add == 0 ? 'd-none' : '' }}"
                        data-toggle="tooltip" data-placement="bottom" title="Add Purchases">
                        <i class="fas fa-plus" style="font-size: 10px"></i> اضافة
                    </a>
                @endif

            </div>
            <div class="card-body font-main">
                <div class="table-responsive">
                    <table class="table text-dark table-bordered" id="salesInvoice-dataTable" dir="rtl" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th> اسم الفرع </th>
                                <th> مدين </th>
                                <th> دائن </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="bodyTableSales text-center">
                            @if (isset($invoice))
                                <tr class="text-center">
                                    <td>{{ $invoice->branch_name }}</td>
                                    <td> {{ $invoice->debtor }} </td>
                                    <td>{{ $invoice->creditor }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('opening_balance_accounts.edit', $invoice->id) }}"
                                            class="btn btn-primary btn-sm {{ $orders->edit == 0 ? 'd-none' : '' }}" data-toggle="tooltip" title="edit"
                                            data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endif
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
