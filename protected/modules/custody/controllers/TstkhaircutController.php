<?php

class TstkhaircutController extends Controller
{
    public $layout = '//layouts/admin_column3';
    public function actionIndex()
    {
        $model = new Tstkhaircut;

        if (isset($_POST['Tstkhaircut']))
        {

            $model->attributes = $_POST['Tstkhaircut'];
            $model->scenario = 'upload';
            if ($model->validate())
            {
                $model->file_upload = CUploadedFile::getInstance($model, 'file_upload');

                $path = FileUpload::getFilePath(FileUpload::UPLOAD_HAIRCUT_STOCK, 'upload.txt');
                $model->file_upload->saveAs($path);
                $filename = $model->file_upload;

                //insert data ke Tstkhaircut
                $lines = file($path);
                $valid = true;
                foreach ($lines as $line_num=>$line)
                {
                    if ($line_num == 1)
                    {
                        $status_dt = substr(trim($line), -8);

                        if (DateTime::createFromFormat('Ymd', $status_dt))
                            $status_dt = DateTime::createFromFormat('Ymd', $status_dt)->format('Y-m-d');
                        $check = Tstkhaircut::model()->find("status_dt = to_date('$status_dt','yyyy-mm-dd')");
                        if ($check)
                        {
                            $model->addError('file_upload', 'File sudah diupload');
                            $valid = false;
                            break;
                        }
                    }

                    if ($line_num >= 3)
                    {
                        $pieces = explode('|', $line);
                        
                        if (count($pieces) == 6)
                        {

                            $model->status_dt = $status_dt;
                            $model->stk_cd = $pieces[1];
                            $model->haircut = $pieces[3];
                            $model->create_dt = new CDbExpression("TO_DATE('" . date('Y-m-d H:i:s') . "','YYYY-MM-DD HH24:MI:SS')");
                            $model->user_id = Yii::app()->user->id;

                            if ($model->save(FALSE))
                            {
                                $model = new Tstkhaircut();

                            }
                        }
                        else
                        {
                            break;
                        }
                    }
                }
                if ($valid && $model->validate() && $model->executeSpUpdateCounter() > 0)
                {
                    $valid = true;
                }
                else
                {
                    $valid = FALSE;
                }

                if ($valid)
                {
                    Yii::app()->user->setFlash('success', 'Successfully upload ' . $filename);
                    $this->redirect(array('index'));
                }

            }//end foreach
        }
        $this->render('index', array('model'=>$model));
    }

}
