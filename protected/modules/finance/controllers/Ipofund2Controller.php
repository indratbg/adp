<?php

class Ipofund2Controller extends AAdminController
{
	public $layout='//layouts/admin_column3';
	
	public function actionAjxGetBatchList()
	{
		$resp['status']  = 'error';
		
		$batch = array();
		
		if(isset($_POST['stk_cd']))
		{
			$stk_cd = $_POST['stk_cd'];
			$sql = "SELECT DISTINCT batch  FROM T_IPO_CLIENT WHERE STK_CD='$stk_cd' and approved_stat='A' order by batch";
			$exec = DAO::queryAllSql($sql);
			foreach($exec as $row)
			{
				$batch[] = $row['batch']; 
			}
			$resp['status'] = 'success';
		}
		
		$resp['content'] = array('batch'=>$batch);
		echo json_encode($resp);
	}
public function actionGetclient()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_REQUEST['term']);
      $qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '".$term."%')
      			AND susp_stat = 'N' AND client_type_1 <> 'B' AND custodian_cd IS NULL
      			AND rownum <= 11
      			ORDER BY client_cd
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['client_cd']
      			, 'labelhtml'=>$search['client_cd']
      			, 'value'=>$search['client_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
	
	public function actionIndex()
	{	$model= new Tpee;
		$modelDetailDana = array();
		$modelDetailPenjatahan = array();
		$modelDetailRefund = array();
		$modelmovement =array();
		$modelIpofund2 = array();
		$modelfundledger=array();
		$modelaccountledger=array();
		$modelPayrech = new Tpayrech;
		$modelPayrecd= new Tpayrecd;
		$modelFolder= new Tfolder;
		$modelFundTrf = new Tfundtrf;
		$model->option=1;
		$model->rdi_type='CUKUP';
		$model->journal_date =date('d/m/Y');
		$valid = true;
		$success=false;
		$modelgen = new Ipofund2;
		$trf_langsung_flg = Sysparam::model()->find("param_id='IPO FUND ENTRY' and param_cd1='TRFLGSG'")->dflg1;
		
		if(isset($_POST['scenario']))
		{	
			$scenario= $_POST['scenario'];
			$model->attributes = $_POST['Tpee'];
			$model->total_setor = str_replace(',', '', $model->total_setor);
			if(DateTime::createFromFormat('d/m/Y',$model->paym_dt))$model->paym_dt=DateTime::createFromFormat('d/m/Y',$model->paym_dt)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->offer_dt_fr))$model->offer_dt_fr=DateTime::createFromFormat('d/m/Y',$model->offer_dt_fr)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->offer_dt_to))$model->offer_dt_to=DateTime::createFromFormat('d/m/Y',$model->offer_dt_to)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->allocate_dt))$model->allocate_dt=DateTime::createFromFormat('d/m/Y',$model->allocate_dt)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->distrib_dt_to))$model->distrib_dt_to=DateTime::createFromFormat('d/m/Y',$model->distrib_dt_to)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->distrib_dt_to))$model->distrib_dt_to=DateTime::createFromFormat('d/m/Y',$model->distrib_dt_to)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->journal_date))$model->journal_date=DateTime::createFromFormat('d/m/Y',$model->journal_date)->format('Y-m-d');
			if($scenario =='filter')//retrieve
			{
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
				$client_cd = $model->client_cd==''?'%':$model->client_cd;
				$branch_cd = $model->branch_cd==''?'%':$model->branch_cd;	
				$rdi_type =  $model->rdi_type;
				$journal_date = $model->journal_date;
				$batch = $model->batch;
				$remarks = $model->remarks;
				
				//RETRIEVE SELECTED PENERIMAAN DANA
				if($model->tahap =='0' && $model->option =='1')
				{
					$option = $model->option=='0'?'ALL':'Selected';
					$modelDetailDana = Ipofund2::model()->findAllBySql(Ipofund2::getPenerimaanDana($model->stk_cd, $option,$client_cd,$branch_cd,$rdi_type,$batch));	
					if(!$modelDetailDana)
					{
						Yii::app()->user->setFlash('danger', 'No data found for stock '. $model->stk_cd);
					}
					
					$setor = 0;
					foreach($modelDetailDana as $row)
					{
						//jika tidak punya RDI jurnal semua dengan menggunakan amount	
						$setor = $setor	+ $row->amount;
						
						if($model->rdi_type =='NORDI')
						{
							$row->setor = $row->amount;
						}
						else {
							$row->setor =0;
						}
					}
					
					$model = Tpee::model()->find("stk_cd='$model->stk_cd' ");
					if(!$model)
					{
					$model = new Tpee;
					$model->option ='1';
					$model->tahap = 0;	
					}
					else
					{
					$model->option ='1';
					$model->tahap = 0;
					$model->client_cd = $client_cd=='%'?'':$client_cd;
					$model->branch_cd = $branch_cd=='%'?'':$branch_cd;
					$model->rdi_type = $rdi_type;
					$model->total_setor = $setor;
					$model->batch = $batch;
					$model->journal_date =$journal_date;
					$model->remarks = $remarks;
				
					}
					
				}
				//RETRIEVE SELECTED PENJATAHAN
				else if($model->tahap == '1' && $model->option =='1')
				{
					$option = $model->option=='0'?'ALL':'Selected';
					$modelDetailPenjatahan = Ipofund2::model()->findAllBySql(Ipofund2::getPenjatahan($model->stk_cd, $option, $client_cd, $branch_cd, $rdi_type,$batch));
					
					$debit=0;
					foreach($modelDetailPenjatahan as $row)
					{
						$debit = $debit+$row->amount;
						$row->save_flg='Y';
					}
				
					if(!$modelDetailPenjatahan)
					{
						Yii::app()->user->setFlash('danger', 'No data found for stock '. $model->stk_cd);
					}
					
					$model = Tpee::model()->find("stk_cd='$model->stk_cd' ");
					if(!$model)
					{
					$model= new Tpee;
					$model->option ='1';
					$model->tahap = 1;	
					$model->rdi_type='0';
					}
					else 
					{
					$model->option ='1';
					$model->tahap = 1;	
					$model->client_cd = $client_cd=='%'?'':$client_cd;
					$model->branch_cd = $branch_cd=='%'?'':$branch_cd;
					$model->rdi_type = $rdi_type;
					$model->total_setor = $debit;
					$model->batch = $batch;
					$model->journal_date =$journal_date;
					$model->remarks = $remarks;
					}
				}
				//RETRIEVE SELECTED REFUND
				else if($model->tahap =='2' && $model->option =='1')
				{
					$option = $model->option=='0'?'ALL':'Selected';
					$modelDetailRefund = Ipofund2::model()->findAllBySql(Ipofund2::getRefund($model->stk_cd, $option, $client_cd, $branch_cd, $rdi_type,$batch));
					
					$debit=0;
					foreach($modelDetailRefund as $row)
					{
						$debit = $debit+$row->refund;
						//$row->save_flg='Y';
					}

					if(!$modelDetailRefund)
					{
						Yii::app()->user->setFlash('danger', 'No data found for stock '. $model->stk_cd);
					}
					
					$model = Tpee::model()->find("stk_cd='$model->stk_cd' ");
					if(!$model)
					{
						$model = new Tpee;
						$model->option ='1';
						$model->tahap = 2;		
					}
					else
					{
						$model->option ='1';
						$model->tahap = 2;
						$model->client_cd = $client_cd=='%'?'':$client_cd;
						$model->branch_cd = $branch_cd=='%'?'':$branch_cd;
						$model->rdi_type = $rdi_type;
						$model->batch = $batch;
						$model->journal_date =$journal_date;
						$model->total_setor = $debit;
						$model->remarks = $remarks;
					}
				}
			/*
			
							//JOURNAL ALL PENERIMAAN DANA
							else if($model->tahap =='0' && $model->option =='0')
							{
								$modelgen->stk_cd = $model->stk_cd;
								$modelgen->tahap = 'PENERIMAAN';
								$modelgen->gl_acct_bank = $model->gl_acct_bank;
								$modelgen->sl_acct_bank = $model->sl_acct_bank;
								$modelgen->gl_acct_hutang = $model->gl_acct_utang;
								$modelgen->sl_acct_hutang = $model->sl_acct_utang;
								$modelgen->user_id = Yii::app()->user->id;
								$model->scenario = 'ipoentry';
								$user= $model->user_id;
								if($modelgen->executeSpGen($user)>0)
								{
									$success=true;
								}
								else
								{
									$success=false;
								}
							}
							//JOURNAL ALL PENJAATAHAN 
							else if($model->tahap =='1' && $model->option=='0')
							{
								$modelgen->stk_cd = $model->stk_cd;
								$modelgen->tahap = 'PENJATAHAN';
									if ($model->check_gl=='Y')
									{
									$modelgen->gl_acct_bank = $model->gl_acct_bank;
									$modelgen->sl_acct_bank = $model->sl_acct_bank;	
									$modelgen->gl_acct_hutang = $model->gl_acct_utang;
									$modelgen->sl_acct_hutang = $model->sl_acct_utang;	
									}
								$modelgen->user_id = Yii::app()->user->id;
								$modelgen->folder_cd = $model->voucher_ref;
								$modelgen->remarks = $model->remarks;
								$model->scenario = 'penjatahan';
								$user= $model->user_id;
								if($folder_cd=='Y' && $model->voucher_ref=='' && $model->check_gl=='Y')
								{
									$model->addError('voucher_ref', 'Voucher ref tidak boleh kosong');
								}
								if($model->remarks =='')
								{
									$model->addError('remarks', 'Remarks tidak boleh kosong');
								}
								
								if($modelgen->executeSpGen($user)>0)$success=true;
								else
								{
									$success=false;
								}
							}
							//JOURNAL ALL REFUND
							else if($model->tahap=='2' && $model->option =='0')
							{
								$modelgen->stk_cd = $model->stk_cd;
								$modelgen->tahap = 'REFUND';
								$modelgen->gl_acct_bank = $model->gl_acct_bank;
								$modelgen->sl_acct_bank = $model->sl_acct_bank;
								$modelgen->gl_acct_hutang = $model->gl_acct_utang;
								$modelgen->sl_acct_hutang = $model->sl_acct_utang;
								$modelgen->user_id = Yii::app()->user->id;
								$model->scenario = 'ipoentry';
								$user= $model->user_id;
								if($modelgen->executeSpGen($user)>0)$success=true;
								else
								{
									$success=false;
								}
							}
							*/
			
				
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('/finance/Ipofund2/index'));
				}
				else 
				{
					$transaction->rollback();
				}
		
		
			}
			else//save 
			{
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
				$menuName = 'IPO FUND ENTRY';		
				
				$rowCountDana = $_POST['rowCountDana'];
				$rowCountPenjatahan = $_POST['rowCountPenjatahan'];
				$rowCountRefund= $_POST['rowCountRefund'];
				$model->scenario=$rowCountPenjatahan>0?'penjatahan':'ipoentry';
				$valid = $model->validate() && $valid;
				
				if($model->journal_date=='')
				{
					$model->addError('journal_date','Tidak boleh kosong');
					$valid=false;
					
				}
				if($model->remarks =='')
				{
					$model->addError('remarks','Tidak boleh kosong');
					$valid=false;
					
				}
				
				//PENERIMAAN DANA
				$safe1=0;
				for($x=1; $x<= $rowCountDana;$x++)
				{	$modelDetailDana[$x] =  new Tipoclient;
					$modelDetailDana[$x]->attributes = $_POST['Tipoclient'][$x];
					$modelDetailDana[$x]->scenario='ipoentry';
					if(isset($_POST['Tipoclient'][$x]['save_flg']) && $_POST['Tipoclient'][$x]['save_flg'] == 'Y')
					{
						$valid = $modelDetailDana[$x]->validate() && $valid;
						$cek =  Ipofund2::model()->findAllBySql(Ipofund2::checkData($modelDetailDana[$x]->client_cd, $model->journal_date,1,'I',$modelDetailDana[$x]->setor));
						if($cek)
						{
							$modelDetailDana[$x]->addError('client_cd', 'Masih ada yang belum diappove');
							$valid=false;
						}
						if($modelDetailDana[$x]->setor <= '0')
						{
							$modelDetailDana[$x]->addError('setor', 'Tidak boleh lebih kecil atau sama dengan 0');
							$valid=false;
						}
						$client_cd = $modelDetailDana[$x]->client_cd;
						$trx_amt = $modelDetailDana[$x]->setor;
						//$cek2 = Tfundmovement::model()->findAll("doc_date = '$model->offer_dt_fr' and source='IPO' and sl_acct_cd='$model->stk_cd' and client_cd='$client_cd' and trx_amt='$trx_amt' ");
						$cek2 = Tipofund::model()->find(" stk_cd='$model->stk_cd' and client_cd = '$client_cd' and tahap='ALOKASI' ");
						if($cek2)
						{
							$modelDetailDana[$x]->addError('client_cd', "Client $client_cd sudah dijurnal ");
							$valid=false;
						}
						$modelDetailDana[$x]->setor = $modelDetailDana[$x]->setor?$modelDetailDana[$x]->setor:0;
												
					$safe1++;			
					}			
				}

				if($model->tahap =='0' && $model->rdi_type=='NORDI')
				{ 
					$cek =  Ipofund2::model()->findAllBySql(Ipofund2::checkData('UMUM', $model->journal_date, '1', 'I', $model->total_setor));
					if($cek)
					{ 
						$model->addError('stk_cd', 'Masih ada yang belum diappove');
						$valid=false;
					}
					else if($model->batch=='')
					{
						$model->addError('batch', 'Tidak Boleh kosong');
						$valid=false;
					}
					else
				 	{
						$safe1=1;
						$valid=true; 
				  	}	
					
				}
					
				//PENJATAHAN
				$safe2=0;
				for($x=1; $x<= $rowCountPenjatahan;$x++)
				{	$modelDetailPenjatahan[$x] =  new Tipoclient;
					$modelDetailPenjatahan[$x]->attributes = $_POST['Tipoclient'][$x];
					$modelDetailPenjatahan[$x]->scenario='ipoentry';
					$modelDetailPenjatahan[$x]->amount = str_replace(',','', $modelDetailPenjatahan[$x]->amount);
					if(isset($_POST['Tipoclient'][$x]['save_flg']) && $_POST['Tipoclient'][$x]['save_flg'] == 'Y')
					{
						$valid = $modelDetailPenjatahan[$x]->validate() && $valid;
						$cek =  Ipofund2::model()->findAllBySql(Ipofund2::checkData($modelDetailPenjatahan[$x]->client_cd, $model->journal_date,'1','O',$modelDetailPenjatahan[$x]->amount));
						if($cek)
						{
							$modelDetailPenjatahan[$x]->addError('client_cd', 'Masih ada yang belum diappove');
							$valid=false;
						}
						$client_cd = $modelDetailPenjatahan[$x]->client_cd;
						$trx_amt = $modelDetailPenjatahan[$x]->amount;
						//$cek2 = Tfundmovement::model()->findAll("doc_date = '$model->journal_date' and trx_type='O' and source='IPO' and sl_acct_cd='$model->stk_cd' and client_cd='$client_cd' and trx_amt='$trx_amt' ");
						$cek2 = Tipofund::model()->find(" stk_cd='$model->stk_cd' and client_cd = '$client_cd' and tahap='PENJATAHAN' ");
						if($cek2)
						{
							$modelDetailPenjatahan[$x]->addError('client_cd', "Client $client_cd sudah dijurnal ");
							$valid=false;
						}
				
						
					$safe2++;			
					}			
				}
				if($model->tahap =='1' &&$model->rdi_type=='NORDI')
				{
					$cek =  Ipofund2::model()->findAllBySql(Ipofund2::checkData('UMUM', $model->journal_date, '1', 'O', $model->total_setor));
					if($cek)
					{
						$model->addError('stk_cd', 'Masih ada yang belum diappove');
						$valid=false;
					}
					else if($model->batch=='')
					{
						$model->addError('batch', 'Tidak Boleh kosong');
						$valid=false;
					}
					else 
					{
					$safe2=1;
					$valid=true;	
					}	
				}

				//REFUND
				$safe3 =0;
				for($x=1; $x<= $rowCountRefund;$x++)
				{	$modelDetailRefund[$x] =  new Tipoclient;
					$modelDetailRefund[$x]->attributes = $_POST['Tipoclient'][$x];
					$modelDetailRefund[$x]->scenario='ipoentry';
					$modelDetailRefund[$x]->refund = str_replace(',', '', $modelDetailRefund[$x]->refund);
					if(isset($_POST['Tipoclient'][$x]['save_flg']) && $_POST['Tipoclient'][$x]['save_flg'] == 'Y')
					{
						$valid = $modelDetailRefund[$x]->validate() && $valid;
						$cek =  Ipofund2::model()->findAllBySql(Ipofund2::checkData($modelDetailRefund[$x]->client_cd, $model->journal_date,1,'O',$modelDetailRefund[$x]->refund));
						if($cek)
						{
							$modelDetailRefund[$x]->addError('client_cd', 'Masih ada yang belum diappove');
							$valid=false;
						}
						$client_cd = $modelDetailRefund[$x]->client_cd;
						$trx_amt = $modelDetailRefund[$x]->refund;
						//$cek2 = Tfundmovement::model()->findAll("doc_date = '$model->journal_date' and source='IPO' and sl_acct_cd='$model->stk_cd' and client_cd='$client_cd' and trx_amt='$trx_amt' ");
						$cek2 = Tipofund::model()->find(" stk_cd='$model->stk_cd' and client_cd = '$client_cd' and tahap='REFUND' ");
						if($cek2)
						{
							$modelDetailRefund[$x]->addError('client_cd', "Client $client_cd sudah dijurnal ");
							$valid=false;
						}		
						$safe3++;
					}			
				}

				if($model->tahap =='2' &&$model->rdi_type=='NORDI')
				{
					$cek =  Ipofund2::model()->findAllBySql(Ipofund2::checkData('UMUM', $model->journal_date, '1', 'O', $model->total_setor));
					//$cek2 = Tfundmovement::model()->findAll("doc_date = '$model->journal_date' and source='IPO' and sl_acct_cd='$model->stk_cd' and client_cd='UMUM' and trx_amt='$model->total_setor' ");
					if($cek)
					{
						$model->addError('stk_cd', 'Masih ada yang belum diappove');
						$valid=false;
					}
					else if($model->batch=='')
					{
						$model->addError('batch', 'Tidak Boleh kosong');
						$valid=false;
					}
					else 
					{
					$safe3=1;
					$valid=true;	
					}	
						
				}

				if($valid)
				{	
					//PENERIMAAN DANA
					if($rowCountDana>0 && $safe1>0)
					{						
					$recordSeq=1;
					//$no_urut=1;
					for($x=1; $x<= $rowCountDana;$x++)
					{
						if(isset($_POST['Tipoclient'][$x]['save_flg']) && $_POST['Tipoclient'][$x]['save_flg'] == 'Y')
						{
							//EXECUTE SP HEADER
							if($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName)>0)$success=true;
							else{
								$success=false;
							}
							/*
							if($model->rdi_type=='CUKUP')
							{
								$count_journal = $trf_langsung_flg=='Y'?'2':'1';
								//SAVE KE T_FUND_MOVEMENT YANG PUNYA REKENING DANA
								for($y=0;$y<$count_journal;$y++)
								{
									//SAVE TO FUND MOVEMENT
									$modelmovement[$y] = new Tfundmovement;
									//GET DOC_NUM
									$doc_num_type = $y=='1'?'W':'O';
									$sql="SELECT GET_DOCNUM_FUND('$model->journal_date','$doc_num_type')  AS DOC_NUM FROM DUAL";
									$doc=DAO::queryRowSql($sql);
									$doc_num=$doc['doc_num'];
									//GET FOLDER_num
									$sql ="select SEQ_FUND_FOLDER.nextval as num from dual";
									$num=DAO::queryRowSql($sql);
									$folder_num = $num['num'];
									//GET FOLDER_CODE
									$sql="SELECT 'RD'||to_char('$folder_num','fm0000') as folder_cd from dual ";
									$folder=DAO::queryRowSql($sql);
									$folder_cd=$folder['folder_cd'];
									
									$modelmovement[$y]->doc_num = $doc_num;
									$modelmovement[$y]->user_id=$model->user_id;
									$modelmovement[$y]->cre_dt = $model->cre_dt;
									$modelmovement[$y]->update_date = $model->update_date;
									$modelmovement[$y]->update_seq = $model->update_seq;
									$modelmovement[$y]->doc_date = $model->journal_date;
									$modelmovement[$y]->trx_type= $y=='1'?'W':'I';
									$modelmovement[$y]->client_cd = $modelDetailDana[$x]->client_cd;
									$client_cd = $modelDetailDana[$x]->client_cd;
									$modelmovement[$y]->brch_cd = trim(Client::model()->find("client_cd = '$client_cd' ")->branch_code);
									$modelmovement[$y]->source = 'IPO';
									$modelmovement[$y]->bank_mvmt_date='';
									$modelmovement[$y]->acct_name=$modelDetailDana[$x]->client_name;
									$modelmovement[$y]->remarks= 'Pemesanan IPO '.$model->stk_cd;
									$modelmovement[$y]->from_client= $modelDetailDana[$x]->client_cd;
									$modelmovement[$y]->from_acct= Clientflacct::model()->find("client_cd= '$client_cd'  and acct_stat <> 'C'")->bank_acct_num;
									$modelmovement[$y]->from_bank= Clientflacct::model()->find("client_cd= '$client_cd'  and acct_stat <> 'C'")->bank_cd;
									$modelmovement[$y]->to_client= 'IPO';
									$modelmovement[$y]->to_acct = $model->ipo_bank_acct;
									$modelmovement[$y]->to_bank = $model->ipo_bank_cd;
									$modelmovement[$y]->trx_amt = $modelDetailDana[$x]->setor;
									$modelmovement[$y]->fee = 0;
									$modelmovement[$y]->folder_cd=$y=='1'?$folder_cd:'';
									$modelmovement[$y]->fund_bank_cd=$modelmovement[$y]->from_bank;
									$modelmovement[$y]->fund_bank_acct = $modelmovement[$y]->from_acct;
									$modelmovement[$y]->sl_acct_cd = $model->stk_cd;
									if($success && $modelmovement[$y]->executeSp(AConstant::INBOX_STAT_INS,$modelmovement[$y]->doc_num,$y+1)>0)$success=true;
									else{
										$success=false;
									}
									
									
									
									//SAVE TO FUND LEDGER
									for($a=0;$success && $a<2;$a++)
									{
									 	$modelfundledger[$a] = new Tfundledger;
										$modelfundledger[$a]->doc_num = $doc_num;
										$modelfundledger[$a]->seqno=$a+1;
										$modelfundledger[$a]->trx_type=	$modelmovement[$y]->trx_type;
										$modelfundledger[$a]->doc_date = $modelmovement[$y]->doc_date;
										if($a==0)
										{
										$modelfundledger[$a]->acct_cd=$y=='1'?'KNPR':'DNU';
										$modelfundledger[$a]->debit = $modelmovement[$y]->trx_amt;
										$modelfundledger[$a]->credit = 0;
										}
										else
										{
											$modelfundledger[$a]->acct_cd=$y=='1'?'DBEBAS':'KNU';
											$modelfundledger[$a]->debit = 0;
											$modelfundledger[$a]->credit = $modelmovement[$y]->trx_amt;;
										}
										
										$modelfundledger[$a]->client_cd = $modelmovement[$y]->client_cd;
										
										$modelfundledger[$a]->user_id= $model->user_id;
										$modelfundledger[$a]->cre_dt = $model->cre_dt;
										$modelfundledger[$a]->manual='Y';
										
										if($success && $modelfundledger[$a]->executeSp(AConstant::INBOX_STAT_INS,$modelfundledger[$a]->doc_num,$modelfundledger[$a]->seqno,$model->update_date,$model->update_seq,$recordSeq)>0)$success=TRUE;
										else{
											$success=false;
										}
										$recordSeq++;
										
											
										if($modelfundledger[$a]->acct_cd =='DNU')
										{
										//SAVE TO IPO FUND
										$modelIpofund2[$a] = new Tipofund;
										$modelIpofund2[$a]->client_cd = $modelmovement[$y]->client_cd;
										$modelIpofund2[$a]->stk_cd = $model->stk_cd;
										$modelIpofund2[$a]->cre_dt = $model->cre_dt;
										$modelIpofund2[$a]->tahap = 'ALOKASI';
										$modelIpofund2[$a]->doc_num = $modelmovement[$y]->doc_num;
										$modelIpofund2[$a]->user_id=$model->user_id;
										
										if($success && $modelIpofund2[$a]->executeSp(AConstant::INBOX_STAT_INS,$modelIpofund2[$a]->stk_cd,$modelIpofund2[$a]->client_cd,$model->update_date,$model->update_seq,1)>0)$success=true;
										else{
											$success=false;
										}
										
										}
									}//SAVE TO FUND LEDGER
										
									//SAVE KE T_FUND_TRF dengan menggunakan doc num W
									if($doc_num_type =='W' && $trf_langsung_flg=='Y' )
									{
										$modelFundTrf = new Tfundtrf;
										$modelFundTrf->trf_date = $modelmovement[$y]->doc_date;
										$modelFundTrf->trf_id = 'IPO';
										$modelFundTrf->doc_num = $modelmovement[$y]->doc_num;
										$modelFundTrf->client_cd = $modelmovement[$y]->client_cd;
										$modelFundTrf->fund_bank_cd =  'BCA';
										$modelFundTrf->trf_type = 'RDCL';
										$modelFundTrf->trf_flg = 'N';
										$modelFundTrf->trf_timestamp = $model->cre_dt;
										$modelFundTrf->trf_amt = $modelmovement[$y]->trx_amt;
										$modelFundTrf->user_id = $model->user_id;
										$modelFundTrf->update_date = $model->update_date;
										$modelFundTrf->update_seq = $model->update_seq;
										
										if($success && $modelFundTrf->executeSp(AConstant::INBOX_STAT_INS, $modelFundTrf->trf_date, $modelFundTrf->trf_id, $modelFundTrf->doc_num , 1)>0){
											$success=TRUE;
										}
										else {
											$success=false;
										}
									}
								}//END count rekening dana SAVE KE T_FUND_MOVEMENT YANG PUNYA REKENING DANA
							
						   }//END UNTUK YANG PUNYA REK DANA
						*/
							//SAVE utk yg  punya Rek Dana dan SALDO TIDAK CUKUP
							if($model->rdi_type =='CUKUP') //else if($model->rdi_type =='KURANG')
							{
								for($y=0;$y<1;$y++)
								{
									//SAVE TO FUND MOVEMENT
									$modelmovement[$y] = new Tfundmovement;
									$sql="SELECT GET_DOCNUM_FUND('$model->journal_date','O')  AS DOC_NUM FROM DUAL";
									$doc=DAO::queryRowSql($sql);
									$doc_num=$doc['doc_num'];
																	
									$modelmovement[$y]->doc_num = $doc_num;
									$modelmovement[$y]->user_id=$model->user_id;
									$modelmovement[$y]->cre_dt = $model->cre_dt;
									$modelmovement[$y]->update_date = $model->update_date;
									$modelmovement[$y]->update_seq = $model->update_seq;
									$modelmovement[$y]->doc_date = $model->journal_date;
									$modelmovement[$y]->trx_type= 'I';
									$modelmovement[$y]->client_cd = $modelDetailDana[$x]->client_cd;
									$client_cd = $modelDetailDana[$x]->client_cd;
									$modelmovement[$y]->brch_cd = trim(Client::model()->find("client_cd = '$client_cd' ")->branch_code);
									$modelmovement[$y]->source = 'IPO';
									$modelmovement[$y]->bank_mvmt_date='';
									$modelmovement[$y]->acct_name=$modelDetailDana[$x]->client_name;
									$modelmovement[$y]->remarks= $model->remarks;
									$modelmovement[$y]->from_client = $modelmovement[$y]->client_cd;
									$modelmovement[$y]->from_acct= '-';
									$modelmovement[$y]->from_bank= '-';
									$modelmovement[$y]->to_client= 'NU';
									$modelmovement[$y]->to_acct = $model->ipo_bank_acct;
									$modelmovement[$y]->to_bank = $model->ipo_bank_cd;
									$modelmovement[$y]->trx_amt = $modelDetailDana[$x]->setor;
									$modelmovement[$y]->fee = 0;
									$modelmovement[$y]->folder_cd='';
									$modelmovement[$y]->fund_bank_cd=Clientflacct::model()->find("client_cd= '$client_cd'  and acct_stat <> 'C'")->bank_cd;
									$modelmovement[$y]->fund_bank_acct = Clientflacct::model()->find("client_cd= '$client_cd'  and acct_stat <> 'C'")->bank_acct_num;
									$modelmovement[$y]->sl_acct_cd =$model->stk_cd;
									
									if($success && $modelmovement[$y]->executeSp(AConstant::INBOX_STAT_INS,$modelmovement[$y]->doc_num,$y+1)>0)$success=true;
									else{
										$success=false;
									}
									
									//SAVE TO FUND LEDGER
									for($a=0;$success && $a<2;$a++)
									{
									 	$modelfundledger[$a] = new Tfundledger;
										$modelfundledger[$a]->doc_num = $doc_num;
										$modelfundledger[$a]->seqno=$a+1;
										$modelfundledger[$a]->trx_type=	$modelmovement[$y]->trx_type;
										$modelfundledger[$a]->doc_date = $modelmovement[$y]->doc_date;
										if($a==0)
										{
										$modelfundledger[$a]->acct_cd='DNU';
										$modelfundledger[$a]->debit = $modelmovement[$y]->trx_amt;
										$modelfundledger[$a]->credit = 0;
										}
										else
										{
											$modelfundledger[$a]->acct_cd='KNU';
											$modelfundledger[$a]->debit = 0;
											$modelfundledger[$a]->credit = $modelmovement[$y]->trx_amt;;
										}
										
										$modelfundledger[$a]->client_cd = $modelmovement[$y]->client_cd;
										
										$modelfundledger[$a]->user_id= $model->user_id;
										$modelfundledger[$a]->cre_dt = $model->cre_dt;
										$modelfundledger[$a]->manual='Y';
										
										if($success && $modelfundledger[$a]->executeSp(AConstant::INBOX_STAT_INS,$modelfundledger[$a]->doc_num,$modelfundledger[$a]->seqno,$model->update_date,$model->update_seq,$recordSeq)>0)$success=TRUE;
										else{
											$success=false;
										}
										$recordSeq++;
										
										if($modelfundledger[$a]->acct_cd =='DNU')
										{
										//SAVE TO IPO FUND
										$modelIpofund2[$a] = new Tipofund;
										$modelIpofund2[$a]->client_cd = $modelmovement[$y]->client_cd;
										$modelIpofund2[$a]->stk_cd = $model->stk_cd;
										$modelIpofund2[$a]->cre_dt = $model->cre_dt;
										$modelIpofund2[$a]->tahap = 'ALOKASI';
										$modelIpofund2[$a]->doc_num = $modelmovement[$y]->doc_num;
										$modelIpofund2[$a]->user_id=$model->user_id;
										if($success && $modelIpofund2[$a]->executeSp(AConstant::INBOX_STAT_INS,$modelIpofund2[$a]->stk_cd,$modelIpofund2[$a]->client_cd,$modelIpofund2[$a]->tahap,$model->update_date,$model->update_seq,1)>0)$success=true;
										else{
											$success=false;
										}
										
										}
									}
									
								}
							}
						}//end save flg=Y
					}//end rowCoundDana	PADA LOOPING PER BARIS						
							//SAVE T_FUND UNTUK YANG TIDAK PUNYA REK DANA
					if($model->rdi_type =='NORDI')
					{
						//EXECUTE SP HEADER
						if($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName)>0)$success=true;
						else{
							$success=false;
						}
					
						for($y=0;$y<1;$y++)
						{
							//SAVE TO FUND MOVEMENT
							$modelmovement[$y] = new Tfundmovement;
							$sql="SELECT GET_DOCNUM_FUND('$model->journal_date','O')  AS DOC_NUM FROM DUAL";
							$doc=DAO::queryRowSql($sql);
							$doc_num=$doc['doc_num'];
						
							$modelmovement[$y]->doc_num = $doc_num;
							$modelmovement[$y]->user_id=$model->user_id;
							$modelmovement[$y]->cre_dt = $model->cre_dt;
							$modelmovement[$y]->update_date = $model->update_date;
							$modelmovement[$y]->update_seq = $model->update_seq;
							$modelmovement[$y]->doc_date = $model->journal_date;
							$modelmovement[$y]->trx_type= 'I';
							$modelmovement[$y]->client_cd = 'UMUM';
							$modelmovement[$y]->brch_cd ='JK';
							$modelmovement[$y]->source = 'IPO';
							$modelmovement[$y]->bank_mvmt_date='';
							$modelmovement[$y]->acct_name='UMUM';
							$modelmovement[$y]->remarks= $model->remarks;
							$modelmovement[$y]->from_client='NU';
							$modelmovement[$y]->from_acct= '-';
							$modelmovement[$y]->from_bank= '-';
							$modelmovement[$y]->to_client= 'NU';
							$modelmovement[$y]->to_acct = $model->ipo_bank_acct;
							$modelmovement[$y]->to_bank = $model->ipo_bank_cd;
							$modelmovement[$y]->trx_amt = $model->total_setor;
							$modelmovement[$y]->fee = 0;
							$modelmovement[$y]->folder_cd='';
							$modelmovement[$y]->fund_bank_cd='NA';
							$modelmovement[$y]->fund_bank_acct = 'NA';
							$modelmovement[$y]->sl_acct_cd =$model->stk_cd;
							if($success && $modelmovement[$y]->executeSp(AConstant::INBOX_STAT_INS,$modelmovement[$y]->doc_num,$y+1)>0)$success=true;
							else{
								$success=false;
							}
							
							//SAVE TO FUND LEDGER
							for($a=0;$success && $a<2;$a++)
							{
								 	$modelfundledger[$a] = new Tfundledger;
									$modelfundledger[$a]->doc_num = $doc_num;
									$modelfundledger[$a]->seqno=$a+1;
									$modelfundledger[$a]->trx_type=	$modelmovement[$y]->trx_type;
									$modelfundledger[$a]->doc_date = $modelmovement[$y]->doc_date;
									if($a==0)
									{
									$modelfundledger[$a]->acct_cd='DNU';
									$modelfundledger[$a]->debit = $modelmovement[$y]->trx_amt;
									$modelfundledger[$a]->credit = 0;
									}
									else
									{
										$modelfundledger[$a]->acct_cd='KNU';
										$modelfundledger[$a]->debit = 0;
										$modelfundledger[$a]->credit = $modelmovement[$y]->trx_amt;
									}
									
									$modelfundledger[$a]->client_cd = $modelmovement[$y]->client_cd;
									$modelfundledger[$a]->user_id= $model->user_id;
									$modelfundledger[$a]->cre_dt = $model->cre_dt;
									$modelfundledger[$a]->manual='Y';
									
									if($success && $modelfundledger[$a]->executeSp(AConstant::INBOX_STAT_INS,$modelfundledger[$a]->doc_num,$modelfundledger[$a]->seqno,$model->update_date,$model->update_seq,$recordSeq)>0)$success=TRUE;
									else{
										$success=false;
									}
									$recordSeq++;
									
										
									if($modelfundledger[$a]->acct_cd =='DNU')
									{
									//SAVE TO IPO FUND
									$modelIpofund2[$a] = new Tipofund;
									$modelIpofund2[$a]->client_cd = $modelmovement[$y]->client_cd;
									$modelIpofund2[$a]->stk_cd = $model->stk_cd;
									$modelIpofund2[$a]->cre_dt = $model->cre_dt;
									$modelIpofund2[$a]->tahap = 'ALOKASI';
									$modelIpofund2[$a]->doc_num = $modelmovement[$y]->doc_num;
									$modelIpofund2[$a]->user_id=$model->user_id;
									if($success && $modelIpofund2[$a]->executeSp(AConstant::INBOX_STAT_INS,$modelIpofund2[$a]->stk_cd,$modelIpofund2[$a]->client_cd,$modelIpofund2[$a]->tahap,$model->update_date,$model->update_seq,1)>0)$success=true;
									else{
										$success=false;
									}
									}
							}
							
						}//END SAVE KE T_FUND_MOVEMENT YANG TIDAK PUNYA REKENING DANA
						
					}//END TIDAK PUNYA REKENING DANA
					
					}//end if rowCount Dana>0
				
					//PENJATAHAN
					if($rowCountPenjatahan>0  && $safe2>0 )
					{
						//SAVE T FUND MOVEMENT YANG PUNYA REKENING DANA
						if($model->rdi_type == 'CUKUP')
						{
							//SAVE KE T FUND MOVEMENT
							$recordSeq=1;
							for($x=1; $x<= $rowCountPenjatahan;$x++)
							{
								if(isset($_POST['Tipoclient'][$x]['save_flg']) && $_POST['Tipoclient'][$x]['save_flg'] == 'Y')
								{
									//EXECUTE SP HEADER
									if($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName)>0)$success=true;
									else{
										$success=false;
									}
									$modelmovement[$x]= new Tfundmovement;
									$sql="SELECT GET_DOCNUM_FUND('$model->journal_date','O')  AS DOC_NUM FROM DUAL";
									$doc=DAO::queryRowSql($sql);
									$doc_num=$doc['doc_num'];
									
									$modelmovement[$x]->doc_num = $doc_num;
									$modelmovement[$x]->doc_date = $model->journal_date;
									$modelmovement[$x]->trx_type= 'O';
									$modelmovement[$x]->client_cd = $modelDetailPenjatahan[$x]->client_cd;
									$client_cd = $modelmovement[$x]->client_cd;
									$modelmovement[$x]->brch_cd = trim(Client::model()->find("client_cd = '$client_cd' ")->branch_code);
									$modelmovement[$x]->source = 'IPO';
									$modelmovement[$x]->bank_mvmt_date='';
									$modelmovement[$x]->acct_name=$modelDetailPenjatahan[$x]->client_name;
									$modelmovement[$x]->remarks= $model->remarks;
									$modelmovement[$x]->from_client= $modelDetailPenjatahan[$x]->client_cd;
									$modelmovement[$x]->from_acct= $model->ipo_bank_acct;
									$modelmovement[$x]->from_bank= $model->ipo_bank_cd;
									$modelmovement[$x]->to_client= 'PE';
									$modelmovement[$x]->to_acct = $model->ipo_bank_acct;;
									$modelmovement[$x]->to_bank = $model->ipo_bank_cd;;
									$modelmovement[$x]->trx_amt = $modelDetailPenjatahan[$x]->amount;
									$modelmovement[$x]->fee = 0;
									$modelmovement[$x]->folder_cd='';
									$modelmovement[$x]->fund_bank_cd= Clientflacct::model()->find("client_cd = '$client_cd' and acct_stat in ('A','I') ")->bank_cd;
									$modelmovement[$x]->fund_bank_acct = Clientflacct::model()->find("client_cd = '$client_cd' and acct_stat in ('A','I') ")->bank_acct_num;
									$modelmovement[$x]->sl_acct_cd=$model->stk_cd;
									$modelmovement[$x]->user_id=$model->user_id;
									$modelmovement[$x]->cre_dt = $model->cre_dt;
									$modelmovement[$x]->update_date = $model->update_date;
									$modelmovement[$x]->update_seq = $model->update_seq;
									if($success && $modelmovement[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelmovement[$x]->doc_num,'1')>0)$success=true;
									else{
										$success=false;
									}
								
									//SAVE KE T FUND LEDGER 
									for($y=0;$y<2;$y++)
									{
										$modelfundledger[$y] = new Tfundledger;
										$modelfundledger[$y]->doc_num = $doc_num;
										$modelfundledger[$y]->seqno=$y+1;
										$modelfundledger[$y]->trx_type='O';
										$modelfundledger[$y]->doc_date = $modelmovement[$x]->doc_date;
										$modelfundledger[$y]->acct_cd=$y==0?'KNU':'DNU';
										$modelfundledger[$y]->client_cd = $modelmovement[$x]->client_cd;
										$modelfundledger[$y]->debit = $y==0?$modelmovement[$x]->trx_amt:0;
										$modelfundledger[$y]->credit = $y==1?$modelmovement[$x]->trx_amt:0;
										$modelfundledger[$y]->user_id= $model->user_id;
										$modelfundledger[$y]->cre_dt = $model->cre_dt;
										$modelfundledger[$y]->manual='Y';
								
										if($success && $modelfundledger[$y]->executeSp(AConstant::INBOX_STAT_INS,$modelfundledger[$y]->doc_num,$modelfundledger[$y]->seqno,$model->update_date,$model->update_seq,$y+1)>0)$success=TRUE;
										else{
											$success=false;
										}
										
										if($modelfundledger[$y]->acct_cd =='DNU')
										{
										//SAVE TO IPO FUND
										$modelIpofund2[$y] = new Tipofund;
										$modelIpofund2[$y]->client_cd = $modelmovement[$x]->client_cd;
										$modelIpofund2[$y]->stk_cd = $model->stk_cd;
										$modelIpofund2[$y]->cre_dt = $model->cre_dt;
										$modelIpofund2[$y]->tahap = 'PENJATAHAN';
										$modelIpofund2[$y]->doc_num = $modelmovement[$x]->doc_num;
										$modelIpofund2[$y]->user_id=$model->user_id;
										if($success && $modelIpofund2[$y]->executeSp(AConstant::INBOX_STAT_INS,$modelIpofund2[$y]->stk_cd,$modelIpofund2[$y]->client_cd,$modelIpofund2[$y]->tahap,$model->update_date,$model->update_seq,1)>0)$success=true;
										else{
											$success=false;
										}
										
										}
										
										
									}
									$recordSeq++;	
								}//end if save flg='y'
							}//END $rowCountPenjatahan
						}//SAVE T FUND MOVEMENT YANG PUNYA REKENING DANA
				
						//SAVE T FUND MOVEMENT YANG TIDAK PUNYA REKENING DANA
						else
						{
							//EXECUTE SP HEADER
							if($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName)>0)$success=true;
							else{
								$success=false;
							}
							//SAVE KE T FUND MOVEMENT
							$recordSeq=1;
							for($x=1; $x<= 1;$x++)
							{						 	
								$modelmovement[$x]= new Tfundmovement;
								$sql="SELECT GET_DOCNUM_FUND('$model->journal_date','O')  AS DOC_NUM FROM DUAL";
								$doc=DAO::queryRowSql($sql);
								$doc_num=$doc['doc_num'];
								
								$modelmovement[$x]->doc_num = $doc_num;
								$modelmovement[$x]->doc_date = $model->journal_date;
								$modelmovement[$x]->trx_type= 'O';
								$modelmovement[$x]->client_cd ='UMUM';
								$modelmovement[$x]->brch_cd = 'JK';
								$modelmovement[$x]->source = 'IPO';
								$modelmovement[$x]->bank_mvmt_date='';
								$modelmovement[$x]->acct_name='UMUM';
								$modelmovement[$x]->remarks=$model->remarks;
								$modelmovement[$x]->from_client= 'UMUM';
								$modelmovement[$x]->from_acct= $model->ipo_bank_acct;
								$modelmovement[$x]->from_bank= $model->ipo_bank_cd;
								$modelmovement[$x]->to_client= 'PE';
								$modelmovement[$x]->to_acct = $model->ipo_bank_acct;;
								$modelmovement[$x]->to_bank = $model->ipo_bank_cd;;
								$modelmovement[$x]->trx_amt = $model->total_setor;
								$modelmovement[$x]->fee = 0;
								$modelmovement[$x]->folder_cd='';
								$modelmovement[$x]->fund_bank_cd= 'NA';
								$modelmovement[$x]->fund_bank_acct = 'NA';
								$modelmovement[$x]->sl_acct_cd=$model->stk_cd;
								$modelmovement[$x]->user_id=$model->user_id;
								$modelmovement[$x]->cre_dt = $model->cre_dt;
								$modelmovement[$x]->update_date = $model->update_date;
								$modelmovement[$x]->update_seq = $model->update_seq;
								if($success && $modelmovement[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelmovement[$x]->doc_num,$recordSeq)>0)$success=true;
								else{
									$success=false;
								}
							
								
								//SAVE KE T FUND LEDGER 
								for($y=0;$y<2;$y++)
								{
									$modelfundledger[$y] = new Tfundledger;
									$modelfundledger[$y]->doc_num = $doc_num;
									$modelfundledger[$y]->seqno=$y+1;
									$modelfundledger[$y]->trx_type='O';
									$modelfundledger[$y]->doc_date =$modelmovement[$x]->doc_date;
									$modelfundledger[$y]->acct_cd=$y==0?'KNU':'DNU';
									$modelfundledger[$y]->client_cd = $modelmovement[$x]->client_cd;
									$modelfundledger[$y]->debit = $y==0?$modelmovement[$x]->trx_amt:0;
									$modelfundledger[$y]->credit = $y==1?$modelmovement[$x]->trx_amt:0;
									$modelfundledger[$y]->user_id= $model->user_id;
									$modelfundledger[$y]->cre_dt = $model->cre_dt;
									$modelfundledger[$y]->manual='Y';
							
									if($success && $modelfundledger[$y]->executeSp(AConstant::INBOX_STAT_INS,$modelfundledger[$y]->doc_num,$modelfundledger[$y]->seqno,$model->update_date,$model->update_seq,$y+1)>0)$success=TRUE;
									else{
										$success=false;
									}
									
									if($modelfundledger[$y]->acct_cd =='DNU')
										{
										//SAVE TO IPO FUND
										$modelIpofund2[$y] = new Tipofund;
										$modelIpofund2[$y]->client_cd = $modelmovement[$x]->client_cd;
										$modelIpofund2[$y]->stk_cd = $model->stk_cd;
										$modelIpofund2[$y]->cre_dt = $model->cre_dt;
										$modelIpofund2[$y]->tahap = 'PENJATAHAN';
										$modelIpofund2[$y]->doc_num = $modelmovement[$x]->doc_num;
										$modelIpofund2[$y]->user_id=$model->user_id;
										if($success && $modelIpofund2[$y]->executeSp(AConstant::INBOX_STAT_INS,$modelIpofund2[$y]->stk_cd,$modelIpofund2[$y]->client_cd,$modelIpofund2[$y]->tahap,$model->update_date,$model->update_seq,1)>0)$success=true;
										else{
											$success=false;
										}
										
										}
										
								}
								$recordSeq++;	
							}//END $rowCountPenjatahan
						}//end SAVE T FUND MOVEMENT YANG TIDAK PUNYA REKENING DANA	
				}//end if rowcountPenjatahan>0
				
				
				//REFUND
				if($rowCountRefund>0  && $safe3>0)
				{
					//REFUND UNTUK YANG PUNYA RDI
					if($model->rdi_type =='CUKUP')
					{
					$recordSeq=1;
					for($x=1; $x<= $rowCountRefund;$x++)
					{
						if(isset($_POST['Tipoclient'][$x]['save_flg']) && $_POST['Tipoclient'][$x]['save_flg'] == 'Y')
						{
						 	//EXECUTE SP HEADER
							if($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName)>0)$success=true;
							else{
								$success=false;
							}
							
							for($y=0;$y<1;$y++)
							{
								//SAVE TO FUND MOVEMENT
								$modelmovement[$y] = new Tfundmovement;
								$type = $y==0?'O':'R';
								$sql="SELECT GET_DOCNUM_FUND('$model->journal_date','$type')  AS DOC_NUM FROM DUAL";
								$doc=DAO::queryRowSql($sql);
								$doc_num=$doc['doc_num'];
								/*
								//GET FOLDER_num
								$sql ="select SEQ_FUND_FOLDER.nextval as num from dual";
								$num=DAO::queryRowSql($sql);
								$folder_num = $num['num'];
								//GET FOLDER_CODE
								$sql="SELECT 'RD'||to_char('$folder_num','fm0000') as folder_cd from dual ";
								$folder=DAO::queryRowSql($sql);
								$folder_cd=$folder['folder_cd'];
								 * 
								 */
								$modelmovement[$y]->doc_num = $doc_num;
								$modelmovement[$y]->doc_date = $model->journal_date;
								$modelmovement[$y]->trx_type= $type;
								$modelmovement[$y]->client_cd = $modelDetailRefund[$x]->client_cd;
								$client_cd = $modelDetailRefund[$x]->client_cd;
								$modelmovement[$y]->brch_cd = trim(Client::model()->find("client_cd = '$client_cd' ")->branch_code);
								$modelmovement[$y]->source = 'IPO';
								$modelmovement[$y]->bank_mvmt_date='';
								$modelmovement[$y]->acct_name=$modelDetailRefund[$x]->client_name;
								$modelmovement[$y]->remarks= $model->remarks;
								$modelmovement[$y]->from_client= 'IPO';
								$modelmovement[$y]->from_acct= $model->ipo_bank_acct;
								$modelmovement[$y]->from_bank= $model->ipo_bank_cd;
								$modelmovement[$y]->to_client= $client_cd;
								$modelmovement[$y]->to_acct =  Clientflacct::model()->find("client_cd = '$client_cd' and acct_stat in ('A','I') ")->bank_acct_num;
								$modelmovement[$y]->to_bank = Clientflacct::model()->find("client_cd = '$client_cd' and acct_stat in ('A','I') ")->bank_cd;
								$modelmovement[$y]->trx_amt = $modelDetailRefund[$x]->refund;
								$modelmovement[$y]->fee = 0;
								$modelmovement[$y]->folder_cd='';
								$modelmovement[$y]->fund_bank_cd=$modelmovement[$y]->from_bank;
								$modelmovement[$y]->fund_bank_acct = $modelmovement[$y]->from_acct;
								$modelmovement[$y]->sl_acct_cd=$model->stk_cd;
								$modelmovement[$y]->user_id=$model->user_id;
								$modelmovement[$y]->cre_dt = $model->cre_dt;
								$modelmovement[$y]->update_date = $model->update_date;
								$modelmovement[$y]->update_seq = $model->update_seq;
								if($success && $modelmovement[$y]->executeSp(AConstant::INBOX_STAT_INS,$modelmovement[$y]->doc_num,$y+1)>0)$success=true;
								else{
									$success=false;
								}
							
								//SAVE TO FUND LEDGER
								for($a=0;$success && $a<2;$a++)
								{
								 	$modelfundledger[$a] = new Tfundledger;
									$modelfundledger[$a]->doc_num = $doc_num;
									
									$modelfundledger[$a]->seqno=$a+1;
									$modelfundledger[$a]->trx_type=$modelmovement[$y]->trx_type;
									$modelfundledger[$a]->doc_date = $modelmovement[$y]->doc_date;
									if($a==0)
									{
									$modelfundledger[$a]->acct_cd=$y=='0'?'KNU':'DBEBAS';
									$modelfundledger[$a]->debit = $modelmovement[$y]->trx_amt;
									$modelfundledger[$a]->credit = 0;
									}
									else
									{
										$modelfundledger[$a]->acct_cd=$y=='0'?'DNU':'KNPR';
										$modelfundledger[$a]->debit = 0;
										$modelfundledger[$a]->credit = $modelmovement[$y]->trx_amt;;
									}
									$modelfundledger[$a]->client_cd = $modelmovement[$y]->client_cd;
									$modelfundledger[$a]->user_id= $model->user_id;
									$modelfundledger[$a]->cre_dt = $model->cre_dt;
									$modelfundledger[$a]->manual='Y';
									
									if($success && $modelfundledger[$a]->executeSp(AConstant::INBOX_STAT_INS,$modelfundledger[$a]->doc_num,$modelfundledger[$a]->seqno,$model->update_date,$model->update_seq,$recordSeq)>0)$success=TRUE;
									else{
										$success=false;
									}
									
									if($modelfundledger[$a]->acct_cd =='DNU')
									{
									//SAVE TO IPO FUND
									$modelIpofund2[$a] = new Tipofund;
									$modelIpofund2[$a]->client_cd = $modelmovement[$y]->client_cd;
									$modelIpofund2[$a]->stk_cd = $model->stk_cd;
									$modelIpofund2[$a]->cre_dt = $model->cre_dt;
									$modelIpofund2[$a]->tahap = 'REFUND';
									$modelIpofund2[$a]->doc_num = $modelmovement[$y]->doc_num;
									$modelIpofund2[$a]->user_id=$model->user_id;
									if($success && $modelIpofund2[$a]->executeSp(AConstant::INBOX_STAT_INS,$modelIpofund2[$a]->stk_cd,$modelIpofund2[$a]->client_cd,$modelIpofund2[$a]->tahap,$model->update_date,$model->update_seq,1)>0)$success=true;
									else{
										$success=false;
									}
									}
									
								$recordSeq++;
								}
							}
						}//end save flg=Y
					}//end rowCoundRefund
					}//end refund yang punya RDI
					
					//REFUND UNTUK YANG TIDAK PUNYA REKENING DANA
					else 
					{
						 	//EXECUTE SP HEADER
							if($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName)>0)$success=true;
							else{
								$success=false;
							}
							$recordSeq=1;
							for($y=0;$y<1;$y++)
							{
								//SAVE TO FUND MOVEMENT
								$modelmovement[$y] = new Tfundmovement;
								$type ='O';
								$sql="SELECT GET_DOCNUM_FUND('$model->journal_date','$type')  AS DOC_NUM FROM DUAL";
								$doc=DAO::queryRowSql($sql);
								$doc_num=$doc['doc_num'];
								
								$modelmovement[$y]->doc_num = $doc_num;
								$modelmovement[$y]->doc_date = $model->journal_date;
								$modelmovement[$y]->trx_type= $type;
								$modelmovement[$y]->client_cd = 'UMUM';
								$modelmovement[$y]->brch_cd ='JK';
								$modelmovement[$y]->source = 'IPO';
								$modelmovement[$y]->bank_mvmt_date='';
								$modelmovement[$y]->acct_name= 'UMUM';
								$modelmovement[$y]->remarks= $model->remarks;
								$modelmovement[$y]->from_client= 'IPO';
								$modelmovement[$y]->from_acct= $model->ipo_bank_acct;
								$modelmovement[$y]->from_bank= $model->ipo_bank_cd;
								$modelmovement[$y]->to_client= 'NU';
								$modelmovement[$y]->to_acct = '-';
								$modelmovement[$y]->to_bank = '-';
								$modelmovement[$y]->trx_amt = $model->total_setor;
								$modelmovement[$y]->fee = 0;
								$modelmovement[$y]->folder_cd='';
								$modelmovement[$y]->fund_bank_cd='NA';
								$modelmovement[$y]->fund_bank_acct = 'NA';
								$modelmovement[$y]->sl_acct_cd=$model->stk_cd;
								$modelmovement[$y]->user_id=$model->user_id;
								$modelmovement[$y]->cre_dt = $model->cre_dt;
								$modelmovement[$y]->update_date = $model->update_date;
								$modelmovement[$y]->update_seq = $model->update_seq;
								if($success && $modelmovement[$y]->executeSp(AConstant::INBOX_STAT_INS,$modelmovement[$y]->doc_num,$y+1)>0)$success=true;
								else{
									$success=false;
								}
							
								//SAVE TO FUND LEDGER
								for($a=0;$success && $a<2;$a++)
								{
								 	$modelfundledger[$a] = new Tfundledger;
									$modelfundledger[$a]->doc_num = $doc_num;
									
									$modelfundledger[$a]->seqno=$a+1;
									$modelfundledger[$a]->trx_type=$modelmovement[$y]->trx_type;
									$modelfundledger[$a]->doc_date = $modelmovement[$y]->doc_date;
									if($a==0)
									{
										$modelfundledger[$a]->acct_cd='KNU';
										$modelfundledger[$a]->debit = $modelmovement[$y]->trx_amt;
										$modelfundledger[$a]->credit = 0;
									}
									else
									{
										$modelfundledger[$a]->acct_cd='DNU';
										$modelfundledger[$a]->debit = 0;
										$modelfundledger[$a]->credit = $modelmovement[$y]->trx_amt;;
									}
									$modelfundledger[$a]->client_cd = $modelmovement[$y]->client_cd;
									$modelfundledger[$a]->user_id= $model->user_id;
									$modelfundledger[$a]->cre_dt = $model->cre_dt;
									$modelfundledger[$a]->manual='Y';
									
									if($success && $modelfundledger[$a]->executeSp(AConstant::INBOX_STAT_INS,$modelfundledger[$a]->doc_num,$modelfundledger[$a]->seqno,$model->update_date,$model->update_seq,$recordSeq)>0)$success=TRUE;
									else{
										$success=false;
									}
									
									
									if($modelfundledger[$a]->acct_cd =='DNU')
									{
									//SAVE TO IPO FUND
									$modelIpofund2[$a] = new Tipofund;
									$modelIpofund2[$a]->client_cd = $modelmovement[$y]->client_cd;
									$modelIpofund2[$a]->stk_cd = $model->stk_cd;
									$modelIpofund2[$a]->cre_dt = $model->cre_dt;
									$modelIpofund2[$a]->tahap = 'REFUND';
									$modelIpofund2[$a]->doc_num = $modelmovement[$y]->doc_num;
									$modelIpofund2[$a]->user_id=$model->user_id;
									if($success && $modelIpofund2[$a]->executeSp(AConstant::INBOX_STAT_INS,$modelIpofund2[$a]->stk_cd,$modelIpofund2[$a]->client_cd,$modelIpofund2[$a]->tahap,$model->update_date,$model->update_seq,1)>0)$success=true;
									else{
										$success=false;
									}
									}
									
									
								$recordSeq++;
								}
							}
					}//END REFUND YANG TIDAK PUNYA REKENING DANA
				}
				
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('/finance/Ipofund2/index'));
				}
				else 
				{
					$transaction->rollback();
				}
				
				}//end valid
			}
		}

