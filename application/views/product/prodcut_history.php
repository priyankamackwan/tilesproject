<?php
// print_r($procut_history);die(); 
?>
<!-- For Payment History Poup view -->
<section class="content-header">
    <div class="alert alert-success" style="display: none;">
        <button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
        <div id="successpaid"></div>
    </div>
    <div class="alert alert-danger" style="display: none;">
        <button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
        <div id="dangerpaid"></div>
    </div>
</section>
<form enctype="multipart/form-data" action="" method="post" id="demo-form3" data-parsley-validate class="form-horizontal form-label-left">
    <input type="hidden" name="id" id="id" value="<?php echo $procut_history->id;?>">
    <input type="hidden" name="productHistoryId" id="productHistoryId" value="<?php echo $procut_history->productHistoryId;?>">
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>">
    <input type="hidden" name="purchase_expense" id="purchase_expense" value="<?php echo $procut_history->purchase_expense;?>">
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">Item Name :</label>
        <div class="col-md-9 col-sm-12 col-xs-12 mt_5">
            <?php echo  $procut_history->name;?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="sales_expense">
          Purchase Price <font color="red"><span class="required">*</span></font> :
        </label>

        <div class="col-md-9 col-sm-12 col-xs-12">
          <input type="text" name="purchase_rate" id="purchase_rate" class="form-control " placeholder="Enter Reference Purchase Price" required="required" value="<?php if(!empty($procut_history->purchase_rate)){echo  $procut_history->purchase_rate;}?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="sales_expense">
          Quantity <font color="red"><span class="required">*</span></font>:
        </label>

        <div class="col-md-9 col-sm-12 col-xs-12">
          <input type="text" name="quantity" id="quantity" class="form-control " placeholder="Enter Quantity" required="required" value="<?php if(!empty($procut_history->quantity)){echo  $procut_history->quantity;}?>" read>
        </div>
    </div>
    <input type="submit" class="btn btn-primary text-center" value="Save">
</form>
<script type="text/javascript">
$(document).ready(function (){
    $("#payment_gly").click(function() {
        $("#paymentdate").val('');
            $('#payment_datetimepicker').datetimepicker({
            locale: 'ru',
            autoclose: true
            });
        });
    $('#demo-form3').validate({
        errorClass:"text-danger",
        rules:{
            purchase_rate:{
                noSpace: true,
                required: true,
                number:true,
            },
            quantity:{
                noSpace: true,
                required: true,
                number:true,
            },   
        },
        messages: {
                                    
            paymentdate: {
                required: "Please select Payment Date",
            },
            amount: {
                required: "Please Enter Amount",
            }
            
        },
        submitHandler: function(form){
            $(".alert-success").hide();
            $(".alert-danger").hide();
            // form.submit();
            $.ajax({
                type : "POST",
                url : "<?php echo base_url().$this->controller."/updateProductHistory/" ?>",
                data : $('#demo-form3').serialize(),
                dataType: "json",
                 success: function (data) {

                    if(data.status=="success"){
                        $("#paymentdate").val();
                        $("#payment_mode").val();
                        $("#reference").val();
                        $("#amount").val();
                        
                        $(".alert-success").show();
                        $("#successpaid").html(data.message);
                    }else{
                        $(".alert-danger").show();
                        $("#dangerpaid").html(data.message);
                    }
                  setTimeout(function(){ window.location.reload(); }, 1000);
                 }
             });
             return false;
        }
    });
});


</script>