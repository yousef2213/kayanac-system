
let lang = $(".lang").val();
let List = [];
let hold = false;
let delevery = false;
let ListResponse;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let IDGenertaor = function () {
    return '_' + Math.random().toString(36).substr(2, 10);
};
$(".chosen").chosen();
$(document).ready(function () {
    $('.products-search').select2({
        placeholder: "البحث عن طريق اسم / الكود",
        allowClear: true,
        width: 'resolve'
    });

    $('.products-search-2').select2({
        placeholder: "البحث عن طريق اسم / الكود",
        allowClear: true,
        width: 'resolve'
    });
});


document.addEventListener('contextmenu', (e) => {
    e.preventDefault();
});
//

const GetHolds = () => {
    $.ajax({
        type: 'GET',
        url: '/erp/public/GetHoldInvoice',
        data: {
            _token: '{{ csrf_token() }}',
        },
        success: function (data = []) {
            let item = ''
            data.Orders.forEach((ele) => {
                item += `
        <tr class="invoice-${ele.id}">
            <td> ${ele.id} </td>
            <td> ${ele.netTotal} </td>
            <td>
                <button class="btn btn-primary py-1 px-4" onclick="activeHold(${ele.id})"> Recovery </button>
            </td>
        </tr>`
            })
            $('.bodyOrdersHold').html(item)
        },
    })
}

const activeHold = (id) => {
    $.ajax({
        type: 'GET',
        url: '/erp/public/activeHoldInvoice/' + id,
        data: {
            _token: '{{ csrf_token() }}',
        },
        success: function (data = []) {
            if (data.status == 200) {
                $(`.invoice-${data.id}`).remove()
                alert(data.msg)
            }
        },
    })
}


function getItemById(id, csrf) {
    $.ajax({
        type: 'POST',
        url: "/erp/public/getItemById/" + id,
        data: {
            _token: csrf,
        },
        success: function (data = []) {
            $('#productsCategorys').empty();
            let item;
            let text = `name${lang}`;
            data.items.forEach(option => {
                let listItem = data.list.filter(item => item.itemId == option.id);
                if (listItem.length == 1) {
                    item = `
                       <button class="product mx-1 mb-2 thisproduct"  onclick="addItem(${option.id}, '${csrf}')" >
                           <h6 class="font-main my-2" style="font-size: 14px"> ${listItem[0].price1} - ${option[text]} </h6>
                       </button>
                   `;
                } else {
                    item = `
                       <button class="product mx-1 mb-2 thisproduct"  onclick="addItem(${option.id}, '${csrf}')" data-toggle="modal" data-target="#modalItems">
                           <h6 class="font-main my-2" style="font-size: 14px"> ${option[text]} </h6>
                       </button>
                   `;
                }

                $('#productsCategorys').append(item);
            });
        }
    });
}


function addItem(id, csrf) {
    $('.body-items').empty();
    $.ajax({
        type: 'POST',
        url: "/erp/public/getItem/" + id,
        data: {
            _token: csrf,
        },
        success: function (data) {
            if (data.list.length == 1) {
                confirmData(data)
            } else {
                createModal(data)
            }

        }
    });
}
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


function confirmData(data) {
    let id = IDGenertaor();
    let storeId = $('#stores').val();
    let item = {
        unitId: data.list[0].unitId,
        itemId: data.list[0].itemId,
        unit_name: data.list[0].unit_name,
        unit_namear: data.list[0].unit_name,
        unit_nameen: data.list[0].unit_nameen,
        price: data.list[0].price1,
        qtn: 1,
        name: data.item.namear,
        namear: data.item.namear,
        nameen: data.item.nameen,
        id,
        added: data.item.taxRate,
        storeId,
        discount: 0,
        priceWithTax: data.item.priceWithTax,
        taxRate: data.item.taxRate
    }
    if (data.item.priceWithTax == 1) {
        let taxNew = +item.taxRate / 100;
        let lastPrice = item.price;
        item.price = item.price / (taxNew + 1);
        item.value = lastPrice - item.price;
        item.total = item.price + item.value;
    } else {
        item.value = item.price * item.taxRate / 100;
        item.total = item.price;
    }
    List.push(item);
    CreateItemBody(item);
    ListResponse = []
}

const createModal = (data) => {

    ListResponse = data;
    $('.body-items').empty();
    data.list.forEach((option) => {
        item = `
               <button class="product mx-1 mb-2 thisproduct" data-dismiss="modal" onclick="Show('${option.id}')" >
                   <h6 class="font-main my-2" style="font-size: 13px">  ${lang == "ar" ? option.unit_name : option.unit_nameen} - ${option.av_price} </h6>
               </button>
           `;
        $('.body-items').append(item);
    });
}

