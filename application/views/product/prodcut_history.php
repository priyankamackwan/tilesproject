<?php
print_r($procut_history);die(); 
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
    <input type="hidden" name="id" id="id" value="<?php echo $order_id;?>">
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>">
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">Invoice Amount :</label>
        <div class="col-md-9 col-sm-12 col-xs-12 mt_5">
            <?php echo  $this->My_model->getamount(round($payment_history->total_price  + $orderTax,2));?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">Balance Amount :</label>
        <div class="col-md-9 col-sm-12 col-xs-12 mt_5">
            <?php echo  $this->My_model->getamount(round($payment_history->total_price + $orderTax -$paidamount));?>
        </div>
    </div>
    <div class="form-group" id="id_payment_date"> 
    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="payment_date">
      Payment Date <font color="red"><span class="required">*</span></font>:
    </label>
    <div class="col-md-9 col-sm-12 col-xs-12">
      <div class='input-group date' id='payment_datetimepicker'>
          <input type='text' class="form-control" id="paymentdate" name="paymentdate"   required="required"/ value="<?php echo $payment_date;?>">
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar" id="payment_gly"></span>
          </span>
      </div>
    </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="sales_expense">
          Payment Mode :
        </label>

        <div class="col-md-9 col-sm-12 col-xs-12">
          <input type="text" name="payment_mode" id="payment_mode" class="form-control " placeholder="Payment Mode" value="<?php echo $payment_mode;?>" >
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="sales_expense">
          Reference Id :
        </label>

        <div class="col-md-9 col-sm-12 col-xs-12">
          <input type="text" name="reference" id="reference" class="form-control " placeholder="Enter Reference Id" value="<?php echo $reference;?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-12 col-xs-12" for="sales_expense">
          Amount <font color="red"><span class="required">*</span></font>:
        </label>

        <div class="col-md-9 col-sm-12 col-xs-12">
          <input type="text" name="amount" id="amount" class="form-control " placeholder="Enter Amount" required="required" value="<?php echo $amount;?>">
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
            paymentdate:{
                required: true,
            },
            amount:{
                noSpace: true,
                required: true,
                number:true,
                range:[1,<?php echo $payment_history->total_price+ $orderTax-$rangepaidamount;?>],
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
                url : "<?php echo base_url().$this->controller."/update_order_payment/" ?>",
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