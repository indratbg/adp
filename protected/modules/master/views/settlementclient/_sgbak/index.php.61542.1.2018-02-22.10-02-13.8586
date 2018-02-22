<?php
$this->breadcrumbs=array(
	'Client Settlement Days'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Settlementclient', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/settlementclient/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('settlementclient-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Client Settlement Days</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'settlementclient-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'eff_dt','type'=>'date'),
		'client_cd',
		array('name'=>'market_type','value'=>'Parameter::getParamDesc("MARKET", $data->market_type)'),
		array('name'=>'ctr_type','value'=>'Parameter::getParamDesc("CTRTYP", $data->ctr_type)'),
		array('name'=>'sale_sts','value'=>'AConstant::$settle_client_sale_sts[$data->sale_sts]'),
		array('name'=>'Days','value'=>'$data->kds_value','type'=>'raw'),
		/*
		'csd_script',
		'csd_value',
		'kds_script',
		'kds_value',
		'user_id',
		'cre_dt',
		'upd_dt',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("master/settlementclient/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("master/settlementclient/view",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/master/settlementclient/delete", $data->getPrimaryKey())',
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
