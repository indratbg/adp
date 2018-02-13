<?php

class TtccepatfixedController extends AAdminController
{	
	public function actionIndex()
	{
		$model = new Ttccepat;
		$model->contr_dt = date('d/m/Y');
		$model->doc_type = 0;
		$model1 = array();
		$modelFotd = array();
		
		$market_type = '';
		$valid = false;
		$success = false;
		
		if(isset($_POST['Ttccepat']))
		{
			$model->attributes = $_POST['Ttccepat'];
			$model->scenario = 'fixed';

			if($model->validate())
			{
				$rowCount = $_POST['rowCount'];
				$valid = true;
			
				$modelFotd = Fotdtrade::model()->findAll(array(
					'select'=>"DISTINCT clearingAccount AS client_cd, symbol as stk_cd, DECODE(side,1,'BELI','JUAL') trx_type, SUM(cumqty * lotsize) AS qty, 
					 SUBSTR(symbolsfx,2,2) AS mrkt_type, DECODE(SUBSTR(symbolsfx,2,2),'TN',trade_date,Get_Due_Date(3,trade_date)) due_date, price",
					'condition'=>"clearingAccount = '$model->client_cd' AND symbolsfx = '0RG'",
					'group'=>'trade_date,clearingAccount,symbol,side,symbolsfx,price',
					'order'=>'1,2,3'));
				
				for($x = 0;$x < $rowCount; $x++)
				{
					if(isset($_POST['checkBox'.($x+1)]))
					{
						$modelFotd[$x] = new Fotdtrade;
						$modelFotd[$x]->client_cd = $_POST['Fotdtrade'][$x+1]['client_cd'];
						$modelFotd[$x]->stk_cd = $_POST['Fotdtrade'][$x+1]['stk_cd'];
						$modelFotd[$x]->trx_type = $_POST['Fotdtrade'][$x+1]['trx_type']=='BELI'?1:2;
						$modelFotd[$x]->qty = $_POST['Fotdtrade'][$x+1]['qty'];
						$modelFotd[$x]->mrkt_type = $_POST['Fotdtrade'][$x+1]['mrkt_type'];
						$modelFotd[$x]->due_date = $_POST['Fotdtrade'][$x+1]['due_date'];
						$modelFotd[$x]->price = $_POST['Fotdtrade'][$x+1]['price'];
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
							$model1[$x]->trx_type = $modelFotd[$x]->trx_type;
							$model1[$x]->qty = $modelFotd[$x]->qty;
							$model1[$x]->mrkt_type = $modelFotd[$x]->mrkt_type;
							$model1[$x]->due_dt = $modelFotd[$x]->due_date;
							$model1[$x]->price = $modelFotd[$x]->price;
							
							//$model1[$x]->validate();
							
							if($success && $model1[$x]->executeSp() > 0)$success = true;
							else {
								$success = false;
							}
						}
					}
					
					if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Successfully create Trade Confirmation Fixed Price');
						
						$modelFotd = Fotdtrade::model()->findAll(array(
							'select'=>"DISTINCT clearingAccount AS client_cd, symbol as stk_cd, DECODE(side,1,'BELI','JUAL') trx_type, SUM(cumqty * lotsize) AS qty, 
							 SUBSTR(symbolsfx,2,2) AS mrkt_type, DECODE(SUBSTR(symbolsfx,2,2),'TN',trade_date,Get_Due_Date(3,trade_date)) due_date, price",
							'condition'=>"clearingAccount = '$model->client_cd' AND symbolsfx = '0RG'",
							'group'=>'trade_date,clearingAccount,symbol,side,symbolsfx,price',
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
						$row->trx_type = $row->trx_type==1?'BELI':'JUAL';
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
		
		$this->render('index',array(
			'model'=>$model,
			'model1'=>$model1,
			'modelFotd'=>$modelFotd,
		));
	}

	public function actionAjxGetTradeListFixed()
	{
		$resp['status']  = 'error';
		
		$client_cd = array();
		$stk_cd = array();
		$trx_type = array();
		$qty = array();
		$mrkt_type = array();
		$due_date = array();
		$price = array();
		
		if(isset($_POST['client_cd']))
		{
			$clientCd = $_POST['client_cd'];
			
			$modelFotd = Fotdtrade::model()->findAll(array(
				'select'=>"DISTINCT clearingAccount AS client_cd, symbol as stk_cd, DECODE(side,1,'BELI','JUAL') trx_type, SUM(cumqty * lotsize) AS qty, 
							 SUBSTR(symbolsfx,2,2) AS mrkt_type, DECODE(SUBSTR(symbolsfx,2,2),'TN',trade_date,Get_Due_Date(3,trade_date)) due_date, price",
				'condition'=>"clearingAccount = '$clientCd' AND symbolsfx = '0RG'",
				'group'=>'trade_date,clearingAccount,symbol,side,symbolsfx,price',
				'order'=>'1,2,3'));
			
			foreach($modelFotd as $row)
			{
				$client_cd[] = $row->client_cd;
				$stk_cd[] = $row->stk_cd;
				$trx_type[] = $row->trx_type;
				$qty[] = $row->qty;
				$mrkt_type[] = $row->mrkt_type;
				$due_date[] = $row->due_date?DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('d/m/Y'):'';
				$price[] = $row->price;
			}
			$resp['status'] = 'success';
		}
		
		$resp['content'] = array('client_cd'=>$client_cd,'stk_cd'=>$stk_cd,'trx_type'=>$trx_type,'qty'=>$qty,'mrkt_type'=>$mrkt_type,'due_date'=>$due_date,'price'=>$price);
		echo json_encode($resp);
	}
}
