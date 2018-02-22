<?php
$this->breadcrumbs=array(
	'Stock Closing Price'=>array('index'),
	'Import',
);

$this->menu=array(
	
	array('label'=>'Upload Stock Close Price', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
);

?>

<br/>

<?php AHelper::showFlash($this) ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tcontracts-form',
	'enableAjaxValidation'=>false,
	'type'=>'inline',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model,$modelPreviews,$modelPreviewSingle); ?>
	
	<?php 
		//foreach($modelPreview as $row)
		//	echo $form->errorSummary($row); 
	?>

	
	<?php echo $form->hiddenField($model,'scenario');?>
	
	<?php if(empty($model->scenario)): ?>
		<?php echo $form->fileFieldRow($model,'upload_file',array('required'=>'required'));?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'secondary',
					'label'=>'Upload',
		)); ?>
	<?php else: ?>
		<?php echo $form->textFieldRow($model,'upload_file',array('disabled'=>'disabled'));?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'secondary',
					'label'=>'Save',
					'id'=>'btnSave'
		)); ?>
	<?php endif; ?>
<?php $this->endWidget(); ?>

<?php 
	function checkType(&$value)
	{
		if(is_numeric($value))
		{
			$value = number_format($value,3,'.',',');	
			return 1;
		}
		else {
			return 0;
		}
	}
 ?>

<br/>
<br/>

		<table id ="table_close" class="items table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<?php foreach($modelPreviewSingle->attributes as $key => $value): ?>
					<?php if($key =='cre_dt' || $key=='user_id' || $key =='approved_dt' || $key == 'approved_stat' || $key=='upd_by' || $key =='approved_by' || $key=='upd_dt' || $key == 'upd_by'){continue;
					}
					else{ ?>
					<th><a href="#"><?php echo $key; ?></a></th>	
					<?php }?>
					
					
				<?php endforeach;?>	
			</tr>
		</thead>
		<?php if(count($modelPreviews) > 0 ): ?> 
			<?php foreach($modelPreviews as $model): ?>
				
				<tr>
				<?php foreach($model->attributes as $key=>$value): ?>
					<?php if($key =='cre_dt' || $key=='user_id' || $key =='approved_dt' || $key == 'approved_stat' || $key=='upd_by' || $key =='approved_by' || $key=='upd_dt' || $key == 'upd_by'){continue;
					}
					else{ ?>
					<td <?php if(checkType($value)){ ?> style="text-align:right" <?php } ?>><?php echo $value; ?></td>
				<?php } endforeach;?>
				</tr>
			<?php endforeach;?>
		<?php  endif; ?>
		<tbody>
</tbody>
</table>

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
	var rowNum = '<?php echo count($modelPreviews);?>'
	if(rowNum>0){
		$('#table_close').show();
	}
	else{
		$('#table_close').hide();
	}
	
	$('#btnSave').click(function(){
		$('#mywaitdialog').dialog('open');
		})
</script>
