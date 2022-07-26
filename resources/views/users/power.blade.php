<div class="row">
    <div class="col-12 py-5">
        <div class="accordion font-main" id="SystemParent">

            @foreach ($parents as $parent)
                @if ($parent->page_name != 'TsReports' && $parent->page_name != 'TsSettings' && $parent->page_name != 'TsPrintSetting')
                <div class="accordion-item">
                        <h2 class="accordion-header" id="{{ $parent->page_name }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#{{ $parent->page_name }}Manual" aria-expanded="false"
                                aria-controls="{{ $parent->page_name }}Manual">
                                <div class="form-group p-0 m-0">
                                    <label for="{{ $parent->page_name }}It" class="font-main font-weight-bold mr-2">
                                        {{ $parent->name }} </label>
                                    <input type="checkbox" name="{{ $parent->page_name }}"
                                        id="{{ $parent->page_name }}It" onchange="handelValue(event)"
                                        value="0" />
                                </div>
                            </button>
                        </h2>
                        <div id="{{ $parent->page_name }}Manual" class="accordion-collapse collapse"
                            aria-labelledby="{{ $parent->page_name }}" data-bs-parent="#SystemParent">
                            <div class="accordion-body">
                                @foreach ($childs as $child)
                                    @if ($child->parent_id == $parent->id)
                                        <div class="form-group">
                                            <label for="{{ $child->id }}" class="font-main font-weight-bold mr-2">
                                                {{ $child->name }} </label>
                                            <input type="checkbox" id="{{ $child->id }}"
                                                onchange="handelValue(event)" name="{{ $child->page_name }}"
                                                value="0" />
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            <hr>
            <hr>


        </div>
    </div>
</div>

















