<?php
//echo memory_get_usage();
class TbankmutationController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionAjxValidateBackDated() 
	{
		$resp = '';
		echo json_encode($resp);
	}
	
	public function actionIndex()
	{
		$model= array();
		$modelReport = new Rptuplrekdanamutasi('LAP_REKENING_DANA_MUTASI','RPT_UPL_REK_DANA_MUTASI','Rpt_rek_dana_mutasi.rptdesign');
		$modelUploadFail = new Rptbankmutationfail('BANK_MUTATION_FAIL', 'R_BANK_MUTATION_FAIL', 'Bank_Mutation_Fail.rptdesign');
		$modelDummyRpt = new Tbankmutation;
		$modeldummy=new Tbankmutation();
		$modelInterest = new Tbankmutation; 
		$cek_broker = Vbrokersubrek::model()->find()->broker_cd;
		$broker_cd = substr($cek_broker, 0,2);
		$valid = true;
		$success = false;
		$import_type;
		$filename = '';
		$from_dt='';
		$to_dt='';
		$type='';
		$branch='';
		$url='';
		$checkAll = false;
		$url_fail='';
		if(isset($_POST['scenario']))
		{ 
			if($_POST['scenario'] == 'import')
			{
				$modeldummy->scenario = 'upload';
				$modeldummy->attributes = $_POST['Tbankmutation'];
				
				if($modeldummy->validate())
				{
					
					$import_type = $modeldummy->import_type;
					$modeldummy->file_upload = CUploadedFile::getInstance($modeldummy,'file_upload');
					$path = FileUpload::getFilePath(FileUpload::T_BANK_MUTATION,'upload.txt' );
					$modeldummy->file_upload->saveAs($path);
					$filename = $modeldummy->file_upload;
					$lines = file($path);
					$sql1="select nvl(max(importseq),0) as importseq1 from t_bank_mutation
							where trunc(importdate) = trunc(sysdate)";
					$import=DAO::queryRowSql($sql1);
					$importseq=$import['importseq1'];	
					$bank_cd=Fundbank::model()->find("DEFAULT_FLG='Y'")->bank_cd;
					$success=FALSE;
					$importseq++;
					$tanggal_efektif='';
					foreach ($lines as $line_num => $line) 
					{
					 $data= $line;
					 $pieces = explode(';', $data);
					 $tanggal_efektif=$pieces[6];
					
					 if($modeldummy->validate()  && $modeldummy->executeSp($bank_cd, $importseq, $data)>0){
					 	$success =true;
					 }
					 else{
					 	$success=FALSE;
					 }
					//$importseq++;	
					}//end foreach
					//setelah di upload dan dibaca, delete file nya
					//unlink(FileUpload::getFilePath(FileUpload::T_BANK_MUTATION,$filename ));
					if($success)
					{
						$modelfile = new Tbankmutationfile;
						$modelfile->filename = $filename;
						$modelfile->cre_dt = date('Y-m-d H:i:s');
						$modelfile->file_year =date('Y');
						$modelfile->save();
						//10nov2016 untuk menghitung jumlah record yang fail per tanggalefektif dari text file
						 // where tanggalefektif=to_date('$tanggal_efektif','yyyymmdd')
						$sql = "select count(1) cnt from t_bank_mutation_fail where tanggalefektif=to_date('$tanggal_efektif','yyyymmdd')";
						$exec =DAO::queryRowSql($sql);
						
						$sql = "select count(1) cnt from t_bank_mutation where tanggalefektif=to_date('$tanggal_efektif','yyyymmdd')
								and importseq='$importseq' ";
						$exec_mutation =DAO::queryRowSql($sql);
						$count_new_mutation = $exec_mutation['cnt'];
						
						if(count($exec)>0)
						{
							Yii::app()->user->setFlash('danger', 'Uploaded : ('.$count_new_mutation .') new mutation, Failed : ('.$exec['cnt'].') Please Check Report Bank Mutation Failed');
							//$this->redirect(array('/finance/Rptbankmutationfail/index','eff_date'=>DateTime::createFromFormat('Ymd',$tanggal_efektif)->format('d/m/Y')));
								$modelUploadFail->eff_date = DateTime::createFromFormat('Ymd',$tanggal_efektif)->format('d/m/Y');
								if ($modelUploadFail->validate() && $modelUploadFail->executeRpt()> 0)
								{
									$rpt_link = $modelUploadFail->showReport();
									$url_fail = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
								}	
						}
						else
						{
							Yii::app()->user->setFlash('success', 'Successfully upload '.$filename);
						}

					
						//$this->redirect(array('/finance/tbankmutation/index'));
					}
				
				}
			}
			else if($_POST['scenario'] =='filter')
			{
				$modeldummy->scenario='filter';
				$modeldummy->attributes = $_POST['Tbankmutation'];
				if(DateTime::createFromFormat('d/m/Y',$modeldummy->from_dt))$modeldummy->from_dt=DateTime::createFromFormat('d/m/Y',$modeldummy->from_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('d/m/Y',$modeldummy->to_dt))$modeldummy->to_dt=DateTime::createFromFormat('d/m/Y',$modeldummy->to_dt)->format('Y-m-d');
				
				if($modeldummy->validate())
				{
					$from_dt=$modeldummy->from_dt;
					$to_dt=$modeldummy->to_dt;
					$type=$modeldummy->type_mutasi?$modeldummy->type_mutasi:'%';
					$branch=$modeldummy->branch?$modeldummy->branch:'All';
					$bank_rdi = $modeldummy->bank_rdi;
					$sql = "SELECT GET_DOC_DATE('1',to_date('$modeldummy->from_dt','yyyy-mm-dd')) FROM_DT_FUND, get_due_date('1',to_date('$modeldummy->to_dt','yyyy-mm-dd')) TO_DT_FUND FROM DUAL";
					$exec_sql = DAO::queryRowSql($sql);
					$from_dt_fund = $exec_sql['from_dt_fund'];
					$to_dt_fund = $exec_sql['to_dt_fund'];
					if(DateTime::createFromFormat('Y-m-d H:i:s',$from_dt_fund))$from_dt_fund=DateTime::createFromFormat('Y-m-d H:i:s',$from_dt_fund)->format('Y-m-d');
					if(DateTime::createFromFormat('Y-m-d H:i:s',$to_dt_fund))$to_dt_fund=DateTime::createFromFormat('Y-m-d H:i:s',$to_dt_fund)->format('Y-m-d');
		
					if(($type=='%' && $broker_cd !='YJ') || $modeldummy->type_mutasi =='S' || ($modeldummy->type_mutasi =='I' && $broker_cd !='YJ'))
					{	
						$model= Tbankmutation::model()->findAllBySql(Tbankmutation::getData($from_dt_fund, $to_dt_fund, $from_dt, $to_dt, $type, $branch, $bank_rdi));	
						
						if(count($model)=='0')
						{
							Yii::app()->user->setFlash('danger', 'No Data Found');
						}
						
					}
					else if($modeldummy->type_mutasi =='I' && $broker_cd =='YJ')
					{
						$modelDummyRpt = Tbankmutation::model()->findAllBySql($sql);		
						
						if(count($modelDummyRpt)=='0')
						{
							Yii::app()->user->setFlash('danger', 'No Data Found');
						}		
						else 
						{
							$user_id=Yii::app()->user->id;
							$x=0;
							$modelReport->vo_random_value = rand(1, 999999999);
							foreach($modelDummyRpt as $row)
							{
								$modelReport->tanggaltimestamp = $row->tanggaltimestamp;
								$modelReport->frombank = $row->frombank;
								$modelReport->instructionfrom = $row->instructionfrom;
								$modelReport->rdn = $row->rdn;
								$modelReport->branch = trim($row->branch_code);
								$modelReport->client_cd = $row->client_cd;
								$modelReport->client_name = $row->namanasabah;		
								$modelReport->beginningbalance = $row->beginningbalance;
								$modelReport->transactionvalue = $row->transactionvalue;
								$modelReport->closingbalance = $row->closingbalance;
								$modelReport->journal = $row->typetext;	
								if($modelReport->validate() && $modelReport->executeRpt()>0)
								
								$rand_value[]=$modelReport->vo_random_value;
								$x++;		
							}
							$url = $modelReport->showReport();	
						}
					}//end interest
				}//end validate
				
				foreach($model as $row)
				{
					$row->client_name = $row->namanasabah;
					$row->tgl_time =  $row->tanggaltimestamp;//Y-M-D H:I:S
					if(DateTime::createFromFormat('Y-m-d H:i:s',$row->tanggaltimestamp))$row->tanggaltimestamp=DateTime::createFromFormat('Y-m-d H:i:s',$row->tanggaltimestamp)->format('d/m/Y H:i');
					if(DateTime::createFromFormat('Y-m-d H:i:s',$row->tanggalefektif))$row->tanggalefektif=DateTime::createFromFormat('Y-m-d H:i:s',$row->tanggalefektif)->format('d/m/Y');
					if ($row->transactiontype =='NTAX' || $row->transactiontype =='NINT')
					{
						$row->safe_flg = 'Y';
						$checkAll = TRUE;
					}
				}			
			}//end filter
			else if($_POST['scenario'] =='print')
			{
				$modeldummy->scenario='filter';
				$modeldummy->attributes = $_POST['Tbankmutation'];
				
				if(DateTime::createFromFormat('d/m/Y',$modeldummy->from_dt))$modeldummy->from_dt=DateTime::createFromFormat('d/m/Y',$modeldummy->from_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('d/m/Y',$modeldummy->to_dt))$modeldummy->to_dt=DateTime::createFromFormat('d/m/Y',$modeldummy->to_dt)->format('Y-m-d');
				if($modeldummy->validate())
				{
					$from_dt=$modeldummy->from_dt;
					$to_dt=$modeldummy->to_dt;
					$type=$modeldummy->type_mutasi?$modeldummy->type_mutasi:'%';
					$branch=$modeldummy->branch?$modeldummy->branch:'All';
					$bank_rdi = $modeldummy->bank_rdi;
					$sql = "SELECT GET_DOC_DATE('1',to_date('$modeldummy->from_dt','yyyy-mm-dd')) FROM_DT_FUND, get_due_date('1',to_date('$modeldummy->to_dt','yyyy-mm-dd')) TO_DT_FUND FROM DUAL";
					$exec_sql = DAO::queryRowSql($sql);
					$from_dt_fund = $exec_sql['from_dt_fund'];
					$to_dt_fund = $exec_sql['to_dt_fund'];
					if(DateTime::createFromFormat('Y-m-d H:i:s',$from_dt_fund))$from_dt_fund=DateTime::createFromFormat('Y-m-d H:i:s',$from_dt_fund)->format('Y-m-d');
					if(DateTime::createFromFormat('Y-m-d H:i:s',$to_dt_fund))$to_dt_fund=DateTime::createFromFormat('Y-m-d H:i:s',$to_dt_fund)->format('Y-m-d');
					
					$modelDummyRpt= Tbankmutation::model()->findAllBySql(Tbankmutation::getData($from_dt_fund, $to_dt_fund, $from_dt, $to_dt, $type, $branch, $bank_rdi)); 						
				
					if(count($modelDummyRpt)==0)
					{
						Yii::app()->user->setFlash('danger', 'No Data Found');
					}
					else
					{
						$user_id=Yii::app()->user->id;
						$x=0;
						//$rand_value=array();
						$modelReport->vo_random_value = rand(1, 999999999);
						foreach($modelDummyRpt as $row)
						{
							$modelReport->tanggaltimestamp = $row->tanggaltimestamp;
							$modelReport->frombank = $row->frombank;
							$modelReport->instructionfrom = $row->instructionfrom;
							$modelReport->rdn = $row->rdn;
							$modelReport->branch = trim($row->branch_code);
							$modelReport->client_cd = $row->client_cd;
							$modelReport->client_name = $row->namanasabah;		
							$modelReport->beginningbalance = $row->beginningbalance;
							$modelReport->transactionvalue = $row->transactionvalue;
							$modelReport->closingbalance = $row->closingbalance;
							$modelReport->journal = $row->typetext;	
							
							if($modelReport->validate() && $modelReport->executeRpt()>0)
							{
								//$url = $modelReport->showReport();
							}	
							$rand_value[]=$modelReport->vo_random_value;
						$x++;		
						}
						//$modelReport->vo_random_value=1;
						$url = $modelReport->showReport();		
					}
				}//end validate	
			}//end print
			else //Journal
			{
				//Membuat Jurnal
				$rowCount = $_POST['rowCount'];
				$x;
				$save_flag = false; //False if no record is saved
				$modeldummy->attributes = $_POST['Tbankmutation'];
				
				if(($modeldummy->type_mutasi=='' && $broker_cd !='YJ') ||$modeldummy->type_mutasi =='S' || ($modeldummy->type_mutasi =='I' && $broker_cd != 'YJ'))
				{
					for($x=0;$x<$rowCount;$x++)
					{
						$model[$x] = new Tbankmutation;
						$model[$x]->attributes = $_POST['Tbankmutation'][$x+1];
						if(DateTime::createFromFormat('d/m/Y',$model[$x]->tanggalefektif))$model[$x]->tanggalefektif =DateTime::createFromFormat('d/m/Y',$model[$x]->tanggalefektif)->format('Y-m-d');
						$ip = Yii::app()->request->userHostAddress;
						if($ip=="::1")
							$ip = '127.0.0.1';
						$model[$x]->ip_address = $ip;
						$model[$x]->user_id =  Yii::app()->user->id;
						
						if(isset($_POST['Tbankmutation'][$x+1]['safe_flg']) && $_POST['Tbankmutation'][$x+1]['safe_flg'] == 'Y')
						{
							$save_flag = true;
							//INSERT
							$model[$x]->scenario = 'insert';
							$valid = $model[$x]->validate() && $valid;		
							$authorizedBackDated = $_POST['authorizedBackDated'];
			
							if(!$authorizedBackDated)
							{
								$currMonth = date('Ym');
								$docMonth = DateTime::createFromFormat('Y-m-d',$model[$x]->tanggalefektif)->format('Ym');
								
								if($docMonth < $currMonth)
								{
									Yii::app()->user->setFlash('danger', 'You are not authorized to journal last month date ');
									$valid = FALSE;
								}
							}
					
							$amt = $model[$x]->transactionvalue;
							$client_cd = $model[$x]->client_cd;
							$doc_date =  $model[$x]->tanggalefektif;
							$bank_mvmt_date = DateTime::createFromFormat('Y-m-d H:i:s',$model[$x]->tgl_time)->format('Y/m/d H:i:s');
							$bankrefence = $model[$x]->bankreference;
							//cek masih ada belum diapprove
		               	 	 $cek =Tmanydetail::model()->findAllBySql(Tbankmutation::getCekUnapprove($amt, $client_cd, $doc_date, $bankrefence, $bank_mvmt_date));
			                 if($cek)
			                 {
			                 	Yii::app()->user->setFlash('danger', 'Masih ada belum diapprove');	
								$valid = FALSE;
			                 }   
						}	
					}//end loop
					$valid = $valid && $save_flag;	
				}// type setoran
				else if($modeldummy->type_mutasi =='I' && $broker_cd == 'YJ')
				{
						$valid = TRUE;	
				}
		
				if($valid)
				{
					$success = true;
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					$menuName = 'UPLOAD RDN MUTATION';
					/**
					 * Untuk YJ terdapat 2 type yang akan dijurnal yaitu I dan S dan untuk PF/MU 1 aja, yaitu Mutasi(M) dalam mutasi
					 * di MU/PF tersebut sudah termasuk Setoran(S)/ Interest/Tax (I)
					 * DI YJ Interest pada saat diretrive tidak dimunculin karena banyak sedangkan di PF/MU dimunculin
					 */
					if(($modeldummy->type_mutasi=='' && $broker_cd !='YJ') || $modeldummy->type_mutasi =='S' || ($modeldummy->type_mutasi =='I' && $broker_cd != 'YJ'))
					{	
						for($x=0;$success && $x<$rowCount;$x++)
						{ 		
							if($model[$x]->safe_flg == 'Y')
							{	
								if($model[$x]->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
								
								if($model[$x]->typetext=='Setoran' || $model[$x]->typetext=='Koreksi' || $model[$x]->typetext=='Interest' || $model[$x]->typetext=='Tax')
								{
									//INSERT Type Mutasi Setoran
									if($success && $model[$x]->executeSpInbox(AConstant::INBOX_STAT_INS,1) > 0)$success = true; 
									else {
										$success = false;
									}
								}
							}	
						}//end loop
					}
					else if($modeldummy->type_mutasi =='I' && $broker_cd =='YJ')
					{
						//execute sp header
						//if($modeldummy->validate() && $modeldummy->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
						if(DateTime::createFromFormat('d/m/Y',$modeldummy->from_dt))$modeldummy->from_dt=DateTime::createFromFormat('d/m/Y',$modeldummy->from_dt)->format('Y-m-d');
						if(DateTime::createFromFormat('d/m/Y',$modeldummy->to_dt))$modeldummy->to_dt=DateTime::createFromFormat('d/m/Y',$modeldummy->to_dt)->format('Y-m-d');
						$modelInterest->from_dt = $modeldummy->from_dt;
						$modelInterest->to_dt = $modeldummy->to_dt;
						$modelInterest->branch = $modeldummy->branch?$modeldummy->branch:'All';
						$modelInterest->type_mutasi = $modeldummy->type_mutasi;
						$modelInterest->bank_rdi = $modeldummy->bank_rdi;
						$sql = "SELECT GET_DOC_DATE('1',to_date('$modelInterest->from_dt','yyyy-mm-dd')) FROM_DT_FUND, get_due_date('1',to_date('$modelInterest->to_dt','yyyy-mm-dd')) TO_DT_FUND FROM DUAL";
						$exec_sql = DAO::queryRowSql($sql);
						$from_dt_fund = $exec_sql['from_dt_fund'];
						$to_dt_fund = $exec_sql['to_dt_fund'];
						if(DateTime::createFromFormat('Y-m-d H:i:s',$from_dt_fund))$from_dt_fund=DateTime::createFromFormat('Y-m-d H:i:s',$from_dt_fund)->format('Y-m-d');
						if(DateTime::createFromFormat('Y-m-d H:i:s',$to_dt_fund))$to_dt_fund=DateTime::createFromFormat('Y-m-d H:i:s',$to_dt_fund)->format('Y-m-d');
						$modelInterest->update_date =$modeldummy->update_date;
						$modelInterest->update_seq = $modeldummy->update_seq;
						$modelInterest->user_id = Yii::app()->user->id;
						if($success && $modelInterest->validate() && $modelInterest->executeInterest($menuName,$from_dt_fund,$to_dt_fund)>0)
						{
							$success = TRUE;
						}
						else
						{
							$success =FALSE;
						}
					}//end type I
					if(($success && $modeldummy->type_mutasi =='I') || ($rowCount>0 && $modeldummy->type_mutasi =='' && $broker_cd !='YJ')  || ($rowCount>0 && $modeldummy->type_mutasi =='S') || ($rowCount>0 && $modeldummy->type_mutasi =='M'))
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('index'));
					}
					else 
					{
						$transaction->rollback();
					}
				}
			}	
		}
		else
		{			
			$branch='All';
			$bank_name = Fundbank::model()->find("default_flg ='Y'")->bank_name;
			//set from date		
			$sql="select get_doc_date(1,trunc(sysdate)) as from_date from dual";
			$date = DAO::queryRowSql($sql);
			$from_date = $date['from_date'];
			
			$today_dt= date('Y-m-d');
			$from_dt = $broker_cd=='YJ'?$today_dt:DateTime::createFromFormat('Y-m-d H:i:s',$from_date)->format('Y-m-d');
			$to_dt = $today_dt;
			$sql = "SELECT GET_DOC_DATE('1',to_date('$today_dt','yyyy-mm-dd')) FROM_DT_FUND, get_due_date('1',to_date('$today_dt','yyyy-mm-dd')) TO_DT_FUND FROM DUAL";
			$exec_sql = DAO::queryRowSql($sql);
			$from_dt_fund = $exec_sql['from_dt_fund'];
			$to_dt_fund = $exec_sql['to_dt_fund'];
			if(DateTime::createFromFormat('Y-m-d H:i:s',$from_dt_fund))$from_dt_fund=DateTime::createFromFormat('Y-m-d H:i:s',$from_dt_fund)->format('Y-m-d');
			if(DateTime::createFromFormat('Y-m-d H:i:s',$to_dt_fund))$to_dt_fund=DateTime::createFromFormat('Y-m-d H:i:s',$to_dt_fund)->format('Y-m-d');
			$branch ='All';
			$type =$broker_cd=='YJ'?'S':'%';
			$bank_rdi =Fundbank::model()->find("default_flg = 'Y'")->bank_cd;
			$model= Tbankmutation::model()->findAllBySql(Tbankmutation::getData($from_dt_fund, $to_dt_fund, $from_dt, $to_dt, $type, $branch, $bank_rdi));			
		
			foreach($model as $row)
			{
				$row->client_name = $row->namanasabah;
				$row->tgl_time =  $row->tanggaltimestamp;//Y-M-D H:I:S
				if(DateTime::createFromFormat('Y-m-d H:i:s',$row->tanggaltimestamp))$row->tanggaltimestamp=DateTime::createFromFormat('Y-m-d H:i:s',$row->tanggaltimestamp)->format('d/m/Y H:i');
				if(DateTime::createFromFormat('Y-m-d H:i:s',$row->tanggalefektif))$row->tanggalefektif=DateTime::createFromFormat('Y-m-d H:i:s',$row->tanggalefektif)->format('d/m/Y');
				if ($row->transactiontype =='NTAX' || $row->transactiontype =='NINT')
				{
					$row->safe_flg = 'Y';
					$checkAll = TRUE;
				}
			}	
			
			
			$modeldummy=new Tbankmutation();
			$modeldummy->from_dt= $broker_cd=='YJ'?date('d/m/Y'):DateTime::createFromFormat('Y-m-d H:i:s', $from_date)->format('d/m/Y');
			$modeldummy->to_dt=date('d/m/Y');
			$modeldummy->type_mutasi=$broker_cd=='YJ'?'S':'%';
			$modeldummy->bank_rdi = Fundbank::model()->find("default_flg ='Y'")->bank_cd;
		}
		

		if(DateTime::createFromFormat('Y-m-d',$modeldummy->from_dt))$modeldummy->from_dt=DateTime::createFromFormat('Y-m-d',$modeldummy->from_dt)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$modeldummy->to_dt))$modeldummy->to_dt=DateTime::createFromFormat('Y-m-d',$modeldummy->to_dt)->format('d/m/Y');
		
		$this->render('index',array('model'=>$model,
									'modeldummy'=>$modeldummy,
									'from_dt'=>$from_dt,
									'to_dt'=>$to_dt,
									'type'=>$type,
									'branch'=>$branch,
									'url'=>$url,
									'modelReport'=>$modelReport,
									'checkAll'=>$checkAll,
									'modelInterest'=>$modelInterest,
									'modelUploadFail'=>$modelUploadFail,
									'url_fail'=>$url_fail
									));
	}

 
  
  /*
public function printReport($from_dt,$to_dt,$type,$branch,$bank_rdi)
{
				$from_dt_fund = $this->cek_date_bursa($modeldummy->from_dt, 'F');
				$to_dt_fund =$this->cek_date_bursa($modeldummy->to_dt, 'T');
				
				$sql="SELECT X.* FROM (
					SELECT  a.tanggalefektif,  a.TANGGALTimestamp, a.currency, a.InstructionFrom, a.RDN, c.branch_code, c.client_cd, c.client_name,a.namanasabah, 
					                a.BEGINNINGBALANCE, a.TRANSACTIONVALUE, a.CLOSINGBALANCE , a.BANKREFERENCE, 'N' Jurnal, b.cnt , 
					 a.bankid, a.transactiontype, f.descrip TYPETEXT , 	a.remark, f.descrip default_remark,a.typemutasi ,b.acct_stat,
					         DECODE(a.transactiontype,'NINT',f.ip_bank_cd,'NTAX',f.ip_bank_cd,DECODE(a.InstructionFrom,'0000000000','XXX',f.ip_bank_cd)) frombank 
					
					FROM(	SELECT NVL(bank_ref_num,'X') bank_ref_num, fund_bank_acct AS BANK_ACCT_NUM, doc_Date,    sl_acct_cd 
						    FROM T_FUND_MOVEMENT a 
						WHERE doc_date BETWEEN to_date('$from_dt_fund','yyyy-mm-dd') AND  to_date('$to_dt_fund','yyyy-mm-dd')
						AND source = 'MUTASI'
						AND approved_sts <> 'C'
						) d, 
					     ( SELECT  a.*				
					        FROM T_BANK_MUTATION a,
					          (SELECT REPLACE(REPLACE(bank_acct_cd,'-',''),'.','')  pe_bank_acct
					                 FROM MST_BANK_ACCT 
					                                   WHERE  bank_acct_cd <> 'X') b
					        WHERE a.TanggalEfektif BETWEEN to_date('$from_dt','yyyy-mm-dd') AND to_date('$to_dt','yyyy-mm-dd') 
					        AND a.InstructionFrom = pe_bank_acct(+)
					        AND pe_bank_acct IS NULL
						 ) a, 
					             ( 
						SELECT BANK_ACCT_NUM, MAX(client_cd) AS client_cd, COUNT(1) AS cnt,acct_stat 
						FROM 	MST_CLIENT_FLACCT 
						WHERE acct_stat IN ('A','C')
						GROUP BY BANK_ACCT_NUM,acct_stat
						) b, 
					            ( SELECT client_cd, client_name, 
						            DECODE(trim(rem_cd),'LOT','LO',DECODE(trim(MST_CLIENT.olt),'N',trim(branch_code),'LO')) branch_finan, 
						            branch_code 
						FROM MST_CLIENT ) c, 
					             ( 	SELECT t.rdi_trx_type, t.descrip, t.grp, f.ip_bank_cd, t.db_cr_flg 
						   FROM MST_RDI_TRX_TYPE t, MST_FUND_BANK f 
						   WHERE t.fund_bank_cd = f.bank_cd 
						   AND t.grp like '%$type'
						   ) f 
					WHERE  a.transactiontype LIKE f.rdi_trx_type 
					AND a.typemutasi = f.db_Cr_flg 
					AND b.client_cd = c.client_cd 
					AND a.BANKREFERENCE = d.bank_ref_num(+) 
					AND  d.bank_ref_num IS NULL 
					AND a.rdn = b.BANK_ACCT_NUM 
					AND a.rdn = d.BANK_ACCT_NUM(+) 
					AND d.BANK_ACCT_NUM IS NULL 
					
					AND d.doc_date IS NULL 
					AND a.transactiontype = d.sl_acct_cd(+) 
					AND d.sl_acct_cd IS NULL 
					AND ('$branch' = 'All' 
					     OR  INSTR('$branch',trim(branch_finan)) > 0))X
					   where bankid like '%$bank_rdi'  
					 ORDER BY client_cd,tanggaltimestamp DESC";								
			$modelDummyRpt=Tbankmutation::model()->findAllBySql($sql);	
				
				if(count($modelDummyRpt)==0){
					Yii::app()->user->setFlash('danger', 'No Data Found');
				}
			else{
					$user_id=Yii::app()->user->id;
							
			
				$x=0;
				//$rand_value=array();
				$modelReport->vo_random_value = rand(1, 999999999);
				foreach($modelDummyRpt as $row)
				{
					$modelReport->tanggaltimestamp = $row->tanggaltimestamp;
					$modelReport->frombank = $row->frombank;
					$modelReport->instructionfrom = $row->instructionfrom;
					$modelReport->rdn = $row->rdn;
					$modelReport->branch = trim($row->branch_code);
					$modelReport->client_cd = $row->client_cd;
					$modelReport->client_name = $row->namanasabah;		
					$modelReport->beginningbalance = $row->beginningbalance;
					$modelReport->transactionvalue = $row->transactionvalue;
					$modelReport->closingbalance = $row->closingbalance;
					$modelReport->journal = $row->typetext;	
					
					
					if($modelReport->validate() && $modelReport->executeRpt())
					{
						//$url = $modelReport->showReport();
					}	
					
					$rand_value[]=$modelReport->vo_random_value;
				$x++;		
				}
				//$modelReport->vo_random_value=1;
				$url = $modelReport->showReport();		
					
				
			}
			return $url;
}	
*/
 /*
 public function cek_date_bursa($date,$date_flg)
	{
	$date_bursa='';
	if($date_flg == 'F')
	{
		
			//$from_dt_fund = DateTime::createFromFormat('d/m/Y',$date)->format('Y-m-d');	
			$from_dt_fund = date('Y-m-d',strtotime("$date -1 day"));
			
			
			$date_holiday = DateTime::createFromFormat('Y-m-d',$from_dt_fund)->format('D');
						
						if($date_holiday =='Sat'){
							$from_dt_fund = date('Y-m-d',strtotime("$from_dt_fund -1 day"));
						}
						else if($date_holiday == 'Sun'){
							$from_dt_fund = date('Y-m-d',strtotime("$from_dt_fund -2 day"));
						}
						else if($date_holiday == 'Mon'){
							$from_dt_fund = date('Y-m-d',strtotime("$from_dt_fund -3 day"));
						}
						
			
			$cek = Calendar::model()->find("tgl_libur = to_date('$from_dt_fund','yyyy-mm-dd')");
			
			while ($cek){
				
				$from_dt_fund = date('Y-m-d',strtotime("$from_dt_fund -1 day"));
				$date_holiday = DateTime::createFromFormat('Y-m-d',$from_dt_fund)->format('D');
			
			if($date_holiday =='Sat'){
				$from_dt_fund = date('Y-m-d',strtotime("$from_dt_fund -1 day"));
			}
			else if($date_holiday == 'Sun'){
				$from_dt_fund = date('Y-m-d',strtotime("$from_dt_fund -2 day"));
			}
			else if($date_holiday == 'Mon'){
				$from_dt_fund = date('Y-m-d',strtotime("$from_dt_fund -3 day"));
			}
				$cek = Calendar::model()->find("tgl_libur = to_date('$from_dt_fund','yyyy-mm-dd')");
			}
			 
			
			$date_bursa=$from_dt_fund;
	}
	else if($date_flg == 'T')
	{
			//$to_dt_fund = DateTime::createFromFormat('d/m/Y',$date)->format('Y-m-d');	
			$to_dt_fund = date('Y-m-d',strtotime("$date +1 day"));
			
			$date_holiday = DateTime::createFromFormat('Y-m-d',$to_dt_fund)->format('D');
						
						if($date_holiday =='Sat'){
							$to_dt_fund = date('Y-m-d',strtotime("$to_dt_fund +2 day"));
						}
						else if($date_holiday == 'Sun'){
							$to_dt_fund = date('Y-m-d',strtotime("$to_dt_fund +1 day"));
						}
						else if($date_holiday == 'Fri'){
							$to_dt_fund = date('Y-m-d',strtotime("$to_dt_fund +3 day"));
						}
			
			
			$cek = Calendar::model()->find("tgl_libur = to_date('$to_dt_fund','yyyy-mm-dd')");
			
			while ($cek){
				
				$to_dt_fund = date('Y-m-d',strtotime("$to_dt_fund +1 day"));
				$date_holiday = DateTime::createFromFormat('Y-m-d',$to_dt_fund)->format('D');
			
			if($date_holiday =='Sat'){
				$to_dt_fund = date('Y-m-d',strtotime("$to_dt_fund +2 day"));
			}
			else if($date_holiday == 'Sun'){
				$to_dt_fund = date('Y-m-d',strtotime("$to_dt_fund +1 day"));
			}
			else if($date_holiday == 'Fri'){
				$to_dt_fund = date('Y-m-d',strtotime("$to_dt_fund +3 day"));
			}
				$cek = Calendar::model()->find("tgl_libur = to_date('$to_dt_fund','yyyy-mm-dd')");
			}
			$date_bursa = $to_dt_fund;
	}
	
	if(DateTime::createFromFormat('d/m/Y',$date_bursa))$date_bursa=DateTime::createFromFormat('d/m/Y',$date_bursa)->format('Y-m-d');
	return $date_bursa;
			
	}
*/

}

