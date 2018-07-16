@extends('statistic.layout.main') @section('js')
<script src="/js/statistic/citySearch.js" type="text/javascript"></script>
<script src="/js/statistic/kpiCompletion.js?v=2222" type="text/javascript"></script>

@endsection @section('content')
<!-- Tab -->
<ul id="pageTab" class="nav nav-tabs">
	<li><a href="#kpiCompletion" data-toggle="tab" data-id="kpiCompletion">
			统计表：KPI完成情况 </a></li>
</ul>
<!-- Tabcontent -->
<div id="pageTabContent" class="tab-content">
	<!-- KPI完成情况统计 -->
	<div class="tab-pane fade" id="kpiCompletion">
		<!-- BEGIN PAGE BAR -->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><a href="home"><i class="fa fa-home"></i>首页</a> ></li>
				<li><span>数据管理</span></li>
			</ul>
		</div>
		<!-- END PAGE BAR -->
		<!-- BEGIN PAGE CONTENT -->
		@include('statistic.kpi-complete.search')

		<div class="content-block">
			<!-- <div class="content-block-title">
                                    <span>KPI完成情况统计</span>
                                </div> -->
			<div class="content-block-content">
				<table
					class="table table-striped table-bordered table-advance table-hover">
					<thead class="custom-thead">
						<tr class="main-title">
							<th colspan="6">地区选择</th>
							<th colspan="5">KPI完成情况统计</th>
						</tr>
						<tr>
							<th>序号</th>
							<th>集团</th>
							<th>大区</th>
							<th>事业部</th>
							<th>片区</th>
							<th>项目</th>
							<th>时间（年/月/日）</th>
							<th>KPI（万元）</th>
							<th>GMV（万元）</th>
							<th>完成率</th>
						</tr>
					</thead>
					<tbody id="result_field">
						@foreach($rows as $k => $v)
						<tr>
							<td>{{$k + 1}}</td>
							<td>{{$v->name4}}</td>
							<td>{{$v->name3}}</td>
							<td>
								@if(in_array($groupField,['name2','name1','name']))
								{{$v->name2}}
								@endif
							</td>
							<td>
								@if($groupField == 'name1' || $groupField == 'name')
								{{$v->name1}}
								@endif
							</td>
							<td>
								@if($groupField == 'name')
								{{$v->name}}
								@endif
							</td>
							<td>

								@if(old('unit') == 'year')
								{{date('Y',$beginTime)}}
								@else
								{{old('begin_time',date('Y-m',$beginTime))}} -- {{old('end_time',date('Y-m',$endTime) )}}

								@endif
							</td>


							<td>
							@isset($organizeKpi[$v->$groupField])
							{{$organizeKpi[$v->$groupField]}}
							@endisset
							</td>
							<td>
							@isset($orderInfo[$v->$groupField])
							{{$orderInfo[$v->$groupField]}}
							@endisset
							</td>
							<td>

							@if(isset($orderInfo[$v->$groupField]) && isset($organizeKpi[$v->$groupField]))
							@if($organizeKpi[$v->$groupField] == 0)
							{{sprintf("%.2f",$orderInfo[$v->$groupField]*100,2).'%'}}

							@else
							{{sprintf("%.2f",($orderInfo[$v->$groupField]/$organizeKpi[$v->$groupField])*100,2).'%'}}
							@endif
							@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-12">
<!-- 						{{ $rows->links() }} -->
						<div id = 'kpiPagination'></div>
					</div>
				</div>
				<input type='hidden' value = "{{$chartTitle}}" class = 'chartTitle'>
				<input type='hidden' value = "{{date('Y',time()).'年'}}" class = 'chartDate'>

				<input type='hidden' value = "{{$chartkpiData}}" class = 'chartkpiData'>
				<div class="chart-content" id="kpiChart"></div>
			</div>
		</div>
		<!-- END PAGE CONTENT -->
	</div>
</div>

@endsection
