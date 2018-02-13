<?php
$this->breadcrumbs=array(
	'Taxrates'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Taxrate', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/taxrate/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('taxrate-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Dividend Tax Rates</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'taxrate-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'begin_dt','type'=>'date'),
		array('name'=>'end_dt','type'=>'date'),
		'rate_type',
		'client_cd',
		'stk_cd',
		'client_type_1',
		'client_type_2',
		array('name'=>'rate_1','htmlOptions'=>array('style'=>'text-align:right')),
		array('name'=>'rate_2','htmlOptions'=>array('style'=>'text-align:right')),
		/*
		'rate_1',
		'rate_2',
		'cre_dt',
		'user_id',
		'tax_desc',
		'upd_dt',
		'upd_by',
		'approved_dt',
		'approved_by',
		'approved_stat',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			//'updateButtonUrl'=>'Yii::app()->createUrl("custody/taxrate/update",$data->seqno)',
			//'viewButtonUrl'=>'Yii::app()->createUrl("custody/taxrate/view",$data->seqno)',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/custody/taxrate/AjxPopDelete", array("id" => $data->primaryKey))',			// AH : change
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
