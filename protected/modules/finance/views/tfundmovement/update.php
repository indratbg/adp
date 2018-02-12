<?php
$this->breadcrumbs=array(
	'Manually Input Fund Movement'=>array('index'),
	$model->client_cd=>array('view','id'=>$model->doc_num),
	'Update',
);

$this->menu=array(
	array('label'=>'', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list'),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'View','url'=>array('view','id'=>$model->doc_num),'icon'=>'eye-open'),
);
?>

<h1>Update Fund Movement <?php echo $model->client_cd; ?></h1>


<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php if($model->trx_type=='R' || $model->trx_type=='B'){
 echo $this->renderPartial('_formUpdate',array('model'=>$model,'oldModel'=>$oldModel)); 	
}
else if($model->trx_type=='O' || $model->trx_type=='I'){
echo $this->renderPartial('_formUpdateTarik',array('model'=>$model,'oldModel'=>$oldModel)); 		
}
else{
echo $this->renderPartial('_formUpdateTarik',array('model'=>$model,'oldModel'=>$oldModel)); 		
}
?>
