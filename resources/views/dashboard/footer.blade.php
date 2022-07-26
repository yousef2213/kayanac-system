<!-- Footer -->
{{-- <footer class="sticky-footer bg-white">
    <div class="container my-auto">

        <div class="copyright text-center my-auto">
            <span>Copyright &copy; <a href="https://www.facebook.com/YousefAymanElsayed/" target="_blank">
                    Yousef Ayman
                </a> {{ now()->year }} </span>
        </div>
    </div>
</footer> --}}
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Core plugin JavaScript-->
<script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<!-- Custom scripts for all pages-->
<script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>
<!-- Page level plugins -->
<script src="{{ asset('backend/vendor/chart.js/Chart.min.js') }}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>



<script src="{{ asset('docsupport/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ asset('docsupport/prism.js') }}" type="text/javascript"></script>
<script src="{{ asset('docsupport/init.js') }}" type="text/javascript"></script>


<script>
    window.onload = function() {
        document.querySelector('.preloader').classList.add("hiden-pre-load");
    }
</script>

@stack('scripts')
<script>
    if (navigator.onLine) {
        const CheckFunctionGlobal = async () => {
            const req1 = await fetch('https://yousef-ayman.com/getLastVersion');
            const res1 = await req1.json();
            if (res1.status == 200) {
                const req = await fetch(`/erp/public/check-version/${res1.data.version}`);
                const res = await req.json();
                if (res.status == 200) {
                    swal(res.msg);
                }
            }
        }
        CheckFunctionGlobal()
    }
</script>
{{-- clock --}}
<script>
    const hourEl = document.querySelector('.hour')
    const minuteEl = document.querySelector('.minute')
    const secondEl = document.querySelector('.second')
    const timeEl = document.querySelector('.time')
    const dateEl = document.querySelector('.date')

    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];



    function setTime() {
        const time = new Date();
        const month = time.getMonth()
        const day = time.getDay()
        const date = time.getDate()
        const hours = time.getHours()
        const hoursForClock = hours >= 13 ? hours % 12 : hours;
        const minutes = time.getMinutes()
        const seconds = time.getSeconds()
        const ampm = hours >= 12 ? 'PM' : 'AM'

        hourEl.style.transform = `translate(-50%, -100%) rotate(${scale(hoursForClock, 0, 12, 0, 360)}deg)`
        minuteEl.style.transform = `translate(-50%, -100%) rotate(${scale(minutes, 0, 60, 0, 360)}deg)`
        secondEl.style.transform = `translate(-50%, -100%) rotate(${scale(seconds, 0, 60, 0, 360)}deg)`

        timeEl.innerHTML = `${hoursForClock}:${minutes < 10 ? `0${minutes}` : minutes}  ${seconds} ${ampm}`
        dateEl.innerHTML = `${days[day]}, ${months[month]} <span class="circle">${date}</span>`
    }

    const scale = (num, in_min, in_max, out_min, out_max) => {
        return (num - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;
    }

    setTime()

    setInterval(setTime, 1000)
</script>
<script src="{{ asset('boot5/bootstrap.min.js') }}"></script>

<script src={{ asset('js/source.js') }}></script>
<script src={{ asset('js/configration/index.js') }}></script>
