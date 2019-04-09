 <!-- footer content -->
        <footer>
          <div class="pull-right">
            Developed By : Web Patriot
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap-progressbar.min.js"></script>

<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
	
	 <!-- Select2 -->
	<script src="<?php echo base_url();?>assets/js/select2.full.min.js"></script>
	
    <!-- Skycons -->
    <script src="<?php echo base_url();?>assets/js/skycons.js"></script>
    <!-- DateJS -->
    <script src="<?php echo base_url();?>assets/js/date.js"></script>
	
	
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url();?>assets/js/moment.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script> 
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url();?>assets/js/custom.min.js"></script>
	
	<!-- Include Date Range Picker -->
	<script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>

	
	<!--Copy Data-->
	<script src="<?php echo base_url();?>assets/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
	<!-- sweetalert JS -->
		<script src="<?php echo base_url();?>assets/js/sweetalert.min.js"></script>
	
	<!-- Datatables -->
    
    <script src="<?php echo base_url();?>assets/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/pdfmake.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>application/third_party/ckeditor/ckeditor.js"></script>
	<!-- Common Js -->
	<script src="<?php echo base_url();?>assets/js/common.js"></script>
	  
	<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/additional-methods.min.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>


	<script>
    $(document).ready(function(){
      $('#timepicker1').timepicker();
       $('.datetimepicker3').datetimepicker({
                   //format: 'LT',
                    format : 'HH:mm',
                    
                });
      $('#datepicker').datepicker({
        format: 'dd-mm-yyyy',
       
        todayHighlight: true,
        autoclose: true,
      });
       
	   $("select").select2({
			  placeholder: "Select",
			  allowClear: true
		});
		$(document).on('click', '.confirm-delete', function(e) {
        e.preventDefault(); // Prevent the href from redirecting directly
        var linkURL = $(this).attr("href");
        warnBeforeDelete(linkURL);
    });
    
    		$(document).on('click', '.confirm-delete-user', function(e) {
        e.preventDefault(); // Prevent the href from redirecting directly
        var linkURL = $(this).attr("href");
        warnBeforeDeleteUser(linkURL);
    });
    
    $(document).on('click', '.confirm-statuschange', function(e) {
        e.preventDefault(); // Prevent the href from redirecting directly
        var linkURL = $(this).attr("href");
        warnBeforeStatusChange(linkURL);
    });
    
     function warnBeforeStatusChange(linkURL) {
        swal({
            title: "Are You Sure to change the status?",
            type: "warning",
            showCancelButton: true
        }, function() {
            // Redirect the user
            window.location.href = linkURL;
        });
    }

    function warnBeforeDelete(linkURL) {
        swal({
            title: "Are You Sure to delete?",
            text: "Once Delete, Action Can Not Be Undone!!!",
            type: "warning",
            showCancelButton: true
        }, function() {
            // Redirect the user
            window.location.href = linkURL;
        });
    }
    
     function warnBeforeDelete(linkURL) {
        swal({
            title: "Are You Sure to delete?",
            text: "All Orders of the contact will also get deleted!!",
            type: "warning",
            showCancelButton: true
        }, function() {
            // Redirect the user
            window.location.href = linkURL;
        });
    }
		
    });
	
	$(document).ready(function() {
    $('#example').DataTable();
	});
</script>
	
  </body>
</html>