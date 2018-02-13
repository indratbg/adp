<?php
$this->breadcrumbs=array(
	'Bonds'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Bond', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('bond-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List Of Coupon Schedule</h1>


<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'bond-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'bond_cd',
		array('name'=>'period_from','type'=>'date'),
		array('name'=>'period_to', 'type'=>'date'),
		'period_days',
		'int_rate',
		
	
	)
)
); ?>


	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bond-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
	));?>
	
	<?php echo $form->errorSummary($model);?>
	<input type="hidden" name="Bond[bond_cd]"/>
	<div class="text-center">
<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Generate',
				
			)); ?>
	
	</div>	
<?php $this->endWidget();?>
