<?php

class TconsoljrnController extends AAdminController
{
	public $menu_name = 'CONSOLIDATION JOURNAL ENTRY';
	public $parent_table_name = 'T_CONSOL_JRN';
	public $layout = '//layouts/admin_column3';
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		//$modelParentDetail	  = null;
		//$modelParentDetailUpd   = null;
		$modelChildDetail = array();
		$modelChildDetailUpd = array();
		
		//$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name',array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name));
		$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name)));
		$listTmanyChildDetail = array();
		
		$x;
		
		for($x=0;$x<$childRecordCount->record_cnt;$x++)
		{
			$listTmanyChildDetail[$x] = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq',array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name,':record_seq'=>($x+1)));
		}
		
		if($model->status == AConstant::INBOX_STAT_UPD){
			//$parentRowid = $listTmanyParentDetail[0]->table_rowid;
			
		//	$modelParentDetailCurr = Bankmaster::model()->find("rowid ='$parentRowid'"); 
			//$modelParentDetail = Bankmaster::model()->find("rowid ='$parentRowid'");
			//Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
			
			$modelChildDetailCurr = array();
			
			$xn_doc_num = Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date='$model->update_date' and field_name='XN_DOC_NUM'")->field_value;
			$doc_date = Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date='$model->update_date' and field_name='DOC_DATE'")->field_value;
			$modelChildDetailCurr =Tconsoljrn::model()->findAll("xn_doc_num='$xn_doc_num' and doc_date='$doc_date' and approved_sts='A'");
			
			for($x=0;$x<$childRecordCount->record_cnt;$x++)
			{
				if($listTmanyChildDetail[$x][0]->table_rowid)
				{
					//Status = UPDATE OR CANCEL
					$childRowid=$listTmanyChildDetail[$x][0]->table_rowid;
					//$modelChildDetailCurr[$x] = Tconsoljrn::model()->find("rowid ='$childRowid'");
					$modelChildDetail[$x] = Tconsoljrn::model()->find("rowid ='$childRowid'");
					if($listTmanyChildDetail[$x][0]->upd_status == 'U')
					{	
						//Status = UPDATE
						Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
					}
				}
				else {
					//Status = INSERT
					$modelChildDetail[$x] = new Tconsoljrn;
					Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
				}
			}
			
			if($model->approved_status != AConstant::INBOX_APP_STAT_ENTRY):
				$this->render('view',array(
					'model'=>$model,
					//'modelParentDetail'=>$modelParentDetail,
					'modelChildDetail' => $modelChildDetail,
					'listTmanyChildDetail'=>$listTmanyChildDetail,
				));	
			else:
				
				$this->render('view_compare',array(
					'model'=>$model,
					//'modelParentDetailCurr'=>$modelParentDetailCurr,
					'modelChildDetailCurr'=>$modelChildDetailCurr,
					//'modelParentDetail'=>$modelParentDetail,
					'modelChildDetail' =>$modelChildDetail,
					'listTmanyChildDetail'=>$listTmanyChildDetail,
				));
			endif;

		}else{
			if($model->status == AConstant::INBOX_STAT_CAN){
				//$parentRowid = $listTmanyParentDetail[0]->table_rowid;
				//$modelParentDetail = Bankmaster::model()->find("rowid ='$parentRowid'");
				for($x=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$childRowid=$listTmanyChildDetail[$x][0]->table_rowid;
					$modelChildDetail[$x] = Tconsoljrn::model()->find("rowid ='$childRowid'");
				}
			}else{
			//	$modelParentDetail  = new Tconsoljrn;
				//Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
								
				for($x=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$modelChildDetail[$x] = new Tconsoljrn;
					Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
				}
			}
			
			$this->render('view',array(
				'model'=>$model,
				//'modelParentDetail'=> $modelParentDetail,
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
		$model->approve();
		$doc_num=Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date='$model->update_date' and field_name='XN_DOC_NUM'")->field_value;
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve journal'.$doc_num.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve journal '.$doc_num);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason);
		$doc_num=Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date='$model->update_date' and field_name='XN_DOC_NUM'")->field_value;
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve journal '.$doc_num.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject journal '.$doc_num);
	}
	
	private function rejectChecked($model,$arrid)
	{
		$reject_reason = $model->reject_reason;
		$doc_num=array();
		$x=0;
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->reject($reject_reason);
			$doc_num[]=Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date='$model->update_date' and field_name='XN_DOC_NUM'")->field_value;
			if($model->error_code < 0){
				Yii::app()->user->setFlash('error', 'Error reject journal '.$doc_num[$x].' '.$model->error_msg);
				return false;
			}
			$x++;
		endforeach;
		
		Yii::app()->user->setFlash('success', 'Successfully reject '.json_encode($doc_num));
		return true;
	}
	

	public function actionApproveChecked()
	{
		$result  = 'error';
		$doc_num=array();
		if(isset($_POST['arrid'])):
			
			$arrid	 = $_POST['arrid'];
			$result  = 'success';
			$x=0;
			foreach($arrid as $id)
			{
				$model = $this->loadModel($id);
				$model->approve();
				$doc_num[]=Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date='$model->update_date' and field_name='XN_DOC_NUM'")->field_value;
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
				$x++;
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve journal '.$doc_num[$x].' '.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve journal '.json_encode($doc_num));
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
