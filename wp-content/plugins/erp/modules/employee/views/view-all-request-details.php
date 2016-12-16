<div class="postbox">
                <div class="inside">
                    <h2>My Pre Travel Expense Requests</h2>
                    <?php
                    $table = new WeDevs\ERP\Employee\My_Pre_Travel_Expenses();
                    $table->prepare_items();

                    $message = '';
                    if ('delete' === $table->current_action()) {
                        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'companies_table_list'), count($_REQUEST['id'])) . '</p></div>';
                    }
                    ?>
                <div class="list-table-wrap erp-hr-employees-wrap">
                    <div class="list-table-inner erp-hr-employees-wrap-inner">
                        <?php echo $message;?>
                        <?php //$table->views(); ?>
                        <form method="post">
                          <input type="hidden" name="page" value="Requests" />
                          <?php $table->search_box('Search Request Code', 'search_id'); ?>
                        </form>

                        <form method="GET">
                            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                            <?php $table->display() ?>
                        </form>

                    </div>
                </div>
                </div>
            </div>
            <div class="postbox">
                <div class="inside">
                    <h2>My Post Travel Expense Requests</h2>
                    <?php
                    $table = new WeDevs\ERP\Employee\My_Post_Travel_Expenses();
                    $table->prepare_items();

                    $message = '';
                    if ('delete' === $table->current_action()) {
                        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'companies_table_list'), count($_REQUEST['id'])) . '</p></div>';
                    }
                    ?>
                <div class="list-table-wrap erp-hr-employees-wrap">
                    <div class="list-table-inner erp-hr-employees-wrap-inner">
                        <?php echo $message;?>
                        <?php //$table->views(); ?>
                        <form method="post">
                          <input type="hidden" name="page" value="Requests" />
                          <?php $table->search_box('Search Request Code', 'search_id'); ?>
                        </form>

                        <form method="GET">
                            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                            <?php $table->display() ?>
                        </form>

                    </div>
                </div>
                </div>
            </div>