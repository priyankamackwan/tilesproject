<?php
	$this->load->view('include/header');
    $this->load->view('include/leftsidemenu');
    // Save Status from dashboard page unpaid orders
    $dash_status=$client_name='';
    if(isset($_GET['status']) && $_GET['status']!='' && $_GET['status']=="unpaid"){
        $dash_status='selected';
    }
    if(isset($_GET['client_name']) && $_GET['client_name']!='' ){
        $client_name=str_replace('_', '&',str_replace('-', ' ',$_GET['client_name']));
    }
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
                        
					  <li><a href="<?php echo base_url($this->controller);?>/uploadOrders"><button class="btn btn-primary"><i class="fa fa-plus"></i> Import Orders</button></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                    
                 </div>
				 <div class="x_content">
                <div class="datatable-responsive">
                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>Sr No.</th>
                          <th>Client Name</th>
                          <th>LPO No</th>
                          <th>Delivery No</th>
                          <th>Invoice No</th>
                          <th>Sales Expense</th>
                          <th>Invoice Status</th>
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
    </section>


    <section class="content">

        <!--<div class="box"> <-- Balance Box Start ---
            <div class="box-body table-responsive">
                <div class="col-md-12 no-padding">

                    <div class="col-md-2">
                         <h4>Your Balance :</h4>
                    </div>

                    <div class="col-md-3 no-padding">
                        <div class="col-md-3">
                            <img src="https://hajiri.co/assets/admin/images/credit.png" class="balanceIcon">
                        </div>
                        <div class="col-md-9">
                            <h4>Total Paid Amount</h4>
                            <p><i class="fa fa-inr"></i><span id="creditBalance"> <?php echo number_format($totalAmounts->paidAmount,2);?></span></p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <h4 class="text-center">Total Unpaid Amount</h4>
                        <p class="text-center"><i class="fa fa-inr"></i><span id="totalBalance"> <?php echo number_format($totalAmounts->unpaidAmount,2);?></span></p>
                    </div>

                    <div class="col-md-3">
                        <div class="col-md-4">
                            <img src="https://hajiri.co/assets/admin/images/debit.png" class="balanceIcon">
                        </div>
                        <div class="col-md-8">
                            <h4>Total Invoice Amount</h4>
                            <p><i class="fa fa-inr"></i><span id="debitBalance"> <?php echo number_format($totalAmounts->invoiceAmount,2);?></span></p>
                        </div>
                    </div>

                </div>
            </div>
        </div> <-- Balance Box End --->

        <div class="box"> <!-- Balance Box Start --->
            <div class="box-body table-responsive">
                <div class="col-md-12 no-padding">

                    <div class="col-md-2">
                         <h4>Your Balance :</h4>
                    </div>

                    <div class="col-md-3">
                        <h4 class="text-center"><b>Total Invoice Amount</b></h4>
                        <p class="text-center" style="font-size: 17px;">
                            <span id="creditBalance"> <?php echo $this->My_model->getamount(ROUND($totalAmounts->invoiceAmount,2));?>
                            </span>
                        </p>
                    </div>

                    <div class="col-md-3">
                        <h4 class="text-center" style="color:#00c400"><b>Total Paid Amount</b></h4>
                        <p class="text-center" style="font-size: 17px;">
                            <span id="totalBalance"> <?php echo $this->My_model->getamount(ROUND($totalAmounts->paidAmount,2));?>
                            </span>
                        </p>
                    </div>

                    <div class="col-md-3">
                        <h4 class="text-center" style="color:red"><b>Total Unpaid Amount</b></h4>
                        <p class="text-center" style="font-size: 17px;">
                            <span id="debitBalance"> <?php echo $this->My_model->getamount(ROUND($totalAmounts->unpaidAmount,2));?>
                            </span>
                        </p>
                    </div>

                </div>
            </div>
        </div> <!-- Balance Box End --->

        <div class="box">
            <div class="box-body">
                <!-- <div class="row form-group">
                    <div class="col-md-3 col-sm-12 col-xs-12 pull-right">
                        <table class="pull-right">
                            <tbody>
                                <tr>
                                    <td><b>Total Invoice Amount </b></td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td style="text-align: right"><?php echo number_format($totalAmounts->invoiceAmount,2);?></td>
                                </tr> 
                                <tr>
                                    <td><b>Total Paid Amount</b></td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td style="text-align: right"><?php echo number_format($totalAmounts->paidAmount,2);?></td>
                                </tr>
                                <tr>
                                    <td><b>Total Unpaid Amount</b></td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td style="text-align: right"><?php echo number_format($totalAmounts->unpaidAmount,2);?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> -->
                <div class="row form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-1 col-sm-12 col-xs-12">
                                <h4>Filters:</h4>
                            </div>

                            <div class="col-md-11 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="row">

                                        <!-- Client Filter  -->
                                        <div class="col-md-1 col-sm-12 col-xs-12" >
                                            <!-- <label class="control-label" style="margin-top:7px;">Company Name:</label> -->
                                        </div>

                                        <!-- Client Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select name="clientList" class="form-control select2" style="width: 100%;" id="clientList">
                                                <option value="" selected="selected">All Companies</option>
                                                <?php
                                                    if(!empty($activeUsers) && count($activeUsers) > 0 ){
                                                    
                                                        foreach ($activeUsers as $activeUsersKey => $activeUsersValue) {
                                                ?>
                                                            <option value="<?php echo $activeUsersValue['company_name']; ?>" <?php if(isset($client_name) && $client_name!='' && $client_name==$activeUsersValue['company_name']){ echo 'selected';}?>><?php echo $activeUsersValue['company_name']; ?></option>
                                                <?php
                                                        }
                                                    }else{
                                                ?>
                                                    <option value="">-- No Company Available --</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Item Filter -->
                                        <div class="col-md-1 col-sm-12 col-xs-12">
                                            <!-- <label class="control-label" style="margin-top:7px;">Item:</label> -->
                                        </div>

                                        <!-- Item Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select class="form-control select2" name="productsList" style="width:100%;" id="productsList">
                                                <option value="" selected >All Items</option>
                                                <?php
                                                    if(!empty($activeProducts) && count($activeProducts) > 0 ){
                                                    
                                                    foreach ($activeProducts as $activeProductsKey => $activeProductsValue) {
                                                ?>
                                                    <option value="<?php echo $activeProductsValue['id']; ?>"><?php echo $activeProductsValue['name'].' ( '.$activeProductsValue['design_no'].' )'; ?></option>
                                                <?php
                                                    }
                                                    }else{
                                                ?>
                                                    <option value="">-- No Item Available --</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Date Range Filter -->
                                        <div class="col-md-1 col-sm-12 col-xs-12">
                                            <!-- <label class="control-label" style="margin-top:7px;">Date:</label> -->
                                        </div>

                                        <!-- Date Range Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <div class="input-group">
                                                <input class="form-control" placeholder="Orede Date" required="" id="salesOrderDate" name="salesOrderDate" type="text">
                                                <label class="input-group-addon btn" for="salesOrderDate">
                                                    <span class="fa fa-calendar"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <!-- Invoice Status Filter -->
                                    <div class="col-md-1 col-sm-12 col-xs-12">
                                        <!-- <label class="control-label" style="margin-top:7px;">Invoice Status:</label> -->
                                    </div>

                                    <!-- Invoice Status Filter Dropdown -->
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <select class="form-control" name="invoiceStatus" style="width:100%;" id="invoiceStatus">
                                            <option value="">All Invoice Status</option>
                                            <option value="unpaid" <?php echo $dash_status;?>>Unpaid</option>
                                            <option value="paid">Paid</option>
                                        </select>
                                    </div>

                                    <!-- Delivery Status Filter -->
                                    <div class="col-md-1 col-sm-12 col-xs-12">
                                        <!-- <label class="control-label" style="margin-top:7px;">Delivery Status:</label> -->
                                    </div>

                                    <!-- Delivery Status Filter Dropdown -->
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <select class="form-control" name="status" style="width:100%;" id="status">
                                            <option value="">All Delivery Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="inprogress">In Progress</option>
                                            <option value="completed">Completed</option>
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
                        <h3 class="box-title"><?php echo $msgName;?></h3>
                        
                        <a href="<?php echo base_url($this->controller);?>/uploadOrders" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Import Orders</a>
                    </div>

                    <!-- Order table -->
                    <div class="box-body table-responsive">
                        <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
                            <thead>
                                <th class="text-center">Sr No.</th>
                                <th class="text-center">Company Name</th>
                                <th class="text-center">LPO No</th>
                                <th class="text-center">Delivery No</th>
                                <th class="text-center">Invoice No</th>
                                <th class="text-center">Placed By</th>
                                <th class="text-center">Sales Expense</th>
                                <th class="text-center">Invoice Status</th>
                                <th class="text-center">Delivery Status</th>
                                <th class="text-center">Created On</th>
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
    var dataTable1 = '';

    $(function(){

        //Date range picker
        $('#salesOrderDate').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD-MM-YYYY',
            },
        });

        // ,function(start, end, label) {
        //     daterangeStartValue = start.format('YYYY-MM-DD');
        //     daterangeEndValue= end.format('YYYY-MM-DD');
        //     dataTable1.draw();
        // }

        $('#salesOrderDate').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

            daterangeStartValue = picker.startDate.format('YYYY-MM-DD');
            daterangeEndValue= picker.endDate.format('YYYY-MM-DD');

            dataTable1.draw();
        });

        $('#salesOrderDate').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataTable1.draw();
        });

        daterangeStartValue = moment($('#salesOrderDate').val().split(" - ")[0],'DD/MM/YYYY').format('YYYY-MM-DD');
        daterangeEndValue = moment($('#salesOrderDate').val().split(" - ")[1],'DD/MM/YYYY').format('YYYY-MM-DD');
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
        
        // Ajax for Order table data with filters
	    dataTable1 = $('#datatables').DataTable({
            "processing": true,
            "serverSide": true,
            'dom': 'lBfrtip',
            "buttons": 
            [{
                extend:'excel',
                text: 'Excel',
                filename: 'Order',
                title:'',
                sheetName: 'Order List',                
                exportOptions: {
                    columns: [1,2,3,4,5,6,7,8,9]
                },
                action: newExportAction,
                customize: function (xlsx) {                            
                  // console.log(rels);
                  var sheet = xlsx.xl.worksheets['sheet1.xml'];
                  // To add new row count
                  var numrows = 11;
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
                  var r1 = Addrow(1, [{ key: 'G', value: 'Total Invoice Amount  ' }, { key: 'H', value: '<?php echo $this->My_model->getamount(ROUND($totalAmounts->invoiceAmount,2));?>'  }]);
                  var r2 = Addrow(2, [{ key: 'G', value: 'Total Paid Amount' }, { key: 'H', value: '<?php echo $this->My_model->getamount(ROUND($totalAmounts->paidAmount,2));?>'  }]);
                  
                  var r3 = Addrow(3, [{ key: 'G', value: 'Total Unpaid Amount' }, { key: 'H', value: '<?php echo $this->My_model->getamount(ROUND($totalAmounts->unpaidAmount,2));?>'  }]);

                  var r4 = Addrow(4, [{ key: '', value: '' }]);

                  var r5 = Addrow(5, [{ key: 'A', value: 'Filters' }]);

                  var r6 = Addrow(6, [{ key: 'A', value: 'Company Name: ' }, { key: 'B', value: $("#clientList option:selected").html() }]);

                  var r7 = Addrow(7, [{ key: 'A', value: 'Item: ' },{ key: 'B', value: $("#productsList option:selected").html() },]);

                  var r8 = Addrow(8, [{ key: 'A', value: 'Date: ' },{ key: 'B', value: $("#salesOrderDate").val() }]);
                  
                  var r9 = Addrow(9, [{ key: 'A', value: 'Invoice Status: ' },{ key: 'B', value: $("#invoiceStatus option:selected").html() }]);

                  var r10 = Addrow(10, [{ key: 'A', value: 'Status: ' },{ key: 'B', value: $("#status option:selected").html() }]);
                  
                  var sheetData = sheet.getElementsByTagName('sheetData')[0];

                  sheetData.insertBefore(r10,sheetData.childNodes[0]);
                  sheetData.insertBefore(r9,sheetData.childNodes[0]);
                  sheetData.insertBefore(r8,sheetData.childNodes[0]);                 
                  sheetData.insertBefore(r7,sheetData.childNodes[0]);
                  sheetData.insertBefore(r6,sheetData.childNodes[0]);
                  sheetData.insertBefore(r6,sheetData.childNodes[0]);
                  sheetData.insertBefore(r5,sheetData.childNodes[0]);
                  sheetData.insertBefore(r4,sheetData.childNodes[0]);
                  sheetData.insertBefore(r3,sheetData.childNodes[0]);
                  sheetData.insertBefore(r2,sheetData.childNodes[0]);
                  sheetData.insertBefore(r1,sheetData.childNodes[0]);

                  // Style of rows
                  $('row c[r^="I"]', sheet).attr('s', '51');
                  $('row c[r="I12"]', sheet).attr('s', '2');
                  $('row c[r="A6"]', sheet).attr('s', '7');
                  $('row c[r="A7"]', sheet).attr('s', '7');
                  $('row c[r="A8"]', sheet).attr('s', '7');
                  $('row c[r="A9"]', sheet).attr('s', '7');                  
                  $('row c[r="A10"]', sheet).attr('s', '7');
                       
                },
                
            }],
			"ajax":{
				"url": "<?php echo base_url().$this->controller."/server_data/" ?>",
				"dataType": "json",
				"type": "POST",
                "data":function(data) {
                    data.userName = $('#clientList').val();
                    data.productId = $('#productsList').val();
                    data.salesOrderDate = $('#salesOrderDate').val();
                    data.invoiceStatus = $('#invoiceStatus').val();
                    data.status = $('#status').val();
                    data.startdate = daterangeStartValue;
                    data.enddate = daterangeEndValue;
                },
            },
			"columns": [
				{ "data": "id"},
                { "data": "company_name"},
                { "data": "lpo_no"},
                { "data": "do_no"},
                { "data": "invoice_no"},
                { "data": "placed_by"},
                { "data": "sales_expense"},
                { "data": "invoice_status"},
                { "data": "status"},
                { "data": "created"},
				{ "data": "manage"}
			],
			"columnDefs": [ {
				"targets": [0,10],
				"orderable": false
			},{
                "className": 'text-center',
                "targets":   [0,7,8,9,10]
            }], 
            "order": [[ 1, "DESC"]],  
            "drawCallback": function(settings) {
              $("#creditBalance").html(settings.json.invoiceAmount);
              $("#totalBalance").html(settings.json.paidAmount);
              $("#debitBalance").html(settings.json.unpaidAmount);
            },   
		});

        $(".dt-buttons").css("margin-top", "-4px"); // for manage margin of excel button

        $('.search-input-select').on( 'change', function (e) {   
            // for dropdown
            var i =$(this).attr('data-column');  // getting column index
            var v =$(this).val();  // getting search input value
            dataTable1.api().columns(i).search(v).draw();
        });
	});

    
    // Filter for User list
    $(document).on("change","#clientList",function(evt){
        // dataTable1.rows().deselect();
        dataTable1.draw();
    });

    // Filter for Product list
    $(document).on("change","#productsList",function(evt){
        dataTable1.draw();
    });

    // Filter for Invoice Status
    $(document).on("change","#invoiceStatus",function(evt){
        dataTable1.draw();
    });

    // Filter for Status
    $(document).on("change","#status",function(evt){
        dataTable1.draw();
    });
</script>