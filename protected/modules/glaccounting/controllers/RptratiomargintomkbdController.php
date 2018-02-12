<?php
class RptratiomargintomkbdController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
		$model= new Rptratiomargintomkbd('LIST_OF_RATIO_MARGIN_TO_MKBD','R_RATIO_MARGIN_TO_MKBD','Ratio_Margin_to_MKBD.rptdesign');
		
		//$model->trans_date =date('d/m/Y');
		$url 	= "";
		
		if(isset($_POST['Rptratiomargintomkbd'])){
			
			
			$model->attributes=$_POST['Rptratiomargintomkbd'];
			
			if($model->validate() && $model->executeReportGenSp()>0  ){
				$url = $model->showReport().'&__showtitle=false&__format=pdf';
			}
	
		}else{
			$model->to_dt = date('d/m/Y');
		}
		
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url
		));
	}
	
	
}
?>