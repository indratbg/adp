<?php
$this->breadcrumbs=array(
	'Interest Journal Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'List of Interest Journal Entry', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tdncnh/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('Tdncnh-grid', {
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
</div> <!--search-form -->


<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'Tdncnh-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
	array('name'=>'dncn_date',
	'type'=>'date',
	'htmlOptions'=>array('width'=>100)
	),
	
	array('name'=>'folder_cd',
	'htmlOptions'=>array('width'=>100)
	),
	array('name'=>'dncn_num',
	'htmlOptions'=>array('width'=>200)
	),
	'ledger_nar',
	
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("finance/Tdncnh/update",array("id"=>$data->dncn_num))',
			'viewButtonUrl'=>'Yii::app()->createUrl("finance/Tdncnh/view",array("id"=>$data->dncn_num))',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/finance/Tdncnh/AjxPopDelete", array("id"=>$data->dncn_num))',			// AH : change
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

 