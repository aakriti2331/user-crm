<?php
	
include('config/function.php');
if(!isset($_SESSION['user_name']))
{
	header('location:login.php');
	exit();
}

$start_year=2000; // Starting year for dropdown list box
$end_year=2030;  // Ending year for dropdown list box

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include('head.php'); ?>
		<script langauge="javascript">
		function post_value(mm,dt,yy)
		{
			var date = yy + "-" + mm + "-" + dt;
			document.getElementById("date").value = date;
			document.Cart.submit();
			opener.document.f1.p_name.value = mm + "/" + dt + "/" + yy;
			/// cheange the above line for different date format
			self.close();
		}

		function reload(form)
		{
			var month_val=document.getElementById('month').value; // collect month value
			var year_val=document.getElementById('year').value;      // collect year value
			self.location='calender.php?month=' + month_val + '&year=' + year_val ; // reload the page
		}
		</script>
		<style>
		.main_table_calendar {
		background: #fff6f6;
		width: 600px;
		height: 450px;
		border: 1px solid #e9e9e9;
		padding: 15px;
		margin: auto;
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
					<h4 class="mb-0 font-size-18">Calendar</h4>
					<div class="page-title-right">
					<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">K2 Group</a></li>
					<li class="breadcrumb-item active">Calendar</li>
					</ol>
					</div>
					</div>
					</div>
					</div>
					<!-- end page title -->
					<div class="row">
					<div class="col-lg-12">
					<?Php
					@$month=$_GET['month'];
					@$year=$_GET['year'];

					if(!($month <13 and $month >0))
					{
						$month =date("m");  // Current month as default month
					}

					if(!($year <=$end_year and $year >=$start_year))
					{
						$year =date("Y");  // Set current year as default year 
					}

					$no_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);//calculate number of days in a month

					$j= date('w',mktime(0,0,0,$month,1,$year)); // This will calculate the week day of the first day of the month

					$adj=str_repeat("<td bgcolor='lightgrey'>*&nbsp;</td>",$j);  // Blank starting cells of the calendar 

					$blank_at_end=42-$j-$no_of_days; // Days left after the last day of the month
					if($blank_at_end >= 7)
					{
						$blank_at_end = $blank_at_end - 7 ;
					} 

					$adj2=str_repeat("<td bgcolor='lightgrey'>*&nbsp;</td>",$blank_at_end); // Blank ending cells of the calendar

					/// Starting of top line showing year and month to select ///////////////
					echo "<table class='main main_table_calendar'><td colspan=6 >

					<select name=month value='' onchange=\"reload(this.form)\" id=\"month\">
					<option value=''>Select Month</option>";
					for($p=1;$p<=12;$p++)
					{
						$dateObject   = DateTime::createFromFormat('!m', $p);
						$monthName = $dateObject->format('F');
						if($month==$p)
						{
							echo "<option value=$p selected>$monthName</option>";
						}
						else
						{
							echo "<option value=$p>$monthName</option>";
						}
					}
					echo "</select>

					<select name=year value='' onchange=\"reload(this.form)\" id=\"year\">Select Year</option>
					";
					for($i=$start_year;$i<=$end_year;$i++)
					{
						if($year==$i)
						{
							echo "<option value='$i' selected>$i</option>";
						}
						else
						{
							echo "<option value='$i'>$i</option>";
						}
					}
					echo "</select>";

					echo " </td><td align='center'><a href='calender.php'>X</a></td></tr><tr>";
					echo "<th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr><tr>";

					////// End of the top line showing name of the days of the week//////////

					//////// Starting of the days//////////

					for($i=1;$i<=$no_of_days;$i++)
					{
						if($i=='1') { $ni='01'; } if($i=='2') { $ni='02'; } if($i=='3') { $ni='03'; } if($i=='4') { $ni='04'; } if($i=='5') { $ni='05'; } if($i=='6') { $ni='06'; } if($i=='7') { $ni='07'; } if($i=='8') { $ni='08'; } if($i=='9') { $ni='09'; } if($i=='10') { $ni='10'; } if($i=='11') { $ni='11'; } if($i=='12') { $ni='12'; } if($i=='13') { $ni='13'; } if($i=='14') { $ni='14'; } if($i=='15') { $ni='15'; } if($i=='16') { $ni='16'; } if($i=='17') { $ni='17'; } if($i=='18') { $ni='18'; } if($i=='19') { $ni='19'; } if($i=='20') { $ni='20'; } if($i=='21') { $ni='21'; } if($i=='22') { $ni='22'; } if($i=='23') { $ni='23'; } if($i=='24') { $ni='24'; } if($i=='25') { $ni='25'; } if($i=='26') { $ni='26'; } if($i=='27') { $ni='27'; } if($i=='28') { $ni='28'; } if($i=='29') { $ni='29'; } if($i=='30') { $ni='30'; } if($i=='31') { $ni='31'; }
						$pv="'$month'".","."'$ni'".","."'$year'";
						$date_ct = "$year"."/"."$month"."/"."$ni"; 
						$day_name = date('l', strtotime($date_ct));
						$start = "$year"."/"."$month"."/"."$ni"; 
						$querycolorrecords = "SELECT task_name FROM user_task WHERE company_id='".$_SESSION['user_id']."' AND DATE(task_start_date) = '{$start}' ORDER BY id DESC";
						if($sql_select = $conn->query($querycolorrecords))
						{
							if($sql_select->num_rows==1)
							{
								$result = $sql_select->fetch_array(MYSQLI_ASSOC);
								$task_name = $result['task_name'];
								echo $adj."
								<td class='active-td'><div class='dropdown'><p>$i</p><a href='javascript:void(0);' onclick=\"post_value($pv)\" class='btn btn-primary text-white dropbtn'>$task_name</a>";
							}
							else if($sql_select->num_rows>1)
							{
								echo $adj."
								<td class='active-td'><div class='dropdown'><p>$i</p><a href='javascript:void(0);' onclick=\"post_value($pv)\" class='btn btn-primary text-white dropbtn'>See All Task List</a>
								<div class='dropdown-content'>";
								while($result = $sql_select->fetch_array(MYSQLI_ASSOC))
								{
									$task_name = $result['task_name'];
									echo $adj."<a href='#'>$task_name</a>";
								}
								echo $adj."</div>
								</div>";
							}
							else
							{
								echo $adj."<td><p>$i</p><a href='javascript:void(0);' onclick=\"post_value($pv)\" ></a>";
							}
						}							
						echo " </td>";
						$adj='';
						$j ++;
						if($j==7)
						{
							echo "</tr><tr>"; // start a new row
							$j=0;
						}
					}

					echo $adj2;   // Blank the balance cell of calendar at the end 
					echo "</tr></table>";
					echo "<center><a href='calender.php'>Reset Calendar</a></center>";

					?>
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