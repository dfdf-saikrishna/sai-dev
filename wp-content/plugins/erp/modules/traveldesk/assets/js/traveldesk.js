/* jshint devel:true */
/* global wpErpHr */
/* global wp */

;(function($) {
    'use strict';

    var WeDevs_ERP_TRAVELDESK = {
        
        /**
         * Initialize the events
         *
         * @return {void}
         */
        initialize: function() {

            // Travel Desk
            $( 'body' ).on( 'change', '#select_emp', this.travelDesk.view );
            $( 'body' ).on( 'change', '#select_emp_withappr', this.travelDesk.withApprView );
            $( '.travel-desk-request').on( 'submit', '#traveldesk_request', this.travelDesk.createRequest );
            $( '.travel-desk-request').on( 'click', '#add-traveldesk-requestappr', this.travelDesk.addRowappr );
            $( '.travel-desk-request').on( 'click', '#add-traveldesk-request', this.travelDesk.addRow );
            $( 'body').on( 'click', 'span#remove-traveldesk-request', this.travelDesk.removeRow );
            
            

            this.initTipTip();

            // this.employee.addWorkExperience();
        },

        initTipTip: function() {
            $( '.erp-tips' ).tipTip( {
                defaultPosition: "top",
                fadeIn: 100,
                fadeOut: 100
            } );
        },

        initDateField: function() {
            $( '.erp-date-field').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: '-100:+0',
            });
        },

        reloadPage: function() {
            $( '.erp-area-left' ).load( window.location.href + ' #erp-area-left-inner', function() {
                $('.select2').select2();
            } );
        },
        
        travelDesk : {
            addRowappr: function(){
                var optionsCat;
                var optionsMode;
                 wp.ajax.send( 'get-exp-cat', {
                    success: function(category) {
                        wp.ajax.send( 'get-mode', {
                            success: function(mode) {
                            
                                $.each( category, function( index, value ){
                                    //console.log(value);
                                    optionsCat += '<option value="'+value.EC_Id+'">'+value.EC_Name+'</option>';
                                });
                                $.each( mode, function( index, value ){
                                    //console.log(value);
                                    optionsMode += '<option value="'+value.MOD_Id+'">'+value.MOD_Name+'</option>';
                                });
                                var rowCount = $('#traveldesk_request tr').length;
                                $('#hidrowno').val(rowCount);
                                $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-traveldesk-request" class="dashicons dashicons-dismiss red"></span></a>');
                                $('#traveldesk_request tr').last().after('<tr>\n\
                                <td data-title="Date"><input name="txtDate[]" id="txtDate'+rowCount+'" class="erp-leave-date-field" placeholder="dd/mm/yyyy" autocomplete="off"></td>\n\
                                <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc'+rowCount+'" class="" autocomplete="off"></textarea></td>\n\
                                <td data-title="Category"><select name="selExpcat[]"  id="selExpcat'+rowCount+'" class=""><option value="">Select</option>'+optionsCat+'\n\
                                <td data-title="Category"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'\n\
                                <td data-title="Place"><input  name="from[]" id="from'+rowCount+'" type="text" placeholder="From" class=""><input  name="to[]" id="to1" type="text" placeholder="To" class=""></td>\n\
                                <td data-title="Estimated Cost"><input type="text" class="" name="txtCost[]" id="txtCost'+rowCount+'" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" autocomplete="off"/></br><span class="red" id="show-exceed"></span></td>\n\
                                <td data-title="Get Quote"><button type="button" name="getQuote" id="getQuote1'+rowCount+'" class="button button-primary" onclick="getQuotefunc(1)">Get Quote</button></td></tr>');
                                $( '.erp-leave-date-field' ).datepicker({
                                    dateFormat: 'dd-mm-yy',
                                    changeMonth: true,
                                    changeYear: true
                                });
                            },
                            error: function(error) {
                                console.log( error );
                            }
                         });
                    },
                    error: function(error) {
                        console.log( error );
                    }
                 });
                 
                 
            },
            addRow: function(){
                var optionsCat;
                var optionsMode;
                 wp.ajax.send( 'get-exp-cat', {
                    success: function(category) {
                        wp.ajax.send( 'get-mode', {
                            success: function(mode) {
                            
                                $.each( category, function( index, value ){
                                    //console.log(value);
                                    optionsCat += '<option value="'+value.EC_Id+'">'+value.EC_Name+'</option>';
                                });
                                $.each( mode, function( index, value ){
                                    //console.log(value);
                                    optionsMode += '<option value="'+value.MOD_Id+'">'+value.MOD_Name+'</option>';
                                });
                                var rowCount = $('#table-pre-travel tr').length;
                                $('#hidrowno').val(rowCount);
                                $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-traveldesk-request" class="dashicons dashicons-dismiss red"></span></a>');
                                $('#traveldesk_request tr').last().after('<tr>\n\
                                <td data-title="Date"><input name="txtDate[]" id="txtDate'+rowCount+'" class="erp-leave-date-field" placeholder="dd/mm/yyyy" autocomplete="off"></td>\n\
                                <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc'+rowCount+'" class="" autocomplete="off"></textarea></td>\n\
                                <td data-title="Category"><select name="selExpcat[]"  id="selExpcat'+rowCount+'" class=""><option value="">Select</option>'+optionsCat+'\n\
                                <td data-title="Category"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'\n\
                                <td data-title="Place"><input  name="from[]" id="from'+rowCount+'" type="text" placeholder="From" class=""><input  name="to[]" id="to1" type="text" placeholder="To" class=""></td>\n\
                                <td data-title="Estimated Cost"><input type="text" class="" name="txtCost[]" id="txtCost'+rowCount+'" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" autocomplete="off"/></br><span class="red" id="show-exceed"></span></td>\n\
                                <td><input type="file" name="file[]" id="file" multiple="true"></td></tr>');
                                $( '.erp-leave-date-field' ).datepicker({
                                    dateFormat: 'dd-mm-yy',
                                    changeMonth: true,
                                    changeYear: true
                                });
                            },
                            error: function(error) {
                                console.log( error );
                            }
                         });
                    },
                    error: function(error) {
                        console.log( error );
                    }
                 });
                 
                 
            },
            removeRow: function(){
                var rowCount = $('#traveldesk_request tr').length;
                if(rowCount==3){
                    $('#traveldesk_request tr:last').remove();
                    $('#removebuttoncontainer').html('');
                }
                else if(rowCount>2){
                $('#traveldesk_request tr:last').remove();
                }
                
            },
            view: function() {
                var val = $(this).val();
                if(val == 0){
                    $('#emp_details').slideUp();
                }else{
                    window.location.replace("/wp-admin/admin.php?page=Request-Without-Approval&selEmployees="+val);
                }
                
            },
            withApprView: function() {
                var val = $(this).val();
                if(val == 0){
                    $('#emp_details').slideUp();
                }else{
                    window.location.replace("/wp-admin/admin.php?page=Request-With-Approval&selEmployees="+val);
                }
            },
           createRequest: function(e){
               e.preventDefault();
                $('.erp-loader').show();
                $('#submit-traveldesk-request').addClass('disabled');
                wp.ajax.send( 'traveldesk_request_create', {
                      data: $(this).serialize(),
                    success: function(resp) {
                        console.log("successsssssss"); 
                        console.log(resp);
                        
                        $('.erp-loader').hide();
                        $('#submit-traveldesk-request').removeClass('disabled');
                        switch(resp.status){
                            case 'info':
                                $('#p-info').html(resp.message);
                                $('#info').show();
                                $("#info").delay(5000).slideUp(200);
                                break;
                            case 'notice':
                                $('#p-notice').html(resp.message);
                                $('#notice').show();
                                $("#notice").delay(5000).slideUp(200);
                                break;
                            case 'success':
                                $('#p-success').html(resp.message);
                                $('#success').show();
                                $("#success").delay(5000).slideUp(200);
                                break;
                            case 'failure':
                                $('#p-failure').html(resp.message);
                                $('#failure').show();
                                $("#failure").delay(5000).slideUp(200);
                                break;
                        }
                    },
                    error: function(error) {
                        console.log("failure");
                        console.log( error );
                    }
                });
           },
        },
  
    };

    $(function() {
        WeDevs_ERP_TRAVELDESK.initialize();
    });
})(jQuery);
