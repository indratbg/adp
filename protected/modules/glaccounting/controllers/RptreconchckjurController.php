<?php
class RptreconchckjurController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
		$model= new Rptreconchckjur('LIST_OF_RECONCILE_CHECK_JOURNAL','R_RECON_CHCK_JUR','Recon_Chck_Jur.rptdesign');
		
		//$model->trans_date =date('d/m/Y');
		$url 	= "";
		
		if(isset($_POST['Rptreconchckjur'])){
			
			
			$model->attributes=$_POST['Rptreconchckjur'];
			
			if($model->validate() && $model->executeReportGenSp()>0  ){
				$url = $model->showReport().'&__showtitle=false&__format=pdf';
			}
	
		}
		
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url
		));
	}
	
	
}
?>