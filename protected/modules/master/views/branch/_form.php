<style>
	form table tr td{padding: 0px;}
	.help-inline.error{display: none;}
	
</style>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'branch-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
		<div class="span6">
			<?php if($model->isNewRecord): ?>
				<?php echo $form->textFieldRow($model,'brch_cd',array('class'=>'span2','maxlength'=>2)); ?>
			<?php else: ?>
				<?php echo $form->textFieldRow($model,'brch_cd',array('class'=>'span2','maxlength'=>2,'readonly'=>'readonly')); ?>
			<?php endif ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'brch_name',array('class'=>'span8','maxlength'=>30,'id'=>'brchname')); ?>
		</div>
	</div>
	<?php echo $form->textFieldRow($model,'def_addr_1',array('class'=>'span6','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'def_addr_2',array('class'=>'span6','maxlength'=>50)); ?>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->label($model,'&nbsp',array('class'=>'control-label'));?>
			<?php echo $form->textFieldRow($model,'def_addr_3',array('class'=>'span8','maxlength'=>30,'label'=>false)); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'post_cd',array('class'=>'span8','maxlength'=>6)); ?>
			<?php //echo $form->dropDownListRow($model, 'regn_cd', Parameter::cmbRegion(),array('class'=>'span8')); ?>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'phone_num',array('class'=>'span8','maxlength'=>15)); ?>
			<?php echo $form->textFieldRow($model,'phone2_1',array('class'=>'span8','maxlength'=>15)); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'fax_num',array('class'=>'span8','maxlength'=>15)); ?>
			<?php echo $form->textFieldRow($model,'hand_phone1',array('class'=>'span8','maxlength'=>15)); ?>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'contact_pers',array('class'=>'span8','maxlength'=>40)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<?php echo $form->textFieldRow($model,'e_mail1',array('class'=>'span6','maxlength'=>50)); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
		<?php echo $form->dropDownListRow($model,'bank_cd',Chtml::listData(Bankacct::model()->findAll(array('condition'=>'approved_stat = \'A\'','order'=>'bank_cd')),'bank_cd', 'BankCdAndName'),
						array('class'=>'span8','id'=>'cmb_bank_cd','prompt'=>'-Choose Bank-')); ?>
	
		
		<?php echo $form->textFieldRow($model,'acct_prefix',array('class'=>'span8','maxlength'=>2)); ?>
		
		</div>
		<div class="span6">
			<?php if($model->isNewRecord): ?>
					<?php echo $form->dropDownListRow($model,'brch_acct_num', array(),
									array('class'=>'span8','id'=>'cmb_acct_num')); ?>
			<?php else: ?>
					<?php echo $form->textFieldRow($model,'brch_acct_num',array('class'=>'span8')); ?>
			<?php endif ?>
			<?php echo $form->radioButtonListInLineRow($model,'branch_status',array('A'=>'Active','C'=>'Closed'),array('class'=>'span4')); ?>
		</div>
		
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">

	$("#brchname").keyup(function(){
		$("#brchname").val(($("#brchname").val()).toUpperCase());
	});
	
	init();
	
	function init()
	{
		genCmbAcctNum();
	}
	
	function genCmbAcctNum()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxCmbAccNum'); ?>',
			'dataType' : 'json',
			'data'     : $('#branch-form').serialize(),
			'success'  : function(data){
				var txtCmb  = '<option value="">-Choose Account Number-</option>';
				var dataCmb = data.content;
				
				$.each(dataCmb.acct_label, function(i, item) {
				    txtCmb  += '<option value="'+dataCmb.acct_value[i]+'">'+dataCmb.acct_label[i]+'</option>';
				});
				
				$('#cmb_acct_num').html(txtCmb);
				$('#cmb_acct_num').val('<?php echo $model->brch_acct_num; ?>');
			}
		});
	}
	
	$('#cmb_bank_cd').change(function(){
		genCmbAcctNum();
	});
		
</script>
