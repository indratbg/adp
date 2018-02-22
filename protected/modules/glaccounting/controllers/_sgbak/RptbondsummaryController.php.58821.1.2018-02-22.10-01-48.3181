<?php

class RptbondsummaryController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
 

    public function actionIndex()
    {
        $model = new Rptbondsummary('BOND_TRX_SUMMARY', 'R_BOND_TRX_SUMMARY', 'Bond_trx_summary.rptdesign');
        $model->bgn_date = date('01/m/Y');
        $model->end_date = date('t/m/Y');
        $model->year = date('Y');
        $model->month = date('m');
        $url = '';
        $url_xls = '';
        if (isset($_POST['Rptbondsummary']))
        {
            $model->attributes = $_POST['Rptbondsummary'];
            $scenario = $_POST['scenario'];
            $model->validate();
            if($scenario=='print')
            {
            
            if ($model->executeRpt() > 0)
            {
                if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
                    $model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
                if (DateTime::createFromFormat('Y-m-d', $model->end_date))
                    $model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');
                $rpt_link = $model->showReport($model->bgn_date, $model->end_date);
                $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
             
            }    
            }
            else {
                $condition = "where rand_value='$model->vo_random_value' and user_id='$model->vp_userid' ";
                $fileName = 'Bond Transaction Summary';
                $this->ExportToExcel('INSISTPRO_RPT',$model, $condition, $fileName);
            }
            

        }

        $this->render('index', array(
            'model' => $model,
            'url' => $url,
            'rand_value'=>$model->vo_random_value
        ));
    }
}
