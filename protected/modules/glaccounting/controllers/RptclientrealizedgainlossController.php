<?php

class RptclientrealizedgainlossController extends AAdminController {

	public $layout = '//layouts/admin_column3';

	public function actionGetclient() {
		$i = 0;
		$src = array();
		$term = strtoupper($_REQUEST['term']);
		$qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '" . $term . "%')
      			AND susp_stat = 'N'
      			AND rownum <= 11
      			ORDER BY client_cd
      			");

		foreach ($qSearch as $search) {
			$src[$i++] = array('label' => $search['client_cd'] . ' - ' . $search['client_name'], 'labelhtml' => $search['client_cd'], 'value' => $search['client_cd']);
		}

		echo CJSON::encode($src);
		Yii::app() -> end();
	}

	public function actionIndex() {
		$model = new Rptclientrealizedgainloss('CLIENT_REALIZED_GAIN_LOSS', 'R_REALISED_GAINLOSS', 'client_realised_gainloss.rptdesign');
		$dropdown_branch = Branch::model() -> findAll(array('select' => "brch_cd, brch_cd ||' - '|| brch_name as brch_name", 'condition' => "approved_stat='A' ", 'order' => 'brch_cd'));
		$dropdown_rem_cd = Sales::model() -> findAll(array('select' => " rem_cd, rem_cd||' - '||rem_name rem_name ", 'condition' => "approved_stat='A' ", 'order' => 'rem_cd'));
		$dropdown_stk_cd = Counter::model() -> findAll(array('select' => " stk_cd, stk_cd||' - '||stk_desc stk_desc ", 'condition' => "approved_stat='A' ", 'order' => 'stk_cd'));
		$model -> bgn_date = date('d/m/Y');
		$model -> end_date = date('d/m/Y');
		$url = '';
		$url_xls = '';
		if (isset($_POST['Rptclientrealizedgainloss'])) {
			$model -> attributes = $_POST['Rptclientrealizedgainloss'];
			$client_cd=$model->client_cd;
			//stock
			if ($model -> stk_cd) {
				$bgn_stk = $model -> stk_cd;
				$end_stk = $model -> stk_cd;
			} else {
				$bgn_stk = '%';
				$end_stk = '_';
			}
 				 
 				// $random_temp=$model->vo_random_value;
 			// if ($model -> vo_random_value != NULL) {
				// if ($model -> validate() && $model -> executeRpt($model->client_cd,$model->bgn_date,$model->end_date,$bgn_stk,$end_stk,$model->vo_random_value) > 0) {
				// $model->vo_random_value=$random_temp;	
				// var_dump($model->vo_random_value);die();
						// $model -> vp_userid = 'AS';
						// $param = '&ACC_TOKEN='. 'zz' . '&ACC_USER_ID=' . $model->vp_userid . '&RP_RANDOM_VALUE=' . $model->vo_random_value;
						// $rpt_link = Constanta::URL . $model -> rptname . $param;
						// $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
						// $url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				// }
			// } else {
				 	if ($model -> validate() && $model -> executeRpt($client_cd,$bgn_stk,$end_stk) > 0) {
					
					$begin_date = DateTime::createFromFormat('Y-m-d', $model -> bgn_date) -> format('d-m-Y');
					$end_date = DateTime::createFromFormat('Y-m-d', $model -> end_date) -> format('d-m-Y');	
					// $rpt_link = $model -> showReport($model -> bgn_date,$model -> end_date);
					$rpt_link = $model -> showReport($begin_date,$end_date);
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					 // // var_dump($model->vo_random_value);die();
					}

			// Untuk Testing
   
// 
    // $locale = '&__locale=in_ID';
    // $param     = '&ACC_TOKEN='.'XX'.'&ACC_USER_ID='.'AS'.'&RP_RANDOM_VALUE='.'614505464';
    // $url   = Constanta::URL.$model->rptname.$locale.$param.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';

    
		}

		if (DateTime::createFromFormat('Y-m-d', $model -> bgn_date)){
			$model -> bgn_date = DateTime::createFromFormat('Y-m-d', $model -> bgn_date) -> format('d/m/Y');
		}
		if (DateTime::createFromFormat('Y-m-d', $model -> end_date)){
			$model -> end_date = DateTime::createFromFormat('Y-m-d', $model -> end_date) -> format('d/m/Y');
		}
		$this -> render('index', array('model' => $model, 'url' => $url, 'url_xls' => $url_xls, 'branch_cd' => $dropdown_branch, 'rem_cd' => $dropdown_rem_cd, 'dropdown_stk_cd' => $dropdown_stk_cd));

}

}
