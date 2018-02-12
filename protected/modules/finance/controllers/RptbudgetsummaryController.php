<?php

class RptbudgetsummaryController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionIndex()
	{
		$model = new Rptbudgetsummary('BUDGET_SUMMARY','R_BUDGET_SUMMARY_YJ','budget_summary.rptdesign');
		$url = '';
		$url_xls= '';
		$model->p_report_date=date('d/m/Y');
		if (isset($_POST['Rptbudgetsummary']))
		{
			$model->attributes = $_POST['Rptbudgetsummary'];
			
			if ($model->validate() && $model->executeRpt($model->p_report_date)>0)
			{
					$rpt_link =$model->showReport();	

						$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
						$url_xls = $rpt_link .'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					
			}

		}
		
		   if (DateTime::createFromFormat('Y-m-d', $model->p_report_date))
			$model->p_report_date = DateTime::createFromFormat('Y-m-d', $model->p_report_date)->format('d/m/Y');
		
		$this->render('index', array(
			'model' => $model,
			'url' => $url,
			'url_xls'=> $url_xls
		));
	}


	
}