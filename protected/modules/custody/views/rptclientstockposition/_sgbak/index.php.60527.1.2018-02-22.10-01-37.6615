
<?php
$this->menu=array(
	array('label'=>'Client Stock Position', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
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
				<input type="radio" id="client_option_0" name="Rptclientstockposition[client_option]" value="0" class="client_option" <?php if($model->client_option == 0)echo 'checked' ?> />&nbsp; All
			</div>
			<div class="span3">
				<input type="radio" id="client_option_1" name="Rptclientstockposition[client_option]" value="1" class="client_option" <?php if($model->client_option == 1)echo 'checked' ?> />&nbsp; Regular
			</div>
			<div class="span3">
				<input type="radio" id="client_option_2" name="Rptclientstockposition[client_option]" value="2" class="client_option" <?php if($model->client_option == 2)echo 'checked' ?> />&nbsp; @Custody
			</div>
		</div>
		<div class="control-group">
			<div class="span3">	
			</div>
			<div class="span3">
				<input type="radio" id="client_option_3" name="Rptclientstockposition[client_option]" value="3" class="client_option" <?php if($model->client_option == 3)echo 'checked' ?> />&nbsp; Specified
			</div>
			<div class="span3">
				<input type="radio" id="client_option_4" name="Rptclientstockposition[client_option]" value="4" class="client_option" <?php if($model->client_option == 4)echo 'checked' ?> />&nbsp; Margin
			</div>
			<div class="span3">
				<input type="radio" id="client_option_5" name="Rptclientstockposition[client_option]" value="5" class="client_option" <?php if($model->client_option == 5)echo 'checked' ?> />&nbsp; T Plus
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
		<div class="control-group">
			<div class="span3">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
										'id'=>'btnSubmit',
										'buttonType'=>'submit',
										'type'=>'primary',
										'label'=>'Show Report',
									)); ?>
			</div>
			<div class="span5">
				<a href="<?php echo Yii::app()->request->baseUrl.'?r=custody/rptclientstockposition/GetXls&rand_value='.$rand_value.'&user_id='.$user_id ;?> " id="btn_xls" class="btn btn-primary">Save to Excel</a>
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
				<label>Position</label>
			</div>
			<div class="span3">
				<?php //echo $form->radioButton($model,'position_option',array('value'=>'0'))."&nbsp; All";?>
				<input type="radio" name="Rptclientstockposition[position_option]" value="0" <?php if($model->position_option == 0)echo 'checked' ?> />&nbsp; All
			</div>
			<div class="span3">
				<?php //echo $form->radioButton($model,'position_option',array('value'=>'1'))."&nbsp; Repo";?>
				<input type="radio" name="Rptclientstockposition[position_option]" value="1" <?php if($model->position_option == 1)echo 'checked' ?> />&nbsp; Repo
			</div>
			
		</div>
		<div class="control-group">
			<div class="span3"></div>
			<div class="span3">
				<?php //echo $form->radioButton($model,'position_option',array('value'=>'2'))."&nbsp; Short-Sell";?>
				<input type="radio" name="Rptclientstockposition[position_option]" value="2" <?php if($model->position_option == 2)echo 'checked' ?> />&nbsp; Short-Sell
			</div>
			<div class="span3">
				<?php //echo $form->radioButton($model,'position_option',array('value'=>'3'))."&nbsp; Scrip";?>
				<input type="radio" name="Rptclientstockposition[position_option]" value="3" <?php if($model->position_option == 3)echo 'checked' ?> />&nbsp; Scrip
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Group By</label>
			</div>
			<div class="span6">
				<?php echo $form->radioButton($model,'group_option',array('value'=>'0'))."&nbsp; Client Code, Stock Code";?>
			</div>
			<div class="span3">
			    <input type="checkbox" name="Rptclientstockposition[bond_flg]" value="Y" <?php echo $model->bond_flg=='Y'?'checked':'';?>/> &nbsp; Bond Only
			</div>
		</div>
		<div class="control-group">
			<div class="span3"></div>
			<div class="span5">
				<?php echo $form->radioButton($model,'group_option',array('value'=>'1'))."&nbsp; Stock Code, Client Code";?>
			</div>
		</div>
	</div>
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
		getClient();
		stock_option();
		client_option();
		sales_option();
		branch_option();
		getStock();
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	}
	function getStock()
    { 
        var result = [];
        $('#Rptclientstockposition_stk_cd').autocomplete(
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
		$('#Rptclientstockposition_bgn_client ,#Rptclientstockposition_end_client').autocomplete(
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
			$('#Rptclientstockposition_stk_cd').attr('disabled',true);
			$('#Rptclientstockposition_stk_cd').val('');
		}
		else
		{
			$('#Rptclientstockposition_stk_cd').attr('disabled',false);
		}
	}
	
	$('.client_option').change(function(){
		client_option();
	})	
	
	function client_option()
	{
		if($('#client_option_3').is(':checked'))
		{
			$('#Rptclientstockposition_bgn_client').attr('disabled',false);
			$('#Rptclientstockposition_end_client').attr('disabled',false);
		}
		else
		{
			$('#Rptclientstockposition_bgn_client').val('');
			$('#Rptclientstockposition_end_client').val('');
			$('#Rptclientstockposition_bgn_client').attr('disabled',true);
			$('#Rptclientstockposition_end_client').attr('disabled',true);
		}
	}
	$('.sales_option').change(function(){
		sales_option();
	})
	function sales_option()
	{
		if($('#sales_option_1').is(':checked'))
		{
			$('#Rptclientstockposition_rem_cd').attr('disabled',false);
		}
		else
		{	$('#Rptclientstockposition_rem_cd').val('');
			$('#Rptclientstockposition_rem_cd').attr('disabled',true);
		}
	}
	
	$('.branch_option').change(function(){
		branch_option();
	})
	function branch_option()
	{
		if($('#branch_option_1').is(':checked'))
		{
			$('#Rptclientstockposition_branch_cd').attr('disabled',false);
		}
		else
		{
			$('#Rptclientstockposition_branch_cd').val('');
			$('#Rptclientstockposition_branch_cd').attr('disabled',true);
		}
	}
	$('#Rptclientstockposition_bgn_client').change(function(){
		$('#Rptclientstockposition_end_client').val($('#Rptclientstockposition_bgn_client').val().toUpperCase());
	})
</script>