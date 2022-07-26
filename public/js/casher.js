
window.document.querySelector(".form-barcode").focus();

let list = [];
let Rows = [];
let valPrint = "filterItem";
let storeId = $("#storeId").val();
let hold = false;
let voiceId = 0;

let IDGenertaor = function () {
    return '_' + Math.random().toString(36).substr(2, 10);
};


const changePrinter = num => {
    let pointerSelect = document.getElementById(valPrint);
    if (num != 10) {
        if (pointerSelect) {
            pointerSelect.value += num;
            pointerSelect.focus();
        }
    } else pointerSelect.value = pointerSelect.value.slice(0, -1);
}; // change pointer keyboard
const SetId = val => {
    valPrint = val;
};
const CalcVal = input => {
    let item = document.getElementById(input);
    let val1 = +document.getElementById("cashVal").value;
    let val2 = +document.getElementById("visaVal").value;
    let val3 = +document.getElementById("masterVal").value;
    let val4 = +document.getElementById("creditVal").value;
    let netTotal = $(".netTotal").text();
    netTotal = +netTotal;
    let total = val1 + val2 + val3 + val4;
    let newValue = netTotal - total;
    item.value = newValue;
};

function getItemById(id) {
    $.ajax({
        type: "POST",
        url: "/erp/public/getItemById/" + id,
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (data = []) {
            $("#productsCategorys").empty();
            let item;
            data.items.forEach(option => {
                let listItem = data.list.filter(
                    item => item.itemId == option.id
                );
                if (listItem.length == 1) {
                    item = `
                        <button class="product mx-1 mb-2"  onclick="addItem(${option.id
                        })" >
                            ${option.img
                            ? `<img src={{ asset('assets/items/${option.img}') }} class='rounded' style='max-width: 60px;max-height: 60px;height: 100%' />`
                            : "<img src={{ asset('user.jpg') }} class='img-fluid rounded' style='max-width: 80px;max-height: 80px;height: 100%' />"
                        }
                            <h6 class="font-main my-2" style="font-size: 14px"> ${option.namear.substring(
                            0,
                            10,
                            ".."
                        )} </h6>
                        </button>
                    `;
                } else {
                    item = `
                        <button class="product mx-1 mb-2"  onclick="addItem(${option.id
                        })" data-toggle="modal" data-target="#modalItems">
                            ${option.img
                            ? `<img src={{ asset('assets/items/${option.img}') }} class='rounded p-0' style='max-width: 60px;max-height: 60px;height: 100%' />`
                            : "<img src={{ asset('user.jpg') }} class='rounded' style='max-width: 80px;max-height: 80px;height: 100%' />"
                        }
                            <h6 class="font-main my-2" style="font-size: 14px"> ${option.namear.substring(
                            0,
                            10,
                            ".."
                        )} </h6>
                        </button>
                    `;
                }

                $("#productsCategorys").append(item);
            });
        }
    });
}

function addItem(id) {
    $(".body-items").empty();
    $.ajax({
        type: "POST",
        url: "/erp/public/getItem/" + id,
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (data) {
            if (data.list.length == 1) {
                let { unitId, price1, id } = data.list[0];
                confirmData(
                    unitId,
                    price1,
                    data.item.namear,
                    data.item.img,
                    data.item.id,
                    data.item.description,
                    data.item.group,
                    data.item.priceWithTax,
                    data.item.taxRate,
                    data.item.quantityM,
                    id
                );
            } else {
                createSwal(data);
            }
        }
    });
}

async function createSwal(data) {
    $(".body-items").empty();
    data.list.forEach((option, idx) => {
        item = `
                <button class="product mx-1 mb-2" data-dismiss="modal" onclick="confirmData(
                        ${option.unitId},
                        ${option.price1},
                        '${data.item.namear}',
                        '${data.item.img}',
                        '${data.item.id}',
                        '${data.item.description}',
                        '${data.item.group}',
                        '${data.item.priceWithTax}',
                        '${data.item.taxRate}',
                        '${data.item.quantityM}',
                        '${data.list[idx].id}'
                        ) " >
                    ${data.item.img
                ? `<img src={{ asset('assets/items/${data.item.img}') }} class='rounded' style='max-width: 80px;max-height: 80px;height: 100%' />`
                : "<img src={{ asset('user.jpg') }} class='rounded' style='max-width: 80px;max-height: 80px;height: 100%' />"
            }
                    <h6 class="font-main my-2"> ${data.units.find(item => item.id == +option.unitId)
                .namear
            } - ${option.price1} </h6>
                </button>
            `;
        $(".body-items").append(item);
    });
}

