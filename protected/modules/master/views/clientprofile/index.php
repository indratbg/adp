<style>
	.radio{width:6em;}
	.div-hid{display:none;}
</style>

<?php 
$this->breadcrumbs=array(
	'Clientprofile'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Clientprofile', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
);
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->radioButtonListInlineRow($model, 'status', Clientprofile::$client_profile_status,array('id'=>'radio_status')); ?>
	
	<div id="status_aktif" class="div-hid">
	<?php echo $form->dropDownListRow($model,'client_cd_aktif',CHtml::listData(Client::model()->findAll(array('condition'=>"client_type_1 <> 'B' AND susp_stat <> 'C'",'order'=>'client_cd ASC')), 
										'client_cd', 'CodeAndNameAndType')); ?>
										
	<?php echo $form->dropDownListRow($model,'old_cd_aktif',CHtml::listData(Client::model()->findAll(array('condition'=>"client_type_1 <> 'B' AND susp_stat <> 'C'",'order'=>'client_cd ASC')), 
										'client_cd', 'CodeAndNameAndType')); ?>
	</div>
	
	<div id="status_closed" class="div-hid">
	<?php echo $form->dropDownListRow($model,'client_cd_closed',CHtml::listData(Client::model()->findAll(array('condition'=>"client_type_1 <> 'B' AND susp_stat = 'C'",'order'=>'client_cd ASC')), 
										'client_cd', 'CodeAndNameAndType')); ?>
										
	<?php echo $form->dropDownListRow($model,'old_cd_closed',CHtml::listData(Client::model()->findAll(array('condition'=>"client_type_1 <> 'B' AND susp_stat = 'C'",'order'=>'client_cd ASC')), 
										'client_cd', 'CodeAndNameAndType')); ?>
	</div>
	
	<div id="status_all" class="div-hid">
	<?php echo $form->dropDownListRow($model,'client_cd_all',CHtml::listData(Client::model()->findAll(array('condition'=>"client_type_1 <> 'B'",'order'=>'client_cd ASC')), 
										'client_cd', 'CodeAndNameAndType')); ?>
										
	<?php echo $form->dropDownListRow($model,'old_cd_all',CHtml::listData(Client::model()->findAll(array('condition'=>"client_type_1 <> 'B'",'order'=>'client_cd ASC')), 
										'client_cd', 'CodeAndNameAndType')); ?>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Submit',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
	function hideAll()
	{
		$('.div-hid').hide();
	}
	$('#radio_status').change(function(){
		var status = $('#radio_status input:checked').val();
		hideAll();
		switch(status)
		{
			case('<?php echo Clientprofile::CLIENT_PROFILE_AKTIF;?>'):
			$('#status_aktif').show();
			break;
			
			case('<?php echo Clientprofile::CLIENT_PROFILE_CLOSED;?>'):
			$('#status_closed').show();
			break;
			
			case('<?php echo Clientprofile::CLIENT_PROFILE_ALL;?>'):
			$('#status_all').show();
			break;
		}//end switch
	});
	$('#radio_status').trigger('change');
</script>





















