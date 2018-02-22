<?php
$this->breadcrumbs=array(
	'Print Journal'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Print Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
//	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tcorpact/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tcorpact-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br/>
<?php echo $form->errorSummary(array($modelreport)); ?>
<a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-small btn-primary">Save to Excel</a>
<br />
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%;"></iframe>


<?php $this->endWidget(); ?>
<script>
var url_xls = '<?php echo $url_xls ?>';

init();
	function init()
	{
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	}
</script>