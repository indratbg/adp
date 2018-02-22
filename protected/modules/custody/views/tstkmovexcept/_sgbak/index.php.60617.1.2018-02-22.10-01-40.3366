<?php
$this->breadcrumbs=array(
	'Movement Exception'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Movement Exception', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Stock Movement','url'=>array('/custody/tstkmovement/index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>

<?php AHelper::showFlash($this); ?> <!-- show flash -->

<br/>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tstkmovexcept-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
	<?php echo $form->label($model,'client_cd', array('class'=>'control-label')); ?>
	<?php echo $form->textField($model,'client_cd',array('id'=>'clientCd','class'=>'span2','required'=>true)); ?>
	
	&emsp;
	
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id'=>'btnAdd',
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Add',
		'htmlOptions'=>array('name'=>'submit','value'=>'add')
	)); ?>
	
	&emsp;
	
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id'=>'btnDelete',
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Delete',
		'htmlOptions'=>array('name'=>'submit','value'=>'delete')
	)); ?>
</div>

<?php $this->endWidget(); ?>

<script>
	var result;

	$(document).ready(function()
	{
		$("#clientCd").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getClient'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{'term': request.term},
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
	            	
		            if(!match)
		            {
		            	alert("Client code not found");
		            	$(this).val('');
		            }
		            
		            //$(this).focus();
	            }
	        },
	        open: function() { 
				$(this).autocomplete("widget").width(400); 
			}, 
		    minLength: 1
		})
	});
</script>
