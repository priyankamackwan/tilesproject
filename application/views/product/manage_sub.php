<?php
	$this->load->view('include/header');
?>
<!-- page content -->
     <div class="right_col" role="main">
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
                     <form action="<?php echo base_url().$this->controller.'/addProducts';?>" method="post">
                    <div>
                         <button type="submit" class="btn btn-primary" style="text-align: right">Import Products</button>
                        </div>
                    </form>
                    
				 <div class="x_content">
                <div class="datatable-responsive">
                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>Sr No.</th>
                          <th>Design No.</th>
                          <th>Name</th>
                          <th>Item Group</th>
                      <th>Image</th>
                       <th>Quantity</th>
                          <th>Cash Rate</th>
                        <th>Credit Rate</th>
                        <th>Walkin Rate</th>
                      
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
        { "data": "cate_name"},
                              { "data": "image"},
                              { "data": "quantity"},
                              { "data": "cash_rate"},
                              { "data": "credit_rate"},
                              { "data": "walkin_rate"},
                              
                                { "data": "size"},
                                { "data": "unit"},
                                { "data": "status"},
				{ "data": "manage"}
			],
			"columnDefs": [ {
				"targets": [0,10,11],
				"orderable": false
			} ],
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