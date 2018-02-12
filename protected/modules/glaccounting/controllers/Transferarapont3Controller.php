<?php

class Transferarapont3Controller extends AAdminController
{
public $layout='//layouts/admin_column3';

public function actionIndex()
{
	$model = new Transferarapont3;	
	$model->due_date = date('d/m/Y');
	$flg = 'N';
	if(isset($_POST['Transferarapont3']))
	{
		$model->attributes = $_POST['Transferarapont3'];
		$model->user_id =Yii::app()->user->id;
	if(DateTime::createFromFormat('d/m/Y',$model->due_date))$model->due_date = DateTime::createFromFormat('d/m/Y',$model->due_date)->format('Y-m-d');
	
	$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			
			$model->ip_address = $ip;
		if($model->validate() && $model->executeSp()>0){
			Yii::app()->user->setFlash('success', 'Process Completed');
			$this->redirect(array('index','flg'=>'Y'));
		}
		$flg = 'Y';	
	}	
	if(DateTime::createFromFormat('Y-m-d',$model->due_date))$model->due_date = DateTime::createFromFormat('Y-m-d',$model->due_date)->format('d/m/Y');	
	$this->render('index',array('model'=>$model,'flg'=>$flg));	
	
}
	
}
