<?php
class Rptmkbdvd51baris103Controller extends AAdminController
{

    public $layout = '//layouts/admin_column3';

    public function actionIndex()
    {
        $model = new Rptmkbdvd51baris103('MKBD_VD51_BARIS_103', 'R_MKBD51_103_AR', 'MKBD_VD51_Baris_103.rptdesign');
        //$model = new Rptmkbdvd51baris103('MKBD_VD51_BARIS_103', 'R_AR_103',
        // 'Daftar_Umur_Piutang_Nasabah.rptdesign');
        $model->end_date = date('d/m/Y');
        $url = '';
        $url_xls = '';
        $model->option = '0';
        if (isset($_POST['Rptmkbdvd51baris103']))
        {
            $model->attributes = $_POST['Rptmkbdvd51baris103'];
            $model->validate();
            $mode = '';
            if ($model->option == '0')
            {
                $mode = 'NPR';
            }
            else
            {
                $mode = 'STOCK';
            }

            $bgn_date = $mode;
            $end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d MM Y');

            if ($model->validate() && $model->executeRpt() > 0)
            {
                $bgn_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d M Y');
                $end_date = $bgn_date;
                $rpt_link = $model->showReport($mode, $end_date);
                $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                $url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
            }

            // Untuk Testing
            /*
             $locale = '&__locale=in_ID';
             $param = '&ACC_TOKEN=' . 'XX' . '&ACC_USER_ID=' .'INDRATBG'.
             '&RP_RANDOM_VALUE=611012134&BGN_DATE=' . $bgn_date . '&END_DATE=' .
             $end_date;
             $url = Constanta::URL . $model->rptname . $locale . $param .
             '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
             $url_xls = Constanta::URL . $model->rptname . $locale . $param .
             '&&__format=xlsx';
             */
        }
        if (DateTime::createFromFormat('Y-m-d', $model->end_date))
            $model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

        $this->render('index', array(
            'model'=>$model,
            'url'=>$url,
            'url_xls'=>$url_xls
        ));
    }

}
