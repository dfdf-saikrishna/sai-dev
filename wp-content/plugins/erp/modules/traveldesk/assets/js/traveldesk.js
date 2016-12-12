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
            view: function() {
                var val = $(this).val();
                if(val == 0){
                    $('#emp_details').slideUp();
                }else{
                    window.location.replace("/wp-admin/admin.php?page=Request-Without-Approval&selEmployees="+val);
                }
                
            },
        },
  
    };

    $(function() {
        WeDevs_ERP_TRAVELDESK.initialize();
    });
})(jQuery);
