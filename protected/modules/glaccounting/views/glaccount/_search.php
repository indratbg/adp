<style>
 	#tooltip
 	{
 		 position:absolute;
 		 border:1px solid #333;
 		 border-radius:5px;
 		 background:#f7f5d1;
 		 padding:2px 5px;
 		 color:#333;
 		 display:none;
 	 } 
</style>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
	<?php echo $form->textFieldRow($model,'gl_a',array('class'=>'span2','maxlength'=>4)); ?>
	<?php echo $form->textFieldRow($model,'sl_a',array('id'=>'slA','class'=>'span2','maxlength'=>12,'title'=>"Gunakan '%' untuk search bagian dari sub acct, misal untuk search semua yang depannya 10, ketik '10%'. Untuk search semua yang belakangnya 10, ketik '%10'")); ?>
	<?php echo $form->textFieldRow($model,'acct_name',array('class'=>'span5','maxlength'=>50)); ?>
	<?php echo $form->textFieldRow($model,'acct_stat',array('class'=>'span3','maxlength'=>1)); ?>
	<?php echo $form->textFieldRow($model,'acct_short',array('class'=>'span3','maxlength'=>20)); ?>
	<?php echo $form->textFieldRow($model,'acct_type',array('class'=>'span3','maxlength'=>4)); ?>
	<?php echo $form->dropDownListRow($model,'prt_type',array(''=>'-All-','S'=>'Summary','D'=>'Detail','M'=>'Khusus'),array('class'=>'span3')); ?>
	<?php echo $form->textFieldRow($model,'def_cpc_cd',array('class'=>'span3','maxlength'=>4)); ?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
//Function for displaying tooltip
$(function() {
    $("#slA").focus(function(e) {
        this.t = this.title;
        this.title = "";
        var offset = $(this).offset();
        $("body").append("<span id='tooltip'>" + this.t + "</span>");
        $("#tooltip").css("top", offset.top + "px").css("left", (offset.left+150) + "px").fadeIn("fast");
    });

    $("#slA").blur(function(e) {
        this.title = this.t;
        var offset = $(this).offset();
        $("#tooltip").remove();
        $("#tooltip").css("top", offset.top + "px").css("left", (offset.left+150) + "px").fadeIn("fast");
    });   
});
</script>