<?php 

include('config/function.php');
if(!isset($_SESSION['user_name']))
{
	header('location:login.php');
	exit();
}

if(isset($_GET['id']) && $_GET['id']!="")
{
	$id = $_GET['id'];
	$query_delete="DELETE FROM revenues WHERE id='".$id."'";
	if($sql_delete=$conn->query($query_delete))
	{
		echo "<script>document.location.href='animals.php';</script>";
	    exit();					
	}
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<?php include('head.php'); ?>
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
                                    <h4 class="mb-0 font-size-18">Animal List</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Animals</a></li>
                                            <li class="breadcrumb-item active">Animals List</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body">
										<h4 class="card-title mb-4">Animal List <a href="submission.php"><button type="button" class="btn btn-primary">+</button></a></h4>
										<div class="col-lg-3">

										
										<select class="form-control"  name="category" id="category">
										<option value="">sort category</option>
										<option value="zero">herbivores</option>	
										<option value="one">omnivores</option>
										<option value="five">Carnivores</option>
										</select>
										
									
										
										<select class="form-control"  name="expectancy" id="expectancy">
										<option value="">Sort expectancy</option>
										<option value="zero">0-1 Year</option>	
										<option value="one">1-5 Year</option>
										<option value="five">5-10 Year</option>
										<option value="ten">10+ Year</option>
										</select>
										
										</div>
										<div class="table-responsive">
											<table class="table table-centered table-nowrap mb-0">
												<thead class="thead-light">
													<tr>
														<th># ID</th>
														<th>Name</th>
														<th>Image</th>
														<th>Category</th>
														<th>Description</th>
														<th>Expectancy</th>
													</tr>
												</thead>
												<tbody>
												<?php 
												$query="SELECT * FROM revenues WHERE animal_id = '".$_SESSION['user_id']."' ORDER BY id DESC";
												if($sql_select=$conn->query($query))
												{
													if($sql_select->num_rows>0)
													{
														while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
														{
															$id = $result['id'];
															?>
															<tr>
																<td><a href="javascript: void(0);" class="text-body font-weight-bold">#<?php echo $id; ?></a> </td>
																
																<td><?php echo $result['name']; ?></td>
																<td><?php echo $result['image']; ?></td>
																<td><?php echo $result['category']; ?></td>
																<td><?php echo $result['description']; ?></td>
																<td><?php echo $result['expectancy']; ?></td>
																
															</tr>
															<?php
														}
													}
												}
												?>
												</tbody>
											</table>
										</div>
										<!-- end table-responsive -->
									</div>
								</div>
							</div>
						</div>
                        <!-- end row -->
                    </div> <!-- container-fluid -->
                </div>
           </div>
        </div>
		<?php include('footer.php'); ?>
	</body>
</html>