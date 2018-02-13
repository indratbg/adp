<?php

class GenrepointjournalController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/admin_column3';

	public function actionIndex()
	{
		$model = new Tbalforeigncurrency;
		$modelDetail = array();
		$folder_cd_flg = Sysparam::model()->find(" param_id='SYSTEM' AND PARAM_CD1='VCH_REF'")->dflg1;
		$model->bal_dt = date('d/m/Y');
		$success = true;
		$valid = true;
		if (isset($_POST['Tbalforeigncurrency']))
		{
			$model->attributes = $_POST['Tbalforeigncurrency'];
			$scenario = $_POST['scenario'];

			if ($scenario == 'filter')
			{

				$modelDetail = Tbalforeigncurrency::model()->findAllBySql(Tbalforeigncurrency::getGenKursJournal($model->bal_dt));
				if(count($modelDetail)==0)
				{
					$model->addError('bal_dt', 'No Data Found');
				}
			}
			else if ($scenario == 'journal')
			{
				$rowCount = $_POST['rowCount'];
				$connection = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				$model->scenario = 'generate';
				$valid = $valid && $model->validate();
				
				for ($x = 0; $x < $rowCount; $x++)
				{
					$modelDetail[$x] = new Tbalforeigncurrency;
					$modelDetail[$x]->attributes = $_POST['Tbalforeigncurrency'][$x];
					$modelDetail[$x]->scenario = 'generate';
					$valid = $modelDetail[$x]->validate() && $valid;
					
				}

				if ($valid)
				{

					for ($x = 0; $x < $rowCount; $x++)
					{
						if ($modelDetail[$x]->executeGenKursJournal($model->bal_dt) > 0)
						{
							$success = TRUE;
						}
						else
						{
							$success = false;
						}
					}

					if ($success)
					{
						Yii::app()->user->setFlash('success', 'Data Successfully Journal');
						$transaction->commit();
						$this->redirect(array('index'));
					}
					else
					{
						$transaction->rollback();
					}
				}

			}
		}

		foreach ($modelDetail as $row)
		{
			if (DateTime::createFromFormat('Y-m-d H:i:s', $row->bal_dt))
				$row->bal_dt = DateTime::createFromFormat('Y-m-d H:i:s', $row->bal_dt)->format('d/m/Y');
			if (DateTime::createFromFormat('Y-m-d', $row->bal_dt))
				$row->bal_dt = DateTime::createFromFormat('Y-m-d', $row->bal_dt)->format('d/m/Y');
		}

		$this->render('index', array(
			'model' => $model,
			'modelDetail' => $modelDetail,
			'folder_cd_flg' => $folder_cd_flg
		));
	}

}
