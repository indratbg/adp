
<?php
$this->menu=array(
	array('label'=>'List of Repo', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
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
		<div class="control-group">
			<div class="span2">
				<label>Date From</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'bgn_date',array('class'=>'span10 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
			<div class="span2">
				<label>Date To</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'end_date',array('class'=>'span10 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>Stock</label>
			</div>
			<div class="span8">
				<?php echo $form->radioButton($model,'stk_option',array('value'=>'0','class'=>'option','id'=>'option_0')) ."&emsp; All";?>
				
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'stk_option',array('value'=>'1','class'=>'option','id'=>'option_1')) ."&emsp; Specified";?>
			</div>
			<div class="span2">
				<label>From</label>
			</div>
			<div class="span2">
				<?php echo $form->dropDownList($model,'stk_cd_from',CHtml::listData($stk_cd,'stk_cd', 'stk_desc'),array('class'=>'span12','prompt'=>'-Select-'));?>
			</div>
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span2">
				<?php echo $form->dropDownList($model,'stk_cd_to',CHtml::listData($stk_cd,'stk_cd', 'stk_desc'),array('class'=>'span12','prompt'=>'-Select-'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>Broker</label>
			</div>
			<div class="span8">
				<?php echo $form->radioButton($model,'broker_option',array('value'=>'0','class'=>'option_broker','id'=>'option_broker_0')) ."&emsp; All";?>
				
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'broker_option',array('value'=>'1','class'=>'option_broker','id'=>'option_broker_1')) ."&emsp; Specified";?>
			</div>
		
			<div class="span2">
				<?php echo $form->textField($model,'broker_cd',array('class'=>'span12'));?>
			</div>
			
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span1">
				<label>Client</label>
			</div>
			<div class="span8">
				<?php echo $form->radioButton($model,'client_option',array('value'=>'0','class'=>'option2','id'=>'client_option_0')) ."&emsp; All";?>
				
			</div>
		</div>
		<div class="control-group">
			<div class="span1">
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'client_option',array('value'=>'1','class'=>'option2','id'=>'client_option_1')) ."&emsp; Specified";?>
			</div>
			<div class="span1">
				<label>From</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'bgn_client',array('class'=>'span12'));?>
			</div>
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'end_client',array('class'=>'span12'));?>
			</div>
		</div>
		
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
	init();
	function init()
	{
	$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	getClient();
	check_option_stock();
	check_option_client();
	check_option_broker();
	}
	
	$('.option').change(function(){
		check_option_stock();
	})
	$('.option2').change(function(){
		check_option_client();
	})
	
	$('#Rptlistofrepo_bgn_date').change(function(){
		$('#Rptlistofrepo_end_date').val($('#Rptlistofrepo_bgn_date').val());
	})
	$('#Rptlistofrepo_bgn_client').change(function(){
		$('#Rptlistofrepo_end_client').val($('#Rptlistofrepo_bgn_client').val());
	})
	$('.option_broker').change(function(){
		check_option_broker();
	})
	$('#Rptlistofrepo_stk_cd_from').change(function(){
		$('#Rptlistofrepo_stk_cd_to').val($('#Rptlistofrepo_stk_cd_from').val());
	})
	$('#Rptlistofrepo_broker_cd').change(function(){
	$('#Rptlistofrepo_broker_cd').val($('#Rptlistofrepo_broker_cd').val().toUpperCase());	
	})
	function check_option_broker()
	{
		if($('#option_broker_1').is(':checked'))
		{
			$('#Rptlistofrepo_broker_cd').attr('disabled',false);
		}
		else
		{
			$('#Rptlistofrepo_broker_cd').val(' ');
			$('#Rptlistofrepo_broker_cd').attr('disabled',true);
		}
	}
	function check_option_client()
	{
		if($('#client_option_1').is(':checked'))
		{
			$('#Rptlistofrepo_bgn_client').attr('disabled',false);
			$('#Rptlistofrepo_end_client').attr('disabled',false);
		}
		else
		{
			$('#Rptlistofrepo_bgn_client').val(' ');
			$('#Rptlistofrepo_end_client').val(' ');
			$('#Rptlistofrepo_bgn_client').attr('disabled',true);
			$('#Rptlistofrepo_end_client').attr('disabled',true);
		}
	}
	
	
	function check_option_stock()
	{
		if($('#option_1').is(':checked'))
		{
			$('#Rptlistofrepo_stk_cd_from').attr('disabled',false);
			$('#Rptlistofrepo_stk_cd_to').attr('disabled',false);
		}
		else
		{
			$('#Rptlistofrepo_stk_cd_from').val(' ');
			$('#Rptlistofrepo_stk_cd_to').val(' ');
			$('#Rptlistofrepo_stk_cd_from').attr('disabled',true);
			$('#Rptlistofrepo_stk_cd_to').attr('disabled',true);
		}
	}
	
	
function getClient()
	{
		var result = [];
		$('#Rptlistofrepo_bgn_client ,#Rptlistofrepo_end_client').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getclient'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				           				 result = data;
				    				}
				});
		    },
		    change: function(event,ui)
	        {
	        	$(this).val($(this).val().toUpperCase());
	        	if (ui.item==null)
	            {
	            	// Only accept value that matches the items in the autocomplete list
	            	
	            	var inputVal = $(this).val();
	            	var match = false;
	            	
	            	$.each(result,function()
	            	{
	            		if(this.value.toUpperCase() == inputVal)
	            		{
	            			match = true;
	            			return false;
	            		}
	            	});
	            	
	            }
	        },
		    minLength: 1
		});
	}
</script>

