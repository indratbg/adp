<?php

class CashdividenController extends AAdminController
{

    public $layout = '//layouts/admin_column3';

    public function actionIndex()
    {
        $cek_pape = Sysparam::model()->find("param_id='CASH DIVIDEN' AND PARAM_CD1='PAPE' ")->dflg1;

        $modeldummy = new Tcorpact;
        $modeldummy->distrib_dt = Date('d/m/Y', strtotime('-100 days'));
        $model = Tcorpact::model()->findAllBySql(Rptcashdividen::retrieveData('%', $modeldummy->distrib_dt, '', $cek_pape));

        if (isset($_POST['scenario']))
        {
            $scenario = $_POST['scenario'];
            if ($scenario == 'filter')
            {
                $modeldummy->attributes = $_POST['Tcorpact'];
                $stk_cd = $modeldummy->stk_cd ? $modeldummy->stk_cd : '%';
                $model = Tcorpact::model()->findAllBySql(Rptcashdividen::retrieveData($stk_cd, $modeldummy->distrib_dt, $modeldummy->recording_dt, $cek_pape));
            }
        }

        if (DateTime::createFromFormat('Y-m-d', $modeldummy->distrib_dt))
            $modeldummy->distrib_dt = DateTime::createFromFormat('Y-m-d', $modeldummy->distrib_dt)->format('d/m/Y');
        if (DateTime::createFromFormat('Y-m-d', $modeldummy->recording_dt))
            $modeldummy->recording_dt = DateTime::createFromFormat('Y-m-d', $modeldummy->recording_dt)->format('d/m/Y');

        $this->render('index', array(
            'model'=>$model,
            'modeldummy'=>$modeldummy
        ));
    }

