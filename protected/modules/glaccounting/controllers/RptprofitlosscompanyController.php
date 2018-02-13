<?php

class RptprofitlosscompanyController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	
	public function actionIndex()
    {
		$rpt_name = 'PL_Company_YJ.rptdesign';
    	$model = new Rptprofitlosscompany('PROFIT_LOSS_COMPANY','R_PROFIT_LOSS_COMPANY',$rpt_name);
		$url='';
		$url_xls='';
		$branch_cd = Branch::model()->findAll(array('select'=>"brch_cd, brch_cd ||' - '|| brch_name as brch_name",'condition'=>"approved_stat='A' ",'order'=>'brch_cd' ));
		$model->bgn_date = date('d/m/Y');
		$model->year = date('Y');
		$model->month = date('m');
		
		if(isset($_POST['Rptprofitlosscompany']))
		{
			$model->attributes = $_POST['Rptprofitlosscompany'];
			
			if($model->validate())
			{
				
				if($model->bgn_branch)
				{
					$bgn_branch = $model->bgn_branch;
					$end_branch = $model->end_branch;
				}
				else 
				{
					$bgn_branch = '%';
					$end_branch = '_';	
				}
			
				if($model->executeRpt($bgn_branch, $end_branch)>0)
				{
					$rpt_link =$model->showReport();
					$url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			
			}
		}
		
		
		if(DateTime::createFromFormat('Y-m-d',$model->bgn_date))$model->bgn_date = DateTime::createFromFormat('Y-m-d',$model->bgn_date)->format('d/m/Y');
	
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									'url_xls'=>$url_xls,
									'branch_cd'=>$branch_cd));
	}
}
?>