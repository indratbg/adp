<?php

class ImportController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionAjxReconcileKsei()
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = new RptImpRekDanaWKsei('IMP_RECON_RDI_KSEI', 'R_RECON_RDI_KSEI', 'Reconcile_ksei.rptdesign');
			if ($model->validate() && $model->executeReportGenSp() > 0)
			{
				$url = $model->showReport();
				echo $url;
			}
			else
			{
				throw new CHttpException(400, $model->getErrors());
			}
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	public function actionAjxReconcileBank()
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = new RptImpRekDanaWBank('IMP_RECON_RDI_BANK', 'R_RECON_RDI_BANK', 'Reconcile_bank.rptdesign');
			if ($model->validate() && $model->executeReportGenSp() > 0)
			{
				$url = $model->showReport();
				echo $url;
			}
			else
			{
				throw new CHttpException(400, $model->getErrors());
			}
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');

		/*
		 if(Yii::app()->request->isPostRequest)
		 {
		 $modelToken = new Token;
		 $user_id = Yii::app()->user->id;
		 $module = "Import_Reconcile_Bank";
		 $token_cd = $modelToken->insertToken($user_id,$module);
		 $url = Constanta::URL."Reconcile_bank.rptdesign&ACC_TOKEN=$token_cd&ACC_USER_ID=$user_id";
		 echo $url;
		 }
		 else
		 throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');*/
	}

	public function actionIndex()
	{
		$modelfail = Vfailimprekdana::model()->findAll();
		$modelclient = Clientflacct::model()->findAll();
		$model = new Trekdanaksei();
		//$model->unsetAttributes();
		$cif = new Cif('search');
		$cif->unsetAttributes();
		$import_type;
		$filename = '';
		$valid = TRUE;
		$success = false;
		$cancel_reason = '';

		if (isset($_POST['Trekdanaksei']))
		{
			$model->attributes = $_POST['Trekdanaksei'];
			$model->scenario = 'upload';
			if ($model->validate())
			{

				$import_type = $model->import_type;

				//buat ambil file yang di upload tanpa $_FILES
				$model->file_upload = CUploadedFile::getInstance($model, 'file_upload');

				$path = FileUpload::getFilePath(FileUpload::IMPORT_REK_DANA, 'Upload.cas');
				$model->file_upload->saveAs($path);
				$filename = $model->file_upload;

				$ksei_date_char = substr($filename, -12);

				$ksei_date = substr($ksei_date_char, 0, 8);

				if ($import_type == AConstant::IMPORT_TYPE_PERTAMA)
				{
					$success = TRUE;

					//lakukan backup
					if ($model->executeBackup() > 0)
					{
						$success = TRUE;
					}
					else
					{
						$success = FALSE;
					}

				}

				//insert data ke Trekdanaksei
				$lines = file($path);
				foreach ($lines as $line_num => $line)
				{
					if ($line_num != 0)
					{
						$pieces = explode('|', $line);

						$model->name = substr($pieces[4],0,49);
						$model->sid = $pieces[5];
						$model->subrek = $pieces[6];
						if (strlen($pieces[7]) > 13)
						{

							$rek_dana = substr($pieces[7], 6);

							if (substr($rek_dana, 0, 1) == '0')
							{
								$rek_dana = substr($rek_dana, 1);

							}

							$model->rek_dana = $rek_dana;

						}
						else
						{
							$model->rek_dana = $pieces[7];
						}

						$model->bank_cd = $pieces[8];
						$model->create_dt = new CDbExpression("TO_DATE('" . date('Y-m-d H:i:s') . "','YYYY-MM-DD HH24:MI:SS')");
						$model->ksei_date = DateTime::createFromFormat('Ymd', $ksei_date)->format('Y-m-d');
						;

						//if(DateTime::createFromFormat('d/m/Y',$to_dt))$to_dt=DateTime::createFromFormat('d/m/Y',$to_dt)->format('Y-m-d');

						$model->user_id = Yii::app()->user->id;

						$activity = trim($pieces[10]);

						if ($activity !== 'C')
						{
							if ($model->save(FALSE))
							{
								$model = new Trekdanaksei();

							}
							//$model->unsetAttributes();
						}//end if model save
					}//pieces != C
				}//end if line!=0

				//setelah di upload dan dibaca, delete file nya
				//unlink(FileUpload::getFilePath(FileUpload::IMPORT_REK_DANA,$filename ));
				Yii::app()->user->setFlash('success', 'Successfully upload ' . $filename);
				$this->redirect(array('/master/import/index'));

			}//end foreach
		}//end if isset

		if (empty($model->import_type))
		{
			//supaya ada nilai default di checkbox nya
			$model->import_type = AConstant::IMPORT_TYPE_PERTAMA;
		}//end else

		$this->render('index', array(
			'model' => $model,
			'cif' => $cif,
			'modelfail' => $modelfail,
			'modelclient' => $modelclient
		));
	}

}
