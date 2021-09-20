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
	<head>
	<?php include('head.php'); ?>
	<style>
	#tech-companies-4,#tech-companies-3,#tech-companies-2{
		margin-top:50px;
	}
	.focus-btn-group{
		display:none!important
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
                        <div class="row ">
							<div class="col-lg-12">
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#home">Today's</a>
								</li>
								<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#menu1">Upcomings</a>
								</li>
								<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#menu2">In Progress</a>
								</li>
								<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#menu3">Completed</a>
								</li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div id="home" class="container tab-pane active"><br>
									<h3>Today</h3>
									<div class="table-rep-plugin">
									<div class="table-responsive mb-0" data-pattern="priority-columns">
									<table id="tech-companies-1" class="table table-striped">
									<thead>
									<tr>
									<th data-priority="1">Task Name</th>
									<th data-priority="1">Start Date</th>
									<th data-priority="3">End Date</th>
									<th data-priority="3">Last Comment</th>
									<th data-priority="3">Status</th>
									</tr>
									</thead>
									<tbody>
									<?php 
									$date  = date('Y-m-d');
									//$date  = date('2020-11-04');
									$query = "SELECT ut.* FROM user_task ut LEFT JOIN user_update uu ON ut.id=uu.task_id  WHERE ut.company_id = '".$_SESSION['user_id']."'  AND ((DATE(uu.followup_date) = '{$date}' AND uu.is_visited = '0') || DATE(ut.task_start_date) = '{$date}' AND ut.is_visited = '0') ORDER BY id DESC";
									if($sql_select=$conn->query($query))
									{
										if($sql_select->num_rows>0)
										{
											while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
											{
												$id = $result['id'];
												?>
												<tr>
												<th><?php echo $result['task_name']; ?></span></th>
												<td><?php echo date("d M Y", strtotime($result['task_start_date'])); ?></td>
												<td><?php echo date("d M Y", strtotime($result['task_end_date'])); ?></td>
												<td><?php echo date("d M Y", strtotime($result['updated'])); ?></td>
												<td class="text-white"><a href="update-task.php?id=<?php echo $result['id']; ?>" class="text-dark btn btn-primary p-1">Pending</a></td>
												</tr>
												<?php 
											}
										}
										else
										{
											?>
											<tr>
											<td>There is no today task!</td>
											</tr>
											<?php 
										}
									}
									?>
									</tbody>
									</table>
									</div>
									</div>
								</div>
								<div id="menu1" class="container tab-pane fade"><br>
									<h3>Upcoming</h3>
									<div class="table-rep-plugin">
										<div class="table-responsive mb-0" data-pattern="priority-columns">
										<table id="tech-companies-2" class="table table-striped">
										<thead>
										<tr>
										<th data-priority="1">Task Name</th>
										<th data-priority="1">Start Date</th>
										<th data-priority="3">End Date</th>
										<th data-priority="3">Last Comment</th>
										<th data-priority="3">Followup Date</th>
										<th data-priority="3">Status</th>
										</tr>
										</thead>
										<tbody>
										<?php 
										$date  = date('Y-m-d');
										$query = "SELECT ut.*, uu.followup_date FROM user_task ut LEFT JOIN user_update uu ON ut.id=uu.task_id  WHERE ut.status != 'Completed' AND ut.company_id = '".$_SESSION['user_id']."' AND (DATE(uu.followup_date) > '{$date}' || DATE(ut.task_start_date) > '{$date}') ORDER BY ut.id DESC";
										if($sql_select=$conn->query($query))
										{
											if($sql_select->num_rows>0)
											{
												while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
												{
													$id = $result['id'];
													?>
													<tr>
													<th><?php echo $result['task_name']; ?></span></th>
													<td><?php echo date("d M Y", strtotime($result['task_start_date'])); ?></td>
													<td><?php echo date("d M Y", strtotime($result['task_end_date'])); ?></td>
													<td><?php echo date("d M Y", strtotime($result['updated'])); ?></td>
													<td><?php if($result['followup_date']!="") { echo date("d M Y", strtotime($result['followup_date'])); } else { echo "--"; } ?></td>
													<td class="text-white"><a href="update-task.php?id=<?php echo $result['id']; ?>" class="text-dark btn btn-primary p-1">Waiting</a></td>
													</tr>
													<?php 
												}
											}
											else
											{
												?>
												<tr>
												<td>There is no upcoming task!</td>
												</tr>
												<?php 
											}
										}
										?>
										</tbody>
										</table>
										</div>
									</div>
								</div>
								<div id="menu2" class="container tab-pane fade"><br>
									<h3>In Progress</h3>
									<div class="table-rep-plugin">
										<div class="table-responsive mb-0" data-pattern="priority-columns">
											<table id="tech-companies-3" class="table table-striped">
												<thead>
												<tr>
												<th data-priority="1">Task Name</th>
												<th data-priority="1">Start Date</th>
												<th data-priority="3">End Date</th>
												<th data-priority="3">Last Comment</th>
												<th data-priority="3">Followup Date</th>
												<th data-priority="3">Status</th>
												</tr>
												</thead>
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
															<th><?php echo $result['task_name']; ?></span></th>
															<td><?php echo date("d M Y", strtotime($result['task_start_date'])); ?></td>
															<td><?php echo date("d M Y", strtotime($result['task_end_date'])); ?></td>
															<td><?php echo date("d M Y", strtotime($result['updated'])); ?></td>
															<td><?php echo date("d M Y", strtotime($followup_date)); ?></td>
															<td class="text-white"><a href="update-task.php?id=<?php echo $result['id']; ?>" class="text-dark btn btn-primary p-1">Progress</a></td>
															</tr>
															<?php 
														}
													}
													else
													{
														?>
														<tr>
														<td>There is no progress task!</td>
														</tr>
														<?php 
													}
												}
												?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div id="menu3" class="container tab-pane fade"><br>
									<h3>Completed</h3>
									<div class="table-rep-plugin">
										<div class="table-responsive mb-0" data-pattern="priority-columns">
										<table id="tech-companies-4" class="table table-striped">
										<thead>
											<tr>
											<th data-priority="1">Task Name</th>
											<th data-priority="1">Start Date</th>
											<th data-priority="3">End Date</th>
											<th data-priority="3">Last Comment</th>
											<th data-priority="3">Status</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										$query="SELECT * FROM user_task WHERE company_id = '".$_SESSION['user_id']."' AND status = 'Completed' ORDER BY id DESC";
										if($sql_select=$conn->query($query))
										{
											if($sql_select->num_rows>0)
											{
												while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
												{
													?>
													<tr>
													<th><?php echo $result['task_name']; ?></span></th>
													<td><?php echo date("d M Y", strtotime($result['task_start_date'])); ?></td>
													<td><?php echo date("d M Y", strtotime($result['task_end_date'])); ?></td>
													<td><?php echo date("d M Y", strtotime($result['updated'])); ?></td>
													<td class="text-white"><a href="javascript:void(0);" class="text-dark btn btn-primary p-1">Completed</a></td>
													</tr>
													<?php 
												}
											}
											else
											{
												?>
												<tr>
												<td>There is no completed task yet!</td>
												</tr>
												<?php 
											}
										}
										?>
										</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
							</div>
                            <div class="col-lg-8 d-none">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Upcoming</h4>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap table-centered mb-0">
                                                <tbody>
												<?php 
												$query="SELECT * FROM user_task WHERE company_id = '".$_SESSION['user_id']."' AND status = 'Waiting' ORDER BY id DESC";
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
																	<h5 class="text-truncate font-size-14 m-0"><a href="javascript:void(0)" class="text-dark"><?php echo $result['taskname']; ?></a></h5>
																</td>
																<td>
																	<h5 class="text-truncate font-size-14 m-0"><a href="javascript:void(0)" class="text-dark"><b>Start Date: </b><?php echo date("d M Y", strtotime($result['start'])); ?><br><br><b>End Date: </b><?php echo date("d M Y", strtotime($result['end'])); ?></a></h5>
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
																	<h5 class="text-truncate font-size-14 m-0"><a href="#" class="text-dark"><?php echo $result['taskname']; ?></a></h5>
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
																	<h5 class="text-truncate font-size-14 m-0"><a href="javascript:void(0)" class="text-dark"><?php echo $result['taskname']; ?></a></h5>
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
                       
                        </div>
                        <!-- end row -->
                    </div> <!-- container-fluid -->
                </div>
           </div>
        </div>
		<?php include('footer.php'); ?>
	</body>
</html>