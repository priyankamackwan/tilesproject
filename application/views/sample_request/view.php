<?php
/*echo '<pre>';
print_r($result); exit;*/
  $this->load->view('include/header');
  $this->load->view('include/leftsidemenu');
  defined('BASEPATH') OR exit('No direct script access allowed');
  error_reporting(0);

?>
<!-- Main Container start-->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="row">
      <div class="col-md-9 col-sm-12 col-xs-12">
        <a href="<?php echo base_url($this->controller);?>"class="btn btn-danger">Back to list</a> 
        <span style="float:right;">
        
        <button class="btn btn-info" id="back" value="<?php echo $result[0]->id;?>"><< Prev <br><?= $prev?></button>
        <button class="btn btn-info" id="next" value="<?php echo $result[0]->id;?>">Next >> <br> <?= $next?></button>
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
                  Item Name :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php 
                    if(!empty($activeProducts[0]->name)) {
                      echo $activeProducts[0]->name; 
                    }
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  User Name :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php 
                    if(!empty($activecustomer[0]->company_name)) {
                      echo $activecustomer[0]->company_name;
                    }
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Tax :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php 
                  if(!empty($result[0]->tax)){
                    echo $this->My_model->getamount(round($result[0]->tax,2));
                  }
                  ?>
                </div>
              </div>
      
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Cargo :
                </label>
              
                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php 
                    if(!empty($result[0]->cargo)){  
                      echo $result[0]->cargo;
                    }
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Cargo Number :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php 
                    if(!empty($result[0]->cargo_number)){  
                      echo $result[0]->cargo_number;
                    }
                  ?>
                </div>
              </div>
             
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Location :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php 
                    if(!empty($result[0]->location)) {
                      echo $result[0]->location;
                    }
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
                  Mark :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <?php 
                    if(!empty($result[0]->mark))  {
                      echo $result[0]->mark;
                    }
                  ?>
                </div>
              </div>
                           
              <div class="form-group" id="id_payment_date"> <!-- if payment status is completed then display the date div -->
                <label class="control-label col-md-3 col-sm-6 col-xs-6 " for="payment_date">
                  Created On :
                </label>

                <div class="col-md-9 col-sm-6 col-xs-6 mt_5">
                  <div class='input-group date' id='payment_datetimepicker'>
                    <?php 
                    if(!empty($result[0]->created)) {
                      echo $this->My_model->date_conversion($result[0]->created,'d/m/Y H:i:s',' ');
                    } 
                    ?>
                  </div>
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
      data : {id:"<?php echo $result[0]->id;?>"},
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
