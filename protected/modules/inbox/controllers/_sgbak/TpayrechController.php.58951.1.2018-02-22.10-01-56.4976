<?php

class TpayrechController extends AAdminController
{
	public $menu_name = 'VOUCHER ENTRY';
	public $parent_table_name = 'T_PAYRECH';
	public $child_table_name = 'T_ACCOUNT_LEDGER';
	
	public $sp_approve = 'SP_T_PAYRECH_APPROVE';
	public $sp_reject = 'SP_T_PAYRECH_REJECT';
	
	public $layout = '//layouts/admin_column3';
	
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		$modelParentDetail	  = null;
		$modelParentDetailUpd   = null;
		$modelChildDetail = array();
		$modelChildDetailUpd = array();
		
		if($model->status == AConstant::INBOX_STAT_UPD)
		{
			$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name AND record_seq = 1',array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name));
		}
		else
		{
			$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name',array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name));
		}
		
		$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->child_table_name)));
		$listTmanyChildDetail = array();
		
		$x;
		
		for($x=0;$x<$childRecordCount->record_cnt;$x++)
		{
			$listTmanyChildDetail[$x] = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq',array(':update_seq'=>$model->update_seq,':table_name'=>$this->child_table_name,':record_seq'=>($x+1)));
		}
		
		if($model->status == AConstant::INBOX_STAT_UPD){	
			
			$modelChildDetailCurr = array();
			
			if($childRecordCount->record_cnt > 0)
			{
				// REVERSAL
				$listTmanyParentDetailCancel = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name AND upd_status = \'C\'',array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name));
				$parentRowid = $listTmanyParentDetailCancel[0]->table_rowid;
			
				$modelParentDetailCurr = Tpayrech::model()->find("rowid ='$parentRowid'"); 
				$modelParentDetail = new Tpayrech;
			
				Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
				
				$modelChildDetailCurr = Taccountledger::model()->findAll("xn_doc_num = '$modelParentDetailCurr->payrec_num'");
				
				for($x=0,$y=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$modelChildDetail[$y] = new Taccountledger;
					Tmanydetail::generateModelAttributes2($modelChildDetail[$y], $listTmanyChildDetail[$x]);
					
					if($modelChildDetail[$y]->record_source == 'RE')
					{
						unset($modelChildDetail[$y]);
					}
					else {
						$y++;
					}
				}
			}
			else 
			{
				// NON REVERSAL
				$parentRowid = $listTmanyParentDetail[0]->table_rowid;
			
				$modelParentDetailCurr = Tpayrech::model()->find("rowid ='$parentRowid'"); 
				$modelParentDetail = new Tpayrech;
			
				Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
				
				$modelChildDetailCurr = Taccountledger::model()->findAll("xn_doc_num = '$modelParentDetail->payrec_num'");
			}
			
			if($model->approved_status != AConstant::INBOX_APP_STAT_ENTRY):
				$this->render('view',array(
					'model'=>$model,
					'modelParentDetail'=>$modelParentDetail,
					'modelChildDetail' => $modelChildDetail,
					'listTmanyChildDetail'=>$listTmanyChildDetail,
				));	
			else:
				
				$this->render('view_compare',array(
					'model'=>$model,
					'modelParentDetailCurr'=>$modelParentDetailCurr,
					'modelChildDetailCurr'=>$modelChildDetailCurr,
					'modelParentDetail'=>$modelParentDetail,
					'modelChildDetail' =>$modelChildDetail,
					'listTmanyChildDetail'=>$listTmanyChildDetail,
				));
			endif;

		}else{
			if($model->status == AConstant::INBOX_STAT_CAN){
				$parentRowid = $listTmanyParentDetail[0]->table_rowid;
				$modelParentDetail = Tpayrech::model()->find("rowid ='$parentRowid'");

				$modelChildDetail = Taccountledger::model()->findAll("xn_doc_num = '$modelParentDetail->payrec_num'");

			}else{
				$modelParentDetail  = new Tpayrech;
				Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
								
				for($x=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$modelChildDetail[$x] = new Taccountledger;
					Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
				}
				
				/*if(substr($modelParentDetail->payrec_type ,1,1) == 'D') //Non Transaction
				{
					$modelChildDetailFirst = new Tpayrecd;
					$modelChildDetailFirst->gl_acct_cd = $modelParentDetail->gl_acct_cd;
					$modelChildDetailFirst->sl_acct_cd = $modelParentDetail->sl_acct_cd;
					$modelChildDetailFirst->payrec_amt = $modelParentDetail->curr_amt;
					$modelChildDetailFirst->remarks = $modelParentDetail->remarks;
					$modelChildDetailFirst->tal_id = 90;
					$modelChildDetailFirst->doc_date = $modelParentDetail->payrec_date;
					$modelChildDetailFirst->db_cr_flg = substr($modelParentDetail->payrec_type,0,1) == 'R'?'D':'C'; 

					$modelChildDetail = array_merge(array($modelChildDetailFirst),$modelChildDetail);
				}	*/			
			}
			
			$this->render('view',array(
				'model'=>$model,
				'modelParentDetail'=> $modelParentDetail,
				'modelChildDetail' => $modelChildDetail,
				'listTmanyChildDetail'=>$listTmanyChildDetail,
			));	
		}
	}

	public function actionAjxPopReject($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model = $this->loadModel($id);
		$model->scenario = 'reject';
		
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];			
			if($model->validate()):
				$this->reject($model);
				$is_successsave = true;
			endif;
		}

		$this->render('/template/_popreject',array(
			'model'=>$model,
			'is_successsave'=>$is_successsave
		));
	}

	public function actionAjxPopRejectChecked()
	{
		$this->layout 	= '//layouts/main_popup';
		
		if(!isset($_GET['arrid']))
			throw new CHttpException(404,'The requested page does not exist.');
		
		$is_successsave = false;
		$model = new Tmanyheader();
		$model->scenario = 'rejectchecked';
		
		$arrid = $_GET['arrid'];
			
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];
			if($model->validate() && $this->rejectChecked($model,$arrid))
				$is_successsave = true;
		}	
	

		$this->render('/template/_popreject',array(
			'model'=>$model,
			'is_successsave'=>$is_successsave
		));	
	} 
	
	public function actionApprove($id)
	{
		$model = $this->loadModel($id);
		//$recordCnt = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->child_table_name)));
		$model->approve($this->sp_approve);
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '.$model->update_seq);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason,$this->sp_reject);
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject '.$model->update_seq);
	}
	
	private function rejectChecked($model,$arrid)
	{
		$reject_reason = $model->reject_reason;
		
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->reject($reject_reason,$this->sp_reject);
			
			if($model->error_code < 0){
				Yii::app()->user->setFlash('error', 'Error reject '.$model->update_seq.' '.$model->error_msg);
				return false;
			}
		endforeach;
		
		Yii::app()->user->setFlash('success', 'Successfully reject '.json_encode($arrid));
		return true;
	}
	

	public function actionApproveChecked()
	{
		$result  = 'error';
		
		if(isset($_POST['arrid'])):
			
			$arrid	 = $_POST['arrid'];
			$result  = 'success';
			
			foreach($arrid as $id)
			{
				$model = $this->loadModel($id);
				$model->approve($this->sp_approve);
				
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '.$model->update_seq.' '.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($arrid));
		endif;
		
		echo $result;
	}

	public function actionIndex()
	{
		$model = new Vinboxpayrec('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Vinboxpayrec']))
			$model->attributes=$_GET['Vinboxpayrec'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionIndexProcessed()
	{
		$model = new Tmanyheader('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = '<>'.AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Tmanyheader']))
			$model->attributes=$_GET['Tmanyheader'];

		$this->render('index_processed',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model = Tmanyheader::model()->find('update_seq=:update_seq AND menu_name=:menu_name',array(':update_seq'=>$id,':menu_name'=>$this->menu_name));
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
