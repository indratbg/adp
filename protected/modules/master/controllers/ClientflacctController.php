<?php

class ClientflacctController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionView($client_cd,$bank_acct_num)
	{
		if($client_cd || !empty($client_cd)){
			$pos = strrpos($client_cd,' - ');
			if($pos){
				$trimmedclientcd = substr($client_cd,0,$pos);
				$client_cd = $trimmedclientcd;
			}
		}
		$this->render('view',array(
			'model'=>$this->loadModel($client_cd,$bank_acct_num),
		));
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
      	$src[$i++] = array('label'=>$search['client_cd'].' - '.$search['client_name']
      			, 'labelhtml'=>$search['client_cd'].' - '.$search['client_name'] //WT: Display di auto completenya
      			, 'value'=>$search['client_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }

	public function actionCreate()
	{
		$model=new Clientflacct;
		$sql = "SELECT acct_mask FROM MST_FUND_BANK ORDER BY bank_cd";
		$res = DAO::queryRowSql($sql);
		$model->account_format = str_replace("#","9",$res['acct_mask']);
		$errflg = 0;
		$firstdterrflg = 1;
		$secdterrflg = 1;
		
		
		
		
		if($model->client_cd || !empty($model->client_cd)){
			$pos = strrpos($model->client_cd,' - ');
			if($pos){
				$trimmedclientcd = substr($model->client_cd,0,$pos);
				//var_dump($trimmedclientcd);
				//die();
				$model->client_cd = $trimmedclientcd;
			}
			
			$qclientname = Client::model()->find("client_cd = '$model->client_cd'");
			//var_dump($model->client_cd);
			//die();
			$clientname = $qclientname->client_name;
			$model->client_cd = $model->client_cd.' - '.$clientname;
		}
		
		if(isset($_POST['Clientflacct']))
		{
			/*
			if($_POST['Clientflacct']['from_dt']){
			
				$fromdtval = $_POST['Clientflacct']['from_dt'];			
				
				if(strtotime(DateTime::createFromFormat('d/m/Y H:i',$fromdtval)->format('Y-m-d H:i'))){
					$firstdterrflg = 0;
					$errflg = 0;
				}else{
					$firstdterrflg = 1;
					$errflg = 1;
				}
			}
			
			if($_POST['Clientflacct']['to_dt']){
				
				if($_POST['Clientflacct']['acct_stat'] == 'C'){
					$todtval = date('d/m/Y 12:00');
				}else{
					$todtval = $_POST['Clientflacct']['to_dt'];
				}
					
				if($errflg == 0 && strtotime(DateTime::createFromFormat('d/m/Y H:i',$todtval)->format('Y-m-d H:i'))){
					$secdterrflg = 0;
					$errflg = 0;
				}else if($errflg == 1 && strtotime(DateTime::createFromFormat('d/m/Y H:i',$todtval)->format('Y-m-d H:i'))){
					$secdterrflg = 0;
					$errflg = 1;
				}else{
					$secdterrflg = 1;
					$errflg = 1;
				}
			}
			*/
			
			
			$model->attributes=$_POST['Clientflacct'];
			
		//	if($_POST['Clientflacct']['acct_stat'] == 'C'){
			//	$model->to_dt = date('Y-m-d 00:00:00');
			//}
			//$model->to_dt = $todtval;
			//var_dump($model->bank_short_name);
			//die();
			$sql = "SELECT acct_mask FROM MST_FUND_BANK where bank_cd = '$model->bank_cd'";
			$res = DAO::queryRowSql($sql);
			$model->account_format = str_replace("#","9",$res['acct_mask']);
			
			if($model->client_cd || !empty($model->client_cd)){
				$pos = strrpos($model->client_cd,' - ');
				
				if($pos){
					$trimmedclientcd = substr($model->client_cd,0,$pos);
					//var_dump($trimmedclientcd);
					//die();
					$model->client_cd = $trimmedclientcd;
				}
				//var_dump($model->client_cd);
				//die();
			}
			
			if($_POST['flag']=='TRUE'){
				
				
			
				//if($errflg == 0){
					if($model->validate()){
						if($model->executeSp(AConstant::INBOX_STAT_INS,$model->client_cd,$model->bank_acct_num)>0){
			            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->client_cd);
							
							$this->redirect(array('/master/clientflacct/index'));
						}
		            }
				/*
				}else{
					if($firstdterrflg == 1)
						$model->addError('from_dt','Invalid From Date');
					if($secdterrflg == 1)
						$model->addError('to_dt','Invalid To Date');
				}
				 */
			}//end if $_POST
		}else{
			$model->to_dt = '2030-12-30';
			$model->from_dt = date('Y-m-d');
		}
		
		$qMask = DAO::queryAllSql("SELECT bank_cd, bank_name, acct_mask FROM MST_FUND_BANK ORDER BY bank_cd");
		$masks = array();
		
		foreach($qMask as $mask){
			$rawmask = $mask['acct_mask'];
			if($mask['acct_mask'])
			$mask['acct_mask'] = str_replace("#","9",$rawmask);
			$masks[] = $mask;
		}
		//var_dump($gg);
		//die();
		
		if(empty($model->account_format))
			$model->is_format_null = TRUE;
		else 
			$model->is_format_null = FALSE;
		
		if($model->client_cd || !empty($model->client_cd)){
			$pos = strrpos($model->client_cd,' - ');
			if($pos){
				$trimmedclientcd = substr($model->client_cd,0,$pos);
				//var_dump($trimmedclientcd);
				//die();
				$model->client_cd = $trimmedclientcd;
			}
			
			$qclientname = Client::model()->find("client_cd = '$model->client_cd'");
			//var_dump($model->client_cd);
			//die();
			$clientname = $qclientname->client_name;
			$model->client_cd = $model->client_cd.' - '.$clientname;
		}
		
		$this->render('create',array(
			'model'=>$model,
			'listMask'=>$masks
		));
		
	}


	public function actionUpdate($client_cd,$bank_acct_num)
	{
		$model = $this->loadModel($client_cd,$bank_acct_num);
		$sql = "SELECT acct_mask FROM MST_FUND_BANK where bank_cd = '$model->bank_cd'";
		$res = DAO::queryRowSql($sql);
		$model->account_format = str_replace("#","9",$res['acct_mask']);
		//$model->from_dt = DateTime::createFromFormat('Y-m-d H:i:s',$model->from_dt)->format('d/m/Y H:i');
		//$model->to_dt = DateTime::createFromFormat('Y-m-d H:i:s',$model->to_dt)->format('d/m/Y H:i');
		$errflg = 0;
		$firstdterrflg = 1;
		$secdterrflg = 1;
		//$todtval = null;
		//var_dump($model->from_dt);
		//die();
		
		if($model->client_cd || !empty($model->client_cd)){
			$pos = strrpos($model->client_cd,' - ');
			if($pos){
				$trimmedclientcd = substr($model->client_cd,0,$pos);
				//var_dump($trimmedclientcd);
				//die();
				$model->client_cd = $trimmedclientcd;
			}
			
			$qclientname = Client::model()->find("client_cd = '$model->client_cd'");
			//var_dump($model->client_cd);
			//die();
			$clientname = $qclientname->client_name;
			$model->client_cd = $model->client_cd.' - '.$clientname;
		}
		
		if(isset($_POST['Clientflacct']))
		{
			/*	
			if($_POST['Clientflacct']['from_dt']){
			
				$fromdtval = $_POST['Clientflacct']['from_dt'];			
				
				if(strtotime(DateTime::createFromFormat('d/m/Y H:i',$fromdtval)->format('Y-m-d H:i'))){
					$firstdterrflg = 0;
					$errflg = 0;
				}else{
					$firstdterrflg = 1;
					$errflg = 1;
				}
			}
			
			if($_POST['Clientflacct']['to_dt']){
				
				if($_POST['Clientflacct']['acct_stat'] == 'C'){
					$todtval = date('d/m/Y 12:00');
				}else{
					$todtval = $_POST['Clientflacct']['to_dt'];
				}
					
				if($errflg == 0 && strtotime(DateTime::createFromFormat('d/m/Y H:i',$todtval)->format('Y-m-d H:i'))){
					$secdterrflg = 0;
					$errflg = 0;
				}else if($errflg == 1 && strtotime(DateTime::createFromFormat('d/m/Y H:i',$todtval)->format('Y-m-d H:i'))){
					$secdterrflg = 0;
					$errflg = 1;
				}else{
					$secdterrflg = 1;
					$errflg = 1;
				}
			}
			 */
			
			$model->attributes = $_POST['Clientflacct'];
			
			//if($_POST['Clientflacct']['acct_stat'] == 'C'){
				//$model->to_dt = date('Y-m-d 00:00:00');
			//}
			//$model->to_dt = $todtval;
			
			if($model->client_cd || !empty($model->client_cd)){
				$pos = strrpos($model->client_cd,' - ');
				
				if($pos){
					$trimmedclientcd = substr($model->client_cd,0,$pos);
					//var_dump($trimmedclientcd);
					//die();
					$model->client_cd = $trimmedclientcd;
				}
				//var_dump($model->client_cd);
				//die();
			}
			
			if($_POST['flag']=='TRUE'){
				//if($errflg == 0){
					if($model->validate()){
						if($model->executeSp(AConstant::INBOX_STAT_UPD,$client_cd,$bank_acct_num)>0){
			            	Yii::app()->user->setFlash('success', 'Successfully update '.$model->client_cd);
							//$this->redirect(array('index'));
							$this->redirect(array('/master/clientflacct/index'));
						}//end if model->executeSp
		            }//end if model->validate
				/*
				}else{
					if($firstdterrflg == 1)
						$model->addError('from_dt','Invalid From Date');
					if($secdterrflg == 1)
						$model->addError('to_dt','Invalid To Date');
				}
				*/
			}//end if $_POST
		}
		
		$qMask = DAO::queryAllSql("SELECT bank_cd, bank_name, acct_mask FROM MST_FUND_BANK ORDER BY bank_cd");
		$masks = array();
		
		foreach($qMask as $mask){
			$rawmask = $mask['acct_mask'];
			if($mask['acct_mask'])
			$mask['acct_mask'] = str_replace("#","9",$rawmask);
			$masks[] = $mask;
		}
		
		if(empty($model->account_format))
			$model->is_format_null = TRUE;
		else 
			$model->is_format_null = FALSE;
		
		if($model->client_cd || !empty($model->client_cd)){
			$pos = strrpos($model->client_cd,' - ');
			if($pos){
				$trimmedclientcd = substr($model->client_cd,0,$pos);
				//var_dump($trimmedclientcd);
				//die();
				$model->client_cd = $trimmedclientcd;
			}
			
			$qclientname = Client::model()->find("client_cd = '$model->client_cd'");
			//var_dump($model->client_cd);
			//die();
			$clientname = $qclientname->client_name;
			$model->client_cd = $model->client_cd.' - '.$clientname;
		}
		
		$this->render('update',array(
			'model'=>$model,
			'listMask'=>$masks
		));
	}



	public function actionIndex()
	{
		$model=new Clientflacct('search');
		$model->unsetAttributes();  // clear any default values
		$model->acct_stat = '<>C';
		

		if(isset($_GET['Clientflacct']))
			$model->attributes=$_GET['Clientflacct'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionAjxPopDelete($client_cd,$bank_acct_num)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model 			 = new Ttempheader();
		$model->scenario = 'cancel';
		$model1 		 = null;
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate())
			{	
				$model1    				= $this->loadModel($client_cd,$bank_acct_num);
				$model1->cancel_reason  = $model->cancel_reason;
				//$cek=Tfundmovement::model()->find("from_acct='$model1->bank_acct_num' or to_acct='$model1->bank_acct_num'");
				//$cek = 1;
				//if($cek){
					if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$client_cd,$bank_acct_num) > 0){
						Yii::app()->user->setFlash('success', 'Successfully cancel investor account '.$model1->client_cd);
						$is_successsave = true;
					}
				/*
				}
				else{
					Yii::app()->user->setFlash('error', 'Error cancel investor account');
					$is_successsave = true;	
				}*/
				
			}
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$model1,
			'is_successsave'=>$is_successsave		
		));
	}
	public function actionStatus(){
	
		$resp['status']='error';
		if(isset($_POST['Clientcd'])){
			$client=$_POST['Clientcd'];
			$query="select f_fund_bal('$client',trunc(SYSDATE)) as balqty from dual";
			$stat = DAO::queryRowSql($query);
			
			if($stat['balqty'] =='0' || $stat['balqty'] == null){
				$resp['cek'] = 'success';
			}
			else{
				$resp['balance']=$stat['balqty'];
				$resp['cek']='fail';
			}
			$resp['status']='success';
	
		}
		
		
		echo json_encode($resp);
	}
	
	public function actionShowsid(){
	
		$resp['status']='error';
		if(isset($_POST['client_cd'])){
			$client=$_POST['client_cd'];
			$query="select mst_cif.sid as sid, v_client_subrek14.subrek001 as subrek001 from mst_cif,v_client_subrek14,mst_client 
					where v_client_subrek14.client_cd = mst_client.client_cd 
					and mst_client.cifs=mst_cif.cifs and mst_client.client_cd= '$client'";
			$stat = DAO::queryRowSql($query);
			$resp['sid']=$stat['sid'];
			$resp['subrek001']=$stat['subrek001'];
				$resp['status'] = 'success';

		}
		
		
		echo json_encode($resp);
	}
	
	
	
	public function actionAcct_num(){
		
		$resp['status']='error';
		if(isset($_POST['bank_acct_num'])){
			$bank_acct_num=$_POST['bank_acct_num'];
			$query="select bank_acct_num from mst_client_flacct";
			$stat = DAO::queryAllSql($query);
			foreach($stat as $row){
				if($row['bank_acct_num'] == $bank_acct_num){
				$resp['fail']=true;
				break;
			
			}
			else{
				$resp['fail']=false;
			}
				
			}
			
		}	
		$resp['status']='success';
		echo json_encode($resp);
	}
	

	public function loadModel($client_cd,$bank_acct_num)
	{
		$model=Clientflacct::model()->find("client_cd = :client_cd AND bank_acct_num = :bank_acct_num",array(':client_cd'=>$client_cd,':bank_acct_num'=>$bank_acct_num));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
