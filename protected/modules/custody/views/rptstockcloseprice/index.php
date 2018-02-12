
<?php
$this->menu=array(
	array('label'=>'Stock Close Price', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
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
	<div class="control-group">
		<div class="span1">
			<label>Periode</label>
		</div>
		<div class="span2" style="margin: 0 -23px 0 30px">
			<label class="span4">From</label>
			<?php echo $form->textField($model,'p_bgn_date',array('class'=>'span6 tdate','placeholder'=>'dd/mm/yyyy'));?>
		</div>
		<div class="span2">
			<label class="span4" style="margin: 0 -4px 0 0">To</label>
			<?php echo $form->textField($model,'p_end_date',array('class'=>'span6 tdate','placeholder'=>'dd/mm/yyyy'));?>
		</div>
	</div>
	<div class="control-group">
		<div class="span1">
			<label>Stock</label>
		</div>
			<div class="span4">
				<?php echo $form->radioButton($model,'p_option',array('value'=>'0','class'=>'p_opt','id'=>'p_opt_0')) ."&nbsp; All";?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php echo $form->radioButton($model,'p_option',array('value'=>'1','class'=>'p_opt','id'=>'p_opt_1')) ."&nbsp; Specified";?>
			</div>
	</div>
		<div class="control-group">
			<div class="span6">
			<div class="span2">
				<label>From</label>
			</div>
			<style>
				#bgn_stk,#end_stk{text-transform:uppercase}	
			</style>
			<div class="span4">
				<?php echo $form->textField($model,'p_bgn_stk',array('class'=>'span8','placeholder'=>''));?>

			</div>
			<div>
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span4">
				<?php echo $form->textField($model,'p_end_stk',array('class'=>'span8','placeholder'=>''));?>
			</div>
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

<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>
<?php echo $form->datePickerRow($model,'dummy_date',array('style'=>'display:none','label'=>false));?>
<?php $this->endWidget();?>

<script>
var url = '<?php echo $url;?>';

	if (url=='')
		{
			$('#iframe').hide();
			// $('#Rptstockcloseprice_p_bgn_stk').val('');
		}	
	init();
			
	
	function init()
	{
		option();
		getStk();
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		$("#iframe").offset({left:2});
		$("#iframe").css('width',($(window).width()));
		
	}
	
	function getStk()
	{
		var result = [];
		$('#Rptstockcloseprice_p_bgn_stk').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getstk'); ?>',
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
		    minLength: 1,
		     open: function() { 
			        $(this).autocomplete("widget").width(400);
			    }
		});
		$('#Rptstockcloseprice_p_end_stk').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getstk'); ?>',
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
		    minLength: 1,
		     open: function() { 
			        $(this).autocomplete("widget").width(400);
			    } 
		});
	}
	
	$('.p_opt').change(function()
	{
		option();
	})
	function option()
	{
		if($('#p_opt_1').is(':checked'))
		{
			$('#Rptstockcloseprice_p_bgn_stk').attr('disabled',false);
			$('#Rptstockcloseprice_p_end_stk').attr('disabled',false);

		}
		else if($('#p_opt_0').is(':checked'))
		{
			$('#Rptstockcloseprice_p_bgn_stk').attr('disabled',true);
			$('#Rptstockcloseprice_p_end_stk').attr('disabled',true);
		}
	}
	
	$('#Rptstockcloseprice_p_bgn_stk').change(function()
	{
		val();
	})
	function val()
	{	
		$('#Rptstockcloseprice_p_end_stk').val($('#Rptstockcloseprice_p_bgn_stk').val());
	}
	$('#Rptstockcloseprice_p_bgn_date').change(function()
	{
		val_1();
	})
	function val_1()
	{
		$('#Rptstockcloseprice_p_end_date').val($('#Rptstockcloseprice_p_bgn_date').val());
	}
	
</script>