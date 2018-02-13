<?php

class MapmkbdController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	public function actionIndex()
	{
		$model= array();
		$valid = true;
		$success = false;
		$cancel_reason = '';
		$version= '';
		$modelReport = new Rptmapmkbd('MAP_GL_ACCOUNT_CODE_TO_MKBD','R_MST_MAP_MKBD','Map_Gl_Account_Code_to_MKBD.rptdesign');
		$modelDummy = new Mapmkbd;
		$modelDummy->ver_bgn_dt = date('d/m/Y');
		$url='';
		if(isset($_POST['scenario'])){
			$scenario = $_POST['scenario'];
			$modelDummy->attributes = $_POST['Mapmkbd'];
			if(DateTime::createFromFormat('d/m/Y',$modelDummy->ver_bgn_dt))$modelDummy->ver_bgn_dt=DateTime::createFromFormat('d/m/Y',$modelDummy->ver_bgn_dt)->format('Y-m-d');
			
			//echo "<script>alert('$scenario')</script>";
			if($scenario == 'source')
				{
			$version = $_POST['source'];
			
			//echo "<script>alert('$version')</script>";
			
			$model = Mapmkbd::model()->findAll(array('condition'=>" '$modelDummy->ver_bgn_dt' between ver_bgn_dt and ver_end_dt and source like '%$version%' and approved_stat ='A' ", 'order'=>'source,mkbd_cd,ver_bgn_dt'));
				
				
				foreach($model as $row)
				{
					if($row->ver_bgn_dt)$row->ver_bgn_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->ver_bgn_dt)->format('d/m/Y');
					if($row->ver_end_dt)$row->ver_end_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->ver_end_dt)->format('d/m/Y');
					$row->old_ver_bgn_dt = $row->ver_bgn_dt;
					$row->old_gl_a = $row->gl_a;
					$row->old_mkbd_cd = $row->mkbd_cd;
					$row->old_source = $row->source;
				}
					if(count($model)==0){
					$model[0]=new Mapmkbd;
				
					}
				}
			else if($scenario=='print')//print report
			{
				$version = $_POST['source'];
				$modelReport->source = $version;
				
				$modelReport->ver_date = $modelDummy->ver_bgn_dt;
				if($modelReport->validate() && $modelReport->executeSpReport()>0){
					$url= $modelReport->showReport();
				}
			}	
			else{
				
			$rowCount = $_POST['rowCount'];
			
				$model = Mapmkbd::model()->findAll(array('condition'=>"approved_stat ='A' ", 'order'=>'source,mkbd_cd,ver_bgn_dt'));
				foreach($model as $row)
				{
					if($row->ver_bgn_dt)$row->ver_bgn_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->ver_bgn_dt)->format('d/m/Y');
					if($row->ver_end_dt)$row->ver_end_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->ver_end_dt)->format('d/m/Y');
					$row->old_ver_bgn_dt = $row->ver_bgn_dt;
					$row->old_gl_a = $row->gl_a;
					$row->old_mkbd_cd = $row->mkbd_cd;
					$row->old_source = $row->source;
		
				}
				$x;
				
				$save_flag = false; //False if no record is saved
				
				if(isset($_POST['cancel_reason']))
				{
					if(!$_POST['cancel_reason'])
					{
						$valid = false;
						Yii::app()->user->setFlash('error', 'Cancel Reason Must be Filled');
					}
					else
					{
						$cancel_reason = $_POST['cancel_reason'];
					}
				}
		
				for($x=0;$x<$rowCount;$x++)
				{
					$model[$x] = new Mapmkbd;
					$model[$x]->attributes = $_POST['Mapmkbd'][$x+1];
					
					
					
					if(isset($_POST['Mapmkbd'][$x+1]['save_flg']) && $_POST['Mapmkbd'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						if(isset($_POST['Mapmkbd'][$x+1]['cancel_flg']))
						{
							if($_POST['Mapmkbd'][$x+1]['cancel_flg'] == 'Y')
							{
								//CANCEL
								$model[$x]->scenario = 'cancel';
								$model[$x]->cancel_reason = $_POST['cancel_reason'];
							}
							else 
							{
								//UPDATE
								$model[$x]->scenario = 'update';
							}
						}
						else 
						{
							//INSERT
							$model[$x]->scenario = 'insert';
						}
						//$a = $model[$x]->scenario ;
						//echo "<script>alert('$a');</script>";
						
						$valid = $model[$x]->validate() && $valid;
						
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
						
						if($model[$x]->save_flg == 'Y')
						{	//echo "<script>alert('Data')</script>";
						
							if($model[$x]->cancel_flg == 'Y')
							{	//echo "<script>alert('Cancel')</script>";
								//CANCEL
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_CAN,$model[$x]->old_ver_bgn_dt,$model[$x]->old_gl_a,$model[$x]->old_mkbd_cd,$model[$x]->old_source) > 0)$success = true;
								else {
									$success = false;
								}
							}
							else if($model[$x]->old_ver_bgn_dt)
							{ 	//echo "<script>alert('Update')</script>";
								//UPDATE
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model[$x]->old_ver_bgn_dt,$model[$x]->old_gl_a,$model[$x]->old_mkbd_cd,$model[$x]->old_source) > 0)$success = true;
								else {
									$success = false;
								}
							}			
							else 
							{	//echo "<script>alert('Insert')</script>";
								//INSERT
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->ver_bgn_dt,$model[$x]->gl_a,$model[$x]->mkbd_cd,$model[$x]->source) > 0)$success = true;
								else {
									$success = false;
								}
							}
						}
					}

					if($success)
					{
						$transaction->commit();
							
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/glaccounting/Mapmkbd/index'));
					}
					else {
						
						$transaction->rollback();
					}
				}
			
					foreach($model as $row)
					{
						if(DateTime::createFromFormat('Y-m-d',$row->ver_bgn_dt))$row->ver_bgn_dt=DateTime::createFromFormat('Y-m-d',$row->ver_bgn_dt)->format('d/m/Y');
						if(DateTime::createFromFormat('Y-m-d',$row->ver_end_dt))$row->ver_end_dt=DateTime::createFromFormat('Y-m-d',$row->ver_end_dt)->format('d/m/Y');
					}	
		}
		}
		
		else{
				
				$model = Mapmkbd::model()->findAll(array('condition'=>"approved_stat ='A' ", 'order'=>'source,mkbd_cd,ver_bgn_dt'));
				if(count($model)==0){
					$model[0]=new Mapmkbd;
				
					}
			
				foreach($model as $row)
				{
					if($row->ver_bgn_dt)$row->ver_bgn_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->ver_bgn_dt)->format('d/m/Y');
					if($row->ver_end_dt)$row->ver_end_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->ver_end_dt)->format('d/m/Y');
					$row->old_ver_bgn_dt = $row->ver_bgn_dt;
					$row->old_gl_a = $row->gl_a;
					$row->old_mkbd_cd = $row->mkbd_cd;
					$row->old_source = $row->source;
		
				}
		
		}
		$this->render('index',array(
			'model'=>$model,
			'source'=>$version,
			'cancel_reason'=>$cancel_reason,
			'modelDummy'=>$modelDummy,
			'url'=>$url,
			'modelReport'=>$modelReport
		));
	}
/*
	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}
*/
	public function actionAjxPopDelete($ver_bgn_dt,$gl_a,$mkbd_cd,$source)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		$model1 = NULL;
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				
				$model1    				= $this->loadModel($ver_bgn_dt,$gl_a,$mkbd_cd,$source);
				$model1->cancel_reason  = $model->cancel_reason;
					if($ver_bgn_dt)$ver_bgn_dt = DateTime::createFromFormat('Y-m-d G:i:s',$ver_bgn_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->ver_bgn_dt))$model1->ver_bgn_dt = DateTime::createFromFormat('Y-m-d G:i:s',$model1->ver_bgn_dt)->format('Y-m-d');
				
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$ver_bgn_dt,$gl_a,$mkbd_cd,$source) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Map GL Account Code to MKBD Entry');
					$is_successsave = true;
				}
			}
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$model1,
			'is_successsave'=>$is_successsave		
		));
	}

	public function loadModel($ver_bgn_dt,$gl_a,$mkbd_cd,$source)
	{
		$model=Mapmkbd::model()->find("ver_bgn_dt = '$ver_bgn_dt' AND gl_a = '$gl_a' AND mkbd_cd = '$mkbd_cd' AND source = '$source'");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
