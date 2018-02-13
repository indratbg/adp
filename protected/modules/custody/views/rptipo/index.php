<style>
	.tnumber
	{
		text-align:right
	}
	
	.help-inline.error
	{
		display: none
	}
	
	.radio.inline label
	{
		margin-left: 15px
	}
	
	#brchCd
	{
		margin-left: -50px;
	}
</style>

<?php
$this->menu=array(
	array('label'=>'IPO Report', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
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
		<?php echo $form->dropDownListRow($model, 'stk_cd', CHtml::listData(Tpee::model()->findAll(array('condition'=>"distrib_dt_to > TRUNC(SYSDATE)-30 AND approved_stat = 'A'",'order'=>'stk_cd')), 'stk_cd', 'stk_cd'), array('class'=>'span4', 'id'=>'stkCd','prompt'=>'-Choose Stock-','required'=>true)) ?>
	</div>
	<div class="span6">
		<?php echo $form->datePickerRow($model,'pre_payment_dt',array('id'=>'prePaymentDt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->radioButtonListInlineRow($model, 'report_type', array(1=>'Invoice', 2=>'IPO List', 3=>'Refund'), array('id'=>'reportType','class'=>'reportType')) ?>
	</div>
	<div class="span4">
		<?php echo $form->radioButtonListInlineRow($model, 'brch_opt', array(1=>'All', 2=>'Specified'), array('id'=>'brchOpt')) ?>
	</div>
	<?php echo $form->dropDownList($model, 'brch_cd', CHtml::listData(Branch::model()->findAll(array('condition'=>"approved_stat = 'A'",'order'=>'brch_cd')), 'brch_cd', 'brch_cd'), array('class'=>'span2', 'id'=>'brchCd','prompt'=>'-Choose Branch-')) ?>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->textFieldRow($model, 'client_from',array('id'=>'clientFrom','class'=>'span4')) ?>
		<?php echo $form->textFieldRow($model, 'client_to',array('id'=>'clientTo','class'=>'span4')) ?>
	</div>
	<div class="span6">
        <?php echo $form->radioButtonListInlineRow($model, 'qty_flg', array(0=>'All', 1=>'Fixed', 2=>'Pooling'),array('id'=>'qtyFlg')) ?>
       
    </div>
</div>

<br/>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id'=>'btnSubmit',
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Show Report',
	)); ?>
	<?php if ($model->hiddenbuttonxls==0) {
		  $this->widget('bootstrap.widgets.TbButton', array(
		  'id'=>'btn_xls',
						
		  'type'=>'primary',
		  'label'=>'Export to Excel',
		  'disabled'=>'true',
		  ));
		  } else {
		  $this->widget('bootstrap.widgets.TbButton', array(
		  'id'=>'btn_xls',
			
		  'type'=>'primary',
		  'label'=>'Export to Excel',
		  'url'=>$url_xls,
		  ));
		  }
	?>
</div>

<div id="showloading" style="display:none;margin-top: -50px; width: auto; text-align: center;">
	Please wait...<br />
	<img src="<?php echo Yii::app()->request->baseUrl ?>/images/loading2.gif" width="25px">	
</div>

<br/>

<?php $this->endWidget() ?>

<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<script>
	$(document).ready(function()
	{		
		changeRadio();
		initAutoComplete();
		qty_option();
		if('<?php echo $url ?>')$("#showloading").show();
	});
	
	$("#stkCd").change(function()
	{
		 $.ajax({
        	'type'		: 'POST',
        	'url'		: '<?php echo $this->createUrl('ajxGetPaymentDt'); ?>',
        	'dataType' 	: 'json',
        	'data'		:	{
        						'stk_cd' : $(this).val(),
        					},
        	'success'	: 	function (data) 
        					{
		           				$("#prePaymentDt").val(data)
		    				}
		});
	});
	
	$("#iframe").load(function()
	{
		$("#showloading").hide();
		$(window).resize();
	});
	
	$("#brchOpt").change(function()
	{
		changeRadio();	
	});
	$('#reportType').change(function() {
	   qty_option();
	});
	
	function changeRadio()
	{
		if($("#brchOpt [type=radio]:checked").val() == 1)$("#brchCd").hide().removeAttr('required');
		else
			$("#brchCd").show().attr('required',true);
	}
	
	function initAutoComplete()
	{
		$("#clientFrom, #clientTo").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getClient'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'stk_cd' : $("#stkCd").val(),
		        						'term': request.term,
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				response(data);
				           				result = data;
				    				}
				});
		   },
		   minLength: 0,
		   open: function()
		   {
        		$(this).autocomplete("widget").width(500); 
           },   
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        })
        
        $("#clientFrom").blur(function()
        {
        	$("#clientTo").val($("#clientFrom").val());
        });
	}
	
	function qty_option()
	{
	    if($("#reportType [type=radio]:checked").val()== 2 )
	    {
	       $('#qtyFlg [type=radio]').attr('disabled',false);
	    }
	    else
	    {
	       $('#qtyFlg [type=radio]').attr('disabled',true);
	    }
	}
</script>