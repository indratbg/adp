<?php

class TreksnabController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	public function actionIndex()
	{
		$model= array();
		$oldModel = array();
		$dateRange = 30;
		$filter = true;
		$valid = true;
		
		$cancel_reason = '';
	$success = false;
		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			if($scenario == 'filter')
			{
				$dateRange = $_POST['dateRange'];
				
				if(!is_numeric($dateRange))
				{
					Yii::app()->user->setFlash('error', 'Date Range must be numeric');
					
					
				}
				else{
				$model = Treksnab::model()->findAll(array('condition'=>"nab_date >= TRUNC(SYSDATE - '$dateRange') AND approved_stat = 'A'",'order'=>'nab_date DESC, reks_cd'));
			
				foreach($model as $row)
				{
					if($row->nab_date)$row->nab_date=DateTime::createFromFormat('Y-m-d G:i:s',$row->nab_date)->format('d/m/Y');
					if($row->mkbd_dt)$row->mkbd_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->mkbd_dt)->format('d/m/Y');
					$row->old_reks_cd = $row->reks_cd;
					$row->old_mkbd_dt = $row->mkbd_dt;			
				}
			}
			}
			else 
			{
				
				$dateRange = $_POST['oldDateRange'];
				$model = Treksnab::model()->findAll(array('condition'=>"nab_date >= TRUNC(SYSDATE - '$dateRange') AND approved_stat = 'A'",'order'=>'nab_date DESC, reks_cd'));
			
				foreach($model as $row)
				{
					if($row->nab_date)$row->nab_date=DateTime::createFromFormat('Y-m-d G:i:s',$row->nab_date)->format('d/m/Y');
					if($row->mkbd_dt)$row->mkbd_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->mkbd_dt)->format('d/m/Y');
					$row->old_reks_cd = $row->reks_cd;
					$row->old_mkbd_dt = $row->mkbd_dt;
		
				}
				
				$rowCount = $_POST['rowCount'];
				
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
					$model[$x] = new Treksnab;
					$model[$x]->attributes = $_POST['Treksnab'][$x+1];
					
					if(isset($_POST['Treksnab'][$x+1]['save_flg']) && $_POST['Treksnab'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						if(isset($_POST['Treksnab'][$x+1]['cancel_flg']))
						{
							if($_POST['Treksnab'][$x+1]['cancel_flg'] == 'Y')
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
						{
							if($model[$x]->cancel_flg == 'Y')
							{
								//CANCEL
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_CAN,$model[$x]->old_reks_cd,$model[$x]->old_mkbd_dt) > 0)$success = true;
								else {
									$success = false;
								}
							}
							else if($model[$x]->old_reks_cd)
							{
								//UPDATE
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model[$x]->old_reks_cd,$model[$x]->old_mkbd_dt) > 0)$success = true;
								else {
									$success = false;
								}
							}			
							else 
							{
								//INSERT
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->reks_cd,$model[$x]->mkbd_dt) > 0)$success = true;
								else {
									$success = false;
								}
							}
						}
					}

					if($success)
					{
						$transaction->commit();
						$model = Treksnab::model()->findAll(array('condition'=>"nab_date >= TRUNC(SYSDATE - '$dateRange') AND approved_stat = 'A'",'order'=>'nab_date DESC, reks_cd'));
							
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('index'));
					}
					else {
						$transaction->rollback();
					}
				}

				foreach($model as $row)
					{
						if(DateTime::createFromFormat('Y-m-d',$row->nab_date))$row->nab_date=DateTime::createFromFormat('Y-m-d',$row->nab_date)->format('d/m/Y');
						if(DateTime::createFromFormat('Y-m-d',$row->mkbd_dt))$row->mkbd_dt=DateTime::createFromFormat('Y-m-d',$row->mkbd_dt)->format('d/m/Y');
						
					}	
			}
		}
		else{
			
			
			$model = Treksnab::model()->findAll(array('condition'=>"nab_date >= TRUNC(SYSDATE - '$dateRange') AND approved_stat = 'A'",'order'=>'nab_date DESC, reks_cd'));
					
					foreach($model as $row)
					{
						if($row->nab_date)$row->nab_date=DateTime::createFromFormat('Y-m-d G:i:s',$row->nab_date)->format('d/m/Y');
						if($row->mkbd_dt)$row->mkbd_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->mkbd_dt)->format('d/m/Y');
						$row->old_reks_cd = $row->reks_cd;
							$row->old_mkbd_dt = $row->mkbd_dt;
				
					}
			if(!$model)
			{
				$model[0] = new Treksnab; 
			}
		}
		
		
	

		$this->render('index',array(
			'model'=>$model,
		
			'dateRange'=>$dateRange,
			'cancel_reason'=>$cancel_reason,
		));
	}

	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}

	public function actionAjxPopDelete($reks_cd,$mkbd_dt)
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
				
				$model1    				= $this->loadModel($reks_cd,$mkbd_dt);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if($mkbd_dt)$mkbd_dt = DateTime::createFromFormat('Y-m-d G:i:s',$mkbd_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->mkbd_dt))$model1->mkbd_dt = DateTime::createFromFormat('Y-m-d G:i:s',$model1->mkbd_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->nab_date))$model1->nab_date = DateTime::createFromFormat('Y-m-d G:i:s',$model1->nab_date)->format('Y-m-d');
				
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$reks_cd,$mkbd_dt) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel NAB Harian');
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

	public function loadModel($reks_cd,$mkbd_dt)
	{
		$model=Treksnab::model()->find("reks_cd = '$reks_cd' AND mkbd_dt = TO_DATE('$mkbd_dt','YYYY-MM-DD HH24:MI:SS')");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
