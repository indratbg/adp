<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
	.radio
	{
		margin-left:-120px;
	}
</style>

<?php

$this->breadcrumbs=array(
	'Process Average Price'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Process Average Price', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'processDepFixAsset-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	
	
	<?php echo $form->errorSummary($model); ?>
	<?php AHelper::showFlash($this) ?> 
	 <br/>
 	<div class="row-fluid">
 		<div class="span6">
 		<div class="control-group">
 			<div class="span2">
 				<label>Date From  </label>
 			</div>
 			<div class="span3">
 				<?php echo $form->textField($model,'from_dt',array('id'=>'fromDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span10','required'=>true)); ?>
 			</div>
 			<div class="span1">
 				<label>To</label>
 			</div>
 			<div class="span3">
 				<?php echo $form->textField($model,'to_dt',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span10','required'=>true)); ?>
 			</div>
 		</div>
 		<div class="control-group">
 			<div class="span2">
 				<label>Client</label>
 			</div>
 			<div class="span2 btnRadio">
 				<?php echo $form->radioButtonList($model, 'client_search_md', array('A'=>'All Client','S'=>'Specified'),array('id'=>'clientOpt','onChange'=>'checkSpecified()')); ?>
 			</div>
 		</div>
 		<div class="control-group">
 			<div class="span3 offset2">
 				<?php echo $form->textField($model,'client_cd',array('id'=>'client_Cd','required'=>'required','class'=>'span10'));?>
 			</div>
 		</div>
 		
 		</div>
 		<div class="span6">
 			<div class="control-group">
 			<div class="span2">
 				<label>Stock</label>
 			</div>
 			<div class="span2 btnRadio">
 				<?php echo $form->radioButtonList($model, 'stock_search_md', array('A'=>'All Stock','S'=>'Specified'),array('id'=>'stockOpt','onChange'=>'checkSpecified()')); ?>
 			</div>
 			</div>
 			<div class="control-group">
 			<div class="span3 offset2">
 				<?php echo $form->textField($model,'stock_cd',array('id'=>'stock_Cd','required'=>'required','class'=>'span10'));?>
 			</div>
 			</div>
 		</div>
 </div>

	<div class="form-actions">		
			<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Process',
			'id'=>'btnProcess',
			'htmlOptions'=>array("class"=>"control-group",'disabled'=>$flag=='Y'?true:false,'style'=>$flag=='Y'?'opacity:0.2':'opacity:1'),
		)); ?>
	</div>
	
	<?php echo $form->datePickerRow($model,'dummy_dt',array('label'=>false,'style'=>'display:none')) ?>
	<?php $this->endWidget(); ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'Process Average Price In Progress',
            'modal'=>true,
            'autoOpen'=>false,// default is true
            'closeOnEscape'=>false,
            'resizable'=>false,
            'draggable'=>false,
            'height'=>120,
            'open'=>// supply a callback function to handle the open event
                    'js:function(){ // in this function hide the close button
                         $(".ui-dialog-titlebar-close").hide();
						 //$(".ui-dialog-content").hide();
						
                    }'
         ))
);

	$this->widget('bootstrap.widgets.TbProgress',
    array('percent' => 100, // the progress
        	'striped' => true,
        	'animated' => true,
    )
);
?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>


<script type="text/javascript" charset="utf-8">
	
	var searchOpt;
	var suspFlg;
	var authorizedSpv = true;
	
	$(document).ready(function()
	{
		$("#fromDt").datepicker({format:'dd/mm/yyyy'});
		$("#toDt").datepicker({format:'dd/mm/yyyy'});
	
		//setAutoCompleteClient();
		
	});
	
	checkSpecified();
	
	function checkSpecified(){
		
		var specificClient=$('#Processavgprc_client_search_md_1').is(':checked');
		var specificStock=$('#Processavgprc_stock_search_md_1').is(':checked');
		
		// console.log('specClient: '+specificClient);
		// console.log('specStock: '+specificStock);
		
		$('#client_Cd').attr('readonly',!specificClient);
		$('#stock_Cd').attr('readonly',!specificStock);
		
		if(!specificClient){
			$('#client_Cd').attr('value',"");
		}
		
		if(!specificStock){
			$('#stock_Cd').attr('value',"");
		}
	}

	
	$("#btnProcess").click(function(event)
	{	
		//event.preventDefault();
		//console.log("klik");
		var clientPass = ($("input[type='radio'][id='clientOpt1']:checked").val()||($("input[type='radio'][id='clientOpt2']:checked").val()&&$("#client_Cd").val()))?true:false;
		var stockPass =($("input[type='radio'][id='stockOpt1']:checked").val()||($("input[type='radio'][id='stockOpt2']:checked").val()&&$("#stock_Cd").val()))?true:false;
		
		//console.log('clientPass: '+clientPass);
		//console.log("stockPass: "+stockPass);
		if(clientPass&&stockPass){
			if(confirm("Process Average Price ?")){
				$('#mywaitdialog').dialog("open"); 
			}else{
				return false;
			}
		
		}
	})
	
	var result = [];
		$('#stock_Cd').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getstock'); ?>',
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
		    open: function()
		   {
        		$(this).autocomplete("widget").width(500); 
           },
           position: 
           {
           	    offset: '0 0' // Shift 150px to the left, 0px vertically.
    	   }
		});
		
		$('#client_Cd').autocomplete(
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
		    minLength: 1,
		    open: function()
		   {
        		$(this).autocomplete("widget").width(500); 
           },
           position: 
           {
           	    offset: '0 0' // Shift 150px to the left, 0px vertically.
    	   }
		});
		
</script>


