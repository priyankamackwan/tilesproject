<?php
  $this->load->view('include/leftsidemenu');
	$this->load->view('include/header');
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);
//  print_r($user_data);die();
?>

<!-- page content -->
        <!-- <div class="right_col" role="main">
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
                    Please provide client type
                <div class="x_content">
                    <br />
                    <form action="<?php echo base_url().$this->controller.'/accept';?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="client_type">Client Type<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="js-example-basic-multiple" name="client_type" id="client_type">
                         <?php if ($client_type == 1) { ?>
                                <option value="1" selected="">Cash</option>
                         <?php } else { ?>
                                <option value="1">Cash</option>
                         <?php } ?>
                        <?php if ($client_type == 2) { ?>
                                <option value="2" selected="">Credit</option>
                         <?php } else { ?>
                               <option value="2">Credit</option>
                         <?php } ?>
                                
                        <?php if ($client_type == 3) { ?>
                               <option value="3"selected="">Walkin</option>
                        <?php } else { ?>
                                 <option value="3">Walkin</option>
                        <?php } ?>
                             
                        <?php if ($client_type == 4 && $this->userhelper->current('role_id') == 1)  { ?>
                               <option value="4"selected="">Flexible Rate</option>
                        <?php } else { ?>
                                 <option value="4">Flexible Rate</option>
                        <?php } ?>
                             
                             
</select>
                        </div>
                      </div>
					
                           
					  <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" id="submit1" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            </div>
            </div> -->
        <!-- /page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <a href="<?php echo base_url($this->controller);?>"class="btn btn-info">Back</a>
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
            <form action="<?php echo base_url().$this->controller.'/accept';?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
              <!-- Start Of new filed   -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="company_name">
                  Company Name<font color="red"><span class="required" aria-required="true">*</span></font> :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <input type="text" name="company_name" <?php if(isset($user_data->company_name) && $user_data->company_name!=''){?> value="<?php echo $user_data->company_name;?>" <?php } ?> class="form-control col-md-7 col-xs-12" placeholder="Enter Your Company Group Name">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="contact_person_name  ">
                  Contact Person Name<font color="red"><span class="required" aria-required="true">*</span></font> :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <input type="text" name="contact_person_name" <?php if(isset($user_data->contact_person_name  ) && $user_data->contact_person_name  !=''){?> value="<?php echo $user_data->contact_person_name  ;?>" <?php } ?> class="form-control col-md-7 col-xs-12" placeholder="Enter Your Contact Person Name">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="email">
                  Email<font color="red"><span class="required" aria-required="true">*</span></font> :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <input type="text" name="email" <?php if(isset($user_data->email) && $user_data->email !=''){?> value="<?php echo $user_data->email;?>" <?php } ?> class="form-control col-md-7 col-xs-12" placeholder="Enter Your Email Address">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="phone_no">
                  Phone<font color="red"><span class="required" aria-required="true">*</span></font> :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <input type="text" name="phone_no" <?php if(isset($user_data->phone_no  ) && $user_data->phone_no !=''){?> value="<?php echo $user_data->phone_no;?>" <?php } ?> class="form-control col-md-7 col-xs-12" placeholder="Enter Your Phone No">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="vat_number">
                  Vat Number <font color="red"><span class="required" aria-required="true">*</span></font> :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <input type="text" name="vat_number" <?php if(isset($user_data->vat_number) && $user_data->vat_number !=''){?> value="<?php echo $user_data->vat_number;?>" <?php } ?> class="form-control col-md-7 col-xs-12" placeholder="Enter Your Vat No">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="company_address">
                  Company Address<!-- <font color="red"><span class="required" aria-required="true">*</span></font> --> :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <textarea type="text" name="company_address"  class="form-control col-md-7 col-xs-12" ><?php if(isset($user_data->company_address) && $user_data->company_address!=''){ echo $user_data->company_address; } ?></textarea>
                </div>
              </div>
              <!-- End Of new filed   -->
              <div class="form-group">
                <label for="access" class="col-sm-3 control-label">Client Type<font color="red">*</font> :</label>
                <div class="col-sm-9">
                  <select class="form-control select2"  name='client_type' id="client_type" style="width: 100%;">
                    <option value="">All</option>
                    <option value="1" <?php  if ($user_data->client_type == 1) { echo 'selected'; }?>>Cash</option>
                    <option value="2" <?php  if ($user_data->client_type == 2) { echo 'selected'; }?>>Credit</option>
                    <option value="3" <?php  if ($user_data->client_type == 3) { echo 'selected'; }?>>Walkin</option>
                    <?php 
                    if ($user_data->client_type == 4 && $this->userhelper->current('role_id') == 1)  { 
                    ?>
                    <option value="4"selected="">Flexible Rate</option>
                  <?php } ?>

                    <?php 
                    /*
                      if ($client_type == 1) { 
                    ?>
                        <option value="1" selected="">Cash</option>
                    <?php 
                      } else {
                    ?>
                        <option value="1">Cash</option>
                    <?php 
                      }

                      if ($client_type == 2) { 
                    ?>
                        <option value="2" selected="">Credit</option>
                    <?php 
                      } else { 
                    ?>
                        <option value="2">Credit</option>
                    <?php
                      }

                      if ($client_type == 3) { 
                    ?>
                        <option value="3"selected="">Walkin</option>
                    <?php 
                      } else { 
                    ?>
                        <option value="3">Walkin</option>
                    <?php 
                      } 
                    
                      if ($client_type == 4 && $this->userhelper->current('role_id') == 1)  { 
                    ?>
                        <option value="4"selected="">Flexible Rate</option>
                    <?php 
                      } else { 
                    ?>
                        <option value="4">Flexible Rate</option>
                    <?php 
                      } 
                    */ ?>
                  </select>
                  <span class="text-danger" id="clientType"></span>
                </div>
              </div>

              <div class="box-footer">
                <input type="submit" id="submit1" name="submit" class="btn btn-primary" value="Submit">
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
//New Validation
$(document).ready(function (){                  

jQuery.validator.addMethod("noSpace", function(value, element){
  return value == '' || value.trim().length != 0;  
}, "No space please and don't leave it empty");

    var id = $('input[name = "id"]').val();
    var action = $('input[name = "action"]').val();
    $('#demo-form2').validate({
      errorClass:"text-danger",
      rules:{
              company_name:{
              required: true,
            },
            contact_person_name  :{
              required: true,
            },
            email :{
              required : true,
              email: true
            },
            phone_no:{
              required : true,
              number: true,
             // minlength: 7,
             // maxlength: 13,
            },
            vat_number:{
              required : true,
            },
            client_type :{
              required : true,
            }
        },
        messages: {
          company_name: {
            required: "Please Enter Company Name",
          },
          contact_person_name: {
            required: "Please Enter Contact Person Name",
          },
          email: {
            required: "Please Enter Email Address",
          },
          phone_no:{
            required: "Please Enter Phone Number",
          },
          vat_number:{
            required: "Please Enter Vat Number",
          },
          client_type:{
            required: "Please Select Client Type",
          }
        },
        submitHandler: function(form){
          form.submit();
        }
  });
});
// OLd Validation
/*$(document).on('click','#submit1',function(){
  
  var selectedoption = $("#client_type option:selected").val();
  if(selectedoption){
    $('#clientType').text('').hide();
    return true;
  }else{
    event.preventDefault();
    $('#clientType').text('Please select one Client type.').show();
    return false;
  }
});*/
  
</script>