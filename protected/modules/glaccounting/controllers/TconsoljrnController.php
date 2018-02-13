<?php

class TconsoljrnController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	public function actionView($xn_doc_num,$doc_date)
	{$model=array();
	$model=$this->loadModel($xn_doc_num,$doc_date);
			

		$this->render('view',array(
			'model'=>$model,
			
		));
	}
	public function actionCreate()
	{	
		$model=array();
			$success = false;
			$modelfilter=new Tconsoljrn;
			$cancel_reason = '';
			$valid = true;
			$modelfilter =new Tconsoljrn;
			
				if(isset($_POST['Tconsoljrn']))
		{
			
		
			
			if(isset($_POST['rowCount']))
			{
				
				$rowCount = $_POST['rowCount'];
				$x;
				$y;
					$modelfilter->attributes = $_POST['Tconsoljrn'];
					
				for($x=0;$x<$rowCount;$x++)
						{$model[$x] = new Tconsoljrn;
						$model[$x]->attributes = $_POST['Tconsoljrn'][$x+1];
					if(isset($_POST['Tconsoljrn'][$x+1]['save_flg']) && $_POST['Tconsoljrn'][$x+1]['save_flg'] == 'Y')
					{
						
					
						$valid = $model[$x]->validate() && $valid;
					}	
				}
				/*
					if($modelfilter->balance !=0){
						$debit= $_POST['debit'];
						$credit =$_POST['credit'];
								//$modelfilter->addError('balance', "Amount not balance Debit : $debit and Credit : $credit ");
								Yii::app()->user->setFlash('info',"Amount not balance Debit : $debit and Credit : $credit ");
								//$valid=false;
								
							}	
			 */
				if($valid)
				{
					$success = true;
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					$menuName = 'CONSOLIDATION JOURNAL ENTRY';
					$modelfilter->attributes = $_POST['Tconsoljrn'];
if(DateTime::createFromFormat('d/m/Y',$modelfilter->rep_date))$modelfilter->rep_date=DateTime::createFromFormat('d/m/Y',$modelfilter->rep_date)->format('Y-m-d');
				
					$ip = Yii::app()->request->userHostAddress;
						if($ip=="::1")
						$ip = '127.0.0.1';
					
					$modelfilter->ip_address = $ip;
					$modelfilter->user_id =  Yii::app()->user->id;
				
					
					 if($modelfilter->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
					
					$recordSeq=1;
					for($x=0;$success && $x<$rowCount;$x++)
					{
						
						
						if(DateTime::createFromFormat('d/m/Y',$model[$x]->doc_date))$model[$x]->doc_date=DateTime::createFromFormat('d/m/Y',$model[$x]->doc_date)->format('Y-m-d');
						$model[$x]->curr_val = str_replace( ',', '', $model[$x]->curr_val );
						$model[$x]->user_id =$modelfilter->user_id;
						$model[$x]->ip_address=$modelfilter->ip_address;
						$model[$x]->update_date =$modelfilter->update_date;
						$model[$x]->update_seq= $modelfilter->update_seq;
						if($model[$x]->save_flg == 'Y')
						{	//INSERT
							
						if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->doc_date,$model[$x]->xn_doc_num,$model[$x]->tal_id,$recordSeq) > 0)$success = true;
							else {
								$success = false;
							
							}
							$recordSeq++;
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
if(DateTime::createFromFormat('Y-m-d',$modelfilter->rep_date))$modelfilter->rep_date=DateTime::createFromFormat('Y-m-d',$modelfilter->rep_date)->format('d/m/Y');
			}
			}
		$this->render('create',array(
			'model'=>$model,
			'cancel_reason'=>$cancel_reason,
			'modelfilter'=>$modelfilter	
		));
		}
public function actionUpdate($xn_doc_num,$doc_date)
	{
		$model=array();
		$modelfilter=new Tconsoljrn;
		
		$model=$this->loadModel($xn_doc_num,$doc_date);
		foreach($model as $row){
			$row->old_xn_doc_num=$row->xn_doc_num;
			$row->old_doc_date=$row->doc_date;
			$row->old_tal_id=$row->tal_id;
		}
		
		
		$valid = true;
		$success = false;
	
		$cancel_reason = '';
		
		if(isset($_POST['Tconsoljrn'])){
			
			$rowCount = $_POST['rowCount'];
					$x;
					$modelfilter->attributes = $_POST['Tconsoljrn'];
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
				if($modelfilter->balance !=0){
						
						$debit= $_POST['debit'];
						$credit =$_POST['credit'];
						//$modelfilter->addError('balance', "Amount not balance Debit : $debit and Credit : $credit ");
						Yii::app()->user->setFlash('info',"Amount not balance Debit : $debit and Credit : $credit ");
						//$valid=false;
				}

					
					for($x=0;$x<$rowCount;$x++)
				{
					$model[$x] = new Tconsoljrn;
				
					$model[$x]->attributes = $_POST['Tconsoljrn'][$x+1];
					if(DateTime::createFromFormat('Y-m-d H:i:s',$model[$x]->old_doc_date))$model[$x]->old_doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$model[$x]->old_doc_date)->format('Y-m-d');
					if(isset($_POST['Tconsoljrn'][$x+1]['save_flg']) && $_POST['Tconsoljrn'][$x+1]['save_flg'] == 'Y')
					{
						
						$save_flag = true;
						if(isset($_POST['Tconsoljrn'][$x+1]['cancel_flg']))
						{
							if($_POST['Tconsoljrn'][$x+1]['cancel_flg'] == 'Y')
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
					$menuName = 'CONSOLIDATION JOURNAL ENTRY';
					$modelfilter->attributes = $_POST['Tconsoljrn'];

					$ip = Yii::app()->request->userHostAddress;
						if($ip=="::1")
						$ip = '127.0.0.1';
					
					$modelfilter->ip_address = $ip;
					$modelfilter->user_id =  Yii::app()->user->id;
					
					if($modelfilter->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName) > 0)$success = true;
					
					
					$recordSeq=1;
					for($x=0;$success && $x<$rowCount;$x++)
					{
						$model[$x]->curr_val = str_replace( ',', '', $model[$x]->curr_val );
						$model[$x]->user_id =$modelfilter->user_id;
						$model[$x]->ip_address=$modelfilter->ip_address;
						$model[$x]->update_date =$modelfilter->update_date;
						$model[$x]->update_seq= $modelfilter->update_seq;
						if($model[$x]->save_flg == 'Y')
						{
							if($model[$x]->cancel_flg == 'Y')
							{
								//CANCEL
						if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_CAN,$model[$x]->old_doc_date,$model[$x]->old_xn_doc_num,$model[$x]->old_tal_id,$recordSeq) > 0)$success = true;
						else {
							$success = false;
						}
						$recordSeq++;
							}
							else if($model[$x]->old_xn_doc_num)
							{	
								//UPDATE
							if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model[$x]->old_doc_date,$model[$x]->old_xn_doc_num,$model[$x]->old_tal_id,$recordSeq) > 0)$success = true;
							else {
								$success = false;
							}
							$recordSeq++;
							}			
							else 
							{
								//INSERT
							
						if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->doc_date,$model[$x]->xn_doc_num,$model[$x]->tal_id,$recordSeq) > 0)$success = true;
							else {
								$success = false;
							}
							$recordSeq++;
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
		
		$this->render('update',array(
			'model'=>$model,
			'modelfilter'=>$modelfilter,
			'cancel_reason'=>$cancel_reason,
		));
		
		
		
	}
		public function actionAjxPopDelete($xn_doc_num,$doc_date)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		//$model1=array();
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		$model2 = new Tconsoljrn;
		$model1 = $this->loadModel($xn_doc_num,$doc_date);
		
		if(isset($_POST['Tmanyheader']))
		{
			
			$model->attributes = $_POST['Tmanyheader'];	
					
			//if($model->validate()){
				
				$model2->cancel_reason  = $model->cancel_reason;
				$model2->user_id = Yii::app()->user->id;
				$model2->ip_address = Yii::app()->request->userHostAddress;
				if($model2->ip_address=="::1")
					$model2->ip_address = '127.0.0.1';
				
				
				$success = false;
				$menuName = 'CONSOLIDATION JOURNAL ENTRY';
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				
					if($model2->executeSpHeader(AConstant::INBOX_STAT_CAN,$menuName) > 0)$success = true;	
					
			
				$recordSeq=1;
					$jur_num='';
				foreach($model1 as $row){
					$jur_num=$row->xn_doc_num;
					$row->update_date=$model2->update_date;
					$row->update_seq= $model2->update_seq;
				if(DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date))$row->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date)->format('Y-m-d');	
					
					if($success && $row->executeSp(AConstant::INBOX_STAT_CAN,$row->doc_date,$row->xn_doc_num,$row->tal_id,$recordSeq) > 0)$success = true;
							else {
								$success = false;
							}
							$recordSeq++;
				}
				
			
					if($success){
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$jur_num);
					$is_successsave = true;
				}
				else {
					$transaction->rollback();
				}
			//}
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$model1,		
			'is_successsave'=>$is_successsave,	
			'model2'=>$model2
		));
	}
	
	public function actionIndex()
	{
			$model=new Tconsoljrn('search');
			//$model->unsetAttributes();  // clear any default values
		$model->approved_sts='A';

		if(isset($_GET['Tconsoljrn']))
			$model->attributes=$_GET['Tconsoljrn'];

		$this->render('index',array(
			'model'=>$model,
		));
			
			
	}

	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}

	public function loadModel($xn_doc_num,$doc_date)
	{
		$model=Tconsoljrn::model()->findAll("xn_doc_num='$xn_doc_num' and doc_date='$doc_date' and approved_sts='A'");
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


}
		