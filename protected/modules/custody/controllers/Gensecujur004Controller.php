<?php

class Gensecujur004Controller extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
    {
    	$model = new Gensecujur004;
		$model->due_date = date('d/m/Y');
	
		if(isset($_POST['Gensecujur004']))
		{
			$model->attributes = $_POST['Gensecujur004'];
			if($model->validate())
			{
			
				if($model->executeSp()>0)
				{
					Yii::app()->user->setFlash('success', 'Journal succesful generated');
				}
			}
		}
		$this->render('index',array('model'=>$model));	
	}
}
