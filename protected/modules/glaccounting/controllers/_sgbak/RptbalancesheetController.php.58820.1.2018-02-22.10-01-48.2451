<?php

class RptbalancesheetController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model = new Rptbalancesheet('BALANCE_SHEET','R_BALANCE_SHEET','Balance_sheet.rptdesign');
		$branch_flg = Sysparam::model()->find(" PARAM_ID='SYSTEM' AND PARAM_CD1='CHECK' AND PARAM_CD2='ACCTBRCH' ")->dflg1;
		$model->end_date=date('d/m/Y');
		$url_xls='';
		$url ='';
		
		if(isset($_POST['Rptbalancesheet']))
		{
			$model->attributes = $_POST['Rptbalancesheet'];
			$branch_cd = $model->branch_cd?$model->branch_cd:'%';
			
			if($model->validate() && $model->executeRpt($branch_cd)>0)
			{
				$rpt_link =$model->showReport();
				$url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
			}
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->end_date))$model->end_date = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d/m/Y');
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									'url_xls'=>$url_xls,
									'branch_flg'=>$branch_flg));
	}
}
