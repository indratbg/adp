<?php
class RptprofitlossrecapController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Rptprofitlossrecap('PROFIT_LOSS_RECAP', 'R_PROFIT_LOSS_RECAP', 'Profit_Loss_Recap.rptdesign');
        $model->month = date('m');
        $model->year = date('Y');
        $url = '';
        $url_xls = '';
        if (isset($_POST['Rptprofitlossrecap']))
        {
            $model->attributes = $_POST['Rptprofitlossrecap'];

            $bgn_date = date('Y-m-d', strtotime("$model->year" . '-' . "$model->month" . '-01'));
            $end_date = date('Y-m-t', strtotime("$model->year" . '-' . "$model->month" . '-01'));

            if ($model->validate() && $model->executeRpt($bgn_date, $end_date) > 0)
            {
                $rpt_link = $model->showReport();
                $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                $url_xls = $rpt_link . '&&__dpi=96&__format=xlsx&__pageoverflow=0&__overwrite=false&#zoom=100';
            }

            // Untuk Testing
            /*
             $locale = '&__locale=in_ID';
             $param = '&ACC_TOKEN=' . 'XX' . '&ACC_USER_ID=' . 'LISA' .
            '&RP_RANDOM_VALUE=' . '855964378';
             $rpt_link = Constanta::URL . $model->rptname . $locale . $param;
             $url = $rpt_link .
            '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
             $url_xls = $rpt_link .
            '&&__dpi=96&__format=xlsx&__pageoverflow=0&__overwrite=false&#zoom=100';
             */
        }

        $this->render('index', array(
            'model'=>$model,
            'url'=>$url,
            'url_xls'=>$url_xls
        ));
    }

}