{{-- <div class="accordion-item">
                <h2 class="accordion-header" id="System">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#SystemManual" aria-expanded="false" aria-controls="SystemManual">
                        <p>
                            <span class="font-main font-weight-bold mr-2"> النظام </span>
                            <input type="checkbox" name="system" onchange="handelValue(event)" value="1" />
                        </p>
                    </button>
                </h2>
                <div id="SystemManual" class="accordion-collapse collapse" aria-labelledby="System"
                    data-bs-parent="#SystemParent">
                    <div class="accordion-body">
                        <div class="form-group">
                            <label for="company" class="font-main font-weight-bold mr-2"> الشركة </label>
                            <input type="checkbox" id="company" onchange="handelValue(event)" name="company"
                                value="0" />
                        </div>
                        <div class="form-group">
                            <label for="branch" class="font-main font-weight-bold mr-2"> الفروع </label>
                            <input type="checkbox" id="branch" onchange="handelValue(event)" name="branch" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="fiscal_years" class="font-main font-weight-bold mr-2"> السنوات المالية </label>
                            <input type="checkbox" id="fiscal_years" onchange="handelValue(event)" name="fiscal_years"
                                value="0" />
                        </div>
                        <div class="form-group">
                            <label for="curreny" class="font-main font-weight-bold mr-2"> العملات </label>
                            <input type="checkbox" id="curreny" onchange="handelValue(event)" name="curreny"
                                value="0" />
                        </div>
                        <div class="form-group">
                            <label for="users" class="font-main font-weight-bold mr-2"> المستخدمين </label>
                            <input type="checkbox" id="users" onchange="handelValue(event)" name="users" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="employees" class="font-main font-weight-bold mr-2"> الموظفين </label>
                            <input type="checkbox" id="employees" onchange="handelValue(event)" name="employees"
                                value="0" />
                        </div>
                        <div class="form-group">
                            <label for="customers" class="font-main font-weight-bold mr-2"> العملاء </label>
                            <input type="checkbox" id="customers" onchange="handelValue(event)" name="customers"
                                value="0" />
                        </div>
                        <div class="form-group">
                            <label for="suppliers" class="font-main font-weight-bold mr-2"> الموردين </label>
                            <input type="checkbox" id="suppliers" onchange="handelValue(event)" name="suppliers"
                                value="0" />
                        </div>
                    </div>
                </div>
            </div>


            <div class="accordion-item">
                <h2 class="accordion-header" id="Stores">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#StoresManual" aria-expanded="false" aria-controls="StoresManual">
                        <div class="form-group p-0 m-0">
                            <label for="storesIt" class="font-main font-weight-bold mr-2"> المخازن </label>
                            <input type="checkbox" name="stores" id="storesIt" onchange="handelValue(event)"
                                value="1" />
                        </div>
                    </button>
                </h2>
                <div id="StoresManual" class="accordion-collapse collapse" aria-labelledby="Stores"
                    data-bs-parent="#SystemParent">
                    <div class="accordion-body">
                        <div class="form-group">
                            <label for="category_card" class="font-main font-weight-bold mr-2"> كارت الصنف </label>
                            <input type="checkbox" id="category_card" onchange="handelValue(event)" name="category_card"
                                value="0" />
                        </div>
                        <div class="form-group">
                            <label for="items" class="font-main font-weight-bold mr-2"> الاصناف </label>
                            <input type="checkbox" id="items" onchange="handelValue(event)" name="items" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="units" class="font-main font-weight-bold mr-2"> الوحدات </label>
                            <input type="checkbox" id="units" onchange="handelValue(event)" name="units" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="itemsGroup" class="font-main font-weight-bold mr-2"> مجموعة الاصناف </label>
                            <input type="checkbox" id="itemsGroup" onchange="handelValue(event)" name="itemsGroup"
                                value="0" />
                        </div>
                        <div class="form-group">
                            <label for="openingBalance" class="font-main font-weight-bold mr-2"> رصيد افتتاحي </label>
                            <input type="checkbox" id="openingBalance" onchange="handelValue(event)"
                                name="openingBalance" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="defintionStores" class="font-main font-weight-bold mr-2"> تعريف المخازن </label>
                            <input type="checkbox" id="defintionStores" onchange="handelValue(event)"
                                name="defintionStores" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="permisionAdd" class="font-main font-weight-bold mr-2">اذن اضافة </label>
                            <input type="checkbox" id="permisionAdd" onchange="handelValue(event)" name="permisionAdd"
                                value="0" />
                        </div>
                        <div class="form-group">
                            <label for="permisionCash" class="font-main font-weight-bold mr-2"> اذن صرف </label>
                            <input type="checkbox" id="permisionCash" onchange="handelValue(event)" name="permisionCash"
                                value="0" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="Salles">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#SallesManual" aria-expanded="false" aria-controls="SallesManual">
                        <div class="form-group p-0 m-0">
                            <label for="sallesIt" class="font-main font-weight-bold mr-2"> المبيعات </label>
                            <input type="checkbox" id="sallesIt" name="salles" onchange="handelValue(event)"
                                value="1" />
                        </div>
                    </button>
                </h2>
                <div id="SallesManual" class="accordion-collapse collapse" aria-labelledby="Salles"
                    data-bs-parent="#SystemParent">
                    <div class="accordion-body">
                        <div class="form-group">
                            <label for="invoicesSalles" class="font-main font-weight-bold mr-2"> فاتورة المبيعات
                            </label>
                            <input type="checkbox" id="invoicesSalles" onchange="handelValue(event)"
                                name="invoicesSalles" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="reportsSalles" class="font-main font-weight-bold mr-2"> تقارير المبيعات </label>
                            <input type="checkbox" id="reportsSalles" onchange="handelValue(event)" name="reportsSalles"
                                value="0" />
                        </div>
                        <div class="form-group">
                            <label for="ReturnedSalles" class="font-main font-weight-bold mr-2"> مرتجع المبيعات </label>
                            <input type="checkbox" id="ReturnedSalles" onchange="handelValue(event)"
                                name="ReturnedSalles" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="reportsItemsSalles" class="font-main font-weight-bold mr-2"> تقارير الاصناف
                            </label>
                            <input type="checkbox" id="reportsItemsSalles" onchange="handelValue(event)"
                                name="reportsItemsSalles" value="0" />
                        </div>

                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="purchases">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#purchasesMaual" aria-expanded="false" aria-controls="purchasesMaual">
                        <div class="form-group p-0 m-0">
                            <label for="purchasesIt" class="font-main font-weight-bold mr-2"> المشتريات </label>
                            <input type="checkbox" name="purchases" id="purchasesIt" onchange="handelValue(event)"
                                value="0" />
                        </div>
                    </button>
                </h2>
                <div id="purchasesMaual" class="accordion-collapse collapse" aria-labelledby="purchases"
                    data-bs-parent="#SystemParent">
                    <div class="accordion-body">
                        <div class="form-group">
                            <label for="invoicePurchases" class="font-main font-weight-bold mr-2"> فاتورة المشتريات
                            </label>
                            <input type="checkbox" id="invoicepurchases" onchange="handelValue(event)"
                                name="invoicePurchases" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="reportsPurchases" class="font-main font-weight-bold mr-2"> تقارير المشتريات
                            </label>
                            <input type="checkbox" id="reportsPurchases" onchange="handelValue(event)"
                                name="reportsPurchases" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="returnedPurchases" class="font-main font-weight-bold mr-2"> مرتجع المشتريات
                            </label>
                            <input type="checkbox" id="returnedPurchases" onchange="handelValue(event)"
                                name="returnedPurchases" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="reportsItemsPurchases" class="font-main font-weight-bold mr-2"> تقارير الاصناف
                            </label>
                            <input type="checkbox" id="reportsItemsPurchases" onchange="handelValue(event)"
                                name="reportsItemsPurchases" value="0" />
                        </div>

                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="FinancialAccounting">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#FinancialAccountingMaual" aria-expanded="false"
                        aria-controls="FinancialAccountingMaual">
                        <div class="form-group p-0 m-0">
                            <label for="accountsIt" class="font-main font-weight-bold mr-2"> المحاسبة المالية </label>
                            <input type="checkbox" name="accounts" id="accountsIt" onchange="handelValue(event)"
                                value="1" />
                        </div>
                    </button>
                </h2>
                <div id="FinancialAccountingMaual" class="accordion-collapse collapse"
                    aria-labelledby="FinancialAccounting" data-bs-parent="#SystemParent">
                    <div class="accordion-body">
                        <div class="form-group">
                            <label for="Accounts" class="font-main font-weight-bold mr-2"> الحسابات </label>
                            <input type="checkbox" id="Accounts" onchange="handelValue(event)" name="Accounts"
                                value="0" />
                        </div>
                        <div class="form-group">
                            <label for="AccountsDaily" class="font-main font-weight-bold mr-2"> قيود يومية </label>
                            <input type="checkbox" id="AccountsDaily" onchange="handelValue(event)" name="AccountsDaily"
                                value="0" />
                        </div>
                        <div class="form-group">
                            <label for="AccountsShow" class="font-main font-weight-bold mr-2"> كشف حساب </label>
                            <input type="checkbox" id="AccountsShow" onchange="handelValue(event)" name="AccountsShow"
                                value="0" />
                        </div>
                        <div class="form-group">
                            <label for="OpeningAccounts" class="font-main font-weight-bold mr-2"> رصيد افتتاحي </label>
                            <input type="checkbox" id="OpeningAccounts" onchange="handelValue(event)"
                                name="OpeningAccounts" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="reportsBugets" class="font-main font-weight-bold mr-2"> تقرير الميزانية
                            </label>
                            <input type="checkbox" id="reportsBugets" onchange="handelValue(event)" name="reportsBugets"
                                value="0" />
                        </div>

                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="Bonds">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#BondsManual" aria-expanded="false" aria-controls="BondsManual">
                        <div class="form-group p-0 m-0">
                            <label for="bondsIt" class="font-main font-weight-bold mr-2"> السندات </label>
                            <input type="checkbox" name="bonds" id="bondsIt" onchange="handelValue(event)" value="1" />
                        </div>
                    </button>
                </h2>
                <div id="BondsManual" class="accordion-collapse collapse" aria-labelledby="Bonds"
                    data-bs-parent="#SystemParent">
                    <div class="accordion-body">
                        <div class="form-group">
                            <label for="cash_receipt_voucher" class="font-main font-weight-bold mr-2"> سند قبض نقدي
                            </label>
                            <input type="checkbox" id="cash_receipt_voucher" onchange="handelValue(event)"
                                name="cash_receipt_voucher" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="bank_receipt_voucher" class="font-main font-weight-bold mr-2"> سند قبض بنكي
                            </label>
                            <input type="checkbox" id="bank_receipt_voucher" onchange="handelValue(event)"
                                name="bank_receipt_voucher" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="voucher_for_cash" class="font-main font-weight-bold mr-2"> سند صرف نقدي
                            </label>
                            <input type="checkbox" id="voucher_for_cash" onchange="handelValue(event)"
                                name="voucher_for_cash" value="0" />
                        </div>
                        <div class="form-group">
                            <label for="voucher_for_bank" class="font-main font-weight-bold mr-2"> سند صرف بنكي
                            </label>
                            <input type="checkbox" id="voucher_for_bank" onchange="handelValue(event)"
                                name="voucher_for_bank" value="0" />
                        </div>

                    </div>
                </div>
            </div>



            <div class="accordion-item">
                <h2 class="accordion-header" id="reports">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#reportsManual" aria-expanded="false" aria-controls="reportsManual">
                        <div class="form-group p-0 m-0">
                            <label for="reportsit" class="font-main font-weight-bold mr-2"> التقارير </label>
                            <input type="checkbox" name="reports" id="reportsit" onchange="handelValue(event)"
                                value="1" />
                        </div>
                    </button>
                </h2>
                <div id="reportsManual" class="accordion-collapse collapse" aria-labelledby="reports"
                    data-bs-parent="#SystemParent">
                    <div class="accordion-body">
                        <div class="form-group">
                            <label for="reportsDaily" class="font-main font-weight-bold mr-2"> تقارير اليومية </label>
                            <input type="checkbox" id="reportsDaily" onchange="handelValue(event)" name="reportsDaily"
                                value="0" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="setting printer">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#settingprinterManual" aria-expanded="false"
                        aria-controls="settingprinterManual">
                        <div class="form-group p-0 m-0">
                            <label for="printSetting" class="font-main font-weight-bold mr-2"> اعدادات الطابعة </label>
                            <input type="checkbox" name="printSetting" id="printSetting" onchange="handelValue(event)"
                                value="0" />
                        </div>
                    </button>
                </h2>
                <div id="settingprinterManual" class="accordion-collapse collapse" aria-labelledby="setting printer"
                    data-bs-parent="#SystemParent">
                    <div class="accordion-body">
                        <div class="form-group">
                            <label for="setting" class="font-main font-weight-bold mr-2"> الاعدادات </label>
                            <input type="checkbox" id="setting" onchange="handelValue(event)" name="setting"
                                value="0" />
                        </div>
                    </div>
                </div>
            </div>


            <div class="form-group px-3 py-3">
                <label for="tables" class="font-main font-weight-bold mr-2"> الطاولات </label>
                <input type="checkbox" id="tables" onchange="handelValue(event)" name="tables" value="0" />
            </div> --}}
