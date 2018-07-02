@extends('statistic.layout.main') @section('js')
<script src="/js/statistic/citySearch.js" type="text/javascript"></script>
<script src="/js/statistic/cooperative.js" type="text/javascript"></script>

@endsection @section('content')
<div class="page-content-expand-btn unexpand"></div>
<!-- Tab -->
<ul id="pageTab" class="nav nav-tabs">
	<li><a href="#cooperative" data-toggle="tab" data-id="cooperative">
			统计表：合作社 </a></li>
</ul>
<!-- Tabcontent -->
<div id="pageTabContent" class="tab-content">
	<!-- 合作社 -->
	<div class="tab-pane fade" id="cooperative">
		<!-- BEGIN PAGE BAR -->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><a href="home"><i class="fa fa-home"></i>首页</a> ></li>
				<li><span>数据管理</span></li>
			</ul>
		</div>
		<!-- END PAGE BAR -->
		<!-- BEGIN PAGE CONTENT -->
		@include('statistic.cooperative.search')

		<div class="content-block">
			<!-- <div class="content-block-title">
                                    <span>合作社统计</span>
                                </div> -->
			<div class="content-block-content">
				<table
					class="table table-striped table-bordered table-advance table-hover">
					<thead class="custom-thead">
						<tr class="main-title">
							<th>排名</th>
							<th>合作社ID</th>
							<th>社名</th>
							<th>合作社成立时间</th>
							<th>社长姓名</th>
							<th>社长手机号</th>
							<th>社员人数</th>
							<th>在投人数</th>
							<th>在投金额（万元）</th>
							<th>年化金额（万元）</th>
							<th>冲抵订单金额（万元）</th>
							<th>所属项目</th>
							<th>社长所属事业部</th>
							<th>社长所属大区</th>
							<th>社长所属集团</th>
						</tr>
					</thead>
					<tbody id="result_field">
						@foreach($rows as $k => $v)
						<tr>
							<td>{{$k + 1 }}</td>
							<td>{{$v->club_id}}</td>
							<td>{{$v->name}}</td>
							<td>{{date('Y年-m月-d日',$v->created_at)}}</td>
							<td>{{$v->username}}</td>
							<td>{{$v->mobile}}</td>
							<td>{{$v->member}}</td>
							<td>{{$v->investment_person}}</td>
							<td>{{sprintf("%.2f",$v->investment_fee/10000,2)}}</td>
							<td>{{sprintf("%.2f",$v->annualized_fee/10000,2)}}</td>
							<td>{{sprintf("%.2f",$v->offset_fee/10000,2)}}</td>
							<td>{{$v->project}}</td>
							<td>{{$v->department}}</td>
							<td>{{$v->large_area}}</td>
							<td>{{$v->o_group}}</td>



						</tr>
						@endforeach

					</tbody>
				</table>
				<div class="row">
					<div class="col-md-12">
						{{ $rows->links() }}

					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT -->
	</div>
</div>
@endsection
