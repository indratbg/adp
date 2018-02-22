<?php

class RpthighriskclientController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';
	
	private function fillVpParameter(&$model)
	{
		$model->vp_occupation = $model->vp_business_indi = $model->vp_business_inst = $model->vp_country = $model->vp_customer = $model->vp_job = 'N';
		$object = array();
		switch ($model->type) {
			case Rpthighriskclient::CLIENT_TYPE_ALL:
				$object = $model->kategori_all;
				$flag = true;
				break;
			case Rpthighriskclient::CLIENT_TYPE_INDIVIDU:
				$object = $model->kategori_indi;
				$flag = true;
				break;
			case Rpthighriskclient::CLIENT_TYPE_INSTITUSI:
				$object = $model->kategori_inst;
				$flag = true;
				break;
		}//end switch
		
		if(!empty($object)):
		foreach ($object as $value) {
			switch ($value) {
				case Rpthighriskclient::LIST_OCCUPATION:
					$model->vp_occupation = $value;
					break;
				case Rpthighriskclient::LIST_BUSINESS:
					if($model->type==Rpthighriskclient::CLIENT_TYPE_ALL)$model->vp_business_indi = $model->vp_business_inst = $value;
					else if($model->type==Rpthighriskclient::CLIENT_TYPE_INDIVIDU)$model->vp_business_indi = $value;
					else if($model->type==Rpthighriskclient::CLIENT_TYPE_INSTITUSI)$model->vp_business_inst = $value;
					break;
				case Rpthighriskclient::LIST_COUNTRY:
					$model->vp_country = $value;
					break;
				case Rpthighriskclient::LIST_CUSTOMER:
					$model->vp_customer = $value;
					break;
				case Rpthighriskclient::LIST_JOB:
					$model->vp_job = $value;
					break;
			}
		}//end foreach
		endif;
	}

	public function actionIndex()
	{
		// [AR] provide Module Name, Table Name, RptDesign Name
		//      notice that no unset attributes because it will make error !!  
		$model 		= new Rpthighriskclient('HIGH_RISK_CLIENT','R_CLIENT_HIGHRISK_REP','High_risk_client.rptdesign');
		$url 		= NULL;
		$modelToken = new Token;
		
		if(isset($_POST['Rpthighriskclient']))
		{
			$model->attributes = $_POST['Rpthighriskclient'];
			$this->fillVpParameter($model);

			if($model->validate() && $model->executeReportGenSp() > 0 )
				$url = $model->showReport();
		}
		else
		{$model->type = '1';}
		
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url,
		));
	}
}
