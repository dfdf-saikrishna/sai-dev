<div class="postbox">
    <div class="inside">
        <div class="wrap pre-travel-request" id="wp-erp">
            <h2><?php _e( 'Pre Travel Expense Request', 'employee' ); ?></h2>
            <code class="description">ADD Request</code>
            <!-- Messages -->
            <div style="display:none" id="failure" class="notice notice-error is-dismissible">
            <p id="p-failure"></p>
            </div>

            <div style="display:none" id="notice" class="notice notice-warning is-dismissible">
                <p id="p-notice"></p>
            </div>

            <div style="display:none" id="success" class="notice notice-success is-dismissible">
                <p id="p-success"></p>
            </div>

            <div style="display:none" id="info" class="notice notice-info is-dismissible">
                <p id="p-info"></p>
            </div>
            
            <table class="wp-list-table widefat fixed striped admins" border="1" id="table1">
                  <thead class="cf">
                    <tr>
                      <th>Date</th>
                      <th >Expense Description</th>
                      <th colspan="2">Expense Category</th>
                      <th >Place</th>
                      <th>Estimated Cost</th>
                      <th >Get Quote</th>
                    </tr>
                  </thead>
                  <tbody <?php /*?>align="center"<?php */?>>
                    <tr>
                      <td data-title="Date" class=""><input name="txtDate[]" id="txtDate1" class="erp-leave-date-field" placeholder="dd/mm/yyyy" autocomplete="off"/>
                      <input name="txtStartDate[]" id="txtStartDate1" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate1" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" />
                      <input type="text" name="textBillNo[]" id="textBillNo1" autocomplete="off"  class="" style="width:105px; display:none;" value="n/a"/>
                      </td>
                      <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc1" class="" autocomplete="off"></textarea><input type="text" class="" name="txtdist[]" id="txtdist1" autocomplete="off" style="display:none;" value="n/a"/></td>
                      <td data-title="Category"><select name="selExpcat[]" id="selExpcat1" class="" onchange="javascript:getMotPreTravel(this.value,1)">
                          <option value="">Select</option>
                         
                        </select></td>
                      <td data-title="Category"><span id="modeoftr1acontent">
                        <select name="selModeofTransp[]"  id="selModeofTransp1" class="" onchange="setFromTo(this.value, 1);">
                          <option value="">Select</option>
                          
                        </select>
                        </span></td>
                      <td data-title="Place"><span id="city1container">
                        <input  name="from[]" id="from1" type="text" placeholder="From" class="">
                        <input  name="to[]" id="to1" type="text" placeholder="To" class="">
                        </span></td>
                      <td data-title="Estimated Cost"> <span id="cost1container">
                        <input type="text" class="" name="txtCost[]" id="txtCost1" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" autocomplete="off"/>
                        </span></td>
                      <td data-title="Get Quote"><button type="button" name="getQuote" id="getQuote1" class="button button-primary" onclick="getQuotefunc(1)">Get Quote</button></td>
                    </tr>
                  </tbody>
                </table>

        </div>
    </div>
    
</div>
