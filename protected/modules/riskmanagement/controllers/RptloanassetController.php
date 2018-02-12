<?php

class RptloanassetController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Rptloanasset('LOAN_TO_ASSET_PER_DATE', 'R_LOAN_TO_ASSET', 'Loan_to_Asset.rptdesign');
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
        $model->acct_type = 'M';
        $model->client_option = '0';
        $model->branch_option = '0';
        $model->rem_option = '0';
        $url = '';
        if (isset($_POST['Rptloanasset']))
        {
            $model->attributes = $_POST['Rptloanasset'];

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

            $bgn_margin = $model->acct_type;
            $end_margin = $model->acct_type;

            $sql = " SELECT MAX(STK_DATE) price_date FROM T_CLOSE_PRICE WHERE STK_DATE  <=to_date('$model->trx_date','dd/mm/yyyy') AND APPROVED_STAT='A' ";
            $exec = DAO::queryRowSql($sql);
            $price_date = $exec['price_date'];
            if (DateTime::createFromFormat('Y-m-d H:i:s', $price_date))
                $price_date = DateTime::createFromFormat('Y-m-d H:i:s', $price_date)->format('Y-m-d');

            if ($model->validate() && $model->executeRpt($price_date, $bgn_margin, $end_margin, $bgn_client, $end_client, $bgn_branch, $end_branch, $bgn_rem, $end_rem) > 0)
            {
                $bgn_date = DateTime::createFromFormat('Y-m-d', $model->trx_date)->format('d/m/Y');
                $price_date = DateTime::createFromFormat('Y-m-d', $price_date)->format('d/m/Y');
                $rpt_link = $model->showReport($bgn_date, $price_date);
                $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
            }
 
          
             
        }
        if (DateTime::createFromFormat('Y-m-d', $model->trx_date))
            $model->trx_date = DateTime::createFromFormat('Y-m-d', $model->trx_date)->format('d/m/Y');

        $this->render('index', array(
            'model'=>$model,
            'url'=>$url,
            'branch'=>$branch,
            'rem_cd'=>$rem_cd
        ));
    }

}
