@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-2 justify-content-end font-main">
                        <li class="breadcrumb-item active" aria-current="page"> عرض سعر </li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                    </ol>
                </nav>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left font-main"> Offer Price </h6>
                        <a href="{{ route('offer-price.create') }}"
                            class="{{ $orders->add == 0 ? 'd-none' : '' }} btn btn-primary font-main btn-sm float-right"
                            data-toggle="tooltip" data-placement="bottom" title="Add Purchases">
                            <i class="fas fa-plus" style="font-size: 10px"></i> اضافة
                        </a>
                    </div>


                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="salesInvoice-dataTable" dir="rtl" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center font-main">
                                        <th> رقم الفاتورة </th>
                                        <th> التاريخ </th>
                                        <th> العميل </th>
                                        <th> الصافي </th>
                                        <th> طريقة الدفع </th>
                                        {{-- <th> تاريخ التتبع </th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bodyTableSales">
                                    @foreach ($Invoices as $Invoice)
                                        <tr class="text-center font-main">
                                            <td>{{ $Invoice->id }}</td>
                                            <td>{{ $Invoice->created_at }}</td>
                                            <td>
                                                {{ $Invoice->customer_name }}
                                            </td>
                                            <td>
                                                {{ $Invoice->netTotal }}
                                            </td>
                                            <td>
                                                @if ($Invoice->status == 2)
                                                    <span class="bagde bg-success py-1 rounded text-light d-inline-block"
                                                        style="width: 60px"> اجل </span>
                                                @endif
                                                @if ($Invoice->status == 1)
                                                    <span class="bagde bg-success py-1 rounded text-light d-inline-block"
                                                        style="width: 60px"> كاش </span>
                                                @endif
                                                @if ($Invoice->status == 3)
                                                    <span class="bagde bg-warning py-1 rounded d-inline-block"
                                                        style="width: 60px"> معلقة </span>
                                                @endif
                                            </td>

                                            {{-- <td> {{ \Carbon\Carbon::parse($Invoice->date_follow)->diffForHumans() }} </td> --}}
                                            <td style="width: 120px">
                                                <div class="d-flex justify-content-between">

                                                    <a href="{{ route('offer-price.print', $Invoice->id) }}"
                                                        class="btn btn-info btn-sm  mr-1">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <a href="{{ route('offer-price.edit', $Invoice->id) }}"
                                                        class="btn {{ $orders->edit == 0 ? 'd-none' : '' }} btn-primary btn-sm mr-1" data-toggle="tooltip"
                                                        title="edit" data-placement="bottom"><i
                                                            class="fas fa-edit"></i></a>
                                                    <form method="POST"
                                                        class="{{ $orders->delete == 0 ? 'd-none' : '' }}"
                                                        action="{{ route('offer-price.destroy', [$Invoice->id]) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm dltBtn"
                                                            data-id={{ $Invoice->id }} data-toggle="tooltip"
                                                            data-placement="bottom" title="Delete"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
