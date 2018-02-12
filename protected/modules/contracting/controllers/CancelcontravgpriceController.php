<?php

class CancelcontravgpriceController extends AAdminController
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
	
	public function actionAjxPopDelete($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		$currdate = date('Y-m-d');
		$model1 = NULL;
		$model2 = array();
		$model3 = array();
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		$success = false;
		$transaction;
			
		$model1    				= $this->loadModel($id);
		$model1->cancel_reason  = $model->cancel_reason;
		$menuName = 'CANCEL CONTRACT AVG PRICE';
		$model1->user_id = Yii::app()->user->id;
		$ip = Yii::app()->request->userHostAddress;
		if($ip=="::1")
			$ip = '127.0.0.1';
		$model1->ip_address = $ip;
		
		$modelaprice = Tcontraprice::model()->find(array('select'=>'orig_contr_num',
		'condition'=>"to_contr_num = '$model1->contr_num' AND stk_cd = '$model1->stk_cd' AND TO_CHAR(contr_dt,'YYYY-MM-DD') = '$model1->contr_dt' AND trx_type = SUBSTR(ORIG_CONTR_NUM,5,1)"));
		
		if($modelaprice){
			$origcontrnum = $modelaprice->orig_contr_num;
			
			$modelcontractset = Tcontraprice::model()->findAll(array('select'=>'from_contr_num, to_contr_num',
			'condition'=>"orig_contr_num = '$origcontrnum' AND stk_cd = '$model1->stk_cd' AND TO_CHAR(contr_dt,'YYYY-MM-DD') = '$model1->contr_dt' AND trx_type = SUBSTR(ORIG_CONTR_NUM,5,1) AND to_contr_num not like '%GLA%'",
			'order'=>'from_contr_num'));
			
			if($modelcontractset){
				
				$m = 0;
				$k = 0;
				foreach($modelcontractset as $row){
					if($row->from_contr_num == 'A'){
						$model2[$m] = $this->loadModel($row->to_contr_num);
						$model2[$m]->cancel_flg = 'Y';
						$model3[$k] = $this->loadModel($row->to_contr_num);
						$k++;
					}
					if($row->to_contr_num == 'A'){
						$model2[$m] = $this->loadModel($row->from_contr_num);
						$model2[$m]->cancel_flg = 'N';
					}
					$m++;
				}
				
				if(isset($_POST['Tmanyheader']))
				{					
					$model->attributes = $_POST['Tmanyheader'];
					$model->user_id = Yii::app()->user->id;
					$ip = Yii::app()->request->userHostAddress;
					if($ip=="::1")
						$ip = '127.0.0.1';
					$model->ip_address = $ip;
					if($model->validate()){
					
						if($model1->executeSpManyHeader(AConstant::INBOX_STAT_CAN,$menuName,$transaction) > 0)
							$success = true;
						else
							$success = false;
						
						$n = 1;
						foreach($model2 as $m){
							$m->cancel_reason = $model1->cancel_reason;
							$m->user_id = $model1->user_id;
							$m->ip_address = $model1->ip_address;
							$m->update_seq = $model1->update_seq;
							$m->update_date = $model1->update_date;
							if($success){
								if($m->cancel_flg == 'Y'){
									if($success && $m->executeSpCancelAvgPrice(AConstant::INBOX_STAT_CAN,$m->contr_num,$n,$transaction)){
										$success = true;
									}else{
										$success = false;
									}
								}else{
									if($success && $m->executeSpCancelAvgPrice(AConstant::INBOX_STAT_UPD,$m->contr_num,$n,$transaction)){
										$success = true;
									}else{
										$success = false;
									}
								}
							}
							$n++;
						}
					}else{
						$success = false;
					}
					
					if($success){
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Successfully cancel contract correction');
						$is_successsave = true;
					}else{
						$transaction->rollback();
					}
				}
					
			}else{
				$model->addError('','Retrieve contract set from T_CONTR_APRICE: data not found!');
			}
			
		}else{
			$model->addError('','Retrieve orig_contr_num from T_CONTR_APRICE: data not found!');
		}
		
		//var_dump($success);
		//die();

		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$model1,
			'model2'=>$model2,
			'model3'=>$model3,
			'is_successsave'=>$is_successsave
		));
	}
	
	public function actionIndex()
	{
		$model=new Vcontractavgpricecancel('search');
		$model->unsetAttributes();  // clear any default values
		$model->contr_dt = date('d/m/Y');
		
		$tcontracts = new Tcontracts;
		
		if(isset($_GET['Vcontractavgpricecancel'])):
			$model->attributes=$_GET['Vcontractavgpricecancel'];
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
