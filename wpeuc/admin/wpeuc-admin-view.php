<?php

/**
 * Provide a admin-facing view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://github.com/nicholaskajoh/wp-energy-usage-calculator
 * @since      0.1.0
 * @package    WP Energy Usage Calculator
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="bootstrap-wrapper">
  <div class="container">
    <?php $this->admin_add_appliance(); // add new appliance form processing ?>
    <?php $this->admin_edit_appliance(); // edit appliance form processing ?>
    <?php $this->admin_delete_appliance(); // delete appliance form processing ?>

    <h1><?php echo self::PLUGIN_NAME ?></h1>
    <p class="alert alert-info">Add this calculator to any page or post with the short code: <strong>[wpeuc]</strong></p>

    <!-- Calculator settings -->
    <form method="post" action="options.php">
      <?php settings_errors('wpeuc_settings'); ?>
      <?php settings_fields('wpeuc_settings'); ?>
      <?php do_settings_sections($this->settings_page); ?>
      <div class="pull-right">
        <input type="submit" name="submit" id="submit" class="btn btn-lg btn-success" value="Save">
      </div>
    </form>
    <!-- #Calculator settings -->

    <!-- Appliances -->
    <h2>Appliances</h2>
    <p>Add appliance</p>
    <form class="form-inline" method="post" action="">
      <label>Appliance name: </label>
      <input class="form-control" type="text" name="appliance_name" value="">
      <label>Power Rating (Watts): </label>
      <input class="form-control" type="number" step="0.01" name="power_rating" value="">
      <label>Average Daily Usage (Hours): </label>
      <input class="form-control" type="number" step="0.01" name="average_daily_usage" value="">
      <input class="btn btn-primary" name="add_appliance" type="submit" value="Add">
    </form>

    <?php $myAppliances = $this->get_appliances(); ?><br>

    <table class="table table-bordered table-striped">
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
                <input class="form-control" type="text" name="appliance_name" value="<?php echo $appliance->appliance_name; ?>">
              </td>

              <td>
                <input class="form-control" type="number" step="0.01" name="power_rating" value="<?php echo $appliance->power_rating; ?>">
              </td>

              <td>
                <input class="form-control" type="number" step="0.01" name="average_daily_usage" value="<?php echo $appliance->average_daily_usage; ?>">
              </td>

              <td>
                <input class="form-control" type="hidden" name="id" value="<?php echo $appliance->id; ?>">
                <input class="btn btn-success" type="submit" name="edit_appliance" value="Save">
                <input class="btn btn-danger" type="submit" name="delete_appliance" value="Delete">
              </td>
            </form>
          </tr>
      <?php
        $c++;
      }
    ?>
    </table>
    <!-- #Appliances -->
  </div>  
</div>