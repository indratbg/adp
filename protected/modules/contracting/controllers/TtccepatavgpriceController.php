<?php

class TtccepatavgpriceController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';
	
	public function actionCreate()
	{
		$model = new Ttccepat;
		$model->user_id = Yii::app()->user->id;
		$ip = Yii::app()->request->userHostAddress;
		if($ip=="::1") $ip = '127.0.0.1';
		$model->ip_address = $ip;
		$model->brok_perc /= 100;
			
		if(isset($_POST['client_cd']) && isset($_POST['stk_cd']) && isset($_POST['belijual']) && !isset($_POST['rowcount'])){
			$client_cd = $_POST['client_cd'];
			$stk_cd = $_POST['stk_cd'];
			$belijual = $_POST['belijual'];
			$modelfotd = $this->loadModelFotd($client_cd,$stk_cd,$belijual);
			
			$client = Client::model()->find("client_cd = :client_cd",array(':client_cd'=>$modelfotd->client_cd));
			$cif = Cif::model()->find("cifs = :cifs",array(':cifs'=>$client->cifs));
			if($client->custodian_cd){
				$sid = '%';
			}else{
				$sid = $cif->sid;
			}
			$modelClient = Client::model()->findAll(array('condition'=>"SID like '$sid' AND approved_stat <> 'C'",'order'=>'client_cd'));
			$model->client_cd = $client_cd;
			$model->stk_cd = $stk_cd;
			$model->trx_type = $belijual;
		}else{
			$modelfotd = new Vfotdtradetc;
			$modelClient = Client::model()->findAll(array('condition'=>"approved_stat <> 'C'",'order'=>'client_cd'));
		}
		//var_dump($model->client_cd);
		//die();
		$model1 = array();
		$model1[0] = new Ttccepat;
		$valid = false;
		$success = false;
		$totalqty = 0;
		$avgprice = 0;
		
		if(isset($_POST['rowcount']))
		{
			$client_cd = $_POST['from_client_cd'];
			$stk_cd = $_POST['from_stk_cd'];
			$belijual = $_POST['from_belijual'];
			
			$modelfotd = $this->loadModelFotd($client_cd,$stk_cd,$belijual);
			
			$model->client_cd = $modelfotd->client_cd;
			$model->stk_cd = $modelfotd->stk_cd;
			$model->trx_type = $modelfotd->belijual;
			$model->qty = $modelfotd->qty;
			
			$rowCount = $_POST['rowcount'];
			$x;
			$y;
			$totalqty = 0;
			$valid = true;
			$seq = 2;
				
			for($x=2;$x<=$rowCount;$x++)
			{
				if(isset($_POST['Ttccepat'][$x]))
				{
					$avgprice = $_POST['avg_price'];
					$model1[$x] = new Ttccepat;
					$model1[$x]->attributes=$_POST['Ttccepat'][$x];
					$model1[$x]->trx_type = $belijual;
					$model1[$x]->stk_cd = $stk_cd;
					$model1[$x]->price = $avgprice;
					$model1[$x]->contr_dt = $modelfotd->trade_date;
					$model1[$x]->from_client_cd = $client_cd;
					$valid = $model1[$x]->validate() && $valid;
					$totalqty += $model1[$x]->qty;
					$seq++;
				}
			}
			//var_dump($model1[2]->brok_perc);
			//die();
			
			if($totalqty > $modelfotd->qty || $totalqty == 0){
				$valid = false;
				for($x=2;$x<=$rowCount;$x++){
					if(isset($_POST['Ttccepat'][$x])){
						$model1[$x]->addError('qty', 'Invalid total quantity');
					}
				}
			}
			
		}else{
			$rowCount = 0;
			$totalqty = 0;
		}
		
		if($valid)
		{	
			$transaction; //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
			$success = false;
			$menuName = 'TC CEPAT AVG PRICE';
			if($model->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName,$transaction) > 0)
				$success = true;
			/*
			if($success && $model->executeSpSourceAvgPrice('X',1,$transaction) > 0)
				$success = true;
			else {
				$success = false;
			}
			*/
			for($x=2; $success && $x<=$rowCount ;$x++)
			{
				if(isset($_POST['Ttccepat'][$x]))
				{
					$model1[$x]->update_date = $model->update_date;
					$model1[$x]->update_seq = $model->update_seq;
					if($success && $model1[$x]->executeSpUpdAvgPrice(AConstant::INBOX_STAT_INS,$x,$transaction,$totalqty) > 0){
						$success = true;
					}else {
						$success = false;
					}
				}	
			}

			if($success)
			{
				$transaction->commit();
				Yii::app()->user->setFlash('success', 'Successfully create tc cepat avg price');
				$this->redirect(array('/inbox/ttccepatavgprice/index'));
			}else{
				$transaction->rollback();
			}
		}

		$this->render('create',array(
			'modelfotd'=>$modelfotd,
			'model'=>$model,
			'model1'=>$model1,
			'rowCount'=>$rowCount,
			'totalqty'=>$totalqty,
			'avgprice'=>$avgprice,
			'modelClient'=>$modelClient,
			'formstat'=>'insert'
		));
	}

	public function actionUpdate($client_cd,$stk_cd,$belijual,$contr_num)
	{
		$modelfotd = $this->loadModelFotd($client_cd,$stk_cd,$belijual);
		$model = $this->loadModel($contr_num);
		$model->user_id = Yii::app()->user->id;
		$ip = Yii::app()->request->userHostAddress;
		if($ip=="::1") $ip = '127.0.0.1';
		$model->ip_address = $ip;
		$model->brok_perc /= 100;
		$model->trx_type = $belijual;
		$client = Client::model()->find("client_cd = :client_cd",array(':client_cd'=>$modelfotd->client_cd));
		$cif = Cif::model()->find("cifs = :cifs",array(':cifs'=>$client->cifs));
		if($client->custodian_cd){
			$sid = '%';
		}else{
			$sid = $cif->sid;
		}
		$modelClient = Client::model()->findAll(array('condition'=>"SID like '$sid' AND approved_stat <> 'C'",'order'=>'client_cd'));
		//var_dump($model->client_cd);
		//die();
		$model1 = array();
		$model1[0] = new Ttccepat;
		$valid = false;
		$success = false;
		$totalqty = 0;
		$avgprice = 0;
		
		if(isset($_POST['rowcount']))
		{
			$rowCount = $_POST['rowcount'];
			$x;
			$y;
			$totalqty = 0;
			$valid = true;
			$seq = 2;
				
			for($x=2;$x<=$rowCount;$x++)
			{
				if(isset($_POST['Ttccepat'][$x]))
				{
					$avgprice = $_POST['avg_price'];
					$model1[$x] = new Ttccepat;
					$model1[$x]->attributes=$_POST['Ttccepat'][$x];
					$model1[$x]->trx_type = $belijual;
					$model1[$x]->stk_cd = $stk_cd;
					$model1[$x]->price = $avgprice;
					$model1[$x]->contr_dt = $modelfotd->trade_date;
					$model1[$x]->from_client_cd = $client_cd;
					$valid = $model1[$x]->validate() && $valid;
					$totalqty += $model1[$x]->qty;
					$seq++;
				}
			}
			
			if($totalqty > $modelfotd->qty || $totalqty == 0){
				$valid = false;
				for($x=2;$x<=$rowCount;$x++){
					if(isset($_POST['Ttccepat'][$x])){
						$model1[$x]->addError('qty', 'Invalid total quantity');
					}
				}
			}
			
		}else{
			$rowCount = 0;
			$totalqty = 0;
		}
		
		if($valid)
		{	
			$transaction; //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
			$menuName = 'TC CEPAT AVG PRICE';
			$success = false;
			if($model->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName,$transaction) > 0)
				$success = true;
			/*
			if($success && $model->executeSpSourceAvgPrice('X',0,$transaction) > 0)
				$success = true;
			else {
				$success = false;
			}
			*/
			if($success && $model->executeSpCancelAvgPrice(AConstant::INBOX_STAT_CAN,1,$transaction,$contr_num) > 0)
				$success = true;
			else {
				$success = false;
			}
			
			for($x=2; $success && $x<=$rowCount ;$x++)
			{
				if(isset($_POST['Ttccepat'][$x]))
				{
					$model1[$x]->update_date = $model->update_date;
					$model1[$x]->update_seq = $model->update_seq;
					if($success && $model1[$x]->executeSpUpdAvgPrice(AConstant::INBOX_STAT_INS,$x,$transaction,$totalqty) > 0){
						$success = true;
					}else {
						$success = false;
					}
				}	
			}

			if($success)
			{
				$transaction->commit();
				Yii::app()->user->setFlash('success', 'Successfully update tc cepat avg price');
				$this->redirect(array('/inbox/ttccepatavgprice/index'));
			}else{
				$transaction->rollback();
			}
		}

		$this->render('update',array(
			'modelfotd'=>$modelfotd,
			'model'=>$model,
			'model1'=>$model1,
			'rowCount'=>$rowCount,
			'totalqty'=>$totalqty,
			'avgprice'=>$avgprice,
			'modelClient'=>$modelClient,
			'formstat'=>'update'
		));
	}

	public function actionAjxPopDelete($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		$model1 = $this->loadModel($id);
		
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];	
					
			if($model->validate()){
				$model1->cancel_reason  = $model->cancel_reason;
				$model1->user_id = Yii::app()->user->id;
				$model1->ip_address = Yii::app()->request->userHostAddress;
				if($model1->ip_address=="::1")
					$model1->ip_address = '127.0.0.1';
				
				$success = false;
				$transaction;
				$menuName = 'TC CEPAT AVG PRICE';
				if($model1->executeSpHeader(AConstant::INBOX_STAT_CAN,$menuName,$transaction) > 0)$success = true;
				
				if($success && $model1->executeSpCancelAvgPrice(AConstant::INBOX_STAT_CAN,1,$transaction,$id) > 0){
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->client_cd);
					$is_successsave = true;
				}
			}
		}
		$this->render('_popcancel',array(
			'model'=>$model,
			'is_successsave'=>$is_successsave,
			'model1'=>$model1
		));
	}

	public function actionIndex()
	{
		$model= new Ttccepat('search');
		$model->unsetAttributes();
		$model->contr_num = '<>NULL';
		
		if(isset($_GET['Ttccepat'])):
			$model->attributes=$_GET['Ttccepat'];
		endif;
		
		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function loadModelFotd($client_cd,$stk_cd,$belijual)
	{
		$model=Vfotdtradetc::model()->find(array('condition'=>"client_cd = '$client_cd' AND stk_cd = '$stk_cd' AND belijual = '$belijual'"));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadModel($id)
	{
		$model=Ttccepat::model()->find(array('condition'=>"contr_num = '$id'"));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
}
