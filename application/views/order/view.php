<?php
/*echo '<pre>';
print_r($result); exit;*/
  $this->load->view('include/header');
  $this->load->view('include/leftsidemenu');
  defined('BASEPATH') OR exit('No direct script access allowed');
  error_reporting(0);

?>

<style type="text/css">
  /*table, th, td
  {
    border: 2px solid grey;
  }

  th 
  {
    background-color: #3c8dbc ;
    color: #fff;
  }*/
</style>
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
*/
?>
        <!-- Main Container start-->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="row">
      <div class="col-md-9 col-sm-12 col-xs-12">
        <a href="<?php echo base_url($this->controller);?>"class="btn btn-danger">Back to list</a> 
        <span style="float:right;">
        <button class="btn btn-info" id="back" value="<?php echo $result[0]->id;?>">Back</button>
        <button class="btn btn-info" id="next" value="<?php echo $result[0]->id;?>">Next</button>
        </span> 
      </div>
    </div>
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

            <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/Update'?>" method="post" id="demo-form2" onsubmit="return formvalidate();" data-parsley-validate class="form-horizontal form-label-left">
                                
              <input type="hidden" id="id" name="id" value="<?php echo $result[0]->id;?>">
            
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Order Detail :
                </label>
                
                <div class="col-md-9 col-sm-12 col-xs-12">
                  <table border ="1" width="100%">
                    <tr>
                      <th style="text-align: center">Item Name</th>
                      <th style="text-align: center">Design No</th>
                      <th style="text-align: center">Quantity</th>
                      <th style="text-align: center">Rate</th>
                      <th style="text-align: center">Price</th>
                    </tr>      
                         
                      <?php 
                        for($p=0;$p<count($productData);$p++) { 
                      ?>
                          <tr>
                            <td style="text-align: center"><?php echo $productData[$p]['name'];?></td>
                            <td style="text-align: center"><?php echo $productData[$p]['design_no'];?></td>
                            <td style="text-align: center"><?php echo $productData[$p]['quantity'];?></td>
                            <td style="text-align: center"><?php echo $productData[$p]['rate'];?></td>
                            <td style="text-align: center"><?php echo $this->My_model->getamount(round($productData[$p]['price'],2));?></td>
                          </tr>
                                                  
                      <?php 
                        } 
                      ?>                    
                  </table>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  User Name :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $User[0]['company_name'];?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Tax :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $this->My_model->getamount(round($result[0]->tax,2));?>
                  <?php echo "  ( ".$result[0]->tax_percentage. " % )"; ?> <!-- display tax in percentage -->
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Total Price :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $this->My_model->getamount(round($result[0]->total_price,2));?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Grand Total :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $this->My_model->getamount(round($result[0]->total_price+ $result[0]->tax,2));?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  LPO No :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->lpo_no;?>
                </div>
              </div>
              
              <!-- if customer lpo no is added then display it -->
              <?php if($customer_lpo[0]['customer_lpo']!="") {  ?>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Customer LPO No :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $customer_lpo[0]['customer_lpo'];?>
                </div>
              </div>
              
            <?php } ?>


              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Do No :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->do_no;?>
                </div>
              </div>
        
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Invoice No :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->invoice_no;?>
                </div>
              </div>
        
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Cargo :
                </label>
              
                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->cargo;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Cargo Number :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->cargo_number;?>
                </div>
              </div>
              <!-- Add new feild  Legacy Invoice Number-->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Legacy Invoice Number :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->legacy_invoice_no;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Location :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->location;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Mark :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->mark;?>
                </div>
              </div>
                        
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="sales_expense">
                  Sales Expense :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php echo $result[0]->sales_expense;?>
                </div>
              </div>    
              <div class="form-group" id="id_payment_date"> <!-- if payment status is completed then display the date div -->
                <label class="control-label col-md-3 col-sm-6 col-xs-6 " for="payment_date">
                  Created On :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <div class='input-group date' id='payment_datetimepicker'>
                      <?php 
                      echo $this->My_model->date_conversion($result[0]->created,'d/m/Y H:i:s',' ');
                      ?>
                  </div>
                </div>
              </div>    
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="order_status">
                  Delivery Status :
                </label>
                    <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                    <?php 
                      if ($result[0]->status == 0) {
                      echo  'Pending';
                      }elseif($result[0]->status == 1) { 
                          echo 'In Progress'; 
                      }elseif($result[0]->status == 2) { 
                          echo 'Completed'; 
                      }
                    ?>
                </div>
              </div>
              <?php if(isset($result[0]->delivery_date) && $result[0]->delivery_date!='' && $result[0]->status == 2) { ?>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="order_status">
                  Delivery Date :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                    <?php 
                    /*echo $this->My_model->date_conversion($result[0]->delivery_date,'d/m/Y h:i A',' ');*/
                    echo $this->My_model->date_conversion($result[0]->delivery_date,'d/m/Y H:i:s',' ');
                    ?>
                </div>
              </div>
                <?php 
                  } 
                  ?>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="order_payment_status">
                  Payment Status :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                    <?php
                      if ($result[0]->invoice_status == 0) { 
                        echo 'Pending';
                      }elseif ($result[0]->invoice_status == 1) { 
                        echo 'Paid';
                      }elseif ($result[0]->invoice_status == 2) { 
                        echo 'Partial Paid';
                      }
                    ?>
                </div>
              </div>
              <?php if(isset($result[0]->payment_date) && $result[0]->payment_date!='' && $result[0]->invoice_status == 1) { ?>
              <div class="form-group" id="id_payment_date"> <!-- if payment status is completed then display the date div -->
                <label class="control-label col-md-3 col-sm-6 col-xs-6 " for="payment_date">
                  Payment Date :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <div class='input-group date' id='payment_datetimepicker'>
                      <?php 
                      echo $this->My_model->date_conversion($result[0]->payment_date,'d/m/Y H:i:s',' ');
                      //echo date('d/m/Y h:i A',strtotime($result[0]->payment_date));
                      ?>
                  </div>
                </div>
              </div>
              <?php
                }   
              ?>
              <?php
                    if(isset($payment_history) && $payment_history!='' && count($payment_history) >0){
                    ?>
               <div class="form-group">
                      <label class="control-label col-md-3 col-sm-12 col-xs-12" for="order_payment_status">
                        Payment Details :
                      </label>
                    </div>     
              <table border ="1" width="100%" class="table main-table  table-bordered table-hover  table-striped  dataTable no-footer" id="datatables1">
                      <thead>
                            <tr class="">
                              <th style="text-align: center">Date</th>
                              <th style="text-align: center">Payment Mode</th>
                              <th style="text-align: center">Reference Id</th>
                              <th style="text-align: center">Amount</th>
                              <!-- <th style="text-align: center">Action</th> -->
                            </tr>
                        </thead>
                    <?php
                    if(isset($payment_history) && $payment_history!='' && count($payment_history) >0){
                      // if(isset($result[0]->tax) && $result[0]->tax!='' ){
                      //   $orderTax=$result[0]->total_price * $result[0]->tax /100; 
                      // }else{
                      //   $orderTax=$result[0]->total_price * Vat /100; 
                      // }
                      //tax amount
                      $orderTax=$result[0]->tax;
                    ?>
                      
                        
                        <tbody>
                          <?php
                          
                          foreach ($payment_history as $key => $payment_history_val) {
                            $totalPaidAmount +=$payment_history_val['amount'];
                            $delete = base_url($this->controller.'/removePayment/'.$this->utility->encode($payment_history_val['id']));
                          ?>
                            <tr>
                              <td style="text-align: center" >
                                <?php
                                if(isset($payment_history_val['payment_date']) && $payment_history_val['payment_date']!=''){
                                  echo date('d/m/Y',strtotime($payment_history_val['payment_date']));
                                }
                                ?>
                              </td>
                              <td>
                                <?php
                                if(isset($payment_history_val['payment_mode']) && $payment_history_val['payment_mode']!=''){
                                  echo $payment_history_val['payment_mode'];
                                }
                                ?>
                              </td>
                              <td>
                                <?php
                                if(isset($payment_history_val['reference']) && $payment_history_val['reference']!=''){
                                  echo $payment_history_val['reference'];
                                }
                                ?>
                              </td>
                              <td style="text-align: right;">
                                <?php
                                if(isset($payment_history_val['amount']) && $payment_history_val['amount']!=''){
                                  echo $this->My_model->getamount(round($payment_history_val['amount'],2));
                                }
                                ?>
                              </td>
                              <?php
                              /*
                              <td style="text-align: center;">
                                <a onclick="edit_payment(<?php echo $id;?>,<?php echo $payment_history_val['id'];?>)" class="btn  btn-primary  btn-sm" style="padding: 8px;margin-top:1px;" data-toggle="tooltip" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;<a onclick="delete_payment(<?php echo $id;?>,<?php echo $payment_history_val['id'];?>);" class="btn btn-danger btn-sm" style="padding: 9px;margin-top:1px;" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                              </td>
                              */
                              ?>
                          </tr>
                          <?php
                          }
                          ?> 
                        </tbody>
                        <tbody style="border-top: 2px solid black;">
                          <tr style="border: 1px solid black;">
                            <td></td>
                            <td></td>
                            <th>Total</th>
                            <td style="text-align: right;"><?php echo $this->My_model->getamount(round($totalPaidAmount,2));?></td>
                            <!-- <td></td> -->
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <th>Balance</th>
                            <td style="text-align: right;">
                              <?php                             
                              echo $this->My_model->getamount(round($result[0]->total_price + $orderTax-$totalPaidAmount,2));
                              ?>
                            </td>
                            <!-- <td></td> -->
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <th>Total Invoice Amount</th>
                            <td style="text-align: right;">
                              <?php                             
                              echo $this->My_model->getamount(round($result[0]->total_price + $orderTax,2));
                              ?>
                            </td>
                            <!-- <td></td> -->
                          </tr>
                        </tbody>
                      
                    <?php
                  }else{
                    echo '<tbody>

              <tr class="odd"><td valign="top" colspan="9" class="dataTables_empty">No data available in table</td></tr></tbody>';
                  }
                    ?>
                    </table>

<?php
                          }
                          ?> 
              <!-- <div class="box-footer">
                <input type="submit" class="btn btn-primary" value="Submit">
              </div> -->
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
</style>
<script type="text/javascript">
  $("#next").click(function(){
    var id = $(this).val();
    $.ajax({
      type : "POST",
      url : "<?php echo base_url().$this->controller."/next/" ?>",
      data : {id:id},
      dataType: "json",
      success : function (data){
        var id =  data;
        window.location.href = id;
      }
    });  
  });
   $("#next").click(function(e){
    e.preventDefault();
    var id = $(this).val();
    $.ajax({
      type : "POST",
      url : "<?php echo base_url().$this->controller."/next/" ?>",
      data : {id:id},
      dataType: "json",
      success : function (data){
        $("#next").attr("disabled","true");
      }
    }); 
  }); 
  $("#back").click(function(){
    var id = $(this).val();
    $.ajax({
      type : "POST",
      url : "<?php echo base_url().$this->controller."/previous/" ?>",
      data : {id:id},
      dataType: "json",
      success : function (data){
        var id =  data.url;
        if(data.status=="success") {
          $("#next").prop('disabled',false);
          window.location.href = id;
        }
        if(data.status="fail"){
          $("#next").attr('disabled','disabled');
          $("#back").removeAttr('disabled');
        }
      }
    });  
  });
</script>