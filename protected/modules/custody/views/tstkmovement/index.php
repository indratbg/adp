<?php
$this->breadcrumbs=array(
	'Stock Movement'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'List of Manually Input Stock Movement', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Cancel Multiple','url'=>array('cancelMultiple'),'icon'=>'trash','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tstkmovementall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tstkmovement-grid', {
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
	'id'=>'tstkmovement-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'doc_dt','type'=>'date'),
		'client_cd',
		'stk_cd',
		'movement_type',
		array('name'=>'qty','value'=>'number_format($data->qty,0)','htmlOptions'=>array('style'=>'text-align:right')),
		'doc_rem',
		array('name'=>'price','value'=>'number_format($data->price,0)','htmlOptions'=>array('style'=>'text-align:right')),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("custody/Tstkmovement/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("custody/Tstkmovement/view",$data->getPrimaryKey())',
			'buttons'=>array(
				'update'=>array(
					'visible'=>'Tstkmovement::checkButtonVisible($data->doc_num, $data->ref_doc_num)'
				),
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/custody/Tstkmovement/AjxPopDelete", $data->getPrimaryKey())',			// AH : change
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Cancel Reason",this.href);
		            }',
		            'visible'=>'Tstkmovement::checkButtonVisible($data->doc_num, $data->ref_doc_num)'
		         ),
        	 )
		),
	),
)); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>
