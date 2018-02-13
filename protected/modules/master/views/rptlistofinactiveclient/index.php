<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>


<h3>Report List Of Inactive Client</h3>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'reportstock-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row-fluid">
		<div class="span6">
			<fieldset>
				<h4>Transaksi</h4><hr/>
				<?php echo $form->radioButtonListInlineRow($model, 'dec_bgn_dt', Rptlistofinactiveclient::$rad_inc_end_dt, array('class'=>'rad-decbgndt')); ?>
				<?php echo $form->datePickerRow($model,'vp_bgn_dt',array('label'=>true,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','id'=>'dt-bgndt','options'=>array('format' => 'dd/mm/yyyy'))); ?>
				<?php echo $form->datePickerRow($model,'vp_end_dt',array('label'=>true,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','disabled'=>'disabled','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			</fieldset>
		</div>
		<div class="span6">
			<fieldset>
				<h4>Branch</h4><hr/>
				<?php echo $form->dropDownListRow($model,'vp_bgn_branch',CHtml::listData(Branch::model()->findAll("approved_stat <> 'C'"),'brch_cd', 'CodeAndName'),array('percent'=>'-- All Branch --'));?>
	
				
			</fieldset>		
		</div>
		<div class="clear"></div>	
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

<script>

	function ajxAdjustDate(decval)
	{
		$.ajax({
			'type' 	  :'POST',
			'url'  	  :'<?php echo $this->createUrl('AjxAdjustDate')?>',
			'data'	  :{
				decval : decval,
			},
			'success' :function(msg){
				$("#dt-bgndt").val(msg);
			},
			'error':function(){
				alert('Silahka coba lagi');
			}
		});
	} 
	
	$(".rad-decbgndt").click(function(){
		var decval = $(this).val();
		ajxAdjustDate(decval);
	});
	
	ajxAdjustDate('<?php echo $model->dec_bgn_dt; ?>');
	
</script>