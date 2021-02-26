
</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

@yield('scripts')

<!--  Charts Plugin -->
<script src="assets/js/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>

<!--  Search Core JS    -->
<script src="assets/js/search.js"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>

@yield('notification')
@yield('reloadjs')

<script>
    var token = '{{ Session::token() }}';
    setTimeout(function() {
    $.ajax({
        method: 'GET',
        url: '{{ route('checkautstatus') }}',
        data: {
        _token: token,
        }
    }).done(function(msg) {
        if (msg['status'] == true) {
        window.location.reload();
        }
    })
    }, 1000);

  </script>


</html>