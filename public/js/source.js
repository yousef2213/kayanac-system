
setInterval(() => {
    if (navigator.onLine) {
        checkUser()
    }
}, 20000);
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
let token_user_erp = $('meta[name="csrf-token"]').attr('content');
const checkUser = async () => {
    const req = await fetch('/erp/public/check-user')
    const res = await req.json();
    await confirmUser(res.term, res.ref)
}

const confirmUser = async (data, ref) => {
    const req = await fetch(`https://yousef-ayman.com/confirm-user/${data.secret_code}`);
    const res = await req.json();

    if (res.ref != ref.ref) {
        changeRef({ refServer: res, refUser: ref })
    }

    if (res.status == 4) {
        runUser()
    }
    if (res.status == 0) {
        // swal('السيستم غير مفعل سيتم اغلاق السيستم قريبا , من فضلك قم بالاتصال بالدعم الفني في اقرب وقت');
        fetch(`/erp/public/change-activator`);
    }
    if (res.status == 1) {
        fetch(`/erp/public/change-activator-active`);
    }
}

async function changeRef(data) {
    const req = await fetch(`/erp/public/changeRef/${data.refServer.ref}/${data.refUser.ref}`);
    const res = await req.json();
}

const runUser = async () => {
    const req = await fetch(`/erp/public/run-user`);
    const res = await req.json();
}
if (navigator.onLine) {
    checkUser()
}

