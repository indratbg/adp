<?php
$this->breadcrumbs=array(
	'Fixed Asset Movement'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Fixed Asset Movement', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-10px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/fixedassetmovement/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('branch-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model
)); ?>
</div><!-- search-form --> 

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'branch-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'doc_date','type'=>'date'),
		'branch_cd',
		'asset_cd',
		'asset_desc',
		'mvmt_type',
		'qty',
		'to_branch',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("glaccounting/fixedassetmovement/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("glaccounting/fixedassetmovement/view",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/glaccounting/fixedassetmovement/AjxPopDelete", $data->getPrimaryKey())',			// AH : change
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Cancel Reason",this.href);
		            }',
		            
		         ),
        	 )
		),
	),
)); ?>


<?php
  	AHelper::popupwindow($this, 600, 500);
?>

