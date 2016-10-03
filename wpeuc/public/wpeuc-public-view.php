<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://github.com/nicholaskajoh/wp-energy-usage-calculator
 * @since      0.1.0
 * @package    WP Energy Usage Calculator
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wpeuc-calc-container">
	<!-- calculator display name -->
	<div class="wpeuc-name"><?php echo $this->calc_name; ?></div>
	<!-- calculator description -->
	<div class="wpeuc-desc"><?php echo $this->calc_desc; ?></div>
	<!-- instructions for use -->
	<?php if($this->calc_instructions !== ""): ?>
		<div class="wpeuc_instructions wpeuc-alert wpeuc-alert-info"><?php echo $this->calc_instructions; ?></div>
	<?php endif; ?>

	<?php $myAppliances = $this->get_appliances(); // get all appliances in DB ?>

	<!-- calculator table -->
	<table id="wpeuc_table" class="wpeuc-calc-table">
		<tr>
			<th>Appliance</th>
			<th>Power Rating (Watts)</th>
			<th>Average Daily Usage (Hours)</th>
			<th>Quantity</th>
		</tr>
	</table>
	<button id="add_row" class="btn btn-success btn-sm">Add</button>
	<button id="remove_row" class="btn btn-danger btn-sm">Remove</button>

	<div id="resultArea">
		<h1 id="result">0.00 kWh</h1>
		<div><button id="calculate" class="btn btn-primary btn-lg">Calculate Energy Usage</button></div>
	</div>
</div>

<!-- hand appliances over to js -->
<script type="text/javascript">
	var appliances_data = <?php echo json_encode($myAppliances); ?>
</script>