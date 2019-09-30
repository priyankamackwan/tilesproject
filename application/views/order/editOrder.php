<?php
	$this->load->view('include/header');
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);

	if($action == 'insert')
	{
		$btn = "Save";
	}
	else if($action == 'salesOrderUpdate')
	{
		$btn = "Update";
	}
?>

    <div class="right_col" role="main">
        <div class="row">

            <!-- Page Title  -->
            <div class="page-title">
                <div class="title_left">
                    <a href="<?php echo base_url($this->controller);?>"class="btn btn-info">Back</a> 
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="x_panel">

                        <!-- Header (Title)  -->
                        <div class="x_title">
                            <h2><?php echo $btn.' '.$this->msgName;?></h2>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <br />
                            
                            <!-- Update Product detail form -->
                            <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                                <!-- Order Detail -->
                                <div class="form-group">

                                    <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">
                                        Order Detail
                                    </label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                            
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
                                                        <td style="text-align: center">
                                                            <?php echo $productData[$p]['product_name'];?>
                                                        </td>

                                                        <td style="text-align: center">
                                                            <?php echo $productData[$p]['product_design_no'];?>
                                                        </td>

                                                        <td style="text-align: center">
                                                            <?php echo $productData[$p]['product_quantity'];?>
                                                        </td>

                                                        <td style="text-align: center">
                                                            <?php echo $productData[$p]['product_price'];?>
                                                        </td>
                                                    </tr>
                                            <?php 
                                                } 
                                            ?>
                                        </table>
                                    </div>
                                </div>

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
<?php
	$this->load->view('include/footer');
?>