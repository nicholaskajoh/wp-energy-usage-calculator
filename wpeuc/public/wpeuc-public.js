(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	// ENERGY USAGE CALCULATOR
	var calc_table_rows = $('#wpeuc_table tr').length - 1; // -1 for header tr

	// hide all inputs
	for(var i = 1; i <= calc_table_rows; i++) {
		$('#custom_pr_'+i).hide(); // power rating
		$('#custom_adu_'+i).hide(); // average daily usage
	};

	// make a value editable
	$('a').on('click', function() {
		var id = $(this).attr("id");
		$('#default_'+id).hide();
		$('#custom_'+id).show();
	});

	// total power consumption/energy usage
	$('#calculate').on('click', function() {
		var total = 0;
		for(var i = 1; i <= calc_table_rows; i++) {
			var pr = parseFloat($('#custom_pr_'+i).val());
			var adu = parseFloat($('#custom_adu_'+i).val());
			var qty = parseFloat($('#quantity_'+i).val());
			var e = (pr*adu*30*qty)/1000;
			total += e;
		};
		$('#result').html(total+" KWH");
	});

})( jQuery );
