<?php

class RptsalesperformanceController extends AAdminController
{

    public $layout = '//layouts/admin_column3';

    public function actionIndex()
    {
        $model = new Rptsalesperformance('SALES_PERFORMANCE', 'R_SALES_PERFORMANCE', 'Sales_Performance.rptdesign');
        $dropdown_branch = Branch::model()->findAll(array(
            'select'=>"brch_cd, brch_cd ||' - '|| brch_name as brch_name",
            'condition'=>"approved_stat='A' ",
            'order'=>'brch_cd'
        ));
        $dropdown_rem_cd = Sales::model()->findAll(array(
            'select'=>" rem_cd, rem_cd||' - '||rem_name rem_name ",
            'condition'=>"approved_stat='A' ",
            'order'=>'rem_cd'
        ));
        $model->bgn_date = date('01/m/Y');
        $model->end_date = date('t/m/Y');
        $model->year = date('Y');
        $model->month = date('m');
        $model->rpt_type = '0';
        $url = '';
        $url_xls = '';

        if (isset($_POST['Rptsalesperformance']) && isset($_POST['scenario']))
        {
            $model->attributes = $_POST['Rptsalesperformance'];
            $scenario = $_POST['scenario'];
            if ($scenario == 'print')
            {

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
                //rem cd
                if ($model->rem_option == '0')
                {
                    $bgn_rem_cd = '%';
                    $end_rem_cd = '_';
                }
                else
                {
                    $bgn_rem_cd = $model->rem_cd;
                    $end_rem_cd = $model->rem_cd;
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
                if ($model->rpt_type == '0')
                {
                    $rpt_mode = 'SUMMARY';
                }
                else if ($model->rpt_type == '1')
                {
                    $rpt_mode = 'DETAIL';
                }
                else
                {
                    $rpt_mode = 'COMMISSION';
                }

                if ($model->validate() && $model->executeRpt($bgn_branch, $end_branch, $bgn_ctr_type, $end_ctr_type, $bgn_rem_cd, $end_rem_cd, $rpt_mode) > 0)
                {
                    $rpt_link = $model->showReport();
                    $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                    $url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';

                }
            }
            else
            {
                $user_id=Yii::app()->user->id;
                $condition = "where user_id= '$user_id' and rand_value=$model->vo_random_value";
                $this->ExportToExcel('INSISTPRO_RPT', $model, $condition, 'Sales Performance');

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
            'branch_cd'=>$dropdown_branch,
            'rem_cd'=>$dropdown_rem_cd
        ));
    }

}
