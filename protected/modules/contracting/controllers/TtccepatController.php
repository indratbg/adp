<?php

class TtccepatController extends AAdminController
{	
	public function actionIndex()
	{
		$model = new Ttccepat;
		$model->contr_dt = date('d/m/Y');
		$model1 = array();
		$modelFotd = array();
		$modelTcDoc = array();
		
		$market_type = '';
		$valid = false;
		$success = false;
		
		
		if(isset($_POST['Ttccepat']))
		{
			$model->attributes = $_POST['Ttccepat'];
			$x = 0;
			if(isset($_POST['Ttccepat']['market_type']))
			{
				if(isset($_POST['Ttccepat']['market_type'][0]))
				{
					$model->market_type[$x] = $_POST['Ttccepat']['market_type'][0];
					$x++;
				}
				if(isset($_POST['Ttccepat']['market_type'][1]))
				{
					$model->market_type[$x] = $_POST['Ttccepat']['market_type'][1];
				}
			}
			else {
				$model->market_type = '';
			}
			$model->scenario = 'fixed';
			
			if(empty($model->market_type))
			{
				$model->addError('market_type', 'Market Type cannot be blank');
			}
			else 
			{
				for($x = 0;$x < count($model->market_type);$x++)
				{
					if($market_type == '')$market_type .= '0'.$model->market_type[$x];
					else {
						$market_type .= '*0'.$model->market_type[$x];
					}
				}
				
				if($model->validate())
				{
					$rowCount = $_POST['rowCount'];
					$valid = true;
					
					$modelFotd = Fotdtrade::model()->findAll(array(
						'select'=>"DISTINCT clearingAccount AS client_cd,symbol as stk_cd, DECODE(execbroker,contrabroker,'TS',SUBSTR(symbolsfx,2,2)) AS mrkt_type,
									 DECODE(SUBSTR(symbolsfx,2,2),'TN',trade_date,Get_Due_Date(3,trade_date)) due_date",
						'condition'=>"INSTR('$market_type',symbolsfx)>0",
						//				AND clearingAccount NOT IN(SELECT client_cd FROM T_TC_DOC WHERE tc_date = TO_DATE('$model->contr_dt','YYYY-MM-DD') AND tc_status = 0)",
						'order'=>'1,2,3'));	
					
					for($x = 0;$x < $rowCount; $x++)
					{
						if(isset($_POST['checkBox'.($x+1)]))
						{
							$modelFotd[$x] = new Fotdtrade;
							$modelFotd[$x]->client_cd = $_POST['Fotdtrade'][$x+1]['client_cd'];
							$modelFotd[$x]->stk_cd = $_POST['Fotdtrade'][$x+1]['stk_cd'];
							$modelFotd[$x]->mrkt_type = $_POST['Fotdtrade'][$x+1]['mrkt_type'];
							$modelFotd[$x]->due_date = $_POST['Fotdtrade'][$x+1]['due_date'];
							$modelFotd[$x]->check_flag = 1;
							$modelFotd[$x]->scenario = 'fixed';
							$valid = $modelFotd[$x]->validate() && $valid;
						}
						else {
							$modelFotd[$x]->check_flag = 0;
						}
					}
					
					if($valid)
					{
						$success = true;
						$connection  = Yii::app()->db;
						$transaction = $connection->beginTransaction();	
						
						for($x = 0;$success && $x < $rowCount; $x++)
						{
							if($modelFotd[$x]->check_flag == 1)
							{
								$model1[$x] = new Ttccepat;
								
								$model1[$x]->scenario = 'fixed';
								
								$model1[$x]->contr_dt = $model->contr_dt;
								$model1[$x]->client_cd = $modelFotd[$x]->client_cd;
								$model1[$x]->stk_cd = $modelFotd[$x]->stk_cd;
								$model1[$x]->mrkt_type = $modelFotd[$x]->mrkt_type;
								$model1[$x]->price = 0;
								$model1[$x]->due_dt = $modelFotd[$x]->due_date;
								
								if($success && $model1[$x]->executeSp() > 0)$success = true;
								else {
									$success = false;
								}
							}
						}
						/*
						for($x = 0;$success && $x < $rowCount; $x++)
						{
							if($modelFotd[$x]->check_flag == 1)
							{
								$modelTcDoc[$x] = new Ttcdoc;
												
								$modelTcDoc[$x]->tc_date = $model->contr_dt;
								$modelTcDoc[$x]->client_cd = $modelFotd[$x]->client_cd;
								
								if($success && $modelTcDoc[$x]->executeSp(2,'TN') > 0)$success = true;
								else {
									$success = false;
								}
							}
						}
						*/
						
						if($success)
						{
							$transaction->commit();
							Yii::app()->user->setFlash('success', 'Successfully create Trade Confirmation Cepat Nego/Tunai');
							
							$modelFotd = Fotdtrade::model()->findAll(array(
								'select'=>"DISTINCT clearingAccount AS client_cd,symbol as stk_cd, DECODE(execbroker,contrabroker,'TS',SUBSTR(symbolsfx,2,2)) AS mrkt_type,
											 DECODE(SUBSTR(symbolsfx,2,2),'TN',trade_date,Get_Due_Date(3,trade_date)) due_date",
								'condition'=>"INSTR('$market_type',symbolsfx)>0 ",
								//AND clearingAccount NOT IN(SELECT client_cd FROM T_TC_DOC WHERE tc_date = TO_DATE('$model->contr_dt','YYYY-MM-DD') AND tc_status = 0)",
								'order'=>'1,2,3'));	
						}
						else {
							$transaction->rollback();
							
						}
					}
					
					$x = 0;
					foreach($modelFotd as $row)
					{
						if(!$success && isset($_POST['checkBox'.($x+1)]))
						{
							if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d',$row->due_date)->format('d/m/Y');
						}
						else
						{
							if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('d/m/Y');
						}
						$x++;
					}
				}
				if($model->contr_dt)$model->contr_dt = Datetime::createFromFormat('Y-m-d',$model->contr_dt)->format('d/m/Y'); 
			}
		}
		
		$this->render('index',array(
			'model'=>$model,
			'model1'=>$model1,
			'modelTcDoc'=>$modelTcDoc,
			'modelFotd'=>$modelFotd,
			'market_type'=>$market_type
		));
	}
	
