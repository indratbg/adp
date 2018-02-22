<?php

class RptfixedassetController extends AAdminController
{
	public $layout = '//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model = new Rptfixedasset('FIXED_ASSET', 'R_FIXED_ASSET', 'Fixed_Asset.rptdesign');
		$sql = DAO::queryRowSql("SELECT to_char(MAX(SUBSTR(depr_mon,3,2)||SUBSTR(depr_mon,1,2))) start_dt FROM T_MON_DEPR where cre_dt is not null");
		$start_dt=$sql['start_dt'];
		$year=substr(date('Y'),0,2).substr($start_dt,0,2);
		$month=substr($start_dt,2);
		$date=$month.'/01/'.$year;
		$model->end_date = date('t/m/Y',strtotime($date));
		$url = '';
		
		if(isset($_POST['Rptfixedasset']))
		{
			$model->attributes = $_POST['Rptfixedasset'];
			
				$branch_cd = $model->branch_cd?$model->branch_cd:'%';
				
				if($model->validate() && $model->executeRpt($branch_cd)>0)
				{
					$url = $model->showReport($model->end_date,$model->end_date).'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				}	
			}
		
	if(DateTime::createFromFormat('Y-m-d',$model->end_date))$model->end_date = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d/m/Y');
	
		$this -> render('index', array('model' => $model,'url'=>$url));
	}

}
