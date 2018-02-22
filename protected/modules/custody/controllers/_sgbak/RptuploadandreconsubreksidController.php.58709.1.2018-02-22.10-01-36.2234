<?php
class RptuploadandreconsubreksidController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	

	public function actionIndex()
    {
    	$model = new Rptuploadandreconsubreksid('UPLOAD_AND_RECONCILE_SUBREK_AND_SID','R_RECONCILE_SUBREK','Reconcile_subrek.rptdesign');
		$model_sid = new Rptuploadandreconsubreksid('UPLOAD_AND_RECONCILE_SUBREK_AND_SID','R_RECONCILE_SID','Reconcile_sid.rptdesign');
		$sql = "SELECT distinct status_dt,to_char(status_dt,'dd/mm/yy') as status_dt_char FROM t_subrek_ksei	where status_dt >= (trunc(sysdate) - 20) ORDER BY status_dt Desc";
		$imported_list= Tsubrekksei::model()->findAllBySql($sql);
		$modelUpload = new Tsubrekksei();	 
		$url = '';
		$sql = "select get_doc_date(1,trunc(sysdate)) as doc_date from dual";
		$date = DAO::queryRowSql($sql);
		$date = $date['doc_date'];
		if(DateTime::createFromFormat('Y-m-d H:i:s',$date))$date = DateTime::createFromFormat('Y-m-d H:i:s',$date)->format('d/m/Y');
		$model->doc_date = $date;
		$success=true;
		
		if(isset($_POST['Rptuploadandreconsubreksid']))
		{
			$model->attributes = $_POST['Rptuploadandreconsubreksid'];
			$scenario = $_POST['scenario'];
			if($scenario =='upload')
			{	$model->scenario = 'upload';
				if($model->validate(false))
				{
					//buat ambil file yang di upload tanpa $_FILES
					$model->file_upload = CUploadedFile::getInstance($model,'file_upload');
					
					$path = FileUpload::getFilePath(FileUpload::UPLOAD_SUBREK,'upload.txt' );
					$model->file_upload->saveAs($path);
					$filename = $model->file_upload;
					/*
					$ksei_date_char=substr($filename,-12);
					$ksei_date=substr($ksei_date_char,0,8);
					if(!DateTime::createFromFormat('Ymd',$ksei_date))
					{ 	
						Yii::app()->user->setFlash('danger', 'File name should be containing date with format yyyymmdd.txt');
						$this->redirect(array('index'));
					}
					*/
				//	$status_dt = DateTime::createFromFormat('Ymd',$ksei_date)->format('Y-m-d');
				
					$status_dt = $model->doc_date;
	/*
					if($status_dt != $model->doc_date)
					{
						Yii::app()->user->setFlash('danger', 'Input Date must be same with date  textfile');
						$this->redirect(array('index'));
					}
*/
					$cek = Tsubrekksei::model()->find("status_dt = '$status_dt' "); 
					if($cek)
					{
						Tsubrekksei::model()->deleteAll("status_dt = '$status_dt' ");
					}
					
					//insert data ke T_subrek_ksei
					$lines = file($path);
					foreach($lines as $line_num=>$line)
					{
						$pieces = explode('|',$line);
						if(count($pieces)<14)
						{
							Yii::app()->user->setFlash('danger', 'Failed upload file, check text file');
							$success=FALSE;
							break;
						}
						if($pieces[7] != 'CLOSED' && substr($pieces[2], 5,4) <> '0000')
						{
							$modelUpload = new Tsubrekksei();	
							$modelUpload->status_dt = $status_dt;
							$modelUpload->client_name = $pieces[4];
							$modelUpload->subrek = $pieces[2];
							$modelUpload->id_num = $pieces[8];
							$modelUpload->sid = $pieces[12];
							$modelUpload->save(); 
						}
					}
				if($success)
				{
					if($modelUpload->executeSpLogUpd($status_dt)>0)
					{
						Yii::app()->user->setFlash('success', 'Successfully upload '.$filename);	
					}					
				}
				$this->redirect(array('index'));
				}
			}
			else if($scenario == 'subrek')
			{
				if($model->validate())
				{ 
					$subrek_001 = $model->subrek_001?'Y':'N';
					$subrek_004 = $model->subrek_004?'Y':'N';
					$option = 'SUBREK';
					if($model->executeRpt($subrek_001, $subrek_004, $option)>0)
					{
						$url = $model->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
				}
			}
			else if($scenario =='sid')
			{ //var_dump('test');die();
				if($model->validate())
				{
					$subrek_001 ='';
					$subrek_004 = '';
					$option = 'SID';
					$model_sid->doc_date = $model->doc_date;
					if($model_sid->validate() && $model_sid->executeRpt($subrek_001, $subrek_004, $option)>0)
					{
						$url = $model_sid->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
				}
			}
			
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->doc_date)) $model->doc_date = DateTime::createFromFormat('Y-m-d',$model->doc_date)->format('d/m/Y');
		
		
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									'imported_list'=>$imported_list,
									'model_sid'=>$model_sid,
									'modelUpload'=>$modelUpload));
	}
}
?>