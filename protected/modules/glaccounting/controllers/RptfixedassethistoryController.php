<?php

class RptfixedassethistoryController extends AAdminController
{
	public $layout = '//layouts/admin_column3';
	
	public function actionGetasset()
	{
		 $i = 0;
		 $src = array();
		 $term = strtoupper($_REQUEST['term']);
		 $qSearch = DAO::queryAllSql("
			 Select asset_cd FROM MST_FIXED_ASSET
				 WHERE asset_cd LIKE '".$term."%' and approved_stat='A'
      			 ORDER BY asset_cd
      			 ");

		 foreach ($qSearch as $search)
		 {
			 $src[$i++] = array(
				 'label' => $search['asset_cd'],
				 'labelhtml' => $search['asset_cd'],
				 'value' => $search['asset_cd']
			 );
		 }
 
		 echo CJSON::encode($src);
		 Yii::app()->end();
	 }
	
	public function actionIndex()
	{
		$model = new Rptfixedassethistory('FIXED_ASSET_HISTORY', 'R_FIXED_ASSET_HISTORY', 'Fixed_Asset_History.rptdesign');
		$url = '';
		$model->asset_cd='';
		$model->option='0';
		$model->bgn_date = date('01/m/Y', strtotime('-1 month'));
		$model->end_date = date('t/m/Y', strtotime('-1 month'));
		
		
		if(isset($_POST['Rptfixedassethistory']))
		{	
			$model->attributes = $_POST['Rptfixedassethistory'];
				if($model->option=='0'){
					$model->asset_cd='%';
				}
				
				if($model->validate() && $model->executeRpt()>0)
				{
					$url = $model->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				}	
			}
			
	
	if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
			$model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
		   if (DateTime::createFromFormat('Y-m-d', $model->end_date))
			$model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');
	
		$this -> render('index', array('model' => $model,'url'=>$url));
	}

}
