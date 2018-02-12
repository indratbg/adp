<?php

class RptdebtclientController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Rptdebtclient('HUTANG NASABAH PLUS STOCK', 'R_DEBT_CLIENT', 'Hutang_nasabah_plus_stock.rptdesign');
        $model->end_date = date('d/m/Y');
        $url = '';
        $url_xls = '';
        if (isset($_POST['Rptdebtclient']) && isset($_POST['scenario']))
        {

            $model->attributes = $_POST['Rptdebtclient'];
            $scenario = $_POST['scenario'];
            if ($scenario == 'print')
            {

                if ($model->client_cd)
                {
                    $bgn_client = $model->client_cd;
                    $end_client = $model->client_cd;
                }
                else
                {
                    $bgn_client = '%';
                    $end_client = '_';
                }
                
                if ($model->validate() && $model->executeRpt($bgn_client, $end_client) > 0)
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
                $condition = " where rand_value=$model->vo_random_value and user_id='$user_id' order by cifs,client_cd";
                $this->ExportToExcel('INSISTPRO_RPT', $model, $condition, 'Hutang Nasabah On Off Plus Stock');

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
