<?php

class TrepoController extends AAdminController
{
	public $menu_name = 'REPO ENTRY';
	public $parent_table_name = 'T_REPO';
	public $child_table_name = 'T_REPO_HIST';
	public $child_table_name2 = 'T_REPO_VCH';
	
	public $sp_approve = 'SP_T_REPO_APPROVE';
	
	public $layout='//layouts/admin_column3';
	
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		$modelParentDetail	  = null;
		$modelParentDetailUpd   = null;
		$modelChildDetail = array();
		$modelChildDetailUpd = array();
		$voucher = false;
		
		$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name',array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name));
		$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name IN (:table_name,:table_name2)','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->child_table_name,':table_name2'=>$this->child_table_name2)));
		$listTmanyChildDetail = array();
		
		$x;
		
		for($x=0;$x<$childRecordCount->record_cnt;$x++)
		{
			$listTmanyChildDetail[$x] = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name IN (:table_name,:table_name2) AND record_seq = :record_seq',array(':update_seq'=>$model->update_seq,':table_name'=>$this->child_table_name,':table_name2'=>$this->child_table_name2,':record_seq'=>($x+1)));
		}
		
		if($model->status == AConstant::INBOX_STAT_UPD){
			$parentRowid = $listTmanyParentDetail[0]->table_rowid;
			
			$modelParentDetailCurr = Trepo::model()->find("rowid ='$parentRowid'"); 
			$modelParentDetail = Trepo::model()->find("rowid ='$parentRowid'");
			Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
			
			$modelChildDetailCurr = array();
			
			$check = Tmanydetail::model()->find("update_seq ='$model->update_seq' AND table_name ='$this->child_table_name2'");
			if($check)
			{
				$voucher = true;
				$modelChildDetailCurr = Trepovch::model()->findAllBySql(Trepovch::getVchSql($modelParentDetailCurr->repo_date, $modelParentDetailCurr->client_cd, $modelParentDetailCurr->repo_num));
			}
			
			for($x=0;$x<$childRecordCount->record_cnt;$x++)
			{
				if($listTmanyChildDetail[$x][0]->table_rowid)
				{
					//Status = UPDATE OR CANCEL
					$childRowid=$listTmanyChildDetail[$x][0]->table_rowid;
					if($voucher)
					{
						$modelVch = Trepovch::model()->find("rowid ='$childRowid'");
						//$modelChildDetailCurr[$x] = Vrepovch::model()->find("repo_num ='$modelVch->repo_num' AND doc_num = '$modelVch->doc_num'");
						$modelChildDetail[$x] = Trepovch::model()->findBySql(Trepovch::getVchSql($modelParentDetailCurr->repo_date, $modelParentDetailCurr->client_cd, $modelParentDetailCurr->repo_num,$modelVch->doc_num,$modelVch->doc_ref_num));
					}
					else {
						$modelChildDetailCurr[$x] = Trepohist::model()->find("rowid ='$childRowid'");
						$modelChildDetail[$x] = Trepohist::model()->find("rowid ='$childRowid'");
					}
					if($listTmanyChildDetail[$x][0]->upd_status == 'U')
					{	
						//Status = UPDATE
						Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
					}
				}
				else {
					//Status = INSERT
					if($voucher)$modelChildDetail[$x] = new Trepovch;
					else
						$modelChildDetail[$x] = new Trepohist;
					
					Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
				}
			}
			
			if($model->approved_status != AConstant::INBOX_APP_STAT_ENTRY):
				$this->render('view',array(
					'model'=>$model,
					'modelParentDetail'=>$modelParentDetail,
					'modelChildDetail' => $modelChildDetail,
					'listTmanyChildDetail'=>$listTmanyChildDetail,
					'voucher'=>$voucher,
				));	
			else:
				
				$this->render('view_compare',array(
					'model'=>$model,
					'modelParentDetailCurr'=>$modelParentDetailCurr,
					'modelChildDetailCurr'=>$modelChildDetailCurr,
					'modelParentDetail'=>$modelParentDetail,
					'modelChildDetail' =>$modelChildDetail,
					'listTmanyChildDetail'=>$listTmanyChildDetail,
					'voucher'=>$voucher,
				));
			endif;

		}else{
			if($model->status == AConstant::INBOX_STAT_CAN){
				$parentRowid = $listTmanyParentDetail[0]->table_rowid;
				$modelParentDetail = Trepo::model()->find("rowid ='$parentRowid'");
				for($x=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$childRowid=$listTmanyChildDetail[$x][0]->table_rowid;
					$modelChildDetail[$x] = Trepohist::model()->find("rowid ='$childRowid'");
				}
			}else{
				$modelParentDetail  = new Trepo;
				Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);			
				for($x=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$modelChildDetail[$x] = new Trepohist;
					Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
				}
			}
			
			$this->render('view',array(
				'model'=>$model,
				'modelParentDetail'=> $modelParentDetail,
				'modelChildDetail' => $modelChildDetail,
				'listTmanyChildDetail'=>$listTmanyChildDetail,
				'voucher'=>$voucher,
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
		$model->approve($this->sp_approve);
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '.$model->update_seq);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason);
		
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
			$model->reject($reject_reason);
			
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
		$model = new Tmanyheader('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Tmanyheader']))
			$model->attributes=$_GET['Tmanyheader'];

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
