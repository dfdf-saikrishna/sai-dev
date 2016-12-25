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
            $( '.travel-desk-request').on( 'click', '#edit-traveldesk-requestappr', this.travelDesk.editRowappr );
            $( 'body').on( 'click', '#add-traveldesk-groupreq', this.travelDesk.addRowGroup );
            $( 'body').on( 'click', '#add-traveldesk-groupreq-edit', this.travelDesk.addRowGroupEdit );
            $( '.travel-desk-request').on( 'click', '#add-traveldesk-request', this.travelDesk.addRow );
            $( 'body').on( 'click', 'span#remove-traveldesk-request', this.travelDesk.removeRow );
            $( 'body').on( 'click', 'span#remove-group-request', this.travelDesk.removeGroupRow );
            $( '.traveldeskrequestarrow' ).on( 'click', '', this.traveldeskrequestarrow.view);
            $( '.erp-traveldeskbankdetails' ).on( 'click', 'a#erp-traveldeskbankdetails-new', this.traveldeskBankdetails.create );
            $( '.erp-traveldeskbankdetails' ).on( 'click', 'span.edit a', this.traveldeskBankdetails.edit );
            $('body').on('click', '#traveldeskrise_invoice', this.traveldeskRiseinvoice.traveldeskInvoice);
            $('body').on('click', '#buttonCalculate', this.traveldeskRiseinvoice.buttonCalculate);
            $('body').on('submit', '#tdinvoiceForm', this.traveldeskClaims.sendclaims);
            $('body').on('submit', '#buttoneditclaim', this.traveldeskClaimsUpdate.buttoneditclaim);
            $('body').on('click', '.group_emp', this.travelDesk.groupEmps);
            $('body').on('click', '#groupReqClaimButton', this.travelDesk.groupReqCliam);
            //$('body').on('click', '#claimedit', this.traveldeskclaimedit.claimedit);
            
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
 
			traveldeskBankdetails: {
                
			 /**
             * Reload the department area
             *
             * @return {void}
             */
            reload: function() {
                $( '.erp-traveldeskbankdetails-wrap' ).load( window.location.href + ' .erp-traveldeskbankdetails-wrap-inner' );
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

                if ( typeof wpErpTd.traveldeskbankdetails_empty === 'undefined' ) {
                    //return;
                }
                $.erpPopup({
                    title: wpErpTd.popup.traveldeskbankdetails_title,
                    button: wpErpTd.popup.traveldeskbankdetails_create,
                    id: "erp-new-traveldeskbankdetails-popup",
					//content:"<h1>Test</h1>",
                   content: wperp.template('traveldeskbankdetails-create')( wpErpTd.traveldeskbankdetails_empty ).trim(),
                    /**
                     * Handle the onsubmit function
                     *
                     * @param  {modal}
                     */
                    onSubmit: function(modal) {
                        $( 'button[type=submit]', '.erp-modal' ).attr( 'disabled', 'disabled' );
                        wp.ajax.send( 'traveldeskbankdetails_create', {
                            data: this.serialize(),
                            success: function(response) {
                                console.log(response);
                                WeDevs_ERP_TRAVELDESK.traveldeskBankdetails.reload();
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
                $.erpPopup({
                    title: wpErpTd.popup.traveldeskbankdetails_update,
                    button: wpErpTd.popup.update,
                    id: 'erp-traveldeskbankdetails-edit',
                    onReady: function() {
                        var modal = this;
                        $( 'header', modal).after( $('<div class="loader"></div>').show() );
                        wp.ajax.send('traveldeskbankdetails_get', {
                            data: {
                                id: self.data('id'),
                               // _wpnonce: wpErpTa.nonce
                            },
                            success: function(response) {
                                //console.log(response);
                              var html = wp.template('traveldeskbankdetails-create')( response );
                                $( '.content', modal ).html( html );
                                $( '.loader', modal).remove();
                                // disable current one
                                }
                        });
                    },
                    onSubmit: function(modal) {
                        modal.disableButton();

                        wp.ajax.send({
                            data: this.serialize(),
                            success: function(response) {
                                WeDevs_ERP_TRAVELDESK.traveldeskBankdetails.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function(error) {
                                modal.enableButton();
                                modal.showError( error );
								console.log(error);
                            }
                        });
                    }
                });
            },
        },
	
        travelDesk : {
            groupEmps: function(e){
                e.preventDefault();
                $('.show_group_emps').slideUp('slow');
                $(this).closest("tr").find('.show_group_emps').slideDown('slow');
            },
            groupReqCliam: function(e){
                e.preventDefault();
                wp.ajax.send( 'group-req-claim', {
                      data: {
                      id : $(this).val(), 
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
            editRowappr: function(){
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
                                <td data-title="Get Quote"><button type="button" name="getQuote" id="getQuote1'+rowCount+'" class="button button-primary" onclick="getQuotefunc(1)">Get Quote</button></td>\n\
                                <td><button type="button" value="" class="button button-default" name="deleteRowbutton" id="deleteRowbutton" title="delete row"><i class="fa fa-trash-o"></i></button></td></tr>');
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
                                <td data-title="Place"><input  name="from[]" id="from'+rowCount+'" type="text" placeholder="From" class=""><input  name="to[]" id="to'+rowCount+'" type="text" placeholder="To" class=""></td>\n\
                                <td data-title="Estimated Cost"><input type="text" class="" name="txtCost[]" id="txtCost'+rowCount+'" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" autocomplete="off"/></br><span class="red" id="show-exceed"></span></td>\n\
                                <td data-title="Get Quote"><button type="button" name="getQuote" id="getQuote1'+rowCount+'" class="button button-primary" onclick="getQuotefunc(1)">Get Quote</button></td>\n\</tr>');
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
            addRowGroup: function(){
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
                                var rowCount = $('#group_request tr').length;
                                $('#hidrowno').val(rowCount);
                                $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-group-request" class="dashicons dashicons-dismiss red"></span></a>');
                                $('#group_request tr').last().after('<tr>\n\
                                <td><input name="txtDate[]"  id="txtDate'+rowCount+'" style="width:101px;" class="erp-leave-date-field"placeholder="dd/mm/yyyy" autocomplete="off"/></td>\n\
                                <td><textarea name="txtaExpdesc[]" rows="2" cols="12" id="txtaExpdesc'+rowCount+'" data-height="auto" class="" autocomplete="off"></textarea></td>\n\
                                <td data-title="Category"><select name="selExpcat[]" onchange="javascript:getMotPreTravel(this.value,'+rowCount+')" style="width:110px;" id="selExpcat'+rowCount+'" class=""><option value="">Select</option>'+optionsCat+'\n\
                                <td data-title="Categorysss"><span id="modeoftr'+rowCount+'acontent"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'\n\
                                <td><span id="city'+rowCount+'container"><input  name="from[]" id="from'+rowCount+'" type="text" style="width:130px;" placeholder="From" class="" autocomplete="off"><input  name="to[]" id="to'+rowCount+'" type="text" style="width:130px;" placeholder="To" class="" autocomplete="off" ></span></td>\n\
                                <td><input type="text" class="" name="txtCost[]" id="txtCost'+rowCount+'" style="width:110px;" onkeyup="valGroupRequestCost(this.value);"  autocomplete="off"/></td>\n\
                                <td><input type="text" class="" name="txtTotalCost[]" id="txtTotalCost'+rowCount+'" style="width:110px;" autocomplete="off"/></td>\n\
                                <td><input type="file" name="file'+rowCount+'[]" id="file'+rowCount+'[]" multiple="true" style="width:150px;" onchange="Validate(this.id);"></td>\n\</tr>');
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
            addRowGroupEdit: function(){
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
                                var rowCount = $('#group_request tr').length;
                                $('#hidrowno').val(rowCount);
                                $('#removebuttoncontainer').html('<a title="Delete Rows" class="btn btn-default"><span id="remove-group-request" class="dashicons dashicons-dismiss red"></span></a>');
                                $('#group_request tr').last().after('<tr>\n\
                                <td><input name="txtDate[]"  id="txtDate'+rowCount+'" style="width:101px;" class="erp-leave-date-field"placeholder="dd/mm/yyyy" autocomplete="off"/></td>\n\
                                <td><textarea name="txtaExpdesc[]" rows="2" cols="12" id="txtaExpdesc'+rowCount+'" data-height="auto" class="" autocomplete="off"></textarea></td>\n\
                                <td data-title="Category"><select name="selExpcat[]" onchange="javascript:getMotPreTravel(this.value,'+rowCount+')" style="width:110px;" id="selExpcat'+rowCount+'" class=""><option value="">Select</option>'+optionsCat+'\n\
                                <td data-title="Categorysss"><span id="modeoftr'+rowCount+'acontent"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'\n\
                                <td><span id="city'+rowCount+'container"><input  name="from[]" id="from'+rowCount+'" type="text" style="width:130px;" placeholder="From" class="" autocomplete="off"><input  name="to[]" id="to'+rowCount+'" type="text" style="width:130px;" placeholder="To" class="" autocomplete="off" ></span></td>\n\
                                <td><input type="text" class="" name="txtCost[]" id="txtCost'+rowCount+'" style="width:110px;" onkeyup="valGroupRequestCost(this.value);"  autocomplete="off"/></td>\n\
                                <td><input type="text" class="" name="txtTotalCost[]" id="txtTotalCost'+rowCount+'" style="width:110px;" autocomplete="off"/></td>\n\
                                <td><input type="file" name="file'+rowCount+'[]" id="file'+rowCount+'[]" multiple="true" style="width:150px;" onchange="Validate(this.id);"></td>\n\
                                <td><button type="button" class="button button-default" name="deleteRowbutton" onclick="return checkDeletRow();" id="deleteRowbutton" title="delete row" disabled><i class="fa fa-trash-o"></i></button></td>\n\</tr>');
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
            removeGroupRow: function(){
                var rowCount = $('#group_request tr').length;
                if(rowCount==3){
                    $('#group_request tr:last').remove();
                    $('#removebuttoncontainer').html('');
                }
                else if(rowCount>2){
                $('#group_request tr:last').remove();
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
		
		traveldeskrequestarrow:{
			
			view: function(e) {
					 var self = $(this);
					 var id = self.data('id')
					 //var state = $('.hide-table' + id).attr('class').split(' ')[1];
					 var state = $('.hide-table' + id).hasClass( "collapse" );
					 var caret = $(this).find(".collapse-caret");
					 if(state){
						 $('.hide-table' + id).removeClass('collapse');
						 $('.hide-table' + id).removeClass('init-invoice');
						 $('.hide-table' + id).slideDown();
						 caret.removeClass("fa-angle-down").addClass( "fa-angle-up" );
					 }
					 else{
					 //$(".hide-table").not($(this)).hide('slow');
					 //$(this).closest('tr').hide('slow');
					 $('.hide-table' + id).addClass('collapse');
					 $('.hide-table' + id).addClass('init-invoice');
					 $('.hide-table' + id).slideUp();
					 caret.removeClass("fa-angle-up").addClass( "fa-angle-down" );
					 //$(this).find('.hide-table').hide();
					 }
                },
			
		},
		  
	traveldeskRiseinvoice: {
			
			indianRupeeFormat: function(x){
	
				x=x.toString();
				var lastThree = x.substring(x.length-3);
				var otherNumbers = x.substring(0,x.length-3);
				if(otherNumbers != '')
					lastThree = ',' + lastThree;
				var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
				
				//res=parseInt(res);
				
				return res;

			},
		
            reload: function () {
                $('.erp-traveldesk-wrap').load(window.location.href + ' .erp-traveldesk-wrap-inner');
            },
			traveldeskInvoice: function (e) {
                e.preventDefault();
                var values = new Array();
                $.each($("input[name='reqid[]']:checked"), function () {
                    values.push($(this).val());
                });
                if(values!=""){
					window.location.replace("/wp-admin/admin.php?page=RiseInvoice&action=view&reqid=" + values);
					}

            },
			buttonCalculate:function (e) {
				var servTax		=	$("#txtServiceTax").val();
				var servChrg	=	$("#txtServiceChrgs").val();
				var totalAmnt=$("#totalAmount").val();
				var calc;
				var totalAmntFrmtd;
				var nooftickets=$('#hiddenTickets').val();
				if(servTax || servChrg){
					if(servTax){
						calc=nooftickets * (servChrg * (servTax / 100));
						calc=calc.toFixed();
						var calcText	=	WeDevs_ERP_TRAVELDESK.traveldeskRiseinvoice.indianRupeeFormat(calc);
						//alert('CalculatedAmnt='+calc);
						$("#servicetaxlistid").css('display', 'block');
						$("#servicetaxid").text(calcText);
						totalAmnt=parseInt(totalAmnt)+parseInt(calc);
					}
					if(servChrg){
						servChrg	=	parseInt(servChrg) * parseInt(nooftickets);
						$("#serviceamntlistid").css('display', 'block');
						$("#servicechargesid").text(servChrg);
						//alert(totalAmnt);
						totalAmnt=parseInt(totalAmnt) + parseInt(servChrg);
					}
					//alert('Total Amnt='+totalAmnt);
					totalAmntFrmtd= WeDevs_ERP_TRAVELDESK.traveldeskRiseinvoice.indianRupeeFormat(totalAmnt)+'.00';
					$("#totalamountid").text(totalAmntFrmtd);
					//$("#totalAmount").val(totalAmnt);
				} else {
					totalAmntFrmtd= WeDevs_ERP_TRAVELDESK.traveldeskRiseinvoice.indianRupeeFormat(totalAmnt)+'.00';
					$("#totalamountid").text(totalAmntFrmtd);
					if(!servTax)
					$("#servicetaxlistid").css('display', 'none'); 
					if(!servChrg)
					$("#serviceamntlistid").css('display', 'none');	
				}
			},
        },
		traveldeskClaims:{
			
			/* Reload the department area
             *
             * @return {void}
             */
            reload: function() {
                $( '.erp-traveldeskclaims-wrap' ).load( window.location.href + ' .erp-traveldeskclaims-wrap-inner' );
            }, 
			
			  /**
             * Create a new employee modal
             *
             * @param  {event}
             */
             sendclaims: function(e) {
				 e.preventDefault();
					/**
                     * Handle the onsubmit function
                     *
                     * @param  {modal}
                     */
                        wp.ajax.send( 'traveldeskclaims_create', {
                            data: $(this).serialize(),
                            success: function(response) {
						switch(resp.status){
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
                               // console.log(response);
                              //  WeDevs_ERP_TRAVELDESK.traveldeskClaims.reload();
							   window.location.replace("/wp-admin/admin.php?page=claims");
               
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                   
            },
			 
		},
		
	traveldeskClaimsUpdate:{
		/* Reload the department area
             *
             * @return {void}
             */
            reload: function() {
                $( '.erp-traveldeskclaims-wrap' ).load( window.location.href + ' .erp-traveldeskclaims-wrap-inner' );
            }, 
			
		buttoneditclaim: function(e) {
					 e.preventDefault();
					/**
                     * Handle the onsubmit function
                     *
                     * @param  {modal}
                     */
                        wp.ajax.send( 'traveldeskclaims_update', {
                            data: $(this).serialize(),
                            success: function(response) {
						
                                console.log(response);
                              //  WeDevs_ERP_TRAVELDESK.traveldeskClaims.reload();
							   //window.location.replace("/wp-admin/admin.php?page=claims");
               
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                   
            },
			
	},	
  
    };
    $(function() {
        WeDevs_ERP_TRAVELDESK.initialize();
    });
})(jQuery);
