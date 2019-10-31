<?php
  $this->load->view('include/header');
  $this->load->view('include/leftsidemenu'); 
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
    <!-- Add Filter -->
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

                                        <!-- Contact Filter  -->
                                        <div class="col-md-1 col-sm-12 col-xs-12" >
                                            <label class="control-label" style="margin-top:7px;">Company Name:</label>
                                        </div>

                                        <!-- Contact Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select name="clientList" class="form-control select2" style="width: 100%;" id="clientList">
                                                <option value="" selected="selected">All</option>
                                                <?php
                                                    if(!empty($all_user) && count($all_user) > 0 ){
                                                    
                                                        foreach ($all_user as $all_userKey => $all_userValue) {
                                                ?>
                                                            <option value="<?php echo $all_userValue['company_name']; ?>"><?php echo $all_userValue['company_name']; ?></option>
                                                <?php
                                                        }
                                                    }else{
                                                ?>
                                                    <option value="">-- No User Available --</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <!-- Contact Filter  -->
                                        <div class="col-md-1 col-sm-12 col-xs-12" >
                                            <label class="control-label" style="margin-top:7px;">Client Type:</label>
                                        </div>

                                        <!-- Contact Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select name="client_type" class="form-control select2" style="width: 100%;" id="client_type">
                                                <option value="" selected="selected">All</option>
                                                <option value="1">Cash</option>
                                                <option value="2">Credit</option>
                                                <option value="3">Walkin</option>
                                                <option value="4">Flexible Rate</option>
                                            </select>
                                        </div>

                                        
                                        <!-- Status Filter -->
                                        <div class="col-md-1 col-sm-12 col-xs-12">
                                            <label class="control-label" style="margin-top:7px;">Status:</label>
                                        </div>
                                        <!-- Status Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select class="form-control" name="status" style="width:100%;" id="status">
                                                <option value="" selected="selected">All</option>
                                                <option value="1">Active</option>
                                                <option value="3">Rejected</option>
                                                <option value="4">Pending</option>        
                                                <option value="2">Block</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Filter -->
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
                    <th class="text-center">Created On</th>
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
    var dataTable2 = $('#datatables').dataTable({
      "responsive": true,
      "processing": true,
      "serverSide": true,
      'dom': 'lBfrtip',
      "buttons": 
      [{
        extend: 'excel',
        //className: 'btn btn-sm btn-success',
        text: window.excelButtonTrans,
        title: '',
        filename: 'Contact List',
        sheetName:'Contact List',
        exportOptions: {
          columns: [1,2,3,4,5,6,7,8]
        },
        /*{
          text: 'Red',
          className: 'red'
        },*/
        customize: function (xlsx) {                            
          // console.log(rels);
          var sheet = xlsx.xl.worksheets['sheet1.xml'];

          // To add new row count
          var numrows = 5;

          // Get row from sheet
          var clRow = $('row', sheet);
          
          // Update Row
          clRow.each(function () {
              var attr = $(this).attr('r');
              var ind = parseInt(attr);
              ind = ind + numrows;
              $(this).attr("r", ind);
          });

          // Create row before data
          $('row c ', sheet).each(function (index) {
              var attr = $(this).attr('r');

              var pre = attr.substring(0, 1);
              var ind = parseInt(attr.substring(1, attr.length));
              ind = ind + numrows;
              $(this).attr("r", pre + ind);
          });

          function Addrow(index, data) {

              var row = sheet.createElement('row');

              row.setAttribute("r", index);

              for (i = 0; i < data.length; i++) {
                  var key = data[i].key;
                  var value = data[i].value;

                  var c  = sheet.createElement('c');
                  c.setAttribute("t", "inlineStr");
                  c.setAttribute("s", "2");
                  c.setAttribute("r", key + index);

                  var is = sheet.createElement('is');
                  var t = sheet.createElement('t');
                  var text = sheet.createTextNode(value)

                  t.appendChild(text);
                  is.appendChild(t);
                  c.appendChild(is);

                  row.appendChild(c);
              }
              return row;
          }          
          // Add row data 
          var r1 = Addrow(1, [{ key: 'A', value: 'Filters' }, { key: 'B', value: '' }]);

          var r2 = Addrow(2, [{ key: 'A', value: 'Company Name: ' }, { key: 'B', value: $("#clientList option:selected").html() }]);

          var r3 = Addrow(3, [{ key: 'A', value: 'Client Type: ' },{ key: 'B', value: $("#client_type option:selected").html() }]);

          var r4 = Addrow(4, [{ key: 'A', value: 'Status: ' },{ key: 'B', value: $("#status option:selected").html() }]);
          
          var sheetData = sheet.getElementsByTagName('sheetData')[0];
         
          sheetData.insertBefore(r4,sheetData.childNodes[0]);
          sheetData.insertBefore(r3,sheetData.childNodes[0]);
          sheetData.insertBefore(r2,sheetData.childNodes[0]);
          sheetData.insertBefore(r1,sheetData.childNodes[0]);

          // Style of rows
          $('row c[r="A2"]', sheet).attr('s', '7');
          $('row c[r="A3"]', sheet).attr('s', '7');
          $('row c[r="A4"]', sheet).attr('s', '7');
          $('row c[r="B2"]', sheet).attr('s', '7');
          $('row c[r="B3"]', sheet).attr('s', '7');
          $('row c[r="B4"]', sheet).attr('s', '7');
          $('row c[r="D3"]', sheet).attr('s', '7');
          $('row c[r="C3"]', sheet).attr('s', '7');
        },
        action: newExportAction,     
      }],
      "ajax":{
        "url": "<?php echo base_url().$this->controller."/server_data/" ?>",
        "dataType": "json",
        "type": "POST",
        // add data attribute for pass data of filter
        "data":function(data) {
              data.company_name = $('#clientList').val();
              data.status = $('#status').val();
              data.client_type=$("#client_type").val();
            },
        },
      "columns": [
        { "data": "id"},     
        { "data": "company_name"},
        { "data": "contact_person_name"},
        { "data": "email"},
        { "data": "vat_number"},
        { "data": "phone_no"},
        { "data": "client_type"},
        { "data": "created"},
        { "data": "status"},
        { "data": "manage"}
      ],
      "columnDefs": [ {
        "targets": [6,8],
        "orderable": false,  
      },{
        "className": 'text-center',
        "targets":   [0,7,8,9],
        "orderable": false
      }],

      "order": [[ 0, "DESC"]],
    });


    $(".dt-buttons").css("margin-top", "-4px"); // for manage margin of excel button
            
             $('.search-input-select').on('change', function (e) {   
                // for dropdown
                var i =$(this).attr('data-column');  // getting column index
                var v =$(this).val();  // getting search input value
                dataTable2.api().columns(i).search(v).draw();
            });
            
    // change event of filetr       
    $('#clientList').on('change', function (e) {
        // dataTable1.rows().deselect();
        dataTable2.api().draw();
    });
    $('#status').on('change', function (e) {
        // dataTable1.rows().deselect();
        dataTable2.api().draw();
    });
    $('#client_type').on('change', function (e) {
        // dataTable1.rows().deselect();
        dataTable2.api().draw();
    });    
  });
</script>