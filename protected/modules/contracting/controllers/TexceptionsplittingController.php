<?php

class TexceptionsplittingController extends AAdminController
{
	public $layout='//layouts/admin_column2';	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionGetclient()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
      $qSearch = DAO::queryAllSql("
				Select client_cd, client_name From MST_CLIENT 
				Where (client_cd like '".$term."%')
      			AND rownum <= 15
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
		$model=new Texceptionsplitting;

		if(isset($_POST['Texceptionsplitting']))
		{
			$model->attributes=$_POST['Texceptionsplitting'];
			if($model->validate()){
				$model->save();
            	Yii::app()->user->setFlash('success', 'Successfully create exception for '.$model->client_cd);
				$this->redirect(array('/contracting/Texceptionsplitting/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($client_cd, $available_dt)
	{
		$model=$this->loadModel($client_cd, $available_dt);

		if(isset($_POST['Texceptionsplitting']))
		{
			$model->attributes=$_POST['Texceptionsplitting'];
			if($model->validate()){
				$model->save();
            	Yii::app()->user->setFlash('success', 'Successfully update exception for '.$model->client_cd);
				$this->redirect(array('/contracting/Texceptionsplitting/index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($client_cd, $available_dt)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($client_cd, $available_dt);
			if($model){
				if(!isset($_GET['ajax']))
					Yii::app()->user->setFlash('success', 'Successfully delete exception for '.$model->client_cd);
					$model->delete();
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			}else{
				$model->addError('','Data not found!');
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionIndex()
	{
		$model=new Texceptionsplitting('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Texceptionsplitting'])):
			$model->attributes=$_GET['Texceptionsplitting'];
		endif;

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($client_cd, $available_dt)
	{
		$model=Texceptionsplitting::model()->findByPk(array('client_cd'=>$client_cd,'available_dt'=>$available_dt));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
