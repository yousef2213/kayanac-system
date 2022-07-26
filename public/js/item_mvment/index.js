const Show = (event, csrf) => {
    event.preventDefault();
    let item = $("#select-items");
    let item_id = item.val();
    let unit_id = $("#select-items option:selected").data("unit");
    let from = $("#date-from").val();
    let to = $("#date-to").val();
    let data = { _token: csrf, item_id, unit_id, from, to };
    let ele = document.querySelector(".items_movement");
    $.ajax({
        type: "POST",
        url: "/erp/public/item-movement/filter",
        data,
        success: function (res) {
            ele.innerHTML = "<span></span>";
            let data = [...res.list, ...res.list2, ...res.listCollection, ...res.listCollection2];
            // console.log(data);
            if (data.length != 0) {
                let row = data.map(item => {
                    return `<tr class="text-center font-main">
                        <td> ${item.date} </td>
                        <td> ${item.source_num} - ${item.source}  </td>
                        <td> ${item.store_name} </td>
                        <td> ${item.unit_name} </td>
                        <td> ${item.qtn} </td>
                        <td> ${item.price || 0} </td>
                        <td> ${item.total || 0} </td>
                        <td> ${item.nettotal || 0} </td>
                    </tr>`;
                });
                ele.innerHTML = row.join("");
            } else {
                swal("لا يوجد بيانات");
            }
        }
    });
};
