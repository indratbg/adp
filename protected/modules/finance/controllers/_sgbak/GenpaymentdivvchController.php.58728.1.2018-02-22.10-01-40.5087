<?php

Class GenpaymentdivvchController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	public $menuName = 'GENERATE VOUCHER SETTLE TRX';
	public function actionIndex()
	{
		$model = new Genpaymentdivvch;
		$folder_flg = Sysparam::model()->find("param_id='SYSTEM' AND PARAM_CD1='VCH_REF'")->dflg1;
		$model->payrec_date=date('d/m/Y');
		$modeldetail = array();
		$valid = true;
		$success=true;
		
		if(isset($_POST['Genpaymentdivvch']))
		{
			$scenario = $_POST['scenario'];
			$model->attributes = $_POST['Genpaymentdivvch'];
			if(DateTime::createFromFormat('d/m/Y',$model->payrec_date))$model->payrec_date=DateTime::createFromFormat('d/m/Y',$model->payrec_date)->format('Y-m-d');
			//get list voucher
			if($scenario =='filter')
			{
				$payrec_date = $model->payrec_date;
				$branch_cd = $model->brch_cd?$model->brch_cd:'%';
				$modeldetail = Genpaymentdivvch::model()->findAllBySql(Genpaymentdivvch::getPaymentList($payrec_date, $branch_cd));
				 
				foreach($modeldetail as $row)
				{
					$row->folder_cd = $model->getPrefixFolder($row->rdi_bank_cd); 
					$row->pembulatan ='0';
				}
				if(count($modeldetail)==0)
				{
					Yii::app()->user->setFlash('danger', 'No data found');
				}
			}
			//save voucher
			else
			{
				$rowCount = $_POST['rowCount'];
				
				for($x=0;$x<$rowCount;$x++)
				{
					$modeldetail[$x] = new Genpaymentdivvch;
					$modeldetail[$x]->attributes = $_POST['Genpaymentdivvch'][$x+1];
					$modeldetail[$x]->payrec_date = $model->payrec_date;
					//print_r($modeldetail[$x]->rowid);die();
					
					if($modeldetail[$x]->save_flg =='Y')
					{
						$valid=$valid && $modeldetail[$x]->validate();
					}
				}
				
				if($valid)
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction(); 
					$menuName = 'GENERATE PAYMENT DIVIDEN VOUCHER';
					
					for($x=0;$x<$rowCount;$x++)
					{
						if($modeldetail[$x]->save_flg =='Y')
						{
							if($modeldetail[$x]->executeSpPaymentDiv()>0)
							{
								$success=true;
							}
							else 
							{
								$success=false;
							}
						}
					}
					
					if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Generated');
						$this->redirect(array('index'));
					}
					else {
						$transaction->rollback();
					}
					
				}
				
				
			}
			
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->payrec_date))$model->payrec_date=DateTime::createFromFormat('Y-m-d',$model->payrec_date)->format('d/m/Y');
		$this->render('index',array(
			'model'=>$model,
			'modeldetail'=>$modeldetail,
			'folder_flg'=>$folder_flg
		));
	}
}
