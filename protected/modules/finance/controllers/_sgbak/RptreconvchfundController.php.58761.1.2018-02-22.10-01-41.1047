<?php

class RptreconvchfundController extends AAdminController
{

    public $layout = '//layouts/admin_column3';

    public function actionIndex()
    {
        $model = new Rptreconvchfund('RECON_VCH_FUND_VS_CASH_TRX', 'R_RECON_VCHFUND', 'Reconcile_vchfund_vs_cash_trx.rptdesign');
        $model->doc_date = date('d/m/Y');
        $model->option = 'DIFF';
        $url = '';
        $url_xls = '';
        if (isset($_POST['Rptreconvchfund']))
        {
            $model->attributes = $_POST['Rptreconvchfund'];

            if ($model->validate() && $model->executeRpt() > 0)
            {
                $date = DateTime::createFromFormat('Y-m-d',$model->doc_date)->format('d-M-Y');
                $rpt_link = $model->showReport($date,$date);
                $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                $url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
            }

        }
        if (DateTime::createFromFormat('Y-m-d', $model->doc_date))
            $model->doc_date = DateTime::createFromFormat('Y-m-d', $model->doc_date)->format('d/m/Y');

        $this->render('index', array(
            'model'=>$model,
            'url'=>$url
        ));
    }

}
