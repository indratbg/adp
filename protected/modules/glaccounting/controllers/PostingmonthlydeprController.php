<?php

class PostingmonthlydeprController extends AAdminController
{
public $layout='//layouts/admin_column3';

public function actionCheckPosting(){
		$resp['status'] ='error';
			
		if(isset($_POST['tanggal']))
		{
			$tanggal=$_POST['tanggal'];
			if(DateTime::createFromFormat('d/m/Y',$tanggal))$tanggal=DateTime::createFromFormat('d/m/Y',$tanggal)->format('Y-m-d');
			$cek = Taccountledger::model()->findAll("doc_date = '$tanggal' and budget_cd='DEPR' ");
			if($cek)
			{
				$resp['status']='success';
			}
		
			
		
		}
		echo json_encode($resp);
	}
public function actionIndex()
{
	$model = new Postingmonthlydepr;	
	//$model->doc_date = date('t/m/Y');
	$model->doc_date = $this->getLastDay(date('t/m/Y'));
	$flg='N';
	$cek_folder =  Sysparam::model()->find("param_id='GL_JOURNAL_ENTRY' and param_cd1='DOC_REF'")->dflg1;
	$valid=true;
	if(isset($_POST['Postingmonthlydepr']))
	{
		$model->attributes = $_POST['Postingmonthlydepr'];
		$model->user_id =Yii::app()->user->id;
	
	if(DateTime::createFromFormat('d/m/Y',$model->doc_date))$model->doc_date = DateTime::createFromFormat('d/m/Y',$model->doc_date)->format('Y-m-d');
	
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$model->ip_address = $ip;
			$model->mmyy = DateTime::createFromFormat('Y-m-d',$model->doc_date)->format('my');
			$model->user_id = Yii::app()->user->id;
			
			if($cek_folder=='Y' && $model->folder_cd=='')
			{
				$model->addError('folder_cd', 'File Number cannot be blank');
				$valid=false;
			}
/*
			$cek = Taccountledger::model()->find("doc_date='$model->doc_date' and budget_cd='DEPR' ");
			if($cek)
			{
				Yii::app()->user->setFlash('info', 'Sudah pernah diposting');
			}
	*/		
			if($valid &&$model->validate() && $model->executeSp()>0)
			{
				Yii::app()->user->setFlash('success', 'Process Completed');
				$this->redirect(array('index','flg'=>'Y') );
			}
			
	}	
	if(DateTime::createFromFormat('Y-m-d',$model->doc_date))$model->doc_date = DateTime::createFromFormat('Y-m-d',$model->doc_date)->format('d/m/Y');	
	$this->render('index',array('model'=>$model,'flg'=>$flg));	
	
}
public function getLastDay($date)
{
	$x=0;
	do{
			$sql = "select F_IS_HOLIDAY('$date') as num from dual";
			$cek = DAO::queryRowSql($sql);
			$x = 0;
			if($cek['num']=='1')
			{
				$sql = "SELECT GET_DOC_DATE(1,TO_DATE('$date','dd/mm/yyyy')) as doc_date from dual";
				$exec = DAO::queryRowSql($sql);
				$date = $exec['doc_date'];
				$date = DateTime::createFromFormat('Y-m-d H:i:s',$date)->format('d/m/Y');
				$x=1;
			}	
	}
	while($x=0);
	
	return $date;
	
}
	
	
}
