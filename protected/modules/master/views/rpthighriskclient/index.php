<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; }
	.checkbox.inline{padding-left:1em; padding-right:1em;}
	.div-cb{display:none}
</style>


<h3>High Risk Client Report</h3>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'rpthighriskclient-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->radioButtonListInlineRow($model, 'type', Rpthighriskclient::$client_type,array('id'=>'radio_type')); ?>
			
	<?php //echo $form->dropDownListRow($model,'vp_client',CHtml::listData(Client::model()->findAll("client_type_1 = 'I' and approved_stat = 'A'"),'client_cd', 'CodeAndName'),array('percent'=>'--All--'));?>
	
	<?php //echo $form->dropDownListRow($model,'vp_branch',CHtml::listData(Branch::model()->findAll("approved_stat = 'A'"),'brch_cd', 'CodeAndName'),array('percent'=>'--All--'));?>
	
	<div id="div_all" class="div-cb"><?php echo $form->checkBoxListInlineRow($model,'kategori_all',Rpthighriskclient::$list_all);?></div>
	<div id="div_indi" class="div-cb"><?php echo $form->checkBoxListInlineRow($model,'kategori_indi',Rpthighriskclient::$list_indi);?></div>
	<div id="div_inst" class="div-cb"><?php echo $form->checkBoxListInlineRow($model,'kategori_inst',Rpthighriskclient::$list_inst);?></div>
	
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
	function hideAll(){$('.div-cb').hide();}
	
	$('#radio_type').change(function(){
		var status = $('#radio_type input:checked').val();
		hideAll();
		switch(status)
		{
			case('<?php echo Rpthighriskclient::CLIENT_TYPE_ALL;?>'):
			$('#div_all').show();
			break;
			
			case('<?php echo Rpthighriskclient::CLIENT_TYPE_INDIVIDU;?>'):
			$('#div_indi').show();
			break;
			
			case('<?php echo Rpthighriskclient::CLIENT_TYPE_INSTITUSI;?>'):
			$('#div_inst').show();
			break;
		}//end switch
	});
	$('#radio_type').trigger('change');
	
</script>

