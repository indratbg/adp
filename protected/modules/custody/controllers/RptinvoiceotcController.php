<?php

class RptinvoiceotcController extends AAdminController
{

    public $layout = '//layouts/admin_column3';

    public function actionIndex()
    {
        $model = new Rptinvoiceotc('LIST_OF_INVOICE', 'R_INVOICE_OTC_CLIENT', 'Invoice_otc_client.rptdesign');
        $modelRepo = new Rptinvoiceotc('LIST_OF_INVOICE', 'R_INVOICE_REPO', 'Invoice_repo.rptdesign');
        $sql = "select  stk_cd, stk_cd||'-'||stk_desc stk_desc from mst_counter where approved_stat='A' order by stk_cd";
        $stk_cd = Counter::model()->findAllBySql($sql);
        $url = '';
        $model->bgn_date = date('d/m/Y');
        $model->end_date = date('d/m/Y');
        $model->stk_option = '0';
        $model->broker_option = '0';
        $model->client_option = '0';
        $model->invoice_type = '0';
        $model->otc = '20000';
        $model->acct_jual = '50';
        $model->acct_beli = '09';
        if (isset($_POST['Rptinvoiceotc']))
        {
            $model->attributes = $_POST['Rptinvoiceotc'];
            $model->scenario = 'print';
            if ($model->validate())
            {
                if ($model->stk_option == '0')
                {
                    $bgn_stk = '%';
                    $end_stk = '_';
                }
                else
                {
                    $bgn_stk = $model->stk_cd_from;
                    $end_stk = $model->stk_cd_to;
                }
                if ($model->client_option == '0')
                {
                    $bgn_client = '%';
                    $end_client = '_';
                }
                else
                {
                    $bgn_client = $model->bgn_client;
                    $end_client = $model->end_client;
                }
                if ($model->broker_option == '0')
                {
                    $bgn_broker = '%';
                    $end_broker = '_';
                }
                else
                {
                    $bgn_broker = $model->broker_cd;
                    $end_broker = $model->broker_cd;
                }
                $otc = '20000';
                $model->acct_jual = '50';
                $model->acct_beli = '09';
                //var_dump($model->invoice_type);die();
                if ($model->invoice_type == '0')
                {
                    if ($model->executeRptClient($bgn_stk, $end_stk, $bgn_client, $end_client, $bgn_broker, $end_broker, $otc) > 0)
                    {
                        if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
                            $model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
                        if (DateTime::createFromFormat('Y-m-d', $model->end_date))
                            $model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

                        $url = $model->showReport($model->bgn_date, $model->end_date) . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                    }
                }
                if ($model->invoice_type == '1')
                {
                    $modelRepo->bgn_date = $model->bgn_date;
                    $modelRepo->end_date = $model->end_date;

                    if ($modelRepo->validate() && $modelRepo->executeRptRepo($bgn_stk, $end_stk, $bgn_client, $end_client, $bgn_broker, $end_broker, $otc, $model->acct_jual, $model->acct_beli) > 0)
                    {
                        if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
                            $model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
                        if (DateTime::createFromFormat('Y-m-d', $model->end_date))
                            $model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

                        $url = $modelRepo->showReport($model->bgn_date, $model->end_date) . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                    }
                }
            }
        }

        if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
            $model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
        if (DateTime::createFromFormat('Y-m-d', $model->end_date))
            $model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

        $this->render('index', array(
            'model'=>$model,
            'modelRepo'=>$modelRepo,
            'url'=>$url,
            'stk_cd'=>$stk_cd
        ));
    }

}
?>