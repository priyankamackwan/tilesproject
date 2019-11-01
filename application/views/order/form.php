<?php
	$this->load->view('include/header');
	$this->load->view('include/leftsidemenu');	
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);
?>
<?php
	if($action == 'insert')
	{
		$btn = "Save";
	}
	else if($action == 'update')
	{
		$btn = "Update";
	}
?>
<style type="text/css">
a:hover, a:active, a:focus {
    cursor: pointer;
}
</style>
<!-- Main Container start-->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	<a href="<?php echo base_url($this->controller);?>"class="btn btn-info">Back</a>
	
	<?php
		echo $this->session->flashdata('edit_profile');
		echo $this->session->flashdata('Change_msg');
		echo $this->session->flashdata('dispMessage');		
		echo $this->session->flashdata($this->msgDisplay);
	?>
	<!-- <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
		<li class="active">Users</li>
	</ol> -->
	</section>
	<!-- Main content section start-->
	<section class="content">
    	<div class="row">
      		<div class="col-md-9 col-sm-12 col-xs-12">

				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title"><?php echo $btn.' '.$this->msgName;?></h3>
					</div>

					<div class="box-body">
						<form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/Update_order';?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							
							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
							<input type="hidden" id="action" name="action" value="<?php echo $action;?>">
							<input type="hidden" id="ordercount" name="ordercount" value="<?php echo count($result);?>">
									<div class="col-md-3 col-sm-12 col-xs-12">
									</div>
									<div class="col-md-5 col-sm-5 col-xs-5">
										<label>Item Name (Design No)</label>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-3">
										<label >Quantity</label>
										
									</div>
									<div class="col-md-1 col-sm-4 col-xs-4">
										<label >Delete</label>
									</div>
									<!-- Show byuing product -->
							<div id="new_item_add">		
							<?php 
							$username=$sales_expense=$status=$invoice_status=$payment_date=$delivery_date=$price=$client_type=[];
							foreach ($result as $key => $value) {
								$username=$value['company_name'];
								$sales_expense=$value['sales_expense'];
								$status=$value['status'];
								$invoice_status=$value['invoice_status'];
								if(isset($value['payment_date']) && $value['payment_date']!=''){
									$payment_date=$value['payment_date'];
								}
								if(isset($value['delivery_date']) && $value['delivery_date']!=''){
									$delivery_date=$value['delivery_date'];
								}
								if(isset($value['client_type']) && $value['client_type']!='' && $value['client_type']==1){
									$price=$value['cash_rate'];
									$client_type='cash_rate';
								}elseif(isset($value['client_type']) && $value['client_type']!='' && $value['client_type']==2){
									$price=$value['credit_rate'];
									$client_type='credit_rate';
								}elseif(isset($value['client_type']) && $value['client_type']!='' && $value['client_type']==3){
									$price=$value['walkin_rate'];
									$client_type='walkin_rate';
								}elseif(isset($value['client_type']) && $value['client_type']!='' && $value['client_type']==4){
									$price=$value['flexible_rate'];
									$client_type='flexible_rate';
								}
							?>
							<div id="delete_<?php echo $key+1;?>">
								<div class="form-group select2">
									<label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
										Item <font color="red"><span class="required">*</span></font> :
									</label>

									<div class="col-md-5 col-sm-5 col-xs-5">
										
									<select class="form-control select2" name="product_id<?php echo $key+1;?>" style="width:100%;" id="product_id" required="required">
									    <option value="" selected >All</option>
									    <?php
									        if(!empty($activeProducts) && count($activeProducts) > 0 ){
									        
									            foreach ($activeProducts as $activeProductsKey => $activeProductsValue) {
									    ?>
									                <option value="<?php echo $activeProductsValue['id']; ?>" <?php if(isset($value['product_id']) && $value['product_id']!='' && $value['product_id']==$activeProductsValue['id']){echo 'selected';}?>><?php echo $activeProductsValue['name'].' ( '.$activeProductsValue['design_no'].' )'; ?></option>
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
									<div class="col-md-1 col-sm-1 col-xs-1">
										<input type="text" name="quantity_<?php echo $key+1;?>" id="quantity" value="<?php echo $value['quantity'];?>" required="required" onkeypress="return IsNumeric(event);">
									</div>
									<div class="col-md-1 col-sm-1 col-xs-1 pull-right">
										<a class='btn btn-danger'  onclick="remove_item(<?php echo $key+1;?>);" data-toggle='tooltip' title='Delete' ><i class='fa fa-close'></i></a>
									</div>
								</div>
							</div>
							<?php	
							}
							?>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 pull-right">
									<a class="pull-right" data-toggle="tooltip" title="" data-original-title="Add more items" onclick="add_more_items();"><i class="fa fa-plus"></i> Add More Items</a>
								</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">User Name :</label>
								<div class="col-md-9 col-sm-12 col-xs-12">
								<?php echo $username;?>
								</div>
							</div>
							<div class="form-group">
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="sales_expense">
				                  Sales Expense :
				                </label>

				                <div class="col-md-9 col-sm-12 col-xs-12">
				                  <input type="text" name="sales_expense" value="<?php echo $sales_expense;?>" class="form-control" placeholder="Enter Sales Expense">
				                </div>
				              </div>

				              <div class="form-group">
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="order_status">
				                  Delivery Status :
				                </label>

				                <div class="col-md-9 col-sm-12 col-xs-12">
				                  <select name="status" class="form-control select2" style="width: 100%;" id="delivery_status">
				                        <option value="0" <?php if($status==0){echo 'selected';}?>>Pending</option>
				                        <option value="1" <?php if($status==1){echo 'selected';}?>>In Progress</option>
				                        <option value="2" <?php if($status==2){echo 'selected';}?>>Completed</option>
				                  </select>
				                </div>
				              </div>
				              <div class="form-group" id="id_delivery_date" <?php if ($status != 2) { ?> style="display: none;" <?php } ?> >  <!-- if delivery status is completed then display the date div -->
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="delivery_date">
				                  Delivery Date :
				                </label>

				                <div class="col-md-9 col-sm-12 col-xs-12">
				                  <div class='input-group date' id='delivery_datetimepicker'>
				                      	<?php 
				                        if ($status != 2) 
				                        {
				                            $delivery_date_value="";
				                        }else{
				                            $delivery_date_value=date('d/m/Y h:i A',strtotime($delivery_date));
				                        }
				                      ?>
				                      <input type='text' class="form-control" id="txt_deliverydate" name="txt_deliverydate" value="<?php echo $delivery_date_value; ?>" required="required"/>
				                      <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar" id="delivery_gly"></span>
				                      </span>
				                  </div>
				                </div>
				              </div>

			              <div class="form-group">
			                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="order_payment_status">
			                  Payment Status :
			                </label>
			                <div class="col-md-9 col-sm-12 col-xs-12">
			                  <select name="invoice_status" style="width: 100%;" class="form-control select2" id="payment_status">
			                        <option value="0" <?php if($invoice_status==1){echo 'selected';}?>>Unpaid</option>
			                        <option value="1" <?php if($invoice_status==1){echo 'selected';}?>>Paid</option>
			                    ?> 
			                  </select>
			                </div>
			              </div>
			              <!-- payment date -->
			              <div class="form-group" id="id_payment_date" <?php if ($invoice_status != 1) { ?> style="display: none;" <?php } ?> > 
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="payment_date">
				                  Payment Date :
				                </label>
				                <div class="col-md-9 col-sm-12 col-xs-12">
				                  <div class='input-group date' id='payment_datetimepicker'>
				                      <?php 
				                            if ($invoice_status != 1){
				                              $payment_date_value="";
				                            }else{
				                              $payment_date_value=date('d/m/Y h:i A',strtotime($payment_date));
				                            }
				                      ?>
				                      <input type='text' class="form-control" id="txt_paymentdate" name="txt_paymentdate" value="<?php echo $payment_date_value; ?>"  required="required"/>
				                      <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar" id="payment_gly"></span>
				                      </span>
				                  </div>
				                </div>
				              </div>
				              <input type="hidden" name="username" value="<?php echo $username;?>">
				              <input type="hidden" name="price" value="<?php echo $price;?>">
				              <input type="hidden" name="client_type" value="<?php echo $client_type;?>">
				              
				              <div class="form-group">
				              	<div class="col-md-3 col-sm-12 col-xs-12"></div>
					              	
								</div>
								<div class="box-footer">
									<input type="submit" class="btn btn-primary" value="<?php echo $btn;?>">
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
$(document).ready(function (){
    
    jQuery.validator.addMethod("noSpace", function(value, element) {
		return value == '' || value.trim().length != 0;  
    }, "No space please and don't leave it empty");
	
	$('#demo-form2').validate({
		errorClass:"text-danger",
		rules:{
			image:{
				required: true,
			},
			name:{
				required: true,
			                                noSpace: true,
				remote:{
					url:"<?php echo base_url().$controller."/checkname";?>",
					type:"post",
					data:{
						id:id,
						action: action,
						name: function(){
							return $('input[name = "name"]').val();
						},
					},
				}
			},
		                         description:{noSpace: true,},   
		},
		messages: {
                                    
			name: {
				required: "Please Enter Item Group",
				remote: "Item Group Name Exist"
			}
			
		},
		submitHandler: function(form){
			form.submit();
		}
	});
});
function readURL(input) {  
  $('#updated_image').html('');
  var file = input.files[0];
  var fileType = file["type"];
  var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/jpg","image/bmp"];
  if ($.inArray(fileType, validImageTypes) < 0) {
    $('#updated_image').html('The image must be a file of type: jpg, jpeg, gif, png. ').css("color", "red");
    return flase;
  }
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#blah')
      .attr('src', e.target.result)
      .width(50)
      .height(50);
    };
    reader.readAsDataURL(input.files[0]);
  }
}
function add_more_items(){
	var item_nmuber=$("#ordercount").val();
	var add_item=1;
	var total_item= parseInt(item_nmuber) + parseInt(add_item);
	$("#ordercount").val(total_item);
	$("#new_item_add").append('<div id="delete_'+total_item+'">');


	$("#delete_"+total_item).append('<div class="form-group select2"><label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">Item <font color="red"><span class="required">*</span></font>:</label><div class="col-md-5 col-sm-5 col-xs-5"><select class="form-control select2" name="product_id'+total_item+'" style="width:100%;" id="product_id" required="required"><option value="" selected >All</option><?php if(!empty($activeProducts) && count($activeProducts) > 0 ){
    foreach ($activeProducts as $activeProductsKey => $activeProductsValue){
?><option value="<?php echo $activeProductsValue['id']; ?>"><?php echo $activeProductsValue['name'].' ( '.$activeProductsValue['design_no'].' )'; ?></option><?php } }else{ ?><option value="">-- No Item Available --</option><?php } ?></select></div><div class="col-md-1 col-sm-1 col-xs-1"><input type="text" name="quantity_'+total_item+'" id="quantity" required="required" onkeypress="return IsNumeric(event);"></div><div class="col-md-1 col-sm-1 col-xs-1 pull-right"><a class="btn btn-danger" onclick="remove_item('+total_item+')" data-toggle="tooltip" title="Delete"><i class="fa fa-close"></i></a></div></div>');
	$('select').select2();
}
function remove_item(id){
	if (confirm("Do you want to delete this items")){
		$("#delete_"+id).remove();
	}
	return false;
	alert(id);
}


