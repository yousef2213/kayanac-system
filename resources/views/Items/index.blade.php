@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main p-2">
                <li class="breadcrumb-item active" aria-current="page"> الاصناف </li>
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
                <h6 class="m-0 font-weight-bold text-primary float-left font-main"> Items List </h6>

                <a href="{{ route('items.create') }}"
                    class=" {{ $orders->add == 0 ? 'd-none' : '' }} btn btn-primary font-main btn-sm float-right"
                    data-toggle="tooltip" data-placement="bottom" title="Add User">
                    <i class="fas fa-plus" style="font-size: 10px"> </i> اضافة صنف
                </a>
                <a href="{{ route('file.items') }}"
                    class="{{ $orders->add == 0 ? 'd-none' : '' }} btn btn-primary font-main btn-sm float-right mx-2"
                    data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"
                        style="font-size: 10px"></i> اضافة اصناف من ملف اكسيل
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="items-dataTable" dir="rtl" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th>م</th>
                                <th>اسم الصنف</th>
                                <th> فئة </th>
                                <th> تفعيل </th>
                                <th> باركود </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr class="text-center font-main">
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->namear }}</td>
                                    <td>
                                        {{ $categorys->find($item->group) ? $categorys->find($item->group)->namear : '' }}
                                    </td>
                                    <td>
                                        @if ($item->active == '1')
                                            نشط
                                        @endif
                                        @if ($item->active == '0')
                                            غير نشط
                                        @endif
                                    </td>

                                    <td class="px-0" style="width: 100px">
                                        @php
                                            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                                            $Itemslist = App\Itemslist::where('itemId', $item->id)->first();
                                        @endphp
                                        @if ($item->barcodee != 0 && $item->barcodee)
                                            <img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($item->barcodee, $generatorPNG::TYPE_CODE_128)) }}"
                                                height="50" width="100">
                                            <h6>{{ $item->barcodee }}</h6>
                                        @endif


                                    </td>
                                    <td>
                                        <a href="{{ route('items.edit', $item->id) }}"
                                            class="{{ $orders->edit == 0 ? 'd-none' : '' }} btn btn-primary btn-sm float-left mr-1" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" class="{{ $orders->delete == 0 ? 'd-none' : '' }}" action="{{ route('items.destroy', [$item->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $item->id }}
                                                data-toggle="tooltip" data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <div class="text-right">
                {!! $items->links() !!}
               </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('boot5/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        #items-dataTable_paginate {
            display: flex !important;
            justify-content: end
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

    <script>
        $(document).ready(function() {
            $('#items-dataTable').DataTable({
                "dom": 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

        });
    </script>
@endpush
