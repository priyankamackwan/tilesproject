<?php 
  $url=$this->uri->segment(1);
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" id="menu">
            <li class="treeview <?php echo $url == 'Dashboard'?'active':'';?>">
                        <a href="<?php echo base_url();?>Dashboard"><i class="fa fa-desktop"></i><span>Dashboard</span></a>
                    </li>
            <?php
                // Show side menubar according to role
                if ($this->userhelper->current('role_id') == 1) {
            ?>
                    <li class="treeview <?php echo $url == 'Adminuser'?'active':'';?>">
                        <a href="<?php echo base_url();?>Adminuser"><i class="fa fa-user-plus"></i><span>Admin Users</span></a>
                    </li>
            <?php
                }

                if (in_array('3',$this->userhelper->current('rights'))) {
            ?>
                    <li class="treeview <?php echo $url == 'User'?'active':'';?>">
                        <a href="<?php echo base_url();?>User"><i class="fa fa-user"></i><span>Contacts</span></a>
                    </li>
            <?php    
                }

                if (in_array('4',$this->userhelper->current('rights'))) {
            ?>
                    <li class="treeview <?php echo $url == 'Category'?'active':'';?>">
                        <a href="<?php echo base_url();?>Category"><i class="fa fa-tag"></i><span>Item Group</span></a>
                    </li> 
            <?php    
                }

                if (in_array('5',$this->userhelper->current('rights'))) {
            ?>
                    <li class="treeview <?php echo $url == 'Product'?'active':'';?>">
                        <a href="<?php echo base_url();?>Product"><i class="fa fa-tag"></i><span>Items</span></a>
                    </li>
                    <li class="treeview <?php echo $url == 'Low_stock'?'active':'';?>">
                        <a href="<?php echo base_url();?>Low_stock"><i class="fa fa-tag"></i><span>Low Stock Items</span></a>
                    </li>
            <?php   
                }

                if (in_array('6',$this->userhelper->current('rights'))) {
            ?>
                    <li class="treeview <?php echo $url == 'Order'?'active':'';?>">
                        <a href="<?php echo base_url();?>Order"><i class="fa fa-tag"></i><span>Sales Orders</span></a>
                    </li>
            <?php
                }

                if ($this->userhelper->current('role_id') == 1) {
            ?>
                    <li class="treeview <?php echo $url == 'Customer_report'?'active':'';?>">
                        <a href="<?php echo base_url();?>Customer_report"><i class="fa fa-tag"></i><span>Customer Reports</span></a>
                    </li>
                    <li class="treeview <?php echo $url == 'Sales_report'?'active':'';?>">
                        <a href="<?php echo base_url();?>Sales_report"><i class="fa fa-tag"></i><span>Sales Reports</span></a>
                    </li>
                    <li class="treeview <?php echo $url == 'Expense_report'?'active':'';?>">
                        <a href="<?php echo base_url();?>Expense_report"><i class="fa fa-tag"></i><span>Expense Reports</span></a>
                    </li>
                    <li class="treeview <?php echo $url == 'Product_report'?'active':'';?>">
                        <a href="<?php echo base_url();?>Product_report"><i class="fa fa-tag"></i><span>Product Reports</span></a>
                    </li>
            <?php
                }
            ?>
        </ul>
    </section>
 <!-- /.sidebar -->
</aside>


