
<?php
$this->menu=array(
	array('label'=>'Stock history', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
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
		<!-- <legend><h5>Periode Date</h5></legend> -->
		<div class="control-group">
			<div class="span2">
				<label> Periode Date From</label>
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
				<?php echo $form->radioButton($model,'stk_option',array('value'=>'0','class'=>'stk_option','id'=>'stk_option_0')) ."&emsp; All";?>
				
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'stk_option',array('value'=>'1','class'=>'stk_option','id'=>'stk_option_1')) ."&emsp; Specified";?>
			</div>
			<div class="span7">
				<?php //echo $form->dropDownList($model,'stk_cd',CHtml::listData($stk_cd,'stk_cd', 'stk_desc'),array('class'=>'span4','prompt'=>'-Select-','style'=>'font-family:courier'));?>
				<?php echo $form->textField($model,'stk_cd',array('class'=>'span4'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>Client</label>
			</div>
			<div class="span8">
				<?php echo $form->radioButton($model,'client_option',array('value'=>'0','class'=>'client_option','id'=>'client_option_0')) ."&emsp; All";?>
				
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'client_option',array('value'=>'1','class'=>'client_option','id'=>'client_option_1')) ."&emsp; Specified";?>
			</div>
			<div class="span7">
				<?php echo $form->textField($model,'client_cd',array('class'=>'span4'));?>
			</div>
		</div>
		
	</div>
	<div class="span6">
		<!-- <legend><h5>Sales</h5></legend> -->
		<div class="control-group">
			<div class="span2">
				<label>Sales</label>
			</div>
			<div class="span8">
				<?php echo $form->radioButton($model,'rem_option',array('value'=>'0','class'=>'rem_option','id'=>'rem_option_0')) ."&emsp; All";?>
				
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'rem_option',array('value'=>'1','class'=>'rem_option','id'=>'rem_option_1')) ."&emsp; Specified";?>
			</div>
			<div class="span7">
				<?php echo $form->dropDownList($model,'rem_cd',CHtml::listData($rem_cd,'rem_cd', 'rem_name'),array('class'=>'span4','prompt'=>'-Select-','style'=>'font-family:courier'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span2">
				<label>Quantity</label>
			</div>
			<div class="span3">
				<input type="radio"  name="Rptstockhistory[qty_option]" value="0" <?php if($model->qty_option == 0)echo 'checked' ?> />&nbsp; Theoritical
			</div>
			<div class="span3">
				<input type="radio"  name="Rptstockhistory[qty_option]" value="1" <?php if($model->qty_option == 1)echo 'checked' ?> />&nbsp; On Hand
			</div>
		</div>
		<div class="control-group">
			<div class="span5">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnSubmit',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Show Report',
				)); ?>
			</div>
			<div class="span5">
			<a href="<?php echo Yii::app()->request->baseUrl.'?r=custody/rptstockhistory/GetXls&rand_value='.$rand_value.'&user_id='.$user_id ;?> " id="btn_xls" class="btn btn-primary">Save to Excel</a>
			</div>
			
		</div>
		
		
	</div>

</div>


<div class="form-actions">
	
</div>

<br/>
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php echo $form->datePickerRow($model,'dummy_date',array('style'=>'display:none','label'=>false));?>
<?php $this->endWidget() ?>
<script>
	var url_xls = '<?php echo $url ?>';
	init();
	function init()
	{
	$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
	stk_option();
	rem_option();
	getClient();
	client_option();
	getStock();
	if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	}
	
	$('.stk_option').change(function(){
		stk_option();
	})
	
	$('.rem_option').change(function(){
		rem_option();
	})
	$('.client_option').change(function(){
		client_option();
	})
	
	
	$('#Rptstockhistory_bgn_date').change(function(){
		$('#Rptstockhistory_end_date').val($('#Rptstockhistory_bgn_date').val());
	})
	
	
	function stk_option()
	{
		if($('#stk_option_1').is(':checked'))
		{
			$('#Rptstockhistory_stk_cd').attr('disabled',false);
		}
		else
		{
			$('#Rptstockhistory_stk_cd').val('');
			$('#Rptstockhistory_stk_cd').attr('disabled',true);
		}
	}
	function rem_option()
	{
		if($('#rem_option_1').is(':checked'))
		{
			$('#Rptstockhistory_rem_cd').attr('disabled',false);
		}
		else
		{
			$('#Rptstockhistory_rem_cd').val('');
			$('#Rptstockhistory_rem_cd').attr('disabled',true);
		}
	}
	function client_option()
	{
		if($('#client_option_1').is(':checked'))
		{
			$('#Rptstockhistory_client_cd').attr('disabled',false);
		}
		else
		{
			$('#Rptstockhistory_client_cd').val('');
			$('#Rptstockhistory_client_cd').attr('disabled',true);
		}
	}
	function getStock()
{ 
        var result = [];
        $('#Rptstockhistory_stk_cd').autocomplete(
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
                    $(this).autocomplete("widget").width(400);
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
		$('#Rptstockhistory_client_cd').autocomplete(
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
		
</script>

