<?php
$this->breadcrumbs=array(
	'Corporate Action Journal'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Corporate Action Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tstkmovementall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);
?>
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tcorpact-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br/>

<input type="hidden" name="scenario" id="scenario"  />
<input type="hidden" name="at_journal" id="at_journal"/>
<?php 
$label= $ca_type =='SPLIT' || $ca_type =='REVERSE'?'Create X Date Journal':'Create Cum Date Journal';//'Create Cum Date/X Date Journal';
$label2 = 'Create Distribution Date Journal';
	
?>
<?php echo $form->errorSummary(array($model)); ?>
<div class="row-fluid control-group">
	<div class="span2">
		<?php echo "Stock &emsp; ".$form->textField($model,'stk_cd',array('class'=>'span6','readonly'=>$ca_type=='RIGHT'||$ca_type == 'WARRANT'?FALSE:FALSE));?>
	</div>
	<div class="span7" style="margin-left: -15px">
		<?php echo "Journal Description &emsp; ".$form->textField($model,'remarks',array('class'=>'span7','readonly'=>$ca_type=='RIGHT'||$ca_type == 'WARRANT'?FALSE:FALSE,'required'=>TRUE));?>
	</div>	
	<div class="span2" style="margin-left: -30px">
	<?php echo $form->textField($model,'today_dt',array('class'=>'span7','style'=>'display:none;'));?>
	</div>
</div>
<div class="row-fluid control-group">
	<div class="span4">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
							'id'=>'btnJournal_Cum_dt',
							'buttonType'=>'submit',
							'type'=>'primary',
							'htmlOptions'=>array('style'=>'margin-left:0em;','class'=>'btn btn-small btn-primary'),
							'label'=> $label)); ?>
	</div>
	<div class="span4">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
							'id'=>'btnJournal_Ditrib_dt',
							'buttonType'=>'submit',
							'type'=>'primary',
							'htmlOptions'=>array('style'=>'margin-left:0em;','class'=>'btn btn-small btn-primary'),
							'label'=> $label2)); ?>
	</div>
</div>

<br/>


<iframe src= "<?php echo $url.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false'; ?>" class="span12" style="min-height:600px;max-width: 100% ;"></iframe>
<?php $this->endWidget();?>

