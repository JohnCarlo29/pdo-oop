$(document).ready(function(){
	
	$('#admin').click(function(){
		$('#uname').val('admin');
	});

	$('#student').click(function(){
		$('#uname').val('student');
	});

	$('.showAll').hide();

	$('.showAll').click(function(){
		location.reload();
	});

	//highlight the current page
	var getActivePAge = $(function(){
    var current = location.pathname;
		switch(current){
			case'/ccj/index.php':
				$('#dashboard').addClass('active');
				break;
			case'/ccj/examinees.php':
				$('#examinees').addClass('active');
				break;
			case'/ccj/results.php':
				$('#results').addClass('active');
				break;
		}
	});

	getActivePAge;

	$("#studno").chosen();

	$("#studno").change(function(){
		var id = $("#studno").val();
		$.ajax({ 
			data: {id:id,action:"getExamineeResult"},
			url: "ajax.php",
			type: 'post',
			dataType: 'json',
			success: function(response){
				
				$('#test1').val(response.cjp);
				$('#test2').val(response.lea);
				$('#test3').val(response.cdip);
				$('#test4').val(response.c);
				$('#test5').val(response.ca);
				$('#test6').val(response.csehr);
			}
		});
	});

	//populating bar graph of pass/fail
	$.ajax({ 
		data: {action:"getPerYearResult"},
		url: "ajax.php",
		type: 'post',
		dataType: 'json',
		success: function(response){
			var newDatasets = {}; // new dataset array
			var label = ['cjp','lea','cdip','c','ca','csehr'];
			var cjp = [];
			var lea = [];
			var cdip = [];
			var c = [];
			var ca = [];
			var csehr = [];
			var bg = [];
			var bd = [];
			var subj = [];
			var year = []
			var data ={labels: year, datasets:[]}; // initial data for chart

			for(var i = 0; i < 6; i++){
				var hue = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';
				bd.push(hue);
				bg.push(hue);
			}

			//pushing new datasets in data
			$.each(response, function(key1, value1){
				var hue = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';
				year.push(value1[0].year);
				cjp.push(value1[0].cjp);
				lea.push(value1[0].lea);
				cdip.push(value1[0].cdip);
				c.push(value1[0].c);
				ca.push(value1[0].ca);
				csehr.push(value1[0].csehr);
				
			});

			subj.push(cjp);
			subj.push(lea);
			subj.push(cdip);
			subj.push(c);
			subj.push(ca);
			subj.push(csehr);

			for(var j = 0; j < 6; j++){

				newDatasets.label = label[j];
				newDatasets.data = subj[j];
				newDatasets.backgroundColor = bg[j];
				newDatasets.borderColor = bd[j];
				newDatasets.fill = false;

				data.datasets.push(newDatasets);

				newDatasets = {};
			}

			var ctx = $("#myChart1");
			var myChart = new Chart(ctx, {
			    type: 'line',
			    data: data,
			    options: { 
			    	title: {
			    		display: true,
			    		text : 'Percentage of Yearly Results by Subjects ('+year[0]+' - '+year[2]+')',
			    		fontSize : 25
			    	},
			    	maintainAspectRatio: false,
			   		scales: {
				        yAxes: [{
				            ticks: {
				                beginAtZero: true,
				                stepSize: 10
				            },
			            	scaleLabel: {
						        display: true,
						        labelString: 'Exam Results (in Percent)',
						        fontSize:15
						    }
				        }]
				    }     
			    }			
			});

			var subject=[
							"Criminal Jurisprudence and Procedures",
							"Law Enforcement Administration",
							"Crime Detection Investigation and Prevention",
							"Criminalistic",
							"Correctional Administration",
							"Criminal Sociology Ethics and Human Relations",
						];
			var analysis = "";
	
			for(var i = 0 ; i < year.length; i++){
				var lowest = parseFloat(cjp[i]);
				var lowsub = 'CJP';
				if(lowest > parseFloat(lea[i])){
					lowest = parseFloat(lea[i]); 
					lowsub = 'LEA';
				}else if(parseFloat(cdip[0]) < lowest){
					lowest = parseFloat(cdip[i]); 
					lowsub = 'CDIP';
				}else if(parseFloat(cdip[0]) < lowest){
					lowest = parseFloat(cdip[i]); 
					lowsub = 'CDIP';
				}else if(parseFloat(c[0]) < lowest){
					lowest = parseFloat(c[i]); 
					lowsub = 'C';
				}else if(parseFloat(ca[0]) < lowest){
					lowest = parseFloat(ca[i]); 
					lowsub = 'CA';
				}else if(parseFloat(csehr[i]) < lowest){
					lowest = parseFloat(csehr[i]); 
					lowsub = 'CSEHR';
				}

				analysis += "<h4>In "+year[i]+" the lowest subject was "+lowsub+" averaging "+lowest+"%</h4>"; 

				var lowest = null;
				var lowsub = null;
			}
			$("#analysis1").html(analysis);
		}
	});

	
	//populating bar graph of pass/fail
	$.ajax({ 
		data: {action:"getPerYearPercentage"},
		url: "ajax.php",
		type: 'post',
		dataType: 'json',
		success: function(response){
			var result = [];
			var yearLabel = []
			
			var hue = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';
			
			$.each(response, function(key, value){
				
				yearLabel.push(value[0].year);
				result.push(value[0].percent);
			});

			var ctx = $("#myChart2");
			var myChart = new Chart(ctx, {
			    type: 'bar',
			    data: {
			    	labels: yearLabel,
			    	datasets:[{
			    		label: 'Year Percentage',
			    		data: result,
			    		backgroundColor: [hue, hue, hue]
			    	}]
			    },
			    options: { 
			    	maintainAspectRatio: false,
			   		scales: {
				        yAxes: [{
				            ticks: {
				                beginAtZero: true,
				                max: 100,
				                stepSize: 20
				            }
				        }]
				    },
				    animation: {
	                    duration: 1,
	                    onComplete: function () {
	                        var chartInstance = this.chart,
	                            ctx = chartInstance.ctx;
	                        ctx.textAlign = 'center';
	                        ctx.fillStyle = "rgba(0, 0, 0, 1)";
	                        ctx.textBaseline = 'bottom';

	                        this.data.datasets.forEach(function (dataset, i) {
	                            var meta = chartInstance.controller.getDatasetMeta(i);
	                            meta.data.forEach(function (bar, index) {
	                                var data = dataset.data[index];
	                                ctx.fillText(data, bar._model.x , bar._model.y - 5);

	                            });
	                        });
	                    }
	                }		    
				}		
			});

			var analysis;
			var lowest = null;
			for(var i=0; i<result.length; i++){
				if(lowest == null){
					lowest = result[i];
				}else{
					if(lowest > result[i]){
						lowest = result[i];
					}
				}
			}
			analysis = "<h4>For the past 3 years the lowest passing rate was in year "+yearLabel[result.indexOf(lowest)]+" averaging "+lowest+"%</h4>";
			$("#analysis2").html(analysis);
		}
	});

	$.ajax({ 
		data: {action:"getPerBatchResult"},
		url: "ajax.php",
		type: 'post',
		dataType: 'json',
		success: function(response){
			
			var hue = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';
			var hue1 = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';
			var hue2 = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';
			
			var ctx = $("#myChart3");
			var myChart = new Chart(ctx, {
			    type: 'doughnut',
			    data: {
			    	labels: response.year,
			    	datasets:[{
			    		data: response.first,
			    		backgroundColor:[hue, hue1, hue2],
			    		label: 'Batch 1'
			    	},{
			    		data: response.second,
			    		backgroundColor:[hue, hue1, hue2],
			    		label: 'Batch 2'
			    	}]
			    },
			    options: { 
			    	maintainAspectRatio : false,
			   		animation:{
			   			animateScate: true,
			   			animateRotate: true
			   		},
			   		tooltips: {
							callbacks: {
							label: function(item, data) {
							    return data.datasets[item.datasetIndex].label+ ": "+ data.labels[item.index]+ ": "+ data.datasets[item.datasetIndex].data[item.index];
							}
						}
					}
			    }			
			});
			
			var analysis ="";
			if(response.first[0] > response.second[0]){
				analysis += "<h4>In "+response.year[0]+" the first batch got higher passing rate ("+response.first[0]+")</h4>";
			}else{
				analysis += "<h4>In "+response.year[0]+" the second batch got higher passing rate ("+response.second[0]+")</h4>";
			}

			if(response.first[1] > response.second[1]){
				analysis += "<h4>In "+response.year[1]+" the first batch got higher passing rate ("+response.first[1]+")</h4>";
			}else{
				analysis += "<h4>In "+response.year[1]+" the second batch got higher passing rate ("+response.second[1]+")</h4>";
			}

			if(response.first[2] > response.second[2]){
				analysis += "<h4>In "+response.year[2]+" the first batch got higher passing rate ("+response.first[2]+")</h4>";
			}else{
				analysis += "<h4>In "+response.year[2]+" the second batch got higher passing rate ("+response.second[2]+")</h4>";
			}


			$("#analysis3").html(analysis);

		}
	});

	$.ajax({ 
		data: {action:"getNPR"},
		url: "ajax.php",
		type: 'post',
		dataType: 'json',
		success: function(response){

			var batch1 = [];
			var batch2 = [];
			
			$.each(response[1], function(key, value){
				batch1.push(value);
			});

			$.each(response[2], function(key, value){
				batch2.push(value);
			});

			var data ={labels: response[0], datasets:[]};
			
			var hue = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';
			
			var newDatasets = {}; // new dataset array

			newDatasets.label = '1st Batch';
			newDatasets.data = batch1;
			newDatasets.backgroundColor = 	hue;
			newDatasets.borderColor = 		hue;
			newDatasets.fill = false;

			data.datasets.push(newDatasets);

			var hue1 = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';
			
			var newDatasets1 = {}; // new dataset array

			newDatasets1.label = '2nd Batch';
			newDatasets1.data = batch2;
			newDatasets1.backgroundColor = 	hue1;
			newDatasets1.borderColor = 		hue1;
			newDatasets1.fill = false;

			data.datasets.push(newDatasets1);

			var ctx = $("#myChart4");
			var myChart = new Chart(ctx, {
			    type: 'bar',
			    data: data,
			    options: { 
			    	maintainAspectRatio: false,
			   		scales: {
				        yAxes: [{
				            ticks: {
				                beginAtZero: true,
				                stepSize: 20,
				                max: 100
				            }
				        }],
				    },     
			        animation: {
	                    duration: 1,
	                    onComplete: function () {
	                        var chartInstance = this.chart,
	                            ctx = chartInstance.ctx;
	                        ctx.textAlign = 'center';
	                        ctx.fillStyle = "rgba(0, 0, 0, 1)";
	                        ctx.textBaseline = 'bottom';

	                        this.data.datasets.forEach(function (dataset, i) {
	                            var meta = chartInstance.controller.getDatasetMeta(i);
	                            meta.data.forEach(function (bar, index) {
	                                var data = dataset.data[index];
	                                ctx.fillText(data, bar._model.x , bar._model.y - 5);

	                            });
	                        });
	                    }
	                }
			    }			
			});

			var analysis="<h4>";
			if(batch1[0] > batch2[0]){
				var diff = batch1[0]-batch2[0];
				analysis += "In "+response[0][0]+" the first batch is "+diff+"% higher than second batch</h4>";
			}else{
				var diff = batch2[0]-batch1[0];
				analysis += "In "+response[0][0]+" the second batch is "+diff+"% higher than first batch</h4>";
			}

			if(batch1[1] > batch2[1]){
				var diff = batch1[1]-batch2[1];
				analysis += "<h4>In "+response[0][1]+" the first batch is "+diff+"% higher than second batch</h4>";
			}else{
				var diff = batch2[1]-batch1[1];
				analysis += "<h4>In "+response[0][1]+" the second batch is "+diff+"% higher than first batch</h4>";
			}

			if(batch1[2] > batch2[2]){
				var diff = batch1[2]-batch2[2];
				analysis += "<h4>In "+response[0][2]+" the first batch is "+diff+"% higher than second batch</h4>";
			}else{
				var diff = batch2[2]-batch1[2];
				analysis += "<h4>In "+response[0][2]+" the second batch is "+diff+"% higher than first batch</h4>";
			}
			$('#analysis4').html(analysis);
		}
	});

	$.ajax({ 
		data: {action:"getCorrelation"},
		url: "ajax.php",
		type: 'post',
		dataType: 'json',
		success: function(response){
			var data = [];
			var examineesMean;
			var resultsMean;
			var a=[];
			var b=[];
			var axb=[];
			var aa=[];
			var bb=[];
			var axbTotal = 0;
			var aaTotal = 0;
			var bbTotal = 0;

			var examineesTotal=0;
			var resultsTotal=0;

			for(var i = 0; i<response[0].length; i++){
				examineesTotal = examineesTotal + response[0][i];
				resultsTotal = resultsTotal + parseInt(response[1][i]);
			}

			examineesMean = examineesTotal/response[0].length;
			resultsMean = resultsTotal/response[0].length;

			for(var i = 0; i<response[0].length; i++){
				result = response[0][i] - examineesMean;
				a.push(result);
			}

			for(var i = 0; i<response[0].length; i++){
				result = response[1][i] - resultsMean;
				b.push(result);
			}

			for(var i = 0; i<a.length; i++){
				result = a[i] * b[i];
				axb.push(result);
			}

			for(var i = 0; i<a.length; i++){
				result = a[i] * a[i];
				aa.push(result);
			}

			for(var i = 0; i<b.length; i++){
				result = b[i] * b[i];
				bb.push(result);
			}

			for(var i = 0; i<axb.length; i++){
				axbTotal = axbTotal + axb[i];
			}

			for(var i = 0; i<aa.length; i++){
				aaTotal = aaTotal + aa[i];
			}

			for(var i = 0; i<bb.length; i++){
				bbTotal = bbTotal + bb[i];
			}

			var correlation = Math.round((axbTotal/(Math.sqrt(aaTotal*bbTotal)))*100)/100;


			for(var i = 0; i < response[0].length; i++){
				var datas = {};
				datas.x = response[0][i];
				datas.y = response[1][i];
				data.push(datas);
			}

			var hue = 'rgb(' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ',' + (Math.floor(Math.random() * 256)) + ')';

			var ctx = $("#myChart5");
			var myChart = new Chart(ctx, {
			    type: 'line',
			    data: {
			    	datasets:[{
			    		label: 'Correlation',
			    		data:data,
			    		backgroundColor:hue,
			    		borderColor:hue,
			    		fill:false
			    	}]
			    },
			    options: { 
			    	maintainAspectRatio : false,
			   		scales: {
			            xAxes: [{
			                type: 'linear',
			                position: 'bottom',
			                scaleLabel: {
						        display: true,
						        labelString: 'Examinees Per Year',
						        fontSize:15
						    }
			            }],
			            yAxes:[{
			            	scaleLabel: {
						        display: true,
						        labelString: 'Passing % per Year',
						        fontSize:15
						    }
			            }]
			        }
			    }			
			});

			var analysis="<h4>The correlation betweeen examinees and passing percentage got ";
			if(correlation == 0){
				analysis += "no correlation ";
			}else if(correlation > 0){
				analysis += "positive correlation ";
			}else{
				analysis += "negative correlation ";
			}

			analysis += " with correlation score of "+correlation;
			$('#analysis5').html(analysis);
		}
	});

	//populating select of all year in student list and displaying 1st page of student list base on selected year
	$.ajax({ 
		data: {action:"getYears"},
		url: "ajax.php",
		type: 'post',
		dataType: 'json',
		success: function(response){

			$.each(response, function(key, value){
				$('#examyear').append('<option value="'+value.year+'">'+value.year+'</option>');
				$('#resultyear').append('<option value="'+value.year+'">'+value.year+'</option>');
				$('.examineesCount').append('<li class="dropdown-submenu"><a class="year" onclick="getTotalExaminees('+value.year+')" >'+value.year+'</span></a><ul class="dropdown-menu"><li><a class="firstBatch" tabindex="-1" >1st Batch</a></li><li><a class="secondBatch" tabindex="-1" >2nd Batch</a></li></ul></li>');
				$('.passedCount').append('<li class="dropdown-submenu"><a class="year" onclick="getTotalPassed('+value.year+')" >'+value.year+'</span></a><ul class="dropdown-menu"><li><a class="firstBatch">1st Batch</a></li><li><a class="secondBatch" tabindex="-1" >2nd Batch</a></li></ul></li>');
				$('.failedCount').append('<li class="dropdown-submenu"><a class="year"onclick="getTotalFailed('+value.year+')" >'+value.year+'</span></a><ul class="dropdown-menu"><li><a class="firstBatch"tabindex="-1" >1st Batch</a></li><li><a class="secondBatch" tabindex="-1" >2nd Batch</a></li></ul></li>');
			});

			//getting student first page
			$.ajax({
				data:{action:"getExaminees", year:$('#examyear').val()},
				url: "ajax.php",
				type:'post',
				dataType:'json',
				success: function(response){

					$.each(response, function(key, value){
						$('#examineeInfo tbody').append('<tr><td>'+value.examinee_no+'</td><td>'+value.lname+'</td><td>'+value.fname+'</td><td>'+value.m_i+'</td></tr>')
					});
				}
			});

			$.ajax({
				data:{action:"getResults", year:$('#resultyear').val()},
				url: "ajax.php",
				type:'post',
				dataType:'json',
				success: function(response){
					$.each(response, function(key, value){
						$('#resultsInfo tbody').append('<tr><td>'+value.examinee_no+'</td><td>'+value.lname+'</td><td>'+value.fname+'</td><td>'+value.m_i+'</td><td>'+value.cjp+'</td><td>'+value.lea+'</td><td>'+value.cdip+'</td><td>'+value.c+'</td><td>'+value.ca+'</td><td>'+value.csehr+'</td><td>'+value.gen_ave+'</td></tr>')
					});
				}
			});
		}
	});

	//for every choose of year data in table will change
	$('#examyear').change('change', function(){
		$.ajax({
			data:{action:"getExaminees", year:$(this).val()},
			url: "ajax.php",
			type:'post',
			dataType:'json',
			success: function(response){
				var content = '';
				for (var i = 0; i < response.length; i++) {
					content += '<tr><td>'+response[i].examinee_no+'</td><td>'+response[i].lname+'</td><td>'+response[i].fname+'</td><td>'+response[i].m_i+'</td></tr>'
				}

				$('.currentPage').text('1');
				$('#examineeInfo tbody').html(content);
				$('#examPagination').show();
			}
		});
	});

	$('#resultyear').change('change', function(){
		$.ajax({
			data:{action:"getResults", year:$(this).val()},
			url: "ajax.php",
			type:'post',
			dataType:'json',
			success: function(response){
				var content = '';
				for (var i = 0; i < response.length; i++) {
					content += '<tr><td>'+response[i].examinee_no+'</td><td>'+response[i].lname+'</td><td>'+response[i].fname+'</td><td>'+response[i].m_i+'</td><td>'+response[i].cjp+'</td><td>'+response[i].lea+'</td><td>'+response[i].CDIP+'</td><td>'+response[i].c+'</td><td>'+response[i].ca+'</td><td>'+response[i].csehr+'</td><td>'+response[i].total+'</td></tr>';
				}
				$('.currentPage').text('1');
				$('#resultsInfo tbody').html(content);
				$('#resultPagination').show();
			}
		});
	});

	//student tab next button
	$('#examNextBtn').click(function(){
		var page = parseInt($('.currentPage').text());
		var year = $('#examyear').val();
		$.ajax({
			data:{action:"examGetTotalPage", year:year},
			url: "ajax.php",
			type:'post',
			dataType:'text',
			success: function(response){
				if(parseInt(response) != page){
					$.ajax({
						data:{action:"getExamPerPage", year:year, page:page+1},
						url: "ajax.php",
						type:'post',
						dataType:'json',
						success: function(response){
				
							var content = '';
							for (var i = 0; i < response[0].length; i++) {
								content += '<tr><td>'+response[0][i].examinee_no+'</td><td>'+response[0][i].lname+'</td><td>'+response[0][i].fname+'</td><td>'+response[0][i].m_i+'</td></tr>';
							}
							$('.currentPage').text(page+1);
							$('#examineeInfo tbody').html(content);
						}
					});
				}else{
					swal ( "Oops" ,  "Your Already on last Page" ,  "error" )
				}
			}
		});
	});

	$('#resultNextBtn').click(function(){
		var page = parseInt($('.currentPage').text());
		var year = $('#resultyear').val();
		$.ajax({
			data:{action:"examGetTotalPage", year:year},
			url: "ajax.php",
			type:'post',
			dataType:'text',
			success: function(response){
				if(parseInt(response) != page){
					$.ajax({
						data:{action:"getResultPerPage", year:year, page:page+1},
						url: "ajax.php",
						type:'post',
						dataType:'json',
						success: function(response){
						
							var content = '';
							for (var i = 0; i < response[0].length; i++) {
								content += '<tr><td>'+response[0][i].examinee_no+'</td><td>'+response[0][i].lname+'</td><td>'+response[0][i].fname+'</td><td>'+response[0][i].m_i+'</td><td>'+response[0][i].cjp+'</td><td>'+response[0][i].lea+'</td><td>'+response[0][i].cdip+'</td><td>'+response[0][i].c+'</td><td>'+response[0][i].ca+'</td><td>'+response[0][i].csehr+'</td><td>'+response[0][i].gen_ave+'</td></tr>';
							}
							$('.currentPage').text(page+1);
							$('#resultsInfo tbody').html(content);
						}
					});
				}else{
					swal ( "Oops" ,  "Your Already on last Page" ,  "error" )
				}
			}
		});
	});

	//student tab previous button
	$('#examPreviosBtn').click(function(){
		var page = parseInt($('.currentPage').text());
		if(page > 1 ){
			$.ajax({
				data:{action:"getExamPerPage", year:$('#examyear').val(), page:page-1},
				url: "ajax.php",
				type:'post',
				dataType:'json',
				success: function(response){
					var content = '';
					for (var i = 0; i < response[0].length; i++) {
						content += '<tr><td>'+response[0][i].examinee_no+'</td><td>'+response[0][i].lname+'</td><td>'+response[0][i].fname+'</td><td>'+response[0][i].m_i+'</td></tr>'
					}
					$('.currentPage').text(page-1);
					$('#examineeInfo tbody').html(content);
				}
			});
		}else{
			swal ( "Oops" ,  "Your Already on First Page" ,  "error" )
		}
	});

	$('#resultPreviosBtn').click(function(){
		var page = parseInt($('.currentPage').text());
		if(page > 1 ){
			$.ajax({
				data:{action:"getResultPerPage", year:$('#resultyear').val(), page:page-1},
				url: "ajax.php",
				type:'post',
				dataType:'json',
				success: function(response){
					var content = '';
					for (var i = 0; i < response[0].length; i++) {
						content += '<tr><td>'+response[0][i].examinee_no+'</td><td>'+response[0][i].lname+'</td><td>'+response[0][i].fname+'</td><td>'+response[0][i].m_i+'</td><td>'+response[0][i].cjp+'</td><td>'+response[0][i].lea+'</td><td>'+response[0][i].cdip+'</td><td>'+response[0][i].c+'</td><td>'+response[0][i].ca+'</td><td>'+response[0][i].csehr+'</td><td>'+response[0][i].gen_ave+'</td></tr>';
					}
					$('.currentPage').text(page-1);
					$('#resultsInfo tbody').html(content);
				}
			});
		}else{
			swal ( "Oops" ,  "Your Already on First Page" ,  "error" )
		}
	});


	$('.txtExamNum').keyup(function(e){
		if (/\D/g.test(this.value))
		{
			// Filter non-digits from input value.
			this.value = this.value.replace(/\D/g, '');
		}
	}); 

	$('.txtResultNum').keyup(function(e){
		if (/\D/g.test(this.value))
		{
			// Filter non-digits from input value.
			this.value = this.value.replace(/\D/g, '');
		}
	}); 

	$('#examSearchBtn').click(function(){
		var examNum = $('.txtExamNum').val();
		if($.trim(examNum) == ""){
			swal ( "Oops" ,  "You must enter Examinee #" ,  "error" )
		}else{
			$.ajax({
				data:{action:"searchExaminees", year:$('#examyear').val(), examNum:examNum},
				url: "ajax.php",
				type:'post',
				dataType:'json',
				success: function(response){
				
					var content = '';
					for (var i = 0; i < response.length; i++) {
						content += '<tr><td>'+response[i].examinee_no+'</td><td>'+response[i].lname+'</td><td>'+response[i].fname+'</td><td>'+response[i].m_i+'</td></tr>'
					}
					$('#examPagination').hide();
					$('.showAll').show();
					$('#examineeInfo tbody').html(content);
				}
			});
		}
	});

	$('#resultSearchBtn').click(function(){
		var resultNum = $('.txtResultNum').val();
		if($.trim(resultNum) == ""){
			swal ( "Oops" ,  "You must enter Examinee #" ,  "error" )
		}else{
			$.ajax({
				data:{action:"searchExamineesResult", year:$('#resultyear').val(), resultNum:resultNum},
				url: "ajax.php",
				type:'post',
				dataType:'json',
				success: function(response){
				
					var content = '';
					for (var i = 0; i < response.length; i++) {
						content += '<tr><td>'+response[i].examinee_no+'</td><td>'+response[i].lname+'</td><td>'+response[i].fname+'</td><td>'+response[i].m_i+'</td><td>'+response[i].cjp+'</td><td>'+response[i].lea+'</td><td>'+response[i].cdip+'</td><td>'+response[i].c+'</td><td>'+response[i].ca+'</td><td>'+response[i].csehr+'</td><td>'+response[i].gen_ave+'</td></tr>'
					}
					$('#resultPagination').hide();
					$('.showAll').show();
					$('#resultsInfo tbody').html(content);
				}
			});
		}
	});

});


