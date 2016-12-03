/* jshint devel:true */
/* global wpErpCr */
/* global wp */

;(function($) {
    'use strict';

    var WeDevs_ERP_HR = {

        /**
         * Initialize the events
         *
         * @return {void}
         */
        initialize: function() {

            // Company Admin
            $( 'body' ).on( 'click', 'a#companyadmin-new', this.companyAdmin.create );
            $( '.erp-hr-companyadmin' ).on( 'click', 'span.edit a', this.companyAdmin.edit );
            $( '.erp-hr-companyadmin' ).on( 'click', 'span.delete a', this.companyAdmin.remove );
            
			 // Master Admin
            $( 'body' ).on( 'click', 'a#masteradmin-new', this.masterAdmin.create );
            $( '.erp-hr-masteradmin' ).on( 'click', 'span.edit a', this.masterAdmin.edit );
			 $( '.erp-hr-masteradmin' ).on( 'click', 'a#erp-masteradmin-print', this.masterAdmin.printData );
			
            // employee
            $( 'body' ).on( 'click', 'a#erp-company-new', this.employee.create );
            $( '.erp-hr-employees' ).on( 'click', 'a#erp-employee-new', this.employee.create );
            $( '.erp-hr-employees' ).on( 'click', 'span.edit a', this.employee.edit );
            $( '.erp-hr-employees' ).on( 'click', 'a.submitdelete', this.employee.remove );
            $( '.erp-hr-employees' ).on( 'click', 'a.submitrestore', this.employee.restore );
            $( '.erp-hr-employees' ).on( 'click', 'a#erp-empl-status', this.employee.updateJobStatus );
            $( '.erp-hr-employees' ).on( 'click', 'a#erp-empl-compensation', this.employee.updateJobStatus );
            $( '.erp-hr-employees' ).on( 'click', 'a#erp-empl-jobinfo', this.employee.updateJobStatus );
            $( '.erp-hr-employees' ).on( 'click', 'td.action a.remove', this.employee.removeHistory );
            $( '.erp-hr-employees' ).on( 'click', 'a#erp-employee-print', this.employee.printData );
            $( 'body' ).on( 'focusout', 'input#erp-hr-user-email', this.employee.checkUserEmail );
            $( 'body' ).on( 'click', 'a#erp-hr-create-wp-user-to-employee', this.employee.makeUserEmployee );
          
            //Travel Agent Create
            $( 'body' ).on( 'click', 'a#travel-agent-new', this.travelagent.create );
            $( '.erp-hr-travelagent' ).on( 'click', 'span.edit a', this.travelagent.edit );
            //$( '.erp-hr-travelagent' ).on( 'click', 'a#travel-agent-new', this.travelagent.create );

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
            /**
             * Create a new Travelagent modal
             *
             * @param  {event}
             */
            travelagent: {
            
            reload: function() {
                
                $( '.erp-hr-travelagent-wrap' ).load( window.location.href + ' .erp-hr-travelagent-wrap-inner' );
            },
            create: function(e) {
                //alert('dsfkj');
                if ( typeof e !== 'undefined' ) {
                    //e.preventDefault();
                }

                if ( typeof wpErpCr.travelagent_empty === 'undefined' ) {
                    //return;
                }
		//alert("create");
                $.erpPopup({
                    title: wpErpCr.popup.travel_title,
                    button: wpErpCr.popup.travel_submit,
                   // button1: wpErpCr.popup.travel-agent-reset,
                    id: "erp-new-travelagent-popup",
                    content: wperp.template('erp-new-travelagent')( wpErpCr.travelagent_empty ).trim(),
                    //content: '<h1>sss</h1>',
		
                    onReady: function() {
                        WeDevs_ERP_HR.initDateField();
                        //$('.select2').select2();
                       // WeDevs_ERP_HR.Employee.select2Action('erp-hrm-select2');
                        //WeDevs_ERP_HR.travelagent.select2AddMoreContent();

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
                        alert("submit");
                        $( 'button[type=submit]', '.erp-modal' ).attr( 'disabled', 'disabled' );
                        wp.ajax.send( 'erp-hr-travelagent-new', {
                            data: this.serialize(),
                            success: function(response) {
                                console.log(response);
                                WeDevs_ERP_HR.travelagent.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function(error) {
                                modal.enableButton();
				$('.erp-modal-backdrop, .erp-modal' ).find( '.erp-loader' ).addClass('erp-hide');
                                //modal.showError(error);
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
                    title: wpErpCr.popup.travel_update,
                    button: wpErpCr.popup.travel_update,
                    //content:'dhcvdh',
                    id: 'erp-travelagent-edit',
                    onReady: function() {
                        var modal = this;

                        $( 'header', modal).after( $('<div class="loader"></div>').show() );
                        //alert('fdhbdfj');
                        wp.ajax.send( 'erp-hr-travelagent-get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCr.nonce
                            },
                            success: function(response) {
                                //console.log("test");
                                console.log(response);
                                var html = wp.template('erp-new-travelagent')( response );
                                $( '.content', modal ).html( html );
                                $( '.loader', modal).remove();

                                WeDevs_ERP_HR.initDateField();

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
                                WeDevs_ERP_HR.travelagent.reload();
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
                        _wpnonce: wpErpCr.nonce
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
                        _wpnonce: wpErpCr.nonce
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
                        _wpnonce: wpErpCr.nonce
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
                    title: wpErpCr.popup.dept_title,
                    button: wpErpCr.popup.dept_submit,
                    id: 'erp-hr-new-department',
                    content: wperp.template('erp-new-dept')().trim(),
                    extraClass: 'smaller',
                    onSubmit: function(modal) {
                        wp.ajax.send( {
                            data: this.serialize(),
                            success: function(res) {
                                WeDevs_ERP_HR.department.reload();

                                if ( is_single != '1' ) {
                                    $('body').trigger( 'erp-hr-after-new-dept', [res]);
                                } else {
                                    WeDevs_ERP_HR.department.tempReload();
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
                    title: wpErpCr.popup.dept_update,
                    button: wpErpCr.popup.dept_update,
                    id: 'erp-hr-new-department',
                    content: wp.template('erp-new-dept')().trim(),
                    extraClass: 'smaller',
                    onReady: function() {
                        var modal = this;

                        $( 'header', modal).after( $('<div class="loader"></div>').show() );

                        wp.ajax.send( 'erp-hr-get-dept', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCr.nonce
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
                                WeDevs_ERP_HR.department.reload();
                                WeDevs_ERP_HR.department.tempReload();
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

                if ( confirm( wpErpCr.delConfirmDept ) ) {
                    wp.ajax.send( 'erp-hr-del-dept', {
                        data: {
                            '_wpnonce': wpErpCr.nonce,
                            id: self.data( 'id' )
                        },
                        success: function() {
                            self.closest('tr').fadeOut( 'fast', function() {
                                $(this).remove();
                                WeDevs_ERP_HR.department.tempReload();
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

                if ( typeof wpErpCr.employee_empty === 'undefined' ) {
                    //return;
                }
                $.erpPopup({
                    title: wpErpCr.popup.company_title,
                    button: wpErpCr.popup.employee_create,
                    id: "erp-new-companyadmin-popup",
                   content: wperp.template('companyadmin-create')( wpErpCr.employee_empty ).trim(),
					//content: '<h1>sss</h1>',
                    onReady: function() {
                        WeDevs_ERP_HR.initDateField();
                        $('.select2').select2();
                        WeDevs_ERP_HR.employee.select2Action('erp-hrm-select2');
                        WeDevs_ERP_HR.employee.select2AddMoreContent();

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
                                WeDevs_ERP_HR.employee.reload();
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
                    title: wpErpCr.popup.employee_update,
                    button: wpErpCr.popup.employee_update,
                    id: 'erp-employee-edit',
                    onReady: function() {
                        var modal = this;

                        $( 'header', modal).after( $('<div class="loader"></div>').show() );

                        wp.ajax.send( 'companyadmin_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCr.nonce
                            },
                            success: function(response) {
                                console.log(response);
                              var html = wp.template('companyadmin-create')( response );
                                $( '.content', modal ).html( html );
                                $( '.loader', modal).remove();
                                WeDevs_ERP_HR.initDateField();

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
                                WeDevs_ERP_HR.employee.reload();
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

                if ( confirm( wpErpCr.delConfirmEmployee ) ) {
                    wp.ajax.send( 'companyadmin-delete', {
						
                        data: {
                            _wpnonce: wpErpCr.nonce,
                            id: self.data( 'id' ),
                            hard: self.data( 'hard' )
							
                        },
                        success: function() {
							alert("delete");
                            self.closest('tr').fadeOut( 'fast', function() {
                                $(this).remove();
                                WeDevs_ERP_HR.companyAdmin.reload();
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
                WeDevs_ERP_HR.employee.select2AddMoreActive('erp-hr-desi-drop-down');
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
                    title: wpErpCr.popup.desig_title,
                    button: wpErpCr.popup.desig_submit,
                    id: 'erp-hr-new-designation',
                    content: wp.template( 'erp-new-desig' )().trim(),
                    extraClass: 'smaller',
                    onSubmit: function(modal) {
                        wp.ajax.send( {
                            data: this.serialize(),
                            success: function(res) {
                                WeDevs_ERP_HR.designation.reload();
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
                    title: wpErpCr.popup.desig_update,
                    button: wpErpCr.popup.desig_update,
                    content: wp.template( 'erp-new-desig' )().trim(),
                    id: 'erp-hr-new-designation',
                    extraClass: 'smaller',
                    onReady: function() {
                        var modal = this;

                        $( 'header', modal).after( $('<div class="loader"></div>').show() );

                        wp.ajax.send( 'erp-hr-get-desig', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCr.nonce
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
                                WeDevs_ERP_HR.designation.reload();

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

                if ( confirm( wpErpCr.delConfirmDept ) ) {
                    wp.ajax.send( 'erp-hr-del-desig', {
                        data: {
                            '_wpnonce': wpErpCr.nonce,
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

        employee: {

            /**
             * Reload the department area
             *
             * @return {void}
             */
            reload: function() {
                $( '.erp-hr-employees-wrap' ).load( window.location.href + ' .erp-hr-employees-wrap-inner' );
            },

            /**
             * Set photo popup
             *
             * @param {event}
             */
            setPhoto: function(e) {
                e.preventDefault();
                e.stopPropagation();
                var frame;

                if ( frame ) {
                    frame.open();
                    return;
                }

                frame = wp.media({
                    title: wpErpCr.emp_upload_photo,
                    button: { text: wpErpCr.emp_set_photo }
                });

                frame.on('select', function() {
                    var selection = frame.state().get('selection');

                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();

                        var html = '<img src="' + attachment.url + '" alt="" />';
                            html += '<input type="hidden" id="emp-photo-id" name="company[photo_id]" value="' + attachment.id + '" />';
                            html += '<a href="#" class="erp-remove-photo">&times;</a>';

                        $( '.photo-container', '.erp-employee-form' ).html( html );
                    });
                });

                frame.open();
            },

            /**
             * Remove an employees avatar
             *
             * @param  {event}
             */
            removePhoto: function(e) {
                e.preventDefault();

                var html = '<a href="#" id="erp-set-emp-photo" class="button button-small">' + wpErpCr.emp_upload_photo + '</a>';
                    html += '<input type="hidden" name="personal[photo_id]" id="emp-photo-id" value="0">';

                $( '.photo-container', '.erp-employee-form' ).html( html );
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

                if ( typeof wpErpCr.employee_empty === 'undefined' ) {
                    //return;
                }
		//alert("create");
                $.erpPopup({
                    title: wpErpCr.popup.company_title,
                    button: wpErpCr.popup.employee_create,
                    id: "erp-new-employee-popup",
                    content: wperp.template('erp-new-employee')( wpErpCr.employee_empty ).trim(),
					//content: '<h1>sss</h1>',
		
                    onReady: function() {
                        WeDevs_ERP_HR.initDateField();
                        $('.select2').select2();
                        WeDevs_ERP_HR.employee.select2Action('erp-hrm-select2');
                        WeDevs_ERP_HR.employee.select2AddMoreContent();

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
                        alert("submit");
                        wp.ajax.send( 'erp-hr-employee-new', {
                            data: this.serialize(),
                            success: function(response) {
                                console.log(response);
                                WeDevs_ERP_HR.employee.reload();
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

            /**
             * select2 with add more button content
             *
             * @return  {void}
             */
            select2AddMoreContent: function() {
                var selects = $('.erp-hrm-select2-add-more');
                $.each( selects, function( key, element ) {
                   WeDevs_ERP_HR.employee.select2AddMoreActive(element);
                });
            },

            /**
             * select2 with add more button active
             *
             * @return  {void}
             */
            select2AddMoreActive: function(element) {
                var id = $(element).data('id');
                $(element).select2({
                    width: 'element',
                    "language": {
                        noResults: function(){
                           return '<a href="#" class="button button-primary" id="'+id+'">Add New</a>';
                        }
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    }

                });
            },

            /**
             * select2 action
             *
             * @return  {void}
             */
            select2Action: function(element) {
                $('.'+element).select2({
                    width: 'element',
                });
            },

            /**
             * Edit an employee
             *
             * @param  {event}
             */
            edit: function(e) {
                e.preventDefault();

                var self = $(this);
                //alert("edit");
                $.erpPopup({
                    title: wpErpCr.popup.employee_update,
                    button: wpErpCr.popup.employee_update,
                    id: 'erp-employee-edit',
                    onReady: function() {
                        var modal = this;

                        $( 'header', modal).after( $('<div class="loader"></div>').show() );

                        wp.ajax.send( 'erp-hr-emp-get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCr.nonce
                            },
                            success: function(response) {
                                console.log("test");
                                console.log(response);
                                var html = wp.template('erp-new-employee')( response );
                                $( '.content', modal ).html( html );
                                $( '.loader', modal).remove();

                                WeDevs_ERP_HR.initDateField();

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
                                WeDevs_ERP_HR.employee.reload();
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

            /**
             * Remove an employee
             *
             * @param  {event}
             */
            remove: function(e) {
                e.preventDefault();

                var self = $(this);

                if ( confirm( wpErpCr.delConfirmEmployee ) ) {
                    wp.ajax.send( 'erp-hr-emp-delete', {
                        data: {
                            _wpnonce: wpErpCr.nonce,
                            id: self.data( 'id' ),
                            hard: self.data( 'hard' )
                        },
                        success: function() {
                            self.closest('tr').fadeOut( 'fast', function() {
                                $(this).remove();
                                WeDevs_ERP_HR.employee.reload();
                            });
                        },
                        error: function(response) {
                            alert( response );
                        }
                    });
                }
            },

            restore: function(e) {
                e.preventDefault();

                var self = $(this);

                if ( confirm( wpErpCr.restoreConfirmEmployee ) ) {
                    wp.ajax.send( 'erp-hr-emp-restore', {
                        data: {
                            _wpnonce: wpErpCr.nonce,
                            id: self.data( 'id' ),
                        },
                        success: function() {
                            self.closest('tr').fadeOut( 'fast', function() {
                                $(this).remove();
                                WeDevs_ERP_HR.employee.reload();
                            });
                        },
                        error: function(response) {
                            alert( response );
                        }
                    });
                }

            },

            general: {

                create: function(e) {
                    if ( typeof e !== 'undefined' ) {
                        e.preventDefault();
                    }

                    var self = $(this);

                    $.erpPopup({
                        title: self.data('title'),
                        content: wp.template( self.data('template' ) )( self.data('data') ),
                        extraClass: 'smaller',
                        id: 'erp-hr-new-general',
                        button: self.data('button'),
                        onReady: function() {
                            WeDevs_ERP_HR.initDateField();
                        },
                        onSubmit: function(modal) {
                            wp.ajax.send( {
                                data: this.serializeObject(),
                                success: function() {
                                    WeDevs_ERP_HR.reloadPage();
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

                    if ( confirm( wpErpCr.confirm ) ) {
                        wp.ajax.send( self.data('action'), {
                            data: {
                                id: self.data('id'),
                                employee_id: self.data('employee_id'),
                                _wpnonce: wpErpCr.nonce
                            },
                            success: function() {
                                WeDevs_ERP_HR.reloadPage();
                            },
                            error: function(error) {
                                alert( error );
                            }
                        });
                    }
                },
            },

            updateJobStatus: function(e) {
                if ( typeof e !== 'undefined' ) {
                    e.preventDefault();
                }

                var self = $(this);

                $.erpPopup({
                    title: self.data('title'),
                    button: wpErpCr.popup.update_status,
                    id: 'erp-hr-update-job-status',
                    content: '',
                    extraClass: 'smaller',
                    onReady: function() {
                        var html = wp.template( self.data('template') )(window.wpErpCurrentEmployee);
                        $( '.content', this ).html( html );
                        WeDevs_ERP_HR.initDateField();

                        $( '.row[data-selected]', this ).each(function() {
                            var self = $(this),
                                selected = self.data('selected');

                            if ( selected !== '' ) {
                                self.find( 'select' ).val( selected );
                            }
                        });
                    },
                    onSubmit: function(modal) {
                        wp.ajax.send( {
                            data: this.serializeObject(),
                            success: function() {
                                WeDevs_ERP_HR.reloadPage();
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

            removeHistory: function(e) {
                e.preventDefault();

                if ( confirm( wpErpCr.confirm ) ) {
                    wp.ajax.send( 'erp-hr-emp-delete-history', {
                        data: {
                            id: $(this).data('id'),
                            _wpnonce: wpErpCr.nonce
                        },
                        success: function() {
                            WeDevs_ERP_HR.reloadPage();
                        }
                    });
                }
            },

            printData: function(e) {
                e.preventDefault();
                window.print();
            },

            checkUserEmail: function() {
                var self = $(this),
                    val = self.val(),
                    id = self.closest('form').find('#erp-employee-id').val();

                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                if ( val == '' || !re.test( val ) ) {
                    return false;
                }

                if ( id != '0' ) {
                    return false;
                }

                wp.ajax.send( 'erp_hr_check_user_exist', {
                    data: {
                        email: val,
                        _wpnonce: wpErpCr.nonce
                    },
                    success: function() {
                        var form = self.closest('form');
                        form.find('.modal-suggession').fadeOut( 300, function() {
                            $(this).remove();
                        });
                        form.find('button[type=submit]' ).removeAttr( 'disabled' );
                    },
                    error: function( response ) {
                        var form = self.closest('form');
                        form.find('button[type=submit]' ).attr( 'disabled', 'disabled');

                        if ( response.type == 'employee' ) {
                            form.find('.modal-suggession').remove();
                            form.find('header.modal-header').append('<div class="modal-suggession">' + wpErpCr.employee_exit + '</div>');
                        }

                        if ( response.type == 'wp_user' ) {
                            form.find('.modal-suggession').remove();
                            form.find('header.modal-header').append('<div class="modal-suggession">'+ wpErpCr.make_employee_text +' <a href="#" id="erp-hr-create-wp-user-to-employee" data-user_id="'+ response.data.ID +'">' + wpErpCr.create_employee_text + '</a></div>' );
                        }

                        $('.modal-suggession').hide().slideDown( function() {
                            form.find('.content-container').css({ 'marginTop': '15px' });
                        });
                    }
                });
            },

            makeUserEmployee: function(e) {
                e.preventDefault();
                var self = $(this),
                    user_id = self.data('user_id');

                self.closest('.modal-suggession').append('<div class="erp-loader" style="top:9px; right:10px;"></div>');

                wp.ajax.send( 'erp-hr-convert-wp-to-employee', {
                    data: {
                        user_id: user_id,
                        _wpnonce: wpErpCr.nonce
                    },
                    success: function() {
                        self.closest('.modal-suggession').find('.erp-loader').remove();
                        self.closest('.erp-modal').remove();
                        $('.erp-modal-backdrop').remove();
                        WeDevs_ERP_HR.employee.reload();

                        $.erpPopup({
                            title: wpErpCr.popup.employee_update,
                            button: wpErpCr.popup.employee_update,
                            id: 'erp-employee-edit',
                            onReady: function() {
                                var modal = this;

                                $( 'header', modal).after( $('<div class="loader"></div>').show() );

                                wp.ajax.send( 'erp-hr-emp-get', {
                                    data: {
                                        id: user_id,
                                        _wpnonce: wpErpCr.nonce
                                    },
                                    success: function(response) {
                                        var html = wp.template('erp-new-employee')( response );
                                        $( '.content', modal ).html( html );
                                        $( '.loader', modal).remove();

                                        WeDevs_ERP_HR.initDateField();

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
                                        WeDevs_ERP_HR.employee.reload();
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
                    error: function( response ) {
                        alert(response);
                    }
                });
            },

            addNote: function(e) {
                e.preventDefault();

                var form = $(this),
                    submit = form.find( 'input[type=submit]');

                submit.attr('disabled', 'disabled');
                form.find('.erp-note-loader').show();

                wp.ajax.send({
                    data: form.serializeObject(),
                    success: function() {
                        $.get( window.location.href, function( data ) {
                            if( $('ul.notes-list li').length < 0 ){
                                $('ul.notes-list').prepend( $(data).find( 'ul.notes-list' ).after() );
                            }else {
                                $('ul.notes-list').prepend( $(data).find( 'ul.notes-list li' ).first() );
                            }

                            if( $('ul.notes-list li').length > 10 ){
                                $('ul.notes-list li').last().remove();
                            }
                            WeDevs_ERP_HR.employee.showLoadMoreBtn() ;
                            form.find('.erp-note-loader').hide();
                            form.find('textarea').val('');
                            submit.removeAttr( 'disabled' );
                        });

                    },
                    error: function() {
                        submit.removeAttr('disabled');
                        form.find('.erp-note-loader').hide();
                    }
                });
            },

            showLoadMoreBtn: function(){
                if( $('ul.notes-list li').length >= 10 ){
                    $('.wperp-load-more-btn').show();
                }else {
                    $('.wperp-load-more-btn').hide();
                }
            },

            loadNotes: function(e) {
                e.preventDefault();

                var self = $(this),
                    data = {
                        action : 'erp-load-more-notes',
                        user_id : self.data('user_id'),
                        total_no : self.data('total_no'),
                        offset_no : self.data('offset_no')
                    };

                var spiner = '<span class="erp-loader" style="margin:4px 0px 0px 10px"></span>';

                self.closest('p')
                    .append( spiner )
                    .find('.erp-loader')
                    .show();

                self.attr( 'disabled', true );

                wp.ajax.send({
                    data: data,
                    success: function( resp ) {
                        self.data( 'offset_no', parseInt(data.total_no)+parseInt(data.offset_no) );
                        $(resp.content).appendTo(self.closest('.note-tab-wrap').find('ul.notes-list')).hide().fadeIn();
                        self.removeAttr( 'disabled' );
                        $('.erp-loader').remove();
                    },
                    error: function( error ) {
                        alert(error);
                    }
                });
            },

            deleteNote: function(e) {
                e.preventDefault();

                if ( confirm( wpErpCr.delConfirmEmployeeNote ) ) {

                    var self = $(this),
                        data = {
                            action: 'erp-delete-employee-note',
                            note_id: self.data('note_id'),
                            _wpnonce : wpErpCr.nonce
                        };

                    wp.ajax.send({
                        data: data,
                        success: function( resp ) {
                            self.closest('li').fadeOut( 400, function() {
                                $(this).remove();
                                WeDevs_ERP_HR.employee.showLoadMoreBtn() ;
                            });
                        },
                        error: function( error ) {
                            alert(error);
                        }
                    });
                }
            },

            updatePerformance: function(e) {

                if ( typeof e !== 'undefined' ) {
                    e.preventDefault();
                }

                var self = $(this);

                $.erpPopup({
                    title: self.data('title'),
                    button: wpErpCr.popup.update_status,
                    id: 'erp-hr-update-performance',
                    content: '',
                    extraClass: 'smaller',
                    onReady: function() {
                        var html = wp.template( self.data('template') )(window.wpErpCurrentEmployee);
                        $( '.content', this ).html( html );
                        WeDevs_ERP_HR.initDateField();
                        WeDevs_ERP_HR.employee.select2Action('erp-hrm-select2');

                        $( '.row[data-selected]', this ).each(function() {
                            var self = $(this),
                                selected = self.data('selected');

                            if ( selected !== '' ) {
                                self.find( 'select' ).val( selected );
                            }
                        });
                    },
                    onSubmit: function(modal) {
                        wp.ajax.send( {
                            data: this.serializeObject(),
                            success: function() {
                                WeDevs_ERP_HR.reloadPage();
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

            removePerformance: function(e) {
                e.preventDefault();

                if ( confirm( wpErpCr.confirm ) ) {
                    wp.ajax.send({
                        data: {
                            action: 'erp-hr-emp-delete-performance',
                            id: $(this).data('id'),
                            _wpnonce: wpErpCr.nonce
                        },
                        success: function() {
                            WeDevs_ERP_HR.reloadPage();
                        }
                    });
                }
            },

            terminateEmployee: function(e) {

                if ( typeof e !== 'undefined' ) {
                    e.preventDefault();
                }

                var self = $(this);

                if ( self.data('data') ) {
                    var terminateData = self.data('data');
                } else {
                    var terminateData = window.wpErpCurrentEmployee;
                }

                $.erpPopup({
                    title: self.data('title'),
                    button: wpErpCr.popup.terminate,
                    id: 'erp-hr-employee-terminate',
                    content: '',
                    extraClass: 'smaller',
                    onReady: function() {
                        var html = wp.template( self.data('template') )( terminateData );
                        $( '.content', this ).html( html );
                        WeDevs_ERP_HR.initDateField();

                        $( '.row[data-selected]', this ).each(function() {
                            var self = $(this),
                                selected = self.data('selected');

                            if ( selected !== '' ) {
                                self.find( 'select' ).val( selected );
                            }
                        });

                        WeDevs_ERP_HR.employee.select2Action('erp-hrm-select2');
                    },
                    onSubmit: function(modal) {
                        wp.ajax.send( {
                            data: this.serializeObject(),
                            success: function() {
                                WeDevs_ERP_HR.reloadPage();
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

            activateEmployee: function(e) {
                e.preventDefault();

                if ( confirm( wpErpCr.confirm ) ) {
                    wp.ajax.send({
                        data: {
                            action: 'erp-hr-emp-activate',
                            id: $(this).data('id'),
                            _wpnonce: wpErpCr.nonce
                        },
                        success: function() {
                            WeDevs_ERP_HR.reloadPage();
                        }
                    });
                }
            },

            changeEmployeeStatus: function(e) {
                e.preventDefault();

                var self = $(this),
                    form = self.closest('form'),
                    selectField = form.find( 'select#erp-hr-employee-status-option' ),
                    optionVal = selectField.val(),
                    selected = selectField.attr('data-selected');


                if ( 'terminated' == optionVal  ) {
                    if ( optionVal != selected ) {
                        $.erpPopup({
                            title: self.data('title'),
                            button: wpErpCr.popup.terminate,
                            id: 'erp-hr-employee-terminate',
                            content: '',
                            extraClass: 'smaller',
                            onReady: function() {
                                var html = wp.template( 'erp-employment-terminate' )({});
                                $( '.content', this ).html( html );
                                WeDevs_ERP_HR.initDateField();

                                WeDevs_ERP_HR.employee.select2Action('erp-hrm-select2');
                            },
                            onSubmit: function(modal) {
                                wp.ajax.send( {
                                    data: this.serializeObject(),
                                    success: function() {
                                        WeDevs_ERP_HR.reloadPage();
                                        modal.closeModal();
                                    },
                                    error: function(error) {
                                        modal.enableButton();
                                        modal.showError( error );
                                    }
                                });
                            }
                        });
                    } else {
                        alert( wpErpCr.popup.already_terminate );
                    }
                } else if ( 'active' == optionVal ) {
                    if ( optionVal != selected ) {
                        var self = $(this);
                        $.erpPopup({
                            title: wpErpCr.popup.employment_status,
                            button: wpErpCr.popup.update_status,
                            id: 'erp-hr-update-job-status',
                            content: '',
                            extraClass: 'smaller',
                            onReady: function() {
                                var html = wp.template('erp-employment-status')(window.wpErpCurrentEmployee);
                                $( '.content', this ).html( html );
                                WeDevs_ERP_HR.initDateField();
                            },
                            onSubmit: function(modal) {
                                wp.ajax.send( {
                                    data: this.serializeObject(),
                                    success: function() {
                                        modal.closeModal();
                                        form.submit();
                                    },
                                    error: function(error) {
                                        modal.enableButton();
                                        modal.showError( error );
                                    }
                                });
                            }
                        });
                    } else {
                        alert( wpErpCr.popup.already_active );
                    }

                } else {
                    form.submit();
                }
            }

        },
		
		masterAdmin: {
                
			 /**
             * Reload the department area
             *
             * @return {void}
             */
            reload: function() {
                $( '.erp-hr-masteradmin-wrap' ).load( window.location.href + ' .erp-hr-masteradmin-wrap-inner' );
            },
            /**
             * Create a new employee modal
             *
             * @param  {event}
             */
            create: function(e) {
                //alert("test");
                if ( typeof e !== 'undefined' ) {
                    //e.preventDefault();
                }

                if ( typeof wpErpCr.masteradmin_empty === 'undefined' ) {
                    //return;
                }
                $.erpPopup({
                    title: wpErpCr.popup.masteradmin_title,
                    button: wpErpCr.popup.masteradmin_create,
                    id: "erp-new-matseradmin-popup",
					//content: '<h1>sss</h1>',
                   content: wperp.template('master-admin-add')( wpErpCr.masteradmin_empty ).trim(),
                    /**
                     * Handle the onsubmit function
                     *
                     * @param  {modal}
                     */
                    onSubmit: function(modal) {
                        $( 'button[type=submit]', '.erp-modal' ).attr( 'disabled', 'disabled' );
                        wp.ajax.send( 'masteradmin_create', {
                            data: this.serialize(),
                            success: function(response) {
                                console.log(response);
                                WeDevs_ERP_HR.masterAdmin.reload();
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
                    title: wpErpCr.popup.masteradmin_updatetitle,
                    button: wpErpCr.popup.masteradmin_update,
                    id: 'erp-masteradmin-edit',
                    onReady: function() {
                        var modal = this;

                        $( 'header', modal).after( $('<div class="loader"></div>').show() );

                        wp.ajax.send( 'masteradmin_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCr.nonce
                            },
                            success: function(response) {
                                //console.log(response);
                              var html = wp.template('master-admin-add')( response );
                                $( '.content', modal ).html( html );
                                $( '.loader', modal).remove();
                               // WeDevs_ERP_HR.initDateField();

                               /* $( 'li[data-selected]', modal ).each(function() {
                                    var self = $(this),
                                        selected = self.data('selected');

                                    if ( selected !== '' ) {
                                        self.find( 'select' ).val( selected ).trigger('change');
                                    }
                                });*/

                                // disable current one
                                //$('#work_reporting_to option[value="' + response.id + '"]', modal).attr( 'disabled', 'disabled' );
                            }
                        });
                    },
                    onSubmit: function(modal) {
                        modal.disableButton();
                        wp.ajax.send( {
                            data: this.serialize(),
                            success: function(response) {
								//console.log(response);
                                WeDevs_ERP_HR.masterAdmin.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function(error) {
                                modal.enableButton();
                                modal.showError( error );
								console.log(error);
								alert("test error");
                            }
                        });
                    }
                });
            },
			printData: function(e) {
                e.preventDefault();
                window.print();
            },
			
        },
		
    };

    $(function() {
        WeDevs_ERP_HR.initialize();
    });
})(jQuery);
