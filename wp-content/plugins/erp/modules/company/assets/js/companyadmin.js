/* jshint devel:true */
/* global wpErpHr */
/* global wp */

;
(function ($) {
    'use strict';

    var WeDevs_ERP_COMPANY = {
        /**
         * Initialize the events
         *
         * @return {void}
         */
        initialize: function () {
            //alert("sdasdadas");
            // Import Excel
            $('body').on('click', '#crp_import_excel', this.Emp.import);
            $('body').on('click', '#crp_import_pdf', this.gradelimitsupload.download);

            // Dasboard Overview

            $('ul.erp-dashboard-announcement').on('click', 'a.mark-read', this.dashboard.markAnnouncementRead);
            $('ul.erp-dashboard-announcement').on('click', 'a.view-full', this.dashboard.viewAnnouncement);
            $('ul.erp-dashboard-announcement').on('click', '.announcement-title a', this.dashboard.viewAnnouncementTitle);

            $('.erp-hr-company').on('click', 'a#erp-companyemployee-new', this.companyEmployee.create);
            $('.erp-hr-company').on('change', '#selectEmployee', this.companyEmployee.view);
            //$( '.erp-hr-company' ).on( 'click', '#employeesubmit', this.companyEmployee.view );
            $('.erp-hr-company').on('click', 'span.edit a', this.companyEmployee.edit);
            $('body').on('click', 'a#company-emp-photo ', this.companyEmployee.setPhoto);
            //$( '.erp-hr-company' ).on( 'click', 'a.submitdelete', this.companyEmployee.remove );
            $('.erp-hr-company').on('click', 'a#erp-employee-print', this.companyEmployee.printData);

            //Mileage
            //$('body').on('click', 'a#erp-new-mileage', this.mileage.create);
            $('.erp-company-mileage').on('click', 'a#erp-new-mileage', this.mileage.create);
            $('.erp-company-mileage').on('click', 'span.edit a', this.mileage.edit);

            //Grades
            $('.erp-company-grades').on('click', 'a#erp-new-grades', this.grades.create);
            $('.erp-company-grades').on('click', 'span.edit a', this.grades.edit);


            //Designation
            $('body').on('click', 'a#erp-new-designations', this.designations.create);
            $('.erp-company-designations').on('click', 'span.edit a', this.designations.edit);

            //Departments
            $('.erp-company-departments').on('click', 'a#erp-new-departments', this.departments.create);
            $('.erp-company-departments').on('click', 'span.edit a', this.departments.edit);
            //cost center
            $('.erp-company-costcenter').on('click', 'a#erp-new-costcenter', this.costcenter.create);
            $('.erp-company-costcenter').on('click', 'span.edit a', this.costcenter.edit);
            //Project Code
            $('.erp-company-projectcode').on('click', 'a#erp-new-projectcode', this.projectcode.create);
            $('.erp-company-projectcode').on('click', 'span.edit a', this.projectcode.edit);


            $('.erp-hr-company').on('click', 'a#erp-companyemployee-new', this.companyEmployee.create);
            $('.erp-hr-company').on('change', '#selectEmployee', this.companyEmployee.view);
            //$( '.erp-hr-company' ).on( 'click', '#employeesubmit', this.companyEmployee.view );
            $('.erp-hr-company').on('click', 'span.edit a', this.companyEmployee.edit);
            $('body').on('click', 'a#company-emp-photo ', this.companyEmployee.setPhoto);
            //$( '.erp-hr-company' ).on( 'click', 'a.submitdelete', this.companyEmployee.remove );
            $('.erp-hr-company').on('click', 'a#erp-employee-print', this.companyEmployee.printData);

            // Workflow
            $('.workflow-update').on('click', '#selPreTrvPol-update', this.workflow.PreTrvPol);
            $('.workflow-update').on('click', '#selPostTrvPol-update', this.workflow.PostTrvPol);
            $('.workflow-update').on('click', '#selGenExpReq-update', this.workflow.GenExpReq);
            $('.workflow-update').on('click', '#selMileageReq-update', this.workflow.MileageReq);
            $('.workflow-update').on('click', '#selUtilityReq-update', this.workflow.UtilityReq);

            // Finance Approver
            $('body').on('change', '#select-finance-approver', this.finance.setAmount);
            $('body').on('click', '#submit_app_limit', this.finance.subAmount);
            $('body').on('click', '#remove_finance', this.finance.removieFinance);

            // Company Admin
            $('body').on('click', 'a#companyadmin-new', this.companyAdmin.create);
            $('.erp-hr-companyadmin').on('click', 'span.edit a', this.companyAdmin.edit);
            $('.erp-hr-companyadmin').on('click', 'span.delete a', this.companyAdmin.remove);

            $('.erp-company-traveldesk').on('click', 'a#erp-new-traveldesk', this.traveldesk.create);
            $('.erp-company-traveldesk').on('click', 'span.edit a', this.traveldesk.edit);
            //employee grade limits edit
            // $('body').on('click', 'span.edit a', this.gradelimits.create);
            $('.erp-company-gradelimits').on('click', 'span.edit a', this.gradelimits.edit);
            this.initTipTip();

            // this.employee.addWorkExperience();
        },
        initTipTip: function () {
            $('.erp-tips').tipTip({
                defaultPosition: "top",
                fadeIn: 100,
                fadeOut: 100
            });
        },
        initDateField: function () {
            $('.erp-date-field').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: '-100:+0',
            });
        },
        reloadPage: function () {
            $('.erp-area-left').load(window.location.href + ' #erp-area-left-inner', function () {
                $('.select2').select2();
            });
        },
        Emp: {
            import: function () {
                $('.erp-loader').show();
                $('#crp_import_excel').addClass('disabled');
            }
        },
        gradelimitsupload: {
            download: function () {
                $('.erp-loader').show();
                $('#crp_import_pdf').addClass('disabled');
            }
        },
        //  *****************************
        //         gradelimits add
        //   *****************************
        gradelimits: {
            reload: function () {
                $('.erp-company-gradelimits-wrap').load(window.location.href + ' .erp-company-gradelimits-wrap-inner');
            },
//             create: function (e) {
//                //alert('test');
//                if (typeof e !== 'undefined') {
//                    //e.preventDefault();
//                }
//                if (typeof wpErpCompany.gradelimits_empty === 'undefined') {
//                    //return;
//                }
//                $.erpPopup({
//                    title: wpErpCompany.popup.gradelimits_title,
//                    button: wpErpCompany.popup.gradelimits_submit,
//                    id: "erp-new-gradelimits-popup",
//                   // extraClass: 'smaller',
//                    content: wperp.template('grade-limits')(wpErpCompany.gradelimits_empty).trim(),
//                    //content: '<h1>Test</h1>',
//                    /**
//                     * Handle the onsubmit function
//                     */
//                    onSubmit: function (modal) {
//                        $('button[type=submit]', '.erp-modal').attr('disabled', 'disabled');
//                        wp.ajax.send('gradelimits_create', {
//                            data: this.serialize(),
//                            success: function (response) {
//                                console.log(response);
//                                modal.enableButton();
//                                modal.closeModal();
//                            },
//                            error: function (error) {
//                                modal.enableButton();
//                                $('.erp-modal-backdrop, .erp-modal').find('.erp-loader').addClass('erp-hide');
//                                modal.showError(error);
//                                console.log(error);
//                            }
//                        });
//                    }
//                });
//            },
            edit: function (e) {
                e.preventDefault();
                var self = $(this);
                //alert("edit");
                $.erpPopup({
                    title: wpErpCompany.popup.gradelimits_edit,
                    button: wpErpCompany.popup.update,
                    id: 'erp-gradelimits-edit',
                    //extraClass: 'smaller',
                    //content: wperp.template('gradelimits-create')().trim(),
                    onReady: function () {
                        //alert('dfhdvj');
                        var modal = this;
                        $('header', modal).after($('<div class="loader"></div>').show());
                        wp.ajax.send('gradelimits_get', {
                            data: {
                                id: self.data('id'),
                            },
                            success: function (response) {
                                //alert(response);
                                //console.log(response);
                                var html = wp.template('grade-limits')(response);
                                $('.content', modal).html(html);
                                $('.loader', modal).remove();
                                //console.log(response);
                            }
                        });
                    },
                    onSubmit: function (modal) {
                        modal.disableButton();
                        wp.ajax.send({
                            data: this.serialize(),
                            success: function (response) {
                                WeDevs_ERP_COMPANY.gradelimits.reload();
                                modal.enableButton();
                                modal.closeModal();
                                //console.log(response);
                            },
                            error: function (error) {
                                console.log(error);
                                modal.enableButton();
                                modal.showError(error);
                            }
                        });
                    }
                });
            },
        },
        //  *****************************
        //         costcenter add
        //   *****************************
        costcenter: {
            reload: function () {
                $('.erp-company-costcenter-wrap').load(window.location.href + ' .erp-company-costcenter-wrap-inner');
            },
            /**
             project code   modal
             */
            create: function (e) {
                //alert('test');
                if (typeof e !== 'undefined') {
                    //e.preventDefault();
                }
                if (typeof wpErpCompany.costcenter_empty === 'undefined') {
                    //return;
                }
                $.erpPopup({
                    title: wpErpCompany.popup.costcenter_title,
                    button: wpErpCompany.popup.costcenter_submit,
                    id: "erp-new-costcenter-popup",
                    extraClass: 'smaller',
                    content: wperp.template('costcenter-create')(wpErpCompany.costcenter_empty).trim(),
                    //content: '<h1>Test</h1>',
                    /**
                     * Handle the onsubmit function
                     */
                    onSubmit: function (modal) {
                        $('button[type=submit]', '.erp-modal').attr('disabled', 'disabled');
                        wp.ajax.send('costcenter_create', {
                            data: this.serialize(),
                            success: function (response) {
                                console.log(response);
                                switch (response.status) {
                                    case 'success':
                                        $('#p-success').html(response.message);
                                        $('#success').show();
                                        $("#success").delay(5000).slideUp(200);
                                        break;
                                    case 'failure':
                                        $('#p-failure').html(response.message);
                                        $('#failure').show();
                                        $("#failure").delay(5000).slideUp(200);
                                        break;
                                }
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                $('.erp-modal-backdrop, .erp-modal').find('.erp-loader').addClass('erp-hide');
                                modal.showError(error);
                                console.log(error);
                            }
                        });
                    }
                });
            },
            edit: function (e) {
                e.preventDefault();
                var self = $(this);
                //alert("edit");
                $.erpPopup({
                    title: wpErpCompany.popup.costcenter_edit,
                    button: wpErpCompany.popup.update,
                    id: 'erp-costcenter-edit',
                    extraClass: 'smaller',
                    //content: wperp.template('costcenter-create')().trim(),
                    onReady: function () {
                        //alert('dfhdvj');
                        var modal = this;
                        $('header', modal).after($('<div class="loader"></div>').show());
                        wp.ajax.send('costcenter_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCompany.nonce
                            },
                            success: function (response) {
                                console.log(response);
                                switch (response.status) {
                                    case 'success':
                                        $('#p-success').html(response.message);
                                        $('#success').show();
                                        $("#success").delay(5000).slideUp(200);
                                        break;
                                    case 'failure':
                                        $('#p-failure').html(response.message);
                                        $('#failure').show();
                                        $("#failure").delay(5000).slideUp(200);
                                        break;
                                }
                                var html = wp.template('costcenter-create')(response);
                                $('.content', modal).html(html);
                                $('.loader', modal).remove();
                            }
                        });
                    },
                    onSubmit: function (modal) {
                        modal.disableButton();
                        wp.ajax.send({
                            data: this.serialize(),
                            success: function (response) {
                                WeDevs_ERP_COMPANY.costcenter.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                modal.showError(error);
                            }
                        });
                    }
                });
            },
        },
        //  *****************************
        //         projectcode add
        //   *****************************
        projectcode: {
            reload: function () {
                $('.erp-company-projectcode-wrap').load(window.location.href + ' .erp-company-projectcode-wrap-inner');
            },
            /**
             project code   modal
             */
            create: function (e) {
                //alert('test');
                if (typeof e !== 'undefined') {
                    //e.preventDefault();
                }
                if (typeof wpErpCompany.projectcode_empty === 'undefined') {
                    //return;
                }
                $.erpPopup({
                    title: wpErpCompany.popup.projectcode_title,
                    button: wpErpCompany.popup.projectcode_submit,
                    id: "erp-new-projectcode-popup",
                    extraClass: 'smaller',
                    content: wperp.template('project-create')(wpErpCompany.projectcode_empty).trim(),
                    //content: '<h1>Test</h1>',
//                    onReady: function () {
//                        WeDevs_ERP_COMPANY.initDateField();
//                    },
                    /**
                     * Handle the onsubmit function
                     */
                    onSubmit: function (modal) {
                        $('button[type=submit]', '.erp-modal').attr('disabled', 'disabled');
                        wp.ajax.send('projectcode_create', {
                            data: this.serialize(),
                            success: function (response) {
                                console.log(response);
                                WeDevs_ERP_COMPANY.projectcode.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                $('.erp-modal-backdrop, .erp-modal').find('.erp-loader').addClass('erp-hide');
                                modal.showError(error);
                                console.log(error);
                            }
                        });
                    }
                });
            },
            edit: function (e) {
                e.preventDefault();
                var self = $(this);
                //alert("edit");
                $.erpPopup({
                    title: wpErpCompany.popup.projectcode_edit,
                    button: wpErpCompany.popup.update,
                    id: 'erp-projectcode-edit',
                    extraClass: 'smaller',
                    //content: wperp.template('projectcode-create')().trim(),
                    onReady: function () {
                        //alert('dfhdvj');
                        var modal = this;
                        $('header', modal).after($('<div class="loader"></div>').show());
                        wp.ajax.send('projectcode_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCompany.nonce
                            },
                            success: function (response) {
                                console.log(response);
                                var html = wp.template('project-create')(response);
                                $('.content', modal).html(html);
                                $('.loader', modal).remove();
//                                WeDevs_ERP_COMPANY.initDateField();
//
//                                $('li[data-selected]', modal).each(function () {
//                                    var self = $(this),
//                                            selected = self.data('selected');
//
//                                    if (selected !== '') {
//                                        self.find('select').val(selected).trigger('change');
//                                    }
//                                });
                            }
                        });
                    },
                    onSubmit: function (modal) {
                        modal.disableButton();
                        wp.ajax.send({
                            data: this.serialize(),
                            success: function (response) {
                                WeDevs_ERP_COMPANY.projectcode.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                modal.showError(error);
                            }
                        });
                    }
                });
            },
        },
        //  *****************************
        //        Department add
        //   *****************************
        departments: {
            reload: function () {
                $('.erp-company-departments-wrap').load(window.location.href + ' .erp-company-departments-wrap-inner');
            },
            /**
             finance limits   modal
             */
            create: function (e) {
                //alert('test');
                if (typeof e !== 'undefined') {
                    //e.preventDefault();
                }
                if (typeof wpErpCompany.departments_empty === 'undefined') {
                    //return;
                }
                $.erpPopup({
                    title: wpErpCompany.popup.departments_title,
                    button: wpErpCompany.popup.departments_submit,
                    id: "erp-new-departments-popup",
                    extraClass: 'smaller',
                    content: wperp.template('department-create')(wpErpCompany.departments_empty).trim(),
                    //content: '<h1>Test</h1>',
//                    onReady: function () {
//                        WeDevs_ERP_COMPANY.initDateField();
//                    },
                    /**
                     * Handle the onsubmit function
                     */
                    onSubmit: function (modal) {
                        $('button[type=submit]', '.erp-modal').attr('disabled', 'disabled');
                        wp.ajax.send('departments_create', {
                            data: this.serialize(),
                            success: function (response) {
                                console.log(response);
                                WeDevs_ERP_COMPANY.departments.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                $('.erp-modal-backdrop, .erp-modal').find('.erp-loader').addClass('erp-hide');
                                modal.showError(error);
                                console.log(error);
                            }
                        });
                    }
                });
            },
            edit: function (e) {
                e.preventDefault();
                var self = $(this);
                //alert("edit");
                $.erpPopup({
                    title: wpErpCompany.popup.departments_edit,
                    button: wpErpCompany.popup.update,
                    id: 'erp-departments-edit',
                    extraClass: 'smaller',
                    //content: wperp.template('departments-create')().trim(),
                    onReady: function () {
                        //alert('dfhdvj');
                        var modal = this;
                        $('header', modal).after($('<div class="loader"></div>').show());
                        wp.ajax.send('departments_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCompany.nonce
                            },
                            success: function (response) {
                                console.log(response);
                                var html = wp.template('department-create')(response);
                                $('.content', modal).html(html);
                                $('.loader', modal).remove();
                                WeDevs_ERP_COMPANY.initDateField();

                                $('li[data-selected]', modal).each(function () {
                                    var self = $(this),
                                            selected = self.data('selected');

                                    if (selected !== '') {
                                        self.find('select').val(selected).trigger('change');
                                    }
                                });
                            }
                        });
                    },
                    onSubmit: function (modal) {
                        modal.disableButton();
                        wp.ajax.send({
                            data: this.serialize(),
                            success: function (response) {
                                WeDevs_ERP_COMPANY.departments.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                modal.showError(error);
                            }
                        });
                    }
                });
            },
        },
        //  *****************************
        //         Desination add
        //   *****************************
        designations: {
            reload: function () {
                $('.erp-company-designations-wrap').load(window.location.href + ' .erp-company-designations-wrap-inner');
            },
            /**
             finance limits   modal
             */
            create: function (e) {
                //alert('test');
                if (typeof e !== 'undefined') {
                    //e.preventDefault();
                }
                if (typeof wpErpCompany.designation_empty === 'undefined') {
                    //return;
                }
                $.erpPopup({
                    title: wpErpCompany.popup.designation_title,
                    button: wpErpCompany.popup.designation_submit,
                    id: "erp-new-designations-popup",
                    extraClass: 'smaller',
                    content: wperp.template('designation-create')(wpErpCompany.designation_empty).trim(),
                    //content: '<h1>Test</h1>',
//                    onReady: function () {
//                        WeDevs_ERP_COMPANY.initDateField();
//                    },
                    /**
                     * Handle the onsubmit function
                     */
                    onSubmit: function (modal) {
                        $('button[type=submit]', '.erp-modal').attr('disabled', 'disabled');
                        wp.ajax.send('designation_create', {
                            data: this.serialize(),
                            success: function (response) {
                                console.log(response);
                                WeDevs_ERP_COMPANY.designations.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                $('.erp-modal-backdrop, .erp-modal').find('.erp-loader').addClass('erp-hide');
                                modal.showError(error);
                                console.log(error);
                            }
                        });
                    }
                });
            },
            edit: function (e) {
                e.preventDefault();
                var self = $(this);
                //alert("edit");
                $.erpPopup({
                    title: wpErpCompany.popup.designation_edit,
                    button: wpErpCompany.popup.update,
                    id: 'erp-designations-edit',
                    extraClass: 'smaller',
                    //content: wperp.template('desgination-create')().trim(),
                    onReady: function () {
                        //alert('dfhdvj');
                        var modal = this;
                        $('header', modal).after($('<div class="loader"></div>').show());
                        wp.ajax.send('designation_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCompany.nonce
                            },
                            success: function (response) {
                                console.log(response);
                                var html = wp.template('designation-create')(response);
                                $('.content', modal).html(html);
                                $('.loader', modal).remove();
                            }
                        });
                    },
                    onSubmit: function (modal) {
                        modal.disableButton();
                        wp.ajax.send({
                            data: this.serialize(),
                            success: function (response) {
                                WeDevs_ERP_COMPANY.designations.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                modal.showError(error);
                            }
                        });
                    }
                });
            },
        },
        //  *****************************
        //         Grades add
        //   *****************************
        grades: {
            reload: function () {
                $('.erp-company-grades-wrap').load(window.location.href + ' .erp-company-grades-wrap-inner');
            },
            /**
             finance limits   modal
             */
            create: function (e) {
                //alert('test');
                if (typeof e !== 'undefined') {
                    //e.preventDefault();
                }
                if (typeof wpErpCompany.grades_empty === 'undefined') {
                    //return;
                }
                $.erpPopup({
                    title: wpErpCompany.popup.gardes_title,
                    button: wpErpCompany.popup.gardes_submit,
                    id: "erp-new-grades-popup",
                    extraClass: 'smaller',
                    content: wperp.template('grades-create')(wpErpCompany.grades_empty).trim(),
//                    //content: '<h1>Test</h1>',
//                    onReady: function () {
//                        WeDevs_ERP_COMPANY.initDateField();
//                    },
                    /**
                     * Handle the onsubmit function
                     */
                    onSubmit: function (modal) {
                        $('button[type=submit]', '.erp-modal').attr('disabled', 'disabled');
                        wp.ajax.send('grades_create', {
                            data: this.serialize(),
                            success: function (response) {
                                console.log(response);
                                WeDevs_ERP_COMPANY.grades.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                $('.erp-modal-backdrop, .erp-modal').find('.erp-loader').addClass('erp-hide');
                                modal.showError(error);
                                console.log(error);
                            }
                        });
                    }
                });
            },
            edit: function (e) {
                e.preventDefault();
                var self = $(this);
                //alert("edit");
                $.erpPopup({
                    title: wpErpCompany.popup.gardes_edit,
                    button: wpErpCompany.popup.update,
                    id: 'erp-grades-edit',
                    extraClass: 'smaller',
                    //content: wperp.template('grades-create')().trim(),
                    onReady: function () {
                        //alert('dfhdvj');
                        var modal = this;
                        $('header', modal).after($('<div class="loader"></div>').show());
                        wp.ajax.send('grades_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCompany.nonce
                            },
                            success: function (response) {
                                console.log(response);
                                var html = wp.template('grades-create')(response);
                                $('.content', modal).html(html);
                                $('.loader', modal).remove();
                            }
                        });
                    },
                    onSubmit: function (modal) {
                        modal.disableButton();
                        wp.ajax.send({
                            data: this.serialize(),
                            success: function (response) {
                                WeDevs_ERP_COMPANY.grades.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                console.log(error);
                                modal.enableButton();
                                modal.showError(error);
                            }
                        });
                    }
                });
            },
        },
        //  *****************************
        //        Travel Desk
        //   *****************************
        traveldesk: {
            reload: function () {
                $('.erp-company-traveldesk-wrap').load(window.location.href + ' .erp-company-traveldesk-wrap-inner');
            },
            /**
             finance limits   modal
             */
            create: function (e) {
                //alert('test');
                if (typeof e !== 'undefined') {
                    //e.preventDefault();
                }
                if (typeof wpErpCompany.traveldesk_empty === 'undefined') {
                    //return;
                }
                $.erpPopup({
                    title: wpErpCompany.popup.traveldesk_title,
                    button: wpErpCompany.popup.traveldesk_submit,
                    id: "erp-new-traveldesk-popup",
                    extraClass: 'smaller',
                    content: wperp.template('traveldesk-create')(wpErpCompany.traveldesk_empty).trim(),
                    //content: '<h1>Test</h1>',
                    onReady: function () {
                        WeDevs_ERP_COMPANY.initDateField();
                    },
                    /**
                     * Handle the onsubmit function
                     */
                    onSubmit: function (modal) {
                        $('button[type=submit]', '.erp-modal').attr('disabled', 'disabled');
                        wp.ajax.send('traveldesk_create', {
                            data: this.serialize(),
                            success: function (response) {
                                console.log(response);
                                WeDevs_ERP_COMPANY.traveldesk.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                $('.erp-modal-backdrop, .erp-modal').find('.erp-loader').addClass('erp-hide');
                                modal.showError(error);
                                console.log(error);
                            }
                        });
                    }
                });
            },
            edit: function (e) {
                e.preventDefault();
                var self = $(this);
                //alert("edit");
                $.erpPopup({
                    title: wpErpCompany.popup.traveldesk_edit,
                    button: wpErpCompany.popup.update,
                    id: 'erp-traveldesk-edit',
                    extraClass: 'smaller',
                    //content: wperp.template('traveldesk-create')().trim(),
                    onReady: function () {
                        //alert('dfhdvj');
                        var modal = this;
                        $('header', modal).after($('<div class="loader"></div>').show());
                        wp.ajax.send('traveldesk_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCompany.nonce
                            },
                            success: function (response) {
                                console.log(response);
                                var html = wp.template('traveldesk-create')(response);
                                $('.content', modal).html(html);
                                $('.loader', modal).remove();
                            }
                        });
                    },
                    onSubmit: function (modal) {
                        //alert('dfhvg');
                        modal.disableButton();
                        wp.ajax.send({
                            data: this.serialize(),
                            success: function (response) {
                                console.log(response);
                                WeDevs_ERP_COMPANY.traveldesk.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                modal.showError(error);
                            }
                        });
                    }
                });
            },
        },
        //  *****************************
        //         Mileage add
        //   *****************************
        mileage: {
            reload: function () {
                $('.erp-company-mileage-wrap').load(window.location.href + ' .erp-company-mileage-wrap-inner');
            },
            /**
             mileage limits   modal
             */
            create: function (e) {
                //alert('test');
                if (typeof e !== 'undefined') {
                    //e.preventDefault();
                }
                if (typeof wpErpCompany.mileage_empty === 'undefined') {
                    //return;
                }
                $.erpPopup({
                    title: wpErpCompany.popup.mileage_title,
                    button: wpErpCompany.popup.mileage_submit,
                    id: "erp-new-mileage-popup",
                    extraClass: 'smaller',
                    content: wperp.template('mileage-create')(wpErpCompany.mileage_empty).trim(),
                    //content: '<h1>Test</h1>',
                    onReady: function () {
                        WeDevs_ERP_COMPANY.initDateField();
                    },
                    /**
                     * Handle the onsubmit function
                     */
                    onSubmit: function (modal) {
                        $('button[type=submit]', '.erp-modal').attr('disabled', 'disabled');
                        wp.ajax.send('mileage_create', {
                            data: this.serialize(),
                            success: function (response) {
                                console.log(response);
                                WeDevs_ERP_COMPANY.mileage.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                $('.erp-modal-backdrop, .erp-modal').find('.erp-loader').addClass('erp-hide');
                                modal.showError(error);
                                console.log(error);
                            }
                        });
                    }
                });
            },
            edit: function (e) {
                e.preventDefault();
                var self = $(this);
                //alert("edit");
                $.erpPopup({
                    title: wpErpCompany.popup.mileage_edit,
                    button: wpErpCompany.popup.mileage_update,
                    id: 'erp-mileage-edit',
                    extraClass: 'smaller',
                    //content: wperp.template('mileage-create')().trim(),
                    onReady: function () {
                        //alert('dfhdvj');
                        var modal = this;
                        $('header', modal).after($('<div class="loader"></div>').show());
                        wp.ajax.send('mileage_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCompany.nonce
                            },
                            success: function (response) {
                                console.log(response);
                                var html = wp.template('mileage-create')(response);
                                $('.content', modal).html(html);
                                $('.loader', modal).remove();
                                WeDevs_ERP_COMPANY.initDateField();

                                $('li[data-selected]', modal).each(function () {
                                    var self = $(this),
                                            selected = self.data('selected');

                                    if (selected !== '') {
                                        self.find('select').val(selected).trigger('change');
                                    }
                                });
                            }
                        });
                    },
                    onSubmit: function (modal) {
                        modal.disableButton();
                        wp.ajax.send({
                            data: this.serialize(),
                            success: function (response) {
                                WeDevs_ERP_COMPANY.mileage.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                modal.showError(error);
                            }
                        });
                    }
                });
            },
        },
        workflow: {
            PreTrvPol: function () {

                wp.ajax.send('save-PreTrvPol', {
                    data: {
                        select: $('#selPreTrvPol').val()
                    },
                    success: function (resp) {
                        console.log(resp);
                        switch (resp.status) {
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
                    error: function (resp) {
                        $('#p-failure').html("Something went wrong Please try again");
                        $('#failure').show();
                        $("#failure").delay(5000).slideUp(200);
                        return;
                    }

                });
            },
            PostTrvPol: function () {

                wp.ajax.send('save-PostTrvPol', {
                    data: {
                        select: $('#selPostTrvPol').val()
                    },
                    success: function (resp) {
                        console.log(resp);
                        switch (resp.status) {
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
                    error: function (resp) {
                        $('#p-failure').html("Something went wrong Please try again");
                        $('#failure').show();
                        $("#failure").delay(5000).slideUp(200);
                        return;
                    }

                });
            },
            GenExpReq: function () {

                wp.ajax.send('save-GenExpReq', {
                    data: {
                        select: $('#selGenExpReq').val()
                    },
                    success: function (resp) {
                        console.log(resp);
                        switch (resp.status) {
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
                    error: function (resp) {
                        $('#p-failure').html("Something went wrong Please try again");
                        $('#failure').show();
                        $("#failure").delay(5000).slideUp(200);
                        return;
                    }

                });
            },
            MileageReq: function () {

                wp.ajax.send('save-MileageReq', {
                    data: {
                        select: $('#selMileageReq').val()
                    },
                    success: function (resp) {
                        console.log(resp);
                        switch (resp.status) {
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
                    error: function (resp) {
                        $('#p-failure').html("Something went wrong Please try again");
                        $('#failure').show();
                        $("#failure").delay(5000).slideUp(200);
                        return;
                    }

                });
            },
            UtilityReq: function () {

                wp.ajax.send('save-UtilityReq', {
                    data: {
                        select: $('#selUtilityReq').val()
                    },
                    success: function (resp) {
                        console.log(resp);
                        switch (resp.status) {
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
                    error: function (resp) {
                        $('#p-failure').html("Something went wrong Please try again");
                        $('#failure').show();
                        $("#failure").delay(5000).slideUp(200);
                        return;
                    }

                });
            }
        },
        finance: {
            reload: function () {
                $('.erp-hr-employees-wrap').load(window.location.href + ' .erp-hr-employees-wrap-inner');
            },
            setAmount: function (e) {
                var select = $('#select-finance-approver').val();
                wp.ajax.send('get-limit-amount', {
                    data: {
                        employee_id: select
                    },
                    success: function (resp) {
                        //console.log( resp );
                        if (resp) {
                            $('#approvers_limit').show().fadeIn();
                            $('#limit_amount').val(resp.APL_LimitAmount);
                            $('#aplId').val(resp.APL_Id);
                        } else {
                            if (select == "0") {
                                $('#approvers_limit').hide().fadeOut();
                            } else {
                                $('#limit_amount').val('');
                                $('#approvers_limit').show().fadeIn();
                            }

                        }
                        //leavetypewrap.html( resp ).hide().fadeIn();
                        //leaveWrap.find( 'input[type="text"], textarea').removeAttr('disabled');
                    },
                    error: function (resp) {
                        //leavetypewrap.html( wpErpHr.empty_entitlement_text ).hide().fadeIn();
                        console.log(resp);
                    }
                });
            },
            subAmount: function (e) {
                wp.ajax.send('set-limit-amount', {
                    data: {
                        limit_amount: $('#limit_amount').val(),
                        aplId: $('#aplId').val(),
                        empid: $('#select-finance-approver').val()
                    },
                    success: function (resp) {
                        console.log(resp);
                        WeDevs_ERP_COMPANY.finance.reload();
                        switch (resp.status) {
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
                    error: function (resp) {
                        //leavetypewrap.html( wpErpHr.empty_entitlement_text ).hide().fadeIn();
                        console.log(resp);
                    }
                });
            },
            removieFinance: function (e) {
                var values = new Array();
                $.each($("input[name='id[]']:checked"), function () {
                    values.push($(this).val());
                });
                wp.ajax.send('remove-finance-approver', {
                    data: {
                        select: values,
                    },
                    success: function (resp) {
                        console.log(resp);
                        WeDevs_ERP_COMPANY.finance.reload();
                        switch (resp.status) {
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
                    error: function (resp) {
                        //leavetypewrap.html( wpErpHr.empty_entitlement_text ).hide().fadeIn();
                        console.log(resp);
                    }
                });
            }
        },
        dashboard: {
            markAnnouncementRead: function (e) {
                e.preventDefault();
                var self = $(this);

                if (!self.closest('li').hasClass('unread')) {
                    return;
                }

                wp.ajax.send('erp_hr_announcement_mark_read', {
                    data: {
                        id: self.data('row_id'),
                        _wpnonce: wpErpHr.nonce
                    },
                    success: function (res) {
                        self.closest('li').removeClass('unread');
                        self.addClass('erp-hide');
                    },
                    error: function (error) {
                        alert(error);
                    }
                });
            },
            viewAnnouncementTitle: function (e) {
                e.preventDefault();
                var self = $(this).closest('li').find('a.view-full');
                wp.ajax.send('erp_hr_announcement_view', {
                    data: {
                        id: self.data('row_id'),
                        _wpnonce: wpErpHr.nonce
                    },
                    success: function (res) {
                        $.erpPopup({
                            title: res.title,
                            button: '',
                            id: 'erp-hr-announcement',
                            content: '<p>' + res.content + '</p>',
                            extraClass: 'midium',
                        });
                        self.closest('li').removeClass('unread');
                        self.siblings('.mark-read').addClass('erp-hide');
                    },
                    error: function (error) {
                        alert(error);
                    }
                });
            },
            viewAnnouncement: function (e) {
                e.preventDefault();
                var self = $(this);

                wp.ajax.send('erp_hr_announcement_view', {
                    data: {
                        id: self.data('row_id'),
                        _wpnonce: wpErpHr.nonce
                    },
                    success: function (res) {
                        $.erpPopup({
                            title: res.title,
                            button: '',
                            id: 'erp-hr-announcement',
                            content: '<p>' + res.content + '</p>',
                            extraClass: 'midium',
                        });
                        self.closest('li').removeClass('unread');
                        self.siblings('.mark-read').addClass('erp-hide');
                    },
                    error: function (error) {
                        alert(error);
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
            afterNew: function (e, res) {
                var selectdrop = $('.erp-hr-dept-drop-down');
                wperp.scriptReload('erp_hr_script_reload', 'tmpl-erp-new-employee');
                selectdrop.append('<option selected="selected" value="' + res.id + '">' + res.title + '</option>');
                selectdrop.select2().select2("val", res.id);
            },
            /**
             * Reload the department area
             *
             * @return {void}
             */
            reload: function () {
                $('#erp-dept-table-wrap').load(window.location.href + ' #erp-dept-table-wrap');
            },
            /**
             * Template reload after insert, edit, delete
             *
             * @return {void}
             */
            tempReload: function () {
                wperp.scriptReload('erp_hr_new_dept_tmp_reload', 'tmpl-erp-new-dept');
            },
            /**
             * Create new department
             *
             * @param  {event}
             */
            create: function (e) {
                e.preventDefault();
                var self = $(this),
                        is_single = self.data('single');

                $.erpPopup({
                    title: wpErpHr.popup.dept_title,
                    button: wpErpHr.popup.dept_submit,
                    id: 'erp-hr-new-department',
                    content: wperp.template('erp-new-dept')().trim(),
                    extraClass: 'smaller',
                    onSubmit: function (modal) {
                        wp.ajax.send({
                            data: this.serialize(),
                            success: function (res) {
                                WeDevs_ERP_COMPANY.department.reload();

                                if (is_single != '1') {
                                    $('body').trigger('erp-hr-after-new-dept', [res]);
                                } else {
                                    WeDevs_ERP_COMPANY.department.tempReload();
                                }

                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.showError(error);
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
            edit: function (e) {
                e.preventDefault();

                var self = $(this);

                $.erpPopup({
                    title: wpErpHr.popup.dept_update,
                    button: wpErpHr.popup.dept_update,
                    id: 'erp-hr-new-department',
                    content: wp.template('erp-new-dept')().trim(),
                    extraClass: 'smaller',
                    onReady: function () {
                        var modal = this;

                        $('header', modal).after($('<div class="loader"></div>').show());

                        wp.ajax.send('erp-hr-get-dept', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpHr.nonce
                            },
                            success: function (response) {
                                $('.loader', modal).remove();

                                $('#dept-title', modal).val(response.name);
                                $('#dept-desc', modal).val(response.data.description);
                                $('#dept-parent', modal).val(response.data.parent);
                                $('#dept-lead', modal).val(response.data.lead);
                                $('#dept-id', modal).val(response.id);
                                $('#dept-action', modal).val('erp-hr-update-dept');

                                // disable current one
                                $('#dept-parent option[value="' + self.data('id') + '"]', modal).attr('disabled', 'disabled');

                            }
                        });
                    },
                    onSubmit: function (modal) {
                        wp.ajax.send({
                            data: this.serialize(),
                            success: function () {
                                WeDevs_ERP_COMPANY.department.reload();
                                WeDevs_ERP_COMPANY.department.tempReload();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.showError(error);
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
            remove: function (e) {
                e.preventDefault();

                var self = $(this);

                if (confirm(wpErpHr.delConfirmDept)) {
                    wp.ajax.send('erp-hr-del-dept', {
                        data: {
                            '_wpnonce': wpErpHr.nonce,
                            id: self.data('id')
                        },
                        success: function () {
                            self.closest('tr').fadeOut('fast', function () {
                                $(this).remove();
                                WeDevs_ERP_COMPANY.department.tempReload();
                            });
                        },
                        error: function (response) {
                            alert(response);
                        }
                    });
                }
            },
        },
        companyAdmin: {
            reload: function () {
                $('.erp-hr-employees-wrap').load(window.location.href + ' .erp-hr-employees-wrap-inner');
            },
            /**
             * Create a new employee modal
             *
             * @param  {event}
             */
            create: function (e) {
                if (typeof e !== 'undefined') {
                    //e.preventDefault();
                }

                if (typeof wpErpHr.employee_empty === 'undefined') {
                    //return;
                }
                $.erpPopup({
                    title: wpErpHr.popup.company_title,
                    button: wpErpHr.popup.employee_create,
                    id: "erp-new-companyadmin-popup",
                    content: wperp.template('companyadmin-create')(wpErpHr.employee_empty).trim(),
                    //content: '<h1>sss</h1>',
                    onReady: function () {
                        WeDevs_ERP_COMPANY.initDateField();
                        $('.select2').select2();
                        WeDevs_ERP_COMPANY.employee.select2Action('erp-hrm-select2');
                        WeDevs_ERP_COMPANY.employee.select2AddMoreContent();

                        $('#user_notification').on('click', function () {
                            if ($(this).is(':checked')) {
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
                    onSubmit: function (modal) {
                        $('button[type=submit]', '.erp-modal').attr('disabled', 'disabled');
                        wp.ajax.send('companyadmin_create', {
                            data: this.serialize(),
                            success: function (response) {
                                console.log(response);
                                WeDevs_ERP_COMPANY.employee.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                $('.erp-modal-backdrop, .erp-modal').find('.erp-loader').addClass('erp-hide');
                                modal.showError(error);
                                console.log(error);
                            }
                        });
                    }
                });
            },
            edit: function (e) {
                e.preventDefault();
                var self = $(this);
                //alert("edit");
                $.erpPopup({
                    title: wpErpHr.popup.employee_update,
                    button: wpErpHr.popup.employee_update,
                    id: 'erp-employee-edit',
                    onReady: function () {
                        var modal = this;

                        $('header', modal).after($('<div class="loader"></div>').show());

                        wp.ajax.send('companyadmin_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpHr.nonce
                            },
                            success: function (response) {
                                console.log(response);
                                var html = wp.template('companyadmin-create')(response);
                                $('.content', modal).html(html);
                                $('.loader', modal).remove();
                                WeDevs_ERP_COMPANY.initDateField();

                                $('li[data-selected]', modal).each(function () {
                                    var self = $(this),
                                            selected = self.data('selected');

                                    if (selected !== '') {
                                        self.find('select').val(selected).trigger('change');
                                    }
                                });

                                // disable current one
                                $('#work_reporting_to option[value="' + response.id + '"]', modal).attr('disabled', 'disabled');
                            }
                        });
                    },
                    onSubmit: function (modal) {
                        modal.disableButton();

                        wp.ajax.send({
                            data: this.serialize(),
                            success: function (response) {
                                WeDevs_ERP_COMPANY.employee.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                modal.showError(error);
                            }
                        });
                    }
                });
            },
            remove: function (e) {
                e.preventDefault();

                var self = $(this);

                if (confirm(wpErpHr.delConfirmEmployee)) {
                    wp.ajax.send('companyadmin-delete', {
                        data: {
                            _wpnonce: wpErpHr.nonce,
                            id: self.data('id'),
                            hard: self.data('hard')

                        },
                        success: function () {
                            alert("delete");
                            self.closest('tr').fadeOut('fast', function () {
                                $(this).remove();
                                WeDevs_ERP_COMPANY.companyAdmin.reload();
                            });
                        },
                        error: function (response) {
                            alert(response);
                        }
                    });
                }
            },
        },
        companyEmployee: {
            /**
             * Reload the department area
             *
             * @return {void}
             */
            reload: function () {
                $('.erp-hr-employees-wrap').load(window.location.href + ' .erp-hr-employees-wrap-inner');
            },
            /**
             * Set photo popup
             *
             * @param {event}
             */
            setPhoto: function (e) {
                e.preventDefault();
                e.stopPropagation();
                console.log("inside1");
                var frame;

                if (frame) {
                    frame.open();
                    return;
                }

                frame = wp.media({
                    title: wpErpCompany.emp_upload_photo,
                    button: {text: wpErpCompany.emp_set_photo}
                });

                frame.on('select', function () {
                    var selection = frame.state().get('selection');

                    selection.map(function (attachment) {
                        attachment = attachment.toJSON();

                        var html = '<img src="' + attachment.url + '" alt="" />';
                        html += '<input type="hidden" id="emp-photo-id" name="companyemployee[photo_id]" value="' + attachment.id + '" />';
                        html += '<a href="#" class="erp-remove-photo">&times;</a>';
                        console.log("inside2");
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

                var html = '<a href="#" id="erp-set-emp-photo" class="button button-small">' + wpErpCompany.emp_upload_photo + '</a>';
                html += '<input type="hidden" name="companyemployee[photo_id]" id="emp-photo-id" value="0">';

                $('.photo-container', '.erp-employee-form').html(html);
            },
            /**
             * Create a new employee modal
             *
             * @param  {event}
             */
            create: function (e) {
                //alert("test");
                if (typeof e !== 'undefined') {
                    //e.preventDefault();
                }

                if (typeof wpErpCompany.companyemployee_empty === 'undefined') {
                    //return;
                }
                $.erpPopup({
                    title: wpErpCompany.popup.companyemployee_title,
                    button: wpErpCompany.popup.companyemployee_create,
                    id: "erp-new-companyemployee-popup",
                    content: wperp.template('companyemployee-create')(wpErpCompany.companyemployee_empty).trim(),
                    /**
                     * Handle the onsubmit function
                     *
                     * @param  {modal}
                     */
                    onSubmit: function (modal) {
                        $('button[type=submit]', '.erp-modal').attr('disabled', 'disabled');
                        wp.ajax.send('companyemployee_create', {
                            data: this.serialize(),
                            success: function (response) {
                                console.log(response);
                                WeDevs_ERP_COMPANY.companyEmployee.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                $('.erp-modal-backdrop, .erp-modal').find('.erp-loader').addClass('erp-hide');
                                modal.showError(error);
                                console.log(error);
                            }
                        });
                    }
                });
            },
            edit: function (e) {
                e.preventDefault();
                var self = $(this);
                $.erpPopup({
                    title: wpErpCompany.popup.companyemployee_update,
                    button: wpErpCompany.popup.companyemployee_update,
                    id: 'erp-companyemployee-edit',
                    onReady: function () {
                        var modal = this;

                        $('header', modal).after($('<div class="loader"></div>').show());

                        wp.ajax.send('companyemployee_get', {
                            data: {
                                id: self.data('id'),
                                _wpnonce: wpErpCompany.nonce
                            },
                            success: function (response) {
                                console.log(response);
                                var html = wp.template('companyemployee-create')(response);
                                $('.content', modal).html(html);
                                $('.loader', modal).remove();
                                WeDevs_ERP_COMPANY.initDateField();

                                $('li[data-selected]', modal).each(function () {
                                    var self = $(this),
                                            selected = self.data('selected');

                                    if (selected !== '') {
                                        self.find('select').val(selected).trigger('change');
                                    }
                                });

                                // disable current one
                                $('#work_reporting_to option[value="' + response.id + '"]', modal).attr('disabled', 'disabled');
                            }
                        });
                    },
                    onSubmit: function (modal) {
                        modal.disableButton();

                        wp.ajax.send({
                            data: this.serialize(),
                            success: function (response) {
                                WeDevs_ERP_COMPANY.companyEmployee.reload();
                                modal.enableButton();
                                modal.closeModal();
                            },
                            error: function (error) {
                                modal.enableButton();
                                modal.showError(error);
                            }
                        });
                    }
                });
            },
            view: function (e) {
                e.preventDefault();
                var self = $(this);
                var selectEmployee = $('#selectEmployee').val();
                var tabkey = $('#key').val();
                //alert(selectEmployee);
                wp.ajax.send('companyemployee_view', {
                    data: {
                        id: selectEmployee,
                        //_wpnonce: wpErpCompany.nonce
                    },
                    success: function (response) {
                        console.log(response);
                        //var html = wp.template('companyemployee-view')( response );
                        if (selectEmployee == '0') {
                            $('#employeeview').hide();
                        } else {
                            $('#employeeview').show();
                        }
                        if (response.EMP_Photo == "") {
                            $('#EMP_Photo').html('<img alt="" src="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=32&amp;d=mm&amp;r=g" srcset="http://1.gravatar.com/avatar/19227018b81eea78a037d9d4719f68cd?s=64&amp;d=mm&amp;r=g 2x" class="avatar avatar-150 photo" height="150" width="150">');
                        } else {
                            $('#EMP_Photo').html('<img src="' + response.EMP_Photo + '" height="150" width="150">');
                        }
                        $('#EMP_Name').html(response.EMP_Name);
                        $('#EMP_Id').html(response.EMP_Id);
                        $('#EMP_Id').val(response.EMP_Id);
                        $('#EMP_Code').html(response.EMP_Code);
                        $('#EMP_Email').html(response.EMP_Email);
                        $('#EMP_Funcrepmngrcode').html(response.EMP_Funcrepmngrcode);
                        $('#EMP_Phonenumber').html(response.EMP_Phonenumber);
                        $('#EMP_Phonenumber2').html(response.EMP_Phonenumber2);
                        $('#EMP_Reprtnmngrcode').html(response.EMP_Reprtnmngrcode);
                        $("#tabs").attr("href", "http://localhost/wp-admin/admin.php?page=Profile&action=view&id=" + response.EMP_Id + "&tab=" + tabkey);
                    }
                });

            },
            remove: function (e) {
                e.preventDefault();

                var self = $(this);

                if (confirm(wpErpCompany.delConfirmEmployee)) {
                    wp.ajax.send('companyemployee-delete', {
                        data: {
                            _wpnonce: wpErpCompany.nonce,
                            id: self.data('id'),
                            hard: self.data('hard')

                        },
                        success: function () {
                            alert("delete");
                            self.closest('tr').fadeOut('fast', function () {
                                $(this).remove();
                                WeDevs_ERP_COMPANY.companyEmployee.reload();
                            });
                        },
                        error: function (response) {
                            alert(response);
                        }
                    });
                }
            },
            printData: function (e) {
                e.preventDefault();
                window.print();
            },
        },
    };

    $(function () {
        WeDevs_ERP_COMPANY.initialize();
    });



})(jQuery);


