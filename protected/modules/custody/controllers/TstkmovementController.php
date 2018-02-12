<?php

class TstkmovementController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	public $menuName = 'STOCK MOVEMENT ENTRY';
	/*
	public function actionGetClient()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
     /* $qSearch = DAO::queryAllSql("
				SELECT a.CLIENT_CD, CLIENT_NAME 
				FROM MST_CLIENT a, MST_CLIENT_FLACCT b,
				( 
					SELECT TRIM(PRM_DESC) BLOCK_FLG		
        			FROM MST_PARAMETER		
       				WHERE PRM_CD_1 = 'BLOCK'		
         			AND PRM_CD_2 = 'RDN'
         		) p						
				WHERE a.CLIENT_CD = b.CLIENT_CD(+)
				AND (NVL(b.acct_stat,'C') in ('A','I') OR p.BLOCK_FLG = 'N')				
				AND a.CLIENT_CD LIKE '".$term."%'
				AND ROWNUM <= 15
				AND client_type_1 <> 'B' 
				AND susp_stat = 'N' 
				ORDER BY a.CLIENT_CD
      			");*/
      			
/*
      $qSearch = DAO::queryAllSql("
      				SELECT client_cd, client_name 
					FROM MST_CLIENT 
					WHERE susp_stat = 'N' 
					AND CLIENT_CD LIKE '".$term."%'
					ORDER BY client_cd");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['client_cd'].' - '.$search['client_name']
      			, 'labelhtml'=>$search['client_cd'] //WT: Display di auto completenya
      			, 'value'=>$search['client_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
	*/
	//10may2017 pake sharesqlController
