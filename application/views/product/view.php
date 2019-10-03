<?php
  $this->load->view('include/leftsidemenu');
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
                    <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
	
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Product Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->name;?>
                        </div>
                      </div>
                        		  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="design_no">Design No<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->design_no;?>
                        </div>
                      </div>
                        		  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="cash_rate">Cash Rate<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->cash_rate;?>
                        </div>
                      </div>
                        		  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="credit_rate">Credit Rate<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->credit_rate;?>
                        </div>
                      </div>
                        		  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="walkin_rate">Walkin Rate<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->walkin_rate;?>
                        </div>
                      </div>
                        		  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="purchase_expense">Purchase Price<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->purchase_expense;?>
                        </div>
                      </div>
                         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Size
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->size;?>
                        </div>
                      </div>
                         <div class="form-group uploadedImage">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_image">Uploaded Image
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<img width="150px" height="150px" src="<?php echo base_url().'./assets/uploads/'.$result[0]->image;?>" style="background-color:navy;" >
						</div>
					  </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Quantity<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->quantity;?>
                        </div>
                      </div>
                       <?php if ($this->userhelper->current('role_id') ==1) { ?>
                         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="purchase_expense">Purchase Price<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->purchase_expense;?>
                        </div>
                      </div>
                       <?php } ?>
                              <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="latitude">Categories<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="js-example-basic-multiple" name="categories[]" multiple="multiple" id="category" disabled="">
                              <?php for($i=0;$i<count($categories);$i++) { 
                              if (in_array($categories[$i]['id'], $choosen_categories)) { ?>
                              <option value="<?php echo $categories[$i]['id'];?>" selected=""><?php echo $categories[$i]['name'];?></option>
                              <?php } else { ?>
                               <option value="<?php echo $categories[$i]['id'];?>"><?php echo $categories[$i]['name'];?></option>
                              <?php } }?>
</select>
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
						<h3 class="box-title"><?php echo $btn.' '.$this->msgName;?></h3>
					</div>

					<div class="box-body">
            <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Product Name :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->name;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="design_no">
                Design No :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->design_no;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="cash_rate">
                  Cash Rate :
                </label>
                
                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->cash_rate;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="credit_rate">
                  Credit Rate :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->credit_rate;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="walkin_rate">
                  Walkin Rate :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->walkin_rate;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="purchase_expense">
                  Purchase Price :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->purchase_expense;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Size:
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->size;?>
                </div>
              </div>
              <div class="form-group uploadedImage">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_image">
                  Uploaded Image :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <img width="150px" height="150px" src="<?php echo base_url().'./assets/uploads/'.$result[0]->image;?>" style="background-color:navy;" >
                </div>
					    </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Quantity :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->quantity;?>
                </div>
              </div>

              <?php 
                if ($this->userhelper->current('role_id') ==1) { 
              ?>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="purchase_expense">
                      Purchase Price :
                    </label>

                    <div class="col-md-9 col-sm-12 col-xs-12">
                      <?php echo $result[0]->purchase_expense;?>
                    </div>
                  </div>
              <?php 
                } 
              ?>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="latitude">
                  Categories :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <select class="form-control select2" name="categories[]" multiple="multiple" id="category" disabled="" width="100%">

                    <?php 
                      for($i=0;$i<count($categories);$i++) { 
                        if (in_array($categories[$i]['id'], $choosen_categories)) { 
                    ?>
                          <option value="<?php echo $categories[$i]['id'];?>" selected=""><?php echo $categories[$i]['name'];?></option>
                    <?php 
                        } else { 
                    ?>
                          <option value="<?php echo $categories[$i]['id'];?>"><?php echo $categories[$i]['name'];?></option>
                    <?php 
                        } 
                      }
                    ?>
                  </select>
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
						name:{
							required: true,
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
						}
					
					},
					messages: {
						name: {
							required: "Please Enter Category",
							remote: "Category Name Exist"
						}
						
					},
					submitHandler: function(form){
						form.submit();
					}
		});
	});
	</script>