<?php
global $wpdb;
$compid = $_SESSION['compid'];
if ($row->REQ_Claim) {

    $selrow = $wpdb->get_results("SELECT * FROM payment_details WHERE REQ_Id='$reqid' AND PD_Status=1");
    ?>

    <br />
    <div class="col-xs-offset-4">
        <section class="panel">
            <header class="panel-heading">
                <h3>Payment Details</h3>
            </header>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">Payment mode</label>
                    <div>
                        <select class="form-control" name="selPaymentMode" id="selPaymentMode" disabled="disabled">
                            <option value="">Select</option>
                            <?php
                            $selsql =$wpdb->get_results("SELECT * FROM payment_details ");

                            foreach ($selsql as $rowsql) {
                                ?>
                                <option value="<?php echo $rowsql->PM_Id; ?>" <?php echo ($selrow->PM_Id == $rowsql->PM_Id) ? 'selected="selected"' : ''; ?> ><?php echo $rowsql->PM_Name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div id="chequeid" <?php echo ($selrow->PM_Id == 1) ? 'style="display:block;"' : 'style="display:none;"'; ?>  >
                    <div class="form-group">
                        <label class="control-label">Cheque Number</label>
                        <div>
                            <input type="text" class="form-control" name="txtChequeNumber" id="txtChequeNumber" readonly="readonly"  <?php echo ($selrow->PD_ChequeNumber) ? 'value="' . $selrow->PD_ChequeNumber . '"' : ''; ?> />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Cheque Date</label>
                        <div>
                            <input type="text" <?php /* ?>name="txtDate[]"<?php */ ?> name="txtCqDate" id="txtCqDate" readonly="readonly" class="form-control"  <?php echo ($selrow->PD_ChequeDate) ? 'value="' . $selrow->PD_ChequeDate . '"' : ''; ?>>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Issuing Bank</label>
                        <div>
                            <input type="text" class="form-control" name="txtBankBranch" id="txtBankBranch" readonly="readonly"  <?php echo ($selrow->PD_ChequeIssuingbb) ? 'value="' . $selrow->PD_ChequeIssuingbb . '"' : ''; ?>/>
                        </div>
                    </div>
                </div>
                <div id="cashid" <?php echo ($selrow->PM_Id == 2) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                    <div class="form-group">
                        <label class="control-label">Payment Details</label>
                        <div>
                            <textarea class="form-control" data-height="auto" name="txtaCshComments" readonly="readonly" id="txtaCshComments" ><?php echo ($selrow->PD_CashPaymentDetails) ? stripslashes($selrow->PD_CashPaymentDetails) : ''; ?>
                            </textarea>
                        </div>
                    </div>
                </div>
                <div id="banktransferid" <?php echo ($selrow->PM_Id == 3) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                    <div class="form-group">
                        <label class="control-label">Transaction Id</label>
                        <div>
                            <input type="text" class="form-control" name="txtTransId" id="txtTransId"  readonly="readonly"  <?php echo ($selrow->PD_BTTransactionId) ? 'value="' . $selrow->PD_BTTransactionId . '"' : ''; ?>/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Bank Name</label>
                        <div>
                            <input type="text" class="form-control" name="txtBankdetails" id="txtBankdetails"  readonly="readonly"  <?php echo ($selrow->PD_BTBankDetails) ? 'value="' . $selrow->PD_BTBankDetails . '"' : ''; ?>/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Transaction Date</label>
                        <div>
                            <input type="text" name="txtBBDate" id="txtBBDate"  readonly="readonly" class="form-control"  <?php echo $selrow->PD_BTTransferDate ? 'value="' . $selrow->PD_BTTransferDate . '"' : ''; ?>>
                        </div>
                    </div>
                </div>
                <div id="othersid" <?php echo ($selrow->PM_Id == 4) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
                    <div class="form-group">
                        <label class="control-label">Payment Details</label>
                        <div>
                            <textarea class="form-control" data-height="auto" name="txtaOtherComments"  readonly="readonly" ><?php echo ($selrow->PD_OthersPaymentDetails) ? stripslashes($selrow->PD_OthersPaymentDetails) : ''; ?>
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php } ?>
