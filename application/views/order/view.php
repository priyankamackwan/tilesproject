<?php
//echo '<pre>';
//print_r($productData); exit;
  $this->load->view('include/leftsidemenu');
	$this->load->view('include/header');
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
                    <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/Update'?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
	<input type="hidden" id="id" name="id" value="<?php echo $result[0]->id;?>">
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Order Detail
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                      
                            <table border ="1" width="100%"><tr><th style="text-align: center">Product Name</th><th style="text-align: center">Design No</th><th style="text-align: center">Quantity</th><th style="text-align: center">Price</th></tr>
                                
                         
   <?php 
   for($p=0;$p<count($productData);$p++) { ?>
                                <tr><td style="text-align: center"><?php echo $productData[$p]['name'];?></td><td style="text-align: center"><?php echo $productData[$p]['design_no'];?></td><td style="text-align: center"><?php echo $productData[$p]['quantity'];?></td><td style="text-align: center"><?php echo $productData[$p]['price'];?></td></tr>
                                
                            <?php } ?>
                            
                            </table>
                        </div>
                      </div>
                        	  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">User Name
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $User[0]['company_name'];?>
                        </div>
                      </div>
    
       
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Tax
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->tax;?>
                        </div>
                      </div>
         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Total Price
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->total_price;?>
                        </div>
                      </div>
         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">LPO No
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->lpo_no;?>
                        </div>
                      </div>
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Do No
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->do_no;?>
                        </div>
                      </div>
        
         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Invoice No
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->invoice_no;?>
                        </div>
                      </div>
        
         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Cargo
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->cargo;?>
                        </div>
                      </div>
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Cargo Number
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->cargo_number;?>
                        </div>
                      </div>
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Location
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->location;?>
                        </div>
                      </div>
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Mark
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->mark;?>
                        </div>
                      </div>
                        
                          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="sales_expense">Sales Expense
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="sales_expense" value="<?php echo $result[0]->sales_expense;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Sales Expense">
                        </div>
                      </div>
        
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="order_status">Order Status
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status">
                                <?php 
                                
                                if ($result[0]->status == 0) { ?>
                                <option value="0" selected="selected">Pending</option>
                                <?php } else { ?>
                                <option value="0">Pending</option>
                                <?php } ?>
                                  <?php if ($result[0]->status == 1) { ?>
                                <option value="1" selected="selected">In Progress</option>
                               <?php } else { ?>
                                <option value="1">In Progress</option>
                                <?php } ?>
                                  <?php if ($result[0]->status == 2) { ?>
                                <option value="2" selected="selected">Completed</option>
                                <?php } else { ?>
                               <option value="2">Completed</option>
                                <?php } ?>
                                
                                
                            </select>
                        </div>
                      </div>
        
        
                <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="order_payment_status">Order Payment Status
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="invoice_status">
                                <?php 
                                
                                if ($result[0]->invoice_status == 0) { ?>
                                <option value="0" selected="selected">Unpaid</option>
                                <?php } else { ?>
                                <option value="0">Unpaid</option>
                                <?php } ?>
                                  <?php if ($result[0]->invoice_status == 1) { ?>
                                <option value="1" selected="selected">Paid</option>
                               <?php } else { ?>
                                <option value="1">Paid</option>
                                <?php } ?>
                             
                                
                                
                            </select>
                        </div>
                      </div>
                        		  <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Submit</button>
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

            <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/Update'?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                
	            <input type="hidden" id="id" name="id" value="<?php echo $result[0]->id;?>">
					  
					    <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Order Detail :
                </label>
                
                <div class="col-md-9 col-sm-12 col-xs-12">
                  <table border ="1" width="100%">
                    <tr>
                      <th style="text-align: center">Product Name</th>
                      <th style="text-align: center">Design No</th>
                      <th style="text-align: center">Quantity</th>
                      <th style="text-align: center">Price</th>
                    </tr>      
                         
                      <?php 
                        for($p=0;$p<count($productData);$p++) { 
                      ?>
                          <tr>
                            <td style="text-align: center"><?php echo $productData[$p]['name'];?></td>
                            <td style="text-align: center"><?php echo $productData[$p]['design_no'];?></td>
                            <td style="text-align: center"><?php echo $productData[$p]['quantity'];?></td>
                            <td style="text-align: center"><?php echo round($productData[$p]['price'],2);?></td>
                          </tr>
                                                  
                      <?php 
                        } 
                      ?>                    
                  </table>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  User Name :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $User[0]['company_name'];?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Tax :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo round($result[0]->tax,2);?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Total Price :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo round($result[0]->total_price,2);?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  LPO No :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->lpo_no;?>
                </div>
              </div>
              

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Customer LPO No :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $customer_lpo[0]['customer_lpo'];?>
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Do No :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->do_no;?>
                </div>
              </div>
        
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Invoice No :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->invoice_no;?>
                </div>
              </div>
        
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Cargo :
                </label>
              
                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->cargo;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Cargo Number :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->cargo_number;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Location :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->location;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                  Mark :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->mark;?>
                </div>
              </div>
                        
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="sales_expense">
                  Sales Expense :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <input type="text" name="sales_expense" value="<?php echo $result[0]->sales_expense;?>" class="form-control" placeholder="Enter Sales Expense">
                </div>
              </div>
        
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="order_status">
                  Order Status :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <select name="status" class="form-control select2" style="width: 100%;">
                    <?php 
                      if ($result[0]->status == 0) { 
                    ?>
                        <option value="0" selected="selected">Pending</option>
                    <?php 
                      } else { 
                    ?>
                        <option value="0">Pending</option>
                    <?php 
                      }

                      if ($result[0]->status == 1) { 
                    ?>
                        <option value="1" selected="selected">In Progress</option>
                    <?php 
                      } else { 
                    ?>
                        <option value="1">In Progress</option>
                    <?php 
                      } 

                      if ($result[0]->status == 2) { 
                    ?>
                        <option value="2" selected="selected">Completed</option>
                    <?php 
                      } else { 
                    ?>
                        <option value="2">Completed</option>
                    <?php
                      } 
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="order_payment_status">
                  Order Payment Status :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <select name="invoice_status" style="width: 100%;" class="form-control select2">
                    <?php
                      if ($result[0]->invoice_status == 0) { 
                    ?>
                        <option value="0" selected="selected">Unpaid</option>
                    <?php 
                      } else { 
                    ?>
                        <option value="0">Unpaid</option>
                    <?php 
                      } 

                      if ($result[0]->invoice_status == 1) { 
                    ?>
                        <option value="1" selected="selected">Paid</option>
                    <?php
                      } else { 
                    ?>
                        <option value="1">Paid</option>
                    <?php 
                      } 
                    ?> 
                  </select>
                </div>
              </div>
              <div class="box-footer">
                <input type="submit" class="btn btn-primary" value="Submit">
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
