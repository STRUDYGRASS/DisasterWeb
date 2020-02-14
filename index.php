<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
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
    </style>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=3ccb5362c4712a1dd2df47f58f49188a">
    </script>
    <script type="text/javascript"
        src="http://api.map.baidu.com/library/TextIconOverlay/1.2/src/TextIconOverlay_min.js"></script>
    <script type="text/javascript"
        src="http://api.map.baidu.com/library/MarkerClusterer/1.2/src/MarkerClusterer_min.js"></script>
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>疫情地图</title>
</head>

<body>
    <div id="allmap"></div>
</body>

</html>

<script type="text/javascript">
    var myStyles = [{
        url: 'image/no1.jfif',
        size: new BMap.Size(30, 26),
        opt_anchor: [16, 0],
        textColor: '#ff00ff',
        opt_textSize: 10
    }, {
        url: 'image/no2.jfif',
        size: new BMap.Size(40, 35),
        opt_anchor: [40, 35],
        textColor: '#ff0000',
        opt_textSize: 12
    }, {
        url: 'image/no3.jfif',
        size: new BMap.Size(50, 44),
        opt_anchor: [32, 0],
        textColor: 'white',
        opt_textSize: 14
    }];
    var opts = {
        width: 250, // 信息窗口宽度
        height: 80, // 信息窗口高度
        title: "详细信息", // 信息窗口标题
        enableMessage: true //设置允许信息窗发送短息
    };

    function addClickHandler(content, marker) {
        marker.addEventListener("click", function (e) {
            openInfo(content, e)
        });
    };

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
                alert("数据更新失败！");
            }
        });
    }

    function UpdateInfos(time){
        UpdateInfo(time,"医院");
        UpdateInfo(time,"小区");
        UpdateThings();
    }

    // 定义一个控件类,即function
    function AttributeShow(what, size) {
        // 默认停靠位置和偏移量
        this.defaultAnchor = BMAP_ANCHOR_TOP_RIGHT;
        this.defaultOffset = new BMap.Size(10, size);
        this.what = what;
        this.show = true;
    }

    // 通过JavaScript的prototype属性继承于BMap.Control
    AttributeShow.prototype = new BMap.Control();

    // 自定义控件必须实现自己的initialize方法,并且将控件的DOM元素返回
    // 在本方法中创建个div元素作为控件的容器,并将其添加到地图容器中
    AttributeShow.prototype.initialize = function (map) {
        // 创建一个DOM元素
        var div = document.createElement("div");
        var That = this;
        // 添加文字说明
        div.appendChild(document.createTextNode("隐藏" + That.what));
        // 设置样式
        div.style.cursor = "pointer";
        div.style.border = "1px solid gray";
        div.style.backgroundColor = "white";
        div.onclick = function (e) {
            if (That.show) {
                That.show = false;
                div.firstChild.nodeValue = "显式" + That.what;
            } else {
                That.show = true;
                div.firstChild.nodeValue = "隐藏" + That.what;
            }
            UpdateThings();
        }
        // 添加DOM元素到地图中
        map.getContainer().appendChild(div);
        // 将DOM元素返回
        return div;
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
    UpdateInfos("2020-02-11");
</script>