<?php

class ConsolidationjournalreportController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model = new Rptconsoljournal('CONSOLIDATION_JOURNAL','R_T_CONSOL_JRN','Consolidation_Journal.rptdesign');
		$url='';
		$model->doc_date=date('d/m/Y');
		
		
		if(isset($_POST['Rptconsoljournal']))
		{
			$model->attributes = $_POST['Rptconsoljournal'];
			
			if($model->validate() && $model->executeRpt()>0){
				$url = $model->showReport();
			}
		}	
	$this->render('index',array('model'=>$model,'url'=>$url));	
	}

}
?>