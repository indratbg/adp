<?php

class ClientcorpController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionGetcif()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
      $qSearch = DAO::queryAllSql("
				Select a.cifs cifs, a.cif_name cif_name From MST_CIF a, MST_CLIENT b
				Where a.cifs = b.cifs
				AND b.susp_stat <> 'C'
				AND (a.cifs like '".$term."%')
				AND a.client_type_1 = 'C'
      			AND rownum <= 15
      			ORDER BY a.cifs
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['cifs']
      			, 'labelhtml'=>$search['cifs'].' - '.$search['cif_name'] //WT: Display di auto completenya
      			, 'value'=>$search['cifs']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
	
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		
		$model->cust_client_flg=$model->cust_client_flg=='A'?'Y':'N';
		$model->desp_pref=$model->desp_pref=='Y'?'Y':'N';
		
		$result = DAO::queryRowSql("SELECT bank_acct_fmt FROM MST_CLIENT_FLACCT WHERE client_cd = '$model->client_cd' AND acct_stat = 'A'");
		
		if($result)$model->rdn = $result['bank_acct_fmt'];
		
		$modelClientMember = VClientmember::model()->findAll("cifs = '$model->cifs'");
		
		$row = VClientSubrek14::model()->find("client_cd = '$model->client_cd'");
		
		if($row)
		{
			$subrek1 = $row->subrek001;
			$model->subrek001_1 = substr($subrek1,5,4);
			$model->subrek001_2 = substr($subrek1,12,2);
			
			$subrek4 = $row->subrek004;
			$model->subrek004_1 = substr($subrek4,5,4);
			$model->subrek004_2 = substr($subrek4,12,2);
		}
		
		$modelClientAutho = Clientautho::model()->findAll("cifs = '$id' AND approved_stat = 'A'");
		
		$modelClientBank = array();
		
		$query = " SELECT a.bank_acct_num AS def_bank_acct_num, b.*
					FROM MST_CLIENT a, MST_CLIENT_BANK b
					WHERE a.cifs = b.cifs
					AND a.client_cd =  '$model->client_cd'
					AND b.approved_stat = 'A'";		
		
		$modelTemp = DAO::queryAllSql($query);
		
		$x = 0;
		
		foreach($modelTemp as $row)
		{
			$modelClientBank[$x] = new Clientbank;
			
			foreach($modelClientBank[$x] as $key=>$value)
			{
				foreach($row as $key2=>$value2)
				{
					if(strtoupper(trim($key)) == strtoupper(trim($key2)))
					{
						$modelClientBank[$x]->setAttribute($key,$value2);
						unset($row[$key2]);
						break;
					}
				}
			}
			
			if($modelClientBank[$x]->bank_acct_num == $row['def_bank_acct_num'])$modelClientBank[$x]->default_flg = 'Y';
			else {
				$modelClientBank[$x]->default_flg = 'N';
			}
			
			$x++;
		}
		
		$this->render('view',array(
			'modelClientDetail'=>$model,
			'modelCifDetail'=>$this->loadModelCif($model->cifs),
			'modelClientInstDetail'=>$this->loadModelClientinst($model->cifs),
			'modelClientAuthoDetail'=>$modelClientAutho,
			'modelClientBankDetail'=>$modelClientBank,
			'modelClientMember' => $modelClientMember,
		));
	}

	public function actionCreate()
	{
		$model			 = new Client;
		$modelClientinst = new Clientinst;
		$modelCif 		 = new Cif;
		$modelClientBank = array();
		$modelClientAutho = array();
		$modelClientMember = array();
		
		//RD: Edited add suppl_doc_type and suppl_exp_date 7 sept 2017
		$a = Sysparam::model()->findAll("param_id = 'CLIENT MASTER' AND param_cd1 = 'SUPPL' AND param_cd2 = 'REQUIRED'");
		
		$supplRequired = null;
		for($x = 0; $x < count($a); $x++){
			if($x < count($a)-1){
				$supplRequired = $supplRequired."'".$a[$x]['dstr1']."',";
			}else{
				$supplRequired = $supplRequired."'".$a[$x]['dstr1']."'";
			}
		} 
		
		// var_dump($supplRequired);
		// die();
		
		$copy_flg = FALSE;
		
		if(isset($_POST['Client']['copy_client']))
		{
			$clientCopy = $_POST['Client']['copy_client'];
			
			$result = DAO::queryRowSql("SELECT * FROM MST_CLIENT WHERE client_cd = '$clientCopy' AND client_type_1 = '".Constanta::CLIENT_TYPE1_CORPORATE."'");
			
			if($result)
			{
				$copy_flg = TRUE;
				
				$model->attributes = $result;
				$model->client_cd = '';
				$model->cifs = '';
				$model->npwp_no = '';
				$model->client_birth_dt = '';
				$model->branch_code = trim($model->branch_code);
				$model->custodian_cd = '';
				
				$cifCopy = $result['cifs'];
				$resultCif = DAO::queryRowSql("SELECT * FROM MST_CIF WHERE cifs = '$cifCopy'");		
				$modelCif->client_type_1 = Constanta::CLIENT_TYPE1_CORPORATE; 	//To manipulate the initial rules set in model Cif
				$modelCif->attributes = $resultCif;
				$modelCif->cifs = '';
				$modelCif->sid = '';
				$modelCif->npwp_no = '';
				$modelCif->npwp_date = '';
				$modelCif->client_birth_dt = '';
				$modelCif->inst_type = '';
				$modelCif->biz_type = '';
				$modelCif->industry_cd = '';
				$modelCif->industry = '';
				$modelCif->addl_fund = '';
				$modelCif->net_asset_cd = '';
				$modelCif->profit_cd = '';
				$modelCif->net_asset_yr = '';
				
				$resultClientInst = DAO::queryRowSql("SELECT * FROM MST_CLIENT_INST WHERE cifs = '$cifCopy'");
				$modelClientinst->attributes = $resultClientInst;
				$modelClientinst->cifs = '';
				$modelClientinst->net_asset_cd2 = '';
				$modelClientinst->profit_cd2 = '';
				$modelClientinst->net_asset_yr2 = '';
				$modelClientinst->net_asset_cd3 = '';
				$modelClientinst->profit_cd3 = '';
				$modelClientinst->net_asset_yr3 = '';
				
				$resultClientAutho = DAO::queryAllSql("SELECT * FROM MST_CLIENT_AUTHO WHERE cifs = '$cifCopy' AND approved_stat = 'A'");
				
				$x = 0;
				foreach($resultClientAutho as $row)
				{
					$modelClientAutho[$x] = new Clientautho;
					$modelClientAutho[$x]->attributes = $row;
					$modelClientAutho[$x]->save_flg = 'Y';
					$x++;
				}
				
				$resultClientBank = DAO::queryAllSql("SELECT * FROM MST_CLIENT_BANK WHERE cifs = '$cifCopy' AND default_flg = 'Y' AND approved_stat = 'A'");
				
				$x = 0;
				foreach($resultClientBank as $row)
				{
					$modelClientBank[$x] = new Clientbank;
					$modelClientBank[$x]->attributes = $row;
					$modelClientBank[$x]->save_flg = 'Y';
					$x++;
				}
			}
			else {
				$_POST['Client']['copy_client'] = '';
			}
		}
		
		$model->client_type_1 = Constanta::CLIENT_TYPE1_CORPORATE;
		$model->stk_exch = 'IDX';
		$model->curr_cd = 'IDR';
		$model->def_curr_cd = 'IDR';
		//$model->pph_appl_flg = 'Y';
		$model->levy_appl_flg ='Y';
		$model->vat_appl_flg = 'Y';
		$model->int_pay_days = 360;
		$model->int_rec_days = 360;
		$model->int_accumulated = 'N';
		$model->amt_int_flg = 'Y';
		$model->recov_charge_flg = 'N';
		$model->susp_trx = 'N';
		//$model->cust_client_flg = 'Y';
		$model->olt = 'N';
		
		$modelCif->client_type_1 = Constanta::CLIENT_TYPE1_CORPORATE;
		
		$render = FALSE;
		$valid = FALSE;
		$success = FALSE;
		
		$init_deposit_cd = array('dana'=>'','efek'=>'');
		
		$menuName = 'INSTITUTIONAL CLIENT PROFILE ENTRY';
		
		$cancel_reason = '';
		$cancel_reason_autho = '';
		
		$minimumFeeFlg = $withholdingTaxFlg = $acopenFeeFlg = $taxOnInterestFlg = $recovChargeFlg =	$pphFlg = '';

		if(isset($_POST['Client']))
		{
			$render = TRUE;
			
			$model->attributes			 = $_POST['Client'];
			$model->susp_stat = 'N';
			
			$submit = $_POST['submit'];
			
			$minimumFeeFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'MINFEE' AND param_cd2 = 'DEFAULT'");
			$withholdingTaxFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'WHTAX' AND param_cd2 = 'DEFAULT'");
			$acopenFeeFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'OTC' AND param_cd2 = 'DEFAULT'");
			$taxOnInterestFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'INTTAX' AND param_cd2 = 'DEFAULT'");
			$recovChargeFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = '2490' AND param_cd2 = 'DEFAULT'");
			$pphFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'PPH' AND param_cd2 = 'DEFAULT'");
			
			if($submit=='render')
			{
				//$model->scenario = 'render';
				if(!($model->cif_opt == Client::CIF_OPTION_EXISTING && !$_POST['auto_comp_cif']))
				{
					$model->pph_appl_flg = $pphFlg['dflg2'];
					
					if($model->cif_opt == Client::CIF_OPTION_NEW)
					{
						$row = Vbrokersubrek::model()->find();
						
						$subrek1 = $row->broker_001;
						$model->subrek001_1 = substr($subrek1,5,4);
						$model->subrek001_2 = substr($subrek1,12,2);
						
						$subrek4 = $row->broker_004;
						$model->subrek004_1 = substr($subrek4,5,4);
						$model->subrek004_2 = substr($subrek4,12,2);
						
						if(!$copy_flg)$model->client_type_2 = $modelCif->client_type_2 = 'L';
					}
					else 
					{
						$cif = $_POST['auto_comp_cif'];
					
						$modelCif = $this->loadModelCif($cif);
						$modelClientinst = $this->loadModelClientinst($cif);
						$modelClientMember = VClientmember::model()->findAll("cifs = '$cif'");
						
						$row1 = Vbrokersubrek::model()->find();
						
						$subrek1 = $row1->broker_001;
						$model->subrek001_1 = substr($subrek1,5,4);
						$model->subrek001_2 = substr($subrek1,12,2);
						
						$row2 = VClientSubrek14::model()->find("client_cd = '$cif'");
						
						$subrek4 = $row2?$row2->subrek004:$row1->broker_004;
						$model->subrek004_1 = substr($subrek4,5,4);
						$model->subrek004_2 = substr($subrek4,12,2);
						
						$model->client_title = $modelCif->client_title;
						$model->client_name = $modelCif->cif_name;
						
						$client = Client::model()->find(array("select"=>"branch_code, rem_cd","condition"=>"client_cd = '$cif'"));
						
						if($client)
						{
							$model->old_branch_code = $model->branch_code = trim($client->branch_code);
							$model->old_rem_cd = $model->rem_cd = $client->rem_cd;
						}
						
						$modelClientAutho = Clientautho::model()->findAll("cifs = '$cif' AND approved_stat = 'A'");
						
						foreach($modelClientAutho as $row)
						{
							$row->old_seqno = $row->seqno;
							
							if($row->ktp_expiry)
							{
								$row->ktp_expiry = DateTime::createFromFormat('Y-m-d G:i:s',$row->ktp_expiry)->format('d/m/Y');
								$row->old_ktp_expiry = DateTime::createFromFormat('d/m/Y',$row->ktp_expiry)->format('Y-m-d');
							}
							if($row->passport_expiry)
							{
								$row->passport_expiry = DateTime::createFromFormat('Y-m-d G:i:s',$row->passport_expiry)->format('d/m/Y');
								$row->old_passport_expiry = DateTime::createFromFormat('d/m/Y',$row->passport_expiry)->format('Y-m-d');
							}
							if($row->kitas_expiry)
							{
								$row->kitas_expiry = DateTime::createFromFormat('Y-m-d G:i:s',$row->kitas_expiry)->format('d/m/Y');
								$row->old_kitas_expiry = DateTime::createFromFormat('d/m/Y',$row->kitas_expiry)->format('Y-m-d');
							}
							if($row->npwp_date)
							{
								$row->npwp_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->npwp_date)->format('d/m/Y');
								$row->old_npwp_date = DateTime::createFromFormat('d/m/Y',$row->npwp_date)->format('Y-m-d');
							}
							if($row->birth_dt)
							{
								$row->birth_dt = DateTime::createFromFormat('Y-m-d G:i:s',$row->birth_dt)->format('d/m/Y');
								$row->old_birth_dt = DateTime::createFromFormat('d/m/Y',$row->birth_dt)->format('Y-m-d');
							}
						}
						
						$query = "SELECT * FROM MST_CLIENT_BANK
									WHERE cifs = '$modelCif->cifs'
									AND approved_stat ='A'";		
						
						$modelTemp = DAO::queryAllSql($query);
						
						$x = 0;
						
						foreach($modelTemp as $row)
						{
							$modelClientBank[$x] = new Clientbank;
							
							foreach($modelClientBank[$x] as $key=>$value)
							{
								foreach($row as $key2=>$value2)
								{
									if(strtoupper(trim($key)) == strtoupper(trim($key2)))
									{
										$modelClientBank[$x]->setAttribute($key,$value2);
										unset($row[$key2]);
										break;
									}
								}
							}
							
							$modelClientBank[$x]->old_bank_acct_num = $modelClientBank[$x]->bank_acct_num;
							$modelClientBank[$x]->old_bank_cd = $modelClientBank[$x]->bank_cd;
							$modelClientBank[$x]->old_bank_branch = $modelClientBank[$x]->bank_branch;
							$modelClientBank[$x]->old_bank_phone_num = $modelClientBank[$x]->bank_phone_num;
							$modelClientBank[$x]->old_acct_name = $modelClientBank[$x]->acct_name;
							$modelClientBank[$x]->old_bank_acct_type = $modelClientBank[$x]->bank_acct_type;
							$modelClientBank[$x]->old_bank_acct_currency = $modelClientBank[$x]->bank_acct_currency;
							
							$x++;
						}
					}
					
					$model->client_code_opt = 'A';
					$model->acct_open_dt = date('d/m/Y');
					
					$model->acopen_fee_flg = $acopenFeeFlg->dflg2;
					$model->internet_client = $minimumFeeFlg->dflg2;
					
					//if($model->client_type_1 != $withholdingTaxFlg->dstr1)$model->desp_pref = 'A';
					if($modelCif->client_type_1 == $withholdingTaxFlg->dstr1 && $modelCif->client_type_2 == $withholdingTaxFlg->dstr2)$model->desp_pref = $withholdingTaxFlg->dflg2;
					else {
						$model->desp_pref = 'A';
					}
				}
				else {
					$render = FALSE;
					$model->addError('cif_opt','Cif must be filled');	
				}
				
			}
			else if($submit=='submit')
			{
				//$model->scenario = 'submit';	
				if($_POST['Cif']['cifs'] != 'NEW')
				{
					$cif = $_POST['Cif']['cifs'];
					$modelCif = $this->loadModelCif($cif);
					$modelClientinst = $this->loadModelClientinst($cif);
					$modelClientMember = VClientmember::model()->findAll("cifs = '$cif'");
					
					$client = Client::model()->find(array("select"=>"branch_code, rem_cd","condition"=>"client_cd = '$cif'"));
						
					if($client)
					{
						$model->old_branch_code = trim($client->branch_code);
						$model->old_rem_cd = $client->rem_cd;
					}
				}
				
				$modelCif->attributes 		 		= $_POST['Cif'];
				$modelClientinst->attributes 		= $_POST['Clientinst'];
				
				$init_deposit_cd['dana'] = isset($_POST['dana'])?$_POST['dana']:'';
				$init_deposit_cd['efek'] = isset($_POST['efek'])?$_POST['efek']:'';
				
				$model->client_type_2 = $modelCif->client_type_2;
				$model->biz_type = $modelCif->biz_type;
				
				if($model->client_type_3 == $recovChargeFlg->dstr1)$model->recov_charge_flg = $recovChargeFlg->dflg2;
				else
					$model->recov_charge_flg = 'N';
				
				$validCd = true;
				
				if($model->client_code_opt == 'A')
				{
					$row  	   = DAO::queryRowSql("SELECT F_GEN_CLIENT_CD('".strtoupper($model->client_name)."','".$model->client_type_3."') AS client_cd FROM DUAL");
 					$model->client_cd = $row['client_cd'];
				}
				else
				{
					if(strlen(trim($model->client_cd)) == 8)
					{
						$noSpace = trim(str_replace(' ','',$model->client_name));
						$noSpecChar = preg_replace('/[^A-Za-z]/', '', $noSpace);
						
						if(strlen($noSpecChar) >= 4)$firstPart = 4;
						else 
						{
							$firstPart = strlen($noSpecChar);
						}
						
						$secondPart = 7 - $firstPart;
						
						switch($model->client_type_3)
						{
							case 'M':
								$lastPart = 'M';
								break;
							case 'L':
								$lastPart = 'S';
								break;
							case 'T':
								$lastPart = 'T';
								break;
							default:
								$lastPart = 'R';
						}
						
						if(substr($model->client_cd,0,$firstPart) != substr($noSpecChar,0,$firstPart)
							|| !preg_match('/^[0-9]*$/',substr($model->client_cd,$firstPart,$secondPart))
							|| substr($model->client_cd,7,1) != $lastPart 
						)
						{
							$validCd = false;
						}
					}
					else {
						$validCd = false;
					}
				}
				
				if($modelCif->cifs == 'NEW') $model->cifs = $model->client_cd;
				else
				{
					$model->cifs = $modelCif->cifs;
				}
				
				$model->sid = $modelCif->sid = str_replace('.','',$modelCif->sid);
				$model->npwp_no = $modelCif->npwp_no = str_replace(array('.','-'),'',$modelCif->npwp_no);
				
				if($model->custodian_cd)
				{
					$modelCif->custodian = TRUE;
				}
				else {
					$modelCif->custodian = FALSE;
				}
				
				$valid = $model->validate() && $validCd;
				$valid = $modelClientinst->validate() && $valid;
				$valid = $modelCif->validate() && $valid;
				
				if(!$validCd)$model->addError('client_cd','Invalid Client Code');
				
				$x;
				$y;
				
				$rowCount = $_POST['rowCount'];
				$authoCount = $_POST['authoCount']/3;
				
				if(isset($_POST['cancel_reason']))
				{
					if(!$_POST['cancel_reason'])
					{
						$valid = false;
						Yii::app()->user->setFlash('error', 'Bank Cancel Reason Must be Filled');
					}
					else
					{
						$cancel_reason = $_POST['cancel_reason'];
						$model->cancel_reason = $_POST['cancel_reason'];
					}
				}
				
				if(isset($_POST['cancel_reason_autho']))
				{
					if(!$_POST['cancel_reason_autho'])
					{
						$valid = false;
						Yii::app()->user->setFlash('error', 'Authorized Persons Cancel Reason Must be Filled');
					}
					else
					{
						$cancel_reason_autho = $_POST['cancel_reason_autho'];
						if(!$model->cancel_reason)$model->cancel_reason = $_POST['cancel_reason_autho'];
					}
				}
				
				if(!isset($_POST['default']))
				{
					$default = '';
					$valid = FALSE;
					Yii::app()->user->setFlash('error','Client must have one default bank account');
				}
				else {
					$default = $_POST['default'];	
				}
				
				for($x=0;$x<$rowCount;$x++)
				{
					$modelClientBank[$x] = new Clientbank;
					$modelClientBank[$x]->attributes = $_POST['Clientbank'][$x+1];
					
					if($x+1 == $default)$modelClientBank[$x]->default_flg = 'Y';
					else {
						$modelClientBank[$x]->default_flg = 'N';	
					}
					
					if(isset($_POST['Clientbank'][$x+1]['save_flg']) && $_POST['Clientbank'][$x+1]['save_flg'] == 'Y')
					{
						if(isset($_POST['Clientbank'][$x+1]['cancel_flg']))
						{
							if($_POST['Clientbank'][$x+1]['cancel_flg'] == 'Y')
							{
								//CANCEL
								$modelClientBank[$x]->scenario = 'cancel';
								$modelClientBank[$x]->cancel_reason = $_POST['cancel_reason'];
							}
							else 
							{
								//UPDATE
								$modelClientBank[$x]->scenario = 'update';
							}
						}
						else 
						{
							//INSERT
							$modelClientBank[$x]->scenario = 'insert';
						}
					
						$valid = $modelClientBank[$x]->validate() && $valid;
					}
					else {
						$modelClientBank[$x]->bank_cd = $modelClientBank[$x]->old_bank_cd; //Get the old value since the field on form is disabled
					}
				}
				
				for($x=0;$x<$rowCount;$x++)
				{
					for($y=$x+1;$y<$rowCount;$y++)
					{
						if(
							isset($_POST['Clientbank'][$x+1]['save_flg']) && $_POST['Clientbank'][$x+1]['save_flg'] == 'Y'
							&& isset($_POST['Clientbank'][$y+1]['save_flg']) && $_POST['Clientbank'][$y+1]['save_flg'] == 'Y'
							&& (!isset($_POST['Clientbank'][$x+1]['cancel_flg']) || $_POST['Clientbank'][$x+1]['cancel_flg'] != 'Y')
							&& (!isset($_POST['Clientbank'][$y+1]['cancel_flg']) || $_POST['Clientbank'][$y+1]['cancel_flg'] != 'Y')
						)
						{
							if($modelClientBank[$x]->bank_acct_num == $modelClientBank[$y]->bank_acct_num)
							{
								$valid = FALSE;
								$modelClientBank[$x]->addError('bank_acct_num','Account Number must be unique');
								break;
							}
						}
					}
					if(!$valid)break;
				}
				
				for($x=0;$x<$authoCount;$x++)
				{
					$modelClientAutho[$x] = new Clientautho;
					$modelClientAutho[$x]->attributes = $_POST['Clientautho'][$x+1];
					
					if($model->custodian_cd)
					{
						$modelClientAutho[$x]->custodian = TRUE;
					}
					else {
						$modelClientAutho[$x]->custodian = FALSE;
					}
					
					if(isset($_POST['Clientautho'][$x+1]['save_flg']) && $_POST['Clientautho'][$x+1]['save_flg'] == 'Y')
					{
						if(isset($_POST['Clientautho'][$x+1]['cancel_flg']))
						{
							if($_POST['Clientautho'][$x+1]['cancel_flg'] == 'Y')
							{
								//CANCEL
								$modelClientAutho[$x]->scenario = 'cancel';
								$modelClientAutho[$x]->cancel_reason = $_POST['cancel_reason_autho'];
							}
							else 
							{
								//UPDATE
								$modelClientAutho[$x]->scenario = 'update';
							}
						}
						else 
						{
							//INSERT
							$modelClientAutho[$x]->scenario = 'insert';
						}
					
						$valid = $modelClientAutho[$x]->validate() && $valid;
					}
					else {
						$modelClientAutho[$x]->ktp_expiry = $modelClientAutho[$x]->old_ktp_expiry; //Get the old value since the field on form is disabled
						$modelClientAutho[$x]->passport_expiry = $modelClientAutho[$x]->old_passport_expiry;
						$modelClientAutho[$x]->kitas_expiry = $modelClientAutho[$x]->old_kitas_expiry;
						$modelClientAutho[$x]->npwp_date = $modelClientAutho[$x]->old_npwp_date;
						$modelClientAutho[$x]->birth_dt = $modelClientAutho[$x]->old_birth_dt;
					}
				}	
					
				for($x=0;$x<$authoCount;$x++)
				{
					for($y=$x+1;$y<$authoCount;$y++)
					{
						if(
							isset($_POST['Clientautho'][$x+1]['save_flg']) && $_POST['Clientautho'][$x+1]['save_flg'] == 'Y'
							&& isset($_POST['Clientautho'][$y+1]['save_flg']) && $_POST['Clientautho'][$y+1]['save_flg'] == 'Y'
							&& (!isset($_POST['Clientautho'][$x+1]['cancel_flg']) || $_POST['Clientautho'][$x+1]['cancel_flg'] != 'Y')
							&& (!isset($_POST['Clientautho'][$y+1]['cancel_flg']) || $_POST['Clientautho'][$y+1]['cancel_flg'] != 'Y')
						)
						{
							if($modelClientAutho[$x]->seqno == $modelClientAutho[$y]->seqno)
							{
								$valid = FALSE;
								$modelClientAutho[$x]->addError('seqno','No Urut must be unique');
								break;
							}
						}
					}		
					if(!$valid)break;
				}
				
				$seqno1 = 0; // Index of seqno number 1
				$seqno1UpdFlg = FALSE; // To determine whether the data of authorized person number 1 should be updated to MST_CIF 
				
				for($x=0;$x<$authoCount;$x++)
				{
					if(
						$_POST['Clientautho'][$x+1]['seqno'] == '1' 
						&& (
							(isset($_POST['Clientautho'][$x+1]['save_flg']) && $_POST['Clientautho'][$x+1]['save_flg'] == 'Y')
							|| $modelClientAutho[$x]->old_seqno //Record is saved or is old record
						)
						&& (!isset($_POST['Clientautho'][$x+1]['cancel_flg']) || $_POST['Clientautho'][$x+1]['cancel_flg'] != 'Y')
					)
					{
						$seqno1 = $x + 1;	
						if(isset($_POST['Clientautho'][$x+1]['save_flg']) && $_POST['Clientautho'][$x+1]['save_flg'] == 'Y')$seqno1UpdFlg = TRUE; 
					}
				}
				
				if(!$seqno1 /*&& $authoCount*/)
				{
					$valid = FALSE;
					
					if($authoCount)
						Yii::app()->user->setFlash('error','There has to be one authorized person with No urut 1');
					else
						Yii::app()->user->setFlash('error','There has to be at least one authorized person');
				}
				
				if($modelCif->inst_type != 90)
				{
					if($modelCif->inst_type)
						$modelCif->inst_type_txt = Parameter::model()->find("prm_cd_1 = 'KARAK' AND prm_cd_2 = '$modelCif->inst_type'")->prm_desc;
				}
				
				if($modelClientinst->premise_stat != 9)
				{
					if($modelClientinst->premise_stat)
						$modelClientinst->premise_stat_text = Parameter::model()->find("prm_cd_1 = 'OFFICE' AND prm_cd_2 = '$modelClientinst->premise_stat'")->prm_desc;
				}
				
				if($modelClientinst->investment_type != 9)
				{
					if($modelClientinst->investment_type)
						$modelClientinst->investment_type_text = Parameter::model()->find("prm_cd_1 = 'INSTRU' AND prm_cd_2 = '$modelClientinst->investment_type'")->prm_desc;
				}
				
				if($modelCif->industry_cd != 90)
				{
					if($modelCif->industry_cd)
						$modelCif->addl_fund = Parameter::model()->find("prm_cd_1 = 'INDUST' AND prm_cd_2 = '$modelCif->industry_cd'")->prm_desc;
				}
				
				if($modelCif->funds_code != 90)
				{
					if($modelCif->funds_code)
						$modelCif->source_of_funds = Parameter::model()->find("prm_cd_1 = 'FUNDC' AND prm_cd_2 = '$modelCif->funds_code'")->prm_desc;
				}
				
				if($modelCif->net_asset_cd != 90)
				{
					if($modelCif->net_asset_cd)
						$modelCif->net_asset = Parameter::model()->find("prm_cd_1 = 'NASSET' AND prm_cd_2 = '$modelCif->net_asset_cd'")->prm_desc;
				}
			
				if($modelClientinst->net_asset_cd2 != 90)
				{
					if($modelClientinst->net_asset_cd2)
						$modelClientinst->net_asset2 = Parameter::model()->find("prm_cd_1 = 'NASSET' AND prm_cd_2 = '$modelClientinst->net_asset_cd2'")->prm_desc;
				}
				
				if($modelClientinst->net_asset_cd3 != 90)
				{
					if($modelClientinst->net_asset_cd3)
						$modelClientinst->net_asset3 = Parameter::model()->find("prm_cd_1 = 'NASSET' AND prm_cd_2 = '$modelClientinst->net_asset_cd3'")->prm_desc;
				}
				
				if($modelCif->profit_cd != 90)
				{
					if($modelCif->profit_cd)
						$modelCif->profit = Parameter::model()->find("prm_cd_1 = 'PROFIT' AND prm_cd_2 = '$modelCif->profit_cd'")->prm_desc;
				}
				
				if($modelClientinst->profit_cd2 != 90)
				{
					if($modelClientinst->profit_cd2)
						$modelClientinst->profit2 = Parameter::model()->find("prm_cd_1 = 'PROFIT' AND prm_cd_2 = '$modelClientinst->profit_cd2'")->prm_desc;
				}
				
				if($modelClientinst->profit_cd3 != 90)
				{
					if($modelClientinst->profit_cd3)
						$modelClientinst->profit3 = Parameter::model()->find("prm_cd_1 = 'PROFIT' AND prm_cd_2 = '$modelClientinst->profit_cd3'")->prm_desc;
				}		
		
				if($model->recommended_by_cd != 9)
				{
					if($model->recommended_by_cd)
						$model->recommended_by_other = Parameter::model()->find("prm_cd_1 = 'RECBY' AND prm_cd_2 = '$model->recommended_by_cd'")->prm_desc;
				}
				
				if($valid)
				{					
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					if($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName) > 0)$success = TRUE;
					
					$model->client_birth_dt = $modelCif->client_birth_dt;
					
					$broker = Vbrokersubrek::model()->find();
					
					if($model->subrek001_1 && $model->subrek001_2 && $model->subrek004_1 && $model->subrek004_2)
					{
						$model->subrek001 = $broker->broker_cd.$model->subrek001_1.'001'.$model->subrek001_2;
						$model->subrek004 = $broker->broker_cd.$model->subrek004_1.'004'.$model->subrek004_2;
					}
					
					if(!$model->custodian_cd)
					{
						if($model->client_type_3 != 'M')$model->agreement_no = $model->subrek001;
						else {
							$model->agreement_no = Vbrokersubrek::model()->find()->broker_004;
						}
						
						$exist001 = DAO::queryRowSql("SELECT client_cd FROM MST_CLIENT_REKEFEK WHERE SUBSTR(subrek_cd,6,4) = '$model->subrek001_1' AND SUBSTR(subrek_cd,10,3) = '001' AND SUBSTR(subrek_cd,6,4) <> '0000' AND client_cd <> '$model->client_cd' AND status = 'A'");
						$exist004 = DAO::queryRowSql("SELECT client_cd FROM MST_CLIENT_REKEFEK WHERE SUBSTR(subrek_cd,6,4) = '$model->subrek004_1' AND SUBSTR(subrek_cd,10,3) = '004' AND SUBSTR(subrek_cd,6,4) <> '0000' AND cifs <> '$model->cifs' AND status = 'A'");
						
						if($exist001)
						{
							$success = false;
							$model->addError('subrek001_01','Duplicated Subrek 001');
						}
						
						if($exist004)
						{
							$success = false;
							$model->addError('subrek004_01','Duplicated Subrek 004');
						}
					}
					
					if($model->stop_pay == 'Y')$model->e_mail1 = $modelCif->e_mail1;
					
					$model->bank_cd = $modelClientBank[$default-1]->bank_cd;
					$model->bank_acct_num = $modelClientBank[$default-1]->bank_acct_num;
					$model->bank_brch_cd = $modelClientBank[$default-1]->bank_brch_cd;
					
					if($seqno1UpdFlg)
					{
						$middle_name = $last_name = '';
						$idType;
						$idNum;
						$idExpiry;
						
						if($modelClientAutho[$seqno1-1]->middle_name)$middle_name = ' '.$modelClientAutho[$seqno1-1]->middle_name;
						
						if($modelClientAutho[$seqno1-1]->last_name)$last_name = ' '.$modelClientAutho[$seqno1-1]->last_name;
						
						if($modelClientAutho[$seqno1-1]->ktp_no)
						{
							$idType = Parameter::model()->find("prm_cd_1 = 'IDTYPE' AND prm_desc = 'KTP'")->prm_cd_2;
							$idNum = $modelClientAutho[$seqno1-1]->ktp_no;
							$idExpiry = $modelClientAutho[$seqno1-1]->ktp_expiry;
						}
						else if($modelClientAutho[$seqno1-1]->passport_no)
						{
							$idType = Parameter::model()->find("prm_cd_1 = 'IDTYPE' AND prm_desc = 'PASSPORT'")->prm_cd_2;
							$idNum = $modelClientAutho[$seqno1-1]->passport_no;
							$idExpiry = $modelClientAutho[$seqno1-1]->passport_expiry;
						}
						else if($modelClientAutho[$seqno1-1]->kitas_no)
						{
							$idType = Parameter::model()->find("prm_cd_1 = 'IDTYPE' AND prm_desc = 'KITAS'")->prm_cd_2;
							$idNum = $modelClientAutho[$seqno1-1]->kitas_no;
							$idExpiry = $modelClientAutho[$seqno1-1]->kitas_expiry;
						}
						else if($modelClientAutho[$seqno1-1]->npwp_no)
						{
							$idType = Parameter::model()->find("prm_cd_1 = 'IDTYPE' AND prm_desc = 'NPWP'")->prm_cd_2;
							$idNum = $modelClientAutho[$seqno1-1]->npwp_no;
							$idExpiry = $modelClientAutho[$seqno1-1]->npwp_expiry;
						}
						else 
						{
							$idType = $idNum = $idExpiry = '';
						}
						
						$modelCif->autho_person_name = $modelClientAutho[$seqno1-1]->first_name.$middle_name.$last_name;
						$modelCif->autho_person_ic_type = $idType;
						$modelCif->autho_person_ic_num = $idNum;
						$modelCif->autho_person_position = $modelClientAutho[$seqno1-1]->position;
						$modelCif->autho_person_ic_expiry = $idExpiry;
					}
					
					if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->client_cd,1) > 0)$success = TRUE;
					else {
						$success = FALSE;
					}
					
					if($success)
					{					
						if($modelCif->cifs == 'NEW') 
						{
							//NEW CIF
							$modelCif->cifs = $modelClientinst->cifs = $model->cifs;
							$modelCif->purpose06 = $modelCif->purpose07 = $modelCif->purpose08 = $modelCif->purpose09 = $modelCif->purpose10 = $modelCif->purpose11 = '00';
							$modelCif->asset_owner = '1';
							
							if($modelCif->executeSp(AConstant::INBOX_STAT_INS,$modelCif->cifs,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
							else {
								$success = FALSE;
							}
							
							if($success && $modelClientinst->executeSp(AConstant::INBOX_STAT_INS,$modelClientinst->cifs,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
							else {
								$success = FALSE;
							}
							
							if($success)
							{
								$x = 0;
								foreach($modelClientBank as $row)
								{
									if($row->save_flg == 'Y')
									{
										$row->client_cd = $model->client_cd;
										$row->cifs = $modelCif->cifs;
										$row->old_bank_acct_num = $row->bank_acct_num;
										
										if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$modelCif->cifs,$model->update_date,$model->update_seq,$x+1) > 0)$success = TRUE;
										else {
											$success = FALSE;
										}
										$row->old_bank_acct_num = '';
										$x++;
									}
								}
							}
							
							if($success)
							{
								$x = 0;
								foreach($modelClientAutho as $row)
								{
									$row->cifs = $modelCif->cifs;
									if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$modelCif->cifs,$model->update_date,$model->update_seq,$x+1) > 0)$success = TRUE;
									else {
										$success = FALSE;
									}
									$x++;
								}
							}
							
							$modelCif->cifs = 'NEW';
						}
						else 
						{
							//EXISTING CIF
							$modelCif->purpose06 = $modelCif->purpose07 = $modelCif->purpose08 = $modelCif->purpose09 = $modelCif->purpose10 = $modelCif->purpose11 = '00';
							
							if($modelCif->executeSp(AConstant::INBOX_STAT_UPD,$modelCif->cifs,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
							else {
								$success = FALSE;
							}
							
							if($success && $modelClientinst->executeSp(AConstant::INBOX_STAT_UPD,$modelClientinst->cifs,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
							else {
								$success = FALSE;
							}
														
							if($success)
							{
								$recordSeq = 1;
								for($x=0; $success && $x<$rowCount; $x++)
								{
									if($modelClientBank[$x]->save_flg == 'Y')
									{
										$modelClientBank[$x]->client_cd = $model->client_cd;
										$modelClientBank[$x]->cifs = $modelCif->cifs;
										
										if($modelClientBank[$x]->cancel_flg == 'Y')
										{
											//CANCEL
											$modelClientBank[$x]->bank_cd = $modelClientBank[$x]->old_bank_cd;
											if($success && $modelClientBank[$x]->executeSp(AConstant::INBOX_STAT_CAN,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
											else {
												$success = false;
											}
										}
										else if($modelClientBank[$x]->old_bank_acct_num)
										{
											//UPDATE
											if($success && $modelClientBank[$x]->executeSp(AConstant::INBOX_STAT_UPD,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
											else {
												$success = false;
											}
										}			
										else 
										{
											//INSERT
											$modelClientBank[$x]->old_bank_acct_num = $modelClientBank[$x]->bank_acct_num;
											if($success && $modelClientBank[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
											else {
												$success = false;
											}
											$modelClientBank[$x]->old_bank_acct_num = '';
										}
										$recordSeq++;
									}
								}

								$recordSeq = 1;
								for($x=0; $success && $x<$authoCount; $x++)
								{
									if($modelClientAutho[$x]->save_flg == 'Y')
									{
										$modelClientAutho[$x]->cifs = $modelCif->cifs;
										
										if($modelClientAutho[$x]->cancel_flg == 'Y')
										{
											//CANCEL
											$modelClientAutho[$x]->seqno = $modelClientAutho[$x]->old_seqno;
											if($success && $modelClientAutho[$x]->executeSp(AConstant::INBOX_STAT_CAN,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
											else {
												$success = false;
											}
										}
										else if($modelClientAutho[$x]->old_seqno)
										{
											//UPDATE
											if($success && $modelClientAutho[$x]->executeSp(AConstant::INBOX_STAT_UPD,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
											else {
												$success = false;
											}
										}			
										else 
										{
											//INSERT
											$modelClientAutho[$x]->old_seqno = $modelClientAutho[$x]->seqno;
											if($success && $modelClientAutho[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
											else {
												$success = false;
											}
											$modelClientAutho[$x]->old_seqno = '';
										}
										$recordSeq++;
									}
								}
							
							}					
						}
					}	
					
					if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Successfully create Client');
						$this->redirect(array('/master/clientcorp/index'));
					}
					else {
						$transaction->rollback();
					}			
				}
				
				foreach($modelClientAutho as $row)
				{
					if($row->ktp_expiry)$row->ktp_expiry = DateTime::createFromFormat('Y-m-d',$row->ktp_expiry)->format('d/m/Y');
					if($row->passport_expiry)$row->passport_expiry = DateTime::createFromFormat('Y-m-d',$row->passport_expiry)->format('d/m/Y');
					if($row->kitas_expiry)$row->kitas_expiry = DateTime::createFromFormat('Y-m-d',$row->kitas_expiry)->format('d/m/Y');
					if($row->npwp_date)$row->npwp_date = DateTime::createFromFormat('Y-m-d',$row->npwp_date)->format('d/m/Y');
					if($row->birth_dt)$row->birth_dt = DateTime::createFromFormat('Y-m-d',$row->birth_dt)->format('d/m/Y');
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'supplRequired'=>$supplRequired,
			'modelClientinst'=>$modelClientinst,
			'modelCif'=>$modelCif,
			'modelClientBank'=>$modelClientBank,
			'modelClientAutho'=>$modelClientAutho,
			'modelClientMember'=>$modelClientMember,
			'minimumFeeFlg'=>$minimumFeeFlg,
			'withholdingTaxFlg'=>$withholdingTaxFlg,
			'acopenFeeFlg'=>$acopenFeeFlg,
			'taxOnInterestFlg'=>$taxOnInterestFlg,
			'pphFlg'=>$pphFlg,
			'init_deposit_cd'=>$init_deposit_cd,
			'cancel_reason'=>$cancel_reason,
			'cancel_reason_autho'=>$cancel_reason_autho,
			'render'=>$render
		));
	}

	public function actionUpdate($id)
	{
		$model			 = $this->loadModel($id);
		$modelClientinst = $this->loadModelClientinst($model->cifs);
		$modelCif 		 = $this->loadModelCif($model->cifs);
		$modelClientBank = array();
		$modelClientAutho = array();
		$modelClientMember = VClientmember::model()->findAll("cifs = '$modelCif->cifs'");
		
		//RD: Edited add suppl_doc_type and suppl_exp_date 7 sept 2017
		$a = Sysparam::model()->findAll("param_id = 'CLIENT MASTER' AND param_cd1 = 'SUPPL' AND param_cd2 = 'REQUIRED'");
		
		$supplRequired = null;
		for($x = 0; $x < count($a); $x++){
			if($x < count($a)-1){
				$supplRequired = $supplRequired."'".$a[$x]['dstr1']."',";
			}else{
				$supplRequired = $supplRequired."'".$a[$x]['dstr1']."'";
			}
		}
		
		$model->old_branch_code = $model->branch_code = trim($model->branch_code);
		$model->old_rem_cd = $model->rem_cd;
		
		$init_deposit_cd = array('dana'=>$model->init_deposit_amount?'D':'','efek'=>$model->init_deposit_efek?'E':'');
		
		$row = VClientSubrek14::model()->find("client_cd = '$model->client_cd'");
		
		if($row)
		{
			$subrek1 = $row->subrek001;
			$model->subrek001_1 = substr($subrek1,5,4);
			$model->subrek001_2 = substr($subrek1,12,2);
			
			$row2 = Vbrokersubrek::model()->find();
			
			$subrek4 = $row->subrek004;
			if(!$subrek4)$subrek4 = $row2->broker_004;
			
			$model->subrek004_1 = substr($subrek4,5,4);
			$model->subrek004_2 = substr($subrek4,12,2);
		}
		
		$model->client_title = trim($model->client_title);
		
		$menuName = 'INSTITUTIONAL CLIENT PROFILE ENTRY';
		
		$cancel_reason = '';
		$cancel_reason_autho = '';
		
		$render = TRUE;
		$valid = FALSE;
		$success = FALSE;
		
		$minimumFeeFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'MINFEE' AND param_cd2 = 'DEFAULT'");
		$withholdingTaxFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'WHTAX' AND param_cd2 = 'DEFAULT'");
		$acopenFeeFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'OTC' AND param_cd2 = 'DEFAULT'");
		$taxOnInterestFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'INTTAX' AND param_cd2 = 'DEFAULT'");
		$recovChargeFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = '2490' AND param_cd2 = 'DEFAULT'");
		$pphFlg = Sysparam::model()->find("param_id = 'CLIENT MASTER' AND param_cd1 = 'PPH' AND param_cd2 = 'DEFAULT'");
		
		if(isset($_POST['Client']))
		{
			$model->attributes = $_POST['Client'];
			$modelClientinst->attributes 		= $_POST['Clientinst'];
			$modelCif->attributes 		 		= $_POST['Cif'];
			
			$init_deposit_cd['dana'] = isset($_POST['dana'])?$_POST['dana']:'';
			$init_deposit_cd['efek'] = isset($_POST['efek'])?$_POST['efek']:'';
			
			$model->client_type_2 = $modelCif->client_type_2;
			$model->biz_type = $modelCif->biz_type;
			
			$model->sid = $modelCif->sid = str_replace('.','',$modelCif->sid);
			$model->npwp_no = $modelCif->npwp_no = str_replace(array('.','-'),'',$modelCif->npwp_no);
			
			if($model->custodian_cd)
			{
				$modelCif->custodian = TRUE;
			}
			else {
				$modelCif->custodian = FALSE;
			}
			
			$valid = $model->validate();
			$valid = $modelClientinst->validate() && $valid;
			$valid = $modelCif->validate() && $valid;
			
			$x;
			$y;
			
			$rowCount = $_POST['rowCount'];
			$authoCount = $_POST['authoCount']/3;
			
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
			
			if(isset($_POST['cancel_reason_autho']))
			{
				if(!$_POST['cancel_reason_autho'])
				{
					$valid = false;
					Yii::app()->user->setFlash('error', 'Authorized Persons Cancel Reason Must be Filled');
				}
				else
				{
					$cancel_reason_autho = $_POST['cancel_reason_autho'];
					if(!$model->cancel_reason)$model->cancel_reason = $_POST['cancel_reason_autho'];
				}
			}
			
			if(!isset($_POST['default']))
			{
				$default = '';
				$valid = FALSE;
				Yii::app()->user->setFlash('error','Client must have one default bank account');
			}
			else {
				$default = $_POST['default'];	
			}
			
			for($x=0;$x<$rowCount;$x++)
			{
				$modelClientBank[$x] = new Clientbank;
				$modelClientBank[$x]->attributes = $_POST['Clientbank'][$x+1];
				
				if($x+1 == $default)$modelClientBank[$x]->default_flg = 'Y';
				else {
					$modelClientBank[$x]->default_flg = 'N';	
				}
				
				if(isset($_POST['Clientbank'][$x+1]['save_flg']) && $_POST['Clientbank'][$x+1]['save_flg'] == 'Y')
				{
					if(isset($_POST['Clientbank'][$x+1]['cancel_flg']))
					{
						if($_POST['Clientbank'][$x+1]['cancel_flg'] == 'Y')
						{
							//CANCEL
							$modelClientBank[$x]->scenario = 'cancel';
							$modelClientBank[$x]->cancel_reason = $_POST['cancel_reason'];
						}
						else 
						{
							//UPDATE
							$modelClientBank[$x]->scenario = 'update';
						}
					}
					else 
					{
						//INSERT
						$modelClientBank[$x]->scenario = 'insert';
					}
				
					$valid = $modelClientBank[$x]->validate() && $valid;
				}
				else {
					$modelClientBank[$x]->bank_cd = $modelClientBank[$x]->old_bank_cd; //Get the old value since the field on form is disabled
				}
			}
			
			for($x=0;$x<$rowCount;$x++)
			{
				for($y=$x+1;$y<$rowCount;$y++)
				{
					if(
						isset($_POST['Clientbank'][$x+1]['save_flg']) && $_POST['Clientbank'][$x+1]['save_flg'] == 'Y'
						&& isset($_POST['Clientbank'][$y+1]['save_flg']) && $_POST['Clientbank'][$y+1]['save_flg'] == 'Y'
						&& (!isset($_POST['Clientbank'][$x+1]['cancel_flg']) || $_POST['Clientbank'][$x+1]['cancel_flg'] != 'Y')
						&& (!isset($_POST['Clientbank'][$y+1]['cancel_flg']) || $_POST['Clientbank'][$y+1]['cancel_flg'] != 'Y')
					)
					{
						if($modelClientBank[$x]->bank_acct_num == $modelClientBank[$y]->bank_acct_num)
						{
							$valid = FALSE;
							$modelClientBank[$x]->addError('bank_acct_num','Account Number must be unique');
							break;
						}
					}
				}
				if(!$valid)break;
			}
			
			for($x=0;$x<$authoCount;$x++)
			{
				$modelClientAutho[$x] = new Clientautho;
				$modelClientAutho[$x]->attributes = $_POST['Clientautho'][$x+1];
				
				if($model->custodian_cd)
				{
					$modelClientAutho[$x]->custodian = TRUE;
				}
				else {
					$modelClientAutho[$x]->custodian = FALSE;
				}
				
				if(isset($_POST['Clientautho'][$x+1]['save_flg']) && $_POST['Clientautho'][$x+1]['save_flg'] == 'Y')
				{
					if(isset($_POST['Clientautho'][$x+1]['cancel_flg']))
					{
						if($_POST['Clientautho'][$x+1]['cancel_flg'] == 'Y')
						{
							//CANCEL
							$modelClientAutho[$x]->scenario = 'cancel';
							$modelClientAutho[$x]->cancel_reason = $_POST['cancel_reason'];
						}
						else 
						{
							//UPDATE
							$modelClientAutho[$x]->scenario = 'update';
						}
					}
					else 
					{
						//INSERT
						$modelClientAutho[$x]->scenario = 'insert';
					}
				
					$valid = $modelClientAutho[$x]->validate() && $valid;
				}
				else {
					$modelClientAutho[$x]->ktp_expiry = $modelClientAutho[$x]->old_ktp_expiry; //Get the old value since the field on form is disabled
					$modelClientAutho[$x]->passport_expiry = $modelClientAutho[$x]->old_passport_expiry;
					$modelClientAutho[$x]->kitas_expiry = $modelClientAutho[$x]->old_kitas_expiry;
					$modelClientAutho[$x]->npwp_date = $modelClientAutho[$x]->old_npwp_date;
					$modelClientAutho[$x]->birth_dt = $modelClientAutho[$x]->old_birth_dt;
				}
			}
				
			for($x=0;$x<$authoCount;$x++)
			{
				for($y=$x+1;$y<$authoCount;$y++)
				{
					if(
						isset($_POST['Clientautho'][$x+1]['save_flg']) && $_POST['Clientautho'][$x+1]['save_flg'] == 'Y'
						&& isset($_POST['Clientautho'][$y+1]['save_flg']) && $_POST['Clientautho'][$y+1]['save_flg'] == 'Y'
						&& (!isset($_POST['Clientautho'][$x+1]['cancel_flg']) || $_POST['Clientautho'][$x+1]['cancel_flg'] != 'Y')
						&& (!isset($_POST['Clientautho'][$y+1]['cancel_flg']) || $_POST['Clientautho'][$y+1]['cancel_flg'] != 'Y')
					)
					{
						if($modelClientAutho[$x]->seqno == $modelClientAutho[$y]->seqno)
						{
							$valid = FALSE;
							$modelClientAutho[$x]->addError('seqno','No Urut must be unique');
							break;
						}
					}
				}		
				if(!$valid)break;
			}
			
			$seqno1 = 0; // Index of seqno number 1
			$seqno1UpdFlg = FALSE; // To determine whether the data of authorized person number 1 should be updated to MST_CIF 
			
			for($x=0;$x<$authoCount;$x++)
			{
				if(
					$_POST['Clientautho'][$x+1]['seqno'] == '1' 
					&& (
						(isset($_POST['Clientautho'][$x+1]['save_flg']) && $_POST['Clientautho'][$x+1]['save_flg'] == 'Y')
						|| $modelClientAutho[$x]->old_seqno //Record is saved or is old record
					)
					&& (!isset($_POST['Clientautho'][$x+1]['cancel_flg']) || $_POST['Clientautho'][$x+1]['cancel_flg'] != 'Y')
				)
				{
					$seqno1 = $x + 1;	
					if(isset($_POST['Clientautho'][$x+1]['save_flg']) && $_POST['Clientautho'][$x+1]['save_flg'] == 'Y')$seqno1UpdFlg = TRUE; 
				}
			}
			
			if(!$seqno1 && $authoCount)
			{
				$valid = FALSE;
				$modelClientAutho[0]->addError('seqno','There has to be one authorized person with No urut 1');
			}
		
			if($modelCif->inst_type != 90)
			{
				if($modelCif->inst_type)
					$modelCif->inst_type_txt = Parameter::model()->find("prm_cd_1 = 'KARAK' AND prm_cd_2 = '$modelCif->inst_type'")->prm_desc;
			}
			
			if($modelClientinst->premise_stat != 9)
			{
				if($modelClientinst->premise_stat)
					$modelClientinst->premise_stat_text = Parameter::model()->find("prm_cd_1 = 'OFFICE' AND prm_cd_2 = '$modelClientinst->premise_stat'")->prm_desc;
			}
			
			if($modelClientinst->investment_type != 9)
			{
				if($modelClientinst->investment_type)
					$modelClientinst->investment_type_text = Parameter::model()->find("prm_cd_1 = 'INSTRU' AND prm_cd_2 = '$modelClientinst->investment_type'")->prm_desc;
			}
			
			if($modelCif->industry_cd != 90)
			{
				if($modelCif->industry_cd)
					$modelCif->addl_fund = Parameter::model()->find("prm_cd_1 = 'INDUST' AND prm_cd_2 = '$modelCif->industry_cd'")->prm_desc;
			}
			
			if($modelCif->funds_code != 90)
			{
				if($modelCif->funds_code)
					$modelCif->source_of_funds = Parameter::model()->find("prm_cd_1 = 'FUNDC' AND prm_cd_2 = '$modelCif->funds_code'")->prm_desc;
			}
			
			if($modelCif->net_asset_cd != 90)
			{
				if($modelCif->net_asset_cd)
					$modelCif->net_asset = Parameter::model()->find("prm_cd_1 = 'NASSET' AND prm_cd_2 = '$modelCif->net_asset_cd'")->prm_desc;
			}
			
			if($modelClientinst->net_asset_cd2 != 90)
			{
				if($modelClientinst->net_asset_cd2)
					$modelClientinst->net_asset2 = Parameter::model()->find("prm_cd_1 = 'NASSET' AND prm_cd_2 = '$modelClientinst->net_asset_cd2'")->prm_desc;
			}
			
			if($modelClientinst->net_asset_cd3 != 90)
			{
				if($modelClientinst->net_asset_cd3)
					$modelClientinst->net_asset3 = Parameter::model()->find("prm_cd_1 = 'NASSET' AND prm_cd_2 = '$modelClientinst->net_asset_cd3'")->prm_desc;
			}
			
			if($modelCif->profit_cd != 90)
			{
				if($modelCif->profit_cd)
					$modelCif->profit = Parameter::model()->find("prm_cd_1 = 'PROFIT' AND prm_cd_2 = '$modelCif->profit_cd'")->prm_desc;
			}
			
			if($modelClientinst->profit_cd2 != 90)
			{
				if($modelClientinst->profit_cd2)
					$modelClientinst->profit2 = Parameter::model()->find("prm_cd_1 = 'PROFIT' AND prm_cd_2 = '$modelClientinst->profit_cd2'")->prm_desc;
			}
			
			if($modelClientinst->profit_cd3 != 90)
			{
				if($modelClientinst->profit_cd3)
					$modelClientinst->profit3 = Parameter::model()->find("prm_cd_1 = 'PROFIT' AND prm_cd_2 = '$modelClientinst->profit_cd3'")->prm_desc;
			}
			
			if($model->recommended_by_cd != 9)
			{
				if($model->recommended_by_cd)
					$model->recommended_by_other = Parameter::model()->find("prm_cd_1 = 'RECBY' AND prm_cd_2 = '$model->recommended_by_cd'")->prm_desc;
			}
		
			if($valid)
			{
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				
				if($model->executeSpHeader(AConstant::INBOX_STAT_UPD, $menuName) > 0)$success = TRUE;
				
				$model->client_birth_dt = $modelCif->client_birth_dt;
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->commit_fee_dt))$model->commit_fee_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->commit_fee_dt)->format('Y-m-d');
				
				$broker = Vbrokersubrek::model()->find();
				
				if($model->subrek001_1 && $model->subrek001_2 && $model->subrek004_1 && $model->subrek004_2)
				{
					$model->subrek001 = $broker->broker_cd.$model->subrek001_1.'001'.$model->subrek001_2;
					$model->subrek004 = $broker->broker_cd.$model->subrek004_1.'004'.$model->subrek004_2;
				}
				
				if(!$model->custodian_cd)
				{
					if($model->client_type_3 != 'M')$model->agreement_no = $model->subrek001;
					else {
						$model->agreement_no = Vbrokersubrek::model()->find()->broker_004;
					}
					
					$exist001 = DAO::queryRowSql("SELECT client_cd FROM MST_CLIENT_REKEFEK WHERE SUBSTR(subrek_cd,6,4) = '$model->subrek001_1' AND SUBSTR(subrek_cd,10,3) = '001' AND SUBSTR(subrek_cd,6,4) <> '0000' AND client_cd <> '$model->client_cd' AND status = 'A'");
					$exist004 = DAO::queryRowSql("SELECT client_cd FROM MST_CLIENT_REKEFEK WHERE SUBSTR(subrek_cd,6,4) = '$model->subrek004_1' AND SUBSTR(subrek_cd,10,3) = '004' AND SUBSTR(subrek_cd,6,4) <> '0000' AND cifs <> '$model->cifs' AND status = 'A'");
					
					if($exist001)
					{
						$success = false;
						$model->addError('subrek001_01','Duplicated Subrek 001');
					}
					
					if($exist004)
					{
						$success = false;
						$model->addError('subrek004_01','Duplicated Subrek 004');
					}
				}
				
				if($model->stop_pay == 'Y')$model->e_mail1 = $modelCif->e_mail1;
				
				$model->bank_cd = $modelClientBank[$default-1]->bank_cd;
				$model->bank_acct_num = $modelClientBank[$default-1]->bank_acct_num;
				$model->bank_brch_cd = $modelClientBank[$default-1]->bank_brch_cd;
				
				if($seqno1UpdFlg)
				{
					$middle_name = $last_name = '';
					$idType;
					$idNum;
					$idExpiry;
					
					if($modelClientAutho[$seqno1-1]->middle_name)$middle_name = ' '.$modelClientAutho[$seqno1-1]->middle_name;
					
					if($modelClientAutho[$seqno1-1]->last_name)$last_name = ' '.$modelClientAutho[$seqno1-1]->last_name;
					
					if($modelClientAutho[$seqno1-1]->ktp_no)
					{
						$idType = Parameter::model()->find("prm_cd_1 = 'IDTYPE' AND prm_desc = 'KTP'")->prm_cd_2;
						$idNum = $modelClientAutho[$seqno1-1]->ktp_no;
						$idExpiry = $modelClientAutho[$seqno1-1]->ktp_expiry;
					}
					else if($modelClientAutho[$seqno1-1]->passport_no)
					{
						$idType = Parameter::model()->find("prm_cd_1 = 'IDTYPE' AND prm_desc = 'PASSPORT'")->prm_cd_2;
						$idNum = $modelClientAutho[$seqno1-1]->passport_no;
						$idExpiry = $modelClientAutho[$seqno1-1]->passport_expiry;
					}
					else if($modelClientAutho[$seqno1-1]->kitas_no)
					{
						$idType = Parameter::model()->find("prm_cd_1 = 'IDTYPE' AND prm_desc = 'KITAS'")->prm_cd_2;
						$idNum = $modelClientAutho[$seqno1-1]->kitas_no;
						$idExpiry = $modelClientAutho[$seqno1-1]->kitas_expiry;
					}
					else if($modelClientAutho[$seqno1-1]->npwp_no)
					{
						$idType = Parameter::model()->find("prm_cd_1 = 'IDTYPE' AND prm_desc = 'NPWP'")->prm_cd_2;
						$idNum = $modelClientAutho[$seqno1-1]->npwp_no;
						$idExpiry = $modelClientAutho[$seqno1-1]->npwp_expiry;
					}
					else 
					{
						$idType = $idNum = $idExpiry = '';
					}
					
					$modelCif->autho_person_name = $modelClientAutho[$seqno1-1]->first_name.$middle_name.$last_name;
					$modelCif->autho_person_ic_type = $idType;
					$modelCif->autho_person_ic_num = $idNum;
					$modelCif->autho_person_position = $modelClientAutho[$seqno1-1]->position;
					$modelCif->autho_person_ic_expiry = $idExpiry;
				}
				
				if($success && $model->executeSp(AConstant::INBOX_STAT_UPD,$id,1) > 0)$success = TRUE;
				else {
					$success = FALSE;
				}
				
				if($success)
				{					
					//$oldModelClientBank = Clientbank::model()->findAll("cifs = '$modelCif->cifs' and approved_stat = 'A'");
					
					if($modelCif->executeSp(AConstant::INBOX_STAT_UPD,$modelCif->cifs,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
					else {
						$success = FALSE;
					}
					
					if($success && $modelClientinst->executeSp(AConstant::INBOX_STAT_UPD,$modelClientinst->cifs,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
					else {
						$success = FALSE;
					}
					
					if($success)
					{
						$recordSeq = 1;
						for($x=0; $success && $x<$rowCount; $x++)
						{
							if($modelClientBank[$x]->save_flg == 'Y')
							{
								$modelClientBank[$x]->client_cd = $model->client_cd;
								$modelClientBank[$x]->cifs = $modelCif->cifs;
								
								if($modelClientBank[$x]->cancel_flg == 'Y')
								{
									//CANCEL
									$modelClientBank[$x]->bank_cd = $modelClientBank[$x]->old_bank_cd;
									if($success && $modelClientBank[$x]->executeSp(AConstant::INBOX_STAT_CAN,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}
								else if($modelClientBank[$x]->old_bank_acct_num)
								{
									//UPDATE
									if($success && $modelClientBank[$x]->executeSp(AConstant::INBOX_STAT_UPD,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}			
								else 
								{
									//INSERT
									$modelClientBank[$x]->old_bank_acct_num = $modelClientBank[$x]->bank_acct_num;
									if($success && $modelClientBank[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}
								$recordSeq++;
							}
						}

						$recordSeq = 1;
						for($x=0; $success && $x<$authoCount; $x++)
						{
							if($modelClientAutho[$x]->save_flg == 'Y')
							{
								$modelClientAutho[$x]->cifs = $modelCif->cifs;
								
								if($modelClientAutho[$x]->cancel_flg == 'Y')
								{
									//CANCEL
									$modelClientAutho[$x]->seqno = $modelClientAutho[$x]->old_seqno;
									if($success && $modelClientAutho[$x]->executeSp(AConstant::INBOX_STAT_CAN,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}
								else if($modelClientAutho[$x]->old_seqno)
								{
									//UPDATE
									if($success && $modelClientAutho[$x]->executeSp(AConstant::INBOX_STAT_UPD,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}			
								else 
								{
									//INSERT
									$modelClientAutho[$x]->old_seqno = $modelClientAutho[$x]->seqno;
									if($success && $modelClientAutho[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
									$modelClientAutho[$x]->old_seqno = '';
								}
								$recordSeq++;
							}
						}
					}						
				}	
				
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully update Client');
					$this->redirect(array('/master/clientcorp/index'));
				}
				else {
					$transaction->rollback();
				}			
			}

			foreach($modelClientAutho as $row)
			{
				if($row->ktp_expiry)$row->ktp_expiry = DateTime::createFromFormat('Y-m-d',$row->ktp_expiry)->format('d/m/Y');
				if($row->passport_expiry)$row->passport_expiry = DateTime::createFromFormat('Y-m-d',$row->passport_expiry)->format('d/m/Y');
				if($row->kitas_expiry)$row->kitas_expiry = DateTime::createFromFormat('Y-m-d',$row->kitas_expiry)->format('d/m/Y');
				if($row->npwp_date)$row->npwp_date = DateTime::createFromFormat('Y-m-d',$row->npwp_date)->format('d/m/Y');
				if($row->birth_dt)$row->birth_dt = DateTime::createFromFormat('Y-m-d',$row->birth_dt)->format('d/m/Y');
			}
		}
		else 
		{	
			/*$query = " SELECT a.bank_acct_num AS def_bank_acct_num, b.*
						FROM MST_CLIENT a, MST_CLIENT_BANK b
						WHERE a.cifs = b.cifs
						AND a.client_cd IN
						(
							SELECT client_cd FROM MST_CLIENT
							WHERE cifs = '$model->cifs'
							AND ROWNUM = 1
						)
						AND b.approved_stat = 'A'";*/
			$modelClientAutho = Clientautho::model()->findAll("cifs = '$model->cifs' AND approved_stat = 'A'");
						
			foreach($modelClientAutho as $row)
			{
				$row->old_seqno = $row->seqno;
				
				if($row->ktp_expiry)
				{
					$row->ktp_expiry = DateTime::createFromFormat('Y-m-d G:i:s',$row->ktp_expiry)->format('d/m/Y');
					$row->old_ktp_expiry = DateTime::createFromFormat('d/m/Y',$row->ktp_expiry)->format('Y-m-d');
				}
				if($row->passport_expiry)
				{
					$row->passport_expiry = DateTime::createFromFormat('Y-m-d G:i:s',$row->passport_expiry)->format('d/m/Y');
					$row->old_passport_expiry = DateTime::createFromFormat('d/m/Y',$row->passport_expiry)->format('Y-m-d');
				}
				if($row->kitas_expiry)
				{
					$row->kitas_expiry = DateTime::createFromFormat('Y-m-d G:i:s',$row->kitas_expiry)->format('d/m/Y');
					$row->old_kitas_expiry = DateTime::createFromFormat('d/m/Y',$row->kitas_expiry)->format('Y-m-d');
				}
				if($row->npwp_date)
				{
					$row->npwp_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->npwp_date)->format('d/m/Y');
					$row->old_npwp_date = DateTime::createFromFormat('d/m/Y',$row->npwp_date)->format('Y-m-d');
				}
				if($row->birth_dt)
				{
					$row->birth_dt = DateTime::createFromFormat('Y-m-d G:i:s',$row->birth_dt)->format('d/m/Y');
					$row->old_birth_dt = DateTime::createFromFormat('d/m/Y',$row->birth_dt)->format('Y-m-d');
				}
			}
						
			$query = " SELECT a.bank_acct_num AS def_bank_acct_num, b.*
						FROM MST_CLIENT a, MST_CLIENT_BANK b
						WHERE a.cifs = b.cifs
						AND a.client_cd =  '$model->client_cd'
						AND b.approved_stat = 'A'";
			
			$modelTemp = DAO::queryAllSql($query);
			
			$x = 0;
			
			foreach($modelTemp as $row)
			{
				$modelClientBank[$x] = new Clientbank;
				
				foreach($modelClientBank[$x] as $key=>$value)
				{
					foreach($row as $key2=>$value2)
					{
						if(strtoupper(trim($key)) == strtoupper(trim($key2)))
						{
							$modelClientBank[$x]->setAttribute($key,$value2);
							unset($row[$key2]);
							break;
						}
					}
				}
				$modelClientBank[$x]->old_bank_acct_num = $modelClientBank[$x]->bank_acct_num;
				$modelClientBank[$x]->old_bank_cd = $modelClientBank[$x]->bank_cd;
				$modelClientBank[$x]->old_bank_branch = $modelClientBank[$x]->bank_branch;
				$modelClientBank[$x]->old_bank_phone_num = $modelClientBank[$x]->bank_phone_num;
				$modelClientBank[$x]->old_acct_name = $modelClientBank[$x]->acct_name;
				$modelClientBank[$x]->old_bank_acct_type = $modelClientBank[$x]->bank_acct_type;
				$modelClientBank[$x]->old_bank_acct_currency = $modelClientBank[$x]->bank_acct_currency;
								
				if($modelClientBank[$x]->bank_acct_num == $row['def_bank_acct_num'])$modelClientBank[$x]->default_flg = 'Y';
				else {
					$modelClientBank[$x]->default_flg = 'N';
				}
				
				$x++;
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'supplRequired'=>$supplRequired,
			'modelClientinst'=>$modelClientinst,
			'modelCif'=>$modelCif,
			'modelClientBank'=>$modelClientBank,
			'modelClientAutho'=>$modelClientAutho,
			'modelClientMember'=>$modelClientMember,
			'minimumFeeFlg'=>$minimumFeeFlg,
			'withholdingTaxFlg'=>$withholdingTaxFlg,
			'acopenFeeFlg'=>$acopenFeeFlg,
			'taxOnInterestFlg'=>$taxOnInterestFlg,
			'pphFlg'=>$pphFlg,
			'init_deposit_cd'=>$init_deposit_cd,
			'cancel_reason'=>$cancel_reason,
			'cancel_reason_autho'=>$cancel_reason_autho,
			'render'=>$render
		));
	}

	public function actionUpdateSales($id)
	{
		$model = $this->loadModel($id);
		$modelCif = new Cif;
		$modelClientinst = new Clientinst;
		$modelClientAutho = array();
		$modelClientBank = array();
		
		$success = false;
		
		if(isset($_POST['Client']))
		{
			$model->attributes = $_POST['Client'];
			$model->cancel_reason = $_POST['Client']['cancel_reason'];
			$model->copy_client = 0;
			$model->commission_per_buy /= 100;
			$model->commission_per_sell /= 100;
			$model->validate();
			
			/*$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$model->ip_address = $ip;
			
			$model->upd_by = Yii::app()->user->id;
			$model->upd_dt = Yii::app()->datetime->getDateTimeNow();*/
			
			$row = VClientSubrek14::model()->find("client_cd = '$model->client_cd'");
		
			if($row)
			{
				$model->subrek001 = $row->subrek001;
				
				$row2 = Vbrokersubrek::model()->find();
				
				$model->subrek004 = $row->subrek004;
				if(!$row->subrek004)$model->subrek004 = $row2->broker_004;
			}
			
			$modelCif = $this->loadModelCif($model->cifs);
			
			if($modelCif->act_first_dt)$modelCif->act_first_dt=DateTime::createFromFormat('d/m/Y',$modelCif->act_first_dt)->format('Y-m-d H:i:s');
			if($modelCif->act_last_dt)$modelCif->act_last_dt=DateTime::createFromFormat('d/m/Y',$modelCif->act_last_dt)->format('Y-m-d H:i:s');
			if($modelCif->skd_expiry)$modelCif->skd_expiry=DateTime::createFromFormat('d/m/Y',$modelCif->skd_expiry)->format('Y-m-d H:i:s');
			if($modelCif->autho_person_ic_expiry)$modelCif->autho_person_ic_expiry=DateTime::createFromFormat('d/m/Y',$modelCif->autho_person_ic_expiry)->format('Y-m-d H:i:s');
			if($modelCif->npwp_date)$modelCif->npwp_date=DateTime::createFromFormat('d/m/Y',$modelCif->npwp_date)->format('Y-m-d H:i:s');
			if($modelCif->siup_expiry_date)$modelCif->siup_expiry_date=DateTime::createFromFormat('d/m/Y',$modelCif->siup_expiry_date)->format('Y-m-d H:i:s');
			if($modelCif->tdp_expiry_date)$modelCif->tdp_expiry_date=DateTime::createFromFormat('d/m/Y',$modelCif->tdp_expiry_date)->format('Y-m-d H:i:s');
			if($modelCif->pma_expiry_date)$modelCif->pma_expiry_date=DateTime::createFromFormat('d/m/Y',$modelCif->pma_expiry_date)->format('Y-m-d H:i:s');
						
			$modelClientinst = $this->loadModelClientinst($model->cifs);
			
			$modelClientAutho = Clientautho::model()->findAll("cifs = '$model->cifs' AND approved_stat = 'A'");
			
			foreach($modelClientAutho as $row)
			{
				$row->old_seqno = $row->seqno;
			}
			
			$query = " SELECT a.bank_acct_num AS def_bank_acct_num, b.*
			FROM MST_CLIENT a, MST_CLIENT_BANK b
			WHERE a.cifs = b.cifs
			AND a.client_cd =  '$model->client_cd'
			AND b.approved_stat = 'A'";
			
			$modelTemp = DAO::queryAllSql($query);
			
			$x = 0;
			
			foreach($modelTemp as $row)
			{
				$modelClientBank[$x] = new Clientbank;
				
				foreach($modelClientBank[$x] as $key=>$value)
				{
					foreach($row as $key2=>$value2)
					{
						if(strtoupper(trim($key)) == strtoupper(trim($key2)))
						{
							$modelClientBank[$x]->setAttribute($key,$value2);
							unset($row[$key2]);
							break;
						}
					}
				}
				$modelClientBank[$x]->old_bank_acct_num = $modelClientBank[$x]->bank_acct_num;
				$modelClientBank[$x]->old_bank_cd = $modelClientBank[$x]->bank_cd;
				$modelClientBank[$x]->old_bank_branch = $modelClientBank[$x]->bank_branch;
				$modelClientBank[$x]->old_bank_phone_num = $modelClientBank[$x]->bank_phone_num;
				$modelClientBank[$x]->old_acct_name = $modelClientBank[$x]->acct_name;
				$modelClientBank[$x]->old_bank_acct_type = $modelClientBank[$x]->bank_acct_type;
				$modelClientBank[$x]->old_bank_acct_currency = $modelClientBank[$x]->bank_acct_currency;
								
				if($modelClientBank[$x]->bank_acct_num == $row['def_bank_acct_num'])$modelClientBank[$x]->default_flg = 'Y';
				else {
					$modelClientBank[$x]->default_flg = 'N';
				}
				
				$x++;
			}
			
			$connection  = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			
			if($model->executeSpHeader(AConstant::INBOX_STAT_UPD, 'INSTITUTIONAL CLIENT PROFILE ENTRY') > 0)$success = TRUE;
			
			if($success && $model->executeSp(AConstant::INBOX_STAT_UPD,$id,1) > 0)$success = TRUE;
			else {
				$success = FALSE;
			}	
			
			if($success && $modelCif->executeSp(AConstant::INBOX_STAT_UPD,$modelCif->cifs,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
			else {
				$success = FALSE;
			}
			
			if($success && $modelClientinst->executeSp(AConstant::INBOX_STAT_UPD,$modelClientinst->cifs,$model->update_date,$model->update_seq,1) > 0)$success = TRUE;
			else {
				$success = FALSE;
			}
			
			$recordSeq = 1;
			
			foreach($modelClientAutho as $row)
			{
				if($success && $row->executeSp(AConstant::INBOX_STAT_UPD,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq++) > 0)$success = true;
				else {
					$success = false;
				}
			}
			
			$recordSeq = 1;
			foreach($modelClientBank as $row)
			{
				if($success && $row->executeSp(AConstant::INBOX_STAT_UPD,$modelCif->cifs,$model->update_date,$model->update_seq,$recordSeq++) > 0)$success = true;
				else {
					$success = false;
				}
			}
			
			if($success)
			{
				$transaction->commit();
				Yii::app()->user->setFlash('success', 'Successfully update Client');
				$this->redirect(array('/master/clientcorp/index'));
			}
			else {
				$transaction->rollback();
			}
		}
		else
		{
			$model->old_branch_code = $model->branch_code = trim($model->branch_code);
			$model->old_rem_cd = $model->rem_cd;
			$model->cancel_reason = 'Edit ';
		}
		
		$this->render('updateSales',array(
			'model'=>$model,
			'modelClientinst'=>$modelClientinst,
			'modelCif'=>$modelCif,
			'modelClientAutho'=>$modelClientAutho,
			'modelClientBank'=>$modelClientBank,
		));
	}

	public function actionAjxPopModify($modifyReason)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model = new Client;
		
		$model->cancel_reason = $modifyReason;
		
		if(isset($_POST['Client']))
		{
			if($_POST['Client']['modify_reason'])
			{
				$model->cancel_reason = $_POST['Client']['modify_reason'];
				$is_successsave = true;
			}
			else {
				$model->cancel_reason = '';
				$model->addError('cancel_reason','Modify Reason must be filled');
			}
		}

		$this->render('_popmodify',array(
			'model'=>$model,
			'is_successsave'=>$is_successsave		
		));
	}

	public function actionIndex()
	{
		$model=new Client('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->susp_stat = '<>C';
		$model->client_type_1 = "'C','H'";

		if(isset($_GET['Client']))
			$model->attributes=$_GET['Client'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Client::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModelCif($id)
	{
		$model=Cif::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModelClientinst($id)
	{
		$model=Clientinst::model()->findByPk($id);
		if($model===null)
			$model = new Clientinst;
		return $model;
	}
	
	public function loadModelClientEmergency($id)
	{
		$model=Clientemergency::model()->find("Cifs = '$id'");
		if($model===null)$model = new Clientemergency;
		return $model;
	}
}
