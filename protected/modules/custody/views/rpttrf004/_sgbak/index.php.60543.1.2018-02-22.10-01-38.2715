<style>
	.tnumber
	{
		text-align:right
	}
	
	.help-inline.error
	{
		display: none
	}
</style>

<?php
$this->menu=array(
	array('label'=>'Transfer from/to Subrek 004 Report', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
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
		<?php echo $form->datePickerRow($model,'due_date',array('id'=>'dueDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span2">
				<?php echo $form->label($model,'client_cd',array('class'=>'control-label')); ?>
			</div>
			<div class="controls">
				<?php echo $form->checkBox($model,'all_client_flg',array('value'=>'Y','uncheckValue'=>'N','id'=>'allClientFlg','class'=>'allFlg')); ?>
				&nbsp; All &emsp;
				<?php echo $form->textField($model,'client_cd',array('id'=>'clientCd','class'=>'span3')) ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->datePickerRow($model,'trx_date',array('id'=>'trxDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span2">
				<?php echo $form->label($model,'stk_cd',array('class'=>'control-label')); ?>
			</div>
			<div class="controls">
				<?php echo $form->checkBox($model,'all_stk_flg',array('value'=>'Y','uncheckValue'=>'N','id'=>'allStkFlg','class'=>'allFlg')); ?>
				&nbsp; All &emsp;
				<?php echo $form->textField($model,'stk_cd',array('id'=>'stkCd','class'=>'span3')) ?>
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<div class="span4 trfMode_span">
				<?php echo $form->label($model,'trf_mode',array('class'=>'control-label')); ?>
			</div>
			<input id="trfMode1" class="trfMode" type="radio" name="Rpttrf004[trf_mode]" value="N" style="float:left" <?php if($model->trf_mode == 'N')echo 'checked' ?>>
			<label for="trfMode1" style="float:left">&emsp;Trx yg sudah due</label>
		</div>
		
		<div class="control-group">
			<div class="span4">

			</div>
			<input id="trfMode2" class="trfMode" type="radio" name="Rpttrf004[trf_mode]" value="004" style="float:left" <?php if($model->trf_mode == '004')echo 'checked' ?>>
			<label for="trfMode2" style="float:left">&emsp;Net Sell T1/T2 ke 004</label>
		</div>
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
		adjustLabelWidth();
		initAutoComplete();
		
		$(".allFlg").each(function(){changeVisibility($(this))});
		
		if('<?php echo $url ?>')$("#showloading").show();
	});
	
	$(window).resize(function()
	{
		adjustLabelWidth();
	});
	
	$("#dueDate").change(function()
	{
		 $.ajax({
        	'type'		: 'POST',
        	'url'		: '<?php echo $this->createUrl('ajxGetTrxDate'); ?>',
        	'dataType' 	: 'json',
        	'data'		:	{
        						'due_date' : $(this).val(),
        					},
        	'success'	: 	function (data) 
        					{
		           				$("#trxDate").val(data)
		    				}
		});
	});
	
	$("#iframe").load(function()
	{
		$("#showloading").hide();
		$(window).resize();
	});
	
	$(".allFlg").change(function()
	{
		changeVisibility($(this));
	})
	
	function changeVisibility(obj)
	{
		if(obj.is(":checked"))obj.next().hide().removeAttr('required');
		else
			obj.next().show().attr('required',true);
	}
	
	function adjustLabelWidth()
	{
		$("label[for=dueDate], label[for=trxDate]").width($(".trfMode_span").width());
	}
	
	function initAutoComplete()
	{
		$("#clientCd").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getClient'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				response(data);
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
        
		$("#stkCd").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getStock'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				response(data);
				    				}
				});
		   },
		   minLength: 0,
		}).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        })
	}
</script>