//adding test results
function addResult(){

	var formData = new FormData($('#addResultForm')[0]);
	formData.append('action', "addResult");
	$.ajax({ 
		data: formData,
		url: "ajax.php",
		type: 'post',
		contentType: false,
    	processData: false,
		success: function(response){
			var result = $.parseJSON(response)
			if(result.hasOwnProperty("success")){
				swal({
					title: "Success!",
					text: result.success,
					type: "success",
					icon: "success",
					button: "OK"
				}).then(function() {
					location.reload();
				});
			}else{
				alert(result.error);
			}
		}
	});

}

//remove examinee from examinee list
function removeExaminee(id){
	var action = "removeExaminee";
	swal("Remove this to list of examinees?", {
			buttons: {
				cancel: "No!",
				catch: {
				  text: "Yes",
				  value: "remove",
				},
			},
		})
		.then((value) => {
		switch (value) {

		case "remove":
			$.ajax({ 
				data: {action:action,id:id},
				url: "ajax.php",
				type: 'post',
				success: function(response){
					swal({
					title: "Success!",
					text: response,
					type: "success",
					icon: "success",
					button: "OK"
					}).then(function() {
						location.reload();
					});
				}
			});
		  break;

		default:
		  swal("Examinees Not Removed");
		}
   	});
}

