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
            //$( '.pre-travel-request').on( 'click', '#submit-pre-travel-request', this.travelRequest.create );
            $( '.pre-travel-request').on( 'submit', '#request_form', this.travelRequest.create );
            $( '.pre-travel-request').on( 'submit', '#request_edit_form', this.travelRequest.edit );
            $( '.pre-travel-request').on( 'click', '#deleteRowbutton', this.travelRequest.delete );
            $( 'body').on( 'click', '#post-emp-chat', this.travelRequest.createChatMsg );
            $( 'body').on( 'click', 'span#add-row-pretravel', this.travelRequest.addRow );
            $( 'body').on( 'click', 'span#remove-row-pretravel', this.travelRequest.removeRow );
            $( 'body').on( 'click', 'a#subApprove', this.travelRequest.subApprove );
            $( 'body').on( 'click', 'a#submitApprove', this.travelRequest.submitApprove );

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
        
        travelRequest : {
           
            reset: function() {
                console.log("test");
                $('#request_form')[0].reset();
            },
            subApprove: function(e){
              e.preventDefault();
              wp.ajax.send( 'approve-request', {
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
                                <td data-title="Date"><input name="txtDate[]" id="txtDate'+rowCount+'" class="erp-leave-date-field" placeholder="dd/mm/yyyy" autocomplete="off"></td>\n\
                                <td data-title="Description"><textarea name="txtaExpdesc[]" id="txtaExpdesc'+rowCount+'" class="" autocomplete="off"></textarea></td>\n\
                                <td data-title="Category"><select name="selExpcat[]"  id="selExpcat'+rowCount+'" class=""><option value="">Select</option>'+optionsCat+'\n\
                                <td data-title="Category"><select name="selModeofTransp[]"  id="selModeofTransp'+rowCount+'" class=""><option value="">Select</option>'+optionsMode+'\n\
                                <td data-title="Place"><input  name="from[]" id="from'+rowCount+'" type="text" placeholder="From" class=""><input  name="to[]" id="to1" type="text" placeholder="To" class=""></td>\n\
                                <td data-title="Estimated Cost"><input type="text" class="" name="txtCost[]" id="txtCost'+rowCount+'" onkeyup="valPreCost(this.value);" onchange="valPreCost(this.value);" autocomplete="off"/></br><span class="red" id="show-exceed"></span></td>\n\
                                <td data-title="Get Quote"><button type="button" name="getQuote" id="getQuote1'+rowCount+'" class="button button-primary" onclick="getQuotefunc(1)">Get Quote</button></td>\n\
                                <td><button type="button" value="" class="button button-default" name="deleteRowbutton" id="deleteRowbutton" title="delete row"><i class="fa fa-times"></i></button></td></tr>');
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
                var rowCount = $('#table-pre-travel tr').length;
                if(rowCount==3){
                    $('#table-pre-travel tr:last').remove();
                    $('#removebuttoncontainer').html('');
                }
                else if(rowCount>2){
                $('#table-pre-travel tr:last').remove();
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
