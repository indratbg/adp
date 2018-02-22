<?php
class RptclientmotherController extends AAdminController {
	public $layout = '//layouts/admin_column3';
	public function actionGetclient() {
		$i = 0;
		$src = array();
		$term = strtoupper($_REQUEST['term']);
		$qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '" . $term . "%')
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
		$model = new Rptclientmother('MOTHER_NAME', 'R_CLIENT_MOTHERNAME', 'Mother_name.rptdesign');
		$url = '';
		$url_xls = '';
		$model -> client_status = '0';
		$model -> branch_status = '0';
		if (isset($_POST['Rptclientmother'])) {
			$model -> attributes = $_POST['Rptclientmother'];
			if ($model -> client_status == '0') {
				$client_status = "%";
			} else if ($model -> client_status == '1') {
				$client_status = "A";
			} else if ($model -> client_status == '2') {
				$client_status = 'I';
			} else {
				$client_status = 'S';
			}

			if ($model -> branch_status == '0') {
				$branch_cd = '%';
			} else {
				$branch_cd = $model -> branch_cd;
			}

			$client_cd = $model -> client_cd ? $model -> client_cd : '%';
					
			if ($model -> validate() && $model -> executeRpt($client_cd, $client_status, $branch_cd) > 0) {

				$rpt_link = $model -> showReport();	
				$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
			}

		}

		$this -> render('index', array('model' => $model, 'url' => $url, 'url_xls' => $url_xls));
	}

}
