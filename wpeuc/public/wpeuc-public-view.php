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

	<table id="wpeuc_table" class="wpeuc-calc-table">
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
						(<a id="pr_<?php echo $c; ?>" href="javascript:void(0);">edit</a>)
					</div>
					<input type="number" step="0.01" id="custom_pr_<?php echo $c; ?>" value="<?php echo $appliance->power_rating; ?>">
				</td>

				<td>
					<div id="default_adu_<?php echo $c; ?>">
						<span><?php echo $appliance->average_daily_usage; ?></span> &nbsp;
						(<a id="adu_<?php echo $c; ?>" href="javascript:void(0);">edit</a>)
					</div>
					<input type="number" step="0.01" id="custom_adu_<?php echo $c; ?>" value="<?php echo $appliance->average_daily_usage; ?>">
				</td>

				<td>
					<input type="number" step="0.01" id="quantity_<?php echo $c; ?>" value="0">
				</td>

		<?php
				echo "</tr>";
				$c++;
			}
		?>
	</table>

	<div id="resultArea">
		<h1 id="result">0 KWH</h1>
		<div><button id="calculate" class="btn btn-primary btn-lg">Calculate Energy Usage</button></div>
	</div>
</div>