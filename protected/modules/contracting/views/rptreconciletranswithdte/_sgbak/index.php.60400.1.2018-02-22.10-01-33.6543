<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php 
	$this->breadcrumbs=array(
	'Report Reconcile Transaction With DTE'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Report Reconcile Transaction With DTE', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'importTransaction-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	
	
	<?php echo $form->errorSummary($model); ?>
	<?php AHelper::showFlash($this) ?> 
	<br>


	<div class="row-fluid">
		<div class="control-group">
			<div class="span1"> </div>
			<div class="span8">
				<?php echo $form->datePickerRow($model,'trans_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy')));?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="control-group">
			<div class="span1"> </div>
			<div class="span8">
				<?php echo $form->radioButtonListInlineRow($model, 'selected_opt', AConstant::$reconcile_dhk); ?>
			</div>
		</div>
	</div>
		
	<div class="row-fluid">
		<div class="control-group">
			<div class="span1"> </div>
			<div class="span8">
				<?php //echo $form->radioButtonListInlineRow($model, 'selected_from', array('T_CONTRACTS'=>'Transaction','TC'=>'Trade Confimation')); ?>
				<?php echo $form->radioButtonListInlineRow($model, 'selected_from', array('T_CONTRACTS'=>'Transaction')); ?>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="control-group">
			<div class="span1"></div>
			<div class="span8">
				<label class="control-label"></label>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Show Report',
					'id'=>'btnImport'
				)); ?>
			</div>
		</div>
	</div>
	
<?php $this->endWidget(); ?>

<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<script type="text/javascript" charset="utf-8">
	$("#btnImport").click(function(event)
	{	
		console.log("klik");
		//$('#mywaitdialog').dialog("open"); 
	
	})
</script>


