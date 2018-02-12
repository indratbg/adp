
<?php
$this->menu=array(
	array('label'=>'Client Stock Position (for client)', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
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
	echo $form->errorSummary(array($model));
?>

<br/>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<div class="span3">
				<label>Report Type</label>	
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'report_type',array('value'=>'0'))."&nbsp; Summary";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'report_type',array('value'=>'1'))."&nbsp; Detail";?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Report Date</label>
			</div>
			<div class="span4">
				<?php echo $form->textField($model,'doc_date',array('class'=>'span8 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Stock</label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'stk_option',array('value'=>'0','id'=>'stock_option_0','class'=>'stock_option'))."&nbsp; All";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'stk_option',array('value'=>'1','id'=>'stock_option_1','class'=>'stock_option'))."&nbsp; Specified";?>
			</div>
			<div class="span3">
				<?php //echo $form->dropDownList($model,'stk_cd',CHtml::listData($stk_cd,'stk_cd','stk_desc'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
				<?php echo $form->textField($model,'stk_cd',array('class'=>'span12'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Client</label>
			</div>
			<div class="span3">
				<input type="radio" id="client_option_0" name="Rptclientstockpositionforclient[client_option]" value="0" class="client_option" <?php if($model->client_option == 0)echo 'checked' ?> />&nbsp; All
			</div>
			<div class="span3">
				<input type="radio" id="client_option_1" name="Rptclientstockpositionforclient[client_option]" value="1" class="client_option" <?php if($model->client_option == 1)echo 'checked' ?> />&nbsp; Regular
			</div>
			<div class="span3">
				<input type="radio" id="client_option_2" name="Rptclientstockpositionforclient[client_option]" value="2" class="client_option" <?php if($model->client_option == 2)echo 'checked' ?> />&nbsp; @Custody
			</div>
		</div>
		<div class="control-group">
			<div class="span3">	
			</div>
			<div class="span3">
				<input type="radio" id="client_option_3" name="Rptclientstockpositionforclient[client_option]" value="3" class="client_option" <?php if($model->client_option == 3)echo 'checked' ?> />&nbsp; Specified
			</div>
			<div class="span3">
				<input type="radio" id="client_option_4" name="Rptclientstockpositionforclient[client_option]" value="4" class="client_option" <?php if($model->client_option == 4)echo 'checked' ?> />&nbsp; Margin
			</div>
			<div class="span3">
				<input type="radio" id="client_option_5" name="Rptclientstockpositionforclient[client_option]" value="5" class="client_option" <?php if($model->client_option == 5)echo 'checked' ?> />&nbsp; T Plus
			</div>
		</div>
			<div class="control-group">
			
			<div class="span3">
				<label>From</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'bgn_client',array('class'=>'span12'));?>
			</div>
			<div class="span3" style="text-align: center">
				<label>To</label>
			</div>
			<div class="span3">
					<?php echo $form->textField($model,'end_client',array('class'=>'span12'));?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span3">
				<label>Sales</label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'sales_option',array('value'=>'0','class'=>'sales_option','id'=>'sales_option_0'))."&nbsp; All";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'sales_option',array('value'=>'1','class'=>'sales_option','id'=>'sales_option_1'))."&nbsp; Specified";?>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'rem_cd',CHtml::listData($rem_cd, 'rem_cd', 'rem_name'),array('prompt'=>'-Select-','class'=>'span12','style'=>'font-family:courier'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Branch</label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'branch_option',array('value'=>'0','class'=>'branch_option','id'=>'branch_option_0'))."&nbsp; All";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'branch_option',array('value'=>'1','class'=>'branch_option','id'=>'branch_option_1'))."&nbsp; Specified";?>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'branch_cd',CHtml::listData($branch_cd, 'brch_cd', 'brch_name'),array('prompt'=>'-Select-','class'=>'span12','style'=>'font-family:courier'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Price</label>
			</div>
			<div class="span3">
				<input type="radio" name="Rptclientstockpositionforclient[price_option]" value="0" <?php if($model->price_option == 0)echo 'checked' ?> />&nbsp; YES
			</div>
			<div class="span3">
				<input type="radio" name="Rptclientstockpositionforclient[price_option]" value="1" <?php if($model->price_option == 1)echo 'checked' ?> />&nbsp; NO
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
		getClient();
		stock_option();
		client_option();
		sales_option();
		branch_option();
		getStock();
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
	}
	function getStock()
    { 
        var result = [];
        $('#Rptclientstockpositionforclient_stk_cd').autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getstock'); ?>',
                    'dataType'  : 'json',
                    'data'      :   {
                                        'term': request.term,
                                        
                                    },
                    'success'   :   function (data) 
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
                        $(this).val('');
                    }
                }
            },
            minLength: 0,
           open: function() { 
                    $(this).autocomplete("widget").width(500);
                     $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
                } 
        }).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
    }
    
		function getClient()
	{
		var result = [];
		$('#Rptclientstockpositionforclient_bgn_client ,#Rptclientstockpositionforclient_end_client').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo Yii::app()->createUrl('share/sharesql/getclient'); ?>',
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
		    minLength: 0,
		     open: function() { 
			        $(this).autocomplete("widget").width(400);
                    $(this).autocomplete("widget").css('overflow-y','scroll');
                    $(this).autocomplete("widget").css('max-height','250px');
                    $(this).autocomplete("widget").css('font-family','courier');
			    } 
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
	}
	
	$('.stock_option').change(function()
	{
		stock_option();
	})
	
	function stock_option()
	{
		if($('#stock_option_0').is(':checked'))
		{
			$('#Rptclientstockpositionforclient_stk_cd').val('');
			$('#Rptclientstockpositionforclient_stk_cd').attr('disabled',true);
		}
		else
		{
			$('#Rptclientstockpositionforclient_stk_cd').attr('disabled',false);
		}
	}
	
	$('.client_option').change(function(){
		client_option();
	})	
	
	function client_option()
	{
		if($('#client_option_3').is(':checked'))
		{
			$('#Rptclientstockpositionforclient_bgn_client').attr('disabled',false);
			$('#Rptclientstockpositionforclient_end_client').attr('disabled',false);
		}
		else
		{
			$('#Rptclientstockpositionforclient_bgn_client').val('');
			$('#Rptclientstockpositionforclient_end_client').val('');
			$('#Rptclientstockpositionforclient_bgn_client').attr('disabled',true);
			$('#Rptclientstockpositionforclient_end_client').attr('disabled',true);
		}
	}
	$('.sales_option').change(function(){
		sales_option();
	})
	function sales_option()
	{
		if($('#sales_option_1').is(':checked'))
		{
			$('#Rptclientstockpositionforclient_rem_cd').attr('disabled',false);
		}
		else
		{
			$('#Rptclientstockpositionforclient_rem_cd').val('');
			$('#Rptclientstockpositionforclient_rem_cd').attr('disabled',true);
		}
	}
	
	$('.branch_option').change(function(){
		branch_option();
	})
	function branch_option()
	{
		if($('#branch_option_1').is(':checked'))
		{
			$('#Rptclientstockpositionforclient_branch_cd').attr('disabled',false);
		}
		else
		{
			$('#Rptclientstockpositionforclient_branch_cd').val('');
			$('#Rptclientstockpositionforclient_branch_cd').attr('disabled',true);
		}
	}
	$('#Rptclientstockpositionforclient_bgn_client').change(function(){
		$('#Rptclientstockpositionforclient_end_client').val($('#Rptclientstockpositionforclient_bgn_client').val().toUpperCase());
	})
</script>