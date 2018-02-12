<table id="tablePembukaan" class="tableDetailList table-bordered table-condensed">
	<thead>
		<tr>
			<th class="first" rowspan="2" width="8%">Client Cd</th>
			<th class="first" rowspan="2" width="34%">Client Name</th>
			<th class="first" rowspan="2" width="2%">Type</th>
			<th class="first" width="2%" style="text-align:center">
				<input id="checkAll001" type="checkbox" checked />
			</th>
			<th class="first" colspan="2" style="text-align:center">=====Sub Rekening Efek=====</th>
			<th class="first" width="2%" style="text-align:center">
				<input id="checkAll004" type="checkbox" />
			</th>
			<th class="first" width="2%" style="text-align:center">
				<input id="checkAll005" type="checkbox" />
			</th>
			<th class="first" rowspan="2" width="2%">
				<a title="add" onclick="addRowPembukaan()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
		<tr>
			<th class="second" width="1%">001</th>
			<th class="second" width="5%"></th>
			<th class="second" width="15%">4 Digit</th>
			<th class="second" width="1%">004</th>
			<th class="second" width="1%">005</th>
		</tr>
	</thead>
	<tbody>
		<?php $x=1;
			foreach($modelPembukaan as $row){ ?>
		<tr>
			<td class="clientCd">
				<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Pembukaan['.$x.'][client_cd]','readonly'=>'readonly')) ?>
			</td>
			<td class="clientName">
				<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'Pembukaan['.$x.'][client_name]','readonly'=>'readonly')) ?>
			</td>
			<td class="clientType">
				<?php echo $form->textField($row,'client_type_1',array('class'=>'span','name'=>'Pembukaan['.$x.'][client_type_1]','readonly'=>'readonly')) ?>
			</td>
			<td class="001">
				<?php echo $form->checkBox($row,'flg',array('class'=>'span check001','name'=>'Pembukaan['.$x.'][flg]','value'=>'Y','uncheckValue'=>'N')) ?>
			</td>
			<td class="abCode">
				<?php echo $row->ab_code ?>
			</td>
			<td class="subrekCd">
				<?php echo $form->textField($row,'subrek_cd',array('class'=>'span6','name'=>'Pembukaan['.$x.'][subrek_cd]','maxlength'=>4)) ?>
				&nbsp;
				<?php echo $row->subrek_type ?>
				&emsp;
				<?php echo $row->subrek_suffix ?>
			</td>
			<td class="004">
				<?php echo $form->checkBox($row,'flg_004',array('class'=>'span check004','name'=>'Pembukaan['.$x.'][flg_004]','value'=>'Y','uncheckValue'=>'N')) ?>
			</td>
			<td class="005">
				<?php echo $form->checkBox($row,'flg_005',array('class'=>'span check005','name'=>'Pembukaan['.$x.'][flg_005]','value'=>'Y','uncheckValue'=>'N')) ?>
			</td>
			<td>
			</td>
		</tr>

		<?php 
				$x++;
			}
		?>
	</tbody>
</table>

