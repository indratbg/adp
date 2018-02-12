<?php
$this->breadcrumbs = array(
	'Repo Daily Report' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'REPO DAILY REPORT',
		'itemOptions' => array('style' => 'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
	),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/texchrate/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
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

<?php AHelper::showFlash($this) ?>
<!-- show flash -->
<?php AHelper::applyFormatting()
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'Rptrepoharian-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>
<?php echo $form->errorSummary(array($model)); ?>

<br/>

<div class="row-fluid">
	<div class="control-group">
		<div class="span5">
			<?php echo $form->datePickerRow($model, 'rpt_date', array(
				'prepend' => '<i class="icon-calendar"></i>',
				'placeholder' => 'dd/mm/yyyy',
				'class' => 'tdate span8',
				'options' => array('format' => 'dd/mm/yyyy')
			));
			?>
		</div>
		<div class="span5">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'OK',
					'id'=>'btnPrint'
				)); ?>
				&emsp;
				<a id="btnSave" class="btn btn-primary">Save to Text File </a> 
		</div>
	</div>
</div>
<pre><strong>Note : Save text file hanya boleh dilakukan jika sudah print report pada tanggal tersebut</strong></pre>
<br />
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>

<?php $this->endWidget(); ?>
<script>

	var rand_value = '<?php echo $model->vo_random_value;?>';
	var save_flg ='<?php echo $save_flg; ?>';

	init();
	function init()
	{
		console.log(rand_value);
		if(save_flg=='N')
		{
			$('#btnSave').attr('disabled',true);
		}
		else
		{
			$('#btnSave').attr('href','<?php echo $this->createUrl('getTextFile&rand_value='); ?>'+rand_value);	
		}
		
		
	}
	
	
</script>