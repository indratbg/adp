<?php

class RptbranchperformanceController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model = new Rptbranchperformance('BRANCH_PERFORMANCE','R_BRANCH_PERFORMANCE','Branch_Performance.rptdesign');
		$dropdown_branch = Branch::model()->findAll(array('select'=>"brch_cd, brch_cd ||' - '|| brch_name as brch_name",'condition'=>"approved_stat='A' ",'order'=>'brch_cd' ));
		$dropdown_rem_cd = Sales::model()->findAll(array('select'=>" rem_cd, rem_cd||' - '||rem_name rem_name ",'condition'=>"approved_stat='A' ",'order'=>'rem_cd'));
		$model->bgn_date=date('01/m/Y');
		$model->end_date=date('d/m/Y');
		$model->rpt_type='0';
		$model->month = date('m');
		$model->year = date('Y');
		$url ='';
		$url_xls='';
		
		if(isset($_POST['Rptbranchperformance']))
		{
			$model->attributes = $_POST['Rptbranchperformance'];
			
			//branch	
			if($model->branch_option=='0')
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
			if($model->rem_option=='0')
			{
				$bgn_rem_cd = '%';
				$end_rem_cd = '_';
			}
			else
			{
				$bgn_rem_cd = $model->rem_cd;
				$end_rem_cd = $model->rem_cd;
			}	
	
			$contr_type= $model->contract_option=='0'?'%':$model->contract_type;	
			$rpt_mode = $model->rpt_type=='0'?'SUMMARY':'DETAIL';
		
					
			if($model->validate() && $model->executeRpt($bgn_branch, $end_branch, $bgn_rem_cd, $end_rem_cd, $contr_type, $rpt_mode)>0)
			{
				$rpt_link =$model->showReport();
				$url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
		
			}
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->bgn_date))$model->bgn_date = DateTime::createFromFormat('Y-m-d',$model->bgn_date)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->end_date))$model->end_date = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d/m/Y');
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									'url_xls'=>$url_xls,
									'branch_cd'=>$dropdown_branch,
									'rem_cd'=>$dropdown_rem_cd));
	}
}
