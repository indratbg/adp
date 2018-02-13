<?php
$this->breadcrumbs=array( 
    'Cifs'=>array('index'), 
    'List', 
);

$this->menu=array( 
    array('label'=>'Cif', 'itemOptions'=>array('class'=>'nav-header')), 
    array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')), 
    array('label'=>'Create','url'=>array('create'),'icon'=>'plus'), 
); 

Yii::app()->clientScript->registerScript('search', " 
$('.search-button').click(function(){ 
    $('.search-form').toggle(); 
    return false; 
}); 
$('.search-form form').submit(function(){ 
    $.fn.yiiGridView.update('cif-grid', { 
        data: $(this).serialize() 
    }); 
    return false; 
}); 
"); 
?> 

<h1>List Cifs</h1> 

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?> 
<div class="search-form" style="display:none"> 
<?php $this->renderPartial('_search',array( 
    'model'=>$model, 
)); ?>
</div><!-- search-form --> 

<?php AHelper::showFlash($this) ?> <!-- show flash --> 

<?php $this->widget('bootstrap.widgets.TbGridView',array( 
    'id'=>'cif-grid', 
    'type'=>'striped bordered condensed', 
    'dataProvider'=>$model->search(), 
    'filter'=>$model, 
    'filterPosition'=>'', 
    'columns'=>array( 
        'cif_name',
        'sid',
        'client_type_1',
        'client_type_2',
        'npwp_no',
        'client_title',
        /*
        'mother_name',
        'client_birth_dt',
        'client_ic_num',
        'ic_type',
        'ic_expiry_dt',
        'def_addr_1',
        'def_addr_2',
        'def_addr_3',
        'country',
        'post_cd',
        'phone_num',
        'hp_num',
        'fax_num',
        'hand_phone1',
        'phone2_1',
        'e_mail1',
        'inst_type',
        'inst_type_txt',
        'annual_income_cd',
        'annual_income',
        'funds_code',
        'source_of_funds',
        'purpose01',
        'purpose02',
        'purpose03',
        'purpose04',
        'purpose05',
        'purpose06',
        'purpose07',
        'purpose08',
        'purpose09',
        'purpose10',
        'purpose11',
        'purpose90',
        'purpose_lainnya',
        'invesment_period',
        'net_asset_cd',
        'net_asset',
        'net_asset_yr',
        'addl_fund_cd',
        'addl_fund',
        'biz_type',
        'act_first',
        'act_first_dt',
        'act_last',
        'act_last_dt',
        'siup_no',
        'tdp_no',
        'modal_dasar',
        'modal_disetor',
        'industry_cd',
        'industry',
        'cre_dt',
        'cre_user_id',
        'upd_dt',
        'upd_user_id',
        'autho_person_name',
        'autho_person_ic_type',
        'autho_person_ic_num',
        'autho_person_position',
        'profit_cd',
        'profit',
        'tempat_pendirian',
        'skd_no',
        'skd_expiry',
        'tax_id',
        'autho_person_ic_expiry',
        'def_city',
        'npwp_date',
        'direct_sid',
        'asset_owner',
        'upd_by',
        'approved_dt',
        'approved_by',
        'approved_stat',
        */
        array( 
            'class'=>'bootstrap.widgets.TbButtonColumn', 
        ), 
    ), 
)); ?> 