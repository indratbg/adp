<?php

class UploadhaircutmkbdController extends AAdminController
{

	public $layout = '//layouts/admin_column3';
	public function actionGetListImportDate()
	{
		$sql="SELECT DISTINCT eff_dt, to_char(EFF_DT,'dd/mm/yyyy') as eff_dt2 FROM T_HAIRCUT_KOMITE where approved_stat='A' ORDER BY EFF_DT DESC";
		$list_eff_dt = DAO::queryAllSql($sql);
		$resp['status'] = 'success';
		
		$resp['list_eff_dt'] = $list_eff_dt;
		
		echo json_encode($resp);
	}

	public function actionIndex()
	{
		$model = new Thaircutkomite;
		$modelDetail=array();
		
		//$model->eff_dt = date('d/m/Y');
		$model->eff_dt = $this->getStartDate();
		$success=true;
		if (isset($_POST['Thaircutkomite']))
		{
			$model->attributes = $_POST['Thaircutkomite'];
			$model->scenario = 'upload';
			$scenario = $_POST['scenario'];

			if ($scenario == 'import')
			{
				if ($model->validate())
				{
					//buat ambil file yang di upload tanpa $_FILES
					$model->file_upload = CUploadedFile::getInstance($model, 'file_upload');
					$path = FileUpload::getFilePath(FileUpload::UPLOAD_HAIRCUT_MKBD, 'upload.txt');
					$model->file_upload->saveAs($path);
					$filename = $model->file_upload;
					$eff_dt = $model->eff_dt;
					//insert data ke T_HAIRCUT_KOMITE
					$lines = file($path);
					$x=0;
					foreach ($lines as $line_num => $line)
					{
						if ($line_num != 0)
						{

							$pieces = explode('|', $line);
							$model->status_dt = DateTime::createFromFormat('Ymd', $pieces[0])->format('Y-m-d');
							$model->stk_cd = $pieces[1];
							$model->haircut = $pieces[3];
							$model->eff_dt = $eff_dt;
							$model->cre_dt = date('Y-m-d H:i:s');
							$model->create_dt = date('Y-m-d H:i:s');
							$model->user_id = Yii::app()->user->id;
							$model->approved_stat = 'A';
							$model->approved_by = Yii::app()->user->id;
							$model->approved_dt = date('Y-m-d H:i:s');
							$model->upd_dt = '';
							$model->upd_by = '';
							$model->user_id = Yii::app()->user->id;
							//CEK DATA IF EXISTING
							
							$cek = Thaircutkomite::model()->find("status_dt='$model->status_dt' and stk_cd='$model->stk_cd' ");
							if($cek)
							{
								$status_dt = DateTime::createFromFormat('Y-m-d',$model->status_dt)->format('d-M-Y');
								Yii::app()->user->setFlash('danger', 'Data sudah ada sebelumnya dengan status date '.$status_dt);
								$success=false;	
								break;
							}
							//assign to detail 
							$modelDetail[$x]=new Thaircutkomite;
							$modelDetail[$x]->status_dt = DateTime::createFromFormat('Y-m-d',$model->status_dt)->format('d/m/Y');
							$modelDetail[$x]->stk_cd = $model->stk_cd;
							$modelDetail[$x]->haircut = $model->haircut;
							$modelDetail[$x]->create_dt = DateTime::createFromFormat('Y-m-d H:i:s',$model->create_dt)->format('d/m/Y H:i:s');
							$modelDetail[$x]->eff_dt =DateTime::createFromFormat('Y-m-d',$model->eff_dt)->format('d/m/Y');
							
							
							if ($model->save(FALSE))
							{
								$model = new Thaircutkomite;
							}
						}
					$x++;	
					}
					if($success)
					{
						//reset eff_dt
						$model->eff_dt = DateTime::createFromFormat('Y-m-d',$eff_dt)->format('d/m/Y');
						Yii::app()->user->setFlash('success', 'Upload Berhasil');
						//$this->redirect(array('index'));	
					}
					

				}//end foreach
			}
		}//end scenario import

		$this->render('index', array('model' => $model,
									'modelDetail'=>$modelDetail));

	}
public function getStartDate()
{
	$date = date('Y-m-01');
	$day = DateTime::createFromFormat('Y-m-d',$date)->format('D');
	$cek = Calendar::model()->find("tgl_libur = '$date' ");
	if($day =='Sat' || $day =='Sun' || $cek)
	{
		$sql = "select get_due_date(1,'$date') start_date from dual";
		$exec = DAO::queryRowSql($sql);
		$date = $exec['start_date'];
	}

	if(DateTime::createFromFormat('Y-m-d',$date))$date =DateTime::createFromFormat('Y-m-d',$date)->format('d/m/Y');
	if(DateTime::createFromFormat('Y-m-d H:i:s',$date))$date =DateTime::createFromFormat('Y-m-d H:i:s',$date)->format('d/m/Y'); 
	return $date;
}

}