<script>
	
	var ca_type = '<?php echo $ca_type ;?>';
	var from_qty = '<?php echo $from_qty ;?>';
	var to_qty = '<?php echo $to_qty ;?>';
	var cek_pape = '<?php echo $cek_pape?>';
	init();
	function init()
	{
		if( ca_type == 'RIGHT' || ca_type =='WARRANT'){
			var remarks = 'HMETD  '+from_qty+ ' : '+to_qty;
			$('#Rptcorpactjournal_remarks').val(remarks);
		}
		else if(ca_type == 'STKDIV'){
			var remarks = 'DIVIDEN '+from_qty+ ' : '+to_qty;
			$('#Rptcorpactjournal_remarks').val(remarks);
		}
		else
		{
			var remarks = ca_type+' '+from_qty+ ' : '+to_qty;
			$('#Rptcorpactjournal_remarks').val(remarks);
		}
		
		$('#Rptcorpactjournal_remarks').change(function(){
				$('#Rptcorpactjournal_remarks').val($('#Rptcorpactjournal_remarks').val().toUpperCase());
		})
		
	}
	
	$('#btnJournal_Cum_dt').click(function(){
		
		if(ca_type == 'SPLIT' || ca_type == 'REVERSE')
		{	
			$('#at_journal').val('X');
		}
		else
		{
			$('#at_journal').val('C');
		}
		
	});
	
	$('#btnJournal_Ditrib_dt').click(function(){
		$('#at_journal').val('D');
	});
	$('#Rptcorpactjournal_today_dt').change(function(){
		cek_jurnal();
	});
	
	 cek_jurnal();
	function cek_jurnal(){
		
		$('#btnJournal_Ditrib_dt').prop('disabled',true);
		$('#btnJournal_Cum_dt').prop('disabled',true);
		
		var jur_cumdt = '<?php echo $jurnal_cumdt ?>';
		var jur_distribdt = '<?php echo $jurnal_distribdt ?>';
		var distrib_dt_journal = '<?php echo $distrib_dt_journal;?>';
		var cum_dt = '<?php echo $cum_dt;?>';
			 cum_dt = cum_dt.split('-');
			cum_dt = cum_dt[0]+cum_dt[1]+cum_dt[2];
		var distrib_dt = '<?php echo $distrib_dt;?>';
			distrib_dt = distrib_dt.split('-');
			distrib_dt = distrib_dt[0]+distrib_dt[1]+distrib_dt[2];
		var distrib_dt_bursa = '<?php echo $distrib_dt_bursa;?>';
			distrib_dt_bursa = distrib_dt_bursa.split('-');
			distrib_dt_bursa = distrib_dt_bursa[0]+distrib_dt_bursa[1]+distrib_dt_bursa[2];
		var recording_dt_bursa = '<?php echo $recording_dt_bursa;?>';
			recording_dt_bursa = recording_dt_bursa.split('-');
			recording_dt_bursa = recording_dt_bursa[0]+recording_dt_bursa[1]+recording_dt_bursa[2];
		var recording_dt  = '<?php echo $recording_dt?>';
			recording_dt  = recording_dt.split('-');
			recording_dt = recording_dt[0]+recording_dt[1]+recording_dt[2];
		var date = $('#Rptcorpactjournal_today_dt').val();
			date = date.split('-');
			date = date[0]+date[1]+date[2];
			
		if(jur_cumdt == 'Y'){
			$('#btnJournal_Cum_dt').prop('disabled',true);
		}
		if(jur_distribdt == 'Y'){
			
			$('#btnJournal_Ditrib_dt').prop('disabled',true);
		}	
			
		if(cek_pape=='Y')
		{
			
		
			
		 if(jur_cumdt =='N' && date < distrib_dt)
		{
	
			var label = ca_type=='REVERSE'|| ca_type =='SPLIT'?'Create X Date Journal':'Create Cum Date Journal';
			
			$('#btnJournal_Cum_dt').html(label);
						
			$('#btnJournal_Cum_dt').prop('disabled',false);	
			$('#btnJournal_Ditrib_dt').prop('disabled',true);
		}
		else if(jur_cumdt =='N' && date >= distrib_dt)
		{		//alert('test123');
			var label = ca_type=='REVERSE'|| ca_type =='SPLIT'?'Create X Date Journal':'Create Cum Date Journal';
			
			$('#btnJournal_Cum_dt').html(label);
			$('#btnJournal_Cum_dt').prop('disabled',true);
			$('#btnJournal_Ditrib_dt').prop('disabled',true);
		}
		else if(jur_cumdt =='Y' && date < recording_dt)
		{
			var label = ca_type=='REVERSE'|| ca_type =='SPLIT'?'Create X Date Journal':'Create Cum Date Journal';
			
			$('#btnJournal_Cum_dt').html(label);
			$('#btnJournal_Cum_dt').prop('disabled',true);
			$('#btnJournal_Ditrib_dt').prop('disabled',true);
		}
		else if(jur_cumdt =='Y' && date<recording_dt && distrib_dt == recording_dt_bursa)
		{
			$('#btnJournal_Ditrib_dt').html('Create Distribution Date Journal');
			$('#btnJournal_Ditrib_dt').prop('disabled',false);
			$('#btnJournal_Cum_dt').prop('disabled',true);
		}
		else if(jur_cumdt =='Y' && date == distrib_dt && jur_distribdt !='Y'){
		
			$('#btnJournal_Ditrib_dt').html('Create Distribution Date Journal');
			$('#btnJournal_Ditrib_dt').prop('disabled',false);
			$('#btnJournal_Cum_dt').prop('disabled',true);
		}
		else if(jur_cumdt =='Y' && date == recording_dt && distrib_dt > recording_dt_bursa )
		{	//test
			//alert('test')
			$('#btnJournal_Ditrib_dt').html('Create Distribution Date Journal');
			$('#btnJournal_Ditrib_dt').prop('disabled',true);
			$('#btnJournal_Cum_dt').prop('disabled',true);
		}
		else if(jur_cumdt =='Y' && date == distrib_dt_bursa && jur_distribdt !='Y')
		{
			$('#btnJournal_Ditrib_dt').html('Create Distribution Date Journal');
			$('#btnJournal_Ditrib_dt').prop('disabled',false);
			$('#btnJournal_Cum_dt').prop('disabled',true);
		}
		else if(jur_cumdt =='Y'  && date == distrib_dt && jur_distribdt !='Y')
		{
			$('#btnJournal_Ditrib_dt').html('Create Distribution Date Journal');
			$('#btnJournal_Ditrib_dt').prop('disabled',false);
			$('#btnJournal_Cum_dt').prop('disabled',true);
		}
		
		else if(jur_distribdt =='Y')
		{ 
			$('#btnJournal_Ditrib_dt').html('Create Distribution Date Journal');
			$('#btnJournal_Ditrib_dt').prop('disabled',true);
			$('#btnJournal_Cum_dt').prop('disabled',true);
		}
		else if(cum_dt > date)
		{
			$('#btnJournal_Ditrib_dt').prop('disabled',true);
			$('#btnJournal_Cum_dt').prop('disabled',true);
		}
		 //alert(distrib_dt)
		if(ca_type =='WARRANT' && jur_cumdt=='Y' && date==distrib_dt && jur_distribdt !='Y')
		{
			$('#btnJournal_Ditrib_dt').html('Create Distribution Date Journal');
			$('#btnJournal_Ditrib_dt').prop('disabled',false);
			$('#btnJournal_Cum_dt').prop('disabled',true);
		}
		
	}
	else//pape N
	{
		//alert(distrib_dt_journal);
		if(jur_distribdt =='N' && distrib_dt_journal =='N' && date==distrib_dt ){
			
			$('#btnJournal_Ditrib_dt').prop('disabled',false);
			$('#btnJournal_Cum_dt').prop('disabled',true);
		}
		else{
			$('#btnJournal_Ditrib_dt').prop('disabled',true);
			$('#btnJournal_Cum_dt').prop('disabled',true);
		}
		
	}
		
		
	}
	
	
</script>
