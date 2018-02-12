<?php

class GenvoucherdivallController extends AAdminController
{
	public $layout='//layouts/admin_column3';

public function actionIndex()
{
	$model = new Genvoucherdivall;
	$model->distrib_dt = date('d/m/Y');
	$branch_flg = Sysparam::model()->find("param_id='VOUCHER_DIVIDEN' AND PARAM_CD1='BRANCH' and param_cd2='ALL'")->dflg1;
	$folder_flg = Sysparam::model()->find(" param_id='SYSTEM' AND PARAM_CD1='VCH_REF' ")->dflg1;
	$model->folder_cd = $model->getFolderPrefix();
	
	if(isset($_POST['Genvoucherdivall']))
	{
		$model->attributes = $_POST['Genvoucherdivall'];
		if(DateTime::createFromFormat('d/m/Y',$model->distrib_dt))$model->distrib_dt =DateTime::createFromFormat('d/m/Y',$model->distrib_dt)->format('Y-m-d'); 
		$model->user_id = Yii::app()->user->id; 
		$ip = Yii::app()->request->userHostAddress;
		if($ip=="::1")
			$ip = '127.0.0.1';
		$model->ip_address = $ip;
		
		
		if($model->executeSp()>0)
		{
			Yii::app()->user->setFlash('success', 'Successfully Generate Voucher Dividen');
		}
		
	}
	
	if(DateTime::createFromFormat('Y-m-d',$model->distrib_dt))$model->distrib_dt =DateTime::createFromFormat('Y-m-d',$model->distrib_dt)->format('d/m/Y'); 
	$this->render('index',array('model'=>$model,'branch_flg'=>$branch_flg,'folder_flg'=>$folder_flg));
}
}