	public function actionAjxGetClientListFixed()
	{
		$resp['status']  = 'error';
		
		$client_cd = array();
		$stk_cd = array();
		$mrkt_type = array();
		$due_date = array();
		
		if(isset($_POST['tc_date']) && $_POST['tc_date'] != '')
		{
			$tc_date = $_POST['tc_date'];
			$type1 = $_POST['type1'];
			$type2 = $_POST['type2'];
			
			$market_type = '';
			
			if($type1 == 1)$market_type .= '0TN';
			if($type2 == 1)
			{
				if($market_type != '')$market_type .= '*0NG';
				else {
					$market_type .= '0NG';
				}
			}
			
			$modelFotd = Fotdtrade::model()->findAll(array(
				'select'=>"DISTINCT clearingAccount AS client_cd,symbol as stk_cd, DECODE(execbroker,contrabroker,'TS',SUBSTR(symbolsfx,2,2)) AS mrkt_type,
							 DECODE(SUBSTR(symbolsfx,2,2),'TN',trade_date,Get_Due_Date(3,trade_date)) due_date",
				'condition'=>"INSTR('$market_type',symbolsfx)>0",
				//AND clearingAccount NOT IN(SELECT client_cd FROM T_TC_DOC WHERE tc_date = TO_DATE('$tc_date','DD/MM/YYYY') AND tc_status = 0)",
				'order'=>'1,2,3'));
			
			foreach($modelFotd as $row)
			{
				$client_cd[] = $row->client_cd;
				$stk_cd[] = $row->stk_cd;
				$mrkt_type[] = $row->mrkt_type;
				$due_date[] = $row->due_date?DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('d/m/Y'):'';
			}
			$resp['status'] = 'success';
		}
		
		$resp['content'] = array('client_cd'=>$client_cd,'stk_cd'=>$stk_cd,'mrkt_type'=>$mrkt_type,'due_date'=>$due_date);
		echo json_encode($resp);
	}
}
