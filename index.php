<?php
if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('GMT');
}
include('config/function.php'); 
if(!isset($_SESSION['user_name']) || empty($_SESSION['user_name']))
{
	header('location:login.php');
	exit();
}
$query = "SELECT month(ut.task_end_date) as month, u.name as name, sum(IF(DATE(ut.`task_com_date`)<=DATE(ut.`task_end_date`),1,0)) as completionavg FROM user_task ut LEFT JOIN users u ON u.id=ut.company_id WHERE ut.status='Completed' AND ut.company_id='".$_SESSION['user_id']."' group by u.name,month(ut.task_end_date)";
if($sql_select=$conn->query($query))
{
	if($sql_select->num_rows>0)
	{
		$groupArray = array();
		while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
		{
			$groupArray[] = array('Month'=>date("F", mktime(0, 0, 0, $result['month'], 10)),$result['name']=>$result['completionavg']);
		}
		$json_encode = json_encode($groupArray);	
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Dashboard | K2 Group</title>
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
<link href="assets/css/style.css" id="app-style" rel="stylesheet" type="text/css" />
<style>
#chartdiv {
  width: 989px;
  height: 500px;
}
#piediv{
	height: 414px;
}
</style>
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/dataviz.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<!-- Chart code -->
<script>
am4core.ready(function() {
// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end
// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);
// Add data
chart.data = <?php echo $json_encode ?>
// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "Month";
categoryAxis.renderer.grid.template.location = 0;
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.inside = true;
valueAxis.renderer.labels.template.disabled = true;
valueAxis.min = 0;
// Create series
function createSeries(field, name) {
  // Set up series
  var series = chart.series.push(new am4charts.ColumnSeries());
  series.name = name;
  series.dataFields.valueY = field;
  series.dataFields.categoryX = "Month";
  series.sequencedInterpolation = true;
  // Make it stacked
  series.stacked = true;
  // Configure columns
  series.columns.template.width = am4core.percent(60);
  series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";
  // Add label
  var labelBullet = series.bullets.push(new am4charts.LabelBullet());
  labelBullet.label.text = "{valueY}";
  labelBullet.locationY = 0.5;
  labelBullet.label.hideOversized = true;
  return series;
}
createSeries("<?php echo $newobject->getdata($conn,"users","name","id",$_SESSION['user_id']); ?>", "<?php echo $newobject->getdata($conn,"users","name","id",$_SESSION['user_id']); ?>");
// Legend
chart.legend = new am4charts.Legend();
}); // end am4core.ready()
</script>
<script>
am4core.ready(function() {
// Themes begin
am4core.useTheme(am4themes_dataviz);
am4core.useTheme(am4themes_animated);
// Themes end
var container = am4core.create("piediv", am4core.Container);
container.width = am4core.percent(100);
container.height = am4core.percent(100);
container.layout = "horizontal";
var chart = container.createChild(am4charts.PieChart);
// Add data
chart.data = [
{
  "country": "<?php echo $newobject->getdata($conn,"users","name","id",$_SESSION['user_id']); ?>",
  "litres": <?php echo $newobject->getTotalTask($conn,$_SESSION['user_id']); ?>,
  "subData": [{ name: "Success", value: <?php echo $newobject->onTime($conn,$_SESSION['user_id']); ?> }, { name: "Fail", value: <?php echo $newobject->behindTime($conn,$_SESSION['user_id']); ?> }]
}
];
// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "litres";
pieSeries.dataFields.category = "country";
pieSeries.slices.template.states.getKey("active").properties.shiftRadius = 0;
//pieSeries.labels.template.text = "{category}\n{value.percent.formatNumber('#.#')}%";
pieSeries.slices.template.events.on("hit", function(event) {
  selectSlice(event.target.dataItem);
})
var chart2 = container.createChild(am4charts.PieChart);
chart2.width = am4core.percent(30);
chart2.radius = am4core.percent(80);
// Add and configure Series
var pieSeries2 = chart2.series.push(new am4charts.PieSeries());
pieSeries2.dataFields.value = "value";
pieSeries2.dataFields.category = "name";
pieSeries2.slices.template.states.getKey("active").properties.shiftRadius = 0;
//pieSeries2.labels.template.radius = am4core.percent(50);
//pieSeries2.labels.template.inside = true;
//pieSeries2.labels.template.fill = am4core.color("#ffffff");
pieSeries2.labels.template.disabled = true;
pieSeries2.ticks.template.disabled = true;
pieSeries2.alignLabels = false;
pieSeries2.events.on("positionchanged", updateLines);
var interfaceColors = new am4core.InterfaceColorSet();
var line1 = container.createChild(am4core.Line);
line1.strokeDasharray = "2,2";
line1.strokeOpacity = 0.5;
line1.stroke = interfaceColors.getFor("alternativeBackground");
line1.isMeasured = false;
var line2 = container.createChild(am4core.Line);
line2.strokeDasharray = "2,2";
line2.strokeOpacity = 0.5;
line2.stroke = interfaceColors.getFor("alternativeBackground");
line2.isMeasured = false;
var selectedSlice;
function selectSlice(dataItem) {
  selectedSlice = dataItem.slice;
  var fill = selectedSlice.fill;
  var count = dataItem.dataContext.subData.length;
  pieSeries2.colors.list = [];
  for (var i = 0; i < count; i++) {
    pieSeries2.colors.list.push(fill.brighten(i * 2 / count));
  }
  chart2.data = dataItem.dataContext.subData;
  pieSeries2.appear();
  var middleAngle = selectedSlice.middleAngle;
  var firstAngle = pieSeries.slices.getIndex(0).startAngle;
  var animation = pieSeries.animate([{ property: "startAngle", to: firstAngle - middleAngle }, { property: "endAngle", to: firstAngle - middleAngle + 360 }], 600, am4core.ease.sinOut);
  animation.events.on("animationprogress", updateLines);
  selectedSlice.events.on("transformed", updateLines);
//  var animation = chart2.animate({property:"dx", from:-container.pixelWidth / 2, to:0}, 2000, am4core.ease.elasticOut)
//  animation.events.on("animationprogress", updateLines)
}
function updateLines() {
  if (selectedSlice) {
    var p11 = { x: selectedSlice.radius * am4core.math.cos(selectedSlice.startAngle), y: selectedSlice.radius * am4core.math.sin(selectedSlice.startAngle) };
    var p12 = { x: selectedSlice.radius * am4core.math.cos(selectedSlice.startAngle + selectedSlice.arc), y: selectedSlice.radius * am4core.math.sin(selectedSlice.startAngle + selectedSlice.arc) };
    p11 = am4core.utils.spritePointToSvg(p11, selectedSlice);
    p12 = am4core.utils.spritePointToSvg(p12, selectedSlice);
    var p21 = { x: 0, y: -pieSeries2.pixelRadius };
    var p22 = { x: 0, y: pieSeries2.pixelRadius };
    p21 = am4core.utils.spritePointToSvg(p21, pieSeries2);
    p22 = am4core.utils.spritePointToSvg(p22, pieSeries2);
    line1.x1 = p11.x;
    line1.x2 = p21.x;
    line1.y1 = p11.y;
    line1.y2 = p21.y;
    line2.x1 = p12.x;
    line2.x2 = p22.x;
    line2.y1 = p12.y;
    line2.y2 = p22.y;
  }
}
chart.events.on("datavalidated", function() {
  setTimeout(function() {
    selectSlice(pieSeries.dataItems.getIndex(0));
  }, 1000);
});
}); // end am4core.ready()
</script>
<!-- HTML -->
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
					<div class="row mt-4">
						<?php 
						$query="SELECT * FROM users WHERE id = '".$_SESSION['user_id']."'"; 
						if($sql_select=$conn->query($query))
						{
							if($sql_select->num_rows>0)
							{
								while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
								{
									$id = $result['id'];
									$name=$result['name'];
									$logo=$result['logo'];
									?>
									<div class="col-md-3 block-company">
										<div class="card overflow-hidden">
											<div class="bg-soft-primary">
												<div class="row">
												<div class="col-7">
												<div class="text-primary p-3">
												<h5 class="text-primary"><?php echo $name; ?></h5>
												</div>
												</div>
												<div class="col-5 align-self-end">
												<img src="assets/images/profile-img.png" alt="" class="img-fluid">
												</div>
												</div>
											</div>
											<div class="card-body pt-0">
												<div class="row">
												<div class="col-sm-4">
												<div class="avatar-md profile-user-wid mb-4">
												<img src="assets/images/<?php echo $logo ?>" alt="" class="img-thumbnail rounded-circle <?php echo $name; ?>">
												</div>
												<h5 class="font-size-15 text-truncate">Manager</h5>
												<p class="text-muted mb-0 text-truncate"><?php echo $result['manager_name']; ?></p>
												</div>
												<div class="col-sm-8">
												<div class="pt-4">
												<div class="row">
												<div class="col-6">
												<h5 class="font-size-15"><?php echo $newobject->gettotaltask($conn,$id); ?></h5>
												<p class="text-muted mb-0">Task</p>
												</div>
												<div class="col-6">
												<h5 class="font-size-15">INR <?php echo $newobject->getRevenues($conn,$id); ?></h5>
												<p class="text-muted mb-0">Revenue</p>
												</div>
												</div>
												<div class="mt-4">
												</div>
												</div>
												</div>
												</div>
											</div>
										</div>
									</div>
									<?php 
								}
							}
						}
						?>
						<div>
							<div class="mt-5 row mx-md-3 mx-0 chart-row">
								<div class="col-md-12 first-chart chart-bg ">
									<div class="shadow bg-white p-4 ">
									<div id="chartdiv"></div>		
									</div>
								</div>
								<div class="col-md-12 first-chart chart-bg mt-5 pie-chart">
									<div class="shadow bg-white p-4 ">
									<div id="piediv"></div>		
									</div>
								</div>
								<div class="col-md-12 first-chart chart-bg mt-5 pie-chart">
									<div class="row">
										<div class="col-md-12">
											<div class="card">
												<div class="card-body">
													<h4 class="card-title">Toady's Listed Task</h4>
													<div class="table-responsive mt-4">
														<table class="table mb-0">
															<thead class="thead-light">
																<tr>
																<th data-priority="1">Task Name</th>
																<th data-priority="1">Assign To</th>
																<th data-priority="1">Start Date</th>
																<th data-priority="3">End Date</th>
																<th data-priority="3">Last Comment</th>
																<th data-priority="3">Status</th>
																</tr>
															</thead>
															<tbody>
															<?php 
															$date  = date('Y-m-d');
															$query = "SELECT ut.* FROM user_task ut LEFT JOIN user_update uu ON ut.id=uu.task_id  WHERE ut.company_id = '".$_SESSION['user_id']."' AND ((DATE(uu.followup_date) = '{$date}' AND uu.is_visited = '0') || DATE(ut.task_start_date) = '{$date}' AND ut.is_visited = '0') ORDER BY id DESC";
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
																		<th><?php echo $newobject->getdata($conn,"users","name","id",$result['company_id']); ?></th>
																		<td><?php echo date("d M Y", strtotime($result['task_start_date'])); ?></td>
																		<td><?php echo date("d M Y", strtotime($result['task_end_date'])); ?></td>
																		<td><?php echo date("d M Y", strtotime($result['updated'])); ?></td>
																		<td class="text-white"><a href="update-task.php?id=<?php echo $result['id']; ?>" class="text-white btn btn-primary p-1">Pending</a></td>
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
										</div>
									</div>
								</div>
							</div>
						</div>
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
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="assets/libs/jquery/jquery.min.js"></script>
	<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/libs/metismenu/metisMenu.min.js"></script>
	<script src="assets/libs/simplebar/simplebar.min.js"></script>
	<script src="assets/libs/node-waves/waves.min.js"></script>
	<!-- apexcharts -->
	<script src="assets/libs/apexcharts/apexcharts.min.js"></script>
	<script src="assets/js/pages/dashboard.init.js"></script>
	<!-- App js -->
	<script src="assets/js/app.js"></script>
</body>
</html>