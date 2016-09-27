<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://github.com/nicholaskajoh/wp-energy-usage-calculator
 * @since      0.1.0
 *
 * @package    WP Energy Usage Calculator
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h2 class="wpeuc_name"><?php echo $this->calc_name; ?></h2>

<p class="wpeuc_desc"><?php echo $this->calc_desc; ?></p>

<p class="wpeuc_instructions"><?php echo $this->calc_instructions; ?></p>

<?php $myAppliances = $this->get_appliances(); ?>

<table id="wpeuc_table" class="wpeuc_calc_table">
	<tr>
		<th>Appliance</th>
		<th>Power Rating (Watts)</th>
		<th>Average Daily Usage (Hours)</th>
		<th>Quantity</th>
	</tr>
	<?php
		$c = 1; // count 
		foreach ($myAppliances as $appliance) {
			echo "<tr>";
			echo "<td>{$appliance->appliance_name}</td>";
	?>
			<td>
				<div id="default_pr_<?php echo $c; ?>">
					<span><?php echo $appliance->power_rating; ?></span> &nbsp;
					<a id="pr_<?php echo $c; ?>" href="javascript:void(0);">Edit</a>
				</div>
				<input type="number" id="custom_pr_<?php echo $c; ?>" value="<?php echo $appliance->power_rating; ?>">
			</td>

			<td>
				<div id="default_adu_<?php echo $c; ?>">
					<span><?php echo $appliance->average_daily_usage; ?></span> &nbsp;
					<a id="adu_<?php echo $c; ?>" href="javascript:void(0);">Edit</a>
				</div>
				<input type="number" id="custom_adu_<?php echo $c; ?>" value="<?php echo $appliance->average_daily_usage; ?>">
			</td>

			<td>
				<input type="number" id="quantity_<?php echo $c; ?>" value="0">
			</td>

	<?php
			echo "</tr>";
			$c++;
		}
	?>
</table>

<div id="resultArea">
	<h1 id="result">0 KWH</h1>
	<div><button id="calculate">Calculate Energy Usage</button></div>
</div>