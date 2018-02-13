<?php
$this->breadcrumbs=array(
	'Client Exception'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Client Exception', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('texceptionsplitting-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Client Exception for Contract Correction</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form --> 

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'texceptionsplitting-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'available_dt','type'=>'date'),
		'client_cd',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update}{delete}',
			'updateButtonUrl'=>'Yii::app()->createUrl("contracting/texceptionsplitting/update",$data->getPrimaryKey())',
			'deleteButtonUrl'=>'Yii::app()->createUrl("contracting/texceptionsplitting/delete",$data->getPrimaryKey())',
		),
	),
)); ?>

