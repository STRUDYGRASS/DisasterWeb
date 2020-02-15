<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/DisasterWeb/php_func/rand_aks.php";
    $ak = rand_aks();
    $preAkUrl = "http://api.map.baidu.com/api?v=2.0&ak=";
    $src = $preAkUrl.$ak;
    echo "<script type=\"text/javascript\" ".'src='.$src."> </script>";
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style type="text/css">
        body,
        html,
        #allmap {
            width: 100%;
            height: 100%;
            overflow: hidden;
            margin: 0;
            font-family: "微软雅黑";
        }

        #l-map {
            height: 100%;
            width: 78%;
            float: left;
            border-right: 2px solid #bcbcbc;
        }

        #r-result {
            height: 100%;
            width: 20%;
            float: left;
        }
        .start {
            cursor: pointer;
        }

        .end {
            cursor: pointer;
            color: #fff;
            background: #b1b0b0;
            border: none;
        }
    </style>
    <script type="text/javascript"
        src="http://api.map.baidu.com/library/TextIconOverlay/1.2/src/TextIconOverlay_min.js"></script>
    <script type="text/javascript"
        src="http://api.map.baidu.com/library/MarkerClusterer/1.2/src/MarkerClusterer_min.js"></script>
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/MapWeb.js"></script>
    <title>疫情地图</title>
</head>

<body>
    <div id="allmap"></div>
</body>

</html>

<script type="text/javascript">
    

    function openInfo(content, e) {
        var p = e.target;
        var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
        var infoWindow = new BMap.InfoWindow(content, opts); // 创建信息窗口对象 
        map.openInfoWindow(infoWindow, point); //开启信息窗口
    };

    function UpdateThings() {
        var zoom = map.getZoom();
        // console.log(zoom)
        if (zoom < 15) {
            //获取屏幕边界
            var bound = map.getBounds();
            //清除以前的点
            markerClusterer1.clearMarkers(markers);
            markerClusterer2.clearMarkers(markers2);
            //清除数组的数据
            markers = [];
            markers2 = [];
            //添加小区和医院数据
            for (var i = 0; i < data_info.length; i++) {
                pt = new BMap.Point(data_info[i][0], data_info[i][1]);
                if (bound.containsPoint(pt) && mAS_INFO.show) {
                    var marker1 = new BMap.Marker(pt); // 创建标注  
                    var content = data_info[i][2];

                    markers.push(marker1);
                    addClickHandler(content, marker1);
                }
            }
            for (var i = 0; i < data_hsp.length; i++) {
                pt = new BMap.Point(data_hsp[i][0], data_hsp[i][1]);
                if (bound.containsPoint(pt) && mAS_HSP.show) {
                    var content = data_hsp[i][2];
                    var myIcon = new BMap.Icon("image/hsp.png", new BMap.Size(24, 24));

                    var marker2 = new BMap.Marker(pt, {
                        icon: myIcon
                    }); // 创建标注    
                    markers2.push(marker2);
                    addClickHandler(content, marker2);
                }
            }
            //添加聚合点
            markerClusterer1.addMarkers(markers);
            markerClusterer2.addMarkers(markers2);
        }
    }

    function UpdateInfo(m_time, m_thing) {
        $.ajax({
            url: "server.php",
            type: "POST",
            data: {
                time: m_time,
                thing: m_thing
            },
            cache: false,
            dataType: "json",
            success: function (data) {
                if (m_thing == "医院") {
                    data_hsp = data;
                } else if (m_thing == "小区") {
                    data_info = data;
                }
            },
            error: function (err) {
                alert(JSON.stringify(err));
                alert("数据更新失败！");
            }
        });
    }

    function UpdateInfos(time){
        UpdateInfo(time,"医院");
        UpdateInfo(time,"小区");
        UpdateThings();
    }
    
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    // map.centerAndZoom("泉州",12);  
    map.centerAndZoom(new BMap.Point(118.680144, 24.880476), 13); //须显式设置地图中心，不然会报错
    map.enableScrollWheelZoom(); //启用滚轮放大缩小，默认禁用
    map.enableContinuousZoom(); //启用地图惯性拖拽，默认禁用

    //初始化打点数据
    var markers = [];
    var markers2 = [];
    //初始化点聚合
    var markerClusterer1 = new BMapLib.MarkerClusterer(map, {
        markers: markers
    });
    var markerClusterer2 = new BMapLib.MarkerClusterer(map, {
        markers: markers2
    });

    markerClusterer2.setStyles(myStyles);
    markerClusterer1.setGridSize(100);
    // 编写自定义函数,创建标注
    // 编写自定义函数,创建标注



    var top_left_control = new BMap.ScaleControl({
        anchor: BMAP_ANCHOR_TOP_LEFT
    }); // 左上角，添加比例尺
    var top_left_navigation = new BMap.NavigationControl(); //左上角，添加默认缩放平移控件
    var top_right_navigation = new BMap.NavigationControl({
        anchor: BMAP_ANCHOR_TOP_RIGHT,
        type: BMAP_NAVIGATION_CONTROL_SMALL
    }); //右上角，仅包含平移和缩放按钮
    /*缩放控件type有四种类型:
    BMAP_NAVIGATION_CONTROL_SMALL：仅包含平移和缩放按钮；BMAP_NAVIGATION_CONTROL_PAN:仅包含平移按钮；BMAP_NAVIGATION_CONTROL_ZOOM：仅包含缩放按钮*/



    //添加控件和比例尺
    map.addControl(top_left_control);
    map.addControl(top_left_navigation);
    // map.addControl(top_right_navigation);    


    var size = new BMap.Size(10, 20);
    map.addControl(new BMap.CityListControl({
        anchor: BMAP_ANCHOR_TOP_RIGHT,
        offset: size,
        // 切换城市之前事件
        // onChangeBefore: function(){
        //    alert('before');
        // },
        // 切换城市之后事件
        // onChangeAfter:function(){
        //   alert('after');
        // }
    }));

    //为什么不写成直接函数封装呢？因为这样就只运行一次了，我也不知道为什么
    map.addEventListener("dragend", function () {
        UpdateThings();
    });
    map.addEventListener("zoomend", function () {
        UpdateThings();
    });

    // 创建控件
    var mAS_HSP = new AttributeShow("医院", 80);
    var mAS_INFO = new AttributeShow("小区", 120);
    // 添加到地图当中
    map.addControl(mAS_HSP);
    map.addControl(mAS_INFO);
    var timelist =  GetTime();
    var timeline = new TimeLine("2020-02-11");
    map.addControl(timeline);
    var data_info = [];
    var data_hsp = [];
    UpdateInfos("2020-02-11");
</script>