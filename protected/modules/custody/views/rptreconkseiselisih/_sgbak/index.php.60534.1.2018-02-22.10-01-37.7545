
<?php
$this->menu=array(
	array('label'=>'Reconcile Dana di KSEI', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'iporeport-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	echo $form->errorSummary($model);
?>

<br/>

<div class="row-fluid">
	<div class="control-group">
		<div class="span5">
			<?php echo $form->datePickerRow($model,'p_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="span1">
			<label>Selisih</label>
		</div>
		<div class="span3" style="padding-left: 40px">
			<?php echo $form->radioButton($model,'p_selisih',array('value'=>'DOMAIN','class'=>'p_selisih','id'=>'p_selisih_0','uncheckValue'=>null)) ."&nbsp; Selisih 10.000 karena Domain";?>
		</div>
	</div>
	<div class="control-group">
		<div class="span3" style="padding-left: 140px">
			<?php echo $form->radioButton($model,'p_selisih',array('value'=>'OTHER','class'=>'p_selisih','id'=>'p_selisih_1','uncheckValue'=>null)) ."&nbsp; Selisih Lainnya";?>
		</div>
	</div>
	<div class="control-group">
		<div class="span1">
			<label>Show</label>
		</div>
		<div class="span3" style="padding-left: 40px">
			<?php echo $form->radioButton($model,'p_option',array('value'=>'N','class'=>'p_option','id'=>'p_option_0','uncheckValue'=>null)) ."&nbsp; Different Only";?>
		</div>
	</div>
	<div class="control-group">
		<div class="span3" style="padding-left: 140px">
			<?php echo $form->radioButton($model,'p_option',array('value'=>'ALL','class'=>'p_option','id'=>'p_option_1','uncheckValue'=>null)) ."&nbsp; All";?>
		</div>	
	</div>
</div>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id'=>'btnSubmit',
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'OK',
	)); ?>
</div>

<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php $this->endWidget();?>


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
var url = '<?php echo $url;?>';
	if (url=='')
		{
			$('#iframe').hide();
		}	
	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		$("#iframe").offset({left:2});
		$("#iframe").css('width',($(window).width()));
	}
	
	
</script>