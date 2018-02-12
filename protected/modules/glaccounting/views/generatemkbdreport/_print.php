<style>
	#type > label
	{
		min-width:102px;
		margin-left:-5px;
	}
	
	#type > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:-30px;
	}
	
	#type > label > input
	{
		float:left;
		margin-left:-50px;
	}
</style>
<?php
$this->breadcrumbs=array(
	'MKBD Report',
);
?>
<?php
$this->menu=array(
	
	array('label'=>$label_header, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
		array('label'=>'Generate','url'=>array('generate'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
		//array('label'=>'Print','url'=>array('print'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/Generatemkbdreport/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);

?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Generatemkbd-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br />
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php echo $form->errorSummary($model);?>

<input type="hidden" name="scenario" id="scenario" />
<div class="row-fluid">
	<div class="span1">
		
	</div>
	<div class="span4">
		<?php echo $form->checkBox($model,'vd51',array('class'=>'span1 checkBoxDetail'))."VD 5-1 Asset";?><br/>
		<?php echo $form->checkBox($model,'vd52',array('class'=>'span1 checkBoxDetail'))."VD 5-2 Liabilities + Ekuitas";?><br/>
		<?php echo $form->checkBox($model,'vd53',array('class'=>'span1 checkBoxDetail'))."VD 5-3 Ranking Liabilities";?><br/>
		<?php echo $form->checkBox($model,'vd54',array('class'=>'span1 checkBoxDetail'))."VD 5-4 Reksadana";?><br/>
		<?php echo $form->checkBox($model,'vd55',array('class'=>'span1 checkBoxDetail'))."VD 5-5 Lindung Nilai";?><br/>
		<?php echo $form->checkBox($model,'vd56',array('class'=>'span1 checkBoxDetail'))."VD 5-6 Pembantu Dana";?><br/>
		<?php echo $form->checkBox($model,'vd57',array('class'=>'span1 checkBoxDetail'))."VD 5-7 Pembantu Efek";?><br/>
		<?php echo $form->checkBox($model,'vd58',array('class'=>'span1 checkBoxDetail'))."VD 5-8 MKBD diwajibkan";?><br/>
		<?php echo $form->checkBox($model,'vd59',array('class'=>'span1 checkBoxDetail'))."VD 5-9 MKBD";?><br/>
		<?php echo $form->checkBox($model,'vd51_9',array('class'=>'span1 checkBoxDetail','id'=>'checkBoxDetailAll','onclick'=>'changeAll()'))."All VD 5.1-5.9/clear all";?><br/>
		<?php echo $form->checkBox($model,'both',array('class'=>'span1 both','onclick'=>'checkAll()'))."All VD 5.1-10/clear All";?><br/>
		</div>
	<div class="span4">
		
		<?php echo $form->checkBox($model,'vd510a',array('class'=>'span1 checkBoxDetail2'))."VD 5-10 A Repo";?><br/>
		<?php echo $form->checkBox($model,'vd510b',array('class'=>'span1 checkBoxDetail2'))."VD 5-10 B Reverse Repo";?><br/>
		<?php echo $form->checkBox($model,'vd510c',array('class'=>'span1 checkBoxDetail2'))."VD 5-10 C Portofolio";?><br/>
		<?php echo $form->checkBox($model,'vd510d',array('class'=>'span1 checkBoxDetail2'))."VD 5-10 D Margin";?><br/>
		<?php echo $form->checkBox($model,'vd510e',array('class'=>'span1 checkBoxDetail2'))."VD 5-10 E Jaminan Margin";?><br/>
		<?php echo $form->checkBox($model,'vd510f',array('class'=>'span1 checkBoxDetail2'))."VD 5-10 F Penjaminan Emisi Efek";?><br/>
		<?php echo $form->checkBox($model,'vd510g',array('class'=>'span1 checkBoxDetail2'))."VD 5-10 G Penjaminan oleh perusahaan";?><br/>
		<?php echo $form->checkBox($model,'vd510h',array('class'=>'span1 checkBoxDetail2'))."VD 5-10 H Komitmen belanja modal";?><br/>
		<?php echo $form->checkBox($model,'vd510i',array('class'=>'span1 checkBoxDetail2'))."VD 5-10 I Transaksi dlm mata uang asing";?><br/>
		<?php echo $form->checkBox($model,'vd510a_i',array('class'=>'span1 checkBoxDetail2','id'=>'checkBoxVD510','onclick'=>'checkAllVD10()'))."All VD 5-10/clear all";?><br/>
		</div>
	<div class="span2">
		
			
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			// 'loadingText'=>'loading...',
			'htmlOptions'=>array('id'=>'btnPrintReport','style'=>'margin-left:-9em;','class'=>'btn btn-primary'),
			'label'=>'Print Report',
		)); ?>
	
	</div>
</div>




<div class="row-fluid" id="header_report">
	<div class="span10">
<h4><?php // echo $label_header ;?></h4>		
	</div>
	<div class="span2" >

		
<?php 
 $this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'myModal')
); ?>
 
    <div class="modal-header text-center">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Print MKBD Report</h4>
    </div>
 
    <div class="modal-body">
       <?php $this->renderPartial('_printall',array(
		'model'=>$model,
		'form'=>$form,
		'urlvd51'=>$urlvd51,
		'urlvd52'=>$urlvd52,
		'urlvd53'=>$urlvd53,
		'urlvd54'=>$urlvd54,
		'urlvd55'=>$urlvd55,
		'urlvd56'=>$urlvd56,
		'urlvd57'=>$urlvd57,
		'urlvd58'=>$urlvd58,
		'urlvd59'=>$urlvd59,
		'urlvd510a'=>$urlvd510a,
		'urlvd510b'=>$urlvd510b,
		'urlvd510c'=>$urlvd510c,
		'urlvd510d'=>$urlvd510d,
		'urlvd510e'=>$urlvd510e,
		'urlvd510f'=>$urlvd510f,
		'urlvd510g'=>$urlvd510g,
		'urlvd510h'=>$urlvd510h,
		'urlvd510i'=>$urlvd510i,
		)); ?>
    </div>
 
    <div class="modal-footer">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            array(
            'buttonType'=>'submit',
                'type' => 'primary',
                'label' => 'Print Report',
                // 'url'=> $this->createUrl('index'),
               'htmlOptions' => array('id'=>'btnPrint','class'=>'btn btn-primary btn-small'),
                // 'htmlOptions' => array('data-dismiss' => 'modal','class'=>'btn btn-small'),
            )
        ); ?>
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'label' => 'Close',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal', 'class'=>'btn btn-small'),
            )
        ); ?>
    </div>
 
