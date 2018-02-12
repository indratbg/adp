<?php 

Class TautotrffailController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model=new Tautotrffail('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Tautotrffail']))
			$model->attributes=$_GET['Tautotrffail'];
		else {
			$model->cre_dt_from = date('d/m/Y');
			$model->cre_dt_to = date('d/m/Y');
			$model->vch_type = '%';
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}
}
