<?php

class ReconcilebankstmtController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	public function actionIndex()
	{	$modelReport = new Rptreconcilebankstmt('RECONCILE BANK ACCOUNT STATEMENT','R_T_BANK_STMT','Reconcile_bank_account_statement.rptdesign');
		$model = new Tbankstmt;
		$url = '';
		$model->import_type = 'DIFF';
		$model->period_from = date('01/m/Y');
		$model->period_to = date('t/m/Y');
		$modelDetail = Tbankstmt::model()->findAll(array('select'=>' distinct period_from,bank_acct_num, gl_acct_cd, sl_acct_cd',
													'order'=>'period_from desc'));
		//$modelDetail = array();
		if(isset($_POST['Tbankstmt']))
		{
			$scenario =$_POST['scenario'];
			$model->attributes = $_POST['Tbankstmt'];
			
			if($scenario == 'import'){
			
					$model->scenario='upload' ;
					if($model->validate()){
					$import_type = $model->import_type;
					
					//buat ambil file yang di upload tanpa $_FILES
					$model->file_upload = CUploadedFile::getInstance($model,'file_upload');
					
					$path = FileUpload::getFilePath(FileUpload::T_BANK_STMT,'Upload.csv' );
					$model->file_upload->saveAs($path);
					$filename = $model->file_upload;
					//insert data ke Tbankstmt
					$lines = file($path);
		 		$date=$model->period_from;
				$date2=$model->period_to;
				$gl_acct_cd = $model->gl_acct_cd;
				$sl_acct_cd = $model->sl_acct_cd;
				$bank_num='';
				foreach ($lines as $line_num => $line) 
				{	$data = str_replace('"', '',str_replace(',""', '|', $line));
					$pieces = explode("|",$data);
					if($line_num == 2)
					{
					$model->bank_acct_num = substr(trim($pieces[0]),-10);
					}
					$bank_num = $model->bank_acct_num;
					if($line_num>6 && $line_num < count($lines)-5)
					{	$line_data=explode(',',$pieces[0]);
						$tanggal = $line_data[0];
						if(DateTime::createFromFormat('d/m',$tanggal))$tanggal = DateTime::createFromFormat('d/m',$tanggal)->format('Y-m-d');
						$model->trx_date = $tanggal;
						
						$sql = "DELETE T_BANK_STMT WHERE TRX_DATE BETWEEN '$model->period_from' and '$model->period_to' and gl_acct_cd='$gl_acct_cd'
						and sl_Acct_cd= '$sl_acct_cd'";
						$exec = DAO::executeSql($sql);
					}
					
					
				}
			
				$x=1;
				foreach ($lines as $line_num => $line) 
				{
					if($line_num>6 && $line_num < count($lines)-5)
					{
						
							$data = str_replace(',""', '',str_replace(',"', '|', $line));
							$pieces = explode("|",$data);
							$model->period_from = $date;
							$model->period_to = $date2;
							$model->gl_acct_cd= $gl_acct_cd;
							$model->sl_acct_cd = $sl_acct_cd;
							$model->trx_date = str_replace('"', '', $pieces[0]);
if(DateTime::createFromFormat('d/m',$model->trx_date))$model->trx_date = DateTime::createFromFormat('d/m',$model->trx_date)->format('2015-m-d');
								$model->seqno = $x;
								$model->description = str_replace('"', '', $pieces[1]);
									
								$model->amount = str_replace(',', '',trim(str_replace(substr($pieces[3],-3),'', $pieces[3])));
								$model->db_cr_flg =str_replace('"', '', substr($pieces[3],-3));
								$model->balance = str_replace('"', '', str_replace(',', '', trim($pieces[4])));
								$model->bank_acct_num =$bank_num;
						
							// $sql="DELETE FROM T_BANK_STMT WHERE period_from = '$model->period_from' and trx_date = '$model->trx_date' and
								// seqno = '$model->seqno' and trim(gl_acct_cd) = '$model->gl_acct_cd' and sl_acct_cd = '$model->sl_acct_cd' ";
							// $exec = DAO::executeSql($sql);
						
						
						if(strtotime($model->trx_date) >= strtotime($model->period_from) && strtotime($model->trx_date) <= strtotime($model->period_to))
						{
							
						//save file upload to Tbankstmt			
							if($model->save(FALSE))
							{
							$model = new Tbankstmt();	
							}
								
						$x++;	
						}
								
								

					}//end if line!=0
		}
	
		$model->period_from = $date;
		$model->period_to = $date2;
		$model->gl_acct_cd = $gl_acct_cd;
		$model->sl_acct_cd=$sl_acct_cd;
		$model->import_type ='DIFF';
		
				//setelah di upload dan dibaca, delete file nya
			//unlink(FileUpload::getFilePath(FileUpload::IMPORT_REK_DANA,$filename ));
			Yii::app()->user->setFlash('success', 'Successfully upload '.$filename);
			//$this->redirect(array('index'));
			$modelDetail = Tbankstmt::model()->findAll(array('select'=>' distinct period_from,bank_acct_num, gl_acct_cd, sl_acct_cd',
													'order'=>'period_from desc'));
			
			}
			}//import
			
		else//report
		{
			if($model->validate())
			{
					//$modelReport->from = $model->period_from;
					$modelReport->import_type = $model->import_type;
					$modelReport->gl_acct_cd = $model->gl_acct_cd;
					$modelReport->sl_acct_cd = $model->sl_acct_cd;
					//$date = new DateTime($model->period_from);
					//$modelReport->end_date = $date->format('Y-m-t');
					$modelReport->period_from = $model->period_from;
					$modelReport->period_to = $model->period_to;
				
					if($modelReport->validate() && $modelReport->executeRpt()>0)
					{
						$url = $modelReport->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					}	
			}
			
		}
	}

foreach($modelDetail as $row)
{
	if(DateTime::createFromFormat('Y-m-d H:i:s',$row->period_from))$row->period_from = DateTime::createFromFormat('Y-m-d H:i:s',$row->period_from)->format('d M Y');
	if(DateTime::createFromFormat('Y-m-d',$row->period_from))$row->period_from = DateTime::createFromFormat('Y-m-d',$row->period_from)->format('d M Y');
}

		$this->render('index',array('model'=>$model,'url'=>$url,'modelDetail'=>$modelDetail,'modelReport'=>$modelReport));
	}

public function actionView($period_from,$gl_acct_cd, $sl_acct_cd)
{
	if(DateTime::createFromFormat('d M Y',$period_from))$period_from = DateTime::createFromFormat('d M Y',$period_from)->format('Y-m-d');
	
	$model= Tbankstmt::model()->findAll(array('condition'=>"period_from= '$period_from' and gl_acct_cd='$gl_acct_cd' and sl_acct_cd='$sl_acct_cd' ",'order'=>'trx_date'));
	

foreach($model as $row)
{
	if(DateTime::createFromFormat('Y-m-d H:i:s',$row->period_from))$row->period_from = DateTime::createFromFormat('Y-m-d H:i:s',$row->period_from)->format('d M Y');
	if(DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date))$row->trx_date = DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date)->format('d M Y');
}
	
	
	$this->render('view',array('model'=>$model));
	
	
}


}