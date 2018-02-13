<?php

class TbalforeigncurrencyController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/admin_column3';

	public function actionAjxdelete($rowid)
	{
		$success = false;

		$delete = Tbalforeigncurrency::model()->find("t.rowid = '$rowid' ")->delete();
		if ($delete)
		{
			$success = true;
		}

		echo json_encode(array('success' => $success));
	}

	public function actionIndex()
	{

		$model = Tbalforeigncurrency::model()->findAll(array(
			'select' => 't.rowid,t.*',
			'condition' => "approved_sts='A'",
			'order' => 'bal_dt desc, cre_dt desc'
		));
		$insert = false;

		if (isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];

			if ($scenario == 'create')
			{
				$model[0] = new Tbalforeigncurrency;
				$model[0]->attributes = $_POST['Tbalforeigncurrency'][0];
				$model[0]->scenario = 'insert';
				if ($model[0]->validate())
				{
					$model[0]->upd_dt = '';
					$model[0]->upd_by = '';
					$model[0]->approved_sts = 'A';
					$model[0]->approved_dt = date('Y-m-d H:i:s');
					$model[0]->approved_by = $model[0]->user_id;

					$bal_dt = $model[0]->bal_dt;
					$gl_acct =trim($model[0]->gl_acct_cd);
					$sl_acct =$model[0]->sl_acct_cd;
					$cek = Tbalforeigncurrency::model()->find("bal_dt ='$bal_dt' and trim(gl_acct_cd)='$gl_acct' and sl_acct_cd = '$sl_acct' ");
					if ($cek)
					{
						$model[0]->addError('bal_dt', 'Data duplicate');
					}
					else
					{
						$model[0]->save(false);
						Yii::app()->user->setFlash('success', 'Successfully Add New Balance');
						$this->redirect(array('index'));
					}

				}
			}
			else if ($scenario == 'update')
			{
				$rowSeq = $_POST['rowSeq'];
				$rowid = $_POST['Tbalforeigncurrency'][$rowSeq]['rowid'];
				$model[$rowSeq] = Tbalforeigncurrency::model()->find("t.rowid = '$rowid' ");
				$model[$rowSeq]->attributes = $_POST['Tbalforeigncurrency'][$rowSeq];
				$model[$rowSeq]->save();
				Yii::app()->user->setFlash('success', 'Successfully Update Data');
				$this->redirect(array('index'));

			}

		}

		foreach ($model as $row)
		{
			$row->gl_acct_cd = trim($row->gl_acct_cd);
		}
		if(count($model)==0)
		{
			$model[0] = new Tbalforeigncurrency;
			$insert = true;
		}

		$this->render('index', array(
			'model' => $model,
			'insert' => $insert
		));
	}

}