function confirmData(id, price, name, img, idItem, description, group, priceWithTax, taxRate, quantityM, idxList, row) {
    let data = {};
    let storeId = $("#storeId").val();

    // data.unitId = id;
    data.unit_name = row.unit_name;
    data.listId = idxList;
    data.name = name;
    data.namear = name;
    data.nameen = row.nameen;
    data.unitId = row.unitId;

    data.img = img;
    data.price = price;
    data.itemId = idItem;
    data.description = description;
    data.group = group;
    data.priceWithTax = priceWithTax;
    data.taxRate = taxRate;
    data.quantityM = quantityM;
    let check = list.find(item => item.listId == idxList);
    let item;
    if (check) {
        check.qtn += 1;
        check.total = check.qtn * check.price;
        $(".input-qtn-" + check.unitId + "-" + data.itemId + "-" + idxList).text(check.qtn);
        $(".total-" + check.unitId + "-" + data.itemId + "-" + idxList).text(check.total);
    } else {
        data.qtn = 1;
        data.price1 = price;
        data.total = data.qtn * price;
        data.total = data.qtn * price;
        data.discount = 0;
        data.added = 0;
        data.storeId = storeId;
        list.push(data);
        if (data.priceWithTax == "1") {
            data.priceafterTax = data.price / `1.${data.taxRate}`;
            data.TaxVal = (data.priceafterTax * data.taxRate) / 100;
        } else {
            data.priceafterTax = data.price;
            data.TaxVal = (data.priceafterTax * data.taxRate) / 100;
        }
        item = `
                <tr class="row-${data.listId}">
                    <td class="td-casher"> ${name.substring(0, 15, "..")} - ${data.unit_name}</td>
                    <td class="td-casher th-casher-md"> .. </td>
                    <td class="td-casher input-qtn-${data.unitId}-${data.itemId}-${idxList}">
                        <input type="number" class="input-form w-100" min="1" onkeyup="changeCount(event,${idxList})" value=${data.qtn} />
                    </td>

                    <td class="td-casher th-casher-md"> ${data.price1} </td>
                    <td class="px-0">
                        <input type="number" name="discount" onkeyup="handelDiscount(event,'${id}')" class="form-control dis-${id}" />
                    </td>
                    <td class="td-casher th-casher-md"> ${+data.TaxVal.toFixed(3)} </td>
                    <td class="td-casher total-${data.unitId}-${data.itemId}-${idxList}"> ${+data.total.toFixed(3)} </td>
                    <td class="td-casher  td-md">
                        <button class="btn btn-md btn-danger" onclick="deleteRow(${data.listId})" > <i class="fas fa-trash"></i> </button>
                    </td>
                </tr>
            `;
    }
    // <td class="td-casher input-qtn-${data.unitId}-${data.itemId}-${idxList}">
    //  <input type="number" class="input-form w-100" min="1" onkeyup="changeCount(event,${idxList})" value=${data.qtn} />
    // </td>
    // <td class="td-casher ">
    //     <input type="number" class="input-form w-100" min="1" onkeyup="changePrice(event,${idxList})" value=${data.price1} />
    // </td>

    getTotal();
    $(".tableItems").append(item);
}

function changeCount(event, id) {
    list = [...list];
    let item = list.find(item => item.listId == id);
    item.qtn = +event.target.value;
    item.total = +event.target.value * item.price;
    $(`.total-${item.unitId}-${item.itemId}-${item.listId}`).text(+item.total.toFixed(3));
    getTotal();
}

function changePrice(event, id) {
    list = [...list];
    let item = list.find(item => item.listId == id);
    item.price = +event.target.value;
    item.total = +event.target.value * item.qtn;
    $(`.total-${item.unitId}-${item.itemId}-${item.listId}`).text(+item.total.toFixed(3));
    getTotal();
}

function getItem(event) {
    addItem(event.target.value);
}

