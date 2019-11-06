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
                    <h2><?php echo $msgName;?> Detail</h2>
                   
                    <ul class="nav navbar-right panel_toolbox">
                        
            <li><a href="<?php echo base_url($this->controller);?>/add"><button class="btn btn-primary"><i class="fa fa-plus"></i> Add Product</button></a>
                                              <li><a href="<?php echo base_url($this->controller);?>/uploadProducts"><button class="btn btn-primary"><i class="fa fa-plus"></i> Import Products</button></a>
                      </li>
                      
                    </ul>
                    
                    <div class="clearfix"></div>
                    
                 </div>
                    
         <div class="x_content">
                <div class="datatable-responsive">
                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>Sr No.</th>
                          <th>Design No.</th>
                          <th>Name</th>
                      <th>Image</th>
                       <th>Quantity</th>
                          <th>Cash Rate</th>
                        <th>Credit Rate</th>
                        <th>Walkin Rate</th>
                        <th>Purchase Price</th>
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

                                        <!-- Products Filter -->
                                        <div class="col-md-1 col-sm-12 col-xs-12">
                                            <label class="control-label" style="margin-top:7px;">Items:</label>
                                        </div>

                                        <!-- Products Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select class="form-control select2" name="productsList" style="width:100%;" id="productsList">
                                                <option value="" selected >All</option>
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

                                        <!-- Unit Filter -->
                                        <div class="col-md-1 col-sm-12 col-xs-12">
                                            <label class="control-label" style="margin-top:7px;">Units:</label>
                                        </div>

                                        <!-- Unit Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select class="form-control select2" name="units" style="width:100%;" id="units">
                                                <option value="" selected >All</option>
                                                <option value="1">CTN</option>
                                                <option value="2">SQM</option>
                                                <option value="3">PCS</option>
                                                <option value="4">SET</option>
                                            </select>
                                        </div>

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
                                                        <option value="">-- No Items Group Available --</option>
                                                    <?php
                                                        }
                                                    ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Status Filter -->
                                    <div class="col-md-1 col-sm-12 col-xs-12">
                                        <label class="control-label" style="margin-top:7px;">Status:</label>
                                    </div>

                                    <!-- Status Filter Dropdown -->
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <select class="form-control" name="status" style="width:100%;" id="status">
                                            <option value="">All</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
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
            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <h3 class="box-title"><?php echo $msgName;?> Detail</h3>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12 pull-right">
                <div class="box-tools pull-right">             
                  <a href="<?php echo base_url($this->controller);?>/add" class="btn btn-primary"><i class="fa fa-plus"></i> Add Item</a>
                            
                  <a href="<?php echo base_url($this->controller);?>/uploadProducts" class="btn btn-primary"><i class="fa fa-plus"></i> Import Items</a>
                </div>
              </div>
            </div>
            
          </div>

          <div class="box-body table-responsive">
            <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
              <thead>
                <th width="5%" class="text-center">Sr No.</th>
                <th class="text-center">Design No.</th>
                <th class="text-center">Name</th>
                <th class="text-center">Item Group</th>
                <th class="text-center">Image</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Cash Rate</th>
                <th class="text-center">Credit Rate</th>
                <th class="text-center">Walkin Rate</th>
                <th class="text-center">Purchase Price</th>
                <th class="text-center">Size</th>
                <th class="text-center">Unit</th>
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
        title:'',
        filename: 'Items List',
        sheetName:'Items List',
        action: newExportAction,
        exportOptions: {
          columns: [1,2,3,5,6,7,8,9,10,11,12]
        },
        customize: function (xlsx) {                            
          // console.log(rels);
          var sheet = xlsx.xl.worksheets['sheet1.xml'];

          // To add new row count
          var numrows = 6;

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

          var r2 = Addrow(2, [{ key: 'A', value: 'Items: ' }, { key: 'B', value: $("#productsList option:selected").html() }]);

          var r3 = Addrow(3, [{ key: 'A', value: 'Items Group: ' },{ key: 'B', value: $("#cat_id option:selected").html() }]);

          var r4 = Addrow(4, [{ key: 'A', value: 'Units: ' },{ key: 'B', value: $("#units option:selected").html() }]);

          var r5 = Addrow(5, [{ key: 'A', value: 'Status: ' },{ key: 'B', value: $("#status option:selected").html() }]);
          
          var sheetData = sheet.getElementsByTagName('sheetData')[0];
         
          sheetData.insertBefore(r5,sheetData.childNodes[0]);
          sheetData.insertBefore(r4,sheetData.childNodes[0]);
          sheetData.insertBefore(r3,sheetData.childNodes[0]);
          sheetData.insertBefore(r2,sheetData.childNodes[0]);
          sheetData.insertBefore(r1,sheetData.childNodes[0]);

          // Style of rows
          //$('row c[c="A1"]', sheet).attr('s', '7');
          $('row c[r^="D"]', sheet).attr('s', '51');
          $('row c[r="D7"]', sheet).attr('s', '2');
          $('row c[r^="E"]', sheet).attr('s', '52');
          $('row c[r="E7"]', sheet).attr('s', '2');
          $('row c[r^="F"]', sheet).attr('s', '52');
          $('row c[r="F7"]', sheet).attr('s', '2');
          $('row c[r^="G"]', sheet).attr('s', '52');
          $('row c[r="G7"]', sheet).attr('s', '2');
          $('row c[r^="H"]', sheet).attr('s', '52');
          $('row c[r="H7"]', sheet).attr('s', '2');
          $('row c[r^="I"]', sheet).attr('s', '51');
          $('row c[r="I7"]', sheet).attr('s', '2');
          $('row c[r="A2"]', sheet).attr('s', '7');
          $('row c[r="A3"]', sheet).attr('s', '7');
          $('row c[r="A5"]', sheet).attr('s', '7');
          $('row c[r="B2"]', sheet).attr('s', '7');
          $('row c[r="B3"]', sheet).attr('s', '7');
          $('row c[r="B4"]', sheet).attr('s', '7');          
          $('row c[r="B5"]', sheet).attr('s', '7'); 
          $('row c[r="A4"]', sheet).attr('s', '7');          
        },
      }],
      "ajax":{
        "url": "<?php echo base_url().$this->controller."/server_data/" ?>",
        "dataType": "json",
        "type": "POST",
        "data":function(data) {
              data.cat_id = $('#cat_id').val();
              data.productid = $('#productsList').val();
              data.units = $('#units').val();
              data.status = $('#status').val();
          },
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
        { "data": "purchase_expense"},
        { "data": "size"},
        { "data": "unit"},
        { "data": "status"},
        { "data": "manage"}
      ],
      "columnDefs": [ {
        "targets": [4,13],
        "orderable": false
      },
      {
        "className": 'text-right',
        "targets":   [5,6,7,8,9],
        "orderable": true
      },
      {
        "className": 'text-center',
        "targets":   [0],
        "orderable": false
      },
      {
        "className": 'text-center',
        "targets":   [0,10,11,12,13],
        "orderable": true
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
            $(document).on("change","#productsList",function(evt){
                dataTable1.api().draw();
            });
            $(document).on("change","#units",function(evt){
                dataTable1.api().draw();
            });
            $(document).on("change","#cat_id",function(evt){
                dataTable1.api().draw();
            });
            $(document).on("change","#status",function(evt){
                dataTable1.api().draw();
            });
  });
</script>