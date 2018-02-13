<?php

class SettlementclientController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionView($eff_dt,$client_cd,$market_type,$ctr_type,$sale_sts)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($eff_dt,$client_cd,$market_type,$ctr_type,$sale_sts),
		));
	}
	
	public function actionGetclient()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
      $qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '".$term."%')
      			AND susp_stat = 'N' AND client_type_1 <> 'B'
      			AND rownum <= 11
      			ORDER BY client_cd
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['client_cd']
      			, 'labelhtml'=>$search['client_cd'].' - '.$search['client_name'] //WT: Display di auto completenya
      			, 'value'=>$search['client_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }

	public function actionCreate()
	{
		$model = new Settlementclient;
		$model->exch_cd 	= 'JSX';
		$model->kds_script  = $model->kds_value;
		
		if(isset($_POST['Settlementclient']))
		{
			$model->attributes = $_POST['Settlementclient'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->eff_dt,$model->client_cd,$model->market_type,$model->ctr_type,$model->sale_sts) > 0 ){
            	Yii::app()->user->setFlash('success', 'Successfully insert '.$model->eff_dt.' '.$model->client_cd);
             	$this->redirect(array('/master/settlementclient/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($eff_dt,$client_cd,$market_type,$ctr_type,$sale_sts)
	{
		$model=$this->loadModel($eff_dt,$client_cd,$market_type,$ctr_type,$sale_sts);
		
		if(isset($_POST['Settlementclient']))
		{
			$model->attributes=$_POST['Settlementclient'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$eff_dt,$client_cd,$market_type,$ctr_type,$sale_sts) > 0){
            	Yii::app()->user->setFlash('success', 'Successfully update '.$model->eff_dt.' '.$model->client_cd);
             	$this->redirect(array('/master/settlementclient/index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	/*
	public function actionDelete($eff_dt,$client_cd,$market_type,$ctr_type,$sale_sts)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($eff_dt,$client_cd,$market_type,$ctr_type,$sale_sts)->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	 *
	 */
	
	public function actionDelete($eff_dt,$client_cd,$market_type,$ctr_type,$sale_sts)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model1 = NULL;
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				
				$model1    				= $this->loadModel($eff_dt,$client_cd,$market_type,$ctr_type,$sale_sts);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$eff_dt,$client_cd,$market_type,$ctr_type,$sale_sts) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel client settlement day');
					$is_successsave = true;
				}
			}
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$model1,
			'is_successsave'=>$is_successsave		
		));
	}

	public function actionIndex()
	{
		$model=new Settlementclient('search');
		$model->unsetAttributes();  // clear any default values
		$model->approved_stat = 'A';

		if(isset($_GET['Settlementclient']))
			$model->attributes=$_GET['Settlementclient'];

		$this->render('index',array(
			'model'=>$model,
		));
	}


	public function loadModel($eff_dt,$client_cd,$market_type,$ctr_type,$sale_sts)
	{
		$criteria = new CDbCriteria();
		$criteria->condition = "TO_CHAR(eff_dt,'YYYY-MM-DD') = :eff_dt AND client_cd = :client_cd AND 
								market_type = :market_type AND ctr_type = :ctr_type AND sale_sts = :sale_sts";
		$criteria->params    = array(':eff_dt'=>$eff_dt,':client_cd'=>$client_cd,':market_type'=>$market_type,
									 ':ctr_type'=>$ctr_type,':sale_sts'=>$sale_sts);
									 
		$model = Settlementclient::model()->find($criteria);
					  
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
