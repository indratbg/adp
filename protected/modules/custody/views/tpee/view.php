<?php $format = new CFormatter;
	$format->numberFormat=array('decimals'=>null, 'decimalSeparator'=>null, 'thousandSeparator'=>',');
 ?>


<?php
$this->breadcrumbs=array(
	'Tpees'=>array('index'),
	$model->stk_cd,
);

$this->menu=array(
	array('label'=>'Tpee', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->stk_cd)),
);
?>

<h1>View IPO Stock #<?php echo $model->stk_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
				'stk_cd',
				'stk_name',
				'jenis_penjaminan',
				array('name'=>'tgl_kontrak','type'=>'date'),
				array('name'=>'eff_dt_fr','type'=>'date'),
				array('name'=>'eff_dt_to','type'=>'date'),
				array('name'=>'offer_dt_fr','type'=>'date'),
				array('name'=>'offer_dt_to','type'=>'date'),
				array('name'=>'distrib_dt_fr','type'=>'date'),
				array('name'=>'allocate_dt','type'=>'date'), 
				array('name'=>'paym_dt','type'=>'date'),
				array('name'=>'price','value'=>$format->formatNumber($model->price)),
				array('name'=>'nilai_komitment','value'=>$format->formatNumber($model->nilai_komitment)),
				array('name'=>'bank_garansi','value'=>$format->formatNumber($model->bank_garansi)),
				array('name'=>'unsubscribe_qty','value'=>$format->formatNumber($model->unsubscribe_qty)),
				array('name'=>'order_price','value'=>$format->formatNumber($model->order_price)),
				array('name'=>'ipo_bank_cd','value'=>$model->ipo_bank_cd?Ipbank::model()->find("approved_stat='A' and bank_cd='$model->ipo_bank_cd' ")->bank_name:'-'),
				'ipo_bank_acct',
				'ipo_acct_name'
	),
)); ?>


