<?php
  $this->load->view('include/header');
  $this->load->view('include/leftsidemenu');
  defined('BASEPATH') OR exit('No direct script access allowed');
  error_reporting(0);
?>
<div class="content-wrapper">
	<section class="content-header">
		<a href="<?php echo base_url($this->controller);?>"class="btn btn-info">Back</a>
		<?php
			echo $this->session->flashdata('edit_profile');
			echo $this->session->flashdata('Change_msg');
			echo $this->session->flashdata($this->msgDisplay);
		?>
	</section>
	<section class="content">
  		<div class="row">
		    <div class="col-md-9 col-sm-12 col-xs-12">
		        <div class="box box-primary">
		          	<div class="box-header">
		            	<h3 class="box-title"><?php echo $btn.' '.$this->msgName;?></h3>
		          	</div>
		          	<div class="box-body">
		          		<form action="<?php echo base_url().$this->controller?>/placeorder" method="post" id="listform" data-parsley-validate class="form-horizontal form-label-left">
		          			<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="product_name">
									User List<font color="red"><span class="required">*</span></font> :
								</label>
								<div class="col-md-9 col-sm-12 col-xs-12">
									<p><select class="form-control select2" name="usersList" style="width:100%;" id="usersList">
                                        <option value="" selected >All Users</option>
                                        <?php
                                            if(!empty($activecustomer) && count($activecustomer) > 0 ){
                                            
                                            foreach ($activecustomer as $activecustomerKey => $activecustomerValue) {
                                        ?>
                                            <option value="<?php echo $activecustomerValue['id']; ?>"><?php echo $activecustomerValue['company_name']; ?></option>
                                        <?php
                                            }
                                            }else{
                                        ?>
                                            <option value="">-- No User Available --</option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <input type="hidden" name="userid" id="userid">
                                    <label id="usersList-error" class="error" for="usersList"></label>
                                	</p>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="product_name">
									Items<font color="red"><span class="required">*</span></font> :
								</label>
								<div class="col-md-9 col-sm-12 col-xs-12">
									<p><select class="form-control select2" name="productsList" style="width:100%;" id="productsList">
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
                                    <label id="productsList-error" class="error" for="productsList"></label>
                                	</p>
                                    <div id="show" style="display:none;">
                                    	<div class="card">
	                                    	<div class="form-group">
		                                        <div class="col-md-3">
		                                        	<strong>Item Name:</strong>
		                                        </div>
		                                        <div class="col-md-9">
		                                        	<input type="text" id="item_name" name="item_name" disabled="" class="form-control">
		                                        </div>
	                                    	</div>
	                                    	<div class="form-group">
		                                        <div class="col-md-3">
		                                        	<strong>Design No:</strong>
		                                        </div>
		                                        <div class="col-md-9">
		                                        	<input type="text" id="design_no" name="design_no" disabled="" class="form-control">
		                                        </div>
	                                    	</div>
	                                    	<div class="form-group">
		                                        <div class="col-md-3">
		                                        	<strong>Available Quantity:</strong>
		                                        </div>
		                                        <div class="col-md-9">
		                                        	<input type="text" id="availableqty" disabled="" class="form-control" name="availableqty">
		                                        </div>
	                                    	</div>
	                                    	<div class="form-group">
		                                        <div class="col-md-3">
		                                        	<strong>Size:</strong>
		                                        </div>
		                                        <div class="col-md-9">
		                                        	<input type="text" id="size" name="size" disabled="" class="form-control">
		                                        </div>
	                                    	</div>
	                                    	<div class="form-group">
		                                        <div class="col-md-3">
		                                        	<strong>Rate:</strong>
		                                        </div>
		                                        <div class="col-md-9">
		                                        	<div class="col-md-3">
		                                        		Cash<input type="text" id="ratec" disabled="" class="form-control">
		                                        	</div>
		                                        	<div class="col-md-3">
		                                        		Credit<input type="text" id="ratecr" disabled="" class="form-control">
		                                        	</div>
		                                        	<div class="col-md-3">
		                                        		Walkin<input type="text" id="ratew" disabled="" class="form-control">
		                                        	</div>
		                                        	<div class="col-md-3">
		                                        		Flexible<input type="text" id="ratew" disabled="" class="form-control" value="No Rate">
		                                        	</div> 
		                                        	<div style="margin:5px;"><strong style="color:green;">User Rate :- </strong><input type="text" id="hidrates" disabled=""></div>      	
		                                        </div>
			                                    
	                                    	</div>
                                    	</div>
                                    </div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="description">Quantity <font color="red"><span class="required">*</span></font>:</label>			
								<div class="col-md-9 col-sm-12 col-xs-12">
									<input type="number" name="qty" id="qty" class="form-control" value="1" min="1">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="description">Cargo <font color="red"><span class="required">*</span></font>:</label>			
								<div class="col-md-9 col-sm-12 col-xs-12">
									<input type="text" class="form-control"  name="cargo" id="cargo">
									<label id="cargo-error" class="error" for="cargo"></label>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="description">Cargo Number <font color="red"><span class="required">*</span></font>:</label>			
								<div class="col-md-9 col-sm-12 col-xs-12">
									<input type="text" class="form-control"  name="cargo_number" id="cargo_number">
									<label id="cargo_number-error" class="error" for="cargo_number"></label>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="description">Location <font color="red"><span class="required">*</span></font>:</label>			
								<div class="col-md-9 col-sm-12 col-xs-12">
									<input type="text" class="form-control"  name="location" id="location">
									<label id="location-error" class="error" for="location"></label>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="description">Mark <font color="red"><span class="required">*</span></font>:</label>			
								<div class="col-md-9 col-sm-12 col-xs-12">
									<input type="text" class="form-control"  name="mark" id="mark">
									<label id="mark-error" class="error" for="mark"></label>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="description">Customer LPO Number <font color="red"><span class="required">*</span></font>:</label>			
								<div class="col-md-9 col-sm-12 col-xs-12">
									<input type="text" class="form-control"  name="clpo" id="clpo">
									<label id="clpo-error" class="error" for="clpo"></label>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="description">Vat (5%) :</label>			
								<div class="col-md-9 col-sm-12 col-xs-12">
									<input type="text" class="form-control"  name="vat" id="vat" value="5%" disabled="">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="description">Total Price :</label>			
								<div class="col-md-9 col-sm-12 col-xs-12">
									<input type="text" class="form-control"  name="totalprice" id="totalprice" disabled="">
								</div>
							</div>
							<div class="box-footer">
								<input type="hidden" name="hidpid" id="hidpid">
								<input type="hidden" name="hidprice" id="hidprice">
								<input type="hidden" name="hidrate" id="hidrate">
								<input type="submit" class="btn btn-primary" style="float:right;font-size:16px;background-color:#e4573d;border-color:#e4573d;" value="Place Order">
							</div>
						</form>
		            </div>
		        </div>
		    </div>
		</div>
  	</section>
</div>
<?php
  $this->load->view('include/footer');
?>
<style type="text/css">
  .list-unstyled
  {
    text-align: center !important;
    padding: 10px;
  }
  .table-condensed thead tr th
  {
    text-align: center !important;
  }
  .error {
  	color: red !important;
  }
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#usersList").on('change', function() {
		var id = $(this).val();
	    $("#userid").val(id);
	});
	$('#productsList').on('keyup change', function() {
  		var id = $(this).val();
  		var userid = $("#userid").val();

	    $.ajax({
	      type : "POST",
	      url : "<?php echo base_url().$this->controller."/fetchitem/" ?>",
	      data : {id:id,userid:userid},
	      dataType: "json",
	      success : function (data){
	      	if(data.status=="success"){
	      		$("#show").css("display", "block");
	        	$("#item_name").val(data.item.name);
	        	$("#design_no").val(data.item.design_no);
	  			$("#availableqty").val((data.item.quantity) - (data.item.sold_quantity));
	        	$("#size").val(data.item.size);
	        	$("#ratec").val(data.item.cash_rate);
	        	$("#ratecr").val(data.item.credit_rate);
	        	$("#ratew").val(data.item.walkin_rate);
	        	$("#ratef").val(data.item.flexible_rate);
	        	$("#hidpid").val(data.item.id);
	        	$("#hidrate").val(data.rate);
	        	$("#hidrates").val(data.rate);
	        		var qty = $("#qty").val();
					var rate = $("#hidrate").val();
					var price = (rate * qty);
					var vat = ((price * 5) / 100);
					var totalprice = (price + vat);
					$("#totalprice").val(totalprice);
					$("#hidprice").val(totalprice);
	        }else {
	        	$("#show").css("display", "none");
	        }
	      }
	    });
	     
	});
	$('#qty').on('keyup change', function() {
		var qty = $("#qty").val();
		var rate = $("#hidrate").val();
		var price = (rate * qty);
		var vat = ((price * 5) / 100);
		var totalprice = (price + vat);
		$("#totalprice").val(totalprice);
		$("#hidprice").val(totalprice);
	});
});
</script>
<script type="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#listform').validate({
        rules: {
        	usersList : {
        		required :true,
        	},
            productsList: {
                required :true,
            },
            qty: {
            	required :true,
            	digits: true
            },
            cargo : {
            	required :true
            },
            cargo_number : {
            	required :true
            },
            location : {
            	required :true
            },
            mark :  {
            	required :true
            },
            clpo : {
            	required :true
            }
        },
        messages : {
        	usersList : {
        		required : "Please Select User"
        	},
            productsList: {  
              required : "Please Select Item"
            },
            qty: {
            	required : "Please Enter Quantity",
            	digits: "Allow Only Digit"
            },
            cargo : {
            	required : "Please Enter Cargo"
            },
            cargo_number : {
            	required : "Please Enter Cargo Number"
            },
            location : {
            	required : "Please Enter Location"
            },
            mark : {
            	required : "Please Enter Mark"
            },
            clpo : {
            	required : "Please Enter Customer LPO Number"
            }
        }
    });
});
</script>