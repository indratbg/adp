
<?php
$this->menu=array(
	array('label'=>'Invoice OTC Client', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
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
	echo $form->errorSummary(array($model,$modelRepo));
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
				<?php //echo $form->dropDownList($model,'stk_cd_from',CHtml::listData($stk_cd,'stk_cd', 'stk_desc'),array('class'=>'span12','prompt'=>'-Select-'));?>
				<?php echo $form->textField($model,'stk_cd_from',array('class'=>'span12'));?>
			</div>
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span2">
				<?php //echo $form->dropDownList($model,'stk_cd_to',CHtml::listData($stk_cd,'stk_cd', 'stk_desc'),array('class'=>'span12','prompt'=>'-Select-'));?>
				<?php echo $form->textField($model,'stk_cd_to',array('class'=>'span12'));?>
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
		<div class="control-group">
			<div class="span1">
				<label>Invoice</label>
			</div>
			<div class="span5">
				<?php echo $form->radioButton($model,'invoice_type',array('value'=>'0','class'=>'invoice_type','id'=>'invoice_type_0'))."&emsp; Client";?>
			</div>
		</div>
		<div class="control-group">
			<div class="span1">
				
			</div>
			<div class="span2">
				<?php echo $form->radioButton($model,'invoice_type',array('value'=>'1','class'=>'invoice_type','id'=>'invoice_type_1'))."&emsp; Repo";?>
			</div>
			<div class="span2" style="text-align: right">
				<!-- <label>Acct Jual</label> -->
			</div>
			<div class="span3">
				<?php //echo $form->textField($model,'acct_jual',array('class'=>'span12'));?>
			</div>
			<div class="span1">
				<!-- <label>Beli</label> -->
			</div>
			<div class="span3">
				<?php //echo $form->textField($model,'acct_beli',array('class'=>'span12'));?>
			</div>
		</div>
		<div class="control-group">
			<div class="span1">
				<!-- <label>OTC</label> -->
			</div>
			<div class="span5">
				<?php //echo $form->textField($model,'otc',array('class'=>'span6 tnumber','style'=>'text-align:right'));?>
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
	option_invoice_type();
	getClient();
	getStock();
	
	}
	
	$('.option').change(function(){
		check_option_stock();
	})
	$('.option2').change(function(){
		check_option_client();
	})
	
	$('#Rptinvoiceotc_bgn_date').change(function(){
		$('#Rptinvoiceotc_end_date').val($('#Rptinvoiceotc_bgn_date').val());
	})
	$('#Rptinvoiceotc_bgn_client').change(function(){
		$('#Rptinvoiceotc_end_client').val($('#Rptinvoiceotc_bgn_client').val());
	})
	$('.option_broker').change(function(){
		check_option_broker();
	})
	$('#Rptinvoiceotc_stk_cd_from').change(function(){
		$('#Rptinvoiceotc_stk_cd_to').val($('#Rptinvoiceotc_stk_cd_from').val());
	})
	$('#Rptinvoiceotc_broker_cd').change(function(){
	$('#Rptinvoiceotc_broker_cd').val($('#Rptinvoiceotc_broker_cd').val().toUpperCase());	
	})
	$('.invoice_type').change(function(){
		option_invoice_type()
	})
	
	function option_invoice_type()
	{
		if($('#invoice_type_1').is(':checked'))
		{
			$('#Rptinvoiceotc_acct_jual').prop('disabled', false);
			$('#Rptinvoiceotc_acct_beli').prop('disabled', false);		
		}
		else
		{
			$('#Rptinvoiceotc_acct_jual').prop('disabled', true);
			$('#Rptinvoiceotc_acct_beli').prop('disabled', true);
		}
	}
	function check_option_broker()
	{
		if($('#option_broker_1').is(':checked'))
		{
			$('#Rptinvoiceotc_broker_cd').attr('disabled',false);
		}
		else
		{
			$('#Rptinvoiceotc_broker_cd').val('');
			$('#Rptinvoiceotc_broker_cd').attr('disabled',true);
		}
	}
	function check_option_client()
	{
		if($('#client_option_1').is(':checked'))
		{
			$('#Rptinvoiceotc_bgn_client').attr('disabled',false);
			$('#Rptinvoiceotc_end_client').attr('disabled',false);
		}
		else
		{	$('#Rptinvoiceotc_bgn_client').val('');
			$('#Rptinvoiceotc_end_client').val('');
			$('#Rptinvoiceotc_bgn_client').attr('disabled',true);
			$('#Rptinvoiceotc_end_client').attr('disabled',true);
		}
	}
	
	
	function check_option_stock()
	{
		if($('#option_1').is(':checked'))
		{
			$('#Rptinvoiceotc_stk_cd_from').attr('disabled',false);
			$('#Rptinvoiceotc_stk_cd_to').attr('disabled',false);
		}
		else
		{
			$('#Rptinvoiceotc_stk_cd_from').val('');
			$('#Rptinvoiceotc_stk_cd_to').val('');
			$('#Rptinvoiceotc_stk_cd_from').attr('disabled',true);
			$('#Rptinvoiceotc_stk_cd_to').attr('disabled',true);
		}
	}
	
function getStock()
{ 
        var result = [];
        $('#Rptinvoiceotc_stk_cd_from, #Rptinvoiceotc_stk_cd_to').autocomplete(
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
        $('#Rptinvoiceotc_bgn_client, #Rptinvoiceotc_end_client').autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getclient'); ?>',
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
        });;
    }
</script>

