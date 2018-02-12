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
</style>

<?php
$this->menu=array(
	array('label'=>'Repo / Reverse Repo Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/gljournalledger/index','icon'=>'list','itemOptions'=>array('style'=>'float:right'))
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'genrepojournal-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	echo $form->errorSummary($model); 
	if($modelHeader)echo $form->errorSummary($modelHeader);
	foreach($modelLedger as $row)
	{
		echo $form->errorSummary($row);
	}
	if($modelFolder)echo $form->errorSummary($modelFolder);
?>

<br/>

<?php echo $form->datePickerRow($model, 'repo_date',array('id'=>'repoDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>

<?php echo $form->dropDownListRow($model, 'repo_num', CHtml::listData(Trepo::model()->findAll("sett_val > 0 AND approved_stat = 'A' AND penghentian_pengakuan = 'Y'"), 'repo_num', 'repo_ref'), array('class'=>'span4', 'id'=>'repoNum','prompt'=>'-Choose Repo-','required'=>true)) ?>

<input type="hidden" id="repoType" name="Genrepojournal[repo_type]" value="<?php echo $model->repo_type ?>" />
<input type="hidden" id="returnVal" name="Genrepojournal[return_val]" value="<?php echo $model->return_val ?>" />


<?php echo $form->textFieldRow($model, 'repo_val', array('id'=>'repoVal', 'class'=>'tnumber span3'/*, 'readonly'=>true*/)) ?>

<?php echo $form->radioButtonListInlineRow($model, 'repo_stage', array(1=>'First Leg', 2=>'Second Leg'), array('id'=>'repoStage')) ?>

<br/>

GL Account Code:

<div class="control-group">
	<?php echo $form->label($model, 'Bank', array('class'=>'control-label')) ?>
	
	<div class="controls">
		<?php echo $form->textField($model, 'bank_gla', array('id'=>'bankGla', 'class'=>'span1', 'readonly'=>true)) ?>
		<?php echo $form->textField($model, 'bank_sla', array('id'=>'bankSla', 'class'=>'span2')) ?>
	</div>
</div>

<div class="control-group">
	<?php echo $form->label($model, 'Laba / Rugi Portofolio', array('class'=>'control-label')) ?>
	
	<div class="controls">
		<?php echo $form->textField($model, 'lr_porto_gla', array('id'=>'lrPortoGla', 'class'=>'span1', 'readonly'=>true)) ?>
		<?php echo $form->textField($model, 'lr_porto_sla', array('id'=>'lrPortoSla', 'class'=>'span2')) ?>
	</div>
</div>

<div class="control-group">
	<?php echo $form->label($model, 'Portofolio', array('class'=>'control-label')) ?>
	
	<div class="controls">
		<?php echo $form->textField($model, 'porto_gla', array('id'=>'portoGla', 'class'=>'span1', 'readonly'=>true)) ?>
		<?php echo $form->textField($model, 'porto_sla', array('id'=>'portoSla', 'class'=>'span2')) ?>
	</div>
</div>

<br/>

<?php echo $form->textFieldRow($model, 'remarks', array('id'=>'remarks', 'class'=>'span6', 'maxlength'=>50)) ?>

<?php echo $form->textFieldRow($model, 'folder_cd', array('id'=>'folderCd', 'class'=>'span2', 'maxlength'=>8)) ?>

<div class="text-center" id="retrieve">
<?php $this->widget('bootstrap.widgets.TbButton', array(
	'id'=>'btnSubmit',
	'buttonType'=>'submit',
	'type'=>'primary',
	'label'=>'Create'
)); ?>

</div>	

<?php $this->endWidget() ?>

<script>
	$(document).ready(function()
	{
		//$(".radioSpan").css('width',$("#stkCd_span > .control-group > label").width());
		
		initAutoComplete();
	});
	
	$("#repoNum").change(function()
	{
		getDetail();
	});
	
	$("input[type=text]").change(function()
	{
		$(this).val($(this).val().toUpperCase());
	});
	
	function initAutoComplete()
	{
		var bankGla = $("#bankGla").val();
		
		$("#bankSla").autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getBankSla'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						'bankGla' : bankGla
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				    				}
				});
		    },
		    minLength: 1
		})
	}
	
	function getDetail()
	{
		var repo_num = $("#repoNum").val();
		
		$.ajax({
        	'type'		: 'POST',
        	'url'		: '<?php echo $this->createUrl('ajxGetDetail'); ?>',
        	'dataType' 	: 'json',
        	'data'		:	{'repo_num': repo_num},
        	'success'	: 	function (data) 
			{
				if(data)
				{
					$("#repoVal").val(setting.func.number.addCommas(data['repo_val']));
					$("#returnVal").val(data['return_val']);
					$("#repoType").val(data['repo_type']);
					$("#portoSla").val(data['stk_cd']);
				}
				else
				{
					$("#repoVal").val('');
					$("#returnVal").val('');
					$("#repoType").val('');
					$("#portoSla").val('');
				}
			}
		});
	}
</script>