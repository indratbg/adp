<?php

class GeneraterepointerestController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';


	public function actionCreate()
	{	$success = false;
		$modelfilter=new Vgeneraterepointjur;
		$model= array();
		$modelledger=array();
		$modelrepo=array();
		$modelheader=array();
		$modeltrepovch = array();
		$modelfolder= array();
		$success=true;
		
		$folder = Sysparam::model()->find("param_id='SYSTEM' and param_cd1='VCH_REF'")->dflg1;
		$sign_ref =Sysparam::model()->find("param_id='SYSTEM' and param_cd1='DOC_REF'")->dflg1;
		if(isset($_POST['scenario'])){
		$scenario = $_POST['scenario'];
				if($scenario == 'filter'){
					$modelfilter->attributes = $_POST['Vgeneraterepointjur'];
					
					$firstDay=date('Y-01-01',strtotime("first day of this year"));
					$year_end =date('Y-12-31');
					$end_date = $modelfilter->jur_date;
					//if year end
						$cek2=Sysparam::model()->find("param_id = 'W_JUR_REPO_INTEREST' and param_Cd1 = 'YEAREND'")->dnum1;
					if($modelfilter->jurnal_type == '0'){
										
					for($x=0;$x<5;$x++){
					if(DateTime::createFromFormat('Y-m-d',$firstDay))$firstDay=DateTime::createFromFormat('Y-m-d',$firstDay)->format('d/m/Y');
					
					
					$query="select f_is_holiday('$firstDay') AS LIBUR FROM DUAL ";
					$source = DAO::queryRowSql($query);
					$cek=$source['libur'];
					
					if($cek == '1'){
						if(DateTime::createFromFormat('d/m/Y',$firstDay))$firstDay=DateTime::createFromFormat('d/m/Y',$firstDay)->format('Y-m-d');
						$firstDay = date('Y-m-d',strtotime("$firstDay +1 days"));
						
					}
					
					
					}
					
					if($cek2 == '1'){
						$year_end = date('Y-01-01');
					}
					else{
						$year_end = date('Y-m-d',strtotime("$year_end -1 years"));
					}
					
					$end_date = $modelfilter->jur_date;
					
					}
					else{//jurnal year end
						
						$date = DateTime::createFromFormat('d/m/Y',$modelfilter->jur_date)->format('Y-m-t');
					if($cek2 == '1'){
						$year_end = date('Y-m-d',strtotime($date."+1 day"));
					}
					else{
						$year_end = $date;
					}
					$firstDay = date('Y-01-02');
					//$firstDay = date('Y-m-d', strtotime($firstDay."-1 year"));
					$end_date = $year_end;
					
					}
					
				
					
					if(DateTime::createFromFormat('Y-m-d',$firstDay))$firstDay=DateTime::createFromFormat('Y-m-d',$firstDay)->format('d/m/Y');
					if(DateTime::createFromFormat('Y-m-d',$year_end))$year_end=DateTime::createFromFormat('Y-m-d',$year_end)->format('d/m/Y');
					if(DateTime::createFromFormat('Y-m-d',$end_date))$end_date=DateTime::createFromFormat('Y-m-d',$end_date)->format('d/m/Y');
					//var_dump($firstDay);die();
					
			$model = Vgeneraterepointjur::model()->findAllBySql("SELECT repo_num,
					  repo_type,
					  repo_ref,
					  client_cd,
					  repo_date,
					  due_date,
					  repo_val,
					  interest_rate,
					  days,
					  int_amt,
					  ROUND( int_amt / (100 - interest_tax) * 100,0) int_aft_tax,
					  ROUND( int_amt / (100 - interest_tax) * 100,0) - int_amt AS int_tax_amt,
					  'Y' jur_flg,
					  '' folder_cd
					FROM
					  (SELECT a.repo_num,
					    a.repo_type,
					    a.repo_ref,
					    a.client_cd,
					    a.repo_date,
					    a.due_date,
					    a.interest_tax,
					    a.repo_val,
					    a.interest_rate,
					    NVL( B.days,to_date('$end_date','dd/mm/yyyy')                     - a.repo_date) days,
					    DECODE(to_date('$end_date','dd/mm/yyyy'),a.due_date, a.return_val - a.repo_val- NVL(b.accum_int,0), ROUND(NVL(b.days,to_date('$end_date','dd/mm/yyyy') - a.repo_date) * a.repo_val * a.interest_rate /100 / 360, 0) ) AS int_amt
					  FROM
					    (SELECT h.repo_num,
					      h.repo_type,
					      d.repo_ref,
					      d.repo_date,
					      d.due_date,
					      d.repo_val,
					      d.return_val,
					      h.client_cd,
					      d.interest_rate,
					      d.interest_tax
					    FROM T_REPO h,
					      T_REPO_HIST d
					    WHERE h.sett_val    > 0
					    AND h.sett_val      < h.return_val
					    AND d.interest_rate > 0
					    AND h.repo_num      = d.REPO_NUM
					    AND h.extent_dt     = d.repo_date
					    ) a,
					    (SELECT h.repo_num                                                                 AS repo_num,
					      SUM(DECODE(t.db_Cr_flg,'D',1,                                                                                        -1) * DECODE( t.doc_date,h.extent_dt,0,t.curr_val)) AS accum_int,
					      DECODE(to_date('$end_date','dd/mm/yyyy'),to_date('$firstDay','dd/mm/yyyy'),to_date('$end_date','dd/mm/yyyy') - to_date('$year_end','dd/mm/yyyy'), to_date('$end_date','dd/mm/yyyy') - NVL(MAX(t.doc_date) , H.extent_dt)) DAYS
					    FROM T_REPO h,
					      T_REPO_VCH d,
					      T_ACCOUNT_LEDGER t,
					      MST_GLA_TRX v
					    WHERE h.sett_val > 0
					    AND h.sett_val   < h.return_val
					    AND h.repo_num   = d.REPO_NUM
					    AND to_date('$end_date','dd/mm/yyyy') BETWEEN h.extent_dt + 1 AND h.due_date
					    AND t.doc_date BETWEEN h.extent_dt AND to_date('$end_date','dd/mm/yyyy')
					    AND t.approved_sts <> 'C'
					    AND t.budget_cd     = 'INTREPO'
					    AND v.jur_type     = 'REPO'
					    AND t.reversal_jur  ='N'
					    AND t.gl_acct_cd    = v.gl_a
					    AND t.sl_acct_cd    = h.client_cd
					    AND t.xn_doc_num    = d.doc_num
					    GROUP BY h.repo_num,
					      H.extent_dt
					    ) b
					  WHERE a.repo_num = b.repo_num(+)
					  )
					WHERE days > 0");
				
				foreach($model as $row){
			if(DateTime::createFromFormat('Y-m-d H:i:s',$row->repo_date))$row->repo_date= DateTime::createFromFormat('Y-m-d H:i:s',$row->repo_date)->format('d/m/Y');		
			if(DateTime::createFromFormat('Y-m-d H:i:s',$row->due_date))$row->due_date= DateTime::createFromFormat('Y-m-d H:i:s',$row->due_date)->format('d/m/Y');
				$row->sign_jur= $row->jur_flg;
				}
				
				
				
				
				}
				//scenario save
				else{
					$rowCount=$_POST['rowCount'];
					
					
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
					$menuName = 'GENERATE REPO INTEREST JOURNAL';
					$modelfilter->attributes = $_POST['Vgeneraterepointjur'];
					
				$folder = Sysparam::model()->find("param_id = 'W_JUR_REPO_INTEREST'and param_Cd1 = 'FOLDER'")->dflg1;
					
					if($rowCount ==  0){
					$modelfilter->addError('save_flg', 'Tidak ada data yang diproses');	
					}
					
							
					if(DateTime::createFromFormat('d/m/Y',$modelfilter->jur_date))$modelfilter->jur_date = DateTime::createFromFormat('d/m/Y',$modelfilter->jur_date)->format('Y-m-d');	
				
				
				
					$cre_date = date('Y-m-d H:i:s');
				
					$record_seq = 1;
					for($x=0; $x<$rowCount; $x++){
						$model[$x] =new Vgeneraterepointjur;
						
						$modelledger[$x] = new Taccountledger;
						$model[$x]->attributes = $_POST['Vgeneraterepointjur'][$x+1];
						$modelheader[$x] = new Tjvchh;
						$modeltrepovch[$x] = new Trepovch;
						$model[$x]->int_amt=str_replace( ',', '', $model[$x]->int_amt );
						$model[$x]->int_tax_amt=str_replace( ',', '', $model[$x]->int_tax_amt );
						$model[$x]->int_aft_tax=str_replace( ',', '', $model[$x]->int_aft_tax );
						$rep_num=$model[$x]->repo_num;
						$modelrepo[$x] = Trepo::model()->find("repo_num ='$rep_num'");
						if(DateTime::createFromFormat('Y-m-d H:i:s',$modelrepo[$x]->repo_date))$modelrepo[$x]->repo_date = DateTime::createFromFormat('Y-m-d H:i:s',$modelrepo[$x]->repo_date)->format('Y-m-d');
						if(DateTime::createFromFormat('Y-m-d H:i:s',$modelrepo[$x]->due_date))$modelrepo[$x]->due_date = DateTime::createFromFormat('Y-m-d H:i:s',$modelrepo[$x]->due_date)->format('Y-m-d');
						if(DateTime::createFromFormat('Y-m-d H:i:s',$modelrepo[$x]->extent_dt))$modelrepo[$x]->extent_dt = DateTime::createFromFormat('Y-m-d H:i:s',$modelrepo[$x]->extent_dt)->format('Y-m-d');
							if(isset($_POST['Vgeneraterepointjur'][$x+1]['save_flg']) && $_POST['Vgeneraterepointjur'][$x+1]['save_flg'] == 'Y')
					{
						
						
						
				if($folder == 'Y'){
					
						//cek folder_cd		
						if( $model[$x]->folder_cd == '' || $model[$x]->folder_cd == null ){
							
							$model[$x]->addError('folder_cd','Folder harus diisi');
						$success=FALSE;
						}
				$cek_folder_cd = $this->checkFolderCd($model[$x]->folder_cd,$modelfilter->jur_date);
				
				if($cek_folder_cd){
					
					$model[$x]->addError('folder_cd',"File Code ".$model[$x]->folder_cd." is already used by $cek_folder_cd[0] $cek_folder_cd[1] $cek_folder_cd[2]");
					$success=FALSE;
					
				}
				
				
					}
					
					//cek jika days = 0
					
					if($model[$x]->days =='0'){
						$model[$x]->addError('days','Interest 0, mungkin sudah dijurnal sebelumnya');
						$success=FALSE;
					}
						
						
						//get doc num
					$sql="SELECT GET_DOCNUM_GL(to_date('$modelfilter->jur_date','yyyy-mm-dd'),'GL') as jvch_num from dual";
					$num=DAO::queryRowSql($sql);
					$jvch_num=$num['jvch_num'];
					$jvch_num = substr($jvch_num,0,6).'A'.substr($jvch_num,7,7);
						
						
						
		if(DateTime::createFromFormat('d/m/Y',$model[$x]->repo_date))$model[$x]->repo_date = DateTime::createFromFormat('d/m/Y',$model[$x]->repo_date)->format('Y-m-d');
		if(DateTime::createFromFormat('d/m/Y',$model[$x]->due_date))$model[$x]->due_date = DateTime::createFromFormat('d/m/Y',$model[$x]->due_date)->format('Y-m-d');
						$ip = Yii::app()->request->userHostAddress;
						if($ip=="::1")
						$ip = '127.0.0.1';
					
					$modelheader[$x]->ip_address = $ip;
					$modelheader[$x]->user_id =  Yii::app()->user->id;	
					//desc
					$curr_val =floor($model[$x]->repo_val / 1000000000);
					$desc = $model[$x]->client_cd.' '.DateTime::createFromFormat('Y-m-d',$model[$x]->repo_date)->format('d/m/y').' '.$curr_val.' M '.$model[$x]->interest_rate.'%';
					//assign nilai model header
					$modelheader[$x]->jvch_num =$jvch_num;
					$modelheader[$x]->jvch_type= 'GL';
					$modelheader[$x]->jvch_date=$modelfilter->jur_date;
					$modelheader[$x]->curr_cd='IDR';
					$modelheader[$x]->curr_amt=str_replace( ',', '', $model[$x]->int_amt );
					$modelheader[$x]->remarks = $desc;
					$modelheader[$x]->reversal_jur = 'N';
					//$modelheader[$x]->approved_sts ='A';
					$modelheader[$x]->folder_cd = $model[$x]->folder_cd;
					$modelheader[$x]->cre_dt = $cre_date;
				//header_jurnal	
				if($success && $modelheader[$x]->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
				if($success && $modelheader[$x]->executeSp(AConstant::INBOX_STAT_INS,$jvch_num,1) > 0)$success = true;
					else {
						$success = false;
					}
					
					
					if($folder == 'Y'){
					//insert ke t folder	
					$modelfolder[$x] =new Tfolder;	
					$modelfolder[$x]->fld_mon = DateTime::createFromFormat('Y-m-d',$modelfilter->jur_date)->format('my');
					$modelfolder[$x]->folder_cd = $model[$x]->folder_cd; 	
					$modelfolder[$x]->doc_date = $modelfilter->jur_date;
					$modelfolder[$x]->doc_num = $jvch_num;
					$modelfolder[$x]->user_id= Yii::app()->user->id;
					$modelfolder[$x]->cre_dt = $cre_date;
					if($success && $modelfolder[$x]->validate() && $modelfolder[$x]->executeSp(AConstant::INBOX_STAT_INS, $modelfolder[$x]->doc_num, $modelheader[$x]->update_date, $modelheader[$x]->update_seq, $record_seq) > 0)$success = true;
					else {
						$success = false;
					}
					}
					
				//update  t_repo upd_status='U'
				$repo_num = $model[$x]->repo_num;
				$sett_val = Trepo::model()->find("repo_num = '$repo_num'")->sett_val;
				
					
					$modelrepo[$x]->repo_num = $model[$x]->repo_num;
					$modelrepo[$x]->sett_val= $sett_val + str_replace( ',', '', $model[$x]->int_amt );
					$modelrepo[$x]->update_date = $modelheader[$x]->update_date;
					$modelrepo[$x]->update_seq = $modelheader[$x]->update_seq;
					$modelrepo[$x]->upd_by = $modelheader[$x]->user_id;
					$modelrepo[$x]->upd_dt = $cre_date;
					if($success && $modelrepo[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model[$x]->repo_num,$record_seq) > 0)$success = true;
					else {
						$success = false;
					}
					
			
					
					$arap_tal_id='';
				
					//insert ke t account ledger
					$seq=1;
					for($y=1 ; $y<=3 ; $y++){
						$curr_val = 0;
						$gl_acct_cd='';
						$sl_acct_cd = '';
						$db_cr_flg = '';
						$ledger_nar = '';
						$client_cd = $model[$x]->client_cd;
						$sql =" SELECT  MST_BRANCH.ACCT_PREFIX as prefix
								  FROM MST_CLIENT, MST_BRANCH
								  WHERE MST_CLIENT.client_cd = '$client_cd'
								  AND MST_BRANCH.brch_cd = trim(MST_CLIENT.branch_code)";
						$sl_acct = DAO::queryRowSql($sql);
						
						$acct_income= trim($sl_acct['prefix']).'0000';
						
						
						if($y == 1){
							if($model[$x]->repo_type =='REVERSE'){
								$gl_acct_cd ='1415';
								$sl_acct_cd = $model[$x]->client_cd;
								$db_cr_flg = 'D';
								$curr_val =str_replace( ',', '', $model[$x]->int_amt );
								$ledger_nar = 'B.REPO '.$desc;
								$arap_tal_id =$y;
							}
							else{
								$gl_acct_cd ='5300';
								$sl_acct_cd = '100094';
								$db_cr_flg = 'D';
								$curr_val= str_replace( ',', '', $model[$x]->int_aft_tax );
								$ledger_nar = 'B.REPO '.$desc;
							}
							
						}
						else if($y == 2 && $model[$x]->int_tax_amt > 0){
							if($model[$x]->repo_type ='REVERSE'){
								$gl_acct_cd ='1524';
								$sl_acct_cd = '000000';
								$db_cr_flg = 'D';
								$curr_val = str_replace( ',', '', $model[$x]->int_tax_amt );
								$ledger_nar = 'UM23 '.$desc;
							}
							else{
								$gl_acct_cd ='2526';
								$sl_acct_cd = '000000';
								$db_cr_flg = 'C';
								$curr_val = str_replace( ',', '', $model[$x]->int_tax_amt );
								$ledger_nar = 'UM23 '.$desc;
							}
						}
						
						else if($y == 3){
							if($model[$x]->repo_type == 'REVERSE'){
								$gl_acct_cd ='6511';
								$sl_acct_cd = $acct_income;//'100000';
								$db_cr_flg = 'C';
								$curr_val = str_replace( ',', '', $model[$x]->int_aft_tax );
								$ledger_nar = 'P.REVREPO '.$desc;
							}
							else{
								$gl_acct_cd ='2515';
								$sl_acct_cd = $model[$x]->client_cd;
								$db_cr_flg = 'C';
								$curr_val = str_replace( ',', '', $model[$x]->int_amt );
								$ledger_nar = 'B.REPO '.$desc;
								$arap_tal_id =$y;
							}
						}
					
						
						if($curr_val >0){
							//insert ke t account ledger
				$modelledger[$x]->xn_doc_num = $jvch_num;
				if ($sign_ref =='Y'){
					$modelledger[$x]->doc_ref_num=$jvch_num;
				}
		
				$modelledger[$x]->tal_id= $seq;
				$modelledger[$x]->gl_acct_cd = $gl_acct_cd;
				$modelledger[$x]->sl_acct_cd = $sl_acct_cd;
				$modelledger[$x]->curr_val = $curr_val;
				$modelledger[$x]->xn_val = $curr_val;
				$modelledger[$x]->budget_cd = 'INTREPO';
				$modelledger[$x]->db_cr_flg = $db_cr_flg;
				$modelledger[$x]->ledger_nar = $ledger_nar;
				$modelledger[$x]->user_id = $modelheader[$x]->user_id;
				$modelledger[$x]->doc_date = $modelfilter->jur_date;
				$modelledger[$x]->due_date = $modelfilter->jur_date;
				$modelledger[$x]->record_source = 'GL';
				$modelledger[$x]->sett_for_curr = '0';
				$modelledger[$x]->reversal_jur='N';
				$modelledger[$x]->curr_cd = 'IDR';
				$modelledger[$x]->manual='Y';
				$modelledger[$x]->cre_dt = $cre_date;
				$modelledger[$x]->folder_cd = $model[$x]->folder_cd; 		
				$modelledger[$x]->update_date= $modelheader[$x]->update_date;
				$modelledger[$x]->update_seq = $modelheader[$x]->update_seq;			
				if($success && $modelledger[$x]->executeSp(AConstant::INBOX_STAT_INS,$jvch_num,$seq, $modelheader[$x]->update_date,$modelheader[$x]->update_seq,$seq) > 0)$success = true;
					else {
						$success = false;
					}
						$seq++;	
						}
			   
			
					}
					
					
					//insert t_repo_vch
					$modeltrepovch[$x]->repo_num = $model[$x]->repo_num;
					$modeltrepovch[$x]->doc_num = $jvch_num;
					$modeltrepovch[$x]->doc_ref_num = $jvch_num;
					$modeltrepovch[$x]->tal_id = $arap_tal_id;
					$modeltrepovch[$x]->amt = str_replace( ',', '', $model[$x]->int_amt );
					$modeltrepovch[$x]->doc_dt = $modelfilter->jur_date;
					$modeltrepovch[$x]->user_id = $modelheader[$x]->user_id;
					$modeltrepovch[$x]->update_date = $modelheader[$x]->update_date;
					$modeltrepovch[$x]->update_seq= $modelheader[$x]->update_seq;
					$modeltrepovch[$x]->cre_dt = $cre_date;
					if($success && $modeltrepovch[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->repo_num,$jvch_num,$jvch_num,$modelheader[$x]->update_date,$modelheader[$x]->update_seq,$record_seq) > 0)$success = true;
					else {
						$success = false;
					}
					
						
					}
						
												
						$record_seq++;
					}
			
				
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('/glaccounting/generaterepointerest/index'));
				}
				else {
					$transaction->rollback();
				}
								
				}
		
		
		
		if(DateTime::createFromFormat('Y-m-d',$modelfilter->jur_date))$modelfilter->jur_date = DateTime::createFromFormat('Y-m-d',$modelfilter->jur_date)->format('d/m/Y');
		foreach ($model as $row) {
			if(DateTime::createFromFormat('Y-m-d',$row->repo_date))$row->repo_date = DateTime::createFromFormat('Y-m-d',$row->repo_date)->format('d/m/Y');
			if(DateTime::createFromFormat('Y-m-d',$row->due_date))$row->due_date = DateTime::createFromFormat('Y-m-d',$row->due_date)->format('d/m/Y');
		
		
		}
		
		
		
		}
		else{
				
		$model = Vgeneraterepointjur::model()->findAll("rownum<1");
			
			foreach($model as $row){
					if(DateTime::createFromFormat('Y-m-d H:i:s',$row->repo_date))$row->repo_date= DateTime::createFromFormat('Y-m-d H:i:s',$row->repo_date)->format('d/m/Y');
				if(DateTime::createFromFormat('Y-m-d H:i:s',$row->due_date))$row->due_date= DateTime::createFromFormat('Y-m-d H:i:s',$row->due_date)->format('d/m/Y');
			
			}
			$modelfilter->jurnal_type='0';
			$modelfilter->jur_date=date('d/m/Y');
		}
	
		$this->render('create',array(
			'model'=>$model,
			'modelfilter'=>$modelfilter,
			'modelheader'=>$modelheader,
			'modeltrepovch'=>$modeltrepovch,
			'modelledger'=>$modelledger,
			'modelrepo'=>$modelrepo,
			'modelfolder'=>$modelfolder
		));
	}


	public function actionIndex()
	{
			$model=new Vgeneraterepointerest('search');
	//	$model->unsetAttributes();  // clear any default values
		

		if(isset($_GET['Vgeneraterepointerest']))
			$model->attributes=$_GET['Vgeneraterepointerest'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	public function checkFolderCd($folder_cd,$jvch_date)
	{
		$model=new Tjvchh;
		$return;
		$doc_num;
		$user_id;
		$doc_date;
		
		$connection  = Yii::app()->db;
		//$transaction = $connection->beginTransaction();	
		
		$query  = "CALL SP_CHECK_FOLDER_CD(
					:P_FOLDER_CD,
					TO_DATE(:P_DATE,'YYYY-MM-DD'),
					:P_RTN,
					:P_DOC_NUM,
					:P_USER_ID,
					:P_DOC_DATE)";
					
		$command = $connection->createCommand($query);
		$command->bindValue(":P_FOLDER_CD",strtoupper($folder_cd),PDO::PARAM_STR);
		$command->bindValue(":P_DATE",$jvch_date,PDO::PARAM_STR);
		$command->bindParam(":P_RTN",$return,PDO::PARAM_STR,1);
		$command->bindParam(":P_DOC_NUM",$doc_num,PDO::PARAM_STR,100);
		$command->bindParam(":P_USER_ID",$user_id,PDO::PARAM_STR,10);
		$command->bindParam(":P_DOC_DATE",$doc_date,PDO::PARAM_STR,100);

		$command->execute();
		
		if($doc_date)$doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$doc_date)->format('d/m/Y');
		
		if($return == 1){
		//$model->addError('folder_cd',"File Code ".$folder_cd." is already used by $user_id $doc_num $doc_date");
		
		return array($user_id,$doc_date,$doc_num);
		//return $doc_date;
		//return $doc_num;
		}
	}

		public function actionCekHoliday(){
			
			$resp['status']='error';
			if(isset($_POST['jur_date'])){
			$tanggal=$_POST['jur_date'];
			$query="select f_is_holiday('$tanggal') AS LIBUR FROM DUAL ";
			$source = DAO::queryRowSql($query);
		
				//$resp['tanggal'] = $tanggal;
				$resp['holiday'] = $source['libur'];
				$resp['status']='success';
		
		
		
			}
		echo json_encode($resp);
	}

	
}
