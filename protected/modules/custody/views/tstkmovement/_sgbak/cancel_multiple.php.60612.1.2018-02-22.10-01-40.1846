<?php
$this->breadcrumbs=array(
	'Stock Movement'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Cancel Multiple Stock Movement', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Cancel Multiple','url'=>array('cancelMultiple'),'icon'=>'trash','itemOptions'=>array('class'=>'active','style'=>'float:right')),
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

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyScrollableGridView() ?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'tstkmovement-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(true),
	'filter'=>$model,
    'filterPosition'=>'',
    
    'bulkActions' => array(
		'actionButtons' => array(
			array(
				'buttonType' => 'button',
				'type'  => 'secondary',
				'size'  => 'small',
				'id'	=> 'btnCancelMultiple',
				'icon'  => 'trash',
				'label' => 'Cancel Checked',
				'click' => 'js:function(checked_element){
						var temp = "&";
						for(var i =0;i<checked_element.length;i++)	
							temp += ("arrid[]="+checked_element[i].value)+"&";
						temp = temp.substring(0,temp.length -1);
						
						showPopupModal("Cancel Reason","'.(Yii::app()->getBaseUrl(true).'/index.php?r=custody/tstkmovement/AjxPopCancelMultiple').'"+temp);	
				}'
			)
		),
		'checkBoxColumnConfig' => array(
		    'name' => 'id',
		    'value'=> '$data->doc_num'
		),
	),
	'columns'=>array(
		array('name'=>'doc_dt','type'=>'date'),
		'client_cd',
		'stk_cd',
		'movement_type',
		array('name'=>'qty','value'=>'number_format($data->qty,0)','htmlOptions'=>array('style'=>'text-align:right')),
		'doc_rem',
		array('name'=>'price','value'=>'number_format($data->price,0)','htmlOptions'=>array('style'=>'text-align:right')),
	),
)); ?>


<?php
  	AHelper::popupwindow($this, 600, 500);
?>
