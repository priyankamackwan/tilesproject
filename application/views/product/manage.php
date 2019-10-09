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
                        
					  <li><a href="<?php echo base_url($this->controller);?>/add"><button class="btn btn-primary"><i class="fa fa-plus"></i> Add Product</button></a>
                                              <li><a href="<?php echo base_url($this->controller);?>/uploadProducts"><button class="btn btn-primary"><i class="fa fa-plus"></i> Import Products</button></a>
                      </li>
                      
                    </ul>
                    
                    <div class="clearfix"></div>
                    
                 </div>
                    
				 <div class="x_content">
                <div class="datatable-responsive">
                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>Sr No.</th>
                          <th>Design No.</th>
                          <th>Name</th>
                      <th>Image</th>
                       <th>Quantity</th>
                          <th>Cash Rate</th>
                        <th>Credit Rate</th>
                        <th>Walkin Rate</th>
                        <th>Purchase Price</th>
                        <th>Size</th>
                        <th>Unit</th>
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
                          <th></th>
                  
                          <th></th>
                          <th><select type="select" name="test" class="search-input-select" data-column="2">
                    <option value="">All</option>
                    <option value="1">Active</option>
                    <option value="2">Block</option>
                    </select></th>
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
        echo $this->session->flashdata('dispMessage');
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
                <h3 class="box-title"><?php echo $msgName;?> Detail</h3>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12 pull-right">
                <div class="box-tools pull-right">             
                  <a href="<?php echo base_url($this->controller);?>/add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Product</a>
                            
                  <a href="<?php echo base_url($this->controller);?>/uploadProducts" class="btn btn-primary"><i class="fa fa-plus"></i>Import Products</a>
                </div>
              </div>
            </div>
            
          </div>

          <div class="box-body table-responsive">
            <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
              <thead>
                <th width="5%" class="text-center">Sr No.</th>
                <th class="text-center">Design No.</th>
                <th class="text-center">Name</th>
                <th class="text-center">Image</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Cash Rate</th>
                <th class="text-center">Credit Rate</th>
                <th class="text-center">Walkin Rate</th>
                <th class="text-center">Purchase Price</th>
                <th class="text-center">Size</th>
                <th class="text-center">Unit</th>
                <th class="text-center">Status</th>
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
        { "data": "design_no"},
				{ "data": "name"},
        { "data": "image"},
        { "data": "quantity"},
        { "data": "cash_rate"},
        { "data": "credit_rate"},
        { "data": "walkin_rate"},
        { "data": "purchase_expense"},
        { "data": "size"},
        { "data": "unit"},
        { "data": "status"},
				{ "data": "manage"}
			],
			"columnDefs": [ {
				"targets": [11,12],
				"orderable": false
			},{
        "className": 'text-center',
        "targets":   0,
        "orderable": false
      }],
			"rowCallback": function( row, data, index ) {
				  //$("td:eq(3)", row).css({"background-color":"navy","text-align":"center"});
			},
			"order": [[ 1, "DESC"]],
                        
		});

            $('.search-input-select').on( 'change', function (e) {   
                // for dropdown
                var i =$(this).attr('data-column');  // getting column index
                var v =$(this).val();  // getting search input value
                dataTable1.api().columns(i).search(v).draw();
            });
	});
</script>