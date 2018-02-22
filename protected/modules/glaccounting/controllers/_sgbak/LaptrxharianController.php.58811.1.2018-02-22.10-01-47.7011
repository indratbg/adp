<?php

class  LaptrxharianController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	public function actionIndex()
	{
			$model =new Laptrxharian('LAPORAN_TRX_HARIAN','LAP_TRX_HARIAN','Lap_trx_harian.rptdesign');
			$modelData =array();
			$model->trx_date = Date('d/m/Y');
			$model->type = 0;
			$url = '';
			$success=FALSE;
			
			if(isset($_POST['scenario'])){
				$scenario =  $_POST['scenario'];
				
				if($scenario == 'filter'){
					if(isset($_POST['Laptrxharian'])){
				
			$model->attributes = $_POST['Laptrxharian'];
		if(DateTime::createFromFormat('d/m/Y',$model->trx_date))$model->trx_date = DateTime::createFromFormat('d/m/Y',$model->trx_date)->format('Y-m-d');		
	
			
			
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
				
				
			$model->ip_address = $ip;
			$model->vp_userid =  Yii::app()->user->id;
			$model->upd_status ='I';
			$model->approved_sts = 'E';
			if($model->type == 0){
				
					
			//$date = DateTime::createFromFormat('Y-m-d',$model->trx_date)->format('Y/m/d 00:00:00');
			
			
			//cek pending report
			$sql="SELECT * FROM (SELECT 
		(SELECT to_date(FIELD_VALUE,'yyyy/mm/dd hh24:mi:ss') FROM T_MANY_DETAIL DA 
		        WHERE DA.TABLE_NAME = 'LAP_TRX_HARIAN' 
		        AND DA.UPDATE_DATE = DD.UPDATE_DATE
		        AND DA.UPDATE_SEQ = DD.UPDATE_SEQ
		        AND DA.FIELD_NAME = 'TRX_DT'
		        AND DA.RECORD_SEQ = DD.RECORD_SEQ) TRX_DATE, 
		HH.APPROVED_STATUS,HH.MENU_NAME
		FROM T_MANY_DETAIL DD, T_MANY_HEADER HH WHERE DD.TABLE_NAME = 'LAP_TRX_HARIAN' AND DD.UPDATE_DATE = HH.UPDATE_DATE
          AND DD.UPDATE_SEQ = HH.UPDATE_SEQ AND DD.RECORD_SEQ = 1 
          AND DD.FIELD_NAME = 'TRX_DT' AND HH.APPROVED_STATUS = 'E')
          
          where trx_date = '$model->trx_date'
          ";
		  
		  $cek=DAO::queryAllSql($sql);
		  if($cek){
		  		Yii::app()->user->setFlash('danger', 'Masih ada belum diapprove');	
			
		  }
		  else{
		  	
		  
				$connection  = Yii::app()->dbrpt;
				$transaction = $connection->beginTransaction();
				$menuName='LAPORAN TRX HARIAN';
				if($model->validate() && $model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName)){
					$success = true;
				}
				else{
					$success=false;
				}
			//delete data lama di tanggal yang sama	
			$sql ="DELETE FROM LAP_TRX_HARIAN WHERE TRX_DT = '$model->trx_date' ";
				$delete=DAO::executeSql($sql);
			
			
			//insert into LAP_TRX_HARIAN			
			if($model->validate() && $model->executeReportGenSp()>0)$success =true;
			else {
				$success=false;
			}
			//GET CLIENT CD
			$sqlClient = "SELECT TRIM(OTHER_1) v_client FROM MST_COMPANY";
			$client = DAO::queryRowSql($sqlClient);
			$client_cd = $client['v_client'];
			
			
			$sql ="SELECT '$model->trx_date' TRX_DT, GRP, SEQNO, DESCRIP, NVL(BELI,0) beli, NVL(JUAL,0) jual				
			FROM( SELECT 1 grp, 1 SEQNO, 'PORTOFOLIO' AS DESCRIP, SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'B',VAL,0)) BELI,				
			       SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'J',VAL,0)) JUAL				
			FROM T_CONTRACTS				
			WHERE CONTR_DT = '$model->trx_date'				
			AND CONTR_STAT <> 'C'				
			AND SUBSTR(CONTR_NUM,6,1) = 'R'				
			AND (SUBSTR(CLIENT_TYPE,1,1) = 'H' OR CLIENT_CD = '$client_cd')				
			UNION				
			SELECT 1 grp, 2 SEQNO, 'NASABAH', SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'B',VAL,0)) BELI,				
			       SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'J',VAL,0)) JUAL				
			FROM T_CONTRACTS				
			WHERE CONTR_DT = '$model->trx_date'				
			AND CONTR_STAT <> 'C'				
			AND   SUBSTR(CONTR_NUM,6,1) = 'R'				
			AND (SUBSTR(CLIENT_TYPE,1,1) <> 'H' AND CLIENT_CD <> '$client_cd')				
			UNION				
			SELECT 2 grp, 3 SEQNO, 'REGULAR', SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'B',VAL,0)) BELI,				
			       SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'J',VAL,0)) JUAL				
			FROM T_CONTRACTS				
			WHERE CONTR_DT = '$model->trx_date'				
			AND CONTR_STAT <> 'C'				
			AND  SUBSTR(CONTR_NUM,6,1) = 'R'				
			AND SUBSTR(CLIENT_CD,8,1) IN ( 'R','T') 			
			AND (SUBSTR(CLIENT_TYPE,1,1) <> 'H' AND CLIENT_CD <> '$client_cd')				
			UNION				
			SELECT 2 grp, 4 SEQNO, 'MARGIN', SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'B',VAL,0)) BELI,				
			       SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'J',VAL,0)) JUAL				
			FROM T_CONTRACTS				
			WHERE CONTR_DT = '$model->trx_date'				
			AND CONTR_STAT <> 'C'				
			AND   SUBSTR(CONTR_NUM,6,1) = 'R'				
			AND SUBSTR(CLIENT_CD,8,1) = 'M' 				
			AND (SUBSTR(CLIENT_TYPE,1,1) <> 'H' AND CLIENT_CD <> '$client_cd')				
			UNION				
			SELECT 2 grp, 5 SEQNO, 'SHORT',  SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'B',VAL,0)) BELI,				
			       SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'J',VAL,0)) JUAL				
			FROM T_CONTRACTS				
			WHERE CONTR_DT = '$model->trx_date'				
			AND CONTR_STAT <> 'C'				
			AND   SUBSTR(CONTR_NUM,6,1) = 'R'				
			AND SUBSTR(CLIENT_CD,8,1) = 'S' 				
			AND (SUBSTR(CLIENT_TYPE,1,1) <> 'H' AND CLIENT_CD <> '$client_cd')				
			UNION				
			SELECT 3 grp, 6 SEQNO, 'LOKAL', SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'B',VAL,0)) BELI,				
			       SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'J',VAL,0)) JUAL				
			FROM T_CONTRACTS				
			WHERE CONTR_DT = '$model->trx_date'				
			AND CONTR_STAT <> 'C'				
			AND   SUBSTR(CONTR_NUM,6,1) = 'R'				
			AND SUBSTR(CLIENT_TYPE,2,1) = 'L' 				
			AND (SUBSTR(CLIENT_TYPE,1,1) <> 'H' AND CLIENT_CD <> '$client_cd')				
			UNION				
			SELECT 3 grp, 7 SEQNO, 'ASING', SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'B',VAL,0)) BELI,				
			       SUM(DECODE(SUBSTR(CONTR_NUM,5,1),'J',VAL,0)) JUAL				
			FROM T_CONTRACTS				
			WHERE CONTR_DT = '$model->trx_date'				
			AND CONTR_STAT <> 'C'				
			AND   SUBSTR(CONTR_NUM,6,1) = 'R'				
			AND SUBSTR(CLIENT_TYPE,2,1) = 'F'				
			AND (SUBSTR(CLIENT_TYPE,1,1) <> 'H' AND CLIENT_CD <> '$client_cd') ) 				
					
							"; 
			
			$modelData =Tcontracts::model()->findAllBySql($sql);
			
			$record_seq = 1;
			foreach($modelData as $row){
					$model->trx_date = $row->trx_dt;
					$model->grp = $row->grp;
					$model->seqno = $row->seqno;
					$model->descrip = $row->descrip;
					$model->beli = $row->beli;
					$model->jual = $row->jual;
					$model->approved_sts = 'E';
					$model->upd_status = 'I';
				//INSERT INTO T_TEMP
				if($model->validate() && $model->executeSp($record_seq)>0)$success=true;
				else{$success=false;}
				$record_seq++;
			}
			
			
					if($success){
					 
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Generate');
						$this->redirect(array('/glaccounting/Laptrxharian/index'));
					}
					else{
						$transaction->rollback();
					}
					}//end type 1
					
					}//end cek pending
					
					
					
					
					
				else{//print report
				// $model->attributes = $_POST['Laptrxharian'];
		// if(DateTime::createFromFormat('d/m/Y',$model->trx_date))$model->trx_date = DateTime::createFromFormat('d/m/Y',$model->trx_date)->format('Y-m-d');
				// $sql ="DELETE FROM LAP_TRX_HARIAN WHERE TRX_DT = '$model->trx_date' and approved_sts='A'";
				// $delete=DAO::executeSql($sql);
// 				
				//	$model->approved_stat='A';
					$url = $model->showReport();
				
				}
			}
			
				}//end filter
	else{//save to txt file
	$model->attributes = $_POST['Laptrxharian'];
	if(DateTime::createFromFormat('d/m/Y',$model->trx_date))$model->trx_date = DateTime::createFromFormat('d/m/Y',$model->trx_date)->format('Y-m-d');
		
	//GROUP 1
	$model->vp_userid =  Yii::app()->user->id;
	
	$cek=Laptrxharianinbox::model()->find("trx_dt = '$model->trx_date' and approved_sts='A'  ");
	if($cek){
	$portofolio_beli = Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A'  and seqno=1"))->beli;				
	$portofolio_jual = Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A'  and seqno=1"))->jual;				
	$total_portofolio = Laptrxharianinbox::model()->find(array('select'=>"sum(beli+jual) as total_portofolio",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A'  and seqno=1"))->total_portofolio;
	$nasabah_beli = Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A'  and seqno=2"))->beli;
	$nasabah_jual = Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A'   and seqno=2"))->jual;
	$total_nasabah = Laptrxharianinbox::model()->find(array('select'=>"sum(beli+jual) as total_nasabah",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=2 "))->total_nasabah;
	//TOTAL GROUP 1				
	$total_trx_beli_1 = Laptrxharianinbox::model()->find(array('select'=>"sum(beli) as total_trx_beli_1",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and grp=1 ",'group'=>'grp'))->total_trx_beli_1;				
	$total_trx_jual_1 = Laptrxharianinbox::model()->find(array('select'=>"sum(jual) as total_trx_jual_1",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and grp=1 ",'group'=>'grp'))->total_trx_jual_1;	
	$total_trx_1 = Laptrxharianinbox::model()->find(array('select'=>"sum(beli+jual) as total_trx_1",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and grp=1 ",'group'=>'grp'))->total_trx_1;	
	//GROUP 2
	$reguler_beli =Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=3 "))->beli;
	$reguler_jual =Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=3 "))->jual;
	$total_reguler =  Laptrxharianinbox::model()->find(array('select'=>"sum(beli+jual) as total_reguler",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=3 "))->total_reguler;
	$margin_beli =Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=4 "))->beli;				
	$margin_jual =Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=4 "))->jual;
	$total_margin =  Laptrxharianinbox::model()->find(array('select'=>"sum(beli+jual) as total_margin",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=4 "))->total_margin;		
	$short_beli =Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=5 "))->beli;
	$short_jual =Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=5 "))->jual;					
	$total_short =  Laptrxharianinbox::model()->find(array('select'=>"sum(beli+jual) as total_short",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=5 "))->total_short;							
	//TOTAL GROUP 2				
	$total_trx_beli_2 = Laptrxharianinbox::model()->find(array('select'=>"sum(beli) as total_trx_beli_2",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and grp=2 ",'group'=>'grp'))->total_trx_beli_2;
	$total_trx_jual_2 = Laptrxharianinbox::model()->find(array('select'=>"sum(jual) as total_trx_jual_2",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and grp=2 ",'group'=>'grp'))->total_trx_jual_2;
	$total_trx_2 = Laptrxharianinbox::model()->find(array('select'=>"sum(beli+jual) as total_trx_2",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and grp=2 ",'group'=>'grp'))->total_trx_2;	
	//GROUP 3
	$lokal_beli =Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=6 "))->beli;
	$lokal_jual =Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=6 "))->jual;
	$total_lokal =  Laptrxharianinbox::model()->find(array('select'=>"sum(beli+jual) as total_lokal",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=6 "))->total_lokal;
	$asing_beli =Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=7 "))->beli;				
	$asing_jual =Laptrxharianinbox::model()->find(array('condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=7 "))->jual;
	$total_asing =  Laptrxharianinbox::model()->find(array('select'=>"sum(beli+jual) as total_asing",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and seqno=7 "))->total_asing;		
		
	//TOTAL GROUP 3				
	$total_trx_beli_3 = Laptrxharianinbox::model()->find(array('select'=>"sum(beli) as total_trx_beli_3",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and grp=3 ",'group'=>'grp'))->total_trx_beli_3;
	$total_trx_jual_3 = Laptrxharianinbox::model()->find(array('select'=>"sum(jual) as total_trx_jual_3",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and grp=3 ",'group'=>'grp'))->total_trx_jual_3;
	$total_trx_3 = Laptrxharianinbox::model()->find(array('select'=>"sum(beli+jual) as total_trx_3",	
					'condition'=>"trx_dt='$model->trx_date' and approved_sts='A' and grp=3 ",'group'=>'grp'))->total_trx_3;	
	
	
	// var_dump(number_format((float)$portofolio_beli,2,'.',''));
	// die();		
	//FORMAT NUMBER ALL VALIABLE
	//GROUP 1
	$portofolio_beli = number_format((float)$portofolio_beli,2,'.','');				
	$portofolio_jual = number_format((float)$portofolio_jual,2,'.','');						
	$total_portofolio = number_format((float)$total_portofolio,2,'.',''); 
	$nasabah_beli = number_format((float)$nasabah_beli,2,'.','');
	$nasabah_jual = number_format((float)$nasabah_jual,2,'.','');
	$total_nasabah =number_format((float)$total_nasabah,2,'.','');
					
	//TOTAL GROUP 1				
	$total_trx_beli_1 = number_format((float)$total_trx_beli_1,2,'.',''); 								
	$total_trx_jual_1 = number_format((float)$total_trx_jual_1,2,'.','');
	$total_trx_1 =number_format((float)$total_trx_1,2,'.','');
	//GROUP 2
	$reguler_beli =number_format((float)$reguler_beli,2,'.','');
	$reguler_jual =number_format((float)$reguler_jual,2,'.','');
	$total_reguler =number_format((float)$total_reguler,2,'.','');
	$margin_beli =number_format((float)$margin_beli,2,'.','');				
	$margin_jual =number_format((float)$margin_jual,2,'.','');
	$total_margin =number_format((float)$total_margin,2,'.','');
	$short_beli =number_format((float)$short_beli,2,'.','');
	$short_jual =number_format((float)$short_jual,2,'.','');					
	$total_short =number_format((float)$total_short,2,'.','');					
	//TOTAL GROUP 2				
	$total_trx_beli_2 =number_format((float)$total_trx_beli_2,2,'.',''); 
	$total_trx_jual_2 = number_format((float)$total_trx_jual_2,2,'.','');
	$total_trx_2 = number_format((float)$total_trx_2,2,'.','');
	//GROUP 3
	$lokal_beli = number_format((float)$lokal_beli,2,'.','');
	$lokal_jual =number_format((float)$lokal_jual,2,'.','');
	$total_lokal =number_format((float)$total_lokal,2,'.','');
	$asing_beli =number_format((float)$asing_beli,2,'.','');				
	$asing_jual = number_format((float)$asing_jual,2,'.','');
	$total_asing =number_format((float)$total_asing,2,'.','');		
		
	//TOTAL GROUP 3				
	$total_trx_beli_3 = number_format((float)$total_trx_beli_3,2,'.',''); 
	$total_trx_jual_3 =number_format((float)$total_trx_jual_3,2,'.','');
	$total_trx_3 = 	number_format((float)$total_trx_3,2,'.','');
			
					
					
					
							
				$direktur = Company::model()->find()->contact_pers;
				$namaAB =  Company::model()->find()->nama_prsh;
				$kodeAB =  Parameter::model()->find(" prm_cd_1 = 'AB' and prm_cd_2 ='000' ")->prm_desc;
				$kodeAB = substr($kodeAB, 0,2);
				
			
				
				$date =  DateTime::createFromFormat('Y-m-d',$model->trx_date)->format('Ymd');
				$file = fopen("upload/lap_trx_harian/$kodeAB-LTH$date.LTH","w");
				//chmod("YJ-LTH$date.LTH", 0750);
				fwrite($file, "LAPORAN TRANSAKSI HARIAN\r\n");
				fwrite($file, "NAMA AB|$namaAB||\r\n");
				fwrite($file, "KODE AB|$kodeAB||\r\n");
				fwrite($file, "TANGGAL|$date||\r\n");
				fwrite($file, "DIREKTUR|$direktur||\r\n");
				fwrite($file, "TRANSAKSI PORTOFOLIO|$portofolio_beli|$portofolio_jual|$total_portofolio\r\n");
				fwrite($file, "TRANSAKSI NASABAH|$nasabah_beli|$nasabah_jual|$total_nasabah\r\n");
				fwrite($file, "TOTAL TRANSAKSI|$total_trx_beli_1|$total_trx_jual_1|$total_trx_1\r\n");
				fwrite($file, "TRANSAKSI NASABAH REGULER|$reguler_beli|$reguler_jual|$total_reguler\r\n");
				fwrite($file, "TRANSAKSI NASABAH MARGIN|$margin_beli|$margin_jual|$total_margin\r\n");
				fwrite($file, "TRANSAKSI NASABAH SHORT SELLING|$short_beli|$short_jual|$total_short\r\n");
				fwrite($file, "TOTAL TRANSAKSI NASABAH|$total_trx_beli_2|$total_trx_jual_2|$total_trx_2\r\n");
				fwrite($file, "TRANSAKSI LOKAL|$lokal_beli|$lokal_jual|$total_lokal\r\n");
				fwrite($file, "TRANSAKSI PEMODAL ASING|$asing_beli|$asing_jual|$total_asing\r\n");
				fwrite($file, "TOTAL TRANSAKSI NASABAH|$total_trx_beli_3|$total_trx_jual_3|$total_trx_3\r\n");
				fclose($file);
				
				//DOWNLOAD FILE LTH
				$filename = "upload/lap_trx_harian/$kodeAB-LTH$date.LTH";
				header("Cache-Control: public");
				header("Content-Description: File Transfer");
				header("Content-Length: ". filesize("$filename").";");
				header("Content-Disposition: attachment; filename=$kodeAB-LTH$date.LTH");
				header("Content-Type: application/octet-stream; "); 
				header("Content-Transfer-Encoding: binary");
				ob_clean();
		        flush();
				readfile($filename);
				unlink("upload/lap_trx_harian/$kodeAB-LTH$date.LTH");
				exit;
				//DELETE FILE AFTER DOWNLOAD	
				
			}
		else{
			Yii::app()->user->setFlash('danger', 'No data found in date');
						$this->redirect(array('/glaccounting/Laptrxharian/index'));
		}
					
			
			
			
			
			
			/*
			$zip = new ZipArchive();
			$filename = "upload/lap_trx_harian/YJ-LTH$date.zip";
			
			if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
			    exit("cannot open <$filename> \r\n");
			}
			$zip->addFile("YJ-LTH$date.LTH");
			
			echo "numfiles: " . $zip->numFiles . " \r\n";
			echo "status:" . $zip->status . " \r\n";
			$zip->close();
			//unlink("YJ-LTH$date.LTH");
			
			$zippath = "upload/lap_trx_harian/";
			$filename = "YJ-LTH$date.zip";
			$file=$zippath.$filename;
			if (headers_sent()) {
			    Yii::app()->user->setFlash('danger', 'HTTP header already sent');  
			} else {
			    if (!is_file($file)) {
			        header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
			     Yii::app()->user->setFlash('danger', 'File Not Found');
			    } else if (!is_readable($file)) {
			        header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
			      Yii::app()->user->setFlash('danger', 'File not readable'); 
			    } else {
			        while (ob_get_level()) {
			            ob_end_clean();
			        }
			       ob_start();
			       header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
			       header("Content-Type: application/zip");
			       header("Content-Transfer-Encoding: Binary");
			       header("Content-Length: ".filesize($file));
			       header('Pragma: no-cache');
			       header("Content-Disposition: attachment; filename=\"".basename($file)."\"");
			       ob_flush();
			       ob_clean();
			       readfile($file);
			       exit;
			   }
			}
		
		//	unlink($filename);*/
		
			// $sql="DELETE FROM LAP_TRX_HARIAN ";
			// $exec=DAO::executeSql($sql);
		
			}//end save file
				
				
			}
			
			
	if(DateTime::createFromFormat('Y-m-d',$model->trx_date))$model->trx_date = DateTime::createFromFormat('Y-m-d',$model->trx_date)->format('d/m/Y');
			
			$this->render('index',array(
			'model'=>$model,
			'url'=>$url,
			'modelData'=>$modelData
			
		));
			
	}
	public function actionCek_date()
	{
		$resp['status'] ='error';
		
		if(isset($_POST['tanggal']))
		{
			$tanggal=$_POST['tanggal'];
			if(DateTime::createFromFormat('d/m/Y',$tanggal))$tanggal=DateTime::createFromFormat('d/m/Y',$tanggal)->format('Y-m-d');
			//$tanggal = DateTime::createFromFormat('d/m/Y',$tanggal)->format('Y-m-d');				
			$date_holiday = DateTime::createFromFormat('Y-m-d',$tanggal)->format('D');
						
			if($date_holiday =='Sat' || $date_holiday == 'Sun')
			{
				$resp['status'] = 'success';
			}
			
			else {
				$cek = Calendar::model()->find("tgl_libur = to_date('$tanggal','yyyy-mm-dd')");	
				if($cek)
				{
					$resp['status'] = 'success';	
				}	
				
				}
		}
	echo json_encode($resp);	
	}
}
?>
		