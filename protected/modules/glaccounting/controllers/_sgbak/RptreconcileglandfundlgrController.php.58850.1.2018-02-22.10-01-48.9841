<?php
class RptreconcileglandfundlgrController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
		$model= new Rptreconcileglandfundlgr('LIST_OF_RECONCILE_GL_FUND_LGR','R_RECON_GL_FUND_LGR','Recon_gl_fund_lgr.rptdesign');
			
		$model->trans_date =date('d/m/Y');
		$url 	= NULL;
		
		
		if(isset($_POST['Rptreconcileglandfundlgr'])){
			
			$model->attributes=$_POST['Rptreconcileglandfundlgr'];
			
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