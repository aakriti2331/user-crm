<!-- End Page-content -->
<footer class="footer">
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-6">
			<script>document.write(new Date().getFullYear())</script> © ADS N URL.
		</div>
		<div class="col-sm-6">
			<div class="text-sm-right d-none d-sm-block">
				Design & Develop by ADS N URL
			</div>
		</div>
	</div>
</div>
</footer>
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<!-- bootstrap datepicker -->
<script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Summernote js -->
<script src="assets/libs/summernote/summernote-bs4.min.js"></script>
<!-- form repeater js -->
<script src="assets/libs/jquery.repeater/jquery.repeater.min.js"></script>
<script src="assets/js/pages/task-create.init.js"></script>
<script src="assets/js/app.js"></script>
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">New Task Alert</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body" id="tasklist">
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
window.setInterval(function () {
$.ajax({
	type: "GET",
	url: "checktask.php?",
	data: "userId="+<?php echo $_SESSION['user_id']; ?>,
	success: function(response)
	{
		//alert(response);
		if(response!="")
		{
			$('#tasklist').html(response);
			$('#myModal').modal('show');
		}
	}
});
}, 500000);

</script>