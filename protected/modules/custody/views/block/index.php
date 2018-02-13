<?php
$this->breadcrumbs=array(
	'Blocks'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Block', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
);

?>

<h1>List of Blocks</h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'parameter-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'prm_cd_2',
		array('name'=>'prm_desc','value'=>'$data->prm_desc==\'Y\' ? \'BLOCKED\' : \'UNBLOCKED\''),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}',
			'updateButtonUrl'=>'Yii::app()->createUrl("custody/block/update",$data->getPrimaryKey())',
		),
	),
)); ?>