<?php

class GeneratemkbdreportController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$modelSave = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD51','Report_VD51.rptdesign');
		$model=new Vlapmkbdvd51('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->approved_stat ='<>C';


		if(isset($_GET['Vlapmkbdvd51'])){
			$model->attributes=$_GET['Vlapmkbdvd51'];
		}
		$this->render('list',array(
			'model'=>$model,
			'modelSave'=>$modelSave
		));
	}
	
	
	public function actionGenerate()
	{
		$model = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD51','Report_VD51.rptdesign');
		$model->gen_dt = date('d/m/Y');
		$success=false;
		
		if(isset($_POST['Rptmkbdreport']))
		{
			$model->attributes = $_POST['Rptmkbdreport'];
			if(DateTime::createFromFormat('d/m/Y',$model->gen_dt))$model->gen_dt = DateTime::createFromFormat('d/m/Y',$model->gen_dt)->format('Y-m-d');
			if(DateTime::createFromFormat('d/m/Y',$model->price_dt))$model->price_dt = DateTime::createFromFormat('d/m/Y',$model->price_dt)->format('Y-m-d');
			$model->scenario = 'generate';
			if($model->validate())
			{
				$menuName = 'MKBD REPORT';					
				$begin_dt = DateTime::createFromFormat('Y-m-d',$model->gen_dt)->format('Y-m-01');
				$cek = Tcloseprice::model()->find("stk_date='$model->gen_dt' and approved_stat='A'");
				
				$cek4 = Tcontracts::model()->find("contr_dt = to_date('$model->gen_dt','yyyy-mm-dd') and contr_stat <>'C' ");
				$cek5 = Tcontracts::model()->find("	contr_dt between to_date('$model->gen_dt','yyyy-mm-dd') -20 and to_date('$model->gen_dt','yyyy-mm-dd')		
															and contr_stat <> 'C'		
															and due_dt_for_amt <= to_date('$model->gen_dt','yyyy-mm-dd')		
															and nvl(sett_qty,0) < qty
															");
															
				$cek6 = Tbondtrx::model()->find("trx_date between  to_date('$model->gen_dt','yyyy-mm-dd') -20 and  to_date('$model->gen_dt','yyyy-mm-dd')			
															and approved_sts = 'A'			
															and value_dt <=  to_date('$model->gen_dt','yyyy-mm-dd')	
															and doc_num is not null		
															and nvl(settle_secu_flg,'N') = 'N'	");
                                                        
                                                            
				if($cek)
				{
					$msg1='';
					$msg2='';
					$msg3='';	
                    $msg4='';										
					if(!$cek4)
					{
						$msg1 = "Transaksi hari ini belum diproses! <br />";
					}
					if($cek5)
					{
						$msg2 = "Ada transaksi yang belum disettle! <br />";
					}
				
					if($cek6)
					{
						$msg3 = "Ada transaksi bond yang belum disettle! <br />";
					}
					if(Rptmkbdreport::checkJournalApproval($model->gen_dt)>0)
                    {
                        $msg4 = "Masih ada jurnal belum di approve! <br />";
                    }
					if($msg1 ||$msg2 ||$msg3 || $msg4)
					{
						Yii::app()->user->setFlash('info', $msg1. $msg2. $msg3. $msg4);
					}
					
				}
				
				//get IP Address
				$ip = Yii::app()->request->userHostAddress;
				if($ip=="::1")
				$ip = '127.0.0.1';
				$model->ip_address =$ip;
				//set connection
				$connection  = Yii::app()->dbrpt;
				$transaction = $connection->beginTransaction();
					
				//execute SP_T_MANY_HEADER_INSERT	
				if($model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName)>0)$success=TRUE;
				else{
					$success=FALSE;
				}
				///execute SPR_MKBD_Upd
				if($success && $model->executeSpInbox(AConstant::INBOX_STAT_INS, 1)>0)$success=true;
				else{
					$success=false;
				}

				//execute sp mkbd
				if($success && $model->executeVd('510A')>0)$success=TRUE;
				else{
					$success=false;
				}

				if($success && $model->executeVd('510B')>0)$success=TRUE;
				else{
					$success=false;
				}

				if($success && $model->executeVd('510C')>0)$success=TRUE;
				else{
					$success=false;
				}


				if($success && $model->executeVd('510D')>0)$success=TRUE;
				else{
					$success=false;
				}

				if($success && $model->executeVd('510E')>0)$success=TRUE;
				else{
					$success=false;
				}

	
				if($success && $model->executeVd('510F')>0)$success=TRUE;
				else{
					$success=false;
				}

				if($success && $model->executeVd('510G')>0)$success=TRUE;
				else{
					$success=false;
				}

				if($success && $model->executeVd('510H')>0)$success=TRUE;
				else{
					$success=false;
				}

				if($success && $model->executeVd('510I')>0)$success=TRUE;
				else{
					$success=false;
				}
		 
				if($success && $model->executeVd('54')>0)$success=TRUE;
				else{
					$success=false;
				}

	
				if($success && $model->executeVd('55')>0)$success=TRUE;
				else{
					$success=false;
				}

				if($success && $model->executeVd('56')>0)$success=TRUE;
				else{
					$success=false;
				}
	
				if($success && $model->executeVd('57')>0)$success=TRUE;
				else{
					$success=false;
				}
	
				if($success && $model->executeVd('51')>0)$success=TRUE;
				else{
					$success=false;
				}

				if($success && $model->executeVd('52')>0)$success=TRUE;
				else{
					$success=false;
				}

			
				if($success && $model->executeVd('53')>0)$success=TRUE;
				else{
					$success=false;
				}

			
				if($success && $model->executeVd('58')>0)$success=TRUE;
				else{
					$success=false;
				}

				if($success && $model->executeVd('59')>0)$success=TRUE;
				else{
					$success=false;
				}
	
				if($success)
				{	
				//CEK APAKAH SAMA TOTAL VD51 DAN VD52
				$vd51="SELECT C1 FROM INSISTPRO_RPT.LAP_MKBD_VD51 WHERE update_seq='$model->update_seq' and update_date='$model->update_date' and mkbd_cd ='113' ";
				$vd51_c1 =DAO::queryRowSql($vd51);
				$vd52 = "SELECT C1 FROM INSISTPRO_RPT.LAP_MKBD_VD52 WHERE update_seq='$model->update_seq' and update_date='$model->update_date'  and mkbd_cd ='173' ";				 
				$vd52_c1=DAO::queryRowSql($vd52);
				$vd51c1 = round($vd51_c1['c1'],2);
				$vd52c1 = round($vd52_c1['c1'],2);
				
				$msg1='';
				$msg2='';
				if(($vd51c1 != $vd52c1) && ($vd51_c1 && $vd52_c1)){
					$msg1= 'Total MKBD VD51 tidak sama dengan MKBD VD52'."<br />";
				}
				$cek_mkbd_val = Tmanydetail::model()->find("update_seq = '$model->update_seq' and update_date = '$model->update_date' and table_name='LAP_MKBD_VD51' and field_name='NILAI_MKBD' ");
				//cek nilai MKBD
				if($model->vd59 && $cek_mkbd_val)
				{
					$nilai = $cek_mkbd_val->field_value;
					if($nilai<=0)
					{
						$msg2 = 'Tidak memenuhi nilai minimum MKBD'."<br />";
						$log_mkbd = new Tmkbdlog;
						$log_mkbd->update_date = $model->update_date;
						$log_mkbd->update_seq = $model->update_seq;
						$log_mkbd->seqno = 1;
						$log_mkbd->cre_dt =date('Y-m-d H:i:s');
						$log_mkbd->user_id = Yii::app()->user->id;
					}
				}
				
				//CEK BARIS DAN KOLOM DARI APAKAH ADA YANG NILAINYA  < 0
				$msgvd51 = '';
				$msgvd52 = '';
				$msgvd53 =  '';
				$msgvd54 =  '';
				$msgvd55 =  '';
				$msgvd56 =  '';
				$msgvd57 =  '';
				$msgvd58 =  '';
				$msgvd59 =  '';
				$msgvd510a =  '';
				$msgvd510b =  '';
				$msgvd510c =  '';
				$msgvd510d =  '';
				$msgvd510e =  '';
				$msgvd510f =  '';
				$msgvd510g =  '';
				$msgvd510h =  '';
				$msgvd510i =  '';
				//cek vd51
				$sql_vd51 = "select COUNT(1),MKBD_CD from INSISTPRO_RPT.LAP_MKBD_VD51 WHERE update_seq = '$model->update_seq' and update_date = '$model->update_date'
							 AND C1<0 GROUP BY MKBD_CD";
				$cek_vd51 = DAO::queryAllSql($sql_vd51);	
				
				if($cek_vd51)
				{	
					foreach($cek_vd51 as $row)
					{
						$msgvd51 =  $msgvd51.'VD 5-1 bernilai minus pada kolom B baris '.$row['mkbd_cd']."<br />";
					}
				}
				
				//cek vd52
				$sql_vd52 = "select COUNT(1),MKBD_CD from INSISTPRO_RPT.LAP_MKBD_VD52 WHERE update_seq = '$model->update_seq' and update_date = '$model->update_date' 
							 AND C1<0 GROUP BY MKBD_CD";
				$cek_vd52 = DAO::queryAllSql($sql_vd52);	
				
				if($cek_vd52)
				{	
					foreach($cek_vd52 as $row)
					{
						$msgvd52 = $msgvd52.'VD 5-2 bernilai minus pada kolom B baris '.$row['mkbd_cd']."<br />";	
					}
				}
				//cek vd53
				$sql_vd53 = "select COUNT(1),MKBD_CD from INSISTPRO_RPT.LAP_MKBD_VD53 WHERE update_seq = '$model->update_seq' and update_date = '$model->update_date' 
							 AND C1<0 GROUP BY MKBD_CD";
				$cek_vd53 = DAO::queryAllSql($sql_vd53);	
				if($cek_vd53)
				{	foreach($cek_vd53 as $row)
					{
						$msgvd53 = $msgvd53.'VD 5-3 bernilai minus pada kolom B baris '.$row['mkbd_cd']."<br />";	
					}
				}
				//cek vd54
				$sql_vd54 = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD54 Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(market_value<0 or nab<0 or risiko_persen<0 or batasan_mkbd<0 or risiko<0)
							 Group By Mkbd_Cd";
				$cek_vd54 = DAO::queryAllSql($sql_vd54);	
				if($cek_vd54)
				{	foreach($cek_vd54 as $row)
					{
						$msgvd54 = $msgvd54.'VD 5-4 bernilai minus pada baris '.$row['mkbd_cd']."<br />";		
					}
				}
				//cek vd55
				$sql_vd55 = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD55 Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(NILAI_EFEK<0 or NILAI_LINDUNG<0 or NILAI_TUTUP<0 or NILAI_HAIRCUT<0 or NILAI_HAIRCUT_LINDUNG<0 or PENGEMBALIAN<0)
							 Group By Mkbd_Cd";
				$cek_vd55 = DAO::queryAllSql($sql_vd55);	
				if($cek_vd55)
				{	foreach($cek_vd55 as $row)
					{
						$msgvd55 =$msgvd55.'VD 5-5 bernilai minus pada baris '.$row['mkbd_cd']."<br />";	
					}
				}
		
				//cek vd56
				$sql_vd56 = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD56 Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(c1<0 or c2<0 or c3<0 or c4<0)
							 Group By Mkbd_Cd";
				$cek_vd56 = DAO::queryAllSql($sql_vd56);	
				if($cek_vd56)
				{	foreach($cek_vd56 as $row)
					{
						$msgvd56 =$msgvd56. 'VD 5-6 bernilai minus pada baris '.$row['mkbd_cd']."<br />";	
					}
				}
				//cek vd57
				$sql_vd57 = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD57 Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(c1<0 or c2<0 or c3<0 or c4<0)
							 Group By Mkbd_Cd";
				$cek_vd57 = DAO::queryAllSql($sql_vd57);	
				if($cek_vd57)
				{	foreach($cek_vd57 as $row)
					{
						$msgvd57 =$msgvd57. 'VD 5-7 bernilai minus pada baris '.$row['mkbd_cd']."<br />";	
					}
				}
				//cek vd58
				$sql_vd58 = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD58 Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	c1<0 
							 Group By Mkbd_Cd";
				$cek_vd58 = DAO::queryAllSql($sql_vd58);	
				if($cek_vd58)
				{	foreach($cek_vd58 as $row)
					{
						$msgvd58 = $msgvd58.'VD 5-8 bernilai minus pada baris '.$row['mkbd_cd']."<br />";	
					}
				}
				//cek vd59
				$sql_vd59 = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD59 Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(c1<0 or c2<0 )
							 Group By Mkbd_Cd";
				$cek_vd59 = DAO::queryAllSql($sql_vd59);	
				if($cek_vd59)
				{	foreach($cek_vd59 as $row)
					{
						$msgvd59 =$msgvd59.'VD 5-9 bernilai minus pada baris '.$row['mkbd_cd']."<br />";	
					}
				}
				//cek vd510A
				$sql_vd510a = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD510a Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(REPO_VAL<0 or RETURN_VAL<0 or SUM_QTY<0 or MARKET_VAL<0 or RANKING<0)
							 Group By Mkbd_Cd";
				$cek_vd510a = DAO::queryAllSql($sql_vd510a);	
				if($cek_vd510a)
				{	foreach($cek_vd510a as $row)
					{
						$msgvd510a = $msgvd510a. 'VD 5-10 A bernilai minus pada baris '.$row['mkbd_cd']."<br />";	
					}
				}
				//cek vd510B
				$sql_vd510b = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD510b Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(REPO_VAL<0 or RETURN_VAL<0 or SUM_QTY<0 or MARKET_VAL<0 or RANKING<0)
							 Group By Mkbd_Cd";
				$cek_vd510b = DAO::queryAllSql($sql_vd510b);	
				if($cek_vd510b)
				{	foreach($cek_vd510b as $row)
					{
						$msgvd510b = $msgvd510b.'VD 5-10 B bernilai minus pada baris '.$row['mkbd_cd']."<br />";	
					}
				}
				//cek vd510C
				$sql_vd510c = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD510c Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(BUY_PRICE<0 or PRICE<0 or MARKET_VAL<0 or PERSEN_MARKET<0 or RANKING<0)
							 Group By Mkbd_Cd";
				$cek_vd510c = DAO::queryAllSql($sql_vd510c);	
				if($cek_vd510c)
				{	foreach($cek_vd510b as $row)
					{
						$msgvd510c  =$msgvd510c.'VD 5-10 C bernilai minus pada baris '.$row['mkbd_cd']."<br />";	
					}
				}
				//cek vd510D
				$sql_vd510d = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD510d Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(end_bal<0 or stk_val<0 or ratio<0 or lebih_client<0 or lebih_porto<0)
							 Group By Mkbd_Cd";
				$cek_vd510d = DAO::queryAllSql($sql_vd510d);	
				if($cek_vd510d)
				{	foreach($cek_vd510d as $row)
					{
						$msgvd510d = $msgvd510d.'VD 5-10 D bernilai minus pada baris '.$row['mkbd_cd']."<br />";	
					}
				}
				//cek vd510E
				$sql_vd510e = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD510e Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(price<0 or market_val<0 )
							 Group By Mkbd_Cd";
				$cek_vd510e = DAO::queryAllSql($sql_vd510e);	
				if($cek_vd510e)
				{	foreach($cek_vd510e as $row)
					{
						$msgvd510e = $msgvd510e. 'VD 5-10 E bernilai minus pada baris '.$row['mkbd_cd']."<br />";	
					}
				}
				//cek vd510F
				$sql_vd510f = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD510f Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(nilai_komitment<0 or haircut<0 or unsubscribe_amt<0 or bank_garansi<0 or ranking<0)
							 Group By Mkbd_Cd";
				$cek_vd510f = DAO::queryAllSql($sql_vd510f);	
				if($cek_vd510f)
				{	foreach($cek_vd510f as $row)
					{
						$msgvd510f =$msgvd510f. 'VD 5-10 F bernilai minus pada baris '.$row['mkbd_cd']."<br />";	
					}
				}
		
				//cek vd510G
				$sql_vd510g = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD510g Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(NILAI<0 or RANKING<0 )
							 Group By Mkbd_Cd";
				$cek_vd510g = DAO::queryAllSql($sql_vd510g);	
				if($cek_vd510g)
				{	foreach($cek_vd510g as $row)
					{
						$msgvd51g =$msgvd51g.'VD 5-10 G bernilai minus pada baris '.$row['mkbd_cd']." <br />";	
					}
				}
				//cek vd510H
				$sql_vd510h = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD510h Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(SUDAH_REAL<0 or BELUM_REAL<0 and ranking<0 )
							 Group By Mkbd_Cd";
				$cek_vd510h = DAO::queryAllSql($sql_vd510h);	
				if($cek_vd510h)
				{	foreach($cek_vd510h as $row)
					{
						$msgvd510h = $msgvd510h.  'VD 5-10 H bernilai minus pada baris '.$row['mkbd_cd']."<br/>";	
					}
				}
				//cek vd510I
				$sql_vd510i = "Select Count(1),Mkbd_Cd From INSISTPRO_RPT.LAP_MKBD_VD510i Where
						 	update_seq = '$model->update_seq' and update_date = '$model->update_date'
						 	And	(NILAI_RPH<0 or UNTUNG_RUGI<0 and RANKING<0 )
							 Group By Mkbd_Cd";
				$cek_vd510i = DAO::queryAllSql($sql_vd510i);	
				if($cek_vd510i)
				{	foreach($cek_vd510i as $row)
					{
						$msgvd510i = $msgvd510i.'VD 5-10 I bernilai minus pada baris '.$row['mkbd_cd']."<br />";	
					}
				}
				
				if($msg1|| $msg2 || $msgvd51 ||$msgvd52 ||$msgvd53 ||$msgvd54 ||$msgvd55 ||$msgvd56 ||$msgvd57 ||$msgvd58 || $msgvd59||
					$msgvd510a ||$msgvd510b ||$msgvd510c ||$msgvd510d ||$msgvd510e ||$msgvd510f ||$msgvd510g ||$msgvd510h ||$msgvd510i)
				{
				Yii::app()->user->setFlash('danger', $msg1.$msg2
											.$msgvd51
											.$msgvd52
											.$msgvd53
											.$msgvd54
											.$msgvd55
											.$msgvd56
											.$msgvd57
											.$msgvd58
											.$msgvd58
											.$msgvd510a
											.$msgvd510b
											.$msgvd510c
											.$msgvd510d
											.$msgvd510e
											.$msgvd510f
											.$msgvd510g
											.$msgvd510h
											.$msgvd510i
											);
				}
				}//end cek success
		
				if($success)
				{
					$date=$model->gen_dt;
					if(DateTime::createFromFormat('Y-m-d',$date))$date=DateTime::createFromFormat('Y-m-d',$date)->format('d M Y');
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully Generate MKBD report at '.$date);
					$this->redirect(array('index'));
				}
				else 
				{
					$transaction->rollback();
				}
		
		
				
			}//end validate model
			
			
		}
		if(DateTime::createFromFormat('Y-m-d',$model->gen_dt))$model->gen_dt = DateTime::createFromFormat('Y-m-d',$model->gen_dt)->format('d/m/Y');
		$this->render('generate',array('model'=>$model));
	}

	public function actionSave_Text_File($update_date, $update_seq)
	{
		$modelSave = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD51','Report_VD51.rptdesign');//dummy
		$model=new Vlapmkbdvd51('search');
		$model->unsetAttributes();  // clear any default values
		$model->approved_stat ='<>C';
		
		$modelSave->scenario = 'save';
		$modelSave->update_date = $update_date;
		$modelSave->update_seq = $update_seq;
	
		//GET MKBD_DATE
		$mkbd_date  = Vlapmkbdvd51::model()->find(array('condition'=>"update_date = '$update_date' and update_seq = '$update_seq' "))->mkbd_date;
		$mkbd_date = DateTime::createFromFormat('Y-m-d H:i:s',$mkbd_date)->format('Y-m-d');
		$modelSave->gen_dt = $mkbd_date;
		
		
	
		if($modelSave->validate())
		{
			 	$sql = "SELECT c2 FROM INSISTPRO_RPT.LAP_MKBD_VD59 WHERE update_seq = '$update_seq' and update_date = '$update_date' and MKBD_CD='102' and approved_stat='A'";
			 	$c2 = DAO::queryRowSql($sql);
			 	$amount = $c2['c2'];
			 	if($modelSave->executeSaveMKbd($mkbd_date, $amount, $modelSave->vp_userid)>0){
			 		
			 	}
				//$user_id = Yii::app()->user->id;
			 	$sql = "UPDATE INSISTPRO_RPT.LAP_MKBD_VD51 SET SAVETXT_DATE=SYSDATE, SAVE_TXT_BY ='$modelSave->vp_userid' 
			 			where update_seq = '$update_seq' and update_date = '$update_date' ";
				$exec  = DAO::executeSql($sql);		
				
			 
						$direktur = Company::model()->find()->contact_pers;
						$kode_AB =  Parameter::model()->find(" prm_cd_1 = 'AB' and prm_cd_2 ='000' ")->prm_desc;
						$kode_AB = substr($kode_AB, 0,2);
						
						
						$date =  DateTime::createFromFormat('Y-m-d',$mkbd_date)->format('ymd');
						$date_AB =  DateTime::createFromFormat('Y-m-d',$mkbd_date)->format('Ymd');
						
						$sql = "SELECT VD||'.'||TRIM(A.MKBD_CD)||'|'||DECODE(B.VIS1,1,TRIM(TO_CHAR(A.C1,'9999999999999999990.99')),'')||'|||||||||' AS text_vd51 
								FROM INSISTPRO_RPT.LAP_MKBD_VD51 a,IPNEXTG.form_mkbd B WHERE A.MKBD_CD =B.MKBD_CD  and b.source='VD51'  
								and update_seq = '$update_seq' and update_date = '$update_date' and A.APPROVED_STAT ='A'  order by a.mkbd_cd";
						$datavd51 = Lapmkbdvd51::model()->findAllBySql($sql);
						
						$sql2 = "SELECT VD||'.'||TRIM(A.MKBD_CD)||'|'||DECODE(B.VIS1,1,TRIM(TO_CHAR(A.C1,'9999999999999999990.99')),'')||'|||||||||' AS text_vd52 
								 FROM INSISTPRO_RPT.LAP_MKBD_VD52 a,IPNEXTG.form_mkbd B WHERE A.MKBD_CD =B.MKBD_CD  and b.source='VD52' 
								 and update_seq = '$update_seq' and update_date = '$update_date' and A.APPROVED_STAT ='A'  order by a.mkbd_cd";
						$datavd52 = Lapmkbdvd51::model()->findAllBySql($sql2);
						
						$sql3 ="SELECT VD||'.'||TRIM(A.MKBD_CD)||'|'||DECODE(B.VIS1,1,TRIM(TO_CHAR(A.C1,'9999999999999999990.99')),'')||'|||||||||' AS text_vd53 
								FROM insistpro_rpt.LAP_MKBD_VD53 a,IPNEXTG.form_mkbd B WHERE A.MKBD_CD =B.MKBD_CD  and b.source='VD53' 
							 and update_seq = '$update_seq' and update_date = '$update_date' and A.APPROVED_STAT ='A' order by a.mkbd_cd";
						$datavd53 = Lapmkbdvd51::model()->findAllBySql($sql3);
						
						$sql4 = "select VD||'.'||TRIM(MKBD_CD)||'|'||TRIM(REKS_TYPE)||'|'||TRIM(REKS_CD)||'|'||TRIM(AFILIASI)||'|'||
							    TRIM(TO_CHAR(MARKET_VALUE,'99999999999999999999999999990.99'))||'|' ||
							    TRIM(TO_CHAR(NAB,'99999999999999999999999999990.99'))||'||'||
							    TRIM(TO_CHAR(BATASAN_MKBD,'99999999999999999999999999990.99'))||'|'||
							    TRIM(TO_CHAR(RISIKO,'99999999999999999999999999990.99'))||'||'
							    AS text_vd54  from insistpro_rpt.lap_mkbd_vd54 where approved_stat='A' 
							    and update_seq = '$update_seq' and update_date = '$update_date' order by mkbd_cd";
						$datavd54 =Lapmkbdvd51::model()->findAllBySql($sql4);			
						
						
						$sqlvd55="select TRIM(VD)||'.'||TRIM(MKBD_CD)||'|'||
							      TRIM(NAMA_EFEK)||'|'||TRIM(TO_CHAR(NILAI_EFEK,'9999999999999999990.99'))||'|'||
							      TRIM(NAMA_LINDUNG)||'|'||TRIM(TO_CHAR(NILAI_LINDUNG,'9999999999999999990.99'))||'|'||
							      TRIM(TO_CHAR(NILAI_TUTUP,'9999999999999999990.99'))||'|'||TRIM(TO_CHAR(NILAI_HAIRCUT,'9999999999999999990.99'))||'|'||
							      TRIM(TO_CHAR(NILAI_HAIRCUT_LINDUNG,'9999999999999999990.99'))||'|'||TRIM(TO_CHAR(PENGEMBALIAN,'9999999999999999990.99'))||'||'
								   AS text_vd55
								   FROM insistpro_rpt.LAP_MKBD_VD55 where approved_stat='A' 
							  	   and update_seq = '$update_seq' and update_date = '$update_date' ";	
						$datavd55 =Lapmkbdvd51::model()->findAllBySql($sqlvd55);
						
						$sql5="SELECT VD||'.'||TRIM(A.MKBD_CD)||'|'||
								DECODE(B.VIS1,1,TRIM(TO_CHAR(A.C1,'9999999999999999990.99')),'')||'|' ||
								DECODE(B.VIS2,1,TRIM(TO_CHAR(A.C2,'9999999999999999990.99')),'')||'|'|| 
								DECODE(B.VIS3,1,TRIM(TO_CHAR(A.C3,'9999999999999999990.99')),'')||'|'|| 
								DECODE(B.VIS4,1,TRIM(TO_CHAR(A.C4,'9999999999999999990.99')),'')||'||||||'
								AS text_vd56a 
								FROM insistpro_rpt.LAP_MKBD_VD56 a,IPNEXTG.form_mkbd B WHERE A.MKBD_CD =B.MKBD_CD  
								and b.source='VD56' AND A.MKBD_CD between 8 and 23
								and update_seq = '$update_seq' and update_date = '$update_date'
								and A.MKBD_CD <> 16 AND A.APPROVED_STAT ='A' order by a.mkbd_cd";
						$datavd56a = Lapmkbdvd51::model()->findAllBySql($sql5);			
						
						$sql6 ="SELECT VD||'.'||TRIM(A.MKBD_CD)||'.'||TRIM(A.NORUT)||'|'||TRIM(SUBSTR(A.DESCRIPTION,1,3))||'|'||
								TRIM(SUBSTR(A.MILIK,1,1))||'|'||TRIM(A.BANK_ACCT_CD)||'|'||TRIM(A.CURRENCY)||'|'||
								TRIM(TO_CHAR(A.C3,'9999999999999999990.99'))||'|' ||
								TRIM(TO_CHAR(A.C4,'9999999999999999990.99'))||'||||' 
								AS text_vd56b 
								FROM insistpro_rpt.LAP_MKBD_VD56 a,IPNEXTG.form_mkbd B WHERE A.MKBD_CD =B.MKBD_CD 
								 and b.source='VD56' AND A.MKBD_CD ='24' AND A.NORUT > 0
								  and update_seq = '$update_seq' and update_date = '$update_date' AND A.APPROVED_STAT ='A' order by  A.NORUT";
						$datavd56b = Lapmkbdvd51::model()->findAllBySql($sql6);	
						
						$sql7 ="SELECT VD||'.'||TRIM(A.MKBD_CD)||'|'||
								DECODE(B.VIS1,1,TRIM(TO_CHAR(A.C1,'9999999999999999990.99')),'')||'|'||
								DECODE(B.VIS2,1,TRIM(TO_CHAR(A.C2,'9999999999999999990.99')),'')||'|'||
								DECODE(B.VIS3,1,TRIM(TO_CHAR(A.C3,'9999999999999999990.99')),'')||'|'||
								DECODE(B.VIS4,1,TRIM(TO_CHAR(A.C4,'9999999999999999990.99')),'')||'||||||'
								AS text_vd57
								FROM insistpro_rpt.LAP_MKBD_VD57 a,IPNEXTG.form_mkbd B WHERE A.MKBD_CD =B.MKBD_CD  and b.source='VD57' 
								AND A.APPROVED_STAT ='A' AND A.MKBD_CD NOT IN (7,27,37,38)  
								and update_seq = '$update_seq' and update_date = '$update_date' order by  A.MKBD_CD";
						$datavd57 = Lapmkbdvd51::model()->findAllBySql($sql7);	
						
						$sql8="SELECT VD||'.'||TRIM(A.MKBD_CD)||'||||'||
								DECODE(B.VIS1,1,TRIM(TO_CHAR(A.C1,'9999999999999999990.99')),'')||'||||||'
								AS text_vd58 
								FROM insistpro_rpt.LAP_MKBD_VD58 a,IPNEXTG.form_mkbd B WHERE A.MKBD_CD =B.MKBD_CD  and b.source='VD58' 
								 and update_seq = '$update_seq' and update_date = '$update_date' AND A.APPROVED_STAT ='A' order by  A.MKBD_CD";
						$datavd58 = Lapmkbdvd51::model()->findAllBySql($sql8);
						
						$sql9 = "SELECT VD||'.'||TRIM(A.MKBD_CD)||'||||'||
								 DECODE(B.VIS1,1,TRIM(TO_CHAR(A.C1,'9999999999999999990.99')),'')||'||' ||
								 DECODE(B.VIS2,1,TRIM(TO_CHAR(A.C2,'9999999999999999990.99')),'')||'||||' 
								 AS text_vd59
							     FROM insistpro_rpt.LAP_MKBD_VD59 a,IPNEXTG.form_mkbd B WHERE A.MKBD_CD =B.MKBD_CD 
								 and b.source='VD59' AND A.APPROVED_STAT ='A'
								 and update_seq = '$update_seq' and update_date = '$update_date' order by  A.mkbd_cd";
						$datavd59 = Lapmkbdvd51::model()->findAllBySql($sql9);		 
								 
						$sql10a="select 'VD510.A.'||TRIM(MKBD_CD)||'|'||TRIM(JENIS_CD)||'|'||TRIM(JENIS)||'|'||
								   TRIM(LAWAN)||'|'||TRIM(TO_CHAR(EXTENT_DT,'DD/MM/YYYY'))||'|'||
								    TRIM(TO_CHAR(DUE_DATE,'DD/MM/YYYY'))||'|'||
								    TRIM(TO_CHAR(REPO_VAL,'9999999999999999990.99'))||'|'||
								   TRIM(TO_CHAR(RETURN_VAL,'9999999999999999990.99'))||'|'||
								    TRIM(STK_CD)||'|'||
								    TRIM(TO_CHAR(SUM_QTY,'99999999999999999999999999990.99'))||'|'||
								  TRIM(TO_CHAR(RANKING,'99999999999999999999999999990.99'))
								AS text_vd510a
								FROM insistpro_rpt.LAP_MKBD_VD510A where approved_stat='A' 
								and update_seq = '$update_seq' and update_date = '$update_date' ";		 
						$datavd10a = Lapmkbdvd51::model()->findAllBySql($sql10a);				 
								 
						$sql10b = "SELECT 'VD510.B.'||TRIM(MKBD_CD)||'|'||DECODE(MKBD_CD,'A','','B','','C','','T','',TRIM(JENIS_CD))||'|'||
							    TRIM(LAWAN)||'|'||TRIM(TO_CHAR(EXTENT_DT,'DD/MM/YYYY'))||'|'||
							    TRIM(TO_CHAR(DUE_DATE,'DD/MM/YYYY'))||'|'||
							    TRIM(TO_CHAR(REPO_VAL,'9999999999999999990.99'))||'|'||
							    TRIM(TO_CHAR(RETURN_VAL,'9999999999999999990.99'))||'|'||
							    TRIM(STK_CD)||'|'||
							    TRIM(TO_CHAR(SUM_QTY,'9999999999999999999999999990.99'))||'|'||
							    TRIM(TO_CHAR(MARKET_VAL,'9999999999999999999999999990.99'))||'|'||
							    TRIM(TO_CHAR(RANKING,'9999999999999999999999999990.99'))
							    AS text_vd510b
							    FROM insistpro_rpt.LAP_MKBD_VD510B where APPROVED_STAT ='A' 
							     and update_seq = '$update_seq' and update_date = '$update_date' ";
						$datavd510b = Lapmkbdvd51::model()->findAllBySql($sql10b);
						
						$sql10c="select 'VD510.C.'||TRIM(MKBD_CD)||'||'||DECODE(MKBD_CD,'A','','B','','C','','D','','E','','T','',TRIM(STK_CD))||'|'||
								   DECODE(MKBD_CD,'A','','B','','C','','D','','E','','T','', TRIM(AFILIASI))||'|'||
								   DECODE(MKBD_CD,'A','','B','','C','','D','','E','','T','', TRIM(TO_CHAR(QTY,'99999999999999999999999999990.99')))||'|'||
								   DECODE(MKBD_CD,'A','','B','','C','','D','','E','','T','', TRIM(TO_CHAR(BUY_PRICE,'99999999999999999999999999990.99')))||'|'||
								   DECODE(MKBD_CD,'A','','B','','C','','D','','E','','T','',  TRIM(TO_CHAR(PRICE,'99999999999999999999999999990.99')))||'|'||
								   TRIM(TO_CHAR(MARKET_VAL,'99999999999999999999999999990.99'))||'|'||
								   DECODE(MKBD_CD,'A','','B','','C','','D','','E','','T','',TRIM(GRP_EMITENT))||'|'||
								   DECODE(MKBD_CD,'A','','B','','C','','D','','E','','T','', TRIM(TO_CHAR(PERSEN_MARKET,'99999999999999999999999999990.99')))||'|'||
								   TRIM(TO_CHAR(RANKING,'99999999999999999999999999990.99'))
								   as text_vd510c
								   from  insistpro_rpt.LAP_MKBD_VD510C where
								    approved_stat='A' and update_seq = '$update_seq' and update_date = '$update_date'
								    order by DECODE(substr(mkbd_cd,3),NULL,'Z','A')||SUBSTR(MKBD_CD,1,1)||TO_CHAR(to_number(nvl(substr(mkbd_cd,3),999)),'FM000')
									,mkbd_cd  ";
						$datavd510c = Lapmkbdvd51::model()->findAllBySql($sql10c);
						
						
						
						
						$sql10d =" select 'VD510.D.'||TRIM(MKBD_CD)||'|'||DECODE(MKBD_CD,'A','','B','','T','',TRIM(SID))||'|'||
									DECODE(MKBD_CD,'A','','B','','T','',TRIM(TRX_TYPE))||'|'||
								   TRIM(TO_CHAR(END_BAL,'99999999999999999999999999990.99'))||'|'||
								   TRIM(TO_CHAR(STK_VAL,'99999999999999999999999999990.99'))||'|'||
								   DECODE(MKBD_CD,'A','','B','','T','',TRIM(TO_CHAR(RATIO,'99999999999999999999999999990.99')))||'|'||
								   TRIM(TO_CHAR(LEBIH_CLIENT,'99999999999999999999999999990.99'))||'|'||
								   TRIM(TO_CHAR(LEBIH_PORTO,'99999999999999999999999999990.99'))||'|||'
								   AS text_vd510d
								from insistpro_rpt.LAP_MKBD_VD510D
								Where approved_stat='A' and update_seq = '$update_seq' and update_date = '$update_date'
								Order By substr(mkbd_cd,1,1), 
								to_number(nvl(substr(mkbd_cd,3),999))";	
						$datavd510d = Lapmkbdvd51::model()->findAllBySql($sql10d);
						
						$sql10e ="select 'VD510.E.'||TRIM(MKBD_CD)||'||'||DECODE(MKBD_CD,'T','',TRIM(STK_CD))||'|'||
							      TRIM(TO_CHAR(QTY,'9999999999999999990.99'))||'|'||
							      TRIM(TO_CHAR(PRICE,'9999999999999999990.99'))||'|'||
							      TRIM(TO_CHAR(MARKET_VAL,'9999999999999999990.99'))||'|||||'
								  AS text_vd510e
								  from insistpro_rpt.LAP_MKBD_VD510E
								  Where approved_stat='A' and update_seq = '$update_seq' and update_date = '$update_date' ";
						$datavd510e = Lapmkbdvd51::model()->findAllBySql($sql10e);
						
						
						$sql10f = "select 'VD510.F.' || TRIM(MKBD_CD) || '|' ||
									DECODE(GRP,'D',TRIM(TO_CHAR(TGL_KONTRAK,'DD/MM/YYYY')),'') || '|' ||
									DECODE(GRP,'D',TRIM(JENIS_PENJAMINAN),'') || '|' ||
									DECODE(GRP,'D',TRIM(STK_NAME),'') || '|' ||
									DECODE(GRP,'D',TRIM(STATUS_PENJAMINAN),'') || '|' ||
									TRIM(TO_CHAR(NILAI_KOMITMENT,'999999999999999990.99')) || '|' ||
									CASE 
										WHEN GRP = 'D' OR HAIRCUT <> 0 THEN
											TRIM(TO_CHAR(HAIRCUT,'999999999999999990.99')) || '|'
										ELSE
											'|' 
									END ||
									CASE 
										WHEN GRP = 'D' OR UNSUBSCRIBE_AMT <> 0 THEN
											TRIM(TO_CHAR(UNSUBSCRIBE_AMT,'999999999999999990.99')) || '|'
										ELSE
											'|' 
									END ||
									CASE 
										WHEN GRP = 'D' OR BANK_GARANSI <> 0 THEN
											TRIM(TO_CHAR(BANK_GARANSI,'999999999999999990.99')) || '|'
										ELSE
											'|' 
									END ||
							    	TRIM(TO_CHAR(RANKING,'999999999999999990.99')) || '|' 
									AS text_vd510f
									from insistpro_rpt.LAP_MKBD_VD510F
									Where approved_stat='A' 
									and update_seq = '$update_seq' and update_date = '$update_date' ";			
									
						$datavd510f = Lapmkbdvd51::model()->findAllBySql($sql10f);
						
						
						$sql10g="select 'VD510.G.'||TRIM(MKBD_CD)||'|'||
							    TRIM(TO_CHAR(CONTRACT_DT,'DD/MM/YYY'))||'|'||
							    TRIM(GUARANTEED)||'|'||
							    TRIM(AFILIASI)||'|'||
							    TRIM(RINCIAN)||'|'||
							    TRIM(JANGKA)||'|'||
							    TRIM(TO_CHAR(END_CONTRACT_DT,'DD/MM/YYYY'))||'|'||
							    TRIM(TO_CHAR(NILAI,'999999999999999990.99'))||'|'||
							    TRIM(TO_CHAR(RANKING,'999999999999999990.99'))||'||'
							    as text_vd510g
							    FROM insistpro_rpt.LAP_MKBD_VD510G Where approved_stat='A' 
							   and update_seq = '$update_seq' and update_date = '$update_date' ";
						$datavd510g = Lapmkbdvd51::model()->findAllBySql($sql10g);	
						
						$sql10h="select 'VD510.H.'||TRIM(MKBD_CD)||'|'||
								   TRIM(TO_CHAR(TGL_KOMITMEN,'DD/MM/YYYY'))||'|'||
								  TRIM(RINCIAN)||'|'||
								  TRIM(TO_CHAR(TGL_REALISASI,'DD/MM/YYYY'))||'|'||
								  TRIM(TO_CHAR(SUDAH_REAL,'9999999999999999990.99'))||'|'||
								  TRIM(TO_CHAR(BELUM_REAL,'9999999999999999990.99'))||'|'||
								  TRIM(TO_CHAR(RANKING,'9999999999999999990.99'))||'||||'
								  as text_vd510h
								  FROM insistpro_rpt.LAP_MKBD_VD510H Where approved_stat='A' 
							    and update_seq = '$update_seq' and update_date = '$update_date' ";
		    			$datavd510h = Lapmkbdvd51::model()->findAllBySql($sql10h);	
						
						$sql10i="select 'VD510.I.'||TRIM(MKBD_CD)||'|'||
								   TRIM(JENIS_TRX)||'|'||
								   TRIM(TO_CHAR(TGL_TRX,'DD/MM/YYYY'))||'|'||
								  TRIM(CURRENCY_TYPE)||'|'||
								  TRIM(TO_CHAR(NILAI_RPH,'9999999999999999990.99'))||'|'||
								  TRIM(TO_CHAR(UNTUNG_RUGI,'9999999999999999990.99'))||'|'||
								  TRIM(TO_CHAR(RANKING,'9999999999999999990.99'))||'||||'
								  as text_vd510i
								  FROM insistpro_rpt.LAP_MKBD_VD510I Where approved_stat='A' 
							    and update_seq = '$update_seq' and update_date = '$update_date' ";
						$datavd510i = Lapmkbdvd51::model()->findAllBySql($sql10i);							
						
						$file = fopen("upload/mkbd_report/$kode_AB$date.MKB","w");
						//WRITE FILE
						fwrite($file, "Kode AB|$kode_AB|||||||||\r\n");
						fwrite($file, "Tanggal|$date_AB|||||||||\r\n");
						fwrite($file, "Direktur|$direktur|||||||||\r\n");
						//WRITE VD51
						foreach($datavd51 as $row){
						fwrite($file, $row->text_vd51."\r\n");	
						}
						//WRITE VD52
						foreach($datavd52 as $row){
						fwrite($file, $row->text_vd52."\r\n");	
						}
						//WRITE VD53
						foreach($datavd53 as $row){
						fwrite($file, $row->text_vd53."\r\n");	
						}
						//WRITE VD54
						if($datavd54)
						{
							foreach($datavd54 as $row)
							{
							fwrite($file, $row->text_vd54."\r\n");	
							}
						}
						else{
							fwrite($file, "VD54.T||||||||||\r\n");	
						}
						
						//WRITE VD55
						if($datavd55)
						{
							foreach($datavd55 as $row)
							{
								fwrite($file, $row->text_vd55."\r\n");	
							}
						}
						else
						{
						fwrite($file, "VD55.T||||||||||\r\n");		
						}
						//WRITE VD56
						foreach($datavd56a as $row){
						fwrite($file, $row->text_vd56a."\r\n");	
						}
						foreach($datavd56b as $row){
						fwrite($file, $row->text_vd56b."\r\n");	
						}
						fwrite($file, "VD56.P||||||||||\r\n");
						//WRITE VD57
						foreach($datavd57 as $row){
						fwrite($file, $row->text_vd57."\r\n");	
						}
						fwrite($file, "VD57.P||||||||||\r\n");
						//WRITE VD58
						foreach($datavd58 as $row){
						fwrite($file, $row->text_vd58."\r\n");	
						}
						//WRITE VD59
						foreach($datavd59 as $row){
						fwrite($file, $row->text_vd59."\r\n");	
						}
						//WRITE VD510A
						if(count($datavd10a)>4){
							foreach($datavd10a as $row){
							fwrite($file, $row->text_vd510a."\r\n");		
							}
						}
						else{
						fwrite($file, "VD510.A.A||||||||||\r\n");
						fwrite($file, "VD510.A.B||||||||||\r\n");
						fwrite($file, "VD510.A.C||||||||||\r\n");
						fwrite($file, "VD510.A.T||||||||||\r\n");	
						}
						
						//WRITE VD510B
						if(count($datavd510b)>4)
						{
							foreach($datavd510b as $row)
							{
							fwrite($file, $row->text_vd510b."\r\n");	
							}
						}
						else 
						{
							fwrite($file, "VD510.B.A||||||||||\r\n");
							fwrite($file, "VD510.B.B||||||||||\r\n");
							fwrite($file, "VD510.B.C||||||||||\r\n");
							fwrite($file, "VD510.B.T||||||||||\r\n");	
						}
						
						//WRITE VD510C
						if($datavd510c)
						{
							foreach($datavd510c as $row)
							{
							fwrite($file, $row->text_vd510c."\r\n");	
							}	
						}
						else 
						{
							fwrite($file, "VD510.C.A||||||||||\r\n");
							fwrite($file, "VD510.C.B||||||||||\r\n");
							fwrite($file, "VD510.C.C||||||||||\r\n");
							fwrite($file, "VD510.C.D||||||||||\r\n");
							fwrite($file, "VD510.C.E||||||||||\r\n");
							fwrite($file, "VD510.C.T||||||||||\r\n");	
						}
						
						
						//WRITE VD510D
						if($datavd510d)
						{
							foreach($datavd510d as $row)
							{
							fwrite($file, $row->text_vd510d."\r\n");	
							}
						}
						else 
						{
							fwrite($file, "VD510.D.A||||||||||\r\n");
							fwrite($file, "VD510.D.B||||||||||\r\n");
							fwrite($file, "VD510.D.T||||||||||\r\n");
						}
						
						
						//WRITE VD510E
						if($datavd510e)
						{
							foreach($datavd510e as $row)
							{
							fwrite($file, $row->text_vd510e."\r\n");	
							}
						}
						else 
						{
							fwrite($file, "VD510.E.T||||||||||\r\n");	
						}
						
						
						//WRITE VD510F
						if($datavd510f){
						foreach($datavd510f as $row){
						fwrite($file, $row->text_vd510f."\r\n");	
						}
						}
						else{
							fwrite($file, "VD510.F.A||||||||||\r\n");
							fwrite($file, "VD510.F.B||||||||||\r\n");
							fwrite($file, "VD510.F.C||||||||||\r\n");
							fwrite($file, "VD510.F.D||||||||||\r\n");
							fwrite($file, "VD510.F.T||||||||||\r\n");
						}
						
						//WRITE VD510G
						if($datavd510g){
						foreach($datavd510g as $row){
						fwrite($file, $row->text_vd510g."\r\n");	
						}
						}
						else{
						fwrite($file,"VD510.G.T||||||||||\r\n");	
						}
						//WRITE VD510H
						
						if($datavd510h){
						foreach($datavd510h as $row){
						fwrite($file, $row->text_vd510h."\r\n");	
						}	
						}
						else
						{
							fwrite($file,"VD510.H.T||||||||||\r\n");
						}
						
						//WRITE VD510I
						if($datavd510i){
							foreach($datavd510i as $row){
							fwrite($file, $row->text_vd510i."\r\n");		
							}
						}
						else{
						fwrite($file,"VD510.I.T||||||||||\r\n");	
						}
						
						
						fclose($file);
						
						//DOWNLOAD FILE LTH
						$filename = "upload/mkbd_report/$kode_AB$date.MKB";
						header("Cache-Control: public");
						header("Content-Description: File Transfer");
						header("Content-Length: ". filesize("$filename").";");
						header("Content-Disposition: attachment; filename=$kode_AB$date.MKB");
						header("Content-Type: application/octet-stream; "); 
						header("Content-Transfer-Encoding: binary");
						ob_clean();
				        flush();
						readfile($filename);
						unlink("upload/mkbd_report/$kode_AB$date.MKB");
						exit;
					
		}
		else 
		{
			//Yii::app()->user->setFlash('danger', 'Fail Save MKBD text file ');
			//$this->redirect(array('index'));
		}
		
			$this->render('list',array(
			'model'=>$model,
			'modelSave'=>$modelSave
		));
		
	}
	
	
	public function actionPrint($update_date,$update_seq)
	{
		$model = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD51','Report_VD51.rptdesign');
		$urlvd51 ='';
		$urlvd52 ='';
		$urlvd53 ='';
		$urlvd54 ='';
		$urlvd55 ='';
		$urlvd56 ='';
		$urlvd57 ='';
		$urlvd58 ='';
		$urlvd59 ='';
		$urlvd510a ='';
		$urlvd510b ='';
		$urlvd510c ='';
		$urlvd510d ='';
		$urlvd510e ='';
		$urlvd510f ='';
		$urlvd510g ='';
		$urlvd510h ='';
		$urlvd510i ='';
		$label_header='';
		$urlprint='';
		$mkbd_date = Vlapmkbdvd51::model()->find(array('condition'=>"update_date='$update_date' and update_seq = '$update_seq' "))->mkbd_date;
		if(DateTime::createFromFormat('Y-m-d H:i:s',$mkbd_date)) $mkbd_date =  DateTime::createFromFormat('Y-m-d H:i:s',$mkbd_date)->format('Y-m-d');
		//$approved_stat = Tmanyheader::model()->find("update_date='$update_date' and update_seq='$update_seq' ")->approved_status;
		//24jan2017
		//dganti karena t_many_header dibackup tiap pagi hari, sehingga update_date dan update_Seq yang dipilih tidak ada lagi di t_many_header
		$approved_stat=Vlapmkbdvd51::model()->find(array('condition'=>"update_date='$update_date' and update_seq = '$update_seq' "))->approved_stat;
		$date_header = DateTime::createFromFormat('Y-m-d',$mkbd_date)->format('d-M-Y');
		$label_header = $approved_stat=='A'?'Report MKBD Approved at '.$date_header:'Report MKBD Not Approved at '.$date_header;
		
		
		if(isset($_POST['Rptmkbdreport']))
		{
			$model->attributes = $_POST['Rptmkbdreport'];
			$scenario = $_POST['scenario'];
			
			$user_id =  Yii::app()->user->id;
			
			
			if($scenario =='selected')
			{
				if($model->vd51){
				$modelvd51 = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD51','LAP_MKBD_VD51.rptdesign');
				$modelvd51->vp_userid = $user_id;
				$modelvd51->trx_date = $mkbd_date;
				$modelvd51->approved_stat = $approved_stat;
				$urlvd51 = $modelvd51->showLapMKBD($update_date, $update_seq);
				}
				
				if($model->vd52){
				$modelvd52 = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD52','LAP_MKBD_VD52.rptdesign');
				$modelvd52->vp_userid = $user_id;
				$modelvd52->trx_date = $mkbd_date;
				$modelvd52->approved_stat = $approved_stat;
				$urlvd52 = $modelvd52->showLapMKBD($update_date, $update_seq);
				}
				
				if($model->vd53){
				$modelvd53 = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD53','LAP_MKBD_VD53.rptdesign');
				$modelvd53->vp_userid = $user_id;
				$modelvd53->trx_date = $mkbd_date;
				$modelvd53->approved_stat = $approved_stat;
				$urlvd53 = $modelvd53->showLapMKBD($update_date, $update_seq);
				}
				
				if($model->vd54){
				$modelvd54 = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD54','LAP_MKBD_VD54.rptdesign');
				$modelvd54->vp_userid = $user_id;
				$modelvd54->trx_date = $mkbd_date;
				$modelvd54->approved_stat = $approved_stat;
				$urlvd54 = $modelvd54->showLapMKBD($update_date, $update_seq);
				}
				
				if($model->vd55){
				$modelvd55 = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD55','LAP_MKBD_VD55.rptdesign');
				$modelvd55->trx_date = $mkbd_date;
				$modelvd55->vp_userid = $user_id;
				$modelvd55->approved_stat = $approved_stat;
				$urlvd55 = $modelvd55->showLapMKBD($update_date, $update_seq);
				}
				
				if($model->vd56){
				$modelvd56 = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD56','LAP_MKBD_VD56.rptdesign');
				$modelvd56->trx_date = $mkbd_date;
				$modelvd56->vp_userid = $user_id;
				$modelvd56->approved_stat =$approved_stat;
				$urlvd56 = $modelvd56->showLapMKBD($update_date, $update_seq);
				}
				
				if($model->vd57){
				$modelvd57 = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD57','LAP_MKBD_VD57.rptdesign');
				$modelvd57->trx_date = $mkbd_date;
				$modelvd57->vp_userid = $user_id;
				$modelvd57->approved_stat =$approved_stat;
				$urlvd57 = $modelvd57->showLapMKBD($update_date, $update_seq);
				}
				
				if($model->vd58){
				$modelvd58 = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD58','LAP_MKBD_VD58.rptdesign');
				$modelvd58->trx_date = $mkbd_date;
				$modelvd58->vp_userid =  $user_id;
				$modelvd58->approved_stat =$approved_stat;
				$urlvd58 = $modelvd58->showLapMKBD($update_date, $update_seq);
				}
			
				if($model->vd59){
				$modelvd59 = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD59','LAP_MKBD_VD59.rptdesign');
				$modelvd59->trx_date = $mkbd_date;
				$modelvd59->vp_userid = $user_id;
				$modelvd59->approved_stat =$approved_stat;
				$urlvd59 = $modelvd59->showLapMKBD($update_date, $update_seq);
				}
					
				if($model->vd510a){
				$modelvd510a = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD510A','LAP_MKBD_VD510A.rptdesign');
				$modelvd510a->trx_date = $mkbd_date;
				$modelvd510a->vp_userid = $user_id;
				$modelvd510a->approved_stat =$approved_stat;
				$urlvd510a = $modelvd510a->showLapMKBD($update_date, $update_seq);
				}
				
				if($model->vd510b){
				$modelvd510b = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD510B','LAP_MKBD_VD510B.rptdesign');
				$modelvd510b->trx_date =  $mkbd_date;
				$modelvd510b->vp_userid = $user_id;
				$modelvd510b->approved_stat =$approved_stat;
				$urlvd510b = $modelvd510b->showLapMKBD($update_date, $update_seq);
				}
				
				if($model->vd510c){
				$modelvd510c = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD510C','LAP_MKBD_VD510C.rptdesign');
				$modelvd510c->trx_date =  $mkbd_date;
				$modelvd510c->vp_userid = $user_id;
				$modelvd510c->approved_stat =$approved_stat;
				$urlvd510c = $modelvd510c->showLapMKBD($update_date, $update_seq);
				}
				
				if($model->vd510d){
				$modelvd510d = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD510D','LAP_MKBD_VD510D.rptdesign');
				$modelvd510d->trx_date = $mkbd_date;
				$modelvd510d->vp_userid = $user_id;
				$modelvd510d->approved_stat =$approved_stat;
				$urlvd510d = $modelvd510d->showLapMKBD($update_date, $update_seq);
				}
			
				if($model->vd510e){
				$modelvd510e = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD510E','LAP_MKBD_VD510E.rptdesign');
				$modelvd510e->trx_date = $mkbd_date;
				$modelvd510e->vp_userid =  $user_id;
				$modelvd510e->approved_stat = $approved_stat;
				$urlvd510e = $modelvd510e->showLapMKBD($update_date, $update_seq);
				}
				
				if($model->vd510f){
				$modelvd510f = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD510F','LAP_MKBD_VD510F.rptdesign');
				$modelvd510f->trx_date = $mkbd_date;
				$modelvd510f->vp_userid = $user_id;
				$modelvd510f->approved_stat =$approved_stat;
				$urlvd510f = $modelvd510f->showLapMKBD($update_date, $update_seq);
				}
					
				if($model->vd510g){
				$modelvd510g = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD510G','LAP_MKBD_VD510G.rptdesign');
				$modelvd510g->trx_date = $mkbd_date;
				$modelvd510g->vp_userid = $user_id;
				$modelvd510g->approved_stat =$approved_stat;
				$urlvd510g = $modelvd510g->showLapMKBD($update_date, $update_seq);
				}
				
				if($model->vd510h){
				$modelvd510h = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD510H','LAP_MKBD_VD510H.rptdesign');
				$modelvd510h->trx_date = $mkbd_date;
				$modelvd510h->vp_userid = $user_id;
				$modelvd510h->approved_stat =$approved_stat;
				$urlvd510h = $modelvd510h->showLapMKBD($update_date, $update_seq);
				}
			
				if($model->vd510i){
				$modelvd510i = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD510I','LAP_MKBD_VD510I.rptdesign');
				$modelvd510i->trx_date =  $mkbd_date;
				$modelvd510i->vp_userid =$user_id;
				$modelvd510i->approved_stat =$approved_stat;
				$urlvd510i = $modelvd510i->showLapMKBD($update_date, $update_seq);
				}
			}
			//print all report
			else 
			{
				$modelprint = new Rptmkbdreport('Generate_MKBD_Report','LAP_MKBD_VD510I','ALL_MKBD_REV.rptdesign');
				$modelprint->approved_stat = $approved_stat;
				$modelprint->vp_userid = $user_id;
				$modelprint->trx_date=$mkbd_date;
				if($model->r_1)
				{
				$modelprint->p_vd51 = 'Y';
				}
				else
				{
					$modelprint->p_vd51 = 'N';
				}
				if($model->r_2)
				{
				$modelprint->p_vd52 = 'Y';
				}
				else
				{
					$modelprint->p_vd52 = 'N';
				}
				if($model->r_3)
				{
				$modelprint->p_vd53 = 'Y';
				}
				else
				{
					$modelprint->p_vd53 = 'N';
				}
				if($model->r_4)
				{
				$modelprint->p_vd54 = 'Y';
				}
				else
				{
					$modelprint->p_vd54 = 'N';
				}
				if($model->r_5)
				{
				$modelprint->p_vd55 = 'Y';
				}
				else
				{
					$modelprint->p_vd55 = 'N';
				}
				if($model->r_6)
				{
					$modelprint->p_vd56 = 'Y';			
				}
				else
				{
					$modelprint->p_vd56 = 'N';
				}
				if($model->r_7)
				{
				$modelprint->p_vd57 = 'Y';
				}
				else
				{
					$modelprint->p_vd57 = 'N';
				}
				if($model->r_8)
				{
				$modelprint->p_vd58 = 'Y';
				}
				else
				{
					$modelprint->p_vd58 = 'N';
				}
				if($model->r_9)
				{
				$modelprint->p_vd59 = 'Y';
				}
				else
				{
					$modelprint->p_vd59 = 'N';
				}
				if($model->r_a)
				{
				$modelprint->p_vd510a = 'Y';
				}
				else
				{
					$modelprint->p_vd510a = 'N';
				}
				if($model->r_b)
				{
				$modelprint->p_vd510b = 'Y';
				}
				else
				{
					$modelprint->p_vd510b = 'N';
				}
				if($model->r_c)
				{
				$modelprint->p_vd510c = 'Y';
				}
				else
				{
					$modelprint->p_vd510c = 'N';
				}
				if($model->r_d)
				{
				$modelprint->p_vd510d = 'Y';
				}
				else
				{
					$modelprint->p_vd510d = 'N';
				}
				if($model->r_e)
				{
				$modelprint->p_vd510e = 'Y';
				}
				else
				{
					$modelprint->p_vd510e = 'N';
				}
				if($model->r_f)
				{
				$modelprint->p_vd510f = 'Y';
				}
				else
				{
					$modelprint->p_vd510f = 'N';
				}
				if($model->r_g)
				{
				$modelprint->p_vd510g = 'Y';
				}
				else
				{
					$modelprint->p_vd510g = 'N';
				}
				if($model->r_h)
				{
				$modelprint->p_vd510h = 'Y';
				}
				else
				{
					$modelprint->p_vd510h = 'N';
				}
				if($model->r_i)
				{
				$modelprint->p_vd510i = 'Y';
				}
				else
				{
					$modelprint->p_vd510i = 'N';
				}
				
				$urlprint = $modelprint->showReportMkbd($update_date,$update_seq);
				
			}
			
		}
		
		
		
		
		$this->render('_print',array('model'=>$model,
									'urlvd51'=>$urlvd51,
									'urlvd52'=>$urlvd52,
									'urlvd53'=>$urlvd53,
									'urlvd54'=>$urlvd54,
									'urlvd55'=>$urlvd55,
									'urlvd56'=>$urlvd56,
									'urlvd57'=>$urlvd57,
									'urlvd58'=>$urlvd58,
									'urlvd59'=>$urlvd59,
									'urlvd510a'=>$urlvd510a,
									'urlvd510b'=>$urlvd510b,
									'urlvd510c'=>$urlvd510c,
									'urlvd510d'=>$urlvd510d,
									'urlvd510e'=>$urlvd510e,
									'urlvd510f'=>$urlvd510f,
									'urlvd510g'=>$urlvd510g,
									'urlvd510h'=>$urlvd510h,
									'urlvd510i'=>$urlvd510i,
									'urlprint'=>$urlprint,
									'label_header'=>$label_header));
		
	}

	public function actionCekdate(){
		$resp['status'] ='error';
		
		if(isset($_POST['tanggal']))
		{
			$tanggal=$_POST['tanggal'];
			if(DateTime::createFromFormat('d/m/Y',$tanggal))$tanggal=DateTime::createFromFormat('d/m/Y',$tanggal)->format('Y-m-d');
			
			//validation T_CLOSE_PRICE
		$cek =Tcloseprice::model()->find("stk_date = to_date('$tanggal','yyyy-mm-dd')");
		$price_dt= Tcloseprice::model()->find(array('select'=>'MAX(STK_DATE) stk_date',
				'condition'=>"stk_date between to_date('$tanggal','yyyy-mm-dd')-20 and to_date('$tanggal','yyyy-mm-dd')"));
		if(DateTime::createFromFormat('Y-m-d h:i:s',$price_dt->stk_date))$price_dt->stk_date = DateTime::createFromFormat('Y-m-d h:i:s',$price_dt->stk_date)->format('d/m/Y');
		
		if(!$cek){
			$resp['status'] = 'success';
			$resp['price_dt']=$price_dt->stk_date;
		}
		else 
		{
			$resp['status'] = 'error';
			$resp['price_dt']=$price_dt->stk_date;
			
		}
	
		}
	 echo json_encode($resp);	
	 }
	
	
	}