<?php

class GensecujournalvaluedtController extends AAdminController
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
					$model = Tbondtrx::model()->findAll(array(
					'select'=>"T.*, decode(custodian_cd,'KSEI7','Y','N') isksei",
					'condition'=>"trx_date <= to_date('$value_dt','DD/MM/YYYY') AND value_dt <= to_date('$value_dt','DD/MM/YYYY') AND trx_id = '$trx_id' AND settle_secu_flg is null AND doc_num is not null AND secu_jur_trx is not null AND approved_sts in ('E','A')",
					'order'=>'trx_date desc, trx_id, price, trx_type'));
				}else{
					$model = Tbondtrx::model()->findAll(array(
					'select'=>"T.*, decode(custodian_cd,'KSEI7','Y','N') isksei",
					'condition'=>"trx_date <= to_date('$value_dt','DD/MM/YYYY') AND value_dt <= to_date('$value_dt','DD/MM/YYYY') AND settle_secu_flg is null AND doc_num is not null AND secu_jur_trx is not null AND approved_sts in ('E','A')",
					'order'=>'trx_date desc, trx_id, price, trx_type'));
				}
				
				if(!$model){
					$modeldummy->addError('','Tidak ada bond transaction yang belum disettle');
				}else{
					foreach($model as $m){
						$m->save_flg = 'Y';
					}
				}
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
					$model[$x] = new Tbondtrx;
					$model[$x]->attributes = $_POST['Tbondtrx'][$x+1];
					if($model[$x]->isksei != 'Y'){
						$model[$x]->isksei = 'N';
					}
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
					$menuName = 'GEN SECU JOURNAL VALUE DT';
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
							//var_dump($model[$x]->trx_seq_no);
							//die();
							
							if($success && $model[$x]->executeSpBondTrxSecuValuedt($x+1, $transaction, $menuName) > 0){
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
							Yii::app()->user->setFlash('success', 'Securities journal has been successfully generated');
							$this->redirect(array('/custody/gensecujournalvaluedt/index'));
						}
					}
				}
			}
		}
		else {
			$model = Tbondtrx::model()->findAll(array(
					'select'=>"T.*, decode(custodian_cd,'KSEI7','Y','N') isksei",
					'condition'=>"trx_date <= SYSDATE AND value_dt <= SYSDATE AND settle_secu_flg is null AND doc_num is not null AND secu_jur_trx is not null AND approved_sts in ('E','A')",
					'order'=>'trx_date desc, trx_id, price, trx_type'));
			foreach($model as $row){
				$row->save_flg = 'Y';
			}
			$modeldummy->value_dt = date('Y-m-d');
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

	public function loadModel($trx_date, $trx_seq_no)
	{
		$model=Tbondtrx::model()->findByPk(array('trx_date'=>$trx_date,'trx_seq_no'=>$trx_seq_no));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