const Show = id => {
    let item = ListResponse.list.find(row => row.id == id);
    let newList = [];
    newList.push(item)
    ListResponse.list = newList;

    confirmData(ListResponse);
}

const CreateItemBody = (item) => {
    let { id, name, unit_name, qtn, price, added, itemId, unitId, priceWithTax, total, value } = item;
    if (lang == "en") name = item.nameen;
    if (lang == "en") name = item.nameen;
    if (lang == "en") unit_name = item.unit_nameen;
    // .substring(0, 12, '..')
    let row;

    row = `
    <tr class="row-res-${id}">
            <input type="hidden" class="form-control text-center px-0 withtax-${id}" value="${priceWithTax}"  />
            <td style="width: 140px"> ${name} - ${unit_name}</td>
        <td style="width: 60px" class="p-0 input-qtn-${unitId}-${itemId}">
          <input type="number" class="form-control text-center font-weight-bold qtn-resturant-${id}" step="0.1" onkeyup="handelQtnResturant(event,'${id}')" value="${qtn}" />
        </td>
        <td style="width: 90px" class="px-0">
          <input type="number" class="form-control px-0 text-center font-weight-bold price-resturant-${id}" step="0.1" onkeyup="handelPriceResturant(event,'${id}')" value="${+price.toFixed(3)}" />
        </td>
        <td style="width: 80px" class="px-0">
            <input disabled type="number" class="form-control text-center font-weight-bold px-0 added-resturant-${id}" step="0.1"  onkeyup="handelAddedResturant(event,'${id}')" value="${added}" />
        </td>
        <td style="width: 70px" class="nettotal-resturant-${id}"> ${+(total * qtn).toFixed(2)} </td>
        <td style="width: 70px" class="description-resturant-${id} px-0">
            <input type="text" class="form-control text-center px-0 description-resturant-${id}" onkeyup="handelDescription(event,'${id}')"  />
        </td>
        <td class="" style="width: 70px">
            <button class="text-danger btn btn-delete" onclick="DeleteRowResturant('${id}')" > <i class="fas fa-trash"></i> </button>
        </td>
    </tr>
`;
    $('.tableItems').append(row);
    CalcResturant(id)
    getTotalResturant()
}

const handelQtnResturant = (event, id) => {
    let item = List.find(el => el.id == id);
    item.qtn = event.target.value;
    CalcResturant(id, event.target.value);

}
const handelDescription = (event, id) => {
    let item = List.find(el => el.id == id);
    item.description = event.target.value;
}
const handelPriceResturant = (event, id) => {
    let item = List.find(el => el.id == id);
    item.price = event.target.value;
    CalcResturant(id, event.target.value);
}
const handelAddedResturant = (event, id) => {
    let item = List.find(el => el.id == id);
    item.added = event.target.value;
    CalcResturant(id)
}

let CalcResturant = (id) => {
    let price = $(`.price-resturant-${id}`).val();
    let qtn = $(`.qtn-resturant-${id}`).val();
    let added = $(`.added-resturant-${id}`).val();
    let total = (+qtn * +price);
    let value = (total * added) / 100;

    // let withTax = added = $(`.withtax-${id}`).val();
    // if (withTax != 1) {
    //     total = total + value;
    // }
    let item = List.find(el => el.id == id);
    item.value = value;
    // $(`.nettotal-resturant-${id}`).html(+total.toFixed(3));
    getTotalResturant()
}

const handelDelevery = () => {
    getTotalResturant()
}



function getTotalResturant() {
    let company = document.querySelector('.isTab3').value;

    if (List.length != 0) {
        $(".btn-save-pos").attr("disabled", false);
    } else {
        $(".btn-save-pos").attr("disabled", true);
    }

    let delevry = $('#price-deleiver').val() || 0;
    let total = 0;
    let taxs = 0;
    let netTotal = 0;


    List.forEach(item => {
        taxs += +item.value || 0;
        total += (+item.qtn * +item.price || 0);
        // netTotal += +company == 1 ? (+calcTax + +total + +delevry + +calcTaxBefore) * 2 : (+calcTax + +total + +delevry + +calcTaxBefore);
    });
    $('.totalTaxVal').html(+total.toFixed(2));
    let tobacco_tax = 0;
    if (+company == 1) {
        tobacco_tax = +(+total).toFixed(2);
        $('.tobacco_tax').html(tobacco_tax);
        $('.isTab3Value').val(tobacco_tax);
        taxs = +taxs * 2;
    }
    netTotal = +total + taxs + tobacco_tax;
    $('.taxVals').html(+taxs.toFixed(2)); // ضريبة مضافة
    $('.netTotal').html(+netTotal.toFixed(2));
}


