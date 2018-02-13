
<?php
$this->menu=array(
	array('label'=>'Client Activity', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'clientactivity-form',
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
				<label>Date</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'bgn_date',array('class'=>'span12 tdate','placeholder'=>'dd/mm/yyyy'));?>
			</div>
			<div class="span3">
				<label>To</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'end_date',array('class'=>'span12 tdate','placeholder'=>'dd/mm/yyyy'));?>
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
				<label>Stock</label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'stk_option',array('value'=>'0','id'=>'stock_option_0','class'=>'stock_option'))."&nbsp; All";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'stk_option',array('value'=>'1','id'=>'stock_option_1','class'=>'stock_option'))."&nbsp; Specified";?>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'stk_cd',CHtml::listData($stk_cd,'stk_cd','stk_desc'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Client</label>
			</div>
			<div class="span3">
				<input type="radio" id="client_option_0" name="Rptclientactivity[client_option]" value="0" class="client_option" <?php if($model->client_option == 0)echo 'checked' ?> />&nbsp; All
			</div>
			<div class="span3">
				<input type="radio" id="client_option_1" name="Rptclientactivity[client_option]" value="1" class="client_option" <?php if($model->client_option == 1)echo 'checked' ?> />&nbsp; Regular
			</div>
			<div class="span3">
				<input type="radio" id="client_option_2" name="Rptclientactivity[client_option]" value="2" class="client_option" <?php if($model->client_option == 2)echo 'checked' ?> />&nbsp; @Custody
			</div>
		</div>
		<div class="control-group">
			<div class="span3">	
			</div>
			<div class="span3">
				<input type="radio" id="client_option_3" name="Rptclientactivity[client_option]" value="3" class="client_option" <?php if($model->client_option == 3)echo 'checked' ?> />&nbsp; Specified
			</div>
			<div class="span3">
				<input type="radio" id="client_option_4" name="Rptclientactivity[client_option]" value="4" class="client_option" <?php if($model->client_option == 4)echo 'checked' ?> />&nbsp; Margin
			</div>
			<div class="span3">
				<input type="radio" id="client_option_5" name="Rptclientactivity[client_option]" value="5" class="client_option" <?php if($model->client_option == 5)echo 'checked' ?> />&nbsp; T Plus
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
				<label>Price</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'price',array('class'=>'span12 tnumber','style'=>'text-align:right'));?>
			</div>
			<div class="span3">
				
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
				<label>Market Type</label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'market_type_option',array('value'=>'0','id'=>'market_type_option_0','class'=>'market_type_option'))."&nbsp; All";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'market_type_option',array('value'=>'1','id'=>'market_type_option_1','class'=>'market_type_option'))."&nbsp; Specified";?>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'market_type',array('0'=>'Regular','1'=>'Titip','2'=>'Nego','3'=>'Tutup Sendiri','4'=>'Tunai'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
			</div>
		</div>
		
		
		
		<div class="control-group">
			<div class="span3">
				<label>Beli/Jual</label>
			</div>
			<div class="span3">
				<input type="radio" name="Rptclientactivity[beli_jual]" value="0" <?php if($model->beli_jual == 0)echo 'checked' ?> />&nbsp; All
			</div>
			<div class="span3">
				<input type="radio" name="Rptclientactivity[beli_jual]" value="1" <?php if($model->beli_jual == 1)echo 'checked' ?> />&nbsp; Beli
			</div>
			<div class="span3">
				<input type="radio" name="Rptclientactivity[beli_jual]" value="2" <?php if($model->beli_jual == 2)echo 'checked' ?> />&nbsp; Jual
			</div>
		</div>
		
		<div class="control-group">
			<div class="span3">
				<label>KPEI Due Date</label>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'kpei_due_dt_option',array('value'=>'0','id'=>'kpei_due_dt_option_0','class'=>'kpei_due_dt_option'))."&nbsp; All";?>
			</div>
			<div class="span3">
				<?php echo $form->radioButton($model,'kpei_due_dt_option',array('value'=>'1','id'=>'kpei_due_dt_option_1','class'=>'kpei_due_dt_option'))."&nbsp; Specified";?>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model,'kpei_due_dt',array('3'=>'3','2'=>'2','1'=>'1','0'=>'0'),array('class'=>'span12','prompt'=>'-Select-','style'=>'font-family:courier'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Group By</label>
			</div>
			<div class="span3">
				<input type="radio" name="Rptclientactivity[group_by]" value="0" <?php if($model->group_by == 0)echo 'checked' ?> />&nbsp; Client Code
			</div>
			<div class="span3">
				<input type="radio" name="Rptclientactivity[group_by]" value="1" <?php if($model->group_by == 1)echo 'checked' ?> />&nbsp; Sales Code
			</div>
			<div class="span3">
				<input type="radio" name="Rptclientactivity[group_by]" value="2" <?php if($model->group_by == 2)echo 'checked' ?> />&nbsp; Old Client Code
			</div>
		</div>
		<div class="control-group">
			<div class="span3"></div>
			<div class="span3">
				<input type="radio" name="Rptclientactivity[group_by]" value="3" <?php if($model->group_by == 3)echo 'checked' ?> />&nbsp; Stock
			</div>
			<div class="span3">
				<input type="radio" name="Rptclientactivity[group_by]" value="4" <?php if($model->group_by == 4)echo 'checked' ?> />&nbsp; Contract Date
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
					<a href="<?php echo Yii::app()->request->baseUrl.'?r=contracting/rptclientactivity/GetXls&rand_value='.$rand_value.'&user_id='.$user_id ;?> " id="btn_xls" class="btn btn-primary">Save to Excel</a>
			</div>
		</div>
	</div>
</div>

<hr class="divider"/>
<br/>
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php echo $form->datePickerRow($model,'dummy_date',array('style'=>'display:none','label'=>false));?>
<?php $this->endWidget() ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'In Progress',
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
<script>
	var url_xls = '<?php echo $url ?>';
	init();
	function init()
	{
		$("#iframe").offset({left:2});
		$("#iframe").css('width',($(window).width()));
		$(window).resize(function()
		{
			$("#iframe").offset({left:2});
			$("#iframe").css('width',($(window).width()));
		});
		
		getClient();
		stock_option();
		client_option();
		sales_option();
		branch_option();
		market_type_option();
		kpei_due_dt_option();
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	}
	
		function getClient()
	{
		var result = [];
		$('#Rptclientactivity_bgn_client ,#Rptclientactivity_end_client').autocomplete(
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
		     open: function() { 
			        $(this).autocomplete("widget").width(400);
			    } 
		});
	}
	
	$('.stock_option').change(function()
	{
		stock_option();
	})
	
	$('.market_type_option').change(function()
	{
		market_type_option();
	})
	$('.kpei_due_dt_option').change(function(){
		kpei_due_dt_option();
	})
	$('#Rptclientactivity_bgn_date').change(function(){
		$('#Rptclientactivity_end_date').val($('#Rptclientactivity_bgn_date').val());
	})
	
	
	function stock_option()
	{
		if($('#stock_option_0').is(':checked'))
		{
			$('#Rptclientactivity_stk_cd').attr('disabled',true);
			$('#Rptclientactivity_stk_cd').val('');
		}
		else
		{
			$('#Rptclientactivity_stk_cd').attr('disabled',false);
		}
	}
		
	function market_type_option()
	{
		if($('#market_type_option_0').is(':checked'))
		{
			$('#Rptclientactivity_market_type').attr('disabled',true);
			$('#Rptclientactivity_market_type').val('');
		}
		else
		{
			$('#Rptclientactivity_market_type').attr('disabled',false);
		}
	}
	function kpei_due_dt_option()
	{
		if($('#kpei_due_dt_option_0').is(':checked'))
		{
			$('#Rptclientactivity_kpei_due_dt').attr('disabled',true);
			$('#Rptclientactivity_kpei_due_dt').val('');
		}
		else
		{
			$('#Rptclientactivity_kpei_due_dt').attr('disabled',false);
		}
	}
	
	$('.client_option').change(function(){
		client_option();
	})	
	
	function client_option()
	{
		if($('#client_option_3').is(':checked'))
		{
			$('#Rptclientactivity_bgn_client').attr('disabled',false);
			$('#Rptclientactivity_end_client').attr('disabled',false);
		}
		else
		{
			$('#Rptclientactivity_bgn_client').val('');
			$('#Rptclientactivity_end_client').val('');
			$('#Rptclientactivity_bgn_client').attr('disabled',true);
			$('#Rptclientactivity_end_client').attr('disabled',true);
		}
	}
	$('.sales_option').change(function(){
		sales_option();
	})
	function sales_option()
	{
		if($('#sales_option_1').is(':checked'))
		{
			$('#Rptclientactivity_rem_cd').attr('disabled',false);
		}
		else
		{	$('#Rptclientactivity_rem_cd').val('');
			$('#Rptclientactivity_rem_cd').attr('disabled',true);
		}
	}
	
	$('.branch_option').change(function(){
		branch_option();
	})
	function branch_option()
	{
		if($('#branch_option_1').is(':checked'))
		{
			$('#Rptclientactivity_branch_cd').attr('disabled',false);
		}
		else
		{
			$('#Rptclientactivity_branch_cd').val('');
			$('#Rptclientactivity_branch_cd').attr('disabled',true);
		}
	}
	
	$('#btnSubmit').on('click',function(){
		$('#mywaitdialog').dialog("open"); 
	});
	$('#Rptclientactivity_bgn_client').change(function(){
		$('#Rptclientactivity_end_client').val($('#Rptclientactivity_bgn_client').val().toUpperCase());
	});
</script>