<?php
$this->breadcrumbs=array(
	'Tautotrffail'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'List of Failed Vouchers', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('soa-grid', {
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
	'id'=>'soa-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'payrec_date','type'=>'date'),
		array('name'=>'payrec_type','value'=>'$data->getPayrecTypeDesc()'),
		array('name'=>'vch_type','value'=>'$data->getTypeDesc()'),
		'client_cd',
		'brch_cd',
		array('name'=>'outs_amt','type'=>'number','htmlOptions'=>array('style'=>'text-align:right')),
		array('name'=>'trf_amt','type'=>'number','htmlOptions'=>array('style'=>'text-align:right')),
		array('name'=>'cre_dt','type'=>'datetime'),
		'user_id',
	),
)); ?>
