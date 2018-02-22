<?php

Class NettingarapController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	public $menuName = 'NETTING VOUCHER';
	
	public function actionIndex()
	{
		$model = new Nettingarap;
		$valid = false;
		$success = false;
		
		if(isset($_POST['Nettingarap']))
		{
			$model->attributes = $_POST['Nettingarap'];	
			
			if($model->validate())
			{				
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				
				$success = TRUE;
				
				if($success && $model->executeSpNettingArap() > 0)$success = TRUE;
				else {
					$success = FALSE;
				}
				
				if($success)
				{
					$transaction->commit();
					
					if($model->successCnt > 0)
					{
						Yii::app()->user->setFlash('success', 'Generate Voucher Success: '.$model->successCnt.' --- Fail: '.$model->failCnt.'. '.$model->failMsg);
						$this->redirect(array('index'));
					}
					else {
						Yii::app()->user->setFlash('error', 'Generate Voucher Success: '.$model->successCnt.' --- Fail: '.$model->failCnt.'. '.$model->failMsg);
					}
				}
				else {
					$transaction->rollback();
				}
			}
		}
		else 
		{
			$model->netting_date = date('d/m/Y');
		}
		
		$this->render('index',array(
			'model'=>$model,
		));
	}
}