function IsNumeric(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
// For date picker
$(document).ready(function() {
  $('#delivery_datetimepicker').datetimepicker({
    locale: 'ru',
      autoclose: true
  });

  $('#payment_datetimepicker').datetimepicker({
    locale: 'ru',
      autoclose: true,
  });
});

//Reselect delivery date -->
$("#delivery_gly").click(function() {
  $("#txt_deliverydate").val('');
  $('#delivery_datetimepicker').datetimepicker({
    locale: 'ru',
      autoclose: true
  });
});
// Reselect payment date 
$("#payment_gly").click(function() {

  $("#txt_paymentdate").val('');
  $('#payment_datetimepicker').datetimepicker({
    locale: 'ru',
      autoclose: true
  });
});
$("#delivery_status").change(function(){

  if($("#delivery_status").val()=="2") // if status is completed then display datetimepicker
  {
    document.getElementById("id_delivery_date").style.display = "block";
  }
  else
  {
    document.getElementById("id_delivery_date").style.display = "none";
    $("#txt_deliverydate").val('');
  }
});
$("#payment_status").change(function(){

  if($("#payment_status").val()=="1") // if status is paid then display datetimepicker
  {
    document.getElementById("id_payment_date").style.display = "block";
  }
  else
  {
    document.getElementById("id_payment_date").style.display = "none";
    $("#txt_paymentdate").val('');
  }
});
</script>
