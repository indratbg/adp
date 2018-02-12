<?php
$this->breadcrumbs=array(
	'Close Price'=>array('index'),
	$model->stk_date,
);

$this->menu=array(
	array('label'=>'Close Price', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','stk_date'=>$model->stk_date,'stk_cd'=>$model->stk_cd)),
);
?>

<h1>View Close Price <?php echo $model->stk_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		  array('name'=>'stk_date','type'=>'date'),
                   'stk_cd',
                    'stk_name',
                    array('name'=>'stk_prev','type'=>'number'),
                    array('name'=>'stk_high','type'=>'number'),
                    array('name'=>'stk_low','type'=>'number'),
                    array('name'=>'stk_clos','type'=>'number'),
                    array('name'=>'stk_volm','type'=>'number'),
                    array('name'=>'stk_amt','type'=>'number'),
                    array('name'=>'stk_indx','type'=>'number'),
                    array('name'=>'stk_pidx','type'=>'number'),
                    array('name'=>'stk_askp','type'=>'number'),
                    array('name'=>'stk_askv','type'=>'number'),
                    array('name'=>'stk_askf','type'=>'number'),
                    array('name'=>'stk_bidp','type'=>'number'),
                    array('name'=>'stk_bidv','type'=>'number'),
                    array('name'=>'stk_bidf','type'=>'number'),
                    array('name'=>'stk_open','type'=>'number'),
                    'isin_code'
	),
)); ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	   array('name'=>'cre_dt','type'=>'datetime'),
        'user_id',
        array('name'=>'upd_dt','type'=>'datetime'),
        'upd_by',
        array('name'=>'approved_dt','type'=>'datetime'),
        'approved_by',
	),
)); ?>
