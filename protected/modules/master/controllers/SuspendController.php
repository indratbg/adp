<?php

class SuspendController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	public function actionIndex()
	{
		$model= array();
		$valid = true;
		$success = false;
		$selected = 0;
		$client_cd='';
		$client_cd1='';
			
		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			if($scenario == 'filter')
			{ //echo "<script>alert('test')</script>";
				$client_cd = $_POST['Client_cd'];
				$client_cd1 =$_POST['Client_cd1'];
				$selected = $_POST['filter'];
				if($client_cd!=''){
		
				$model = Clientsuspend::model()->findAll(array('condition'=>"client_cd like '%$client_cd%' and susp_stat <> 'C' and client_type_1 <> 'B' ",'order'=>'cifs,client_cd'));
				}
				else{
					
				$model = Clientsuspend::model()->findAll(array('condition'=>"client_cd like '%$client_cd1%' and susp_stat <> 'C' and client_type_1 <> 'B'",'order'=>'cifs,client_cd'));
				}
			
			
			}
			else 
			{ 
				$rowCount = $_POST['rowCount'];
				
			
				$x;
				
				$save_flag = false; //False if no record is saved
			
		
				for($x=0;$x<$rowCount;$x++)
				{
					$client_cd=$_POST['Client'][$x+1]['client_cd'];
					
					$model[$x] = ClientSuspend::model()->find(array('condition'=>"client_cd= '$client_cd'"));
					$model[$x]->attributes = $_POST['Client'][$x+1];
					
					
					if(isset($_POST['Client'][$x+1]['save_flg']) && $_POST['Client'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						
						//UPDATE
						$model[$x]->scenario = 'update';
						
						$valid = $model[$x]->validate() && $valid;
					}
				}
				
				$valid = $valid && $save_flag;
				
				if($valid)
				{ $ip = Yii::app()->request->userHostAddress;
				if($ip=="::1")
				$ip = '127.0.0.1';
			
				$model[0]->ip_address = $ip;
				$model[0]->upd_dt  = Yii::app()->datetime->getDateTimeNow();
				$model[0]->upd_by  = Yii::app()->user->id;
				$model[0]->user_id =  Yii::app()->user->id;
					$success = true;
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					$menuName = 'SUSPEND CLIENT ACCOUNT';
					
					
		
					for($x=0;$success && $x<$rowCount;$x++)
					{
							
						if($model[$x]->save_flg == 'Y')
						{if(DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->client_birth_dt))$model[$x]->client_birth_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->client_birth_dt)->format('Y-m-d');
						if(DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->acct_open_dt))$model[$x]->acct_open_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->acct_open_dt)->format('Y-m-d');
						if(DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->next_rollover_dt))$model[$x]->next_rollover_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->next_rollover_dt)->format('Y-m-d');
						if(DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->ac_expiry_dt))$model[$x]->ac_expiry_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->ac_expiry_dt)->format('Y-m-d');
						if(DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->commit_fee_dt))$model[$x]->commit_fee_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->commit_fee_dt)->format('Y-m-d');
						if(DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->roll_fee_dt))$model[$x]->roll_fee_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->roll_fee_dt)->format('Y-m-d');
						
						if(DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->init_deposit_efek_date))$model[$x]->init_deposit_efek_date=DateTime::createFromFormat('Y-m-d G:i:s' ,$model[$x]->init_deposit_efek_date)->format('Y-m-d');
						if(DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->closed_date))$model[$x]->closed_date=DateTime::createFromFormat('Y-m-d G:i:s',$model[$x]->closed_date)->format('Y-m-d');
				
							if($model[$x]->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName) > 0)$success = true;
								//UPDATE
								$model[$x]->susp_trx='A';
								$model[$x]->susp_stat=$model[$x]->old_susp_stat;
								
							
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model[$x]->client_cd,1) > 0)$success = true;
								else {
									$success = false;
								}
						}
					}

					if($success)
					{
						$transaction->commit();
							
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/master/suspend/index'));
					}
					else {
						$transaction->rollback();
					}
				}
			
					
			}
		}
		else {
		
			$model = Clientsuspend::model()->findAll(array('condition'=>"susp_stat <> 'C' and client_type_1 <> 'B' ",'order'=>'cifs,client_cd'));
			
	}
		$this->render('index',array(
			'model'=>$model,
			'client_cd'=>$client_cd,
			'client_cd1'=>$client_cd1,
			'selected'=>$selected
		));
	}

	public function loadModel($id)
	{
		$model=Clientsuspend::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
