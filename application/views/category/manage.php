<?php
  $this->load->view('include/header');
  $this->load->view('include/leftsidemenu');
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
                                echo $this->session->flashdata('dispMessage');
			?>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
				<div class="x_title">
                    <h2><?php echo $msgName;?> Detail</h2>
                   
                    <ul class="nav navbar-right panel_toolbox">
                        
					  <li><a href="<?php echo base_url($this->controller);?>/add"><button class="btn btn-primary"><i class="fa fa-plus"></i> Add Category</button></a>
                      </li>
                      
                    </ul>
                    
                    <div class="clearfix"></div>
                    
                 </div>
                    
				 <div class="x_content">
                <div class="datatable-responsive">
                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>Sr No.</th>
                          <th>Category Name</th>
                          <th>Category Image</th>
                          <th>Status</th>
                          <th>Manage</th>
                    </thead>
<thead>
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
            <h3 class="box-title"><?php echo $msgName;?> Detail</h3>
            <a href="<?php echo base_url($this->controller);?>/add" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Item Group </a>
          </div>

          <div class="box-body table-responsive">
            <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
              <thead>
                <th width="5%" class="text-center">Sr No.</th>
                <th class="text-center">Item Group  Name</th>
                <th class="text-center">Item Group  Image</th>
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
      // Add fr download data in excel all pages 
      var oldExportAction = function (self, e, dt, button, config) {
        if (button[0].className.indexOf('buttons-excel') >= 0) {
            if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
            }
            else {
                $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            }
        } else if (button[0].className.indexOf('buttons-print') >= 0) {
            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
        }
      };
        
      var newExportAction = function (e, dt, button, config) {
        var self = this;
        var oldStart = dt.settings()[0]._iDisplayStart;
        dt.one('preXhr', function (e, s, data) {
            // Just this once, load all data from the server...
            data.start = 0;
            data.length = 2147483647;
            dt.one('preDraw', function (e, settings) {
                // Call the original action function 
                oldExportAction(self, e, dt, button, config);
                dt.one('preXhr', function (e, s, data) {
                    // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                    // Set the property to what it was before exporting.
                    settings._iDisplayStart = oldStart;
                    data.start = oldStart;
                });
                // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                setTimeout(dt.ajax.reload, 0);
                // Prevent rendering of the full data to the DOM
                return false;
            });
        });
        // Requery the server with the new one-time export settings
        dt.ajax.reload();
      };
      //End For download
     
	var dataTable1 = $('#datatables').dataTable({
			"processing": true,
			"serverSide": true,
      'dom': 'lBfrtip',
      "buttons": 
      [{
        extend:'excel',
        text: window.excelButtonTrans,
        title: '',
        filename: 'Category List',
        sheetName:'Category List',
        action: newExportAction,
        exportOptions: {
          columns: [1,3],
        }
      }],
			"ajax":{
				"url": "<?php echo base_url().$this->controller."/server_data/" ?>",
				"dataType": "json",
				"type": "POST",
				},
			"columns": [
				{ "data": "id"},
				{ "data": "name"},
        { "data": "image"},
        { "data": "status"},
				{ "data": "manage"}
			],
			"columnDefs": [ {
				"targets": [2,4],
				"orderable": false
			},{
        "className": 'text-center',
        "targets":   [0,3,4],
        "orderable": false
      }],
			"rowCallback": function( row, data, index ) {
				  //$("td:eq(3)", row).css({"background-color":"navy","text-align":"center"});
			},
			"order": [[ 1, "DESC"]],                        
		});

    $(".dt-buttons").css("margin-top", "-4px"); // for manage margin of excel button

    $('.search-input-select').on( 'change', function (e) {   
        // for dropdown
        var i =$(this).attr('data-column');  // getting column index
        var v =$(this).val();  // getting search input value
        dataTable1.api().columns(i).search(v).draw();
    });
	});
</script>