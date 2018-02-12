<?php
ini_set('memory_limit', '128M');
class ContractcorrectionController extends AAdminController
{

	public $layout='//layouts/admin_column2';

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->user_id = Yii::app()->user->id;
		$ip = Yii::app()->request->userHostAddress;
		if($ip=="::1") $ip = '127.0.0.1';
		$model->ip_address = $ip;
		$model->brok_perc /= 100;
		$client = Client::model()->find(array('select'=>'cifs, custodian_cd','condition'=>"client_cd = '$model->client_cd'"));
		$cif = Cif::model()->find(array('select'=>'sid','condition'=>"cifs = '$client->cifs'"));
		
		if($client->custodian_cd){
			$sid = '%';
			$dropdownclient = Client::model()->findAllBySql("SELECT a.client_cd client_cd, client_name FROM MST_CLIENT a LEFT JOIN T_EXCEPTION_SPLITTING b ON a.client_cd = b.client_cd
			WHERE (b.available_dt = to_date('$model->contr_dt','YYYY-MM-DD') AND b.client_cd is not null) OR a.custodian_cd is not null order by 1");
		}else{
			$sid = $cif->sid;
			$dropdownclient = Client::model()->findAllBySql("SELECT a.client_cd client_cd, client_name FROM MST_CLIENT a LEFT JOIN T_EXCEPTION_SPLITTING b ON a.client_cd = b.client_cd
			WHERE (b.available_dt = to_date('$model->contr_dt','YYYY-MM-DD') AND b.client_cd is not null) OR a.SID = '$sid' order by 1");
		}
		
		$model1 = array();
		$model1[0] = new Tcontracts;
		$valid = false;
		$success = false;
		$totalqty = 0;
		
		if(isset($_POST['rowcount']))
		{
			$rowCount = $_POST['rowcount'];
			$x;
			$y;
			$totalqty = 0;
			$valid = true;
			$seq = 2;
			$model->seqno = 1;
			$model->scenario = 'splitting';
				
			for($x=2;$x<=$rowCount;$x++)
			{
				if(isset($_POST['Tcontracts'][$x]))
				{
					$model1[$x] = new Tcontracts;
					$model1[$x]->attributes=$_POST['Tcontracts'][$x];
					$temp = $model1[$x]->client_cd;
					$qcommission = DAO::queryRowSql("SELECT commission_per FROM MST_CLIENT WHERE client_cd = '$temp'");
					$commission = $qcommission['commission_per'];
					$model1[$x]->seqno = $seq;
					$model1[$x]->contr_dt = $model->contr_dt;
					$model1[$x]->stk_cd = $model->stk_cd;
					$model1[$x]->price = $model->price;
					$model1[$x]->lawan_perc = $commission/100; //AS:only to bypass the validation rule for lawan_perc
					$model1[$x]->brok_perc = $commission/100;
					$valid = $model1[$x]->validate() && $valid;
					$totalqty += $model1[$x]->qty;
					$seq++;
				}	
			}
			$model->correction_reason = $_POST['Tcontracts']['correction_reason'];
			$valid = $model->validate(array('correction_reason')) && $valid;
			
			if($totalqty != $model->qty || $totalqty == 0){
				$valid = false;
				$flg = 0;
				for($x=2;$x<=$rowCount;$x++){
					if(isset($_POST['Tcontracts'][$x]) && $flg == 0){
						$model->addError('', 'Total quantity must equal to '.$model->qty);
						$flg = 1;
					}	
				}
			}
			
		}else{
			$rowCount = 0;
		}
		
		if($valid)
		{	
			$transaction; //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
			$menuName = 'CONTRACT CORRECTION';
			if($model->executeSpManyHeader(AConstant::INBOX_STAT_UPD,$menuName,$transaction) > 0)
				$success = true;

			if($success && $model->executeSpCancelContract(AConstant::INBOX_STAT_CAN,1,$transaction) > 0)
				$success = true;
			else {
				$success = false;
			}
			
			for($x=2; $success && $x<=$rowCount ;$x++)
			{
				if(isset($_POST['Tcontracts'][$x]))
				{
					$model1[$x]->update_date = $model->update_date;
					$model1[$x]->update_seq = $model->update_seq;
					$model1[$x]->contr_num = $model->contr_num;
					$bj = substr($model->contr_num,4,1);
					if($success && $model1[$x]->executeSp(AConstant::INBOX_STAT_INS,$x,$bj,$transaction) > 0){
						$success = true;
					}else {
						$success = false;
					}
				}	
			}

			if($success)
			{
				$transaction->commit();
				Yii::app()->user->setFlash('success', 'Successfully update contract correction');
				$this->redirect(array('/contracting/contractcorrection/index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'model1'=>$model1,
			'sid'=>$sid,
			'dropdownclient'=>$dropdownclient,
			'rowCount'=>$rowCount,
			'totalqty'=>$totalqty
		));
	}
	
	public function actionAjxPopSelfcorrect($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		$model1 = NULL;
		$model  = new Tmanyheader;
		$model->scenario = 'cancel';
		if(isset($_POST['Tmanyheader']))
		{
			$transaction;
			$success = false;
			$model->attributes = $_POST['Tmanyheader'];
			$model->user_id = Yii::app()->user->id;
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$model->ip_address = $ip;
			
			if($model->validate()){
				
				$model1 = $this->loadModel($id);
				$temp = $model1->client_cd;
				$qcommission = DAO::queryRowSql("SELECT commission_per FROM MST_CLIENT WHERE client_cd = '$temp'");
				$commission = $qcommission['commission_per'];
				$model1->lawan_perc = $commission/100; //AS:only to bypass the validation rule for lawan_perc
				$model1->brok_perc = $commission/100;
				$model1->correction_reason  = $model->cancel_reason;
				$menuName = 'CONTRACT CORRECTION';
				
				$model1->user_id = Yii::app()->user->id;
				$ip = Yii::app()->request->userHostAddress;
				if($ip=="::1")
					$ip = '127.0.0.1';
				$model1->ip_address = $ip;
				$transaction;
				if($model1->executeSpManyHeader(AConstant::INBOX_STAT_UPD,$menuName,$transaction) > 0)
					$success = true;
				if($success && $model1->executeSpCancelContract(AConstant::INBOX_STAT_CAN,1,$transaction) > 0)
					$success = true;
				else {
					$success = false;
				}
				
				$bj = substr($model1->contr_num,4,1);
				if($success && $model1->executeSp(AConstant::INBOX_STAT_INS,2,$bj,$transaction) > 0){
					$success = true;
				}else {
					$success = false;
				}
				
				if($success){
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully update contract correction');
					$is_successsave = true;
				}	
				
			}
		}

		$this->render('_popselfcorr',array(
			'model'=>$model,
			'model1'=>$model1,
			'is_successsave'=>$is_successsave		
		));
	}

	public function actionIndex()
	{
		$model=new Vcontractcorrection('search');
		$model->unsetAttributes();  // clear any default values
		$model->contr_dt = date('d/m/Y');
		
		$tcontracts = new Tcontracts;
		
		if(isset($_GET['Vcontractcorrection'])):
			$model->attributes=$_GET['Vcontractcorrection'];
		endif;
		
		$this->render('index',array(
			'model'=>$model,
			'modelTcontracts'=>$tcontracts,
		));
	}

	public function loadModel($id)
	{
		$model=Tcontracts::model()->findByPk($id);
		$model->belijual = substr($model->contr_num,4,1);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
}
