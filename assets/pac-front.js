/**
* Frontend js
*/

jQuery(document).ready( function() {

	Date.prototype.format = function(format) //author: meizz
	{
		var o = {
		    "M+" : this.getMonth()+1, //month
		    "d+" : this.getDate(),    //day
		    "h+" : this.getHours(),   //hour
		    "m+" : this.getMinutes(), //minute
		    "s+" : this.getSeconds(), //second
		    "q+" : Math.floor((this.getMonth()+3)/3),  //quarter
		    "S" : this.getMilliseconds() //millisecond
		}

		if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
			(this.getFullYear()+"").substr(4 - RegExp.$1.length));
			for(var k in o)if(new RegExp("("+ k +")").test(format))
				format = format.replace(RegExp.$1,
					RegExp.$1.length==1 ? o[k] :
					("00"+ o[k]).substr((""+ o[k]).length));
			return format;
		}

		function unavailable(date) {
			unavailableDates = new Array();
			jQuery.each(pac_front_date_vars.pac_front_inserted_date, function(key, value) { 
				unavailableDates.push(new Date(value).format('yyyy-M-dd'));
			});
			var d = new Date(date)
			var date_pac = d.format('yyyy-M-dd');
			if (jQuery.inArray(date_pac, unavailableDates) == -1) {
				return [true, ""];
			} else {
				return [true, "pac_front_booked ui-state-disabled", ""];
			}
		}

		jQuery( ".pac-frontcalendar" ).datepicker( {
			numberOfMonths: 1,
			minDate: 0,
			beforeShowDay:unavailable,
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			monthNamesShort : [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ],
			onSelect: function(dateText, inst) {
			//var target = event.target;
			var selected_date = jQuery(this).val();
			var selector = jQuery(this);
			inst.inline = false;// prevent refresh calender
			jQuery(".pac-book-form").dialog({
				width: 500,
				dialogClass: "pac_dialog"
			});
			jQuery(".pac_hidden_booked_date").val(selected_date);
		}

	} );


		jQuery( ".pac-front-widget-calendar" ).datepicker( {
			numberOfMonths: 1,
			minDate: 0,
			beforeShowDay:unavailable,
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			onSelect: function(dateText, inst) {
			//var target = event.target;
			var selected_date = jQuery(this).val();
			var selector = jQuery(this);
			inst.inline = false;// prevent refresh calender
			jQuery(".pac-book-form-widget").dialog({
				dialogClass: "pac_dialog",
				width: 500,
			});
			jQuery(".pac_hidden_booked_date").val(selected_date);
		}

	} );

		function validateEmail(email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}
	/**
	 * Submit the form from calendar
	 */

	 jQuery("#pac_front_btn").live("click", function(e){
	 	e.preventDefault();

	 	var name_target = jQuery(this).closest('.pac_front_form').find('input[name="pac_user_form[pac_user_form_name]"]');
	 	var email_target = jQuery(this).closest('.pac_front_form').find('input[name="pac_user_form[pac_user_form_email]"]');
	 	var subject_target = jQuery(this).closest('.pac_front_form').find('input[name="pac_user_form[pac_user_form_subject]"]');
	 	var detail_target = jQuery(this).closest('.pac_front_form').find('textarea[name="pac_user_form[pac_user_form_detail]"]');

	 	var name = name_target.val();
	 	var email = email_target.val();
	 	var detail = detail_target.val();

	 	error_flag = 0;
	 	if(name==''){
	 		error_flag = 1;
	 		error_msg = 'Please enter your name.';
	 		name_target.addClass('pac_error');
	 	}else{
	 		name_target.removeClass('pac_error');
	 	}
	 	if(email==''){
	 		error_flag = 1;
	 		error_msg = 'Please enter your email.';
	 		email_target.addClass('pac_error');
	 	}else{
	 		if(validateEmail(email)){
	 			email_target.removeClass('pac_error');
	 		}else{
	 			error_flag = 1;
	 			email_target.addClass('pac_error');
	 		}            
	 	}
	 	if(detail==''){
	 		error_flag = 1;
	 		detail_target.addClass('pac_error');
	 	}else{
	 		detail_target.removeClass('pac_error');
	 	}

	 	if(error_flag==0){
	 		var pac_form_datas = jQuery(".pac_front_form").serialize();
	 		jQuery.ajax({
	 			method: "POST",
	 			url: pac_front_date_vars.ajaxurl,
	 			data: {"form_data":pac_form_datas,action:"pac_front_form_data"},
	 			success: function(response){
	 				alert("Form submitted successfully.");
	 				name_target.attr('value', '');
	 				email_target.attr('value', '');
	 				subject_target.attr('value', '');
	 				detail_target.attr('value', '');
	 			}
	 		});
	 	}
	 });

	 jQuery(".ui-dialog-titlebar-close").live("click", function(){
	 	var name_target = jQuery('input[name="pac_user_form[pac_user_form_name]"]');
	 	var email_target = jQuery('input[name="pac_user_form[pac_user_form_email]"]');
	 	var subject_target = jQuery('input[name="pac_user_form[pac_user_form_subject]"]');
	 	var detail_target = jQuery('textarea[name="pac_user_form[pac_user_form_detail]"]');
	 	name_target.attr('value', '');
	 	email_target.attr('value', '');
	 	subject_target.attr('value', '');
	 	detail_target.attr('value', '');
	 	jQuery('.pac_front_form').find(':input').removeClass('pac_error');
	 });

	} );