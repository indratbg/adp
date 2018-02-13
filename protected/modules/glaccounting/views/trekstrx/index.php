<?php
$this->breadcrumbs=array(
	'Penyertaan Reksa dana'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Penyertaan Reksa dana', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/trekstrx/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trekstrx-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Penyertaan Reksa dana</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'trekstrx-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'reks_cd',
		'reks_name',
		array('name'=>'trx_date','type'=>'date'),
		'trx_type',
		array('name'=>'subs','value'=>'number_format((float) $data->subs,6,\'.\',\',\')','htmlOptions'=>array(
		'style'=>'text-align:right;',
		
		)),
		array('name'=>'redm','value'=>'number_format((float) $data->redm,6,\'.\',\',\')','htmlOptions'=>array('style'=>'text-align:right;')),
		
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("glaccounting/Trekstrx/update",array("id"=>$data->doc_ref_num))',
			'viewButtonUrl'=>'Yii::app()->createUrl("glaccounting/Trekstrx/view",array("id"=>$data->doc_ref_num))',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/glaccounting/Trekstrx/AjxPopDelete", array("id"=>$data->doc_ref_num))',			// AH : change
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