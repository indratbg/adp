<style>
		#printAll > label
	{
		width:200px;
		margin-left:-12px;
	}
	
	#printAll > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:10px;
		font-weight: bold;
		font-size: 11pt;
	}
	
	#printAll > label > input
	{
		float:left;
	}
</style>
<div class="row-fluid cek_status">
	<div class="span12">
		<?php //echo $form->radioButtonListInlineRow($model,'print_stat_a',array('0'=>'Approved','1'=>'Belum Diapprove'),array('id'=>'printAll','label'=>true));?>
	
		
	</div>
</div>

<div class="row-fluid">
	<div class="span5">
		<?php echo $form->checkBox($model,'r_1',array('class'=>'span1 kolom1 ','checked'=>$urlvd51?TRUE:FALSE))." &emsp; VD 5-1 Asset";?><br/>
		<?php echo $form->checkBox($model,'r_2',array('class'=>'span1 kolom1','checked'=>$urlvd52?TRUE:FALSE))." &emsp; VD 	5-2 Liabilities + Ekuitas";?><br/>
		<?php echo $form->checkBox($model,'r_3',array('class'=>'span1 kolom1','checked'=>$urlvd53?TRUE:FALSE))." &emsp; VD 5-3 Ranking Liabilities";?><br/>
		<?php echo $form->checkBox($model,'r_4',array('class'=>'span1 kolom1','checked'=>$urlvd54?TRUE:FALSE))." &emsp; VD 5-4 Reksadana";?><br/>
		<?php echo $form->checkBox($model,'r_5',array('class'=>'span1 kolom1','checked'=>$urlvd55?TRUE:FALSE))." &emsp; VD 5-5 Lindung Nilai";?><br/>
		<?php echo $form->checkBox($model,'r_6',array('class'=>'span1 kolom1','checked'=>$urlvd56?TRUE:FALSE))." &emsp; VD 5-6 Pembantu Dana";?><br/>
		<?php echo $form->checkBox($model,'r_7',array('class'=>'span1 kolom1','checked'=>$urlvd57?TRUE:FALSE))." &emsp; VD 5-7 Pembantu Efek";?><br/>
		<?php echo $form->checkBox($model,'r_8',array('class'=>'span1 kolom1','checked'=>$urlvd58?TRUE:FALSE))." &emsp; VD 5-8 MKBD diwajibkan";?><br/>
		<?php echo $form->checkBox($model,'r_9',array('class'=>'span1 kolom1','checked'=>$urlvd59?TRUE:FALSE))." &emsp; VD 5-9 MKBD";?><br/>
		<?php echo $form->checkBox($model,'all_r_1_9',array('class'=>'span1 kolom11','checked'=>TRUE))." &emsp; All VD 5.1-5.9/clear all";?><br/>
		<?php  echo $form->checkBox($model,'all_r',array('class'=>'span1 allCheck','checked'=>TRUE))." &emsp; All VD 5.1-10/clear All";?><br/>
		
		</div>
	<div class="span7">
		
		<?php echo $form->checkBox($model,'r_a',array('class'=>'span1 kolom2','checked'=>$urlvd510a?TRUE:FALSE))." &emsp; VD 5-10 A Repo";?><br/>
		<?php echo $form->checkBox($model,'r_b',array('class'=>'span1 kolom2','checked'=>$urlvd510b?TRUE:FALSE))." &emsp; VD 5-10 B Reverse Repo";?><br/>
		<?php echo $form->checkBox($model,'r_c',array('class'=>'span1 kolom2','checked'=>$urlvd510c?TRUE:FALSE))." &emsp; VD 5-10 C Portofolio";?><br/>
		<?php echo $form->checkBox($model,'r_d',array('class'=>'span1 kolom2','checked'=>$urlvd510d?TRUE:FALSE))." &emsp; VD 5-10 D Margin";?><br/>
		<?php echo $form->checkBox($model,'r_e',array('class'=>'span1 kolom2','checked'=>$urlvd510e?TRUE:FALSE))." &emsp; VD 5-10 E Jaminan Margin";?><br/>
		<?php echo $form->checkBox($model,'r_f',array('class'=>'span1 kolom2','checked'=>$urlvd510f?TRUE:FALSE))." &emsp; VD 5-10 F Penjaminan Emisi Efek";?><br/>
		<?php echo $form->checkBox($model,'r_g',array('class'=>'span1 kolom2','checked'=>$urlvd510g?TRUE:FALSE))." &emsp; VD 5-10 G Penjaminan oleh perusahaan";?><br/>
		<?php echo $form->checkBox($model,'r_h',array('class'=>'span1 kolom2','checked'=>$urlvd510h?TRUE:FALSE))." &emsp; VD 5-10 H Komitmen belanja modal";?><br/>
		<?php echo $form->checkBox($model,'r_i',array('class'=>'span1 kolom2','checked'=>$urlvd510i?TRUE:FALSE))." &emsp;VD 5-10 I Transaksi dlm mata uang asing";?><br/>
		<?php echo $form->checkBox($model,'all_r_a_i',array('class'=>'span1 kolom22'))." &emsp; All VD 5-10/clear all";?><br/>
		</div>
</div>


<script>
$('#Rptmkbdreport_all_r').change(function(){
		check_All()
});
$('#Rptmkbdreport_all_r_1_9').change(function(){
	check_kolom1();
})
$('#Rptmkbdreport_all_r_a_i').change(function(){
	check_kolom2();
})

$('.cek_status').hide();
function check_All(){
		if($("#Rptmkbdreport_all_r").is(':checked'))
		{
			$(".kolom1").prop('checked',true);
			$(".kolom2").prop('checked',true);
			$(".kolom22").prop('checked',true);
			$(".kolom11").prop('checked',true);
		}
		else
		{
			$(".kolom1").prop('checked',false);
			$(".kolom2").prop('checked',false);
			$(".kolom22").prop('checked',false);
			$(".kolom11").prop('checked',false);
		}
}
function check_kolom1(){
		if($("#Rptmkbdreport_all_r_1_9").is(':checked'))
		{
			$(".kolom1").prop('checked',true);
			$('.allCheck').prop('checked',false);
		}
		else
		{
			$(".kolom1").prop('checked',false);
			$('.allCheck').prop('checked',false);
		}
}
function check_kolom2(){
		if($("#Rptmkbdreport_all_r_a_i").is(':checked'))
		{
			$(".kolom2").prop('checked',true);
			$('.allCheck').prop('checked',false);
		}
		else
		{
			$(".kolom2").prop('checked',false);
			$('.allCheck').prop('checked',false);
		}
}


$(document).ready(function(){
	$('#Rptmkbdreport_all_r_a_i').prop('checked',true);
	$('#Rptmkbdreport_all_r_1_9').prop('checked',true);
	$('#Rptmkbdreport_all_r').prop('checked',false)
	$('.span1.kolom2').each(function(){	
		if(!$(this).is(':checked'))
		{
		$('#Rptmkbdreport_all_r_a_i').prop('checked',false);
		}
	
	});
	$('.span1.kolom1').each(function(){	
		if(!$(this).is(':checked'))
		{
		$('#Rptmkbdreport_all_r_1_9').prop('checked',false);
		}
	
	});
	
	if($('#Rptmkbdreport_all_r_a_i').is(':checked') && $('#Rptmkbdreport_all_r_1_9').is(':checked')){
		$('#Rptmkbdreport_all_r').prop('checked',true)
	}
	
	
})

	
</script>

