<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'fixedasset-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'asset_cd',array('class'=>'span2','maxlength'=>7,'readonly'=>'readonly')); ?>

	<?php echo $form->dropDownListRow($model,'branch_cd',CHtml::listData(Branch::model()->findAll(array('condition'=>"approved_stat='A'",'order'=>'brch_cd')), 'brch_cd', 'CodeAndName'),array('class'=>'span3','prompt'=>'-Select Branch Code-')); ?>

	<?php echo $form->dropDownListRow($model,'asset_type',CHtml::listData(Parameter::model()->findAll("PRM_CD_1 = 'FASSET'"), 'prm_cd_2', 'prm_desc'),array('class'=>'span5','prompt'=>'-Select Asset Type-')); ?>

	<?php echo $form->textAreaRow($model,'asset_desc',array('class'=>'span5','maxlength'=>60)); ?>

	<?php echo $form->datePickerRow($model,'purch_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>

	<?php echo $form->textFieldRow($model,'purch_price',array('class'=>'span3 tnumber','maxlength'=>21,'style'=>'text-align:right')); ?>
<div class="control-group">
	<?php echo $form->labelEx($model,'age',array('class'=>'control-label'))?>
	<?php echo $form->textField($model,'age',array('class'=>'span1','maxlength'=>3)); ?>
	Months
</div>
	<?php echo $form->textFieldRow($model,'asset_stat',array('class'=>'span2','maxlength'=>10,'value'=>$model->isNewRecord?'ACTIVE':$model->asset_stat)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>


<script>
    var asset_cd ='<?php echo $model->isNewRecord?'':$model->asset_cd;?>';
    var asset_type = '<?php echo $model->isNewRecord?'':$model->asset_type;?>';
   
	$('#Fixedasset_asset_type').change(function(){
		
		if(asset_cd.substr(0,1) != $('#Fixedasset_asset_type').val().substr(0,1))
		{
		  Asset_no();    
		}
	    if($('#Fixedasset_asset_type').val() == asset_type)
	    {
	        $('#Fixedasset_asset_cd').val(asset_cd);
	    }	
	});
	
	function Asset_no(){
		var asset_no = $('#Fixedasset_asset_type').val();
		//alert('asas');
			$.ajax({
	    		'type'     :'POST',
	    		'url'      : '<?php echo $this->createUrl('Assetno'); ?>',
				'dataType' : 'json',
				'data'     : {'asset_no' : asset_no
								
							  
							},
				'success'  : function(data){
						var asset_no = data.num;
						
						$('#Fixedasset_asset_cd').val(asset_no);
						
						
					
						
				}
			});
			
	}
</script>