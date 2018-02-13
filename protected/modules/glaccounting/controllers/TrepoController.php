<?php

class TrepoController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	public $layout='//layouts/admin_column3';
	
	public function actionGetClientCd()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
      $qSearch = DAO::queryAllSql("
				Select client_cd, client_name From MST_CLIENT 
				Where (client_cd like '".$term."%')
      			AND rownum <= 15
      			ORDER BY client_cd
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['client_cd']
      			, 'labelhtml'=>$search['client_cd'].' - '.$search['client_name'] //WT: Display di auto completenya
      			, 'value'=>$search['client_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }

	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$modelHist = Trepohist::model()->findAll(array('condition'=>"repo_num = '$id' AND approved_stat <> 'C'",'order'=>'repo_date'));
		$modelVch = Trepovch::model()->findAllBySql(Trepovch::getVchSql($model->repo_date, $model->client_cd, $model->repo_num));
		
		$this->render('view',array(
			'model'=> $model,
			'modelHist'=>$modelHist,
			'modelVch'=>$modelVch,
		));
	}

	public function actionCreate()
	{
		$model=new Trepo;
		$modelHist = array();
		$modelHist[0] = new Trepohist;
		$modelVch = array();
		
		$perpanjangan = false;
		$voucher = false;

		if(isset($_POST['Trepo']))
		{
			$model->attributes=$_POST['Trepo'];
			$model->sett_val = 1;
			$model->extent_dt = $model->repo_date;
			$modelHist[0]->attributes=$_POST['Trepohist'][1];
			$modelHist[0]->repo_type = $model->repo_type;
			$menuName = 'REPO ENTRY';
			$connection  = Yii::app()->db;
			$transaction = $connection->beginTransaction();	
			
			if(	$model->validate() && $modelHist[0]->validate() &&
			 	$model->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0 && 
				$model->executeSp(AConstant::INBOX_STAT_INS,$model->repo_num,1) > 0 && 
			 	$modelHist[0]->executeSp(AConstant::INBOX_STAT_INS,$modelHist[0]->repo_num,$modelHist[0]->repo_date,$model->update_date,$model->update_seq,1) > 0)
			{
            	$transaction->commit();
            	Yii::app()->user->setFlash('success', 'Successfully create repo');
				$this->redirect(array('/glaccounting/trepo/index','id'=>$model->repo_num));
            }
			else {
				$transaction->rollback();
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'modelHist'=>$modelHist,
			'modelVch'=>$modelVch,
			'perpanjangan'=>$perpanjangan,
			'voucher'=>$voucher,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$modelHist = array();
		$modelVch = array();
		$oldPkId = array();
		
		$valid = false;
		$success = false;
		$perpanjangan = false;
		$voucher = false;
		
		$cancel_reason = '';
		
		if(isset($_POST['Trepo']))
		{
			if($_POST['voucherFlg'] == 0)//UPDATE REPO / PERPANJANGAN
			{
				$model->attributes=$_POST['Trepo'];
				$model->repo_date = $_POST['repoDateHid'];
				$model->extent_dt = $_POST['extentDateHid'];
				$model->due_date = $_POST['dueDateHid'];
				
				$valid = $model->validate();
				
				$oldModelHist = Trepohist::model()->findAll(array('condition'=>"repo_num = '$id' AND approved_stat <> 'C'",'order'=>'repo_date'));
				$histCount = $_POST['perpanjanganCnt'];
				
				$x;
				
				for($x=0;$x<$histCount;$x++)
				{
					$modelHist[$x] = new Trepohist;
					$modelHist[$x]->attributes=$_POST['Trepohist'][$x+1];
					$valid = $modelHist[$x]->validate() && $valid;
				}
				
				if($_POST['perpanjanganFlg'] == 1)
				{
					$perpanjangan = true;
					$oldHistCount = $histCount - 1;
				}
				else {
					$oldHistCount = $histCount;
				}
				
				if($valid){
					$menuName = 'REPO ENTRY';
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					if($model->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName) > 0)$success = true;
					
					if($perpanjangan)$model->sett_val = 1;//$modelHist[$x-1]->return_val;
					
					if($success && $model->executeSp(AConstant::INBOX_STAT_UPD,$id,1) > 0)$success = true;
					else {
						$success = false;
					}
					
					for($x=0; $success && $x<$oldHistCount;$x++)
					{
						$modelHist[$x]->repo_num = $model->repo_num;
						$modelHist[$x]->repo_type = $model->repo_type;
						if($success && $modelHist[$x]->executeSp(AConstant::INBOX_STAT_UPD,$oldModelHist[$x]->repo_num,DateTime::createFromFormat('Y-m-d G:i:s',$oldModelHist[$x]->repo_date)->format('Y-m-d'),$model->update_date,$model->update_seq,$x+1) > 0)$success = true;
						else {
							$success = false;
						}
					}
					
					if($success && $perpanjangan)
					{
						$modelHist[$x]->repo_num = $model->repo_num;
						$modelHist[$x]->repo_type = $model->repo_type;
						if($success && $modelHist[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelHist[$x]->repo_num,$modelHist[$x]->repo_date,$model->update_date,$model->update_seq,$x+1) > 0)$success = true;
						else {
							$success = false;
						}
					}
					
					if($success)
					{
						$transaction->commit();
		               	Yii::app()->user->setFlash('success', 'Successfully update '.$model->repo_num);
						$this->redirect(array('/glaccounting/trepo/index'));
					}
					else {
						$transaction->rollback();
					}
	            }
				
				for($x=0;$x<count($modelHist);$x++)
				{
					if($modelHist[$x]->repo_date)$modelHist[$x]->repo_date = DateTime::createFromFormat('Y-m-d',$modelHist[$x]->repo_date)->format('d/m/Y');
					if($modelHist[$x]->due_date)$modelHist[$x]->due_date = DateTime::createFromFormat('Y-m-d',$modelHist[$x]->due_date)->format('d/m/Y');
				}
				
				$modelVch = Trepovch::model()->findAllBySql(Trepovch::getVchSql($model->repo_date, $model->client_cd, $model->repo_num));
		
				foreach($modelVch as $row)
				{
					$row->doc_dt = DateTime::createFromFormat('Y-m-d G:i:s',$row->doc_dt)->format('d/m/Y');
					
					$row->old_doc_num = $row->doc_num;
					$row->old_doc_ref_num = $row->doc_ref_num;
				}
				
				$vchCount = count($modelVch);
				
				for($x=0;$x<$vchCount;$x++)
				{
					$modelVch[$x]->scenario = 'update';
				}
			}
			else //VOUCHER
			{
				$voucher = true;
				$valid = true;
				$vchCount = $_POST['voucherCnt'];
				
				$x=0;
				$y=0;
				
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
						$model->cancel_reason = $_POST['cancel_reason'];
					}
				}
				
				if($vchCount > 0)
				{
					for($x=0;$x<$vchCount;$x++)
					{
						$modelVch[$x] = new Trepovch;
						$modelVch[$x]->attributes=$_POST['Trepovch'][$x+1];
						
						switch($modelVch[$x]->payrec_type)
						{
							case 'Receipt':
								$modelVch[$x]->payrec_type = 'RD';
								break;
							case 'Payment':
								$modelVch[$x]->payrec_type = 'PD';
								break;
							case 'Receipt to Settle':
								$modelVch[$x]->payrec_type = 'RV';
								break;
							case 'Payment to Settle':
								$modelVch[$x]->payrec_type = 'PV';
								break;
						}
						
						if(isset($_POST['Trepovch'][$x+1]['save_flg']) && $_POST['Trepovch'][$x+1]['save_flg'] == 'Y')
						{
							if(isset($_POST['Trepovch'][$x+1]['cancel_flg']))
							{
								if($_POST['Trepovch'][$x+1]['cancel_flg'] == 'Y')
								{
									//CANCEL
									$modelVch[$x]->scenario = 'cancel';
									$modelVch[$x]->cancel_reason = $_POST['cancel_reason'];
								}
								else 
								{
									//UPDATE
									$modelVch[$x]->scenario = 'update';
								}
							}
							else 
							{
								//INSERT
								$modelVch[$x]->scenario = 'insert';
							}
							$modelVch[$x]->repo_num = $model->repo_num;
							$valid = $modelVch[$x]->validate() && $valid;
						}
						else {
							$modelVch[$x]->doc_num = $modelVch[$x]->old_doc_num; //Get the old value since the field on form is disabled
						}		
					}
					
					//validasi primary key tiap baris yang di-save tidak boleh ada yang sama (kecuali yang di-cancel)
					for($x=0;$valid && $x < $vchCount;$x++)
					{
						for($y = $x+1;$valid && $y < $vchCount;$y++)
						{
							if(
								isset($_POST['Trepovch'][$x+1]['save_flg']) && $_POST['Trepovch'][$x+1]['save_flg'] == 'Y'
								&& isset($_POST['Trepovch'][$y+1]['save_flg']) && $_POST['Trepovch'][$y+1]['save_flg'] == 'Y'
								&& (!isset($_POST['Trepovch'][$x+1]['cancel_flg']) || $_POST['Trepovch'][$x+1]['cancel_flg'] != 'Y')
								&& (!isset($_POST['Trepovch'][$y+1]['cancel_flg']) || $_POST['Trepovch'][$y+1]['cancel_flg'] != 'Y')
							)
							{
								if($modelVch[$x]->doc_num == $modelVch[$y]->doc_num && $modelVch[$x]->doc_ref_num == $modelVch[$y]->doc_ref_num)
								{
									$modelVch[$x]->addError('doc_num','Duplicated Journal Ref');
									$valid = false;
								}
							}
						}
					}
					
					if($valid)
					{
						$menuName = 'REPO ENTRY';
						$connection  = Yii::app()->db;
						$transaction = $connection->beginTransaction();	
						
						$model->repo_date = DateTime::createFromFormat('Y-m-d G:i:s',$model->repo_date)->format('Y-m-d');
						if($model->extent_dt)$model->extent_dt = DateTime::createFromFormat('Y-m-d G:i:s',$model->extent_dt)->format('Y-m-d');
						$model->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$model->due_date)->format('Y-m-d');
						$model->sett_val = $_POST['totalAmount'];
						
						if($model->validate() && $model->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName) > 0)$success = true;
						
						if($success &&  $model->executeSp(AConstant::INBOX_STAT_UPD,$id,1) > 0)$success = true;
						else {
							$success = false;
						}
						
						$recordSeq = 1;
						
						for($x=0,$y=0; $success && $x<$vchCount;$x++)
						{
							if($modelVch[$x]->save_flg == 'Y')
							{
								if($modelVch[$x]->cancel_flg == 'Y')
								{
									//CANCEL
									if($success && $modelVch[$x]->executeSp(AConstant::INBOX_STAT_CAN,$model->repo_num,$modelVch[$x]->old_doc_num,$modelVch[$x]->old_doc_ref_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}
								else if($modelVch[$x]->old_doc_num)
								{
									//UPDATE
									
									//Cek bila doc_num atau doc_ref_num di-edit, STATUS = CANCEL + INSERT. Bila yang di-edit hanya amt, STATUS = UPDATE.
									
									if($modelVch[$x]->old_doc_num != $modelVch[$x]->doc_num || $modelVch[$x]->old_doc_ref_num != $modelVch[$x]->doc_ref_num)
									{
										//CANCEL + INSERT
											
										//CANCEL
										if($success && $modelVch[$x]->executeSp(AConstant::INBOX_STAT_CAN,$model->repo_num,$modelVch[$x]->old_doc_num,$modelVch[$x]->old_doc_ref_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
										else {
											$success = false;
										}
										
										$recordSeq++;
										
										//INSERT
										if($success && $modelVch[$x]->executeSp(AConstant::INBOX_STAT_INS,$model->repo_num,$modelVch[$x]->doc_num,$modelVch[$x]->doc_ref_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
										else {
											$success = false;
										}
									}
									else
									{
										//UPDATE
										if($success && $modelVch[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model->repo_num,$modelVch[$x]->old_doc_num,$modelVch[$x]->old_doc_ref_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
										else {
											$success = false;
										}
									}	
								}			
								else 
								{
									//INSERT
									if($success && $modelVch[$x]->executeSp(AConstant::INBOX_STAT_INS,$model->repo_num,$modelVch[$x]->doc_num,$modelVch[$x]->doc_ref_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
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
							Yii::app()->user->setFlash('success', 'Successfully update Repo Voucher');
							$this->redirect(array('/glaccounting/trepo/index'));
						}
						else {
							$transaction->rollback();
						}
					}
				}
				else 
				{
					Yii::app()->user->setFlash('error', 'No Data');
				}
				
				foreach($modelVch as $row)
				{
					if(DateTime::createFromFormat('Y-m-d',$row->doc_dt))$row->doc_dt = DateTime::createFromFormat('Y-m-d',$row->doc_dt)->format('d/m/Y');
					$row->amt = str_replace(",","",$row->amt);
				}

				$modelHist = Trepohist::model()->findAll(array('condition'=>"repo_num = '$id' AND approved_stat <> 'C'",'order'=>'repo_date'));
		
				foreach($modelHist as $row)
				{
					$row->repo_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->repo_date)->format('d/m/Y');
					$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('d/m/Y');
				}
			}	
		}
		else {
			$modelHist = Trepohist::model()->findAll(array('condition'=>"repo_num = '$id' AND approved_stat <> 'C'",'order'=>'repo_date'));
		
			foreach($modelHist as $row)
			{
				$row->repo_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->repo_date)->format('d/m/Y');
				$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('d/m/Y');
			}
			
			//$modelVch = Trepovch::model()->findAll(array('condition'=>"TRUNC(doc_dt)>=TRUNC(TO_DATE('$model->repo_date','YYYY-MM-DD HH24:MI:SS')) AND sl_acct_cd='$model->client_cd' AND repo_num='$model->repo_num'",'order'=>'repo_num'));
			
			$modelVch = Trepovch::model()->findAllBySql(Trepovch::getVchSql($model->repo_date, $model->client_cd, $model->repo_num));
		
			foreach($modelVch as $row)
			{
				$row->doc_dt = DateTime::createFromFormat('Y-m-d G:i:s',$row->doc_dt)->format('d/m/Y');
				
				$row->old_doc_num = $row->doc_num;
				$row->old_doc_ref_num = $row->doc_ref_num;
			}

			$vchCount = count($modelVch);
			for($x=0;$x<$vchCount;$x++)
			{
				$modelVch[$x]->scenario = 'update';
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'modelHist'=>$modelHist,
			'modelVch'=>$modelVch,
			'perpanjangan'=>$perpanjangan,
			'voucher'=>$voucher,
			'oldPkId'=>$oldPkId,
			'cancel_reason'=>$cancel_reason,
		));
	}

	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether a user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}
	
	public function actionAjxAssignVchDetail($id)
	{
		$resp['status']  = 'error';
		
		if(isset($_POST['doc_num']))
		{
			$model = $this->loadModel($id);
			
			$doc_num = $_POST['doc_num'];
			$doc_ref_num = $_POST['doc_ref_num'];
			$repo_date = $_POST['repo_date'];
			$client_cd = $_POST['client_cd'];
			$s_gl_acct = $_POST['s_gl_acct'];
			$repo_num = $_POST['repo_num'];
			$tal_id = $_POST['tal_id'];
			
			$journalRef = Vjournalrefvch::model()->find(array('condition'=>"payrec_date >= TRUNC(TO_DATE('$repo_date','YYYY-MM-DD HH24:MI:SS')) AND gl_acct_cd = '$s_gl_acct' AND sl_acct_cd LIKE '$client_cd%' AND payrec_num = '$doc_num' AND doc_ref_num ='$doc_ref_num' AND tal_id = '$tal_id'"));
			if($journalRef)$journalRef->payrec_date = DateTime::createFromFormat('Y-m-d G:i:s',$journalRef->payrec_date)->format('d/m/Y');
			else {
				$detailVch = Trepovch::model()->findBySql(Trepovch::getVchSql($model->repo_date, $model->client_cd, $model->repo_num, $doc_num, $doc_ref_num));
				$journalRef = new Vjournalrefvch;
				$journalRef->payrec_date = DateTime::createFromFormat('Y-m-d G:i:s',$detailVch->doc_dt)->format('d/m/Y');
				$journalRef->payrec_type = $detailVch->payrec_type;
				$journalRef->payrec_amt = $detailVch->amt;
				$journalRef->folder_cd = $detailVch->folder_cd;
				$journalRef->remarks = $detailVch->remarks;
				$journalRef->doc_ref_num = $detailVch->doc_ref_num;
				$journalRef->tal_id = $detailVch->tal_id;
			}
			
			$resp['status'] = 'success';
		}	
		
		$resp['content'] = array('payrec_date'=>$journalRef->payrec_date,'payrec_type'=>$journalRef->payrec_type,'amt'=>$journalRef->payrec_amt,'folder_cd'=>$journalRef->folder_cd,'remarks'=>$journalRef->remarks,'doc_ref_num'=>$journalRef->doc_ref_num,'tal_id'=>$journalRef->tal_id);
		echo json_encode($resp);
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$model=new Trepo('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->sett_val = ' > 0';
		$model->approved_stat = 'A';

		if(isset($_GET['Trepo']))
			$model->attributes=$_GET['Trepo'];
			

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Trepo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
