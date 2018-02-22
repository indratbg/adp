<?php

class ContractavgpriceController extends AAdminController
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
	
	public function actionUpdate($id)
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
		
		$maxduedt = '';
		$maxduedtforamt = '';
		
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
			$duedt = DateTime::createFromFormat('Y-m-d',$model[$z]->due_dt_for_amt)->format('Ymd');
			if($maxduedt == ''){
				$maxduedt = $duedt;
				$maxduedtforamt = DateTime::createFromFormat('Y-m-d',$model[$z]->due_dt_for_amt)->format('d/m/Y');
			}elseif($maxduedt < $duedt){
				$maxduedt = $duedt;
				$maxduedtforamt = DateTime::createFromFormat('Y-m-d',$model[$z]->due_dt_for_amt)->format('d/m/Y');
			}else{
				//do nothing
			}
			
		}
		
		$model[1]->correction_reason = 'Average price';
		
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
			$model[1]->scenario = 'splitting';
				
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
					$avgprice = $model1[$x]->avg_price;
					$totalqty += $model1[$x]->qty;
					$seq++;
				}	
			}
			
			$model[1]->correction_reason = $_POST['cancelreason'];
			$valid = $model[1]->validate(array('correction_reason')) && $valid;
			
			if($totalqty != $trueqty || $totalqty == 0){
				$valid = false;
				$flg = 0;
				for($x=$z+1;$x<=$rowCount;$x++){
					if(isset($_POST['Tcontracts'][$x]) && $flg == 0){
						$model[1]->addError('', 'Total quantity must equal to '.$trueqty);
						$flg = 1;
					}
				}
			}
			
			foreach($model1 as $row){
				if(substr($row->client_cd,-1) == 'M' && $valid){
					$qcekmargin = DAO::queryRowSql("SELECT F_CEK_STK_MARGIN('$row->stk_cd','SPLIT') as ismarginvalid FROM dual");
					
					if($qcekmargin['ismarginvalid'] == '1'){
						$valid = true;
					}else{
						$valid = FALSE;
						$model[1]->addError('', 'Saham '.$row->stk_cd.' tidak valid untuk nasabah margin!');
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
			if($model[1]->executeSpManyHeader(AConstant::INBOX_STAT_UPD,$menuName,$transaction) > 0)
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
					$bj = substr($model[1]->contr_num,4,1);
					if($success && $model1[$x]->executeSpAvgPrice(AConstant::INBOX_STAT_INS,$x,$totalqty,$totalbrok,$totalcommission,$totalval,$totaltranslevy,$totalvat,$totalpph,$bj,$transaction) > 0){
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
				$this->redirect(array('/contracting/contractavgprice/index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'model1'=>$model1,
			'trueqty'=>$trueqty,
			'totalqty'=>$totalqty,
			'rowz'=>$z,
			'rowCount'=>$rowCount,
			'maxduedtforamt'=>$maxduedtforamt,
			'avgprice'=>$avgprice
		));
	}
	
	public function actionIndex()
	{
		$model=new Vcontractavgprice('search');
		$model->unsetAttributes();  // clear any default values
		$model->contr_dt = date('d/m/Y');
		
		$tcontracts = new Tcontracts;
		
		if(isset($_GET['Vcontractavgprice'])):
			$model->attributes=$_GET['Vcontractavgprice'];
		endif;
		
		$this->render('index',array(
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
}
