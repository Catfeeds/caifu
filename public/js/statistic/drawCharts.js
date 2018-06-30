/*-----KPI完成情况表格 S------*/
function drawKpiTable(id, time, area, data){
	if(!data || data.length <=0){
		return;
	}
	var timeList = [];
	var kpiList = [];
	var sumList = [];
	var percentList = [];
	for(var i = 0; i < data.length; i++){
		timeList.push(data[i].time);
		kpiList.push(data[i].kpi);
		sumList.push(data[i].sum);
		percentList.push((data[i].kpi/data[i].sum).toFixed(2) * 100);
	}
	var option = {
	    tooltip: {
	        trigger: 'axis'
	    },
        axisPointer: {
            type: 'line'
        },
	    title:{
	    	text: '' + time + area + 'KPI完成情况',
	    	top: 0,
	    	x: 'center',
	    	textStyle: {
	    		color: '#000000'
	    	}
	    },
	    legend: {
	    	bottom: 0,
	        data:['KPI（单位：万元）','金额总数（单位：万元）','完成率（单位：%）']
	    },
	    xAxis: [
	        {
	            type: 'category',
	            data: timeList,
	            axisPointer: {
	                type: 'shadow'
	            },
	            splitLine: {
	            	show: false
	            }
	        }
	    ],
	    yAxis: [
	        {
	            type: 'value',
	        },
	        {
	            type: 'value',
	        }
	    ],
	    series: [
	        {
	            name:'KPI（单位：万元）',
	            type:'bar',
	            data:kpiList
	        },
	        {
	            name:'金额总数（单位：万元）',
	            type:'bar',
	            data:sumList
	        },
	        {
	            name:'完成率（单位：%）',
	            type:'line',
	            yAxisIndex: 1,
	            data:percentList
	        }
	    ]
	};
    echarts.init(document.getElementById(id), 'walden').setOption(option, true);
}
/*-----KPI完成情况表格 E------*/
/*-----日报表格 S------*/
function drawRibaoTable(id, data){
	if(!data || data.length <=0){
		return;
	}
	var timeList = [];
	var moneyList = [];
	for(var i = 0; i < data.length; i++){
		timeList.push(data[i].time);
		moneyList.push(data[i].money);
	}
	var option = {
	    tooltip: {
	        trigger: 'axis',
	        axisPointer: {
	            type: 'line'
	        }
	    },
	    legend: {
	    	bottom: 0,
	        data:['投资金额（单位：万元）']
	    },
	    xAxis: {
            type: 'category',
            data: timeList,
            axisPointer: {
                type: 'shadow'
            },
            splitLine: {
            	show: false
            }
        },
	    yAxis: {
            type: 'value',
	        name: '投资金额',
	        nameLocation : 'center',
	        nameTextStyle:{
	        	fontSize: 13,
	        },
	        nameGap: 50,
        },
	    series: [
	        {
	            name:'投资金额（单位：万元）',
	            type:'line',
	            data:moneyList
	        }
	    ]
	};
    echarts.init(document.getElementById(id), 'walden').setOption(option, true);
}
/*-----日报表格 E------*/
/*-----新增用户表格 S------*/
function drawUserTable(id, data){
	if(!data || data.length <=0){
		return;
	}
	var timeList = [];
	var numList = [];
	for(var i = 0; i < data.length; i++){
		timeList.push(data[i].time);
		numList.push(data[i].num);
	}
	var option = {
	    tooltip: {
	        trigger: 'axis',
	        axisPointer: {
	            type: 'line'
	        }
	    },
	    xAxis: {
            type: 'category',
            data: timeList,
            axisPointer: {
                type: 'shadow'
            },
            splitLine: {
            	show: false
            }
        },
	    yAxis: {
            type: 'value',
        },
	    series: [
	        {
	            name:'新增用户',
	            type:'line',
	            data:numList
	        }
	    ]
	};
    echarts.init(document.getElementById(id), 'walden').setOption(option, true);
}
/*-----新增用户表格 E------*/
/*-----贡献率表格 S------*/
function drawGongxianTable(id, data){
	if(!data || data.length <=0){
		return;
	}
	var numList = [];
	for(var i = 0; i < data.length; i++){
		numList.push({
			name: data[i].area,
			value: data[i].num,
		});
	}
	var option = {
	    title : {
	        text: '地区KPI贡献率',
	    	top: 0,
	    	x: 'center',
	    	textStyle: {
	    		color: '#000000'
	    	}
	    },
	    tooltip : {
	        trigger: 'item',
	        formatter: "{a} <br/>{b} : {c} ({d}%)"
	    },
	    series : [
	        {
	            name: '贡献率',
	            type: 'pie',
	            center: ['50%', '50%'],
	            data: numList,
	            itemStyle: {
	                emphasis: {
	                    shadowBlur: 10,
	                    shadowOffsetX: 0,
	                    shadowColor: 'rgba(0, 0, 0, 0.5)'
	                }
	            }
	        }
	    ]
	};
    echarts.init(document.getElementById(id), 'walden').setOption(option, true);
}
/*-----贡献率表格 E------*/

/*-----地区用户表格 S------*/
function drawAreaTable(id, data,text){
	if(!data || data.length <=0){
		return;
	}
	var areaList = [];
	var percentList = [];
	for(var i = 0; i < data.length; i++){
		areaList.push(data[i].area);
		percentList.push(data[i].percent);
	}
	var option = {
	    tooltip: {
	        trigger: 'axis',
	        axisPointer: {
	            type: 'line'
	        }
	    },
	    xAxis: {
            type: 'category',
            data: areaList,
            axisPointer: {
                type: 'shadow'
            },
            splitLine: {
            	show: false
            }
        },
	    yAxis: {
            type: 'value',
        },
	    series: [
	        {
	            name:text,
	            type:'bar',
	            data:percentList
	        }
	    ]
	};
    echarts.init(document.getElementById(id), 'walden').setOption(option, true);
}
/*-----地区用户表格 E------*/