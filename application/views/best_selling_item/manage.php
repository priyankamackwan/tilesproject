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
			?>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
				<div class="x_title">
                    <h2>Products Report</h2>
                    <div class="clearfix"></div>
                    
                 </div>
                    
				 <div class="x_content">
                <div class="datatable-responsive">

                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>Sr No.</th>
                          <th>Product Name</th>
                          <th>Design No.</th>
                          <th>Size</th>
                          <th>Category</th>
                          <th>Purchase Price</th>
                          <th>Total Quantity</th>
                          <th>Sold Quantity</th>
                          <th>Balance Quantity</th>
                           <th>Total Amount Balance</th>
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
                              <h3 class="box-title">Products Report</h3>
                          </div>
                      </div>
                  </div>

                  <div class="box-body table-responsive">
                      <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
                          <thead>
                            <th width="5%" class="text-center">Sr No.</th>
                            <th class="text-center">Item Name</th>
                            <th class="text-center">Design No.</th>
                            <th class="text-center">Size</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Purchase Price</th>
                            <th class="text-center">Total Quantity</th>
                            <th class="text-center">Sold Quantity</th>
                            <th class="text-center">Balance Quantity</th>
                            <th class="text-center">Total Amount Balance</th>
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
          filename:'Product report',
          sheetName: 'Product report',
          action: newExportAction,
				  exportOptions: {
							columns: [1,2,3,4,5,6,7,8,9]
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

              var r2 = Addrow(2, [{ key: 'A', value: 'Items' },{ key: 'B', value: $("#productsList option:selected").html() }]);

              var r3 = Addrow(3, [{ key: 'A', value: 'Items Group' },{ key: 'B', value: $("#cat_id option:selected").html() }]);
              
              var sheetData = sheet.getElementsByTagName('sheetData')[0];

              sheetData.insertBefore(r3,sheetData.childNodes[0]);
              sheetData.insertBefore(r2,sheetData.childNodes[0]);
              sheetData.insertBefore(r1,sheetData.childNodes[0]);

              // Style of rows
              $('row c[r="A2"]', sheet).attr('s', '7');
              $('row c[r="B2"]', sheet).attr('s', '7'); 
              $('row c[r="B3"]', sheet).attr('s', '7');
              $('row c[r="A3"]', sheet).attr('s', '7');   
            },
			  }],
			"ajax":{
				"url": "<?php echo base_url().$this->controller."/server_data/" ?>",
				"dataType": "json",
				"type": "POST",
				"data":function(data) {
                    data.cat_id = $('#cat_id').val();
                    data.productid = $('#productsList').val();
                },
				},
			"columns": [
				{ "data": "id"},
        { "data": "product_name"},
        { "data": "design_no"},
        { "data": "size"},
        { "data": "category"},
        { "data": "purchase_expense"},
        { "data": "quantity"},
        { "data": "sold_quantity"},
        { "data": "total_left_quantity"},
        { "data": "amount"},
			],
			"columnDefs": [ {
				"targets": [],
				"orderable": false
			},
      {
          "className": 'text-right',
          "targets":   [6,7,8,9],
          "orderable": false
      },
      {
          "className": 'text-center',
          "targets":   [0,1,,2,3,4,5],
          "orderable": false
      }],
			"rowCallback": function( row, data, index ) {
				  //$("td:eq(3)", row).css({"background-color":"navy","text-align":"center"});
			},
			"order": [[ 0, "DESC"]],
                        
		});

        
            
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
			$(document).on("change","#productsList",function(evt){
                dataTable1.api().draw();
            });
            $(document).on("change","#cat_id",function(evt){
                dataTable1.api().draw();
            });


            
	});
        

</script>