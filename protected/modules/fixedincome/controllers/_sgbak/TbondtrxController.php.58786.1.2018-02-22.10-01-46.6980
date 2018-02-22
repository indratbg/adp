<?php

class TbondtrxController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';
	
	public function actionAjxFilterCounterpart(){
		$lawantypeval = $_POST['lawantypeval'];
		$resp['status'] = 'error';
		$lawan[] = array();
		$lawanname[] = array();
		
		if(!empty($lawantypeval)){
			$modelLawan = LawanBondTrx::model()->findAll(array('select'=>'lawan, lawan_name','condition'=>'approved_sts = \'A\' AND is_active = \'Y\' AND lawan_type = \''.$lawantypeval.'\'','order'=>'lawan'));
			foreach($modelLawan as $listLawan){
				$lawan[] = $listLawan->lawan;
				$lawanname[] = $listLawan->lawan_name;
			}
			$resp['status'] = 'success';
		}
		$resp['content'] = array('lawan'=>$lawan,'lawan_name'=>$lawanname);
		echo json_encode($resp);
	}
	
	public function actionAjxPurchaseBond(){
		$trid = $_POST['trxidval'];
		$trtype = $_POST['trxtypeval'];
		
		$trxdate[] = array();
		$trxid[] = array();
		$bondcd[] = array();
		$law[] = array();
		$sisatemp[] = array();
		$sisanominal[] = array();
		$pri[] = array();
		$valuedt[] = array();
		$trxseqno[] = array();
		$trxtype[] = array();
		$trxref[] = array();

		$resp['status'] = 'error';
		
		if(!empty($trid)){
			$modelValue = DAO::queryRowSql("SELECT bond_cd, to_char(trx_date,'YYYY-MM-DD') trx_date, to_char(value_dt,'YYYY-MM-DD') value_dt, trx_id_yymm FROM T_BOND_TRX WHERE trx_id = $trid
							AND (trx_date between TRUNC(SYSDATE,'MM')-5 AND TRUNC(SYSDATE)+5) AND approved_sts = 'A' order by trx_date desc");
			//$modelValue = DAO::queryRowSql("SELECT bond_cd, to_char(trx_date,'YYYY-MM-DD') trx_date, to_char(value_dt,'YYYY-MM-DD') value_dt, trx_id_yymm FROM T_BOND_TRX WHERE trx_id = $trid
			//				AND to_char(trx_date,'YYYY-MM-DD') = '2014-06-12' AND approved_sts = 'A'");
			$resp['status'] = 'success';
			//var_dump($modelValue);
			//die();
			if($modelValue){
				$resp['isfound'] = 'Y';
				$modelCoupon = new Tbondtrx;
				if(isset($modelValue['trx_date'])){
					$resp['trxdate'] = DateTime::createFromFormat('Y-m-d',$modelValue['trx_date'])->format('d/m/Y');
				} else {
					$resp['trxdate'] = '';
				}
				if(isset($modelValue['value_dt'])){
					$resp['valuedt'] = DateTime::createFromFormat('Y-m-d',$modelValue['value_dt'])->format('d/m/Y');
					$modelCoupon->value_dt = $modelValue['value_dt'];
				} else {
					$resp['valuedt'] = '';
				}
				if(isset($modelValue['trx_id_yymm'])){
					$resp['trxidyymm'] = $modelValue['trx_id_yymm'];
				}else{
					$resp['trxidyymm'] = date('Ym').str_pad($trid,3," ", STR_PAD_LEFT);
				}
				if(isset($modelValue['bond_cd'])){
					$resp['bondcd'] = $modelValue['bond_cd'];
					$modelCoupon->bond_cd = $modelValue['bond_cd'];
					$modelBond = DAO::queryRowSql("SELECT to_char(maturity_date,'YYYY-MM-DD') maturity_date FROM MST_BOND WHERE bond_cd = '".$modelValue['bond_cd']."'");
					$resp['maturitydate'] = $modelBond['maturity_date']?DateTime::createFromFormat('Y-m-d',$modelBond['maturity_date'])->format('d/m/Y') : '';
					
				}else{
					$resp['bondcd'] = '';
					$resp['maturitydate'] = '';
				}
				$modelCoupon->user_id = Yii::app()->user->id;
				
				$modelCoupon->executeSpGetCouponDate();
				
				//var_dump($modelCoupon->gen_last_coupon);
				//die();
				$resp['lastcoupon'] = $modelCoupon->gen_last_coupon?DateTime::createFromFormat('Y-m-d h:i:s',$modelCoupon->gen_last_coupon)->format('d/m/Y') : '';
				$resp['nextcoupon'] = $modelCoupon->gen_next_coupon?DateTime::createFromFormat('Y-m-d h:i:s',$modelCoupon->gen_next_coupon)->format('d/m/Y') : '';
				$resp['interestrate'] = $modelCoupon->gen_interest_rate;
				
				if($trtype == 'S'){
					
					$listSellBond = Voutsbuybond::model()->findAll("trx_date BETWEEN (TO_DATE('".$modelValue['trx_date']."','YYYY-MM-DD')-20) AND (TO_DATE('".$modelValue['trx_date']."','YYYY-MM-DD'))
									 AND bond_cd = '".$modelValue['bond_cd']."' AND jual > 0");
					if(isset($listSellBond)){
						foreach($listSellBond as $alist){
							$trxdate[] = DateTime::createFromFormat('Y-m-d',$alist->trx_date)->format('d/m/Y');
							$trxid[] = $alist->trx_id;
							$bondcd[] = $alist->bond_cd;
							$law[] = $alist->lawan;
							$sisatemp[] = number_format($alist->jual,0);
							$sisanominal[] = number_format($alist->sisa_nominal,0);
							$pri[] = $alist->price;
							$valuedt[] = DateTime::createFromFormat('Y-m-d',$alist->value_dt)->format('d/m/Y');
							$trxseqno[] = $alist->trx_seq_no;
							$trxtype[] = $alist->trx_type;
							if($alist->trx_ref){
								$trxref[] = $alist->trx_ref;
							} else{
								$trxref[] = '';
							}
						}
					}
					$resp['content_sell'] = array('trx_date'=>$trxdate,'trx_id'=>$trxid,'bond_cd'=>$bondcd,'lawan'=>$law,'sisa_temp'=>$sisatemp,
										'sisa_nominal'=>$sisanominal,'price'=>$pri,'value_dt'=>$valuedt,'trx_seq_no'=>$trxseqno,'trx_type'=>$trxtype,
										'trx_ref'=>$trxref);
				}		
			}else{
				$resp['trxidyymm'] = date('Ym').str_pad($trid,3," ", STR_PAD_LEFT);
				$resp['content_sell'] = null;
				$resp['isfound'] = 'N';
			}
			
		}
		echo json_encode($resp);
		
	}

	public function actionAjxBond(){
		$bondval = $_POST['bondcdval'];
		$trxdtval = $_POST['trxdateval'];
		$trxtypeval = $_POST['typeval'];
		$valuedtval = $_POST['valuedtval'];
		$resp['status'] = 'error';
		$maturitydate = '';
		$periodfrom = '';
		$periodto = '';
		$intrate = '';
		
		$trxdate[] = array();
		$trxid[] = array();
		$bondcd[] = array();
		$law[] = array();
		$sisatemp[] = array();
		$sisanominal[] = array();
		$pri[] = array();
		$valuedt[] = array();
		$trxseqno[] = array();
		$trxtype[] = array();
		$trxref[] = array();
		
		$trxdtval = DateTime::createFromFormat('d/m/Y',$trxdtval)->format('Y-m-d');
		
		if(!empty($bondval)){
			$modelCoupon = new Tbondtrx;
			$modelCoupon->value_dt = DateTime::createFromFormat('d/m/Y',$valuedtval)->format('Y-m-d');
			$modelCoupon->bond_cd = $bondval;
			$modelCoupon->user_id = Yii::app()->user->id;
			$modelCoupon->executeSpGetCouponDate();
			//var_dump($modelCoupon->gen_last_coupon);
			//die();
			
			$modelBond = DAO::queryRowSql("SELECT to_char(maturity_date,'YYYY-MM-DD') maturity_date FROM MST_BOND WHERE bond_cd = '".$bondval."'");
			
			$maturitydate = $modelBond['maturity_date']?DateTime::createFromFormat('Y-m-d',$modelBond['maturity_date'])->format('d/m/Y') : '';
			$periodfrom = $modelCoupon->gen_last_coupon?DateTime::createFromFormat('Y-m-d h:i:s',$modelCoupon->gen_last_coupon)->format('d/m/Y') : '';
			$periodto = $modelCoupon->gen_next_coupon?DateTime::createFromFormat('Y-m-d h:i:s',$modelCoupon->gen_next_coupon)->format('d/m/Y') : '';
			$intrate = $modelCoupon->gen_interest_rate;
			$resp['status'] = 'success';
			
			if($trxtypeval == 'S'){
				$listSellBond = Voutsbuybond::model()->findAll(array('condition'=>"trx_date BETWEEN (TO_DATE('$trxdtval','YYYY-MM-DD')-20) AND (TO_DATE('$trxdtval','YYYY-MM-DD')) 
							AND bond_cd = '$bondval' AND jual > 0"));
				if(isset($listSellBond)){
					foreach($listSellBond as $alist){
						$trxdate[] = DateTime::createFromFormat('Y-m-d',$alist->trx_date)->format('d/m/Y');
						$trxid[] = $alist->trx_id;
						$bondcd[] = $alist->bond_cd;
						$law[] = $alist->lawan;
						$sisatemp[] = number_format($alist->jual,0);
						$sisanominal[] = number_format($alist->sisa_nominal,0);
						$pri[] = $alist->price;
						$valuedt[] = DateTime::createFromFormat('Y-m-d',$alist->value_dt)->format('d/m/Y');
						$trxseqno[] = $alist->trx_seq_no;
						$trxtype[] = $alist->trx_type;
						if($alist->trx_ref){
							$trxref[] = $alist->trx_ref;
						} else{
							$trxref[] = '';
						}
					}
				}
			}
		}
		$resp['content'] = array('maturity_date'=>$maturitydate,'period_from'=>$periodfrom,'period_to'=>$periodto,'int_rate'=>$intrate);
		$resp['content_sell'] = array('trx_date'=>$trxdate,'trx_id'=>$trxid,'bond_cd'=>$bondcd,'lawan'=>$law,'sisa_temp'=>$sisatemp,
									'sisa_nominal'=>$sisanominal,'price'=>$pri,'value_dt'=>$valuedt,'trx_seq_no'=>$trxseqno,'trx_type'=>$trxtype,
									'trx_ref'=>$trxref);
		echo json_encode($resp);
		
	}

	public function actionAjxTaxpcn(){
		$lawanval = $_POST['lawanval'];
		$lawantypeval = $_POST['lawantypeval'];
		$trxdateval = $_POST['trxdateval'];
		$trxidval = $_POST['trxidval'];
		$accruedtaxpcn = '';
		$capitaltaxpcn = '';
		$participant = '';
		$resp['buyprice'] = null;
		
		if(!empty($lawanval) && !empty($lawantypeval)){
			$modelTax = LawanBondTrx::model()->find(array('select'=>'capital_tax_pcn, participant','condition'=>"lawan = '$lawanval'"));
			
			if($modelTax){
				$accruedtaxpcn = $modelTax->capital_tax_pcn * 100;
				$capitaltaxpcn = $modelTax->capital_tax_pcn * 100;
				$participant = $modelTax->participant;
			}
			
			if($lawantypeval == 'I'){
				$modelprice = Tbondtrx::model()->find(array('condition'=>"lawan = '$lawanval' AND TO_CHAR(trx_date,'DD/MM/YYYY') = '$trxdateval' AND
						trx_id = '$trxidval' and trx_type = 'S'",'order'=>'trx_seq_no desc'));
				
				if($modelprice){
					$buyprice = $modelprice->price;
					$resp['buyprice'] = $buyprice;
				}
			}
			
			$resp['status'] = 'success';
		}
		$resp['content'] = array('accruedtaxpcn'=>$accruedtaxpcn,'capitaltaxpcn'=>$capitaltaxpcn,'participant'=>$participant);
		echo json_encode($resp);
		
	}
	
	public function actionAjxCalcBond(){
		$model=new Tbondtrx;
		$resp['status']='error';
		if(isset($_POST['Tbondtrx'])){
			$model->attributes=$_POST['Tbondtrx'];
			$model->validate();
			$model->executeSpCalcBond();
			//var_dump($model->error_msg);
			//die();
        	$pcost = number_format($model->pocost,0);
			$paccrueddays = number_format($model->poaccrued_days,0);
			$pcalcint = number_format($model->pocalc_accrued_int,0);
			$paccruedint = number_format($model->poaccrued_int,0);
			$paccruedtaxdays = number_format($model->poaccrued_tax_days,0);
			$pcalcinttax = number_format($model->pocalc_interest,0);
			$paccruedinttax = number_format($model->poaccrued_int_tax,0);
			$pcapitalgain = number_format($model->pocapital_gain,0);
			$pcapitaltax = number_format($model->pocapital_tax,0);
			$pnetcapitalgain = number_format($model->ponet_capital_gain,0);
			$pnetamount = number_format($model->ponet_amount,0);
			$perrorcode = $model->error_code;
			$perrormsg = $model->error_msg;
			$resp['status'] = 'success';
		}
		$resp['content'] = array('cost'=>$pcost,'accrued_days'=>$paccrueddays,'calc_int'=>$pcalcint,'accrued_int'=>$paccruedint,'accrued_tax_days'=>$paccruedtaxdays,
								 'calc_int_tax'=>$pcalcinttax,'accrued_int_tax'=>$paccruedinttax,'capital_gain'=>$pcapitalgain,'capital_tax'=>$pcapitaltax,
								 'net_capital_gain'=>$pnetcapitalgain,'net_amount'=>$pnetamount,'error_code'=>$perrorcode,'error_msg'=>$perrormsg);
		echo json_encode($resp);
	}
	
	public function actionView($trx_date, $trx_seq_no)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($trx_date, $trx_seq_no),
		));
	}

	public function actionCreate()
	{
		$model = new Tbondtrx;
		$valid = true;
		$n = 0;
		$model1 = array();
		$modelprice = array();
		if(isset($_POST['checkedbond']) && !empty($_POST['checkedbond'])){
			$checkedbondval = $_POST['checkedbond'];
			$compositepk = array();
			$compositepk = explode(' ', $checkedbondval);
			$checkeddate = array();
			$checkedtrxdate = array();
			$checkedtrxseqno = array();
			$checkedsisaval = array();
			$checkedsisaval = explode(' ', $_POST['checkedsisa']);
			$checkedsisa = array();
			foreach($compositepk as $compk){
				$checkeddate[] = substr($compk,0,strpos($compk,'-'));
				$checkedtrxseqno[] = substr($compk,strpos($compk,'-')+1,strpos($compk,'#')-(strpos($compk,'-')+1));
				$n++;
			}
			//var_dump($checkedtrxseqno);
			//die();
			foreach($checkedsisaval as $chsisa){
				$checkedsisa[] = $chsisa;
			}
			foreach($checkeddate as $chdate){
				$checkedtrxdate[] = DateTime::createFromFormat('d/m/Y',$chdate)->format('Y-m-d');
			}
			for($x=0;$x<$n;$x++){
				$model1[$x+1] = $this->loadModel($checkedtrxdate[$x], $checkedtrxseqno[$x]);
				$model1[$x+1]->sisa_temp = $checkedsisa[$x];
				if(empty($model1[$x+1]->calc_accrued_int)) $model1[$x+1]->calc_accrued_int = 0;
				$valid = $model1[$x+1]->validate() && $valid;
				//$model1[$x]->sisa_nominal = $model1[$x]->sisa_nominal - $model1[$x]->sisa_temp;
				//$model1[$x]->sisa_temp = $model1[$x]->sisa_nominal - $model1[$x]->sisa_temp;
				$valid = $model1[$x+1]->validate() && $valid;
			}
			//var_dump($model1[0]->sisa_nominal);
			//die();
		}
		//var_dump($_POST['Multiprice']);
		//die();
		if(isset($_POST['Tbondtrx'])){
			$model->attributes=$_POST['Tbondtrx'];
			if($model->trx_type == 'S' && (!isset($_POST['checkedbond']) || empty($_POST['checkedbond']))){
				$valid = false;
				$model->addError('','Sell transaction type requires at least one outstanding buy to be checked!');
			}
			if($model->trx_type == 'S' && $model->buy_price <= 0){
				$valid = false;
				$model->addError('buy_price','Sell transaction must have purchase price!');
			}
			if($model->multi_buy_price == 'Y'){
				$model->multi_buy_price = 'Y';
			}else{
				$model->multi_buy_price = 'N';
			}
			$valid = $valid && $model->validate();
		}else{
			$valid = false;
			$model->custodian_cd = 'BCA01';
			$model->ctp_trx_type = 'O';
			$model->maturity_date = null;
			$model->last_coupon = null;
			$model->next_coupon = null;
		}
		$totalmultinominal = 0;
		if($valid && (isset($_POST['Tbondtrx']['multi_buy_price']))){
			if($_POST['Tbondtrx']['multi_buy_price'] == 'Y'){
				$r = 0;
				
				foreach($_POST['Multiprice'] as $row){
					$modelprice[$r] = new Tbondtrx;
					$modelprice[$r]->trx_date = $model->trx_date;
					$modelprice[$r]->seller_buy_dt = $row['sellerbuydt'];
					$modelprice[$r]->buy_price = $row['buyprice'];
					$modelprice[$r]->nominal = $row['nominal'];
					$valid = $valid && $modelprice[$r]->validate(array('trx_date','seller_buy_dt','buy_price','nominal'));
					$totalmultinominal += $modelprice[$r]->nominal;
					$r++;
				}
				
				if($model->nominal <> $totalmultinominal){
					$valid = false;
					$model->addError('nominal','Total nominal tidak sesuai!');
				}
			}
			
		}
		
		if($valid){
			$success = false;
			$transaction;
			$menuName = 'BOND TRANSACTION';
			if(isset($_POST['editcalc'])){
				if($_POST['editcalc'] == 'Y'){
					$model->cancel_reason = 'Manual Calculation';
				}
			}
			
			$model->user_id = Yii::app()->user->id;
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$model->ip_address = $ip;
			if($model->executeSpManyHeader(AConstant::INBOX_STAT_INS,$menuName,$transaction) > 0)
				$success = true;
			
			if(isset($_POST['Tbondtrx']))
			{
				$model->sisa_temp = $model->nominal;
				$model->sisa_nominal = $model->nominal;
				$model->int_rate = $model->int_rate / 100;
				$model->accrued_tax_pcn = $model->accrued_tax_pcn /100;
				$model->capital_tax_pcn = $model->capital_tax_pcn /100;
				$model->buy_trx_seq = $model->trx_type == 'S'?$model1[1]->buy_trx_seq : '';
				if($success && $model->executeSpBondTrxUpd(AConstant::INBOX_STAT_INS,$model->trx_date, $model->trx_seq_no,1,$transaction) > 0){
	            	$success = true;
	            }else{
	            	$success = false;
	            }
				if($model->nominal <= 0){
					$success = false;
					$model->addError('nominal', 'Nominal must be greater than 0.');
				}
				if($model->net_amount <= 0){
					$success = false;
					$model->addError('net_amount', 'Net amount must be greater than 0.');
				}
			}else{
				$success = false;
				$model->custodian_cd = 'BCA01';
				$model->ctp_trx_type = 'O';
			}
			if($model->multi_buy_price == 'Y' && $success){
				$z = 1;
				foreach($modelprice as $row){
					$row->user_id = Yii::app()->user->id;
					$row->ip_address = $ip;
					$row->update_seq = $model->update_seq;
					$row->update_date = $model->update_date;
					//var_dump($row->buy_price);
					//die();
					if($success && $row->executeSpBondTrxMultiprice(AConstant::INBOX_STAT_INS,$z,$transaction) > 0){
		            	$success = true;
		            }else{
		            	$success = false;
		            }
					$z++;
				}
			}
			
			if(isset($_POST['checkedbond'])){
				
				for($x=1;$success && $x<=$n;$x++){
					$model1[$x]->update_date = $model->update_date;
					$model1[$x]->update_seq = $model->update_seq;
					if($success && $model1[$x]->executeSpBondTrxUpd('X',$model->trx_date,NULL,$x+1,$transaction) > 0){
						$success = true;
					}else {
						$success = false;
					}
				}
			}	
			
			if($success){
				$transaction->commit();
				Yii::app()->user->setFlash('success', 'Successfully create bond '.$model->trx_date);
				$this->redirect(array('/fixedincome/tbondtrx/index'));
			}
		}		
		
		$this->render('create',array(
			'model'=>$model,
			'model1'=>$model1,
			'sellcount'=>$n,
			'modelprice'=>$modelprice
		));
	}

	public function actionUpdate($trx_date, $trx_seq_no)
	{
		$model=$this->loadModel($trx_date, $trx_seq_no);
		$model->int_rate = $model->int_rate * 100;
		$model->accrued_tax_pcn = $model->accrued_tax_pcn * 100;
		$model->capital_tax_pcn = $model->capital_tax_pcn * 100;
		$modelBondBuy = null;
		$modelOutsDone = null;
		$modelSell = null;
		//$model->executeSpCalcBond();
		//$model->calc_accrued_int = $model->pocalc_accrued_int?$model->pocalc_accrued_int : 0;
		//$model->calc_interest = $model->pocalc_interest?$model->pocalc_interest : 0;
		$model->calc_accrued_int = $model->accrued_int;
		$model->calc_interest = 0;
		$listSellBond = Voutsbuybond::model()->findAll(array('condition'=>"trx_date BETWEEN (TO_DATE('$model->trx_date','YYYY-MM-DD')-20) AND (TO_DATE('$model->trx_date','YYYY-MM-DD')) 
							AND bond_cd = '$model->bond_cd'"));
		$modelMultiprice = Tbondbuytrx::model()->findAll(array('condition'=>"trx_date = TO_DATE('$model->trx_date','YYYY-MM-DD') AND trx_seq_no = $model->trx_seq_no AND multi_buy_price = 'Y' AND approved_sts = 'A'"));
		$n = 0;
		$r = 0;
		if($model->trx_type == 'S'){
			$modelBondBuy = Tbondbuytrx::model()->findAll("trx_date = '$trx_date' AND trx_seq_no = '$trx_seq_no' AND approved_sts = 'A'");
			$modelOutsDone = array();
			//var_dump($modelBondBuy[0]->buy_trx_seq);
			//die();
			if($modelBondBuy){
				foreach ($modelBondBuy as $buy){
					$modelOutsDone[] = Tbondtrx::model()->find("to_char(buy_dt,'YYYY-MM-DD') = '$buy->buy_dt' AND buy_trx_seq = '$buy->buy_trx_seq' AND approved_sts = 'A' AND trx_type = 'B'");
					//$modelOutsDone[]->seqno = $buy->seqno;
					$r++;
				}
				$s = 0;
				foreach($modelOutsDone as $m){
					$m->seqno = $modelBondBuy[$s]->seqno;
					$s++; 
				}
				
				$modelSell = Tbondtrx::model()->findAll(array('condition'=>"trx_date BETWEEN (TO_DATE('$trx_date','YYYY-MM-DD')-20) AND (TO_DATE('$trx_date','YYYY-MM-DD')) 
							AND bond_cd = '$model->bond_cd' AND trx_type = 'B' AND sisa_temp > 0 AND approved_sts <> 'C' AND 
							buy_trx_seq NOT IN (SELECT buy_trx_seq FROM T_BOND_BUY_TRX WHERE buy_dt = (TO_DATE('$model->buy_dt','YYYY-MM-DD')))"));
				/*
				 $modelSell = Voutsbuybond::model()->findAll(array('condition'=>"trx_date BETWEEN (TO_DATE('$model->trx_date','YYYY-MM-DD')-20) AND (TO_DATE('$model->trx_date','YYYY-MM-DD')) 
								AND bond_cd = '$model->bond_cd'"));
				 * 
				 */
			}
			//var_dump($modelOutsDone[0]->seqno);
			//die();
			
		}
		//var_dump($modelOutsDone[1]->trx_date);
		//die();
		
		$modelBond = DAO::queryRowSql("SELECT to_char(maturity_date,'YYYY-MM-DD') maturity_date FROM MST_BOND WHERE bond_cd = '".$model->bond_cd."'");
		$model->maturity_date = $modelBond['maturity_date']?DateTime::createFromFormat('Y-m-d',$modelBond['maturity_date'])->format('d/m/Y') : '';
		$valid = true;
		
		$model1 = array();
		$sold = ($model->nominal) - ($model->sisa_temp);
		if(isset($_POST['checkedbond']) && !empty($_POST['checkedbond'])){
			$checkedbondval = $_POST['checkedbond'];
			$compositepk = array();
			$compositepk = explode(' ', $checkedbondval);
			$checkeddate = array();
			$checkedtrxdate = array();
			$checkedtrxseqno = array();
			$checkedsisaval = array();
			$checkedsisaval = explode(' ', $_POST['checkedsisa']);
			$checkedsisa = array();
			foreach($compositepk as $compk){
				$checkeddate[] = substr($compk,0,strpos($compk,'-'));
				$checkedtrxseqno[] = substr($compk,strpos($compk,'-')+1,strpos($compk,'#')-(strpos($compk,'-')+1));
				$n++;
			}
			//var_dump($checkedtrxseqno);
			//die();
			foreach($checkedsisaval as $chsisa){
				$checkedsisa[] = $chsisa;
			}
			foreach($checkeddate as $chdate){
				$checkedtrxdate[] = DateTime::createFromFormat('d/m/Y',$chdate)->format('Y-m-d');
			}
			for($x=0;$x<$n;$x++){
				$model1[$x] = $this->loadModel($checkedtrxdate[$x], $checkedtrxseqno[$x]);
				$model1[$x]->sisa_temp = $checkedsisa[$x];
				if(empty($model1[$x]->calc_accrued_int)) $model1[$x]->calc_accrued_int = 0;
				$valid = $model1[$x]->validate() && $valid;
			}
		}
		if(isset($_POST['Tbondtrx'])){
			$model->attributes=$_POST['Tbondtrx'];
			if($model->trx_type == 'S' && (!isset($model->buy_trx_seq) || empty($model->buy_trx_seq)) && (!isset($_POST['checkedbond']) || empty($_POST['checkedbond']))){
				$valid = false;
				$model->addError('','Sell transaction type requires at least one outstanding buy to be checked!');
			}
			if($model->trx_type == 'S' && $model->buy_price <= 0){
				$valid = false;
				$model->addError('buy_price','Sell transaction must have purchase price!');
			}
			
			if($model->multi_buy_price == 'Y'){
				$model->multi_buy_price = 'Y';
			}else{
				$model->multi_buy_price = 'N';
			}
			
			/*
			if($model->trx_type == 'B'){
				if($model->nominal < $sold){
					//$valid = false;
					//$model->addError('nominal','Nominal tidak boleh kurang dari jumlah yang sudah terjual ('.number_format($sold,0).') !');
				}
				$model->sisa_temp = $model->nominal;
				$model->sisa_nominal = $model->nominal;
				//var_dump($sold);
				//die();
			}*/
		
			if($valid){
				$success = false;
				$transaction;
				$menuName = 'BOND TRANSACTION';
				
				$model->user_id = Yii::app()->user->id;
				$ip = Yii::app()->request->userHostAddress;
				if($ip=="::1")
					$ip = '127.0.0.1';
				$model->ip_address = $ip;
				if($model->executeSpManyHeader(AConstant::INBOX_STAT_UPD,$menuName,$transaction) > 0)
					$success = true;
				
				$success = $success && $model->validate();
				$model->int_rate = $model->int_rate / 100;
				$model->accrued_tax_pcn = $model->accrued_tax_pcn / 100;
				$model->capital_tax_pcn = $model->capital_tax_pcn / 100;
				if($success && $model->executeSpBondTrxUpd(AConstant::INBOX_STAT_UPD,$trx_date,$trx_seq_no,1,$transaction) > 0){
	            	$success = true;
	            }else{
	            	$success = false;
	            }
				//var_dump($model->int_rate);
				//die();
				
				if(isset($_POST['checkedbond'])){
					$z = 2;
					
					for($y=0; $success && $y<$r; $y++){
						$modelOutsDone[$y]->update_date = $model->update_date;
						$modelOutsDone[$y]->update_seq = $model->update_seq;
						if($success && $modelOutsDone[$y]->executeSpBondTrxUpd('Z',$trx_date, $trx_seq_no,$z,$transaction) > 0){
							$success = true;
							//var_dump($modelOutsDone[$y]->seqno);
							//die();
						}else{
							$success = false;
						}
						$z++;
					}
					
					for($x=0;$success && $x<$n;$x++){
						//$model->buy_trx_seq = $model->buy_trx_seq?$model1[$x]->buy_trx_seq : $model->buy_trx_seq;
						$model1[$x]->update_date = $model->update_date;
						$model1[$x]->update_seq = $model->update_seq;
						if($success && $model1[$x]->executeSpBondTrxUpd('X',$trx_date,$trx_seq_no,$z,$transaction) > 0){
							$success = true;
						}else {
							$success = false;
						}
						$z++;
					}
				}
				//var_dump($model->error_code);
				//die();
				
				if($success){
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully update bond '.$model->trx_date);
					$this->redirect(array('/fixedincome/tbondtrx/index'));
				}else{
					$model->int_rate = $model->int_rate * 100;
					$model->accrued_tax_pcn = $model->accrued_tax_pcn * 100;
					$model->capital_tax_pcn = $model->capital_tax_pcn * 100;
				}
			}	
		}

		$this->render('update',array(
			'model'=>$model,
			'model1'=>$model1,
			'modeloutsdone'=>$modelOutsDone,
			'modelbondbuy'=>$modelBondBuy,
			'modelsell'=>$modelSell,
			'sellcount'=>$n,
			'modelmultiprice'=>$modelMultiprice
		));
	}
	
	public function actionAjxPopDelete($trx_date, $trx_seq_no)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		$currdate = date('Y-m-d');
		$model1 = NULL;
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		
		if(isset($_POST['Tmanyheader']))
		{
			$transaction;
			$success = false;
			$model->attributes = $_POST['Tmanyheader'];
			$model->user_id = Yii::app()->user->id;
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$model->ip_address = $ip;
					
			if($model->validate()){
				
				$model1    				= $this->loadModel($trx_date, $trx_seq_no);
				$model1->cancel_reason  = $model->cancel_reason;
				$menuName = 'BOND TRANSACTION';
				
				if(!$model1->doc_num){
					$model1->user_id = Yii::app()->user->id;
					$ip = Yii::app()->request->userHostAddress;
					if($ip=="::1")
						$ip = '127.0.0.1';
					$model1->ip_address = $ip;
					if($model1->executeSpManyHeader(AConstant::INBOX_STAT_CAN,$menuName,$transaction) > 0)
						$success = true;
					if($success && $model1->executeSpBondTrxUpd(AConstant::INBOX_STAT_CAN,$trx_date, $trx_seq_no,1,$transaction) > 0)
						$success = true;
					else $success = false;
					
					if($success){
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Successfully cancel bond transaction');
						$is_successsave = true;
					}	
				}else{
					$model1->addError('trx_date',"Bond sudah dijournal");
				}
				
			}
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$model1,
			'is_successsave'=>$is_successsave		
		));
	}

	public function actionIndex()
	{
		$model=new Tbondtrx('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tbondtrx']))
			$model->attributes=$_GET['Tbondtrx'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($trx_date, $trx_seq_no)
	{
		$model=Tbondtrx::model()->findByPk(array('trx_date'=>$trx_date,'trx_seq_no'=>$trx_seq_no));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
