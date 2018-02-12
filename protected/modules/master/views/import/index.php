<style>
	.filter-group *
	{
		float:left;
	}
	#tableImport
	{
		background-color:#C3D9FF;
	}
	#tableImport thead, #tableImport tbody
	{
		display:block;
	}
	#tableImport tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}

	.markCancel
	{
		background-color:#BB0000;
	}
.radio.inline{
	width: 130px;
}

</style>

<?php
$this->breadcrumbs=array(
	'Upload Rekening Dana',
);
?>
<?php
$this->menu=array(
	//array('label'=>'Trekdanaksei', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Upload Rekening Dana', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
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
			<?php echo $form->errorSummary($model); ?>
		
		
			<input type="hidden" id="scenario" name="scenario"/>
			<?php
				/*if(!$model->isNewRecord) 
				{
					if($model->client_po_clientfile!='')
					{
						echo CHtml::link($model->client_po_clientfile, FileUpload::getHttpPath($model->so_cd, FileUpload::CLIENT_PO_PATH), array('id'=>'file_link'));
						//'<a id="file_link" href="'.Yii::app()->request->baseUrl."/upload/client_po/".$model->client_po_clientfile.'" target="_blank">'.$model->client_po_clientfile.'</a>';
						echo ' '. CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/delete_red.png'), 'javascript://', array('id'=>'del_file')). '<br />';
					}
				}*/
			?>
		
			
			<div class="row-fluid">
				<div class="span4">
					<?php  echo CHTML::activeFileField($model,'file_upload');?>
					
				</div>
				<div class="span4" style="margin-left:-10px;margin-top:0px;">
						<?php echo $form->radioButtonListInlineRow($model, 'import_type', AConstant::$import_type,array('label'=>false)); ?>
				
				</div>
				<div class="span4">
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
				</div>
				
				
			</div>
				
			

<?php $this->endWidget(); ?>
	
<script type="text/javascript" charset="utf-8">
adjustWidth();


	
	function ajxReconcileKsei()
	{
		$.ajax({
			'type' 	  :'POST',
			'url'  	  :'<?php //echo CController::createUrl('import/AjxReconcileKsei')?>',
			'success' :function(msg){
				$("#ksei-iframe").attr('src', msg);
			},
			'error':function(){
				alert('Error KSEI coba lagi');
			}
		});
	}
	
	function ajxReconcileBank()
	{
		$.ajax({
			'type' 	  :'POST',
			'url'  	  :'<?php //echo CController::createUrl('import/AjxReconcileBank')?>',
			'success' :function(msg){
				$("#bank-iframe").attr('src', msg);
			},
			'error':function(){
				alert('Error BANK coba lagi');
			}
		});
	}
	
	$('#ksei-grid').hide();
	$('#bank-grid').hide();
	
	$('#btnReconcileKsei').click(function(e)
	{
		//show reconcile KSEI
		ajxReconcileKsei();
		$('#ksei-grid').show();
		$('#bank-grid').hide();
		//alert('tai');
	});
	
	$('#btnReconcileBank').click(function(e)
	{
		//show reconcile bank
		ajxReconcileBank();
		$('#bank-grid').show();
		$('#ksei-grid').hide();
	});
	
	
	
	
	
	
</script>