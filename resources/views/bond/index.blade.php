@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> {{ $title }} </li>
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
                <h6 class="m-0 font-weight-bold text-primary float-left font-main"> {{ $title }} </h6>
                <a href="{{ route('bond.create', $type) }}"
                    class="{{ $orders->add == 0 ? 'd-none' : '' }} btn btn-primary font-main btn-sm float-right"
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
                                <th> Num </th>
                                <th> التاريخ </th>
                                <th> الحالة </th>
                                <th> الوصف </th>
                                <th> اسم الصندوق </th>
                                <th> الاجمالي </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="bodyTableSales text-center">
                            @foreach ($bonds as $key => $bond)
                                <tr>
                                    <td>{{ $bond->num }}</td>
                                    <td>{{ $bond->date }}</td>
                                    <td>{{ $bond->status ? 'معتمد' : 'غير معتمد' }}</td>
                                    <td> {{ $bond->description }} </td>
                                    <td>{{ $bond->account_name }}</td>
                                    <td> {{ $bond->total }} </td>
                                    <td style="width: 120px">
                                        <div class="d-flex justify-content-between ">
                                            <a href="{{ route('bond.edit', [$bond->id, $type]) }}"
                                                class="btn {{ $orders->edit == 0 ? 'd-none' : '' }} btn-primary btn-sm  mr-1">
                                                <i class="fas fa-edit"></i></a>
                                            <a href="{{ route('bond.print', [$bond->id, $type]) }}"
                                                class="btn btn-primary btn-sm  mr-1">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <form method="POST" class="{{ $orders->delete == 0 ? 'd-none' : '' }}"
                                                action="{{ route('bond.delete', [$bond->id, $type]) }}">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm dltBtn" data-id={{ $bond->id }}
                                                    data-toggle="tooltip" data-placement="bottom" title="Delete"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                    <div class="modal fade" id="delModalCustomer{{ $bond->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="#delModalCustomer{{ $bond->id }}Label"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="#delModalCustomer{{ $bond->id }}Label">
                                                        Delete user </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post"
                                                        action="{{ route('ItemsPurchases.destroy', $bond->id) }}">
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
