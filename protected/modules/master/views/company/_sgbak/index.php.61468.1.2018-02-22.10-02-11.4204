<?php
$this->breadcrumbs=array(
	'Companies'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Company', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/company/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('company-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Company Profile</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'company-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'nama_prsh',
		'kd_broker',
		/*'round',
		'limit_mkbd',
		'jsx_listed',
		'ssx_listed',
		'kom_fee_pct',
		
		'vat_pct',
		'pph_pct',
		'levy_pct',
		'min_fee_flag',
		'min_value',
		'min_charge',
		'brok_nom_asing',
		'brok_nom_lokal',
		'jenis_ijin1',
		'no_ijin1',
		'tgl_ijin1',
		'jenis_ijin2',
		'no_ijin2',
		'tgl_ijin2',
		'jenis_ijin3',
		'no_ijin3',
		'tgl_ijin3',
		'jenis_ijin4',
		'no_ijin4',
		'tgl_ijin4',
		'jenis_ijin5',
		'no_ijin5',
		'tgl_ijin5',
		'user_id',
		'cre_dt',
		'upd_dt',
		'other_1',
		'other_2',
		'def_addr_1',
		'def_addr_2',
		'def_addr_3',
		'post_cd',
		'contact_pers',
		'phone_num',
		'hp_num',
		'fax_num',
		'e_mail1',
		'con_pers_title',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/master/company/AjxPopDelete", array("id" => $data->primaryKey))',			// AH : change
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Cancel Reason",this.href);
		            }'
		         ),
        	 )
		),
	),
)); ?>


<?php
  	AHelper::popupwindow($this, 600, 500);
?>

