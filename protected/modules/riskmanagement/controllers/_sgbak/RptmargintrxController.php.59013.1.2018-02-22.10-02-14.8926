<?php

class RptmargintrxController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Rptmargintrx('MARGIN_TRANSACTION', 'R_MARGIN_TRX', 'Margin_Trx_with_Capping_0.rptdesign');
        $model->bgn_date = date('01/m/Y');
        $model->end_date = date('t/m/Y');
        $url = '';
        $url_xls = '';
        if (isset($_POST['Rptmargintrx']))
        {
            $model->attributes = $_POST['Rptmargintrx'];
            
            if ($model->validate() && $model->executeRpt() > 0)
            {
                $bgn_date = DateTime::createFromFormat('Y-m-d',$model->bgn_date)->format('d M Y');
                $end_date = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d M Y');
                $rpt_link = $model->showReport($bgn_date,$end_date);
                $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                $url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
            }

        }
        if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
            $model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
        if (DateTime::createFromFormat('Y-m-d', $model->end_date))
            $model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

        $this->render('index', array(
            'model' => $model,
            'url' => $url
        ));
    }

}
