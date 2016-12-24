/* jshint devel:true */
/* global wpErpHr */
/* global wp */

;(function($) {
    'use strict';

    var WeDevs_CRP_EMP = {

        /**
         * Initialize the events
         *
         * @return {void}
         */
        initialize: function() {
     
            // Travel Requests
            $( '.pre-travel-request' ).on( 'click', '#reset', this.travelRequest.reset );
            $( '.pre-travel-request').on( 'submit', '#request_form', this.travelRequest.create );
            $( '.pre-travel-request').on( 'submit', '#request_edit_form', this.travelRequest.edit );
            $( '.pre-travel-request').on( 'click', '#deleteRowbutton', this.travelRequest.delete );
            $( 'body').on( 'click', '#post-emp-chat', this.travelRequest.createChatMsg );
            $( 'body').on( 'click', 'span#add-row-pretravel-edit', this.travelRequest.addRowEdit );
            $( 'body').on( 'click', 'span#add-row-pretravel', this.travelRequest.addRow );
            $( 'body').on( 'click', 'span#add-row-posttravel', this.travelRequest.addRowPost );
            $( 'body').on( 'click', 'span#add-row-mileage', this.travelRequest.addRowMileage );
            $( 'body').on( 'click', 'span#add-row-utility', this.travelRequest.addRowUtility );
            $( 'body').on( 'click', 'span#add-row-others', this.travelRequest.addRowOthers );
            
            $( 'body').on( 'click', 'span#add-row-posttravel-edit', this.travelRequest.addRowPostEdit );
            $( 'body').on( 'click', 'span#add-row-mileage-edit', this.travelRequest.addRowMileageEdit );
            $( 'body').on( 'click', 'span#add-row-utility-edit', this.travelRequest.addRowUtilityEdit );
            $( 'body').on( 'click', 'span#add-row-others-edit', this.travelRequest.addRowOthersEdit );
            
            $( 'body').on( 'click', 'span#remove-row-pretravel', this.travelRequest.removeRow );
            $( 'body').on( 'click', 'span#remove-row-posttravel', this.travelRequest.removeRowPost );
            $( 'body').on( 'click', 'span#remove-row-mileage', this.travelRequest.removeRowMileage );
            $( 'body').on( 'click', 'span#remove-row-utility', this.travelRequest.removeRowUtility );
            $( 'body').on( 'click', 'span#remove-row-others', this.travelRequest.removeRowOthers );
            $( 'body').on( 'click', 'a#subApprove', this.travelRequest.subApprove );
            $( 'body').on( 'click', 'a#submitApprove', this.travelRequest.submitApprove );
            
            //Booking
            $( 'body').on( 'click', '#bookTickets', this.booking.tickets );
            $( 'body').on( 'click', '#buttonSelfbooking', this.booking.selfBooking );
            $( 'body').on( 'click', '#cancelTickets', this.booking.cancelBooking );
            
            //Delegate
            $( 'body').on( 'submit', '#addDelegate', this.delegate.create );
            $( 'body').on( 'submit', '#updDelegate', this.delegate.edit );
            
            // handle postbox toggle
            $('body').on( 'click', 'div.handlediv', this.handleToggle );
            
            
            // Dasboard Overview
            $( 'ul.erp-dashboard-announcement' ).on( 'click', 'a.mark-read', this.dashboard.markAnnouncementRead );
            $( 'ul.erp-dashboard-announcement' ).on( 'click', 'a.view-full', this.dashboard.viewAnnouncement );
            $( 'ul.erp-dashboard-announcement' ).on( 'click', '.announcement-title a', this.dashboard.viewAnnouncementTitle );

            // Department
            $( 'body' ).on( 'click', 'a#erp-new-dept', this.department.create );
            $( '.erp-hr-depts' ).on( 'click', 'a.submitdelete', this.department.remove );
            $( '.erp-hr-depts' ).on( 'click', 'span.edit a', this.department.edit );

            // Designation
            $( 'body' ).on( 'click', 'a#erp-new-designation', this.designation.create );
            $( '.erp-hr-designation' ).on( 'click', 'a.submitdelete', this.designation.remove );
            $( '.erp-hr-designation' ).on( 'click', 'span.edit a', this.designation.edit );
            
            // Company Admin
            $( 'body' ).on( 'click', 'a#companyadmin-new', this.companyAdmin.create );
            $( '.erp-hr-companyadmin' ).on( 'click', 'span.edit a', this.companyAdmin.edit );
            $( '.erp-hr-companyadmin' ).on( 'click', 'span.delete a', this.companyAdmin.remove );           

            // Trigger
            $('body').on( 'erp-hr-after-new-dept', this.department.afterNew );
            $('body').on( 'erp-hr-after-new-desig', this.designation.afterNew );

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
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                yearRange: '-100:+0',
            });
        },
        
        /**
         * Handle postbox toggle effect
         *
         * @param  {object} e
         *
         * @return {void}
         */
        handleToggle: function(e) {
            e.preventDefault();
            var self = $(this),
                postboxDiv = self.closest('.postbox');

            if ( postboxDiv.hasClass('closed') ) {
                postboxDiv.removeClass('closed');
            } else {
                postboxDiv.addClass('closed');
            }
        },

        reloadPage: function() {
            $( '.erp-area-left' ).load( window.location.href + ' #erp-area-left-inner', function() {
                $('.select2').select2();
            } );
        },
        delegate : {
            create: function(e){
                e.preventDefault();
                wp.ajax.send( 'create-delegate', {
                      data: $(this).serialize(),
                    success: function(resp) {
                        console.log("success"); 
                        console.log(resp);
                        $('.erp-loader').hide();
                        $('#submit-pre-travel-request').removeClass('disabled');
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
            edit: function(e){
                e.preventDefault();
                wp.ajax.send( 'edit-delegate', {
                      data: $(this).serialize(),
                    success: function(resp) {
                        console.log("success"); 
                        console.log(resp);
                        $('.erp-loader').hide();
                        $('#submit-pre-travel-request').removeClass('disabled');
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
        booking : {
            selfBooking: function(){
                var atLeastOneIsChecked = $('input[name="rdid[]"]:checked').length > 0;
	
                if(!atLeastOneIsChecked)
                {
                        alert("Please check atlease one ticket to set as self book.");
                        return false;
                }
                else{

                        if(confirm("If these details has been sent to travel desk for booking & not yet cancelled, then tickets will be automatically cancelled and these details will be duplicated & updated with self booking.")){
                                return true;	
                        }else{
                                return false;	
                        }


                }
            },
            tickets: function() {
                var atLeastOneIsChecked = $('input[name="rdid[]"]:checked').length > 0;

                if(!atLeastOneIsChecked)
                {
                    alert("Please check atlease one ticket to book.");
                    return false;
                }
                if(confirm("Are you sure want the travel desk to book the tickets ?"))
                    return true;
                else
                    return false;
                
            },
            cancelBooking: function() {
                var atLeastOneIsChecked = $('input[name="rdid[]"]:checked').length > 0;
	
                if(!atLeastOneIsChecked)
                {
                        alert("Please check atlease one ticket to cancel");
                        return false;
                        }
                        else
                        {
                                var rdids = [];
                                $("input[name='rdid[]']:checked").each(function() {
                                  rdids.push($(this).val());
                                });
                        }									


                if(confirm("Are you sure to cancel these tickets"))
                return true;
                else 
                return false;
            }
        },
        travelRequest : {
           
            reset: function() {
                console.log("test");
                $('#request_form')[0].reset();
            },
            subApprove: function(e){
              e.preventDefault();
              var self = $(this);
              wp.ajax.send( 'approve-request', {
                    data: {
                        et    : $('#et').val(),
                        empid : $('#emp_id').val(),
                        req_id : $('#req_id').val(),
                        req_id_table: self.data( 'id' ),
                    },
                    success: function(resp) {
                        console.log(resp);
                        //$( 'body' ).load( window.location.href + '.pre-travel-request' );
                        switch(resp.status){
                            case 'success':
                                $('#p-success').html(resp.message);
                                $('#success').show();
                                $("#success").delay(5000).slideUp(200);
                                break;
                        }
                    },
                    error: function(error) {
                        console.log( error );
                    }
                });
              
              
              //alert(reqid);
            },
            submitApprove: function(e){
              e.preventDefault();
              wp.ajax.send( 'approve-finance-request', {
                    data: {
                        et    : $('#et').val(),
                        empid : $('#emp_id').val(),
                        req_id : $('#req_id').val(),
                    },
                    success: function(resp) {
                        console.log(resp);
                        $( 'body' ).load( window.location.href + '.pre-travel-request' );
                        switch(resp.status){
                            case 'success':
                                $('#p-success').html(resp.message);
                                $('#success').show();
                                $("#success").delay(5000).slideUp(200);
                                break;
                        }
                    },
                    error: function(error) {
                        console.log( error );
                    }
                });
              
              
              //alert(reqid);
            },
            addRowEdit: function(){
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
                                $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-row-pretravel" class="dashicons dashicons-dismiss red"></span></a>');
                                $('#table-pre-travel tr').last().after('<tr>\n\
                                <td data-title="Date"><input name="txtDate[]" id="txtDate'+rowCount+'" class="pretraveldate" placeholder="dd/mm/yyyy" autocomplete="off"><input name="txtStartDate[]" id="txtStartDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /></td>\n\
                                <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc'+rowCount+'" class="" autocomplete="off"></textarea><input type="text" class="" name="txtdist[]" id="txtdist'+rowCount+'" autocomplete="off" style="display:none;" value="n/a"/><input type="text" name="textBillNo[]" id="textBillNo'+rowCount+'" autocomplete="off"  class="" style="width:105px; display:none;" value="n/a"/></td>\n\
                                <td data-title="Category"><select name="selExpcat[]" onchange="javascript:getMotPreTravel(this.value,'+rowCount+')" id="selExpcat'+rowCount+'" class=""><option value="">Select</option>'+optionsCat+'\n\
                                <td data-title="Category"><span id="modeoftr'+rowCount+'acontent"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'\n\
                                <td data-title="Place"><span id="city'+rowCount+'container"><input  name="from[]" id="from'+rowCount+'" type="text" placeholder="From" class=""><input  name="to[]" id="to1" type="text" placeholder="To" class=""></span></td>\n\
                                <td data-title="Estimated Cost"><span id="cost'+rowCount+'container"><input type="text" class="" name="txtCost[]" id="txtCost'+rowCount+'" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" autocomplete="off"/></br><span class="red" id="show-exceed"></span></td>\n\
                                <td data-title="Get Quote"><button type="button" name="getQuote" id="getQuote'+rowCount+'" class="button button-primary" onclick="getQuotefunc(1)">Get Quote</button></td>\n\
                                <td><button type="button" value="" class="button button-default" name="deleteRowbutton" id="deleteRowbutton" title="delete row"><i class="fa fa-trash-o"></i></button></td></tr>');
                                $('.pretraveldate').datepicker({
                                    dateFormat: "dd-mm-yy",
                                    minDate: 0,
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
                                $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-row-pretravel" class="dashicons dashicons-dismiss red"></span></a>');
                                $('#table-pre-travel tr').last().after('<tr>\n\
                                <td data-title="Date"><input name="txtDate[]" id="txtDate'+rowCount+'" class="pretraveldate" placeholder="dd/mm/yyyy" autocomplete="off"><input name="txtStartDate[]" id="txtStartDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /></td>\n\
                                <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc'+rowCount+'" class="" autocomplete="off"></textarea><input type="text" class="" name="txtdist[]" id="txtdist'+rowCount+'" autocomplete="off" style="display:none;" value="n/a"/><input type="text" name="textBillNo[]" id="textBillNo'+rowCount+'" autocomplete="off"  class="" style="width:105px; display:none;" value="n/a"/></td>\n\
                                <td data-title="Category"><select name="selExpcat[]" onchange="javascript:getMotPreTravel(this.value,'+rowCount+')" id="selExpcat'+rowCount+'" class=""><option value="">Select</option>'+optionsCat+'\n\
                                <td data-title="Category"><span id="modeoftr'+rowCount+'acontent"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'\n\
                                <td data-title="Place"><span id="city'+rowCount+'container"><input  name="from[]" id="from'+rowCount+'" type="text" placeholder="From" class=""><input  name="to[]" id="to1" type="text" placeholder="To" class=""></span></td>\n\
                                <td data-title="Estimated Cost"><span id="cost'+rowCount+'container"><input type="text" class="" name="txtCost[]" id="txtCost'+rowCount+'" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" autocomplete="off"/></br><span class="red" id="show-exceed"></span></td>\n\
                                <td data-title="Get Quote"><button type="button" name="getQuote" id="getQuote'+rowCount+'" class="button button-primary" onclick="getQuotefunc(1)">Get Quote</button></td></tr>');
                                $('.pretraveldate').datepicker({
                                    dateFormat: "dd-mm-yy",
                                    minDate: 0,
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
            addRowPost: function(){
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
                                var rowCount = $('#table-post-travel tr').length;
                                $('#hidrowno').val(rowCount);
                                $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-row-posttravel" class="dashicons dashicons-dismiss red"></span></a>');
                                $('#table-post-travel tr').last().after('<tr>\n\
                                <td data-title="Date"><input name="txtDate[]" id="txtDate'+rowCount+'" style="width:110px;" class="posttraveldate" placeholder="dd/mm/yyyy" autocomplete="off"><input name="txtStartDate[]" id="txtStartDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input type="text" name="textBillNo[]" id="textBillNo'+rowCount+'" autocomplete="off"  class="" style="display:none;" value="n/a"/><input type="text" class="" name="txtdist[]" id="txtdist'+rowCount+'" autocomplete="off" style="display:none;" value="n/a"/></td>\n\
                                <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc'+rowCount+'" class="" autocomplete="off"></textarea></td>\n\
                                <td data-title="Category"><select name="selExpcat[]" onchange="javascript:getMotPosttravel(this.value,'+rowCount+')" id="selExpcat'+rowCount+'" class=""><option value="">Select</option>'+optionsCat+'\n\
                                <td data-title="Category"><span id="modeoftr'+rowCount+'acontent"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'\n\
                                <td data-title="Place"><span id="city'+rowCount+'container"><input  name="from[]" id="from'+rowCount+'" type="text" placeholder="From" class=""><input  name="to[]" id="to1" type="text" placeholder="To" class=""></td>\n\
                                <td data-title="Estimated Cost"><input type="text" class="" name="txtCost[]" style="width:110px;" id="txtCost'+rowCount+'" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" autocomplete="off"/></br><span class="red" id="show-exceed"></span></td>\n\
                                <td><input type="file" style="width:150px;" name="file'+rowCount+'[]" id="file'+rowCount+'[]" multiple="true"></td>\n\</tr>');
                                $('.posttraveldate').datepicker({
                                    dateFormat: "dd-mm-yy",
                                    maxDate: 'today',
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
            addRowMileage: function(){
                var optionsCat;
                var optionsMode;
                        wp.ajax.send( 'get-mode-mileage', {
                            success: function(mode) {
                                $.each( mode, function( index, value ){
                                    //console.log(value);
                                    optionsMode += '<option value="'+value.MOD_Id+'">'+value.MOD_Name+'</option>';
                                });
                                var rowCount = $('#table-mileage-travel tr').length;
                                $('#hidrowno').val(rowCount);
                                $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-row-mileage" class="dashicons dashicons-dismiss red"></span></a>');
                                $('#table-mileage-travel tr').last().after('<tr>\n\
                                <td data-title="Date"><input name="txtDate[]" id="txtDate'+rowCount+'" style="width:101px;" class="posttraveldate" placeholder="dd/mm/yyyy" autocomplete="off"><input name="txtStartDate[]" id="txtStartDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input type="text" name="textBillNo[]" id="textBillNo'+rowCount+'" autocomplete="off"  class="" style="display:none;" value="n/a"/></td>\n\
                                <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc'+rowCount+'" class="" autocomplete="off"></textarea><select name="selExpcat[]" id="selExpcat'+rowCount+'" class="" style="display:none;"><option value="5">select</option></td>\n\
                                <td data-title="Category"><span id="modeoftr'+rowCount+'acontent"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'\n\
                                <td data-title="City/Location"><span id="city'+rowCount+'container"><input  name="from[]" id="from'+rowCount+'" type="text" placeholder="From" class=""  autocomplete="off"><input  name="to[]" id="to'+rowCount+'" type="text" placeholder="To" class=""  autocomplete="off"></span><select name="selStayDur[]" class="" style="display:none;"><option value="n/a">Select</option>\n\
                                <td data-title="Distance (in km)"><input type="text" style="width:110px;" class="" name="txtdist[]"  id="txtdist'+rowCount+'" onkeyup="return mileageAmount(this.value, '+rowCount+');" autocomplete="off"/></td>\n\
                                <td data-title="Total Cost"> <input type="text" style="width:110px;" class="" name="txtCost[]" id="txtCost'+rowCount+'" readonly="readonly"  autocomplete="off"/></td>\n\
                                <td><input type="file" name="file'+rowCount+'[]" id="file'+rowCount+'[]" style="width:150px;" multiple="true" onchange="Validate(this.id);"></td></tr>');
                                $('.posttraveldate').datepicker({
                                    dateFormat: "dd-mm-yy",
                                    maxDate: 'today',
                                });
                            },
                            error: function(error) {
                                console.log( error );
                            }
                         });
            },
            addRowUtility: function(){
                var optionsMode;
                wp.ajax.send( 'get-mode-utility', {
                    success: function(mode) {
                        $.each( mode, function( index, value ){
                            //console.log(value);
                            optionsMode += '<option value="'+value.MOD_Id+'">'+value.MOD_Name+'</option>';
                        });
                        var rowCount = $('#table-utility-travel tr').length;
                        $('#hidrowno').val(rowCount);
                        $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-row-utility" class="dashicons dashicons-dismiss red"></span></a>');
                        $('#table-utility-travel tr').last().after('<tr>\n\
                        <td data-title="Start Date" class="scrollmsg"><input name="txtStartDate[]" id="txtStartDate'+rowCount+'" class="erp-leave-date-field" style="width:101px;" placeholder="dd/mm/yyyy" autocomplete="off"/><input name="txtDate[]" id="txtDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" style="display:none;" value="n/a"/></td>\n\
                        <td data-title="End Date" class="scrollmsg"><input name="txtEndDate[]" id="txtEndDate'+rowCount+'" class="erp-leave-date-field" style="width:101px;" placeholder="dd/mm/yyyy" autocomplete="off"/></td>\n\
                        <td data-title="Description"><textarea name="txtaExpdesc[]"  cols="16" rows="2"  id="txtaExpdesc'+rowCount+'" class="" autocomplete="off"></textarea><select name="selExpcat[]" id="selExpcat'+rowCount+'" class="" style="display:none;"><option value="6">select</option></select></td>\n\
                        <td data-title="Category"><span id="modeoftr'+rowCount+'acontent"><select name="selModeofTransp[]" style="width:110px;" id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'</td>\n\
                        <td data-title="Bill Number"><input type="text" name="textBillNo[]" style="width:110px;" id="textBillNo'+rowCount+'" autocomplete="off"  class=""/></td>\n\
                        <td data-title="Bill Amount (Rs)"><span id="city1container"><input type="text" style="width:110px;" class="" name="txtCost[]" id="txtCost'+rowCount+'" onkeyup="valCost(this.value);" autocomplete="off"/><input  name="from[]" id="from'+rowCount+'" type="text" style="display:none;" value="n/a" placeholder="From" class=""  autocomplete="off"><input  name="to[]" id="to'+rowCount+'" type="text" placeholder="To" class="" value="n/a" style="display:none;"  autocomplete="off"><select name="selStayDur[]" class="" style="display:none;"><option value="n/a">Select</option></select><input type="text" class="" name="txtdist[]"  id="txtdist'+rowCount+'" style="display:none;width:110px;" value="n/a" autocomplete="off" /></span> </td>\n\
                        <td><input type="file" name="file'+rowCount+'[]" id="file'+rowCount+'[]" multiple="true" style="width:150px;" onchange="Validate(this.id);"></td>\n\</tr>');
                        $('.erp-leave-date-field').datepicker({
                            dateFormat: "dd-mm-yy",
                            changeMonth: true,
                            changeYear: true
                        });
                    },
                    error: function(error) {
                        console.log( error );
                    }
                 });
            },
            addRowOthers: function(){
                var optionsMode;
                wp.ajax.send( 'get-mode-others', {
                    success: function(mode) {
                        $.each( mode, function( index, value ){
                            //console.log(value);
                            optionsMode += '<option value="'+value.MOD_Id+'">'+value.MOD_Name+'</option>';
                        });
                        var rowCount = $('#table-others-travel tr').length;
                        $('#hidrowno').val(rowCount);
                        $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-row-others" class="dashicons dashicons-dismiss red"></span></a>');
                        $('#table-others-travel tr').last().after('<tr>\n\
                        <td data-title="Date" class="scrollmsg"><input name="txtDate[]" id="txtDate'+rowCount+'" class="posttraveldate" placeholder="dd/mm/yyyy"  /><input name="txtStartDate[]" id="txtStartDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" /><input type="text" name="textBillNo[]" id="textBillNo'+rowCount+'" autocomplete="off"  class="" style="display:none;" value="n/a"/></td>\n\
                        <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc'+rowCount+'" class=""></textarea><select name="selExpcat[]" id="selExpcat'+rowCount+'" class="" style="display:none;"><option value="3">select</option></select></td>\n\
                        <td data-title="Category"><span id="modeoftr'+rowCount+'acontent"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'</td>\n\
                        <td data-title="Total Cost"><input  name="from[]" id="city'+rowCount+'" type="text" placeholder="From" class="" value="n/a" style="display:none;"><input  name="to[]" id="city'+rowCount+'" type="text" placeholder="To" class="" value="n/a" style="display:none;"><select name="selStayDur[]" class="" style="display:none;"><option value="n/a">Select</option></select><input type="text" class="" name="txtdist[]"  id="txtdist'+rowCount+'" style="display:none;" value="n/a" autocomplete="off" /><input type="text" class="" name="txtCost[]" id="txtCost'+rowCount+'" onkeyup="valCost(this.value);" autocomplete="off"/></td>\n\
                        <td><input type="file" name="file'+rowCount+'[]" id="file'+rowCount+'[]" multiple="true" onchange="Validate(this.id);"></td>\n\</tr>');
                        $('.posttraveldate').datepicker({
                            dateFormat: "dd-mm-yy",
                            changeMonth: true,
                            changeYear: true
                        });
                    },
                    error: function(error) {
                        console.log( error );
                    }
                 });
            },
            addRowPostEdit: function(){
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
                                var rowCount = $('#table-post-travel tr').length;
                                $('#hidrowno').val(rowCount);
                                $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-row-posttravel" class="dashicons dashicons-dismiss red"></span></a>');
                                $('#table-post-travel tr').last().after('<tr>\n\
                                <td data-title="Date"><input name="txtDate[]" id="txtDate'+rowCount+'" style="width:110px;" class="posttraveldate" placeholder="dd/mm/yyyy" autocomplete="off"><input name="txtStartDate[]" id="txtStartDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input type="text" name="textBillNo[]" id="textBillNo'+rowCount+'" autocomplete="off"  class="" style="display:none;" value="n/a"/><input type="text" class="" name="txtdist[]" id="txtdist'+rowCount+'" autocomplete="off" style="display:none;" value="n/a"/></td>\n\
                                <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc'+rowCount+'" class="" autocomplete="off"></textarea></td>\n\
                                <td data-title="Category"><select name="selExpcat[]" onchange="javascript:getMotPosttravel(this.value,'+rowCount+')" id="selExpcat'+rowCount+'" class=""><option value="">Select</option>'+optionsCat+'\n\
                                <td data-title="Category"><span id="modeoftr'+rowCount+'acontent"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'\n\
                                <td data-title="Place"><span id="city'+rowCount+'container"><input  name="from[]" id="from'+rowCount+'" type="text" placeholder="From" class=""><input  name="to[]" id="to1" type="text" placeholder="To" class=""></td>\n\
                                <td data-title="Estimated Cost"><input type="text" class="" name="txtCost[]" style="width:110px;" id="txtCost'+rowCount+'" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" autocomplete="off"/></br><span class="red" id="show-exceed"></span></td>\n\
                                <td><input type="file" style="width:150px;" name="file'+rowCount+'[]" id="file'+rowCount+'[]" multiple="true"></td>\n\
                                <td><button type="button" value="" class="button button-default" name="deleteRowbutton" id="deleteRowbutton" title="delete row"><i class="fa fa-trash-o"></i></button></td></tr>');
                                $('.posttraveldate').datepicker({
                                    dateFormat: "dd-mm-yy",
                                    maxDate: 'today',
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
            addRowMileageEdit: function(){
                var optionsCat;
                var optionsMode;
                        wp.ajax.send( 'get-mode-mileage', {
                            success: function(mode) {
                                $.each( mode, function( index, value ){
                                    //console.log(value);
                                    optionsMode += '<option value="'+value.MOD_Id+'">'+value.MOD_Name+'</option>';
                                });
                                var rowCount = $('#table-mileage-travel tr').length;
                                $('#hidrowno').val(rowCount);
                                $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-row-mileage" class="dashicons dashicons-dismiss red"></span></a>');
                                $('#table-mileage-travel tr').last().after('<tr>\n\
                                <td data-title="Date"><input name="txtDate[]" id="txtDate'+rowCount+'" style="width:101px;" class="posttraveldate" placeholder="dd/mm/yyyy" autocomplete="off"><input name="txtStartDate[]" id="txtStartDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="width:105px; display:none;" value="n/a" /><input type="text" name="textBillNo[]" id="textBillNo'+rowCount+'" autocomplete="off"  class="" style="display:none;" value="n/a"/></td>\n\
                                <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc'+rowCount+'" class="" autocomplete="off"></textarea><select name="selExpcat[]" id="selExpcat'+rowCount+'" class="" style="display:none;"><option value="5">select</option></td>\n\
                                <td data-title="Category"><span id="modeoftr'+rowCount+'acontent"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'\n\
                                <td data-title="City/Location"><span id="city'+rowCount+'container"><input  name="from[]" id="from'+rowCount+'" type="text" placeholder="From" class=""  autocomplete="off"><input  name="to[]" id="to'+rowCount+'" type="text" placeholder="To" class=""  autocomplete="off"></span><select name="selStayDur[]" class="" style="display:none;"><option value="n/a">Select</option>\n\
                                <td data-title="Distance (in km)"><input type="text" style="width:110px;" class="" name="txtdist[]"  id="txtdist'+rowCount+'" onkeyup="return mileageAmount(this.value, '+rowCount+');" autocomplete="off"/></td>\n\
                                <td data-title="Total Cost"> <input type="text" style="width:110px;" class="" name="txtCost[]" id="txtCost'+rowCount+'" readonly="readonly"  autocomplete="off"/></td>\n\
                                <td><input type="file" name="file'+rowCount+'[]" id="file'+rowCount+'[]" style="width:150px;" multiple="true" onchange="Validate(this.id);"></td>\n\
                                <td><button type="button" value="" class="button button-default" name="deleteRowbutton" id="deleteRowbutton" title="delete row"><i class="fa fa-trash-o"></i></button></td></tr>');
                                $('.posttraveldate').datepicker({
                                    dateFormat: "dd-mm-yy",
                                    maxDate: 'today',
                                });
                            },
                            error: function(error) {
                                console.log( error );
                            }
                         });
            },
            addRowUtilityEdit: function(){
                var optionsMode;
                wp.ajax.send( 'get-mode-utility', {
                    success: function(mode) {
                        $.each( mode, function( index, value ){
                            //console.log(value);
                            optionsMode += '<option value="'+value.MOD_Id+'">'+value.MOD_Name+'</option>';
                        });
                        var rowCount = $('#table-utility-travel tr').length;
                        $('#hidrowno').val(rowCount);
                        $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-row-utility" class="dashicons dashicons-dismiss red"></span></a>');
                        $('#table-utility-travel tr').last().after('<tr>\n\
                        <td data-title="Start Date" class="scrollmsg"><input name="txtStartDate[]" id="txtStartDate'+rowCount+'" class="erp-leave-date-field" style="width:101px;" placeholder="dd/mm/yyyy" autocomplete="off"/><input name="txtDate[]" id="txtDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" style="display:none;" value="n/a"/></td>\n\
                        <td data-title="End Date" class="scrollmsg"><input name="txtEndDate[]" id="txtEndDate'+rowCount+'" class="erp-leave-date-field" style="width:101px;" placeholder="dd/mm/yyyy" autocomplete="off"/></td>\n\
                        <td data-title="Description"><textarea name="txtaExpdesc[]"  cols="16" rows="2"  id="txtaExpdesc'+rowCount+'" class="" autocomplete="off"></textarea><select name="selExpcat[]" id="selExpcat'+rowCount+'" class="" style="display:none;"><option value="6">select</option></select></td>\n\
                        <td data-title="Category"><span id="modeoftr'+rowCount+'acontent"><select name="selModeofTransp[]" style="width:110px;" id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'</td>\n\
                        <td data-title="Bill Number"><input type="text" name="textBillNo[]" style="width:110px;" id="textBillNo'+rowCount+'" autocomplete="off"  class=""/></td>\n\
                        <td data-title="Bill Amount (Rs)"><span id="city1container"><input type="text" style="width:110px;" class="" name="txtCost[]" id="txtCost'+rowCount+'" onkeyup="valCost(this.value);" autocomplete="off"/><input  name="from[]" id="from'+rowCount+'" type="text" style="display:none;" value="n/a" placeholder="From" class=""  autocomplete="off"><input  name="to[]" id="to'+rowCount+'" type="text" placeholder="To" class="" value="n/a" style="display:none;"  autocomplete="off"><select name="selStayDur[]" class="" style="display:none;"><option value="n/a">Select</option></select><input type="text" class="" name="txtdist[]"  id="txtdist'+rowCount+'" style="display:none;width:110px;" value="n/a" autocomplete="off" /></span> </td>\n\
                        <td><input type="file" name="file'+rowCount+'[]" id="file'+rowCount+'[]" multiple="true" style="width:150px;" onchange="Validate(this.id);"></td>\n\
                        <td><button type="submit" class="button button-default" name="deleteRowbutton" disabled><i class="fa fa-trash-o"></i></button></td></tr>');
                        $('.erp-leave-date-field').datepicker({
                            dateFormat: "dd-mm-yy",
                            changeMonth: true,
                            changeYear: true
                        });
                    },
                    error: function(error) {
                        console.log( error );
                    }
                 });
            },
            addRowOthersEdit: function(){
                var optionsMode;
                wp.ajax.send( 'get-mode-others', {
                    success: function(mode) {
                        $.each( mode, function( index, value ){
                            //console.log(value);
                            optionsMode += '<option value="'+value.MOD_Id+'">'+value.MOD_Name+'</option>';
                        });
                        var rowCount = $('#table-others-travel tr').length;
                        $('#hidrowno').val(rowCount);
                        $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-row-others" class="dashicons dashicons-dismiss red"></span></a>');
                        $('#table-others-travel tr').last().after('<tr>\n\
                        <td data-title="Date" class="scrollmsg"><input name="txtDate[]" id="txtDate'+rowCount+'" class="posttraveldate" placeholder="dd/mm/yyyy"  /><input name="txtStartDate[]" id="txtStartDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" /><input name="txtEndDate[]" id="txtEndDate'+rowCount+'" class="" placeholder="dd/mm/yyyy" autocomplete="off" style="display:none;" value="n/a" /><input type="text" name="textBillNo[]" id="textBillNo'+rowCount+'" autocomplete="off"  class="" style="display:none;" value="n/a"/></td>\n\
                        <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc'+rowCount+'" class=""></textarea><select name="selExpcat[]" id="selExpcat'+rowCount+'" class="" style="display:none;"><option value="3">select</option></select></td>\n\
                        <td data-title="Category"><span id="modeoftr'+rowCount+'acontent"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'</td>\n\
                        <td data-title="Total Cost"><input  name="from[]" id="city'+rowCount+'" type="text" placeholder="From" class="" value="n/a" style="display:none;"><input  name="to[]" id="city'+rowCount+'" type="text" placeholder="To" class="" value="n/a" style="display:none;"><select name="selStayDur[]" class="" style="display:none;"><option value="n/a">Select</option></select><input type="text" class="" name="txtdist[]"  id="txtdist'+rowCount+'" style="display:none;" value="n/a" autocomplete="off" /><input type="text" class="" name="txtCost[]" id="txtCost'+rowCount+'" onkeyup="valCost(this.value);" autocomplete="off"/></td>\n\
                        <td><input type="file" name="file'+rowCount+'[]" id="file'+rowCount+'[]" multiple="true" onchange="Validate(this.id);"></td>\n\
                        <td><button type="submit" class="button button-default" name="deleteRowbutton" disabled><i class="fa fa-trash-o"></i></button></td></tr>');
                        $('.posttraveldate').datepicker({
                            dateFormat: "dd-mm-yy",
                            changeMonth: true,
                            changeYear: true
                        });
                    },
                    error: function(error) {
                        console.log( error );
                    }
                 });
            },
            removeRow: function(){
                var rowCount = $('#table-pre-travel tr').length;
                if(rowCount==3){
                    $('#table-pre-travel tr:last').remove();
                    $('#removebuttoncontainer').html('');
                }
                else if(rowCount>2){
                $('#table-pre-travel tr:last').remove();
                }
                
            },
            removeRowPost: function(){
                var rowCount = $('#table-post-travel tr').length;
                if(rowCount==3){
                    $('#table-post-travel tr:last').remove();
                    $('#removebuttoncontainer').html('');
                }
                else if(rowCount>2){
                $('#table-post-travel tr:last').remove();
                }
                
            },
            removeRowMileage: function(){
                var rowCount = $('#table-mileage-travel tr').length;
                if(rowCount==3){
                    $('#table-mileage-travel tr:last').remove();
                    $('#removebuttoncontainer').html('');
                }
                else if(rowCount>2){
                $('#table-mileage-travel tr:last').remove();
                }
                
            },
            removeRowUtility: function(){
                var rowCount = $('#table-utility-travel tr').length;
                if(rowCount==3){
                    $('#table-utility-travel tr:last').remove();
                    $('#removebuttoncontainer').html('');
                }
                else if(rowCount>2){
                $('#table-utility-travel tr:last').remove();
                }
                
            },
            removeRowOthers: function(){
                var rowCount = $('#table-others-travel tr').length;
                if(rowCount==3){
                    $('#table-others-travel tr:last').remove();
                    $('#removebuttoncontainer').html('');
                }
                else if(rowCount>2){
                $('#table-others-travel tr:last').remove();
                }
                
            },
            createChatMsg: function(e){
                e.preventDefault();
                $('.erp-note-loader').show();
                wp.ajax.send( 'send-emp-note', {
                    data: {
                        rn_status : $('#rn_status').val(),
                        req_id : $('#req_id').val(),
                        emp_id : $('#emp_id').val(),
                        txtaNotes : $('#txtaNotes').val()
                    },
                    success: function(resp) {
                        $('.erp-note-loader').hide();
                        switch(resp.status){
                            case 'success':
                                $( 'body' ).load( window.location.href + '.pre-travel-request' );
                                $('#p-success').html(resp.message);
                                $('#success').show();
                                $("#success").delay(5000).slideUp(200);
                                break;
                        }
                    },
                    error: function(error) {
                        console.log( error );
                    }
                });
            },
            create: function(e) {
                e.preventDefault();
                $('.erp-loader').show();
                $('#submit-pre-travel-request').addClass('disabled');
                wp.ajax.send( 'send_pre_travel_request', {
                      data: $(this).serialize(),
                    success: function(resp) {
                        console.log("success"); 
                        console.log(resp);
                        
                        $('.erp-loader').hide();
                        $('#submit-pre-travel-request').removeClass('disabled');
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
           
           edit: function(e) {
                e.preventDefault();
                $('.erp-loader').show();
                $('#submit-pre-travel-request').addClass('disabled');
                wp.ajax.send( 'send_pre_travel_edit_request', {
                      data: $(this).serialize(),
                    success: function(resp) {
                        console.log("success");
                        console.log(resp);
                        $('.erp-loader').hide();
                        $('#submit-pre-travel-request_edit').removeClass('disabled');
                        switch(resp.status){
                            case 'success':
                                $('#p-success').html(resp.message);
                                $('#success').show();
                                $("#success").delay(5000).slideUp(200);
                                //$( 'body' ).load( window.location.href + '.pre-travel-request' );
                                location.reload()
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
           delete: function(){
              wp.ajax.send( 'pre-travel-request-delete', {
                    data: {
                      id : $(this).val(),
                      req_id : $('#reqid').val(), 
                    },
                    success: function(resp) {
                        console.log("success");
                        console.log(resp);
                        $('.erp-loader').hide();
                        $('#submit-pre-travel-request_edit').removeClass('disabled');
                        switch(resp.status){                         
                            case 'success':
                                $('#p-success').html(resp.message);
                                $('#success').show();
                                $("#success").delay(5000).slideUp(200);
                                //$( 'body' ).load( window.location.href + '.pre-travel-request' );
                                location.reload()
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

        dashboard : {
            markAnnouncementRead: function(e) {
                e.preventDefault();
                var self = $(this);

                if ( ! self.closest( 'li' ).hasClass('unread') ) {
                    return;
                }

                wp.ajax.send( 'erp_hr_announcement_mark_read', {
                    data: {
                        id : self.data( 'row_id' ),
                        _wpnonce: wpErpHr.nonce
                    },
                    success: function(res) {
                        self.closest( 'li' ).removeClass( 'unread' );
                        self.addClass( 'erp-hide' );
                    },
                    error: function(error) {
                        alert( error );
                    }
                });
            },

            viewAnnouncementTitle: function(e) {
                e.preventDefault();
                var self = $(this).closest( 'li' ).find( 'a.view-full' );
                wp.ajax.send( 'erp_hr_announcement_view', {
                    data: {
                        id : self.data( 'row_id' ),
                        _wpnonce: wpErpHr.nonce
                    },
                    success: function(res) {
                        $.erpPopup({
                            title: res.title,
                            button: '',
                            id: 'erp-hr-announcement',
                            content: '<p>'+ res.content +'</p>',
                            extraClass: 'midium',
                        });
                        self.closest( 'li' ).removeClass( 'unread' );
                        self.siblings( '.mark-read' ).addClass( 'erp-hide' );
                    },
                    error: function(error) {
                        alert( error );
                    }
                });
            },

            viewAnnouncement: function(e) {
                e.preventDefault();
                var self = $(this);

                wp.ajax.send( 'erp_hr_announcement_view', {
                    data: {
                        id : self.data( 'row_id' ),
                        _wpnonce: wpErpHr.nonce
                    },
                    success: function(res) {
                        $.erpPopup({
                            title: res.title,
                            button: '',
                            id: 'erp-hr-announcement',
                            content: '<p>'+ res.content +'</p>',
                            extraClass: 'midium',
                        });
                        self.closest( 'li' ).removeClass( 'unread' );
                        self.siblings( '.mark-read' ).addClass( 'erp-hide' );
                    },
                    error: function(error) {
                        alert( error );
                    }
                });
            }
        },

        department: {

            /**
             * After create new department
             *
             * @return {void}
             */
            afterNew: function( e, res ) {
                var selectdrop = $('.erp-hr-dept-drop-down');
                wperp.scriptReload( 'erp_hr_script_reload', 'tmpl-erp-new-employee' );
                selectdrop.append('<option selected="selected" value="'+res.id+'">'+res.title+'</option>');
                selectdrop.select2().select2("val", res.id);
            },

            /**
             * Reload the department area
             *
             * @return {void}
             */
            reload: function() {
                $( '#erp-dept-table-wrap' ).load( window.location.href + ' #erp-dept-table-wrap' );
            },

            /**
             * Template reload after insert, edit, delete
             *
             * @return {void}
             */
            tempReload: function() {
                wperp.scriptReload( 'erp_hr_new_dept_tmp_reload', 'tmpl-erp-new-dept' );
            },

            /**
             * Create new department
             *
             * @param  {event}
             */
            create: function(e) {
                e.preventDefault();
                var self = $(this),
                    is_single = self.data('single');

                $.erpPopup({
                    title: wpErpHr.popup.dept_title,
                    button: wpErpHr.popup.dept_submit,
                    id: 'erp-hr-new-department',
                    content: wperp.template('erp-new-dept')().trim(),
                    extraClass: 'smaller',
                    onSubmit: function(modal) {
                        wp.ajax.send( {
                            data: this.serialize(),
                            success: function(res) {
                                WeDevs_CRP_EMP.department.reload();

                                if ( is_single != '1' ) {
                                    $('body').trigger( 'erp-hr-after-new-dept', [res]);
                                } else {
                                    WeDevs_CRP_EMP.department.tempReload();
                                }

                                modal.closeModal();
                            },
                            error: function(error) {
                                modal.showError( error );
                            }
                        });
                    }
                }); //popup
            },

            /**
             * Edit a department in popup
             *
             * @param  {event}
             */
            edit: function(e) {
                e.preventDefault();

                var self = $(this);

                $.erpPopup({
                    title: wpErpHr.popup.dept_update,
                    button: wpErpHr.popup.dept_update,
                    id: 'erp-hr-new-department',
                    content: wp.template('erp-new-dept')().trim(),
                    extraClass: 'smaller',
                    onReady: function() {
                        var modal = this;

                        $( 'header', modal).after( $('<div class="loader"></div>').show() );

                        wp.ajax.send( 'erp-hr-get-dept', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpHr.nonce
                            },
                            success: function(response) {
                                $( '.loader', modal).remove();

                                $('#dept-title', modal).val( response.name );
                                $('#dept-desc', modal).val( response.data.description );
                                $('#dept-parent', modal).val( response.data.parent );
                                $('#dept-lead', modal).val( response.data.lead );
                                $('#dept-id', modal).val( response.id );
                                $('#dept-action', modal).val( 'erp-hr-update-dept' );

                                // disable current one
                                $('#dept-parent option[value="' + self.data('id') + '"]', modal).attr( 'disabled', 'disabled' );

                            }
                        });
                    },
                    onSubmit: function(modal) {
                        wp.ajax.send( {
                            data: this.serialize(),
                            success: function() {
                                WeDevs_CRP_EMP.department.reload();
                                WeDevs_CRP_EMP.department.tempReload();
                                modal.closeModal();
                            },
                            error: function(error) {
                                modal.showError( error );
                            }
                        });
                    }
                });
            },

            /**
             * Delete a department
             *
             * @param  {event}
             */
            remove: function(e) {
                e.preventDefault();

                var self = $(this);

                if ( confirm( wpErpHr.delConfirmDept ) ) {
                    wp.ajax.send( 'erp-hr-del-dept', {
                        data: {
                            '_wpnonce': wpErpHr.nonce,
                            id: self.data( 'id' )
                        },
                        success: function() {
                            self.closest('tr').fadeOut( 'fast', function() {
                                $(this).remove();
                                WeDevs_CRP_EMP.department.tempReload();
                            });
                        },
                        error: function(response) {
                            alert( response );
                        }
                    });
                }
            },

        },
        
        companyAdmin: {
            
            reload: function() {
                $( '.erp-hr-employees-wrap' ).load( window.location.href + ' .erp-hr-employees-wrap-inner' );
            },
            
            /**
             * Create a new employee modal
             *
             * @param  {event}
             */
            create: function(e) {
                if ( typeof e !== 'undefined' ) {
                    //e.preventDefault();
                }

                if ( typeof wpErpHr.employee_empty === 'undefined' ) {
                    //return;
                }
                $.erpPopup({
                    title: wpErpHr.popup.company_title,
                    button: wpErpHr.popup.employee_create,
                    id: "erp-new-companyadmin-popup",
                   content: wperp.template('companyadmin-create')( wpErpHr.employee_empty ).trim(),
					//content: '<h1>sss</h1>',
                    onReady: function() {
                        WeDevs_CRP_EMP.initDateField();
                        $('.select2').select2();
                        WeDevs_CRP_EMP.employee.select2Action('erp-hrm-select2');
                        WeDevs_CRP_EMP.employee.select2AddMoreContent();

                        $( '#user_notification').on('click', function() {
                            if ( $(this).is(':checked') ) {
                                $('.show-if-notification').show();
                            } else {
                                $('.show-if-notification').hide();
                            }
                        });
                    },

                    /**
                     * Handle the onsubmit function
                     *
                     * @param  {modal}
                     */
                    onSubmit: function(modal) {
                        $( 'button[type=submit]', '.erp-modal' ).attr( 'disabled', 'disabled' );
                        wp.ajax.send( 'companyadmin_create', {
                            data: this.serialize(),
                            success: function(response) {
                                console.log(response);
                                WeDevs_CRP_EMP.employee.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function(error) {
                                modal.enableButton();
				$('.erp-modal-backdrop, .erp-modal' ).find( '.erp-loader' ).addClass('erp-hide');
                                modal.showError(error);
                                console.log(error);
                            }
                        });
                    }
                });
            },
            edit: function(e) {
                e.preventDefault();
                var self = $(this);
                //alert("edit");
                $.erpPopup({
                    title: wpErpHr.popup.employee_update,
                    button: wpErpHr.popup.employee_update,
                    id: 'erp-employee-edit',
                    onReady: function() {
                        var modal = this;

                        $( 'header', modal).after( $('<div class="loader"></div>').show() );

                        wp.ajax.send( 'companyadmin_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpHr.nonce
                            },
                            success: function(response) {
                                console.log(response);
                              var html = wp.template('companyadmin-create')( response );
                                $( '.content', modal ).html( html );
                                $( '.loader', modal).remove();
                                WeDevs_CRP_EMP.initDateField();

                                $( 'li[data-selected]', modal ).each(function() {
                                    var self = $(this),
                                        selected = self.data('selected');

                                    if ( selected !== '' ) {
                                        self.find( 'select' ).val( selected ).trigger('change');
                                    }
                                });

                                // disable current one
                                $('#work_reporting_to option[value="' + response.id + '"]', modal).attr( 'disabled', 'disabled' );
                            }
                        });
                    },
                    onSubmit: function(modal) {
                        modal.disableButton();

                        wp.ajax.send( {
                            data: this.serialize(),
                            success: function(response) {
                                WeDevs_CRP_EMP.employee.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function(error) {
                                modal.enableButton();
                                modal.showError( error );
                            }
                        });
                    }
                });
            },
			
			remove: function(e) {
                e.preventDefault();
                 
                var self = $(this);

                if ( confirm( wpErpHr.delConfirmEmployee ) ) {
                    wp.ajax.send( 'companyadmin-delete', {
						
                        data: {
                            _wpnonce: wpErpHr.nonce,
                            id: self.data( 'id' ),
                            hard: self.data( 'hard' )
							
                        },
                        success: function() {
							alert("delete");
                            self.closest('tr').fadeOut( 'fast', function() {
                                $(this).remove();
                                WeDevs_CRP_EMP.companyAdmin.reload();
                            });
                        },
                        error: function(response) {
                            alert( response );
                        }
                    });
                }
            },
			
			
        },
        designation: {

            /**
             * After create new desination
             *
             * @return {void}
             */
            afterNew: function( e, res ) {
                var selectdrop = $('.erp-hr-desi-drop-down');

                wperp.scriptReload( 'erp_hr_script_reload', 'tmpl-erp-new-employee' );
                selectdrop.append('<option selected="selected" value="'+res.id+'">'+res.title+'</option>');
                WeDevs_CRP_EMP.employee.select2AddMoreActive('erp-hr-desi-drop-down');
                selectdrop.select2("val", res.id);
            },

            /**
             * Reload the department area
             *
             * @return {void}
             */
            reload: function() {
                $( '.erp-hr-designation' ).load( window.location.href + ' .erp-hr-designation' );
            },

            /**
             * Create designation
             *
             * @param  {event}
             *
             * @return {void}
             */
            create: function(e) {
                e.preventDefault();
                var is_single = $(this).data('single');
                $.erpPopup({
                    title: wpErpHr.popup.desig_title,
                    button: wpErpHr.popup.desig_submit,
                    id: 'erp-hr-new-designation',
                    content: wp.template( 'erp-new-desig' )().trim(),
                    extraClass: 'smaller',
                    onSubmit: function(modal) {
                        wp.ajax.send( {
                            data: this.serialize(),
                            success: function(res) {
                                WeDevs_CRP_EMP.designation.reload();
                                if ( is_single != '1' ) {
                                    $('body').trigger( 'erp-hr-after-new-desig', [res] );
                                }
                                modal.closeModal();
                            },
                            error: function(error) {
                                modal.showError( error );
                            }
                        });
                    }
                });
            },

            /**
             * Edit a department in popup
             *
             * @param  {event}
             */
            edit: function(e) {
                e.preventDefault();

                var self = $(this);

                $.erpPopup({
                    title: wpErpHr.popup.desig_update,
                    button: wpErpHr.popup.desig_update,
                    content: wp.template( 'erp-new-desig' )().trim(),
                    id: 'erp-hr-new-designation',
                    extraClass: 'smaller',
                    onReady: function() {
                        var modal = this;

                        $( 'header', modal).after( $('<div class="loader"></div>').show() );

                        wp.ajax.send( 'erp-hr-get-desig', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpHr.nonce
                            },
                            success: function(response) {
                                $( '.loader', modal).remove();

                                $('#desig-title', modal).val( response.name );
                                $('#desig-desc', modal).val( response.data.description );
                                $('#desig-id', modal).val( response.id );
                                $('#desig-action', modal).val( 'erp-hr-update-desig' );
                            }
                        });
                    },
                    onSubmit: function(modal) {
                        wp.ajax.send( {
                            data: this.serialize(),
                            success: function() {
                                WeDevs_CRP_EMP.designation.reload();

                                modal.closeModal();
                            },
                            error: function(error) {
                                modal.showError( error );
                            }
                        });
                    }
                });
            },

            /**
             * Delete a department
             *
             * @param  {event}
             */
            remove: function(e) {
                e.preventDefault();

                var self = $(this);

                if ( confirm( wpErpHr.delConfirmDept ) ) {
                    wp.ajax.send( 'erp-hr-del-desig', {
                        data: {
                            '_wpnonce': wpErpHr.nonce,
                            id: self.data( 'id' )
                        },
                        success: function() {
                            self.closest('tr').fadeOut( 'fast', function() {
                                $(this).remove();
                            });
                        },
                        error: function(response) {
                            alert( response );
                        }
                    });
                }
            },
        },
    };

    $(function() {
        WeDevs_CRP_EMP.initialize();
    });
})(jQuery);