<script>
	var pembukaanCount = <?php echo count($modelPembukaan) ?>;
	var result = {};
	
	$("#checkAll001").click(function()
	{
		if($(this).is(":checked"))
		{
			$(".check001").prop('checked',true);
		}
		else
		{
			$(".check001").prop('checked',false);
		}
	});
	
	$("#checkAll004").click(function()
	{
		if($(this).is(":checked"))
		{
			$(".check004").prop('checked',true);
		}
		else
		{
			$(".check004").prop('checked',false);
		}
	});
	
	$("#checkAll005").click(function()
	{
		if($(this).is(":checked"))
		{
			$(".check005").prop('checked',true);
		}
		else
		{
			$(".check005").prop('checked',false);
		}
	});

	function alignColumnPembukaan()//align columns in thead and tbody
	{		
		var table = $("#tablePembukaan");
		var header = table.children('thead');
		var firstRow = table.children('tbody').children('tr:first');
		
		firstRow.find('td:eq(0)').css('width',header.find('th.first:eq(0)').width()+'px');
		firstRow.find('td:eq(1)').css('width',header.find('th.first:eq(1)').width()+'px');
		firstRow.find('td:eq(2)').css('width',header.find('th.first:eq(2)').width()+'px');
		firstRow.find('td:eq(3)').css('width',header.find('th.first:eq(3)').width()+'px');
		firstRow.find('td:eq(4)').css('width',header.find('th.second:eq(1)').width()+'px');
		firstRow.find('td:eq(5)').css('width',header.find('th.second:eq(2)').width()+'px');
		firstRow.find('td:eq(6)').css('width',header.find('th.second:eq(3)').width()+'px');
		firstRow.find('td:eq(7)').css('width',header.find('th.second:eq(4)').width()+'px');
		firstRow.find('td:eq(8)').css('width',header.find('th.first:eq(7)').width()+'px');
	}
	
	function addRowPembukaan()
	{
		$("#tablePembukaan").find('tbody')
    		.append($('<tr>')
    			.attr('id','row'+(pembukaanCount+1))
    			.append($('<td>')
    				 .attr('class','clientCd')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Pembukaan['+(pembukaanCount+1)+'][client_cd]')
               		 	.attr('type','text')
               		 	.autocomplete(
	         			{
	         				source: function (request, response) 
	         				{
						        $.ajax({
						        	'type'		: 'POST',
						        	'url'		: '<?php echo $this->createUrl('getClientDetail'); ?>',
						        	'dataType' 	: 'json',
						        	'data'		:	{
						        						'term': request.term,
						        					},
						        	'success'	: 	function (data) 
						        					{
								           				 response(data);
								           				 result = data;
								    				}
								});
						    },
						    change: function(event,ui)
					        {
					        	
					        },
						    minLength: 0,
							open: function()
							{
				        		$(this).autocomplete("widget").width(500); 
							},
	         			})
	         			.focus(function(){     
				            $(this).data("autocomplete").search($(this).val());
				        })
				        .blur(function()
				        {
				        	$(this).val($(this).val().toUpperCase());
				        	var inputVal = $(this).val();
				        	var name = '';
				        	var type = '';
				        	var abCode = '';
				        		
				        	$.each(result,function()
				        	{
				        		if(this.value.toUpperCase() == inputVal)
				        		{
				        			name = this.name;
				        			type = this.type;
				        			abCode = this.abCode;
				        		}
				        	});
				        	
				        	$(this).closest('td').siblings('.clientName').children('input').val(name);
				        	$(this).closest('td').siblings('.clientType').children('input').val(type);
				        	$(this).closest('td').siblings('.abCode').html(abCode);
				        })
               		)
               	).append($('<td>')
               		 .attr('class','clientName')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Pembukaan['+(pembukaanCount+1)+'][client_name]')
               		 	.attr('type','text')
               		 	.attr('readonly',true)
               		)
               	).append($('<td>')
               		 .attr('class','clientType')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Pembukaan['+(pembukaanCount+1)+'][client_type]')
               		 	.attr('type','text')
               		 	.attr('readonly',true)
               		)
               	).append($('<td>')
               		 .attr('class','001')
               		 .append($('<input>')
               		 	.attr('class','span check001')
               		 	.attr('name','Pembukaan['+(pembukaanCount+1)+'][flg]')
               		 	.attr('type','checkbox')
						.attr('value','Y')
						.prop('checked',true)
               		)
               	).append($('<td>')
               		 .attr('class','abCode')
               	).append($('<td>')
               		 .attr('class','subrekCd')
               		 .append($('<input>')
               		 	.attr('class','span6')
               		 	.attr('name','Pembukaan['+(pembukaanCount+1)+'][subrek_cd]')
               		 	.attr('type','text')
               		 	.attr('maxlength',4)
               		).append("&nbsp;&nbsp;&nbsp;")
               		 .append("001")
               		 .append("&emsp;&nbsp;&nbsp;")
               		 .append("XX")
               		
               	).append($('<td>')
               		 .attr('class','004')
               		 .append($('<input>')
               		 	.attr('class','span check004')
               		 	.attr('name','Pembukaan['+(pembukaanCount+1)+'][flg_004]')
               		 	.attr('type','checkbox')
						.attr('value','Y')
           			)
               	).append($('<td>')
               		 .attr('class','005')
               		 .append($('<input>')
               		 	.attr('class','span check005')
               		 	.attr('name','Pembukaan['+(pembukaanCount+1)+'][flg_005]')
               		 	.attr('type','checkbox')
						.attr('value','Y')
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRowPembukaan(this)')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	)
               		)
               	)   	
    		);
    	
    	pembukaanCount++;
    	$(window).trigger('resize');
	}
	
	function deleteRowPembukaan(obj)
	{
		$(obj).closest('tr').remove();
		pembukaanCount--;
		$(window).trigger('resize');
	}
</script>