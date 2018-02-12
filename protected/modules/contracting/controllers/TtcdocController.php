<?php

class TtcdocController extends AAdminController
{
	public function actionIndex()
	{
		$model = new Ttcdoc;
		$model->tc_date = date('d/m/Y');
		$model->client_type = 0;
		$model->tc_rev = 1;
		
		$valid = false;
		
		if(isset($_POST['Ttcdoc']))
		{
			$model->attributes=$_POST['Ttcdoc'];
			$valid = $model->validate();
			
			if($valid)
			{
				if($model->client_type == 0)
				{
					$client = Tcontracts::model()->findAll(array('select'=>'DISTINCT client_cd','condition'=>"contr_dt = TO_DATE('$model->tc_date','YYYY-MM-DD') AND contr_stat <> 'C'",'order'=>'client_cd'));
					if($client)
					{
						//$clientFrom = $client[0]->client_cd;
						//$clientTo = $client[count($client)-1]->client_cd;
						$valid  = true;
					}
					else
					{
						$valid = false;
						$model->addError('client_cd','Client tidak ditemukan');
					}	
				}
				else
				{
					if($model->client_cd)
					{
						//$clientFrom = $clientTo = $model->client_cd;
						$valid  = true;
					}
					else
					{
						$valid = false;
						$model->addError('client_cd','Client tidak ditemukan');
					}
				}
				if($valid)
				{
					if($model->client_type == 0)$mode = 1;
					else
						$mode = 3;
					
					$id= '%';
					
					if($model->executeSp($mode,$id) > 0)
					{
						Yii::app()->user->setFlash('success', 'Successfully create Trade Confirmation');
					}
				}
			}

			if(DateTime::createFromFormat('Y-m-d',$model->tc_date))$model->tc_date=DateTime::createFromFormat('Y-m-d',$model->tc_date)->format('d/m/Y');
		}
				
		$this->render('index',array(
			'model'=>$model,
		));
		
	}
	
	public function actionAjxGetClientList()
	{
		$resp['status']  = 'error';
		
		$client_cd = array();
		
		if(isset($_POST['tc_date']))
		{
			$tc_date = $_POST['tc_date'];
			$model = Tcontracts::model()->findAll(array('select'=>'DISTINCT client_cd','condition'=>"contr_dt = TO_DATE('$tc_date','DD/MM/YYYY') AND contr_stat <> 'C'",'order'=>'client_cd'));
			
			foreach($model as $row)
			{
				$client_cd[] = $row->client_cd;
			}
			$resp['status'] = 'success';
		}
		
		$resp['content'] = array('client_cd'=>$client_cd);
		echo json_encode($resp);
	}
}