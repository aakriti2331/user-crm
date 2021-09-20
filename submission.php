<?php
header('Cache-Control: no cache');	
include('config/function.php');
if(!isset($_SESSION['user_name']))
{
	header('location:login.php');
	exit();
}

/* set variable */
$pagename = "Submission";
$pagetaskname = " Submit ";

/* set var blank */
$id = "";
$msg = "";	
$sess_msg = "";
$animal_id = "";
$name = "";
$category = "";
$description = "";
$expectancy = "";
$image = "";

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
	exit; */
	$animal_id = $_POST['animal_id'];
	$name = $_POST['name'];
	$category = $_POST['category'];
	$description = $_POST['description'];
	$expectancy = $_POST['expectancy'];
	$filename = $_FILES["image"]["name"];
    	$tempname = $_FILES["image"]["tmp_name"];  
	$folder = "assets/images/".$filename;
	
      
	/* check title in database */
	
			if($id!="")
			{
								$query_update = "UPDATE revenues SET name='".$name."',animal_id='".$animal_id."',category='".$category."',description='".$description."',image='".$filename."' WHERE id='".$id."'";

				if($sql_update = $conn->prepare($query_update))
				{
					$sql_update->execute();
					$_SESSION['response'] = $pagename." Update Successfully.";		
				}
			}
			else
			{
								$query_insert = "INSERT INTO revenues SET animal_id='".$animal_id."',name='".$name."',description='".$description."',category='".$category."',expectancy='".$expectancy."',image='".$filename."'";

									
if($sql_insert = $conn->prepare($query_insert))
				{
					$sql_insert->execute();
					$id = mysqli_insert_id($conn);
					$_SESSION['response'] = $pagename." Added Successfully.";
				}
			}
		
	
	echo "<script>document.location.href='animals.php';</script>";
	exit;
}

/* Listing  */
if($id!="")
{
    $query_select="SELECT * FROM revenues WHERE id='".$id."'";
	if($sql_select=$conn->query($query_select))
	{ 
		if($sql_select->num_rows>0)
		{
			$result=$sql_select->fetch_array(MYSQLI_ASSOC);
			$animal_id = $result['animal_id'];
			
			$name = $result['name'];
			$category = $result['category'];
			$image = $result['image'];
			$description = $result['description'];
			$expectancy = $result['expectancy'];
			$pagetaskname = " Update ";
		}
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
                                    <h4 class="mb-0 font-size-18">Create Animal</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Animal</a></li>
                                            <li class="breadcrumb-item active">Create Animal</li>
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
                                        <h4 class="card-title mb-4">Create New Animal</h4>
                                        <form class="outer-repeater" method="post" autocomplete="off" enctype="multipart/form-data">
										<input type="hidden" name="animal_id" value="<?php echo $_SESSION['user_id']; ?>">
										<div class="form-group row mb-4">
											<label for="expense" class="col-form-label col-lg-2">Name of the Animal</label>
											<div class="col-lg-10">
												<input id="name" name="name" value="<?php echo $name; ?>" type="text" class="form-control" placeholder="Enter Name of Animal...">
											</div>
										</div>
										<div class="form-group row mb-4">
											<label for="revenue" class="col-form-label col-lg-2">Category</label>
											<div class="col-lg-10">
												 <input  type="radio" id="herbivores" name="category" value="herbivores">
 													 <label for="html">Herbivores</label><br>
 													 <input type="radio" id="omnivores" name="category" value="omnivores">
														  <label for="css">Omnivores</label><br>
														  <input type="radio" id="carnivores" name="category" value="carnivores">
 														 <label for="javascript">Carnivores</label>				
												
											</div>
										</div>
										<div class="form-group row mb-4">
											<label for="expense" class="col-form-label col-lg-2">Desription</label>
											<div class="col-lg-10">
												<input id="description" name="description" value="<?php echo $description; ?>" type="text" class="form-control" placeholder="Enter description">
											</div>
											<label for="revenue" class="col-form-label col-lg-2">Life expectancy</label>
											<div class="col-lg-10">

												<select class="form-control"  name="expectancy" id="expectancy">
														 <option value="">Select Value</option>
													  <option value="zero">0-1 Year</option>	
													  <option value="one">1-5 Year</option>
													<option value="five">5-10 Year</option>
													<option value="ten">10+ Year</option>
																	</select>
												</div>
										</div>
									
										
										
											<div class="form-group row mb-4">
											<label class="col-form-label col-lg-2">Image</label>
											<div class="col-lg-10">
												<div class="col-lg-10">
													<input type="file" name="image" value="" class="form-control" placeholder="image"  />
												</div>
											</div>
										
										</div>
                                        <div class="row justify-content-end">
                                            <div class="col-lg-10">
                                                <button type="submit" name="submit" value="add" class="btn btn-primary"><?php echo $pagetaskname; ?></button>
                                            </div>
                                        </div>
										</form>
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