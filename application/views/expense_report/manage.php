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
			/*	echo $this->session->flashdata('edit_profile');
                                echo $this->session->flashdata('Change_msg');
                                echo $this->session->flashdata($this->msgDisplay); */
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
                                        <!-- Date Range Filter -->
                                        <div class="col-md-1 col-sm-12 col-xs-12">
                                            <label class="control-label" style="margin-top:7px;">Date:</label>
                                        </div>

                                        <!-- Date Range Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <div class="input-group">
                                                <input class="form-control" placeholder="" required="" id="salesOrderDates" name="salesOrderDates" type="text">
                                                <label class="input-group-addon btn" for="salesOrderDates">
                                                    <span class="fa fa-calendar"></span>
                                                </label>
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div></div>
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
                    <?php /*  
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
                   */ ?>
                    <div class="box-body table-responsive">
                        <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
                            <thead>
                                <th width="5%" class="text-center">Sr No.</th>
                                <th class="text-center">Invoice Number</th>
                                <th class="text-center">Invoice Date</th>
                                <th class="text-center">Amount</th>
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
   var dataTable1 = '';
    daterangeStartValue = '';
            daterangeEndValue= '';
            $(function(){

        //Date range picker
        $('#salesOrderDates').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD-MM-YYYY',
            },
        });

        // ,function(start, end, label) {
        //     daterangeStartValue = start.format('YYYY-MM-DD');
        //     daterangeEndValue= end.format('YYYY-MM-DD');
        //     dataTable2.draw();
        // }

        
    });
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
                    columns: [1,2,3,4]
                },
                customize: function (xlsx) {                            
                  // console.log(rels);
                  var sheet = xlsx.xl.worksheets['sheet1.xml'];
                  // To add new row count
                  var numrows = 3;
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

                  var r2 = Addrow(2, [{ key: 'A', value: 'Date:' },{ key: 'B', value: $("#salesOrderDates").val() }]);


                  var sheetData = sheet.getElementsByTagName('sheetData')[0];

                  sheetData.insertBefore(r2,sheetData.childNodes[0]);
                  sheetData.insertBefore(r1,sheetData.childNodes[0]);

                  // Style of rows
                  $('row c[r^="B"]', sheet).attr('s', '51');
                  $('row c[r="B4"]', sheet).attr('s', '2');
                  $('row c[r="A2"]', sheet).attr('s', '7');
                  $('row c[r="B2"]', sheet).attr('s', '7');
                  $('row c[r="A3"]', sheet).attr('s', '7');
                  $('row c[r="B3"]', sheet).attr('s', '7');
                  $('row c[r^="C"]', sheet).attr('s', '52');
                  $('row c[r="C4"]', sheet).attr('s', '2');   
                },
            }
            ],
			"ajax":{
				"url": "<?php echo base_url().$this->controller."/server_data/" ?>",
				"dataType": "json",
				"type": "POST",
        "data":function(data) {
                    data.uid = $('#company_name').val();
                    data.salesOrderDate = $('#salesOrderDates').val();
                    data.startdate = daterangeStartValue;
                    data.enddate = daterangeEndValue;
                    },
				},
			"columns": [
				{ "data": "id"},
                { "data": "invoice_no"},
                { "data": "created"},
                { "data": "total_price"},
                { "data": "sales_expense"},
			],
			"columnDefs": [ {
				"targets": [1],
				"orderable": true
			},
      {
          "className": 'text-center',
          "targets":   [0],
          "orderable": false
      },
      {
          "className": 'text-center',
          "targets":   [2],
          "orderable": true
      },{
          "className": 'text-right',
          "targets":   [3,4],
          "orderable": true
      }],
			"rowCallback": function( row, data, index ) {
				  //$("td:eq(3)", row).css({"background-color":"navy","text-align":"center"});
			},
			"order": [[ 0, "DESC"]],
                        
		});



        
            $('#salesOrderDates').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

            daterangeStartValue = picker.startDate.format('YYYY-MM-DD');
            daterangeEndValue= picker.endDate.format('YYYY-MM-DD');

            dataTable1.api().draw();
        });

        $('#salesOrderDates').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataTable1.api().draw();
        });

        daterangeStartValue = moment($('#salesOrderDates').val().split(" - ")[0],'DD/MM/YYYY').format('YYYY-MM-DD');
        daterangeEndValue = moment($('#salesOrderDates').val().split(" - ")[1],'DD/MM/YYYY').format('YYYY-MM-DD');
         $(".dt-buttons").css("margin-top", "-4px");
/*      $('#ff').change(function(){
=======
=======
>>>>>>> 720672f55fb026a4e194f390e35b741a70120840
    $(".dt-buttons").css("margin-top", "-4px"); // for manage margin of excel button
            
      $('#ff').change(function(){
>>>>>>> 720672f55fb026a4e194f390e35b741a70120840
 
   var i =1;  // getting column index
                var v =$(this).val();  // getting search input value
                dataTable1.api().columns(i).search(v).draw();
});
        $('#datepicker_to').change(function(){
 
   var i =2;  // getting column index
                var v =$(this).val();  // getting search input value
                dataTable1.api().columns(i).search(v).draw();
});

*/

            
	});
        

</script>