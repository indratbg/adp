<?php

class RpthighrisknameController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model= new Rpthighriskname('LIST_OF_HIGH_RISK_NAME','R_HIGHRISK_NAME','High_Risk_Name_Report.rptdesign');	
		$mkategori = Parameter::model()->findAllBySql("select * from mst_parameter where prm_cd_1 = 'HRISK' and approved_stat= 'A' order by prm_cd_2");
		$url ='';
		
		if(isset($_POST['Rpthighriskname']))
		{
			
			$model->attributes = $_POST['Rpthighriskname'];
			
			if($model->kategori==NULL){
				$model->kategori='%';
			}
						
			if($model->validate() && $model->executeRpt()>0)
			{
				$rpt_link =$model->showReport();
				$url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
			}
		}
		
		$this->render('index',array('model'=>$model,
									'mkategori'=>$mkategori,
									'url'=>$url
									));
	}
}
