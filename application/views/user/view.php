<?php
//echo '<pre>';
//print_r($result[0]); exit;
	$this->load->view('include/header');
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);
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
            </div>
        <!-- /page content -->
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
