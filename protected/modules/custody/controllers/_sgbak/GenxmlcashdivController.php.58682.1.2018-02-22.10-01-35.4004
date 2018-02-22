<?php

class GenxmlcashdivController extends AAdminController
{

    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Genxmlcashdiv;
        $modelDetail = array();
        $model->distrib_dt = date('d/m/Y');

        if (isset($_POST['scenario']))
        {
            $scenario = $_POST['scenario'];
            $model->attributes = $_POST['Genxmlcashdiv'];

            if ($model->validate())
            {
                if ($scenario == 'retrieve')
                {
                    $modelDetail = Genxmlcashdiv::model()->findAllBySql(Genxmlcashdiv::getListCashDiv($model->distrib_dt));
                    if (!$modelDetail)
                    {
                        Yii::app()->user->setFlash('danger', 'No Data Found');
                    }
                }
                else if ($scenario == 'process')
                {

                    if ($model->executeGenXMLCashDiv() > 0)
                    {

                        $this->getXML($model->distrib_dt);
                    }
                }

            }

        }
        $this->render('index', array(
            'model'=>$model,
            'modelDetail'=>$modelDetail
        ));
    }

    public function getXML($distrib_dt)
    {
        if(DateTime::createFromFormat('Y-m-d',$distrib_dt))$distrib_dt = DateTime::createFromFormat('Y-m-d',$distrib_dt)->format('Ymd');
        $file = $distrib_dt.'.wt';
        $fileName = Yii::app()->basePath . '/../upload/gen_xml_cashdiv/' . $file;

        $data = DAO::queryAllSql(Genxmlcashdiv::getXMLCashDiv());

        $handle = fopen($fileName, 'wb');
        foreach ($data as $row)
        {
            fwrite($handle, $row['xml'] . "\r\n");
        }

        fclose($handle);

        if (file_exists($fileName))
        {
            header('Content-Description: File Transfer');
            header('Content-Type: text/txt');
            header('Content-Disposition: attachment; filename="' . $file . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileName));
            ob_clean();
            flush();
            readfile($fileName);
            unlink($fileName);

        }
    }

}
?>