<?php

class TinterestrateController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	public function actionView($client_cd)
	{
		$modelClient = Client::model()->findByPk($client_cd);
		$model=Tinterestrate::model()->findAll(array('select'=>'client_cd,eff_dt,int_on_receivable,int_on_payable','condition'=>"client_cd = trim('$client_cd') AND approved_stat = 'A'",'order'=>'eff_dt DESC'));
		
		$this->render('view',array(
			'model'=>$model,
			'modelClient'=>$modelClient,
		));
	}
/*
	public function actionCreate()
	{
		$model=new Tinterestrate;

		if(isset($_POST['Tinterestrate']))
		{
			$model->attributes=$_POST['Tinterestrate'];
			if($model->save()){
            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->client_cd);
				$this->redirect(array('view','id'=>$model->client_cd));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
*/
	public function actionUpdate($client_cd)
	{	$model = array();
		$model= $this->loadModel($client_cd);
		if(!$model->amt_int_flg)$model->amt_int_flg='Y';
		$valid = false;
		$success = false;
		$upd_flag = false;
		
		$cancel_reason = '';
		
		$x = 0;
		$check = array();
		$oldPkId = array();
		
		if(isset($_POST['Client']))
		{
			$model->attributes=$_POST['Client'];
			//$valid = $model->validate();
			$valid=true;
			//Manually assign user_id, upd_dt, upd_by, and ip_address because $modelClient->validate() confilcts with another menu
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			
			$model->ip_address = $ip;
			$model->upd_dt  = Yii::app()->datetime->getDateTimeNow();
			$model->upd_by  = Yii::app()->user->id;
			$model->user_id =  Yii::app()->user->id;
			$rowCount = $_POST['rowCount'];
			$x=0;
			$y=0;
			
			if(isset($_POST['cancel_reason']))
			{ 
				if(!$_POST['cancel_reason'])
				{
					$valid = false;
					Yii::app()->user->setFlash('error', 'Cancel Reason Must be Filled');
				}
				else
				{
					$cancel_reason = $_POST['cancel_reason'];
					$model->cancel_reason = $_POST['cancel_reason'];
				}
			}
			
			
				
			for($x=0;$x<$rowCount;$x++)
			{
				$modelInt[$x] = new Tinterestrate;
				$modelInt[$x]->attributes = $_POST['Tinterestrate'][$x+1];
				
				if(isset($_POST['Tinterestrate'][$x+1]['save_flg']) && $_POST['Tinterestrate'][$x+1]['save_flg'] == 'Y')
				{
					if(isset($_POST['Tinterestrate'][$x+1]['cancel_flg']))
					{
						if($_POST['Tinterestrate'][$x+1]['cancel_flg'] == 'Y')
						{
							//CANCEL
							$modelInt[$x]->scenario = 'cancel';
							$modelInt[$x]->cancel_reason = $_POST['cancel_reason'];
						}
						else 
						{
							//UPDATE
							$modelInt[$x]->scenario = 'update';
						}
					}
					else 
					{
						//INSERT
						$modelInt[$x]->scenario = 'insert';
					}
					
					$valid = $modelInt[$x]->validate() && $valid;
				}
				
				
			}
			
			//validasi primary key tiap baris yang si-save tidak boleh ada yang sama (kecuali yang di-cancel)
			for($x=0;$valid && $x < $rowCount;$x++)
			{
				for($y = $x+1;$valid && $y < $rowCount;$y++)
				{
					if(isset($_POST['Tinterestrate'][$x+1]['save_flg']) && $_POST['Tinterestrate'][$x+1]['save_flg'] == 'Y'
						&& isset($_POST['Tinterestrate'][$y+1]['save_flg']) && $_POST['Tinterestrate'][$y+1]['save_flg'] == 'Y'
						&& (!isset($_POST['Tinterestrate'][$x+1]['cancel_flg']) || $_POST['Tinterestrate'][$x+1]['cancel_flg'] != 'Y')
						&& (!isset($_POST['Tinterestrate'][$y+1]['cancel_flg']) || $_POST['Tinterestrate'][$y+1]['cancel_flg'] != 'Y')
					)
					{
						if($modelInt[$x]->eff_dt == $modelInt[$y]->eff_dt)
					{
						$modelInt[$x]->addError('eff_dt','Effective Date antar baris harus berbeda');
						$valid = false;
					}
					}
				}
			}
			
			if($valid)
			{
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
				$menuName = 'INTEREST RATE ENTRY';
				
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->client_birth_dt))$model->client_birth_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->client_birth_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->acct_open_dt))$model->acct_open_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->acct_open_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->next_rollover_dt))$model->next_rollover_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->next_rollover_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->ac_expiry_dt))$model->ac_expiry_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->ac_expiry_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->commit_fee_dt))$model->commit_fee_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->commit_fee_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->roll_fee_dt))$model->roll_fee_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->roll_fee_dt)->format('Y-m-d');
				
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->init_deposit_efek_date))$model->init_deposit_efek_date=DateTime::createFromFormat('Y-m-d G:i:s' ,$model->init_deposit_efek_date)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->closed_date))$model->closed_date=DateTime::createFromFormat('Y-m-d G:i:s',$model->closed_date)->format('Y-m-d');
				
				
				if($model->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName) > 0)$success = true;
				
				if($success && $model->executeSp(AConstant::INBOX_STAT_UPD,$model->client_cd,1) > 0)$success = true;
				else {
					$success = false;
				}
				
				$recordSeq = 1;
				
				for($x=0; $success && $x<$rowCount; $x++)
				{
					if($modelInt[$x]->save_flg == 'Y')
					{
						if($modelInt[$x]->cancel_flg == 'Y')
						{//$a=$modelInt[$x]->old_eff_dt;
						//echo "<script>alert('$a')</script>";
							//CANCEL
							$modelInt[$x]->old_client_cd = $model->client_cd;
							if($success && $modelInt[$x]->executeSp(AConstant::INBOX_STAT_CAN,$modelInt[$x]->old_client_cd,$modelInt[$x]->old_eff_dt,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
							else {
								$success = false;
							}
						}
						else if($modelInt[$x]->old_eff_dt)
						{$modelInt[$x]->client_cd = $model->client_cd;
						 
						// $a=$modelInt[$x]->old_eff_dt;
						// echo "<script>alert('$a')</script>";
							//UPDATE
							if($success && $modelInt[$x]->executeSp(AConstant::INBOX_STAT_UPD,$modelInt[$x]->client_cd,$modelInt[$x]->old_eff_dt,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
							else {
								$success = false;
							}
						}			
						else 
						{$modelInt[$x]->client_cd = $model->client_cd;
						// $a=$modelInt[$x]->old_eff_dt;
					//	echo "<script>alert('$a')</script>";
							//INSERT
							if($success && $modelInt[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelInt[$x]->client_cd,$modelInt[$x]->old_eff_dt,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
							else {
								$success = false;
							}
						}
						$recordSeq++;
					}
				}
	
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('/finance/tinterestrate/index'));
				}
				else {
					$transaction->rollback();
				}
				foreach($modelInt as $row)
					{
						if(DateTime::createFromFormat('Y-m-d',$row->eff_dt))$row->eff_dt=DateTime::createFromFormat('Y-m-d',$row->eff_dt)->format('d/m/Y');
					}	
			}
		}
		else{
			$modelInt = Tinterestrate::model()->findAll(array('select'=>'client_cd,eff_dt,int_on_receivable,int_on_payable','condition'=>"client_cd = trim('$client_cd') AND approved_stat = 'A'",'order'=>'eff_dt DESC'));

			foreach($modelInt as $row)
			{

				$row->scenario = 'update';
				if($row->eff_dt)$row->eff_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->eff_dt)->format('d/m/Y');
				$row->old_client_cd = $row->client_cd;
				$row->old_eff_dt = $row->eff_dt;
				
			}
			
		}
		
		/*//cek apakah bank_cd pada MST_BANK_ACCT boleh diupdate
		$x = 0;
		foreach($modelInt as $row)
		{
			$check[$x] = Tcheq::model()->find(array('select'=>'COUNT(*) "check"','condition'=>"chq_dt >= TRUNC(TO_DATE('$row->cre_dt','YYYY-MM-DD','HH24:MI:SS')) AND bank_cd = '$row->bank_cd'"));
			$x++;
		}
*/
		$this->render('update',array(
			'model'=>$model,
			'modelInt'=>$modelInt,
			'cancel_reason'=>$cancel_reason,
			'check'=>$check,
		));
	}

	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether a user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}
/*
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
*/
	public function actionIndex()
	{
		$model = new Vinterestrate('search');
		$model->unsetAttributes();
		
		if(isset($_GET['Vinterestrate']))
			$model->attributes=$_GET['Vinterestrate'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Client::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
