<?php
$this->breadcrumbs=array(
	'Clients'=>array('index'),
	$model->client_cd=>array('view','id'=>$model->client_cd),
	'Update',
);

$this->menu=array(
	array('label'=>'Update Individual Client '.$model->client_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','url'=>array('update','id'=>$model->client_cd),'icon'=>'pencil','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'View','url'=>array('view','id'=>$model->client_cd),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
);
?>

<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php 	
	$base = Yii::app()->baseUrl;
	$urlMasked = $base.'/js/jquery.maskedinput.js';
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'client-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<script type="text/javascript" src='<?php echo $urlMasked;?>'></script>

<?php echo $form->errorSummary(array($model,$modelCif,$modelClientindi,$modelClientEmergency)); ?>

<?php foreach($modelClientBank as $row)echo $form->errorSummary($row) ?>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->dropDownListRow($model,'rem_cd',Chtml::listData(Sales::model()->findAll(array('condition'=>"approved_stat <> 'C' AND rem_susp_stat = 'N'",'order'=>'rem_cd')),'rem_cd', 'CodeAndName'),array('class'=>'span8','prompt'=>'-Choose Sales-','required'=>true)); ?>	
		<input type="hidden" id="rem_hid" value="<?php echo $model->old_rem_cd ?>" />
		<input type="hidden" id="rem_change_flg" name="Client[rem_change_flg]" value="0" />
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->dropDownListRow($model,'branch_code',Chtml::listData(Branch::model()->findAll(array('condition'=>"approved_stat <> 'C'",'order'=>'brch_cd')),'brch_cd', 'brch_name'),array('class'=>'span8','prompt'=>'-Choose Branch-','required'=>true)); ?>		
		<input type="hidden" id="branch_hid" value="<?php echo $model->old_branch_code ?>" />
		<input type="hidden" id="branch_change_flg" name="Client[branch_change_flg]" value="0" />
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->dropDownListRow($model,'client_type_3',Chtml::listData(Lsttype3::model()->findAll(array('order'=>'cl_type3')),'cl_type3', 'cl_desc'),array('class'=>'span8')); ?>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<?php echo $form->labelEx($model,'commission_per',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model,'commission_per',array('class'=>'span3 tnumber','style'=>'text-align:right','required'=>true)); ?>
				<?php echo $form->error($model,'commission_per', array('class'=>'help-inline error')); ?>	
			</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		<?php echo $form->dropDownListRow($model,'olt',Parameter::getCombo('OLTFLG', ''),array('class'=>'span2')) ?> 	
	</div>
</div>

<?php echo $form->labelEx($model,'Modify Reason',array('class'=>'control-label')); ?>
<?php echo $form->textAreaRow($model, 'cancel_reason', array('class'=>'span5', 'id'=>'modify_reason', 'name'=>'Client[cancel_reason]', 'rows'=>5,'label'=>false,'required'=>true)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'htmlOptions'=> array('id'=>'btnSubmit','name'=>'submit','value'=>'submit'),
		'label'=>'Save',
	)); ?>
</div>

<?php $this->endWidget(); ?>

<script>
	$("#Client_commission_per").mask("0.?999");
	
	$("#btnSubmit").click(function()
	{
		if($("#Client_commission_per").val() === '0')
		{
			if(!confirm("Commission % is 0. Do you want to continue?"))
			{
				return false;
			}
		}
		
		var rem_code = $("#Client_rem_cd").val();
		var old_rem_code = $("#rem_hid").val();
		
		if(rem_code && rem_code != old_rem_code)
		{
			if(confirm("Do you want to apply the change you made to the Sales/Remisier to the rest of the client members?"))
			{
				$("#rem_change_flg").val(1);
			}
			else
			{
				$("#rem_change_flg").val(0);
			}
		}
		
		var branch_code = $("#Client_branch_code").val();
		var old_branch_code = $("#branch_hid").val();
		
		if(branch_code && branch_code != old_branch_code)
		{
			if(confirm("Do you want to apply the change you made to the Branch Code to the rest of the client members?"))
			{
				$("#branch_change_flg").val(1);
			}
			else
			{
				$("#branch_change_flg").val(0);
			}
		}
	});
</script>