function PayNow(status = 1, csrf = "") {
    let customerId = document.getElementById("customers").value;
    let netTotal = $(".netTotal").text();
    let statusVal = $("#statusType").val();
    let totalAfter = $(".totalTaxVal").text();

    let taxSource = $("#taxSourceRate").val();
    let taxSourceValue = $(".tax_value").html();
    // let isPrint = $('#printafter').is(':checked');


    let taxVals = $(".taxVals").text();
    // if (statusVal) {
    //     status = statusVal;
    // }
    let cash = $("#cashVal").val();
    let visa = $("#visaVal").val();
    let masterCard = $("#masterVal").val();
    let credit = $("#creditVal").val();

    if (Rows.length == 0) {
        swal("تاكد من ان المعلومات صحيحة");
    } else {
        $.ajax({
            type: "POST",
            url: "/erp/public/pos/save/paynow",
            data: {
                _token: csrf,
                //
                list: Rows,
                taxSource,
                taxSourceValue,
                customerId: customerId,
                netTotal: +netTotal,
                taxVals: +taxVals,
                typyInvoice: +statusVal,
                totalAfter: +totalAfter,
                status: status,
                cash,
                visa,
                masterCard,
                credit,
                hold: hold,
                // isPrint,
                voiceId
            },
            success: function (res) {
                if (res.status == 200) {
                    // let handle = window.open(window.location.origin + '/erp/public/print-invoice',
                    //     '_blank', "width=" + window.screen.width + ",height=" + window.screen.height)
                    // handle.window.parameters = JSON.stringify(res);
                    Rows = [];
                    getTotal();
                    $("#productsCategorys").empty();
                    $(".tableItems").empty();
                } else {
                    swal(res.msg);
                }
            }
        });
    }
}

function getTypeInvoice(event) {
    if (event.target.value == 5) {
        if ($(".tablesType").hasClass("d-none")) {
            $(".tablesType").removeClass("d-none");
            $("tbody").addClass("checkH");
        }
    } else {
        $(".tablesType").addClass("d-none");
        $("tbody").removeClass("checkH");
    }
}

function getTypeTable(event) { }

function CancelInvoice() {
    $(".netTotal").text(0);

    $("#productsCategorys").empty();
    $(".tableItems").empty();
}

function sendAlertClose(csrf) {
    $.ajax({
        type: "GET",
        url: "/erp/public/close-shift",
        data: {
            _token: csrf
        },
        success: function (data) {
            if (data.status == 200) {
                let handle = window.open(window.location.origin + "/erp/public/close-shift/printer", "_blank", "width=" + window.screen.width + ",height=" + window.screen.height);
                handle.window.parameters = JSON.stringify(data);
            }
        }
    });
}

