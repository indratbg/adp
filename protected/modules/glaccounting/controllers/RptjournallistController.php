<?php
class RptjournallistController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Rptjournallist('JOURNAL_LIST', 'R_JOURNAL_LIST', 'Journal_list.rptdesign');
        $model->from_date = date('d/m/Y');
        $model->to_date = date('d/m/Y');
        $model->type = 0;
        $url = '';
        if (isset($_POST['Rptjournallist']) && isset($_POST['scenario']))
        {
            $model->attributes = $_POST['Rptjournallist'];
            $scenario = $_POST['scenario'];

            if ($scenario == 'print')
            {

                $type = '';
                if ($model->type == '0')
                {
                    $type = 'ALL';
                }
                else if ($model->type == '1')
                {
                    $type = 'TRX';
                }
                else if ($model->type == '2')
                {
                    $type = 'REVERSAL';
                }

                if ($model->validate() && $model->executeRpt($type) > 0)
                {
                    $from_date = DateTime::createFromFormat('Y-m-d',$model->from_date)->format('d/m/Y');
                    $to_date = DateTime::createFromFormat('Y-m-d',$model->to_date)->format('d/m/Y');
                    $rpt_link = $model->showReport($from_date, $to_date);
                    $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                }
            }
            //scenario
            else
            {
                $this->getDataXLS($model, 'INSISTPRO_RPT');
                    
            }
        }
        if (DateTime::createFromFormat('Y-m-d', $model->from_date))
            $model->from_date = DateTime::createFromFormat('Y-m-d', $model->from_date)->format('d/m/Y');
        if (DateTime::createFromFormat('Y-m-d', $model->to_date))
            $model->to_date = DateTime::createFromFormat('Y-m-d', $model->to_date)->format('d/m/Y');

        $this->render('index', array(
            'model'=>$model,
            'url'=>$url
        ));
    }

}


