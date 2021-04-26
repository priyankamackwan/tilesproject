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
						<input type="submit" name="delivered" id="delivered" class="btn btn-primary delivered" value="Mark as Delivered" disabled="disabled">
					</div>

					<div class="box-body">
						<form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/Update_order';?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
							
							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
							<input type="hidden" id="action" name="action" value="<?php echo $action;?>">
							<input type="hidden" id="ordercount" name="ordercount" value="<?php echo count($result);?>">
								
							
			                <input type="hidden" name="price" value="<?php echo $price;?>">
			                <input type="hidden" name="client_type" id="client_type" value="<?php echo $client_type;?>">
		             
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