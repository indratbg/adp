<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>



<h3>Report List of TC ID</h3>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'reporttcid-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row-fluid"> 
		<div class="span1">
			<?php echo $form->label($model,'Date',array('class'=>'control-label')) ?>
		</div>
		<div class="span3">
		<?php echo $form->datePickerRow($model,'tc_date',array('id'=>'tcDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span1">
			<?php echo $form->label($model,'Client',array('class'=>'control-label')) ?>
		</div>
		<div class="span3">
			<?php echo $form->radioButtonListInlineRow($model,'client_mode',array('All','Specified'),array('class'=>'clientMode','label'=>false)) ?>
		</div>
		<?php echo $form->dropDownListRow($model,'client_cd',CHtml::listData(Ttcdoc::model()->findAll(array('select'=>"NVL(client_cd,'-') client_cd",'condition'=>"tc_date =TO_DATE('$model->tc_date','DD/MM/YYYY')")), 'client_cd', 'client_cd'),array('id'=>'clientCd','class'=>'span5','label'=>false,'style'=>'display:none')) ?>
	</div>
	
	<div class="row-fluid">
		<div class="span1">
			<?php echo $form->label($model,'Doc Status',array('class'=>'control-label')) ?>
		</div>
		<div class="span3">
			<?php echo $form->radioButtonListInlineRow($model,'tc_status',array('Active','All'),array('class'=>'tcStatus','label'=>false)) ?>
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

<script>
	if($("#RptListOfTcId_client_mode_0").is(':checked'))$("#clientCd").hide();
	else
		$("#clientCd").show();

	$("#tcDate").change(function()
	{
		getClientList();
	})
	
	$(".clientMode").change(function()
	{
		if($("#RptListOfTcId_client_mode_0").is(':checked'))$("#clientCd").hide();
		else
			$("#clientCd").show();
	})

	$(".tcStatus").change(function()
	{
		//getClientList();
	})

	function getClientList()
	{
		var tc_status;
		if($("#RptListOfTcId_tc_status_0").is(':checked'))
		{
			tc_status = 0;
		}
		else
			tc_status = 1;
		
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetClientList'); ?>',
			'dataType' : 'json',
			'data'     : {
							'tc_date' : $("#tcDate").val(),
							//'tc_status' : tc_status,
						}, 
			'success'  : function(data){
				var result = data.content.client_cd;
				
				$('#clientCd').empty();
				
				//$('#clientCd').append($('<option>').val('').text('-Select Client-'));
				
				$.each(result, function(i, item) {
			    	$('#clientCd').append($('<option>').val(result[i]).text(result[i]));
				});		
			}
		});
	}
	
</script>
