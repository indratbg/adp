<?php $format = new CFormatter;
	$format->numberFormat=array('decimals'=>null, 'decimalSeparator'=>null, 'thousandSeparator'=>',');
 ?>
<?php
$this->breadcrumbs=array(
	'Bonds'=>array('index'),
	$model->bond_cd,
);

$this->menu=array(
	array('label'=>'Bond', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->bond_cd)),
);
?>

<h1>View Bond #<?php echo $model->bond_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'bond_cd',
		array('name'=>'bond_group_cd','value'=>Parameter::model()->find("prm_cd_1='BONDGR' and prm_cd_2 = '$model->bond_group_cd'")->prm_desc),
		array('name'=>'product_type','value'=>Parameter::model()->find("prm_cd_1='BPROD' and prm_desc = '$model->product_type'")->prm_desc),
		'bond_desc',
		'short_desc',
		'isin_code',
		'issuer',
		array('name'=>'sec_sector','value'=>Parameter::model()->find("prm_cd_1='BINDUS' and prm_CD_2 = '$model->sec_sector'")?Parameter::model()->find("prm_cd_1='BINDUS' and prm_CD_2 = '$model->sec_sector'")->prm_desc:'-'),
		array('name'=>'maturity_date', 'type'=>'date'),
		array('name'=>'listing_date', 'type'=>'date'),
		array('name'=>'issue_date', 'type'=>'date'),
		array('name'=>'int_type','value'=>Parameter::model()->find("prm_cd_1='BRATE' and prm_desc = '$model->int_type'")?Parameter::model()->find("prm_cd_1='BRATE' and prm_desc = '$model->int_type'")->prm_desc:'-'),
		array('name'=>'interest','value'=>$format->formatNumber($model->interest)),
		array('name'=>'int_freq','value'=>Parameter::model()->find("prm_cd_1='BFREQ' and prm_desc = '$model->int_freq'")?Parameter::model()->find("prm_cd_1='BFREQ' and prm_desc = '$model->int_freq'")->prm_desc:'-'),
		array('name'=>'day_count_basis','value'=>Parameter::model()->find("prm_cd_1='BDAYC' and prm_desc = '$model->day_count_basis'")?Parameter::model()->find("prm_cd_1='BDAYC' and prm_desc = '$model->day_count_basis'")->prm_desc:'-'),
		array('name'=>'fee_ijarah','value'=>$format->formatNumber($model->fee_ijarah)),
		array('name'=>'nisbah','value'=>$format->formatNumber($model->nisbah)),	
	),
)); ?>



