<?php
//echo '<pre>';
//print_r($selected_categories); exit;
	$this->load->view('include/header');
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);
             $choosen_categories = array();
        foreach ($selected_categories as $key=>$val) {
            $choosen_categories[]=$val['cat_id'];
        }
        
        $choosen_subcategories = array();
        foreach ($selected_categories as $key=>$val) {
            $choosen_subcategories[]=$val['sub_cat_id'];
        }
       // echo '<pre>';
       // print_r($choosen_categories); exit;
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

<!-- page content -->
        <div class="right_col" role="main">
		<div class="row">
            <div class="page-title">
              <div class="title_left">
					<a href="<?php echo base_url($this->controller);?>"class="btn btn-info">Back</a> 
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $btn.' '.$this->msgName;?></h2>
                    <div class="clearfix"></div>
                  </div>
                <div class="x_content">
                    <br />
                    <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					<input type="hidden" id="id" name="id" value="<?php echo $result[0]->id;?>">
                                       <input type="hidden" id="action" name="action" value="<?php echo $action?>">
                                       <input type="hidden" id="action" name="old_image" value="<?php echo $result[0]->image;?>">
                                       
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Product Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name" value="<?php echo $result[0]->name;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Product Name">
                        </div>
                      </div>
                                                     	  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="design_no">Design No<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="design_no" value="<?php echo $result[0]->design_no;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Design No">
                        </div>
                      </div>
                                     
                                                   	  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="cash_rate">Cash Rate<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php if ($this->userhelper->current('role_id') == 1) { ?>
                          <input type="text" name="cash_rate" value="<?php echo $result[0]->cash_rate;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Cash Rate">
                         <?php } else { ?>
                          <input type="text" name="cash_rate" value="<?php echo $result[0]->cash_rate;?>" readonly="" class="form-control col-md-7 col-xs-12" placeholder="Enter Cash Rate">
                         <?php } ?>
                        </div>
                      </div>
                                    
                                       	  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="credit_rate">Credit Rate<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                             <?php if ($this->userhelper->current('role_id') == 1) { ?>
                          <input type="text" name="credit_rate" value="<?php echo $result[0]->credit_rate;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Credit Rate">
                             <?php } else { ?>
                          <input type="text" name="credit_rate" value="<?php echo $result[0]->credit_rate;?>" readonly="" class="form-control col-md-7 col-xs-12" placeholder="Enter Credit Rate">
                           <?php } ?>
                        </div>
                      </div>
                                       	  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="walkin_rate">Walkin Rate<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                             <?php if ($this->userhelper->current('role_id') == 1) { ?>
                          <input type="text" name="walkin_rate" value="<?php echo $result[0]->walkin_rate;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Walkin Rate">
                             <?php } else { ?>
                      <input type="text" name="walkin_rate" value="<?php echo $result[0]->walkin_rate;?>" readonly="" class="form-control col-md-7 col-xs-12" placeholder="Enter Walkin Rate">
                           <?php } ?>
                        </div>
                      </div>
                                
          	  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="flexible_rate">Flexible Rate<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                             <?php if ($this->userhelper->current('role_id') == 1) { ?>
                          <input type="text" name="flexible_rate" value="<?php echo $result[0]->flexible_rate;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Flexible Rate">
                             <?php } else { ?>
                      <input type="text" name="flexible_rate" value="<?php echo $result[0]->flexible_rate;?>" readonly="" class="form-control col-md-7 col-xs-12" placeholder="Enter Flexible Rate">
                           <?php } ?>
                        </div>
                      </div>                                       
                         
                           
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="Size">Size
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="size" value="<?php echo $result[0]->size;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Size">
                        </div>
                      </div>
                                       <?php if($action == "insert"){ ?>
                                         <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_image">Product Image<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" name="image" class="form-control numberonly col-md-7 col-xs-12">
                        </div>
					  </div>
                                       <?php } ?>
                                                 <?php if($action == "update"){ ?>
                                         <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_image">Product Image<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" name="updated_image" class="form-control numberonly col-md-7 col-xs-12">
                        </div>
					  </div>
					  <div class="form-group uploadedImage">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_image">Uploaded Image
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<img width="150px" height="150px" src="<?php echo base_url().'./assets/uploads/'.$result[0]->image;?>" style="background-color:navy;" >
						</div>
					  </div>
					  <?php } ?>
                                       
                                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="Quantity">Quantity<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="quantity" id="quantity" value="<?php echo $result[0]->quantity;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Quantity">
                        </div>
                                        </div>
                                        <?php if($action == "update"){ ?>
                                         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="Quantity">Sold Quantity
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="sold_quantity" disabled="" id="sold_quantity" value="<?php echo $result[0]->sold_quantity;?>" class="form-control col-md-7 col-xs-12" placeholder="">
                        </div>
                                        </div>
                                       <?php } ?>
                                          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="Factor">Factor<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="factor" id="factor" value="<?php echo $result[0]->factor;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Factor">
                        </div>
                                        </div>
                      <?php if ($this->userhelper->current('role_id') ==1) { ?>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="purchase_expense">Purchase Price<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="purchase_expense" value="<?php echo $result[0]->purchase_expense;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Purchase Price">
                        </div>
                      </div>
                      <?php } ?>
                                         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="latitude">Unit<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="js-example-basic-multiple" name="unit"  id="unit">
                              <option value="0">Select Unit</option>
                              
                                 <?php if($result[0]->unit == 1) { ?>
                              <option value="1" selected="">CTN</option>
                                <?php } else { ?>
                              <option value="1">CTN</option>
                                <?php } ?>
                              
                                 <?php if($result[0]->unit == 2) { ?>
                              <option value="2" selected="">SQM</option>
                                <?php } else { ?>
                              <option value="2">SQM</option>
                                <?php } ?>
                                
                                <?php if($result[0]->unit == 3) { ?>
                              <option value="3" selected="">PCS</option>
                                <?php } else { ?>
                               <option value="3">PCS</option>
                                <?php } ?>
                             
                                 <?php if($result[0]->unit == 3) { ?>
                               <option value="4" selected="">SET</option>
                                <?php } else { ?>
                               <option value="4">SET</option>
                                <?php } ?>
                             
                              
                              