if(DateTime::createFromFormat('Y-m-d H:i:s',$model->paym_dt))$model->paym_dt=DateTime::createFromFormat('Y-m-d H:i:s',$model->paym_dt)->format('d/m/Y');
if(DateTime::createFromFormat('Y-m-d H:i:s',$model->offer_dt_fr))$model->offer_dt_fr=DateTime::createFromFormat('Y-m-d H:i:s',$model->offer_dt_fr)->format('d/m/Y');
if(DateTime::createFromFormat('Y-m-d H:i:s',$model->offer_dt_to))$model->offer_dt_to=DateTime::createFromFormat('Y-m-d H:i:s',$model->offer_dt_to)->format('d/m/Y');
if(DateTime::createFromFormat('Y-m-d H:i:s',$model->allocate_dt))$model->allocate_dt=DateTime::createFromFormat('Y-m-d H:i:s',$model->allocate_dt)->format('d/m/Y');
if(DateTime::createFromFormat('Y-m-d H:i:s',$model->distrib_dt_to))$model->distrib_dt_to=DateTime::createFromFormat('Y-m-d H:i:s',$model->distrib_dt_to)->format('d/m/Y');
if(DateTime::createFromFormat('Y-m-d H:i:s',$model->distrib_dt_to))$model->distrib_dt_to=DateTime::createFromFormat('Y-m-d H:i:s',$model->distrib_dt_to)->format('d/m/Y');

