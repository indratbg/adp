<?php

class GljournalledgerspvController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

		public function actionView($id)
	{	$model=$this->loadModel($id);
		$modeldetail = Taccountledger::model()->findAll("xn_doc_num = '$id' AND approved_sts = '".AConstant::INBOX_APP_STAT_APPROVE."'");	
		if(DateTime::createFromFormat('Y-m-d H:i:s',$model->jvch_date))$model->jvch_date=DateTime::createFromFormat('Y-m-d H:i:s',$model->jvch_date)->format('d M Y');
		$this->render('view',array(
			'model'=>$model,
			'modeldetail'=>$modeldetail,
		));
	}
	public function actionGetSlAcct()
	{
		$i=0;
      	$src=array();
      	$term = strtoupper($_REQUEST['term']);
      	$glAcctCd = $_REQUEST['gl_acct_cd'];
      	
      	$qSearch = DAO::queryAllSql("
					SELECT sl_a, acct_name FROM MST_GL_ACCOUNT 
					WHERE TRIM(gl_a) = '$glAcctCd' 
					AND sl_a LIKE '".$term."%'
					AND prt_type <> 'S'
					AND acct_stat = 'A'
					AND approved_stat = 'A'
	      			AND rownum <= 200
	      			ORDER BY sl_a
      			");
      
	    foreach($qSearch as $search)
	    {
	      	$src[$i++] = array('label'=>$search['sl_a'].' - '.$search['acct_name']
	      			, 'labelhtml'=>$search['sl_a'].' - '.$search['acct_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['sl_a']);
	    }
      
      	echo CJSON::encode($src);
      	Yii::app()->end();
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
	public function actionCreate()
	{
		$model=new Tjvchh;
		$modeldetail=array();
		$modeldetail[0]=new Taccountledger; 
		$oldmodel='';
		$init = true;
		$valid = false;
		$success = false;
		$model->scenario='insert';
		$model->jvch_date =date('d/m/Y');
		$modelfolder = new Tfolder;
		$cek_folder = Sysparam::model()->find("param_id='SYSTEM' AND PARAM_CD1='VCH_REF'")->dflg1;
		$sign=Sysparam::model()->find("param_id='SYSTEM' and param_cd1='DOC_REF'");
		$cek_branch = Sysparam::model()->find("param_id='SYSTEM' and param_cd1='CHECK' AND PARAM_CD2='ACCTBRCH'")->dflg1;

		
		if(isset($_POST['Tjvchh']))
		{
			$init = false;
			
			$model->attributes=$_POST['Tjvchh'];
			$valid = $model->validate();
		
			
			if(isset($_POST['rowCount']))
			{
				$rowCount = $_POST['rowCount'];
				$x;
				$y;
				//$balance=0;	
				for($x=0;$x<$rowCount;$x++)
				{
					if(isset($_POST['Taccountledger'][$x+1]['save_flg']) && $_POST['Taccountledger'][$x+1]['save_flg'] == 'Y')
					{
							
						$modeldetail[$x] = new Taccountledger;
						$modeldetail[$x]->attributes=$_POST['Taccountledger'][$x+1];
						
						$sl_acct_cd =trim($modeldetail[0]->sl_acct_cd);
						$gl_acct_cd =trim($modeldetail[0]->gl_acct_cd);
						$gl=trim($modeldetail[$x]->gl_acct_cd);
						$sl=trim($modeldetail[$x]->sl_acct_cd);
						$db_cr_flg = $modeldetail[$x]->db_cr_flg;
                        /*
                        if($db_cr_flg == 'D')
                        {
                            $balance = $balance + $modeldetail[$x]->curr_val;
                        }
                        else 
                        {
                            $balance = $balance - $modeldetail[$x]->curr_val;
                        }
                        */
						if($cek_branch == 'Y')
						{
							$branch1 = Glaccount::model()->find(" sl_a= '$sl_acct_cd' and trim(gl_a) = trim('$gl_acct_cd') ")->brch_cd;
							$branch2 = Glaccount::model()->find(" sl_a= '$sl' and trim(gl_a) = trim('$gl') ")->brch_cd;	
								
							if(trim($branch1) != trim($branch2))
							{
								$modeldetail[$x]->addError('gl_acct_cd','Harus dari branch yang sama');
								$valid=false;
							}	
						}
						//validate client afiliasi
						//if($broker_cd =='YJ')
					//	{
							//$cek = Client::model()->find("client_cd = '$sl' ");
							/*
							$cek = Tclientafiliasi::model()->find(" client_cd= '$sl' and trunc(sysdate) between from_dt and to_dt");
							if($cek)
							{
								$sql = "select F_GL_ACCT_T3_JAN2016('$sl','$db_cr_flg') gl_a from dual";
								$exec = DAO::queryRowSql($sql);
								$new_gl_a = trim($exec['gl_a']);
								
								if($gl != $new_gl_a)
								{
									$modeldetail[$x]->addError('gl_acct_cd','Client terafiliasi, GL Account seharusnya '.$new_gl_a);
								}
							}
							*/
						//}
							$valid = $modeldetail[$x]->validate(null,false) && $valid;
					}	
	
				}
			/*
			   if($balance !=0)
                 {
                     $model->addError('cre_dt','Journal  not balance');
                     $valid = FALSE;
                 }
             */
				$authorizedBackDated = $_POST['authorizedBackDated'];
				
				if(!$authorizedBackDated)
				{
					$currMonth = date('Ym');
					$docMonth = DateTime::createFromFormat('Y-m-d',$model->jvch_date)->format('Ym');
				
					if($docMonth < $currMonth)
					{
						$model->addError('jvch_date','You are not authorized to select last month date');
						$valid = FALSE;
					}
				}

			 
				if($valid)
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
					$menuName = 'GL JOURNAL ENTRY';
					$tanggal=$model->jvch_date;
					$sql="SELECT GET_DOCNUM_GL(to_date('$tanggal','yyyy-mm-dd'),'GL') as jvch_num from dual";
					$num=DAO::queryRowSql($sql);
					$jvch_num=$num['jvch_num'];
					$model->jvch_num= $jvch_num;
					$model->jvch_type='GL';
					$model->curr_cd='IDR';
					$model->reversal_jur='N';
					
			
					if($model->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
					
					if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->jvch_num,1) > 0)$success = true;
					else {
						$success = false;
					}
					if($cek_folder =='Y')
					{
						//insert t_forder
						$modelfolder->fld_mon = DateTime::createFromFormat('Y-m-d',$model->jvch_date)->format('my');
						$modelfolder->folder_cd = $model->folder_cd;
						$modelfolder->doc_date = $model->jvch_date;
						$modelfolder->doc_num = $jvch_num;
						$modelfolder->user_id= $model->user_id;
						if($success && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_INS, $modelfolder->doc_num, $model->update_date, $model->update_seq, 1) > 0)$success = true;
						else {
							$success = false;
						}
					}
					$recordSeq = 1;
					for($x=0; $success && $x<$rowCount ;$x++)
					{ 
						if($modeldetail[$x]->save_flg == 'Y')
						{
					
						$client=trim($modeldetail[$x]->sl_acct_cd);
						$gl_a=trim($modeldetail[$x]->gl_acct_cd);
						$sql_client="SELECT acct_type FROM MST_CLIENT c,mst_gl_account m WHERE client_cd = sl_a and sl_a='$client' and trim(gl_a)='$gl_a' and m.prt_type <>'S' and m.acct_stat='A' and m.approved_stat='A' ";
						$client_cd=DAO::queryRowSql($sql_client);
						$acct_type = $client_cd['acct_type'];
						if($acct_type){
							$modeldetail[$x]->acct_type = $acct_type;
						}
						
			
								
								$modeldetail[$x]->tal_id=$recordSeq;
								$modeldetail[$x]->xn_doc_num=$model->jvch_num;
								$modeldetail[$x]->folder_cd=$model->folder_cd;
								$modeldetail[$x]->doc_date=$model->jvch_date;
								$modeldetail[$x]->due_date=$modeldetail[$x]->doc_date;
								$modeldetail[$x]->netting_date = $modeldetail[$x]->doc_date;
								$modeldetail[$x]->arap_due_date = $modeldetail[$x]->doc_date;
								$modeldetail[$x]->reversal_jur='N';
								$modeldetail[$x]->curr_cd='IDR';
								$modeldetail[$x]->budget_cd='GL';
								$modeldetail[$x]->manual='Y';
								$modeldetail[$x]->record_source='GL';
								$modeldetail[$x]->xn_val = $modeldetail[$x]->curr_val;
								$modeldetail[$x]->user_id = Yii::app()->user->id;
								$modeldetail[$x]->cre_dt = date('Y-m-d H:i:s');
								if($sign == 'Y'){
								$modeldetail[$x]->doc_ref_num = $modeldetail[$x]->xn_doc_num;
								}
								
							if($success && $modeldetail[$x]->executeSp(AConstant::INBOX_STAT_INS,$modeldetail[$x]->xn_doc_num,$modeldetail[$x]->tal_id,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
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
						$this->redirect(array('/glaccounting/Gljournalledgerspv/index'));
					}
					else {
						$transaction->rollback();
					}
				}
			}
		}
	if(DateTime::createFromFormat('Y-m-d',$model->jvch_date))$model->jvch_date=DateTime::createFromFormat('Y-m-d',$model->jvch_date)->format('d/m/Y');	
		
		$this->render('create',array(
			'model'=>$model,
			'modeldetail'=>$modeldetail,
			//'cancel_reason'=>$cancel_reason,
			'init'=>$init,	
			'modelfolder'=>$modelfolder
		));
	}
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$this->checkCancelled($model, array('index'));
		$oldmodel=$this->loadModel($id);
		$modeldetail = array();
		$oldmodeldetail=array();
		$oldmodeldetail=Taccountledger::model()->findAll("xn_doc_num='$id' and approved_sts='A' ");
		$modelreversal=Taccountledger::model()->findAll("xn_doc_num='$id' and approved_sts='A' ");
		$modelfolder =  Tfolder::model()->find("doc_num = '$id'");
		$modelfolderTAL = Taccountledger::model()->findAll("xn_doc_num = '$id' and approved_sts='A' ");

		$model->scenario='update';
		$cek_folder = Sysparam::model()->find("param_id='SYSTEM' AND PARAM_CD1='VCH_REF'")->dflg1;
		$sign=Sysparam::model()->find("param_id='SYSTEM' and param_cd1='DOC_REF'");
		$cek_branch = Sysparam::model()->find("param_id='SYSTEM' and param_cd1='CHECK' AND PARAM_CD2='ACCTBRCH'")->dflg1;
		$valid = false;
		$success = false;
		$upd_flag = false;
		$doc_num_baru ='';
		$cancel_reason = '';
		
		$x = 0;
		$check = array();
		$oldPkId = array();

		
		//18MAY2016
		$arap_flg=false;
		
		if($cek_folder =='Y')
		{
			if(DateTime::createFromFormat('Y-m-d H:i:s',$modelfolder->doc_date))$modelfolder->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$modelfolder->doc_date)->format('Y-m-d');	
		}
		
		
		if(isset($_POST['Tjvchh']))
		{ 
			$model->attributes=$_POST['Tjvchh'];
			$valid = $model->validate();
			
			$rowCount = $_POST['rowCount'];
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
				
			for($x=0;$x<$rowCount;$x++)
			{
				if(isset($_POST['Taccountledger'][$x+1]['rowid']) && $_POST['Taccountledger'][$x+1]['rowid'])
				{
					$rowid = $_POST['Taccountledger'][$x+1]['rowid'];
					$modeldetail[$x] = Taccountledger::model()->find("rowid = '$rowid' ");	
				}
				else 
				{
					$modeldetail[$x] = new Taccountledger;	
				}
				
				$modeldetail[$x]->attributes = $_POST['Taccountledger'][$x+1];
				$modeldetail[$x]->curr_val= str_replace( ',', '', $modeldetail[$x]->curr_val );
		if(DateTime::createFromFormat('Y-m-d H:i:s',$modeldetail[$x]->netting_date))$modeldetail[$x]->netting_date=DateTime::createFromFormat('Y-m-d H:i:s',$modeldetail[$x]->netting_date)->format('Y-m-d');	
		if(DateTime::createFromFormat('Y-m-d H:i:s',$modeldetail[$x]->arap_due_date))$modeldetail[$x]->arap_due_date=DateTime::createFromFormat('Y-m-d H:i:s',$modeldetail[$x]->arap_due_date)->format('Y-m-d');
				
				if(isset($_POST['Taccountledger'][$x+1]['save_flg']) && $_POST['Taccountledger'][$x+1]['save_flg'] == 'Y')
				{
					if(isset($_POST['Taccountledger'][$x+1]['cancel_flg']))
					{
						if($_POST['Taccountledger'][$x+1]['cancel_flg'] == 'Y')
						{
							//CANCEL
							$modeldetail[$x]->scenario = 'cancel';
							$modeldetail[$x]->cancel_reason = $_POST['cancel_reason'];
						}
						else 
						{
							//UPDATE
							$modeldetail[$x]->scenario = 'update';
						}
					}
					else 
					{
						//INSERT
						$modeldetail[$x]->scenario = 'insert';
					}
					
					$modeldetail[$x]->gl_acct_cd = strtoupper($modeldetail[$x]->gl_acct_cd);
					$modeldetail[$x]->sl_acct_cd = strtoupper($modeldetail[$x]->sl_acct_cd);
				
					$modeldetail[$x]->gl_acct_cd = trim($modeldetail[$x]->gl_acct_cd);
					$modeldetail[$x]->sl_acct_cd = trim($modeldetail[$x]->sl_acct_cd);
					
				
					
					//validasi branch untuk danasakti
					$sl_acct_cd =trim($modeldetail[0]->sl_acct_cd);
					$gl_acct_cd =trim($modeldetail[0]->gl_acct_cd);
					$gl=trim($modeldetail[$x]->gl_acct_cd);
					$sl=trim($modeldetail[$x]->sl_acct_cd);
					$db_cr_flg = $modeldetail[$x]->db_cr_flg;
					if($cek_branch == 'Y')
					{
						$branch1 = Glaccount::model()->find(" sl_a= '$sl_acct_cd' and trim(gl_a) = trim('$gl_acct_cd') ")->brch_cd;
						$branch2 = Glaccount::model()->find(" sl_a= '$sl' and trim(gl_a) = trim('$gl') ")->brch_cd;	
							
						if(trim($branch1) != trim($branch2))
						{
							$modeldetail[$x]->addError('gl_acct_cd','Harus dari branch yang sama');
							$valid=false;
						}	
					}
					//validasi untuk sett_for_curr dan sett_val tidak boleh 0
					if($modeldetail[$x]->rowid)
					{
						$rowid = $modeldetail[$x]->rowid;
						$data = Taccountledger::model()->find("rowid = '$rowid' ");
						$sett_val = Taccountledger::model()->find("rowid = '$rowid' ")->sett_val;
						$sett_val = $sett_val==null?'0':$sett_val;	
						$sett_for_curr = Taccountledger::model()->find("rowid = '$rowid' ")->sett_for_curr;
						$sett_for_curr = $sett_for_curr==null?'0':$sett_for_curr;
					
						if($modeldetail[$x]->sl_acct_cd != $data->sl_acct_cd || $modeldetail[$x]->gl_acct_cd != trim($data->gl_acct_cd)
						|| $modeldetail[$x]->db_cr_flg != $data->db_cr_flg || $modeldetail[$x]->curr_val != $data->curr_val )
						{
							
							if($sett_val != '0' || $sett_for_curr !='0' )
							{ 
								
								$modeldetail[$x]->addError('gl_acct_cd','Cannot update journal, settle value greater than 0');
								$valid=false;
							}
						}
						
					}
						$cek = Tclientafiliasi::model()->find(" client_cd= '$sl' and trunc(sysdate) between from_dt and to_dt");
						if($cek)
						{
							$sql = "select F_GL_ACCT_T3_JAN2016('$sl','$db_cr_flg') gl_a from dual";
							$exec = DAO::queryRowSql($sql);
							$new_gl_a = trim($exec['gl_a']);
							
							if($gl != $new_gl_a)
							{
								$modeldetail[$x]->addError('gl_acct_cd','Client terafiliasi, GL Account seharusnya '.$new_gl_a);
							}
						}
						$modeldetail[$x]->acct_type=trim($modeldetail[$x]->acct_type);  
						$valid = $modeldetail[$x]->validate(null,false) && $valid;
					
					
				}
				
			}
			$authorizedBackDated = $_POST['authorizedBackDated'];
				
				if(!$authorizedBackDated)
				{
					$currMonth = date('Ym');
					$docMonth = DateTime::createFromFormat('Y-m-d',$model->jvch_date)->format('Ym');
				
					if($docMonth < $currMonth)
					{
						$model->addError('jvch_date','You are not authorized to select last month date');
						$valid = FALSE;
					}
				}
				
			//VALIDASI SETT_FOR_CURR DAN SETT_VAL
			 
			
			if($valid)
			{ 
			
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
				$menuName = 'GL JOURNAL ENTRY';
				if(DateTime::createFromFormat('Y-m-d H:i:s',$oldmodel->jvch_date))$oldmodel->jvch_date=DateTime::createFromFormat('Y-m-d H:i:s',$oldmodel->jvch_date)->format('Y-m-d');
				
			//execute SP header
			if($model->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName) > 0)$success = true;
			
				$oldmodel->update_date=$model->update_date;
				$oldmodel->update_seq=$model->update_seq;
				if($success && $oldmodel->executeSp(AConstant::INBOX_STAT_CAN,$id,3) > 0)$success = true;
				else {
					$success = false;
					}
				//get doc num header jurnal baru
				$tanggal=$model->jvch_date;
				$sql="SELECT GET_DOCNUM_GL(to_date('$tanggal','yyyy-mm-dd'),'GL') as jvch_num from dual";
				$num=DAO::queryRowSql($sql);
				$jvch_num=$num['jvch_num'];
				$model->jvch_num=$jvch_num;
				$doc_num_baru =$jvch_num; 
				if($cek_folder == 'Y')
				{
				//cancel t_forder
					if($success && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_CAN, $id, $model->update_date, $model->update_seq, 1) > 0)$success = true;
					else {
						$success = false;
					}
					//buat baru t folder
					$modelfolder->fld_mon = DateTime::createFromFormat('Y-m-d',$model->jvch_date)->format('my');
					$modelfolder->folder_cd = $model->folder_cd;
					$modelfolder->doc_date = $model->jvch_date;
					$modelfolder->doc_num = $jvch_num;
					$modelfolder->user_id= $model->user_id;
					if($success && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_INS, $jvch_num, $model->update_date, $model->update_seq, 2) > 0)$success = true;
					else {
						$success = false;
					}
				
				}
				
				
				//kepala jurnal terbaru
				if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$jvch_num,1) > 0)$success = true;
				else {
					$success = false;
					}
				//buat jurnal terbaru
				$record_seq = 1;
				for($x=0; $success && $x<$rowCount; $x++)
				{ 
					if(($modeldetail[$x]->save_flg == 'Y' || $modeldetail[$x]->old_xn_doc_num !='' ) && $modeldetail[$x]->cancel_flg != 'Y')
					{
						$client=trim($modeldetail[$x]->sl_acct_cd);
						$gl_a=trim($modeldetail[$x]->gl_acct_cd);
											
						$acct_type = Glaccount::model()->find("sl_a='$client' and trim(gl_a)='$gl_a' and acct_stat='A' and prt_type <>'S' and approved_stat='A'");
						if($acct_type)
						{
							$cek=Client::model()->find("client_cd='$client' ");
							if($cek)
							{
								$modeldetail[$x]->acct_type = trim($acct_type->acct_type);	
							}
						}
						if($sign == 'Y'){
							$modeldetail[$x]->doc_ref_num = $modeldetail[$x]->xn_doc_num;
						}
						if(!$modeldetail[$x]->old_xn_doc_num)
						{
						$modeldetail[$x]->curr_cd  = 'IDR';
						$modeldetail[$x]->budget_cd  = 'GL';
						$modeldetail[$x]->reversal_jur = 'N';
						$modeldetail[$x]->record_source='GL';	
						}
						
						$modeldetail[$x]->xn_doc_num = $jvch_num;
						$modeldetail[$x]->doc_date = $model->jvch_date;
						$modeldetail[$x]->due_date = $model->jvch_date;
						$modeldetail[$x]->netting_date = $model->jvch_date;
						$modeldetail[$x]->arap_due_date = $model->jvch_date;
						$modeldetail[$x]->folder_cd = $model->folder_cd;
						
						$modeldetail[$x]->manual = 'Y';
						$modeldetail[$x]->tal_id = $record_seq; 
						$modeldetail[$x]->xn_val = $modeldetail[$x]->curr_val;
						$modeldetail[$x]->user_id  =$model->user_id;
						$modeldetail[$x]->cre_dt = $model->cre_dt;
						if($success && $modeldetail[$x]->executeSp(AConstant::INBOX_STAT_INS,$jvch_num,$record_seq,$model->update_date,$model->update_seq,$record_seq) > 0)$success = true;
						else {
							$success = false;
						}
					
					$record_seq++;
					}
				}

				
					if(DateTime::createFromFormat('Y-m-d H:i:s', $oldmodel->jvch_date)) $oldmodel->jvch_date=DateTime::createFromFormat('Y-m-d H:i:s', $oldmodel->jvch_date)->format('Y-m-d');
					$jur_date_reversal = $oldmodel->jvch_date;	
	


				if($cek_folder == 'Y')
				{
				//GET FOLDER_CD REVERSAL
				$sql3="SELECT  F_GET_FOLDER_NUM(to_date('$jur_date_reversal','yyyy-mm-dd'),'RJ-') as folder_cd FROM DUAL";
				$folder_cd=DAO::queryRowSql($sql3);
				$folder_cd_rev=$folder_cd['folder_cd'];
				}
				else 
				{
				$folder_cd_rev='';
				}
				$folder_cd_rev= $folder_cd_rev;
				//buat header reversal
				$sql="SELECT GET_DOCNUM_GL(to_date('$jur_date_reversal','yyyy-mm-dd'),'GL') as jvch_num from dual";
				$num=DAO::queryRowSql($sql);
				$jvch_num=$num['jvch_num'];
				$oldmodel->jvch_num=$jvch_num;
				$oldmodel->jvch_type = 'RE';
				$oldmodel->folder_cd = $folder_cd_rev;
				$oldmodel->jvch_date = $jur_date_reversal;
				$oldmodel->reversal_jur=$doc_num_baru; //'Y';30may2016
				if($success && $oldmodel->executeSp(AConstant::INBOX_STAT_INS,$jvch_num,2) > 0)$success = true;
				else {
					$success = false;
					}
				//buat jurnal reversal -- modelreversal
			
				if($cek_folder == 'Y')
				{
					$modelfolder = Tfolder::model()->find("doc_num = '$id' ");
					//buat baru t folder UNTUK REVERSAL
					$modelfolder->fld_mon = DateTime::createFromFormat('Y-m-d',$jur_date_reversal)->format('my');//18may2016
					$modelfolder->folder_cd = $folder_cd_rev;
					$modelfolder->doc_date = $jur_date_reversal;//18may2016
					$modelfolder->doc_num = $jvch_num;
					$modelfolder->user_id= $model->user_id;
					if($success && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_INS, $jvch_num, $model->update_date, $model->update_seq, 3) > 0)$success = true;
					else {
						$success = false;
					}
				
				}
				
		
				
				foreach($modelreversal  as $row)
				{
					if(DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date))$row->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date)->format('Y-m-d');
					if(DateTime::createFromFormat('Y-m-d H:i:s',$row->due_date))$row->due_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->due_date)->format('Y-m-d');
					if(DateTime::createFromFormat('Y-m-d H:i:s',$row->arap_due_date))$row->arap_due_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->arap_due_date)->format('Y-m-d');
					if(DateTime::createFromFormat('Y-m-d H:i:s',$row->netting_date))$row->netting_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->netting_date)->format('Y-m-d');
					$row->xn_doc_num = $jvch_num;
					$row->folder_cd = $folder_cd_rev;
					$row->budget_cd='GL';
					$row->record_source = 'RE';
					$row->xn_val = $row->curr_val; 
					$row->db_cr_flg = $row->db_cr_flg=='D'?'C':'D';
					$row->reversal_jur=$doc_num_baru; //'Y';30may2016
					$row->doc_date = $jur_date_reversal;//18may2016
					$row->due_date = $jur_date_reversal;//18may2016
					$row->netting_date = $jur_date_reversal;//18may2016
					$row->arap_due_date = $jur_date_reversal;//18may2016
					
					if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$jvch_num,$row->tal_id,$model->update_date,$model->update_seq,$record_seq) > 0)$success = true;
					else
					{
						$success = false;
					}
					$record_seq++;
				}				
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('/glaccounting/gljournalledgerspv/index'));
				}
				else {
					$transaction->rollback();
				}
			}

	if(DateTime::createFromFormat('Y-m-d',$model->jvch_date))$model->jvch_date=DateTime::createFromFormat('Y-m-d',$model->jvch_date)->format('d/m/Y');
		}
		else{
			$modeldetail = Taccountledger::model()->findAll(array('select'=>'t.*,rowid','condition'=>"xn_doc_num = '$id' and approved_sts='A'"));
			foreach($modeldetail as $row){
				$row->old_xn_doc_num=$row->xn_doc_num;
				$row->old_tal_id=$row->tal_id;
				$row->gl_acct_cd=trim($row->gl_acct_cd);
			}
			
		}
		if(DateTime::createFromFormat('Y-m-d H:i:s',$model->jvch_date))$model->jvch_date=DateTime::createFromFormat('Y-m-d H:i:s',$model->jvch_date)->format('d/m/Y');

		$this->render('update',array(
			'model'=>$model,
			'modeldetail'=>$modeldetail,
			'cancel_reason'=>$cancel_reason,
			'check'=>$check,
			'oldmodel'=>$oldmodel,
			'oldmodeldetail'=>$oldmodeldetail,
			'modelreversal'=>$modelreversal,
			'modelfolder'=>$modelfolder,
			'modelfolderTAL'=>$modelfolderTAL
		));
	}

	public function actionAjxPopDelete($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		$success = false;
		$valid = true;
		$model  = new Tmanyheader();
		$model2 =$this->loadModel($id);
		$model->scenario = 'cancel';
		$model1 = $this->loadModel($id);
		$modelreversal=Taccountledger::model()->findAll("xn_doc_num='$id'");
		$oldjurnal=Taccountledger::model()->findAll("xn_doc_num='$id'");
		$modeltrepovch= Trepovch::model()->find("doc_num='$id' and doc_ref_num='$id'");
		$modelfolder = Tfolder::model()->find("doc_num = '$id' ");
		$arap_flg=false;
		if($modeltrepovch){
			$modelrepo = Trepo::model()->find("repo_num='$modeltrepovch->repo_num'");
		}
		else{
			$modelrepo = new Trepo;
		}
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];	
			
				$this->checkCancelled($model2, Yii::app()->request->requestUri);
				
			//cek yang boleh dicancel
			foreach($modelreversal as $row)
			{
				$row->sett_val = $row->sett_val==null?'0':$row->sett_val;
				$row->sett_for_curr = $row->sett_for_curr==null?'0':$row->sett_for_curr;
				
				if($row->sett_val != '0' || $row->sett_for_curr != '0' )
				{
					$valid=false;	
					$row->addError('sett_val', 'Can not cancel journal, settle value greater than 0');
					break;
				}
				$valid=true;
			}
				
					if(DateTime::createFromFormat('Y-m-d H:i:s', $model2->jvch_date)) $model2->jvch_date=DateTime::createFromFormat('Y-m-d H:i:s', $model2->jvch_date)->format('Y-m-d');
					$jur_date_reversal = $model2->jvch_date;	
				//}			
					
			if($model->validate() && $valid)
			{
				$model1->cancel_reason  = $model->cancel_reason;
				$model1->user_id = Yii::app()->user->id;
				$model1->ip_address = Yii::app()->request->userHostAddress;
				if($model1->ip_address=="::1")
					$model1->ip_address = '127.0.0.1';
				
				
				$menuName = 'GL JOURNAL ENTRY';
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				
				if($model1->executeSpHeader(AConstant::INBOX_STAT_CAN,$menuName) > 0)$success = true;
				
				$sql="SELECT GET_DOCNUM_GL(to_date('$jur_date_reversal','yyyy-mm-dd'),'GL') as jvch_num from dual";
				$num=DAO::queryRowSql($sql);
				$jvch_num=$num['jvch_num'];	
				$p_user_id = Yii::app()->user->id;
				if($modelfolder)
				{
				//GET FOLDER_CD REVERSAL
				$sql3="SELECT  F_GET_FOLDER_NUM(to_date('$jur_date_reversal','yyyy-mm-dd'),'RJ-') as folder_cd FROM DUAL";
				$folder_cd=DAO::queryRowSql($sql3);
				$folder_cd_rev=$folder_cd['folder_cd'];
				}
				else
				{
					$folder_cd_rev='';
				}
	
				$recordSeq=1;
				$model2->jvch_num=$jvch_num;
				$model2->jvch_type='RE';
				$model2->update_date= $model1->update_date;
				$model2->update_seq= $model1->update_seq;
				$model2->folder_cd = $folder_cd_rev;
				$model2->jvch_date = $jur_date_reversal;
				$model2->reversal_jur='Y';
				if($model2->executeSp(AConstant::INBOX_STAT_INS,$jvch_num,2) > 0){$success = true;
					}
				else {
				$success = false;
				}
				//INSERT FOLDER REVERSAL
			if($modelfolder)
			{
			
				$modelfolder->fld_mon = DateTime::createFromFormat('Y-m-d',$jur_date_reversal)->format('my');
				$modelfolder->doc_num = $jvch_num;
				$modelfolder->doc_date = $jur_date_reversal;
				$modelfolder->cre_dt = date('Y-m-d H:i:s');
				$modelfolder->folder_cd = $folder_cd_rev;
				if($success && $modelfolder && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_INS, $jvch_num, $model1->update_date, $model1->update_seq, 1) > 0)$success = true;
				else {
					$success = false;
				}
			}
				
		foreach ($modelreversal as $row) 
		{
			if(DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date))$row->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date)->format('Y-m-d');
			if(DateTime::createFromFormat('Y-m-d H:i:s',$row->due_date))$row->due_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->due_date)->format('Y-m-d');
			if(DateTime::createFromFormat('Y-m-d H:i:s',$row->arap_due_date))$row->arap_due_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->arap_due_date)->format('Y-m-d');
			if(DateTime::createFromFormat('Y-m-d H:i:s',$row->netting_date))$row->netting_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->netting_date)->format('Y-m-d');
			$row->xn_doc_num = $jvch_num;
			$row->folder_cd = $folder_cd_rev;
			$row->budget_cd='GL';
			$row->record_source = 'RE';
			$row->xn_val = $row->curr_val; 
			$row->db_cr_flg = $row->db_cr_flg=='D'?'C':'D';
			//18may2016
			$row->doc_date = $jur_date_reversal;
			$row->due_date = $jur_date_reversal;
			$row->arap_due_date = $jur_date_reversal;
			$row->netting_date = $jur_date_reversal;
			
			if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$jvch_num,$row->tal_id,$model2->update_date,$model2->update_seq,$recordSeq) > 0)$success = true;
			else
			{
				$success = false;
			}
		$recordSeq++;
		}
		
				//cancel jurnal interest repo
			$budget_cd = Taccountledger::model()->find("xn_doc_num ='$id'")->budget_cd;
			if($modeltrepovch && $budget_cd='INTREPO')
			{		
					
		if(DateTime::createFromFormat('Y-m-d H:i:s',$modeltrepovch->doc_dt))$modeltrepovch->doc_dt=DateTime::createFromFormat('Y-m-d H:i:s',$modeltrepovch->doc_dt)->format('Y-m-d');					

				$modeltrepovch->doc_num=$id;
				$modeltrepovch->doc_ref_num=$id;
				//$modeltrepovch->tal_id=''
				if($success && $modeltrepovch->executeSp(AConstant::INBOX_STAT_CAN,$modeltrepovch->repo_num,$id,$id,$model1->update_date,$model1->update_seq,1) > 0){$success=TRUE;
				}
				else{
					$success=FALSE;
				}	
				
				if(DateTime::createFromFormat('Y-m-d H:i:s',$modelrepo->repo_date))$modelrepo->repo_date = DateTime::createFromFormat('Y-m-d H:i:s',$modelrepo->repo_date)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d H:i:s',$modelrepo->due_date))$modelrepo->due_date = DateTime::createFromFormat('Y-m-d H:i:s',$modelrepo->due_date)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d H:i:s',$modelrepo->extent_dt))$modelrepo->extent_dt = DateTime::createFromFormat('Y-m-d H:i:s',$modelrepo->extent_dt)->format('Y-m-d');
				$sett_val =$model1->curr_amt;
				$modelrepo->update_date=$model1->update_date;
				$modelrepo->update_seq=$model1->update_seq;
				$modelrepo->sett_val = $modelrepo->sett_val - $sett_val;
				if($success && $modelrepo->executeSp(AConstant::INBOX_STAT_UPD,$modelrepo->repo_num,1) > 0){$success=TRUE;
				}
				else
				{
					$success=FALSE;
				}
			}
		
		
				if(DateTime::createFromFormat('Y-m-d H:i:s',$model1->jvch_date))$model1->jvch_date=DateTime::createFromFormat('Y-m-d H:i:s',$model1->jvch_date)->format('Y-m-d');
			
				if($success && $model1->executeSp(AConstant::INBOX_STAT_CAN,$id,1) > 0)
				{
					 $success =TRUE;
				}
				else
				{
					$success =false;
				}
				
				if($modelfolder)
				{
					//cancel t_forder
					if(DateTime::createFromFormat('Y-m-d H:i:s',$modelfolder->doc_date))$modelfolder->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$modelfolder->doc_date)->format('Y-m-d');
					
					
					if($success && $modelfolder && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_CAN, $id, $model1->update_date, $model1->update_seq, 2) > 0)$success = true;
					else {
						$success = false;
					}
				}
				
				
				
				if($success){
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->folder_cd);
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
			'model2'=>$model2,
			'modelreversal'=>$modelreversal,
			'modelrepo'=>$modelrepo,
			'modeltrepovch'=>$modeltrepovch,
			'is_successsave'=>$is_successsave,
			'modelfolder'=>$modelfolder,		
		));
	}


	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}
	public function actionAjxValidateBackDated() 
	{
		$resp='';
		echo json_encode($resp);
	}

	public function actionIndex()
	{
		$model=new Vgljournalindex('search');
	//	$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Vgljournalindex']))
			$model->attributes=$_GET['Vgljournalindex'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionUpdateRemarks($id)
	{
		$model = $this->loadModel($id);
		$modelDetail = Taccountledger::model()->findAll(array('select'=>'t.*, rowid','condition'=>"xn_doc_num='$id' "));
		$valid =true;
		if(isset($_POST['Tjvchh']))
		{
			$model->attributes = $_POST['Tjvchh'];
			if(DateTime::createFromFormat('d/m/Y',$model->jvch_date))$model->jvch_date = DateTime::createFromFormat('d/m/Y',$model->jvch_date)->format('Y-m-d');
			$valid = $model->validate() && $valid;
			$rowCount = $_POST['rowCount'];
		
			for($x=0;$x<$rowCount;$x++)
			{
				$rowid = $_POST['Taccountledger'][$x+1]['rowid'];
				$modelDetail[$x] = Taccountledger::model()->find("rowid='$rowid'");
				if(isset($_POST['Taccountledger'][$x+1]['save_flg']) && $_POST['Taccountledger'][$x+1]['save_flg'] == 'Y')
				{
					$modelDetail[$x]->attributes = $_POST['Taccountledger'][$x+1];
					$valid = $modelDetail[$x]->validate() && $valid;
				}
				else 
				{
					$modelDetail[$x]->gl_acct_cd = trim($modelDetail[$x]->gl_acct_cd);	
				}
			}
			if($valid)
			{
					//save updated to t_jvchh	
					$model->save();
					
					for($x=0;$x<$rowCount;$x++)
					{
						if(isset($_POST['Taccountledger'][$x+1]['save_flg']) && $_POST['Taccountledger'][$x+1]['save_flg'] == 'Y')
						{
							$modelDetail[$x]->save();
						}
					}
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model->folder_cd);
					$this->redirect(array('index'));					
			}
			
		}
		else 
		{
			if(DateTime::createFromFormat('Y-m-d H:i:s',$model->jvch_date))$model->jvch_date = DateTime::createFromFormat('Y-m-d H:i:s',$model->jvch_date)->format('d/m/Y');
			foreach($modelDetail as $row)
			{
				$row->gl_acct_cd = trim($row->gl_acct_cd);
				 
			}
		}
		$this->render('_form_update_remarks',array(
			'model'=>$model,
			'modelDetail'=>$modelDetail		
		));
	}

	public function loadModel($id)
	{
		$model=Tjvchh::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	 
}
