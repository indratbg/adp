<?php

class TclientdepositController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	public function actionCheckAmount()
	{
		$resp['status']='error';
		if(isset($_POST['folder_cd']))
		{
			$folder_cd=$_POST['folder_cd'];
			//$client_cd = $_POST['client_cd'];
			$sql ="SELECT d.client_cd,t.curr_val,t.db_cr_flg,T.DOC_DATE,t.folder_cd, t.folder_cd||'  '|| trim(gl_acct_cd)||'  '|| db_cr_flg||'  '|| curr_val||'  '|| to_char(doc_date,'dd/mm/yyyy')||'  '||ledger_nar as text,  xn_doc_num, t.tal_id   
				       FROM  ipnextg.T_ACCOUNT_LEDGER t, ipnextg.T_CLIENT_DEPOSIT d   
				       WHERE t.doc_date > trunc(sysdate)-60
	                   AND trim(t.gl_acct_cd)= '2491' 
	                   AND approved_sts ='A' 
	                   AND t.xn_doc_num = d.doc_num(+)   
				       AND t.tal_id= d.tal_id(+) 
				       and d.doc_num is null 
				       and d.tal_id is null
				       AND t.FOLDER_CD = '$folder_cd' ";
			//$sql = "select * from temp_dropdown_deposit where folder_cd='$folder_cd'";			 
			$curr_val = DAO::queryRowSql($sql);			 
			$resp['curr_val'] = $curr_val['curr_val'];			 
			$resp['client_cd'] = $curr_val['client_cd'];
			$resp['db_cr_flg'] = $curr_val['db_cr_flg'];
			$resp['doc_num'] = $curr_val['xn_doc_num'];
			$resp['tal_id'] = $curr_val['tal_id'];
			$resp['status']='success';
		}
	
	echo json_encode($resp);
	}

	public function actionIndex()
	{	
		$model=new Tclientdeposit('search');
		$model->unsetAttributes();  // clear any default values
		$model->approved_stat='A';
		if(isset($_GET['Tclientdeposit']))
			$model->attributes=$_GET['Tclientdeposit'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	
	public function actionCreate()
	{	
		$model=new Tclientdeposit;
		$model=array();
		$cancel_reason='';
		$valid = true;
		$success = false;
	
		$sql_folder_cd = "SELECT d.client_cd,t.curr_val,t.db_cr_flg,T.DOC_DATE,t.folder_cd, t.folder_cd||'  '|| trim(gl_acct_cd)||'  '|| db_cr_flg||'  '|| curr_val||'  '|| to_char(doc_date,'dd/mm/yyyy')||'  '||ledger_nar as text,  xn_doc_num, t.tal_id   
				       FROM  ipnextg.T_ACCOUNT_LEDGER t, ipnextg.T_CLIENT_DEPOSIT d   
				       WHERE t.doc_date > trunc(sysdate)-60
				             AND trim(t.gl_acct_cd)= '2491' AND approved_sts ='A' AND t.xn_doc_num = d.doc_num(+)   
				       AND t.tal_id= d.tal_id(+) and d.doc_num is null and d.tal_id is null";
		$dropdown_folder_cd = Tclientdeposit::model()->findAllBySql($sql_folder_cd);
		if(isset($_POST['Tclientdeposit']))
		{
			
			if(isset($_POST['rowCount']))
			{
				$rowCount = $_POST['rowCount'];
				$x;
				$y;
					
				for($x=0;$x<$rowCount;$x++)
				{
					if(isset($_POST['Tclientdeposit'][$x+1]['save_flg']) && $_POST['Tclientdeposit'][$x+1]['save_flg'] == 'Y')
					{
						$model[$x] = new Tclientdeposit;
						$model[$x]->attributes=$_POST['Tclientdeposit'][$x+1];
						$valid=$model[$x]->validate()&&$valid;
						
					}	
				}
			
				if($valid)
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
					$menuName = 'DEPOSIT CLIENT ENTRY';
					
					
				
					if($model[0]->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
					else{
						$success=false;
					}
				
					$recordSeq = 1;
					
					for($x=0; $success && $x<$rowCount ;$x++)
					{ 
						if($model[$x]->save_flg == 'Y'){
											 
						$model[$x]->update_date = $model[0]->update_date;
						$model[$x]->update_seq = $model[0]->update_seq; 			
						$model[$x]->tal_id = $model[$x]->tal_id;
						$model[$x]->debit = $model[$x]->debit== null?0:$model[$x]->debit;
						$model[$x]->credit = $model[$x]->credit== null?0:$model[$x]->credit; 
							if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->trx_date,$model[$x]->client_cd,$model[$x]->doc_num,$recordSeq) > 0)$success = true;
							else {
								$success = false;
							}
							$recordSeq++;
						}	
					}

					if($success){
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/finance/tclientdeposit/index'));
					}else {
						$transaction->rollback();
					}
				}
			}
		}
		
		
		
		$this->render('create',array(
			'model'=>$model,
			'cancel_reason'=>$cancel_reason,
			'dropdown_folder_cd'=>$dropdown_folder_cd
		));
	}
	
	public function actionUpdate($id)
	{
		$sql="SELECT TRX_DATE, CLIENT_CD,  DEBIT ,credit,  NO_PERJANJIAN,  DOC_TYPE, 'N' flg, decode(debit,0,'+','-') mvmt_type,			
				doc_num, tal_id,folder_cd FROM T_CLIENT_DEPOSIT WHERE approved_stat = 'A'			
				and client_Cd = '$id' order by trx_Date ";	
		$model = Tclientdeposit::model()->findAllBySql($sql);
		$sql_folder_cd = "SELECT t.folder_cd, t.folder_cd||'  '|| trim(gl_acct_cd)||'  '|| db_cr_flg||'  '|| curr_val||'  '|| to_char(doc_date,'dd/mm/yyyy')||'  '||ledger_nar as text,  xn_doc_num, t.tal_id			
						 FROM T_ACCOUNT_LEDGER t, T_CLIENT_DEPOSIT d			
						 WHERE t.doc_date > '1jan15' 			
						 AND t.gl_acct_cd= '2491' 			
						 AND approved_sts ='A'			
						 AND t.xn_doc_num = d.doc_num(+)			
						 AND t.tal_id= d.tal_id(+)			
						and d.doc_num is null			
						and d.tal_id is null			
						 ORDER BY t.doc_date";
		$dropdown_folder_cd = Tclientdeposit::model()->findAllBySql($sql_folder_cd);
		
		//$folder = new Tclientdeposit;
		
		  
		$cancel_reason='';
		$valid = TRUE;
		$success = false;
	
		if(isset($_POST['Tclientdeposit']))
		{
			$rowCount = $_POST['rowCount'];
		
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
					$model[0]->cancel_reason = $_POST['cancel_reason'];
				}
			}
		
	
		
			for($x=0;$x<$rowCount;$x++)
			{
				$model[$x] = new Tclientdeposit;
				$model[$x]->attributes = $_POST['Tclientdeposit'][$x+1];
	
				if(isset($_POST['Tclientdeposit'][$x+1]['save_flg']) && $_POST['Tclientdeposit'][$x+1]['save_flg'] == 'Y')
				{
					if(isset($_POST['Tclientdeposit'][$x+1]['cancel_flg']))
					{
						if($_POST['Tclientdeposit'][$x+1]['cancel_flg'] == 'Y')
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
				}
				$valid = $model[$x]->validate() && $valid;
			}
			foreach($model as $row)
			{
				//if(DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date))$row->trx_date= DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date)->format('d/m/Y');	
				if(DateTime::createFromFormat('Y-m-d',$row->trx_date))$row->trx_date= DateTime::createFromFormat('Y-m-d',$row->trx_date)->format('d/m/Y');
			
			}
			
			
			if($valid)
			{
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
				$menuName = 'DEPOSIT CLIENT ENTRY';
				
				
				if($model[0]->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName)>0)$success=true;
				else{
					$success = false;
				}
				$recordSeq=1;
				for($x=0;$success && $x<$rowCount;$x++)
				{
				if(DateTime::createFromFormat('Y-m-d H:i:s',$model[$x]->old_trx_date))$model[$x]->old_trx_date= DateTime::createFromFormat('Y-m-d H:i:s',$model[$x]->old_trx_date)->format('Y-m-d');	
				if(DateTime::createFromFormat('d/m/Y',$model[$x]->trx_date))$model[$x]->trx_date= DateTime::createFromFormat('d/m/Y',$model[$x]->trx_date)->format('Y-m-d');
						if($model[$x]->save_flg == 'Y')
						{
							$model[$x]->update_date = $model[0]->update_date;
							$model[$x]->update_seq = $model[0]->update_seq; 		
							
							if($model[$x]->cancel_flg == 'Y')
							{
								//CANCEL
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_CAN,$model[$x]->old_trx_date,$model[$x]->old_client_cd,$model[$x]->old_doc_num,$recordSeq) > 0)$success = true;
								else {
									$success = false;
								}
							}
							else if($model[$x]->old_client_cd)
							{
								//UPDATE
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model[$x]->old_trx_date,$model[$x]->old_client_cd,$model[$x]->old_doc_num,$recordSeq) > 0)$success = true;
								else {
									$success = false;
								}
							}			
							else 
							{
								//GET DOC NUM
								$tanggal = $model[$x]->trx_date;
								$sql="SELECT GET_DOCNUM_GL(to_date('$tanggal','yyyy-mm-dd'),'GL') as doc_num from dual";
								$num=DAO::queryRowSql($sql);
								$model[$x]->doc_num = $num['doc_num'];
								$model[$x]->tal_id= $model[$x]->tal_id;
								$model[$x]->debit = $model[$x]->debit== null?0:$model[$x]->debit;
								$model[$x]->credit = $model[$x]->credit== null?0:$model[$x]->credit; 
								//INSERT
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->trx_date,$model[$x]->client_cd,$model[$x]->doc_num,$recordSeq) > 0)$success = true;
								else {
									$success = false;
								}
							}
							$recordSeq++;
						}
						
					}

		
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('/finance/tclientdeposit/index'));
				}
				else {
					$transaction->rollback();
				} 
				
			}

		}
		else
		{
			
		foreach($model as $row)
		{
			$row->old_client_cd=$row->client_cd;
			$row->old_trx_date = $row->trx_date;
			$row->old_doc_num= $row->doc_num;
			if(DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date))$row->trx_date= DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date)->format('d/m/Y');	
			if(DateTime::createFromFormat('Y-m-d',$row->trx_date))$row->trx_date= DateTime::createFromFormat('Y-m-d',$row->trx_date)->format('d/m/Y');
		
		}
		}
	
		$this->render('update',array(
			'model'=>$model,
			'cancel_reason'=>$cancel_reason,
			'dropdown_folder_cd'=>$dropdown_folder_cd
			
		));
	}
	
	
	public function actionView($id)
	{
		$model=$this->loadModel($id);
		foreach($model as $row)
		{
		if(DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date))$row->trx_date= DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date)->format('d-M-Y');	
		} 
		
		$this->render('view',array('model'=>$model
									));
	}
	
	

	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}
	
	public function loadModel($id)
	{
		$model=Tclientdeposit::model()->findAll("client_cd = '$id' ");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	 
}