if(DateTime::createFromFormat('Y-m-d',$model->paym_dt))$model->paym_dt=DateTime::createFromFormat('Y-m-d',$model->paym_dt)->format('d/m/Y');
if(DateTime::createFromFormat('Y-m-d',$model->offer_dt_fr))$model->offer_dt_fr=DateTime::createFromFormat('Y-m-d',$model->offer_dt_fr)->format('d/m/Y');
if(DateTime::createFromFormat('Y-m-d',$model->offer_dt_to))$model->offer_dt_to=DateTime::createFromFormat('Y-m-d',$model->offer_dt_to)->format('d/m/Y');
if(DateTime::createFromFormat('Y-m-d',$model->allocate_dt))$model->allocate_dt=DateTime::createFromFormat('Y-m-d',$model->allocate_dt)->format('d/m/Y');
if(DateTime::createFromFormat('Y-m-d',$model->distrib_dt_to))$model->distrib_dt_to=DateTime::createFromFormat('Y-m-d',$model->distrib_dt_to)->format('d/m/Y');
if(DateTime::createFromFormat('Y-m-d',$model->distrib_dt_to))$model->distrib_dt_to=DateTime::createFromFormat('Y-m-d',$model->distrib_dt_to)->format('d/m/Y');
if(DateTime::createFromFormat('Y-m-d',$model->journal_date))$model->journal_date=DateTime::createFromFormat('Y-m-d',$model->journal_date)->format('d/m/Y');
	
		$this->render('index',array('model'=>$model,
									'modelDetailDana'=>$modelDetailDana,
									'modelDetailPenjatahan'=>$modelDetailPenjatahan,
									'modelDetailRefund'=>$modelDetailRefund,
									'modelmovement'=>$modelmovement,
									'modelIpofund2'=>$modelIpofund2,
									'modelfundledger'=>$modelfundledger,
									'modelaccountledger'=>$modelaccountledger,
									'modelPayrecd'=>$modelPayrecd,
									'modelPayrech'=>$modelPayrech,
									'modelFolder'=>$modelFolder,
									'modelgen'=>$modelgen,
									'trf_langsung_flg'=>$trf_langsung_flg,
									'modelFundTrf'=>$modelFundTrf
									));
	}


}