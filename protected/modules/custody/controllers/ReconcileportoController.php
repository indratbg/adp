<?php

class ReconcileportoController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model = new Treconcileporto;
		$model_rpt = new Rptreconcileporto('RECONCILE_PORTO','R_RECONCILE_PORTO','Reconcile_porto_system.rptdesign');		
		$modelr = null;
		$repdate = null;
		$filename = '';
		$url='';
		$model->view_type = 'DIFF';
		//$success = true;
		
		if(isset($_POST['Treconcileporto'])){
			$model->attributes = $_POST['Treconcileporto'];
			$model->scenario='upload';
			if($model->validate()){
				$success = true;
				$model->file_upload = CUploadedFile::getInstance($model,'file_upload');
				$path = FileUpload::getFilePath(FileUpload::RECONCILE_PORTO,'Upload.por' );
				$model->file_upload->saveAs($path);
				$filename = $model->file_upload;
				$upldate_char = substr($filename,-12);
				$upldate = substr($upldate_char,0,8);
				$userid = Yii::app()->user->id;
				$lines = file($path);
				
				foreach ($lines as $line_num => $line){
					if($line_num == 3){
						if(trim($line) != $upldate){
							$model->addError('',"File \"$filename\" tidak valid, isi tanggal portofolio tidak sama : $line");
							$success = false;
							break;
						}else{
							if($model->executeSpDelete($upldate) > 0){
								$success = true;
							}else{
								$model->addError('',"Upload gagal!");
								$success = false;
								break;
							}
						}
						
					}else{
						if($line_num > 4){
							$pieces = explode('|',$line);
							
							if(sizeof($pieces) == 9){
								$model->stk_cd = trim($pieces[0]);
								$model->price = trim($pieces[1]);
								$model->port001 = trim($pieces[2]);
								$model->port002 = trim($pieces[3]);
								$model->port004 = trim($pieces[4]);
								$model->client001 = trim($pieces[5]);
								$model->client002 = trim($pieces[6]);
								$model->client004 = trim($pieces[7]);
								$model->subrek_qty = trim($pieces[8]);
								$model->report_date = $upldate;
								$model->rep_type = '1';
								if($model->executeSp() > 0){
									$success == true;
								}else{
									$success == false;
									break;
								}
							}
							
							if(sizeof($pieces) == 6){
								$model->stk_cd = trim($pieces[0]);
								$model->price = trim($pieces[1]);
								$model->port_warkat = trim($pieces[2]);
								$model->client_warkat = trim($pieces[3]);
								$model->port_cust = trim($pieces[4]);
								$model->client_cust = trim($pieces[5]);
								$model->port001 = '';
								$model->port002 = '';
								$model->port004 = '';
								$model->client001 = '';
								$model->client002 = '';
								$model->client004 = '';
								$model->subrek_qty = '';
								$model->report_date = $upldate;
								$model->rep_type = '2';
								if($model->executeSp() > 0){
									$success == true;
								}else{
									$success == false;
									break;
								}
							}
						}
					}
				}
				if($success == true){
					Yii::app()->user->setFlash('success', 'Sukses upload file "'.$filename);
					$p_report_date = DateTime::createFromFormat('Ymd',$upldate)->format('Y-m-d');
					$p_option = $model->view_type;
					
					
					if($model_rpt->validate() && $model_rpt->executeRpt_2($p_report_date,$p_option)>0){
					// var_dump($p_report_date);var_dump($p_report_date);die();						
					$url = $model_rpt->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
				}
			}
					
		}
		
		$this->render('index',array(
			'model'=>$model,
			'modelr'=>$modelr,
			'repdate'=>$repdate,
			'url'=>$url,
			'model_rpt'=>$model_rpt,
		));
	}
	
	public function actionIndexksei()
	{
		$model = new Treconcileporto;
		$model_rpt = new Rptreconcileporto('RECONCILE_PORTO','R_RECONCILE_PORTO','Reconcile_porto_ksei.rptdesign');
		$modelr = null;
		$repdate = null;
		$filename = '';
		$url='';
		$model->view_type = 'DIFF';
		
		if(isset($_POST['Treconcileporto'])){
			$model->attributes = $_POST['Treconcileporto'];
			$model->scenario='upload';
			if($model->validate()){
				$success = true;
				$model->file_upload = CUploadedFile::getInstance($model,'file_upload');
				$path = FileUpload::getFilePath(FileUpload::RECONCILE_PORTO,'Upload.por' );
				$model->file_upload->saveAs($path);
				$filename = $model->file_upload;
				$upldate_char = substr($filename,-12);
				$upldate = substr($upldate_char,0,8);
				
				$lines = file($path);
				foreach ($lines as $line_num => $line){
					if($line_num == 3){
						if(trim($line) != $upldate){
							$model->addError('',"File \"$filename\" tidak valid, isi tanggal portofolio tidak sama : $line");
							$success = false;
							break;
						}else{
							if($model->executeSpDelete($upldate) > 0){
								$success = true;
							}else{
								$model->addError('',"Upload gagal!");
								$success = false;
								break;
							}
						}
						
					}else{
						if($line_num > 4){
							$pieces = explode('|',$line);
							
							if(sizeof($pieces) == 9){
								$model->stk_cd = trim($pieces[0]);
								$model->price = trim($pieces[1]);
								$model->port001 = trim($pieces[2]);
								$model->port002 = trim($pieces[3]);
								$model->port004 = trim($pieces[4]);
								$model->client001 = trim($pieces[5]);
								$model->client002 = trim($pieces[6]);
								$model->client004 = trim($pieces[7]);
								$model->subrek_qty = trim($pieces[8]);
								$model->report_date = $upldate;
								$model->rep_type = '1';
								if($model->executeSp() > 0){
									$success == true;
								}else{
									$success == false;
									break;
								}
							}
							
							if(sizeof($pieces) == 6){
								$model->stk_cd = trim($pieces[0]);
								$model->price = trim($pieces[1]);
								$model->port_warkat = trim($pieces[2]);
								$model->client_warkat = trim($pieces[3]);
								$model->port_cust = trim($pieces[4]);
								$model->client_cust = trim($pieces[5]);
								$model->report_date = $upldate;
								$model->rep_type = '2';
								if($model->executeSp() > 0){
									$success == true;
								}else{
									$success == false;
									break;
								}
							}
						}
					}
				}
				if($success == true){
					Yii::app()->user->setFlash('success', 'Sukses upload file "'.$filename);
					$p_report_date = DateTime::createFromFormat('Ymd',$upldate)->format('Y-m-d');
					$p_option = $model->view_type;
					if($model_rpt->validate() && $model_rpt->executeRpt($p_report_date,$p_option)>0){
					// var_dump($p_report_date);var_dump($p_report_date);die();						
					$url = $model_rpt->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
				}
			}
					
		}
		
		$this->render('indexksei',array(
			'model'=>$model,
			'modelr'=>$modelr,
			'repdate'=>$repdate,
			'url'=>$url,
			'model_rpt'=>$model_rpt
		));
	}
	
}