</select>
                        </div>
                      </div>
                                       <div class="form-group" id="quanity_div">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="quantity_per">Quantity per <span id="unit_name"></span> unit<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="quantity_per_unit" id="quantity_per" readonly="" value="<?php echo $result[0]->quantity_per;?>" class="form-control col-md-7 col-xs-12" placeholder="Quantity Per">
                        </div>
                                        </div>
                          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="latitude">Categories<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="js-example-basic-multiple" name="categories[]" multiple="multiple" id="category">
                              <?php for($i=0;$i<count($categories);$i++) { 
                              if (in_array($categories[$i]['id'], $choosen_categories)) { ?>
                              <option value="<?php echo $categories[$i]['id'];?>" selected=""><?php echo $categories[$i]['name'];?></option>
                              <?php } else { ?>
                               <option value="<?php echo $categories[$i]['id'];?>"><?php echo $categories[$i]['name'];?></option>
                              <?php } }?>
</select>
                        </div>
                      </div>
                                       
                                           <!--  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="latitude">SubCategories<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="js-example-basic-multiple" name="subcategories[]" multiple="multiple" id="subcategory">
                       <?php /*($i=0;$i<count($sub_categories);$i++) { 
                              if (in_array($sub_categories[$i]['id'], $choosen_subcategories)) { ?>
                              <option value="<?php echo $sub_categories[$i]['id'];?>" selected=""><?php echo $sub_categories[$i]['name'];?></option>
                              <?php } else { ?>
                               <option value="<?php echo $sub_categories[$i]['id'];?>"><?php echo $sub_categories[$i]['name'];?></option>
                              <?php } } */?>   
</select>
                        </div>
                      </div> -->

                                        

					  <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-primary"><?php echo $btn;?></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            </div>
            </div>
        <!-- /page content -->
<?php
	$this->load->view('include/footer');
