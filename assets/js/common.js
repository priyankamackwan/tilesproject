jQuery(document).ready(function($){
	
	/* Allow only alphabets */
	
	$(document.body).bind('paste',function(event){
		event.preventDefault();
	});
	
	$(document.body).on('keypress',".numberonly",function(event){
		if ((event.which < 48 || event.which > 57)) 
		{
			event.preventDefault();
		}
	});
	
	$(document.body).on('keypress',".amountonly",function(event){
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) 
		{
			event.preventDefault();
		}
	});
	

	/* Allow only alphabets and digits and dot*/
	$(".alphanumeric").on('keypress',function(event){
		var keyCode = (event.which) ? event.which : event.keyCode;

		// Allow: backspace, delete
		if(event.keyCode == 8 || event.keyCode == 46 || keyCode == 9 || keyCode == 27 || keyCode == 13 || 
			//Capital and small letters
			(keyCode >= 65 && keyCode <= 90 )|| (keyCode >= 97 && keyCode <= 122)||
			//Digits Only
			(keyCode >= 48 && keyCode <= 57 ))
			return; 
	    else{ 
	    	//prevent for Special characters
	    	 event.preventDefault(); }
	});
	
	/* Allow only alphabets */
	$(".textonly").on('keypress',function(event){
		var keyCode = (event.which) ? event.which : event.keyCode;

		// Allow: backspace, delete, tab, escape, and enter
		if ( keyCode == 8 || event.key == 'Del' || keyCode == 9 || keyCode == 27 || keyCode == 13 || keyCode == 32 ||
				// Allow: Ctrl+A
				(keyCode == 65 && event.ctrlKey === true) || 
				//Allow: home, end, left, right
				(keyCode >= 35 && keyCode <= 39)) {
					// let it happen, don't do anything
				return;
		} else if(keyCode < 65 /* A to Z and a */ || keyCode > 122 /* z */) {
			event.preventDefault();
	    }
	});
	
	/* Allow only BACKSPACE AND DELETE */
	$(".datefield").on('keypress',function(event){
		var keyCode = (event.which) ? event.which : event.keyCode;

		// Allow: backspace, delete
		if(event.keyCode == 8 || event.keyCode == 46) { return; }
	    else{ event.preventDefault(); }
	});
	
	
	
	/* Allow only alphabets, Special characters and whitespaces */
	$(".alphaspecial").on('keypress',function(event){
		var keyCode = (event.which) ? event.which : event.keyCode;

		// Allow: backspace, delete
		if(event.keyCode == 8 || event.keyCode == 46 ||
			//Capital and small letters
			(keyCode >= 65 && keyCode <= 90 )|| (keyCode >= 97 && keyCode <= 122)||
			//special characters
			(keyCode >= 32 && keyCode <= 47 ))
			return; 
	    else{
	    	//prevent for digits
	    	if( keyCode >= 48 && keyCode <= 57  ){ event.preventDefault(); }}
	});
	

	
	/* Allow only alphabets and digits, underscore, dash*/
	$(".username").on('keypress',function(event){
		var keyCode = (event.which) ? event.which : event.keyCode;
		
		// Allow: backspace, delete, underscore, dash and dot
		if(keyCode == 8 || event.key == 'Del' || keyCode == 9 || keyCode == 45 || keyCode == 95 || keyCode == 46 ||
			//Capital and small letters
			(keyCode >= 65 && keyCode <= 90 )|| (keyCode >= 97 && keyCode <= 122)||
			//Digits Only
			(keyCode >= 48 && keyCode <= 57 ) ||
			//Allow: home, end, left, right
			(keyCode >= 35 && keyCode <= 39))
			return; 
		else { 
	    	//prevent for Special characters
	    	 event.preventDefault(); }
	});
	/*
	Decimal Example
	<input type="text" name="" id="" class="decimalonly" data-precision="2"/>
	*/
	$(document.body).on('keypress',".decimalonly",function(event){
		 var $this = $(this);
		 var $upto = $(this).attr("data-precision");
		if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
		   ((event.which < 48 || event.which > 57) &&
		   (event.which != 0 && event.which != 8))) {
			   event.preventDefault();
		}

		var text = $(this).val();
		if ((event.which == 46) && (text.indexOf('.') == -1)) {
			setTimeout(function() {
				if ($this.val().substring($this.val().indexOf('.')).length > $upto) {
					$this.val($this.val().substring(0, $this.val().indexOf('.') + $upto));
				}
			}, 1);
		}

		if ((text.indexOf('.') != -1) &&
			(text.substring(text.indexOf('.')).length > $upto) &&
			(event.which != 0 && event.which != 8) &&
			($(this)[0].selectionStart >= text.length - $upto)) {
				event.preventDefault();
		} 
	});
	
	$(document.body).on('paste',".decimalonly", function(e){
		var text = e.originalEvent.clipboardData.getData('Text');
		var $upto = $(this).attr("data-precision");
		if ($.isNumeric(text)) {
			if ((text.substring(text.indexOf('.')).length > $upto) && (text.indexOf('.') > -1)) {
				e.preventDefault();
				$(this).val(text.substring(0, text.indexOf('.') + $upto));
		   }
		}
		else	
		{
			e.preventDefault();
		}
	});
});

