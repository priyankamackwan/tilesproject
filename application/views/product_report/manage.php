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
                    <h2>Products Report</h2>
                    <div class="clearfix"></div>
                    
                 </div>
                    
				 <div class="x_content">
                <div class="datatable-responsive">

                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>Sr No.</th>
                          <th>Product Name</th>
                          <th>Design No.</th>
                          <th>Size</th>
                          <th>Category</th>
                          <th>Purchase Price</th>
                          <th>Total Quantity</th>
                          <th>Sold Quantity</th>
                          <th>Balance Quantity</th>
                           <th>Total Amount Balance</th>
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
                      <div class="row">
                          <div class="col-md-6 col-sm-12 col-xs-12">
                              <h3 class="box-title">Products Report</h3>
                          </div>
                      </div>
                  </div>

                  <div class="box-body table-responsive">
                      <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
                          <thead>
                            <th>Sr No.</th>
                            <th>Product Name</th>
                            <th>Design No.</th>
                            <th>Size</th>
                            <th>Category</th>
                            <th>Purchase Price</th>
                            <th>Total Quantity</th>
                            <th>Sold Quantity</th>
                            <th>Balance Quantity</th>
                            <th>Total Amount Balance</th>
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
                                { "data": "product_name"},
                                { "data": "design_no"},
                                { "data": "size"},
                                { "data": "category"},
                                { "data": "purchase_expense"},
                                { "data": "quantity"},
                                { "data": "sold_quantity"},
                                { "data": "total_left_quantity"},
                                { "data": "amount"},
			],
                                 "bInfo" : false,
                                 "bFilter": false,
			"columnDefs": [ {
				"targets": [0,1,2,3,4,5,6,7,8,9],
				"orderable": false
			} ],
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



            
	});
        

</script>