<?php

class RptclientperformanceController extends AAdminController
{

    public $layout = '//layouts/admin_column3';

    public function actionIndex()
    {
        $rpt_name_olt = '';
        $rpt_name = '';
        if (Rptclientperformance::getBrokerCode() == 'YJ')
        {
            $rpt_name = 'Client_Performance_YJ.rptdesign';
            $rpt_name_olt = 'Client_Performance_OLT_YJ.rptdesign';
        }
        else
        {
            $rpt_name = 'Client_Performance_MU.rptdesign';
            $rpt_name_olt = 'Client_Performance_MU.rptdesign';
        }

        $model = new Rptclientperformance('CLIENT_PERFORMANCE', 'R_CLIENT_PERFORMANCE', $rpt_name);
        $dropdown_branch = Branch::model()->findAll(array(
            'select'=>"brch_cd, brch_cd ||' - '|| brch_name as brch_name",
            'condition'=>"approved_stat='A' ",
            'order'=>'brch_cd'
        ));
        $model->bgn_date = date('01/m/Y');
        $model->end_date = date('d/m/Y');
        $model->rpt_type = '0';
        $model->year = date('Y');
        $model->month = date('m');
        $model->option = 0;
        $url = '';
        $url_xls = '';

        if (isset($_POST['Rptclientperformance']))
        {
            $model->attributes = $_POST['Rptclientperformance'];

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
            if ($model->contract_option == '0')
            {
                $bgn_ctr_type = '%';
                $end_ctr_type = '_';
            }
            else
            {
                $bgn_ctr_type = $model->contract_type;
                $end_ctr_type = $model->contract_type;
            }
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
            if ($model->option == '0')
            {
                $corp = 'ALL';
            }
            else if ($model->option == '1')
            {
                $corp = 'CORP';
            }
            else
            {
                $model->rptname = $rpt_name_olt;
                $corp = 'LOT';
            }
            $rpt_mode = $model->rpt_type == '0' ? 'SUMMARY' : 'DETAIL';
            if ($model->rpt_type == '0' && $model->sort_by == '0')
            {
                $rpt_mode = 'SUMMARY_TRX';
            }
            if ($model->rpt_type == '0' && $model->sort_by == '1')
            {
                $rpt_mode = 'SUMMARY_CL';
            }

            if ($model->validate() && $model->executeRpt($bgn_branch, $end_branch, $bgn_ctr_type, $end_ctr_type, $bgn_client, $end_client, $rpt_mode, $corp) > 0)
            {
                $rpt_link = $model->showReport();
                $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                $url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';

            }
        }

        if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
            $model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
        if (DateTime::createFromFormat('Y-m-d', $model->end_date))
            $model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');
        $this->render('index', array(
            'model'=>$model,
            'url'=>$url,
            'url_xls'=>$url_xls,
            'branch_cd'=>$dropdown_branch
        ));
    }

}
