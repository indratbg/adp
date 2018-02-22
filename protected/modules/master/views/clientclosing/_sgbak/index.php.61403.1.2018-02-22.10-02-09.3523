<?php
$this->breadcrumbs=array(
	'Client Closing'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Client Closing', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Close','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/clientclosing/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tclientclosing-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Closed Clients</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tclientclosing-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		//'client_cd',
		//'client_name',
		array('name'=>'Date','value'=>'$data->cre_dt','type'=>'date'),
		'client_cd',
		array('name'=>'Client Name','value'=>'Client::model()->findByPk($data->client_cd)->client_name'),
		//'upd_dt',
		//'user_id',
		//'new_stat',
		/*
		'from_stat',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'viewButtonUrl'=>'Yii::app()->createUrl("master/clientclosing/view", array("id" => $data->primaryKey))',
			'template'=>'{view}',
		),
	),
)); ?>
