<!--Use this to load the masked input script-->
<?php 	
	$base = Yii::app()->baseUrl;
	$urlMasked = $base.'/js/jquery.maskedinput.js';
?>
<script type="text/javascript" src='<?php echo $urlMasked;?>'></script>
<!--Use this to load the masked input script-->

<?php 
$this->breadcrumbs=array(
	'SDI'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'SDI', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
);

?>

<?php echo $this->renderPartial('_form_header', array('model'=>$model)); ?>

<br/>

<div id="subrek-grid">
	<!-- subrek -->
	<?php if($show_grid==AConstant::SDI_TYPE_SUBREK): ?>
		<?php echo $this->renderPartial('_form_subrek', array('modelSubrek'=>$modelSubrek)); ?>
	<?php endif; ?>
</div>


<div id="data-grid">
	<!-- data -->
	<?php if($show_grid==AConstant::SDI_TYPE_PENGKINIANDATA): ?>
		<?php echo $this->renderPartial('_form_data', array('modelData'=>$modelData)); ?>
	<?php endif; ?>
</div>


<div id="block-grid">
	<!-- block -->
	<?php if($show_grid==AConstant::SDI_TYPE_BLOCK): ?>
		<?php echo $this->renderPartial('_form_block', array('modelBlock'=>$modelBlock)); ?>
	<?php endif; ?>
</div>


<div id="unblock-grid">
	<!-- unblock -->
	<?php if($show_grid==AConstant::SDI_TYPE_UNBLOCK): ?>
		<?php echo $this->renderPartial('_form_unblock', array('modelUnblock'=>$modelUnblock)); ?>
	<?php endif; ?>
</div>


<?php
/*======================================LOAD JQUERY PLUGIN MASK HERE======================================*/
	#$base = Yii::app()->baseUrl;
	//$cs=Yii::app()->clientScript();
	//$cs->registerScriptFile($base.'/framework/web/js/source/jquery.maskedinput.js');
	#$urlMasked = $base.'/js/jquery.maskedinput.js';
	
	//$cs->registerCoreScript('maskedinput');
	
	#Yii::app()->getClientScript()->registerCoreScript('jquery.maskedinput.js');
/*======================================LOAD JQUERY PLUGIN MASK HERE======================================*/
?>














