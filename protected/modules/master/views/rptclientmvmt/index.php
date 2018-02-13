<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php 
	$this->breadcrumbs=array(
	'Report Client Movement'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Report Client Movement', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>



<?php AHelper::applyFormatting(); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'reportstock-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<?php AHelper::showFlash($this) ?> 
	<br>
	
	<div class="row-fluid">
		<div class="control-group">
			<div class="span1"></div>
			<div class='span10'>
				<?php echo $form->datePickerRow($model,'vp_bgn_dt',array('label'=>true,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','id'=>'dt-bgndt','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			</div>
		</div>
	</div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Show Report',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>