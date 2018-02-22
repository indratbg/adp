<?php

class RptavailableassetsController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Rptavailableassets('AVAILABLE ASSETS', 'R_AVAILABLE_ASSETS', 'Available_assets.rptdesign');
        $model->end_date = date('d/m/Y');
        $url = '';
        $url_xls = '';
        if (isset($_POST['Rptavailableassets']) && isset($_POST['scenario']))
        {

            $model->attributes = $_POST['Rptavailableassets'];
            $scenario = $_POST['scenario'];
            if ($scenario == 'print')
            {
                if ($model->validate() && $model->executeRpt() > 0)
                {
                    $bgn_date = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d-M-Y');
                    $rpt_link = $model->showReport($bgn_date, $bgn_date);
                    $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                    $url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
                }
            }
            //export excel
            else
            {
                $user_id = Yii::app()->user->id;
                $condition = " where rand_value=$model->vo_random_value and user_id='$user_id' order by SL_ACCT_CD";
                $this->ExportToExcel('INSISTPRO_RPT', $model, $condition, 'Available Fund');

            }
        }
        if (DateTime::createFromFormat('Y-m-d', $model->end_date))
            $model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');
        $this->render('index', array(
            'model'=>$model,
            'url'=>$url,
            'url_xls'=>$url_xls
        ));
    }

}
