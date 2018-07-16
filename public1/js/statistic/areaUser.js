$(function() {
	H.areaUser = {
		init: function(){
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
			// 选中左侧某个菜单
			selectLeftNode('nav-areaUser');
			// 选中上方某个tab
			$('#pageTab a[href="#areaUser"]').trigger('click');
			this.events();
			// 初始化日期选择插件
			$('#reStatisticsTime').datetimepicker({
				format: 'yyyy-mm-dd',
		        autoclose: true,
		        startView: 2,
		        minView:2,
		        language:  'zh-CN',
			});
			$('#exportBtn').on('click',function(e){
				e.preventDefault();
				window.open('/statistic/area-user/export?'+$('#formId').serialize(),'_blank');

			});
			// 初始化分页组件
			initPagination("#DqyhPagination", 100, 20, 1);
			// 绘制地区用户页面图表
			drawAreaTable("areaChart1",flushing,'冲抵覆盖率（单位：%）');
			drawAreaTable("areaChart2",president,'社长覆盖率（单位：%）');
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
				var time = $('#reStatisticsTime').val();
				if(!time){
					alertErrorMsg('请选择时间');
					return;
				}
				//重新统计弹层提交按钮事件，展示提示信息
				$("#reStatisticsPopup").addClass("none");
				showAlert('数据正在重新统计中...<br>24小时后统计结果才会刷新哦！');
				$.ajax({
					  type: 'POST',
					  url: '/statistic/area-user/reset',
					  data: {
						  'time' : time,

					  },
					  success: function(json){



					  		if(json.errcode == 0){
					  			showAlert('统计成功');
					  			window.location.reload();
					  		}else{
					  			alertErrorMsg(json.msg);
					  		}


					  },
					  dataType: 'json'
				});
			});
		}
	};
	H.areaUser.init();
});