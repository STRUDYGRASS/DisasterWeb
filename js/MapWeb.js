    // 定义一个控件类,即function
    function AttributeShow(what, size,pic_add,statu) {
        // 默认停靠位置和偏移量
        this.defaultAnchor = BMAP_ANCHOR_TOP_RIGHT;
        this.defaultOffset = new BMap.Size(10, size);
        this.what = what;
        this.show = statu;
        this.pic_add = pic_add;
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
        if (That.show){
            div.appendChild(document.createTextNode("隐藏 " + That.what+" "));
        }
        else{
            div.appendChild(document.createTextNode("显示 " + That.what+" "));
        }
        var img = document.createElement('img');//创建一个标签
        img.setAttribute('src',That.pic_add);//给标签定义src链接
        img.setAttribute('height',24);
        img.setAttribute('width',24);

        div.appendChild(img);
        // 设置样式
        div.style.cursor = "pointer";
        div.style.border = "1px solid gray";
        div.style.backgroundColor = "white";
        div.onclick = function (e) {
            if (That.show) {
                That.show = false;
                div.firstChild.nodeValue = "显示 " + That.what + " ";
            } else {
                That.show = true;
                div.firstChild.nodeValue = "隐藏 " + That.what + " ";
            }
            UpdateThings();
        }
        // 添加DOM元素到地图中
        map.getContainer().appendChild(div);
        // 将DOM元素返回
        return div;
    }

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


    function TimeLine(time) {
        // 默认停靠位置和偏移量
        this.defaultAnchor = BMAP_ANCHOR_BOTTOM_RIGHT;
        this.defaultOffset = new BMap.Size(10, 50);
        this.time = time;
    }

    // 通过JavaScript的prototype属性继承于BMap.Control
    TimeLine.prototype = new BMap.Control();

    // 自定义控件必须实现自己的initialize方法,并且将控件的DOM元素返回
    // 在本方法中创建个div元素作为控件的容器,并将其添加到地图容器中
    TimeLine.prototype.initialize = function (map) {
        // 创建一个DOM元素
        var div = document.createElement("div");
        div.style.cursor = "pointer";
        div.style.border = "1px solid gray";
        div.style.backgroundColor = "white";
        var That = this;
        var datasDiv = '<ul id="dates" >';
        for (var i = 0; i < timelist.length; i++) {
            datasDiv += '<li>' + timelist[i] + '</li>';
        }
        datasDiv += '</ul>';
        div.innerHTML = datasDiv;
        $("li", div).each(function () {
            $(this).addClass("start");
            if (this.innerHTML == That.time) {
                $(this).removeClass("start");
                $(this).addClass("end");
                That.selected = this;
            }
        })
        $("li", div).click(function (e) {
            $(That.selected).removeClass("end");
            $(That.selected).addClass("start");
            $(this).removeClass("start");
            $(this).addClass("end");
            UpdateInfos(this.innerHTML);
            That.selected = this;
        });
        // 添加DOM元素到地图中
        map.getContainer().appendChild(div);
        // 将DOM元素返回
        return div;
    }

    function UpdateInfo(m_time, m_thing) {
        $.ajax({
            url: "/requestData/getTimeThing.php",
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

    
    function GetTime() {
        $.ajax({
            url: "/requestData/getTime.php",
            type: "POST",
            async: false,
            cache: false,
            dataType: "json",
        success: function (data) {
               timelist = data[0];
            },
            error: function (err) {
                alert(JSON.stringify(err));
                alert("数据更新失败！");
            }
    });
    }



    function UpdateInfos(time) {
        UpdateInfo(time, "定点医院");
        UpdateInfo(time, "详细地址");
        UpdateThings();
    }
