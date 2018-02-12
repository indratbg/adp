<?php

Class GenvoucherkseiController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	public $menuName = 'GENERATE VOUCHER TRANSFER KSEI';
	
	public function actionIndex()
	{
		$model = new GenVoucherKSEI('header');
		$modelVoucherList = array();
		$retrieved = false;
		$valid = false;
		$success = false;
		$scenario = '';
		
		if(isset($_POST['GenVoucherKSEI']))
		{
			$model->attributes = $_POST['GenVoucherKSEI'];
			
			if($_POST['submit'] != 'generate')
			{
				if($model->validate())
				{
					$retrieved = true;
					
					$scenario = $_POST['submit'];
					
					$result = DAO::queryRowSql("SELECT GET_DOC_DATE(3, TO_DATE('$model->due_date','YYYY-MM-DD')) doc_date FROM dual");
					$doc_date = $result['doc_date'];
					
					$bal_date = DateTime::createFromFormat('Y-m-d H:i:s',$doc_date)->format('Y-m-01');
					
					$mode = $scenario=='transfer'?'TRF':'KSEI';
					
					$modelVoucherList = GenVoucherKSEI::model()->findAllBySql(GenVoucherKSEI::getVoucherTransferKseiSql($bal_date, $model->due_date, $mode, $model->branch_code));

					$model->due_date = DateTime::createFromFormat('Y-m-d',$model->due_date)->format('d/m/Y');
				}
			}
			else 
			{
				$retrieved = true;
				$scenario = 'transfer';
				$valid = true;			
				$generateFlg = false;
				
				$x = 0;
				
				foreach($_POST['VoucherList'] as $row)
				{
					$modelVoucherList[$x] = new GenVoucherKSEI($scenario);
					$modelVoucherList[$x]->attributes = $row;
					$modelVoucherList[$x]->due_date = $model->due_date;
										
					if($row['generate'] == 'Y')
					{
						$generateFlg = true;
						$valid = $modelVoucherList[$x]->validate() && $valid;
					}
					
					$x++;
				}
				
				if($valid && $generateFlg)
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					$success = TRUE;
					
					$successCnt = $failCnt = 0;
					$failMsg = '';
					
					foreach($modelVoucherList as $row)
					{
						if($row->generate == 'Y')
						{
							if($success && $row->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
							else {
								$success = FALSE;
							}
							
							if($success && $row->executeSpTransferKSEI(AConstant::INBOX_STAT_INS) > 0)$success = TRUE;
							else {
								$success = FALSE;
							}
							
							if($success)
							{
								if($row->fail_vch == 0)$successCnt++;
								else {
									$failCnt++;
									$failMsg = $row->error_msg;
								}
							}
							else {
								break;
							}
						}
					}
					
					if($success)
					{
						$transaction->commit();
						
						if($successCnt > 0)
						{
							Yii::app()->user->setFlash('success', 'Generate Voucher Success: '.$successCnt.' --- Fail: '.$failCnt.'. '.$failMsg);
							$this->redirect(array('index'));
						}
						else {
							Yii::app()->user->setFlash('error', 'Generate Voucher Success: '.$successCnt.' --- Fail: '.$failCnt.'. '.$failMsg);
						}
					}
					else {
						$transaction->rollback();
					}
				}
			}
		}
		else 
		{
			$model->due_date = date('d/m/Y');
		}
		
		$this->render('index',array(
			'model'=>$model,
			'modelVoucherList'=>$modelVoucherList,
			'retrieved'=>$retrieved,
			'scenario'=>$scenario,
		));
	}
}
