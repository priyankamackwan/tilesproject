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
                    <form action="<?php echo base_url().$this->controller.'/addUsers';?>" method="post">
                    <div>
                         <button type="submit" class="btn btn-primary" style="text-align: right">Import Contacts</button>
                        </div>
                    </form>
				 <div class="x_content">
                <div class="datatable-responsive">
                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>Sr No.</th>
                          <th>Company Name</th>
                          <th>Contact Person Name</th>
                          <th>Email</th>
                          <th>Vat No</th>
                          <th>Mobille No.</th>
                          <th>Client Type</th>
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
                                { "data": "vat_number"},
                                { "data": "phone_no"},
                                { "data": "client_type"},
                                { "data": "status"},
				{ "data": "manage"}
			],
			"columnDefs": [ {
				"targets": [0,6,7,8],
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