function DeleteRowResturant(id) {
    List = List.filter(item => item.id !== id);
    $(`.row-res-${id}`).remove();
    getTotalResturant();
}

function PayNowResturant(status = 1, csrf = "") {
    $(".btn-save-pos").attr("disabled", true);
    let customerId = document.getElementById("customers").value;
    let netTotal = $(".netTotal").text();
    let priceDeleiver = $('#price-deleiver').val();
    // let taxSource = $("#taxSourceRate").val();
    // let taxSourceValue = $(".tax_value").html();
    let statusVal = $('#statusType').val();
    // pay type
    let storeId = $('#stores').val();
    let isTab3Value = $('.isTab3Value').val();
    // let isPrint = $('#printafter').is(':checked');


    let cash = $('#cashVal').val();
    let visa = $('#visaVal').val();
    let masterCard = $('#masterVal').val();
    let credit = $('#creditVal').val();

    let tab = $('#tab').val();
    let taxs = $('.taxVals').html();


    if (status == 2) {
        credit = netTotal;
        status = 2;
    }
    if (status != 4 && status != 1 && status != 3 && status != 2) {
        status = +statusVal;
    }

    if (statusVal != 7) {
        tab = 0;
    }
    let totalSales = $('.totalTaxVal').html();
    console.log(status);
    console.log(statusVal);



    // status == 3 تعليق
    // status == 4 توصيل
    if (List.length == 0) {
        swal("لا يوجد بيانات ");
        $(".btn-save-pos").attr("disabled", false);

    } else if (statusVal == 7 && !tab) {
        alert('لا يوجد طاولة من فضلك اضف طاولة جديدة');
        $(".btn-save-pos").attr("disabled", false);
    } else {
        List.forEach(el => {
            if (!el.itemId) el.itemId = el.item_id;
            if (!el.unitId) el.unitId = el.unit_id;
            if (!el.storeId) el.storeId = el.store_id;
        })
        $.ajax({
            type: "POST",
            url: "/erp/public/pos/save/paynow",
            data: {
                _token: csrf,
                list: List,
                status: status,
                netTotal: +netTotal,
                voiceId: hold || delevery,
                customerId: customerId,
                priceDeleiver,
                typyInvoice: +statusVal,
                cash,
                visa,
                masterCard,
                credit,
                storeId,
                isPrint: true,
                tab,
                taxs: +taxs,
                totalSales: totalSales,
                tobacco_tax: isTab3Value
            },
            success: function (res) {
                $(".btn-save-pos").attr("disabled", false);
                if (res.status == 200) {
                    List = [];
                    $("#productsCategorys").empty();
                    $(".tableItems").empty();

                    $('#cashVal').val(0);
                    $('#visaVal').val(0);
                    $('#masterVal').val(0);
                    $('#creditVal').val(0);
                    $('#price-deleiver').val("");
                    getTotalResturant();
                } else {
                    swal(res.msg);
                }
            }, error: function (e) {
                $(".btn-save-pos").attr("disabled", false);
            }
        });
    }
}

// Returned

const Returned = async () => {
    $('.holdholdTrue').addClass('d-none');
    $('.holdholdFalse').removeClass('d-none');
    getTotalResturant();
    List = []
    fetch("/erp/public/GetHoldInvoice").then(res => res.json()).then(data => {
        $('.col-products').addClass('d-none');
        $('.col-products').removeClass('d-md-block');
        $('.col-holde').removeClass('d-none');
        $('.col-holde').addClass('d-md-block');
        $('.table-holds').removeClass('d-none');

        // $('.ReturnedTrue').addClass('d-none');
        // $('.ReturnedFalse').removeClass('d-none');
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
            // console.log(data);
            if (data.order.deleiver) {
                $('#price-deleiver').val(data.order.deleiver);
            }
            data.list.forEach(el => {
                List.push(el);

                let { item_name, price, qtn, nettotal, unit_name, unitId, id, itemId, rate } = el;
                let row;
                row = `
                    <tr class="row-res-${id}">
                    <td style="width: 150px"> ${item_name} - ${unit_name}</td>
                    <td style="width: 60px" class="p-0 input-qtn-${unitId}-${itemId}">
                    <input type="number" class="form-control text-center qtn-resturant-${id}" step="0.1" onkeyup="handelQtnResturant(event,'${id}')" value="${qtn}" />
                    </td>
                    <td style="width: 90px">
                    <input type="number" class="form-control text-center price-resturant-${id}" step="0.1" onkeyup="handelPriceResturant(event,'${id}')" value="${price}" />
                    </td>
                    <td style="width: 70px">
                        <input type="number" class="form-control text-center added-resturant-${id}" step="0.1"  onkeyup="handelAddedResturant(event,'${id}')" value="${rate}" />
                    </td>
                    <td style="width: 70px" class="nettotal-resturant-${id}"> ${+nettotal.toFixed(2)} </td>

                    <td class="" style="width: 70px">
                        <button class="text-danger btn btn-delete" onclick="DeleteRowResturant('${id}')" > <i class="fas fa-trash"></i> </button>
                    </td>
                </tr>
                `;
                $('.tableItems').append(row);
                hold = data.order.id;
                getTotalResturant()
                $('.col-products').removeClass('d-none');
                $('.holdholdTrue').removeClass('d-none');
                $('.holdholdFalse').addClass('d-none');
                $('.col-products').addClass('d-md-block');
                $('.col-holde').addClass('d-none');
                $('.col-holde').removeClass('d-md-block');
                $('.table-holds').addClass('d-none');
            });
        });
}

