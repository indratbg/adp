<?php

class RptdetailmkbdController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionIndex()
	{
		$model = new Rptdetailmkbd('DETAIL_REPORT_MKBD', 'R_DETAIL_MKBD', 'DETAIL_MKBD.rptdesign');
		$model->rpt_date = date('d/m/Y');
		$model->rpt_type = 0;
		$url = '';
		$url_xls = '';

		if (isset($_POST['Rptdetailmkbd']))
		{
			$model->attributes = $_POST['Rptdetailmkbd'];

			// TRANSAKSI BELUM T3
			if ($model->rpt_type == '0')
			{
				$model->tablename = 'R_TRX_BFR_T3';
				$model->rptname = 'Transaksi_belum_t3.rptdesign';
				if ($model->validate() && $model->executeTrxBfrT3() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//SALDO DEBIT (REGULAR)
			else if ($model->rpt_type == '1')
			{
				$model->tablename = 'R_SALDO_DEBIT';
				$model->rptname = 'Saldo_debit_credit.rptdesign';
				$type = 'R';

				if ($model->validate() && $model->executeSaldoDebit($type) > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//	 SALDO DEBIT (MARGIN)
			else if ($model->rpt_type == '2')
			{
				$model->tablename = 'R_SALDO_DEBIT';
				$model->rptname = 'Saldo_debit_credit.rptdesign';
				$type = 'M';

				if ($model->validate() && $model->executeSaldoDebit($type) > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//	SALDO KREDIT
			else if ($model->rpt_type == '3')
			{
				$model->tablename = 'R_SALDO_KREDIT';
				$model->rptname = 'Saldo_debit_credit.rptdesign';

				if ($model->validate() && $model->executeSaldoKredit() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//KPEI
			else if ($model->rpt_type == '4')
			{
				$model->tablename = 'R_KPEI_BROK';
				$model->rptname = 'KPEI_BROK.rptdesign';
				$acct_type = 'KPEI';
				if ($model->validate() && $model->executeKpeiBrok($acct_type) > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//BROKER LAIN
			else if ($model->rpt_type == '5')
			{
				$model->tablename = 'R_KPEI_BROK';
				$model->rptname = 'KPEI_BROK.rptdesign';
				$acct_type = 'BROK';
				if ($model->validate() && $model->executeKpeiBrok($acct_type) > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//PORTOFOLIO STOCK
			else if ($model->rpt_type == '6')
			{
				$model->tablename = 'R_PORTO_STOCK';
				$model->rptname = 'Portofolio_Stock.rptdesign';
				if ($model->validate() && $model->executePortoStock() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//PORTO OBLIGASI KORPORASI 
			else if ($model->rpt_type == '7')
			{
				$model->tablename = 'R_PORTO_OBLIGASI_CORP';
				$model->rptname = 'Portofolio_Obligasi_Korporasi.rptdesign';
				if ($model->validate() && $model->executePortoObligasiCorp() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//PORTO SBN
			else if ($model->rpt_type == '8')
			{
				$model->tablename = 'R_MKBD_PORTO_SBN';
				$model->rptname = 'Portofolio_Surat_Berharga_Negara.rptdesign';
				if ($model->validate() && $model->executeSuratBerhargaNegara() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//REPO DETAIL MKBD
			else if ($model->rpt_type == '10')
			{
				$model->tablename = 'R_REPO_DETAIL_MKBD';
				$model->rptname = 'Repo_Detail_Mkbd.rptdesign';
				if ($model->validate() && $model->executeRepo() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//REKSADANA DETAIL MKBD
			else if ($model->rpt_type == '11')
			{
				$model->tablename = 'R_REKSADANA_DETAIL_MKBD';
				$model->rptname = 'Reksadana_Detail_Mkbd.rptdesign';
				if ($model->validate() && $model->executeReksadana() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//VD51 DETAIL MKBD
			else if ($model->rpt_type == '12')
			{
				$model->tablename = 'R_VD51_DETAIL_MKBD';
				$model->rptname = 'Vd51_Detail_Mkbd.rptdesign';
				if ($model->validate() && $model->executeVd51() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//VD52 DETAIL MKBD
			else if ($model->rpt_type == '13')
			{
				$model->tablename = 'R_VD52_DETAIL_MKBD';
				$model->rptname = 'Vd52_Detail_Mkbd.rptdesign';
				if ($model->validate() && $model->executeVd52() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//RISIKO MARGIN DETAIL MKBD
			else if ($model->rpt_type == '14')
			{
				$model->tablename = 'R_RISK_MARGIN_DETAIL_MKBD';
				$model->rptname = 'Risk_Margin_Detail_Mkbd.rptdesign';
				if ($model->validate() && $model->executeRiskMargin() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//PENJAMIN EMISI EFEK DETAIL MKBD
			else if ($model->rpt_type == '15')
			{
				$model->tablename = 'R_PENJ_EMI_EFEK_IPO';
				$model->rptname = 'Penj_Emisi_efek_Detail_Mkbd.rptdesign';
				if ($model->validate() && $model->executePenjEmiEfek() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//VD56-10 DETAIL MKBD
			else if ($model->rpt_type == '16')
			{
				$model->tablename = 'R_VD56_10_20_DETAIL_MKBD';
				$model->rptname = 'Vd56_10_Detail_Mkbd.rptdesign';
				if ($model->validate() && $model->executeVd5610() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//VD56-20 DETAIL MKBD
			else if ($model->rpt_type == '17')
			{
				$model->tablename = 'R_VD56_10_20_DETAIL_MKBD';
				$model->rptname = 'Vd56_20_Detail_Mkbd.rptdesign';
				$end_date = DateTime::createFromFormat('d/m/Y', $model->rpt_date) -> format('d-m-Y');
				if ($model->validate() && $model->executeVd5620() > 0)
				{
					$rpt_link = $model->showReport($model->rpt_date,$end_date);
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			//VD56-17-19 DETAIL MKBD
			else if ($model->rpt_type == '18')
			{
				$model->tablename = 'R_VD56_17_19_DETAIL_MKBD';
				$model->rptname = 'Vd56_17_19_Detail_Mkbd.rptdesign';
				if ($model->validate() && $model->executeVd561719() > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}

		}

		if (DateTime::createFromFormat('Y-m-d', $model->rpt_date))
			$model->rpt_date = DateTime::createFromFormat('Y-m-d', $model->rpt_date)->format('d/m/Y');
		$this->render('index', array('model' => $model, 'url' => $url, 'url_xls' => $url_xls));
	}

}
