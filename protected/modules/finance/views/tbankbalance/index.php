
<?php
$this -> breadcrumbs = array('RDI Balance and  Reconcile Report', );
?>
<?php
$this -> menu = array(
	array(
		'label' => 'RDI Balance and  Reconcile Report',
		'itemOptions' => array('style' => 'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
	),
	array(
		'label' => 'List',
		'url' => array('index'),
		'icon' => 'list',
		'itemOptions' => array(
			'class' => 'active',
			'style' => 'float:right'
		)
	),
);
?>
<br/>

<?php AHelper::showFlash($this) ?>
<!-- show flash -->
<?php AHelper::applyFormatting()
?>
<?php $form = $this -> beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'import-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal',
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	));
?>
<?php echo $form -> errorSummary(array($model,$modelReport)); ?>
<input type="hidden" name="scenario" id="scenario" />

<div class="row-fluid">
	<div class="control-group">
		<div class="span5">
		<?php //echo $form->textField($model,'end_date',array('placeholder'=>'dd/mm/yyyy','class'=>'tdate span4','required'=>true)); ?>
		<?php echo $form->datePickerRow($model,'end_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','required'=>true,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
		<div class="span1">
			<label>Bank</label>
		</div>
		<div class="span2">
			<?php echo $form->dropDownList($model,'bankid',CHtml::listData(Fundbank::model()->findAll(array('order'=>'bank_cd')), 'bank_cd', 'bank_name'),array('prompt'=>'-All-', 'class'=>'span10'));?>
		</div>
		<div class="span2">
			<?php  echo CHTML::activeFileField($model, 'file_upload'); ?>
		</div>
	</div>
	<div class="control-group">
	
		<div class="span5">
			<?php echo $form->radioButtonListRow($model,'reconcile_with',array('0'=>'Tanpa Selisih Pembulatan','1'=>'Hanya Selisih Pembulatan'));?>
		</div>
	</div>
	
	
	<div class="control-group">
		<div class="span4">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label' => 'Import 1',
				'size' => 'medium',
				'id' => 'btnImport1',
				'buttonType' => 'submit',
				//'disabled'=>$btn_import1->dflg1=='N'?true:false,
				'htmlOptions' => array(
					'class' => 'btn-primary',
				)
			));
			?>
		</div>
		<div class="span4">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label' => 'Import 2',
				'size' => 'medium',
				'id' => 'btnImport2',
				'buttonType' => 'submit',
				//'disabled'=>$btn_import->dflg2=='N'?true:false,
				'htmlOptions' => array(
					'class' => 'btn-primary',				
				)
			));
			?>
		</div>
		<div class="span4">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label' => 'Reconcile RDI',
				'size' => 'medium',
				'id' => 'btnReconcile',
				'buttonType' => 'submit',
				'htmlOptions' => array(
					'class' => 'btn-primary',
				)
			));
			?>
		</div>
	</div>
	<div class="control-group">
		<div class="span4">
<pre>
File yang diimport text tab delimited 
Tanpa kolom heading
Kolom : 1. Nama / SID
	2. RDI Account No
	3. Saldo - format general
	4. Kode Bank (BCA02/BNGA3)
</pre>
		</div>
		<div class="span4">
<pre>
Import 2 : Import Saldo BCA
Data dari klikBCA sekuritas	
</pre>			
		</div>
	</div>
</div>
 <iframe src="<?php echo $url; ?>" class="span12" id="report" style="min-height:600px"></iframe>		
 <?php echo $form->datePickerRow($model,'tanggalefektif',array('style'=>'display:none','label'=>false));?>
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

var authorizedFinance=true;
var authorizedCs=true;
init();

function init()
{
	
	
	$('.tdate').datepicker({format:'dd/mm/yyyy'});
	
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateFinance'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedFinance = false;
				}
			},
			 async: false,
		});
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateCs'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedCs = false;
				}
			},
			 async: false,
		});
		//alert(authorizedFinance);
		if(!authorizedFinance)
		{ 
		$('#btnImport1').prop('disabled',true);
		}
		if(!authorizedCs)
		{
		$('#btnImport2').prop('disabled',true);
		}
}

	$('#btnImport1').click(function(event){
		$('#scenario').val('import1');
		$('#mywaitdialog').dialog("open");		
	})
	$('#btnImport2').click(function(event){
		$('#scenario').val('import2');	
		$('#mywaitdialog').dialog("open");	
	})
	$('#btnReconcile').click(function(){
		$('#scenario').val('reconcile');	
	})
	
	
</script>