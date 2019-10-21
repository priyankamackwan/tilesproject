<?php
  $this->load->view('include/leftsidemenu');
  $this->load->view('include/header');
?>
<style type="text/css">
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}
#loadingDiv{
  position:absolute;
  top:0px;
  background-color:#666;
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}


@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
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
							<a class="small-box-footer" href="<?php echo base_url();?>Order">More info
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
								<i class="ion ion-bag"></i>
							</div>
							<a class="small-box-footer" href="<?php echo base_url();?>Order">More info
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
							<a class="small-box-footer" href="<?php echo base_url();?>User">More info
								<i class="fa fa-arrow-circle-right"></i>
							</a>
						</div>
					</div>
					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-red">
							<div class="inner">
								<h3><?php echo $lowdata;?></h3><p>Total Low Stock Products</p>
							</div>
							<div class="icon">
								<i class="ion ion-refresh"></i>
							</div>
							<a class="small-box-footer" href="/admin/Report/LowStock">More info
								<i class="fa fa-arrow-circle-right"></i>
							</a>	
						</div>
					</div>
				</div>
			</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="box box-info " id="order-statistics-box">
							<div class="box-header with-border">
								<h3 class="box-title">
									<i class="fa fa-shopping-cart"></i> Orders
								</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-xs btn-info btn-flat margin-r-5 bg-light-blue" data-chart-role="toggle-chart" data-chart-period="year">Year</button>
									<button class="btn btn-xs btn-info btn-flat margin-r-5" data-chart-role="toggle-chart" data-chart-period="month">Month</button>
									<button class="btn btn-xs btn-info btn-flat" data-chart-role="toggle-chart" data-chart-period="week">Week</button>
									<button class="btn btn-box-tool margin-l-10" data-widget="collapse">
									<i class="fa fa-minus"></i> </button>
								</div>
							</div>
							<div class="box-body">
								<div class="chart" style="height: 300px;">
									<div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
										<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
											<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
										</div>
										<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
											<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
										</div>
									</div>
									<canvas id="order-statistics-chart" height="300" width="510" class="chartjs-render-monitor" style="display: block; width: 510px; height: 300px;"></canvas>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="box box-info " id="customer-statistics-box">
							<div class="box-header with-border">
								<h3 class="box-title">
									<i class="fa fa-user"></i> New customers
								</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-xs btn-info btn-flat margin-r-5" data-chart-role="toggle-chart" data-chart-period="year">Year</button>
									<button class="btn btn-xs btn-info btn-flat margin-r-5" data-chart-role="toggle-chart" data-chart-period="month">Month</button>
									<button class="btn btn-xs btn-info btn-flat bg-light-blue" data-chart-role="toggle-chart" data-chart-period="week">Week</button>
									<button class="btn btn-box-tool margin-l-10" data-widget="collapse">
									<i class="fa fa-minus"></i> </button>
								</div>
							</div>
							<div class="box-body">
								<div class="chart" style="height: 300px;">
									<div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
										<div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
											<div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
										</div>
										<div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
											<div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
										</div>
									</div>
								<canvas id="customer-statistics-chart" height="300" width="510" class="chartjs-render-monitor" style="display: block; width: 510px; height: 300px;"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="box box-info " id="latest-orders-box">
							<div class="box-header with-border">
								<h3 class="box-title">
									<i class="fa fa-cart-plus"></i>
									Latest Orders
									<a class="btn btn-xs btn-info btn-flat margin-l-10" href="<?php echo base_url('Order'); ?>">View All Orders</a>
								 </h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse">
									<i class="fa fa-minus"></i> </button>
								</div>
							</div>
							<div class="box-body">
							<div id="orders-grid_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
								<div class="row">
									<div class="col-md-12">
										<div class="dataTables_scroll">
											<div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px; width: 100%;">
												<div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 704px; padding-right: 0px;">
													<table class="table table-bordered table-hover table-striped dataTable no-footer" width="100%" role="grid" style="margin-left: 0px; width: 704px;">
														
													</table>
												</div>
											</div>
											<div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%;">
												<table class="table table-bordered table-hover table-striped dataTable no-footer" width="100%" id="orders-grid" role="grid" aria-describedby="orders-grid_info" style="width: 100%;">
													<thead>
															<tr role="row">
																<th rowspan="1" colspan="1" style="width: 81px;" class="text-center">Order #</th>
																<th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 103px;">Order status</th>
																<th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 261px;">Customer</th><th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 104px;">Created on</th>
																<th class="sorting_disabled button-column text-center" text-center rowspan="1" colspan="1" style="width: 69px;">View</th>
															</tr>
														</thead>
													<tbody>
														<?php
														if(isset($latest_orders) && $latest_orders!='' && count($latest_orders) >0){
															foreach ($latest_orders as $key => $value) {
																if ($value['status'] == 0) {
											                        $status = 'Pending';
											                    } elseif($value['status'] == 1) {
											                        $status ='In Progress';
											                    } else {
											                        $status ='Completed';
											                    }
											                    $view = base_url('Order/view/'.$this->utility->encode($value['id']));
														?>
														<tr role="row" class="odd">
															<td class="text-center"><?php echo $key+1;?></td>
															<td class="text-center">
																<span class="grid-report-item green"><?php echo $status;?></span>
															</td>
															<td><?php echo $value['company_name'];?>					
															</td>
															<td class="text-center"><?php echo date('d/m/Y',strtotime($value['created']));?></td>
															<td class=" button-column text-center">
																<a class="btn btn-default" href="<?php echo $view;?>"><i class="fa fa-eye"></i> View
																</a>
															</td>
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
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="box box-info " id="latest-orders-box">
							<div class="box-header with-border">
								<h3 class="box-title">
									<i class="fa fa-cart-plus"></i>
									Unpaid Orders
									<a class="btn btn-xs btn-info btn-flat margin-l-10" href="<?php echo base_url('Order'); ?>">View All Orders</a>
								 </h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse">
									<i class="fa fa-minus"></i> </button>
								</div>
							</div>
							<div class="box-body">
							<div id="orders-grid_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
								<div class="row">
									<div class="col-md-12">
										<div class="dataTables_scroll">
											<div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px; width: 100%;">
												<div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 704px; padding-right: 0px;">
													<table class="table table-bordered table-hover table-striped dataTable no-footer" width="100%" role="grid" style="margin-left: 0px; width: 704px;">
														
													</table>
												</div>
											</div>
											<div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%;">
												<table class=" table-responsive table table-bordered table-hover table-striped dataTable no-footer" width="100%" id="orders-grid" role="grid" aria-describedby="orders-grid_info" style="width: 100%;">
													<thead>
															<tr role="row">
																<th rowspan="1" colspan="1" style="width: 81px;" class="text-center">Order #</th>
																<th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 103px;">Order status</th>
																<th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 261px;">Customer</th><th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 104px;">Created on</th>
																<th class="sorting_disabled button-column text-center" rowspan="1" colspan="1" style="width: 69px;">View</th>
															</tr>
														</thead>
													<tbody>
														<?php
														if(isset($unpaid_l_orders) && $unpaid_l_orders!='' && count($unpaid_l_orders) >0){
															foreach ($unpaid_l_orders as $key => $value) {
																if ($value['status'] == 0) {
											                        $status = 'Pending';
											                    } elseif($value['status'] == 1) {
											                        $status ='In Progress';
											                    } else {
											                        $status ='Completed';
											                    }
											                    $view = base_url('Order/view/'.$this->utility->encode($value['id']));
														?>
														<tr role="row" class="odd">
															<td class="text-center"><?php echo $key+1;?></td>
															<td class="text-center">
																<span class="grid-report-item green"><?php echo $status;?></span>
															</td>
															<td><?php echo $value['company_name'];?>					
															</td>
															<td class="text-center" ><?php echo date('d/m/Y',strtotime($value['created']));?></td>
															<td class=" button-column text-center">
																<a class="btn btn-default" href="<?php echo $view;?>"><i class="fa fa-eye"></i> View
																</a>
															</td>
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
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="box box-info " id="latest-orders-box">
							<div class="box-header with-border">
								<h3 class="box-title">
									<i class="fa fa-cart-plus"></i>
									Best selling product (by quantity) 
									<a class="btn btn-xs btn-info btn-flat margin-l-10" href="<?php echo base_url('Order'); ?>">View All Orders</a>
								 </h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse">
									<i class="fa fa-minus"></i> </button>
								</div>
							</div>
							<div class="box-body">
							<div id="orders-grid_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
								<div class="row">
									<div class="col-md-12">
										<div class="dataTables_scroll">
											<div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px; width: 100%;">
												<div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 704px; padding-right: 0px;">
													<table class="table table-bordered table-hover table-striped dataTable no-footer" width="100%" role="grid" style="margin-left: 0px; width: 704px;">
														
													</table>
												</div>
											</div>
											<div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%;">
												<table class=" table-responsive table table-bordered table-hover table-striped dataTable no-footer" width="100%" id="orders-grid" role="grid" aria-describedby="orders-grid_info" style="width: 100%;">
													<thead>
															<tr role="row">
																<th rowspan="1" class="text-center" colspan="1" style="width: 81px;">Name</th>
																<th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 103px;">Total quantity</th>
																<th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 261px;">Total amount (excl tax)	</th>

																<th class="sorting_disabled button-column text-center" rowspan="1" colspan="1" style="width: 69px;">View</th>
															</tr>
														</thead>
													<tbody>
														<?php
														if(isset($sold_quantity) && $sold_quantity!='' && count($sold_quantity) >0){
															foreach ($sold_quantity as $key => $value) {
																
											                    $view = base_url('Order/view/'.$this->utility->encode($value['id']));
														?>
														<tr role="row" class="odd">
															<td><?php echo $value['name'];?></td>
															<td class="text-right">
																<span class="grid-report-item green"><?php echo $value['sold_quantity'];?></span>
															</td>
															
															<td class="text-right"><?php echo $value['sold_quantity']* $value['price'];?></td>
															<td class=" button-column text-center">
																<a class="btn btn-default" href="<?php echo $view;?>"> <i class="fa fa-eye"></i> View
																</a>
															</td>
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
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="box box-info " id="latest-orders-box">
							<div class="box-header with-border">
								<h3 class="box-title">
									<i class="fa fa-cart-plus"></i>
									Best selling product (by quantity) 
									<a class="btn btn-xs btn-info btn-flat margin-l-10" href="<?php echo base_url('Order'); ?>">View All Orders</a>
								 </h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse">
									<i class="fa fa-minus"></i> </button>
								</div>
							</div>
							<div class="box-body">
							<div id="orders-grid_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
								<div class="row">
									<div class="col-md-12">
										<div class="dataTables_scroll">
											<div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px; width: 100%;">
												<div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 704px; padding-right: 0px;">
													<table class="table table-bordered table-hover table-striped dataTable no-footer" width="100%" role="grid" style="margin-left: 0px; width: 704px;">
														
													</table>
												</div>
											</div>
											<div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%;">
												<table class=" table-responsive table table-bordered table-hover table-striped dataTable no-footer" width="100%" id="orders-grid" role="grid" aria-describedby="orders-grid_info" style="width: 100%;">
													<thead>
															<tr role="row">
																<th rowspan="1" class="text-center" colspan="1" style="width: 81px;">Name</th>
																<th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 103px;">Total quantity</th>
																<th class="sorting_disabled text-center" rowspan="1" colspan="1" style="width: 261px;">Total amount (excl tax)	</th>

																<th class="sorting_disabled button-column text-center" rowspan="1" colspan="1" style="width: 69px;">View</th>
															</tr>
														</thead>
													<tbody>
														<?php
														if(isset($sold_amount) && $sold_amount!='' && count($sold_amount) >0){
															foreach ($sold_amount as $key => $value) {
																
											                    $view = base_url('Order/view/'.$this->utility->encode($value['id']));
														?>
														<tr role="row" class="odd">
															<td><?php echo $value['name'];?></td>
															<td class="text-right">
																<span class="grid-report-item green"><?php echo $value['totalQuantity'];?></span>
															</td>
															
															<td class="text-right"><?php echo $value['amount'];?></td>
															<td class=" button-column text-center">
																<a class="btn btn-default" href="<?php echo $view;?>"><i class="fa fa-eye"></i> View
																</a>
															</td>
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
				</div>
				</div>

			</div>
		</div>
      </div>
    </div>
  </section>
<!-- Main content section end-->
</div>

<?php
$this->load->view('include/footer');
?>
	<!-- <div class="loader" id="loadingDiv" ></div> -->
<script>
$(document).ready(function () {
  $('#nopcommerce-common-statistics-box').on('click', 'button[data-widget="collapse"]', function () {
    var collapsed = !$('#nopcommerce-common-statistics-box').hasClass('collapsed-box');
    saveUserPreferences('/admin/Preferences/SavePreference', 'HideCommonStatisticsPanel', collapsed);
  });
});
</script>
<script>
    $(document).ready(function () {
        var osCurrentPeriod='';

        $('#order-statistics-box').on('click', 'button[data-widget="collapse"]', function () {
            var collapsed = !$('#order-statistics-box').hasClass('collapsed-box');
            saveUserPreferences('/admin/Preferences/SavePreference', 'Reports.HideOrderStatisticsPanel', collapsed);
            if (!collapsed) {
                $('#order-statistics-box button[data-chart-role="toggle-chart"]').removeAttr('disabled');
                if (!osCurrentPeriod) {
                    $('#order-statistics-box button[data-chart-role="toggle-chart"][data-chart-period="week"]').trigger('click');
                }
            } else {
                $('#order-statistics-box button[data-chart-role="toggle-chart"]').attr('disabled', 'disabled');
            }
        });
var footerLine1 =[];
        var osConfig = {
            type: 'line',
            data: {
                labels: [],
                
                datasets: [
                    {
                        label: "Orders",
                        fillColor: "rgba(60,141,188,0.9)",
                        strokeColor: "rgba(60,141,188,0.8)",
                        pointColor: "#3b8bba",
                        pointStrokeColor: "rgba(60,141,188,1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(60,141,188,1)",
                        borderColor: 'rgba(60, 141, 188, 0.7)',
                        backgroundColor: 'rgba(44, 152, 214, 0.5)',
                        pointBorderColor: 'rgba(37, 103, 142, 0.9)',
                        pointBackgroundColor: 'rgba(60, 141, 188, 0.4)',
                        pointBorderWidth: 1,
                        data: []
                    }
                ]
            },
            
            options: {
                legend: {
                    display: true,
		            position: "bottom",
		            labels: {
		                fontColor: "#333",
		                fontSize: 16
		            }
                },
	            tooltips: {
	                enabled: true,
	                mode: 'single',
	                callbacks: {
	                    footer: function(tooltipItems, data) {
	                    	console.log(footerLine1[tooltipItems[0].index]);
	                    	return 'Order Amount  ' + footerLine1[tooltipItems[0].index];
    					}
	                }
	            },
                scales: {
                    xAxes: [{
                        display: true,
                        ticks: {
                            userCallback: function (dataLabel, index) {
                                if (window.orderStatistics && window.orderStatistics.config.data.labels.length > 12) {
                                    return index % 5 === 0 ? dataLabel : '';
                                }
                                return dataLabel;
                            }
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            userCallback: function (dataLabel, index) {
                                return (dataLabel ^ 0) === dataLabel ? dataLabel : '';
                            },
                            min: 0
                        }
                    }]
                },
               
            	
                showScale: true,
                scaleShowGridLines: false,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                scaleShowHorizontalLines: true,
                scaleShowVerticalLines: true,
                bezierCurve: true,
                pointDot: false,
                pointDotRadius: 4,
                pointDotStrokeWidth: 1,
                pointHitDetectionRadius: 20,
                datasetStroke: true,
                datasetFill: true,
                maintainAspectRatio: false,
                responsive: true
            }
        };

        function changeOsPeriod(period) {
            var osLabels = [];
            var osData = [];
            var osfooterLine1=[];

            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo base_url();?>Dashboard/orderStatistics",
                dataType: "json",
                data: {
                    period: period
                },
                success: function (data, textStatus, jqXHR) {
                	
					footerLine1=[];

                    for (var i = 0; i < data.length; i++) {
                        osLabels.push(data[i].date);
                        osData.push(data[i].value);
                        footerLine1.push(data[i].amount);
                    }
                    if (!window.orderStatistics) {
                        osConfig.data.labels = osLabels;
                        osConfig.data.datasets[0].data = osData;
                       // osConfig.footerLine1 = osfooterLine1;
                        //console.log(osConfig);
                        osConfig.data.scales =
                        window.orderStatistics = new Chart(document.getElementById("order-statistics-chart").getContext("2d"), osConfig);
                    } else {
                        window.orderStatistics.config.data.labels = osLabels;
                        window.orderStatistics.config.data.datasets[0].data = osData;
                      //  window.orderStatistics.config.footerLine1 = osfooterLine1;
                        window.orderStatistics.update();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#loadOrderStatisticsAlert").click();
                }
            });
        }

        $('#order-statistics-box button[data-chart-role="toggle-chart"]').on('click', function () {
            var period = $(this).attr('data-chart-period');
            osCurrentPeriod = period;
            changeOsPeriod(period);
            $('#order-statistics-box button[data-chart-role="toggle-chart"]').removeClass('bg-light-blue');
            $(this).addClass('bg-light-blue');
        });


                $('#order-statistics-box button[data-chart-role="toggle-chart"][data-chart-period="week"]').trigger('click');
                });
</script>
<script>
    $(document).ready(function () {
        var csCurrentPeriod;

        $('#customer-statistics-box').on('click', 'button[data-widget="collapse"]', function () {
            var collapsed = !$('#customer-statistics-box').hasClass('collapsed-box');
            saveUserPreferences('/admin/Preferences/SavePreference', 'Reports.HideCustomerStatisticsPanel', collapsed);
            if (!collapsed) {
                $('#customer-statistics-box button[data-chart-role="toggle-chart"]').removeAttr('disabled');
                if (!csCurrentPeriod) {
                    $('#customer-statistics-box button[data-chart-role="toggle-chart"][data-chart-period="week"]').trigger('click');
                }
            } else {
                $('#customer-statistics-box button[data-chart-role="toggle-chart"]').attr('disabled', 'disabled');
            }
        });

        var csConfig = {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "New customers",
                        fillColor: "rgba(60,141,188,0.9)",
                        strokeColor: "rgba(60,141,188,0.8)",
                        pointColor: "#00a65a",
                        pointStrokeColor: "rgba(0,166,90,1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(0,166,90,1)",
                        borderColor: 'rgba(0,166,90, 1)',
                        backgroundColor: 'rgba(0,166,90,0.5)',
                        pointBorderColor: 'rgba(0,166,90,0.7)',
                        pointBackgroundColor: 'rgba(0,166,90,0.2)',
                        pointBorderWidth: 1,
                        data: []
                    }
                ]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        display: true,
                        ticks: {
                            userCallback: function (dataLabel, index) {
                                if (window.customerStatistics && window.customerStatistics.config.data.labels.length > 12) {
                                    return index % 5 === 0 ? dataLabel : '';
                                }
                                return dataLabel;
                            }
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            userCallback: function (dataLabel, index) {
                                return (dataLabel ^ 0) === dataLabel ? dataLabel : '';
                            },
                            min: 0
                        }
                    }]
                },
                showScale: true,
                scaleShowGridLines: false,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                scaleShowHorizontalLines: true,
                scaleShowVerticalLines: true,
                bezierCurve: true,
                pointDot: false,
                pointDotRadius: 4,
                pointDotStrokeWidth: 1,
                pointHitDetectionRadius: 20,
                datasetStroke: true,
                datasetFill: true,
                maintainAspectRatio: false,
                responsive: true
            }
        };

        function changeCsPeriod(period) {
            var csLabels = [];
            var csData = [];

            $.ajax({
                cache: false,
                type: "POST",
                url: "<?php echo base_url();?>Dashboard/userStatistics",
                dataType: "json",
                data: {
                    period: period
                },
                beforeSend: function(){
			        $('#image').show();
			    },
			    complete: function(){
			        $('#image').hide();
			    },
                success: function (data, textStatus, jqXHR) {
                    for (var i = 0; i < data.length; i++) {
                        csLabels.push(data[i].date);
                        csData.push(data[i].value);
                    }

                    if (!window.customerStatistics) {
                        csConfig.data.labels = csLabels;
                        csConfig.data.datasets[0].data = csData;
                        csConfig.data.scales =
                        window.customerStatistics = new Chart(document.getElementById("customer-statistics-chart").getContext("2d"), csConfig);
                    } else {
                        window.customerStatistics.config.data.labels = csLabels;
                        window.customerStatistics.config.data.datasets[0].data = csData;
                        window.customerStatistics.update();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#loadCustomerStatisticsAlert").click();
                }
            });
        }

        $('#customer-statistics-box button[data-chart-role="toggle-chart"]').on('click', function () {
            var period = $(this).attr('data-chart-period');
            csCurrentPeriod = period;
            changeCsPeriod(period);
            $('#customer-statistics-box button[data-chart-role="toggle-chart"]').removeClass('bg-light-blue');
            $(this).addClass('bg-light-blue');
        });


                $('#customer-statistics-box button[data-chart-role="toggle-chart"][data-chart-period="week"]').trigger('click');
                });
</script>
<script>
        $(document).ready(function () {
            $('#popular-search-terms-box').on('click', 'button[data-widget="collapse"]', function () {
                var collapsed = !$('#popular-search-terms-box').hasClass('collapsed-box');
                saveUserPreferences('/admin/Preferences/SavePreference', 'Reports.HidePopularSearchTermsReport', collapsed);
            });
        });
    </script>
    <script>
            $(document).ready(function () {
                $('#latest-orders-box').on('click', 'button[data-widget="collapse"]', function () {
                    var collapsed = !$('#latest-orders-box').hasClass('collapsed-box');
                    saveUserPreferences('/admin/Preferences/SavePreference', 'Reports.HideLatestOrdersPanel', collapsed);
                });
            });
        </script>