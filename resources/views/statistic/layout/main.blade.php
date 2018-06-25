<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="format-detection" content="telephone=no">
	<meta name="msapplication-tap-highlight" content="no">
	<meta name="viewport" content="user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1,width=device-width">
	<meta name="screen-orientation" content="portrait">
	<meta name="x5-orientation" content="portrait">
	<meta name="full-screen" content="yes">
	<meta name="x5-fullscreen" content="true">
	<meta name="browsermode" content="application">
	<meta name="x5-page-mode" content="app">
	<meta name="msapplication-tap-highlight" content="no">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>彩富人生</title>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="/assets/plugins/font-awesome/css/fontawesome-all.css" rel="stylesheet" type="text/css" />
	<link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN THEME GLOBAL STYLES -->
	<link href="/assets/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
	<link href="/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
	<!-- END THEME GLOBAL STYLES -->
	<!-- BEGIN THEME LAYOUT STYLES -->
	<link href="/assets/plugins/layouts/css/layout.min.css" rel="stylesheet" type="text/css" />
	<link href="/assets/plugins/layouts/css/themes/light.min.css" rel="stylesheet" type="text/css" id="style_color" />
	<link href="/assets/plugins/layouts/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
	<link href="/assets/plugins/pagination/pagination.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
	<link href="/css/statistic/global.css" rel="stylesheet" type="text/css" />
	<script src="/assets/plugins/jquery.min.js" type="text/javascript"></script>
	@yield('css')

</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            @include('statistic.layout.header')
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                @include('statistic.layout.sidebar')
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
					@yield('content')
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- 重新统计弹层 -->
        <div class="popup none" id="reStatisticsPopup">
            <div class="popup-main">
                <a class="close-btn"><i class="fa fa-times"></i></a>
                <p class="popup-title">重新统计</p>
                <p class="reStatistics-tips">请选择重新统计的起始日期<br>本统计表的数据将从该日起重新统计</p>
                <div class="reStatistics-time">
                    <input type="text" class="form-control" id="reStatisticsTime" value="" data-date-format="yyyy-mm-dd" placeholder="请选择日期">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a class="btn blue" id="reCommitBtn">提交</a>
            </div>
        </div>
        <!-- END CONTAINER -->
        <script src="/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="/assets/plugins/bootstrap-datetimepicker/locales/bootstrap-datepicker.zh-CN.min.js" type="text/javascript"></script>
		<!-- END CORE PLUGINS -->
		<!-- BEGIN THEME GLOBAL SCRIPTS -->
		<script src="/assets/scripts/app.min.js" type="text/javascript"></script>
		<!-- END THEME GLOBAL SCRIPTS -->
		<!-- BEGIN THEME LAYOUT SCRIPTS -->
		<script src="/assets/plugins/layouts/scripts/layout.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="/assets/plugins/pagination/jquery.pagination.js"></script>
        <script type="text/javascript" src="/assets/plugins/pagination/pagination-common.js"></script>
        <script type="text/javascript" src="/assets/plugins/echart/echarts.min.js"></script>
        <script type="text/javascript" src="/assets/plugins/echart/walden.js"></script>
		<!-- END THEME LAYOUT SCRIPTS -->
        <script src="/assets/scripts/util.js" type="text/javascript"></script>
        <script src="/js/statistic/drawCharts.js" type="text/javascript"></script>
        <script src="/js/statistic/data.js" type="text/javascript"></script>
        <script src="/js/statistic/kpiTarget.js" type="text/javascript"></script>
        @yield('js')
    </body>
</html>
