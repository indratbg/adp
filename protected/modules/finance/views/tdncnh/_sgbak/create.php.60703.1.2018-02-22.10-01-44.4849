<?php
$this->breadcrumbs=array(
	'Interest Journal Entry'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Create Interest Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>



<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php echo $this->renderPartial('_form', array('model'=>$model,'modeldetail'=>$modeldetail,'init'=>$init,'modelfolder'=>$modelfolder)); ?>