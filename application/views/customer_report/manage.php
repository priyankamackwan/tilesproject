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
                    <h2>Customer Report</h2>
                    <div class="clearfix"></div>
                    
                 </div>
                    
				 <div class="x_content">
                <div class="datatable-responsive">
                    <p id="date_filter">
                        <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter date" type="text" id="ff" />
    <span id="date-label-to" class="date-label">To:<input class="date_range_filter date"  type="text" id="datepicker_to" />
</p>
                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>Sr No.</th>
                          <th>Company Name</th>
                          <th>Customer Name</th>
                          <th>Total Sales</th>
                           
                          <th>Location</th>
                          <th>Invoice No</th>
                          <th>Invoice Status</th>
                    </thead>
                    <thead>
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
        <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Users</li>
        </ol> -->
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <div class="row form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-1 col-sm-12 col-xs-12">
                                <h4>Filters:</h4>
                            </div>

                            <div class="col-md-11 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="row">

                                        

                                        <!-- Products Filter -->
                                        <div class="col-md-1 col-sm-12 col-xs-12">
                                            <label class="control-label" style="margin-top:7px;">Company Name:</label>
                                        </div>

                                        <!-- Products Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select class="form-control select2" name="company_name" style="width:100%;" id="company_name">
                                                <option value="" selected >All</option>
                                                <?php
                                                    if(!empty($order_list) && count($order_list) > 0 ){
                                                    
                                                        foreach ($order_list as $order_listKey => $order_listValue) {
                                                ?>
                                                            <option value="<?php echo $order_listValue['id']; ?>"><?php echo $order_listValue['company_name']; ?></option>
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

                                        <!-- Unit Filter -->
                                        <div class="col-md-1 col-sm-12 col-xs-12">
                                            <label class="control-label" style="margin-top:7px;">Customer Name:</label>
                                        </div>

                                        <!-- Unit Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select class="form-control select2" name="contact_person_name" style="width:100%;" id="contact_person_name">
                                                <option value="" selected >All</option>
                                                <?php
                                                    if(!empty($order_list) && count($order_list) > 0 ){
                                                    
                                                        foreach ($order_list as $order_listKey => $order_listValue) {
                                                ?>
                                                            <option value="<?php echo $order_listValue['id']; ?>"><?php echo $order_listValue['contact_person_name']; ?></option>
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

                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Status Filter -->
                                    <div class="col-md-1 col-sm-12 col-xs-12">
                                        <label class="control-label" style="margin-top:7px;">Invoice Status:</label>
                                    </div>

                                    <!-- Status Filter Dropdown -->
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <select class="form-control" name="status" style="width:100%;" id="status">
                                            <option value="">All</option>
                                            <option value="Paid">Paid</option>
                                            <option value="Unpaid">Unpaid</option>
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
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <h3 class="box-title">Customer Report</h3>
                            </div>
                        </div>
                    </div>

                    <div class="box-body">
                        <p id="date_filter">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <span id="date-label-from" class="date-label">From: </span>

                                            <input class="date_range_filter date" type="text" id="ff" />
                                        </div>

                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <span id="date-label-to" class="date-label"> To:</span>

                                            <input class="date_range_filter date"  type="text" id="datepicker_to"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </p>
                    </div>
                   
                    <div class="box-body table-responsive">
                        <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
                            <thead>
                                <th width="5%" class="text-center">Sr No.</th>
                                <th class="text-center">Company Name</th>
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Total Sales</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">Invoice No</th>
                                <th class="text-center">Invoice Status</th>
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
   
    jQuery(document).ready(function(){
     
	var dataTable1 = $('#datatables').dataTable({
			"processing": true,
			"serverSide": true,
			"ajax":{
				"url": "<?php echo base_url().$this->controller."/server_data/" ?>",
				"dataType": "json",
				"type": "POST",
                "data":function(data) {
                    data.id = $('#company_name').val();
                    data.cid = $('#contact_person_name').val();
                    data.status = $('#status').val();
                },
				},
			"columns": [
				{ "data": "id"},
                { "data": "company_name"},
                { "data": "contact_person_name"},
                { "data": "total_price"},
                { "data": "location"},
                { "data": "invoice_no"},
                { "data": "invoice_status"},
			],
			"columnDefs": [ {
				"targets": [5],
				"orderable": false
			},{
                "className": 'text-center',
                "targets":   [0],
                "orderable": false
            }],
			"rowCallback": function( row, data, index ) {
				  //$("td:eq(3)", row).css({"background-color":"navy","text-align":"center"});
			},
			"order": [[ 0, "DESC"]],
                        
		});

        
            
      $('#ff').change(function(){
 
   var i =1;  // getting column index
                var v =$(this).val();  // getting search input value
                dataTable1.api().columns(i).search(v).draw();
});
        $('#datepicker_to').change(function(){
 
   var i =2;  // getting column index
                var v =$(this).val();  // getting search input value
                dataTable1.api().columns(i).search(v).draw();
});


            $(document).on("change","#company_name",function(evt){
                dataTable1.api().draw();
            });
            $(document).on("change","#contact_person_name",function(evt){
                dataTable1.api().draw();
            });
            $(document).on("change","#status",function(evt){
                dataTable1.api().draw();
            });
            
	});
        

</script>