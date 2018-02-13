<?php
$this->breadcrumbs=array(
	'Consolidation Journal Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Consolidation Journal Entry', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tconsoljrn/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
	
	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('Gljournalledger-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<br/>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'Gljournalledger-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
	array('name'=>'doc_date','type'=>'date'),
	'xn_doc_num',
	'ledger_nar',
	
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("glaccounting/Tconsoljrn/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("glaccounting/Tconsoljrn/view",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/glaccounting/Tconsoljrn/AjxPopDelete",$data->getPrimaryKey())',			// AH : change
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