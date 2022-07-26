
const UpdateDb = async () => {
    if (navigator.onLine) {
        const req = await fetch('https://yousef-ayman.com/getLastVersionDb');
        const res = await req.json();
        if (res.status == 200) {
            if (res.data) {
                checkVersion(res);
            } else {
                alert('لا يوجد تحديث جديد');
            }
        }
    } else {
        alert("انت غير متصل بالانترنت")
    }

};


const checkVersion = async (res) => {
    const reqDb = await fetch(`check-version-db/${res.data.version}`);
    const resDb = await reqDb.json();
    if (resDb.status == 200 || resDb.download == 1) {
        ShowVersionResilt(resDb, res)
    } else {
        $('.filedb').val(res.data.file);
        $('.name').val(res.data.name);
        $('.versionDb').val(res.data.version);
        $('.badge_alert_success').removeClass("d-none")
        $('.badge_alert_success').html(resDb.msg)
    }
}


const ShowVersionResilt = (data, res) => {
    $('.name').val(res.data.name);
    $('.filedb').val(res.data.file);
    $('.versionDb').val(res.data.version);
    $('.badge_alert_success').removeClass("d-none")
    $('.badge_alert_success').html(data.msg)
}

const downloadVersion = (event) => {
    event.preventDefault();
    $('form#updaedDb').submit();
}
