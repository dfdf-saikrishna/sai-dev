/* jshint devel:true */
/* global wpErpCr */
/* global wp */

;(function($) {
    'use strict';
    var WeDevs_ERP_TRAVELAGENT = {

        /**
         * Initialize the events
         *
         * @return {void}
         */
        initialize: function() {
			$( '.erp-hr-travelagentuser' ).on( 'click', 'a#erp-travelagentuser-new', this.travelagentUser.create );
            $( '.erp-hr-travelagentuser' ).on( 'click', 'span.edit a', this.travelagentUser.edit );
			$( '.erp-travelagentclient' ).on( 'click', 'a#erp-travelagentclient-new', this.travelagentClient.create );
			$('.erp-travelagentclient').on('click', 'span.edit a', this.travelagentClient.edit);
			$('body').on('click', 'a#client-photo ', this.travelagentClient.setPhoto);
            $( '.erp-invoice-management' ).on( 'change', '#Companyinvoice', this.travelagentInvoice.view );
			$( '.erp-travelagentbankdetails' ).on( 'click', 'a#erp-travelagentbankdetails-new', this.travelagentBankdetails.create );
			$( '.erp-travelagentbankdetails' ).on( 'click', 'span.edit a', this.travelagentBankdetails.edit );
			$( '.companyinvoicearrow' ).on( 'click', '', this.travelagentcompanyinvoicearw.view);
			$('body').on('click', '#rise_invoice', this.travelagentRiseinvoice.riseInvoice);
			$('body').on('submit', '#invoiceForm', this.travelagentClaims.sendclaims);
			
			this.initTipTip();

        },

        initTipTip: function() {
            $( '.erp-tips' ).tipTip( {
                defaultPosition: "top",
                fadeIn: 100,
                fadeOut: 100
            } );
        },

		 travelagentRiseinvoice: {
            reload: function () {
                $('.erp-companyinvoicecreate-wrap').load(window.location.href + ' .erp-companyinvoicecreate-wrap-inner');
            },
			riseInvoice: function (e) {
                e.preventDefault();
				var cmpid = $('#filter_cmp').val();
				//alert(cmpid);
                var values = new Array();
                $.each($("input[name='reqid[]']:checked"), function () {
                    values.push($(this).val());
                });
                if(values!=""){
					window.location.replace("/wp-admin/admin.php?page=RiseInvoice&action=view&cmpid=" + cmpid +"&id=" + values);
					}

            },
        },
		
		travelagentClaims:{
			
			/* Reload the department area
             *
             * @return {void}
             */
            reload: function() {
                $( '.erp-companyinvoicecreate-wrap' ).load( window.location.href + ' .erp-companyinvoicecreate-wrap-inner' );
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
                        wp.ajax.send( 'travelagentclaims_create', {
                            data: $(this).serialize(),
                            success: function(response) {
                                console.log(response);
                                WeDevs_ERP_TRAVELAGENT.travelagentClaims.reload();
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                   
            },	 
		},
		
	travelagentUser: {
                
			 /**
             * Reload the department area
             *
             * @return {void}
             */
            reload: function() {
                $( '.erp-hr-travelagentuser-wrap' ).load( window.location.href + ' .erp-hr-travelagentuser-wrap-inner' );
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

                if ( typeof wpErpTa.travelagentuser_empty === 'undefined' ) {
                    //return;
                }
                $.erpPopup({
                    title: wpErpTa.popup.travelagentuser_title,
                    button: wpErpTa.popup.travelagentuser_create,
                    id: "erp-new-travelagentuser-popup",
					//content:"<h1>Test</h1>",
                   content: wperp.template('travelagentuser-create')( wpErpTa.travelagentuser_empty ).trim(),
                    /**
                     * Handle the onsubmit function
                     *
                     * @param  {modal}
                     */
                    onSubmit: function(modal) {
                        $( 'button[type=submit]', '.erp-modal' ).attr( 'disabled', 'disabled' );
                        wp.ajax.send( 'travelagentuser_create', {
                            data: this.serialize(),
                            success: function(response) {
								console.log("response");
                                console.log(response);
                                WeDevs_ERP_TRAVELAGENT.travelagentUser.reload();
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
                    title: wpErpTa.popup.travelagentuser_update,
                    button: wpErpTa.popup.update,
                    id: 'erp-employee-edit',
                    onReady: function() {
                        var modal = this;

                        $( 'header', modal).after( $('<div class="loader"></div>').show() );

                        wp.ajax.send( 'travelagentuser_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpTa.nonce
                            },
                            success: function(response) {
								console.log("response");
                                console.log(response);
                              var html = wp.template('travelagentuser-create')( response );
                                $( '.content', modal ).html( html );
                                $( '.loader', modal).remove();
                                // disable current one
                                }
                        });
                    },
                    onSubmit: function(modal) {
                        modal.disableButton();

                        wp.ajax.send( {
                            data: this.serialize(),
                            success: function(response) {
                                WeDevs_ERP_TRAVELAGENT.travelagentUser.reload();
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
		
	travelagentClient: {
                
			 /**
             * Reload the department area
             *
             * @return {void}
             */
            reload: function() {
                $( '.erp-travelagentclient-wrap' ).load( window.location.href + ' .erp-travelagentclient-wrap-inner' );
            },
			
			/**
             * Set photo popup
             *
             * @param {event}
             */
            setPhoto: function (e) {
                e.preventDefault();
                e.stopPropagation();
                //console.log("inside1");
                var frame;

                if (frame) {
                    frame.open();
                    return;
                }

                frame = wp.media({
                    title: wpErpTa.emp_upload_photo,
                    button: {text: wpErpTa.emp_set_photo}
                });

                frame.on('select', function () {
                    var selection = frame.state().get('selection');

                    selection.map(function (attachment) {
                        attachment = attachment.toJSON();

                        var html = '<img src="' + attachment.url + '" alt="" />';
                        html += '<input type="hidden" id="emp-photo-id" name="travelagentclient[photo_id]" value="' + attachment.id + '" />';
                        html += '<a href="#" class="erp-remove-photo">&times;</a>';
                        //console.log("inside2");
                        $('.photo-container', '.erp-employee-form').html(html);
                    });
                });

                frame.open();
            },
            /**
             * Remove an employees avatar
             *
             * @param  {event}
             */
            removePhoto: function (e) {
                e.preventDefault();

                var html = '<a href="#" id="erp-set-emp-photo" class="button button-small">' + wpErpTa.emp_upload_photo + '</a>';
                html += '<input type="hidden" name="travelagentclient[photo_id]" id="emp-photo-id" value="0">';

                $('.photo-container', '.erp-employee-form').html(html);
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

                if ( typeof wpErpTa.travelagentclient_empty === 'undefined' ) {
                    //return;
                }
                $.erpPopup({
                    title: wpErpTa.popup.travelagentclient_title,
                    button: wpErpTa.popup.travelagentclient_create,
                    id: "erp-new-travelagentclient-popup",
					//content:"<h1>Test</h1>",
                   content: wperp.template('travelagentclient-create')( wpErpTa.travelagentclient_empty ).trim(),
                    /**
                     * Handle the onsubmit function
                     *
                     * @param  {modal}
                     */
                    onSubmit: function(modal) {
						alert("sdfsdfsf");
                        $( 'button[type=submit]', '.erp-modal' ).attr( 'disabled', 'disabled' );
                        wp.ajax.send( 'travelagentclient_create', {
                            data: this.serialize(),
                            success: function(response) {
			                console.log("response");
                                console.log(response);
                                WeDevs_ERP_TRAVELAGENT.travelagentClient.reload();
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
                    title: wpErpTa.popup.travelagentclient_update,
                    button: wpErpTa.popup.update,
                    id: 'erp-travelagentbankdetails-edit',
                    onReady: function() {
                        var modal = this;
                        $( 'header', modal).after( $('<div class="loader"></div>').show() );
                        wp.ajax.send('travelagentclient_get', {
                            data: {
                                id: self.data('id'),
                               // _wpnonce: wpErpTa.nonce
                            },
                            success: function(response) {
                                console.log(response);
                              var html = wp.template('travelagentclient-create')( response );
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
                                WeDevs_ERP_TRAVELAGENT.travelagentClient.reload();
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
		travelagentInvoice: {
			 /**
             * Reload the department area
             *
             * @return {void}
             */
            reload: function() {
                $( '.erp-hr-employees-wrap' ).load( window.location.href + ' .erp-hr-employees-wrap-inner' );
            },
			
            /**
             * Create a new employee modal
             *
             * @param  {event}
             */
			view: function(e) {
                e.preventDefault();
                var self = $(this);
				var Companyinvoice = $('#Companyinvoice').val();
				var tabkey = $('#key').val();
				//alert(Companyinvoice);
                 wp.ajax.send( 'companyinvoice_view', {
                             data: {
                                id: Companyinvoice,
                                //_wpnonce: wpErpCompany.nonce
                            }, 
                            success: function(response) {
                                console.log(response);
								$('#invoiceview').show();
								//$('#EMP_Name').html(response.EMP_Name);
								}
                        });
                    
            },
			
		},
			
	travelagentBankdetails: {
                
			 /**
             * Reload the department area
             *
             * @return {void}
             */
            reload: function() {
                $( '.erp-travelagentbankdetails-wrap' ).load( window.location.href + ' .erp-travelagentbankdetails-wrap-inner' );
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

                if ( typeof wpErpTa.travelagentbankdetails_empty === 'undefined' ) {
                    //return;
                }
                $.erpPopup({
                    title: wpErpTa.popup.travelagentbankdetails_title,
                    button: wpErpTa.popup.travelagentbankdetails_create,
                    id: "erp-new-travelagentbankdetails-popup",
					//content:"<h1>Test</h1>",
                   content: wperp.template('travelagentbankdetails-create')( wpErpTa.travelagentbankdetails_empty ).trim(),
                    /**
                     * Handle the onsubmit function
                     *
                     * @param  {modal}
                     */
                    onSubmit: function(modal) {
                        $( 'button[type=submit]', '.erp-modal' ).attr( 'disabled', 'disabled' );
                        wp.ajax.send( 'travelagentbankdetails_create', {
                            data: this.serialize(),
                            success: function(response) {
                                //console.log(response);
                                WeDevs_ERP_TRAVELAGENT.travelagentBankdetails.reload();
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
                    title: wpErpTa.popup.travelagentbankdetails_update,
                    button: wpErpTa.popup.update,
                    id: 'erp-travelagentbankdetails-edit',
                    onReady: function() {
                        var modal = this;
                        $( 'header', modal).after( $('<div class="loader"></div>').show() );
                        wp.ajax.send('travelagentbankdetails_get', {
                            data: {
                                id: self.data('id'),
                               // _wpnonce: wpErpTa.nonce
                            },
                            success: function(response) {
                                //console.log(response);
                              var html = wp.template('travelagentbankdetails-create')( response );
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
                                WeDevs_ERP_TRAVELAGENT.travelagentBankdetails.reload();
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
	
		
		travelagentcompanyinvoicearw:{
			
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
		
	
    };

	
	
    $(function() {
        WeDevs_ERP_TRAVELAGENT.initialize();
    });
})(jQuery);
