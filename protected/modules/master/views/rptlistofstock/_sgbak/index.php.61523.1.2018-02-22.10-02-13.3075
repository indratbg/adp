<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php 
	$this->breadcrumbs=array(
	'Report List of Stocks'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Report List of Stocks', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>

<?php 
	$stock = Counter::model()->findAll(array('select'=>'stk_cd','condition'=>"approved_stat = 'A'",'order'=>'stk_cd'));
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
			  	<?php echo $form->dropDownListRow($model,'ctr_type',CHtml::listData(Parameter::model()->findAll("prm_cd_1 = 'CTRTYP'"),'prm_cd_2', 'prm_cd_2'),array('percent'=>'--All--'));?>
	
				<?php echo $form->dropDownListRow($model,'vp_bgn_stk',CHtml::listData($stock,'stk_cd','stk_cd'),array('prompt'=>'-All-'));?>
				<?php echo $form->dropDownListRow($model,'vp_end_stk',CHtml::listData($stock,'stk_cd','stk_cd'),array('prompt'=>'-All-'));?>
				 
				<?php echo $form->radioButtonListInlineRow($model, 'group', AConstant::$rp_list_stock_group); ?>
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

