<?php

class TdncnhController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';


	public function actionIndex()
	{	
		$model=new Tdncnh('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->approved_sts='A';
		if(isset($_GET['Tdncnh']))
			$model->attributes=$_GET['Tdncnh'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	
	public function actionCreate()
	{	
		$model=new Tdncnh;
		$modeldetail=array();
		$modeldetail[0]=new Taccountledger; 
		$modeldetail[0]->gl_acct_cd='1422';
		$oldmodel='';
		$init = true;
		$valid = false;
		$success = false;
		$model->scenario='insert';
		$model->dncn_date =date('d/m/Y');
		$modelfolder= new Tfolder;
		
		if(isset($_POST['Tdncnh']))
		{
			$init = false;
			
			$model->attributes=$_POST['Tdncnh'];
			$valid = $model->validate();
			
			if(isset($_POST['rowCount']))
			{
				$rowCount = $_POST['rowCount'];
				$x;
				$y;
					
				for($x=0;$x<$rowCount;$x++)
				{
					if(isset($_POST['Taccountledger'][$x+1]['save_flg']) && $_POST['Taccountledger'][$x+1]['save_flg'] == 'Y')
					{
						$modeldetail[$x] = new Taccountledger;
						$modeldetail[$x]->attributes=$_POST['Taccountledger'][$x+1];
						
						$sql="select dflg1 from mst_sys_param where param_id='SYSTEM' and param_cd1='CHECK' AND PARAM_CD2='ACCTBRCH'";
						$dflg=DAO::queryRowSql($sql);
						$cek_branch = $dflg['dflg1'];
						if($cek_branch=='Y'){
							$sl_acct_cd =trim($modeldetail[0]->sl_acct_cd);
							$gl=trim($modeldetail[$x]->gl_acct_cd);
							$sl=trim($modeldetail[$x]->sl_acct_cd);
							
							$query="SELECT brch_cd from mst_gl_account where sl_a= '$sl_acct_cd'";
							$getquery=DAO::queryRowSql($query);
							$branch=$getquery['brch_cd'];
							
							if($branch){
								$sqlbranch="SELECT brch_cd FROM MST_GL_ACCOUNT WHERE BRCH_CD= '$branch' and gl_a='$gl' and sl_a='$sl'";
								$cekAcct=DAO::queryRowSql($sqlbranch);
								if(!$cekAcct){
									//echo "<script>alert('$branch')</script>";
									$modeldetail[$x]->addError('gl_acct_cd','Harus dari branch yang sama');
									$valid=false;
									//break;
								}
							}
						} 
						 
						$valid=$modeldetail[$x]->validate()&&$valid;
						
					}	
				}
			// var_dump($model->approved_sts);die();
				if($valid)
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
					$menuName = 'INTEREST JOURNAL ENTRY';
					$tanggal=$model->dncn_date;
					$journalType='';
					if($model->db_cr_flg=='D'){
						$journalType="DN";
					}else if($model->db_cr_flg=='C'){
						$journalType="CN";
					}
					//$sql="SELECT Get_Docnum_GL(to_date('$tanggal','yyyy-mm-dd'),'$journalType') as dncn_num from dual";
					$sql="SELECT Get_Docnum_Dcnote(to_date('$tanggal','yyyy-mm-dd'),'$journalType') as dncn_num from dual";
					$num=DAO::queryRowSql($sql);
					$dncn_num=$num['dncn_num'];
					$model->dncn_num= $dncn_num;
					$model->curr_cd='IDR';
					$model->chrg_flg='N';
					$model->reversal_jur='N';
					$sql="select dflg1 from mst_sys_param where param_id='SYSTEM' and param_cd1='DOC_REF'";
					$cek=DAO::queryRowSql($sql);
					$sign=$cek['dflg1'];
					
					
					if($model->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
					
					if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->dncn_num,1) > 0)$success = true;
					else {
						$success = false;
					}
					
					//insert t_forder
					$modelfolder->fld_mon = DateTime::createFromFormat('Y-m-d',$model->dncn_date)->format('my');
					$modelfolder->folder_cd = $model->folder_cd;
					$modelfolder->doc_date = $model->dncn_date;
					$modelfolder->doc_num = $dncn_num;
					$modelfolder->user_id= $model->user_id;
					if($success && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_INS, $modelfolder->doc_num, $model->update_date, $model->update_seq, 1) > 0)$success = true;
					else {
						$success = false;
					}
					
					/*
					$sqlapproved="UPDATE T_MANY_DETAIL SET FIELD_VALUE='A' WHERE UPDATE_SEQ='$model->update_seq' and update_date='$model->update_date' 
					and field_name='APPROVED_STS' and table_name='T_DNCNH' and upd_status = 'I'";
					$updateapproved_sts=DAO::executeSql($sqlapproved);
					 */
					$recordSeq = 1;
					
					for($x=0; $success && $x<$rowCount ;$x++)
					{ 
						if($modeldetail[$x]->save_flg == 'Y'){
							
							$client=trim($modeldetail[$x]->sl_acct_cd);
							$gl_a=trim($modeldetail[$x]->gl_acct_cd);
							$sql_client="SELECT acct_type FROM MST_CLIENT c,mst_gl_account m WHERE client_cd = sl_a and sl_a='$client' and trim(gl_a)='$gl_a'";
							$client_cd=DAO::queryRowSql($sql_client);
							$acct_type = $client_cd['acct_type'];
							
							if($acct_type){
								$modeldetail[$x]->acct_type = $acct_type;
							}
						
							$modeldetail[$x]->tal_id=$recordSeq;
							$modeldetail[$x]->xn_doc_num=$model->dncn_num;
							$modeldetail[$x]->folder_cd=$model->folder_cd;
							$modeldetail[$x]->doc_date=$model->dncn_date;
							$modeldetail[$x]->due_date=$modeldetail[$x]->doc_date;
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
								
							if($success && $modeldetail[$x]->executeSp(AConstant::INBOX_STAT_INS,$modeldetail[$x]->xn_doc_num,$modeldetail[$x]->tal_id,$model->update_date,$model->update_seq,$recordSeq) > 0){
								$success = true;
							}else {
								$success = false;
							}
							$recordSeq++;
						}	
					}

					if($success){
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/finance/Tdncnh/index'));
					}else {
						$transaction->rollback();
					}
				}
			}
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->dncn_date))$model->dncn_date=DateTime::createFromFormat('Y-m-d',$model->dncn_date)->format('d/m/Y');	
		
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
		//header rev t_account_ledger adalah t_jvchh	
		 $modelRevJvch=new Tjvchh;	
		 
		$model=$this->loadModel($id);
		$oldmodel=$this->loadModel($id);
		$modeldetail = array();
		$oldmodeldetail=array();
		$oldmodeldetail=Taccountledger::model()->findAll("xn_doc_num='$id'");
		$modelreversal=Taccountledger::model()->findAll("xn_doc_num='$id'");
		$modelfolder=Tfolder::model()->find("doc_num='$id'");
		$modelfolderTAL = Taccountledger::model()->findAll("xn_doc_num = '$id' ");
		$gl_a1= Sysparam::model()->find("PARAM_ID='GL JOURNAL ENTRY' and param_cd1='UPDATE' AND PARAM_CD2='GL_ACCT'")->dnum1;
		$gl_a2= Sysparam::model()->find("PARAM_ID='GL JOURNAL ENTRY' and param_cd1='UPDATE' AND PARAM_CD2='GL_ACCT'")->dnum2;
		$model->scenario='update';
		
		$sign=Sysparam::model()->find("param_id='GL_JOURNAL_ENTRY' and param_cd1='DOC_REF'");
		$valid = false;
		$success = false;
		$upd_flag = false;
		
		$cancel_reason = '';
		
		$x = 0;
		$check = array();
		$oldPkId = array();
		if(DateTime::createFromFormat('Y-m-d H:i:s',$modelfolder->doc_date))$modelfolder->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$modelfolder->doc_date)->format('Y-m-d');
		
		if(isset($_POST['Tdncnh']))
		{ 
			$model->attributes=$_POST['Tdncnh'];
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
				$modeldetail[$x] = new Taccountledger;
				
				$modeldetail[$x]->attributes = $_POST['Taccountledger'][$x+1];
				$modeldetail[$x]->curr_val= str_replace( ',', '', $modeldetail[$x]->curr_val );
				
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
					$sql="select dflg1 from mst_sys_param where param_id='SYSTEM' and param_cd1='CHECK' AND PARAM_CD2='ACCTBRCH'";
					$dflg=DAO::queryRowSql($sql);
					$cek_branch = $dflg['dflg1'];
					
					if($cek_branch == 'Y'){
						$sl_acct_cd =trim($modeldetail[0]->sl_acct_cd);
						$gl=trim($modeldetail[$x]->gl_acct_cd);
						$sl=trim($modeldetail[$x]->sl_acct_cd);
						$query="SELECT brch_cd from mst_gl_account where sl_a= '$sl_acct_cd'";
						$getquery=DAO::queryRowSql($query);
						$branch=$getquery['brch_cd'];
						if($branch){
							$sqlbranch="SELECT brch_cd FROM MST_GL_ACCOUNT WHERE BRCH_CD= '$branch' and gl_a='$gl' and sl_a='$sl'";
							$cekAcct=DAO::queryRowSql($sqlbranch);
							
							if(!$cekAcct){
								$modeldetail[$x]->addError('gl_acct_cd','Harus dari branch yang sama');
								$valid=false;
								//break;
							}
						}
					}
					
					$valid = $modeldetail[$x]->validate() && $valid;
				}
				
			}
			
			
			if($valid)
			{ 
			
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
				$menuName = 'INTEREST JOURNAL ENTRY';
				if(DateTime::createFromFormat('Y-m-d H:i:s',$oldmodel->dncn_date))$oldmodel->dncn_date=DateTime::createFromFormat('Y-m-d H:i:s',$oldmodel->dncn_date)->format('Y-m-d');
				
				/*
				$queryJurnal="SELECT COUNT(*) AS rowjurnal from t_account_ledger where xn_doc_num='$model->dncn_num'";
				$countjur=DAO::queryRowSql($queryJurnal);
				$countJurnal=$countjur['rowjurnal'];
				*/
			
	 			$beda=false;
		
				for($x=0; $x<$rowCount; $x++)
				{	
				
					if($modeldetail[$x]->old_xn_doc_num){
						//$modeldetail[$x]->curr_val= str_replace( ',', '', $modeldetail[$x]->curr_val );
						if($oldmodel->dncn_date != $model->dncn_date || trim($modeldetail[$x]->gl_acct_cd) != trim($oldmodeldetail[$x]->gl_acct_cd) || trim($modeldetail[$x]->sl_acct_cd) != trim($oldmodeldetail[$x]->sl_acct_cd) ||
							$modeldetail[$x]->curr_val != $oldmodeldetail[$x]->curr_val || $modeldetail[$x]->db_cr_flg != $oldmodeldetail[$x]->db_cr_flg)
						{	
							$beda=true;
							break;	
						}	
					}
					if($oldmodel->curr_val != $model->curr_val){
						$beda=true;
						break;
					}
				
				}
				
				//CEK PERUBAHAN GL ACCOUNT
				for($x=0;$x<$rowCount; $x++)
				{
					if(isset($_POST['Taccountledger'][$x+1]['save_flg']) && $_POST['Taccountledger'][$x+1]['save_flg'] == 'Y')
					{
						if(trim($oldmodeldetail[$x]->gl_acct_cd) !=  trim($modeldetail[$x]->gl_acct_cd) &&
							(substr(trim($modeldetail[$x]->gl_acct_cd),0,1)== $gl_a1 || substr(trim($modeldetail[$x]->gl_acct_cd),0,1)== $gl_a2))
						{
							$beda=false;
							break;
						}
					}
				}		
				$DetailSafe=0;
				for($x=0;$x<$rowCount; $x++)
				{
					if(isset($_POST['Taccountledger'][$x+1]['save_flg']) && $_POST['Taccountledger'][$x+1]['save_flg'] == 'Y')
					{
						$DetailSafe++;		
					}
				}
			
				//execute SP header
				if($model->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName) > 0)$success = true;
				
				if($beda ){
					
					$success=FALSE;
					$model->addError('curr_cd','Hanya boleh mengubah description , GL Account ex: 5xxxx, 6xxxx dan File No. ');
					/*
					$oldmodel->update_date=$model->update_date;
					$oldmodel->update_seq=$model->update_seq;
					if($success && $oldmodel->executeSp(AConstant::INBOX_STAT_CAN,$model->dncn_num,2) > 0)$success = true;
					else {
						$success = false;
					}
					
					
					//get doc num header jurnal baru
					 $tanggal = $model->dncn_date;
					$journalType='';
					if($model->db_cr_flg=='D'){
						$journalType="DN";
					}else if($model->db_cr_flg=='C'){
						$journalType="CN";
					}
					//$sql="SELECT Get_Docnum_GL(to_date('$tanggal','yyyy-mm-dd'),'$journalType') as dncn_num from dual";
					$sql="SELECT Get_Docnum_Dcnote(to_date('$tanggal','yyyy-mm-dd'),'$journalType') as dncn_num from dual";
					$num=DAO::queryRowSql($sql);
					$dncn_num=$num['dncn_num'];
					$model->dncn_num = $dncn_num;
					
					if ($model->folder_cd != $modelfolder->folder_cd || $oldmodel->dncn_date != $model->dncn_date) {
                        
                        //cancel t_forder
                        if ($success && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_CAN, $id, $model->update_date, $model->update_seq, 1) > 0) $success = true;
                        else {
                            $success = false;
                        }
                        
                        //buat baru t folder
                        $modelfolder->fld_mon = DateTime::createFromFormat('Y-m-d', $model->dncn_date)->format('my');
                        $modelfolder->folder_cd = $model->folder_cd;
                        $modelfolder->doc_date = $model->dncn_date;
                        $modelfolder->doc_num = $dncn_num;
                        $modelfolder->user_id = $model->user_id;
                        if ($success && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_INS, $dncn_num, $model->update_date, $model->update_seq, 2) > 0) $success = true;
                        else {
                            $success = false;
                        }
                    }
					
					 //kepala jurnal terbaru
                    if ($success && $model->executeSp(AConstant::INBOX_STAT_INS, $dncn_num, 1) > 0) $success = true;
                    else {
                        $success = false;
                    }
					
					 //buat jurnal terbaru
                    $record_seq = 1;
                    for ($x = 0; $success && $x < $rowCount; $x++) {
                        if (($modeldetail[$x]->save_flg == 'Y' || $modeldetail[$x]->old_xn_doc_num != '') && $modeldetail[$x]->cancel_flg != 'Y') {
                            $client = trim($modeldetail[$x]->sl_acct_cd);
                            $gl_a = trim($modeldetail[$x]->gl_acct_cd);
                            $sql_client = "SELECT acct_type FROM MST_CLIENT c,mst_gl_account m WHERE client_cd = sl_a and sl_a='$client' and trim(gl_a)='$gl_a'";
                            $client_cd = DAO::queryRowSql($sql_client);
                            $acct_type = $client_cd['acct_type'];
                            if ($acct_type) {
                                $modeldetail[$x]->acct_type = $acct_type;
                            }
                            if ($sign == 'Y') {
                                $modeldetail[$x]->doc_ref_num = $modeldetail[$x]->xn_doc_num;
                            }
                            $modeldetail[$x]->xn_doc_num = $dncn_num;
                            $modeldetail[$x]->doc_date = $model->dncn_date;
                            $modeldetail[$x]->due_date = $model->dncn_date;
                            $modeldetail[$x]->folder_cd = $model->folder_cd;
                            $modeldetail[$x]->curr_cd = 'IDR';
                            $modeldetail[$x]->budget_cd = 'GL';
                            $modeldetail[$x]->reversal_jur = 'N';
                            $modeldetail[$x]->manual = 'Y';
                            $modeldetail[$x]->tal_id = $record_seq;
                            $modeldetail[$x]->xn_val = $modeldetail[$x]->curr_val;
                            
                            if ($success && $modeldetail[$x]->executeSp(AConstant::INBOX_STAT_INS, $dncn_num, $record_seq, $model->update_date, $model->update_seq, $record_seq) > 0) $success = true;
                            else {
                                $success = false;
                            }
                            
                            $record_seq++;
                        }
                    }

					 //GET FOLDER_CD REVERSAL
                   // $sql3 = "SELECT  GET_FOLDER_NUM_REVERSAL(to_date('$model->dncn_date','yyyy-mm-dd'),'RJ-','$dncn_num','$model->user_id') as folder_cd FROM DUAL";
					$sql3 = "SELECT  F_GET_FOLDER_NUM(to_date('$model->dncn_date','yyyy-mm-dd'),'RJ-') as folder_cd FROM DUAL";
                    $folder_cd = DAO::queryRowSql($sql3);
                    $folder_cd_rev = $folder_cd['folder_cd'];
					
					//buat header reversal
					$sql="SELECT Get_Docnum_GL(to_date('$tanggal','yyyy-mm-dd'),'GL') as dncn_num from dual";
					$num=DAO::queryRowSql($sql);
					$dncn_num=$num['dncn_num'];	
					
					//insert reversal header 
					 $modelRevJvch->jvch_num =$dncn_num;
					 $modelRevJvch->jvch_type='RE';
					 $modelRevJvch->curr_amt=$model->curr_val;
					 $modelRevJvch->curr_cd=$model->curr_cd;
					 $modelRevJvch->folder_cd=$folder_cd_rev;
					 $modelRevJvch->remarks=$model->ledger_nar;
					 $modelRevJvch->user_id=$model->user_id;
					 $modelRevJvch->update_seq=$model->update_seq;
					 $modelRevJvch->update_date=$model->update_date; 
					 $modelRevJvch->jvch_date = $oldmodel->dncn_date;
					 $modelRevJvch->reversal_jur = 'N';
					if(DateTime::createFromFormat('Y-m-d H:i:s',$modelRevJvch->jvch_date ))$modelRevJvch->jvch_date =DateTime::createFromFormat('Y-m-d H:i:s',$modelRevJvch->jvch_date)->format('Y-m-d');
		
					if($beda && $modelRevJvch->executeSp(AConstant::INBOX_STAT_INS,$dncn_num,1) > 0){
						$success = true;
					}
					else {
						$success = false;
					}
					
					//buat jurnal reversal -- modelreversal  
                    foreach ($modelreversal as $row) {
                        if (DateTime::createFromFormat('Y-m-d H:i:s', $row->doc_date)) $row->doc_date = DateTime::createFromFormat('Y-m-d H:i:s', $row->doc_date)->format('Y-m-d');
                        if (DateTime::createFromFormat('Y-m-d H:i:s', $row->due_date)) $row->due_date = DateTime::createFromFormat('Y-m-d H:i:s', $row->due_date)->format('Y-m-d');
                        $row->xn_doc_num = $dncn_num;
                        $row->folder_cd = $folder_cd_rev;
                        $row->budget_cd = 'GL';
                        $row->record_source = 'RE';
                        $row->xn_val = $row->curr_val;
                        $row->db_cr_flg = $row->db_cr_flg == 'D' ? 'C' : 'D';
                        if ($success && $row->executeSp(AConstant::INBOX_STAT_INS, $dncn_num, $row->tal_id, $model->update_date, $model->update_seq, $record_seq) > 0) $success = true;
                        else {
                            $success = false;
                        }
                        $record_seq++;
                    }
					 */
				}
				else{
					// JIKA TIDAK BUAT REVERSAL
	
                    if ($success && $model->executeSp(AConstant::INBOX_STAT_UPD, $model->dncn_num, 1) > 0) {
                        $success = true;
                    } 
                    else {
                        $success = false;
                    }
                    
                    $recordSeq = 1;
                    for ($x = 0; $x < $rowCount; $x++) {
                        
                        if ($modeldetail[$x]->save_flg == 'Y') {
                            if ($modeldetail[$x]->cancel_flg == 'Y') {
                            } 
                            else if ($modeldetail[$x]->old_xn_doc_num) {
                                
                                //kalau tidak beda
                                
                                $client=trim($modeldetail[$x]->sl_acct_cd);
								$gl_a=trim($modeldetail[$x]->gl_acct_cd);
								$sql_client="SELECT acct_type FROM MST_CLIENT c,mst_gl_account m WHERE client_cd = sl_a and sl_a='$client' and trim(gl_a)='$gl_a'";
								$client_cd=DAO::queryRowSql($sql_client);
								$acct_type = $client_cd['acct_type'];
								
								if($acct_type){
									$modeldetail[$x]->acct_type = $acct_type;
								}
							
                                $modeldetail[$x]->xn_doc_num = $modeldetail[$x]->old_xn_doc_num;
                                $modeldetail[$x]->reversal_jur = 'N';
                                $modeldetail[$x]->manual = 'Y';
                                $modeldetail[$x]->folder_cd= $model->folder_cd;
								$modeldetail[$x]->doc_date = $model->dncn_date;
								$modeldetail[$x]->due_date = $model->dncn_date;
								$modeldetail[$x]->xn_val = $modeldetail[$x]->curr_val;
								$modeldetail[$x]->budget_cd='GL';
								$modeldetail[$x]->curr_cd='IDR';
								if($sign == 'Y')
								{
									$modeldetail[$x]->doc_ref_num = $modeldetail[$x]->xn_doc_num;
								}
                                if ($success && $modeldetail[$x]->executeSp(AConstant::INBOX_STAT_UPD, $id, $modeldetail[$x]->old_tal_id, $model->update_date, $model->update_seq, $recordSeq) > 0) $success = true;
                                else {
                                    $success = false;
                                }
                                
                                //}
                                $recordSeq++;
                            }
                        }else{
                        	//echo "<script>alert('test')</script>";
							if($model->folder_cd != $modelfolder->folder_cd && $modeldetail[$x]->old_tal_id)
							{
								$old_tal_id=$modeldetail[$x]->old_tal_id;
								$modelfolderTAL=Taccountledger::model()->findAll("xn_doc_num='$id' and tal_id='$old_tal_id' ");
								
								foreach($modelfolderTAL as $row)
								{
									if(DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date))$row->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date)->format('Y-m-d');
									if(DateTime::createFromFormat('Y-m-d H:i:s',$row->due_date))$row->due_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->due_date)->format('Y-m-d');
									$row->folder_cd = $model->folder_cd;
									if($success && $row->executeSp(AConstant::INBOX_STAT_UPD,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
										else {
											$success = false;
										}
										$recordSeq++;
								}
							}
                        }
			
                    }//end loop
                    
                    //Jika beda folder code
                    if ($model->folder_cd != $modelfolder->folder_cd) {
                        
                        //insert t_forder
                        $modelfolder->folder_cd = $model->folder_cd;
                        $modelfolder->user_id = $model->user_id;
                        if ($success && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_UPD, $id, $model->update_date, $model->update_seq, 1) > 0) $success = true;
                        else {
                            $success = false;
                        }
						
                    } 
				}

				if($success){
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('/finance/Tdncnh/index'));
				}else {
					$transaction->rollback();
				}
			}

			if(DateTime::createFromFormat('Y-m-d',$model->dncn_date))$model->dncn_date=DateTime::createFromFormat('Y-m-d',$model->dncn_date)->format('d/m/Y');
			
		}else{
				
			$modeldetail = Taccountledger::model()->findAll(array('condition'=>"xn_doc_num = '$id'"));
			foreach($modeldetail as $row){
				$row->old_xn_doc_num=$row->xn_doc_num;
				$row->old_tal_id=$row->tal_id;
				$row->gl_acct_cd=trim($row->gl_acct_cd);
			}
		}
		if(DateTime::createFromFormat('Y-m-d H:i:s',$model->dncn_date))$model->dncn_date=DateTime::createFromFormat('Y-m-d H:i:s',$model->dncn_date)->format('d/m/Y');

		$this->render('update',array(
			'model'=>$model,
			'modeldetail'=>$modeldetail,
			'cancel_reason'=>$cancel_reason,
			'check'=>$check,
			'oldmodel'=>$oldmodel,
			'oldmodeldetail'=>$oldmodeldetail,
			'modelreversal'=>$modelreversal,
			'modelRevJvch'=>$modelRevJvch,
			'modelfolder' => $modelfolder,
			'modelfolderTAL'=>$modelfolderTAL
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
	      			AND rownum <= 15
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

	public function actionView($id)
	{	$model=$this->loadModel($id);
		$modeldetail = Taccountledger::model()->findAll("xn_doc_num = '$id' AND approved_sts = '".AConstant::INBOX_APP_STAT_APPROVE."'");	
		if(DateTime::createFromFormat('Y-m-d H:i:s',$model->dncn_date))$model->dncn_date=DateTime::createFromFormat('Y-m-d H:i:s',$model->dncn_date)->format('d M Y');
		$this->render('view',array(
			'model'=>$model,
			'modeldetail'=>$modeldetail,
		));
	}
	
	public function actionAjxPopDelete($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		$success = false;
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		$model1 = $this->loadModel($id);
	//	$model2 =$this->loadModel($id);
	
		$model2=new Tjvchh;
		
		$modelreversal=Taccountledger::model()->findAll("xn_doc_num='$id'");
		$oldjurnal=Taccountledger::model()->findAll("xn_doc_num='$id'");
		$modelfolder = Tfolder::model()->find("doc_num = '$id'");
		
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];	
					
			if($model->validate()){
				$model1->cancel_reason  = $model->cancel_reason;
				$model1->user_id = Yii::app()->user->id;
				$model1->ip_address = Yii::app()->request->userHostAddress;
				if($model1->ip_address=="::1")
					$model1->ip_address = '127.0.0.1';
				
				$menuName = 'INTEREST JOURNAL ENTRY';
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				
				if($model1->executeSpHeader(AConstant::INBOX_STAT_CAN,$menuName) > 0)$success = true;
				
				//get doc num reversal
				$tanggal=$model1->dncn_date;
				
				if(DateTime::createFromFormat('Y-m-d H:i:s',$tanggal))$tanggal=DateTime::createFromFormat('Y-m-d H:i:s',$tanggal)->format('Y-m-d');
				
				$sql="SELECT Get_Docnum_GL(to_date('$tanggal','yyyy-mm-dd'),'GL') as dncn_num from dual";
				$num=DAO::queryRowSql($sql);
				$dncn_num=$num['dncn_num'];	
						
				$p_user_id = Yii::app()->user->id;
				
				//GET FOLDER_CD REVERSAL
				//$sql3="SELECT  GET_FOLDER_NUM_REVERSAL(to_date('$tanggal','yyyy-mm-dd'),'RJ-','$dncn_num','$p_user_id') as folder_cd FROM DUAL";
				$sql3="SELECT  F_GET_FOLDER_NUM(to_date('$tanggal','yyyy-mm-dd'),'RJ-') as folder_cd FROM DUAL";
				$folder_cd=DAO::queryRowSql($sql3);
				$folder_cd_rev=$folder_cd['folder_cd'];
				
				$recordSeq=1;
				
				//insert reversal header 
				$model2->jvch_num=$dncn_num;
				$model2->jvch_type='RE';
				$model2->update_date= $model1->update_date;
				$model2->update_seq= $model1->update_seq;
				$model2->curr_amt=$model1->curr_val;
				$model2->curr_cd=$model1->curr_cd;
				$model2->folder_cd=$folder_cd_rev;
				$model2->remarks=$model1->ledger_nar;
				$model2->user_id=$model1->user_id;
				$model2->jvch_date = $model1->dncn_date;
				$model2->reversal_jur = 'N';
				if(DateTime::createFromFormat('Y-m-d H:i:s',$model2->jvch_date ))$model2->jvch_date =DateTime::createFromFormat('Y-m-d H:i:s',$model2->jvch_date)->format('Y-m-d');
				
				if($model2->executeSp(AConstant::INBOX_STAT_INS,$dncn_num,1) > 0){
					$success = true;
				}
				else {
					$success = false;
				}
				
				 foreach ($modelreversal as $row) {
                    if (DateTime::createFromFormat('Y-m-d H:i:s', $row->doc_date)) $row->doc_date = DateTime::createFromFormat('Y-m-d H:i:s', $row->doc_date)->format('Y-m-d');
                    if (DateTime::createFromFormat('Y-m-d H:i:s', $row->due_date)) $row->due_date = DateTime::createFromFormat('Y-m-d H:i:s', $row->due_date)->format('Y-m-d');
                    $row->xn_doc_num = $dncn_num;
                    $row->folder_cd = $folder_cd_rev;
                    $row->budget_cd = 'GL';
                    $row->record_source = 'RE';
                    $row->xn_val = $row->curr_val;
                    $row->db_cr_flg = $row->db_cr_flg == 'D' ? 'C' : 'D';
                    if ($success && $row->executeSp(AConstant::INBOX_STAT_INS, $dncn_num, $row->tal_id, $model2->update_date, $model2->update_seq, $recordSeq) > 0) $success = true;
                    else {
                        $success = false;
                    }
                    $recordSeq++;
                }
				
		
				if(DateTime::createFromFormat('Y-m-d H:i:s',$model1->dncn_date))$model1->dncn_date=DateTime::createFromFormat('Y-m-d H:i:s',$model1->dncn_date)->format('Y-m-d');
				
				
				if($success && $model1->executeSp(AConstant::INBOX_STAT_CAN,$id,1) > 0){
					 $success = TRUE;
				}
				else {
					 $success = false;
				}
				
				 //cancel t_forder
                if (DateTime::createFromFormat('Y-m-d H:i:s', $modelfolder->doc_date)) $modelfolder->doc_date = DateTime::createFromFormat('Y-m-d H:i:s', $modelfolder->doc_date)->format('Y-m-d');
                if ($success && $modelfolder->validate() && $modelfolder->executeSp(AConstant::INBOX_STAT_CAN, $id, $model1->update_date, $model1->update_seq, 1) > 0) $success = true;
                else {
                    $success = false;
                }
				
				if ($success) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', 'Successfully cancel ' . $model1->folder_cd);
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
			'is_successsave'=>$is_successsave,
			'modelfolder'=>$modelfolder		
		));
	}

	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}
	
	public function loadModel($id)
	{
		$model=Tdncnh::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	 
}
