<?php

class IpofundController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	
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
		$modelipofund = array();
		$modelfundledger=array();
		$modelaccountledger=array();
		$modelPayrech = new Tpayrech;
		$modelPayrecd= new Tpayrecd;
		$modelFolder= new Tfolder;
		$model->option=1;
		$valid = true;
		//$model->tahap=0;
		$success=false;
		$modelgen = new Ipofund;
		$doc_ref=Sysparam::model()->find("param_id='SYSTEM' and param_cd1='DOC_REF'")->dflg1;
		$model->gl_acct_bank= Sysparam::model()->find("PARAM_ID='IPO FUND ENTRY' and param_cd1='BANK' AND PARAM_CD2='GL'")->dstr1;
		$model->sl_acct_bank = Sysparam::model()->find("PARAM_ID='IPO FUND ENTRY' and param_cd1='BANK' AND PARAM_CD2='GL'")->dstr2;
		$model->gl_acct_utang = Sysparam::model()->find("PARAM_ID='IPO FUND ENTRY' and param_cd1='HUTANG' AND PARAM_CD2='GL'")->dstr1;
		$model->sl_acct_utang =  Sysparam::model()->find("PARAM_ID='IPO FUND ENTRY' and param_cd1='HUTANG' AND PARAM_CD2='GL'")->dstr2;
		$folder_cd =  Sysparam::model()->find("param_id='SYSTEM' and param_cd1='VCH_REF'")->dflg1;
		
		$gl_bank = $model->gl_acct_bank;
		$sl_bank = $model->sl_acct_bank;
		$gl_utang = $model->gl_acct_utang;
		$sl_utang = $model->sl_acct_utang;
		if(isset($_POST['scenario']))
		{	
			$scenario= $_POST['scenario'];
			$model->attributes = $_POST['Tpee'];
			if(DateTime::createFromFormat('d/m/Y',$model->paym_dt))$model->paym_dt=DateTime::createFromFormat('d/m/Y',$model->paym_dt)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->offer_dt_fr))$model->offer_dt_fr=DateTime::createFromFormat('d/m/Y',$model->offer_dt_fr)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->offer_dt_to))$model->offer_dt_to=DateTime::createFromFormat('d/m/Y',$model->offer_dt_to)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->allocate_dt))$model->allocate_dt=DateTime::createFromFormat('d/m/Y',$model->allocate_dt)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->distrib_dt_to))$model->distrib_dt_to=DateTime::createFromFormat('d/m/Y',$model->distrib_dt_to)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->distrib_dt_to))$model->distrib_dt_to=DateTime::createFromFormat('d/m/Y',$model->distrib_dt_to)->format('Y-m-d');
			if($scenario =='filter')//retrieve
			{
				
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
				
				if($model->tahap =='0' && $model->option =='1')
				{
				$client_cd = $model->client_cd==''?'%':$model->client_cd;
				$branch_cd = $model->branch_cd==''?'%':$model->branch_cd;	
				$user_id = $model->user_id==''?'%':$model->user_id;
				$modelDetailDana = Ipofund::model()->findAllBySql(Ipofund::getPenerimaanDana($model->stk_cd, $model->option,$client_cd,$branch_cd,$user_id));	
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
					$model->user_id = $user_id=='%'?'':$user_id;
					}
					
				}
				else if($model->tahap == '1' && $model->option =='1')
				{
				$client_cd = $model->client_cd==''?'%':$model->client_cd;
				$branch_cd = $model->branch_cd==''?'%':$model->branch_cd;
				$remarks = $model->remarks;	
				$voucher_ref = $model->voucher_ref;
				$modelDetailPenjatahan = Ipofund::model()->findAllBySql(Ipofund::getPenjatahan($model->stk_cd, $model->option,$client_cd,$branch_cd));
				$model = Tpee::model()->find("stk_cd='$model->stk_cd' ");
				if(!$model)
				{
				$model= new Tpee;
				$model->option ='1';
				$model->tahap = 1;	
				}
				else 
				{
				$model->option ='1';
				$model->tahap = 1;	
				$model->client_cd = $client_cd=='%'?'':$client_cd;
				$model->branch_cd = $branch_cd=='%'?'':$branch_cd;
				$model->remarks=$remarks;
				$model->voucher_ref = $voucher_ref;
				}
				
				
				$model->gl_acct_bank= Sysparam::model()->find("PARAM_ID='IPO FUND ENTRY' and param_cd1='BANK' AND PARAM_CD2='GL'")->dstr1;
				$model->sl_acct_bank = Sysparam::model()->find("PARAM_ID='IPO FUND ENTRY' and param_cd1='BANK' AND PARAM_CD2='GL'")->dstr2;
				$model->gl_acct_utang = Sysparam::model()->find("PARAM_ID='IPO FUND ENTRY' and param_cd1='HUTANG' AND PARAM_CD2='GL'")->dstr1;
				$model->sl_acct_utang =  Sysparam::model()->find("PARAM_ID='IPO FUND ENTRY' and param_cd1='HUTANG' AND PARAM_CD2='GL'")->dstr2;
				foreach($modelDetailPenjatahan as $row)
				{
					$row->save_flg='Y';
				}
				}
				else if($model->tahap =='2' && $model->option =='1')
				{
				$client_cd = $model->client_cd==''?'%':$model->client_cd;
				$branch_cd = $model->branch_cd==''?'%':$model->branch_cd;
				$modelDetailRefund = Ipofund::model()->findAllBySql(Ipofund::getRefund($model->stk_cd, $model->option,$client_cd,$branch_cd));
				$model = Tpee::model()->find("stk_cd='$model->stk_cd' ");
					if(!$model)
					{	$model = new Tpee;
						$model->option ='1';
						$model->tahap = 2;		
					}
					else{
						$model->option ='1';
						$model->tahap = 2;
					$model->client_cd = $client_cd=='%'?'':$client_cd;
					$model->branch_cd = $branch_cd=='%'?'':$branch_cd;
					}
				
				
				}
				else if($model->tahap =='0' && $model->option =='0')
				{
					$modelgen->stk_cd = $model->stk_cd;
					$modelgen->tahap = 'PENERIMAAN';
					$modelgen->gl_acct_bank = $model->gl_acct_bank;
					$modelgen->sl_acct_bank = $model->sl_acct_bank;
					$modelgen->gl_acct_hutang = $model->gl_acct_utang;
					$modelgen->sl_acct_hutang = $model->sl_acct_utang;
					$modelgen->user_id = Yii::app()->user->id;
					$model->scenario = 'ipentry';
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
				
				
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('/finance/ipofund/index'));
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
				
				$model->total=str_replace(',','', $model->total);
				
				
				
				if($model->scenario=='penjatahan' && $folder_cd=='Y')
				{
					//echo "<script>alert('$model->check_gl_bank')</script>"; 
					if($folder_cd=='Y' && $model->voucher_ref=='' && $model->check_gl =='Y')
					{
					$model->addError('voucher_ref', 'Voucher ref tidak boleh kosong');
					$valid=false;	
					}
					
					if($model->remarks =='')
					{
						$model->addError('remarks', 'Remarks tidak boleh kosong');
					}
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
						$cek =  Ipofund::model()->findAllBySql(Ipofund::checkData($modelDetailDana[$x]->client_cd, $model->offer_dt_fr,1,'P',$modelDetailDana[$x]->setor));
						if($cek)
						{
							$model->addError('distrib_dt_fr', 'Masih ada yang belum diappove');
							$valid=false;
						}
						$client_cd = $modelDetailDana[$x]->client_cd;
						$trx_amt = $modelDetailDana[$x]->setor;
						$cek2 = Tfundmovement::model()->findAll("doc_date = '$model->offer_dt_fr' and source='IPO' and sl_acct_cd='$model->stk_cd' and client_cd='$client_cd' and trx_amt='$trx_amt' ");
						if($cek2)
						{
							$modelDetailDana[$x]->addError('client_cd', "Client $client_cd sudah dijurnal ");
							$valid=false;
						}
						$modelDetailDana[$x]->setor = $modelDetailDana[$x]->setor?$modelDetailDana[$x]->setor:0;
						/*
						if($modelDetailDana[$x]->setor != 0 && $modelDetailDana[$x]->setor > $modelDetailDana[$x]->bal_rdi)
						{
							$modelDetailDana[$x]->addError('setor', "Dana yang akan dipindahkan harus lebih kecil dari Saldo RDI ");
							$valid=false;
						}
						if($modelDetailDana[$x]->setor == 0)
						{
							$modelDetailDana[$x]->addError('setor', "Tidak boleh disimpan ");
							$valid=false;
						}
						
						 
						 */
						
					$safe1++;			
					}			
				}
					
				//PENJATAHAN
				$safe2=0;
				for($x=1; $x<= $rowCountPenjatahan;$x++)
				{	$modelDetailPenjatahan[$x] =  new Tipoclient;
					$modelDetailPenjatahan[$x]->attributes = $_POST['Tipoclient'][$x];
					$modelDetailPenjatahan[$x]->scenario='ipoentry';
					if(isset($_POST['Tipoclient'][$x]['save_flg']) && $_POST['Tipoclient'][$x]['save_flg'] == 'Y')
					{
						$valid = $modelDetailPenjatahan[$x]->validate() && $valid;
						if($model->check_gl =='Y')
						{
						$record_seq = 2;	
						}
						else{
						$record_seq = 1;	
						}
						 
						
						$cek =  Ipofund::model()->findAllBySql(Ipofund::checkData($modelDetailPenjatahan[$x]->client_cd, $model->allocate_dt,$record_seq,'O',$modelDetailPenjatahan[$x]->amount));
						if($cek)
						{
							$model->addError('allocate_dt', 'Masih ada yang belum diappove');
							$valid=false;
						}
						$client_cd = $modelDetailPenjatahan[$x]->client_cd;
						$trx_amt = $modelDetailPenjatahan[$x]->amount;
						$cek2 = Tfundmovement::model()->findAll("doc_date = '$model->allocate_dt' and trx_type='O' and source='IPO' and sl_acct_cd='$model->stk_cd' and client_cd='$client_cd' and trx_amt='$trx_amt' ");
						if($cek2)
						{
							$modelDetailPenjatahan[$x]->addError('client_cd', "Client $client_cd sudah dijurnal ");
							$valid=false;
						}
				
						
					$safe2++;			
					}			
				}
					//REFUND
					$safe3 =0;
				for($x=1; $x<= $rowCountRefund;$x++)
				{	$modelDetailRefund[$x] =  new Tipoclient;
					$modelDetailRefund[$x]->attributes = $_POST['Tipoclient'][$x];
					$modelDetailRefund[$x]->scenario='ipoentry';
					if(isset($_POST['Tipoclient'][$x]['save_flg']) && $_POST['Tipoclient'][$x]['save_flg'] == 'Y')
					{
						$valid = $modelDetailRefund[$x]->validate() && $valid;
						$cek =  Ipofund::model()->findAllBySql(Ipofund::checkData($modelDetailRefund[$x]->client_cd, $model->paym_dt,1,'P',$modelDetailRefund[$x]->refund));
						if($cek)
						{
							$model->addError('paym_dt', 'Masih ada yang belum diappove');
							$valid=false;
						}
						$client_cd = $modelDetailRefund[$x]->client_cd;
						$trx_amt = $modelDetailRefund[$x]->amount;
						$cek2 = Tfundmovement::model()->findAll("doc_date = '$model->paym_dt' and source='IPO' and sl_acct_cd='$model->stk_cd' and client_cd='$client_cd' and trx_amt='$trx_amt' ");
						if($cek2)
						{
							$modelDetailRefund[$x]->addError('client_cd', "Client $client_cd sudah dijurnal ");
							$valid=false;
						}		
						$safe3++;
					}			
				}
				

				if($valid)
				{	
					//PENERIMAAN DANA
					if($rowCountDana>0 && $safe1>0)
					{						
					$recordSeq=1;
					for($x=1; $x<= $rowCountDana;$x++)
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
							$sql="SELECT GET_DOCNUM_FUND('$model->offer_dt_fr','O')  AS DOC_NUM FROM DUAL";
							$doc=DAO::queryRowSql($sql);
							$doc_num=$doc['doc_num'];
							$modelmovement[$y]->doc_num = $doc_num;
							$modelmovement[$y]->user_id=$model->user_id;
							$modelmovement[$y]->cre_dt = $model->cre_dt;
							$modelmovement[$y]->update_date = $model->update_date;
							$modelmovement[$y]->update_seq = $model->update_seq;
							$modelmovement[$y]->doc_date = $model->offer_dt_fr;
							$modelmovement[$y]->trx_type= 'O';
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
							$modelmovement[$y]->to_client= $client_cd;
							$modelmovement[$y]->to_acct = $modelmovement[$y]->from_acct;
							$modelmovement[$y]->to_bank = $modelmovement[$y]->from_bank;
							$modelmovement[$y]->trx_amt = $modelDetailDana[$x]->setor;
							$modelmovement[$y]->fee = 0;
							$modelmovement[$y]->folder_cd='';
							$modelmovement[$y]->fund_bank_cd=$modelmovement[$y]->from_bank;
							$modelmovement[$y]->fund_bank_acct = $modelmovement[$y]->from_acct;
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
									$modelfundledger[$a]->trx_type='O';
									$modelfundledger[$a]->doc_date = $model->offer_dt_fr;
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
							$modelipofund[$a] = new Tipofund;
							$modelipofund[$a]->client_cd = $modelmovement[$y]->client_cd;
							$modelipofund[$a]->stk_cd = $model->stk_cd;
							$modelipofund[$a]->cre_dt = $model->cre_dt;
							$modelipofund[$a]->tahap = 'ALOKASI';
							$modelipofund[$a]->doc_num = $modelmovement[$y]->doc_num;
							$modelipofund[$a]->user_id=$model->user_id;
							if($success && $modelipofund[$a]->executeSp(AConstant::INBOX_STAT_INS,$modelipofund[$a]->stk_cd,$modelipofund[$a]->client_cd,$model->update_date,$model->update_seq,1)>0)$success=true;
							else{
								$success=false;
							}
							}
							
								
							}
							
						}
					}//end save flg=Y
					}//end rowCoundDana	
					}//end if rowCount Dana>0
					//echo "<script>alert('$safe')</script>";
					//PENJATAHAN
					if($rowCountPenjatahan>0  && $safe2>0 )
					{
						
				
					//BUAT VOUCHER	
					if($model->check_gl =='Y')
					{
					//EXECUTE SP HEADER
					if($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName)>0)$success=true;
					else{
						$success=false;
					}	
					
					////SAVE TO PAYRECH
					$modelPayrech->payrec_type='RD';
					$modelPayrech->payrec_date = $model->allocate_dt;
					$modelPayrech->acct_type='';
					$modelPayrech->sl_acct_cd = $model->sl_acct_bank;
					$modelPayrech->gl_acct_cd = $model->gl_acct_bank;	
					$modelPayrech->curr_cd='IDR';
					$modelPayrech->curr_amt =$model->total; 
					$modelPayrech->payrec_frto ='';
					$modelPayrech->remarks=$model->remarks;
					$modelPayrech->client_cd='';
					$modelPayrech->check_num='';
					$modelPayrech->folder_cd=$model->voucher_ref;
					$modelPayrech->num_cheq='';
					$modelPayrech->client_bank_acct='';
					$modelPayrech->client_bank_name='';
					$modelPayrech->reversal_jur='N';
					$modelPayrech->user_id=$model->user_id;
					$modelPayrech->cre_dt=$model->cre_dt;
					$modelPayrech->update_date =$model->update_date;
					$modelPayrech->update_seq = $model->update_seq;
				
					//SAVE KE T PAYRECH 
				if($success && $modelPayrech->validate() && $modelPayrech->executeSp(AConstant::INBOX_STAT_INS,$modelPayrech->payrec_num,1)>0){
					$success=true;
				}
				else{
					$succes=false;
				}	
				
				//SAVE KE T PAYRECD
				$modelPayrecd->payrec_num=$modelPayrech->payrec_num;
				$modelPayrecd->payrec_type='RD';
				$modelPayrecd->payrec_date=$modelPayrech->payrec_date;
				$modelPayrecd->client_cd='';
				$modelPayrecd->gl_acct_cd=$model->gl_acct_utang;
				$modelPayrecd->sl_acct_cd=$model->sl_acct_utang;	
				$modelPayrecd->db_cr_flg='C';
				$modelPayrecd->payrec_amt=$model->total;
				$modelPayrecd->doc_ref_num=$modelPayrech->payrec_num;
				$modelPayrecd->tal_id='2';
				$modelPayrecd->remarks= $model->remarks;
				$modelPayrecd->record_source='VCH';
				$modelPayrecd->doc_date= $modelPayrech->payrec_date;
				$modelPayrecd->due_date = $modelPayrech->payrec_date;
				$modelPayrecd->ref_folder_cd='';
				$modelPayrecd->gl_ref_num='';
				$modelPayrecd->sett_for_curr=0;
				$modelPayrecd->sett_val=0;
				$modelPayrecd->brch_cd='';
				$modelPayrecd->doc_tal_id='';
				$modelPayrecd->source_type='';
				$modelPayrecd->user_id=$model->user_id;
				$modelPayrecd->cre_dt= $model->cre_dt;
				
				if($success && $modelPayrecd->executeSp(AConstant::INBOX_STAT_INS,$modelPayrecd->payrec_num,$modelPayrecd->doc_ref_num,$modelPayrecd->tal_id,$model->update_date,$model->update_seq,1)>0)$success=true;
				else{
					$succes=false;
				}	
					
				//SAVE T_ACCOUNT LEDGER
				for($x=0;$x<2;$x++)
				{
					$modelaccountledger[$x] = new Taccountledger;
					$modelaccountledger[$x]->xn_doc_num=$modelPayrech->payrec_num;
					$modelaccountledger[$x]->tal_id=$x+1;
					if($doc_ref=='Y')
					{
					$modelaccountledger[$x]->doc_ref_num=	$modelPayrech->payrec_num;
					}
					$modelaccountledger[$x]->acct_type='';
					if($x==0)
					{
						$modelaccountledger[$x]->sl_acct_cd= $model->sl_acct_bank;
						$modelaccountledger[$x]->gl_acct_cd=$model->gl_acct_bank;	
						$modelaccountledger[$x]->db_cr_flg = 'D';
					}
					else
					{
						$modelaccountledger[$x]->sl_acct_cd= $model->sl_acct_utang;
						$modelaccountledger[$x]->gl_acct_cd= $model->gl_acct_utang;		
						$modelaccountledger[$x]->db_cr_flg = 'C';
					}
					$modelaccountledger[$x]->curr_cd='IDR';
					$modelaccountledger[$x]->curr_val=$model->total;
					$modelaccountledger[$x]->xn_val=$modelaccountledger[$x]->curr_val;
					$modelaccountledger[$x]->ledger_nar= $model->remarks;
					$modelaccountledger[$x]->doc_date=$modelPayrech->payrec_date;
					$modelaccountledger[$x]->due_date = $modelPayrech->payrec_date;
					$modelaccountledger[$x]->record_source='RD';
					$modelaccountledger[$x]->sett_for_curr=0;
					$modelaccountledger[$x]->folder_cd=$modelPayrech->folder_cd;
					$modelaccountledger[$x]->sett_val=0;
					$modelaccountledger[$x]->reversal_jur='N';
					$modelaccountledger[$x]->manual='Y';
					$modelaccountledger[$x]->arap_due_date=$modelPayrech->payrec_date;
					$modelaccountledger[$x]->user_id= $model->user_id;
					$modelaccountledger[$x]->cre_dt=$model->cre_dt;
					$modelaccountledger[$x]->budget_cd = 'RVCH';
					if($success && $modelaccountledger[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelaccountledger[$x]->xn_doc_num,$modelaccountledger[$x]->tal_id,$model->update_date,$model->update_seq,$x+1)>0)$success=true;
					else{
						$success=false;
					}
				}
				
				if($folder_cd=='Y')
				{
				//SAVE TO T FOLDER
				$modelFolder->fld_mon= DateTime::createFromFormat('Y-m-d',$modelPayrech->payrec_date)->format('my');
				$modelFolder->folder_cd= $modelPayrech->folder_cd;
				$modelFolder->doc_date=$modelPayrech->payrec_date;
				$modelFolder->doc_num= $modelPayrech->payrec_num;
				$modelFolder->user_id= $model->user_id;
				$modelFolder->cre_dt= $model->cre_dt;
				if($success && $modelFolder->executeSp(AConstant::INBOX_STAT_INS,$modelFolder->doc_num,$model->update_date,$model->update_seq,1)>0)$success=true;
				else{
					$success=false;
				}		
				}
				
				
				}//SELESAI MEMBUAT VOUCHER
				
				
				//SAVE KE T FUND MOVEMENT
				$recordSeq=2;
				for($x=1; $x<= $rowCountPenjatahan;$x++)
				{
					if(isset($_POST['Tipoclient'][$x]['save_flg']) && $_POST['Tipoclient'][$x]['save_flg'] == 'Y')
					{
						if($model->check_gl =='Y')
						{
							$recordSeq = $recordSeq;
						}	
						else
						{
							//EXECUTE SP HEADER
						if($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName)>0)$success=true;
						else{
							$success=false;
						}
							$recordSeq=1;
						}
					 	
					$modelmovement[$x]= new Tfundmovement;
					$sql="SELECT GET_DOCNUM_FUND('$model->paym_dt','W')  AS DOC_NUM FROM DUAL";
					$doc=DAO::queryRowSql($sql);
					$doc_num=$doc['doc_num'];
					$modelmovement[$x]->doc_num = $doc_num;
					$modelmovement[$x]->user_id=$model->user_id;
					$modelmovement[$x]->cre_dt = $model->cre_dt;
					$modelmovement[$x]->update_date = $model->update_date;
					$modelmovement[$x]->update_seq = $model->update_seq;
					$modelmovement[$x]->doc_date = $model->allocate_dt;
					$modelmovement[$x]->trx_type= 'O';
					$modelmovement[$x]->client_cd = $modelDetailPenjatahan[$x]->client_cd;
					$client_cd = $modelmovement[$x]->client_cd;
					$modelmovement[$x]->brch_cd = trim(Client::model()->find("client_cd = '$client_cd' ")->branch_code);
					$modelmovement[$x]->source = 'IPO';
					$modelmovement[$x]->bank_mvmt_date='';
					$modelmovement[$x]->acct_name=$modelDetailPenjatahan[$x]->client_name;
					$modelmovement[$x]->remarks= $model->remarks;
					$modelmovement[$x]->from_client= $modelDetailPenjatahan[$x]->client_cd;
					$modelmovement[$x]->from_acct= Tpee::model()->find("stk_cd = '$model->stk_cd'")->ipo_bank_acct;
					$modelmovement[$x]->from_bank= Tpee::model()->find("stk_cd = '$model->stk_cd'")->ipo_bank_cd;
					$modelmovement[$x]->to_client= $client_cd;
					$modelmovement[$x]->to_acct = '-';
					$modelmovement[$x]->to_bank = 'LUAR';
					$modelmovement[$x]->trx_amt = $modelDetailPenjatahan[$x]->amount;
					$modelmovement[$x]->fee = 0;
					$modelmovement[$x]->folder_cd='';
					$modelmovement[$x]->fund_bank_cd= Clientflacct::model()->find("client_cd = '$client_cd' and acct_stat in ('A','I') ")->bank_cd;
					$modelmovement[$x]->fund_bank_acct = Clientflacct::model()->find("client_cd = '$client_cd' and acct_stat in ('A','I') ")->bank_acct_num;
					$modelmovement[$x]->sl_acct_cd=$model->stk_cd;
				if($success && $modelmovement[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelmovement[$x]->doc_num,$recordSeq)>0)$success=true;
				else{
					$success=false;
				}
				
					
					//SAVE KE T FUND LEDGER 
					for($y=0;$y<2;$y++){

					$modelfundledger[$y] = new Tfundledger;
					$modelfundledger[$y]->doc_num = $doc_num;
					$modelfundledger[$y]->seqno=$y+1;
					$modelfundledger[$y]->trx_type='O';
					$modelfundledger[$y]->doc_date = $model->allocate_dt;
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
					
					}
					$recordSeq++;	
					}
				}
				}//end if rowcountPenjatahan>0
				
				
				//REFUND
				if($rowCountRefund>0  && $safe3>0)
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
							
						for($y=0;$y<2;$y++)
						{
							//SAVE TO FUND MOVEMENT
							$modelmovement[$y] = new Tfundmovement;
							$sql="SELECT GET_DOCNUM_FUND('$model->paym_dt','P')  AS DOC_NUM FROM DUAL";
							$doc=DAO::queryRowSql($sql);
							$doc_num=$doc['doc_num'];
							$modelmovement[$y]->doc_num = $doc_num;
							$modelmovement[$y]->user_id=$model->user_id;
							$modelmovement[$y]->cre_dt = $model->cre_dt;
							$modelmovement[$y]->update_date = $model->update_date;
							$modelmovement[$y]->update_seq = $model->update_seq;
							$modelmovement[$y]->doc_date = $model->paym_dt;
							$modelmovement[$y]->trx_type= 'P';
							$modelmovement[$y]->client_cd = $modelDetailRefund[$x]->client_cd;
							$client_cd = $modelDetailRefund[$x]->client_cd;
							$modelmovement[$y]->brch_cd = trim(Client::model()->find("client_cd = '$client_cd' ")->branch_code);
							$modelmovement[$y]->source = 'IPO';
							$modelmovement[$y]->bank_mvmt_date='';
							$modelmovement[$y]->acct_name=$modelDetailRefund[$x]->client_name;
							$modelmovement[$y]->remarks= 'Pemesanan IPO '.$model->stk_cd;
							$modelmovement[$y]->from_client= $modelDetailRefund[$x]->client_cd;
							$modelmovement[$y]->from_acct= Clientflacct::model()->find("client_cd= '$client_cd'  and acct_stat <> 'C'")->bank_acct_num;
							$modelmovement[$y]->from_bank= Clientflacct::model()->find("client_cd= '$client_cd'  and acct_stat <> 'C'")->bank_cd;
							$modelmovement[$y]->to_client= $client_cd;
							$modelmovement[$y]->to_acct = $modelmovement[$y]->from_acct;
							$modelmovement[$y]->to_bank = $modelmovement[$y]->from_bank;
							$modelmovement[$y]->trx_amt = $modelDetailRefund[$x]->amount;
							$modelmovement[$y]->fee = 0;
							$modelmovement[$y]->folder_cd='';
							$modelmovement[$y]->fund_bank_cd=$modelmovement[$y]->from_bank;
							$modelmovement[$y]->fund_bank_acct = $modelmovement[$y]->from_acct;
							$modelmovement[$y]->sl_acct_cd=$model->stk_cd;
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
									$modelfundledger[$a]->trx_type='P';
									$modelfundledger[$a]->doc_date = $model->paym_dt;
									if($y==0)
									{
										$modelfundledger[$a]->acct_cd=$a==0?'DBEBAS':'DNU';
									}
									else
									{
										$modelfundledger[$a]->acct_cd=$a==0?'KNU':'KNPR';
									}
									
									$modelfundledger[$a]->client_cd = $modelmovement[$y]->client_cd;
									$modelfundledger[$a]->debit = $a==0?$modelmovement[$y]->trx_amt:0;
									$modelfundledger[$a]->credit = $a==1?$modelmovement[$y]->trx_amt:0;
									$modelfundledger[$a]->user_id= $model->user_id;
									$modelfundledger[$a]->cre_dt = $model->cre_dt;
									$modelfundledger[$a]->manual='Y';
									
								if($success && $modelfundledger[$a]->executeSp(AConstant::INBOX_STAT_INS,$modelfundledger[$a]->doc_num,$modelfundledger[$a]->seqno,$model->update_date,$model->update_seq,$recordSeq)>0)$success=TRUE;
								else{
									$success=false;
								}
								$recordSeq++;
							}
							
						}
					}//end save flg=Y
					}//end rowCoundRefund
				}
				
				
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('/finance/ipofund/index'));
				}
				else 
				{
					$transaction->rollback();
				}
				
				
					
				}//end valid
				
				
				
			}
		}
		
		
		
		$this->render('index',array('model'=>$model,
									'modelDetailDana'=>$modelDetailDana,
									'modelDetailPenjatahan'=>$modelDetailPenjatahan,
									'modelDetailRefund'=>$modelDetailRefund,
									'modelmovement'=>$modelmovement,
									'modelipofund'=>$modelipofund,
									'modelfundledger'=>$modelfundledger,
									'modelaccountledger'=>$modelaccountledger,
									'modelPayrecd'=>$modelPayrecd,
									'modelPayrech'=>$modelPayrech,
									'modelFolder'=>$modelFolder,
									'modelgen'=>$modelgen,
									'gl_bank'=>$gl_bank,
									'sl_bank'=>$sl_bank,
									'gl_utang'=>$gl_utang,
									'sl_utang'=>$sl_utang
									));
	}


}