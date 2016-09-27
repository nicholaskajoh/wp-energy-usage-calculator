<?php

/**
 * Provide a admin-facing view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://github.com/nicholaskajoh/wp-energy-usage-calculator
 * @since      0.1.0
 *
 * @package    WP Energy Usage Calculator
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php $this->admin_add_appliance(); // add new appliance form processing ?>
<?php $this->admin_edit_appliance(); // edit appliance form processing ?>
<?php $this->admin_delete_appliance(); // delete appliance form processing ?>

<h1><?php echo self::PLUGIN_NAME ?></h1>
<p class="notice notice-info wpeuc-notice">Add this calculator to any page or post with the short code: <strong>[wpeuc]</strong></p>

<!-- Calculator settings -->
<form method="post" action="options.php">
	<?php settings_errors('wpeuc_settings'); ?>
	<?php settings_fields('wpeuc_settings'); ?>
	<?php do_settings_sections($this->settings_page); ?>
	<?php submit_button(); ?>
</form>

<h2>Import</h2>
<p class="notice notice-info wpeuc-notice"> Feeling lazy? Import a ready-to-use list of appliances! Don't worry, you can edit them to suit your needs.</p>
<p class="notice notice-warning wpeuc-notice"> Import should be carried out once. Multiple imports would make for repeated appliance data in your calculator.</p>
<p><button class="button button-primary">Import</button></p>

<h2>Appliances</h2>
<p>Add appliance</p>
<form method="post" action="">
	<label>Appliance name: </label>
	<input type="text" name="appliance_name" value="">
	<label>Power Rating (Watts): </label>
	<input type="number" name="power_rating" value="">
	<label>Average Daily Usage (Hours): </label>
	<input type="number" name="average_daily_usage" value="">
	<input class="button button-primary" name="add_appliance" type="submit" value="Add">
</form>

<?php $myAppliances = $this->get_appliances(); ?>

<table class="wpeuc_admin_table">
	<tr>
		<th>Appliance</th>
		<th>Power Rating (Watts)</th>
		<th>Average Daily Usage (Hours)</th>
		<th>Edit/Delete</th>
	</tr>
	<?php
		$c = 1; // count 
		foreach ($myAppliances as $appliance) {
	?>
			<tr>
				<form method="post" action="">
					<td>
						<input type="text" name="appliance_name" value="<?php echo $appliance->appliance_name; ?>">
					</td>

					<td>
						<input type="number" name="power_rating" value="<?php echo $appliance->power_rating; ?>">
					</td>

					<td>
						<input type="number" name="average_daily_usage" value="<?php echo $appliance->average_daily_usage; ?>">
					</td>

					<td>
						<input type="hidden" name="id" value="<?php echo $appliance->id; ?>">
						<input class="button button-primary" type="submit" name="edit_appliance" value="Save">
						<input class="button wpeuc-delete" type="submit" name="delete_appliance" value="Delete">
					</td>
				</form>
			</tr>
	<?php
		$c++;
	}
?>
</table>
