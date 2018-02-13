<?php

class TfundmovementController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionView($id)
	{
	
		$model=$this->loadModel($id);
		$modelDetail =  Tfundledger::model()->findAll("doc_num='$id'");
	
		$this->render('view',array(
			'model'=>$model,
			'modelDetail'=>$modelDetail
		));
	}
		public function actionAjxValidateBackDated()
	{
		$resp = '';
		echo json_decode($resp);
	}
	public function actionGetDefaultBank()
	{
		$resp['status']='error';
		if(isset($_POST['client_cd'])){
				$client_cd = $_POST['client_cd'];
				$sql = "select bank_cd,bank_acct_num from mst_client where client_cd='$client_cd' and approved_stat='A'";
				$data = DAO::queryRowSql($sql);
				
				if($data)
				{
					$resp['bank_cd']=$data['bank_cd'];
					$resp['bank_acct_num']=$data['bank_acct_num'];
				}
			
			$resp['status']='success';
			}
		echo json_encode($resp);
		
	}
	public function actionCheckBankStock(){
			$resp['status']='error';
			if(isset($_POST['stk_cd'])){
				$stk_cd = $_POST['stk_cd'];
				
				$bank = Tpee::model()->find("stk_cd = '$stk_cd' ");
				if($bank)
				{
				$bank_cd = $bank->ipo_bank_cd;
				$bank_acct_num=  $bank->ipo_bank_acct;
				$resp['bank_cd'] = $bank_cd;
				$resp['bank_acct_num'] = $bank_acct_num;
				}
				
			
			$resp['status']='success';
			}
		echo json_encode($resp);
		}
	public function actionClientCd(){
	
		$resp['status']='error';
			if(isset($_POST['client_cd'])|| isset($_POST['tanggal'])){
			$client_cd=$_POST['client_cd'];
			$doc_date=$_POST['tanggal'];
			
			if(DateTime::createFromFormat('d/m/Y',$doc_date))$doc_date=DateTime::createFromFormat('d/m/Y',$doc_date)->format('Y-m-d');
			
			$query="select acct_name,bank_cd,bank_acct_num from mst_client_flacct where client_cd='$client_cd' and acct_stat in('A','I','B')
			        GROUP BY acct_name,bank_cd,bank_acct_num";
			$sql="select bank_acct_num from mst_client_flacct where client_cd='$client_cd' and acct_stat in('A','I','B') and approved_stat='A' ";
			$query1="SELECT BANK_CD, ACCT_NAME, BANK_ACCT_NUM FROM MST_CLIENT_BANK 
					WHERE CIFS IN (SELECT CIFS FROM MST_CLIENT_BANK WHERE CLIENT_CD = '$client_cd')";
					
			$query2="select bank_cd,bank_acct_num from mst_client where client_cd='$client_cd'";
			$query3 ="SELECT F_FUND_BAL('$client_cd','$doc_date') as saldo1 from dual";
			$client_cd = DAO::queryRowSql($query);
			$client_bank=DAO::queryRowSql($query1);
			$client=DAO::queryRowSql($query2);
			$saldo =DAO::queryRowSql($query3);
			$acct_num=DAO::queryRowSql($sql);
				$resp['bank_cd_mst_client']=$client['bank_cd'];
				$resp['bank_acct_num_mst_client']=$client['bank_acct_num'];
				$resp['acct_name_client']=$client_bank['acct_name'];
				$resp['bank_cd_client']=$client_bank['bank_cd'];
				$resp['bank_acct_num_client']=$client_bank['bank_acct_num'];
				$resp['saldo']=$saldo['saldo1'];
				$resp['acct_name'] = $client_cd['acct_name'];
				$resp['bank_cd'] = $client_cd['bank_cd'];
				$resp['bank_acct_num'] = $acct_num['bank_acct_num'];
				$resp['status']='success';
				$bank_cd = $client_cd['bank_cd'];
		        $resp['fund_bank']=Fundbank::model()->find("bank_cd='$bank_cd'")?Fundbank::model()->find("bank_cd='$bank_cd'")->ip_bank_cd:'';
		
		
			}
		echo json_encode($resp);
	}
	public function actionCeksaldo(){
			$resp['status']='error';
			if(isset($_POST['client_cd'])|| isset($_POST['tanggal'])){
			$client_cd=$_POST['client_cd'];
			$doc_date=$_POST['tanggal'];
	
			if(DateTime::createFromFormat('d/m/Y',$doc_date))$doc_date=DateTime::createFromFormat('d/m/Y',$doc_date)->format('Y-m-d');
			$query3 ="SELECT F_FUND_BAL('$client_cd','$doc_date') as saldo1 from dual";
			$saldo =DAO::queryRowSql($query3);
				$resp['saldo']=$saldo['saldo1'];
				$resp['status']='success';
					}
		echo json_encode($resp);
	}
	public function actionCheckFee(){
			$resp['status']='error';
			if(isset($_POST['client_cd'])){
			$client_cd=$_POST['client_cd'];
			$bank_bawah=$_POST['bank_bawah'];
			$bank_atas=$_POST['bank_atas'];
			
			$trx_amt=(int)$_POST['trx_amt'];
			$branch_cd=$_POST['branch_cd'];
				
			$sql="SELECT OLT FROM MST_CLIENT where client_cd='$client_cd'";
			$olt=DAO::queryRowSql($sql);
				
			$olt1=$olt['olt'];
			
			$query3 ="SELECT F_TRANSFER_FEE('$trx_amt','$bank_atas','$bank_bawah','$branch_cd','$olt1','$olt1','$client_cd') as fee1 from dual";
			$fee =DAO::queryRowSql($query3);
				$resp['fee2']=$fee['fee1'];
				$resp['status']='success';
					}
		echo json_encode($resp);
	}
	public function actionGetbankcd(){
	
		$resp['status']='error';
			if(isset($_POST['client_cd'])){
			$client_cd=$_POST['client_cd'];
			
			$query1="SELECT distinct BANK_CD,bank_acct_num,bank_acct_num ||'-'||BANK_CD as acct_num FROM MST_CLIENT_BANK 
					WHERE CIFS IN (SELECT CIFS FROM MST_CLIENT_BANK WHERE CLIENT_CD = '$client_cd')";	
			$to_acct =DAO::queryAllSql($query1);
				$x=0;
				foreach($to_acct as $row)
				{
					$resp['to_acct1'][$x]['to_acct'] = $to_acct[$x]['bank_cd'];
					$resp['to_acct1'][$x]['acct_bawah'] = $to_acct[$x]['bank_acct_num'];
					$resp['to_acct1'][$x]['acct_num'] = $to_acct[$x]['acct_num'];
					$x++;
				}
		
				$resp['status']='success';

			}
		echo json_encode($resp);
	}
	public function actionGetdropacct(){
		$resp['status']='error';
			if(isset($_POST['client_cd'])){
			$client_cd=$_POST['client_cd'];
			$bank_cd=$_POST['bank_bawah'];
			$query1="SELECT BANK_ACCT_NUM,bank_acct_num ||'-'||BANK_CD as acct_num FROM MST_CLIENT_BANK 
					WHERE CIFS IN (SELECT CIFS FROM MST_CLIENT_BANK where client_cd='$client_cd') and bank_cd like '$bank_cd'";
			$acct_bawah1 =DAO::queryAllSql($query1);
			
				$x=0;
				foreach($acct_bawah1 as $row)
				{
					$resp['to_acct1'][$x]['acct_bawah1'] = $acct_bawah1[$x]['bank_acct_num'];
					$resp['to_acct1'][$x]['acct_num'] = $acct_bawah1[$x]['acct_num'];
					$x++;
				}
				
				$resp['status']='success';

			}
		echo json_encode($resp);
	}

	public function actionGetacct()
    {	
      $i=0;
      $src=array();
      $term = strtoupper($_GET['term']);
	$client_cd=strtoupper($_GET['client_cd']);
	
      $qSearch = DAO::queryAllSql("
				SELECT BANK_ACCT_NUM FROM MST_CLIENT_BANK 
					WHERE CIFS IN (SELECT CIFS FROM MST_CLIENT_BANK where client_cd='$client_cd') and bank_acct_num like '$term%'
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['bank_acct_num']
      			, 'labelhtml'=>$search['bank_acct_num'] //WT: Display di auto completenya
      			, 'value'=>$search['bank_acct_num']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
	   
    }
		public function actionBranchCode(){
			
		$resp['status']='error';
			if(isset($_POST['client_cd'])){
			$client_cd=$_POST['client_cd'];
				
				//echo "<script>alert('$client_cd')</script>";
			$query="select trim(branch_code)  as branch_code from mst_client where client_cd='$client_cd' ";
			$source = DAO::queryRowSql($query);

				
				$resp['branch_cd'] = $source['branch_code'];
				$resp['status']='success';
		
		
		
			}
		echo json_encode($resp);
	}
			public function actionCekHoliday(){
				
			$cek = Sysparam::model()->find("PARAM_ID='SYSTEM' AND PARAM_CD1='CHECK' AND PARAM_CD2='HOLIDAY'")->dflg1;
			$resp['status']='error';
			if(isset($_POST['tanggal'])){
			$tanggal=$_POST['tanggal'];
			$query="select f_is_holiday('$tanggal') AS LIBUR FROM DUAL ";
			$source = DAO::queryRowSql($query);
		
				//$resp['tanggal'] = $tanggal;
				if($cek=='Y')
				{
					$resp['holiday'] = $source['libur'];	
				}
				else {
					$resp['holiday'] = 0;
				}
				
				$resp['status']='success';
		
		
		
			}
		echo json_encode($resp);
	}
		public function actionFindbank(){
			$resp['status']='error';
			if(isset($_POST['client_cd'])){
			$client_cd=$_POST['client_cd'];
			$bank_acc_num=$_POST['acct_bawah'];
			$query="SELECT BANK_CD FROM MST_CLIENT_BANK 
					WHERE CIFS IN (SELECT CIFS FROM MST_CLIENT_BANK where client_cd='$client_cd') and bank_acct_num like '$bank_acc_num'";
			$bank_cd=DAO::queryRowSql($query);
					$resp['bank_cd']=$bank_cd['bank_cd'];
		
				$resp['status']='success';
		
		
		
			}
		echo json_encode($resp);
		}
		public function actionFindacct(){
			$resp['status']='error';
			if(isset($_POST['client_cd'])){
			$client_cd=$_POST['client_cd'];
			$bank_cd=$_POST['bank_bawah'];
			$query="SELECT BANK_ACCT_NUM FROM MST_CLIENT_BANK 
					WHERE CIFS IN (SELECT CIFS FROM MST_CLIENT_BANK where client_cd='$client_cd') and bank_cd like '$bank_cd'";
			$bank_cd=DAO::queryRowSql($query);
					$resp['bank_acct_num']=$bank_cd['bank_acct_num'];
		
				$resp['status']='success';
		
		
		
			}
		echo json_encode($resp);
		}
		public function actionGetclientcd(){
			/*
			$i=0;
      $src=array();
      $term = strtoupper($_REQUEST['term']);
      $qSearch = DAO::queryAllSql("
				SELECT CLIENT_CD FROM MST_CLIENT_FLACCT WHERE CLIENT_CD like '%$term%'");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['client_cd']
      			, 'labelhtml'=>$search['client_cd'] //WT: Display di auto completenya
      			, 'value'=>$search['client_cd']);
      }
      */
		$i=0;
      $src=array();
      $term = strtoupper($_REQUEST['term']);
     
        $qSearch = DAO::queryAllSql("
					SELECT client_cd, branch_code, client_name, DECODE(susp_stat,'C','C','') susp_stat, DECODE(susp_stat,'C',' - Closed','') susp_text
					FROM MST_CLIENT
					Where (client_cd like '".$term."%')
	      			AND susp_stat = 'N' 
	      			AND rownum <= 11
	      			ORDER BY client_cd
	      			");
	      
	    foreach($qSearch as $search)
	    {
	    	$src[$i++] = array('label'=>$search['client_cd'].$search['susp_text'].' - '.$search['branch_code']. ' - '.$search['client_name']
	      			, 'labelhtml'=>$search['client_cd'].$search['susp_text'].' - '.$search['branch_code']. ' - '.$search['client_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['client_cd']
					, 'branch'=>$search['branch_code']
					, 'name'=>$search['client_name']);
	    }
      echo CJSON::encode($src);
      Yii::app()->end();
		}
	
	public function actionCreate()
	{	$success = false;
		$model=new Tfundmovement;
		$modelJurnal= array();
		$model->doc_date = date('d/m/Y');
		$valid = true;
		
		if(isset($_POST['Tfundmovement']))
		{
			
			$model->attributes=$_POST['Tfundmovement'];
			
			//validate if bank acct num not valid
			/*
			if($model->trx_type =='R')
			{
				$cek = Clientbank::model()->find("bank_acct_num = '$model->from_acct' and client_cd = '$model->client_cd' ");
				if(!$cek)
				{
					$model->addError('from_acct', 'Bank account number not found');
					$valid=false;
				}	
			}
			*/
		
			if($model->trx_type =='B'){
				$model->trx_type='R';
			}
            if($model->trx_type=='T')
            {
                $model->trx_type='W';
                $model->sl_acct_cd='NTAX';
            }
			if($model->trx_type =='O' || $model->trx_type =='I'){
			
				$model->source='INPUT';
				$model->fee =$model->fee==''?0:$model->fee;
				$model->from_bank = $model->to_bank;
				$model->from_client = $model->client_cd;
				$model->to_client = $model->client_cd;
				$model->fund_bank_cd = $model->to_bank;
				$model->fund_bank_acct = $model->to_acct;
				$model->to_bank ='LUAR';
				$model->to_acct='-';
			}
			
			if($model->bank_mvmt_date == "__/__/____ __:__:__")$model->bank_mvmt_date='';
			
			if(DateTime::createFromFormat('d/m/Y H:i:s',$model->bank_mvmt_date))$model->bank_mvmt_date=DateTime::createFromFormat('d/m/Y H:i:s',$model->bank_mvmt_date)->format('Y-m-d H:i:s');
			
				
			if($valid && $model->validate(FALSE)){
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
		$menuName = 'FUND MOVEMENT ENTRY';
					
		if($model->validate() && $model->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
		
			
		
			if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->doc_num,1) > 0){
            	$success = true;
			}
			else{
				$success = false;
			}
			

					if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Saved '.$model->client_cd);
						$this->redirect(array('/finance/Tfundmovement/index'));
					}
					else {
						$transaction->rollback();
					}
			}
		}
		if(DateTime::createFromFormat('Y-m-d',$model->doc_date))$model->doc_date=DateTime::createFromFormat('Y-m-d',$model->doc_date)->format('d/m/Y');
if(DateTime::createFromFormat('Y-m-d H:i:s',$model->bank_mvmt_date))$model->bank_mvmt_date=DateTime::createFromFormat('Y-m-d H:i:s',$model->bank_mvmt_date)->format('d/m/Y H:i:s');
		$this->render('create',array(
			'model'=>$model,
			
		));
	}

	public function actionUpdate($id)
	{
		
		$success = false;
		$model=$this->loadModel($id);
		$oldModel= $this->loadModel($id);
		
		if(isset($_POST['Tfundmovement']))
		{
		$model->attributes=$_POST['Tfundmovement'];
	
			if($model->trx_type =='B'){
				$model->trx_type='R';
			}
			if($model->trx_type =='O' || $model->trx_type =='I'){
				
				$model->source='INPUT';
				$model->fee =$model->fee==''?0:$model->fee;
				$model->to_bank = $model->from_bank;
				$model->to_acct = $model->from_acct;
				$model->from_client = $model->client_cd;
				$model->to_client = $model->client_cd;
				$model->fund_bank_cd = $model->from_bank;
				$model->fund_bank_acct = $model->from_acct;
			}
		if($model->validate()){
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
		$menuName = 'FUND MOVEMENT ENTRY';
		
		if($model->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName) > 0)$success = true;

		if(DateTime::createFromFormat('d/m/Y H:i:s',$model->bank_mvmt_date))$model->bank_mvmt_date=DateTime::createFromFormat('d/m/Y H:i:s',$model->bank_mvmt_date)->format('Y-m-d H:i:s');
		if(DateTime::createFromFormat('Y H:i:s-m-d',$model->bank_mvmt_date))$model->bank_mvmt_date=DateTime::createFromFormat('Y H:i:s-m-d',$model->bank_mvmt_date)->format('Y-m-d H:i:s');
		if(DateTime::createFromFormat('Y-m-d H:i:s',$model->doc_date))$model->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$model->doc_date)->format('Y-m-d');
			
			

		if(DateTime::createFromFormat('Y-m-d H:i:s',$oldModel->doc_date)->format('Y-m-d') && $oldModel->client_cd == $model->client_cd && $oldModel->trx_amt == $model->trx_amt && $oldModel->trx_type == $model->trx_type)
		{
				
				
if(DateTime::createFromFormat('Y-m-d H:i:s',$oldModel->doc_date))$oldModel->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$oldModel->doc_date)->format('Y-m-d');
			
		//	echo "<script>alert('$id')</script>";
			if($model->validate() && $success && $model->executeSp(AConstant::INBOX_STAT_UPD,$id,1) > 0){
          	$success = true; 
					
            }
			else{
			
				$success = false;
			}
		}
		else{
			
			$model->doc_num='';
			
			if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->doc_num,1) > 0){
          	$success = true; 
					
            }
			else{
			
				$success = false;
			}
		
		$oldModel->update_date = $model->update_date;
		$oldModel->update_seq = $model->update_seq;
		if(DateTime::createFromFormat('d/m/Y H:i:s',$oldModel->bank_mvmt_date))
		$oldModel->bank_mvmt_date=DateTime::createFromFormat('d/m/Y H:i:s',$oldModel->bank_mvmt_date)->format('Y-m-d H:i:s');
		if(DateTime::createFromFormat('Y-m-d H:i:s',$oldModel->doc_date))$oldModel->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$oldModel->doc_date)->format('Y-m-d');
	
		if($success && $oldModel->executeSp(AConstant::INBOX_STAT_UPD,$id,2) > 0){
          	$success = true;
			  
            }
			else{
				
				$success = false;
			}
		}

		if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Saved ' .$oldModel->client_cd);
						$this->redirect(array('/finance/tfundmovement/index'));
					}
					else {
						
						$transaction->rollback();
					}
					}
					}
		if(DateTime::createFromFormat('Y-m-d H:i:s',$model->bank_mvmt_date))$model->bank_mvmt_date=DateTime::createFromFormat('Y-m-d H:i:s',$model->bank_mvmt_date)->format('d/m/Y H:i:s');	
		if(DateTime::createFromFormat('Y-m-d',$model->doc_date))$model->doc_date=DateTime::createFromFormat('Y-m-d',$model->doc_date)->format('d/m/Y');
		
		$this->render('update',array(
			'model'=>$model,
			'oldModel'=>$oldModel,
		));
	}


	public function actionAjxPopDelete($id)
	{	$success = false;
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		$model1 = $this->loadModel($id);
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];	
				
		if($model->validate()){
		
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
		$menuName = 'FUND MOVEMENT ENTRY';
				$model1->cancel_reason  = $model->cancel_reason;
				$model1->user_id = Yii::app()->user->id;
				$model1->ip_address = Yii::app()->request->userHostAddress;
				if($model1->ip_address=="::1")
					$model1->ip_address = '127.0.0.1';	
		if($model->validate() && $model1->executeSpHeader(AConstant::INBOX_STAT_CAN,$menuName) > 0)$success = true;
				//$a=$model1->doc_date;
		//	echo "<script>alert('$a')</script>";	
				
				if(DateTime::createFromFormat('Y-m-d H:i:s',$model1->doc_date))$model1->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$model1->doc_date)->format('Y-m-d');
				
			//	$a=$model1->doc_date;
			//echo "<script>alert('$a')</script>";	
			//	$oldModel = $this->loadModel($id);
				
				if( $model->validate() && $success && $model1->executeSp(AConstant::INBOX_STAT_UPD,$id,1) > 0){
					
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->client_cd);
					$is_successsave = true;
				}
					
					else {
						$transaction->rollback();
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
		
		
		$model=new Tfundmovement('search');
		$model->unsetAttributes();  // clear any default values
		$model->approved_sts='A';
		//$model->source='INPUT';
		$model->from_date = date("d/m/Y", strtotime("-1 months"));
		$model->to_date = date('d/m/Y');
	
	
		if(isset($_GET['Tfundmovement']))
			$model->attributes=$_GET['Tfundmovement'];
			
			if($model->trx_type =='B'){
				$model->trx_type='R';
			}
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Tfundmovement::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
