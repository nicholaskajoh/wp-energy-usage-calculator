/**
 * Public Js.
 */
 
(function($) {
  'use strict';

  var num_of_appliances = appliances_data.length; // from DB
  var r_id = 0; // row identifier

  // start
  // add initial row
  add_row();

  // for subsequent rows
  $('#add_row').on('click', function() {
    add_row();
  });

  // remove row
  $('#remove_row').on('click', function() {
    remove_row();
  });

  // change values of power rating and average daily usage accordingly when appliance is changed
  $('#wpeuc_table').on('change', 'select.form-control', function() {
    var _id = $(this).attr('id');
    var _val = $(this).val();

    // adjust power rating and average daily usage
    appliances_data.forEach(function(appl) {
      if(appl.id == _val) {
        $('#pr'+_id).val(appl.power_rating);
        $('#adu'+_id).val(appl.average_daily_usage);
      }
    });
  });

  // calculate total energy consumption
  $('#calculate').on('click', function() {
    var num_calc_table_rows = $('#wpeuc_table tr').length - 1; // -1 for header tr
    var total = 0; // kwh
    // run through all the rows and compute energy for each; add to total
    for(var i = 1; i <= num_calc_table_rows; i++) {
      var pr = parseFloat($('#pr_'+i).val());
      var adu = parseFloat($('#adu_'+i).val());
      var qty = parseFloat($('#qty_'+i).val());
      var e = (pr*adu*30*qty)/1000;
      total += e;
    };
    // result; to 2 dp
    $('#result').html(total.toFixed(2) + " kWh");
  });


  /*
   * FUNCTIONS
   */

  // add a new row to the table
  function add_row() {
    r_id++; // for current row being created

    // define a row of the calculator which holds info concerning a given appliance
    var row = "";

    // start tr
    row += '<tr id="appl_' + r_id + '">';
    // appliance select box
    row += '<td><select id="_' + r_id + '" class="form-control">';
    for(var i = 0; i < num_of_appliances; i++) {
      row += '<option value="' + appliances_data[i].id + '">' + appliances_data[i].appliance_name + '</option>';
    }
    row += '</select></td>';
    // power rating input
    row += '<td><input id="pr_' + r_id + '" class="form-control" type="number" step="0.01" value="' + appliances_data[0].power_rating + '"></td>';
    // average daily usage input
    row += '<td><input id="adu_' + r_id + '" class="form-control" type="number" step="0.01" value="' + appliances_data[0].average_daily_usage + '"></td>';
    // quantity input
    row += '<td><input id="qty_' + r_id + '" class="form-control" type="number" step="1" value="0"></td>';
    // end tr
    row += '</tr>';

    // add to calculator table
    $('#wpeuc_table').append(row);
  }

  // remove the last row from the table
  function remove_row() {
    if(r_id > 1) { 
      $('#appl_'+r_id).remove();
      r_id--;
    }
  }

})(jQuery);