?>
	<script>
		$(document).ready(function (){
                   
                    $("#quanity_div").hide();
                        jQuery.validator.addMethod("noSpace", function(value, element) {
return value == '' || value.trim().length != 0;  
    }, "No space please and don't leave it empty");
                     $(function () {
       $("#category").change(function () {
           var cat_id = $("#category").val();
            var sub_cat_id = $("#subcategory").val();
                 $.ajax({
  type: "POST",
  url: "<?php echo base_url().$controller."/addsubcategories";?>",
  data: {
    value: cat_id,
    sub_cat : sub_cat_id,
  },
  success: function(msg) {
     
        $("#subcategory").html(msg);
    
  },
  error:function(e){
      alert("something wrong"+ e) // this will alert an error
  }
});
    })});
    
    $("#quantity").blur(function(){
 
  unit = $("#unit").val();
  quantity =  $("#quantity").val();
  factor =  $("#factor").val();
  quantity_per = quantity*factor;
 
  if (unit != '0' && unit != '' && quantity != '' && factor != '') {
      $("#quanity_div").show();
      $("#quantity_per").val(quantity_per);
        if (unit == 1) {
          unit_value = 'CTN';
            } else if (unit == 2) {
                 unit_value = 'SQM';
            } else if (unit == 3) {
                 unit_value = 'PCS';
            } else if (unit == 4) {
                 unit_value = 'SET';
            }
           
      $("#unit_name").text(unit_value);
        } else  {
         $("#quanity_div").hide(); 
        }
}); 

   $("#factor").blur(function(){
 
  unit = $("#unit").val();
  quantity =  $("#quantity").val();
  factor =  $("#factor").val();
  quantity_per = quantity*factor;
 
  if (unit != '0' && unit != '' && quantity != '' && factor != '') {
      $("#quanity_div").show();
      $("#quantity_per").val(quantity_per);
        if (unit == 1) {
          unit_value = 'CTN';
            } else if (unit == 2) {
                 unit_value = 'SQM';
            } else if (unit == 3) {
                 unit_value = 'PCS';
            } else if (unit == 4) {
                 unit_value = 'SET';
            }
           
      $("#unit_name").text(unit_value);
        } else  {
         $("#quanity_div").hide(); 
        }
}); 

 $('#unit').on('change', function() {
  unit = this.value;
  quantity =  $("#quantity").val();
  factor =  $("#factor").val();
  quantity_per = quantity*factor;
  
  if (unit != '0' && unit != '' && quantity != '' && factor != '') {
      $("#quanity_div").show();
      $("#quantity_per").val(quantity_per);
      if (unit == 1) {
          unit_value = 'CTN';
            } else if (unit == 2) {
                 unit_value = 'SQM';
            } else if (unit == 3) {
                 unit_value = 'PCS';
            } else if (unit == 4) {
                 unit_value = 'SET';
            }
           
      $("#unit_name").text(unit_value);
        } 
      else {
         $("#quanity_div").hide(); 
        }
});
			var id = $('input[name = "id"]').val();
			var action = $('input[name = "action"]').val();
			$('#demo-form2').validate({
				rules:{
                                           image:{
							required: true,
                                                    },
						name:{
							required: true,
						},
                                                design_no:{
							required: true,
						},
                                                cash_rate:{
							required: true,
						},
                                                credit_rate:{
							required: true,
						},
                                                walkin_rate:{
							required: true,
						},
                                                flexible_rate:{
							required: true,
						},
                                                purchase_expense:{
							required: true,
						},
                                                price:{
							required: true,
						},
                                                quantity:{
							required: true,
						},
                                                 unit:{
							required: true,
						}
					
					},
					messages: {
                                                
						name: {
							required: "Please Enter Product",
                                                        noSpace: true,
						},
                                                price: {
							required: "Please Enter Price",
                                                        noSpace: true,
						},
                                                quantity: {
							required: "Please Enter Quantity",
                                                        noSpace: true,
						}
						
					},
					submitHandler: function(form){
						form.submit();
					}
		});
	});
	</script>