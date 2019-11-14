<?php
//echo '<pre>';
//print_r($result[0]); exit;
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
       // echo '<pre>';
       // print_r($choosen_categories); exit;
?>
<?php
	if($action == 'insert')
	{
		$btn = "Save";
    $title_name='Add';
	}
	else if($action == 'update')
	{
		$title_name=$btn = "Update";
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
                             
                                 <?php if($result[0]->unit == 4) { ?>
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
                            <input type="text" name="quantity_per_unit" id="quantity_per" readonly="" value="<?php echo $result[0]->quantity_per_unit;?>" class="form-control col-md-7 col-xs-12" placeholder="Quantity Per">
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
                      </div> -->
        <!-- ----------------------------------------------------            -->
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

                                        

					  <!-- <div class="ln_solid"></div>
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
            </div> -->
        <!-- /page content -->

        <!-- -------------------------------new design------------------------------- -->
<!-- Main Container start-->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
  <a href="<?php echo base_url($this->controller);?>"class="btn btn-info">Back</a>

  <?php
    echo $this->session->flashdata('edit_profile');
    echo $this->session->flashdata('Change_msg');
    echo $this->session->flashdata($this->msgDisplay);
  ?>
  <style type="text/css">
    .select2{
      width: 100% !important;
    }
  </style>
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
              <h3 class="box-title"><?php echo $title_name.' '.$this->msgName;?></h3>
            </div>

            <div class="box-body">
              <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                <input type="hidden" id="id" name="id" value="<?php echo $result[0]->id;?>">
                <input type="hidden" id="action" name="action" value="<?php echo $action?>">
                <input type="hidden" id="action" name="old_image" value="<?php echo $result[0]->image;?>">

					      <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
                    Item Name<font color="red"><span class="required">*</span></font> :
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <input type="text" name="name" value="<?php echo $result[0]->name;?>" class="form-control" placeholder="Enter Item Name">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="design_no">
                    Design No<font color="red"><span class="required">*</span></font> :
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <input type="text" name="design_no" value="<?php echo $result[0]->design_no;?>" class="form-control" placeholder="Enter Design No">
                  </div>
                </div>
                                     
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="cash_rate">
                    Cash Rate<font color="red"><span class="required">*</span></font> :
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <?php 
                      if ($this->userhelper->current('role_id') == 1) { 
                    ?>
                        <input type="text" name="cash_rate" value="<?php echo ROUND($result[0]->cash_rate,2);?>" class="form-control" placeholder="Enter Cash Rate">
                    <?php 
                      } else { 
                    ?>
                        <input type="text" name="cash_rate" value="<?php echo ROUND($result[0]->cash_rate,2);?>" readonly="" class="form-control" placeholder="Enter Cash Rate">
                    <?php 
                      } 
                    ?>
                  </div>
                </div>
                                    
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="credit_rate">
                    Credit Rate<font color="red"><span class="required">*</span></font> :
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <?php 
                      if ($this->userhelper->current('role_id') == 1) { 
                    ?>
                        <input type="text" name="credit_rate" value="<?php echo ROUND($result[0]->credit_rate,2);?>" class="form-control" placeholder="Enter Credit Rate">
                    <?php 
                      } else { 
                    ?>
                        <input type="text" name="credit_rate" value="<?php echo ROUND($result[0]->credit_rate,2);?>" readonly="" class="form-control" placeholder="Enter Credit Rate">
                    <?php 
                      } 
                    ?>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="walkin_rate">
                    Walkin Rate<font color="red"><span class="required">*</span></font> :
                  </label>
                
                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <?php 
                      if ($this->userhelper->current('role_id') == 1) { 
                    ?>
                        <input type="text" name="walkin_rate" value="<?php echo ROUND($result[0]->walkin_rate,2);?>" class="form-control" placeholder="Enter Walkin Rate">
                    <?php
                      } else { 
                    ?>
                        <input type="text" name="walkin_rate" value="<?php echo ROUND($result[0]->walkin_rate,2);?>" readonly="" class="form-control" placeholder="Enter Walkin Rate">
                    <?php
                      } 
                    ?>
                  </div>
                </div>
                                
          	    <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="flexible_rate">
                    Flexible Rate<font color="red"><span class="required">*</span></font> :
                  </label>

                    <div class="col-md-9 col-sm-12 col-xs-12">
                      <?php
                        if ($this->userhelper->current('role_id') == 1) { 
                      ?>
                          <input type="text" name="flexible_rate" value="<?php echo ROUND($result[0]->flexible_rate,2);?>" class="form-control" placeholder="Enter Flexible Rate">
                      <?php
                        } else { 
                      ?>
                          <input type="text" name="flexible_rate" value="<?php echo ROUND($result[0]->flexible_rate,2);?>" readonly="" class="form-control" placeholder="Enter Flexible Rate">
                      <?php 
                        } 
                      ?>
                    </div>
                </div>   
                           
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="Size">
                    Size :
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <input type="text" name="size" value="<?php echo $result[0]->size;?>" class="form-control" placeholder="Enter Size">
                  </div>
                </div>

                <?php 
                  if($action == "insert") { 
                ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_image">
                        Item Image<font color="red"><span class="required">*</span></font> :
                      </label>

                      <div class="col-md-9 col-sm-12 col-xs-12">
                        <input type="file" name="image" class="form-control numberonl" onchange="readURL(this);">
						            <div><img  id="blah"></div>
                      </div>
                    </div>
                <?php 
                  } 
                ?>
                <?php 
                  if($action == "update") { 
                ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_image">
                        Item Image<font color="red"><span class="required">*</span></font> :
                      </label>

                      <div class="col-md-9 col-sm-12 col-xs-12">
                        <input type="file" name="updated_image" class="form-control numberonly" onchange="readURL(this);">
                        <div><img  id="blah"></div>
                      </div>
                    </div>

                    <div class="form-group uploadedImage">
                      <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_image">
                        Uploaded Image
                      </label>

                      <div class="col-md-9 col-sm-12 col-xs-12">
                        <?php
                          if (!empty($result[0]->image) && file_exists(FCPATH.'assets/uploads/'.$result[0]->image)) {
                            $image = base_url().'./assets/uploads/'.$result[0]->image;
                          }else{
                            $image =  base_url().'./assets/default.png';
                          }
                        ?>
                        <img width="150px" height="150px" src="<?php echo $image;?>" style="background-color:navy;" >
                      </div>
                    </div>
                <?php 
                  }
                ?>
                                       
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="Quantity">
                    Quantity<font color="red"><span class="required">*</span></font> :
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <input type="text" name="quantity" id="quantity" value="<?php echo $result[0]->quantity;?>" class="form-control" placeholder="Enter Quantity">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="Factor">
                    Factor<font color="red"><span class="required">*</span></font> :
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                      <input type="text" name="factor" id="factor" value="<?php echo $result[0]->factor;?>" class="form-control" placeholder="Enter Factor">
                  </div>
                </div>

                <?php 
                  if ($this->userhelper->current('role_id') ==1) { 
                ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-12 col-xs-12" for="purchase_expense">
                        Purchase Price<font color="red"><span class="required">*</span></font> :
                      </label>

                      <div class="col-md-9 col-sm-12 col-xs-12">
                        <input type="text" name="purchase_expense" value="<?php echo ROUND($result[0]->purchase_expense,2);?>" class="form-control" placeholder="Enter Purchase Price">
                      </div>
                    </div>
                <?php
                  } 
                ?>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="latitude">
                    Unit<font color="red"><span class="required">*</span></font> :
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <select class="form-control select2" name="unit" id="unit">
                        <option value="">Select Unit</option>
                      <?php 
                        if($result[0]->unit == 1) { 
                      ?>
                          <option value="1" selected="">CTN</option>
                      <?php 
                        } else { 
                      ?>
                          <option value="1">CTN</option>
                      <?php 
                        } 
                      ?> 
                      <?php 
                        if($result[0]->unit == 2) { 
                      ?>
                          <option value="2" selected="">SQM</option>
                      <?php 
                        } else { 
                      ?>
                          <option value="2">SQM</option>
                      <?php
                        } 
                      ?>  
                      <?php 
                        if($result[0]->unit == 3) { 
                      ?>
                          <option value="3" selected="">PCS</option>
                      <?php 
                        } else { 
                      ?>
                        <option value="3">PCS</option>
                      <?php
                        } 
                      ?>
                      <?php 
                        if($result[0]->unit == 4) { 
                      ?>
                          <option value="4" selected="">SET</option>
                      <?php
                        } else { 
                      ?>
                          <option value="4">SET</option>
                      <?php 
                        } 
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group" id="quanity_div">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="quantity_per">
                      Quantity per <span id="unit_name"></span> unit<font color="red"><span class="required">*</span></font> :
                    </label>

                    <div class="col-md-9 col-sm-12 col-xs-12">
                        <input type="text" name="quantity_per_unit" id="quantity_per" readonly="" value="<?php echo ROUND($result[0]->quantity_per_unit,2);?>" class="form-control" placeholder="Quantity Per">
                    </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="latitude">
                    Item Group<font color="red"><span class="required">*</span></font> :
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <select class="form-control select2" name="categories[]" multiple="multiple" id="category">
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

                <div class="box-footer">
                  <input type="submit" class="btn btn-primary" value="Save<?php //echo $btn;?>">
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
                   <?php if ($action == 'insert') { ?>
                    $("#quanity_div").hide();
                   <?php } else { ?>
                      $("#quanity_div").show();  
                    <?php if($result[0]->unit == 1) { ?>
                              $("#unit_name").text('CTN');
                                <?php } ?>
                              
                                 <?php if($result[0]->unit == 2) { ?>
                              $("#unit_name").text('SQM');
                                <?php } ?>
                                
                                <?php if($result[0]->unit == 3) { ?>
                             $("#unit_name").text('PCS');
                                <?php }?>
                             
                                 <?php if($result[0]->unit == 3) { ?>
                                $("#unit_name").text('SET');
                                <?php }  ?>
                      
                   <?php } ?>
                         
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
        errorClass:"text-danger",
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
						},
            "categories[]":{
              required: true,
              minlength: 1  
            }
					
					},
					messages: {
                                                
						name: {
							required: "Please Enter Item",
                                                        noSpace: true,
						},
                                                price: {
							required: "Please Enter Price",
                                                        noSpace: true,
						},
                                                quantity: {
							required: "Please Enter Quantity",
                                                        noSpace: true,
						},
             "categories[]": {
              required: "Please Select  Item Group",
             noSpace: true,
            },
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
      .width(150)
      .height(150);
    };
    reader.readAsDataURL(input.files[0]);
  }
}
	</script>