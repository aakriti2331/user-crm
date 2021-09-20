<?php $img_url = "https://demo.mbrcables.com/k2-crm/"; ?>
<div class="navbar-header">
	<div class="d-flex">
		<!-- LOGO -->
		<div class="navbar-brand-box">
			<a href="<?php echo $site_root; ?>" class="logo logo-dark">
				<span class="logo-sm">
					<img src="<?php echo $img_url; ?>assets/images/<?php echo ucfirst($newobject->getdata($conn,"users","logo","id",$_SESSION['user_id'])); ?>" alt="" height="22">
				</span>
				<span class="logo-lg">
					<img src="<?php echo $img_url; ?>assets/images/<?php echo ucfirst($newobject->getdata($conn,"users","logo","id",$_SESSION['user_id'])); ?>" alt="" height="17">
				</span>
			</a>
			<a href="<?php echo $site_root; ?>" class="logo logo-light">
				<span class="logo-sm">
					<img src="<?php echo $img_url; ?>assets/images/<?php echo ucfirst($newobject->getdata($conn,"users","logo","id",$_SESSION['user_id'])); ?>" alt="" height="22">
				</span>
				<span class="logo-lg">
					<img src="<?php echo $img_url; ?>assets/images/<?php echo ucfirst($newobject->getdata($conn,"users","logo","id",$_SESSION['user_id'])); ?>" alt="" height="19">
				</span>
			</a>
		</div>
		<button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
			<i class="fa fa-fw fa-bars"></i>
		</button>
		<div class="dropdown dropdown-mega d-none d-lg-block ml-2">
			<div class="dropdown-menu dropdown-megamenu"></div>
		</div>
	</div>
	<div class="d-flex">
		<div class="dropdown d-none d-lg-inline-block ml-1">
			<button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
				<i class="bx bx-fullscreen"></i>
			</button>
		</div>
		<div class="dropdown d-inline-block">
			<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img class="rounded-circle header-profile-user" src="<?php echo $img_url; ?>assets/images/<?php echo ucfirst($newobject->getdata($conn,"users","logo","id",$_SESSION['user_id'])); ?>"
					alt="Header Avatar">
				<span class="d-none d-xl-inline-block ml-1"><?php echo ucfirst($newobject->getdata($conn,"users","name","id",$_SESSION['user_id'])); ?></span>
				<i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
			</button>
			<div class="dropdown-menu dropdown-menu-right">
				<div class="dropdown-divider"></div>
				<a class="dropdown-item text-danger" href="logout.php"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> Logout</a>
			</div>
		</div>
	</div>
</div>