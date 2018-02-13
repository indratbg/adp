<h1>List Client Bank Account</h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?>
<?php AHelper::applyHeaderDetail(); ?>

<?php
 	$this->widget('bootstrap.widgets.TbButton',array(
		'label' => 'Add Detail',
		'size' => 'medium',
		'icon' => 'plus',
		'id' => 'btnAddDetailFirst',
	 ));
?>

<br/><br/>

<div id="wrap-detail">
    <?php 
    // AR : uncomment this part if you want to autoembed the details !
    // echo $this->renderPartial('_formdetail',array('model'=>$modelDetail)); 
    ?>
</div>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'client-bank-grid',
	'filterPosition' => '',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'bank_cd',
		'bank_name',
		'bank_branch',
		'acct_name',
		'default_flg',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{update} {delete}',
            'deleteButtonUrl'=>'Chtml::normalizeUrl(array("clientbankaccount/deletedetail","client_cd"=>$data->client_cd,"cifs"=>$data->cifs,"bank_cd"=>$data->bank_cd,"bank_acct_num"=>$data->bank_acct_num))',    	// AR: please sync with delete detail action
            'updateButtonUrl'=>'Chtml::normalizeUrl(array("clientbankaccount/updatedetail","client_cd"=>$data->client_cd,"cifs"=>$data->cifs,"bank_cd"=>$data->bank_cd,"bank_acct_num"=>$data->bank_acct_num))',   			 // AR: please sync with delete detail action
            'updateButtonOptions'=>array(
                'class'=>'update',
                'onclick'=>'ajxCreateOrUpdateDetail(\'#client-bank-form\',\'client-bank-grid\',this.href,\'a\'); return false;',
      		),
            'afterDelete'=>'ajxCreateOrUpdateDetail(\'#client-bank-form\',\'client-bank-grid\');',
		),
	),
)); ?>


<script>
	$('#btnAddDetailFirst').click(function(e){
		  ajxCreateOrUpdateDetail(null,'client-bank-grid','<?php echo $this->createUrl('createdetail',array('client_cd'=>$model->client_cd,'cifs'=> $model->cifs)); ?>');
	});
	
	$('#btnAddDetail').live('click',function(e){
	      e.preventDefault();
	      ajxCreateOrUpdateDetail('#client-bank-form','client-bank-grid');
	});
</script>