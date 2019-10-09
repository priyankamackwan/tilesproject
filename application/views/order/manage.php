<?php
    $this->load->view('include/leftsidemenu');
	$this->load->view('include/header');
?>
<!-- page content -->
     <!-- <div class="right_col" role="main">
            <div class="clearfix"></div>
            <div class="row">
			<?php
                        #echo '<pre>'.$this->msgDisplay;print_r($this->session->flashdata()); exit;
				echo $this->session->flashdata('edit_profile');
                                echo $this->session->flashdata('Change_msg');
                                echo $this->session->flashdata($this->msgDisplay);
			?>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
				<div class="x_title">
                    <h2><?php echo $msgName;?> Detail</h2>
                        <ul class="nav navbar-right panel_toolbox">
                        
					  <li><a href="<?php echo base_url($this->controller);?>/uploadOrders"><button class="btn btn-primary"><i class="fa fa-plus"></i> Import Orders</button></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                    
                 </div>
				 <div class="x_content">
                <div class="datatable-responsive">
                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>Sr No.</th>
                          <th>Client Name</th>
                          <th>LPO No</th>
                          <th>Delivery No</th>
                          <th>Invoice No</th>
                          <th>Sales Expense</th>
                          <th>Invoice Status</th>
                          <th>Status</th>
                          <th>Manage</th>
                    </thead>
                    <thead>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  </div>
                </div>
			</div>
		</div>
	</div>
</div> -->

