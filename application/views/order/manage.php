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
        <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Users</li>
        </ol> -->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $msgName;?></h3>
                        
                        <a href="<?php echo base_url($this->controller);?>/uploadOrders" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Import Orders</a>
                    </div>

                    <div class="box-body table-responsive">
                        <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
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
				},
			"columns": [
				{ "data": "id"},
                                { "data": "user_name"},
                                { "data": "lpo_no"},
                                { "data": "do_no"},
                                { "data": "invoice_no"},
                                { "data": "sales_expense"},
                                { "data": "invoice_status"},
                                { "data": "status"},
				{ "data": "manage"}
			],
			"columnDefs": [ {
				"targets": [0,1,2,3,4,5,6,7],
				"orderable": false
			} ],
			"rowCallback": function( row, data, index ) {
				  //$("td:eq(3)", row).css({"background-color":"navy","text-align":"center"});
			},
			"order": [[ 0, "DESC"]],
                        
		});

            $('.search-input-select').on( 'change', function (e) {   
                // for dropdown
                var i =$(this).attr('data-column');  // getting column index
                var v =$(this).val();  // getting search input value
                dataTable1.api().columns(i).search(v).draw();
            });
	});
</script>