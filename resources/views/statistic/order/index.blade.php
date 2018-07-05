@extends('statistic.layout.main') @section('js')
<script src="/js/statistic/citySearch.js" type="text/javascript"></script>
<script src="/js/statistic/order.js" type="text/javascript"></script>
@endsection @section('content')
<!-- Tab -->
<ul id="pageTab" class="nav nav-tabs">
	<li><a href="#order" data-toggle="tab" data-id="order"> 原始表：订单 </a></li>
</ul>
<!-- Tabcontent -->
<div id="pageTabContent" class="tab-content">
	<!-- 订单 -->
	<div class="tab-pane fade" id="order">
		<!-- BEGIN PAGE BAR -->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><a href="home"><i class="fa fa-home"></i>首页</a> ></li>
				<li><span>数据管理</span></li>
			</ul>
		</div>
		<!-- END PAGE BAR -->
		<!-- BEGIN PAGE CONTENT -->
		@include('statistic.order.search')
		<div class="content-block">
			<div class="content-block-title">
				<span>KPI目标统计</span>
			</div>
			<div class="content-block-content">
				<div class="block-content-overflow">
					<table
						class="table table-striped table-bordered table-advance table-hover">
						<thead class="custom-thead">
							<tr class="main-title">
								<th colspan="11">订单状态</th>
								<th colspan="4">投资人信息</th>
								<th colspan="6">订单所属架构</th>
								<th colspan="3">订单推荐人信息</th>
								<th colspan="2">订单所属合作社</th>
								<th rowspan="2">操作</th>

							</tr>
							<tr>
								<th>序号</th>
								<th>产品类型</th>
								<th>订单号</th>
								<th>第三方订单编号</th>
								<th>订单生效日期</th>
								<th>预期到期时间</th>
								<th>冲抵费用（元）</th>
								<th>订单状态</th>
								<th>期数（月）</th>
								<th>投资金额（元）</th>
								<th>年化金额（元）</th>
								<th>投资用户姓名</th>
								<th>手机号</th>
								<th>性别</th>
								<th>年龄</th>
								<th>集团</th>
								<th>大区</th>
								<th>事业部</th>
								<th>片区</th>
								<th>项目</th>
								<th>地址</th>
								<th>推荐人姓名</th>
								<th>推荐人电话</th>
								<th>推荐人提成奖励（元）</th>
								<th>所属合作社ID</th>
								<th>合作社成立时间</th>
							</tr>
						</thead>
						<tbody id="result_field" class = 'order-edit-organize'>
							@foreach($rows as $v)
							<tr id = "tr-{{$v->id}}">
								<td>{{$v->id}}</td>
								<td>{{App\Statistic\Models\Order::$getModelName[$v->model_name]}}</td>
								<td>{{$v->sn}}</td>
								<td>{{$v->trade_no}}</td>
								<td>{{date('Y-m-d H:i',$v->begin_time)}}</td>
								<td>{{date('Y-m-d H:i',$v->stop_time)}}</td>
								<td>{{$v->offset_fees}}</td>
								<td>{{App\Statistic\Models\Order::$getStatus[$v->status]}}</td>
								<td>{{$v->months}}个月</td>
								<td>{{$v->investment_amount}}</td>
								<td>{{sprintf("%.2f",($v->investment_amount/12) * $v->months)}}</td>
								<td>{{$v->username}}</td>
								<td>{{$v->mobile}}</td>
								<td>{{App\Statistic\Models\Common::getSex($v->idcard_number)}}</td>
								<td>{{App\Statistic\Models\Common::getAge($v->idcard_number)}}</td>
								<td>
									<span class = "o_group">{{$v->name4}}</span>
									<select class="form-control none name4"   data-id="{{$v->id}}">
										<option value="">请选择集团</option>
										<option value="彩生活服务集团">彩生活服务集团</option>
									</select>
								</td>
								<td>
									<span class = "large_area">{{$v->name3}}</span>
									<select class="form-control none name3"  data-id="{{$v->id}}">

									</select>
								</td>
								<td>
									<span class = "department">{{$v->name2}}</span>
									<select class="form-control none name2"   data-id="{{$v->id}}">

									</select>
								</td>
								<td>
									<span class = 'area'>{{$v->name1}}</span>
									<select class="form-control none name1"   data-id="{{$v->id}}">

									</select>
								</td>
								<td>
									<span class = 'project'>{{$v->project_name}}</span>
									<select class="form-control none name" data-id="{{$v->id}}">

									</select>
								</td>
								<td>{{App\Statistic\Models\Order::getAddress($v->model_name,$v->sn)}}</td>
								<td>{{$v->recommend_name}}</td>
								<td>{{$v->recommend_mobile}}</td>
								<td>{{$v->profit_amount}}</td>
								<td>{{$v->club_id}}</td>
								<td>{{date('Y-m-d H:i',$v->created_at)}}</td>
								<td>
                                   <a class="btn orderEditBtn" data-id="{{$v->id}}">编辑</a>
                                   <a class="btn orderSaveBtn none" data-id="{{$v->id}}">保存</a>
                               </td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
				{{ $rows->links() }}
<!-- 					<div class="pagination" id="OrderPagination"></div> -->
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT -->
	</div>
</div>

@endsection
