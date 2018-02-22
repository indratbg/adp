<?php
$this->breadcrumbs=array(
	'Fixedassets'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Fixedasset', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/fixedasset/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('fixedasset-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Fixed Assets</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'fixedasset-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'asset_cd',
		'branch_cd',
		array('name'=>'asset_type','value'=>'Parameter::getAssetType($data->asset_type)'),
		'asset_desc',
		array('name'=>'purch_dt','type'=>'date'),
		array('name'=>'purch_price','type'=>'number','htmlOptions'=>array('style'=>'text-align:right')),
		/*
		'accum_last_yr',
		'cre_dt',
		'upd_dt',
		'user_id',
		'asset_stat',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/glaccounting/fixedasset/AjxPopDelete", array("id"=>"$data->asset_cd"))',			// AH : change
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Cancel Reason",this.href);
		            }'
		         ),
        	 )
		),
	),
)); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>
