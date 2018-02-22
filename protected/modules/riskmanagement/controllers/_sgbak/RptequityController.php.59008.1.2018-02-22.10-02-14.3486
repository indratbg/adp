<?php

class RptequityController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Rptequity('EQUITY', 'R_EQUITY', 'Equity.rptdesign');
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
        $model->as_per_date = date('d/m/Y');
        $model->acct_type = 'M';
        $model->client_option = '0';
        $model->branch_option = '0';
        $model->rem_option = '0';
        $model->limit=0;
        $url = '';
        $url_xls = '';
        if (isset($_POST['Rptequity']))
        {
            $model->attributes = $_POST['Rptequity'];

            //client
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
            //branch
            if ($model->branch_option == '0')
            {
                $bgn_branch = '%';
                $end_branch = '_';
            }
            else
            {
                $bgn_branch = $model->bgn_branch;
                $end_branch = $model->end_branch;
            }
            //sales
            if($model->rem_option=='0')
            {
                $bgn_rem='%';
                $end_rem='_';
            }
            else 
            {
                $bgn_rem=$model->bgn_rem;
                $end_rem=$model->end_rem;    
            }
            
            $bgn_acct_type=$model->acct_type;
            $end_acct_type=$model->acct_type;
            
            $sql = " SELECT MAX(STK_DATE) price_date FROM T_CLOSE_PRICE WHERE STK_DATE  <=to_date('$model->as_per_date','dd/mm/yyyy') AND APPROVED_STAT='A' ";
            $exec = DAO::queryRowSql($sql);
            $price_date = $exec['price_date'];
            if(DateTime::createFromFormat('Y-m-d H:i:s',$price_date))$price_date = DateTime::createFromFormat('Y-m-d H:i:s',$price_date)->format('Y-m-d');
            
            if ($model->validate() && $model->executeRpt($price_date, $bgn_acct_type, $end_acct_type, $bgn_client, $end_client, $bgn_branch, $end_branch, $bgn_rem, $end_rem)> 0)
            {
                $bgn_date = DateTime::createFromFormat('Y-m-d', $model->as_per_date)->format('d/m/Y');
                $price_date = DateTime::createFromFormat('Y-m-d',$price_date)->format('d/m/Y');
                $rpt_link = $model->showReport($bgn_date, $price_date);
                $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                $url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
            }

        }
        if (DateTime::createFromFormat('Y-m-d', $model->as_per_date))
            $model->as_per_date = DateTime::createFromFormat('Y-m-d', $model->as_per_date)->format('d/m/Y');

        $this->render('index', array(
            'model'=>$model,
            'url'=>$url,
            'branch'=>$branch,
            'rem_cd'=>$rem_cd
        ));
    }

}
