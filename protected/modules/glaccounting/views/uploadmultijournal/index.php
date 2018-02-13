
<?php
$this->breadcrumbs=array(
	'Upload Multi Journal',
);
?>
<?php
$this->menu=array(
	
	array('label'=>'Upload Multi Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'Upload','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/gljournalledger/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>
<br/>

	
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 
			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				'id'=>'import-form',
				'enableAjaxValidation'=>false,
				'type'=>'horizontal',
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			)); ?>
			
					<?php 
					foreach($modelledger as $row)
						echo $form->errorSummary(array($row)); 
				?>
					
					<?php	echo $form->errorSummary(array($modelfolder,$model));?> 
			
	<input type="hidden" name="sign" id="sign" />		
					<?php  echo CHTML::activeFileField($model,'file_upload',array('required'=>true));?>
			
				<?php 
				$this->widget('bootstrap.widgets.TbButton',
			    array(
			        'label' => 'Upload',
			        'size' => 'medium',
			        'id' => 'btnImportSave',
			        'buttonType'=>'submit',
			        'htmlOptions'=>array('class'=>'btn-small btn-primary' ,'style'=>'font-weight:bold;margin-left:0px;margin-top:-5px;')
			    )
			); ?>
			<br/><br/>
<pre >
File yg diupload adalah text tab delimited tanpa heading kolom-kolomnya :			
1. Journal date		
2. Reference code (eg. AJ-123)		
3. Nomor urut per journal		
4. GL account code (eg. 1200)		
5. Sub account code ( eg. 100001)		
6. Debit (D) / Credit (C) code 		
7. Amount (Tidak menggunakan pemisah ribuan eg. 1000000 atau 1000,55)		
8. Description (Max : 50 chars)
			</pre>	
			

<?php $this->endWidget(); ?>

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
	$('#sign').val('Y');
	init();
	function init()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('AjxValidateBackDate'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					$('#sign').val('N');
				}
			}
		});
	}
	$('#btnImportSave').click(function(){
		$('#mywaitdialog').dialog('open');
	})
</script>