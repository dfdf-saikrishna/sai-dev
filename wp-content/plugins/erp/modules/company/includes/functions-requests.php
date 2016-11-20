<?php
/**
 * Get the raw requests dropdown
 *
 * @param  int  company id
 *
 * @return array  the key-value paired designations
 */
function get_requests_dropdown_raw( $select_text = '' ) {
    $select_text = empty( $select_text ) ? __( '- ALL -', 'erp' ) : $select_text;
    $designations = erp_hr_get_designations( ['number' => -1 ] );
    $dropdown     = array( '-1' => $select_text );

    if ( $designations ) {
        foreach ($designations as $key => $designation) {
            $dropdown[$designation->id] = stripslashes( $designation->title );
        }
    }

    return $dropdown;
}

/**
 * Get requests dropdown
 *
 * @param  int  company id
 * @param  string  selected designation
 *
 * @return string  the dropdown
 */
function erp_hr_get_designation_dropdown( $selected = '' ) {
    $designations = get_requests_dropdown_raw();
    $dropdown     = '';

    if ( $designations ) {
        foreach ($designations as $key => $title) {
            $dropdown .= sprintf( "<option value='%s'%s>%s</option>\n", $key, selected( $selected, $key, false ), $title );
        }
    }

    return $dropdown;
}
?>