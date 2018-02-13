<?php

class ReconciledhkvscontractsController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	public function actionIndex()
	{	$modelReport = new Rptreconciledhkvscontracts('RECONCILE VS TRANSACTION','R_T_DHK','Reconcile_vs_transaction.rptdesign');
		$model = new Tdhk;	
		$import_type;
		$filename = '';
		$url='';
		$valid = TRUE;
		$success = false;
		$model->import_type ='DIFF';
		$model->type = 'AB';
		$model->settle_date = date('d/m/Y');
			if(isset($_POST['Tdhk']))
		{
			$scenario =$_POST['scenario'];
			$model->attributes = $_POST['Tdhk'];
			$user_id=Yii::app()->user->id;
			//$model->validate();
			if($scenario == 'import'){
			
					$model->scenario='upload';
					if($model->validate()){
					$import_type = $model->import_type;
				
					//buat ambil file yang di upload tanpa $_FILES
					$model->file_upload = CUploadedFile::getInstance($model,'file_upload');
					
					$path = FileUpload::getFilePath(FileUpload::T_DHK,'Upload.txt' );
					$model->file_upload->saveAs($path);
					$filename = $model->file_upload;
					//insert data ke Tdhk
					$lines = file($path);
		 		$date=$model->settle_date;
				foreach ($lines as $line_num => $line) 
				{
				//	if($line_num!=0 && $line_num < count($lines)-2)
					//{
							$pieces = explode("\t",$line);
							$model->settle_date =$pieces[0];
						 if(DateTime::createFromFormat('d-M-y',$model->settle_date))$model->settle_date = DateTime::createFromFormat('d-M-y',$model->settle_date)->format('Y-m-d');
							$model->subrek004 = $pieces[7];
							$model->sid = $pieces[8];
							$model->subrek001 = str_replace('-', '', $pieces[10]);
						
							$model->stk_cd = $pieces[12];
							$model->net_buy= $pieces[14];
							$model->net_sell= $pieces[15];
							$model->cre_dt = new CDbExpression("TO_DATE('".date('Y-m-d H:i:s')."','YYYY-MM-DD HH24:MI:SS')");
							$model->user_id = $user_id;
						//save file upload to tdhk
						 if(trim($model->stk_cd) != 'IDR' && $model->settle_date == $date)
						 {
						 	$cek = Tdhk::model()->find("settle_date = '$model->settle_date' and subrek004= '$model->subrek004' and stk_cd= '$model->stk_cd' ");
						if($cek)
						{
							$sql="delete from t_dhk where settle_date = '$model->settle_date' and subrek004= '$model->subrek004' and stk_cd= '$model->stk_cd' ";
							$exec =DAO::executeSql($sql);
						}
						if($model->save(FALSE))
						{
						$model = new Tdhk();	
						}	
								
								
						}
					//}//end if line!=0
			
		}
		$model->settle_date = $date;
		$model->import_type ='DIFF';
				//setelah di upload dan dibaca, delete file nya
			//unlink(FileUpload::getFilePath(FileUpload::IMPORT_REK_DANA,$filename ));
			Yii::app()->user->setFlash('success', 'Successfully upload '.$filename);
		//	$this->redirect(array('index'));
			
			
			}//import
			}
		else//report
		{
			if($model->validate()){
				 
			$modelReport->settle_date = $model->settle_date;
			$modelReport->import_type = $model->import_type;
			$modelReport->type = $model->type;
			
		if($modelReport->validate() && $modelReport->executeRpt()){
			$url = $modelReport->showReport();
		}	
		}
		}
		}
			
			
		
		$this->render('index',array(
			'model'=>$model,
			'modelReport'=>$modelReport,
			'url'=>$url
		));
	}

	
}
