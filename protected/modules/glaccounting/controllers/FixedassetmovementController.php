<?php

class FixedassetmovementController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($doc_date,$asset_cd)
	{
		$this->layout='//layouts/admin_column2';
		$this->render('view',array(
			'model'=>$this->loadModel($doc_date,$asset_cd),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Fixedassetmovement;
		$modelReceive = array(); 
		$success=true;
		$mvmt_check=0;
		$model->purch_dt='';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model->doc_date=date('d/m/Y');
		$sql = "select prm_cd_2,prm_cd_2||' - '||prm_desc prm_desc from MST_parameter where prm_cd_1='FASSET'";
		$fasset=Parameter::model()->findAllBySql($sql);
		$sql2= "select brch_cd,brch_cd||' - '||brch_name brch_name from mst_branch where branch_status='A' order by brch_cd";
		$brch=Branch::model()->findAllBySql($sql2);
		$sql3 = DAO::queryRowSql("SELECT to_char(MAX(SUBSTR(depr_mon,3,2)||SUBSTR(depr_mon,1,2))) start_dt FROM T_MON_DEPR where cre_dt is not null");
		$start_dt=$sql3['start_dt'];
		$last_t_mon_depr=substr($start_dt,2).substr($start_dt,0,2);
		$asset_cd_temp;
		$branch_cd_temp;
		
		// var_dump($last_t_mon_depr);die();
		if(isset($_POST['Fixedassetmovement']))
		{			
			$model->attributes=$_POST['Fixedassetmovement'];
			$query_qty=DAO::queryRowSql("select qty from t_mon_depr where asset_cd='".$model->asset_cd."' and depr_mon='".$last_t_mon_depr."'");
			$query_accum=DAO::queryRowSql("select accum_last_yr from mst_fixed_asset where asset_cd='".$model->asset_cd."'");
			$model->accum_last_yr=$query_accum['accum_last_yr'];
			$qty_t_mon_depr=$query_qty['qty'];
			$asset_cd_temp=$model->asset_cd;
			$branch_cd_temp=$model->branch_cd;
			
			$connection  = Yii::app()->db;
			$transaction = $connection->beginTransaction();	
			$menuName = 'FASSET MOVEMENT ENTRY';
			if($model->validate()){
				
			if($model->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
	
			
			if($success && $model->executeSpTFasset(AConstant::INBOX_STAT_INS,$model->doc_date,$model->asset_cd,1) > 0 )$success=true;
				else{
					$success=false;
				}
				if($success){
				if($model->mvmt_type=='BUY'){
					$model->accum_last_yr=0;
					$model->asset_stat='ACTIVE';
					if($success && $model->executeSpMSTFasset(AConstant::INBOX_STAT_INS,$model->asset_cd,1) > 0 )
					{
					 	$success=true;
					}
					else{
						$success=false;
						}
				}
				else if($model->mvmt_type=='SELL'){
					
					if($model->qty==$qty_t_mon_depr){
						$model->asset_stat='SOLD';
					} else {
						$model->asset_stat='ACTIVE';
					}
					if($success && $model->executeSpMSTFasset(AConstant::INBOX_STAT_UPD,$model->asset_cd,1) > 0 )
					{
					 	$success=true;
					}
					else{
						$success=false;
						}
				}
				else if($model->mvmt_type=='TRANSFER'){
					
					if($model->qty==$qty_t_mon_depr){
						$model->asset_stat='ACTIVE';
						$model->asset_cd=$model->to_asset_cd;
						$model->branch_cd=$model->to_branch;
						// var_dump($model->asset_cd);var_dump($asset_cd_temp);die();
						if($success && $model->executeSpMSTFasset(AConstant::INBOX_STAT_INS,$model->asset_cd,1) > 0 )
						{
					 		$success=true;
						}
						else{
							$success=false;
						}
						$model->asset_cd=$asset_cd_temp;
						$model->branch_cd=$branch_cd_temp;	
						$model->asset_stat='TRANSFER';
						// var_dump($model->asset_cd);var_dump($asset_cd_temp);die();
						if($success && $model->executeSpMSTFasset(AConstant::INBOX_STAT_UPD,$model->asset_cd,2) > 0 )
						{
					 		$success=true;
						}
						else{
							$success=false;
						}
						
					} else {
						$model->asset_stat='ACTIVE';
						$model->asset_cd=$model->to_asset_cd;
						$model->branch_cd=$model->to_branch;
						$model->purch_price=($model->qty/$qty_t_mon_depr)*$model->purch_price;
						$accum=$query_accum['accum_last_yr']*($model->qty/$qty_t_mon_depr);
						$model->accum_last_yr=$accum;
						if($success && $model->executeSpMSTFasset(AConstant::INBOX_STAT_INS,$model->asset_cd,1) > 0 )
						{
					 		$success=true;
						}
						else{
							$success=false;
						}
					}		
				}
				else {
					if($model->qty==$qty_t_mon_depr){
						$model->asset_stat='WRITE OFF';
					} else {
						$model->asset_stat='ACTIVE';
					}					
					if($success && $model->executeSpMSTFasset(AConstant::INBOX_STAT_UPD,$model->asset_cd,1) > 0 )
					{
					 	$success=true;
					}
					else{
						$success=false;
						}	
				}
			}
			}
				if($success){
					$transaction->commit();	
					Yii::app()->user->setFlash('success', 'Successfully create '.$model->asset_cd);
					$this->redirect(array('/glaccounting/fixedassetmovement/index'));
					$mvmt_check=1;
				} else {
					$transaction->rollback();
				}
				
			}
			

		$this->render('create',array(
			'model'=>$model,
			'modelReceive'=>$modelReceive,
			'fasset'=>$fasset,
			'brch'=>$brch,
			'mvmt_check'=>$mvmt_check,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($doc_date,$asset_cd)
	{
		
		$model=$this->loadModel($doc_date,$asset_cd);
		$model1=new Fixedassetmovement;
		$modelReceive = array(); 
		$success=true;
		$mvmt_check=1;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		// $model->doc_date=date('d/m/Y');
		$sql = "select prm_cd_2,prm_cd_2||' - '||prm_desc prm_desc from MST_parameter where prm_cd_1='FASSET'";
		$fasset=Parameter::model()->findAllBySql($sql);
		$sql2= "select brch_cd,brch_cd||' - '||brch_name brch_name from mst_branch";
		$brch=Branch::model()->findAllBySql($sql2);
		$sql3 = DAO::queryRowSql("SELECT to_char(MAX(SUBSTR(depr_mon,3,2)||SUBSTR(depr_mon,1,2))) start_dt FROM T_MON_DEPR where cre_dt is not null");
		$start_dt=$sql3['start_dt'];
		$last_t_mon_depr=substr($start_dt,2).substr($start_dt,0,2);
		
		if(isset($_POST['Vfassetmovement']))
		{
		$model1->attributes=$_POST['Vfassetmovement'];
			// var_dump($model1->doc_date);die();
			$query_qty=DAO::queryRowSql("select qty from t_mon_depr where asset_cd='".$model1->asset_cd."' and depr_mon='".$last_t_mon_depr."'");
			$qty_t_mon_depr=$query_qty['qty'];
			$query_accum=DAO::queryRowSql("select accum_last_yr from mst_fixed_asset where asset_cd='".$model1->asset_cd."'");
			$accum=$query_accum['accum_last_yr'];
			
			
			$connection  = Yii::app()->db;
			$transaction = $connection->beginTransaction();	
			$menuName = 'FASSET MOVEMENT ENTRY';
			if($model1->validate()){
			
			if($model1->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName) > 0)$success = true;
	
			
			if($success && $model1->executeSpTFasset(AConstant::INBOX_STAT_UPD,$model1->doc_date,$model1->asset_cd,1) > 0 )$success=true;
				else{
					$success=false;
				}
				if($success){
				if($model1->mvmt_type=='BUY'){
					$model1->accum_last_yr=0;
					$model1->asset_stat='ACTIVE';
					if($success && $model1->executeSpMSTFasset(AConstant::INBOX_STAT_UPD,$model1->asset_cd,1) > 0 )
					{
					 	$success=true;
					}
					else{
						$success=false;
						}
				}
				else if($model1->mvmt_type=='SELL'){
					if($model1->qty==$qty_t_mon_depr){
						$model1->asset_stat='SOLD';
					} else {
						$model1->asset_stat='ACTIVE';
					}
					if($success && $model1->executeSpMSTFasset(AConstant::INBOX_STAT_UPD,$model1->asset_cd,1) > 0 )
					{
					 	$success=true;
					}
					else{
						$success=false;
						}
				}
				else if($model1->mvmt_type=='TRANSFER'){
					$model1->accum_last_yr;
					if($model1->qty==$qty_t_mon_depr){
						$model1->asset_stat='TRANSFER';
					} else {
						$model1->asset_stat='ACTIVE';
						$model1->purch_price=($model1->qty/$qty_t_mon_depr)*$model1->purch_price;
						
					}
					if($success && $model1->executeSpMSTFasset(AConstant::INBOX_STAT_UPD,$model1->asset_cd,1) > 0 )
					{
					 	$success=true;
					}
					else{
						$success=false;
						}	
				}
				else {
					$model->asset_stat='WRITE OFF';
					if($success && $model1->executeSpMSTFasset(AConstant::INBOX_STAT_UPD,$model1->asset_cd,1) > 0 )
					{
					 	$success=true;
					}
					else{
						$success=false;
						}	
				}
			}
			}
				if($success){
					$transaction->commit();	
					Yii::app()->user->setFlash('success', 'Successfully create '.$model->asset_cd);
					$this->redirect(array('/glaccounting/fixedassetmovement/index'));
				} else {
					$transaction->rollback();
				}
				
			}

		$this->render('update',array(
			'model'=>$model,
			'modelReceive'=>$modelReceive,
			'fasset'=>$fasset,
			'brch'=>$brch,
			'mvmt_check'=>$mvmt_check,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($doc_date,$asset_cd)
	{
		$this->loadModel($doc_date,$asset_cd)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionAjxPopDelete($doc_date,$asset_cd)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		$model1 = $this->loadModel($doc_date,$asset_cd);
		$model2 = new Fixedassetmovement;
		
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes  = $_POST['Tmanyheader'];
			$model2->attributes = $model1->attributes;
			// var_dump($model2->asset_cd);die();
			if($model2->validate()){
					
				$model2->cancel_reason  = $model->cancel_reason;
				$model2->user_id = Yii::app()->user->id;
				$model2->ip_address = Yii::app()->request->userHostAddress;
				if($model2->ip_address=="::1")
					$model2->ip_address = '127.0.0.1';
				
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();	
				$menuName = 'FASSET MOVEMENT ENTRY';
				
				if($model2->executeSpHeader(AConstant::INBOX_STAT_CAN,$menuName) > 0)$is_successsave = true;
								
				if($model2->executeSpTFasset(AConstant::INBOX_STAT_CAN,$model2->doc_date,$model2->asset_cd,1) > 0)$is_successsave = true;	
				if($model2->executeSpMSTFasset(AConstant::INBOX_STAT_CAN,$model2->asset_cd,1) > 0 )$is_successsave = true;
				
				if($is_successsave==true){
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model2->asset_cd);
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Vfassetmovement('search');
		$model->unsetAttributes();  // clear any default values
		// $sql="select PRM_CD_2, PRM_DESC ||' - '||PRM_CD_2 PRM_DESC from mst_parameter where prm_cd_1='BANKCD' order by prm_desc";
		// $dropdown_bankcd=Parameter::model()->findAllBySql($sql);
		if(isset($_GET['Vfassetmovement']))
			$model->attributes=$_GET['Vfassetmovement'];
		$this->render('index',array(
			'model'=>$model//,'dropdown_bankcd'=>$dropdown_bankcd
		));
		
	}


	public function actionAssetcd(){
		$resp['status']='error';
		if(isset($_POST['asset_cd'])){
			$assetcd = $_POST['asset_cd'];
			
		//$query_type="select f_asset_type('$assetcd') as asset from dual";
		// $query_desc="select f_asset_desc('$assetcd') as asset from dual";
		// $query_branch="select f_asset_branch('$assetcd') as asset from dual";
		// $query_age="select f_asset_age('$assetcd') as asset from dual";
		// $query_purch_dt="select f_asset_purch_dt('$assetcd') as asset from dual";
		// $query_qty="select f_mon_depr_qty('$assetcd') as asset from dual";
		// $query_purch_price="select f_mon_depr_purch_price('$assetcd') as asset from dual";
			
			$sql3 = DAO::queryRowSql("SELECT to_char(MAX(SUBSTR(depr_mon,3,2)||SUBSTR(depr_mon,1,2))) start_dt FROM T_MON_DEPR where cre_dt is not null");
			$start_dt=$sql3['start_dt'];
			$last_t_mon_depr=substr($start_dt,2).substr($start_dt,0,2);
			$asset = DAO::queryRowSql("select a.asset_type, a.asset_desc, a.branch_cd,
			a.age, a.purch_dt, a.purch_price, b.qty, a.asset_stat, (b.qty-(select qty from t_fasset_movement where asset_cd='$assetcd' and approved_stat='A')) total_qty 
			from mst_fixed_asset a join t_mon_depr b on a.asset_cd=b.asset_cd where a.asset_cd='$assetcd' and depr_mon='$last_t_mon_depr'");		
			// $qty_t_fasset_movement= Fi
			
			// $assetpurchdt=to_char(assetpurchdt,'dd/mm/yyyy');
				
				$resp['assettype'] = $asset['asset_type'];
				$resp['assetdesc'] = $asset['asset_desc'];
				$resp['assetbranch'] = $asset['branch_cd'];
				$resp['assetage'] = $asset['age'];
				$resp['assetpurchdt'] = date('d/m/Y',strtotime($asset['purch_dt']));
				if($asset['total_qty']<>NULL){
					$resp['assetqty'] = $asset['total_qty'];	
				} else {
					$resp['assetqty'] = $asset['qty'];
				}
				
				$resp['assetstat']=$asset['asset_stat'];
				$resp['assetpurchprice']=number_format($asset['purch_price']);
				
				$resp['status']='success';
		
		}
		
		echo json_encode($resp);		
		
	}
	
	public function actionAssetno(){
		$resp['status']='error';
		if(isset($_POST['asset_no'])){
			$assetno = $_POST['asset_no'];
			
		$query="select f_asset_num('$assetno') as asset from dual";
			$assetnum = DAO::queryRowSql($query);
			
				$resp['num'] = $assetnum['asset'];
				
				$resp['status']='success';
		
		}
		
		echo json_encode($resp);		
		
	}
	
	public function actionAssetno_2(){
		$resp['status']='error';
		if(isset($_POST['asset_no'])){
			$assetno = $_POST['asset_no'];
			$assetno = DAO::queryRowSql("select asset_type from mst_fixed_asset where asset_cd=('$assetno')");
			$assetno = $assetno['asset_type'];
		$query="select f_asset_num('$assetno') as asset from dual";
			$assetnum = DAO::queryRowSql($query);
			
				$resp['num'] = $assetnum['asset'];
				
				$resp['status']='success';
		
		}
		
		echo json_encode($resp);		
		
	}
	


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FixedAssetMovement the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($doc_date,$asset_cd)
	{
		$model=Vfassetmovement::model()->find(array('condition'=>"doc_date='".$doc_date."' and asset_cd='".$asset_cd."'"));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FixedAssetMovement $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='fixed-asset-movement-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
