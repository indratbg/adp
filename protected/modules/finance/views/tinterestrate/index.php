<?php
$this->breadcrumbs=array(
	'List of Latest Interest Rate'=>array('index'),
	'List',
);
/*

$this->menu=array(
	array('label'=>'List of Latest Interest Rate', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tinterestrate/index','icon'=>'list'),
	//array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
);*/


$this->menu=array(
	//array('label'=>'Tvd55', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List of Latest Interest Rate', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
		array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tinterestrate/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tinterestrate-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tinterestrate-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'branch_code','htmlOptions'=>array('style'=>'width:20px;')),
		'client_cd',
		'client_name',
		array('name'=>'old_ic_num','htmlOptions'=>array('style'=>'width:40px;')),
		'ar',
		'ap',
		array('name'=>'eff_dt','type'=>'date'),
		'cl_desc',
		'obs',
		//'interest_type',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view} {update}',
			'updateButtonUrl'=>'Yii::app()->createUrl("finance/tinterestrate/update",array(\'client_cd\'=>$data->client_cd))',
			'viewButtonUrl'=>'Yii::app()->createUrl("finance/tinterestrate/view",array(\'client_cd\'=>$data->client_cd))',
		),
	),
)); ?>
