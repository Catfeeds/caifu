@extends('statistic.layout.main') @section('js')
<script src="/js/statistic/userNewlyAdd.js?v=222" type="text/javascript"></script>
@endsection @section('content')
<!-- Tab -->
<ul id="pageTab" class="nav nav-tabs">
	<li><a href="#userNewlyAdd" data-toggle="tab" data-id="userNewlyAdd">
			统计表：用户新增 </a></li>
</ul>
<!-- Tabcontent -->
<div id="pageTabContent" class="tab-content">
	<!-- 用户新增 -->
	<div class="tab-pane fade" id="userNewlyAdd">
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
			<div class="content-block-content">
				<div class="search-content user-page">
					<div class="new-user">
						<div class="new-item">
							<div class="new-left">
								<p class="left-top">昨日新增</p>
								<p class="left-bottom">用户数</p>
							</div>
							<p class="new-right">{{$rows['yesterday']['user_num']}}</p>
						</div>
						<div class="new-item oranage">
							<div class="new-left">
								<p class="left-top">昨日新增</p>
								<p class="left-bottom">推荐人数</p>
							</div>
							<p class="new-right">{{$rows['yesterday']['recommend_num']}}</p>
						</div>
						<div class="new-item yellow">
							<div class="new-left">
								<p class="left-top">昨日新增</p>
								<p class="left-bottom">合作社数</p>
							</div>
							<p class="new-right">{{$rows['yesterday']['club_num']}}</p>
						</div>
						<div class="new-item purpel">
							<div class="new-left">
								<p class="left-top">昨日新增</p>
								<p class="left-bottom">社员人数</p>
							</div>
							<p class="new-right">{{$rows['yesterday']['member_num']}}</p>
						</div>
					</div>
					<div class="btn-group">
						<a class="btn blue" id = 'exportBtn'>导出Excel</a>
						<a class="btn blue"	id="reStatistics">重新统计</a>
					</div>
				</div>
			</div>
		</div>
		<div class="content-block">

			<div class="content-block-content">
				<table
					class="table table-striped table-bordered table-advance table-hover">
					<thead class="custom-thead">
						<tr class="main-title">
							<th></th>
							<th>用户数</th>
							<th>推荐人数</th>
							<th>合作社数</th>
							<th>社员人数</th>
						</tr>
					</thead>
					<tbody id="result_field">
						<tr>
							<td>昨日新增</td>
							<td>{{$rows['yesterday']['user_num']}}</td>
							<td>{{$rows['yesterday']['recommend_num']}}</td>
							<td>{{$rows['yesterday']['club_num']}}</td>
							<td>{{$rows['yesterday']['member_num']}}</td>
						</tr>
						<tr>
							<td>本周累计</td>
							<td>{{$rows['currentWeek']['user_num']}}</td>
							<td>{{$rows['currentWeek']['recommend_num']}}</td>
							<td>{{$rows['currentWeek']['club_num']}}</td>
							<td>{{$rows['currentWeek']['member_num']}}</td>
						</tr>
						<tr>
							<td>年度累计</td>
							<td>{{$rows['currentYear']['user_num']}}</td>
							<td>{{$rows['currentYear']['recommend_num']}}</td>
							<td>{{$rows['currentYear']['club_num']}}</td>
							<td>{{$rows['currentYear']['member_num']}}</td>
						</tr>
						<tr>
							<td>历史累计</td>
							<td>{{$rows['all']['user_num']}}</td>
							<td>{{$rows['all']['recommend_num']}}</td>
							<td>{{$rows['all']['club_num']}}</td>
							<td>{{$rows['all']['member_num']}}</td>
						</tr>
					</tbody>
				</table>
				<div class="user-chart">
					<div class = 'user-char-line'>
					<div class="user-chart-item">
						<p>用户增长</p>
						<div class="search-item">
							<span>时间</span>
							<div class="search-right">
								<div class="search-inline">
									<input type="text" class="form-control dateTimePicker" value="{{date('Y-m-d',strtotime('-1 month'))}}"
										data-date-format="yyyy-mm-dd" placeholder="请选择日期"
										id="userNewlyAdd-dateTime1" data-field = 'user_num'> <i class="fas fa-calendar-alt"></i>
								</div>
								-
								<div class="search-inline">
									<input type="text" class="form-control dateTimePicker" value="{{date('Y-m-d',strtotime('-1 day'))}}"
										data-date-format="yyyy-mm-dd" data-field = 'user_num' placeholder="请选择日期"
										id="userNewlyAdd-dateTime2"> <i class="fas fa-calendar-alt"></i>
								</div>
								<span>单位：</span> <select class="form-control dateTypeSelect-user"
									data-target="userNewlyAdd-dateTime1,userNewlyAdd-dateTime2">
									<option value="day">日</option>
									<option value="month">月</option>
									<option value="year">年</option>
								</select>
							</div>
						</div>
						<div class="chart-content" id="userChart1"></div>
					</div>
					<div class="user-chart-item">
						<p>推荐人数增长</p>
						<div class="search-item">
							<span>时间</span>
							<div class="search-right">
								<div class="search-inline">
									<input type="text" class="form-control dateTimePicker" value="{{date('Y-m-d',strtotime('-1 month'))}}"
										data-date-format="yyyy-mm-dd" placeholder="请选择日期"
										id="userNewlyAdd-dateTime3" data-field = 'recommend_num'>
										<i class="fas fa-calendar-alt"></i>
								</div>
								-
								<div class="search-inline">
									<input type="text" class="form-control dateTimePicker" value="{{date('Y-m-d',strtotime('-1 day'))}}"
										data-date-format="yyyy-mm-dd" placeholder="请选择日期"
										id="userNewlyAdd-dateTime4" data-field = 'recommend_num'>
									<i class="fas fa-calendar-alt"></i>
								</div>
								<span>单位：</span> <select class="form-control dateTypeSelect-user2"
									data-target="userNewlyAdd-dateTime3,userNewlyAdd-dateTime4">
									<option value="day">日</option>
									<option value="month">月</option>
									<option value="year">年</option>
								</select>
							</div>
						</div>
						<div class="chart-content" id="userChart2"></div>
					</div>
					</div>
					<div class = 'user-char-line'>
					<div class="user-chart-item">
						<p>合作社增长</p>
						<div class="search-item">
							<span>时间</span>
							<div class="search-right">
								<div class="search-inline">
									<input type="text" class="form-control dateTimePicker" value="{{date('Y-m-d',strtotime('-1 month'))}}"
										data-date-format="yyyy-mm-dd" placeholder="请选择日期"
										id="userNewlyAdd-dateTime5" data-field = 'club_num'>
									 <i class="fas fa-calendar-alt"></i>
								</div>
								-
								<div class="search-inline">
									<input type="text" class="form-control dateTimePicker" value="{{date('Y-m-d',strtotime('-1 day'))}}"
										data-date-format="yyyy-mm-dd" placeholder="请选择日期"
										id="userNewlyAdd-dateTime6" data-field = 'club_num'>
									<i class="fas fa-calendar-alt"></i>
								</div>
								<span>单位：</span> <select class="form-control dateTypeSelect-user3"
									data-target="userNewlyAdd-dateTime5,userNewlyAdd-dateTime6">
									<option value="day">日</option>
									<option value="month">月</option>
									<option value="year">年</option>
								</select>
							</div>
						</div>
						<div class="chart-content" id="userChart3"></div>
					</div>
					<div class="user-chart-item">
						<p>社员人数增长</p>
						<div class="search-item">
							<span>时间</span>
							<div class="search-right">
								<div class="search-inline">
									<input type="text" class="form-control dateTimePicker" value="{{date('Y-m-d',strtotime('-1 month'))}}"
										data-date-format="yyyy-mm-dd" placeholder="请选择日期"
										id="userNewlyAdd-dateTime7" data-field = 'member_num'>
									<i class="fas fa-calendar-alt"></i>
								</div>
								-
								<div class="search-inline">
									<input type="text" class="form-control dateTimePicker" value="{{date('Y-m-d',strtotime('-1 day'))}}"
										data-date-format="yyyy-mm-dd" placeholder="请选择日期"
										id="userNewlyAdd-dateTime8" data-field = 'member_num'>
									<i class="fas fa-calendar-alt"></i>
								</div>
								<span>单位：</span> <select class="form-control dateTypeSelect-user4"
									data-target="userNewlyAdd-dateTime7,userNewlyAdd-dateTime8">
									<option value="day">日</option>
									<option value="month">月</option>
									<option value="year">年</option>
								</select>
							</div>
						</div>
						<div class="chart-content" id="userChart4"></div>
					</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT -->
	</div>
</div>


@endsection
