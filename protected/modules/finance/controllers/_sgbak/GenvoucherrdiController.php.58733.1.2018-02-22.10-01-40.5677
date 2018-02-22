<?php

Class GenvoucherrdiController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	public $menuName = 'GENERATE VOUCHER TRANSFER RDI';
	
	public function actionAjxGetDueDate()
	{
		$due_date = '';
		
		if(isset($_POST['trxDate']))
		{
			$trx_date = $_POST['trxDate'];
			$result2 = DAO::queryRowSql("SELECT TO_CHAR(GET_DUE_DATE(3, TO_DATE('$trx_date','DD/MM/YYYY')),'DD/MM/YYYY') due_date FROM dual");
			
			$due_date = $result2['due_date'];
		}
		
		echo json_encode($due_date);
	}
	
	public function actionIndex()
	{
		$model = new GenVoucherRDI('header');
		$modelVoucherList = array();
		$retrieved = false;
		$processed = false;
		$viewOnly = false;
		$valid = false;
		$success = false;
		
		if(isset($_POST['GenVoucherRDI']))
		{
			$model->attributes = $_POST['GenVoucherRDI'];
			
			if($_POST['submit'] == 'retrieve')
			{
				if($model->validate())
				{
					if($model->due_date != date('Y-m-d'))$viewOnly = true;
					
					$result = DAO::queryRowSql("SELECT GET_DOC_DATE(3, TO_DATE('$model->due_date','YYYY-MM-DD')) doc_date FROM dual");
					$doc_date = $result['doc_date'];
					
					$bal_date = DateTime::createFromFormat('Y-m-d H:i:s',$doc_date)->format('Y-m-01');
					
					$brch_cd = $model->brch_all_flg=='Y'?'%':$model->brch_cd;
					
					$modelVoucherList = GenVoucherRDI::model()->findAllBySql(GenVoucherRDI::getVoucherTransferRdiSql($bal_date, $model->due_date, $brch_cd));

					if($modelVoucherList)
					{
						$retrieved = true;
					}
				}
			}
			else 
			{
				$retrieved = true;
				$generateFlg = false;
				
				$x = 0;
				
				/*foreach($_POST['VoucherList'] as $row)
				{
					$modelVoucherList[$x] = new GenVoucherRDI;
					$modelVoucherList[$x]->attributes = $row;
					//$modelVoucherList[$x]->validate();

					$x++;
				}*/
				
				if($model->validate())
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					if($model->executeSpTransferRDI() > 0)$success = TRUE;
					else {
						$success = FALSE;
					}
					
					if($success)
					{
						$transaction->commit();
						
						if($model->successCnt > 0)
						{
							Yii::app()->user->setFlash('success', 'Generate Voucher Success: '.$model->successCnt.' --- Fail: '.$model->failCnt.'. '.$model->failMsg);
							$this->redirect(array('index'));
						}
						else {
							Yii::app()->user->setFlash('error', 'Generate Voucher Success: '.$model->successCnt.' --- Fail: '.$model->failCnt.'. '.$model->failMsg);
							$this->redirect(array('index'));
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
			$model->brch_all_flg = 'Y';
			$model->bank_all_flg = 'Y';
		}
		
		$this->render('index',array(
			'model'=>$model,
			'modelVoucherList'=>$modelVoucherList,
			'retrieved'=>$retrieved,
			'processed'=>$processed,
			'viewOnly'=>$viewOnly
		));
	}
}
