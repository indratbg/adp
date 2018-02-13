<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'highriskname-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->dropDownListRow($model,'kategori',AConstant::$highrisk_kategori,array('class'=>'span3','id'=>'kategori')); ?>
	
	<div id="defaultname">
		<?php echo $form->textAreaRow($model,'name',array('class'=>'span5','rows' => 1,'maxlength'=>200,'id'=>'name')); ?>
	</div>
	<div id="countryname">
		<?php echo $form->dropDownListRow($model,'name',Chtml::listData(Parameter::model()->findAll(array('condition'=>"prm_cd_1 = 'NEGARA' AND approved_stat = 'A'",
		'order'=>'prm_desc')), 'prm_desc', 'prm_desc'),array('class'=>'span6','id'=>'country')); ?>
	</div>
	<div id="negara" >
		<?php echo $form->textFieldRow($model,'country',array('class'=>'span6','maxlength'=>100)); ?>
	</div>
	<div id="birth">
		<?php echo $form->textAreaRow($model,'birth',array('class' => 'span5', 'rows' => 1,'maxlength'=>100)); ?>
	</div>
	<div id="address">
		<?php echo $form->textAreaRow($model,'address',array('class' => 'span5', 'rows' => 2,'maxlength'=>200)); ?>
	</div>
	
	<div>
		<?php echo $form->textAreaRow($model,'descrip',array('class' => 'span5', 'rows' => 3,'maxlength'=>500)); ?>
	</div>
	<div>
		<?php echo $form->datePickerRow($model,'ref_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
	</div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
	
	chkCategory();
	
	$("#kategori").change(function(){
		chkCategory();
	});
	
	function chkCategory(){
		var kategorival = $("#kategori :selected").val();
		if(kategorival == 'COUNTRY'){
			$("#defaultname").hide();
			$("#negara").hide();
			$("#birth").hide();
			$("#address").hide();
			$("#name").attr('name',' ');
			$("#country").attr('name','Highriskname[name]');
			$("#countryname").show();
		}else{
			$("#countryname").hide();
			$("#country").attr('name',' ');
			$("#name").attr('name','Highriskname[name]');
			$("#defaultname").show();
			if(kategorival == 'CUSTOMER' || kategorival == 'ENTITY'){
				$("#negara").show();
				$("#birth").show();
				$("#address").show();
			}else{
				$("#negara").hide();
				$("#birth").hide();
				$("#address").hide();
			}
		}
	}
</script>
