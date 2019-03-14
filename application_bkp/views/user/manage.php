<?php
	$this->load->view('include/header');
?>
<!-- page content -->
     <div class="right_col" role="main">
            <div class="clearfix"></div>
            <div class="row">
			<?php
                                echo $this->session->flashdata('edit_profile');
                                echo $this->session->flashdata('Change_msg');
				echo $this->session->flashdata($this->msgDisplay);
			?>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
				<div class="x_title">
                    <h2><?php echo $msgName;?> Detail</h2>
                    <div class="clearfix"></div>
                 </div>
				 <div class="x_content">
                <div class="datatable-responsive">
                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>No.</th>
                          <th>Company Name</th>
                          <th>Contact Person Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Vat No</th>
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
                          <th><select type="select" name="test" class="search-input-select" data-column="2">
                    <option value="">All</option>
                    <option value="1">Pending</option>
                    <option value="2">Active</option>
                    <option value="3">Block</option>
                    <option value="4">Rejected</option>
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
		var dataTable2 = $('#datatables').dataTable({
			"processing": true,
			"serverSide": true,
			"ajax":{
				"url": "<?php echo base_url().$this->controller."/server_data/" ?>",
				"dataType": "json",
				"type": "POST"
				},
			"columns": [
				{ "data": "id"},
                                
				{ "data": "company_name"},
				{ "data": "contact_person_name"},
                                { "data": "email"},
                                { "data": "phone_no"},
				{ "data": "vat_number"},
                                { "data": "status"},
				{ "data": "manage"}
			],
			"columnDefs": [ {
				"targets": [0,5,6,7],
				"orderable": false,  
			} ],

			"order": [[ 0, "DESC"]],
		});
            
             $('.search-input-select').on('change', function (e) {   
                // for dropdown
                var i =$(this).attr('data-column');  // getting column index
                var v =$(this).val();  // getting search input value
                dataTable2.api().columns(i).search(v).draw();
            });
	});
</script>