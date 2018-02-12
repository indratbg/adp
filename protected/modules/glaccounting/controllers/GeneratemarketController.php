<?php

class GeneratemarketController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';


	public function actionCreate()
	{	$success = false;
		$modelfilter=new Vgeneratemarket;
		$model= array();
		$period_end_date='';
		$folder = Sysparam::model()->find("param_id='SYSTEM' and param_cd1='VCH_REF'")->dflg1;
		$valid=true;
	//	$safe_journal=false;
		if(isset($_POST['scenario'])){
		$scenario = $_POST['scenario'];
				if($scenario == 'filter'){
					$modelfilter->attributes = $_POST['Vgeneratemarket'];
					$period_end_date = $modelfilter->end_date;
					if(DateTime::createFromFormat('d/m/Y',$period_end_date))$period_end_date=DateTime::createFromFormat('d/m/Y',$period_end_date)->format('Y-m-d');
					
					$model = Vgeneratemarket::model()->findAllBySql("SELECT T.client_cd, decode(m.susp_stat,'C',0,info_fee) info_fee, 
							M.CLIENT_NAME, M.BRANCH_CODE, 'N' FLG, decode(m.susp_stat,'C','Closed','') Keterangan,olt_user_id,client_type,fee_flg,user_stat,
							accessflag 
							FROM T_OLT_LOGIN T, MST_CLIENT M 
							WHERE period_end_date = '$period_end_date'
							AND fee_flg = 'Y'
							AND T.CLIENT_CD = M.CLIENT_CD
							ORDER BY 1	");
									
				}
				//scenario save
				else{
					$rowCount=$_POST['rowCount'];
					
					
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
					$menuName = 'GENERATE MARKET INFO FEE JOURNAL';
					$modelfilter->attributes = $_POST['Vgeneratemarket'];
					$modelfilter->user_id = Yii::app()->user->id;
					$valid=$modelfilter->validate();
				
					if($rowCount ==  0){
					$modelfilter->addError('save_flg', 'Tidak ada data yang diproses');	
					}
					else{
					for($x=0; $x<$rowCount; $x++){
						$model[$x] =new Vgeneratemarket;
						$model[$x]->attributes = $_POST['Vgeneratemarket'][$x+1];
						$model[$x]->end_date = $modelfilter->end_date;
						$model[$x]->period_end_date =$modelfilter->end_date;
						$model[$x]->user_id = $modelfilter->user_id;
						$valid = $model[$x]->validate() && $valid;
						}
					}
					
					if(DateTime::createFromFormat('d/m/Y',$modelfilter->end_date))$modelfilter->end_date= DateTime::createFromFormat('d/m/Y',$modelfilter->end_date)->format('Y-m-d');	
					if(DateTime::createFromFormat('d/m/Y',$modelfilter->jur_date))$modelfilter->jur_date = DateTime::createFromFormat('d/m/Y',$modelfilter->jur_date)->format('Y-m-d');	
					$period_end_date= $modelfilter->end_date;
				
				
				if($valid){
				
				if($modelfilter->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
				else{
					$success=false;
				}
					
				if($folder == 'Y'){
						//cek folder_cd
					$cek_folder_cd = $this->checkFolderCd($modelfilter->folder_cd,$modelfilter->jur_date);
				
				if($cek_folder_cd)
				{	
					$modelfilter->addError('folder_cd',"File Code ".$modelfilter->folder_cd." is already used by $cek_folder_cd[0] $cek_folder_cd[1] $cek_folder_cd[2]");
				}
				if(strlen($modelfilter->folder_cd)<=3){
						$modelfilter->addError('folder_cd', 'File No. harus sesuai format ex. AJ-001');
						$success=FALSE;
						
					}
					}
					
					
					$record_seq = 1;
					for($x=0; $success && $x<$rowCount; $x++){
						
						if(isset($_POST['Vgeneratemarket'][$x+1]['save_flg']) && $_POST['Vgeneratemarket'][$x+1]['save_flg'] == 'Y')
					{
						$model[$x]->update_date = $modelfilter->update_date;
						$model[$x]->update_seq = $modelfilter->update_seq;
						$model[$x]->upd_by = $modelfilter->user_id;
						$model[$x]->upd_dt = date('Y-m-d H-i-s');
						
						if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD,$modelfilter->end_date,$model[$x]->olt_user_id,$model[$x]->client_cd,$record_seq)>0)$success=true;
						else{
							$success=false;
						}
						$record_seq++;
					//	$safe_journal =true;
					}
				
									
						
					}
					
					//buat jurnal
					if($success && $modelfilter->executeSpJournal() > 0)$success = true;
					else {
						$success = false;
					}
					

				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('/glaccounting/generatemarket/index'));
				}
				else {
					$transaction->rollback();
					
				}
				
					
					}//end valid
			
									
				}
		
		
			if(DateTime::createFromFormat('Y-m-d',$modelfilter->end_date))$modelfilter->end_date= DateTime::createFromFormat('Y-m-d',$modelfilter->end_date)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$modelfilter->jur_date))$modelfilter->jur_date = DateTime::createFromFormat('Y-m-d',$modelfilter->jur_date)->format('d/m/Y');
		
		
		}
		else{
				
		$model = Vgeneratemarket::model()->findAllBySql("SELECT T.client_cd, decode(m.susp_stat,'C',0,info_fee) info_fee, 
							M.CLIENT_NAME, M.BRANCH_CODE, 'N' FLG, decode(m.susp_stat,'C','Closed','') Keterangan 
							FROM T_OLT_LOGIN T, MST_CLIENT M 
							WHERE period_end_date = TRUNC(SYSDATE)
							AND fee_flg = 'Y'
							AND T.CLIENT_CD = M.CLIENT_CD
							ORDER BY 1
									");  //Vgeneratemarket::model()->findAll();

									
																
								$lastdateofthemonth = date("Y-m-t");
								
								$lastworkingday = date('d/m/Y', strtotime($lastdateofthemonth));
								
								if($lastworkingday == "Saturday") { 
								$newdate = strtotime ('-1 day', strtotime($lastdateofthemonth));
								$lastworkingday = date ('Y-m-j', $newdate);
								}
								elseif($lastworkingday == "Sunday") { 
								$newdate = strtotime ('-2 day', strtotime($lastdateofthemonth));
								$lastworkingday = date ( 'Y-m-j' , $newdate );
								}
								
	if(DateTime::createFromFormat('Y-m-d',	$lastworkingday ))	$lastworkingday  = DateTime::createFromFormat('Y-m-d',$lastworkingday )->format('d/m/Y');
								
																	
									
									
									$date = new DateTime('now');
									$date1 = new DateTime('now');
									$date->modify('last day of last month');
									//$date1->modify('last day of this month');
									//$this_month= $date1->format('d/m/Y');
									$last_day =  $date->format('d/m/Y');
									if($folder == 'Y'){
									$modelfilter->folder_cd='AJ-';		
									}
									
									$modelfilter->end_date=$last_day;
									//$modelfilter->end_date=date('30/11/2014');
									$modelfilter->jur_date=	 $lastworkingday;
									
		}
	
		$this->render('create',array(
			'model'=>$model,
			'modelfilter'=>$modelfilter,
			
		));
	}


	public function actionIndex()
	{
		
		$model = Tjvchh::model()->findAllBySql("select   h.jvch_date, h.folder_cd,h.remarks
															from T_ACCOUNT_LEDGER D, T_JVCHH H
															where h.jvch_date > '01jan2015'
															and h.approved_sts = 'A'
															and h.jvch_type = 'GL'
															and h.jvch_num = d.xn_doc_num
															and d.budget_cd is not null
                              								AND D.TAL_ID='1'
															and d.budget_cd = 'OLTFEE'
															order by h.jvch_date desc");
				foreach($model as $row){
					$row->folder_cd=strtoupper(trim($row->folder_cd));
					$row->remarks=strtoupper($row->remarks);
				if(DateTime::createFromFormat('Y-m-d H:i:s',$row->jvch_date))$row->jvch_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->jvch_date)->format('d M Y');	
				}								
					
		

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

	

	
}
