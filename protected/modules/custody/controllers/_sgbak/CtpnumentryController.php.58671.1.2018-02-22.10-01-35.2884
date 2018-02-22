<?php

class CtpnumentryController extends AAdminController
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
					'select'=>'trx_date, trx_seq_no, trx_id, trx_type, value_dt, bond_cd, nominal, price, lawan, ctp_num',
					'condition'=>"trx_date = to_date('$trx_date','DD/MM/YYYY') AND trx_id = '$trx_id' 
					AND approved_sts in ('E','A') AND rowid not in (SELECT h.table_rowid from
					t_temp_header h where h.table_name = 'T_BOND_TRX'
					and h.approved_status = 'E')",
					'order'=>'trx_date, trx_id, trx_type'));
				}else{
					$model = Tbondtrx::model()->findAll(array(
					'select'=>'trx_date, trx_seq_no, trx_id, trx_type, value_dt, bond_cd, nominal, price, lawan, ctp_num',
					'condition'=>"trx_date = to_date('$trx_date','DD/MM/YYYY')
					AND approved_sts in ('E','A') AND rowid not in (SELECT h.table_rowid from
					t_temp_header h where h.table_name = 'T_BOND_TRX'
					and h.approved_status = 'E')",
					'order'=>'trx_date, trx_id, trx_type'));
				}
				
				if(!$model){
					$modeldummy->addError('','Bond transaction not found!');
				}else{
					foreach($model as $m){
						$m->old_ctp_num = $m->ctp_num;
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
						$valid = $model[$x]->validate(array('ctp_num')) && $valid;

					}

				}
				
				$valid = $valid && $save_flag;
				
				if($valid)
				{
					$success = true;
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					for($x=0;$success && $x<$rowCount;$x++)
					{
						//var_dump($model[$x]->save_flg);
						//die();
						$model[$x]->user_id = Yii::app()->user->id;
						$ip = Yii::app()->request->userHostAddress;
						if($ip=="::1")
							$ip = '127.0.0.1';
						$model[$x]->ip_address = $ip;
						
						if($model[$x]->save_flg == 'Y')
						{
							//UPDATE
							if($success && $model[$x]->executeSpUpdCtpNum(AConstant::INBOX_STAT_UPD,$transaction) > 0){
								$success = true;
								
							}else {
								$success = false;
							}
							
						}

					}

					if($success)
					{
						$transaction->commit();
							
						Yii::app()->user->setFlash('success', 'CTP Number successfully saved');
						$this->redirect(array('/custody/ctpnumentry/index'));
					}
					else {
						$transaction->rollback();
					}
				}
			}
		}
		else {
			$model = null;
			$modeldummy->allid = 'Y';
			
		}
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
