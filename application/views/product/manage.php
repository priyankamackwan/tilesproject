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
                                            <label class="control-label" style="margin-top:7px;">Items:</label>
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

                                        <!-- Unit Filter -->
                                        <div class="col-md-1 col-sm-12 col-xs-12">
                                            <label class="control-label" style="margin-top:7px;">Units:</label>
                                        </div>

                                        <!-- Unit Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select class="form-control select2" name="units" style="width:100%;" id="units">
                                                <option value="" selected >All</option>
                                                <option value="1">CTN</option>
                                                <option value="2">SQM</option>
                                                <option value="3">PCS</option>
                                                <option value="4">SET</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">

                                    <!-- Invoice Status Filter -->
                                    <div class="col-md-1 col-sm-12 col-xs-12">
                                        <label class="control-label" style="margin-top:7px;">Items Group:</label>
                                    </div>

                                    <!-- Invoice Status Filter Dropdown -->
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <select class="form-control" name="cat_id" style="width:100%;" id="cat_id">
                                            <option value="">All</option>
                                            <?php
                                                    if(!empty($product_categories) && count($product_categories) > 0 ){
                                                    
                                                        foreach ($product_categories as $product_categoriesKey => $product_categoriesValue) {
                                                ?>
                                                            <option value="<?php echo $product_categoriesValue['id']; ?>"><?php echo $product_categoriesValue['name']; ?></option>
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

                                    <!-- Status Filter -->
                                    <div class="col-md-1 col-sm-12 col-xs-12">
                                        <label class="control-label" style="margin-top:7px;">Status:</label>
                                    </div>

                                    <!-- Status Filter Dropdown -->
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <select class="form-control" name="status" style="width:100%;" id="status">
                                            <option value="">All</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
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
                <th class="text-center">Item Group</th>
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
        "data":function(data) {
                    data.cat_id = $('#cat_id').val();
                    data.productid = $('#productsList').val();
                    data.units = $('#units').val();
                    data.status = $('#status').val();
                },
				},
			"columns": [
				{ "data": "id"},
        { "data": "design_no"},
				{ "data": "name"},
        { "data": "cate_name"},
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
				"targets": [4],
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
            $(document).on("change","#productsList",function(evt){
                dataTable1.api().draw();
            });
            $(document).on("change","#units",function(evt){
                dataTable1.api().draw();
            });
            $(document).on("change","#cat_id",function(evt){
                dataTable1.api().draw();
            });
            $(document).on("change","#status",function(evt){
                dataTable1.api().draw();
            });
	});
</script>