<?php
Class H2honlinetransferController extends AAdminController
{
	public $layout = '//layouts/admin_column2';

	public function actionIndex()
	{
		$model = new Th2hrefheader;
		$modelDetail = new Th2hrefdetail;
		$sql = "select bi_code,ip_bank_cd||' - '||bi_code||' - '||bank_name bank_name  from mst_bank_bi WHERE APPROVED_STAT='A' order by bank_name";
		$bi_code = DAO::queryAllSql($sql);
		$today = date('d/m/Y');

		$model->trf_date = date('Ymd');
		$model->transfer_type = 'BCA';
		$model->receiver_bank_cd = '0140397';
		$model->receiver_cust_type = '1';
		$model->receiver_cust_residence = 'R';
		$model->curr_cd = 'IDR';
		$model->trx_amt = '0';
		//$model->from_acct = '0611107446';
		//only testing
		//$model->to_acct = '0611117506';
		//only testing
		//$model->trx_ref = 'RF00001';
		//$model->remark1 = 'Remark 1';
		//$model->remark2 = 'Remark 2';

		$success = true;
		$valid = true;
		if (isset($_POST['Th2hrefheader']))
		{
			$model->attributes = $_POST['Th2hrefheader'];

			$result = DAO::queryRowSql("SELECT Get_TRF_ID(to_date('$today','dd/mm/yyyy'))trf_id FROM DUAL");
			$trx_id = $result['trf_id'];
			$model->trf_id = $trx_id;

			$connection = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			$menuName = 'ONLINE TRANSFER';
			$valid = $valid && $model->validate();

			if ($valid)
			{
				$model->user_id = Yii::app()->user->id;
				$ip = Yii::app()->request->userHostAddress;
				if($ip=="::1")
					$ip = '127.0.0.1';
				$model->ip_address = $ip;
				$model->trx_type='OT';
				$model->kbb_type1='9';
				$model->total_record='1';
				$model->save_date = date('Y-m-d H:i:s');
				if ($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName) > 0)
					$success = true;
				else
				{
					$success = false;
				}
				
				//INSERT INTO T_H2H_REF_HEADER
				if ($success && $model->executeSp(AConstant::INBOX_STAT_INS, $model->trf_id, 1) > 0)
					$success = true;
				else
				{
					$success = false;
				}
				//INSERT INTO T_H2H_REF_DETAIL
				$modelDetail->update_date = $model->update_date;
				$modelDetail->update_seq = $model->update_seq;
				$modelDetail->row_id = 1;
				$modelDetail->trx_ref = $model->trx_ref;
				$modelDetail->trf_id = $model->trf_id;
				$modelDetail->acct_name = $model->receiver_name;
				$modelDetail->rdi_acct = $model->from_acct;
				$modelDetail->client_bank_acct = $model->to_acct;
				$modelDetail->bank_name = $model->receiver_bank_name;
				$modelDetail->trf_amt = $model->trx_amt;

				if ($success && $modelDetail->executeSp(AConstant::INBOX_STAT_INS, $modelDetail->trf_id, $modelDetail->trx_ref, 1) > 0)
					$success = true;
				else
				{
					$success = false;
				}

				if ($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data successfully Save, Please check Approval');
					$this->redirect(array('index'));
				}
				else
				{
					$transaction->rollback();
				}
			}

		}

		$this->render('index', array(
			'model' => $model,
			'modelDetail' => $modelDetail,
			'bi_code' => $bi_code
		));
	}

}
