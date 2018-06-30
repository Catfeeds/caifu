@extends('statistic.layout.main') @section('js')
<script src="/js/statistic/citySearch.js" type="text/javascript"></script>
<script src="/js/statistic/areaUser.js?v=11" type="text/javascript"></script>
@endsection @section('content')
<!-- Tab -->
<ul id="pageTab" class="nav nav-tabs">
	<li><a href="#areaUser" data-toggle="tab" data-id="areaUser"> 统计表：地区用户
	</a></li>
</ul>
<!-- Tabcontent -->
<div id="pageTabContent" class="tab-content">
	<!-- 地区用户 -->
	<div class="tab-pane fade" id="areaUser">
		<!-- BEGIN PAGE BAR -->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><a href="home"><i class="fa fa-home"></i>首页</a> ></li>
				<li><span>数据管理</span></li>
			</ul>
		</div>
		<!-- END PAGE BAR -->
		<!-- BEGIN PAGE CONTENT -->
		@include('statistic.area-user.search')

		<div class="content-block">
			<div class="content-block-title">
				<span>地区用户统计</span>
			</div>
			<div class="content-block-content">
				<table
					class="table table-striped table-bordered table-advance table-hover">
					<thead class="custom-thead">
						<tr class="main-title">
							<th colspan="6">地区</th>
							<th colspan="10">用户信息</th>
						</tr>
						<tr>
							<th>集团</th>
							<th>大区</th>
							<th>事业部</th>
							<th>片区</th>
							<th>项目</th>
							<th>业主数</th>
							<th>员工数</th>
							<th>投资户数</th>
							<th>冲抵户数</th>
							<th>冲抵覆盖率</th>
							<th>复投户数</th>
							<th>复投率</th>
							<th>推荐人数</th>
							<th>社长数</th>
							<th>社长覆盖率</th>
						</tr>
					</thead>
					<tbody id="result_field">
						@foreach($rows as $v)
						<tr>
							<td>{{$v->o_group}}</td>
							<td>{{$v->large_area}}</td>
							<td>{{$v->department}}</td>
							<td>{{$v->area}}</td>
							<td>{{$v->project}}</td>
							<td>{{$v->owner_num}}</td>
							<td>{{$v->staff_num}}</td>
							<td>{{$v->investment_num}}</td>
							<td>{{$v->flushing_num}}</td>
							<td>{{(sprintf("%.2f",$v->flushing_num/$v->owner_num)*100).'%'}}</td>
							<td>{{$v->recast_num}}</td>
							<td>{{(sprintf("%.2f",$v->recast_num/$v->investment_num)*100).'%'}}</td>
							<td>{{$v->referee_num}}</td>
							<td>{{$v->president_num}}</td>
							<td>{{(sprintf("%.2f",$v->president_num/$v->staff_num)*100).'%'}}</td>
						</tr>
					@endforeach

					</tbody>
				</table>
				<div class="row">
					<div class="col-md-12">
						{{ $rows->links() }}
					</div>
				</div>
				<div class="user-chart">
					<div class="user-chart-item">
						<p>彩生活服务集团各大区冲抵覆盖率</p>
<!-- 						<div class="search-item"> -->
<!-- 							<span>统计时间:</span> -->
<!-- 							<div class="search-right"> -->
<!-- 								<span>2018年1月1日</span> - <span>2018年1月1日</span> -->
<!-- 							</div> -->
<!-- 						</div> -->
						<div class="chart-content" id="areaChart1"></div>
					</div>
					<div class="user-chart-item">
						<p>彩生活服务集团各大区社长覆盖率</p>
<!-- 						<div class="search-item"> -->
<!-- 							<span>统计时间:</span> -->
<!-- 							<div class="search-right"> -->
<!-- 								<span>2018年1月1日</span> - <span>2018年1月1日</span> -->
<!-- 							</div> -->
<!-- 						</div> -->
						<div class="chart-content" id="areaChart2"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT -->
	</div>
</div>
<<script type="text/javascript">
	var flushing = @php echo $flushing  @endphp;
	var president = @php echo $president  @endphp;

</script>
@endsection
