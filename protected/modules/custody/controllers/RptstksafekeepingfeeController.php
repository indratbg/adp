<?php

class RptstksafekeepingfeeController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Rptstksafekeepingfee('STOCK SAFE KEEPING FEE', 'R_SAFE_KEEPING_FEE', 'Stock_safe_keeping_fee_summary.rptdesign');
        $url = '';
        $model->client_option = '0';
        $model->from_dt = date('d/m/Y');
        $model->to_dt = date('d/m/Y');
        $model->rpt_type = 0;

        if (isset($_POST['Rptstksafekeepingfee']))
        {
            $model->attributes = $_POST['Rptstksafekeepingfee'];
            $scenario = $_POST['scenario'];
            if ($scenario == 'print')
            {
                $bgn_client = '';
                $end_client = '';
                if ($model->client_option == '0')
                {
                    $bgn_client = '%';
                    $end_client = '_';
                }
                else
                {
                    $bgn_client = $model->client_cd;
                    $end_client = $model->client_cd;
                }
                $rpt_type = $model->rpt_type == '0' ? 'SUMMARY' : 'DETAIL';
                $bgn_subrek = $model->bgn_subrek ? $model->bgn_subrek : '%';
                $end_subrek = $model->end_subrek ? $model->end_subrek : '_';
                if ($rpt_type == 'DETAIL')
                {
                    $model->rptname = 'Stock_safe_keeping_fee_detail.rptdesign';
                }

                if ($model->validate() && $model->executeSPStock($bgn_client, $end_client, $bgn_subrek, $end_subrek, $rpt_type) > 0)
                {
                    $bgn_date = DateTime::createFromFormat('Y-m-d', $model->from_dt)->format('01-M-Y');
                    $end_date = DateTime::createFromFormat('Y-m-d', $model->from_dt)->format('d-M-Y');
                    $url = $model->showReport($bgn_date, $end_date) . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                }

 /*
  $locale = '&__locale=in_ID';
             $param = '&ACC_TOKEN=' . 'XX' . '&ACC_USER_ID=' . 'INDRATBG' .
            '&RP_RANDOM_VALUE=' . '731731916';
             $rpt_link = Constanta::URL . $model->rptname . $locale . $param;
             $url = $rpt_link .
            '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
             $url_xls = $rpt_link .
            '&&__dpi=96&__format=xlsx&__pageoverflow=0&__overwrite=false&#zoom=100';
            */
            }
            //export
            else
            {
                $user_id = Yii::app()->user->id;
                $model->tablename = 'R_SAFE_KEEPING_FEE';
                //summary by client
                if ($model->rpt_type == '0')
                {
                    $model->col_name = $model->col_name_summary;
                    $condition = "where user_id= '$user_id' and rand_value=$model->vo_random_value group by client_cd,subrek order by client_cd,subrek ";
                    $this->ExportToExcel('INSISTPRO_RPT', $model, $condition, 'STOCK SAFE KEEPING FEE');
                }
                //detail
                else
                {
                    $user_id = Yii::app()->user->id;
                    $model->tablename = 'R_SAFE_KEEPING_FEE';
                    $condition = "where user_id= '$user_id' and rand_value=$model->vo_random_value order by client_cd,doc_dt,stk_cd ";
                    $this->ExportToExcel('INSISTPRO_RPT', $model, $condition, 'STOCK SAFE KEEPING FEE');
                }
            }
        }

        if (DateTime::createFromFormat('Y-m-d', $model->from_dt))
            $model->from_dt = DateTime::createFromFormat('Y-m-d', $model->from_dt)->format('d/m/Y');
        $this->render('index', array(
            'model'=>$model,
            'url'=>$url
        ));
    }

}
