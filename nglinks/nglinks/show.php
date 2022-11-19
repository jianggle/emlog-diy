<?php 
  if(!defined('EMLOG_ROOT')) {
    header("HTTP/1.1 404 Not Found");
    exit();
  }
?>
<!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-transform"/>
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<meta name="renderer" content="webkit">
<meta name="robots" content="noindex, nofollow">
<title>念链不忘</title>
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<link rel="shortcut icon" href="favicon.ico"/>
<link rel="bookmark" href="favicon.ico"/>
<script src="content/plugins/nglinks/js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="content/plugins/nglinks/js/angular.min.js" type="text/javascript"></script>
<style>
*{margin:0;padding:0}
li,ol,ul{list-style:none}
a{text-decoration:none}
body{font:14px Microsoft YaHei;color:#444;background:#f6f6f6;position:relative}
.w1200{margin:0 auto;width:1200px;position:relative}
.nav-left{width:140px;background:#3a6ea5;position:fixed;}
.nav-left li{display:block;padding:10px 0;text-align:center;color:#fff;border-bottom:1px solid #fff;cursor:pointer}
.nav-left li:hover, .nav-left li.current{border-left:5px solid #3a6ea5;background:#fff;color:#3a6ea5}
.nav-right{margin-left:160px;}
.link-group{overflow:hidden;margin-bottom:20px}
.link-group h3{width:140px;padding:10px;background:#3a6ea5;color:#fff;font-size:16px;font-weight:normal}
.link-group ul{margin-right:-1%}
.link-group ul dl{float:left;width:19%;margin:1% 1% 0 0;padding:14px;font-size:12px;overflow:hidden;background:#fff;color:#aaa;}
.link-group ul dl a{display:block;color:#666;}
.link-group ul dl a dt{
  font-size:14px;
  font-weight:700;
  color:#3a6ea5;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.link-group ul dl a:hover dt{color:#f00;}
.link-group ul dl a dd{
  margin-top:6px;
  height:32px;
  line-height:16px;
  word-break:break-all;
  overflow:hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}
</style>
</head>

<body ng-app="linkApp">
<div class="w1200" ng-controller="linksCtrl">
  <div class="nav-left">
    <li ng-repeat="x in linksort" repeat-finish="navGo()" sid="{{x.linksort_id}}">{{x.linksort_name}}({{x.num}})</li>
  </div>
  <div class="nav-right">
    <div ng-repeat="x in linklist" class="link-group" id="item{{x.sort_id}}">
      <h3>{{x.sort_name}}</h3>
      <ul>
        <dl ng-repeat="y in x.list">
          <a ng-href="{{y.siteurl}}" title="{{y.description}}" target="_blank">
            <dt>{{y.sitename}}</dt>
            <dd>{{y.description}}</dd>
          </a>
        </dl>
      </ul>
    </div>
  </div>
</div>
<script>
angular.module('linkApp', [])
.directive('repeatFinish', function(){
  return {
    link: function(scope,element,attr){
      if(scope.$last == true){
        scope.$eval(attr.repeatFinish)
      }
    }
  }
})
.controller("linksCtrl", function($scope,$http){
  $scope.linksort = <?php echo $linksort;?>;
  $scope.linklist = <?php echo $links;?>;
  $scope.navGo = function(){
    $(".nav-left li").click(function(){
      $(this).addClass("current")
      $(this).siblings().removeClass()
      var sid = $(this).attr("sid")
      var sitem = "#item" + sid
      $('html,body').animate({
        scrollTop:$(sitem).offset().top
      }, 250)
    })
  }
})
</script>
</body>
</html>