    public function actionPilih($stk_cd, $cum_dt, $recording_dt, $distrib_dt)
    {

        $cek_pape = Sysparam::model()->find("param_id='CASH DIVIDEN' AND PARAM_CD1='PAPE' ")->dflg1;
        $model = Tcorpact::model()->find(" ca_type='CASHDIV' AND stk_cd='$stk_cd' and distrib_dt='$distrib_dt' and cum_dt='$cum_dt' and recording_dt='$recording_dt' ");
        $stk_div = Tcorpact::model()->find(" ca_type='STKDIV' AND stk_cd='$stk_cd' and distrib_dt='$distrib_dt' and cum_dt='$cum_dt' and recording_dt='$recording_dt' ");
        $model->client_cd = '0';
        $model->branch = '0';
        $model->from_qty = isset($stk_div->from_qty)?$stk_div->from_qty:0;
        $model->to_qty = isset($stk_div->to_qty)?$stk_div->to_qty:0;
        $model->price = isset($stk_div->rate)?$stk_div->rate:0;
        $modelreport = new Rptcashdividen('LIST_OF_CASH_DIVIDEN', 'R_T_CASH_DIVIDEN', 'List_of_cash_dividen.rptdesign');
        //$stk_cd = Counter::model()->findAllBySql("select distinct b.stk_cd||'-'||b.stk_desc stk_desc, a.stk_cd from 
			//		t_corp_act a, mst_counter b where a.stk_cd=b.stk_cd 
				//	and a.ca_type='CASHDIV'
					//and a.approved_stat='A'");

        if (DateTime::createFromFormat('Y-m-d H:i:s', $model->distrib_dt))
            $model->distrib_dt = DateTime::createFromFormat('Y-m-d H:i:s', $model->distrib_dt)->format('d/m/Y');
        if (DateTime::createFromFormat('Y-m-d H:i:s', $model->recording_dt))
            $model->recording_dt = DateTime::createFromFormat('Y-m-d H:i:s', $model->recording_dt)->format('d/m/Y');

        $bgn_client_cd = '';
        $end_client_cd = '';
        $bgn_branch = '';
        $end_branch = '';

        if (isset($_POST['savePilih']))
        {

            $model->attributes = $_POST['Tcorpact'];

            if (DateTime::createFromFormat('d/m/Y', $model->distrib_dt))
                $model->distrib_dt = DateTime::createFromFormat('d/m/Y', $model->distrib_dt)->format('Y-m-d');
            if (DateTime::createFromFormat('d/m/Y', $model->recording_dt))
                $model->recording_dt = DateTime::createFromFormat('d/m/Y', $model->recording_dt)->format('Y-m-d');
            if (DateTime::createFromFormat('Y-m-d H:i:s', $model->cum_dt))
                $model->cum_dt = DateTime::createFromFormat('Y-m-d H:i:s', $model->cum_dt)->format('Y-m-d');

            if ($model->price == "")
            {
                $model->price = 0;
            }
            if ($model->from_qty == "")
            {
                $model->from_qty = 0;
            }
            if ($model->to_qty == "")
            {
                $model->to_qty = 0;
            }
            if ($model->rate == "")
            {
                $model->rate = 0;
            }
            if ($model->client_cd == 0)
            {
                $bgn_client_cd = '%';
                $end_client_cd = '_';
            }
            else
            {
                $bgn_client_cd = $model->dropdown_client;
                $end_client_cd = $model->dropdown_client;
            }
            if ($model->branch == 0)
            {
                $bgn_branch = '%';
                $end_branch = '_';
            }
            else
            {
                $bgn_branch = $model->dropdown_branch;
                $end_branch = $model->dropdown_branch;
            }

            $modelreport->recording_dt = $model->recording_dt;
            $modelreport->stk_cd = $model->stk_cd;
            $modelreport->distrib_dt = $model->distrib_dt;
            $modelreport->pembagi = $model->from_qty;
            $modelreport->pengali = $model->to_qty;
            $modelreport->price = $model->price;
            $modelreport->end_branch = $end_branch;
            $modelreport->bgn_branch = $bgn_branch;
            $modelreport->bgn_client = $bgn_client_cd;
            $modelreport->end_client = $end_client_cd;
            $modelreport->rate = $model->rate;

            $date = date_create("$model->cum_dt");
            $date = date_format($date, "Y-m-01");

            $modelreport->bgn_dt = $date;
            $modelreport->cum_dt = $model->cum_dt;
            $modelreport->rvpv_number = $model->payrec_num;

            if ($modelreport->validate() && $modelreport->executeReportGenSp() > 0)
            {
                $connection = Yii::app()->dbrpt;
                $transaction = $connection->beginTransaction();

                $modelDeleteToken = Token::model()->find("user_id =:user_id AND module =:module", array(
                    ':user_id'=>$modelreport->vp_userid,
                    ':module'=>'LIST_OF_CASH_DIVIDEN'
                ));
                if ($modelDeleteToken != null)
                {

                    $query = "CALL SP_RPT_REMOVE_RAND(:VP_TABLE_NAME,:VP_RAND_VALUE,:VO_ERRCD,:VO_ERRMSG)";
                    $command = $connection->createCommand($query);
                    $command->bindValue(":VP_TABLE_NAME", $modelDeleteToken->tablename, PDO::PARAM_STR);
                    $command->bindValue(":VP_RAND_VALUE", $modelDeleteToken->random_value, PDO::PARAM_STR);
                    $command->bindParam(":VO_ERRCD", $modelreport->vo_errcd, PDO::PARAM_INT, 10);
                    $command->bindParam(":VO_ERRMSG", $modelreport->vo_errmsg, PDO::PARAM_STR, 100);
                    $command->execute();
                    $modelDeleteToken->delete();
                }

                $cek = Tcontracts::model()->find("contr_dt = '$model->cum_dt' and contr_stat <> 'C' ");

                if (!$cek)
                {
                    $modelreport->addError('cum_dt', 'Tidak ada transaksi pada tanggal ' . DateTime::createFromFormat('Y-m-d', $model->cum_dt)->format('d M Y'));
                }
                else
                {

                    $this->redirect(array(
                        'Report',
                        'random_value'=>$modelreport->vo_random_value,
                        'user_id'=>$modelreport->vp_userid,
                        'stk_cd'=>$modelreport->stk_cd,
                        'rvpv_number'=>$modelreport->rvpv_number
                    ));
                }

            }
        }

        if (DateTime::createFromFormat('Y-m-d', $model->distrib_dt))
            $model->distrib_dt = DateTime::createFromFormat('Y-m-d', $model->distrib_dt)->format('d/m/Y');
        if (DateTime::createFromFormat('Y-m-d', $model->recording_dt))
            $model->recording_dt = DateTime::createFromFormat('Y-m-d', $model->recording_dt)->format('d/m/Y');

        $this->render('_form', array(
            'model'=>$model,
            //'stk_cd'=>$stk_cd,
            'modelreport'=>$modelreport
        ));
    }

