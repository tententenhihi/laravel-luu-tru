(()=>{function t(t,a){for(var e=0;e<a.length;e++){var n=a[e];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}var a=function(){function a(){!function(t,a){if(!(t instanceof a))throw new TypeError("Cannot call a class as a function")}(this,a)}var e,n;return e=a,n=[{key:"initCharts",value:function(){var t=$("div[data-stats]").data("stats"),a=$("div[data-country-stats]").data("country-stats"),e=$("div[data-lang-pageviews]").data("lang-pageviews"),n=$("div[data-lang-visits]").data("lang-visits"),i=[];$.each(t,(function(t,a){i.push({axis:a.axis,visitors:a.visitors,pageViews:a.pageViews})})),new Morris.Area({element:"stats-chart",resize:!0,data:i,xkey:"axis",ykeys:["visitors","pageViews"],labels:[n,e],lineColors:["#dd4d37","#3c8dbc"],hideHover:"auto",parseTime:!1});var o={};$.each(a,(function(t,a){o[a[0]]=a[1]})),$(document).find("#world-map").vectorMap({map:"world_mill_en",backgroundColor:"transparent",regionStyle:{initial:{fill:"#e4e4e4","fill-opacity":1,stroke:"none","stroke-width":0,"stroke-opacity":1}},series:{regions:[{values:o,scale:["#c64333","#dd4b39"],normalizeFunction:"polynomial"}]},onRegionLabelShow:function(t,a,e){void 0!==o[e]&&a.html(a.html()+": "+o[e]+" "+n)}})}}],null&&t(e.prototype,null),n&&t(e,n),a}();$(document).ready((function(){BDashboard.loadWidget($("#widget_analytics_general").find(".widget-content"),route("analytics.general"),null,(function(){a.initCharts()})),$(document).on("click","#widget_analytics_general .portlet > .portlet-title .tools > a.reload",(function(t){t.preventDefault(),BDashboard.loadWidget($("#widget_analytics_general").find(".widget-content"),route("analytics.general"),null,(function(){a.initCharts()}))})),BDashboard.loadWidget($("#widget_analytics_page").find(".widget-content"),route("analytics.page")),BDashboard.loadWidget($("#widget_analytics_browser").find(".widget-content"),route("analytics.browser")),BDashboard.loadWidget($("#widget_analytics_referrer").find(".widget-content"),route("analytics.referrer"))}))})();
