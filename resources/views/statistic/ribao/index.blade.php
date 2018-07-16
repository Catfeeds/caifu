@extends('statistic.layout.main') @section('js')
<script src="/js/statistic/ribao.js?v=222222" type="text/javascript"></script>
@endsection @section('content')
<!-- Tab -->
<ul id="pageTab" class="nav nav-tabs">
	<li><a href="#ribao" data-toggle="tab" data-id="ribao"> 统计表：日报 </a></li>
</ul>
<!-- Tabcontent -->
<div id="pageTabContent" class="tab-content">
	<!-- 日报 -->
	<div class="tab-pane fade" id="ribao">
		<!-- BEGIN PAGE BAR -->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><a href="home"><i class="fa fa-home"></i>首页</a> ></li>
				<li><span>数据管理</span></li>
			</ul>
		</div>
		<!-- END PAGE BAR -->
		<!-- BEGIN PAGE CONTENT -->
		<div class="content-block">
<!-- 			<div class="content-block-title">
				<span>筛选</span>
			</div> -->
			<div class="content-block-content">
				<div class="search-content">
					<div class="btn-group">
						<a class="btn blue" id = 'exportBtn'>导出Excel</a>
						<a class="btn blue" id="reStatistics">重新统计</a>
					</div>
				</div>
			</div>
		</div>
		<div class="content-block">
<!-- 			<div class="content-block-title">
				<span>KPI完成情况统计</span>
			</div> -->
			<div class="content-block-content">
				<table
					class="table table-striped table-bordered table-advance table-hover">
					<thead class="custom-thead">
						<tr class="main-title">
							<th rowspan="2" class="splitTD"><span class="s2">时间</span>
								<p></p> <span class="s1">数据</span></th>
							<th colspan="4">冲抵</th>
							<th colspan="2">资金端</th>
							<th colspan="2">资产端</th>
							<th colspan="2">新增状况</th>
						</tr>
						<tr>
							<th>物业宝（万元）</th>
							<th>停车宝（万元）</th>
							<th>冲抵总金额（万元）</th>
							<th>冲抵总单数</th>
							<th>交易额（万元）</th>
							<th>单数</th>
							<th>交易额（万元）</th>
							<th>单数</th>
							<th>社长人数</th>
							<th>社员人数</th>
						</tr>
					</thead>
					<tbody id="result_field">
						<tr>
							<td>昨日数据</td>
							<td>{{sprintf("%.2f",$rows['yesterday']['property_fee']/10000)}}</td>
							<td>{{sprintf("%.2f",$rows['yesterday']['parking_fee']/10000)}}</td>
							<td>{{sprintf("%.2f",$rows['yesterday']['offset_fee']/10000)}}</td>
							<td>{{$rows['yesterday']['offset_num']}}</td>
							<td>{{sprintf("%.2f",$rows['yesterday']['investment_amounts']/10000)}}</td>
							<td>{{$rows['yesterday']['investment_num']}}</td>
							<td>{{sprintf("%.2f",$rows['yesterday']['assets_amounts']/10000)}}</td>
							<td>{{$rows['yesterday']['assets_num']}}</td>
							<td>{{$rows['yesterday']['manager_num']}}</td>
							<td>{{$rows['yesterday']['member_num']}}</td>
						</tr>
						<tr>
							<td>本月累计</td>
							<td>{{sprintf("%.2f",$rows['currentMonth']['property_fee']/10000)}}</td>
							<td>{{sprintf("%.2f",$rows['currentMonth']['parking_fee']/10000)}}</td>
							<td>{{sprintf("%.2f",$rows['currentMonth']['offset_fee']/10000)}}</td>
							<td>{{$rows['currentMonth']['offset_num']}}</td>
							<td>{{sprintf("%.2f",$rows['currentMonth']['investment_amounts']/10000)}}</td>
							<td>{{$rows['currentMonth']['investment_num']}}</td>
							<td>{{sprintf("%.2f",$rows['currentMonth']['assets_amounts']/10000)}}</td>
							<td>{{$rows['currentMonth']['assets_num']}}</td>
							<td>{{$rows['currentMonth']['manager_num']}}</td>
							<td>{{$rows['currentMonth']['member_num']}}</td>
						</tr>
						<tr>
							<td>年度累计</td>
							<td>{{sprintf("%.2f",$rows['currentYear']['property_fee']/10000)}}</td>
							<td>{{sprintf("%.2f",$rows['currentYear']['parking_fee']/10000)}}</td>
							<td>{{sprintf("%.2f",$rows['currentYear']['offset_fee']/10000)}}</td>
							<td>{{$rows['currentYear']['offset_num']}}</td>
							<td>{{sprintf("%.2f",$rows['currentYear']['investment_amounts']/10000)}}</td>
							<td>{{$rows['currentYear']['investment_num']}}</td>
							<td>{{sprintf("%.2f",$rows['currentYear']['assets_amounts']/10000)}}</td>
							<td>{{$rows['currentYear']['assets_num']}}</td>
							<td>{{$rows['currentYear']['manager_num']}}</td>
							<td>{{$rows['currentYear']['member_num']}}</td>
						</tr>
						<tr>
							<td>历史累计</td>
							<td>{{sprintf("%.2f",$rows['all']['property_fee']/10000)}}</td>
							<td>{{sprintf("%.2f",$rows['all']['parking_fee']/10000)}}</td>
							<td>{{sprintf("%.2f",$rows['all']['offset_fee']/10000)}}</td>
							<td>{{$rows['all']['offset_num']}}</td>
							<td>{{sprintf("%.2f",$rows['all']['investment_amounts']/10000)}}</td>
							<td>{{$rows['all']['investment_num']}}</td>
							<td>{{sprintf("%.2f",$rows['all']['assets_amounts']/10000)}}</td>
							<td>{{$rows['all']['assets_num']}}</td>
							<td>{{$rows['all']['manager_num']}}</td>
							<td>{{$rows['all']['member_num']}}</td>
						</tr>
					</tbody>
				</table>
				<div class="ribao-chart">
					<p>彩富人生平台投资金额</p>
					<div class="search-item">
						<span>时间</span>
						<div class="search-right">
							<div class="search-inline">
								<input type="text" class="form-control dateTimePicker stat-daily-begin_time" value="{{date('Y-m-d',strtotime('-1 month'))}}"
									data-date-format="yyyy-mm-dd" placeholder="请选择日期" > <i
									class="fas fa-calendar-alt"></i>
							</div>
							-
							<div class="search-inline">
								<input type="text" class="form-control dateTimePicker stat-daily-end_time" value="{{date('Y-m-d',strtotime('-1 day'))}}"
									data-date-format="yyyy-mm-dd" placeholder="请选择日期"> <i
									class="fas fa-calendar-alt"></i>
							</div>
							<a class="btn blue data-search" >搜索</a>
						</div>
					</div>
					<div class="chart-content" id="ribaoChart"></div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT -->
	</div>
</div>

@endsection