    public function actionReport($random_value, $user_id, $stk_cd, $rvpv_number)
    {

        $modelreport = new Rptcashdividen('LIST_OF_CASH_DIVIDEN', 'R_T_CASH_DIVIDEN', 'List_of_cash_dividen.rptdesign');
        $cek_pape = Sysparam::model()->find("param_id='CASH DIVIDEN' AND PARAM_CD1='PAPE' ")->dflg1;
        $success = false;
        $diff = false;
        $save = false;
        $false_save = false;
        $cek_data = false;
        $url = '';
        $modelreport->vo_random_value = $random_value;
        $modelreport->vp_userid = $user_id;
        $modelreport->rvpv_number = $rvpv_number;
        if (isset($_POST['save']))
        {

            if ($modelreport->validate() && $modelreport->executeSp() > 0)
            {
                $success = true;
            }
            else
            {
                $success = false;
            }
            if ($success)
            {
                Yii::app()->user->setFlash('success', 'Data Successfully Saved');
                $this->redirect(array('index'));
            }
        }
        else
        {
            if ($cek_pape == 'Y')
            {

                $sql = "SELECT COUNT(*) AS SELISIH FROM INSISTPRO_RPT.R_T_CASH_DIVIDEN WHERE SELISIH>0 AND USER_ID='$modelreport->vp_userid' AND RAND_VALUE='$modelreport->vo_random_value'";
                $selisih = DAO::queryRowSql($sql);
                $sql2 = "SELECT NVL(SUM(QTY),0) AS QTY FROM T_CASH_DIVIDEN WHERE CA_TYPE='CASHDIV' AND STK_CD='$stk_cd'";
                $qty = Tcashdividen::model()->findBySql($sql2);

                $sql3 = "SELECT SUM(ONH) AS ONH FROM INSISTPRO_RPT.R_T_CASH_DIVIDEN WHERE rand_value='$random_value' and USER_ID='$user_id' and stk_cd='$stk_cd'";
                $onh = DAO::queryRowSql($sql3);
                //$sql4="SELECT SUM(ONH) AS ONH FROM
                // INSISTPRO_RPT.R_T_CASH_DIVIDEN WHERE
                // rand_value='$random_value' and USER_ID='$user_id' and
                // stk_cd='$stk_cd'";

                if ($onh['onh'] != $qty->qty)
                {
                    $save = true;
                }

                if ($selisih['selisih'] != 0)
                {

                    $diff = true;
                }

                $sql4 = "SELECT CA_TYPE,STK_CD,CLIENT_CD,distrib_dt,QTY,RATE, GROSS_AMT,TAX_AMT, DIV_AMT, CUM_QTY,ONH, SELISIH_QTY,
						 (CUM_QTY + SELISIH_QTY) as qty2 FROM INSISTPRO_RPT.R_T_CASH_DIVIDEN
						WHERE RAND_VALUE= '$modelreport->vo_random_value' AND USER_ID='$modelreport->vp_userid'";
                $ttl_data = DAO::queryAllSql($sql4);

                foreach ($ttl_data as $row)
                {
                    $client_cd = $row['client_cd'];
                    $distrib_dt = $row['distrib_dt'];
                    $cash_div = Tcashdividen::model()->find("ca_type='CASHDIV' and stk_cd = '$stk_cd' and client_cd = '$client_cd' and distrib_dt = '$distrib_dt'");

                    if ($cash_div)
                    {

                        if ($row['qty2'] != $cash_div->qty || $row['rate'] != $cash_div->rate || $row['gross_amt'] != $cash_div->gross_amt || $row['tax_amt'] != $cash_div->tax_amt || $row['div_amt'] != $cash_div->div_amt || $row['cum_qty'] != $cash_div->cum_qty || $row['onh'] != $cash_div->onh || $row['selisih_qty'] != $cash_div->selisih_qty)
                        {
                            //echo "<script>alert('test123')</script>";
                            $false_save = TRUE;
                            break;
                        }
                        /*
                         else{
                         $cek_data=true;
                         }*/

                    }

                }

            }//end cek pape=Y
            else
            {
                //CEK PAPE='N'
                $sql = " SELECT cum_dt, recording_dt,stk_cd FROM INSISTPRO_RPT.R_T_CASH_DIVIDEN where RAND_VALUE= '$modelreport->vo_random_value' AND USER_ID='$modelreport->vp_userid' ";
                $cek_date = DAO::queryRowSql($sql);
                $recording_dt = $cek_date['recording_dt'];
                $cum_dt = $cek_date['cum_dt'];
                $stk_cd = $cek_date['stk_cd'];
                if (DateTime::createFromFormat('Y-m-d H:i:s', $recording_dt))
                    $recording_dt = DateTime::createFromFormat('Y-m-d H:i:s', $recording_dt)->format('Y-m-d');
                if (DateTime::createFromFormat('Y-m-d H:i:s', $cum_dt))
                    $cum_dt = DateTime::createFromFormat('Y-m-d H:i:s', $cum_dt)->format('Y-m-d');

                if ($cek_pape == 'N' && date('Y-m-d') > $recording_dt)
                {

                    $false_save = true;
                }
            }

            /*
             $cek_div = Tcashdividen::model()->find("stk_cd='$stk_cd' ");
             if(!$cek_div)
             {
             $false_save=true;
             }
             *
             */

            $url = $modelreport->showReport();
        }
        $this->render('_report', array(
            'url'=>$url,
            'modelreport'=>$modelreport,
            'diff'=>$diff,
            'save'=>$save,
            'false_save'=>$false_save,
            'cek_data'=>$cek_data,
            'cek_pape'=>$cek_pape
        ));
    }

}
?>