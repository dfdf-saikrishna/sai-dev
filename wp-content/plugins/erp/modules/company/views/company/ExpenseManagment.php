
    <div  class="wrap erp-company-expense">
        <h2>Company Expense Policy</h2>
        <?php
        $pdf = 0;
        if ($expense = get_expense()) {
            $pdf = 1;
        } else {
            $pdf = 0;
        }
        ?>
        <?php if ($pdf) { ?>
            <label class="color">UPDATE<strong> Company Expense Policy </strong></label>
        <?php } else { ?>
            <label class="color">UPLOAD<strong> Company Expense Policy </strong></label>
        <?php } ?>
    </div>
    <div class="wrap erp-company-expense">
        <label class="control-label">Upload Company Expense Policy Document</label>
        <div>
            <div id="fileDiv">
                <script>
                    function upload()
                        bkp=document.getElementById('fileDiv').innerHTML;
                        document.getElementById('fileDiv').innerHTML="<input type='file' name='fileComplogo' id='fileComplogo' onchange='Validate(this.id);'  />&nbsp;<a href='javascript:cancelImg()'>Cancel</a>";
                </script>
                <?php
                if ($expense) {
                    ?>
                    <a href='javascript:upload()'><img src="E:\xampp\htdocs\wordpress\wp-content\plugins\erp\assets\images" title="click to upload new document" /> </a>
                <?php } else { ?>
                    <a  href="javascript:upload();">Upload Now</a>
                <?php } ?>
            </div>
              <div>
                  <button type="submit"  id="submiaddpdf">Submit</button>
                  <button type="button"> Cancel</button>
                </div>
            <input type="hidden" name="oldfile" id="oldfile" value="<?php echo $selpol['TEPD_Filename']; ?>" />
        </div>
    </div>