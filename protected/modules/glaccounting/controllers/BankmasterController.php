<?php

class BankmasterController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	public function actionView($id)
	{
		$modelAcct = Bankacct::model()->findAll("bank_cd = '$id' AND approved_stat = '".AConstant::INBOX_APP_STAT_APPROVE."'");	
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'modelAcct'=>$modelAcct,
		));
	}

	public function actionCreate()
	{
		$model=new Bankmaster;
		$modelAcct = array();
		$modelAcct[0]=new Bankacct;
		$modelAcct[0]->closed_date = '01/01/2050';
		
		$init = true;
		$valid = false;
		$success = false;

		if(isset($_POST['Bankmaster']))
		{
			$init = false;
			
			$model->attributes=$_POST['Bankmaster'];
			$valid = $model->validate();
			
			if(isset($_POST['rowCount']))
			{
				$rowCount = $_POST['rowCount'];
				$x;
				$y;
					
				for($x=0;$x<$rowCount;$x++)
				{
					if(isset($_POST['Bankacct'][$x+1]['save_flg']) && $_POST['Bankacct'][$x+1]['save_flg'] == 'Y')
					{
						$modelAcct[$x] = new Bankacct;
						$modelAcct[$x]->attributes=$_POST['Bankacct'][$x+1];
						
						$modelAcct[$x]->gl_acct_cd = strtoupper($modelAcct[$x]->gl_acct_cd);
						$modelAcct[$x]->sl_acct_cd = strtoupper($modelAcct[$x]->sl_acct_cd);
						$modelAcct[$x]->brch_cd	   = strtoupper($modelAcct[$x]->brch_cd);
						$modelAcct[$x]->gl_acct_cd = trim($modelAcct[$x]->gl_acct_cd);
						$modelAcct[$x]->sl_acct_cd = trim($modelAcct[$x]->sl_acct_cd);
						$modelAcct[$x]->bank_acct_cd = trim($modelAcct[$x]->bank_acct_cd);
						$modelAcct[$x]->brch_cd = trim($modelAcct[$x]->brch_cd);
						
						$valid = $modelAcct[$x]->validate() && $valid;
					}	
				}
				
				//validasi primary key tiap baris yang di-save tidak boleh ada yang sama 
				for($x=0;$valid && $x < $rowCount;$x++)
				{
					for($y = $x+1;$valid && $y < $rowCount;$y++)
					{
						if(
							isset($_POST['Bankacct'][$x+1]['save_flg']) && $_POST['Bankacct'][$x+1]['save_flg'] == 'Y'
							&& isset($_POST['Bankacct'][$y+1]['save_flg']) && $_POST['Bankacct'][$y+1]['save_flg'] == 'Y'
						)
						{
							if($modelAcct[$x]->gl_acct_cd == $modelAcct[$y]->gl_acct_cd && $modelAcct[$x]->sl_acct_cd == $modelAcct[$y]->sl_acct_cd)
							{
								$modelAcct[$x]->addError('gl_acct_cd','Duplicated Main Acct + Sub Acct');
								$valid = false;
							}
							else if($modelAcct[$x]->bank_acct_cd == $modelAcct[$y]->bank_acct_cd)
							{
								$modelAcct[$x]->addError('bank_acct_cd','Duplicated Bank Code + Bank Acct Code');
								$valid = false;
							}
						}
					}
				}
			
				if($valid)
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
					$menuName = 'OPERATIONAL BANK ENTRY';
					
					if($model->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
					
					if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->bank_cd,1) > 0)$success = true;
					else {
						$success = false;
					}
					
					$recordSeq = 1;
					
					for($x=0; $success && $x<$rowCount ;$x++)
					{
						if($modelAcct[$x]->save_flg == 'Y')
						{
							if($success && $modelAcct[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelAcct[$x]->gl_acct_cd,$modelAcct[$x]->sl_acct_cd,$modelAcct[$x]->bank_cd,$modelAcct[$x]->bank_acct_cd,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
							else {
								$success = false;
							}
							$recordSeq++;
						}	
					}
					if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/glaccounting/bankmaster/index'));
					}
					else {
						$transaction->rollback();
					}
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'modelAcct'=>$modelAcct,
			'init'=>$init,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$modelAcct = array();
		
		$valid = false;
		$success = false;
		$upd_flag = false;
		
		$cancel_reason = '';
		
		$x = 0;
		$check = array();
		$oldPkId = array();
		
		if(isset($_POST['Bankmaster']))
		{
			$model->attributes=$_POST['Bankmaster'];
			$valid = $model->validate();
				
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
				$modelAcct[$x] = new Bankacct;
				$modelAcct[$x]->attributes = $_POST['Bankacct'][$x+1];
				
				if(isset($_POST['Bankacct'][$x+1]['save_flg']) && $_POST['Bankacct'][$x+1]['save_flg'] == 'Y')
				{
					if(isset($_POST['Bankacct'][$x+1]['cancel_flg']))
					{
						if($_POST['Bankacct'][$x+1]['cancel_flg'] == 'Y')
						{
							//CANCEL
							$modelAcct[$x]->scenario = 'cancel';
							$modelAcct[$x]->cancel_reason = $_POST['cancel_reason'];
						}
						else 
						{
							//UPDATE
							$modelAcct[$x]->scenario = 'update';
						}
					}
					else 
					{
						//INSERT
						$modelAcct[$x]->scenario = 'insert';
					}
					
					$modelAcct[$x]->gl_acct_cd = strtoupper($modelAcct[$x]->gl_acct_cd);
					$modelAcct[$x]->sl_acct_cd = strtoupper($modelAcct[$x]->sl_acct_cd);
					$modelAcct[$x]->brch_cd = strtoupper($modelAcct[$x]->brch_cd);
					$modelAcct[$x]->gl_acct_cd = trim($modelAcct[$x]->gl_acct_cd);
					$modelAcct[$x]->sl_acct_cd = trim($modelAcct[$x]->sl_acct_cd);
					$modelAcct[$x]->bank_acct_cd = trim($modelAcct[$x]->bank_acct_cd);
					$modelAcct[$x]->brch_cd = trim($modelAcct[$x]->brch_cd);
					
					$valid = $modelAcct[$x]->validate() && $valid;
				}
				else {
					$modelAcct[$x]->gl_acct_cd = $modelAcct[$x]->old_gl_acct_cd; //Get the old value since the field on form is disabled
				}
			}
			
			//validasi primary key tiap baris yang di-save tidak boleh ada yang sama (kecuali yang di-cancel)
			for($x=0;$valid && $x < $rowCount;$x++)
			{
				for($y = $x+1;$valid && $y < $rowCount;$y++)
				{
					if(
						isset($_POST['Bankacct'][$x+1]['save_flg']) && $_POST['Bankacct'][$x+1]['save_flg'] == 'Y'
						&& isset($_POST['Bankacct'][$y+1]['save_flg']) && $_POST['Bankacct'][$y+1]['save_flg'] == 'Y'
						&& (!isset($_POST['Bankacct'][$x+1]['cancel_flg']) || $_POST['Bankacct'][$x+1]['cancel_flg'] != 'Y')
						&& (!isset($_POST['Bankacct'][$y+1]['cancel_flg']) || $_POST['Bankacct'][$y+1]['cancel_flg'] != 'Y')
					)
					{
						if($modelAcct[$x]->gl_acct_cd == $modelAcct[$y]->gl_acct_cd && $modelAcct[$x]->sl_acct_cd == $modelAcct[$y]->sl_acct_cd)
						{
							$modelAcct[$x]->addError('gl_acct_cd','Duplicated Main Acct + Sub Acct');
							$valid = false;
						}
						else if($modelAcct[$x]->bank_cd == $modelAcct[$y]->bank_cd && $modelAcct[$x]->bank_acct_cd == $modelAcct[$y]->bank_acct_cd)
						{
							$modelAcct[$x]->addError('bank_acct_cd','Duplicated Bank Code + Bank Acct Code');
							$valid = false;
						}
					}
				}
			}
			
			if($valid)
			{
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
				$menuName = 'OPERATIONAL BANK ENTRY';
				
				if($model->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName) > 0)$success = true;
				
				if($success && $model->executeSp(AConstant::INBOX_STAT_UPD,$model->bank_cd,1) > 0)$success = true;
				else {
					$success = false;
				}
				
				$recordSeq = 1;
				
				for($x=0; $success && $x<$rowCount; $x++)
				{
					if($modelAcct[$x]->save_flg == 'Y')
					{
						if($modelAcct[$x]->cancel_flg == 'Y')
						{
							//CANCEL
							$modelAcct[$x]->bank_cd = $model->bank_cd;
							if($success && $modelAcct[$x]->executeSp(AConstant::INBOX_STAT_CAN,$modelAcct[$x]->old_gl_acct_cd,$modelAcct[$x]->old_sl_acct_cd,$model->bank_cd,$modelAcct[$x]->old_bank_acct_cd,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
							else {
								$success = false;
							}
						}
						else if($modelAcct[$x]->old_bank_acct_cd)
						{
							//UPDATE
							if($success && $modelAcct[$x]->executeSp(AConstant::INBOX_STAT_UPD,$modelAcct[$x]->old_gl_acct_cd,$modelAcct[$x]->old_sl_acct_cd,$model->bank_cd,$modelAcct[$x]->old_bank_acct_cd,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
							else {
								$success = false;
							}
						}			
						else 
						{
							//INSERT
							if($success && $modelAcct[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelAcct[$x]->gl_acct_cd,$modelAcct[$x]->sl_acct_cd,$modelAcct[$x]->bank_cd,$modelAcct[$x]->bank_acct_cd,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
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
					$this->redirect(array('/glaccounting/bankmaster/index'));
				}
				else {
					$transaction->rollback();
				}
			}
		}
		else{
			$modelAcct = Bankacct::model()->findAll(array('condition'=>"bank_cd = '$id' AND approved_stat = '".AConstant::INBOX_APP_STAT_APPROVE."'",'order'=>'rowid'));

			foreach($modelAcct as $row)
			{
				$row->gl_acct_cd = trim($row->gl_acct_cd);
				$row->brch_cd = trim($row->brch_cd);
				$row->scenario = 'update';
				
				$row->old_bank_acct_cd = $row->bank_acct_cd;
				$row->old_gl_acct_cd = $row->gl_acct_cd;
				$row->old_sl_acct_cd = $row->sl_acct_cd;
				$row->old_bank_acct_type = $row->bank_acct_type;
				$row->old_brch_cd = $row->brch_cd;
				$row->old_folder_prefix = $row->folder_prefix;
				$row->old_curr_cd = $row->curr_cd;
				$row->old_closed_date = $row->closed_date = $row->closed_date?DateTime::createFromFormat('Y-m-d H:i:s',$row->closed_date)->format('d/m/Y'):'';
			}
		}
		
		//cek apakah bank_cd pada MST_BANK_ACCT boleh diupdate
		$x = 0;
		foreach($modelAcct as $row)
		{
			$check[$x] = Tcheq::model()->find(array('select'=>'COUNT(*) "check"','condition'=>"chq_dt >= TRUNC(TO_DATE('$row->cre_dt','YYYY-MM-DD HH24:MI:SS')) AND bank_cd = '$row->bank_cd'"));
			$x++;
		}

		$this->render('update',array(
			'model'=>$model,
			'modelAcct'=>$modelAcct,
			'cancel_reason'=>$cancel_reason,
			'check'=>$check,
		));
	}

	public function actionAjxValidateCancel()
	{
		$resp['status']  = 'error';
		
		if(isset($_POST['gl_acct_cd']) && isset($_POST['sl_acct_cd']))
		{
			$found = false;
			$gl_acct_cd = $_POST['gl_acct_cd'];
			$sl_acct_cd = $_POST['sl_acct_cd'];
			$find = Taccountledger::model()->find("trim(gl_acct_cd) = '$gl_acct_cd' AND sl_acct_cd = '$sl_acct_cd' AND approved_sts = 'A'");
			
			if($find)$found = true;
			else {
				$found = false;
			}
			
			$resp['status'] = 'success';
		}	
		
		$resp['content'] = array('found'=>$found);
		echo json_encode($resp);
	}
	
	public function actionAjxPopDelete($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		$model1 = $this->loadModel($id);
		
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];	
					
			if($model->validate()){
				$model1->cancel_reason  = $model->cancel_reason;
				$model1->user_id = Yii::app()->user->id;
				$model1->ip_address = Yii::app()->request->userHostAddress;
				if($model1->ip_address=="::1")
					$model1->ip_address = '127.0.0.1';
				
				$success = false;
				$menuName = 'OPERATIONAL BANK ENTRY';
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				
				if($model1->executeSpHeader(AConstant::INBOX_STAT_CAN,$menuName) > 0)$success = true;
				
				if($success && $model1->executeSp(AConstant::INBOX_STAT_CAN,$id,1) > 0){
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->bank_cd);
					$is_successsave = true;
				}
				else {
					$transaction->rollback();
				}
			}
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$model1,
			'is_successsave'=>$is_successsave		
		));
	}

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

	public function actionIndex()
	{
		$model=new Bankmaster('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->approved_stat = 'A';

		if(isset($_GET['Bankmaster']))
			$model->attributes=$_GET['Bankmaster'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Bankmaster::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
