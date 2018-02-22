<?php

class TbondpriceController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	/*
	public function actionIndex()
	{	
		$model = new Tbondprice;
		$model1 = null;
		$model2 = null;
		$modelInsert = null;
		$pricedt = null;
		$dropdownbond = Bond::model()->findAll(array('select'=>"bond_cd, (bond_cd||' - '||short_desc) bond_desc",'condition'=>"approved_sts = 'A'",'order'=>"bond_cd"));
		if(isset($_POST['pricedt'])){
			$pricedt = $_POST['pricedt'];
			$model1 = Tbondprice::model()->findAll("to_char(price_dt,'DD/MM/YYYY') = '$pricedt'");
			$model2 = Tbondprice::model()->findAll("to_char(price_dt,'DD/MM/YYYY') = '$pricedt'");
			//var_dump($model1);
			//die();
			for($i=0;$i<count($model1);$i++){
				$model1[$i]->price_dt = DateTime::createFromFormat('Y-m-d',$model1[$i]->price_dt)->format('d/m/Y');
			}
		}
		$valid1 = true;
		$valid2 = true;
		$updindex = null;
		$insindex = null;
		$pricedtval = array();
		$bondcdval = array();
		$isnew = 0;
		if((isset($_POST['updateflg'])) && ($_POST['updateflg'] != ""))
		{
			$updateflgval = $_POST['updateflg'];
			$updindex = explode(' ', $updateflgval);
			foreach($updindex as $u){
				$pricedtval[$u] = $model2[$u]->price_dt;
				$bondcdval[$u] = $model2[$u]->bond_cd;
				$model1[$u]->attributes = $_POST['Tbondprice0'][$u];
				$valid1 = $model1[$u]->validate() && $valid1;
			}
			$isnew = -1;
		}
		//var_dump($pricedtval);
		//die();
		if(isset($_POST['insertflg']) && ($_POST['insertflg'] != ""))
		{
			$insertflgval = $_POST['insertflg'];
			$insindex = explode(' ', $insertflgval);
			
			$modelInsert = array();
			
			foreach($insindex as $i){
				$modelInsert[$i] = new Tbondprice;
				$modelInsert[$i]->attributes = $_POST['Tbondprice1'][$i];
				$valid2 = $modelInsert[$i]->validate() && $valid2;
			}
			$isnew = -1;
			
		}
		
		if($valid1 && $valid2 && $isnew == -1){
			$success = true;
			$connection  = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			//var_dump($model1);
			//die();
			if((isset($_POST['updateflg'])) && ($_POST['updateflg'] != "")){
				foreach($updindex as $u){
					$model1[$u]->old_price_dt = $pricedtval[$u];
					$model1[$u]->old_bond_cd = $bondcdval[$u];
					$model1[$u]->validate();
					if($success && $model1[$u]->executeSp(AConstant::INBOX_STAT_UPD,$model1[$u]->old_price_dt,$model1[$u]->old_bond_cd)>0){
						$success = true;
					}else{
						$success = false;
					}
				}
			}
			if($success){
				if(isset($_POST['insertflg']) && ($_POST['insertflg'] != "")){
					foreach($insindex as $i){
						if($success && $modelInsert[$i]->executeSp(AConstant::INBOX_STAT_INS,$modelInsert[$i]->price_dt,$modelInsert[$i]->bond_cd)>0){
							$success = true;
						}else{
							$success = false;
						}
					}	
				}
			}
			
			if($success){
				$transaction->commit();
				Yii::app()->user->setFlash('success', 'Successfully save bond price '.$model->price_dt);
				$this->redirect(array('/custody/tbondprice/index'));
			}else{
				$transaction->rollback();
			}
		}	
		
		if(!$model1 && (isset($_POST['updateflg']))){
			$model->addError('','Bond price not found');
		}

		$this->render('index',array(
			'model1'=>$model1,
			'model'=>$model,
			'model2'=>$model2,
			'modelInsert'=>$modelInsert,
			'pricedt'=>$pricedt,
			'updindex'=>$updindex,
			'insindex'=>$insindex,
			'dropdownbond'=>$dropdownbond
		));
	}

	public function loadModel($price_dt, $bond_cd)
	{
		$model=Tbondprice::model()->findByPk(array('price_dt'=>$price_dt, '$bond_cd'=>$bond_cd));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	 * 
	 */
	public function actionIndex()
	{
		$model= array();
		$modeldummy = new Tbondprice;
		$valid = true;
		$success = false;
		
		$dropdownbond = Bond::model()->findAll(array('select'=>"bond_cd, (bond_cd||' - '||short_desc) bond_desc",'condition'=>"approved_sts = 'A'",'order'=>"bond_cd"));		
		//$selected = 0;
		//$pl_bs_flg = 'N';
		$price_dt = null;
		$cancel_reason = '';

		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			if($scenario == 'filter')
			{
				$price_dt = $_POST['pricedt'];
				
				$modeldummy->price_dt = $price_dt;
				$modeldummy->bond_cd = 'aa';
				$modeldummy->price = 99;
				$modeldummy->bond_rate = 'Z';
				$modeldummy->validate();
				
				$model = Tbondprice::model()->findAll(array(
				'select'=>'price_dt, bond_cd, price, yield, bond_rate',
				'condition'=>"to_char(price_dt,'DD/MM/YYYY') = '$price_dt' AND t.approved_stat = 'A'",
				'order'=>'price_dt, bond_cd'));
				
				foreach($model as $row)
				{
					$row->old_price_dt = $row->price_dt;
					$row->old_bond_cd = $row->bond_cd;
				}
				if(!$model){
					$modeldummy->addError('','Bond market price not found!');
				}
			}
			else 
			{
				$price_dt = $_POST['pricedt'];
				$new_price_dt = $_POST['newpricedt'];
				$modeldummy->price_dt = $price_dt;
				$modeldummy->new_price_dt = $new_price_dt;
				$modeldummy->bond_cd = 'aa';
				$modeldummy->price = 99;
				$modeldummy->bond_rate = 'Z';
				$modeldummy->validate();	
				$rowCount = $_POST['rowCount'];
				
				$x;
				
				$save_flag = false; //False if no record is saved
				
				if(isset($_POST['cancel_reason']))
				{
					if(!$_POST['cancel_reason'])
					{
						$valid = false;
						Yii::app()->user->setFlash('error', 'Cancel Reason Must Be Filled');
					}
					else
					{
						$cancel_reason = $_POST['cancel_reason'];
					}
				}
		
				for($x=0;$x<$rowCount;$x++)
				{
					$model[$x] = new Tbondprice;
					$model[$x]->attributes = $_POST['Tbondprice'][$x+1];
					
					if(isset($_POST['Tbondprice'][$x+1]['save_flg']) && $_POST['Tbondprice'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						if(isset($_POST['Tbondprice'][$x+1]['cancel_flg']))
						{
							if($_POST['Tbondprice'][$x+1]['cancel_flg'] == 'Y')
							{
								//CANCEL
								$model[$x]->scenario = 'cancel';
								$model[$x]->cancel_reason = $_POST['cancel_reason'];
							}
							else 
							{
								//UPDATE
								$model[$x]->scenario = 'update';
							}
						}
						else 
						{
							//INSERT
							$model[$x]->scenario = 'insert';
						}
						$valid = $model[$x]->validate() && $valid;
					}
				}
				
				$valid = $valid && $save_flag;
				
				if($valid)
				{
					$success = true;
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					for($x=0;$success && $x<$rowCount;$x++)
					{
							
						if($model[$x]->save_flg == 'Y')
						{
							if($model[$x]->cancel_flg == 'Y')
							{
								//CANCEL
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_CAN,$model[$x]->old_price_dt,$model[$x]->old_bond_cd) > 0)$success = true;
								else {
									$success = false;
								}
							}
							else if($model[$x]->old_price_dt)
							{
								//UPDATE
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model[$x]->old_price_dt,$model[$x]->old_bond_cd) > 0)$success = true;
								else {
									$success = false;
								}
							}			
							else 
							{
								//INSERT
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->price_dt,$model[$x]->bond_cd) > 0)$success = true;
								else {
									$success = false;
								}
							}
						}
					}

					if($success)
					{
						$transaction->commit();
							
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/custody/tbondprice/index'));
					}
					else {
						$transaction->rollback();
					}
				}
			}
		}
		else {
			$model = null;
			
		}
		//var_dump($model[1]->price_dt);
		//die();

		$this->render('index',array(
			'model'=>$model,
			'modeldummy'=>$modeldummy,
			'cancel_reason'=>$cancel_reason,
			'dropdownbond'=>$dropdownbond
		));
	}

	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether a user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}

	public function loadModel($price_dt, $bond_cd)
	{
		$model=Tbondprice::model()->findByPk(array('price_dt'=>$price_dt, '$bond_cd'=>$bond_cd));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
