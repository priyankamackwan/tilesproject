<?php
	$this->load->view('include/header');
	$this->load->view('include/leftsidemenu');	
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);
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
<style type="text/css">
a:hover, a:active, a:focus {
	cursor: pointer;
}
.width_80{
		width: 80px;
	}
	table#datatables1 th {
	vertical-align: middle;
	}
	
@media only screen and (min-width: 320px) and (max-width: 480px) {
	.width_80{
		width: 50px;
	}
	.dis_none{
		display: none;

	}
	.maxwidth300{
		max-width: 300% !important;
	}
}
@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
	.width_80{
			width: 50px;
	}
	.marginright_20px{
		margin-right: 20px;
	}
	.dis_none{
		display: none;
	}
}
@media screen and (device-width: 360px) and (device-height: 640px) and (-webkit-device-pixel-ratio: 2) {
	.width_80{
		width: 50px;
	}
	.dis_none{
		display: none;
	}
}

</style>
<!-- Main Container start-->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	<div class="row">
		<div class="col-md-11 col-sm-12 col-xs-12">
			<a href="<?php echo base_url($this->controller);?>"class="btn btn-danger">Back to list</a>
			<span style="float:right;">
	        	<button class="btn btn-info" id="back" value="<?php echo $id;?>"><< Prev <br><?= $prev?></button>
	        	<button class="btn btn-info" id="next" value="<?php echo $id;?>">Next >> <br> <?= $next?></button>
	        </span> 
		</div>
	</div>
	<?php
		echo $this->session->flashdata('edit_profile');
		echo $this->session->flashdata('Change_msg');
		echo $this->session->flashdata('dispMessage');		
		echo $this->session->flashdata($this->msgDisplay);
	?>
	<!-- <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
		<li class="active">Users</li>
	</ol> -->
	</section>
	<!-- Main content section start-->
	<section class="content">
		<div class="row">
			<div class="col-md-11 col-sm-12 col-xs-12">

				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title"><?php echo $btn.' '.$this->msgName;?></h3>
						&nbsp;&nbsp;
					</div>

					<div class="box-body">
						<form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
							<input type="hidden" id="action" name="action" value="<?php echo $action;?>">
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">User Name :</label>
								<div class="col-md-9 col-sm-12 col-xs-12 mt_5">
									<select name="username" id="username">
										<?php 
										if(!empty($activecustomer)){
											foreach ($activecustomer as $key => $value) { ?>
												<option value="<?=$value['id'];?>" <?php if ($value['company_name']==$result[0]['company_name']) { ?>selected="selected"<?php } ?>><?=$value['company_name'];?></option>
										<?php }}?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="tax">Item  Name <font color="red"><span class="required">*</span></font> :</label>
								<div class="col-md-9 col-sm-12 col-xs-12">
									<select class="form-control select2 product_id" name="product_id" style="width:100%;" id="product_id" required="required">
										<option value="" selected >All</option>
											<?php
										        if(!empty($activeProducts) && count($activeProducts) > 0 ){
										            foreach ($activeProducts as $activeProductsKey => $activeProductsValue) {?>
										                <option value="<?php echo $activeProductsValue['id']; ?>" <?php if(isset($result[0]['product_id']) && $result[0]['product_id']!='' && $result[0]['product_id']==$activeProductsValue['id']){echo 'selected';}?>><?php echo $activeProductsValue['name'].' ( '.$activeProductsValue['design_no'].' )'; ?></option>
										    <?php
										            }
										        }else{
										    ?>
										        <option value="">-- No Item Available --</option>
										    <?php
										        }
										    ?>
									</select>
								</div>
							</div>				
							<div class="form-group">
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="tax">Tax <font color="red"><span class="required">*</span></font> :</label>
				                <div class="col-md-9 col-sm-12 col-xs-12">
				                    <input type="text" name="tax" value="<?php if(isset($post['tax']) && $post['tax']!=''){echo $post['tax'];}else{ echo $result[0]['tax'];}?>" class="form-control" placeholder="Tax">
				                </div>
				            </div>
				            <div class="form-group">
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="cargo">Cargo <font color="red"><span class="required">*</span></font> :
				                 </label>
				                <div class="col-md-9 col-sm-12 col-xs-12">
				                    <input type="text" name="cargo" value="<?php if(isset($post['cargo']) && $post['cargo']!=''){echo $post['cargo'];}else{ echo $result[0]['cargo'];}?>" class="form-control" placeholder="Cargo">
				                </div>
				            </div>
				            <div class="form-group">
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="cargo">Cargo Number <font color="red"><span class="required">*</span></font> :
				                 </label>
				                <div class="col-md-9 col-sm-12 col-xs-12">
				                    <input type="text" name="cargo_number" value="<?php if(isset($post['cargo']) && $post['cargo_number']!=''){echo $post['cargo_number'];}else{ echo $result[0]['cargo_number'];}?>" class="form-control" placeholder="Cargo Number">
				                </div>
				            </div>
				            <div class="form-group">
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="cargo">Location <font color="red"><span class="required">*</span></font> :
				                 </label>
				                <div class="col-md-9 col-sm-12 col-xs-12">
				                    <input type="text" name="location" value="<?php if(isset($post['location']) && $post['location']!=''){echo $post['location'];}else{ echo $result[0]['location'];}?>" class="form-control" placeholder="Location">
				                </div>
				            </div>
				            <div class="form-group">
				                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="cargo">Mark <font color="red"><span class="required">*</span></font> :
				                 </label>
				                <div class="col-md-9 col-sm-12 col-xs-12">
				                    <input type="text" name="mark" value="<?php if(isset($post['mark']) && $post['mark']!=''){echo $post['mark'];}else{ echo $result[0]['mark'];}?>" class="form-control" placeholder="Mark">
				                </div>
				            </div>
				            <div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="description">Status <font color="red"><span class="required">*</span></font>:</label>			
								<div class="col-md-9 col-sm-12 col-xs-12">
									<select class="form-control select2" name="status" style="width:100%;" id="status">
										<option value="1" <?php if(!empty($result[0]['item_status']== "1")){echo 'selected';}?>>New</option>
										<option value="2" <?php if(!empty($result[0]['item_status']== "2")){echo 'selected';}?>>Approved</option>
										<option value="3" <?php if(!empty($result[0]['item_status']== "3")){echo 'selected';}?>>Cancelled</option>
									</select>
									<label id="mark-error" class="error" for="mark"></label>
								</div>
							</div>  
				            <div class="box-footer">
			                	<input type="submit" id="submit1" name="submit" class="btn btn-success" value="<?php //echo $btn;?> Update Sample Request" style="float:right;">
			                </div> 
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<?php $this->load->view('include/footer'); ?>
<script type="text/javascript">
	$("#next").click(function(){
	    var id = $(this).val();
	    $.ajax({
	      type : "POST",
	      url : "<?php echo base_url().$this->controller."/next/" ?>",
	      data : {id:id},
	      dataType: "json",
	      success : function (data){
	        if(data.status=="fail"){
	          $("#next").attr("disabled",true);
	          $("#back").attr("disabled",false);
	          $("#next").html("Next >> <br>"+data.inv);
	        }else {
	          var id =  data.url;
	          window.location.href = id;
	        }
	      }
	    });  
	});
	$("#back").click(function(){
		var id = $(this).val();
	    $.ajax({
	      type : "POST",
	      url : "<?php echo base_url().$this->controller."/previous/" ?>",
	      data : {id:"<?php echo $id;?>"},
	      dataType: "json",
	      success : function (data){
	        if(data.status=="fail"){
	          $("#back").attr("disabled",true);
	          $("#next").attr("disabled",false);
	          $("#back").html("<<  Prev <br>"+data.inv);
	        }else {
	          var id =  data.url;
	          window.location.href = id;
	        }
	      }
	    });  
	});
</script>