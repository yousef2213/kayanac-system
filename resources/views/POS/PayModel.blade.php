<!-- Modal -->
<div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="LableModalPay" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 800px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-main text-right" id="LableModalPay">طرق الدفع</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body font-main">
                <div class="row">

                    <div class="col-7">
                        <form>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"> Cash </label>
                                <div class="col-sm-10">
                                    <input type="number" min="0.1" onclick="SetId('cashVal')" step="0.1" id="cashVal"
                                        class="form-control" style="position: relative;">
                                    <button type="button" onclick="CalcVal('cashVal')" class="btn btn-primary py-1 px-3"
                                        style="position: absolute;right: 15px;top:2px"> Calc </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label"> Visa </label>
                                <div class="col-sm-10">
                                    <input type="number" onclick="SetId('visaVal')" min="0.1" step="0.1" id="visaVal"
                                        class="form-control" style="position: relative;">
                                    <button type="button" onclick="CalcVal('visaVal')" class="btn btn-primary py-1 px-3"
                                        style="position: absolute;right: 15px;top:2px"> Calc </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label"> MasterCard
                                </label>
                                <div class="col-sm-10">
                                    <input type="number" onclick="SetId('masterVal')" min="0.1" step="0.1"
                                        id="masterVal" class="form-control" style="position: relative;">
                                    <button type="button" onclick="CalcVal('masterVal')"
                                        class="btn btn-primary py-1 px-3"
                                        style="position: absolute;right: 15px;top:2px"> Calc </button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label"> Credit </label>
                                <div class="col-sm-10">
                                    <input type="number" onclick="SetId('creditVal')" min="0.1" step="0.1"
                                        id="creditVal" class="form-control" style="position: relative;">
                                    <button type="button" onclick="CalcVal('creditVal')"
                                        class="btn btn-primary py-1 px-3"
                                        style="position: absolute;right: 15px;top:2px"> Calc </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-4 px-1 my-1">
                                <button class="btn btn-primary btn-print w-100 py-2" onclick="changePrinter(1)">
                                    1</button>
                            </div>
                            <div class="col-4 px-1 my-1">
                                <button class="btn btn-primary btn-print w-100 py-2" onclick="changePrinter(2)">
                                    2</button>
                            </div>
                            <div class="col-4 px-1 my-1">
                                <button class="btn btn-primary btn-print w-100 py-2" onclick="changePrinter(3)">
                                    3</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 px-1 my-1">
                                <button class="btn btn-primary btn-print w-100 py-2" onclick="changePrinter(4)">
                                    4</button>
                            </div>
                            <div class="col-4 px-1 my-1">
                                <button class="btn btn-primary btn-print w-100 py-2" onclick="changePrinter(5)">
                                    5</button>
                            </div>
                            <div class="col-4 px-1 my-1">
                                <button class="btn btn-primary btn-print w-100 py-2" onclick="changePrinter(6)"> 6
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 px-1 my-1">
                                <button class="btn btn-primary btn-print w-100 py-2" onclick="changePrinter(7)"> 7
                                </button>
                            </div>
                            <div class="col-4 px-1 my-1">
                                <button class="btn btn-primary btn-print w-100 py-2" onclick="changePrinter(8)">
                                    8</button>
                            </div>
                            <div class="col-4 px-1 my-1">
                                <button class="btn btn-primary btn-print w-100 py-2" onclick="changePrinter(9)">
                                    9</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8 px-1 my-1">
                                <button class="btn w-100 btn-primary btn-print py-2" onclick="changePrinter(0)">
                                    0</button>
                            </div>
                            <div class="col-4 px-1 my-1">
                                <button class="btn w-100 btn-clear py-2 bg-warning" onclick="changePrinter(10)"> C
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <div class="d-flex justify-content-between w-100 flex-row-reverse align-items-center">
                    <div>
                        <button type="button" class="btn btn-primary"
                            onclick="PayNowResturant(10,'{{ csrf_token() }}')" data-dismiss="modal">Save</button>
                        <button type="button" class="btn btn-success"
                            onclick="PayNowResturant(2,'{{ csrf_token() }}')" data-dismiss="modal">Credit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                    <h6 class="netTotal23  font-weight-bold mb-0">00</h6>

                </div>


            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="CustomerAdded">
    <div class="modal-dialog" style="max-width: 800px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-main text-right" id="CustomerAdded">اضافة عميل جديد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body font-main">
                <div class="row">
                    <div class="col-10 mx-auto text-right">
                        <div class="form-group">
                            <label for="">اسم العميل</label>
                            <input type="text" dir="rtl" class="form-control" id="nameCusotmer">
                        </div>
                        <div class="form-group">
                            <label for="">رقم الهاتف</label>
                            <input type="text" dir="rtl" class="form-control" id="phoneCusotmer">
                        </div>
                        <div class="form-group">
                            <label for="">العنوان</label>
                            <input type="text" dir="rtl" class="form-control" id="addressCusotmer">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <div class="d-flex justify-content-between w-100 flex-row-reverse align-items-center">
                    <div>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                            onclick="CreateCustomer('{{ csrf_token() }}')">حفظ</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>

                </div>


            </div>
        </div>
    </div>
</div>





<!-- Modal Delevery -->
<div class="modal fade" id="deleverys">
    <div class="modal-dialog" style="max-width: 800px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-main text-right" id="deleverys">طلبات التوصيل</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body font-main">
                <div class="bodyDelevery">
                </div>
            </div>
            <div class="modal-footer">

                <div class="d-flex justify-content-between w-100 flex-row-reverse align-items-center">
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
