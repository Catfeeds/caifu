$(function() {
	H.userNewlyAdd = {
		init: function(){
			// 选中左侧某个菜单
			selectLeftNode('nav-userNewlyAdd');
			// 选中上方某个tab
			$('#pageTab a[href="#userNewlyAdd"]').trigger('click');
			this.events();
			// 初始化日期选择插件
			$('.dateTimePicker').datetimepicker({
				format: 'yyyy-mm-dd',
		        autoclose: true,
		        startView: 2,
		        minView:2,
		        language:  'zh-CN',
			});
			$('#reStatisticsTime').datetimepicker({
				format: 'yyyy-mm-dd',
		        autoclose: true,
		        startView: 2,
		        minView:2,
		        language:  'zh-CN',
			});
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});

			H.userNewlyAdd.userChart1();
			H.userNewlyAdd.userChart2();
			H.userNewlyAdd.userChart3();
			H.userNewlyAdd.userChart4();

			$('#userNewlyAdd-dateTime1').bind('input propertychange change',function(){
				H.userNewlyAdd.userChart1();

			});
			$('#userNewlyAdd-dateTime2').bind('input propertychange change',function(){
				H.userNewlyAdd.userChart1();

			});
			$('#userNewlyAdd-dateTime3').bind('input propertychange change',function(){
				H.userNewlyAdd.userChart2();

			});
			$('#userNewlyAdd-dateTime4').bind('input propertychange change',function(){
				H.userNewlyAdd.userChart2();

			});
			$('#userNewlyAdd-dateTime5').bind('input propertychange change',function(){
				H.userNewlyAdd.userChart3();

			});
			$('#userNewlyAdd-dateTime6').bind('input propertychange change',function(){
				H.userNewlyAdd.userChart3();

			});
			$('#userNewlyAdd-dateTime7').bind('input propertychange change',function(){
				H.userNewlyAdd.userChart4();

			});
			$('#userNewlyAdd-dateTime8').bind('input propertychange change',function(){
				H.userNewlyAdd.userChart4();

			});
			$('body').on('change','.dateTypeSelect-user',function(){
					var val = $(this).val();
					var format = 'yyyy-mm-dd';
					var startView = 2;
					if(val == 'month'){
						format = 'yyyy-mm';	
						startView = 3;
					}else if(val == 'year'){
						format = 'yyyy';
						startView = 4;
					}
					$('#userNewlyAdd-dateTime1').val('');
					$('#userNewlyAdd-dateTime2').val('');
					$('#userNewlyAdd-dateTime1').datetimepicker('remove');
					$('#userNewlyAdd-dateTime2').datetimepicker('remove');

					$('#userNewlyAdd-dateTime1').datetimepicker({
						autoclose: true,
		        		format: format,
		        		autoclose: true,
					    startView: startView,
					    minView: startView,
		        		language: "zh-CN"
					});
					$('#userNewlyAdd-dateTime2').datetimepicker({
						autoclose: true,
		        		format: format,
		        		autoclose: true,
					    startView: startView,
					    minView: startView,
		        		language: "zh-CN"
					});
			});
			$('body').on('change','.dateTypeSelect-user2',function(){
					var val = $(this).val();
					var format = 'yyyy-mm-dd';
					var startView = 2;
					if(val == 'month'){
						format = 'yyyy-mm';	
						startView = 3;
					}else if(val == 'year'){
						format = 'yyyy';
						startView = 4;
					}
					$('#userNewlyAdd-dateTime3').val('');
					$('#userNewlyAdd-dateTime4').val('');
					$('#userNewlyAdd-dateTime3').datetimepicker('remove');
					$('#userNewlyAdd-dateTime4').datetimepicker('remove');

					$('#userNewlyAdd-dateTime3').datetimepicker({
						autoclose: true,
		        		format: format,
		        		autoclose: true,
					    startView: startView,
					    minView: startView,
		        		language: "zh-CN"
					});
					$('#userNewlyAdd-dateTime4').datetimepicker({
						autoclose: true,
		        		format: format,
		        		autoclose: true,
					    startView: startView,
					    minView: startView,
		        		language: "zh-CN"
					});
			});
			$('body').on('change','.dateTypeSelect-user3',function(){
					var val = $(this).val();
					var format = 'yyyy-mm-dd';
					var startView = 2;
					if(val == 'month'){
						format = 'yyyy-mm';	
						startView = 3;
					}else if(val == 'year'){
						format = 'yyyy';
						startView = 4;
					}
					$('#userNewlyAdd-dateTime5').val('');
					$('#userNewlyAdd-dateTime6').val('');
					$('#userNewlyAdd-dateTime5').datetimepicker('remove');
					$('#userNewlyAdd-dateTime6').datetimepicker('remove');

					$('#userNewlyAdd-dateTime5').datetimepicker({
						autoclose: true,
		        		format: format,
		        		autoclose: true,
					    startView: startView,
					    minView: startView,
		        		language: "zh-CN"
					});
					$('#userNewlyAdd-dateTime6').datetimepicker({
						autoclose: true,
		        		format: format,
		        		autoclose: true,
					    startView: startView,
					    minView: startView,
		        		language: "zh-CN"
					});
			});
			$('body').on('change','.dateTypeSelect-user4',function(){
					var val = $(this).val();
					var format = 'yyyy-mm-dd';
					var startView = 2;
					if(val == 'month'){
						format = 'yyyy-mm';	
						startView = 3;
					}else if(val == 'year'){
						format = 'yyyy';
						startView = 4;
					}
					$('#userNewlyAdd-dateTime7').val('');
					$('#userNewlyAdd-dateTime8').val('');
					$('#userNewlyAdd-dateTime7').datetimepicker('remove');
					$('#userNewlyAdd-dateTime8').datetimepicker('remove');

					$('#userNewlyAdd-dateTime7').datetimepicker({
						autoclose: true,
		        		format: format,
		        		autoclose: true,
					    startView: startView,
					    minView: startView,
		        		language: "zh-CN"
					});
					$('#userNewlyAdd-dateTime8').datetimepicker({
						autoclose: true,
		        		format: format,
		        		autoclose: true,
					    startView: startView,
					    minView: startView,
		        		language: "zh-CN"
					});
			});
		},
		events: function(){
			$("body").delegate("#reStatistics","click",function(){
				//重新统计按钮事件，打开重新统计弹层
				$("#reStatisticsTime").val("");
				$("#reStatisticsPopup").removeClass("none");
			}).delegate("#reStatisticsPopup .close-btn","click",function(){
				//重新统计弹层关闭按钮事件，关闭重新统计弹层
				$("#reStatisticsPopup").addClass("none");
			}).delegate("#reStatisticsPopup #reCommitBtn","click",function(){
				var beginTime = $('#reStatisticsTime').val();
				if(!beginTime){
					alert('请选择时间段');
					return false;
				}
				
				//重新统计弹层提交按钮事件，展示提示信息
				$("#reStatisticsPopup").addClass("none");
				showAlert('数据正在重新统计中...');
				
				$.ajax({
					  type: 'POST',
					  url: '/statistic/user-add/reset',
					  data: {
						  'time' : beginTime

					  },
					  success: function(json){

						  

						if(json.errcode == 0){
							showAlert('数据统计成功');
							window.location.reload();
						}else{
							alert(json.msg);
						}



					  },
					  dataType: 'json'
				});
			});
		},
		userChart1 : function(){
				var beginTime = $("#userNewlyAdd-dateTime1").val();
				var endTime = $('#userNewlyAdd-dateTime2').val();
				var unit = $('.dateTypeSelect-user').val();
				var field = 'user_num';
				if(!beginTime || !endTime){
					return false;
				}
				H.userNewlyAdd.getChart(beginTime,endTime,unit,field,'userChart1');
		},
		userChart2 : function(){
				var beginTime = $("#userNewlyAdd-dateTime3").val();
				var endTime = $('#userNewlyAdd-dateTime4').val();
				var unit = $('.dateTypeSelect-user2').val();
				var field = 'recommend_num';
				if(!beginTime || !endTime){
					return false;
				}
				H.userNewlyAdd.getChart(beginTime,endTime,unit,field,'userChart2');
		},
		userChart3 : function(){
				var beginTime = $("#userNewlyAdd-dateTime5").val();
				var endTime = $('#userNewlyAdd-dateTime6').val();
				var unit = $('.dateTypeSelect-user3').val();
				var field = 'club_num';
				if(!beginTime || !endTime){
					return false;
				}
				H.userNewlyAdd.getChart(beginTime,endTime,unit,field,'userChart3');
		},
		userChart4 : function(){
				var beginTime = $("#userNewlyAdd-dateTime7").val();
				var endTime = $('#userNewlyAdd-dateTime8').val();
				var unit = $('.dateTypeSelect-user4').val();
				var field = 'member_num';
				if(!beginTime || !endTime){
					return false;
				}
				H.userNewlyAdd.getChart(beginTime,endTime,unit,field,'userChart4');
		},
		getChart : function(beginTime,endTime,unit,field,id){

			
			if(!beginTime || !endTime){
				alert('请选择时间段');
				return false;
			}
			
			$.ajax({
				  type: 'POST',
				  url: '/statistic/user-add/search',
				  data: {
					  'begin_time' : beginTime,
					  'end_time' : endTime,
					  'field' : field,
					  'unit' : unit

				  },
				  success: function(json){

					  

					if(json.errcode == 0){
			 			drawUserTable(id,json.data);
					}else{
						alert(json.msg);
					}



				  },
				  dataType: 'json'
			});
		}
	};
	H.userNewlyAdd.init();
});