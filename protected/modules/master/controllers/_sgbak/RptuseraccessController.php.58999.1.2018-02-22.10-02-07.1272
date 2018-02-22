<?php

class RptuseraccessController extends AAdminController
{

	public $layout='//layouts/admin_column2';

	public function actionIndex()
	{
		// [AR] provide Module Name, Table Name, RptDesign Name
		//      notice that no unset attributes because it will make error !!  
		$model 		= new RptUserAccess('USER_ACCESS','R_USER_ACCESS_SSS','User_access_sss.rptdesign');
		$url 		= NULL;
		
		if(isset($_POST['RptUserAccess']))
		{
			$model->attributes = $_POST['RptUserAccess'];
				   
			if($model->validate() && $model->executeReportGenSp() > 0 )
				$url = $model->showReport();
			
		}
		else
		{
			// [AR] adding default value  
			$model->vp_user_id = '%';
		}
		
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url,
		));
	}
}
