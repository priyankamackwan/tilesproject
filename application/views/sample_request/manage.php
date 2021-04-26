<?php
	$this->load->view('include/header');
    $this->load->view('include/leftsidemenu');
    // Save Status from dashboard page unpaid orders
    $dash_status=$client_name='';
    if(isset($_GET['status']) && $_GET['status']!='' && $_GET['status']=="unpaid"){
        $dash_status='selected';
    }
    if(isset($_GET['client_name']) && $_GET['client_name']!='' ){
        $client_name=str_replace('_', '&',str_replace('-', ' ',$_GET['client_name']));
    }
    //start date and end date for datepickker filter
    $from_dateshow = date("d/m/Y", strtotime("first day of this month"));
    $to_dateshow = date("d/m/Y");
?>

<!-- Main Container start-->
<div class="content-wrapper">
    <section class="content-header">
        <?php
            echo $this->session->flashdata('edit_profile');
            echo $this->session->flashdata('Change_msg');
            echo $this->session->flashdata($this->msgDisplay);
        ?>
    </section>

    <section class="content">

        <div class="box">
            <div class="box-body">
                <div class="row form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-1 col-sm-12 col-xs-12">
                                <h4>Filters:</h4>
                            </div>
                            <div class="col-md-11 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="row">

                                        <!-- Client Filter  -->
                                        <div class="col-md-1 col-sm-12 col-xs-12" >
                                            <!-- <label class="control-label" style="margin-top:7px;">Company Name:</label> -->
                                        </div>

                                        <!-- Client Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select name="clientList" class="form-control select2" style="width: 100%;" id="clientList">
                                                <option value="" selected="selected">All Companies</option>
                                                <?php
                                                    if(!empty($activeUsers) && count($activeUsers) > 0 ){
                                                    
                                                        foreach ($activeUsers as $activeUsersKey => $activeUsersValue) {
                                                ?>
                                                            <option value="<?php echo $activeUsersValue['company_name']; ?>" <?php if(isset($client_name) && $client_name!='' && $client_name==$activeUsersValue['company_name']){ echo 'selected';}?>><?php echo $activeUsersValue['company_name']; ?></option>
                                                <?php
                                                        }
                                                    }else{
                                                ?>
                                                    <option value="">-- No Company Available --</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <!-- Item Filter -->
                                        <div class="col-md-1 col-sm-12 col-xs-12">
                                            <!-- <label class="control-label" style="margin-top:7px;">Item:</label> -->
                                        </div>

                                        <!-- Item Filter Dropdown -->
                                        <div class="col-md-3 col-sm-12 col-xs-12">
                                            <select class="form-control select2" name="productsList" style="width:100%;" id="productsList">
                                                <option value="" selected >All Items</option>
                                                <?php
                                                    if(!empty($activeProducts) && count($activeProducts) > 0 ){
                                                    
                                                    foreach ($activeProducts as $activeProductsKey => $activeProductsValue) {
                                                ?>
                                                    <option value="<?php echo $activeProductsValue['id']; ?>"><?php echo $activeProductsValue['name'].' ( '.$activeProductsValue['design_no'].' )'; ?></option>
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

                                        <!-- Date Range Filter -->
                                        <!-- <div class="col-md-1 col-sm-12 col-xs-12"> -->
                                            <!-- <label class="control-label" style="margin-top:7px;">Date:</label> -->
                                        <!-- </div> -->

                                        <!-- Date Range Filter Dropdown -->
                                        <div class="col-md-4 col-sm-12 col-xs-12 ">
                                            <div class="input-group">
                                                <input class="form-control" placeholder="Order Date" required="" id="salesOrderDate" name="salesOrderDate" type="text" value="<?php echo $from_dateshow.' - '.$to_dateshow; ?>">
                                                <label class="input-group-addon btn" for="salesOrderDate">
                                                    <span class="fa fa-calendar"></span>
                                                </label>
                                                <label class="btn-danger input-group-addon btn " id="resetDatePicker" for="salesOrderDate " data-toggle="tooltip" title="Reset" onclick="resetDatePicker()">
                                                    <span class="fa fa-refresh"></span>
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <!-- Invoice Status Filter -->
                                    <div class="col-md-1 col-sm-12 col-xs-12">
                                        <!-- <label class="control-label" style="margin-top:7px;">Invoice Status:</label> -->
                                    </div>

                                    <!-- Invoice Status Filter Dropdown -->
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <select class="form-control" name="invoiceStatus" style="width:100%;" id="invoiceStatus">
                                            <option value="">All Invoice Status</option>
                                            <option value="unpaid" <?php echo $dash_status;?>>Unpaid</option>
                                            <option value="paid">Paid</option>
                                            <option value="parpaid">Partial Paid</option>
                                        </select>
                                    </div>

                                    <!-- Delivery Status Filter -->
                                    <div class="col-md-1 col-sm-12 col-xs-12">
                                        <!-- <label class="control-label" style="margin-top:7px;">Delivery Status:</label> -->
                                    </div>

                                    <!-- Delivery Status Filter Dropdown -->
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <select class="form-control" name="status" style="width:100%;" id="status">
                                            <option value="">All Delivery Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="inprogress">In Progress</option>
                                            <option value="delivered">Delivered</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $msgName;?></h3>
                        <a href="<?php echo base_url($this->controller);?>/uploadOrders" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Import Sample Request</a>
                    </div>

                    <!-- Order table -->
                    <div class="box-body table-responsive">
                        <table id="datatables" class="table main-table  table-bordered table-hover  table-striped " width="100%">
                            <thead>
                                <th class="text-center">Sr No.</th>
                                <th class="text-center">Company Name</th>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Tax</th>
                                <th class="text-center">Cargo</th>
                                <th class="text-center">Cargo Number</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">Mark</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Created On</th>
                                <th class="text-center">Manage</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
  <!-- Main content section end-->
</div>
<?php
	$this->load->view('include/footer');
?>

<script>
    jQuery(document).ready(function(){    
        $.ajax({
            "url": "<?php echo base_url().$this->controller."/server_data/" ?>",
            "dataType": "json",
            "type": "POST",
            "data":function(data) {
               
            },
        });
    });
</script>
