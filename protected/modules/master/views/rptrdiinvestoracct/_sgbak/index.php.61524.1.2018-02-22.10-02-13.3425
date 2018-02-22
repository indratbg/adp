
<?php AHelper::applyFormatting(); ?>

<?php 
	$this->breadcrumbs=array(
	'Report List of Investor Account'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Report List of Investor Account', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>

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
				<?php echo $form->radioButtonListRow($model,'option',RptRdiInvestorAcct::$rp_option); ?>
				<div class="form-actions">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Show Report',
					)); ?>
				</div>
			</div>
		</div>
	</div>
	

<?php $this->endWidget(); ?>

<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>