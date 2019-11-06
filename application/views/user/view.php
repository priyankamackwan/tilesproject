<?php
//echo '<pre>';
//print_r($result[0]); exit;
  $this->load->view('include/header');
  $this->load->view('include/leftsidemenu');
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);
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
                <div class="x_content">
                    <br />
                    <form action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="first_name">Company Name
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->company_name;?>
                        </div>
                      </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="last_name">Company Address
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->company_address;?>
                        </div>
                      </div>
                         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="last_name">Contact Person Name
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->contact_person_name;?>
                        </div>
                      </div>
                  
                                         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="email">Email
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->email;?>
                        </div>
                      </div>
                         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="phone_no">Phone
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->phone_no;?>
                        </div>
                      </div>
                        <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Mobile">Vat Number
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <?php echo $result[0]->vat_number;?>
                        </div>
                        </div>
                        <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Mobile">Client Type
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php if ($result[0]->client_type == 1) { ?>
                                Cash
                         <?php }  ?>
                        <?php if ($result[0]->client_type == 2) { ?>
                                Credit
                         <?php } ?>
                                
                        <?php if ($result[0]->client_type == 3) { ?>
                               Walkin
                        <?php } ?>
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
<!-- -------------------------------new design------------------------------- -->
<!-- Main Container start-->
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
            <h3 class="box-title"><?php echo $this->msgName;?></h3>
          </div>

          <div class="box-body">
            <form action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="first_name">
                  Company Name :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12 mt_5">
                  <?php echo $result[0]->company_name;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="last_name">
                  Company Address :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12 mt_5">
                  <?php echo $result[0]->company_address;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="last_name">
                  Contact Person Name :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12 mt_5">
                  <?php echo $result[0]->contact_person_name;?>
                </div>
              </div>
                  
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="email">
                  Email :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12 mt_5">
                  <?php echo $result[0]->email;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="phone_no">
                  Phone :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12 mt_5">
                  <?php echo $result[0]->phone_no;?>
                </div>
              </div>

              <div class="form-group">
						    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="Mobile">
                  Vat Number :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12 mt_5">
                  <?php echo $result[0]->vat_number;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="Mobile">
                  Created On  :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12 mt_5">
                  <?php echo date('d/m/Y H:i:s',strtotime($result[0]->created));?>
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="Mobile">
                  Last Activity On :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12 mt_5">
                  <?php if(trim($result[0]->last_activity)=='0000-00-00 00:00:00') // if date is not set
                          {
                            echo '00/00/0000 00:00:00';
                          } 
                        else 
                          {
                             echo date('d/m/Y H:i:s',strtotime($result[0]->last_activity));
                          } 
                  ?>
                </div>
              </div>

              <div class="form-group">
						    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="Mobile">
                  Client Type :
                </label>
                <div class="col-md-9 col-sm-12 col-xs-12 mt_5">
                  <?php
                    if ($result[0]->client_type == 1) { 
                  ?>
                      Cash
                  <?php
                    } 
                  ?>
                  <?php 
                    if ($result[0]->client_type == 2) { 
                  ?>
                      Credit
                  <?php 
                    } 
                  ?>  
                  <?php 
                    if ($result[0]->client_type == 3) { 
                  ?>
                      Walkin
                  <?php
                    } 
                  ?>
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
		$(document).ready(function (){
			var id = $('input[name = "id"]').val();
			var action = $('input[name = "action"]').val();
			$('#demo-form2').validate({
				rules:{
						mobile_no: "required",
						number:{
							required: true,
							minlength: 10,
							maxlength: 10,
							remote:{
								url:"<?php echo base_url().$controller."/checknumber";?>",
								type:"post",
								data:{
									id:id,
									action: action,
									number: function(){
										return $('input[name = "number"]').val();
									},
								},
							}
						}
					
					},
					messages: {
						username: "Please Enter Name",
						number: {
							required: "Please Enter Mobile Number",
							minlength: "Please Minimun enter 10 Charecter",
							maxlength: "Please Maximun enter 10 Charecter",
							remote: "Contact Number Exist"
						}
						
					},
					submitHandler: function(form){
						form.submit();
					}
		});
	});
	</script>
