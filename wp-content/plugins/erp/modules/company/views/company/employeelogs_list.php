<div class="wrap erp-hr-company" id="wp-erp">

    <h2>
        <?php
        _e( 'Employee Logs', 'erp' );
        ?>
    </h2>

    <div class="list-table-wrap erp-hr-employees-wrap">
        <div class="list-table-inner erp-hr-employees-wrap-inner">

            <form method="get">
                <input type="hidden" name="page" value="erp-hr-employee">
                <?php
                $employeelog_table = new \WeDevs\ERP\Company\Employeelogs_List_Table();
                $employeelog_table->prepare_items();
                //$employee_table->search_box( __( 'Search Employee', 'erp' ), 'erp-employee-search' );

                if ( current_user_can('companyadmin') ) {
                    $employeelog_table->views();
                }

                $employeelog_table->display();
                ?>
            </form>

        </div><!-- .list-table-inner -->
    </div><!-- .list-table-wrap -->

</div>
