<?php
	$this->load->view('include/header');
?>
<!-- page content -->
     <div class="right_col" role="main">
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
                     <form action="<?php echo base_url().$this->controller.'/addProducts';?>" method="post">
                    <div>
                         <button type="submit" class="btn btn-primary" style="text-align: right">Import Products</button>
                        </div>
                    </form>
                    
				 <div class="x_content">
                <div class="datatable-responsive">
                 <table id="datatables" class="main-table table table-striped table-bordered">
                    <thead>
                          <th>Sr No.</th>
                          <th>Design No.</th>
                          <th>Name</th>
                          <th>Item Group</th>
                      <th>Image</th>
                       <th>Quantity</th>
                          <th>Cash Rate</th>
                        <th>Credit Rate</th>
                        <th>Walkin Rate</th>
                      
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
        filename: 'Products List',
        sheetName:'Products List',
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
                              
                                { "data": "size"},
                                { "data": "unit"},
                                { "data": "status"},
				{ "data": "manage"}
			],
			"columnDefs": [ {
				"targets": [0,10,11],
				"orderable": false
			} ],
			"rowCallback": function( row, data, index ) {
				  //$("td:eq(3)", row).css({"background-color":"navy","text-align":"center"});
			},
			"order": [[ 1, "DESC"]],
                        
		});

            $('.search-input-select').on( 'change', function (e) {   
                // for dropdown
                var i =$(this).attr('data-column');  // getting column index
                var v =$(this).val();  // getting search input value
                dataTable1.api().columns(i).search(v).draw();
            });
	});
</script>