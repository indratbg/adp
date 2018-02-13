<?php

class TcontractsController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	/*
	public function genAutocompleteClient($client_cd)
    {
      $arr = array();
	  $cl = Client::model()->find("client_cd = '$client_cd'");
      $models = Client::model()->findAll(array('condition'=>"susp_stat <> 'N' AND SID LIKE '$cl->sid'",'order'=>'client_cd'));
      foreach($models as $model)
      {
        $arr[] = array(
          'label'=>$model->client_cd.' - '.$model->client_name,  // label for dropdown list
          'value'=>$model->client_cd,  // value for input field
        );
      }
      
      return $arr;
    }
	*/
	public function actionCreate()
	{
		$model=new Tcontracts;

		if(isset($_POST['Tcontracts']))
		{
			$model->attributes=$_POST['Tcontracts'];
			if($model->due_dt_for_amt >= $model->contr_dt){	
				if($model->validate() && $model->executeSpIntra(AConstant::INBOX_STAT_INS) > 0){	
	            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->contr_dt);
					$this->redirect(array('/contracting/tcontracts/index'));
	            }
			}else{
				$model->addError('due_dt_for_amt', 'Due date must be bigger or equals to '.$model->contr_dt);
			}
			
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModelIntra($id),
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->user_id = Yii::app()->user->id;
		$ip = Yii::app()->request->userHostAddress;
		if($ip=="::1") $ip = '127.0.0.1';
		$model->ip_address = $ip;
		$model->brok_perc /= 100;
		$client = Client::model()->find("client_cd = :client_cd",array(':client_cd'=>$model->client_cd));
		$cif = Cif::model()->find("cifs = :cifs",array(':cifs'=>$client->cifs));
		
		if($client->custodian_cd){
			$sid = '%';
		}else{
			$sid = $cif->sid;
		}
		//var_dump($model->client_cd);
		//die();
		$model1 = array();
		$model1[0] = new Tcontracts;
		$valid = false;
		$success = false;
		$totalqty = 0;
		
		if(isset($_POST['rowcount']))
		{
			$rowCount = $_POST['rowcount'];
			$x;
			$y;
			$totalqty = 0;
			$valid = true;
			$seq = 2;
			$model->seqno = 1;
				
			for($x=2;$x<=$rowCount;$x++)
			{
				if(isset($_POST['Tcontracts'][$x]))
				{
					$model1[$x] = new Tcontracts;
					$model1[$x]->attributes=$_POST['Tcontracts'][$x];
					$temp = $model1[$x]->client_cd;
					$qcommission = DAO::queryRowSql("SELECT commission_per FROM MST_CLIENT WHERE client_cd = '$temp'");
					$commission = $qcommission['commission_per'];
					$model1[$x]->seqno = $seq;
					$model1[$x]->contr_dt = $model->contr_dt;
					$model1[$x]->stk_cd = $model->stk_cd;
					$model1[$x]->price = $model->price;
					$model1[$x]->lawan_perc = $commission/100; //AS:only to bypass the validation rule for lawan_perc
					$model1[$x]->brok_perc = $commission/100;
					$valid = $model1[$x]->validate() && $valid;
					$totalqty += $model1[$x]->qty;
					$seq++;
				}	
			}
			
			if($totalqty != $model->qty || $totalqty == 0){
				$valid = false;
				for($x=2;$x<=$rowCount;$x++){
					if(isset($_POST['Tcontracts'][$x])){
						$model1[$x]->addError('qty', 'Total quantity must equal to '.$model->qty);
					}	
				}
			}
			
		}else{
			$rowCount = 0;
		}
		
		if($valid)
		{	
			$transaction; //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
			$menuName = 'CONTRACT CORRECTION';
			if($model->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName,$transaction) > 0)
				$success = true;

			if($success && $model->executeSpCancelContract(AConstant::INBOX_STAT_CAN,1,$transaction) > 0)
				$success = true;
			else {
				$success = false;
			}
			
			for($x=2; $success && $x<=$rowCount ;$x++)
			{
				if(isset($_POST['Tcontracts'][$x]))
				{
					$model1[$x]->update_date = $model->update_date;
					$model1[$x]->update_seq = $model->update_seq;
					$model1[$x]->contr_num = $model->contr_num;
					if($success && $model1[$x]->executeSp(AConstant::INBOX_STAT_INS,$x,$transaction) > 0){
						$success = true;
					}else {
						$success = false;
					}
				}	
			}

			if($success)
			{
				$transaction->commit();
				Yii::app()->user->setFlash('success', 'Successfully update contract correction');
				$this->redirect(array('/contracting/tcontractscorrection/index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'model1'=>$model1,
			'sid'=>$sid,
			'rowCount'=>$rowCount,
			'totalqty'=>$totalqty
		));
	}
	
	public function actionUpdateavgprice($id)
	{
		$contrnum = array();
		$contrnum = explode(',',$id);
		$z = 0;
		$model = array();
		$commission = array();
		$trueqty = 0;
		
		$totalqty = 0;
		$totalbrok = 0;
		$totalcommission = 0;
		$totalval = 0;
		$totaltranslevy = 0;
		$totalvat = 0;
		$totalpph = 0;
		
		foreach($contrnum as $cnum){
			$z++;
			$model[$z] = $this->loadModel($cnum);
			$model[$z]->user_id = Yii::app()->user->id;
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1") $ip = '127.0.0.1';
			$model[$z]->ip_address = $ip;
			$model[$z]->brok_perc /= 100;
			$model[$z]->seqno = $z;			
			$trueqty += $model[$z]->qty;
			$totalbrok += $model[$z]->brok;
			$totalcommission += $model[$z]->commission;
			$totalval += $model[$z]->val;
			$totaltranslevy += $model[$z]->trans_levy;
			$totalvat += $model[$z]->vat;
			$totalpph += $model[$z]->pph;
		}
		
		//var_dump($id);
		//die();
		$model1 = array();
		$model1[0] = new Tcontracts;
		$valid = false;
		$success = false;
		
		
		
		$avgprice = 0;
		
		//var_dump($_POST['rowcount']);
		//die();
		
		if(isset($_POST['rowcount']))
		{
			$rowCount = $_POST['rowcount'];
			$x;
			$y;
			$valid = true;
			$seq = $z+1;
				
			for($x=$seq;$x<=$rowCount;$x++)
			{
				if(isset($_POST['Tcontracts'][$x]))
				{
					$avgprice = $_POST['avg_price'];
					$model1[$x] = new Tcontracts;
					$model1[$x]->attributes=$_POST['Tcontracts'][$x];
					$temp = $model1[$x]->client_cd;
					$qcommission = DAO::queryRowSql("SELECT commission_per FROM MST_CLIENT WHERE client_cd = '$temp'");
					$commission = $qcommission['commission_per'];
					$model1[$x]->seqno = $seq;
					$model1[$x]->contr_dt = $model[1]->contr_dt;
					$model1[$x]->stk_cd = $model[1]->stk_cd;
					$model1[$x]->price = $avgprice;
					$model1[$x]->avg_price = $avgprice;
					$model1[$x]->lawan_perc = $commission/100; //AS:only to bypass the validation rule for lawan_perc
					$model1[$x]->brok_perc = $commission/100;
					$model1[$x]->contr_num = $model[1]->contr_num;
					$valid = $model1[$x]->validate() && $valid;
					$totalqty += $model1[$x]->qty;
					$seq++;
				}	
			}
			
			if($totalqty != $trueqty || $totalqty == 0){
				$valid = false;
				for($x=$z+1;$x<=$rowCount;$x++){
					if(isset($_POST['Tcontracts'][$x])){
						$model1[$x]->addError('qty', 'Total quantity must equal to '.$trueqty);
					}
				}
			}
			
		}else{
			$rowCount = 0;
		}
		
		//var_dump($totalbrok);
		//die();
		
		if($valid)
		{	
			$transaction; //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
			$menuName = 'CONTRACT AVG PRICE';
			if($model[1]->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName,$transaction) > 0)
				$success = true;

			for($x=1; $success && $x<=$z; $x++){
				$model[$x]->update_date = $model[1]->update_date;
				$model[$x]->update_seq = $model[1]->update_seq;
				if($success && $model[$x]->executeSpCancelContract(AConstant::INBOX_STAT_CAN,$x,$transaction) > 0)
					$success = true;
				else {
					$success = false;
				}
			}
			
			for($x=$z+1; $success && $x<=$rowCount ;$x++)
			{
				if(isset($_POST['Tcontracts'][$x]))
				{
					$model1[$x]->update_date = $model[1]->update_date;
					$model1[$x]->update_seq = $model[1]->update_seq;
					if($success && $model1[$x]->executeSpAvgPrice(AConstant::INBOX_STAT_INS,$x,$totalqty,$totalbrok,$totalcommission,$totalval,$totaltranslevy,$totalvat,$totalpph,$transaction) > 0){
						$success = true;
					}else {
						$success = false;
					}
				}	
			}

			if($success)
			{
				$transaction->commit();
				Yii::app()->user->setFlash('success', 'Successfully update contract avg price');
				$this->redirect(array('/contracting/tcontractsavgprice/index'));
			}
		}

		$this->render('updateavgprice',array(
			'model'=>$model,
			'model1'=>$model1,
			'trueqty'=>$trueqty,
			'totalqty'=>$totalqty,
			'rowz'=>$z,
			'rowCount'=>$rowCount
		));
	}

	public function actionUpdateintra($id)
	{		
		$model=$this->loadModelIntra($id);
		$model->brok_perc /= 100;
		//$model = new Tcontracts;
		if(isset($_POST['Tcontracts']))
		{			
			$model->attributes=$_POST['Tcontracts'];
			//var_dump($model);
			//die();
			if($model->due_dt_for_amt >= $model->contr_dt){
				if($model->validate() && $model->executeSpIntra(AConstant::INBOX_CONTR_UPD) > 0){	
	            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->contr_dt);
					$this->redirect(array('/contracting/tcontracts/index'));
	            }
			}else{
				$model->addError('due_dt_for_amt', 'Due date must be bigger or equals to '.$model->contr_dt);
			}
		}

		$this->render('updateintra',array(
			'model'=>$model,
		));
	}

	public function actionAjxPopDelete($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		$model1 = NULL;
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
			if($model->validate()){
				$model1 = $this->loadModelIntra($id);
				$model1->cancel_reason  = $model->cancel_reason;
				$model1->brok_perc /= 100;
				if($model1->validate() && $model1->executeSpIntra(AConstant::INBOX_STAT_CAN) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->contr_num);
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
		$model=new Vcontractcorrection('search');
		$model->unsetAttributes();  // clear any default values
		$model->contr_dt = date('d/m/Y');
		
		$tcontracts = new Tcontracts;
		
		if(isset($_GET['Vcontractcorrection'])):
			$model->attributes=$_GET['Vcontractcorrection'];
		endif;
		
		$this->render('index',array(
			'model'=>$model,
			'modelTcontracts'=>$tcontracts,
		));
	}
	
	public function actionIndexavgprice()
	{
		$model=new Vcontractavgprice('search');
		$model->unsetAttributes();  // clear any default values
		$model->contr_dt = date('d/m/Y');
		
		$tcontracts = new Tcontracts;
		
		if(isset($_GET['Vcontractavgprice'])):
			$model->attributes=$_GET['Vcontractavgprice'];
		endif;
		
		$this->render('indexavgprice',array(
			'model'=>$model,
			'modelTcontracts'=>$tcontracts,
		));
	}
	
	public function actionIndexintra()
	{
		$model=new Vcontractintrabroker('search');
		$model->unsetAttributes();  // clear any default values
		$model->contr_dt = date('d/m/Y');
		
		$tcontracts = new Tcontracts;
		
		if(isset($_GET['Vcontractintrabroker'])):
			$model->attributes=$_GET['Vcontractintrabroker'];
		endif;
		
		$this->render('indexintra',array(
			'model'=>$model,
			'modelTcontracts'=>$tcontracts,
		));
	}

	public function loadModel($id)
	{
		$model=Tcontracts::model()->findByPk($id);
		$model->belijual = substr($model->contr_num,4,1);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModelIntra($id)
	{
		$model=Tcontracts::model()->findByPk($id);
		$model->buy_broker_cd = trim($model->buy_broker_cd);
		$model->sell_broker_cd = trim($model->sell_broker_cd);
		$model->belijual = substr($model->contr_num,4,1);
		if(empty($model->sell_broker_cd)){
			$brokid = substr($model->contr_num,0,4).'B'.substr($model->contr_num,5,8);
		}else{
			$brokid = substr($model->contr_num,0,4).'J'.substr($model->contr_num,5,8);
		}
		$modelbroker=Tcontracts::model()->findByPk($brokid);
		$model->lawan_perc = $modelbroker->brok_perc/100;		
		//var_dump($brokid);
		//die();
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.'.$id);
		return $model;
	}
}
