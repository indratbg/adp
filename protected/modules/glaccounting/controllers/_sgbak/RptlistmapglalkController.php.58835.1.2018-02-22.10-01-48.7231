<?php
class RptlistmapglalkController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
		$model= new Rptlistmapglalk('LIST_MAP_GLA_LK','R_LIST_MAP_GLA_LK','List_of_Map_Gla_LK.rptdesign');
		
		$url 	= "";
		$sql1="SELECT distinct lk_acct FROM MST_MAP_LK order by LK_ACCT";
		$macct_cd= Maplk::model()->findAllBySql($sql1);
		
		if(isset($_POST['Rptlistmapglalk'])){
			
			
			$model->attributes=$_POST['Rptlistmapglalk'];
			
			if($model->rpt_acct_cd == '0'){
				$bgn_acct_cd = '%';
				$end_acct_cd = '_';
			}else{
				$bgn_acct_cd = $model->bgn_acct_cd;
				$end_acct_cd = $model->end_acct_cd;
			}
			
			if($model->validate() && $model->executeRpt($bgn_acct_cd,$end_acct_cd)>0  ){
				$url = $model->showReport().'&__showtitle=false&__format=pdf';
			}
	
		}else{
			$model->to_dt=date('t/m/Y');
			$model->rpt_acct_cd= '0';
		}
		
		$this->render('index',array(
			'model'=>$model,
			'macct_cd'=>$macct_cd,
			'url'=>$url
		));
	}
	
}
?>