<?php $this->endWidget(); ?>
<?php 
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'label' => 'Print All Report',
        'type' => 'primary',
        'htmlOptions' => array(
        	'class'=>'btn btn-small',
            'data-toggle' => 'modal',
            'data-target' => '#myModal',
            'style'=>'margin-left:1em;'
        ),
    )
);

?>


	</div>
</div>


<div role="tabpanel" >

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" >
    <li id ="vd51_h"role="presentation" class="active" ><a href="#vd51_d" aria-controls="vd51_d" role="tab" data-toggle="tab">VD 5-1</a></li>
    <li id ="vd52_h" role="presentation"><a href="#vd52_d" aria-controls="vd52_d" role="tab" data-toggle="tab">VD 5-2</a></li>
    <li id ="vd53_h" role="presentation"><a href="#vd53_d" aria-controls="vd53_d" role="tab" data-toggle="tab">VD 5-3</a></li>
    <li id ="vd54_h" role="presentation"><a href="#vd54_d" aria-controls="vd54_d" role="tab" data-toggle="tab">VD 5-4</a></li>
    <li id ="vd55_h" role="presentation"><a href="#vd55_d" aria-controls="vd55_d" role="tab" data-toggle="tab">VD 5-5</a></li>
    <li id ="vd56_h" role="presentation"><a href="#vd56_d" aria-controls="vd56_d" role="tab" data-toggle="tab">VD 5-6</a></li>
    <li id ="vd57_h" role="presentation"><a href="#vd57_d" aria-controls="vd57_d" role="tab" data-toggle="tab">VD 5-7</a></li>
    <li id ="vd58_h" role="presentation"><a href="#vd58_d" aria-controls="vd58_d" role="tab" data-toggle="tab">VD 5-8</a></li>
    <li id ="vd59_h" role="presentation"><a href="#vd59_d" aria-controls="vd59_d" role="tab" data-toggle="tab">VD 5-9</a></li>
    
 	<li id ="vd510a_h" role="presentation"><a href="#vd510a_d" aria-controls="vd510a_d" role="tab" data-toggle="tab">VD 5-10 A</a></li>
 	<li id ="vd510b_h" role="presentation"><a href="#vd510b_d" aria-controls="vd510b_d" role="tab" data-toggle="tab">VD 5-10 B</a></li>
 	<li id ="vd510c_h" role="presentation"><a href="#vd510c_d" aria-controls="vd510c_d" role="tab" data-toggle="tab">VD 5-10 C</a></li>
 	<li id ="vd510d_h" role="presentation"><a href="#vd510d_d" aria-controls="vd510d_d" role="tab" data-toggle="tab">VD 5-10 D</a></li>
 	<li id ="vd510e_h" role="presentation"><a href="#vd510e_d" aria-controls="vd510e_d" role="tab" data-toggle="tab">VD 5-10 E</a></li>
 	<li id ="vd510f_h" role="presentation"><a href="#vd510f_d" aria-controls="vd510f_d" role="tab" data-toggle="tab">VD 5-10 F</a></li>
 	<li id ="vd510g_h" role="presentation"><a href="#vd510g_d" aria-controls="vd510g_d" role="tab" data-toggle="tab">VD 5-10 G</a></li>
 	<li id ="vd510h_h" role="presentation"><a href="#vd510h_d" aria-controls="vd510h_d" role="tab" data-toggle="tab">VD 5-10 H</a></li>
 	<li id ="vd510i_h" role="presentation"><a href="#vd510i_d" aria-controls="vd510i_d" role="tab" data-toggle="tab">VD 5-10 I</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="vd51_d">
    	<a href="<?php echo $urlvd51.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd51.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'; ?>" class="span12" id="reportvd51" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd52_d">
    	<a href="<?php echo $urlvd52.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd52.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd52" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
	<div role="tabpanel" class="tab-pane" id="vd53_d">
		<a href="<?php echo $urlvd53.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd53.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd53" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
	<div role="tabpanel" class="tab-pane" id="vd54_d">
		<a href="<?php echo $urlvd54.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd54.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd54" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd55_d">
    	<a href="<?php echo $urlvd55.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd55.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd55" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd56_d">
    	<a href="<?php echo $urlvd56.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd56.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd56" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd57_d">
    	<a href="<?php echo $urlvd57.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd57.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd57" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd58_d">
    	<a href="<?php echo $urlvd58.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd58.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd58" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd59_d">
    	<a href="<?php echo $urlvd59.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd59.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd59" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    
    <!--Kolom 2-->

	<div role="tabpanel" class="tab-pane" id="vd510a_d">
		<a href="<?php echo $urlvd510a.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd510a.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd510a" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
	<div role="tabpanel" class="tab-pane" id="vd510b_d">
		<a href="<?php echo $urlvd510b.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd510b.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd510b" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd510c_d">
    	<a href="<?php echo $urlvd510c.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd510c.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd510c" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd510d_d">
    	<a href="<?php echo $urlvd510d.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd510d.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd510d" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd510e_d">
    	<a href="<?php echo $urlvd510e.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd510e.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd510e" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd510f_d">
    	<a href="<?php echo $urlvd510f.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd510f.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd510f" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd510g_d">
    	<a href="<?php echo $urlvd510g.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd510g.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd510g" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd510h_d">
    	<a href="<?php echo $urlvd510h.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd510h.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd510h" style="min-height:600px;max-width: 100%;"></iframe>
    </div>
    <div role="tabpanel" class="tab-pane" id="vd510i_d">
    	<a href="<?php echo $urlvd510i.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false'; ?>"  class="btn btn-small btn-primary">Export to Excel</a>
    	<br /><br />
    	<iframe src="<?php echo $urlvd510i.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';  ?>" class="span12" id="reportvd510i" style="min-height:600px;max-width: 100%;"></iframe>
    </div>

  </div>

