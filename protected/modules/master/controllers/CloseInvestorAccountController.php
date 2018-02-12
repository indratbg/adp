<?php

class CloseInvestorAccountController extends AAdminController
{
	public $layout='//layouts/admin_column2';

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$isvalid = false;
		$model = new Clientflacct;
		
		if(isset($_POST['Clientflacct']))
		{
			$model->attributes	= $_POST['Clientflacct'];
			$submitsts 			= $_POST['submit'];
			$model->scenario   = $submitsts;
					 
			if($submitsts == 'closeinvacct-validate')
			{	
				if($model->validate())
				{
					$model	= Clientflacct::model()->find('client_cd=:client_cd', array(':client_cd'=>$model->client_cd));		
					$row  	= DAO::queryRowSql("SELECT F_FUND_BAL ('".$model->client_cd."',trunc(sysdate)) as saldo_rdi FROM dual");
					$model->saldo_rdi = $row['saldo_rdi'];
					
					if($model->saldo_rdi == 0)
						$model->shw_btn_conf = 1;	
					
					$isvalid = true;
	            }	
			}
			else if($submitsts == 'closeinvacct-close')
			{
				$isvalid 	= true;
				if($model->validate() && $model->saldo_rdi == 0)
				{
					$model	= Clientflacct::model()->find('client_cd=:client_cd', array(':client_cd'=>$model->client_cd));		
					$row  	= DAO::queryRowSql("SELECT F_FUND_BAL ('".$model->client_cd."',trunc(sysdate)) as saldo_rdi FROM dual");
					$model->saldo_rdi = $row['saldo_rdi'];
					$model->acct_stat = 'C';
						
					if($model->executeSp(AConstant::INBOX_STAT_UPD) > 0)
					{
						Yii::app()->user->setFlash('success', 'Successfully close investor account '.$model->client_cd);
						$this->redirect(array('/inbox/closeinvestoraccount/index'));
					} 
	            }
	            else
	            {
	            	$model->executeSpValidate();
	            }
			}
		}
		

		$this->render('create',array(
			'model'=>$model,
			'isvalid'=>$isvalid
		));
	}

	public function loadModel($id)
	{
		$model=TClientclosing::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
