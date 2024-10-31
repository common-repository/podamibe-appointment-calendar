jQuery(document).ready( function() {

	/**
	* Scripts for tab view
	* Preview the leaved tab if browser is not closed
	*/

	jQuery('ul.tabs li').click(function(){
		var tab_id = jQuery(this).attr('data-tab');
		sessionStorage.setItem("activeTab",tab_id);
		jQuery('ul.tabs li').removeClass('current');
		jQuery('.tab-content').removeClass('current');

		jQuery(this).addClass('current');
		jQuery("#"+tab_id).addClass('current');
	});

	var active_tab = sessionStorage.getItem("activeTab");

	if(!active_tab){
		jQuery('ul.tabs li[data-tab="tab-1"]').trigger('click');
	}

	if(active_tab){
		jQuery('ul.tabs li[data-tab='+active_tab+']').trigger("click");
	}

	/**
	* scripts for form display/hide
	*/
	jQuery('.pac-checkform').click(function(){ 
		if(jQuery(this).is(':checked')){
			jQuery(".psc-form-fields").hide();
			jQuery(".psc-cf7-display").show();
		}else{
			jQuery(".psc-form-fields").show();
			jQuery(".psc-cf7-display").hide();
		}
	});

	if(jQuery('.pac-checkform').is(':checked')){
		jQuery(".psc-form-fields").hide();
		jQuery(".psc-cf7-display").show();
	}else{
		jQuery(".psc-cf7-display").hide();
	}

	function toggle(className, obj) {
		var $input = $(obj);
		if ($input.prop('checked')) $(className).hide();
		else $(className).show();
	}

	/**
	* scripts for datepicker
	*/

	jQuery( function() {
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
			jQuery.each(pac_date_vars.pac_inserted_date, function(key, value) { 
				unavailableDates.push(new Date(value).format('yyyy-M-dd'));
			});
			var d = new Date(date)
			var date_pac = d.format('yyyy-M-dd');
			if (jQuery.inArray(date_pac, unavailableDates) == -1) {
				return [true, ""];
			} else {
				return [true, "pac_booked_date", ""];
			}
		}

		var selected_date_Arr = new Array();

		jQuery( ".pac-calendar" ).datepicker( {
			changeMonth: true,
			numberOfMonths: 12,
			minDate: 0,
			changeYear: true,
			beforeShowDay:unavailable,

			onSelect: function(dateText, inst) {
				//var target = event.target;
				var selected_date = jQuery(this).val();
				var selector = jQuery(this);
				console.log(selector);
				inst.inline = false; // prevent refresh calender
				jQuery.ajax({
					method: "POST",
					url: ajaxurl,
					data: {"selected_date":selected_date,action:"pac_insert_selected_date"},
					success: function(response){
						jQuery('#pac_loader').hide();
					}
				});
			}

		} );

		jQuery("body").on("click", ".pac-calendar .ui-state-default", function(){
			var selector = jQuery(this);
			jQuery('.ui-state-default').removeClass('ui-state-active');
			if(selector.parent().hasClass('pac_booked_date')) {
				jQuery('#pac_loader').show();
				selector.parent().removeClass('pac_booked_date');
			}else{
				jQuery('#pac_loader').show();
				selector.parent().addClass('pac_booked_date');
			}
		});

	} );

} );