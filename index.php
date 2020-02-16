<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/php_func/rand_aks.php";
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

        .container{
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .modal-dialog {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }
 
        .modal-content {
            /*overflow-y: scroll; */
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }
 
        .modal-body {
            overflow-y: scroll;
            position: absolute;
            top: 55px;
            bottom: 65px;
            width: 100%;
        }
 
        .modal-header .close {margin-right: 15px;}
 
        .modal-footer {
            position: absolute;
            width: 100%;
            bottom: 0;
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
    <div class="container">
        <div id="allmap"></div>
        <div style="position: absolute; bottom: 5px; right: 200px;" class="div-clear">
            <span>
                <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                    <span class="glyphicon glyphicon glyphicon-zoom-in"></span>免责声明
                </button>
        </div>
        <div style="position: absolute; bottom: 0px; right: 20px;" class="div-by">
            <span>
                <a style="font-style: ; font-size:30px; font-weight: bold; color: #B3B3B3;">
                    <span class="glyphicon glyphicon-user" ></span>XXX团队
                </a>
            </span>
        </div>
    </div>
    <!-- 模态框（Modal） -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                        <h1 class="modal-title" id="myModalLabel" style="text-align: center;">
                            【免责声明】
                        </h1>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 column">
                      <p>
                         <em>1、</em> <strong>《新冠肺炎疫情地图》</strong>基于各省市卫生健康委员会、人民政府、定点医院等官网公布的确诊病例活动轨迹及医院概况，进行了时间、地点、等信息的自动抽取与信息标注。并通过百度地图提供的相关API进行可视化呈现。
                      </p>
                      <p>
                         <em>2、</em> 本网站只是对以上信息来源的信息进行了可视化呈现。由于消息来源存在信息提供不完全的情况（如确诊病例活动轨迹缺失、地点名称不准确等），呈现结果仅供参考。本网站不保证呈现的信息全部准确，<strong>亦不承担任何法律责任</strong>。
                      </p>
                      <p>
                         <em>3、</em> 任何由于黑客攻击、计算机病毒侵入或发作、因政府管制而造成的暂时性关闭等影响网络正常经营的不可抗力而造成的直接或间接损失，本网站<strong>概不负责</strong>。
                      </p>
                      <p>
                         <em>4、</em> 因和本网站链接的其它网站所造成的个人资料泄露及由此而导致的任何法律争议和后果，本网站<strong>概不负责</strong>。
                      </p>
                      <p>
                         <em>5、</em> 本网站如因系统维护或升级而需暂停服务时，将事先公告。若因线路及非本团队控制范围外的硬件故障或其它不可抗力而导致暂停服务，于暂停服务期间造成的一切不便与损失，本网站<strong>概不责任</strong>。
                      </p>
                      <p>
                         <em>6、</em> 本网站使用者因为违反本声明的规定而触犯中华人民共和国法律的，一切后果由使用者自行承担，本网站<strong>概不负责</strong>。
                      </p>
                      <p>
                         <em>7、</em> 凡以任何方式登陆本网站或直接、间接使用本网站资料者，视为自愿接受本网站声明的约束。
                      </p>
                      <p>
                         <em>8、</em> 本网站若无意中侵犯了某个媒体或个人的知识产权，请等留言区功能开放后在留言区向我们反馈，我们将立即删除。
                      </p>
                      <p>
                         <em>9、</em> 呈现内容如有任何信息标注错误或地图呈现错误，请等留言区功能开放后在留言区向我们反馈，我们会及时对您留言中提出的问题进行检查与更正。
                      </p>
                      <p>
                         <em>10、</em><strong>最终解释权归本团队所有</strong>。
                      </p>
                      <p>
                         <b>【注意】</b> 地图上所呈现数字为<strong>疫情出现地点数</strong>，并非病例人数。
                      </p>
                    </div>
                </div>
            </div><!-- /.modal-content -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="javascrtpt:window.location.href='about:blank'">拒绝</button>
                <button type="button" class="btn btn-success" data-dismiss="modal">同意</button>
            </div>
        </div><!-- /.modal -->
    </div>
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
		    async: false,
            data: {
                time: m_time,
                thing: m_thing
            },
            cache: false,
            dataType: "json",
	    success: function (data) {
                if (m_thing == "定点医院") {
                    data_hsp = data;
                } else if (m_thing == "详细地址") {
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
        UpdateInfo(time,"定点医院");
        UpdateInfo(time,"详细地址");
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
    var mAS_HSP = new AttributeShow("定点医院", 80,"image/hsp.png");
    var mAS_INFO = new AttributeShow("详细地址", 120,"image/info.png");
    // 添加到地图当中
    map.addControl(mAS_HSP);
    map.addControl(mAS_INFO);
    var timelist =  GetTime();
    var timeline = new TimeLine("2020-02-11");
    map.addControl(timeline);
    var data_info = [];
    var data_hsp = [];
    //var already_sysn = false;
    UpdateInfos("2020-02-11");
    //already_sysn = true;
</script>
