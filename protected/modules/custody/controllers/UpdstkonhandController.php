<?php

class UpdstkonhandController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	
	public function actionIndex()
	{
		$model = new Updstkhand;
		$model->trx_dt = date('d/m/Y');
		$model->grp='0';
		$modelDetail=array();
		$msg1='';
		$msg2='';
		$valid=true;
		$success = false;
		
		if(isset($_POST['Updstkhand']))
		{
			$model->attributes = $_POST['Updstkhand'];
			$scenario= $_POST['scenario'];
			$connection  = Yii::app()->db;
			$transaction = $connection->beginTransaction(); 
				
			if(DateTime::createFromFormat('d/m/Y',$model->trx_dt))$model->trx_dt = DateTime::createFromFormat('d/m/Y',$model->trx_dt)->format('Y-m-d');
			if($scenario=='filter')
			{
				if ($model->grp=='1')
				{
					$sql= "SELECT GET_DOC_DATE(F_GET_SETTDAYS('$model->trx_dt'),'$model->trx_dt') bgn_date FROM DUAL";
					$date = DAO::queryRowSql($sql);
					$bgn_date = $date['bgn_date'];
					$end_date= $model->trx_dt;
					$modelDetail = Updstkhand::model()->findAllBySql(Updstkhand::getData($bgn_date, $end_date));
					foreach($modelDetail as $row)
					{
						if(DateTime::createFromFormat('Y-m-d',$row->contr_dt))$row->contr_dt=DateTime::createFromFormat('Y-m-d',$row->contr_dt)->format('d/m/Y');
						if(DateTime::createFromFormat('Y-m-d',$row->due_dt_for_amt))$row->due_dt_for_amt=DateTime::createFromFormat('Y-m-d',$row->due_dt_for_amt)->format('d/m/Y');
						if(substr($row->contr_num,4,1)=='J')
						{
							$row->bs ='S';	
						}
						else 
						{
							$row->bs ='B';
						}
						$row->sett_qty = $row->sett_qty?$row->sett_qty:'0';
						$row->entry_qty=$row->qty-$row->sett_qty;
						
					}
					$cek_count = Updstkhand::getCountData($bgn_date, $end_date);
					
					if($cek_count >= 150)
					{
						$msg1 ='Process 150 transaction'."<br />";
						$msg2=$cek_count-150 .' transaction have not settled yet'."<br />";
					}
					else 
					{
						$msg1 = 'Process '.$cek_count. ' transaction'."<br />";	
					}
					Yii::app()->user->setFlash('info', "<strong>".$msg1.$msg2."</strong>");
				}
			}
			//Proses SELECTED STOCK
			else 
			{
				//proses all transaction
				if($model->grp == '0')
				{
					//parameter
					$model->due_dt_for_amt = $model->trx_dt;
					$model->contr_num= '%';
					$model->entry_qty= 0;
					$model->user_id= Yii::app()->user->id;
					$ip = Yii::app()->request->userHostAddress;
					if($ip=="::1")
						$ip = '127.0.0.1';
					$model->ip_address = $ip;
					//parameter exec('A') adalah untuk All Transaction
					if($model->executeSpUpdOnHand('A')>0)$success=true;
					else{
						$success=false;
					}
				}//end proses all transaction
				else 
				{
					$rowCount = $_POST['rowCount'];
					$ip = Yii::app()->request->userHostAddress;
					if($ip=="::1")
						$ip = '127.0.0.1';
					//retrieve data
					for($x=1;$x<=$rowCount;$x++)
					{	$modelDetail[$x] = new Updstkhand;
						$modelDetail[$x]->attributes = $_POST['Updstkhand'][$x];
						$modelDetail[$x]->user_id= Yii::app()->user->id;
						$modelDetail[$x]->entry_qty = str_replace(',', '', $modelDetail[$x]->entry_qty);
						$modelDetail[$x]->qty = str_replace(',', '', $modelDetail[$x]->qty);
						$modelDetail[$x]->sett_qty = str_replace(',', '', $modelDetail[$x]->sett_qty);
						if(DateTime::createFromFormat('d/m/Y',$modelDetail[$x]->due_dt_for_amt))$modelDetail[$x]->due_dt_for_amt= DateTime::createFromFormat('d/m/Y',$modelDetail[$x]->due_dt_for_amt)->format('Y-m-d');
						if(DateTime::createFromFormat('d/m/Y',$modelDetail[$x]->contr_dt))$modelDetail[$x]->contr_dt= DateTime::createFromFormat('d/m/Y',$modelDetail[$x]->contr_dt)->format('Y-m-d');
						$modelDetail[$x]->ip_address = $ip;
						if(isset($_POST['Updstkhand'][$x]['save_flg']) && $_POST['Updstkhand'][$x]['save_flg'] == 'Y')
						{
							$valid=true;	
							if($modelDetail[$x]->entry_qty==''||$modelDetail[$x]->entry_qty=='0')
							{
								$valid=FALSE;
								$modelDetail[$x]->addError('entry_qty','Entry qty cannot 0 to settle transaction');
							}
							
							if($modelDetail[$x]->entry_qty > ($modelDetail[$x]->qty-$modelDetail[$x]->sett_qty) )
							{
								$valid=FALSE;
								$modelDetail[$x]->addError('entry_qty','Entry qty cannot greater than (Qty-settle Qty) ');
							}
						}	
					}
					
					if($valid)
					{
						//proses data
						for($x=1;$x<=$rowCount;$x++)
						{
							if($modelDetail[$x]->save_flg == 'Y')
							{
								//parameter exec('A') adalah untuk Selected Transaction
								if($modelDetail[$x]->executeSpUpdOnHand('S')>0)
								{
									$success=TRUE;	
								}
								else
								{
									$success=false;
								}
							}
						}	
					}
				}//end selected
			
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('index'));
				}
				else 
				{
					$transaction->rollback();
				}
			}
		}

		foreach($modelDetail as $row)
		{
			if(DateTime::createFromFormat('Y-m-d',$row->due_dt_for_amt))$row->due_dt_for_amt= DateTime::createFromFormat('Y-m-d',$row->due_dt_for_amt)->format('d/m/Y');
			if(DateTime::createFromFormat('Y-m-d',$row->contr_dt))$row->contr_dt= DateTime::createFromFormat('Y-m-d',$row->contr_dt)->format('d/m/Y');
		}
		
		$this->render('index',array('model'=>$model,
									'modelDetail'=>$modelDetail,
									'msg1'=>$msg1,
									'msg2'=>$msg2));
	}

	
}
