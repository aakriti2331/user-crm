<?php 

include('config/function.php');
if(!isset($_SESSION['user_name']))
{
	header('location:login.php');
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from themesbrand.com/skote/layouts/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 27 Oct 2020 11:40:16 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Dashboard | Skote - Responsive Bootstrap 4 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
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
                                    <h4 class="mb-0 font-size-18">Task List</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tasks</a></li>
                                            <li class="breadcrumb-item active">Task List</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-lg-8">
								<div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Today Task</h4>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-centered mb-0">
                                                <tbody>
												<?php 
												$date  = date('Y-m-d');
												$query = "SELECT ut.* FROM user_task ut LEFT JOIN user_update uu ON ut.id=uu.task_id  WHERE company_id = '".$_SESSION['user_id']."' AND (DATE(uu.followup_date) = '{$date}' || DATE(ut.task_start_date) = '{$date}') ORDER BY id DESC";
												if($sql_select=$conn->query($query))
												{
													if($sql_select->num_rows>0)
													{
														while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
														{
															$id = $result['id'];
															
															?>
															<tr>
																<td style="width: 60px;">
																	<div class="custom-control custom-checkbox">
																		<input type="checkbox" class="custom-control-input" id="customCheck1">
																		<label class="custom-control-label" for="customCheck1"></label>
																	</div>
																</td>
																<td>
																	<h5 class="text-truncate font-size-14 m-0"><a href="javascript:void(0)" class="text-dark"><?php echo $result['task_name']; ?></a></h5>
																</td>
																<td>
																	<h5 class="text-truncate font-size-14 m-0"><a href="javascript:void(0)" class="text-dark"><b>Start Date: </b><?php echo date("d M Y", strtotime($result['task_start_date'])); ?><br><br><b>End Date: </b><?php echo date("d M Y", strtotime($result['task_end_date'])); ?></a></h5>
																</td>
																<td>
																	<div class="text-center">
																		<span class="badge badge-pill badge-soft-secondary font-size-11"><a href="update-task.php?id=<?php echo $result['id']; ?>" class="text-dark">Pending</a></span>
																	</div>
																</td>
															</tr>
															<?php 
														}
													}
												}
												?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Upcoming</h4>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-centered mb-0">
                                                <tbody>
												<?php 
												$date  = date('Y-m-d');
												$query = "SELECT ut.* FROM user_task ut LEFT JOIN user_update uu ON ut.id=uu.task_id  WHERE company_id = '".$_SESSION['user_id']."' AND (DATE(uu.followup_date) > '{$date}' || DATE(ut.task_start_date) > '{$date}') ORDER BY id DESC";
												if($sql_select=$conn->query($query))
												{
													if($sql_select->num_rows>0)
													{
														while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
														{
															$id = $result['id'];
															
															?>
															<tr>
																<td style="width: 60px;">
																	<div class="custom-control custom-checkbox">
																		<input type="checkbox" class="custom-control-input" id="customCheck1">
																		<label class="custom-control-label" for="customCheck1"></label>
																	</div>
																</td>
																<td>
																	<h5 class="text-truncate font-size-14 m-0"><a href="javascript:void(0)" class="text-dark"><?php echo $result['task_name']; ?></a></h5>
																</td>
																<td>
																	<h5 class="text-truncate font-size-14 m-0"><a href="javascript:void(0)" class="text-dark"><b>Start Date: </b><?php echo date("d M Y", strtotime($result['task_start_date'])); ?><br><br><b>End Date: </b><?php echo date("d M Y", strtotime($result['task_end_date'])); ?></a></h5>
																</td>
																<td>
																	<div class="text-center">
																		<span class="badge badge-pill badge-soft-secondary font-size-11"><a href="update-task.php?id=<?php echo $result['id']; ?>" class="text-dark">Waiting</a></span>
																	</div>
																</td>
															</tr>
															<?php 
														}
													}
												}
												?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">In Progress</h4>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-centered mb-0">
                                                <tbody>
                                                <?php 
												$query="SELECT * FROM user_task WHERE company_id = '".$_SESSION['user_id']."' AND status = 'Progress' ORDER BY id DESC";
												if($sql_select=$conn->query($query))
												{
													if($sql_select->num_rows>0)
													{
														while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
														{
															$id = $result['id'];
															$followup_date = $newobject->getdata($conn,"user_update","followup_date","task_id",$id);
															?>
															<tr>
																<td style="width: 60px;">
																	<div class="custom-control custom-checkbox">
																		<input type="checkbox" class="custom-control-input" id="customCheck1">
																		<label class="custom-control-label" for="customCheck1"></label>
																	</div>
																</td>
																<td>
																	<h5 class="text-truncate font-size-14 m-0"><a href="#" class="text-dark"><?php echo $result['task_name']; ?></a></h5>
																</td>
																<td>
																	<h5 class="text-truncate font-size-14 m-0"><a href="javascript:void(0)" class="text-dark"><b>Followup Date: </b><?php echo date("d M Y", strtotime($followup_date)); ?></a></h5>
																</td>
																<td>
																	<div class="text-center">
																		<span class="badge badge-pill badge-soft-secondary font-size-11"><a href="update-task.php?id=<?php echo $result['id']; ?>">In Progress</a></span>
																	</div>
																</td>
															</tr>
															<?php 
														}
													}
												}
												?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Completed</h4>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-centered mb-0">
                                                <?php 
												$query="SELECT * FROM user_task WHERE company_id = '".$_SESSION['user_id']."' AND status = 'Completed' ORDER BY id DESC";
												if($sql_select=$conn->query($query))
												{
													if($sql_select->num_rows>0)
													{
														while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
														{
															$id = $result['id'];
															?>
															<tr>
																<td style="width: 60px;">
																	<div class="custom-control custom-checkbox">
																		<input type="checkbox" class="custom-control-input" id="customCheck1">
																		<label class="custom-control-label" for="customCheck1"></label>
																	</div>
																</td>
																<td>
																	<h5 class="text-truncate font-size-14 m-0"><a href="javascript:void(0)" class="text-dark"><?php echo $result['task_name']; ?></a></h5>
																</td>
																<td>
																	<div class="text-center">
																		<span class="badge badge-pill badge-soft-secondary font-size-11">Completed</span>
																	</div>
																</td>
															</tr>
															<?php 
														}
													}
												}
												?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3">Tasks</h4>
                                        <div id="task-chart" class="apex-charts"></div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <!-- end row -->
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Skote.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-right d-none d-sm-block">
                                    Design & Develop by Themesbrand
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title px-3 py-4">
                    <a href="javascript:void(0);" class="right-bar-toggle float-right">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                    <h5 class="m-0">Settings</h5>
                </div>
                <!-- Settings -->
                <hr class="mt-0" />
                <h6 class="text-center mb-0">Choose Layouts</h6>
                <div class="p-4">
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch" checked />
                        <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
                    </div>
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css" />
                        <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="custom-control custom-switch mb-5">
                        <input type="checkbox" class="custom-control-input theme-choice" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css" />
                        <label class="custom-control-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>
                </div>
            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
        <script src="assets/js/pages/tasklist.init.js"></script>
        <script src="assets/js/app.js"></script>
    </body>
<!-- Mirrored from themesbrand.com/skote/layouts/vertical/tasks-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 27 Oct 2020 11:41:21 GMT -->
</html>