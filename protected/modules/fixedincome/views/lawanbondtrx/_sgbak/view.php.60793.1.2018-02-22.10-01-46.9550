<?php
$this->breadcrumbs=array(
	'Lawan Bond Trxes'=>array('index'),
	$model->lawan,
);

$this->menu=array(
	array('label'=>'LawanBondTrx', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->lawan)),
);
?>
<?php
 $query="SELECT DISTINCT lawan_type, p.descrip,  capital_tax_pcn, deb_gl_acct, Cre_gl_acct
		FROM MST_LAWAN_BOND_TRX m ,
		( SELECT prm_cd_2, prm_desc AS descrip
		FROM MST_PARAMETER
		WHERE prm_cd_1 = 'LAWAN') p
		WHERE m.lawan_type = p.prm_cd_2
		and lawan_type = '$model->lawan_type'
		ORDER BY 1";
$lawan_type_list=DAO::queryRowSql($query);
?>
<h1>View Counter Party #<?php echo $model->lawan; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'lawan',
		'lawan_name',
		'ctp_cd',
		'custody_cbest_cd',
		array('name'=>'lawan_type','value'=>$lawan_type_list['descrip']),
		'capital_tax_pcn',
		'phone',
		'fax',
		'contact_person',
		'e_mail',
		'deb_gl_acct',
		'cre_gl_acct',
		'sl_acct_cd',
		
	),
)); ?>


<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	),
)); ?>
