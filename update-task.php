<?php
header('Cache-Control: no cache');	
include('config/function.php');
if(!isset($_SESSION['user_name']))
{
	header('location:login.php');
	exit();
}

/* set variable */
$pagename = "User";
$pagetaskname = " Add ";

/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";
$followup_date = "";
$status = "";

/* get id */
if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
}

if(isset($_POST['submit']) && $_POST['submit']=="add")
{
	/* echo "<pre>";
	print_r($_REQUEST);
	echo "</pre>";
	//exit; */ 
	$status = $_POST['status'];
	if(isset($_POST['start']) && $_POST['start']!="")
	{
		$followup_date = date('Y-m-d',(strtotime($_POST['start'])));
	}
	$comments = $_POST['comments'];
	$query_update = "UPDATE user_task SET status='".$status."',is_visited='1' WHERE id='".$id."'";

	if($sql_update = $conn->prepare($query_update))
	{
		$sql_update->execute();
		$query_up = "UPDATE user_update SET is_visited='1' WHERE task_id='".$id."'";
		$sql_up = $conn->prepare($query_up);
		$sql_up->execute();
		$query_insert = "INSERT INTO user_update SET task_id='".$id."',followup_date='".$followup_date."',comments='".$comments."',comment_by='".$_SESSION['user_id']."',status='".$status."'";
		if($sql_insert = $conn->prepare($query_insert))
		{
			$sql_insert->execute();
		}
		$_SESSION['response'] = $pagename." Update Successfully.";		
	}
	
	echo "<script>document.location.href='task_mgmt.php';</script>";
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<?php include('head.php'); ?>
	<style>
	.update_task_tbl tbody td {
		padding: 18px 10px;
	}

	.form-group label.col-form-label {
		font-weight:700;
	}
	</style>
    </head>
    <body data-sidebar="dark">
        <!-- Begin page -->
		<div id="layout-wrapper">
			<header id="page-topbar">
			<?php include('header.php'); ?>
			</header>
			<div class="vertical-menu">
				<div data-simplebar class="h-100">
				<!--- Sidemenu -->
				<div id="sidebar-menu">
				<?php include('sidebar.php'); ?>
				</div>
				<!-- Sidebar -->
				</div>
			</div>
			<!-- Left Sidebar End -->
			<!-- ============================================================== -->
			<!-- Start right Content here -->
			<!-- ============================================================== -->
			<div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">Update Task</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tasks</a></li>
                                            <li class="breadcrumb-item active">Update Task</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Update Task</h4>
                                        <form class="outer-repeater" method="post">
										<div class="table-responsive">
                                            <table class="table table-nowrap table-centered mb-0 update_task_tbl">
												<thead>
												 <tr>
													<th>Task Name</th>
													<th>Start Date</th>
													<th>End Date</th>
												  </tr>
												</thead>
                                                <tbody>
													<tr>
														<td><?php echo $newobject->getdata($conn,"user_task","task_name","id",$id); ?></td>
														<td><?php echo date("d M Y", strtotime($newobject->getdata($conn,"user_task","task_start_date","id",$id))); ?></td>
														<td><?php echo date("d M Y", strtotime($newobject->getdata($conn,"user_task","task_end_date","id",$id))); ?></td>
													</tr>														
												</tbody>
											</table>
										</div>
										<div class="table-responsive">
                                            <table class="table table-nowrap table-centered mb-0 update_task_tbl">
												<thead>
												 <tr>
													<th>Followup By</th>
													<th>Comment</th>
													<th>Next Followup Date</th>
													<th>Status</th>
												  </tr>
												</thead>
                                                <tbody>
												<?php 
												$query = "SELECT * FROM user_update WHERE task_id = '{$id}' ORDER BY id DESC";
												if($sql_select=$conn->query($query))
												{
													if($sql_select->num_rows>0)
													{
														while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
														{
															?>
															<tr>
																<td><?php echo $result['comment_by']; ?> (<?php echo date("d M Y H:i", strtotime($result['created'])); ?>)</td>
																<td><?php echo $result['comments']; ?></td>
																<td><?php if($result['followup_date']!="") { echo date("d M Y", strtotime($result['followup_date'])); } else { echo "--"; } ?></td>
																<td><?php echo $result['status']; ?></td>
															</tr>	
															<?php 
														}
													}
												}
												?>												
												</tbody>
											</table>
										</div>
										<div class="form-group row mb-4 mt-4">
											<div class="col-md-6">
												<label for="taskname" class="col-form-label">Task Status</label>
												<select class="form-control select2" name="status" onChange="CheckStatus(this.value);">
												<option value="">Select</option>
												<option value="Progress">Progress</option>
												<option value="Completed">Completed</option>
												</select>
											</div>
										</div>
										<span id="showtime"></span>
                                        <div class="row justify-content-end">
                                            <div class="col-lg-10">
                                                <button type="submit" name="submit" value="add" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
										</form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php include('footer.php'); ?>
		<script>
		function CheckStatus(status)
		{
			$(document).ready(function()
			{
				$.ajax({
					type: "GET",
					url: "update.php?",
					data: "status="+status,
					success: function(response)
					{
						//alert(response);
						if(response!="")
						{
							$('#showtime').html(response);
						}
					}
				});
			});
		}
		</script>
	</body>
</html>