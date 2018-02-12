<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php 
	$this->breadcrumbs=array(
	'Update Sub Rekening and SID'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Update Sub Rekening and SID', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'importTransaction-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	
	
	<?php echo $form->errorSummary($model); ?>
	<?php AHelper::showFlash($this) ?> 
	<?php AHelper::alphanumericValidator()?>	
	
	<br>
	
		<div class="row-fluid control-group">
			<div class="span1"> </div>
			<?php echo $form->datePickerRow($model,'curr_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy')));?>
		</div>
		
		<div class="row-fluid control-group">
			<div class="span1"> </div>
			<div style="margin-top: 7px;">
				<?php echo $form->radioButtonListInlineRow($model, 'selected_mode', AConstant::$upd_subrek_sid,array('required'=>'required')); ?>
			</div>
			
		
		</div>
	
		<div class="row-fluid control-group">
			<div class="span1"> </div>
			<i style="font-size:11px;color:blue"> Suffix 00 - Jika belum upload pembukaan rekening ke CBEST</i>
			</br>
			<i style="font-size:11px;color:blue"> Suffix XX - Jika sudah upload subrek dari CBEST ke insistpro (upload file ACT)</i>
		
		</div>
		
		<div class="row-fluid control-group">
			<div class="span1"> </div>
			<div style="margin-top: 20px">	
				<?php echo $form->textFieldRow($model,'from_subrek',array('class'=>'span2 tvalAlphaNum upc','maxlength'=>4,'required'=>'required'));?>
			</div>
		</div>
		<div class="row-fluid control-group">
			<div class="span1"> </div>
			<?php echo $form->textFieldRow($model,'to_subrek',array('class'=>'span2 tvalAlphaNum upc','maxlength'=>4,'required'=>'required'));?>
		</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Process',
			'id'=>'btnImport',
			'htmlOptions'=>array('disabled'=>$flag=='Y'?true:false,'style'=>$flag=='Y'?'opacity:0.2':'opacity:1'),
		)); ?>
	</div>
	
<?php $this->endWidget(); ?>

<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'Update Sub Rekening and SID  In Progress',
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


<script type="text/javascript" charset="utf-8">
	
	$("#btnImport").click(function(event)
	{	
		//event.preventDefault();
		//console.log("klik");
		//console.log($('#Updsubrekandsid_from_subrek').val()+' '+$('#Updsubrekandsid_to_subrek').val()+' '+$("input[type='radio'][name='Updsubrekandsid[selected_mode]']:checked").val());
		if($('#Updsubrekandsid_from_subrek').val()&&$('#Updsubrekandsid_to_subrek').val()&&$("input[type='radio'][name='Updsubrekandsid[selected_mode]']:checked").val()){
			$('#mywaitdialog').dialog("open"); 
		}
		
	
	})
	
	$('.upc').change(function(){
		var subrek=$(this).val();
		
		$(this).val(subrek.toUpperCase());
	});
	
	
</script>


