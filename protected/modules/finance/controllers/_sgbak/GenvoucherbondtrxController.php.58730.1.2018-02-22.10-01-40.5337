<?php

class GenvoucherbondtrxController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model= array();
		$modeldummy = new Vvoucherbondtrx;
		$valid = true;
		$success = false;
		$cancel_reason = '';

		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			if($scenario == 'filter')
			{
				$value_dt = $_POST['valuedt'];
				$trx_id = null;
				if(!$_POST['allid']){
					$trx_id = $_POST['trxid'];
				}else{
					$modeldummy->allid = $_POST['allid']; 
				}
				
				
				$modeldummy->value_dt = $value_dt;
				$modeldummy->trx_id = $trx_id?$trx_id : null;
				$modeldummy->validate(array('value_dt'));
				
				if($trx_id){
					$model = Vvoucherbondtrx::model()->findAll(array(
					'condition'=>"to_char(value_dt,'DD/MM/YYYY') = '$value_dt' AND trx_id = '$trx_id'",
					'order'=>'trx_seq_no'));
				}else{
					$model = Vvoucherbondtrx::model()->findAll(array(
					'condition'=>"to_char(value_dt,'DD/MM/YYYY') = '$value_dt'",
					'order'=>'trx_seq_no'));
				}
				
				if(!$model){
					$modeldummy->addError('','Bond transaction not found!');
				}
				/*
				else{
					foreach($model as $m){
						$m->save_flg = 'Y';
					}
				}
				 * 
				 */
			}
			else 
			{
				$value_dt = $_POST['valuedt'];
				$trx_id = $_POST['allid']?null : $_POST['trxid'] ;
				$modeldummy->value_dt = $value_dt;
				$modeldummy->trx_id = $trx_id;
				$modeldummy->validate(array('value_dt'));
				$rowCount = $_POST['rowCount'];
				
				$x;
				
				$save_flag = false; //False if no record is saved
		
				for($x=0;$x<$rowCount;$x++)
				{
					$model[$x] = new Vvoucherbondtrx;
					$model[$x]->attributes = $_POST['Vvoucherbondtrx'][$x+1];
					if(isset($_POST['Vvoucherbondtrx'][$x+1]['save_flg']) && $_POST['Vvoucherbondtrx'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						$model[$x]->scenario = 'generate';

					}else{
						$model[$x]->save_flg == 'N';
					}
					$valid = $model[$x]->validate() && $valid;

				}
				
				$valid = $valid && $save_flag;
				
				if($valid)
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					$success = true;
					$menuName = 'GENERATE VOUCHER BOND TRX';
					
					for($x=0;$success && $x<$rowCount;$x++)
					{
						$model[$x]->user_id = Yii::app()->user->id;
						$ip = Yii::app()->request->userHostAddress;
						if($ip=="::1")
							$ip = '127.0.0.1';
						$model[$x]->ip_address = $ip;
				
						if($model[$x]->save_flg == 'Y')
						{
							if($model[$x]->executeSpManyHeader(AConstant::INBOX_STAT_INS,$menuName,$transaction) > 0)
								$success = true;
							else
								$success = false;
							
							//INSERT
							if($success && $model[$x]->executeSpVchBondTrx(AConstant::INBOX_STAT_INS,$transaction) > 0){
								$success = true;
								
							}else {
								$success = false;
							}
						}

					}					

					if($success)
					{
						$transaction->commit();
							
						Yii::app()->user->setFlash('success', 'Voucher to settle bond transaction has been successfully generated');
						$this->redirect(array('/finance/genvoucherbondtrx/index'));
					}
					else {
						$transaction->rollback();
					}
				}
			}
		}
		else {
			$model = Vvoucherbondtrx::model()->findAll(array(
					'condition'=>"value_dt = trunc(sysdate)",
					'order'=>'trx_seq_no'));
			$modeldummy->value_dt = date('Y-m-d');
			$modeldummy->allid = 'Y';
			if(!$model){
				$model = null;
			}
		}
		
		$this->render('index',array(
			'model'=>$model,
			'modeldummy'=>$modeldummy
		));
	}
}
