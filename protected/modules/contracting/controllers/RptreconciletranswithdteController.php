<?php
class RptreconciletranswithdteController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
		$model= new Rptreconciletranswithdte('LIST_OF_RECONCILE_TRANS_WITH_DTE','R_RECON_TRANS_WITH_DTE','Recon_trans_with_dte.rptdesign');
			
		$model->trans_date =date('d/m/Y');
		$url 	= NULL;
		
		if(isset($_POST['RptreconcileTranswithdte'])){
			
			$model->attributes=$_POST['RptreconcileTranswithdte'];
			
			// $date=$_POST['RptreconcileTranswithdte']['trans_date'];
			// $opt=$_POST['RptreconcileTranswithdte']['selected_opt'];
			
				   
			if($model->validate() && $model->executeReportGenSp() > 0 ){
				$url = $model->showReport().'&__showtitle=false&__format=pdf';
			}
		}else{
			$model->selected_opt="DIFF";
			$model->selected_from="T_CONTRACTS";
		}
			$this->render('index',array(
			'model'=>$model,
			'url'=>$url
		));
	}
}
?>