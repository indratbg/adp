<?php

class RptclientstockpositionforclientController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $broker_cd = Vbrokersubrek::model()->find()->broker_cd;
        $rpt_name = '';
        if (substr($broker_cd, 0, 2) == 'YJ' || substr($broker_cd, 0, 2) == 'MU')
        {
            $rpt_name = 'Client_stock_position_for_client.rptdesign';
        }
        else if (substr($broker_cd, 0, 2) == 'PF')
        {
            $rpt_name = 'Client_stock_position_for_client_PF.rptdesign';
        }
        $model = new Rptclientstockpositionforclient('CLIENT_STOCK_POSITION_FOR_CLIENT', 'R_STK_POSITION_CLIENT', $rpt_name);
        $sql = "select  stk_cd, stk_cd||' - '||stk_desc stk_desc from mst_counter where approved_stat='A' order by stk_cd";
        $stk_cd = Counter::model()->findAllBySql($sql);
        $rem_cd = Sales::model()->findAll(array(
            'select'=>"rem_cd, rem_cd||' - '|| rem_name as rem_name ",
            'condition'=>"approved_stat='A' "
        ));
        $branch_cd = Branch::model()->findAll(array(
            'select'=>"brch_cd, brch_cd ||' - '|| brch_name as brch_name",
            'condition'=>"approved_stat='A' ",
            'order'=>'brch_cd'
        ));
        $model->doc_date = date('d/m/Y');
        $url = '';
        $model->report_type = 1;
        $model->stk_option = 0;
        $model->client_option = 0;
        $model->sales_option = 0;
        $model->branch_option = 0;
        if (substr($broker_cd, 0, 2) == 'YJ')
        {
            $model->price_option = 0;
        }
        else
        {
            $model->price_option = 1;
        }
        if (isset($_POST['Rptclientstockpositionforclient']))
        {
            $model->attributes = $_POST['Rptclientstockpositionforclient'];
            //var_dump($model->client_option);die();
            if ($model->validate())
            {
                //stock
                if ($model->stk_option == '0')
                {
                    $bgn_stk = '%';
                    $end_stk = '_';
                }
                else
                {
                    $bgn_stk = $model->stk_cd;
                    $end_stk = $model->stk_cd;
                }
                //all client
                if ($model->client_option == '0')
                {
                    $bgn_client = '%';
                    $end_client = '_';
                    $custody = 'N';
                    $bgn_client_type_3 = '%';
                    $end_client_type_3 = '_';
                    $bgn_margin = '%';
                    $end_margin = '_';
                }
                //regular
                else if ($model->client_option == '1')
                {
                    $bgn_client = '%';
                    $end_client = '_';
                    $custody = 'N';
                    $bgn_client_type_3 = 'R';
                    $end_client_type_3 = 'R';
                    $bgn_margin = '%';
                    $end_margin = '_';
                }
                //custody
                else if ($model->client_option == '2')
                {
                    $bgn_client = '%';
                    $end_client = '_';
                    $custody = 'Y';
                    $bgn_client_type_3 = '%';
                    $end_client_type_3 = '_';
                    $bgn_margin = '%';
                    $end_margin = '_';
                }
                //SPECIFIED
                else if ($model->client_option == '3')
                {
                    $bgn_client = $model->bgn_client;
                    $end_client = $model->end_client;
                    $custody = 'N';
                    $bgn_client_type_3 = '%';
                    $end_client_type_3 = '_';
                    $bgn_margin = '%';
                    $end_margin = '_';
                }
                //MARGIN
                else if ($model->client_option == '4')
                {
                    $bgn_client = '%';
                    $end_client = '_';
                    $custody = 'N';
                    $bgn_margin = 'M';
                    $end_margin = 'M';
                    $bgn_client_type_3 = 'M';
                    $end_client_type_3 = 'M';
                }
                //T PLUS
                else if ($model->client_option == '5')
                {
                    $bgn_client = '%';
                    $end_client = '_';
                    $custody = 'N';
                    $bgn_margin = 'R';
                    $end_margin = 'R';
                    $bgn_client_type_3 = 'T';
                    $end_client_type_3 = 'T';
                }

                //sales
                if ($model->sales_option == '0')
                {
                    $bgn_rem = '%';
                    $end_rem = '_';
                }
                else
                {
                    $bgn_rem = $model->rem_cd;
                    $end_rem = $model->rem_cd;
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

                //Price YES
                if ($model->price_option == '0')
                {
                    $price_option = 'Y';
                }
                //Price NO
                else if ($model->price_option == '1')
                {
                    $price_option = 'N';
                }

                if ($model->executeRpt($bgn_stk, $end_stk, $bgn_client, $end_client, $bgn_rem, $end_rem, $bgn_branch, $end_branch, $price_option, $custody, $bgn_client_type_3, $end_client_type_3, $bgn_margin, $end_margin) > 0)
                {
                    $date = DateTime::createFromFormat('Y-m-d', $model->doc_date)->format('d-M-Y');
                    $url = $model->showReport($date, $date) . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                }
            }
        }

        if (DateTime::createFromFormat('Y-m-d', $model->doc_date))
            $model->doc_date = DateTime::createFromFormat('Y-m-d', $model->doc_date)->format('d/m/Y');

        $this->render('index', array(
            'model'=>$model,
            'url'=>$url,
            'rem_cd'=>$rem_cd,
            'branch_cd'=>$branch_cd,
            'stk_cd'=>$stk_cd
        ));
    }

}
?>