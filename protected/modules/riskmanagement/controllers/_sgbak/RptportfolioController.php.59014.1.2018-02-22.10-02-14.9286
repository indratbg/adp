<?php

class RptportfolioController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Rptportfolio('PORTFOLIO', 'R_RISK_PORTO', 'Portfolio.rptdesign');
        $branch = Branch::model()->findAll(array(
            'select'=>"brch_cd||' - '||brch_name brch_name,brch_cd",
            'condition'=>"approved_stat='A'",
            'order'=>'brch_cd'
        ));
        $rem_cd = Sales::model()->findAll(array(
            'select'=>"rem_cd||' - '||rem_name rem_name,rem_cd",
            'condition'=>"approved_stat='A'",
            'order'=>'rem_cd'
        ));
        $model->trx_date = date('d/m/Y');
        $model->price_date = Rptportfolio::getPriceDate($model->trx_date);
        $model->acct_type = 'M';
        $model->client_option = '0';
        $model->branch_option = '0';
        $model->rem_option = '0';
        $model->stk_cd_option='0';
        $model->report_type='0';
        $url = '';
        if (isset($_POST['Rptportfolio']))
        {
            $model->attributes = $_POST['Rptportfolio'];

            //client
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
            //branch
            if ($model->branch_option == '0')
            {
                $bgn_branch = '%';
                $end_branch = '_';
            }
            else
            {
                $bgn_branch = $model->branch_cd;
                $end_branch = $model->branch_cd;
            }
            //sales
            if ($model->rem_option == '0')
            {
                $bgn_rem = '%';
                $end_rem = '_';
            }
            else
            {
                $bgn_rem = $model->rem_cd;
                $end_rem = $model->rem_cd;
            }
            //STock
            if ($model->stk_cd_option == '0')
            {
                $bgn_stock = '%';
                $end_stock = '_';
            }
            else
            {
                $bgn_stock = $model->stk_cd;
                $end_stock = $model->stk_cd;
            }
            //report type
            if($model->report_type==0)
            {
                $report_type ='PORTFOLIO';    
            }
            else 
            {
                $report_type ='BUYBACK';
            }
            
            $bgn_margin = $model->acct_type;
            $end_margin = $model->acct_type;
                
            if ($model->validate() && $model->executeRpt($bgn_margin, $end_margin, $bgn_client, $end_client, $bgn_branch, $end_branch, $bgn_rem, $end_rem, $bgn_stock, $end_stock, $report_type)> 0)
            {
                $bgn_date = DateTime::createFromFormat('Y-m-d', $model->trx_date)->format('d-M-Y');
                $price_date = DateTime::createFromFormat('Y-m-d', $model->price_date)->format('d/m/Y');
                $rpt_link = $model->showReport($bgn_date, $price_date);
                $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
            }
        }
        if (DateTime::createFromFormat('Y-m-d', $model->trx_date))
            $model->trx_date = DateTime::createFromFormat('Y-m-d', $model->trx_date)->format('d/m/Y');
        if (DateTime::createFromFormat('Y-m-d', $model->price_date))
            $model->price_date = DateTime::createFromFormat('Y-m-d', $model->price_date)->format('d/m/Y');

        $this->render('index', array(
            'model'=>$model,
            'url'=>$url,
            'branch'=>$branch,
            'rem_cd'=>$rem_cd
        ));
    }

}