const ReturnedFalse = () => {
    $('.holdholdTrue').removeClass('d-none');
    $('.holdholdFalse').addClass('d-none');

    $('.col-products').removeClass('d-none');
    $('.col-products').addClass('d-md-block');
    $('.col-holde').addClass('d-none');
    $('.col-holde').removeClass('d-md-block');
    $('.table-holds').addClass('d-none');


    getTotalResturant();
    List = []
}

function CancelInvoice() {
    List = [];
    getTotalResturant();
    $('.totalTaxVal').text(0);
    $('.netTotal').text(0);
    $('.taxVals').text(0);
    // pay type
    $('#cashVal').val(0);
    $('#visaVal').val(0);
    $('#masterVal').val(0);
    $('#creditVal').val(0);
    $('#productsCategorys').empty();
    $('.tableItems').empty();

    $('#cashVal').val(0);
    $('#visaVal').val(0);
    $('#masterVal').val(0);
    $('#creditVal').val(0);
    $('#price-deleiver').val("");
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



const getDelevery = () => {
    fetch("/erp/public/getDelevery").then(res => res.json()).then(data => {
        document.querySelector('.bodyDelevery').innerHTML = '<span></span>';
        let rows = data.Orders.map(({ id }) => {
            return `<button class="product mx-1 mb-2 thisproduct"  data-dismiss="modal" onclick="getDeleveryById(${id})" >
            <h6 class="font-main mt-2 mb-1" style="font-size: 13px">
                ${id}
            </h6>
        </button>`

        });
        document.querySelector('.bodyDelevery').innerHTML = rows.join('');
    });
}

const getDeleveryById = id => {
    fetch(`/erp/public/getDelevery/${id}`).then(res => res.json()).then(data => {
        List = [];
        $("#productsCategorys").empty();
        $(".tableItems").empty();

        $("#del8").remove();
        let item = ` <option value="4" class="font-main text-right" selected id="del8"> توصيل </option>`;
        $('#statusType').append(item);
        $('#price-deleiver').removeClass('d-none')
        $('#price-deleiver').val(data.invoice.deleiver ? data.invoice.deleiver : 0);
        if (data.list) {
            data.list.forEach(el => {
                List.push(el);
                let { item_name, price, qtn, nettotal, unit_name, unitId, id, itemId, rate, description } = el;
                let row;
                row = `
                    <tr class="row-res-${id}">
                    <td style="width: 140px"> ${item_name} - ${unit_name}</td>
                    <td style="width: 60px" class="p-0 input-qtn-${unitId}-${itemId}">
                        <input type="number" class="form-control text-center qtn-resturant-${id}" step="0.1" onkeyup="handelQtnResturant(event,'${id}')" value="${qtn}" />
                    </td>
                    <td style="width: 90px" class="px-0">
                    <input type="number" class="form-control px-0 text-center price-resturant-${id}" step="0.1" onkeyup="handelPriceResturant(event,'${id}')" value="${price}" />
                    </td>
                    <td style="width: 80px" class="px-0">
                        <input type="number" class="form-control px-0 text-center added-resturant-${id}" step="0.1"  onkeyup="handelAddedResturant(event,'${id}')" value="${rate}" />
                    </td>
                    <td style="width: 70px" class="nettotal-resturant-${id}"> ${+nettotal.toFixed(2)} </td>
                    <td style="width: 70px" class="description-resturant-${id} px-0">
                        <input type="text" class="form-control text-center px-0 description-resturant-${id}" value="${description}" onkeyup="handelDescription(event,'${id}')"  />
                    </td>
                    <td class="" style="width: 70px">
                        <button class="text-danger btn btn-delete" onclick="DeleteRowResturant('${id}')" > <i class="fas fa-trash"></i> </button>
                    </td>
                </tr>
                `;
                $('.tableItems').append(row);
                getTotalResturant()
            });
        }
        delevery = data.invoice.id;

    });
}
