$(function() {
	H.kpiCompletion = {
		init: function(){
			// 选中左侧某个菜单
			selectLeftNode('nav-kpiContribution');
			// 选中上方某个tab
			$('#pageTab a[href="#kpiContribution"]').trigger('click');
			this.events();
			var unit = $('#dateType').val();
			// 初始化日期选择插件
			if(unit == 'year'){
				$('.dateTimePicker').datetimepicker({
					format: 'yyyy',
					autoclose: true,
					startView: 4,
					minView:4,
					language:  'zh-CN',
				});
			}else if(unit == 'day'){
				$('.dateTimePicker').datetimepicker({
					format: 'yyyy-mm-dd',
					autoclose: true,
					startView: 2,
					minView:2,
					language:  'zh-CN',
				});
			}else {
				$('.dateTimePicker').datetimepicker({
					format: 'yyyy-mm',
					autoclose: true,
					startView: 3,
					minView:3,
					language:  'zh-CN',
				});
			}
			var chartkpiData = $('.chartkpiData').val();
			var chartTitle = $('.chartTitle').val();
			var chartDate = $('.chartDate').val();
			// 绘制贡献率页面图表
			drawGongxianTable("GongxianChart",JSON.parse(chartkpiData).sort(compareObject('num')));
			// 初始化分页组件
			var total = $("#total").val();
			var pageNum = $("#pageNum").val();
			initPagination("#kpiPagination", total,20, pageNum);
			//订单日期
			$("body").delegate("#kpiCompletion-dateTime2","change",function(){
				var thetime=$(this).val();
				var dateType = $("#dateType").val();
				var start=$("#kpiCompletion-dateTime1").val();
				if(start == ''){
					alertErrorMsg("请选择开始日期！");
					$(this).val("");
					return;
				}
				var curDate=new Date();
				//日
				if(dateType == 'day'){
					var d=new Date(Date.parse(thetime.replace(/-/g,"/")));
					d.setDate(d.getDate()+1);
					if(d >= curDate)
					{
						alertErrorMsg("请选择小于今天的时间！");
						$(this).val("");
						return;
					}
					
				}
				//月
				if(dateType == 'month'){
					var d=new Date(Date.parse(thetime.replace(/-/g,"/")+'/01'));
					if(d.getFullYear() == curDate.getFullYear() && d.getMonth() > curDate.getMonth()){
						alertErrorMsg("请选择小于等于本月的日期！");
						$(this).val("");
						return;
					};
					
					
				}

			});
			$('#exportBtn').on('click',function(e){
				e.preventDefault();
				window.open('/statistic/kpi-contribution/export?'+$('#queryForm').serialize(),'_blank');

			});
		},
		events: function(){
			$("body").delegate("#submitForm","click",function(){
				//搜索，分页重新开始
				$("#pageNum").val(1);
				$("#queryForm").submit();
			}).delegate(".dateTypeSelect","change",function(){
				let target = $(this).attr("data-target").split(",");
				let val = $(this).val();
				if(val == 'day'){
					for(var i in target){
						$('#' + target[i]).datetimepicker('remove');
						$('#' + target[i]).val('');
						// 初始化日期选择插件
						$('#' + target[i]).datetimepicker({
					        format: 'yyyy-mm-dd',
					        autoclose: true,
					        startView: 2,
					        minView:2,
					        language:  'zh-CN',
						});
					}
				}else if(val == 'month'){
					for(var i in target){
						$('#' + target[i]).datetimepicker('remove');
						$('#' + target[i]).val('');
						// 初始化日期选择插件
						$('#' + target[i]).datetimepicker({
					        format: 'yyyy-mm',
					        autoclose: true,
					        startView: 3,
					        minView: 3,
					        language:  'zh-CN',
						});
					}
				}else if(val == 'year'){
					for(var i in target){
						$('#' + target[i]).datetimepicker('remove');
						$('#' + target[i]).val('');
						// 初始化日期选择插件
						$('#' + target[i]).datetimepicker({
					        format: 'yyyy',
					        autoclose: true,
					        startView: 4,
					        minView: 4,
					        language:  'zh-CN',
						});
					}
				}
			});
		}
	};
	H.kpiCompletion.init();
});