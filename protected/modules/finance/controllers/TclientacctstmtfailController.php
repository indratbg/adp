<?php

class TclientacctstmtfailController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex() 
	{
		$model = array();
		$model_dummy = new Tclientacctstmtfail;
		$model_dummy->from_dt = date('d/m/Y');
		$model_dummy->to_dt = date('d/m/Y');
		$model = array();//Tclientacctstmtfail::model()->findAllBySql(Tclientacctstmtfail::getData($model_dummy->from_dt, $model_dummy->to_dt, $model_dummy->branch_code));
		$valid = true;
		$success = true;
		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			$model_dummy->attributes = $_POST['Tclientacctstmtfail'];
			
			if($scenario =='filter')
			{
				$from_dt = $model_dummy->from_dt;
				$to_dt = $model_dummy->to_dt;
				$branch_cd = $model_dummy->branch_code;
				
				$model = Tclientacctstmtfail::model()->findAllBySql(Tclientacctstmtfail::getData($model_dummy->from_dt, $model_dummy->to_dt, $model_dummy->branch_code));
				if(count($model)==0)
				{
					Yii::app()->user->setFlash('danger', 'No data found');
				}
			}
			//journal
			else 
			{
				$rowCount = $_POST['rowCount'];
				
				$model_dummy->user_id= Yii::app()->user->id;
				$ip = Yii::app()->request->userHostAddress;
				if($ip=="::1")
					$ip = '127.0.0.1';
				$model_dummy->ip_address = $ip; 
				$check_flg=false;
				for($x=0;$x<$rowCount;$x++)
				{
					$model[$x] = new Tclientacctstmtfail;
					$model[$x]->attributes = $_POST['Tclientacctstmtfail'][$x+1];		
					$model[$x]->scenario = 'journal';
					$model[$x]->from_dt = $model_dummy->from_dt;
					$model[$x]->to_dt = $model_dummy->to_dt;
					$model[$x]->user_id = $model_dummy->user_id;
					$model[$x]->ip_address = $model_dummy->ip_address;
					if($model[$x]->save_flg=='Y')
					{
						$valid = $valid && $model[$x]->validate();
						$check_flg=true;
					}
					
				}
				if($valid && $check_flg)
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction(); 
					$menuName = 'FUND AUTO JOURNAL BCA';
					
					for($x=0;$x<$rowCount;$x++)
					{
						if($model[$x]->save_flg=='Y')
						{
							if($success && $model[$x]->executeSp()>0)
							{
								$success=true;
							}
							else
							{
								$success=false;	
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
				
			}
		}
		
		foreach($model as $row)
		{
			if(DateTime::createFromFormat('Y-m-d H:i:s',$row->tanggaltimestamp))$row->tanggaltimestamp=DateTime::createFromFormat('Y-m-d H:i:s',$row->tanggaltimestamp)->format('d/m/Y H:i:s');	
			if(DateTime::createFromFormat('Y-m-d',$row->tanggalefektif))$row->tanggalefektif=DateTime::createFromFormat('Y-m-d',$row->tanggalefektif)->format('d/m/Y');
		}
		
		
		$this->render('index',array('model'=>$model,
									'model_dummy'=>$model_dummy	));
	}
	
}
