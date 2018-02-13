<?php

class NettingarapController extends AAdminController
{
	public $menu_name = array("'NETTING VOUCHER'");
	public $parent_table_name = 'T_PAYRECH';
	public $child_table_name = 'T_PAYRECD';
	
	public $sp_approve = 'SP_NETTING_ARAP_APPROVE';
	public $sp_reject = 'SP_T_PAYRECH_REJECT';
	
	public $layout = '//layouts/admin_column3';
	
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		$modelParentDetail	  = null;
		$modelParentDetailUpd   = null;
		$modelChildDetail = array();
		$modelChildDetailUpd = array();
		
		$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name',array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name));

		$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->child_table_name)));
		$listTmanyChildDetail = array();
		
		$x;
		
		for($x=0;$x<$childRecordCount->record_cnt;$x++)
		{
			$listTmanyChildDetail[$x] = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq',array(':update_seq'=>$model->update_seq,':table_name'=>$this->child_table_name,':record_seq'=>($x+1)));
		}

		$modelParentDetail  = new Tpayrech;
		Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
						
		for($x=0;$x<$childRecordCount->record_cnt;$x++)
		{
			$modelChildDetail[$x] = new Tpayrecd;
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
			
			
		$this->render('view',array(
			'model'=>$model,
			'modelParentDetail'=> $modelParentDetail,
			'modelChildDetail' => $modelChildDetail,
			'listTmanyChildDetail'=>$listTmanyChildDetail,
		));	
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
		
		$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND TABLE_NAME = 'T_PAYRECH' AND field_name IN ('PAYREC_NUM','CLIENT_CD','FOLDER_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
		
		$client_cd = $detail[0]->field_value?'&nbsp;&nbsp;'.$detail[0]->field_value:'';
		$folder_cd = $detail[1]->field_value?'&nbsp;&nbsp;'.$detail[1]->field_value:'';
		$payrec_num = $detail[2]->field_value;
				
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$payrec_num.$folder_cd.$client_cd.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '.$payrec_num.$folder_cd.$client_cd);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason,$this->sp_reject);
		
		$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND TABLE_NAME = 'T_PAYRECH' AND field_name IN ('PAYREC_NUM','CLIENT_CD','FOLDER_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
		
		$client_cd = $detail[0]->field_value?'&nbsp;&nbsp;'.$detail[0]->field_value:'';
		$folder_cd = $detail[1]->field_value?'&nbsp;&nbsp;'.$detail[1]->field_value:'';
		$payrec_num = $detail[2]->field_value;
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Reject '.$payrec_num.$folder_cd.$client_cd.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject '.$payrec_num.$folder_cd.$client_cd);
	}
	
	private function rejectChecked($model,$arrid)
	{
		$reject_reason = $model->reject_reason;
		
		$client_cd = array();
		$folder_cd = array();
		$payrec_num = array();
		$key = array();
		
		$x = 0;
		
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->reject($reject_reason,$this->sp_reject);
			
			$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND TABLE_NAME = 'T_PAYRECH' AND field_name IN ('PAYREC_NUM','CLIENT_CD','FOLDER_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
		
			$client_cd[] = $detail[0]->field_value?'&nbsp;&nbsp;'.$detail[0]->field_value:'';
			$folder_cd[] = $detail[1]->field_value?'&nbsp;&nbsp;'.$detail[1]->field_value:'';
			$payrec_num[] = $detail[2]->field_value;
			
			$key[] = $payrec_num[$x].$folder_cd[$x].$client_cd[$x];
			
			if($model->error_code < 0){
				Yii::app()->user->setFlash('error', 'Error reject '.$payrec_num[$x].$folder_cd[$x].$client_cd[$x].' '.$model->error_msg);
				return false;
			}
			
			$x++;
		endforeach;
		
		Yii::app()->user->setFlash('success', 'Successfully reject '.json_encode($key));
		return true;
	}
	

	public function actionApproveChecked()
	{
		$result  = 'error';
		
		if(isset($_POST['arrid'])):
			
			$arrid	 = $_POST['arrid'];
			$result  = 'success';
			
			$client_cd = $folder_cd = '';
			//$client_cd = array();
			//$folder_cd = array();
			//$payrec_num = array();
			$key = array();
			
			$x = 0;
			
			foreach($arrid as $id)
			{
				$model = $this->loadModel($id);
				$model->approve($this->sp_approve);
				
				//$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND TABLE_NAME = 'T_PAYRECH' AND field_name IN ('PAYREC_NUM','CLIENT_CD','FOLDER_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
				$sql = "SELECT field_value 
						FROM T_MANY_DETAIL
						WHERE update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS')
						AND update_seq = '$model->update_seq' 
						AND TABLE_NAME = 'T_PAYRECH' 
						AND field_name IN ('CLIENT_CD','FOLDER_CD') 
						AND record_seq = 1
						ORDER BY field_name";
				$detail = DAO::queryAllSql($sql);
		
				$client_cd = $detail[0]['field_value']?'&nbsp;&nbsp;'.$detail[0]['field_value']:'';
				$folder_cd = $detail[1]['field_value']?'&nbsp;&nbsp;'.$detail[1]['field_value']:'';
				//$payrec_num[] = $detail[2]->field_value;
				
				$key[] = /*$payrec_num[$x].*/$folder_cd.$client_cd;
				
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}

				$x++;
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '/*.$payrec_num[$x]*/.$folder_cd.$client_cd.' '.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($key));
		endif;
		
		echo $result;
	}

	public function actionIndex()
	{
		$model = new VinboxpayrecAll('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['VinboxpayrecAll']))
			$model->attributes=$_GET['VinboxpayrecAll'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionIndexProcessed()
	{
		$model = new VinboxpayrecAll('search');
		$model->unsetAttributes();
		$model->processed_flg = true;
		$model->menu_name = $this->menu_name;
		$model->approved_status = '<>'.AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['VinboxpayrecAll']))
			$model->attributes=$_GET['VinboxpayrecAll'];

		$this->render('index_processed',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model = Tmanyheader::model()->find("update_seq=:update_seq AND menu_name IN (".implode(',',$this->menu_name).")",array(':update_seq'=>$id));
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
