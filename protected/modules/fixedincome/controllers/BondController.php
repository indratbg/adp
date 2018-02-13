<?php

class BondController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Bond;

		if(isset($_POST['Bond']))
		{
			$model->attributes=$_POST['Bond'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS, $model->bond_cd) > 0){
				
            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->bond_cd);
				$this->redirect(array('index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Bond']))
		{
			$model->attributes=$_POST['Bond'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$id) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->bond_cd);
				$this->redirect(array('index','id'=>$model->bond_cd));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionAjxPopDelete($id)
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
				
				$model1    				= $this->loadModel($id);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->maturity_date))$model1->maturity_date=DateTime::createFromFormat('Y-m-d G:i:s',$model1->maturity_date)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->listing_date))$model1->listing_date=DateTime::createFromFormat('Y-m-d G:i:s',$model1->listing_date)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->issue_date))$model1->issue_date=DateTime::createFromFormat('Y-m-d G:i:s',$model1->issue_date)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->first_coupon_date))$model1->first_coupon_date=DateTime::createFromFormat('Y-m-d G:i:s',$model1->first_coupon_date)->format('Y-m-d');
				$cek=Tbondtrx::model()->find("bond_cd='$id'");
				if(!$cek){
					if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$id) > 0){
					Yii::app()->user->setFlash('success', 'Successfully Cancel Bond Master');
					$is_successsave = true;	
				}
				}
				else{
					$model1->addError('error', 'Error cancel Bond Master,  Bond CD is already in use');
					
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
		$model=new Bond('search');
		$model->unsetAttributes();  // clear any default values
		$model->approved_sts = 'A';

		if(isset($_GET['Bond']))
			$model->attributes=$_GET['Bond'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	public function actionGenerate($id){
	
		$model=new TBondCoupon('search');
			$model->bond_cd=$id;
			if(isset($_POST['Bond'])){
					
				if($model->executeSpGenerate(date('Y-m-d'),$id) > 0){
                Yii::app()->user->setFlash('success', 'Successfully Generate Coupon Schedule '.$model->bond_cd);
				
            }
				
			}
		$this->render('generate',array('model'=>$model,));
	}

	
	public function actionCopy($id){
	
		
		$model=$this->loadModel($id);
		$model->scenario='create';
		$model->bond_cd='';
		if(isset($_POST['Bond']))
		{
			$model->attributes=$_POST['Bond'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->bond_cd) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->bond_cd);
				$this->redirect(array('index','id'=>$model->bond_cd));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
		
		
	}
	/**
	public function actionSelisih(){
	
		$resp['status']='error';
		if(isset($_POST['maturity_date']) && isset($_POST['listing_date']) && $_POST['maturity_date']!='' && $_POST['listing_date']!=''){
			$maturity_date = $_POST['maturity_date'];
			$listing_date = $_POST['listing_date'];
			
			$maturity_date=DateTime::createFromFormat('d/m/Y',$maturity_date)->format('Y-m-d');
			$listing_date=DateTime::createFromFormat('d/m/Y',$listing_date)->format('Y-m-d');
			$maturity_date=date_create($maturity_date);
			$listing_date=date_create($listing_date);
			$diff=date_diff($maturity_date,$listing_date);
			$beda=$diff->format("%a");
			$result=$beda/360;
			
			
			$query="SELECT param_cd2 FROM MST_SYS_PARAM";
			$year = DAO::queryRowSql($query);
			
			if($result< 7){
				$param=Sysparam::model()->find("param_cd2 = '<7 THN'");
				
				$param->dstr2;
				
				$resp['dstr1'] = $param->dstr1;;
				$resp['dstr2'] = $param->dstr2;
			}
			else if($result>=7 && $result<=15){
				$param=Sysparam::model()->find("param_cd2 = '7-15 THN'");
				
				$param->dstr2;
				
				$resp['dstr1'] = $param->dstr1;;
				$resp['dstr2'] = $param->dstr2;
				
			}
			else if($result>15){
				$param=Sysparam::model()->find("param_cd2 = '>15 THN'");
				
				$param->dstr2;
				
				$resp['dstr1'] = $param->dstr1;;
				$resp['dstr2'] = $param->dstr2;
			}
			else{
	
			}
				$resp['status']='success';
		
		}
		
		
		echo json_encode($resp);
	}
	
	 * 
	 */
	public function loadModel($id)
	{
		$model=Bond::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	
}
