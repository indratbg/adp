<?php

class LapkeuanganconsolController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{	$url='';
		$model = new Rptlapkeuanganconsol('LAPORAN_KEUANGAN_KONSOLIDASI','LAP_LK_KONSOL','Lap_konsolidasi_keuangan.rptdesign');
		$modelDetail = new Rptlapkeuanganconsol('LAPORAN_KEUANGAN_KONSOLIDASI','R_LK_KONSOL_DETAIL','Laporan_konsolidasi_keuangan_detail.rptdesign');
		$model->end_period_dt=date('d/m/Y');
		$model->type=0;
		$model->gl_account =0;
		$model->gl_sub_account=0;
		$model->lk_acct =0;
		$model->company=0;
		$model->report_type=0;
		$success=false;
		$modelconsol = new Tlkrep;
	if(isset($_POST['Rptlapkeuanganconsol'])){
		$model->attributes = $_POST['Rptlapkeuanganconsol'];
		$model->validate();
		if(DateTime::createFromFormat('d/m/Y',$model->end_period_dt))$model->end_period_dt = DateTime::createFromFormat('d/m/Y',$model->end_period_dt)->format('Y-m-d');
		
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$model->ip_address =$ip;
			 $connection  = Yii::app()->dbrpt;
			 $transaction = $connection->beginTransaction();
		if($model->type==0)//generate
		{	$menuName='LAPORAN KEUANGAN KONSOLIDASI';
			
			
			$sql="SELECT * FROM (
					select TO_DATE(field_value,'YYYY/MM/DD HH24:MI:SS')REPORT_DATE from t_many_detail d, t_many_header h
					where d.update_date = h.update_date and d.update_seq=h.update_seq
					and h.menu_name='LAPORAN KEUANGAN KONSOLIDASI' AND TABLE_NAME ='LAP_LK_KONSOL' 
					AND FIELD_NAME='REPORT_DATE' AND H.APPROVED_STATUS='E')
					where report_date = '$model->end_period_dt'";
			$cek = DAO::queryRowSql($sql);
			if($cek){
				$date = DateTime::createFromFormat('Y-m-d',$model->end_period_dt)->format('d M Y');
				Yii::app()->user->setFlash('danger', 'Masih ada yang belum diapprove pada tanggal '.$date);
			}	
			else {
			//execute sp header
			if($model->validate() && $model->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName)>0)
			{
				$success= true;
			}
			else
			{
				$success= FALSE;
			}
			
			if($success && $model->executeSp(AConstant::INBOX_STAT_INS, 1)>0)
			{
				$success=true;
			}
			else 
			{
			$success=false;	
			}
			//execute sp report
			if($success && $model->executeSpRpt()>0)
			{
				
				$success=true;
			}
			else 
			{

			$success=false;	
			}
				
		
			if($success)
			{ 	$transaction->commit();
				$date = DateTime::createFromFormat('Y-m-d',$model->end_period_dt)->format('d M Y');
				Yii::app()->user->setFlash('success', 'Successfully generate report at '.$date);
			}
			else{
				$transaction->rollback();
			}
			
			}//end generate
			
		}//end pilihan 1
		else if($model->type==1)//print approve
		{
			
			$model->trx_date = $model->end_period_dt;
			$model->approved_stat ='A';
			$url=$model->showReport2();
		}
		else if($model->type == 2)//generate report detail
		{
			$modelDetail->gl_account_cd= $model->gl_account== 0?'%':$model->gl_account_cd;
			$modelDetail->gl_sub_account_cd = $model->gl_sub_account == 0?'%':$model->gl_sub_account_cd;
			$modelDetail->lk_acct_cd = $model->lk_acct==0?'%':$model->lk_acct_cd;
			$modelDetail->end_period_dt = $model->end_period_dt;
			$modelDetail->company_cd = $model->company==0?'%':$model->company_cd;
			$date = new DateTime($model->end_period_dt);
			$bgn_date = DateTime::createFromFormat('Y-m-d',$modelDetail->end_period_dt)->format('Y-m-01');
			
			
		
			if($modelDetail->validate() && $modelDetail->executeSpRptDetail($bgn_date)>0)
			{
			$transaction->commit();
			$url = $modelDetail->showReport();
			
			}
			else{
				$transaction->rollback();
			}
			
		}
		
		else if($model->type==3)//print unapproved
		{
			$model->trx_date = $model->end_period_dt;
			$model->approved_stat ='E';
			$url=$model->showReport2();
		}
		else if($model->type==4)//generate LKK text File
		{
				
				$sql="SELECT R.COL1||'|'||R.COL2||'|'||R.COL3||'|'||R.COL4||'|'||DECODE(NVL(ISI5,0),1,R.COL5,'')||'||||'
						
						AS TEXT
						FROM insistpro_rpt.LAP_LK_KONSOL r, FORM_LK f 
						WHERE r.line_num = f.LINE_NUM
						AND r.approved_stat='A'
						and '$model->end_period_dt' between f.ver_bgn_dt and f.ver_end_dt
						and r.report_date='$model->end_period_dt'
						ORDER BY r.line_num";
				$data = DAO::queryAllSql($sql);
				$date = DateTime::createFromFormat('Y-m-d',$model->end_period_dt)->format('Ymd');
				$file = fopen("upload/lap_lk_konsol/YJ-$date.lkk","w");
				foreach($data as $row)
				{
				$text = $row['text'];
				fwrite($file, "$text\r\n");	
				}
				fclose($file);
				
				//DOWNLOAD FILE LTH
				$filename = "upload/lap_lk_konsol/YJ-$date.lkk";
				header("Cache-Control: public");
				header("Content-Description: File Transfer");
				header("Content-Length: ". filesize("$filename").";");
				header("Content-Disposition: attachment; filename=YJ-$date.lkk");
				header("Content-Type: application/octet-stream; "); 
				header("Content-Transfer-Encoding: binary");
				ob_clean();
		        flush();
				readfile($filename);
				unlink("upload/lap_lk_konsol/YJ-$date.lkk");
				exit;
				//DELETE FILE AFTER DOWNLOAD	
		}
		else if($model->type==5)//save report
		{
			$modelconsol->report_date = $model->end_period_dt;
			
			if($modelconsol->executeSp('S')>0){
				$success=true;
			}
			else{
				$success=false;
			}
			
			if($success){
				$transaction->commit();
				$date = DateTime::createFromFormat('Y-m-d',$model->end_period_dt)->format('d M Y');
				Yii::app()->user->setFlash('success', 'Successfully save report at '.$date);
			}
			else{
				$transaction->rollback();
			}
		}
	}

		if(DateTime::createFromFormat('Y-m-d',$model->end_period_dt))$model->end_period_dt = DateTime::createFromFormat('Y-m-d',$model->end_period_dt)->format('d/m/Y');
		
		
		
		$this->render('index',array('model'=>$model,'url'=>$url,'modelconsol'=>$modelconsol,'modelDetail'=>$modelDetail));
	}
	
	public function actionCek_date()
	{
		$resp['status'] ='error';
		
		if(isset($_POST['tanggal']))
		{
			$tanggal=$_POST['tanggal'];
			if(DateTime::createFromFormat('d/m/Y',$tanggal))$tanggal=DateTime::createFromFormat('d/m/Y',$tanggal)->format('Y-m-d');
			
				$sql="select * from insistpro_rpt.lap_lk_konsol where report_date = '$tanggal' and approved_stat='A' ";
				$cek=DAO::queryAllSql($sql);
				
				if(!$cek)
				{
				$resp['status'] ='success';
				}
				
				}
		
	echo json_encode($resp);	
	}
	
}
?>
