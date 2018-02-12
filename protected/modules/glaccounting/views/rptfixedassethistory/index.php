
<?php
$this->menu=array(
	array('label'=>'Fixed Asset Movement History', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
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
		<div class="span1" >
			<label>Asset</label>
		</div>
		<div class="span1" style="margin: 0 0px 0 70px">
			<?php echo $form->radioButton($model,'option',array('value'=>'0','class'=>'p_opt','id'=>'p_opt_0')) ."&nbsp; All";?>
		</div>
		<div class="span1">
			<?php echo $form->radioButton($model,'option',array('value'=>'1','class'=>'p_opt','id'=>'p_opt_1')) ."&nbsp; Specified";?>
		</div>
		<div class="span4">
			<?php echo $form->textfield($model,'asset_cd',array('class'=>'span4','id'=>'asset_cd'));?>
		</div>
	</div>	
	<br/>
	<div class="control-group">
		<div class="span4">
			<?php echo $form->datePickerRow($model,'bgn_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy')));?>
		</div>	
			
		<div class="span4" style="margin: 0 0px 0 -30px">
			<?php echo $form->datePickerRow($model,'end_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy')));?>	
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

<?php $this->endWidget();?>

<script>
var url = '<?php echo $url;?>';

	if (url=='')
		{
			$('#iframe').hide();
		}	
	init();
			
	
	function init()
	{
		option();
		getAsset();
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		$("#iframe").offset({left:2});
		$("#iframe").css('width',($(window).width()));
		
	}
	
	function getAsset()
	{
		var result = [];
		$('#asset_cd').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getasset'); ?>',
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
			$('#asset_cd').attr('disabled',false);
		}
		else if($('#p_opt_0').is(':checked'))
		{
			$('#asset_cd').attr('disabled',true);
			$('#asset_cd').val('');
		}
	}
	
</script>