</div><!--End tab panel-->


<?php $this->endWidget(); ?>


<script>
	
	var urlprint = '<?php echo $urlprint?>';

	
	
	if(urlprint !='')
	{
	var print = window.open('<?php echo $urlprint;?>','_blank');
	print.document.title='Print MKBD Report';	
	}
	
	$('#header_report').hide();
	
	
	if($('#reportvd51').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		//$('#reportvd51').hide();
		$('#vd51_h').hide();
		$('#vd51_d').hide();
		
	}
	else{
		$('#header_report').show();
		$('#reportvd51').show();
		$('#vd51_h').show();
		
	}
	if($('#reportvd52').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd52').hide();
		$('#vd52_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd52').show();
		$('#vd52_h').show();
	}
	if($('#reportvd53').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd53').hide();
		$('#vd53_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd53').show();
		$('#vd53_h').show();
	}
	if($('#reportvd54').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd54').hide();
		$('#vd54_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd54').show();
		$('#vd54_h').show();
	}
	if($('#reportvd55').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd55').hide();
		$('#vd55_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd55').show();
		$('#vd55_h').show();
	}
	if($('#reportvd56').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd56').hide();
		$('#vd56_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd56').show();
		$('#vd56_h').show();
	}
	if($('#reportvd57').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd57').hide();
		$('#vd57_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd57').show();
		$('#vd57_h').show();
	}
	if($('#reportvd58').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd58').hide();
		$('#vd58_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd58').show();
		$('#vd58_h').show();
	}
	if($('#reportvd59').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd59').hide();
		$('#vd59_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd59').show();
		$('#vd59_h').show();
	}
	if($('#reportvd510a').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd510a').hide();
		$('#vd510a_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd510a').show();
		$('#vd510a_h').show();
	}
	if($('#reportvd510b').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd510b').hide();
		$('#vd510b_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd510b').show();
		$('#vd510b_h').show();
	}
	if($('#reportvd510c').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd510c').hide();
		$('#vd510c_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd510c').show();
		$('#vd510c_h').show();
	}
	if($('#reportvd510d').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd510d').hide();
		$('#vd510d_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd510d').show();
		$('#vd510d_h').show();
	}
	if($('#reportvd510e').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd510e').hide();
		$('#vd510e_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd510e').show();
		$('#vd510e_h').show();
	}
	if($('#reportvd510f').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd510f').hide();
		$('#vd510f_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd510f').show();
		$('#vd510f_h').show();
	}
	if($('#reportvd510g').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd510g').hide();
		$('#vd510g_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd510g').show();
		$('#vd510g_h').show();
	}
	if($('#reportvd510h').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd510h').hide();
		$('#vd510h_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd510h').show();
		$('#vd510h_h').show();
	}
	if($('#reportvd510i').attr('src') =='&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'){
		$('#reportvd510i').hide();
		$('#vd510i_h').hide();
	}
	else{
		$('#header_report').show();
		$('#reportvd510i').show();
		$('#vd510i_h').show();
	}
	

	$('#dialog-confirm').hide();


	function changeAll()
	{
		if($("#checkBoxDetailAll").is(':checked'))
		{
			$(".checkBoxDetail").prop('checked',true);
		}
		else
		{
			$(".checkBoxDetail").prop('checked',false);
		}
		 checkboth();
	}
	function checkAllVD10(){
		if($("#checkBoxVD510").is(':checked'))
		{	$('#Rptmkbdreport_both').prop('checked',false);
			$(".checkBoxDetail2").prop('checked',true);
		}
		else
		{
			$('#Rptmkbdreport_both').prop('checked',false);
			$(".checkBoxDetail2").prop('checked',false);
		}
		 checkboth();
	}
	
	function checkAll(){
		if($("#Rptmkbdreport_both").is(':checked'))
		{
			$(".checkBoxDetail").prop('checked',true);
			$(".checkBoxDetail2").prop('checked',true);
		}
		else
		{
			$(".checkBoxDetail").prop('checked',false);
			$(".checkBoxDetail2").prop('checked',false);
		}
	}
	

function checkboth(){
	if($('#checkBoxVD510').is(':checked') && $('#checkBoxDetailAll').is(':checked')){
		$('#Rptmkbdreport_both').prop('checked',true);
	}
	else{
		$('#Rptmkbdreport_both').prop('checked',false);
	}
}

$('.checkBoxDetail,.checkBoxDetail2,.both').change(function(){
		if($('.checkBoxDetail,.checkBoxDetail2,.both').is(':checked'))
	{
		//$('#btnGenerate').prop('disabled',false);
		$('#btnPrintReport').prop('disabled',false);
		$('#btnPrint_E').prop('disabled',false);
	}
	else{
		//$('#btnGenerate').prop('disabled',true);
		$('#btnPrintReport').prop('disabled',true);
		$('#btnPrint_E').prop('disabled',true);
	}
})


$('#btnPrintReport').click(function(){
	$('#scenario').val('selected');
})
$('#btnPrint').click(function(){
	$('#scenario').val('all');
})



</script>
