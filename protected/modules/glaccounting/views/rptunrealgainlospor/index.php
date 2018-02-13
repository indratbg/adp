<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php 
	$this->breadcrumbs=array(
	'Unrealised Gain / Loss - Own Portofolio'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Unrealised Gain / Loss - Own Portofolio', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>
	

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'importTransaction-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	
	<?php AHelper::showFlash($this) ?> 
	<?php echo $form->errorSummary(array($model)); ?>

</br>
	<div class="row-fluid">
		<div class="control-group">
			<div class="span4">
				<div class="span2">Date</div>
				<?php echo $form->textField($model,'to_dt',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span3','required'=>true)); ?>
			</div>
		</div>
		<div class="control-group">
			<div class="span4">
				<div class="span2">Client</div>
				<?php echo $form->radioButton($model,'client_opt',array('id'=>'client_cd','value'=>'0','class'=>'span1 optclient')). " All " ?>
				<?php echo $form->radioButton($model,'client_opt',array('id'=>'client_cd','value'=>'1','class'=>'span1 optclient')). " Specified " ?>
				<?php echo $form->textField($model,'client_cd',array('id'=>'client_Cd','class'=>'span3 option opttext'))?>
			</div>				
		</div>
		<div class="control-group">
			<div class="span8">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Show Report',
					'id'=>'btnProcess'
				)); ?>
			</div>
		</div>
	</div>
	<?php echo $form->datePickerRow($model,'dummy_dt',array('label'=>false,'style'=>'display:none')) ?>
<?php $this->endWidget(); ?>

<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<script type="text/javascript" charset="utf-8">

	$(document).ready(function()
	{
		$("#toDt").datepicker({format:'dd/mm/yyyy'});
		
		optionclientCD();
	});
	
	$("#btnProcess").click(function(event)
	{	
		//console.log("klik");
		var specClient=$('input:radio[name="Rptunrealgainlospor[client_cd]"]:checked').val();
		console.log("specClient: "+specClient)
		var isSpecClient=(specClient==='0');
		var clientPass = (isSpecClient&&$("#client_Cd").val() || !isSpecClient)?true:false;
		if(!clientPass){
			alert("Client harus diisi jika centang Specified Client")
			return false;
		}
	
	})
	
	
	$('.optclient').click(function(){
		optionclient_CD();
	})
	
	function optionclient_CD()
	{	
		
		var client_CD=$('input:radio[name="Rptunrealgainlospor[client_opt]"]:checked').val();
		var isclient_CD=(client_CD==='0');
		$('.opttext').attr('disabled',isclient_CD);
			
	}
	 
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


