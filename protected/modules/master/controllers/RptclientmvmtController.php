<?php

class RptclientmvmtController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		// [AR] provide Module Name, Table Name, RptDesign Name
		//      notice that no unset attributes because it will make error !!
		$model= new RptClientMvmt('CLIENT_MVMT','R_CLIENT_MVMT','Client_mvmt.rptdesign');
		
		$url 		= NULL;
		$modelToken = new Token;
		
		if(isset($_POST['RptClientMvmt']))
		{
			$model->attributes = $_POST['RptClientMvmt'];
			if($model->validate() && $model->executeReportGenSp() > 0)
				$url = $model->showReport().'&__showtitle=false&__format=pdf';
		}
		else
		{
			$model->vp_bgn_dt  = date('01/m/Y');
		}
		
		
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url,
		));
	}
}
