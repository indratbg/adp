<table id="tablePengkinian" class="tableDetailList table-bordered table-condensed">
	<thead>
		<tr>
			<th width="11%">Client Cd</th>
			<th width="34%">Client Name</th>
			<th width="2%">Type</th>
			<th width="15%">Subrek001</th>
			<th width="2%">Y/N</th>
			<th width="15%">Subrek004</th>
			<th width="2%">Y/N</th>
			<th width="15%">Subrek005</th>
			<th width="2%">Y/N</th>
			<th width="2%">
				<a title="add" onclick="addRowPengkinian()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<script>
	var pengkinianCount = <?php echo count($modelPengkinian) ?>;
	var result = {};

	function alignColumnPengkinian()//align columns in thead and tbody
	{		
		var table = $("#tablePengkinian");
		var header = table.children('thead');
		var firstRow = table.children('tbody').children('tr:first');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width()+'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width()+'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width()+'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width()+'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width()+'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width()+'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width()+'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width()+'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width()+'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width()+'px');
	}
	
	function addRowPengkinian()
	{
		$("#tablePengkinian").find('tbody')
    		.append($('<tr>')
    			.attr('id','row'+(pengkinianCount+1))
    			.append($('<td>')
    				 .attr('class','clientCd')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Pengkinian['+(pengkinianCount+1)+'][client_cd]')
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
				        	var subrek001 = '';
				        	var subrek004 = '';
				        		
				        	$.each(result,function()
				        	{
				        		if(this.value.toUpperCase() == inputVal)
				        		{
				        			name = this.name;
				        			type = this.type;
				        			subrek001 = this.subrek001;
				        			subrek004 = this.subrek004;
				        		}
				        	});
				        	
				        	$(this).closest('td').siblings('.clientName').children('input').val(name);
				        	$(this).closest('td').siblings('.clientType').children('input').val(type);
				        	$(this).closest('td').siblings('.subrek001').children('input').val(subrek001);
				        	$(this).closest('td').siblings('.subrek004').children('input').val(subrek004);
				        })
               		)
               	).append($('<td>')
               		 .attr('class','clientName')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Pengkinian['+(pengkinianCount+1)+'][client_name]')
               		 	.attr('type','text')
               		 	.attr('readonly',true)
               		)
               	).append($('<td>')
               		 .attr('class','clientType')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Pengkinian['+(pengkinianCount+1)+'][client_type]')
               		 	.attr('type','text')
               		 	.attr('readonly',true)
               		)
               	).append($('<td>')
               		 .attr('class','subrek001')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Pengkinian['+(pengkinianCount+1)+'][subrek001]')
               		 	.attr('type','text')
               		 	.attr('readonly',true)
               		)
               	).append($('<td>')
               		 .attr('class','001')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Pengkinian['+(pengkinianCount+1)+'][flg]')
               		 	.attr('type','checkbox')
						.attr('value','Y')
						.prop('checked',true)
               		)
               	).append($('<td>')
               		 .attr('class','subrek004')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Pengkinian['+(pengkinianCount+1)+'][subrek004]')
               		 	.attr('type','text')
               		 	.attr('readonly',true)
               		)
               	).append($('<td>')
               		 .attr('class','004')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Pengkinian['+(pengkinianCount+1)+'][flg_004]')
               		 	.attr('type','checkbox')
						.attr('value','Y')
						.css('display',$("#GenXmlSDI_type_1").is(":checked")?'none':'inline')
               		)
               	).append($('<td>')
               		 .attr('class','subrek005')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Pengkinian['+(pengkinianCount+1)+'][subrek005]')
               		 	.attr('type','text')
               		 	.attr('readonly',true)
               		)
               	).append($('<td>')
               		 .attr('class','005')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Pengkinian['+(pengkinianCount+1)+'][flg_005]')
               		 	.attr('type','checkbox')
						.attr('value','Y')
						.css('display',$("#GenXmlSDI_type_1").is(":checked")?'none':'inline')
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('onClick','deleteRowPengkinian(this)')
               		 	.attr('title','delete')
               		 	.append($('<img>')
               		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	)
               		)
               	)   	
    		);
    	
    	pengkinianCount++;
    	$(window).trigger('resize');
	}
	
	function deleteRowPengkinian(obj)
	{
		$(obj).closest('tr').remove();
		pengkinianCount--;
		$(window).trigger('resize');
	}
</script>