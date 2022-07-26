@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> رصيد افتتاحي </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left font-main"> Opening Balance </h6>
                <a href="{{ route('opening_balance.create') }}" class="{{ $orders->add == 0 ? 'd-none' : '' }} btn btn-primary font-main btn-sm float-right"
                    data-toggle="tooltip" data-placement="bottom" title="Add Purchases">
                    <i class="fas fa-plus" style="font-size: 10px"></i> اضافة
                </a>
            </div>

            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary float-right font-main mx-2"> الاجمالي </h5>
                <h5 class="m-0 font-weight-bold text-primary float-right font-main"> {{ $total }} </h5>
            </div>
            <div class="card-body font-main">
                <div class="table-responsive">
                    <table class="table text-dark table-bordered" id="salesInvoice-dataTable" dir="rtl" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th> الرقم </th>
                                <th> المخزن </th>
                                <th> اسم الصنف </th>
                                {{-- <th> الوحدة </th>
                            <th> الكمية </th>
                            <th> السعر </th>
                            <th> الخصم </th> --}}
                                <th> اجمالي </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="bodyTableSales text-center">
                            @foreach ($list as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->store_name }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    {{-- <td>{{ $item->unit_name }}</td>
                                <td>{{ $item->qtn }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->discountRate }}</td> --}}
                                    <td>{{ $item->nettotal }}</td>
                                    <td>
                                        {{-- <a href="{{ route('ItemsPurchases.edit', $item->id) }}"
                                        class="btn btn-primary btn-sm float-left mr-1"
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                        data-placement="bottom"><i class="fas fa-edit"></i></a> --}}
                                        <form method="POST" class="{{ $orders->delete == 0 ? 'd-none' : '' }}" action="{{ route('opening_balance.destroy', [$item->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $item->id }} data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
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
