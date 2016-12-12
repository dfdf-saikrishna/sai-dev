<div class="wrap erp-hr-employees" id="wp-erp">

    <div class="list-table-wrap erp-hr-employees-wrap">
        <div class="list-table-inner erp-hr-employees-wrap-inner">

            <form method="get">
                <input type="hidden" name="page" value="erp-hr-employee">
                <?php
                $traveldeskclaim_table = new \WeDevs\ERP\Traveldesk\Traveldesk_Claims_List_Table();
                $traveldeskclaim_table->prepare_items();
                $traveldeskclaim_table->search_box( __( 'Search Employee', 'erp' ), 'erp-employee-search' );

//                if ( current_user_can( erp_hr_get_manager_role() ) ) {
//                    $employee_table->views();
//                }

                $traveldeskclaim_table->display();
                ?>
            </form>

        </div><!-- .list-table-inner -->
    </div><!-- .list-table-wrap -->

</div>
