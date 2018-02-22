<?php

class RptoutsbybranchController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $sql = "select  rem_cd, rem_cd||' - '||rem_name rem_name from mst_sales where approved_stat='A' order by rem_cd";
        $rem_cd = Sales::model()->findAllBySql($sql);
        $sql = "select brch_cd||' - '||brch_name brch_name, brch_cd from mst_branch where approved_stat='A' order by brch_cd";
        $branch = Branch::model()->findAllBySql($sql);
        $model = new Rptoutsbybranch('OUTSTANDING BY BRANCH', 'R_OUTS_BY_BRANCH', 'Outstanding_by_branch.rptdesign');
        $model->end_date = date('d/m/Y');
        
        $url = '';
        if (isset($_POST['Rptoutsbybranch']) && isset($_POST['scenario']))
        {

            $model->attributes = $_POST['Rptoutsbybranch'];
            $scenario = $_POST['scenario'];
            if ($scenario == 'print')
            {
                if($model->branch_cd)
                {
                    $bgn_branch=$model->branch_cd;
                    $end_branch=$model->branch_cd;
                }
                else {
                    $bgn_branch='%';
                    $end_branch='_';
                }
                if($model->rem_cd)
                {
                    $bgn_rem = $model->rem_cd;
                    $end_rem = $model->rem_cd;
                }
                else {
                    $bgn_rem = '%';
                    $end_rem = '_';
                }
                
                if ($model->validate() && $model->executeRpt($bgn_branch, $end_branch, $bgn_rem, $end_rem))
                {
                    $bgn_date = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d-M-Y');
                    $rpt_link = $model->showReport($bgn_date, $bgn_date);
                    $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                   
                }
            }
            //export excel
            else
            {
                $user_id = Yii::app()->user->id;
                $condition = " where rand_value=$model->vo_random_value and user_id='$user_id' order by branch_cd,rem_cd,client_cd";
                $this->ExportToExcel('INSISTPRO_RPT', $model, $condition, 'Daily Cash Flow');

            }
        }
        if (DateTime::createFromFormat('Y-m-d', $model->end_date))
            $model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');
        $this->render('index', array(
            'model'=>$model,
            'url'=>$url,
            'branch'=>$branch,
            'rem_cd'=>$rem_cd
        ));
    }

}
