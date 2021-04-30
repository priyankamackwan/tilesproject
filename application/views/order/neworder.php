<?php
	$this->load->view('include/header');
	$this->load->view('include/leftsidemenu');	
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);
?>

<style type="text/css">
a:hover, a:active, a:focus {
	cursor: pointer;
}
.width_80{
		width: 80px;
	}
	table#datatables1 th {
	vertical-align: middle;
	}
	
@media only screen and (min-width: 320px) and (max-width: 480px) {
	.width_80{
		width: 50px;
	}
	.dis_none{
		display: none;

	}
	.maxwidth300{
		max-width: 300% !important;
	}
}
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
	.width_80{
			width: 50px;
	}
	.marginright_20px{
		margin-right: 20px;
	}
	.dis_none{
		display: none;
	}
}
@media screen and (device-width: 360px) and (device-height: 640px) and (-webkit-device-pixel-ratio: 2) {
	.width_80{
		width: 50px;
	}
	.dis_none{
		display: none;
	}
}

</style>
<!-- Main Container start-->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	<div class="row">
		<div class="col-md-11 col-sm-12 col-xs-12">
			<a href="<?php echo base_url($this->controller);?>"class="btn btn-info">Back</a>
		</div>
	</div>
	<?php
		echo $this->session->flashdata('edit_profile');
		echo $this->session->flashdata('Change_msg');
		echo $this->session->flashdata('dispMessage');		
		echo $this->session->flashdata($this->msgDisplay);
	?>
	</section>
	<!-- Main content section start-->
	<section class="content">
		<div class="row">
			<div class="col-md-11 col-sm-12 col-xs-12">
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title"><?php echo $this->msgName;?></h3>
					</div>
					<div class="box-body">
						<form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/placeorder';?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
							<input type="hidden" id="ordercount" name="ordercount">
							<div class="col-md-12 col-sm-12 col-xs-12 ">
								<div class="col-md-1 col-sm-2 col-xs-2">
									<label class="maxwidth300">&nbsp;</label>
								</div>
								<div class="col-md-3 col-sm-3 col-xs-3">
									<label class="maxwidth300">Item Name (Design No)</label>
								</div>
								<div class="col-md-2 col-sm-3 col-xs-3">
									<label class="maxwidth300">Quantity</label>								
								</div>
								<div class="col-md-2 col-sm-2 col-xs-2">
									<label class="maxwidth300">Rate</label>								
								</div>
								<div class="col-md-2 col-sm-2 col-xs-2">
									<label class="maxwidth300">Price</label>								
								</div>
								<div class="col-md-1 col-sm-2 col-xs-2">
									<label class="maxwidth300">Status</label>
								</div>
								<div class="col-md-1 col-sm-2 col-xs-2">
									<label class="maxwidth300" style="max-width: 125%;">Delete</label>
								</div>
							</div>
							<!-- Show buying product -->
							<div id="new_item_add">		
								<div id="delete_<?php echo $key+1;?>" class="" >
									<div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top:10px;">
										<div class="col-md-1 col-sm-2 col-xs-2">
											&nbsp;
										</div>
										<div class="col-md-3 col-sm-3 col-xs-3">
											<select class="form-control select2 product_id" name="product_id<?php echo $key+1;?>" style="width:100%;" id="product_id" required="required" onchange="price_fetch(this.value,<?php echo $key+1;?>)">
											    <option value="" selected >All</option>
											    <?php
											        if(!empty($activeProducts) && count($activeProducts) > 0 ) {
											            foreach ($activeProducts as $activeProductsKey => $activeProductsValue) {?>
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
										<div class="col-md-2 col-sm-3 col-xs-3">
											<input type="text" name="quantity_<?php echo $key+1;?>" id="quantity" required="required" onkeypress="return IsNumeric(event);" class=" form-control width_80 quantity_<?php echo $key+1;?>" onchange="order_sum()">
										</div>
										<div class="col-md-2 col-sm-2 col-xs-2" >
											<input type="text" name="rate_<?php echo $key+1;?>" id="price"  required="required" class=" form-control width_80 rate_<?php echo $key+1;?>" onchange="order_sum()" ><i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="tooltip" data-original-title="tooltip" data-id="tooltip_<?php echo $key+1;?>" style="color:#00acd6;"></i>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-2" >
											<input type="text" name="price_<?php echo $key+1;?>" id="rate"  required="required" class=" form-control width_80 price_<?php echo $key+1;?>" onchange="order_sum()" readonly>
										</div>
										<div class="col-md-1 col-sm-2 col-xs-2" style="font-size:12px;"> <?php echo "Pending";?>
										</div>
										<div class="col-md-1 col-sm-2 col-xs-2">
											<a class='btn btn-danger' onclick="remove_item(<?php echo $key+1;?>);" data-toggle='tooltip' title='Delete' ><i class='fa fa-close'></i></a>
										</div>
									</div>
								</div>
							</div>
							<div class="control-label col-md-12 col-sm-12 col-xs-12 pull-right">
								<a class="pull-right" data-toggle="tooltip" title="" data-original-title="Add more items" onclick="add_more_items();"><i class="fa fa-plus"></i> Add More Items</a>
							</div>
							<!-- Tax-->
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">Tax <font color="red"><span class="required">*</span></font> :</label>
								<div class="col-md-9 col-sm-12 col-xs-12 mt_5">
									<input type="text" name="tax" id="tax" value="<?php  echo Vat ?>" class="form-control " placeholder="Enter total tax" required="required" readonly>
								</div>
							</div>
							<!-- Tax-->
							<!-- Tax in (%) start-->
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">Tax in (%) <font color="red"><span class="required">*</span></font> :</label>
								<div class="col-md-9 col-sm-12 col-xs-12 mt_5">
									<input type="text" name="tax_percentage" id="tax_percentage" value="<?php  echo Vat ?>" class="form-control " placeholder="Enter tax percentage" required="required" onchange="taxToRateConversion()" onkeypress="return percentageCalculation(event);">
									<!-- Add error for alert -->
									<label id="tax_percentage_error" class="text-danger" for="tax_percentage_error" style="display: none;">Tax percentage not be less than zero.</label>
								</div>
							</div>
							<!-- Tax in (%) end-->
							<!-- Total price-->
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">Total Price <font color="red"><span class="required">*</span></font> :</label>
								<div class="col-md-9 col-sm-12 col-xs-12 mt_5">
									<input type="text" name="total_price" id="total_price" value="<?php echo $total_price;?>" class="form-control " placeholder="Enter total price" required="required" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">User Name :</label>
								<div class="col-md-9 col-sm-12 col-xs-12 mt_5">
									<select name="username" id="username" onchange="userchange()">
										<?php 
										if(!empty($activecustomer)){
											foreach ($activecustomer as $key => $value) { ?>
												<option value="<?=$value['id'];?>"><?=$value['company_name'];?></option>
										<?php }}?>
									</select>
								</div>
							</div>
							<div class="form-group">
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="sales_expense">
				                  Cargo :
				                </label>
				                <div class="col-md-9 col-sm-12 col-xs-12">
				                  <input type="text" name="cargo" class="form-control " placeholder="Enter Cargo" required="required">
				                </div>
				              </div>
				              <div class="form-group">
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="sales_expense">
				                  Cargo Number :
				                </label>
				                <div class="col-md-9 col-sm-12 col-xs-12">
				                  <input type="text" name="cargo_number" class="form-control " placeholder="Enter Cargo Number" required="required">
				                </div>
				              </div>
				              <div class="form-group">
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="sales_expense">
				                  Location :
				                </label>

				                <div class="col-md-9 col-sm-12 col-xs-12">
				                  <input type="text" name="location" class="form-control " placeholder="Enter Location" required="required">
				                </div>
				              </div>
				              <div class="form-group">
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="sales_expense">
				                  Mark :
				                </label>
				                <div class="col-md-9 col-sm-12 col-xs-12">
				                  <input type="text" name="mark" class="form-control " placeholder="Enter mark" required="required">
				                </div>
				              </div>
			            	<input type="hidden" name="price" value="<?php echo $price;?>">
				            <div class="form-group">
				              	<div class="col-md-3 col-sm-12 col-xs-12"></div></div>
								<div class="box-footer">
									<input type="submit" class="btn btn-primary" style="float:right;font-size:16px;background-color:#e4573d;border-color:#e4573d;" value="Place Order">
								</div>
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
<script>
var item_nmuber= 1;
function add_more_items(){

	var add_item=1;
	var total_item= parseInt(item_nmuber) + parseInt(add_item);
	$("#ordercount").val(total_item);
	$("#new_item_add").append('<div id="delete_'+total_item+'">');
	$("#delete_"+total_item).append('<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;"><div class="col-md-1 col-sm-2 col-xs-2"></div><div class="col-md-3 col-sm-3 col-xs-3"><select class="form-control select2 product_id" name="product_id'+total_item+'" style="width:100%;" id="product_id" required="required" onchange="price_fetch(this.value,'+total_item+')"><option value="" selected >All</option><?php if(!empty($activeProducts) && count($activeProducts) > 0 ){
    foreach ($activeProducts as $activeProductsKey => $activeProductsValue){
?><option value="<?php echo $activeProductsValue['id']; ?>"><?php echo $activeProductsValue['name'].' ( '.$activeProductsValue['design_no'].' )'; ?></option><?php } }else{ ?><option value="">-- No Item Available --</option><?php } ?></select></div><div class="col-md-2 col-sm-3 col-xs-3"><input type="text" name="quantity_'+total_item+'" id="quantity" required="required" onkeypress="return IsNumeric(event);" class=" form-control width_80 quantity_'+total_item+'" onchange="order_sum()"></div><div class="col-md-2 col-sm-2 col-xs-2"><input type="text" name="rate_'+total_item+'" id="rate" required="required" class=" form-control width_80 rate_'+total_item+'" onchange="order_sum()"><i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="tooltip" data-original-title="tooltip" data-id="tooltip_'+total_item+'" style="color:#00acd6;"></i></div><div class="col-md-2 col-sm-2 col-xs-2"><input type="text" name="price_'+total_item+'" id="rate_" required="required" readonly class=" form-control width_80 price_'+total_item+'" onchange="order_sum()"></div><div class="col-md-1 col-sm-2 col-xs-2"></div><div class="col-md-1 col-sm-2 col-xs-2 marginright_20px"><a class="btn btn-danger" onclick="remove_item('+total_item+')" data-toggle="tooltip" title="Delete"><i class="fa fa-close"></i></a></div></div>');
	$('select').select2();
	item_nmuber = item_nmuber + 1;
}

function remove_item(id){
	//count product selected if item > 1 it not remove it
	var numItems =$('select.product_id').length;
	if(numItems >1){
		if (confirm("Do you want to delete this items")){
			$("#delete_"+id).remove();
			$("#quantity").focus();
		}
	}else{
		alert('You have must one item in your order..');
	}
	return false;
}


function IsNumeric(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
//percentage calculation
function percentageCalculation(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if(!((evt.keyCode > 95 && evt.keyCode < 106) || (evt.keyCode > 47 && evt.keyCode < 58) || evt.keyCode == 8)) {
    	$("#tax_percentage_error").show();
    	$("#tax_percentage").focus();
	    return true;
	}
}


$("#delivery_status").change(function(){
  if($("#delivery_status").val()=="2") {
    document.getElementById("id_delivery_date").style.display = "block";
  } else {
    document.getElementById("id_delivery_date").style.display = "none";
    $("#txt_deliverydate").val('');
  }
});
//price fetch on change prouct itemid is product id and itemNumber for div if balnck fetch last item_nmuber
function price_fetch(itemId,itemNumber=null){

	var product_id = $("#product_id").val();
	var item_nmuber = $("#ordercount").val();

	if (typeof itemId === "undefined") {
		var itemId =  parseInt(product_id);
	} else {
		var itemId =  parseInt(itemId);
	}

	if(itemNumber==null){
		var total_item= parseInt(item_nmuber);	
	}else{
		var total_item= parseInt(itemNumber);
	}

	if(itemId != '' ){
		$.ajax({
		    type : "POST",
		    url : "<?php echo base_url().$this->controller."/newratefetch/" ?>",
		    data : {itemId:itemId,users_id:$("#username").val()},
		    dataType: "json",
		    success : function (data){
		    	if(data.status="success"){
		    		$(".rate_"+total_item).val(data.price);
		    	}
		    }
		});
	}else{
		alert('There is some Error..'); 
	}
}
function userchange() {
	this.price_fetch();
	this.order_sum();
}
//sum of order onkeyup of quanttiy and price and remove item
function order_sum(){

	var totalPrice = 0;
	var totalItem= parseInt(item_nmuber);
	for (var i = 1; i < totalItem+1; i++) {
		totalPrice +=$(".rate_"+i).val() * $(".quantity_"+i).val();
		$(".price_"+i).val($(".rate_"+i).val() * $(".quantity_"+i).val());
	}
	$("#total_price").val(totalPrice);
	//taxToRateConversion();
	// apply tax on total amount
	var tax_percentage = $("#tax_percentage").val();
	var amountAfterTax = ((totalPrice * parseFloat(tax_percentage))/100);
	if((amountAfterTax - Math.floor(amountAfterTax)) !== 0) {
		$("#tax").val('');
		$("#tax").val(amountAfterTax.toFixed(2));
	} else {
		$("#tax").val('');
		$("#tax").val(amountAfterTax);
	}
}




function taxToRateConversion() 
{ // enter tax % and tax amount reflex on basis of it
	var tax_percentage = $("#tax_percentage").val();

	if(parseFloat(tax_percentage)<0) // if % in minus
	{
		$("#tax_percentage_error").show();
		$("#tax_percentage").focus();
		return false;
	}
	else if(parseFloat(tax_percentage) == tax_percentage)
	{
		var totalPrice = $("#total_price").val();
		var tax_percentage = $("#tax_percentage").val();
		var amountAfterTax = ((parseInt(totalPrice)*parseFloat(tax_percentage))/100);

		if((amountAfterTax - Math.floor(amountAfterTax)) !== 0) // if ans in decimal than display 2 floating points
		{
			$("#tax").val('');
			$("#tax").val(amountAfterTax.toFixed(2));
		}
		else
		{
			$("#tax").val('');
			$("#tax").val(amountAfterTax);
		}
	}
	
}
$('#datatables1').dataTable({
	"ordering": false,
	"bPaginate": false,
	"lengthChange": false,
	"info": false,
	"searching": false,
	"scrollX": true
});
</script>
