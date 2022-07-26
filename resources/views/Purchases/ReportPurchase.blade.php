@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-12 px-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end font-main">
                        <li class="breadcrumb-item active" aria-current="page"> تقرير المشتريات </li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                    </ol>
                </nav>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">

                    <div class="px-3">
                        <form>
                            <div class="form-row align-items-center flex-row-reverse">
                                <div class="col-sm-3 my-1 text-right">
                                    <label class="font-main text-right"> من تاريخ </label>
                                    <input type="datetime-local" class="form-control fromDate" />
                                </div>
                                <div class="col-sm-3 my-1 text-right">
                                    <label class="font-main text-right"> الي تاريخ </label>
                                    <input type="datetime-local" class="form-control toDate" />
                                </div>

                                <div class="col-12 my-1 text-right">
                                    <button type="submit" onclick="filterDate(event)"
                                        class="btn btn-primary font-main px-3"> بحث
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>






                    <div class="row flex-row-reverse font-main px-5 my-5">
                        <div class="col-12 col-md-6">
                            <div class="btn-primary text-right p-2">
                                <p class="text-light font-weight-bold mb-0 pb-0 px-2"> اجماليات </p>
                            </div>
                            <div class="details">
                                <table class="table" dir="rtl">
                                    <tbody>
                                        <tr>
                                            <th class="text-right"> اجمالي بدون ضريبة </th>
                                            <td class="text-center totalBefore"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right"> اجمالي قيمة مضافة </th>
                                            <td class="text-center totalTaxRate"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right"> اجمالي شامل الضريبة </th>
                                            <td class="text-center netTotal"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right"> خدمة توصيل </th>
                                            <td class="text-center"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right"> خصم اضافي </th>
                                            <td class="text-center"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right"> الاجمالي النهائي </th>
                                            <td class="text-center finalTotal"> 00 </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- <div class="col-12 col-md-6">
                        <div class="btn-primary text-right p-2">
                            <p class="text-light font-weight-bold mb-0 pb-0 px-2"> عملية الدفع </p>
                        </div>
                        <div class="details">
                            <table class="table" dir="rtl">
                                <tbody>
                                    <tr>
                                        <th class="text-right"> كاش </th>
                                        <td class="cashVal text-center"> 00 </td>
                                    </tr>
                                    <tr>
                                        <th class="text-right"> اجل </th>
                                        <td class="text-center creditVal"> 00 </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> --}}

                    </div>


                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table " id="salesInvoice-dataTable2" dir="rtl" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr class="text-center font-main">
                                        <th> رقم الفاتورة </th>
                                        <th> التاريخ </th>
                                        <th> المورد </th>
                                        <th> الصافي </th>
                                        <th> طريقة الدفع </th>

                                    </tr>
                                </thead>
                                <tbody class="bodyTableSales">
                                    @foreach ($Invoices as $Invoice)
                                        <tr class="text-center font-main d-none">
                                            <td>{{ $Invoice->id }}</td>
                                            <td>{{ $Invoice->created_at }}</td>
                                            <td>
                                                00
                                            </td>
                                            <td>
                                                {{ $Invoice->netTotal }}
                                            </td>
                                            <td> كاش </td>

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
    <style>
        .table-responsive {
            max-height: 400px !important;
            overflow-y: auto;
        }
    </style>
@endpush

@push('scripts')
    <script src=" {{ asset('js/jquery.js') }} "></script>
    <script src=" {{ asset('js/bootstrap-datepicker.js') }} "></script>
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src=" {{ asset('js/sweetalert.min.js') }} "></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>

    <script>
        let netTotal = 0;
        let netTotal2 = 0;
        let priceAfterTax = 0;
        let taxRateTotal = 0;
        let cash = 0;
        let visa = 0;
        let masterCard = 0;
        let credit = 0;
        let itemsQtn = 0;

        function filterDate(event) {
            event.preventDefault();
            document.querySelector('.preloader').classList.remove("hiden-pre-load");

            let from = $('.fromDate').val();
            let to = $('.toDate').val();
            $.ajax({
                type: 'POST',
                url: "/erp/public/PurchasesItems/filter-purchases",
                data: {
                    _token: "{{ csrf_token() }}",
                    from,
                    to
                },
                success: function(data) {
                    document.querySelector('.preloader').classList.add("hiden-pre-load");
                    let item = '';
                    let Totals = data.InvoicesDetails.reduce((obj, acc) => {
                        obj.total += acc.total;
                        obj.netTotal += acc.nettotal;
                        obj.RateValue += acc.value;
                        return obj;
                    }, {
                        total: 0,
                        netTotal: 0,
                        RateValue: 0
                    });

                    data.orders.forEach(element => {
                        let customer = data.customers.find(item => item.id == element.supplier).name;
                        let Details = data.InvoicesDetails.filter(item => item.purchasesId == element
                            .id);
                        let totalDetails = Details.reduce((el, acc) => {
                            el += acc.nettotal;
                            return el;
                        }, 0);

                        let cashText = '';
                        if (element.cash != 0) {
                            cashText += "كاش";
                            cashText += "-";
                        }
                        if (element.visa != 0) {
                            cashText += "فيزا";
                            cashText += "-";
                        }
                        if (element.masterCard != 0) {
                            cashText += "masterCard";
                            cashText += "-";
                        }
                        if (element.credit != 0) {
                            cashText += "اجل";
                            cashText += "-";
                        }
                        item += `
                        <tr class="text-center font-main">
                                <td>${ element.id }</td>
                                <td>${ new Date(element.created_at).toLocaleString()  }</td>
                                <td>
                                    ${customer}
                                </td>
                                <td>
                                    ${ +totalDetails.toFixed(4) }
                                </td>
                                <td>
                                    ${element.payment == 10 ? cashText : element.payment}
                                </td>

                            </tr>
                        `
                    });
                    $('.bodyTableSales').html(item);
                    // cash , visa, materCard
                    priceAfterTax = +priceAfterTax.toFixed(2)
                    taxRateTotal = +taxRateTotal.toFixed(2)
                    netTotal = +(+priceAfterTax + +taxRateTotal).toFixed(2);

                    $('.cashVal').text(cash);

                    $('.creditVal').text(credit);
                    $('.totalBefore').text(+(Totals.netTotal - Totals.RateValue).toFixed(4));
                    $('.totalTaxRate').text(+Totals.RateValue.toFixed(4));
                    $('.netTotal').text(+Totals.netTotal.toFixed(4));
                    $('.finalTotal').text(+Totals.netTotal.toFixed(4));

                }
            });
        }
        $(document).ready(function() {
            // $('#salesInvoice-dataTable2').DataTable({
            //     // scrollY: 200,
            // });
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
