@extends('statistic.layout.main') @section('js')
<script src="/js/statistic/citySearch.js" type="text/javascript"></script>
<script src="/js/statistic/userCooperative.js" type="text/javascript"></script>
@endsection @section('content')
<!-- Tab -->
<ul id="pageTab" class="nav nav-tabs">
	<li><a href="#userCooperative" data-toggle="tab"
		data-id="userCooperative"> 原始表：用户合作社 </a></li>
</ul>
<!-- Tabcontent -->
<div id="pageTabContent" class="tab-content">
	<!-- 合作社 -->
	<div class="tab-pane fade" id="userCooperative">
		<!-- BEGIN PAGE BAR -->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><a href="home"><i class="fa fa-home"></i>首页</a> ></li>
				<li><span>数据管理</span></li>
			</ul>
		</div>
		<!-- END PAGE BAR -->
		<!-- BEGIN PAGE CONTENT -->
		@include('statistic.user-cooperative.search')
		<div class="content-block">
			<div class="content-block-title">
				<span>合作社统计</span>
			</div>
			<div class="content-block-content">
				 <div class = 'block-content-overflow'>
				<table
					class="table table-striped table-bordered table-advance table-hover">
					<thead class="custom-thead">
						<tr class="main-title">
							<th colspan="11">用户信息</th>
							<th colspan="5">所属地区架构</th>
						</tr>
						<tr>
							<th>用户ID</th>
							<th>用户手机号</th>
							<th>用户姓名</th>
							<th>性别</th>
							<th>年龄</th>
							<th>注册时间</th>
							<th>社员/社长</th>
							<th>入社时间</th>
							<th>合作社ID</th>
							<th>所属合作社</th>
							<th>集团</th>
							<th>大区</th>
							<th>事业部</th>
							<th>片区</th>
							<th>项目</th>
						</tr>
					</thead>
					<tbody id="result_field">
						@foreach($rows as $v)
						<tr>
							<td>{{$v->id}}</td>
							<td>{{$v->mobile}}</td>
							<td>{{$v->username}}</td>
							<td>{{App\Statistic\Models\Common::getSex($v->idcard_number)}}</td>
							<td>{{App\Statistic\Models\Common::getAge($v->idcard_number)}}</td>
							<td>{{date('Y-m-d H:i',$v->created_at)}}</td>
							<td>
							@if($v->status == 1)
								@if($v->id == $v->president_id)
    							社长
    							@else
    							社员
    							@endif
							@endif
							</td>
							<td>
								@if($v->status == 1)
								{{date('Y-m-d H:i',$v->join_club_time)}}
								@endif
							</td>
							<td>
							@if($v->status == 1)
								{{$v->club_id}}
							@endif
							</td>
							<td>
							@if($v->status == 1)
								{{$v->club_name}}
							@endif
							</td>
							<td>{{$v->name4}}</td>
							<td>{{$v->name2}}</td>
							<td>{{$v->name3}}</td>
							<td>{{$v->name1}}</td>
							<td>{{$v->project_name}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				</div>
				<div class="row">
					<div class="col-md-12">
						{{ $rows->links() }}
<!-- 						<div class="pagination" id="userHzsPagination"></div> -->
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT -->
	</div>
</div>

@endsection
