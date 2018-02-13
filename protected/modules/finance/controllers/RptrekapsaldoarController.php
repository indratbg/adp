<?php

class RptrekapsaldoarController extends AAdminController
{

    public $layout = '//layouts/admin_column3';

    public function actionIndex()
    {
        $model = new Rptrekapsaldoar('REKAP_SALDO_AR_CLIENT', 'R_REKAP_SALDO_AR', 'Rekap_Saldo_AR_Client.rptdesign');
        $model->doc_date = date('d/m/Y');
        
        $url = '';
        $url_xls = '';
        if (isset($_POST['Rptrekapsaldoar']))
        {
            $model->attributes = $_POST['Rptrekapsaldoar'];
           
            
            if ($model->validate() && $model->executeRpt()> 0)
            {
                $rpt_link = $model->showReport($model->doc_date,$model->doc_date);
                $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                $url_xls = $rpt_link . '&&__format=xls';
            }

        }
        if(DateTime::createFromFormat('Y-m-d',$model->doc_date))$model->doc_date=DateTime::createFromFormat('Y-m-d',$model->doc_date)->format('d/m/Y');
       
        $this->render('index', array(
            'model' => $model,
            'url' => $url,
            'url_xls'=>$url_xls
        ));
    }

}
