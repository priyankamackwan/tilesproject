<?php
	$this->load->view('include/header');
  $this->load->view('include/leftsidemenu');
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
<?php
/*
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
*/
?>
        <!-- /page content -->
<!-- -------------------------------new design------------------------------- -->
<style type="text/css">
    .select2{
      width: 100% !important;
    }
  </style>
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
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Item Name :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->name;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="design_no">
                Design No :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->design_no;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="cash_rate">
                  Cash Rate :
                </label>
                
                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $this->My_model->getamount(ROUND($result[0]->cash_rate,2));?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="credit_rate">
                  Credit Rate :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $this->My_model->getamount(ROUND($result[0]->credit_rate,2));?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="walkin_rate">
                  Walkin Rate :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $this->My_model->getamount(ROUND($result[0]->walkin_rate,2));?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="walkin_rate">
                  Flexible Rate :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $this->My_model->getamount(ROUND($result[0]->flexible_rate,2));?>
                </div>
              </div>
              <?php 
              //not show to subadmin
              /*
              if($this->userhelper->current('role_id')==1){
              ?>  
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="purchase_expense">
                  Purchase Price :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $this->My_model->getamount(ROUND($result[0]->purchase_expense,2));?>
                </div>
              </div>
              <?php
                }
                */
              ?>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Size:
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->size;?>
                </div>
              </div>
              <div class="form-group uploadedImage">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_image">
                  Item Image :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 ">
                  <?php
										if (!empty($result[0]->image) && file_exists(FCPATH.'assets/uploads/'.$result[0]->image)) {
											$image = base_url().'./assets/uploads/'.$result[0]->image;
										}else{
											$image =  base_url().'./assets/default.png';
										}
									?>
                  
                  <img width="140px" height="140px" src="<?php echo $image;?>" style="background-color:navy;" >
                </div>
					    </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Quantity :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->quantity;?>
                </div>
              </div>

              <?php /*
                if ($this->userhelper->current('role_id') ==1) { 
              ?>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-6 col-xs-6" for="purchase_expense">
                      Purchase Price :
                    </label>

                    <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                      <?php echo ROUND($result[0]->purchase_expense,2);?>
                    </div>
                  </div>
              <?php 
                } */
              ?>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="latitude">
                  Item Group :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6">
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
              <div class="form-group">
                      <label class="control-label col-md-3 col-sm-12 col-xs-12" for="order_payment_status">
                        Item History Details :
                      </label>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <table border ="1" width="100%" class="table main-table  table-bordered table-hover  table-striped  dataTable no-footer" id="datatables1">
                      <thead>
                            <tr class="">
                              <th style="text-align: center">Sr No.</th>
                              <th style="text-align: center">Item Name</th>
                              <th style="text-align: center">Purchase Price</th>
                              <th style="text-align: center">Quantity</th>
                              <th style="text-align: center">Created On</th>
                            </tr>
                        </thead>
                    <?php
                    if(isset($purchase_history) && $purchase_history!='' && count($purchase_history) >0){
                    ?>
                        <tbody>
                          <?php
                          $purchaseAvg=$totalQuantity=0;
                          foreach ($purchase_history as $key => $purchaseHistoryVal) {
                            $purchaseAvg +=$purchaseHistoryVal['purchase_rate'];
                            $totalQuantity += $purchaseHistoryVal['quantity'];
                            $delete = base_url($this->controller.'/removePayment/'.$this->utility->encode($purchaseHistoryVal['id']));
                          ?>
                            <tr>
                              <td style="text-align: center" >
                                <?php echo $key+1;?>
                              </td>
                              <td style="text-align: center" >
                                <?php echo $result[0]->name;?>
                              </td>
                              <td class="text-right">
                                <?php
                                if(isset($purchaseHistoryVal['purchase_rate']) && $purchaseHistoryVal['purchase_rate']!=''){
                                  echo $purchaseHistoryVal['purchase_rate'];
                                }
                                ?>
                              </td>
                              <td class="text-right">
                                <?php
                                if(isset($purchaseHistoryVal['quantity']) && $purchaseHistoryVal['quantity']!=''){
                                  echo $purchaseHistoryVal['quantity'];
                                }
                                ?>
                              </td>
                              <td style="text-align: center;">
                                <?php
                                if(isset($purchaseHistoryVal['created_at']) && $purchaseHistoryVal['created_at']!=''){
                                  echo date('d/m/Y',strtotime($payment_history_val['created_at']));
                                }
                                ?>
                              </td>
                          </tr>
                          <?php
                          }                           
                          ?> 
                        </tbody>
                        <tbody>
                          <td></td>
                          <td><b>Total</b></td>
                          <td><b>Avg Purchase Price</b> : <b class="text-right"><?php echo $purchaseAvg/count($purchase_history); ?></b></td>
                          <td class="text-right"><?php echo $totalQuantity; ?></td>
                          <td></td>
                        </tbody>
                    <?php
                  }
                    ?>
                    </table>
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