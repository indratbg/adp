<?php

class MonthendstockController extends AAdminController
{
public $layout='//layouts/admin_column3';

public function actionIndex()
{
	$model = new Monthendstock;	
	$model->bal_date = date('d/m/Y',strtotime("first day of this month"));
	$date = date('Y-m-01');
	$flg='N';
	if(isset($_POST['Monthendstock']))
	{
		$model->attributes = $_POST['Monthendstock'];
		$model->user_id =Yii::app()->user->id;
	
	if(DateTime::createFromFormat('d/m/Y',$model->bal_date))$model->bal_date = DateTime::createFromFormat('d/m/Y',$model->bal_date)->format('Y-m-d');
	
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$model->ip_address = $ip;
			$date = date('Y-m-d',strtotime("$model->bal_date -1 month"));
			$model->end_date = date('Y-m-t',strtotime($date));
			$model->start_date = DateTime::createFromFormat('Y-m-d',$date)->format('Y-m-01');
		
				if($model->validate() && $model->executeSp()>0)
				{
					Yii::app()->user->setFlash('success', 'Process Completed');
					$this->redirect(array('index','flg'=>'Y'));
				}
				//$flg='Y';
	}	
	if(DateTime::createFromFormat('Y-m-d',$model->bal_date))$model->bal_date = DateTime::createFromFormat('Y-m-d',$model->bal_date)->format('d/m/Y');	
	$this->render('index',array('model'=>$model,'flg'=>$flg));	
	
}
	
	public function actioncekDate(){
			$resp['status'] ='error';
				
			if(isset($_POST['tanggal']))
			{
				$tanggal=$_POST['tanggal'];
				$user_id=Yii::app()->user->id;
				if(DateTime::createFromFormat('d/m/Y',$tanggal))$tanggal=DateTime::createFromFormat('d/m/Y',$tanggal)->format('Y-m-d');
				$cek =Tstkbal::model()->find("bal_dt= '$tanggal' ");
					
					
				if($cek)
				{
					$resp['status']='success';	
				}
			}
			echo json_encode($resp);
		}
	
}
