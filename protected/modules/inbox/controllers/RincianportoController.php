<?php

class RincianportoController extends AAdminController
{
	public $menu_name = 'LAPORAN RINCIAN PORTOFORLIO';
	public $parent_table_name = 'LAP_RINCIAN_PORTO';
	public $layout = '//layouts/admin_column3';
	
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$modeldetail = Vlaprincianporto::model()->findAll(array('select'=>'*','condition'=>"update_seq = '$id' and rep_type=1 ",'order'=>'stk_cd'));
		$modeldetail2 = Vlaprincianporto::model()->findAll(array('select'=>'*','condition'=>"update_seq = '$id' and rep_type=2 ",'order'=>'stk_cd'));
		$nama_ab = Company::model()->find()->nama_prsh;
		$kode_ab = Parameter::model()->find(" PRM_CD_1 = 'AB' AND PRM_CD_2='000' AND APPROVED_STAT='A'")->prm_desc;
		$kode_ab = substr($kode_ab, 0,2);
		$tanggal = Tmanydetail::model()->find("update_seq='$id' and table_name='LAP_RINCIAN_PORTO'")->field_value;
		if(DateTime::createFromFormat('Y/m/d H:i:s',$tanggal))$tanggal = DateTime::createFromFormat('Y/m/d H:i:s',$tanggal)->format('d M Y');
		$jumlah_acct = Vlaprincianporto::model()->find("update_seq = '$id' ")->jumlah_acct;
		$this->render('view',array('model'=>$model,
									'modeldetail'=>$modeldetail,
									'modeldetail2'=>$modeldetail2,
									'nama_ab'=>$nama_ab,
									'kode_ab'=>$kode_ab,
									'tanggal'=>$tanggal,
									'jumlah_acct'=>$jumlah_acct
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
		$model->approveRincianporto();
		$report_date =Tmanydetail::model()->find("table_name='LAP_RINCIAN_PORTO' AND UPDATE_SEQ='$model->update_seq' AND UPDATE_DATE='$model->update_date' AND FIELD_NAME='REPORT_DATE'")->field_value;
		if(DateTime::createFromFormat('Y/m/d H:i:s',$report_date))$report_date= DateTime::createFromFormat('Y/m/d H:i:s',$report_date)->format('d M Y');
		

		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve transaction at'.$report_date.', Error  '.$model->error_code.':'.$model->error_msg);
		else{
			Yii::app()->user->setFlash('success', 'Successfully approve transaction at '.$report_date);
		
		}
			
		$this->redirect(array('/custody/rincianporto/index'));
	}
	
	private function reject(&$model)
	{		
		$model-> rejectRincianPorto($model->reject_reason);
		
		$report_date =Tmanydetail::model()->find("table_name='LAP_RINCIAN_PORTO' AND UPDATE_SEQ='$model->update_seq' AND UPDATE_DATE='$model->update_date' AND FIELD_NAME='REPORT_DATE'")->field_value;
		if(DateTime::createFromFormat('Y/m/d H:i:s',$report_date))$report_date= DateTime::createFromFormat('Y/m/d H:i:s',$report_date)->format('d M Y');
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Reject transaction at'.$report_date.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject transaction at '.$report_date);
	}
	
	private function rejectChecked($model,$arrid)
	{ 
		$reject_reason = $model->reject_reason;
		$hasil=array();
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->rejectRincianPorto($reject_reason);
			
			if($model->error_code < 0){
				Yii::app()->user->setFlash('error', 'Error reject '.$model->update_seq.' '.$model->error_msg);
				return false;
			}
			else
			{
			$report_date =Tmanydetail::model()->find("table_name='LAP_RINCIAN_PORTO' AND UPDATE_SEQ='$id' and FIELD_NAME='REPORT_DATE'")->field_value;
			if(DateTime::createFromFormat('Y/m/d H:i:s',$report_date))$report_date= DateTime::createFromFormat('Y/m/d H:i:s',$report_date)->format('d M Y');
			$hasil[] =$report_date;
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
				$model->approveRincianporto();
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
				else{
		$report_date =Tmanydetail::model()->find("table_name='LAP_RINCIAN_PORTO' AND UPDATE_SEQ='$id' AND FIELD_NAME='REPORT_DATE'")->field_value;	
		if(DateTime::createFromFormat('Y/m/d H:i:s',$report_date))$report_date= DateTime::createFromFormat('Y/m/d H:i:s',$report_date)->format('d M Y');
			$hasil[] = $report_date;
			
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
		$model = new Vinboxrincianporto('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		
		if(isset($_GET['Vinboxrincianporto']))
			$model->attributes=$_GET['Vinboxrincianporto'];

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