<!-- Main Container start-->
<div class="content-wrapper">
    <section class="content-header">
        <?php
            echo $this->session->flashdata('edit_profile');
            echo $this->session->flashdata('Change_msg');
            echo $this->session->flashdata($this->msgDisplay);
        ?>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="row form-group">
                    <div class="col-md-3 col-sm-12 col-xs-12 pull-right">
                        <table class="pull-right">
                            <tbody>
                                <tr>
                                    <td><b>Total Invoice Amount </b></td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td><?php echo number_format($totalAmounts->invoiceAmount,2);?></td>
                                </tr> 
                                <tr>
                                    <td><b>Total Paid Amount</b> </td>
                                    <td>&nbsp;:&nbsp; </td>
                                    <td><?php echo number_format($totalAmounts->paidAmount,2);?></td>
                                </tr>
                                <tr>
                                    <td><b>Total Unpaid  Amount</b> </td>
                                    <td>&nbsp;:&nbsp; </td>
                                    <td><?php echo number_format($totalAmounts->unpaidAmount,2);?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-1 col-sm-12 col-xs-12">
                                <h4>Filters:</h4>
                            </div>

                            <div class="col-md-11 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="row">

                                        <!-- Client Filter  -->
                                        <div class="col-md-1 col-sm-12 col-xs-12" >
                                            <label class="control-label" style="margin-top:7px;">Clients:</label>
                                        </div>

                                        <!-- Client Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select name="clientList" class="form-control select2" style="width: 100%;" id="clientList">
                                                <option value="" selected="selected">All</option>
                                                <?php
                                                    if(!empty($activeUsers) && count($activeUsers) > 0 ){
                                                    
                                                        foreach ($activeUsers as $activeUsersKey => $activeUsersValue) {
                                                ?>
                                                            <option value="<?php echo $activeUsersValue['company_name']; ?>"><?php echo $activeUsersValue['company_name']; ?></option>
                                                <?php
                                                        }
                                                    }else{
                                                ?>
                                                    <option value="">-- No User Available --</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Products Filter -->
                                        <div class="col-md-1 col-sm-12 col-xs-12">
                                            <label class="control-label" style="margin-top:7px;">Products:</label>
                                        </div>

                                        <!-- Products Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select class="form-control select2" name="productsList" style="width:100%;" id="productsList">
                                                <option value="" selected >All</option>
                                                <?php
                                                    if(!empty($activeProducts) && count($activeProducts) > 0 ){
                                                    
                                                        foreach ($activeProducts as $activeProductsKey => $activeProductsValue) {
                                                ?>
                                                            <option value="<?php echo $activeProductsValue['id']; ?>"><?php echo $activeProductsValue['name'].' ( '.$activeProductsValue['design_no'].' )'; ?></option>
                                                <?php
                                                        }
                                                    }else{
                                                ?>
                                                    <option value="">-- No Product Available --</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Date Range Filter -->
                                        <div class="col-md-1 col-sm-12 col-xs-12">
                                            <label class="control-label" style="margin-top:7px;">Date:</label>
                                        </div>

                                        <!-- Date Range Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <div class="input-group">
                                                <input class="form-control" placeholder="" required="" id="salesOrderDate" name="salesOrderDate" type="text">
                                                <label class="input-group-addon btn" for="salesOrderDate">
                                                    <span class="fa fa-calendar"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <!-- Invoice Status Filter -->
                                    <div class="col-md-1 col-sm-12 col-xs-12">
                                        <label class="control-label" style="margin-top:7px;">Invoice Status:</label>
                                    </div>

                                    <!-- Invoice Status Filter Dropdown -->
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <select class="form-control" name="invoiceStatus" style="width:100%;" id="invoiceStatus">
                                            <option value="">All</option>
                                            <option value="unpaid">Unpaid</option>
                                            <option value="paid">Paid</option>
                                        </select>
                                    </div>

                                    <!-- Status Filter -->
                                    <div class="col-md-1 col-sm-12 col-xs-12">
                                        <label class="control-label" style="margin-top:7px;">Status:</label>
                                    </div>

                                    <!-- Status Filter Dropdown -->
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <select class="form-control" name="status" style="width:100%;" id="status">
                                            <option value="">All</option>
                                            <option value="pending">Pending</option>
                                            <option value="inprogress">In Progress</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $msgName;?></h3>
                        
                        <a href="<?php echo base_url($this->controller);?>/uploadOrders" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Import Orders</a>
                    </div>

                    <!-- Order table -->
                    <div class="box-body table-responsive">
                        <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
                            <thead>
                                <th class="text-center">Sr No.</th>
                                <th class="text-center">Client Name</th>
                                <th class="text-center">LPO No</th>
                                <th class="text-center">Delivery No</th>
                                <th class="text-center">Invoice No</th>
                                <th class="text-center">Sales Expense</th>
                                <th class="text-center">Invoice Status</th>
                                <th class="text-center">Delivery Status</th>
                                <th class="text-center">Creation Date</th>
                                <th class="text-center">Manage</th>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
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

<script>
    var dataTable1 = '';

    $(function(){

        //Date range picker
        $('#salesOrderDate').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD-MM-YYYY',
            },
        });

        // ,function(start, end, label) {
        //     daterangeStartValue = start.format('YYYY-MM-DD');
        //     daterangeEndValue= end.format('YYYY-MM-DD');
        //     dataTable1.draw();
        // }

        $('#salesOrderDate').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

            daterangeStartValue = picker.startDate.format('YYYY-MM-DD');
            daterangeEndValue= picker.endDate.format('YYYY-MM-DD');

            dataTable1.draw();
        });

        $('#salesOrderDate').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataTable1.draw();
        });

        daterangeStartValue = moment($('#salesOrderDate').val().split(" - ")[0],'DD/MM/YYYY').format('YYYY-MM-DD');
        daterangeEndValue = moment($('#salesOrderDate').val().split(" - ")[1],'DD/MM/YYYY').format('YYYY-MM-DD');
    });

    jQuery(document).ready(function(){
        
        // Ajax for Order table data with filters
	    dataTable1 = $('#datatables').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax":{
				"url": "<?php echo base_url().$this->controller."/server_data/" ?>",
				"dataType": "json",
				"type": "POST",
                "data":function(data) {
                    data.userName = $('#clientList').val();
                    data.productId = $('#productsList').val();
                    data.salesOrderDate = $('#salesOrderDate').val();
                    data.invoiceStatus = $('#invoiceStatus').val();
                    data.status = $('#status').val();
                    data.startdate = daterangeStartValue;
                    data.enddate = daterangeEndValue;
                },
            },
			"columns": [
				{ "data": "id"},
                { "data": "company_name"},
                { "data": "lpo_no"},
                { "data": "do_no"},
                { "data": "invoice_no"},
                { "data": "sales_expense"},
                { "data": "invoice_status"},
                { "data": "status"},
                { "data": "created"},
				{ "data": "manage"}
			],
			"columnDefs": [ {
				"targets": [0,9],
				"orderable": false
			},{
                "className": 'text-center',
                "targets":   0
            }]      
		});

        $('.search-input-select').on( 'change', function (e) {   
            // for dropdown
            var i =$(this).attr('data-column');  // getting column index
            var v =$(this).val();  // getting search input value
            dataTable1.api().columns(i).search(v).draw();
        });
	});

    
    // Filter for User list
    $(document).on("change","#clientList",function(evt){
        // dataTable1.rows().deselect();
        dataTable1.draw();
    });

    // Filter for Product list
    $(document).on("change","#productsList",function(evt){
        dataTable1.draw();
    });

    // Filter for Invoice Status
    $(document).on("change","#invoiceStatus",function(evt){
        dataTable1.draw();
    });

    // Filter for Status
    $(document).on("change","#status",function(evt){
        dataTable1.draw();
    });
</script>