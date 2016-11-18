<?php
function erp_hr_financelimits_get_statuses( $status = false ) {
    $statuses = array(
        'all' => __( 'All', 'erp' ),
        '1'   => __( 'Approved', 'erp' ),
        '2'   => __( 'Pending', 'erp' ),
        '3'   => __( 'Rejected', 'erp' )
    );

    if ( false !== $status && array_key_exists( $status, $statuses ) ) {
        return $statuses[ $status ];
    }

    return $statuses;
}
function erp_company_url_single_financlimitseview($com_id) {

    $url = admin_url( 'admin.php?page=FinaceEmp&action=view&id=' . $com_id);

    return apply_filters( 'erp_company_url_single_financeview', $url, $com_id );
}
