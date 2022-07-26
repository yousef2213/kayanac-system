@extends('dashboard.master')

@section('main-content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> قيود اليومية </li>
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
            <h6 class="m-0 font-weight-bold text-primary float-left font-main"> قيود يومية </h6>
            <a href="{{ route('daily.create') }}" class="btn {{ $orders->add == 0 ? 'd-none' : '' }} btn-primary font-main btn-sm float-right"
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
                            <th> رقم القيد </th>
                            <th> document </th>
                            <th> رقم المصدر </th>
                            <th> المصدر </th>
                            <th> بيان </th>
                            <th> فرع </th>
                            <th> مدين </th>
                            <th> دائن </th>
                            <th> تاريخ </th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="bodyTableSales text-center">
                        @foreach ($invoices as $key => $invoice)
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>{{ $invoice->document }}</td>
                                <td>{{ $invoice->source }}</td>
                                <td>{{ $invoice->source_name }}</td>
                                <td>{{ $invoice->description }}</td>
                                <td>{{ $invoice->branshName }}</td>
                                <td> {{ $invoice->debtor }} </td>
                                <td>{{ $invoice->creditor }}</td>
                                <td> {{ $invoice->date }} </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('daily.print', [$invoice->id]) }}"
                                            class="btn btn-primary btn-sm  mr-1">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        @if ($invoice->manual == 1)
                                            <a href="{{ route('daily.edit', $invoice->id) }}"
                                                class="btn btn-primary {{ $orders->edit == 0 ? 'd-none' : '' }}  btn-sm float-left mr-1"
                                                data-toggle="tooltip"
                                                title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>

                                            <form method="POST" class="{{ $orders->delete == 0 ? 'd-none' : '' }}" action="{{ route('daily.destroy', [$invoice->id]) }}">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm dltBtn" data-id={{ $invoice->id }}
                                                    data-toggle="tooltip" data-placement="bottom" title="Delete"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

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
