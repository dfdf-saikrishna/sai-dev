<?php

    function count_query($table_name,$fieldname,$condition,$filename, $show=false){

            global $wpdb;

            $selcount="SELECT COUNT($fieldname) AS cnt FROM $table_name $condition";
            if($show){
                    echo $selcount; exit;
            }
            $rescount=$wpdb->get_results($selcount);
            //$rowcount=$rescount->fetch_assoc();

            $error=0;
            if (!$rescount) {

                    $errordesc=$wpdb->error; //error desc
                    $errordesc1=addslashes($errordesc);

                    $error=1; //query failed
            }
            if($error==1)
            {


//                    $mailmsg="Count query = ".$selcount."\n"." Filename= ".$filename."\n"." Error =".$error."\n"." Error Desc =".$errordesc;
//
//
//                            mail("rahul@thefirstventure.com", "query failed", $mailmsg);
//
//
//                            $delete=addslashes($selcount);
//
//                    sqlCommand($selcount,$filename,$error, $errordesc1);
            }


                    //$rescount->free();



                    if(!$error)
                    return $rescount[0]->cnt;

    }
?>