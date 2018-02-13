<?php

class GenerateotcfeeController extends AAdminController
{
    /**
     * @var string the default layout for the views. Defaults to
     * '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/admin_column3';

    public function actionIndex()
    {
        $success = false;
        $modelfilter = new Generateotcfee;
        $model = array();
        $modelledger = array();
        $modelheader = new Tjvchh;

        $sign = Sysparam::model()->find(" param_id='SYSTEM' and param_cd1='DOC_REF'")->dflg1;
        $modelfilter->otc_fee = number_format((float)'20000', 0, '.', ',');
        $modelfilter->jasa_gl_acct_cd = Sysparam::model()->find("param_id = 'OTC_JOURNAL' and param_cd1='JASA' AND PARAM_CD2='GL_A'")->dstr1;
        //'5200';
        $modelfilter->jasa_sl_acct_cd = Sysparam::model()->find("param_id = 'OTC_JOURNAL' and param_cd1='JASA' AND PARAM_CD2='GL_A'")->dstr2;
        //'100040';
        $modelfilter->ymh_gl_acct_cd = Sysparam::model()->find("param_id = 'OTC_JOURNAL' and param_cd1='YMH' AND PARAM_CD2='GL_A'")->dstr1;
        //'2510';
        $modelfilter->ymh_sl_acct_cd = Sysparam::model()->find("param_id = 'OTC_JOURNAL' and param_cd1='YMH' AND PARAM_CD2='GL_A'")->dstr2;
        //'100000';
        $modelfolder = new Tfolder;
        $modelfilter->from_dt = date('01/m/Y');
        $modelfilter->end_dt = date('t/m/Y');
        $modelfilter->jur_date = $this->getLastDay(date('t/m/Y'));
        $folder = Sysparam::model()->find("param_id='SYSTEM' and param_cd1='VCH_REF'")->dflg1;
        if ($folder == 'Y')
        {
            $modelfilter->folder_cd = 'AJ-';
        }
        if (isset($_POST['scenario']))
        {
            $scenario = $_POST['scenario'];
            $modelfilter->attributes = $_POST['Generateotcfee'];
            if ($scenario == 'filter')
            {
                $modelfilter->attributes = $_POST['Generateotcfee'];
                $modelfilter->scenario = 'filter';
                if ($modelfilter->validate())
                {
                    $temp = new  Rptgenerateotcfee('GENERATE_OTC_FEE', 'R_GENERATE_OTC_FEE', 'Generate_otc_fee.rptdesign');    
                    $temp->bgn_dt = $modelfilter->from_dt;
                    $temp->end_dt = $modelfilter->end_dt;
                    $temp->otc_fee = $modelfilter->otc_fee;
                    $temp->vp_userid = $modelfilter->user_id;
                    if($temp->validate() && $temp->executeReportGenSp()>0)
                    {
                        $model = Generateotcfee::model()->findAllBySql(Generateotcfee::GetListData($temp->vo_random_value,$modelfilter->user_id));    
                    }
                }

            }
            else if ($scenario == 'print')
            {
                $modelfilter->scenario = 'filter';
                if ($modelfilter->validate())
                    $this->redirect(array(
                        'Report',
                        'gl_otc_client_non'=>$modelfilter->jasa_gl_acct_cd,
                        'gl_otc_repo'=>$modelfilter->jasa_gl_acct_cd,
                        'gl_biaya_ymh'=>$modelfilter->ymh_gl_acct_cd,
                        'sl_otc_client_non'=>$modelfilter->jasa_sl_acct_cd,
                        'sl_otc_repo'=>$modelfilter->jasa_sl_acct_cd,
                        'sl_biaya_ymh'=>$modelfilter->ymh_sl_acct_cd,
                        'end_dt'=>$modelfilter->end_dt,
                        'bgn_dt'=>$modelfilter->from_dt,
                        'otc_fee'=>$modelfilter->otc_fee
                    ));
            }
            //scenario proses
            else
            {

                $rowCount = $_POST['rowCount'];

                $connection = Yii::app()->db;
                $transaction = $connection->beginTransaction();
                //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika
                // semua transaksi INSERT berhasil dijalankan, bila ada transaksi
                // INSERT yang gagal, transaksi akan di rollback
                $menuName = 'GENERATE OTC FEE JOURNAL';
                $modelfilter->scenario = 'proses';
                if ($modelfilter->validate())
                {
                    $sql = "SELECT GET_DOCNUM_GL(to_date('$modelfilter->jur_date','yyyy-mm-dd'),'GL') as jvch_num from dual";
                    $num = DAO::queryRowSql($sql);
                    $jvch_num = $num['jvch_num'];

                    $ip = Yii::app()->request->userHostAddress;
                    if ($ip == "::1")
                        $ip = '127.0.0.1';

                    $modelheader->ip_address = $ip;
                    $modelheader->user_id = Yii::app()->user->id;
                    $modelheader->jvch_type = 'GL';
                    $modelheader->curr_cd = 'IDR';
                    $modelheader->jvch_date = $modelfilter->jur_date;
                    $modelheader->remarks = $modelfilter->desc;
                    $modelheader->jvch_num = $jvch_num;
                    $modelheader->folder_cd = $modelfilter->folder_cd;
                    $modelheader->curr_amt = $modelfilter->tot_fee;
                    $modelheader->reversal_jur = 'N';
                    //execute header
                    if ($modelheader->validate() && $modelheader->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName) > 0)
                        $success = true;

                    //execute header jurnal
                    if ($success && $modelheader->executeSp(AConstant::INBOX_STAT_INS, $jvch_num, 1) > 0)
                        $success = true;
                    else
                    {
                        $success = false;
                    }

                    if ($rowCount == 0)
                    {

                        $modelfilter->addError('save_flg', 'Tidak ada data yang diproses');
                        $success = FALSE;
                    }

                    if ($folder == 'Y')
                    {

                        $modelfolder->fld_mon = DateTime::createFromFormat('Y-m-d', $modelfilter->jur_date)->format('my');
                        $modelfolder->folder_cd = $modelfilter->folder_cd;
                        $modelfolder->doc_date = $modelfilter->jur_date;
                        $modelfolder->doc_num = $jvch_num;
                        $modelfolder->user_id = Yii::app()->user->id;
                        $modelfolder->cre_dt = $modelheader->cre_dt;
                        if ($success && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_INS, $modelfolder->doc_num, $modelheader->update_date, $modelheader->update_seq, 1) > 0)
                            $success = true;
                        else
                        {
                            $success = false;
                        }
                    }

                    $record_seq = 1;
                    $x;
                    $client_afiliasi = '';
                    for ($x = 0; $success && $x < $rowCount; $x++)
                    {

                        $model[$x] = new Generateotcfee;
                        $modelledger[$x] = new Taccountledger;
                        $model[$x]->attributes = $_POST['Generateotcfee'][$x + 1];
                        $modelledger[$x]->xn_doc_num = $jvch_num;

                        if ($sign == 'Y')
                        {
                            $modelledger[$x]->doc_ref_num = $jvch_num;
                        }
                        $modelledger[$x]->curr_cd = 'IDR';
                        $modelledger[$x]->budget_cd = 'GL';
                        $modelledger[$x]->ledger_nar = $modelfilter->desc;
                        $modelledger[$x]->doc_date = $modelfilter->jur_date;
                        $modelledger[$x]->due_date = $modelfilter->jur_date;
                        $modelledger[$x]->record_source = 'GL';
                        $modelledger[$x]->folder_cd = $modelfilter->folder_cd;
                        $modelledger[$x]->user_id = $modelheader->user_id;
                        $modelledger[$x]->manual = 'Y';
                        $modelledger[$x]->reversal_jur = 'N';
                        $modelledger[$x]->update_date = $modelheader->update_date;
                        $modelledger[$x]->update_seq = $modelheader->update_seq;
                        $modelledger[$x]->cre_dt = $modelheader->cre_dt;
                        if (isset($_POST['Generateotcfee'][$x + 1]['save_flg']) && $_POST['Generateotcfee'][$x + 1]['save_flg'] == 'Y')
                        {

                            $modelledger[$x]->sl_acct_cd = $model[$x]->client_cd;
                            $client_cd = trim($model[$x]->client_cd);

                            $gl_acct_cd = Client::model()->find("client_cd = '$client_cd'");

                            if ($gl_acct_cd)
                            {
                                $client_afiliasi = $gl_acct_cd->cust_client_flg;
                                $gl_acct_cd = Client::model()->find("client_cd = '$client_cd'")->client_type_3;
                            }
                            $modelledger[$x]->db_cr_flg = 'D';
                            $sql = "select  trim(F_GL_ACCT_T3_JAN2016('$client_cd','D')) gl_a from dual";
                            $gl = DAO::queryRowSql($sql);
                            $gl_a = $gl['gl_a'];
                            $modelledger[$x]->gl_acct_cd = $gl_a;
                            $modelledger[$x]->curr_val = $model[$x]->sum_otc_client;
                            $modelledger[$x]->xn_val = $model[$x]->sum_otc_client;
                            $modelledger[$x]->tal_id = $record_seq;
                            $sl_acct_cd = $modelledger[$x]->sl_acct_cd;
                            $gl_a = $modelledger[$x]->gl_acct_cd;
                         

                            if ($success && $modelledger[$x]->executeSp(AConstant::INBOX_STAT_INS, $jvch_num, $record_seq, $modelheader->update_date, $modelheader->update_seq, $record_seq) > 0)
                                $success = true;
                            else
                            {
                                $success = false;
                            }
                            $record_seq++;
                        }
                        if ($modelfilter->count_uncheck > 0 && ($x + 1) == $rowCount)
                        {
                            //untuk yang tidak dicentang
                            $modelledger[$x]->curr_val = $modelfilter->tot_fee_uncheck;
                            $modelledger[$x]->xn_val = $modelfilter->tot_fee_uncheck;
                            $modelledger[$x]->sl_acct_cd = $modelfilter->jasa_sl_acct_cd;
                            $modelledger[$x]->gl_acct_cd = $modelfilter->jasa_gl_acct_cd;
                            $modelledger[$x]->ledger_nar = $modelfilter->desc . ' NONCHARGEABLE';
                            $modelledger[$x]->db_cr_flg = 'D';
                            $modelledger[$x]->tal_id = $record_seq;
                            if ($success && $modelledger[$x]->executeSp(AConstant::INBOX_STAT_INS, $jvch_num, $record_seq, $modelheader->update_date, $modelheader->update_seq, $record_seq) > 0)
                                $success = true;
                            else
                            {
                                $success = false;
                            }
                            $record_seq++;
                        }

                        if (($x + 1) == $rowCount)
                        {
                            //untuk yang tidak dicentang dan dicentang
                            $modelledger[$x]->curr_val = $modelfilter->tot_fee;
                            $modelledger[$x]->xn_val = $modelfilter->tot_fee;
                            $modelledger[$x]->sl_acct_cd = $modelfilter->ymh_sl_acct_cd;
                            $modelledger[$x]->gl_acct_cd = $modelfilter->ymh_gl_acct_cd;
                            $modelledger[$x]->xn_val = $model[$x]->sum_otc_client;
                            $modelledger[$x]->ledger_nar = $modelfilter->desc;
                            $modelledger[$x]->db_cr_flg = 'C';
                            $modelledger[$x]->tal_id = $record_seq;
                            if ($success && $modelledger[$x]->executeSp(AConstant::INBOX_STAT_INS, $jvch_num, $record_seq, $modelheader->update_date, $modelheader->update_seq, $record_seq) > 0)
                                $success = true;
                            else
                            {
                                $success = false;
                            }
                            $record_seq++;
                        }

                    }

                    if ($success)
                    {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'Data Successfully Saved');
                        $this->redirect(array('/glaccounting/generateotcfee/index'));
                    }
                    else
                    {
                        $transaction->rollback();
                    }

                }

            }
            if (DateTime::createFromFormat('Y-m-d', $modelfilter->from_dt))
                $modelfilter->from_dt = DateTime::createFromFormat('Y-m-d', $modelfilter->from_dt)->format('d/m/Y');
            if (DateTime::createFromFormat('Y-m-d', $modelfilter->end_dt))
                $modelfilter->end_dt = DateTime::createFromFormat('Y-m-d', $modelfilter->end_dt)->format('d/m/Y');
            if (DateTime::createFromFormat('Y-m-d', $modelfilter->jur_date))
                $modelfilter->jur_date = DateTime::createFromFormat('Y-m-d', $modelfilter->jur_date)->format('d/m/Y');

        }

        $this->render('index', array(
            'model'=>$model,
            'modelfilter'=>$modelfilter,
            'modelheader'=>$modelheader,
            'modelledger'=>$modelledger,
            'modelfolder'=>$modelfolder
        ));
    }

    public function actionReport($gl_otc_client_non, $gl_otc_repo, $gl_biaya_ymh, $sl_otc_client_non, $sl_otc_repo, $sl_biaya_ymh, $end_dt, $bgn_dt, $otc_fee)
    {
        $url = '';
        $modelreport = new Rptgenerateotcfee('GENERATE_OTC_FEE', 'R_GENERATE_OTC_FEE', 'Generate_otc_fee.rptdesign');

        $modelreport->gl_otc_client = '1422';
        $modelreport->gl_otc_client_non = $gl_otc_client_non;
        $modelreport->gl_otc_repo = $gl_otc_repo;
        $modelreport->gl_biaya_ymh = $gl_biaya_ymh;
        $modelreport->sl_otc_client = 'client_cd';
        $modelreport->sl_otc_client_non = $sl_otc_client_non;
        $modelreport->sl_otc_repo = $sl_otc_repo;
        $modelreport->sl_biaya_ymh = $sl_biaya_ymh;
        $modelreport->end_dt = $end_dt;
        $modelreport->bgn_dt = $bgn_dt;
        $modelreport->otc_fee = $otc_fee;

        if ($modelreport->validate() && $modelreport->executeReportGenSp() > 0)
        {
            $url = $modelreport->showReport();
        }

        $this->render('_report', array(
            'url'=>$url,
            'modelreport'=>$modelreport
        ));

    }

    public function getLastDay($date)
    {
        $x = 0;
        do
        {
            $sql = "select F_IS_HOLIDAY('$date') as num from dual";
            $cek = DAO::queryRowSql($sql);
            $x = 0;
            if ($cek['num'] == '1')
            {
                $sql = "SELECT GET_DOC_DATE(1,TO_DATE('$date','dd/mm/yyyy')) as doc_date from dual";
                $exec = DAO::queryRowSql($sql);
                $date = $exec['doc_date'];
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y');
                $x = 1;
            }
        }
        while($x=0);

        return $date;

    }

}
