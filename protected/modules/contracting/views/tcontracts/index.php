<style>
	/*h5{border-bottom: 1px solid grey;}*/
</style>

<?php
$this->breadcrumbs=array(
	'Tcontracts'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Tcontracts', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'List Intra Broker','url'=>array('indexintra'),'icon'=>'list'),
	array('label'=>'List Avg Price','url'=>array('indexavgprice'),'icon'=>'list'),
	array('label'=>'Create Intra Broker','url'=>array('create'),'icon'=>'plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tcontracts-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Contracts</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tcontracts-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'contr_dt','type'=>'date'),
		'client_cd',
		array('name'=>'belijual','value'=>'AConstant::$contract_belijual[$data->belijual]'),
		'stk_cd',
		array('name'=>'qty','value'=>'number_format($data->qty,0)'),
		'price',
		'mrkt_type',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("contracting/tcontracts/update", array("id" => $data->contr_num))',
			'template'=>'{update}',
		),
	),
)); ?>
