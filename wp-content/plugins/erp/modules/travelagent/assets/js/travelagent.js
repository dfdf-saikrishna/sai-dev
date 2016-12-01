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
			$( '.erp-hr-travelagent' ).on( 'click', 'a#erp-travelagentuser-new', this.travelagentUser.create );
            $( '.erp-hr-travelagent' ).on( 'click', 'span.edit a', this.travelagentUser.edit );
            this.initTipTip();
        },

        initTipTip: function() {
            $( '.erp-tips' ).tipTip( {
                defaultPosition: "top",
                fadeIn: 100,
                fadeOut: 100
            } );
        },	
		
		
	travelagentUser: {
                
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
                alert("edit");
                $.erpPopup({
                    title: wpErpTa.popup.travelagentuser_update,
                    button: wpErpTa.popup.travelagentuser_update,
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
		
    };

    $(function() {
        WeDevs_ERP_TRAVELAGENT.initialize();
    });
})(jQuery);
