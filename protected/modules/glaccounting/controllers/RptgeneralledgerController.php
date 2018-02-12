<?php

class RptgeneralledgerController extends AAdminController
{

    public $layout = '//layouts/admin_column3';

    public function actionIndex()
    {
        $model = new Rptgeneralledger('GENERAL_LEDGER', 'R_GENERAL_LEDGER_REG', 'General_legder.rptdesign');
        $gl_a = Glaccount::model()->findAll(array(
            'select'=>"trim(gl_a) gl_a,gl_a||' - '||acct_name acct_name",
            'condition'=>"approved_stat='A' 
				 and sl_a='000000' AND acct_stat = 'A'",
            'order'=>'gl_a'
        ));
        $model->year = date('Y');
        $model->bgn_date = date('01/m/Y');
        $model->end_date = date('t/m/Y');
        $model->report_mode = 0;
        $model->cancel_flg = '1';
        $model->branch_option = 0;
        $model->month = date('m');
        $url = '';
        if (isset($_POST['Rptgeneralledger']) && isset($_POST['scenario']))
        {
            $model->attributes = $_POST['Rptgeneralledger'];
            $scenario = $_POST['scenario'];
            if ($scenario == 'print')
            {

                if ($model->from_gla == '')
                {
                    $bgn_acct = '%';
                    $end_acct = '_';
                }
                else
                {
                    $bgn_acct = $model->from_gla;
                    $end_acct = $model->to_gla;
                }
                if ($model->from_sla == '')
                {
                    $bgn_sub = '%';
                    $end_sub = '_';
                }
                else
                {
                    $bgn_sub = $model->from_sla;
                    $end_sub = $model->to_sla;
                }

                $branch_cd = $model->branch_option == '0' ? '%' : $model->branch_cd;
                //$reversal_flg = $model->cancel_flg =='0'?'Y':'N';
                $reversal_flg = 'Y';

                $mode = $model->report_mode == '0' ? 'REGULAR' : 'ACCT';
                if ($model->report_mode == '0')
                {
                    $mode = 'REGULAR';
                    $model->tablename = 'R_GENERAL_LEDGER_REG';
                }
                else
                {
                    $mode = 'ACCT';
                    $model->tablename = 'R_GENERAL_LEDGER_ACCT';
                    $model->rptname = 'General_Ledger_Acct.rptdesign';
                }

                if ($model->validate() && $model->executeRpt($bgn_acct, $end_acct, $bgn_sub, $end_sub, $branch_cd, $mode, $reversal_flg) > 0)
                {
                    $rpt_link = $model->showReport();
                    $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                }
            }
            else
            {
                //export
                  $user_id=Yii::app()->user->id;
                if ($model->report_mode == '0')
                {
                    $condition = "where user_id= '$user_id' and rand_value=$model->vo_random_value order by sortk1, doc_date, seqno";
                    $this->ExportToExcel('INSISTPRO_RPT', $model, $condition, 'General Ledger Regular');
                }
                else
                {
                    $model->tablename = 'R_GENERAL_LEDGER_ACCT';
                    $condition = "where user_id= '$user_id' and rand_value=$model->vo_random_value order by gl_acct_cd, doc_date";
                    $model->col_name = $model->col_name_acct;
                    //$this->getDataXLS($model, 'INSISTPRO_RPT');
                    $this->ExportToExcel('INSISTPRO_RPT', $model, $condition, 'General Ledger Acct');
                }
            }

        }
        if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
            $model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
        if (DateTime::createFromFormat('Y-m-d', $model->end_date))
            $model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

        $this->render('index', array(
            'model'=>$model,
            'gl_a'=>$gl_a,
            'url'=>$url
        ));
    }

}
