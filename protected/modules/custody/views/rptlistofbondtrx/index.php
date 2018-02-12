
<?php
$this->menu=array(
	array('label'=>'List of Bond Transaction', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'iporeport-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	echo $form->errorSummary($model);
?>

<br/>

<div class="row-fluid">
	
	<div class="span6">
	<legend><h5>Transaction / Value Date</h5></legend>
		<div class="control-group">
				<div class="span3">
					<label>Date</label>
				</div>
				<div class="span3">
					<?php echo $form->radioButton($model,'option_date',array('value'=>'0'))."&nbsp Transaction";?>
				</div>
				<div class="span3">
					<?php echo $form->radioButton($model,'option_date',array('value'=>'1'))."&nbsp Value";?>
				</div>
			</div>
	
		
		<div class="control-group">
			
			<div class="span3">
				<label>From</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'bgn_date',array('class'=>'span10 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
			<div class="span1">
				<label> To</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'end_date',array('class'=>'span10 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
	<!--
		<div class="control-group">
				<div class="span3">
					<label>Ticket No. From</label>
				</div>
				<div class="span3">
					<?php //echo $form->dropDownList($model,'ticket_no_from',CHtml::listData($dropdown_ticket, 'trx_id_yymm', 'trx_ref'), array('class'=>'span10','prompt'=>'-Select-'));?>
				</div>
				<div class="span1">
					<label> To</label>
				</div>
				<div class="span3">
					<?php //echo $form->dropDownList($model,'ticket_no_to',CHtml::listData($dropdown_ticket, 'trx_id_yymm', 'trx_ref'), array('class'=>'span10','prompt'=>'-Select-'));?>
				</div>
			</div>-->
	
		
	</div>
	<div class="span6">
	
	</div>

</div>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id'=>'btnSubmit',
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Show Report',
	)); ?>
</div>

<br/>
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php echo $form->datePickerRow($model,'dummy_date',array('style'=>'display:none','label'=>false));?>
<?php $this->endWidget() ?>
<script>
	
	//var ticket_no_from  = '<?php //echo $model->ticket_no_from ;?>';
	//var ticket_no_to  = '<?php //echo $model->ticket_no_to ;?>';
	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		//getTicketList();
	}
	
	$('#Rptlistofbondtrx_bgn_date').change(function(){
		$('#Rptlistofbondtrx_end_date').val($('#Rptlistofbondtrx_bgn_date').val());
		//getTicketList();
	})

	//$('#Rptlistofbondtrx_ticket_no_from').change(function(){
//		$('#Rptlistofbondtrx_ticket_no_to').val($('#Rptlistofbondtrx_ticket_no_from').val());
//	})
	/*
	
		function getTicketList()
		{
			$.ajax({
				'type'     :'POST',
				'url'      : '<?php //echo $this->createUrl('Get_ticket_no'); ?>',
				'dataType' : 'json',
				'data'     : {
								'bgn_date' : $("#Rptlistofbondtrx_bgn_date").val(),
								'end_date' : $("#Rptlistofbondtrx_end_date").val(),
							}, 
				'success'  : function(data){
					var ticket_no = data.content.ticket_no;
					var ticket_no_desc = data.content.ticket_no_desc;
					if(ticket_no.length>0)
					{
					$('#Rptlistofbondtrx_ticket_no_from').empty();
					$('#Rptlistofbondtrx_ticket_no_to').empty();
					$('#Rptlistofbondtrx_ticket_no_from').append($('<option>').val(' ').text('-Select-'));
					$('#Rptlistofbondtrx_ticket_no_to').append($('<option>').val(' ').text('-Select-'));
					}
					$.each(ticket_no, function(i, item) {
												  $('#Rptlistofbondtrx_ticket_no_from').append($('<option>').val(ticket_no[i]).text(ticket_no_desc[i]));
						$('#Rptlistofbondtrx_ticket_no_to').append($('<option>').val(ticket_no[i]).text(ticket_no_desc[i]));
																		});	
					$('#Rptlistofbondtrx_ticket_no_from').val(ticket_no_from);	
					$('#Rptlistofbondtrx_ticket_no_to').val(ticket_no_to);
				}
			});
		}
		*/
	
		
</script>

