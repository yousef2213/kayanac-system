@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end font-main p-2">
                        <li class="breadcrumb-item active" aria-current="page"> اضافة عميل </li>
                        <li class="breadcrumb-item"><a href="/erp/public/customers"> العملاء </a></li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 px-0">
                <div class="company text-right font-ar">
                    <div class="col-12 mx-auto py-2 px-0 font-main">
                        <form dir="rtl" method="POST" action="{{ route('customers.store') }}">
                            {{ csrf_field() }}

                            <div class="container">
                                <div class="row">
                                    <div class="col-12 mx-auto px-3">
                                        <ul class="nav nav-tabs mb-4 px-0" dir="rtl" id="myTab" role="tablist">
                                            <li class="nav-item font-main" role="presentation">
                                                <button class="nav-link active font-weight-bold" id="home-tab"
                                                    data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true">بيانات العميل</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link font-main font-weight-bold" id="electron_tab"
                                                    data-bs-toggle="tab" data-bs-target="#electronic" type="button"
                                                    role="tab" aria-controls="electronic" aria-selected="false">
                                                    <span>  سياسة التسعير </span>
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                                aria-labelledby="home-tab">
                                                @include('customers.info')
                                            </div>
                                            <div class="tab-pane fade" id="electronic" role="tabpanel"
                                                aria-labelledby="electron_tab">
                                                @include('customers.RoleSale')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-right px-5">
                                <div class="form-group mb-3">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </div>


                            {{-- <div class="submiting d-flex mt-4">
                                <button type="submit" class="btn btn-primary mx-2 px-4"> حفظ </button>
                            </div> --}}
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('boot5/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        .select2-selection {
            height: 35px !important;
        }
        .chosen-container.chosen-container-single{
            width: 100% !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('boot5/bootstrap.min.js') }}"></script>
    <script src="{{ asset('boot5/bootstrap.bundle.js') }}"></script>
    <!-- Page level plugins -->
    <script src=" {{ asset('js/select2.min.js') }} "></script>

    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script>
        $('#user-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [6, 7]
            }]
        });

        // Sweet alert

        function handelNum(event) {
            // let isTrue = event.target.checked;
            // isTrue ? $('#isChecked').attr('disabled', false) : $('#isChecked').attr('disabled', true)
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
