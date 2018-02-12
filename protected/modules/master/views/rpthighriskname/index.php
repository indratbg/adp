<style>
	.help-inline.error{display: none;}
	.radio.inline label{margin-left: 15px;}
	.well { padding: 2px; margin: 0px 0px 5px 0px; text-align: center;}
	.table-compact{ padding: 0px; }
	.table-compact tr td{ padding: 0px; } 
</style>

<?php 
	$this->breadcrumbs=array(
	'List of High Risk Name'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'List of High Risk Name', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/postinginterest/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>
	

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'importTransaction-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	
	<?php AHelper::showFlash($this) ?> 
	<?php echo $form->errorSummary(array($model)); ?>
<br/>
	<div class="row-fluid">
		<div class="control-group">
			<div class="span1"></div>
			<div class="span8">
				<?php echo $form->label($model, 'Kategori :',array('class'=>'span2'))?>
				<?php echo $form->dropdownList($model, 'kategori',AConstant::$highrisk_kategori,array('empty' => '--All Categories--'),array('id'=>'mkategori','class'=>'span3'))?>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="control-group">
			<div class="span1"></div>
			<div class="span8">
				<label class="control-label"></label>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Show Report',
					'id'=>'btnProcess'
				)); ?>
			</div>
		</div>
	</div>
	<?php echo $form->datePickerRow($model,'dummy_dt',array('label'=>false,'style'=>'display:none')) ?>
	<?php $this->endWidget(); ?>

<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<script type="text/javascript" charset="utf-8">
	// $("#btnProcess").click(function(event)
	// {	
		//console.log("klik");
		
		// var kategoriPass = ($("#client_Cd").val() || !isSpecClient)?true:false;
// 		
		// if(!kategoriPass){
			// alert("Client harus diisi jika centang Specified Client")
			// return false;
		// }
	
	// })
</script>


