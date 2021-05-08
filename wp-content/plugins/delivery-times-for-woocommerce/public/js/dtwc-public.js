jQuery(document).ready(function( $ ) {
	var deliveryDays = dtwc_settings.deliveryDays;
	var weekDays = [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ];
	var deliveryTimes = dtwc_settings.deliveryTimes;
	var prepDays = dtwc_settings.minDate;

	function minutes_with_leading_zeros( dt ) { 
		return (dt.getMinutes() < 10 ? '0' : '') + dt.getMinutes();
	}
	function hours_with_leading_zeros(dt) { 
		return (dt.getHours() < 10 ? '0' : '') + dt.getHours();
	}

	var d = new Date();
	var curr_hour = hours_with_leading_zeros( d );
	var curr_min = minutes_with_leading_zeros( d );
	var currentTime = curr_hour + ":" + curr_min;

	if (0 == prepDays) {
		if ( deliveryTimes.some(el => el > currentTime) ) {
			var minDate = $.datepicker.formatDate('yy-mm-dd', new Date());
		} else {
			var minDate = new Date((new Date()).valueOf() + 1000*3600*24);
			var minDate = $.datepicker.formatDate('yy-mm-dd', minDate);
		}
	} else {
		var minDate = dtwc_settings.minDate;
	}

	console.log(minDate);

	$('#dtwc_delivery_date').datepicker( {
		minDate: minDate,
		maxDate: dtwc_settings.maxDays,
		showAnim: 'fadeIn',
		dateFormat: 'yy-mm-dd',
		firstDay: dtwc_settings.firstDay,
		beforeShowDay: function(date) {
			var currentWeekday = weekDays[ date.getDay() ];
			if ( currentWeekday in deliveryDays ) {
				// So enable the date here by returning an array.
				return [ true, "dtwc_date_available", "This date is available"];
			}
			return [ false, "dtwc_date_unavailable", "This date is unavailable" ];
		}
	} );
} );

jQuery(document).ready(function( $ ) {
	$('#dtwc_delivery_date').change(function() {
		var chosenDate = $(this).val();
		var today = $.datepicker.formatDate('yy-mm-dd', new Date());

		var x = 30; // minutes interval
		var times = []; // time array
		var tt = 0; // start time

		// Create times array.
		for (var i=0;tt<24*60; i++) {
			var hh = Math.floor(tt/60);
			var mm = (tt%60);
			// Time added to array.
			times[i] = ('0' + (hh % 12)).slice(-2) + ':' + ('0' + mm).slice(-2);
			// Add 30 minutes to time.
			tt = tt + x;
		}

		// Delivery date is today.
		if (today === chosenDate) {

			var deliveryTimes = dtwc_settings.deliveryTimes;
			var result = [];

			for(var t in deliveryTimes){
				result.push(deliveryTimes[t]);
			}

			// Loop through times.
			result.forEach(dateCheck);
		}

		// Chosen date is AFTER today.
		if (today < chosenDate) {

			var deliveryTimes = dtwc_settings.deliveryTimes;
			var result = [];

			for(var t in deliveryTimes) {
				result.push(deliveryTimes[t]);
			}

			// Loop through times.
			result.forEach(resetTimes);
		}

		// Prep time check.
		function dateCheck(item) {
			// Update delivery times if selected date is today.
			if (item<=dtwc_settings.prepTime) {
				// Remove specific time from available options.
				$("#dtwc_delivery_time option[value='" + item + "']").hide();
			} else {
				// Add specific times to available options.
				$("#dtwc_delivery_time option[value='" + item + "']").show();
			}
		}

		// Delivery times reset.
		function resetTimes(item) {
			$("#dtwc_delivery_time option[value='" + item + "']").show();
		}

	});
});