function addItemDirectFilter(event) {
    event.preventDefault();

    if (document.getElementById("filterItem").value == "") {
        document.getElementById("flashList").classList.add("flashListHidden");
    } else {
        document
            .getElementById("flashList")
            .classList.remove("flashListHidden");
    }

    let input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("filterItem");
    filter = input.value.toUpperCase();
    ul = document.getElementById("flashList");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function setItemDirectFilter(id, unitId, csrf) {
    let idItem = IDGenertaor();

    $.ajax({
        type: "POST",
        url: "/erp/public/getItemDirect/" + id + "/" + unitId,
        data: {
            _token: csrf
        },
        success: function (data) {
            document.getElementById("flashList").classList.add("flashListHidden");
            document.getElementById("filterItem").value = "";

            Rows.push({
                id: idItem,
                unitId,
                itemId: id,
                storeId: storeId,
                tax: 0,
                price: data.list[0].price1,
                name: data.item.namear,
                qtn: 1,
                value: 0,
            });
            let { namear, unit_name } = data.item;
            let item = `
            <tr class="row-${idItem}">
                    <td class="td-casher"> ${namear.substring(0, 15, "..")} - ${unit_name}</td>
                    <td class="px-0">
                        <input type="number" name="qtn" onkeyup="handelQtn(event,'${idItem}')" value="1" min="1" class="text-center form-control qtn-${idItem}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="price" onkeyup="handelPrice(event,'${idItem}')" value="${data.list[0].price1}" class="text-center form-control price-${idItem}" />
                    </td>
                    <td class="px-0 th-casher-md">
                        <input type="number" name="discount" disabled onkeyup="handelDiscount(event,'${idItem}')" class="text-center th-casher-md form-control dis-${idItem}" />
                    </td>
                    <td class="px-0 th-casher-md">
                        <input type="number" name="added" onkeyup="handelAdded(event,'${idItem}')" value="0" class="text-center th-casher-md form-control added-${idItem}" />
                    </td>
                    <td class="px-0 th-casher-md">
                        <input type="number" disabled name="added" value="0" class="text-center form-control value-${idItem}" />
                    </td>
                    <td class="px-0">
                        <input type="number" disabled onkeyup="handelNetTotal(event,'${idItem}')" value="${data.list[0].price1 * 1}" class="text-center form-control nettotal-${idItem}" />
                    </td>
                    <td class="td-casher  td-md">
                        <button class="btn btn-md btn-danger" onclick="deleteRowUpdate('${idItem}')" > <i class="fas fa-trash"></i> </button>
                    </td>
                </tr>`;
            $(".tableItems").append(item);
            getTotal()
        }
    });
}

const handelQtn = (event, id) => {
    let item = Rows.find(el => el.id == id);
    item.qtn = event.target.value;
    Calc(id, event.target.value);

}

const handelPrice = (event, id) => {
    let item = Rows.find(el => el.id == id);
    item.price = event.target.value;
    Calc(id, event.target.value);
}

const handelAdded = (event, id) => {
    let item = Rows.find(el => el.id == id);
    item.added = event.target.value;
    getTotal()
    CalcRate(id)
    handelTax()
}

let Calc = (id) => {
    let price = $(`.price-${id}`).val();
    let qtn = $(`.qtn-${id}`).val();
    let discount = $(`.dis-${id}`).val();
    let discountValue = (discount * (+qtn * +price)) / 100;
    let total = (+qtn * +price) - discountValue;
    total = total.toFixed(2);
    $(`.nettotal-${id}`).val(total);
    CalcRate(id)
    getTotal()
}

function getTotal() {
    if (Rows.length != 0) {
        $(".btn-save-casher").attr("disabled", false);
    } else {
        $(".btn-save-casher").attr("disabled", true);
    }

    let total = 0;
    let taxs = 0;
    Rows.forEach(item => {
        total += +item.qtn * +item.price || 0
        taxs += +item.value || 0
    });

    let taxSource = +$('.tax_value').html();
    $('._total').html(+total.toFixed(2));
    if (!taxSource) {
        taxSource = $('#taxSourceRate').val();
        taxSource = (+total * +taxSource) / 100;
        $('.tax_value').html(+taxSource);
    }
    $('.taxVals').html(+taxs.toFixed(2));
    let safeTotal = (+taxs + +total) - +taxSource;
    $('.nettotal_inovice').html(+safeTotal);
}

// المنبع
function handelTax(event) {
    let total = $('._total').html();
    let val = event.target.value;
    let tax = 0;
    if (+val != 0) {
        tax = (+total * +val) / 100;
        $('.tax_value').html(+tax);

    } else {
        $('.tax_value').html(0);
    }
    getTotal()
}

let CalcRate = (id) => {
    let item = Rows.find(el => el.id == id);
    let added = $(`.added-${id}`).val();
    let qtn = item.qtn;
    let price = item.price;
    let total = qtn * price;
    let value = (total * added) / 100;
    $(`.value-${id}`).val(+value);
    item.value = value;
    let valRate = $(`.value-${id}`).val();
    let nettotal = +total + +valRate;
    $(`.nettotal-${id}`).val(+nettotal.toFixed(3));
    getTotal()
}

function submiting(event, csrf) {
    event.preventDefault();
    let val = document.getElementById("filterItem").value;
    $.ajax({
        type: "POST",
        url: "/erp/public/getItemByBarCode/" + val,
        data: {
            _token: csrf
        },
        success: function (data) {
            if (data.list.length == 0) {
                swal("هذا الصنف غير موجود");
            } else {
                document.getElementById("filterItem").value = "";
                let { unitId, price1, id } = data.list;
                confirmData(
                    unitId,
                    price1,
                    data.item.namear,
                    data.item.img,
                    data.item.id,
                    data.item.description,
                    data.item.group,
                    data.item.priceWithTax,
                    data.item.taxRate,
                    data.item.quantityM,
                    id
                );
            }
        }
    });
}

function closeShify(csrf) {
    swal({
        title: "هل تريد اغلاق الوردية ؟",
        icon: "warning",
        buttons: true,
        dangerMode: true
    }).then(willDelete => {
        if (willDelete) {
            CallingAfterCheck(csrf);
        } else {
            swal("الوردية ما زالت مفتوحة !");
        }
    });
}

function CallingAfterCheck(csrf) {
    $.ajax({
        type: "GET",
        url: "/erp/public/close-shift",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (data) {
            if (data.status == 200) {
                let items = data;
                if (items.InvoicesDetails.length == 0) {
                    $.ajax({
                        type: "POST",
                        url: "/erp/public/pos/end-shift",
                        data: {
                            _token: "{{ csrf_token() }}",
                            totalSalles: 0,
                            totalTax: 0,
                            Optimzation: [],
                            payment: 0
                        },
                        cache: false,
                        success: function (res) {
                            if (res.status == 200) {
                                document
                                    .querySelector(".preloader")
                                    .classList.add("hiden-pre-load");
                                window.location.replace(res.path);
                            }
                        }
                    });
                } else {

                    $.ajax({
                        type: "POST",
                        url: "/erp/public/pos/end-shift",
                        data: {
                            _token: csrf
                            // totalSalles,
                            // totalTax,
                            // Optimzation,
                            // payment
                        },
                        cache: false,
                        success: function (res) {
                            if (res.status == 200) {
                                document
                                    .querySelector(".preloader")
                                    .classList.add("hiden-pre-load");
                                window.location.replace(res.path);
                            }
                        }
                    });
                }
            }
        }
    });
}

function deleteRowUpdate(id) {
    Rows = Rows.filter(item => item.id != id);
    $(".row-" + id).remove();
    getTotal();
}
// Returned

const Returned = async () => {
    getTotal();
    Rows = []
    fetch("/erp/public/GetHoldInvoice").then(res => res.json()).then(data => {
        $('.notHold').addClass('d-none');
        $('.table-holds').removeClass('d-none');

        $('.ReturnedTrue').addClass('d-none');
        $('.ReturnedFalse').removeClass('d-none');
        let rows = data.Orders.map(({ id, created_at, netTotal }) => {
            let current = new Date(created_at);
            return `<tr class="tr-hold">
                    <td>${id}</td>
                    <td style="width: 170px">${current.toLocaleString()}</td>
                    <td>${netTotal}</td>
                    <td>
                        <button class="btn btn-small btn-success" onclick="getInvoice('${id}')"> <i class="fa fa-mouse"></i> </button>
                    </td>
                </tr>`

        });
        document.querySelector('.bodyHolds').innerHTML = rows.join('');
    });
}

const getInvoice = async id => {
    fetch(`/erp/public/getInvoice/${id}`)
        .then(res => res.json()).then(data => {
            $('#taxSourceRate').val(data.order.taxSource);
            data.list.forEach(rowItem => {
                if (!rowItem.itemId) rowItem.itemId = rowItem.item_id;
                if (!rowItem.unitId) rowItem.unitId = rowItem.unit_id;
            })
            Rows = data.list;

            let rows = data.list.map(({ id, item_name, unit_name, price, qtn, nettotal, rate, value }) => {
                return `<tr class="row-${id}">
                <td class="td-casher"> ${item_name.substring(0, 15, "..")} - ${unit_name}</td>
                <td class="px-0">
                    <input type="number" name="qtn" onkeyup="handelQtn(event,'${id}')" value="${qtn}" min="1" class="text-center form-control qtn-${id}" />
                </td>
                <td class="px-0">
                    <input type="number" name="price" onkeyup="handelPrice(event,'${id}')" value="${price}" class="text-center form-control price-${id}" />
                </td>
                <td class="px-0">
                    <input type="number" name="discount" disabled onkeyup="handelDiscount(event,'${id}')" class="text-center form-control dis-${id}" />
                </td>
                <td class="px-0">
                    <input type="number" name="added" onkeyup="handelAdded(event,'${id}')" value="${rate}" class="text-center form-control added-${id}" />
                </td>
                <td class="px-0">
                    <input type="number" disabled name="added" value="${value}"  class="text-center form-control value-${id}" />
                </td>
                <td class="px-0">
                    <input type="number" disabled onkeyup="handelNetTotal(event,'${id}')" value="${nettotal}" class="text-center form-control nettotal-${id}" />
                </td>
                <td class="td-casher  td-md">
                    <button class="btn btn-md btn-danger" onclick="deleteRowUpdate('${id}')" > <i class="fas fa-trash"></i> </button>
                </td>
            </tr>`

            });
            document.querySelector('.tableItems').innerHTML = rows.join('');
            getTotal();
            hold = true;
            voiceId = +data.order.id;
            $('.notHold').removeClass('d-none');
            $('.table-holds').addClass('d-none');
        });
}

const ReturnedFalse = () => {
    $('.ReturnedTrue').removeClass('d-none');
    $('.ReturnedFalse').addClass('d-none');

    $('.notHold').removeClass('d-none');
    $('.table-holds').addClass('d-none');

    getTotal();
    Rows = []
}



const CreateCustomer = async (csrf) => {
    let name = $('#nameCusotmer').val();
    let phone = $('#phoneCusotmer').val();
    let address = $('#addressCusotmer').val();

    $.ajax({
        type: 'POST',
        url: '/erp/public/customers/pos',
        data: {
            _token: csrf,
            name,
            phone,
            address
        },
        success: function (data = []) {
            console.log(data);
            if (data.status == 200) {
                swal(data.msg);
                let customer = data.customer;
                $('#nameCusotmer').val('');
                $('#phoneCusotmer').val('');
                $('#addressCusotmer').val('');
                let item = `<option value="${customer.id}" selected data-name=${customer.name}>
                ${customer.name} - ${customer.phone} </option>`;
                $('#customers').append(item);
                // document.querySelector('#customernew').innerHTML = rows.join('');

            }
        },
    })
}
