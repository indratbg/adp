<?php

class RptsecutrialbalanceController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model = new Rptsecutrialbalance('SECU_TRIAL_BALANCE','R_SECU_TRIAL_BALANCE','Securities_Trial_Balance.rptdesign');
		$model->end_date=date('d/m/Y');
		$url ='';
		$url_xls='';
		
		if(isset($_POST['Rptsecutrialbalance']))
		{
			$model->attributes = $_POST['Rptsecutrialbalance'];			
			if($model->validate() && $model->executeRpt()>0)
			{
				$rpt_link= $model->showReport();
				$url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
			}
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->end_date))$model->end_date = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d/m/Y');
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									'url_xls'=>$url_xls));
	}
}
