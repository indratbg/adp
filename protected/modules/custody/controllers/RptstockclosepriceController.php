<?php

class RptstockclosepriceController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionGetstk()
	{
		 $i = 0;
		 $src = array();
		 $term = strtoupper($_REQUEST['term']);
		 $qSearch = DAO::queryAllSql("
			 Select stk_cd, stk_desc FROM MST_COUNTER
			 WHERE STK_CD LIKE '".$term."%' and approved_stat='A'
      			 ORDER BY stk_cd
      			 ");

		 foreach ($qSearch as $search)
		 {
			 $src[$i++] = array(
				 'label' => $search['stk_cd'] . ' - ' . $search['stk_desc'],
				 'labelhtml' => $search['stk_cd'],
				 'value' => $search['stk_cd']
			 );
		 }
 

		 echo CJSON::encode($src);
		 Yii::app()->end();
	 }


	public function actionIndex()
	{
		$model = new Rptstockcloseprice('STOCK_CLOSE_PRICE','R_STK_CLOSING_PRICE','stock_closing_price.rptdesign');
		$url = '';
		$url_xls= '';
		$model->p_bgn_date=date('01/m/Y');
		$model->p_end_date=date('t/m/Y');
		$model->p_bgn_stk='';
		$model->p_end_stk='';
		$model->p_option='0';
		$p_bgn_stk='';
		$p_end_stk='';

		if (isset($_POST['Rptstockcloseprice']))
		{
			$model->attributes = $_POST['Rptstockcloseprice'];

			if ($model->p_option=='0'){
				$p_bgn_stk='%';
				$p_end_stk='_';
			}else{
				$p_bgn_stk=$model->p_bgn_stk;
				$p_end_stk=$model->p_end_stk;
			}
			
			// var_dump($model->p_bgn_date);
			// var_dump($model->p_end_date);

			// die();
			
			if ($model->validate() && $model->executeRpt($p_bgn_stk,$p_end_stk)>0)
			{
				// var_dump($model->vo_random_value);die();
					$rpt_link =$model->showReport();	

						$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
						$url_xls = $rpt_link .'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					
			}
			//var_dump('test');die();


		}
		
		
		   if (DateTime::createFromFormat('Y-m-d', $model->p_bgn_date))
			$model->p_bgn_date = DateTime::createFromFormat('Y-m-d', $model->p_bgn_date)->format('d/m/Y');
		   if (DateTime::createFromFormat('Y-m-d', $model->p_end_date))
			$model->p_end_date = DateTime::createFromFormat('Y-m-d', $model->p_end_date)->format('d/m/Y');
		
		
		$this->render('index', array(
			'model' => $model,
			'url' => $url,
			'url_xls'=> $url_xls,

		));
	}


	
}