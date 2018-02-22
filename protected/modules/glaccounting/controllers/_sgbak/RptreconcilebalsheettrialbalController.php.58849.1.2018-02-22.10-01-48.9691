<?php
class RptreconcilebalsheettrialbalController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
		$model= new Rptreconcilebalsheettrialbal('LIST_OF_RECONCILE_BAL_SHEET_TRIAL_BAL','R_RECON_BAL_SHEET_TRIAL_BAL','Recon_bal_sheet_trial_bal.rptdesign');
			
		$model->trans_date =date('d/m/Y');
		$url 	= NULL;
		
		
		if(isset($_POST['Rptreconcilebalsheettrialbal'])){
			
			$model->attributes=$_POST['Rptreconcilebalsheettrialbal'];
			
			// $date=$_POST['RptreconcileTranswithdte']['trans_date'];
			// $opt=$_POST['RptreconcileTranswithdte']['selected_opt'];
			
				   
			if($model->validate() && $model->executeReportGenSp() > 0 ){
				$url = $model->showReport().'&__showtitle=false&__format=pdf';
			}
		}else{
			$model->selected_opt="DIFF";
		}
		
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url
		));
	}
}
?>