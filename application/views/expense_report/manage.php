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
                    <h2>Expense Report</h2>
                    <div class="clearfix"></div>
                    
                 </div>
                    
				 <div class="x_content">
                <div class="datatable-responsive">
                    <p id="date_filter">
                        <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter date" type="text" id="ff" />
    <span id="date-label-to" class="date-label">To:<input class="date_range_filter date"  type="text" id="datepicker_to" />
</p>
                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>Sr No.</th>
                          <th>Invoice Number</th>
                          <th>Expense</th>
                    </thead>
                    <thead>
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
                                <h3 class="box-title">Expense Report</h3>
                            </div>
                        </div>
                    </div>

                    <div class="box-body">
                        <p id="date_filter">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <span id="date-label-from" class="date-label">From: </span>
                                            
                                            <input class="date_range_filter date" type="text" id="ff" />
                                        </div>

                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <span id="date-label-to" class="date-label">To:
                                            </span>

                                            <input class="date_range_filter date"  type="text" id="datepicker_to" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </p>
                    </div>
                   
                    <div class="box-body table-responsive">
                        <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
                            <thead>
                                <th width="5%" class="text-center">Sr No.</th>
                                <th class="text-center">Invoice Number</th>
                                <th class="text-center">Invoice Date</th>
                                <th class="text-center">Expense</th>
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
                title:'',
                filename:'Expense report',
                sheetName: 'Expense report',
                action: newExportAction,
                exportOptions: {
                    columns: [1,2,3]
                },
                customize: function (xlsx) {                            
                  // console.log(rels);
                  var sheet = xlsx.xl.worksheets['sheet1.xml'];
                  // To add new row count
                  var numrows = 4;
                  // Get row from sheet
                  var clRow = $('row', sheet);
                  //console.log(clRow);
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
                          var text = sheet.createTextNode(value);


                          t.appendChild(text);                                      
                          is.appendChild(t);
                          c.appendChild(is);

                          row.appendChild(c);  
                             // console.log(c);       
                      }
                      return row;
                  }          
                  // Add row data
                  var r1 = Addrow(1, [{ key: 'A', value: 'Filters' }]);

                  var r2 = Addrow(2, [{ key: 'A', value: 'From Date' },{ key: 'B', value: $("#ff").val() }]);


                  var r3 = Addrow(3, [{ key: 'A', value: 'To Date' },{ key: 'B', value: $("#datepicker_to").val() }]);

                  var sheetData = sheet.getElementsByTagName('sheetData')[0];

                  sheetData.insertBefore(r3,sheetData.childNodes[0]);
                  sheetData.insertBefore(r2,sheetData.childNodes[0]);
                  sheetData.insertBefore(r1,sheetData.childNodes[0]);

                  // Style of rows
                  $('row c[r="A2"]', sheet).attr('s', '7');
                  $('row c[r="B2"]', sheet).attr('s', '7');
                  $('row c[r="A3"]', sheet).attr('s', '7');
                  $('row c[r="B3"]', sheet).attr('s', '7');   
                },
            }
            ],
			"ajax":{
				"url": "<?php echo base_url().$this->controller."/server_data/" ?>",
				"dataType": "json",
				"type": "POST",
				},
			"columns": [
				{ "data": "id"},
                { "data": "invoice_no"},
                { "data": "created"},
                { "data": "sales_expense"},
			],
			"columnDefs": [ {
				"targets": [1],
				"orderable": false
			},
      {
          "className": 'text-center',
          "targets":   [0,2],
          "orderable": false
      }],
			"rowCallback": function( row, data, index ) {
				  //$("td:eq(3)", row).css({"background-color":"navy","text-align":"center"});
			},
			"order": [[ 0, "DESC"]],
                        
		});

    $(".dt-buttons").css("margin-top", "-4px"); // for manage margin of excel button
            
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