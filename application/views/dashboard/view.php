<?php
  $this->load->view('include/leftsidemenu');
  $this->load->view('include/header');
?>
<!-- Main Container start-->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="box box-primary">
			<div class="box-header">
			<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="box-title">
			<i class="fa ion-stats-bars"></i> Common statistics
			</div>
			</div>
			</div>
			</div>
			<div class="box-body">
			<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-aqua">
			<div class="inner">
			<h3><?php if(isset($tatal_orders)){echo $tatal_orders;} ?></h3><p>Total Orders</p>
			</div>
			<div class="icon"><i class="ion ion-bag"></i></div>
			<a class="small-box-footer" href="/admin/Order/List">More info
			<i class="fa fa-arrow-circle-right"></i>
			</a>
			</div>
			</div>
			<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
			<div class="inner">
			<h3><?php if(isset($unpaid_orders)){echo $unpaid_orders;} ?></h3><p>Total Unpaid Orders</p>
			</div>
			<div class="icon">
			<i class="ion ion-refresh"></i>
			</div>
			<a class="small-box-footer" href="/admin/ReturnRequest/List">More info
			<i class="fa fa-arrow-circle-right"></i>
			</a>
			</div>
			</div>
			<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-green">
			<div class="inner">
			<h3><?php if(isset($all_user)){echo $all_user;} ?></h3><p>Total Registered Users</p>
			</div>
			<div class="icon">
			<i class="ion ion-person-add"></i>
			</div>
			<a class="small-box-footer" href="/admin/Customer/List">More info
			<i class="fa fa-arrow-circle-right"></i>
			</a>
			</div>
			</div>
			<div class="col-lg-3 col-xs-6">
			<div class="small-box bg-red">
			<div class="inner">
			<h3>1</h3><p>Total Low Stock Products</p>
			</div>
			<div class="icon">
			<i class="ion ion-pie-graph"></i>
			</div>
			<a class="small-box-footer" href="/admin/Report/LowStock">More info
			<i class="fa fa-arrow-circle-right"></i>
			</a>
			</div>
			</div>
			</div>
			</div>
		</div>
      </div>
    </div>
  </section>
<!-- Main content section end-->
</div>
<script>
$(document).ready(function () {
  $('#nopcommerce-common-statistics-box').on('click', 'button[data-widget="collapse"]', function () {
    var collapsed = !$('#nopcommerce-common-statistics-box').hasClass('collapsed-box');
    saveUserPreferences('/admin/Preferences/SavePreference', 'HideCommonStatisticsPanel', collapsed);
  });
});
</script>
<?php
$this->load->view('include/footer');
?>
