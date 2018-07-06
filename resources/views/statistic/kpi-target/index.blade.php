@extends('statistic.layout.main')

@section('js')
  <script src="/js/statistic/citySearch.js" type="text/javascript"></script>
  <script src="/js/statistic/kpiTarget.js?v=1" type="text/javascript"></script>

@endsection

@section('content')
<ul id="pageTab" class="nav nav-tabs">
	<li><a href="#kpiTarget" data-toggle="tab" data-id="kpiTarget">
			原始表：KPI目标 </a></li>
</ul>
<!-- Tabcontent -->
<div id="pageTabContent" class="tab-content">
	<!-- KPI目标 -->
	<div class="tab-pane fade" id="kpiTarget">
		<!-- BEGIN PAGE BAR -->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><a href="home"><i class="fa fa-home"></i>首页</a> ></li>
				<li><span>数据管理</span></li>
			</ul>
		</div>
		<!-- END PAGE BAR -->
		<!-- BEGIN PAGE CONTENT -->

		@include('statistic.kpi-target.search')

		<div class="content-block">
<!-- 			<div class="content-block-title">
				<span>KPI目标统计</span>
			</div> -->
			<div class="content-block-content">
			    <div class = 'block-content-overflow'>
				<table class="table table-striped table-bordered table-advance table-hover">
					<thead class="custom-thead">
						<tr class="main-title">
							<th colspan="6">所属组织架构</th>
							<th colspan="14">2018年KPI目标设置（单位：万元）</th>
						</tr>
						<tr>
							<th>序号</th>
							<th>集团</th>
							<th>大区</th>
							<th>事业部</th>
							<th>片区</th>
							<th>项目</th>
							<th>年份</th>
							<th>1月</th>
							<th>2月</th>
							<th>3月</th>
							<th>4月</th>
							<th>5月</th>
							<th>6月</th>
							<th>7月</th>
							<th>8月</th>
							<th>9月</th>
							<th>10月</th>
							<th>11月</th>
							<th>12月</th>
							<th>全年</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="result_field">
						@foreach($rows as $v)
						<tr id="tr-{{$v->id}}">
							<td>{{$v->id}}</td>

							<td>{{$v->o_group}}</td>
							<td>{{$v->large_area}}</td>
							<td>{{$v->department}}</td>
							<td>{{$v->area}}</td>
							<td>{{$v->project}}</td>
							<td>{{$v->year}}</td>
							<td><span>{{$v->month01}}</span><input type="number" name = 'month01' value="{{$v->month01}}" class="form-control none" /></td>
							<td><span>{{$v->month02}}</span><input type="number" name = 'month02' value="{{$v->month02}}" class="form-control none" /></td>
							<td><span>{{$v->month03}}</span><input type="number" name = 'month03' value="{{$v->month03}}" class="form-control none" /></td>
							<td><span>{{$v->month04}}</span><input type="number" name = 'month04' value="{{$v->month04}}" class="form-control none" /></td>
							<td><span>{{$v->month05}}</span><input type="number" name = 'month05' value="{{$v->month05}}" class="form-control none" /></td>
							<td><span>{{$v->month06}}</span><input type="number" name = 'month06' value="{{$v->month06}}" class="form-control none" /></td>
							<td><span>{{$v->month07}}</span><input type="number" name = 'month07' value="{{$v->month07}}" class="form-control none" /></td>
							<td><span>{{$v->month08}}</span><input type="number" name = 'month08' value="{{$v->month08}}" class="form-control none" /></td>
							<td><span>{{$v->month09}}</span><input type="number" name = 'month09' value="{{$v->month09}}" class="form-control none" /></td>
							<td><span>{{$v->month10}}</span><input type="number" name = 'month10' value="{{$v->month10}}" class="form-control none" /></td>
							<td><span>{{$v->month11}}</span><input type="number" name = 'month11' value="{{$v->month11}}" class="form-control none" /></td>
							<td><span>{{$v->month12}}</span><input type="number" name = 'month12' value="{{$v->month12}}" class="form-control none" /></td>
							<td><span>{{$v->annual}}</span><input type="number"  name = 'annual' value="{{$v->annual}}" class="form-control none" /></td>
							<td>
								<a class="btn apiTargetEditBtn" data-id="{{$v->id}}">编辑</a>
                                <a class="btn apiTargetSaveBtn none" data-id="{{$v->id}}">保存</a>
							</td>
						</tr>
						@endforeach

					</tbody>
				</table>
				</div>
				<div class="row">
					<div class="col-md-12">
						{{ $rows->links() }}
<!-- 						<div class="pagination" id="KPITargetPagination"></div> -->
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT -->
	</div>
</div>
@endsection