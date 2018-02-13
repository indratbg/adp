<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php //echo $this->renderPartial('_form',array('model'=>$modelHeader)); ?>
<?php
         $this->widget('bootstrap.widgets.TbButton',array(
			'label' => 'Add Detail',
			'size' => 'medium',
			'id'=>'btnAddDetailFirst',
		));
	?>
<br/>

<div id="wrap-detail">
    <?php 
    // AR : uncomment this part if you want to autoembed the details !
    // echo $this->renderPartial('_formdetail',array('model'=>$modelDetail)); 
    ?>
</div>
<br/>
<?php
 //AR: Code Below is for showing the detail grid
 $controller  = $this;
 $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'clientinstitutionaldetail-grid',
        'type'=>'striped bordered condensed',
        'filterPosition'=>'',
        'dataProvider'=>$modelDetail->search(),
        'filter'=>$modelDetail,
        'columns'=>array(
			'first_name',
			'middle_name',
			'last_name',
		array(
	            'class'=>'bootstrap.widgets.TbButtonColumn',
	            'template'=>'{update} {delete}',
	            'deleteButtonUrl'=>'Chtml::normalizeUrl(array("clientinstitutional/deletedetail","cifs"=>$data->cifs,"seqno"=>$data->seqno))',    // AR: please sync with delete detail action
	            'updateButtonUrl'=>'Chtml::normalizeUrl(array("clientinstitutional/updatedetail","cifs"=>$data->cifs,"seqno"=>$data->seqno))',    // AR: please sync with delete detail action
	            'updateButtonOptions'=>array(
	                'class'=>'update',
	                'onclick'=>'ajxCreateOrUpdateDetail(\'#clientinstitutionaldetail-form\',\'clientinstitutionaldetail-grid\',this.href,\'a\'); return false;',
	            ),
                'afterDelete'=>'ajxCreateOrUpdateDetail(\'#clientinstitutional-form\',\'clientinstitutionaldetail-grid\');',
	        ),
            
        ),
    ));
?>
<?php AHelper::applyHeaderDetail(); ?>

<script>
	
$('#btnAddDetail').live('click',function(e){
      e.preventDefault();
      //alert('btnadddetail');
      //ajxCreateOrUpdateDetail('#clientinstitutionaldetail-form','clientinstitutionaldetail-grid');
      ajxCreateOrUpdateDetail('#clientinstitutionaldetail-form','clientinstitutionaldetail-grid','<?php echo $this->createUrl("createdetail",array("cifs"=>$cifs,"seqno"=>$seqno)); ?>');
});

$('#btnAddDetailFirst').click(function(e){
	  //alert('btnadddetailfirst');
	  ajxCreateOrUpdateDetail(null,'clientinstitutionaldetail-grid','<?php echo $this->createUrl("createdetail",array("cifs"=>$cifs,"seqno"=>$seqno)); ?>');
});

</script>