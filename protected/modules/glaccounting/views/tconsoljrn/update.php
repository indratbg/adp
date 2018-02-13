<?php
/*
$this->breadcrumbs=array(
	'Consolidation Journal Entry'=>array('index'),
	$model[1]->xn_doc_num=>array('view','id'=>$model[1]->xn_doc_num),
	'Update',
);
*/


$this->menu=array(
	array('label'=>'Update Consolidation Journal '.$model[0]->xn_doc_num, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'View','url'=>array('view','xn_doc_num'=>$model[0]->xn_doc_num,'doc_date'=>$model[0]->doc_date),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','xn_doc_num'=>$model[0]->xn_doc_num,'doc_date'=>$model[0]->doc_date),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>




<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'cancel_reason'=>$cancel_reason,'modelfilter'=>$modelfilter)); ?>