function random_rgba() {
    var o = Math.round, r = Math.random, s = 255;
    return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
}

function GetURLParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}


function getTotalExaminees(year){
	$.ajax({ 
		data: {year:year, action:"getTotalExamineePerYear"},
		url: "ajax.php",
		type: 'post',
		success: function(response){
			$('#examineesCount').html(response);
		}
	});
}

function getTotalPassed(year){
	$.ajax({ 
		data: {year:year, action:"getTotalPassed"},
		url: "ajax.php",
		type: 'post',
		success: function(response){

			$('#passedCount').html(response);
		}
	});
}

function getTotalFailed(year){
	$.ajax({ 
		data: {year:year, action:"getTotalFailed"},
		url: "ajax.php",
		type: 'post',
		success: function(response){
		
			$('#failedCount').html(response);
		}
	});
}

$(document).on('click', '.firstBatch', function() { 
	var getClass = $($(this)).parent().parent().parent().parent().attr('class');
	var classes = getClass.split(' ');
	var className = classes[1];

	var year = $($(this)).parent().parent().parent().find('a.year').text();

	switch (className) { 
	case 'examineesCount': 
		$.ajax({ 
			data: {year:year, action:"getTotalExamineePerYearFB"},
			url: "ajax.php",
			type: 'post',
			success: function(response){
				$('#examineesCount').html(response);
			}
		});
		break;
	case 'passedCount': 
		$.ajax({ 
			data: {year:year, action:"getTotalPassedFB"},
			url: "ajax.php",
			type: 'post',
			success: function(response){
				$('#passedCount').html(response);
			}
		});
		break;
	default:
		$.ajax({ 
			data: {year:year, action:"getTotalFailedFB"},
			url: "ajax.php",
			type: 'post',
			success: function(response){
				
				$('#failedCount').html(response);
			}
		});
	}
	

});