/*
	public function actionGetStock()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
      $qSearch = DAO::queryAllSql("
				SELECT STK_CD FROM MST_COUNTER 
				WHERE STK_CD LIKE '".$term."%'
				AND ROWNUM <= 15
				AND APPROVED_STAT = 'A'
				ORDER BY STK_CD
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['stk_cd']
      			, 'labelhtml'=>$search['stk_cd'] //WT: Display di auto completenya
      			, 'value'=>$search['stk_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
*/
    public function actionAjxGetClientName()
	{
		$model = array();
		
		if(isset($_POST['client']))
		{
			$client = $_POST['client'];
			
			$model = DAO::queryRowSql("SELECT CLIENT_NAME FROM MST_CLIENT WHERE CLIENT_CD = '$client'");
		}
		
		echo json_encode($model);
	}
	
	public function actionAjxCheckRdi()
	{
		$model = array();
		
		if(isset($_POST['client']))
		{
			$client = $_POST['client'];
			
			$model = DAO::queryRowSql("SELECT client_name, cek_rdi_by_sid(client_cd) rdi_flg FROM MST_CLIENT WHERE client_cd = '$client'");
		}
		
		echo json_encode($model);
	}
	
	public function actionAjxCheckRatio()
	{
		$result = array();
		
		$valid = true;
		$ratio = '';
		$message = '';
		$block = false;
		
		if(isset($_POST['client']))
		{
			$client = $_POST['client'];
			$stock = $_POST['stock'];
			$qty = $_POST['qty'];
			
			$clientDetail = DAO::queryRowSql(Tstkmovement::getClientTypeSql($client));	

			if($clientDetail['client_type'] == 'M')
			{
				$valid = $this->checkRatio($client, $stock, $qty, $ratio, $message, $block);
			}
		}
		
		$result['valid'] = $valid;
		$result['ratio'] = $ratio;
		$result['message'] = $message;
		$result['block'] = $block;
		
		echo json_encode($result);
	}
	
	public function actionAjxCheckRatioPorto()
	{
		$result = array();
		
		$valid = true;
		$ratio = '';
		$message = '';
		$block = false;
		
		if(isset($_POST[0]))
		{
		     
			$client = $_POST[0]['client'];
			$clientDetail = DAO::queryRowSql(Tstkmovement::getClientTypeSql($client));	

			if($clientDetail['client_type'] == 'M')
			{
				$totalRow = count($_POST);
				$totalQty = 0;
				
				for($x=0;$x<$totalRow;$x++)	
				{
					$stock = $_POST[$x]['stock'];
					$qty = $_POST[$x]['qty'];
					
					$porto_disc = DAO::queryRowSql("SELECT F_CALC_PORTFOLIO_DISCT('$client','$stock','$qty') qty FROM dual");
									
					$totalQty += $porto_disc['qty'];
				}
				
				$valid = $this->checkRatioPorto($client, $totalQty, $ratio, $message, $block);
			}
		}
		
		$result['valid'] = $valid;
		$result['ratio'] = $ratio;
		$result['message'] = $message;
		$result['block'] = $block;
		
		echo json_encode($result);
	}
	
	public function actionAjxGetRepoRef()
	{
		$model = array();
		
		if(isset($_POST['repo']))
		{
			$repo = $_POST['repo'];
			$client = $_POST['client'];
			
			$modelObj = Trepo::model()->findAll("NVL(sett_val,0)<>0 AND repo_type = '$repo' AND client_cd = '$client'");
			
			$x = 0;
			
			foreach($modelObj as $row)
			{
				$model[$x]['repo_ref'] = $row->repo_ref;
				$model[$x]['repo_num'] = $row->repo_num;
				$model[$x]['repo_date'] = DateTime::createFromFormat('Y-m-d G:i:s',$row->repo_date)->format('d M Y');
				$model[$x]['due_date'] = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('d M Y');
				$model[$x]['repo_val'] = $row->repo_val;
				$x++;
			}
		}
		
		echo json_encode($model);
	}
	
	public function actionAjxGetType2()
	{
		$model = array();
		
		if(isset($_POST['moveType']))
		{
			$movement_type = $_POST['moveType'];
			$movement_type_2 = DAO::queryRowSql("SELECT prm_desc2 FROM MST_PARAMETER WHERE prm_cd_1 = 'STKMOV' AND prm_cd_2 = '$movement_type'");
			if($movement_type_2 && $movement_type_2['prm_desc2'])$model = explode(',', $movement_type_2['prm_desc2']);
		}
		
		echo json_encode($model);
	}
	
	public function actionAjxGetEffDt()
	{
		$data = '';
		
		if(isset($_POST['stk_cd']))
		{
			$stk_cd = $_POST['stk_cd'];
			
			$sql = "SELECT TO_CHAR(eff_dt,'DD/MM/YYYY') eff_dt
					FROM
					(  
						SELECT stk_cd, Get_Doc_Date(1,pp_from_dt) AS distrib_dt
						FROM mst_counter m
					   	WHERE ctr_type = 'RT'
					   	AND pp_from_dt IS NOT NULL
					   	AND approved_stat = 'A'
					)  m,
					t_corp_act t
					WHERE m.stk_cd = t.stk_cd
					AND m.distrib_dt = t.distrib_dt
					AND m.stk_cd = '$stk_cd'
					AND t.approved_stat = 'A'";
					
			$result = DAO::queryRowSql($sql);
			
			if($result)$data = $result['eff_dt'];
		}
		
		echo json_encode($data);
	}
	
	public function actionAjxValidateBackDated()
	{
		$resp = '';
		echo json_decode($resp);
	}

	public function actionView($doc_num, $db_cr_flg, $seqno)
	{
		$model = $this->loadModel($doc_num, $db_cr_flg, $seqno);
		$this->setMovementType($model->jur_type, $model->movement_type, $model->movement_type_2);
		
		/*if($model->movement_type == 'WITHDRAW')$model->qty = $model->withdrawn_share_qty;
		else {
			$model->qty = $model->total_share_qty;
		}*/
		
		$model->qty = $model->withdrawn_share_qty + $model->total_share_qty;
		
		$model2 = $this->loadModel($doc_num, $db_cr_flg=='D'?'C':'D', $seqno==1?2:1);
		
		$glAcctDebit = $model->db_cr_flg=='D'?$model->gl_acct_cd:$model2->gl_acct_cd;
		$glAcctCredit = $model->db_cr_flg=='C'?$model->gl_acct_cd:$model2->gl_acct_cd;
		
		$sysdate = date('Y-m-d');
		
		$resultDebit = DAO::queryRowSql("SELECT sl_desc FROM MST_SECURITIES_LEDGER WHERE gl_acct_cd = '$glAcctDebit' AND TO_DATE('$sysdate','YYYY-MM-DD') BETWEEN ver_bgn_dt AND ver_end_dt");
		$resultCredit = DAO::queryRowSql("SELECT sl_desc FROM MST_SECURITIES_LEDGER WHERE gl_acct_cd = '$glAcctCredit' AND TO_DATE('$sysdate','YYYY-MM-DD') BETWEEN ver_bgn_dt AND ver_end_dt");
		
		if($resultDebit && $resultCredit)
		{
			$model->sl_desc_debit = $resultDebit['sl_desc'];
			$model->sl_desc_credit = $resultCredit['sl_desc'];
		}
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function actionCreate()
	{
		$model=new Tstkmovement('header');
		$modelReceive = array(); // For 'Receive'
		$modelRetrieve = array(); // For the rest
		
		$retrieved = FALSE;
		$valid = FALSE;
		$success = FALSE;
		$scenario = '';
		
		$model->doc_dt = date('d/m/Y');
		$model->status = 'L';

		if(isset($_POST['Tstkmovement']))
		{
			$scenario = $_POST['scenario'];
			
			if($scenario)$retrieved = TRUE;
			
			$model->attributes=$_POST['Tstkmovement'];
			$valid = $model->validate() && $model->validateStkBal();
			
			$authorizedBackDated = $_POST['authorizedBackDated'];
			
			if(!$authorizedBackDated)
			{
				$currMonth = date('Ym');
				$docMonth = DateTime::createFromFormat('Y-m-d',$model->doc_dt)->format('Ym');
				
				if($docMonth < $currMonth)
				{
					$model->addError('doc_dt','You are not authorized to select last month date');
					$valid = FALSE;
				}
			}
			

			if($_POST['submit'] == 'retrieve')
			{
				if($valid)
				{
					switch($scenario)
					{
						case 'withdraw':
							$client_cd = $model->client_cd?$model->client_cd:'%';
							$stk_cd = $model->stk_cd?$model->stk_cd:'%';
							$begin_dt = DateTime::createFromFormat('Y-m-d',$model->doc_dt)->format('Y-m-01');
							
							if($model->movement_type == 'WHDR' && $model->movement_type_2 == 1) 
							{
								//Withdraw Scrip
								$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getWithdrawScriptDetailSql($client_cd,$stk_cd,$model->client_type,$begin_dt,$model->doc_dt));
							}
                            //27oct2017 tender offer sell
                            else if($model->movement_type == 'TDOSEL' && $model->movement_type_2 == 2)
                            {
                                $modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getWithdrawDetailSql($client_cd,$stk_cd,$model->client_type,$begin_dt,$model->doc_dt));
                                foreach($modelRetrieve as $row)
                                {
                                    $row->avg_price = $model->price;
                                }
                            }
							else 
							{
								$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getWithdrawDetailSql($client_cd,$stk_cd,$model->client_type,$begin_dt,$model->doc_dt));
							}
							
							break;	
							
						case 'move':
							$client_cd = $model->client_cd;
							$stk_cd = $model->stk_cd?$model->stk_cd:'%';
							$begin_dt = DateTime::createFromFormat('Y-m-d',$model->doc_dt)->format('Y-m-01');
							
							if($model->movement_type_2 == 0)
							{
								// Move Scripless
								$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getWithdrawDetailSql($client_cd,$stk_cd,$model->client_type,$begin_dt,$model->doc_dt));
							}
							else 
							{
								// Move Scrip
								$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getWithdrawScriptDetailSql($client_cd,$stk_cd,$model->client_type,$begin_dt,$model->doc_dt));
							}
							
							foreach($modelRetrieve as $row)
							{
								$row->qty = $row->on_hand;
							}
							
							break;
							
						case 'exercise':
						case 'exercise2':
						case 'exercise3':
							$client_cd = $model->client_cd?$model->client_cd:'%';
							$stk_cd = $model->stk_cd;
							$begin_dt = DateTime::createFromFormat('Y-m-d',$model->doc_dt)->format('Y-m-01');
							
							if($scenario == 'exercise')
								$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getWithdrawDetailSql($client_cd,$stk_cd,$model->client_type,$begin_dt,$model->doc_dt));
							else if($scenario == 'exercise2')
								$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getExercise2DetailSql($client_cd, $stk_cd));
							else
								$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getExercise3DetailSql($client_cd, substr($stk_cd,0,4)));
							
							foreach($modelRetrieve as $row)
							{
								//$row->avg_price = $model->price;
								$row->qty = $row->on_hand;
							}
						
							break;
						
						case 'reverse':
							$begin_dt = DateTime::createFromFormat('Y-m-d',$model->doc_dt)->format('Y-m-01');
							$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getReverseRepoDetailSql($model->client_cd,$model->price_dt,$begin_dt,$model->doc_dt));
							
							$client_name = Client::model()->find("client_cd = '$model->client_cd'");
							
							foreach($modelRetrieve as $row)
							{
								$row->client_cd = $model->client_cd;
								$row->avg_price = $row->price;
								$row->value = $row->qty * $row->price;
								$row->client_name = $client_name->client_name;
							}
							
							break;
							
						case 'retreverse':
						case 'settbuy':
						case 'settsell':
							$client_cd = $model->client_cd?$model->client_cd:'%';
							$stk_cd = $model->stk_cd?$model->stk_cd:'%';
							 
							if($scenario == 'retreverse')
							{
								if($model->movement_type == 'BORWT')
									$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getReturnBorrowSql($client_cd, $stk_cd));
								else if($model->movement_type == 'LENDT')
									$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getReturnLendingSql($client_cd, $stk_cd, $model->movement_type_2==0?'LEND':'LENDPE'));
								else	
									$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getReturnReverseRepoDetailSql($model->repo_ref));				
							}
							else if($scenario == 'settbuy')
                            {
                                $modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getOutstandingBuyDetailSql($client_cd, $stk_cd));
                            }
							else{
                                $modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getOutstandingSellDetailSql($client_cd, $stk_cd));
							}
								
							
							/*$client_name = Client::model()->find("client_cd = '$model->client_cd'");
							
							foreach($modelRetrieve as $row)
							{
								$row->client_name = $client_name->client_name;
							}*/
							
							break;
							
						case 'settle':
							$client_cd = $model->client_cd?$model->client_cd:'%';
							$stk_cd = $model->stk_cd?$model->stk_cd:'%';
							$custodian_cd = $model->withdraw_reason_cd?$model->withdraw_reason_cd:'%';
							
							$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getSettleDetailSql($model->doc_dt, $client_cd, $stk_cd, $custodian_cd));
							
							break;
							
						case 'repo':
							$client_cd = $model->client_cd?$model->client_cd:'%';
							$stk_cd = $model->stk_cd?$model->stk_cd:'%';
							$begin_dt = DateTime::createFromFormat('Y-m-d',$model->doc_dt)->format('Y-m-01');
							
							$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getWithdrawDetailSql($client_cd,$stk_cd,$model->client_type,$begin_dt,$model->doc_dt));
							
							break;
							
						case 'exerciser':
							$client_cd = $model->client_cd?$model->client_cd:'%';
							$stk_cd = $model->stk_cd;
							$begin_dt = DateTime::createFromFormat('Y-m-d',$model->doc_dt)->format('Y-m-01');
							
							$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getExerciserDetailSql($client_cd,$stk_cd,$model->withdraw_dt));
							
							break;
							
						case 'exercisew':
							$client_cd = $model->client_cd?$model->client_cd:'%';
							$stk_cd = $model->stk_cd;
							$begin_dt = DateTime::createFromFormat('Y-m-d',$model->doc_dt)->format('Y-m-01');
							
							$modelRetrieve = Tstkmovement::model()->findAllBySql(Tstkmovement::getWithdrawDetailSql($client_cd,$stk_cd,$model->client_type,$begin_dt,$model->doc_dt));
							
							foreach($modelRetrieve as $row)
							{
								$row->qty = $row->on_hand;
							}
							
							break;
														
						default:
							break;
					}
				}
			}
			else 
			{
			    
				switch($scenario)
				{
					case 'receive':
						$receiveCount = $_POST['receiveCount'];	
						
						$valid = $valid && $receiveCount;

						for($x=0;$x<$receiveCount;$x++)
						{
							$modelReceive[$x] = new Tstkmovement($scenario);
							$modelReceive[$x]->status = 'L';
							$modelReceive[$x]->attributes = $_POST['Tstkmovement']; 
							$modelReceive[$x]->attributes = $_POST['Tstkreceive'][$x+1];
							
							$modelReceive[$x]->doc_rem = str_ireplace('?c',$modelReceive[$x]->client_cd,$modelReceive[$x]->doc_rem);
							$modelReceive[$x]->doc_rem = str_ireplace('?s',$modelReceive[$x]->stk_cd,$modelReceive[$x]->doc_rem);
							$modelReceive[$x]->doc_rem = str_ireplace('?b',$model->withdraw_reason_cd,$modelReceive[$x]->doc_rem);
													
							$valid = $modelReceive[$x]->validate() && $valid;
						}
						
						for($x=0;$valid && $x < $receiveCount;$x++)
						{
							for($y = $x+1;$valid && $y < $receiveCount;$y++)
							{
								if($modelReceive[$x]->client_cd == $modelReceive[$y]->client_cd && $modelReceive[$x]->stk_cd == $modelReceive[$y]->stk_cd)
								{
									$modelReceive[$x]->addError('client_cd','Duplicated Client Code and Stock Code');
									$valid = FALSE;
								}
							}
						}
						
						if($valid)
						{
							$connection  = Yii::app()->db;
							$transaction = $connection->beginTransaction(); 
							
							$success = TRUE;
							
							for($x=0;$success && $x<$receiveCount;$x++)
							{
								if($success && $model->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
								else {
									$success = FALSE;
								}
								$doc_type = $this->getDocType($model->movement_type, $model->movement_type_2, '');
								$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$model->doc_dt','YYYY-MM-DD'),'$doc_type') AS doc_num FROM dual");
								$modelReceive[$x]->doc_num = $result['doc_num'];
								
								if($model->movement_type == 'BORW' || $model->movement_type == 'TDOBUY')
								{
									$modelReceive[$x]->ref_doc_num = 'UNSETTLED';
								}
								else 
								{
									$modelReceive[$x]->ref_doc_num = '';
								}
								
								$modelReceive[$x]->jur_type = $this->getMovementCode($model->movement_type, $model->movement_type_2, '');
								$modelReceive[$x]->seqno = 1;
								
								if($model->movement_type == 'BORW')
									$modelReceive[$x]->s_d_type = 'P';
								else if($model->movement_type == 'TDOBUY')
									$modelReceive[$x]->s_d_type = 'F';
								else
								{
									//RECV
									$modelReceive[$x]->s_d_type = 'C';
								}
								
								$modelReceive[$x]->total_share_qty = $modelReceive[$x]->qty;
								$modelReceive[$x]->withdrawn_share_qty = 0;
								$modelReceive[$x]->db_cr_flg = 'D';
								$modelReceive[$x]->gl_acct_cd = $this->getGlAcctCd($model->movement_type, $model->movement_type_2, '', $modelReceive[$x]->client_cd, $model->doc_dt, $modelReceive[$x]->db_cr_flg);
								
								if($modelReceive[$x]->gl_acct_cd == '')
								{
									$modelReceive[$x]->addError('gl_acct_cd','GL Acct is not found on Secu Acct');
									$success = false;
									break;
								}
								
								$modelReceive[$x]->due_dt_for_cert = $modelReceive[$x]->doc_dt;
								if($model->movement_type == 'TDOBUY')$modelReceive[$x]->due_dt_onhand = $modelReceive[$x]->due_dt_for_cert = $modelReceive[$x]->tender_pay_dt;
								$modelReceive[$x]->doc_stat = 2;
								$totalLot = $this->getTotalLot($modelReceive[$x]->stk_cd, $modelReceive[$x]->qty);
								$modelReceive[$x]->total_lot = $totalLot['totalLot'];
								$modelReceive[$x]->odd_lot_doc = $totalLot['oddLotDoc'];
								$modelReceive[$x]->status = 'L';
								$modelReceive[$x]->manual = 'Y';
								$modelReceive[$x]->broker = $model->withdraw_reason_cd;
								
								if($success && $modelReceive[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelReceive[$x]->doc_num,$modelReceive[$x]->db_cr_flg, $modelReceive[$x]->seqno,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
								else {
									$success = FALSE;
								}
								
								$modelReceive[$x]->seqno = 2;
								$modelReceive[$x]->db_cr_flg = 'C';
								$modelReceive[$x]->gl_acct_cd = $this->getGlAcctCd($model->movement_type, $model->movement_type_2, '', $modelReceive[$x]->client_cd, $model->doc_dt, $modelReceive[$x]->db_cr_flg);
								
								if($success && $modelReceive[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelReceive[$x]->doc_num,$modelReceive[$x]->db_cr_flg, $modelReceive[$x]->seqno,$model->update_date,$model->update_seq,2) > 0)$success = TRUE;
								else {
									$success = FALSE;
								}
							}
							
							if($success)
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success', 'Data Successfully Saved');
								$this->redirect(array('/custody/tstkmovement/index'));
							}
							else {
								$transaction->rollback();
							}
						}
						
						break;
						
					case 'withdraw':
                        //27oct2017 [indra] buat jurnal tender offer
                        $retrieveCount = $_POST['retrieveCount'];   
                         
                        if($model->movement_type=='TDOSEL' && $model->movement_type_2==2)
                        {
                            for($x=0;$x<$retrieveCount;$x++)
                            {
                                $modelRetrieve[$x] = new Tstkmovement;
                                $modelRetrieve[$x]->status='L';
                                $modelRetrieve[$x]->attributes = $_POST['Tstkretrieve'][$x+1];
                                if($modelRetrieve[$x]->qty>0)
                                {
                                    $valid = $modelRetrieve[$x]->validate() && $valid;
                                }
                            }
                       
                         
                            if($valid)
                            {
                               $connection  = Yii::app()->db;
                               $transaction = $connection->beginTransaction(); 
                                
                                $success = TRUE;
                                
                                for($x=0;$success && $x<$retrieveCount;$x++)
                                {
                                    
                                    $old_doc_num='';
                                    $modelRetrieve[$x]->s_d_type = 'F';
                                    $modelRetrieve[$x]->manual = 'Y';
                                    $modelRetrieve[$x]->doc_stat = 2;
                                    $modelRetrieve[$x]->broker = $model->withdraw_reason_cd;
                                    $modelRetrieve[$x]->doc_dt=$model->doc_dt;
                                    $modelRetrieve[$x]->due_dt_for_cert =$model->doc_dt ;
                                    $modelRetrieve[$x]->doc_rem = $model->doc_rem;
                                    for($y=0;$modelRetrieve[$x]->qty>0 && $y<2;$y++)
                                    {
                                        if($success && $model->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
                                        else {
                                            $success = FALSE;
                                        }
                                    
                                        $doc_type = $this->getDocType($model->movement_type, $y, '');
                                        $result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$model->doc_dt','YYYY-MM-DD'),'$doc_type') AS doc_num FROM dual");
                                        $modelRetrieve[$x]->doc_num = $result['doc_num'];
                                       
                                       if($y==0)
                                       {
                                           $old_doc_num=$modelRetrieve[$x]->doc_num;
                                           $modelRetrieve[$x]->ref_doc_num ='SETTLED';
                                           $modelRetrieve[$x]->total_share_qty =0;
                                           $modelRetrieve[$x]->withdrawn_share_qty =  $modelRetrieve[$x]->qty;   
                                       }
                                       else {
                                           $modelRetrieve[$x]->ref_doc_num =$old_doc_num;   
                                           $modelRetrieve[$x]->total_share_qty = $modelRetrieve[$x]->qty;
                                           $modelRetrieve[$x]->withdrawn_share_qty = 0;
                                       }
                                        $modelRetrieve[$x]->jur_type = $this->getMovementCode($model->movement_type, $y, '');
                                        $totalLot = $this->getTotalLot($modelRetrieve[$x]->stk_cd, $modelRetrieve[$x]->qty);
                                        $modelRetrieve[$x]->total_lot = $totalLot['totalLot'];
                                        $modelRetrieve[$x]->odd_lot_doc = $totalLot['oddLotDoc'];
                                        $modelRetrieve[$x]->price = $model->price;
                                          
                                        
                                        for ($i=0;$i<2;$i++)
                                        {
                                            $modelRetrieve[$x]->seqno=$i+1;
                                            $modelRetrieve[$x]->db_cr_flg= $i==0?'D':'C';
                                            $modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($model->movement_type, $y, '', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);      
                                            
                                            if($modelRetrieve[$x]->gl_acct_cd == '')
                                            {
                                                $modelRetrieve[$x]->addError('gl_acct_cd','GL Acct is not found on Secu Acct');
                                                $success = false;
                                                break;
                                            }
                                                    
                                            if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,$i+1) > 0)$success = TRUE;
                                            else {
                                                $success = FALSE;
                                            }
                                        }
                                    }//end per journal
                                }
                                
                                if($success)
                                {
                                    $transaction->commit();
                                    Yii::app()->user->setFlash('success', 'Data Successfully Saved');
                                    $this->redirect(array('/custody/tstkmovement/index'));
                                }
                                else {
                                    $transaction->rollback();
                                }
                            }
                        break;
                         }
                        
                        
					case 'exercisew':
						$retrieveCount = $_POST['retrieveCount'];	
						
						$valid = $valid && $retrieveCount;
						
						/*-------------- OLD CHECK RATIO -------------*/
						/*$totalQty = 0;
						
						if($model->client_cd)$clientDetail = DAO::queryRowSql(Tstkmovement::getClientTypeSql($model->client_cd));*/
						
						for($x=0;$x<$retrieveCount;$x++)
						{
							$modelRetrieve[$x] = new Tstkmovement($scenario);
							$modelRetrieve[$x]->status = 'L';
							$modelRetrieve[$x]->attributes = $_POST['Tstkmovement']; 
							$modelRetrieve[$x]->attributes = $_POST['Tstkretrieve'][$x+1];
							
							$modelRetrieve[$x]->doc_rem = str_ireplace('?c',$modelRetrieve[$x]->client_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?s',$modelRetrieve[$x]->stk_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?b',$model->withdraw_reason_cd,$modelRetrieve[$x]->doc_rem);
							
							/*if($model->client_cd)
							{
								$modelRetrieve[$x]->same_client_flg = true;
								
								if($clientDetail['client_type'] == 'M')
								{
									$client_cd = $modelRetrieve[$x]->client_cd;
									$stk_cd = $modelRetrieve[$x]->stk_cd;
									$qty = str_replace(',','',$modelRetrieve[$x]->qty);
									
									$porto_disc = DAO::queryRowSql("SELECT F_CALC_PORTFOLIO_DISCT('$client_cd','$stk_cd','$qty') qty FROM dual");
									
									$totalQty += $porto_disc['qty'];
								}
							}
							else {
								$modelRetrieve[$x]->same_client_flg = false;
							}*/
							
							if($modelRetrieve[$x]->qty > 0)$valid = $modelRetrieve[$x]->validate() && $valid;
						}
						
						/*if($model->client_cd && $clientDetail['client_type'] == 'M')
						{
							$valid = $this->checkRatio($model, $model->client_cd, $totalQty) && $valid;
						}*/
						/*-------------- OLD CHECK RATIO -------------*/
						
						if($valid)
						{
							$connection  = Yii::app()->db;
							$transaction = $connection->beginTransaction(); 
							
							$success = TRUE;
							$checked = FALSE;
							
							for($x=0;$success && $x<$retrieveCount;$x++)
							{
								if($modelRetrieve[$x]->qty > 0)
								{
									$checked = TRUE;
									
									if($success && $model->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									$doc_type = $this->getDocType($model->movement_type, $model->movement_type_2, '');
									$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$model->doc_dt','YYYY-MM-DD'),'$doc_type') AS doc_num FROM dual");
									$modelRetrieve[$x]->doc_num = $result['doc_num'];
									if($model->movement_type == 'LEND' || $model->movement_type == 'TDOSEL')
									{
										$modelRetrieve[$x]->ref_doc_num = 'UNSETTLED';
									}
									else 
									{
										$modelRetrieve[$x]->ref_doc_num = '';
									}
									
									$modelRetrieve[$x]->jur_type = $this->getMovementCode($model->movement_type, $model->movement_type_2, '');
									$modelRetrieve[$x]->seqno = 1;
									
									if($model->movement_type == 'LEND')
										$modelRetrieve[$x]->s_d_type = 'L';
									else if($model->movement_type == 'TDOSEL')
										$modelRetrieve[$x]->s_d_type = 'F';
									else
										$modelRetrieve[$x]->s_d_type = 'C';
									
									if($model->movement_type == 'TDOSEL' && $model->movement_type_2 == 1)
									{
										$modelRetrieve[$x]->total_share_qty = $modelRetrieve[$x]->qty;
										$modelRetrieve[$x]->withdrawn_share_qty = 0;
									}
									else
									{
										$modelRetrieve[$x]->total_share_qty = 0;
										$modelRetrieve[$x]->withdrawn_share_qty = $modelRetrieve[$x]->qty;
									}
									
									$modelRetrieve[$x]->db_cr_flg = 'D';
									$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($model->movement_type, $model->movement_type_2, '', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
									
									if($modelRetrieve[$x]->gl_acct_cd == '')
									{
										$modelRetrieve[$x]->addError('gl_acct_cd','GL Acct is not found on Secu Acct');
										$success = false;
										break;
									}
									
									if($model->movement_type != 'TDOSEL')
									{
										$modelRetrieve[$x]->price = $modelRetrieve[$x]->avg_price;
									}
									
									$modelRetrieve[$x]->due_dt_for_cert = $modelRetrieve[$x]->doc_dt;
									if($model->movement_type == 'TDOSEL')$modelRetrieve[$x]->due_dt_onhand = $modelRetrieve[$x]->due_dt_for_cert = $modelRetrieve[$x]->tender_pay_dt;
									$modelRetrieve[$x]->doc_stat = 2;
									$totalLot = $this->getTotalLot($modelRetrieve[$x]->stk_cd, $modelRetrieve[$x]->qty);
									$modelRetrieve[$x]->total_lot = $totalLot['totalLot'];
									$modelRetrieve[$x]->odd_lot_doc = $totalLot['oddLotDoc'];
									$modelRetrieve[$x]->status = 'L';
									$modelRetrieve[$x]->manual = 'Y';
									$modelRetrieve[$x]->broker = $model->withdraw_reason_cd;
									
									if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									$modelRetrieve[$x]->seqno = 2;
									$modelRetrieve[$x]->db_cr_flg = 'C';
									$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($model->movement_type, $model->movement_type_2, '', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
									
									if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,2) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
								}
							}

							if($success && $checked)
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success', 'Data Successfully Saved');
								$this->redirect(array('/custody/tstkmovement/index'));
							}
							else {
								$transaction->rollback();
							}
						}
						
						break;
					
					case 'move':
						$retrieveCount = $_POST['retrieveCount'];	
						
						$valid = $valid && $retrieveCount;
						
						/*-------------- OLD CHECK RATIO -------------*/
						/*$totalQty = 0;
						
						if($model->client_cd)$clientDetail = DAO::queryRowSql(Tstkmovement::getClientTypeSql($model->client_cd));*/

						for($x=0;$x<$retrieveCount;$x++)
						{
							$modelRetrieve[$x] = new Tstkmovement($scenario);
							$modelRetrieve[$x]->status = 'L';
							$modelRetrieve[$x]->attributes = $_POST['Tstkmovement']; 
							$modelRetrieve[$x]->attributes = $_POST['Tstkretrieve'][$x+1];
							
							$modelRetrieve[$x]->doc_rem = str_ireplace('?c',$modelRetrieve[$x]->client_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?s',$modelRetrieve[$x]->stk_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?b',$model->withdraw_reason_cd,$modelRetrieve[$x]->doc_rem);
							
							/*if($model->client_cd && $clientDetail['client_type'] == 'M')
							{
								$modelRetrieve[$x]->same_client_flg = true;
								
								if($clientDetail['client_type'] == 'M')
								{
									$client_cd = $modelRetrieve[$x]->client_cd;
									$stk_cd = $modelRetrieve[$x]->stk_cd;
									$qty = str_replace(',','',$modelRetrieve[$x]->qty);
									
									$porto_disc = DAO::queryRowSql("SELECT F_CALC_PORTFOLIO_DISCT('$client_cd','$stk_cd','$qty') qty FROM dual");
				
									$totalQty += $porto_disc['qty'];
								}
							}
							else {
								$modelRetrieve[$x]->same_client_flg = false;
							}*/
							
							if($modelRetrieve[$x]->qty > 0)$valid = $modelRetrieve[$x]->validate() && $valid;
						}

						/*if($model->client_cd && $clientDetail['client_type'] == 'M')
						{
							$valid = $this->checkRatioMove($model, $model->client_cd, $totalQty) && $valid;
						}*/
						/*-------------- OLD CHECK RATIO -------------*/
						
						if($valid)
						{
							$connection  = Yii::app()->db;
							$transaction = $connection->beginTransaction(); 
							
							$success = TRUE;
							$checked = FALSE;
							
							for($x=0;$success && $x<$retrieveCount;$x++)
							{
								if($modelRetrieve[$x]->qty > 0)
								{
									$checked = TRUE;
									
									if($success && $model->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									/*----RECEIVE----*/ 
									
									$temp = $modelRetrieve[$x]->client_cd;
									$modelRetrieve[$x]->client_cd = $modelRetrieve[$x]->client_to;
									$modelRetrieve[$x]->movement_type = 'RECV';
									
									$doc_type = $this->getDocType($modelRetrieve[$x]->movement_type, $model->movement_type_2, '');
									$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$model->doc_dt','YYYY-MM-DD'),'$doc_type') AS doc_num FROM dual");
									$modelRetrieve[$x]->doc_num = $result['doc_num'];
									$modelRetrieve[$x]->ref_doc_num = '';
									$modelRetrieve[$x]->jur_type = $this->getMovementCode($modelRetrieve[$x]->movement_type, $model->movement_type_2, '');
									$modelRetrieve[$x]->seqno = 1;
									$modelRetrieve[$x]->s_d_type = 'C';
									$modelRetrieve[$x]->total_share_qty = $modelRetrieve[$x]->qty;
									$modelRetrieve[$x]->withdrawn_share_qty = 0;
									$modelRetrieve[$x]->db_cr_flg = 'D';
									$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd('RECV', $model->movement_type_2, '', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
									
									if($modelRetrieve[$x]->gl_acct_cd == '')
									{
										$modelRetrieve[$x]->addError('gl_acct_cd','GL Acct is not found on Secu Acct');
										$success = false;
										break;
									}
									
									$modelRetrieve[$x]->price = $modelRetrieve[$x]->avg_price;
									$modelRetrieve[$x]->due_dt_for_cert = $modelRetrieve[$x]->doc_dt;
									//$modelRetrieve[$x]->due_dt_onhand = $modelRetrieve[$x]->doc_dt;
									$modelRetrieve[$x]->doc_stat = 2;
									$totalLot = $this->getTotalLot($modelRetrieve[$x]->stk_cd, $modelRetrieve[$x]->qty);
									$modelRetrieve[$x]->total_lot = $totalLot['totalLot'];
									$modelRetrieve[$x]->odd_lot_doc = $totalLot['oddLotDoc'];
									$modelRetrieve[$x]->status = 'L';
									$modelRetrieve[$x]->manual = 'Y';
									$modelRetrieve[$x]->broker = $model->withdraw_reason_cd;
									
									if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									$modelRetrieve[$x]->seqno = 2;
									$modelRetrieve[$x]->db_cr_flg = 'C';
									$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd('RECV', $model->movement_type_2, '', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
									
									if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,2) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									/*----WITHDRAW----*/ 
									
									$modelRetrieve[$x]->client_cd = $temp;
									$modelRetrieve[$x]->movement_type = 'WHDR';
									
									//$doc_type = $this->getDocType($modelRetrieve[$x]->movement_type, $model->movement_type_2, '');
									//$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$model->doc_dt','YYYY-MM-DD'),'$doc_type') AS doc_num FROM dual");
									//$modelRetrieve[$x]->doc_num = $result['doc_num'];
									$modelRetrieve[$x]->doc_num = str_replace('RSN','WSN',$modelRetrieve[$x]->doc_num);
									$modelRetrieve[$x]->ref_doc_num = '';
									$modelRetrieve[$x]->jur_type = $this->getMovementCode($modelRetrieve[$x]->movement_type, $model->movement_type_2, '');
									$modelRetrieve[$x]->seqno = 1;
									$modelRetrieve[$x]->s_d_type = 'C';
									$modelRetrieve[$x]->total_share_qty = 0;
									$modelRetrieve[$x]->withdrawn_share_qty = $modelRetrieve[$x]->qty;
									$modelRetrieve[$x]->db_cr_flg = 'D';
									$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd('WHDR', $model->movement_type_2, '', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
									
									if($modelRetrieve[$x]->gl_acct_cd == '')
									{
										$modelRetrieve[$x]->addError('gl_acct_cd','GL Acct is not found on Secu Acct');
										$success = false;
										break;
									}
									
									$modelRetrieve[$x]->price = $modelRetrieve[$x]->avg_price;
									$modelRetrieve[$x]->due_dt_for_cert = $modelRetrieve[$x]->doc_dt;
									//$modelRetrieve[$x]->due_dt_onhand = $modelRetrieve[$x]->doc_dt;
									$modelRetrieve[$x]->doc_stat = 2;
									$totalLot = $this->getTotalLot($modelRetrieve[$x]->stk_cd, $modelRetrieve[$x]->qty);
									$modelRetrieve[$x]->total_lot = $totalLot['totalLot'];
									$modelRetrieve[$x]->odd_lot_doc = $totalLot['oddLotDoc'];
									$modelRetrieve[$x]->status = 'L';
									$modelRetrieve[$x]->manual = 'Y';
									$modelRetrieve[$x]->broker = $model->withdraw_reason_cd;
									
									if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,3) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									$modelRetrieve[$x]->seqno = 2;
									$modelRetrieve[$x]->db_cr_flg = 'C';
									$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd('WHDR', $model->movement_type_2, '', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
									
									if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,4) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
								}
							}
							
							if($success && $checked)
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success', 'Data Successfully Saved');
								$this->redirect(array('/custody/tstkmovement/index'));
							}
							else {
								$transaction->rollback();
							}
						}

						break; 
					
					case 'exercise':
					case 'exercise2':
					case 'exercise3':
						$retrieveCount = $_POST['retrieveCount'];	
						
						$valid = $valid && $retrieveCount;

						for($x=0;$x<$retrieveCount;$x++)
						{
							$modelRetrieve[$x] = new Tstkmovement($scenario);
							$modelRetrieve[$x]->status = 'L';
							$modelRetrieve[$x]->attributes = $_POST['Tstkmovement']; 
							$modelRetrieve[$x]->attributes = $_POST['Tstkretrieve'][$x+1];
							
							$modelRetrieve[$x]->doc_rem = str_ireplace('?c',$modelRetrieve[$x]->client_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?s',$modelRetrieve[$x]->stk_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?b',$model->withdraw_reason_cd,$modelRetrieve[$x]->doc_rem);
							
							if($modelRetrieve[$x]->qty > 0)$valid = $modelRetrieve[$x]->validate() && $valid;
						}
						
						if($valid)
						{
							$connection  = Yii::app()->db;
							$transaction = $connection->beginTransaction(); 
							
							$success = TRUE;
							$checked = FALSE;
							
							for($x=0;$success && $x<$retrieveCount;$x++)
							{
								if($modelRetrieve[$x]->qty > 0)
								{
									$checked = TRUE;
									
									if($success && $model->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									$record_seq = 1;
									
									if($scenario == 'exercise2' || $scenario == 'exercise3')
									{
										//STOCK EQUI
										$loop = $scenario == 'exercise2'?1:2;
										
										for($y=0;$y<$loop;$y++)
										{
											$temp = $modelRetrieve[$x]->stk_cd;	
											$modelRetrieve[$x]->stk_cd = $modelRetrieve[$x]->stk_equi;
																				
											$doc_type = $this->getDocType($model->movement_type, $model->movement_type_2, $scenario=='exercise2'?'BELI':$y+1);
											$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$model->doc_dt','YYYY-MM-DD'),'$doc_type') AS doc_num FROM dual");
											$modelRetrieve[$x]->doc_num = $result['doc_num'];
											$modelRetrieve[$x]->ref_doc_num = '';
											$modelRetrieve[$x]->jur_type = $this->getMovementCode($model->movement_type, $model->movement_type_2, $scenario=='exercise2'?'BELI':$y+1);
											$modelRetrieve[$x]->seqno = 1;
											$modelRetrieve[$x]->s_d_type = 'E';
											$modelRetrieve[$x]->total_share_qty = $modelRetrieve[$x]->qty;
											$modelRetrieve[$x]->withdrawn_share_qty = 0;
											$modelRetrieve[$x]->db_cr_flg = 'D';
											$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($model->movement_type, $model->movement_type_2, $scenario=='exercise2'?'BELI':$y+1, $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
											
											if($modelRetrieve[$x]->gl_acct_cd == '')
											{
												$modelRetrieve[$x]->addError('gl_acct_cd','GL Acct is not found on Secu Acct');
												$success = false;
												break;
											}
											
											$modelRetrieve[$x]->price = $modelRetrieve[$x]->avg_price;
											$modelRetrieve[$x]->due_dt_for_cert = $modelRetrieve[$x]->doc_dt;
											//$modelRetrieve[$x]->due_dt_onhand = $modelRetrieve[$x]->doc_dt;
											$modelRetrieve[$x]->doc_stat = 2;
											$totalLot = $this->getTotalLot($modelRetrieve[$x]->stk_cd, $modelRetrieve[$x]->qty);
											$modelRetrieve[$x]->total_lot = $totalLot['totalLot'];
											$modelRetrieve[$x]->odd_lot_doc = $totalLot['oddLotDoc'];
											$modelRetrieve[$x]->status = 'L';
											$modelRetrieve[$x]->manual = 'Y';
											$modelRetrieve[$x]->broker = $model->withdraw_reason_cd;
											
											$create = TRUE;
											
											if($modelRetrieve[$x]->jur_type == 'EXERRECV1')
											{
												$client_cd = $modelRetrieve[$x]->client_cd;
												$other_1 = DAO::queryRowSql("SELECT TRIM(other_1) other_1 FROM MST_COMPANY");
												$type_1 = DAO::queryRowSql("SELECT client_type_1 FROM MST_CLIENT WHERE client_cd = '$client_cd'");
											
												if($client_cd ==  $other_1['other_1'] || $type_1['client_type_1'] == 'H')
												{
													$create = FALSE;
												}
											}	
											
											if($create)
											{
												if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,$record_seq++) > 0)$success = TRUE;
												else {
													$success = FALSE;
												}
												
												$modelRetrieve[$x]->seqno = 2;
												$modelRetrieve[$x]->db_cr_flg = 'C';
												$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($model->movement_type, $model->movement_type_2, $scenario=='exercise2'?'BELI':$y+1, $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
												
												if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,$record_seq++) > 0)$success = TRUE;
												else {
													$success = FALSE;
												}
											}
																						
											$modelRetrieve[$x]->stk_cd = $temp;
										}
									}
									
									if($scenario == 'exercise' || $scenario == 'exercise2')
									{							
										// STOCK RIGHT/WARRANT
										$modelRetrieve[$x]->stk_cd = $model->stk_cd;
										
										$doc_type = $this->getDocType($model->movement_type, $model->movement_type_2, 'SERAH');
										$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$model->doc_dt','YYYY-MM-DD'),'$doc_type') AS doc_num FROM dual");
										$modelRetrieve[$x]->doc_num = $result['doc_num'];
										
										$modelRetrieve[$x]->ref_doc_num = '';
										$modelRetrieve[$x]->jur_type = $this->getMovementCode($model->movement_type, $model->movement_type_2, 'SERAH');
										$modelRetrieve[$x]->seqno = 1;
										$modelRetrieve[$x]->s_d_type = 'E';
										$modelRetrieve[$x]->total_share_qty = 0;
										$modelRetrieve[$x]->withdrawn_share_qty = $modelRetrieve[$x]->qty;
										$modelRetrieve[$x]->db_cr_flg = 'D';
										$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($model->movement_type, $model->movement_type_2, 'SERAH', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
										
										if($modelRetrieve[$x]->gl_acct_cd == '')
										{
											$modelRetrieve[$x]->addError('gl_acct_cd','GL Acct is not found on Secu Acct');
											$success = false;
											break;
										}
										
										$modelRetrieve[$x]->price = $modelRetrieve[$x]->avg_price;
										$modelRetrieve[$x]->due_dt_for_cert = $modelRetrieve[$x]->doc_dt;
										//$modelRetrieve[$x]->due_dt_onhand = $modelRetrieve[$x]->doc_dt;
										$modelRetrieve[$x]->doc_stat = 2;
										$totalLot = $this->getTotalLot($modelRetrieve[$x]->stk_cd, $modelRetrieve[$x]->qty);
										$modelRetrieve[$x]->total_lot = $totalLot['totalLot'];
										$modelRetrieve[$x]->odd_lot_doc = $totalLot['oddLotDoc'];
										$modelRetrieve[$x]->status = 'L';
										$modelRetrieve[$x]->manual = 'Y';
										$modelRetrieve[$x]->broker = $model->withdraw_reason_cd;
										
										if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,$record_seq++) > 0)$success = TRUE;
										else {
											$success = FALSE;
										}
										
										$modelRetrieve[$x]->seqno = 2;
										$modelRetrieve[$x]->db_cr_flg = 'C';
										$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($model->movement_type, $model->movement_type_2, 'SERAH', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
										
										if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,$record_seq++) > 0)$success = TRUE;
										else {
											$success = FALSE;
										}
										
										if($modelRetrieve[$x]->jur_type == 'EXERT0')
										{
											$client_cd = $modelRetrieve[$x]->client_cd;
											$other_1 = DAO::queryRowSql("SELECT TRIM(other_1) other_1 FROM MST_COMPANY");
											$type_1 = DAO::queryRowSql("SELECT client_type_1 FROM MST_CLIENT WHERE client_cd = '$client_cd'");
											
											if($client_cd ==  $other_1['other_1'] || $type_1['client_type_1'] == 'H')
											{
												$success = FALSE;
												$modelRetrieve[$x]->addError('client_cd','Exercise tahap T0 tidak berlaku untuk client type H');
												break;
											}
										}
									}
								}
							}

							if($success && $checked)
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success', 'Data Successfully Saved');
								$this->redirect(array('/custody/tstkmovement/index'));
							}
							else {
								$transaction->rollback();
							}
						}						
						
						break; 
						
					case 'repo':
					case 'reverse':
						$retrieveCount = $_POST['retrieveCount'];	
						
						$valid = $valid && $retrieveCount;

						for($x=0;$x<$retrieveCount;$x++)
						{
							$modelRetrieve[$x] = new Tstkmovement($scenario);
							$modelRetrieve[$x]->status = 'L';
							$modelRetrieve[$x]->attributes = $_POST['Tstkmovement']; 
							$modelRetrieve[$x]->attributes = $_POST['Tstkretrieve'][$x+1];
							
							$modelRetrieve[$x]->doc_rem = str_ireplace('?c',$modelRetrieve[$x]->client_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?s',$modelRetrieve[$x]->stk_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?b',$model->withdraw_reason_cd,$modelRetrieve[$x]->doc_rem);
							
							if($modelRetrieve[$x]->qty > 0)$valid = $modelRetrieve[$x]->validate() && $valid;
						}
						
						if($valid)
						{
							$connection  = Yii::app()->db;
							$transaction = $connection->beginTransaction(); 
							
							$success = TRUE;
							$checked = FALSE;
							
							$repo = Trepo::model()->find("repo_num = '$model->repo_ref'");
							
							for($x=0;$success && $x<$retrieveCount;$x++)
							{
								if($modelRetrieve[$x]->qty > 0)
								{
									$checked = TRUE;
									
									if($success && $model->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
																		
									$modelRetrieve[$x]->penghentian_pengakuan = $repo->penghentian_pengakuan;
									$modelRetrieve[$x]->serah_saham = $repo->serah_saham;
									
									$doc_type = $this->getDocType($model->movement_type, $model->movement_type_2, '');
									$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$model->doc_dt','YYYY-MM-DD'),'$doc_type') AS doc_num FROM dual");
									$modelRetrieve[$x]->doc_num = $result['doc_num'];
									$modelRetrieve[$x]->ref_doc_num = 'UNSETTLED';
									$modelRetrieve[$x]->jur_type = $this->getMovementCode($model->movement_type, $modelRetrieve[$x]->penghentian_pengakuan, $modelRetrieve[$x]->serah_saham);
									
									if($modelRetrieve[$x]->jur_type == false)
									{
										$success= false;
										Yii::app()->user->setFlash('error','No journal generated');
										continue;
									}
									
									$modelRetrieve[$x]->seqno = 1;
									$modelRetrieve[$x]->s_d_type = $scenario=='repo'?'I':'J';
									$modelRetrieve[$x]->total_share_qty = $modelRetrieve[$x]->qty;
									$modelRetrieve[$x]->withdrawn_share_qty = 0;
									$modelRetrieve[$x]->db_cr_flg = 'D';
									$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($modelRetrieve[$x]->movement_type, $modelRetrieve[$x]->penghentian_pengakuan, $modelRetrieve[$x]->serah_saham, $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
									
									if($modelRetrieve[$x]->gl_acct_cd == '')
									{
										$modelRetrieve[$x]->addError('gl_acct_cd','GL Acct is not found on Secu Acct');
										$success = false;
										break;
									}
									
									$modelRetrieve[$x]->price = 0;
									$modelRetrieve[$x]->due_dt_for_cert = $modelRetrieve[$x]->doc_dt;
									//$modelRetrieve[$x]->due_dt_onhand = $modelRetrieve[$x]->doc_dt;
									$modelRetrieve[$x]->doc_stat = 2;
									$totalLot = $this->getTotalLot($modelRetrieve[$x]->stk_cd, $modelRetrieve[$x]->qty);
									$modelRetrieve[$x]->total_lot = $totalLot['totalLot'];
									$modelRetrieve[$x]->odd_lot_doc = $totalLot['oddLotDoc'];
									$modelRetrieve[$x]->status = 'L';
									$modelRetrieve[$x]->manual = 'Y';
									$modelRetrieve[$x]->broker = $model->withdraw_reason_cd;
									
									if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									$modelRetrieve[$x]->seqno = 2;
									$modelRetrieve[$x]->db_cr_flg = 'C';
									$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($modelRetrieve[$x]->movement_type, $modelRetrieve[$x]->penghentian_pengakuan, $modelRetrieve[$x]->serah_saham, $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
									
									if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,2) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
								}
							}
							
							if($success && $checked)
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success', 'Data Successfully Saved');
								$this->redirect(array('/custody/tstkmovement/index'));
							}
							else {
								$transaction->rollback();
							}
						}
						
						break;
						
					case 'retreverse':
					case 'settbuy':
					case 'settsell':
						$retrieveCount = $_POST['retrieveCount'];	
						
						$valid = $valid && $retrieveCount;

						for($x=0;$x<$retrieveCount;$x++)
						{
							$modelRetrieve[$x] = new Tstkmovement($scenario);
							$modelRetrieve[$x]->status = 'L';
							$modelRetrieve[$x]->attributes = $_POST['Tstkmovement']; 
							$modelRetrieve[$x]->attributes = $_POST['Tstkretrieve'][$x+1];
							
							$modelRetrieve[$x]->doc_rem = str_ireplace('?c',$modelRetrieve[$x]->client_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?s',$modelRetrieve[$x]->stk_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?b',$model->withdraw_reason_cd,$modelRetrieve[$x]->doc_rem);
							
							if($modelRetrieve[$x]->check == 'Y')$valid = $modelRetrieve[$x]->validate() && $valid;
						}
						
						if($valid)
						{
							$connection  = Yii::app()->db;
							$transaction = $connection->beginTransaction(); 
							
							$success = TRUE;
							$checked = FALSE;
							
							$repo = Trepo::model()->find("repo_num = '$model->repo_ref'");
							
							for($x=0;$success && $x<$retrieveCount;$x++)
							{
								if($modelRetrieve[$x]->check == 'Y')
								{
									$checked = TRUE;
									
									if($success && $model->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									if($model->movement_type == 'RPOT'||$model->movement_type == 'RRPOT')
									{
										$modelRetrieve[$x]->penghentian_pengakuan = $repo->penghentian_pengakuan;
										$modelRetrieve[$x]->serah_saham = $repo->serah_saham;
									}
									
									$temp = $modelRetrieve[$x]->ref_doc_num = $modelRetrieve[$x]->doc_num;
									
									$loop = $scenario == 'settbuy'?2:1;
									
									$record_seq = 1;
										
									for($y=0;$y<$loop;$y++)
									{
										$doc_type = $this->getDocType($model->movement_type, $model->movement_type_2, '');
										$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$model->doc_dt','YYYY-MM-DD'),'$doc_type') AS doc_num FROM dual");
										$modelRetrieve[$x]->doc_num = $result['doc_num'];
										$modelRetrieve[$x]->doc_dt = $model->doc_dt;
										
										$modelRetrieve[$x]->jur_type = $this->getMovementCode(
																			$model->movement_type, 
																			$model->movement_type == 'RPOT'||$model->movement_type == 'RRPOT'?$modelRetrieve[$x]->penghentian_pengakuan:$model->movement_type_2, 
																			$model->movement_type == 'RPOT'||$model->movement_type == 'RRPOT'?$modelRetrieve[$x]->serah_saham:$y+1
																		);
										
										if($modelRetrieve[$x]->jur_type == false)
										{
											$success= false;
											Yii::app()->user->setFlash('error','No journal generated');
											continue;
										}
										
										$modelRetrieve[$x]->seqno = 1;
										
										if($model->movement_type == 'RPOT')
											$modelRetrieve[$x]->s_d_type = 'I';
										else if($model->movement_type == 'RRPOT')
											$modelRetrieve[$x]->s_d_type = 'J';
										else if($model->movement_type == 'BORWT')
											$modelRetrieve[$x]->s_d_type = 'P';
										else if($model->movement_type == 'LENDT')
											$modelRetrieve[$x]->s_d_type = 'L';
										else 
											$modelRetrieve[$x]->s_d_type = 'F';
										
										if($doc_type != 'WSN')
										{
											$modelRetrieve[$x]->total_share_qty = $modelRetrieve[$x]->qty;
											$modelRetrieve[$x]->withdrawn_share_qty = 0;
										}
										else 
										{
											$modelRetrieve[$x]->total_share_qty = 0;
											$modelRetrieve[$x]->withdrawn_share_qty = $modelRetrieve[$x]->qty;
										}
										
										$modelRetrieve[$x]->db_cr_flg = 'D';
										$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd(
																			$model->movement_type, 
																			$model->movement_type == 'RPOT'||$model->movement_type == 'RRPOT'?$modelRetrieve[$x]->penghentian_pengakuan:$model->movement_type_2, 
																			$model->movement_type == 'RPOT'||$model->movement_type == 'RRPOT'?$modelRetrieve[$x]->serah_saham:$y+1,
																			$modelRetrieve[$x]->client_cd, 
																			$model->doc_dt, 
																			$modelRetrieve[$x]->db_cr_flg
																		);
																		
										if($modelRetrieve[$x]->gl_acct_cd == '')
										{
											$modelRetrieve[$x]->addError('gl_acct_cd','GL Acct is not found on Secu Acct');
											$success = false;
											break;
										}
											
										if($scenario != 'settbuy' && $scenario != 'settsell')$modelRetrieve[$x]->price = 0;
										$modelRetrieve[$x]->due_dt_for_cert = $modelRetrieve[$x]->doc_dt;
										//$modelRetrieve[$x]->due_dt_onhand = $modelRetrieve[$x]->doc_dt;
										$modelRetrieve[$x]->doc_stat = 2;
										$totalLot = $this->getTotalLot($modelRetrieve[$x]->stk_cd, $modelRetrieve[$x]->qty);
										$modelRetrieve[$x]->total_lot = $totalLot['totalLot'];
										$modelRetrieve[$x]->odd_lot_doc = $totalLot['oddLotDoc'];
										$modelRetrieve[$x]->status = 'L';
										$modelRetrieve[$x]->manual = 'Y';
										$modelRetrieve[$x]->broker = $model->withdraw_reason_cd;
										
										if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,$record_seq++) > 0)$success = TRUE;
										else {
											$success = FALSE;
										}
										
										$modelRetrieve[$x]->seqno = 2;
										$modelRetrieve[$x]->db_cr_flg = 'C';
										$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd(
																			$model->movement_type, 
																			$model->movement_type == 'RPOT'||$model->movement_type == 'RRPOT'?$modelRetrieve[$x]->penghentian_pengakuan:$model->movement_type_2, 
																			$model->movement_type == 'RPOT'||$model->movement_type == 'RRPOT'?$modelRetrieve[$x]->serah_saham:$y+1,
																			$modelRetrieve[$x]->client_cd, 
																			$model->doc_dt, 
																			$modelRetrieve[$x]->db_cr_flg
																		);
										
										if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,$record_seq++) > 0)$success = TRUE;
										else {
											$success = FALSE;
										}
									}
									
									$modelRetrieve[$x]->doc_num = $temp;
								}
							}
							
							if($success && $checked)
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success', 'Data Successfully Saved');
								$this->redirect(array('/custody/tstkmovement/index'));
							}
							else {
								$transaction->rollback();
							}
						}
						
						break;
						
					case 'settle':
						$retrieveCount = $_POST['retrieveCount'];	
						
						$valid = $valid && $retrieveCount;

						for($x=0;$x<$retrieveCount;$x++)
						{
							$modelRetrieve[$x] = new Tstkmovement($scenario);
							$modelRetrieve[$x]->status = 'L';
							$modelRetrieve[$x]->attributes = $_POST['Tstkmovement']; 
							$modelRetrieve[$x]->attributes = $_POST['Tstkretrieve'][$x+1];
							
							if(!$modelRetrieve[$x]->withdraw_reason_cd)
							{
								$result = DAO::queryRowSql("SELECT custodian_cd FROM MST_CLIENT WHERE client_cd = '".$modelRetrieve[$x]->client_cd."'");
								$modelRetrieve[$x]->withdraw_reason_cd = $result['custodian_cd'];
							}
							
							$modelRetrieve[$x]->doc_rem = str_ireplace('?c',$modelRetrieve[$x]->client_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?s',$modelRetrieve[$x]->stk_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?b',$modelRetrieve[$x]->withdraw_reason_cd,$modelRetrieve[$x]->doc_rem);
							
							if($modelRetrieve[$x]->check == 'Y')$valid = $modelRetrieve[$x]->validate() && $valid;
						}
						
						if($valid)
						{
							$connection  = Yii::app()->db;
							$transaction = $connection->beginTransaction(); 
							
							$success = TRUE;
							$checked = FALSE;
							
							for($x=0;$success && $x<$retrieveCount;$x++)
							{
								if($modelRetrieve[$x]->check == 'Y')
								{
									$checked = TRUE;
									
									if($success && $model->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									if($modelRetrieve[$x]->belijual == 'BELI')
									{
										$modelRetrieve[$x]->movement_type = 'WHDR';
										$modelRetrieve[$x]->total_share_qty = 0;
										$modelRetrieve[$x]->withdrawn_share_qty = $modelRetrieve[$x]->qty;
										
										$doc_type = $this->getDocType($model->movement_type, 'W', '');
									}
									else
									{
										$modelRetrieve[$x]->movement_type = 'RECV';
										$modelRetrieve[$x]->total_share_qty = $modelRetrieve[$x]->qty;
										$modelRetrieve[$x]->withdrawn_share_qty = 0;
										
										$doc_type = $this->getDocType($model->movement_type, 'R', '');
									}
									
									$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$model->doc_dt','YYYY-MM-DD'),'$doc_type') AS doc_num FROM dual");
									$modelRetrieve[$x]->doc_num = $result['doc_num'];
									$modelRetrieve[$x]->ref_doc_num = '';
									$modelRetrieve[$x]->jur_type = $this->getMovementCode($modelRetrieve[$x]->movement_type, 0, '');
									$modelRetrieve[$x]->seqno = 1;
									$modelRetrieve[$x]->s_d_type = 'U';
									$modelRetrieve[$x]->db_cr_flg = 'D';
									$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($modelRetrieve[$x]->movement_type, 0, '', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
									
									if($modelRetrieve[$x]->gl_acct_cd == '')
									{
										$modelRetrieve[$x]->addError('gl_acct_cd','GL Acct is not found on Secu Acct');
										$success = false;
										break;
									}
									
									$modelRetrieve[$x]->price = 0;
									$modelRetrieve[$x]->due_dt_for_cert = $modelRetrieve[$x]->doc_dt;
									//$modelRetrieve[$x]->due_dt_onhand = $modelRetrieve[$x]->doc_dt;
									$modelRetrieve[$x]->doc_stat = 2;
									$totalLot = $this->getTotalLot($modelRetrieve[$x]->stk_cd, $modelRetrieve[$x]->qty);
									$modelRetrieve[$x]->total_lot = $totalLot['totalLot'];
									$modelRetrieve[$x]->odd_lot_doc = $totalLot['oddLotDoc'];
									$modelRetrieve[$x]->status = 'L';
									$modelRetrieve[$x]->manual = 'Y';
									$modelRetrieve[$x]->broker = $modelRetrieve[$x]->withdraw_reason_cd;
									
									if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									$modelRetrieve[$x]->seqno = 2;
									$modelRetrieve[$x]->db_cr_flg = 'C';
									$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($modelRetrieve[$x]->movement_type, 0, '', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
									
									if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,2) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
								}
							}
							
							if($success && $checked)
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success', 'Data Successfully Saved');
								$this->redirect(array('/custody/tstkmovement/index'));
							}
							else {
								$transaction->rollback();
							}
						}
						
						break;
						
					case 'exerciser':
						$retrieveCount = $_POST['retrieveCount'];	
						
						$valid = $valid && $retrieveCount;

						for($x=0;$x<$retrieveCount;$x++)
						{
							$modelRetrieve[$x] = new Tstkmovement($scenario);
							$modelRetrieve[$x]->status = 'L';
							$modelRetrieve[$x]->attributes = $_POST['Tstkmovement']; 
							$modelRetrieve[$x]->attributes = $_POST['Tstkretrieve'][$x+1];
		
							$modelRetrieve[$x]->doc_rem = str_ireplace('?c',$modelRetrieve[$x]->client_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?s',$modelRetrieve[$x]->stk_cd,$modelRetrieve[$x]->doc_rem);
							$modelRetrieve[$x]->doc_rem = str_ireplace('?b',$modelRetrieve[$x]->withdraw_reason_cd,$modelRetrieve[$x]->doc_rem);
							
							if($modelRetrieve[$x]->check == 'Y')$valid = $modelRetrieve[$x]->validate() && $valid;
						}
						
						if($valid)
						{
							$connection  = Yii::app()->db;
							$transaction = $connection->beginTransaction(); 
							
							$success = TRUE;
							$checked = FALSE;
							
							for($x=0;$success && $x<$retrieveCount;$x++)
							{
								if($modelRetrieve[$x]->check == 'Y')
								{
									$checked = TRUE;
									
									if($success && $model->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									$doc_type = $this->getDocType($model->movement_type, $model->movement_type_2, '');					
									$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$model->doc_dt','YYYY-MM-DD'),'$doc_type') AS doc_num FROM dual");
									$modelRetrieve[$x]->doc_num = $result['doc_num'];
									$modelRetrieve[$x]->ref_doc_num = '';
									$modelRetrieve[$x]->jur_type = $this->getMovementCode($modelRetrieve[$x]->movement_type, $modelRetrieve[$x]->movement_type_2, '');
									$modelRetrieve[$x]->seqno = 1;
									$modelRetrieve[$x]->s_d_type = 'C';
									$modelRetrieve[$x]->total_share_qty = $modelRetrieve[$x]->qty;
									$modelRetrieve[$x]->withdrawn_share_qty = 0;
									$modelRetrieve[$x]->db_cr_flg = 'D';
									$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($modelRetrieve[$x]->movement_type, $modelRetrieve[$x]->movement_type_2, '', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
									
									if($modelRetrieve[$x]->gl_acct_cd == '')
									{
										$modelRetrieve[$x]->addError('gl_acct_cd','GL Acct is not found on Secu Acct');
										$success = false;
										break;
									}
									
									$modelRetrieve[$x]->due_dt_for_cert = $modelRetrieve[$x]->doc_dt;
									//$modelRetrieve[$x]->due_dt_onhand = $modelRetrieve[$x]->doc_dt;
									$modelRetrieve[$x]->doc_stat = 2;
									$totalLot = $this->getTotalLot($modelRetrieve[$x]->stk_cd, $modelRetrieve[$x]->qty);
									$modelRetrieve[$x]->total_lot = $totalLot['totalLot'];
									$modelRetrieve[$x]->odd_lot_doc = $totalLot['oddLotDoc'];
									$modelRetrieve[$x]->status = 'L';
									$modelRetrieve[$x]->manual = 'Y';
									$modelRetrieve[$x]->broker = $modelRetrieve[$x]->withdraw_reason_cd;
									$modelRetrieve[$x]->repo_ref = $modelRetrieve[$x]->withdraw_doc_num;
									
									if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									
									$modelRetrieve[$x]->seqno = 2;
									$modelRetrieve[$x]->db_cr_flg = 'C';
									$modelRetrieve[$x]->gl_acct_cd = $this->getGlAcctCd($modelRetrieve[$x]->movement_type, 0, '', $modelRetrieve[$x]->client_cd, $model->doc_dt, $modelRetrieve[$x]->db_cr_flg);
									
									if($success && $modelRetrieve[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelRetrieve[$x]->doc_num,$modelRetrieve[$x]->db_cr_flg, $modelRetrieve[$x]->seqno,$model->update_date,$model->update_seq,2) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
								}
							}
							
							if($success && $checked)
							{
								$transaction->commit();
								Yii::app()->user->setFlash('success', 'Data Successfully Saved');
								$this->redirect(array('/custody/tstkmovement/index'));
							}
							else {
								$transaction->rollback();
							}
						}
						
						break; 
						
					default:
						break;
				}	
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'modelReceive'=>$modelReceive,
			'modelRetrieve'=>$modelRetrieve,
			'retrieved'=>$retrieved,
			'scenario'=>$scenario
		));
	}

	public function actionUpdate($doc_num, $db_cr_flg, $seqno)
	{
		$model=$this->loadModel($doc_num, $db_cr_flg, $seqno);
		
		$this->checkCancelled($model, array('index'));
		
		$modelReverse = new Tstkmovement;
		
		$this->setMovementType($model->jur_type, $model->movement_type, $model->movement_type_2);
		
		$valid = TRUE;
		$reversal = FALSE;

		if(isset($_POST['Tstkmovement']))
		{
			$model->attributes=$_POST['Tstkmovement'];
			
			$model->doc_rem = str_ireplace('?c',$model->client_cd,$model->doc_rem);
			$model->doc_rem = str_ireplace('?s',$model->stk_cd,$model->doc_rem);
			$model->doc_rem = str_ireplace('?b',$model->withdraw_reason_cd,$model->doc_rem);
			$model->broker = $model->withdraw_reason_cd;//[indra] 14nov2017, supaya isinya sama
			$authorizedBackDated = $_POST['authorizedBackDated'];
			
			if($model->validate() && $model->validateStkBal())
			{
				if(!$authorizedBackDated)
				{
					$currMonth = date('Ym');
					$docMonth = DateTime::createFromFormat('Y-m-d',$model->doc_dt)->format('Ym');
					
					if($docMonth < $currMonth)
					{
						$model->addError('doc_dt','You are not authorized to select last month date');
						$valid = FALSE;
					}
				}
				
				if($valid)
				{
					$oldModel = $this->loadModel($doc_num, $db_cr_flg, $seqno);
					
					if(
						$model->doc_dt != DateTime::createFromFormat('Y-m-d H:i:s',$oldModel->doc_dt)->format('Y-m-d') ||
						$model->client_cd != $oldModel->client_cd ||
						$model->stk_cd != $oldModel->stk_cd ||
						$model->total_share_qty != $oldModel->total_share_qty ||
						$model->withdrawn_share_qty != $oldModel->withdrawn_share_qty ||
						$model->price != $oldModel->price
					)
					{
						$reversal = TRUE;
					}			
					
					$success = FALSE;
					
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction(); 
					
					if($model->executeSpHeader(AConstant::INBOX_STAT_UPD,$this->menuName) > 0)$success = TRUE;
					
					/*----REVERSAL JOURNAL----*/
					
					if($reversal)
					{
						// REVERSAL
						
						$modelReverse = $this->loadModel($doc_num, $db_cr_flg, $seqno);
						$modelReverse->scenario = 'cancel';
						$modelReverse->validate();
						
						//$modelReverse->movement_type = $this->getMovementType($modelReverse->doc_num, $modelReverse->ref_doc_num);
						//$modelReverse->movement_type = $this->getReverseMovement($modelReverse->movement_type);
						
						//$modelReverse->doc_dt = $model->doc_dt;
						$modelReverse->db_cr_flg = $modelReverse->db_cr_flg=='D'?'C':'D';
						//$modelReverse->gl_acct_cd = $this->getGlAcctCd($modelReverse->movement_type, $modelReverse->client_cd, $modelReverse->doc_dt, $modelReverse->db_cr_flg);
						$modelReverse->doc_rem = 'Rv '.substr($modelReverse->doc_rem,0,37); //Because the max size is 40
						$modelReverse->prev_doc_num = $modelReverse->doc_num;
						//$modelReverse->s_d_type = 'R';
						$modelReverse->doc_stat = 3;
						
						$doc_type = $this->getDocType('REVERSAL', '', '');
						$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$modelReverse->doc_dt','YYYY-MM-DD HH24:MI:SS'),'$doc_type') AS doc_num FROM dual");
						$modelReverse->doc_num = $result['doc_num'];
						//$temp = $modelReverse->movement_type;
						$modelReverse->movement_type = 'REVERSAL';
						
						$modelReverse->cre_dt = date('Y-m-d H:i:s');
						$modelReverse->user_id = Yii::app()->user->id;
						
						if($success && $modelReverse->executeSp(AConstant::INBOX_STAT_INS,$modelReverse->doc_num, $modelReverse->db_cr_flg, $modelReverse->seqno,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
						else {
							$success = FALSE;
						}
						
						//$modelReverse->movement_type = $temp;
						$modelReverse2 = $this->loadModel($doc_num, $db_cr_flg=='D'?'C':'D', $seqno==1?2:1);
						
						$modelReverse->seqno = 2;
						$modelReverse->db_cr_flg = $modelReverse->db_cr_flg=='D'?'C':'D';
						//$modelReverse->gl_acct_cd = $this->getGlAcctCd($modelReverse->movement_type, $modelReverse->client_cd, $modelReverse->doc_dt, $modelReverse->db_cr_flg);
						$modelReverse->gl_acct_cd = $modelReverse2->gl_acct_cd;
						
						$modelReverse->movement_type = 'REVERSAL';
						
						if($success && $modelReverse->executeSp(AConstant::INBOX_STAT_INS,$modelReverse->doc_num, $modelReverse->db_cr_flg, $modelReverse->seqno,$model->update_date,$model->update_seq,2) > 0)$success = TRUE;
						else {
							$success = FALSE;
						}
						
						/*----NEW JOURNAL----*/
						
						//$temp = $model->movement_type;
						
						$model2 = $this->loadModel($doc_num, $db_cr_flg=='D'?'C':'D', $seqno==1?2:1); 
						//$model->movement_type = $this->getMoveCode($model->movement_type, $model->gl_acct_cd, $model2->gl_acct_cd);
						
						if(strpos($model->movement_type,'REPO') !== false)
						{
							$repoStock = DAO::queryRowSql("SELECT REPO_NUM FROM T_REPO_STK WHERE DOC_NUM = '$model->doc_num' AND ROWNUM = 1 ORDER BY CRE_DT DESC");
							$model->repo_ref = $repoStock['repo_num'];
						}
						
						$moveDocNumFlg = false;
						
						if($model->jur_type == 'WHDR' || $model->jur_type == 'RECV')
						{
							$newDocNum = DAO::queryRowSql("SELECT new_doc_num FROM T_STK_OTC WHERE doc_num = REPLACE('$model->doc_num','RSN','WSN')");
							
							if($newDocNum && $newDocNum['new_doc_num'])
							{
								$moveDocNumFlg = true;
								
								if($model->jur_type == 'WHDR')
								{
									$model->doc_num = $newDocNum['new_doc_num'];
								}
								else 
								{
									$model->doc_num = str_replace('WSN','RSN',$newDocNum['new_doc_num']);
								}
							}
						}
						
						if(!$moveDocNumFlg)
						{
							//$doc_type = $this->getDocType($model->movement_type, $model->movement_type_2, '');
							$doc_type = substr($model->doc_num,4,3);
							$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$model->doc_dt','YYYY-MM-DD'),'$doc_type') AS doc_num FROM dual");
							$model->doc_num = $result['doc_num'];
						}
						//$model->gl_acct_cd = $this->getGlAcctCd($model->movement_type, $model->client_cd, $model->doc_dt, $model->db_cr_flg);
						$totalLot = $this->getTotalLot($model->stk_cd, $doc_type=='WSN'?$model->withdrawn_share_qty:$model->total_share_qty);
						$model->total_lot = $totalLot['totalLot'];
						$model->odd_lot_doc = $totalLot['oddLotDoc'];
						
						$model->cre_dt = date('Y-m-d H:i:s');
						$model->user_id = Yii::app()->user->id;
									
						if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->doc_num, $model->db_cr_flg, $model->seqno,$model->update_date,$model->update_seq,3) > 0)$success = TRUE;
						else {
							$success = FALSE;
						}
						
						$model->seqno = 2;
						$model->db_cr_flg = $model->db_cr_flg=='D'?'C':'D';
						//$model->gl_acct_cd = $this->getGlAcctCd($model->movement_type, $model->client_cd, $model->doc_dt, $model->db_cr_flg);
						$model->gl_acct_cd = $model2->gl_acct_cd;
						
						if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->doc_num, $model->db_cr_flg, $model->seqno,$model->update_date,$model->update_seq,4) > 0)$success = TRUE;
						else {
							$success = FALSE;
						}
						
						//$model->movement_type = $temp;
					}
					else
					{
						// NON REVERSAL
						
						if($success && $model->executeSp(AConstant::INBOX_STAT_UPD,$model->doc_num,$model->db_cr_flg, $model->seqno,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
						else {
							$success = FALSE;
						}		
						
						$model2 = $this->loadModel($doc_num, $db_cr_flg=='D'?'C':'D', $seqno==1?2:1); 
						
						$model->seqno = 2;
						$model->db_cr_flg = $model->db_cr_flg=='D'?'C':'D';
						$model->gl_acct_cd = $model2->gl_acct_cd;
						
						if($success && $model->executeSp(AConstant::INBOX_STAT_UPD,$model->doc_num,$model->db_cr_flg, $model->seqno,$model->update_date,$model->update_seq,2) > 0)$success = TRUE;
						else {
							$success = FALSE;
						}
					}
					
					if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Updated');
						$this->redirect(array('/custody/tstkmovement/index'));
					}
					else {
						$transaction->rollback();
					}
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'modelReverse'=>$modelReverse,
		));
	}
	
	public function actionAjxPopDelete($doc_num, $db_cr_flg, $seqno)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$journalList = array();
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];	
					
			if($model->validate()){
				
				$success = FALSE;
				
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); 
				
				$modelHeader = $this->loadModel($doc_num, $db_cr_flg, $seqno);
				$this->checkCancelled($modelHeader, Yii::app()->request->requestUri);
				$modelHeader->validate();
				$modelHeader->clearErrors();
				if($modelHeader->executeSpHeader(AConstant::INBOX_STAT_CAN,$this->menuName) > 0)$success = TRUE;
				
				$doc_type = $this->getDocType('REVERSAL', '', '');
				$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$modelHeader->doc_dt','YYYY-MM-DD HH24:MI:SS'),'$doc_type') AS doc_num FROM dual");
				
				$journalList = Tstkmovement::model()->findAll(array('condition'=>"doc_num = '$doc_num'",'order'=>'seqno'));
				
				foreach($journalList as $row)
				{	
					$row->scenario = 'cancel';
					$row->validate();
					$row->clearErrors();
					$row->cancel_reason = $model->cancel_reason;
					
					//$modelReverse->doc_dt = date('Y-m-d');
					$row->db_cr_flg = $row->db_cr_flg=='D'?'C':'D';
					//$modelReverse->gl_acct_cd = $this->getGlAcctCd($modelReverse->movement_type, $modelReverse->client_cd, $modelReverse->doc_dt, $modelReverse->db_cr_flg);
					$row->doc_rem = 'Rv '.substr($row->doc_rem,0,37); //Because the max size is 40
					$row->prev_doc_num = $row->doc_num;
					$row->doc_stat = 3;
					
					$row->doc_num = $result['doc_num'];
	
					$row->movement_type = 'REVERSAL';
					
					$row->cre_dt = date('Y-m-d H:i:s');
					//$modelReverse->user_id = Yii::app()->user->id;
					
					if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->doc_num, $row->db_cr_flg, $row->seqno, $modelHeader->update_date, $modelHeader->update_seq,$row->seqno) > 0)$success = TRUE;
					else {
						$success = FALSE;
						break;
					}
				}
				
				//$modelReverse->movement_type = $temp;
				/*$modelReverse2 = $this->loadModel($doc_num, $db_cr_flg=='D'?'C':'D', $seqno==1?2:1);
				
				$modelReverse->seqno = 2;
				$modelReverse->db_cr_flg = $modelReverse->db_cr_flg=='D'?'C':'D';
				//$modelReverse->gl_acct_cd = $this->getGlAcctCd($modelReverse->movement_type, $modelReverse->client_cd, $modelReverse->doc_dt, $modelReverse->db_cr_flg);
				$modelReverse->gl_acct_cd = $modelReverse2->gl_acct_cd;
				
				$modelReverse->movement_type = 'REVERSAL';
				
				if($success && $modelReverse->executeSp(AConstant::INBOX_STAT_INS,$modelReverse->doc_num, $modelReverse->db_cr_flg, $modelReverse->seqno,$modelReverse->update_date,$modelReverse->update_seq,2) > 0)$success = TRUE;
				else {
					$success = FALSE;
				}*/
				
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Cancelled');
					$is_successsave = true;	
				}
				else {
					$transaction->rollback();
				}	
			}
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$journalList,
			'is_successsave'=>$is_successsave		
		));
	}

	public function actionCancelMultiple()
	{
		$model=new Tstkmovement('search');
		
		$model->unsetAttributes();  // clear any default values
		
		$model->movement_type = 'RW';
		$model->approved_stat = 'A';
		if(isset($_GET['Tstkmovement']))
			$model->attributes=$_GET['Tstkmovement'];

		$this->render('cancel_multiple',array(
			'model'=>$model,
		));
	}
	
	public function actionAjxPopCancelMultiple()
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$journalList = array();
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		
		$doc_dt = $client_cd = $stk_cd = $movement_type = $movement_type_2 = '';
		
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];	
					
			if($model->validate())
			{
				$success = TRUE;
				
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); 
				
				foreach($_GET['arrid'] as $doc_num)
				{
					if($success)
					{
						$modelHeader = Tstkmovement::model()->find("doc_num = '$doc_num' AND seqno = 1");
						$this->checkCancelled($modelHeader, Yii::app()->request->requestUri);
						$modelHeader->validate();
						$modelHeader->clearErrors();
						if($modelHeader->executeSpHeader(AConstant::INBOX_STAT_CAN,$this->menuName) > 0)$success = TRUE;
						
						$doc_type = $this->getDocType('REVERSAL', '', '');
						$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$modelHeader->doc_dt','YYYY-MM-DD HH24:MI:SS'),'$doc_type') AS doc_num FROM dual");
						
						$journalList = Tstkmovement::model()->findAll(array('condition'=>"doc_num = '$doc_num'",'order'=>'seqno'));
						
						$x = 0;
						
						foreach($journalList as $row)
						{
							$doc_date = DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_dt)->format('d M Y');
							$client_cd = $row->client_cd;
							$stk_cd = $row->stk_cd;
							$this->setMovementType($row->jur_type, $movement_type, $movement_type_2);
								
							$row->scenario = 'cancel';
							$row->validate();
							$row->clearErrors();
							$row->cancel_reason = $model->cancel_reason;
							
							$row->db_cr_flg = $row->db_cr_flg=='D'?'C':'D';
							$row->doc_rem = 'Rv '.substr($row->doc_rem,0,37); //Because the max size is 40
							$row->prev_doc_num = $row->doc_num;
							$row->doc_stat = 3;
							
							$row->doc_num = $result['doc_num'];
			
							$row->movement_type = 'REVERSAL';
							
							$row->cre_dt = date('Y-m-d H:i:s');
							//$modelReverse->user_id = Yii::app()->user->id;
							
							if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->doc_num, $row->db_cr_flg, $row->seqno, $modelHeader->update_date, $modelHeader->update_seq,$row->seqno) > 0)$success = TRUE;
							else {
								$success = FALSE;
								break 2;
							}
							
							$x++;
						}
						
						/*$db_cr_flg = 'D';
						$seqno = 1;
						$modelReverse = $this->loadModel($doc_num, $db_cr_flg, $seqno);
						
						$doc_date = DateTime::createFromFormat('Y-m-d H:i:s',$modelReverse->doc_dt)->format('d M Y');
						$client_cd = $modelReverse->client_cd;
						$stk_cd = $modelReverse->stk_cd;
						$this->setMovementType($modelReverse->jur_type, $movement_type, $movement_type_2);
						
						$modelReverse->scenario = 'cancel';
						$modelReverse->validate(); 
						$modelReverse->cancel_reason  = $model->cancel_reason;
						
						if($success && $modelReverse->executeSpHeader(AConstant::INBOX_STAT_CAN,$this->menuName) > 0)$success = TRUE;
						else {
							$success = FALSE;
						}
	
						$modelReverse->db_cr_flg = $modelReverse->db_cr_flg=='D'?'C':'D';
						$modelReverse->doc_rem = 'Rv '.substr($modelReverse->doc_rem,0,37); //Because the max size is 40
						$modelReverse->prev_doc_num = $modelReverse->doc_num;
						$modelReverse->doc_stat = 3;
						
						$doc_type = $this->getDocType('REVERSAL', '', '');
						$result = DAO::queryRowSql("SELECT GET_STK_JURNUM(TO_DATE('$modelReverse->doc_dt','YYYY-MM-DD HH24:MI:SS'),'$doc_type') AS doc_num FROM dual");
						$modelReverse->doc_num = $result['doc_num'];
						$modelReverse->movement_type = 'REVERSAL';
						
						$modelReverse->cre_dt = date('Y-m-d H:i:s');
						$modelReverse->user_id = Yii::app()->user->id;
						
						if($success && $modelReverse->executeSp(AConstant::INBOX_STAT_INS,$modelReverse->doc_num, $modelReverse->db_cr_flg, $modelReverse->seqno,$modelReverse->update_date,$modelReverse->update_seq,1) > 0)$success = TRUE;
						else {
							$success = FALSE;
						}
						
						$modelReverse2 = $this->loadModel($doc_num, $db_cr_flg=='D'?'C':'D', $seqno==1?2:1);
						
						$modelReverse->seqno = 2;
						$modelReverse->db_cr_flg = $modelReverse->db_cr_flg=='D'?'C':'D';
						$modelReverse->gl_acct_cd = $modelReverse2->gl_acct_cd;
						
						$modelReverse->movement_type = 'REVERSAL';
						
						if($success && $modelReverse->executeSp(AConstant::INBOX_STAT_INS,$modelReverse->doc_num, $modelReverse->db_cr_flg, $modelReverse->seqno,$modelReverse->update_date,$modelReverse->update_seq,2) > 0)$success = TRUE;
						else {
							$success = FALSE;
						}*/
					}
				}
				
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Cancelled');
					$is_successsave = true;	
				}
				else {
					$transaction->rollback();
					$journalList[$x]->clearErrors('error_msg');
					$journalList[$x]->addError('error_msg', 'Cancel Stock Movement '.$doc_date.' '.$client_cd.' '.$stk_cd.' '.$movement_type.': Error '.$journalList[$x]->error_code.' '.$journalList[$x]->error_msg);
				}	
			}
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$journalList,
			'is_successsave'=>$is_successsave		
		));
	}

	public function actionIndex()
	{
		$model=new Tstkmovement('search');
		
		$model->unsetAttributes();  // clear any default values
		
		$model->movement_type = 'RW';
		$model->approved_stat = 'A';
		if(isset($_GET['Tstkmovement']))
			$model->attributes=$_GET['Tstkmovement'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($doc_num, $db_cr_flg, $seqno)
	{
		$model=Tstkmovement::model()->findByPk(array('doc_num'=>$doc_num,'db_cr_flg'=>$db_cr_flg,'seqno'=>$seqno));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	private function getTotalLot($stk_cd,$qty)
	{
		$sql = "SELECT lot_size FROM MST_COUNTER WHERE stk_cd = '$stk_cd'";
		$lot = DAO::queryRowSql($sql);
		$lotSize = $lot['lot_size'];
		
		$sql = "SELECT TRUNC($qty/$lotSize) total_lot FROM dual";
		$total = DAO::queryRowSql($sql);
		$totalLot = $total['total_lot'];
		
		$oddLotDoc = $qty%$lotSize==0?'N':'Y';
		
		return array('totalLot'=>$totalLot,'oddLotDoc'=>$oddLotDoc);
	}
	
	private function getGlAcctCd($movement,$type2,$type3,$client_cd,$doc_dt,$db_cr)
	{
		$moveCd = $this->getMovementCode($movement,$type2,$type3);
		$clientDetail = DAO::queryRowSql(Tstkmovement::getClientTypeSql($client_cd));
		$clientType = $clientDetail['client_type'];
		
		$other_1 = DAO::queryRowSql("SELECT TRIM(other_1) other_1 FROM MST_COMPANY");
		$type_1 = DAO::queryRowSql("SELECT client_type_1 FROM MST_CLIENT WHERE client_cd = '$client_cd'");
		
		if($client_cd == $other_1['other_1'] || $type_1['client_type_1'] == 'H')$clientType = 'H';
		
		$sql = "SELECT deb_acct, cre_acct 
				FROM MST_SECU_ACCT
				WHERE mvmt_type = '$moveCd'
				AND (client_type = '$clientType' OR ('$clientType' <> 'H' AND client_type = '%'))
				AND eff_dt_from <= TO_DATE('$doc_dt','YYYY-MM-DD')
				AND eff_dt_to >= TO_DATE('$doc_dt','YYYY-MM-DD')";
		
		$glAcctCd = DAO::queryRowSql($sql);
		
		if($db_cr == 'D')
			return $glAcctCd['deb_acct'];
		else {
			return $glAcctCd['cre_acct'];
		}
	}
	
	private function getDocType($movement_type, $movement_type2, $type3)
	{
		// $type3 = additional flag for EXERCISE type
		switch($movement_type)
		{
			case 'RECV':
			case 'BORW':
			case 'BORWT':
				return 'RSN';
				break;
				
			case 'WHDR':
			case 'LEND':
			case 'LENDT':
				return 'WSN';
				break;
				
			case 'RPO':
			case 'RPOT':
			case 'RRPO':
			case 'RRPOT':
				return 'JVA';
				break;
				
			case 'SETTLE':
				if($movement_type2 == 'R')
					return 'RSN';
				else {
					return 'WSN';
				}
				break;
				
			case 'EXERCS':
				if($movement_type2 == 0)
					return 'WSN';
				else if($movement_type2 == 1)
				{
					if($type3 == 'BELI')
						return 'RSN';
					else 
						return 'WSN';
				}
				else 					
					return 'JVB';
				break;
				
			case 'TDOBUY':
				if($movement_type2 == 0)
					return 'RSN';
				else 					
					return 'JVB';
				break;
				
			case 'TDOSEL':
				if($movement_type2 == 0)
					return 'WSN';
				else 					
					return 'JVS';
				break;
				
			case 'EXERNP':
				if($movement_type2 == 0)
					return 'RSN';
				else 					
					return 'WSN';
				break;
				
			case 'REVERSAL':
				return 'REV';
				break; 
		}
	}
	
	private function getMovementCode($movement,$type2,$type3)
	{
		// For REPO, RETURN REPO, REVERSE REPO, and RETURN REVERSE REPO, $type2 = penghentian_pengakuan, $type3 = serah_saham	
		// For the rest, $type2 = movement_type_2, $type3 = additional flag for EXERCISE and SETTLE TENDER OFFER BUY
		switch($movement)
		{
			case 'RECV':
				if($type2 == 0)
					return 'RECV';
				else if($type2 == 1)
					return 'RECVS';
				else 
					return '3336';
				break;
				
			case 'WHDR':
				if($type2 == 0)
					return 'WHDR';
				else
					return 'WHDRS';
				break;
				
			case 'RPO':
				if($type2 == 'N')
				{
					if($type3 == 'N')
						return false;
					else 
						return 'REPO';
				}
				else
					return 'REPOY';				
				break;
				
			case 'RPOT':
				if($type2 == 'N')
				{
					if($type3 == 'N')
						return false;
					else 
						return 'REPORTN';
				}
				else
					return 'REPOYRTN';
					
				break;
				
			case 'RRPO':
				if($type2 == 'N')
				{
					if($type3 == 'N')
						return 'REREPOC';
					else 
						return 'REREPOS';
				}
				else
					return 'REREPOY';
					
				break;
				
			case 'RRPOT':
				if($type2 == 'N')
				{
					if($type3 == 'N')
						return 'REREPOCRTN';
					else 
						return 'REREPOSRTN';
				}
				else
					return 'REREPOYRTN';				
				break;
				
			case 'EXERCS':
				if($type2 == 0)
					return 'EXERT0';
				else if($type2 == 1)
				{
					if($type3 == 'BELI')
						return 'EXERBELI';
					else 
						return 'EXERSERAH';	
				}
				else 
				{
					if($type3 == 1)
						return 'EXERRECV1';
					else 
						return 'EXERRECV2';	
				}
				break;
				
			case 'TDOBUY':
				if($type2 == 0)
					return 'TOFFBUY';
				else {
					if($type3 == 1)
						return 'TOFFBUYDU1';
					else 
						return 'TOFFBUYDU2';
				}
				break;
				
			case 'TDOSEL':
				if($type2 == 0)
					return 'TOFFSELL';
				else {
					return 'TOFFSELLDU';
				}
				break;
				
			case 'BORW':
				return 'BORROW';
				
			case 'BORWT':
				return 'BORROWRTN';
				
			case 'LEND':
				if($type2 == 0)
					return 'LEND';
				else 
					return 'LENDPE';
				break;
				
			case 'LENDT':
				if($type2 == 0)
					return 'LENDRTN';
				else 
					return 'LENDPERTN';
				break;
				
			case 'EXERNP':
				if($type2 == 0)
					return 'EXERR';
				else
					return 'EXERW';
				break;	
				
			default:
				return $movement;
				break;
		}
	}
	
	/*private function getMoveCode($movement, $gl_acct_cd, $gl_acct_cd2)
	{
		switch($movement)
		{
			case 'RECEIVE':
				return 'RECV';
				break;
			case 'WITHDRAW':
				if($gl_acct_cd == 33 && $gl_acct_cd2 == 12)
					return 'WHDRS';
				else if($gl_acct_cd == 33 && $gl_acct_cd2 == 36)
					return '3336';
				else
					return 'WHDR';
				break;
			case 'REVERSE REPO':
				return 'RRPOC';
				break;
			case 'RETURN REVERSE REPO':
				return 'RRPOCT';
				break;
			default:
				return $movement;
				break;
		}
	}*/
	
	private function setMovementType($jur_type, &$movement_type, &$movement_type_2)
	{
		switch($jur_type)
		{
			case 'RECV':
				$movement_type = 'RECEIVE';
				$movement_type_2 = 'Scripless';
				break;
				
			case 'RECVS':
				$movement_type = 'RECEIVE';
				$mocement_type_2 = 'Scrip';
				break;
				
			case '3336':
				$movement_type = 'RECEIVE';
				$movement_type_2 = 'Convert Scrip';
				break;
				
			case 'WHDR':
				$movement_type = 'WITHDRAW';
				$movement_type_2 = 'Scripless';
				break;
				
			case 'WHDRS':
				$movement_type = 'WITHDRAW';
				$movement_type_2 = 'Scrip';
				break;
				
			case 'REPO':
			case 'REPOY':
				$movement_type = 'REPO';
				break;
				
			case 'REPORTN':
			case 'REPOYRTN':
				$movement_type = 'RETURN REPO';
				break;
				
			case 'REREPOC':
			case 'REREPOS':
			case 'REREPOY':
				$movement_type = 'REVERSE REPO';
				break;
				
			case 'REREPOCRTN':
			case 'REREPOSRTN':
			case 'REREPOYRTN':
				$movement_type = 'RETURN REVERSE REPO';
				break;
				
			case 'EXERT0':
				$movement_type = 'EXERCISE HMETD';
				$movement_type_2 = 'Dipindahkan ke efek jaminan';
				break;
				
			case 'EXERBELI':
				$movement_type = 'EXERCISE HMETD';
				$movement_type_2 = 'Mencatat transaksi beli';
				break;
				
			case 'EXERSERAH':
				$movement_type = 'EXERCISE HMETD';
				$movement_type_2 = 'Menyerahkan HMETD ke LPP';
				break;
				
			case 'EXERRECV1':
			case 'EXERRECV2':
				$movement_type = 'EXERCISE HMETD';
				$movement_type_2 = 'Menerima efek';
				break;
				
			case 'TOFFBUY':
				$movement_type = 'TENDER OFFER BUY';
				$movement_type_2 = 'Buy';
				break;
				
			case 'TOFFBUYDU1':
			case 'TOFFBUYDU2':
				$movement_type = 'TENDER OFFER BUY';
				$movement_type_2 = 'Settle buy';
				break;
				
			case 'TOFFSELL':
				$movement_type = 'TENDER OFFER SELL';
				$movement_type_2 = 'Pindah ke rek tampungan LPP';
				break;
				
			case 'TOFFSELLDU':
				$movement_type = 'TENDER OFFER SELL';
				$movement_type_2 = 'Settle sell';
				break;
				
			case 'BORROW':
				$movement_type = 'BORROWING';
				break;
				
			case 'BORROWRTN':
				$movement_type = 'RETURN BORROWING';
				break;
				
			case 'LEND':
				$movement_type = 'LENDING';
				$movement_type_2 = 'To LKP';
				break;
				
			case 'LENDPE':
				$movement_type = 'LENDING';
				$movement_type_2 = 'To broker';
				break;
				
			case 'LENDRTN':
				$movement_type = 'RETURN LENDING';
				$movement_type_2 = 'To LKP';
				break;
				
			case 'LENDPERTN':
				$movement_type = 'RETURN LENDING';
				$movement_type_2 = 'To broker';
				break;
				
			case 'SPLITX':
				$movement_type = 'SPLITX';
				$movement_type_2 = 'X DATE';
				break;
				
			case 'SPLITD':
				$movement_type = 'SPLITD';
				$movement_type_2 = 'DISTRIBUTION';
				break;
				
			case 'REVERSEX'	:
				$movement_type = 'REVERSE';
				$movement_type_2 = 'X DATE';
				break;
				
			case 'REVERSED'	:
				$movement_type = 'REVERSE';
				$movement_type_2 = 'DISTRIBUTION';
				break;
				
			case 'CORPACTC' :
				$movement_type = 'CORPACTC';
				$movement_type_2 = 'Cum Date';
				break;
				
			case 'CORPACTD' :
				$movement_type = 'CORPACTD';
				$movement_type_2 = 'Distribution Date';
				break;
				
			case 'HMETDC':
				$movement_type = 'HMETD';
				$movement_type_2 = 'CUM DATE';
				break;
				
			case 'HMETDD':
				$movement_type = 'HMEDTD';
				$movement_type_2 = 'DISTRIBUTION';
				break;	
				
			case 'BONUSC':
				$movement_type = 'BONUS';
				$movement_type_2 = 'CUM DATE';
				break;
				
			case 'BONUSD':
				$movement_type = 'HMETD';
				$movement_type_2 = 'DISTRIBUTION';
				break;	
				
			case 'STKDIVC':
				$movement_type = 'STOCK DIVIDEN';
				$movement_type_2 = 'CUM DATE';
				break;
				
			case 'STKDIVD':
				$movement_type = 'STOCK DIVIDEN';
				$movement_type_2 = 'DISTRIBUTION';
				break;
				
			case 'EXERR':
				$movement_type = 'EXERCISE NP';
				$movement_type_2 = 'RECEIVE';
				break;
				
			case 'EXERW':
				$movement_type = 'EXERCISE NP';
				$movement_type_2 = 'WITHDRAW';
				break;
		}
	}
/*	
	private function getReverseMovement($movement)
	{
		switch($movement)
		{
			case 'RECEIVE':
				return 'WHDR';
				break;
			case 'WITHDRAW':
				return 'RECV';
				break;
			case 'REPO':
				return 'RRPOCT';
				break;
			case 'RETURN REPO':
				return 'RRPOC';
				break;
		}
	}
 */
 
 /*-------------- NEW CHECK RATIO -------------*/
 
 	public function checkRatio($client_cd, $stk_cd, $qty, &$ratio, &$message, &$block)
	{
		$valid = true;
		
 		$connection  = Yii::app()->db;
		
		$message_type;
		$ratio_txt;
		$error_code = -999;
		$error_msg;
				
		try{
			$query  = "CALL GET_RATIO_FO(
						:P_CLIENT_CD,
						:P_STK_CD,
						0,
						:P_WITHDRAW_QTY,
						0,
						:P_MESSAGE_TYPE,
						:P_RATIO,
						:P_RATIO_TXT,
						:P_ERROR_CODE,
						:P_ERROR_MSG
						)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_CLIENT_CD",$client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_WITHDRAW_QTY",$qty,PDO::PARAM_STR);	
					
			$command->bindParam(":P_MESSAGE_TYPE",$message_type,PDO::PARAM_STR,10);
			$command->bindParam(":P_RATIO",$ratio,PDO::PARAM_STR,10);
			$command->bindParam(":P_RATIO_TXT",$ratio_txt,PDO::PARAM_STR,200);
			$command->bindParam(":P_ERROR_CODE",$error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			
		}catch(Exception $ex){
			if($error_code = -999)
				$error_msg = $ex->getMessage();
		}
		
		if($error_code < 0)
		{
			$message = 'Fail to get ratio from FO '.$error_msg;
			$valid = false;
			$block = true;
		}
		else
		{
			if($ratio > 0 || $ratio == -1 || $ratio < 0)
			{
				$valid = false;
				$message = $ratio_txt;
				
				if($message_type == 0)
				{
					$block = false;
				}
				else 
				{
					$block = true;
				}
			}
		}
		
		return $valid;
	}
 
 	public function checkRatioPorto($client_cd, $total_qty, &$ratio, &$message, &$block)
	{
		$valid = true;
				
		$connection  = Yii::app()->db;
		
		$message_type;
		$ratio_txt;
		$error_code = -999;
		$error_msg;
		
		try{
			$query  = "CALL GET_RATIO_FO(
						:P_CLIENT_CD,
						'X',
						0,
						0,
						:P_WITHDRAW_PORTO_DISCT,
						:P_MESSAGE_TYPE,
						:P_RATIO,
						:P_RATIO_TXT,
						:P_ERROR_CODE,
						:P_ERROR_MSG
						)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_CLIENT_CD",$client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_WITHDRAW_PORTO_DISCT",$total_qty,PDO::PARAM_STR);	
					
			$command->bindParam(":P_MESSAGE_TYPE",$message_type,PDO::PARAM_STR,10);
			$command->bindParam(":P_RATIO",$ratio,PDO::PARAM_STR,10);
			$command->bindParam(":P_RATIO_TXT",$ratio_txt,PDO::PARAM_STR,200);
			$command->bindParam(":P_ERROR_CODE",$error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			
		}catch(Exception $ex){
			if($error_code = -999)
				$error_msg = $ex->getMessage();
		}
		
		if($error_code < 0)
		{
			$message = 'Fail to get ratio from FO '.$error_msg;
			$valid = false;
			$block = true;
		}
		else
		{
			if($ratio > 0 || $ratio == -1 || $ratio < 0)
			{
				$valid = false;
				$message = $ratio_txt;
				
				if($message_type == 0)
				{
					$block = false;
				}
				else 
				{
					$block = true;
				}
			}
		}
		
		return $valid;
	}	
 
 /*-------------- NEW CHECK RATIO -------------*/
 
 
 
 /*-------------- OLD CHECK RATIO -------------*/
 /*
 	public function checkRatio($model, $client_cd, $total_qty)
	{
		$valid = true;

		$connection  = Yii::app()->db;
		
		$message_type;
		$ratio;
		$ratio_txt;
		$error_code;
		$error_msg;
		
		try{
			$query  = "CALL Get_Ratio_Fo_5dec13(
						:P_CLIENT_CD,
						'X',
						0,
						0,
						:P_WITHDRAW_PORTO_DISCT,
						:P_MESSAGE_TYPE,
						:P_RATIO,
						:P_RATIO_TXT,
						:P_ERROR_CODE,
						:P_ERROR_MSG
						)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_CLIENT_CD",$client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_WITHDRAW_PORTO_DISCT",$total_qty,PDO::PARAM_STR);	
					
			$command->bindParam(":P_MESSAGE_TYPE",$message_type,PDO::PARAM_STR,10);
			$command->bindParam(":P_RATIO",$ratio,PDO::PARAM_STR,10);
			$command->bindParam(":P_RATIO_TXT",$ratio_txt,PDO::PARAM_STR,200);
			$command->bindParam(":P_ERROR_CODE",$error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			
		}catch(Exception $ex){
			if($error_code = -999)
				$error_msg = $ex->getMessage();
		}
		
		if($error_code < 0)
		{
			$model->addError('qty', 'Fail to get ratio from FO '.$error_msg);
			$valid = false;
		}
		else
		{
			if($ratio > 0 || $ratio == -1 || $ratio < 0)
			{
				if($message_type == 0)
				{
					
				}
				else 
				{
					$model->addError('qty', 'Withdraw Failed '.$ratio_txt);
					$valid = false;
				}
			}
		}
		
		return $valid;
	}

	public function checkRatioMove($model, $client_cd, $total_qty)
	{
		$valid = true;
				
		$connection  = Yii::app()->db;
		
		$message_type;
		$ratio;
		$ratio_txt;
		$error_code;
		$error_msg;
		
		try{
			$query  = "CALL Get_Ratio_Fo_5dec13(
						:P_CLIENT_CD,
						'X',
						0,
						0,
						:P_WITHDRAW_PORTO_DISCT,
						:P_MESSAGE_TYPE,
						:P_RATIO,
						:P_RATIO_TXT,
						:P_ERROR_CODE,
						:P_ERROR_MSG
						)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_CLIENT_CD",$client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_WITHDRAW_PORTO_DISCT",$total_qty,PDO::PARAM_STR);	
					
			$command->bindParam(":P_MESSAGE_TYPE",$message_type,PDO::PARAM_STR,10);
			$command->bindParam(":P_RATIO",$ratio,PDO::PARAM_STR,10);
			$command->bindParam(":P_RATIO_TXT",$ratio_txt,PDO::PARAM_STR,200);
			$command->bindParam(":P_ERROR_CODE",$error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			
		}catch(Exception $ex){
			if($error_code = -999)
				$error_msg = $ex->getMessage();
		}
		
		if($error_code < 0)
		{
			$model->addError('qty', 'Fail to get ratio from FO '.$error_msg);
			$valid = false;
		}
		else
		{
			if($ratio > 0 || $ratio == -1 || $ratio < 0)
			{
				if($message_type == 0)
				{
					
				}
				else 
				{
					$model->addError('qty', 'Move Failed '.$ratio_txt);
					$valid = false;
				}
			}
		}
		
		return $valid;
	}	
  */
  /*-------------- OLD CHECK RATIO -------------*/
}
