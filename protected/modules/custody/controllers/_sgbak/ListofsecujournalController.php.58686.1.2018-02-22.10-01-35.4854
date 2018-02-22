<?php

class ListofsecujournalController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	public function actionIndex()
	{
		$model = new Rptsecujournal('LIST_OF_SECURITIES_JOURNAL','R_SECU_JOURNAL','List_of_securities_journal.rptdesign');
		$url = '';
		$model->from_date = date('d/m/Y');
		$model->to_date = date('d/m/Y');	
		if(isset($_POST['Rptsecujournal']))
		{
			$model->attributes = $_POST['Rptsecujournal'];
			
			if($model->validate() && $model->executeRpt()>0)
			{
				$url= $model->showReport();
			}
			
		}
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url
		));
	}

	
}
