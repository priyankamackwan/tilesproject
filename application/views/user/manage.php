<?php
  $this->load->view('include/leftsidemenu');
  $this->load->view('include/header');
  
?>
<!-- page content -->
     <!-- <div class="right_col" role="main">
            <div class="clearfix"></div>
            <div class="row">
			<?php
                                //echo $this->session->flashdata('edit_profile');
                                //echo $this->session->flashdata('Change_msg');
				// echo $this->session->flashdata($this->msgDisplay);
			?>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
				<div class="x_title">
                    <h2><?php //echo $msgName;?> Detail</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        
					  <li><a href="<?php //echo base_url($this->controller);?>/uploadContacts"><button class="btn btn-primary"><i class="fa fa-plus"></i> Import Contacts</button></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                 </div>
                 
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
</div> -->

<!-- Main Container start-->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">

    <?php
      echo $this->session->flashdata('edit_profile');
      echo $this->session->flashdata('Change_msg');
      echo $this->session->flashdata($this->msgDisplay);
    ?>

    <!-- <h1>
      <?php echo $msgName;?>
    </h1> -->
    <!-- <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Users</li>
    </ol> -->
  </section>

  <!-- Main content section start-->
  <section class="content">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title"><?php echo $msgName;?></h3>
            <a href="<?php echo base_url($this->controller);?>/uploadContacts" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Import Contacts</a>
          </div>

          <div class="box-body table-responsive">
            <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
              <thead>
                    <th width="5%" class="text-center">Sr No.</th>
                    <th class="text-center">Company Name</th>
                    <th class="text-center">Contact Person Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Vat No</th>
                    <th class="text-center">Mobille No.</th>
                    <th class="text-center">Client Type</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Manage</th>
              </thead>
              <!-- <thead>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
                      <select type="select" name="test" class="search-input-select" data-column="2">
                        <option value="">All</option>
                        <option value="1">Pending</option>
                        <option value="2">Active</option>
                        <option value="3">Block</option>
                        <option value="4">Rejected</option>
                      </select>
                    </th>
                    <th></th>
              </thead> -->
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
<!-- Main Container end-->

<?php
	$this->load->view('include/footer');
?>
<script>
    jQuery(document).ready(function(){
		var dataTable2 = $('#datatables').dataTable({
      "responsive": true,
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
				"targets": [6,7,8],
				"orderable": false,  
			},{
        "className": 'text-center',
        "targets":   0,
        "orderable": false
      }],

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