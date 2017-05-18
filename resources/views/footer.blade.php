
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright © <span id="year"></span> <a href="#">Company</a>.</strong> All rights reserved.
</footer>
<!-- jQuery 2.2.3 -->
<script src="{{ asset ("../bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>
<!-- MomentJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
<script type="text/javascript">

	$('#year').html(moment().format('YYYY'));
</script>