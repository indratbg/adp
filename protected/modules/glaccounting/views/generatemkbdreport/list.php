<?php
$this->breadcrumbs=array(
	'MKBD Report'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'MKBD Report', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Generate','url'=>array('generate'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/generatemkbdreport/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rincian-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Generatemkbd-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $form->errorSummary($modelSave);?>


<?php $this->endWidget(); ?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->



<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'rincian-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'mkbd_date','type'=>'date'),
		array('name'=>'update_date','type'=>'datetime'),
		'user_id',
		array('name'=>'savetxt_date','type'=>'datetime'),
		'save_txt_by',
		array('name'=>'approved_stat','value'=>'AConstant::$approve_stat[$data->approved_stat]'),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{print}{save}',
			'buttons'=>array(
		        'print'=>array(
		        	'url' => 'Yii::app()->createUrl("/glaccounting/generatemkbdreport/print",$data->getPrimaryKey())',			// AH : change      	
		            'icon'=> 'print',
		            'label'=> 'Print'
		         ),
		        'save'=>array(
		        	'url' => 'Yii::app()->createUrl("/glaccounting/generatemkbdreport/save_text_file",$data->getPrimaryKey())',			// AH : change      	
		            'imageUrl'=> Yii::app()->request->baseUrl .'/images/save.png',
		            'label'=> 'Save'
		         ),
		     )
		),
	),
)); ?>
