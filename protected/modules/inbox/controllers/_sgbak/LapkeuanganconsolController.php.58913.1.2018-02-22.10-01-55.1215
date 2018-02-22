<?php

class LapkeuanganconsolController extends AAdminController
{
	public $menu_name = 'LAPORAN KEUANGAN KONSOLIDASI';
	public $parent_table_name = 'LAP_LK_KONSOL';
	public $layout = '//layouts/admin_column3';
	
	/*public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		$modelChildDetail = array();
		$modelChildDetailUpd = array();
		$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name)));
		$listTmanyChildDetail = array();
		
		$x;
		
		for($x=0;$x<$childRecordCount->record_cnt;$x++)
		{
			$listTmanyChildDetail[$x] = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq',array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name,':record_seq'=>($x+1)));
		}
		
		if($model->status == AConstant::INBOX_STAT_UPD){
			
			
			$modelChildDetailCurr = array();
			
			$xn_doc_num = Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date='$model->update_date' and field_name='XN_DOC_NUM'")->field_value;
			$doc_date = Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date='$model->update_date' and field_name='DOC_DATE'")->field_value;
			$modelChildDetailCurr =Laptrxharianinbox::model()->findAll("xn_doc_num='$xn_doc_num' and doc_date='$doc_date' ");
			
			for($x=0;$x<$childRecordCount->record_cnt;$x++)
			{
				if($listTmanyChildDetail[$x][0]->table_rowid)
				{
					//Status = UPDATE OR CANCEL
					$childRowid=$listTmanyChildDetail[$x][0]->table_rowid;
				
					$modelChildDetail[$x] = Laptrxharianinbox::model()->find("rowid ='$childRowid'");
					if($listTmanyChildDetail[$x][0]->upd_status == 'U')
					{	
						//Status = UPDATE
						Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
					}
				}
				else {
					//Status = INSERT
					$modelChildDetail[$x] = new Laptrxharianinbox;
					Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
				}
			}
			
			if($model->approved_status != AConstant::INBOX_APP_STAT_ENTRY):
				$this->render('view',array(
					'model'=>$model,
					
					'modelChildDetail' => $modelChildDetail,
					'listTmanyChildDetail'=>$listTmanyChildDetail,
				));	
			else:
				
				$this->render('view_compare',array(
					'model'=>$model,
				
					'modelChildDetailCurr'=>$modelChildDetailCurr,
				
					'modelChildDetail' =>$modelChildDetail,
					'listTmanyChildDetail'=>$listTmanyChildDetail,
				));
			endif;

		}else{
			if($model->status == AConstant::INBOX_STAT_CAN){
			
				for($x=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$childRowid=$listTmanyChildDetail[$x][0]->table_rowid;
					$modelChildDetail[$x] = Laptrxharianinbox::model()->find("rowid ='$childRowid'");
				}
			}else{
		
								
				for($x=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$modelChildDetail[$x] = new Laptrxharianinbox;
					Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
				}
			}
			
			$this->render('view',array(
				'model'=>$model,
				
				'modelChildDetail' => $modelChildDetail,
				'listTmanyChildDetail'=>$listTmanyChildDetail,
			));	
		}
	}
*/
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
		$trx_dt = Tmanydetail::model()->find("update_date = '$model->update_date' and update_seq= '$model->update_seq' and field_name='REPORT_DATE' AND TABLE_NAME='LAP_LK_KONSOL' ")->field_value;
		
		$sql = "UPDATE  INSISTPRO_RPT.LAP_LK_KONSOL SET APPROVED_STAT='C' WHERE report_date=to_date('$trx_dt','YYYY/MM/DD HH24:MI:SS') ";
		$exec = DAO::executeSql($sql);
		
		$model->approveLaporan($this->parent_table_name);
		
		$trx_dt = Tmanydetail::model()->find("update_date = '$model->update_date' and update_seq= '$model->update_seq' and field_name='REPORT_DATE' AND TABLE_NAME='LAP_LK_KONSOL' ")->field_value;
		
		if(DateTime::createFromFormat('Y/m/d H:i:s',$trx_dt))$trx_dt = DateTime::createFromFormat('Y/m/d H:i:s',$trx_dt)->format('d M Y');
		
		

		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve transaction at'.$trx_dt.', Error  '.$model->error_code.':'.$model->error_msg);
		else{
			Yii::app()->user->setFlash('success', 'Successfully approve transaction at '.$trx_dt);
		
		}
			
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->rejectLaporan($model->reject_reason,$this->parent_table_name);
		
		$trx_dt = Tmanydetail::model()->find("update_date = '$model->update_date' and update_seq= '$model->update_seq' and field_name='REPORT_DATE' AND TABLE_NAME='LAP_LK_KONSOL' ")->field_value;
		if(DateTime::createFromFormat('Y/m/d H:i:s',$trx_dt))$trx_dt = DateTime::createFromFormat('Y/m/d H:i:s',$trx_dt)->format('d M Y');
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Reject transaction at'.$trx_dt.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject transaction at '.$trx_dt);
	}
	
	private function rejectChecked($model,$arrid)
	{ 
		$reject_reason = $model->reject_reason;
		$hasil=array();
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->rejectLaporan($reject_reason,$this->parent_table_name);
			
			if($model->error_code < 0){
				Yii::app()->user->setFlash('error', 'Error reject '.$model->update_seq.' '.$model->error_msg);
				return false;
			}
			else{
				$trx_dt = Tmanydetail::model()->find("update_date = '$model->update_date' and update_seq= '$model->update_seq' and field_name='REPORT_DATE' AND TABLE_NAME='LAP_LK_KONSOL' ")->field_value;
			if(DateTime::createFromFormat('Y/m/d H:i:s',$trx_dt))$trx_dt = DateTime::createFromFormat('Y/m/d H:i:s',$trx_dt)->format('d M Y');
				$hasil[] = $trx_dt;
			}
			
			
		endforeach;
		
		Yii::app()->user->setFlash('success', 'Successfully reject trasaction at  '.json_encode($hasil));
		return true;
	}
	

	public function actionApproveChecked()
	{
		$result  = 'error';
		
		if(isset($_POST['arrid'])):
			
			$arrid	 = $_POST['arrid'];
			$result  = 'success';
			$hasil=array();
			
			//$x=1;
			foreach($arrid as $id)
			{ 
				$model = $this->loadModel($id);
				
				$trx_dt = Tmanydetail::model()->find("update_date = '$model->update_date' and update_seq= '$model->update_seq' and field_name='REPORT_DATE' AND TABLE_NAME='LAP_LK_KONSOL' ")->field_value;		
				
				$sql = "UPDATE  INSISTPRO_RPT.LAP_LK_KONSOL SET APPROVED_STAT='C' WHERE report_date=to_date('$trx_dt','YYYY/MM/DD HH24:MI:SS') ";
				$exec = DAO::executeSql($sql);
				
				$model->approveLaporan($this->parent_table_name);
			
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
				else{
		
			
			if(DateTime::createFromFormat('Y/m/d H:i:s',$trx_dt))$trx_dt = DateTime::createFromFormat('Y/m/d H:i:s',$trx_dt)->format('d M Y');
			$hasil[] = $trx_dt;
			
				}
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '.$model->update_seq.' '.$model->error_msg);
			else
				
				Yii::app()->user->setFlash('success', 'Successfully approve transaction at '.json_encode($hasil));
		endif;
		
		echo $result;
	}

	public function actionIndex()
	{
		$model = new Vinboxlaplkkonsol('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		
		if(isset($_GET['Vinboxlaplkkonsol']))
			$model->attributes=$_GET['Vinboxlaplkkonsol'];

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