$(document).on('click', '.secondBatch', function() { 
	var getClass = $($(this)).parent().parent().parent().parent().attr('class');
	var classes = getClass.split(' ');
	var className = classes[1];

	var year = $($(this)).parent().parent().parent().find('a.year').text();

	switch (className) { 
	case 'examineesCount': 
		$.ajax({ 
			data: {year:year, action:"getTotalExamineePerYearSB"},
			url: "ajax.php",
			type: 'post',
			success: function(response){
				$('#examineesCount').html(response);
			}
		});
		break;
	case 'passedCount': 
		$.ajax({ 
			data: {year:year, action:"getTotalPassedSB"},
			url: "ajax.php",
			type: 'post',
			success: function(response){
				$('#passedCount').html(response);
			}
		});
		break;
	default:
		$.ajax({ 
			data: {year:year, action:"getTotalFailedSB"},
			url: "ajax.php",
			type: 'post',
			success: function(response){
				$('#failedCount').html(response);
			}
		});
	}

});

function updateResult(){

	var formData = new FormData($('#updateResultForm')[0]);

	formData.append('action', "updateResult");
	$.ajax({ 
		data: formData,
		url: "ajax.php",
		type: 'post',
		contentType: false,
    	processData: false,
		success: function(response){
			if(response){
				swal({
					title: "Success!",
					text: "Update Done",
					type: "success",
					icon: "success",
					button: "OK"
				}).then(function() {
					$('#studno').val('0');
					$('#test1').val("");
					$('#test2').val("");
					$('#test3').val("");
					$('#test4').val("");
					$('#test5').val("");
					$('#test6').val("");
				});
			}
		}
	});
}

