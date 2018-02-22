<?php

class TcorpactController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	public function actionGetDueDate()
	{
		$resp['status']  = 'error';
		$resp['content'] = array('x_dt'=>'','recording_dt'=>'');
		
		if(isset($_POST['cum_dt']))
		{
			$cum_dt = $_POST['cum_dt'];
			$queryResult = DAO::queryRowSql("SELECT TO_CHAR(GET_DUE_DATE(1,TO_DATE('$cum_dt','DD/MM/YYYY')),'DD/MM/YYYY') AS x_dt FROM dual");
			$x_dt = $queryResult['x_dt'];
			
			$queryResult = DAO::queryRowSql("SELECT TO_CHAR(GET_DUE_DATE(F_GET_SETTDAYS(TO_DATE('$cum_dt','DD/MM/YYYY')),TO_DATE('$cum_dt','DD/MM/YYYY')),'DD/MM/YYYY') AS recording_dt FROM dual");
			$recording_dt = $queryResult['recording_dt'];
			
			$queryResult = DAO::queryRowSql("SELECT TO_CHAR(GET_DUE_DATE(1,TO_DATE('$recording_dt','DD/MM/YYYY')),'DD/MM/YYYY') AS distrib_dt FROM dual");
			$distrib_dt = $queryResult['distrib_dt'];
			
			$resp['status'] = 'success';
			$resp['content'] = array('x_dt'=>$x_dt,'recording_dt'=>$recording_dt,'distrib_dt'=>$distrib_dt);
		}	
			
		echo json_encode($resp);
	}

	public function actionIndex()
	{
		$modeldummy = new Tcorpact;
		$model= array();
		$oldModel = array();
		$valid = true;
		$cancel_reason = '';
		$success = false;
	//	$tgl= date('Y/m/d');
	//	$stock_cd = null;
	//	$ca_type = null;
		//$distrib_dt1 = date('Y/m/d', strtotime('0 days', strtotime($tgl)));
		//$distrib_dt = date('d/m/Y',strtotime($distrib_dt1));
			
		if(isset($_POST['scenario']))
		{
		    $modeldummy->attributes = $_POST['Tcorpact'];
			if($_POST['scenario'] == 'filter')
			{
			         $modeldummy->scenario = 'retrieve';
			         $modeldummy->validate();
					
					$stk_cd = $modeldummy->stk_cd?$modeldummy->stk_cd:'%';
					$ca_type = $modeldummy->ca_type?$modeldummy->ca_type:'%'; 
				
					$model = Tcorpact::model()->findAllBySql(Tcorpact::getListStock($stk_cd, $ca_type, $modeldummy->distrib_dt)); 
									
				foreach($model as $row)
				{
					
					if($row->cum_dt)$row->cum_dt =DateTime::createFromFormat('Y-m-d G:i:s',$row->cum_dt)->format('d/m/Y');
					if($row->x_dt)$row->x_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->x_dt)->format('d/m/Y');
					if($row->recording_dt)$row->recording_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->recording_dt)->format('d/m/Y');
					if($row->distrib_dt)$row->distrib_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->distrib_dt)->format('d/m/Y');
					$row->old_stk_cd = $row->stk_cd;
					$row->old_ca_type = $row->ca_type;												
					$row->old_x_dt = $row->x_dt;	
				}
			}	
			else
			{
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
					$model[$x] = new Tcorpact;
					$model[$x]->attributes = $_POST['Tcorpact'][$x+1];
					
					if(isset($_POST['Tcorpact'][$x+1]['save_flg']) && $_POST['Tcorpact'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						if(isset($_POST['Tcorpact'][$x+1]['cancel_flg']))
						{
							if($_POST['Tcorpact'][$x+1]['cancel_flg'] == 'Y')
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
								
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_CAN,$model[$x]->old_stk_cd, $model[$x]->old_ca_type, $model[$x]->old_x_dt ) > 0 )$success = true;
								else {
									$success = false;
								}
							}
							else if($model[$x]->old_stk_cd)
							{ 
								//UPDATE
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model[$x]->old_stk_cd, $model[$x]->old_ca_type, $model[$x]->old_x_dt) > 0)$success = true;
								else {
									$success = false;
								}
							}			
							else 
							{ 
								//INSERT
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->stk_cd, $model[$x]->ca_type, $model[$x]->x_dt) > 0)$success = true;
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
						$this->redirect(array('index'));
					}
					else {
						$transaction->rollback();
					}
				}
	
				foreach($model as $row)
				{
					if(DateTime::createFromFormat('Y-m-d',$row->x_dt))$row->x_dt=DateTime::createFromFormat('Y-m-d',$row->x_dt)->format('d/m/Y');
					if(DateTime::createFromFormat('Y-m-d',$row->cum_dt))$row->cum_dt=DateTime::createFromFormat('Y-m-d',$row->cum_dt)->format('d/m/Y');
					if(DateTime::createFromFormat('Y-m-d',$row->recording_dt))$row->recording_dt=DateTime::createFromFormat('Y-m-d',$row->recording_dt)->format('d/m/Y');
					if(DateTime::createFromFormat('Y-m-d',$row->distrib_dt))$row->distrib_dt=DateTime::createFromFormat('Y-m-d',$row->distrib_dt)->format('d/m/Y');
				}	
			}
		}				
		else
		{
			$stk_cd='%';
			$ca_type = '%';	
			$distrib_dt = date('Y-m-d',strtotime(date('Y-m-d')."-40 day "));
			$model = Tcorpact::model()->findAllBySql(Tcorpact::getListStock($stk_cd, $ca_type, $distrib_dt)); 
			$modeldummy->distrib_dt = Date('d/m/Y',strtotime('-40 days'));	
			foreach($model as $row)
			{
				if($row->cum_dt)$row->cum_dt =DateTime::createFromFormat('Y-m-d G:i:s',$row->cum_dt)->format('d/m/Y');
				if($row->x_dt)$row->x_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->x_dt)->format('d/m/Y');
				if($row->recording_dt)$row->recording_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->recording_dt)->format('d/m/Y');
				if($row->distrib_dt)$row->distrib_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->distrib_dt)->format('d/m/Y');
				$row->old_stk_cd = $row->stk_cd;
				$row->old_ca_type = $row->ca_type;												
				$row->old_x_dt = $row->x_dt;		
			}
            if(!$model)
            {
                $model[0] = new Tcorpact;
            }
		}

    if(DateTime::createFromFormat('Y-m-d',$modeldummy->distrib_dt))$modeldummy->distrib_dt = DateTime::createFromFormat('Y-m-d',$modeldummy->distrib_dt)->format('d/m/Y');
		$criteriaCorp = new CDbCriteria;
		$criteriaCorp->select = 'prm_desc,prm_desc2';
		$criteriaCorp->condition = "prm_cd_1 = 'CATYPE'";
		$criteriaCorp->order = 'prm_cd_2';
		
		$this->render('index',array(
			'model'=>$model,
			'modeldummy'=>$modeldummy,
			'criteriaCorp'=>$criteriaCorp,
			'cancel_reason'=>$cancel_reason
		));
	}

	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}

	public function loadModel($stk_cd,$x_dt)
	{
		$model=Tcorpact::model()->find("stk_cd= '$stk_cd' AND x_dt = TO_DATE('$x_dt','YYYY-MM-DD HH24:MI:SS')");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
