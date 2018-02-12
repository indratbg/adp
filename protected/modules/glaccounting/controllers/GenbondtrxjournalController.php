<?php

class GenbondtrxjournalController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model= array();
		$modeldummy = new Tbondtrx;
		$valid = true;
		$success = false;
		
		$price_dt = null;
		$cancel_reason = '';

		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			if($scenario == 'filter')
			{
				$trx_date = $_POST['trxdate'];
				$trx_id = null;
				if(!$_POST['allid']){
					$trx_id = $_POST['trxid'];
				}else{
					$modeldummy->allid = $_POST['allid']; 
				}
				
				
				$modeldummy->trx_date = $trx_date;
				$modeldummy->trx_id = $trx_id?$trx_id : null;
				$modeldummy->validate(array('trx_date'));
				
				if($trx_id){
					$model = Tbondtrx::model()->findAll(array(
					'condition'=>"to_char(trx_date,'DD/MM/YYYY') = '$trx_date' AND trx_id = '$trx_id' AND ((nvl(sett_val,0) + nvl(sett_for_curr,0)) = 0) AND approved_sts in ('E','A') AND (NVL(journal_status,'X') <> 'A' OR doc_num IS NULL)",
					'order'=>'trx_id, price, trx_type'));
				}else{
					$model = Tbondtrx::model()->findAll(array(
					'condition'=>"to_char(trx_date,'DD/MM/YYYY') = '$trx_date' AND approved_sts in ('E','A') AND ((nvl(sett_val,0) + nvl(sett_for_curr,0)) = 0) AND (NVL(journal_status,'X') <> 'A' OR doc_num IS NULL)",
					'order'=>'trx_id, price, trx_type'));
				}
				
				if(!$model){
					$modeldummy->addError('','Tidak ada bond transaction yang belum dijurnal');
				}else{
					foreach($model as $m){
						$m->save_flg = 'Y';
					}
				}
			}
			else 
			{
				$trx_date = $_POST['trxdate'];
				$trx_id = $_POST['allid']?null : $_POST['trxid'] ;
				$modeldummy->trx_date = $trx_date;
				$modeldummy->trx_id = $trx_id;
				$modeldummy->validate(array('trx_date'));
				$rowCount = $_POST['rowCount'];
				
				$x;
				
				$save_flag = false; //False if no record is saved
		
				for($x=0;$x<$rowCount;$x++)
				{
					$model[$x] = new Tbondtrx;
					$model[$x]->attributes = $_POST['Tbondtrx'][$x+1];
					
					if(isset($_POST['Tbondtrx'][$x+1]['save_flg']) && $_POST['Tbondtrx'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						//$valid = $model[$x]->validate(array('ctp_num')) && $valid;

					}else{
						$model[$x]->save_flg == 'N';
					}
					
					$model[$x]->validate(array('nominal','price','net_amount'));

				}
				
				$valid = $valid && $save_flag;
				
				if($valid)
				{
					$success = false;
					$transaction;
					$menuName = 'GEN BOND TRX JOURNAL';
					//$connection  = Yii::app()->db;
					//$transaction = $connection->beginTransaction();
					if($model[0]->executeSpManyHeader(AConstant::INBOX_STAT_INS,$menuName,$transaction) > 0)
						$success = true;
					
					for($x=0;$success && $x<$rowCount;$x++)
					{
						//var_dump($model[$x]->save_flg);
						//die();
						$model[$x]->update_date = $model[0]->update_date;
						$model[$x]->update_seq = $model[0]->update_seq;
						$model[$x]->user_id = Yii::app()->user->id;
						$ip = Yii::app()->request->userHostAddress;
						if($ip=="::1")
							$ip = '127.0.0.1';
						$model[$x]->ip_address = $ip;
						if($model[$x]->save_flg == 'Y')
						{
							//UPDATE
							if($success && $model[$x]->executeSpBondTrxJur($x+1, $transaction) > 0){
								$success = true;
								
							}else {
								$success = false;
							}
							//var_dump($model[$x]->trx_seq_no);
							//die();
							
							if($success && $model[$x]->executeSpBondTrxSecu(0, $transaction) > 0){
								$success = true;
								
							}else {
								$success = false;
							}
							
						}

					}
					
					if($success)
					{
						$transaction->commit();	
					}
					else {
						$transaction->rollback();
					}
					
					if($success){
						//var_dump($model[0]->executeApproveGenBondJurnal('GEN BOND TRX JOURNAL',$model[0]->update_date,$model[0]->update_seq));
						//die();
						if($model[0]->executeApproveGenBondJurnal($menuName) > 0){
							Yii::app()->user->setFlash('success', 'Bond transaction journal has been successfully generated');
							$this->redirect(array('/glaccounting/genbondtrxjournal/index'));
						}
					}
				}
			}
		}
		else {
			$model = Tbondtrx::model()->findAll(array(
					'condition'=>"trx_date = trunc(sysdate) AND approved_sts in ('E','A') AND ((nvl(sett_val,0) + nvl(sett_for_curr,0)) = 0) AND (NVL(journal_status,'X') <> 'A' OR doc_num IS NULL)",
					'order'=>'trx_id, price, trx_type'));
			foreach($model as $row){
				$row->save_flg = 'Y';
			}
			$modeldummy->trx_date = date('Y-m-d');
			$modeldummy->allid = 'Y';
			if(!$model){
				$model = null;
			}
		}
		//var_dump($model[0]->value_dt);
		//var_dump($_POST);
		//die();
		//var_dump($model[0]->error_msg);
		//die();
		$this->render('index',array(
			'model'=>$model,
			'modeldummy'=>$modeldummy
		));
	}
	
	public function actionCancel()
	{
		$model= array();
		$modeldummy = new Tbondtrx;
		$valid = true;
		$success = false;
		
		$price_dt = null;
		$cancel_reason = '';

		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			if($scenario == 'filter')
			{
				$trx_date = $_POST['trxdate'];
				$trx_id = null;
				if(!$_POST['allid']){
					$trx_id = $_POST['trxid'];
				}else{
					$modeldummy->allid = $_POST['allid']; 
				}
				
				
				$modeldummy->trx_date = $trx_date;
				$modeldummy->trx_id = $trx_id?$trx_id : null;
				$modeldummy->validate(array('trx_date'));
				
				if($trx_id){
					$model = Tbondtrx::model()->findAll(array(
					'condition'=>"to_char(trx_date,'DD/MM/YYYY') = '$trx_date' AND trx_id = '$trx_id' AND ((nvl(sett_val,0) + nvl(sett_for_curr,0)) = 0) AND approved_sts in ('E','A') AND (NVL(journal_status,'X') = 'A' OR doc_num IS NOT NULL)",
					'order'=>'trx_id, price, trx_type'));
				}else{
					$model = Tbondtrx::model()->findAll(array(
					'condition'=>"to_char(trx_date,'DD/MM/YYYY') = '$trx_date' AND approved_sts in ('E','A') AND ((nvl(sett_val,0) + nvl(sett_for_curr,0)) = 0) AND (NVL(journal_status,'X') = 'A' OR doc_num IS NOT NULL)",
					'order'=>'trx_id, price, trx_type'));
				}
				
				if(!$model){
					$modeldummy->addError('','Tidak ada bond transaction yang sudah dijurnal');
				}else{
					foreach($model as $m){
						$m->save_flg = 'N';
					}
				}
			}
			else 
			{
				$trx_date = $_POST['trxdate'];
				$trx_id = $_POST['allid']?null : $_POST['trxid'] ;
				$modeldummy->trx_date = $trx_date;
				$modeldummy->trx_id = $trx_id;
				$modeldummy->validate(array('trx_date'));
				$rowCount = $_POST['rowCount'];
				
				$x;
				
				$save_flag = false; //False if no record is saved
		
				for($x=0;$x<$rowCount;$x++)
				{
					$model[$x] = new Tbondtrx;
					$model[$x]->attributes = $_POST['Tbondtrx'][$x+1];
					
					if(isset($_POST['Tbondtrx'][$x+1]['save_flg']) && $_POST['Tbondtrx'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						//$valid = $model[$x]->validate(array('ctp_num')) && $valid;

					}else{
						$model[$x]->save_flg == 'N';
					}
					$model[$x]->validate(array('nominal','price','net_amount'));

				}
				
				$valid = $valid && $save_flag;
				
				if($valid)
				{
					$success = false;
					$transaction;
					$menuName = 'CANCEL BOND TRX JOURNAL';
					//$connection  = Yii::app()->db;
					//$transaction = $connection->beginTransaction();
					if($model[0]->executeSpManyHeader(AConstant::INBOX_STAT_CAN,$menuName,$transaction) > 0)
						$success = true;
					
					for($x=0;$success && $x<$rowCount;$x++)
					{
						//var_dump($model[$x]->save_flg);
						//die();
						$model[$x]->update_date = $model[0]->update_date;
						$model[$x]->update_seq = $model[0]->update_seq;
						$model[$x]->user_id = Yii::app()->user->id;
						$ip = Yii::app()->request->userHostAddress;
						if($ip=="::1")
							$ip = '127.0.0.1';
						$model[$x]->ip_address = $ip;
						if($model[$x]->save_flg == 'Y')
						{
							//UPDATE
							if($success && $model[$x]->executeSpBondTrxJurCancel($x+1,$transaction) > 0){
								$success = true;
								
							}else {
								$success = false;
							}
							
						}

					}

					if($success)
					{
						$transaction->commit();	
					}
					else {
						$transaction->rollback();
					}
					
					if($success){
						if($model[0]->executeApproveGenBondJurnal($menuName) > 0){
							Yii::app()->user->setFlash('success', 'Bond transaction journal has been successfully canceled');
							$this->redirect(array('/glaccounting/genbondtrxjournal/cancel'));
						}
					}
				}
			}
		}
		else {
			$model = Tbondtrx::model()->findAll(array(
					'condition'=>"trx_date = trunc(sysdate) AND approved_sts in ('E','A') AND ((nvl(sett_val,0) + nvl(sett_for_curr,0)) = 0) AND (NVL(journal_status,'X') = 'A' OR doc_num IS NOT NULL)",
					'order'=>'trx_id, price, trx_type'));
			foreach($model as $row){
				$row->save_flg = 'N';
			}
			$modeldummy->trx_date = date('Y-m-d');
			$modeldummy->allid = 'Y';
			if(!$model){
				$model = null;
			}
		}
		$this->render('cancel',array(
			'model'=>$model,
			'modeldummy'=>$modeldummy
		));
	}

	public function loadModel($trx_date, $trx_seq_no)
	{
		$model=Tbondtrx::model()->findByPk(array('trx_date'=>$trx_date,'trx_seq_no'=>$trx_seq_no));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
