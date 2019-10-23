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
                    <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/addUsers';?>" method="post" id="demo-form2">
				<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_image">Upload Contacts<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" name="upload_contacts" class="form-control numberonly col-md-7 col-xs-12">
                        </div>
					  </div>	
	
                           <br/> <br/> <br/>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" id="submit1" class="btn btn-primary">Submit</button>
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
            <?php        
              echo $this->session->flashdata('imagetype');
            ?>

            <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/addUsers';?>" onsubmit="return uplodContactFormValidation();" method="post" id="demo-form2" class="form-horizontal form-label-left">

              <div class="form-group">
						    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_image">
                  Upload Contacts<font color="red"><span class="required">*</span></font> :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <input type="file" name="upload_contacts" class="form-control numberonly" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                  <p class="text-danger"><small>* only allow .xls, .xlsx and .csv files</small></p>
                </div>
                
					    </div>

              <div class="box-footer">
                <input type="submit" id="submit1" name="submit" class="btn btn-primary" value="Submit">
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
  // $(document).ready(function (){

		
	// });

  function uplodContactFormValidation() {
    $('#demo-form2').validate({
      errorClass:"text-danger",
      rules:{
        upload_contacts: {
          required: true,
        }
      },
			
      // submitHandler: function(form){
      // 	form.submit();
      // }
		});

    if(!$('#demo-form2').valid()){
      return false;
    }else{
      return true;
    }
  }
 
	</script>
