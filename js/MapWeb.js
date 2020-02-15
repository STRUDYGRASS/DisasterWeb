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
        $("li", div).click(function (e) {
            UpdateInfos(this.innerHTML);
        });
        // 添加DOM元素到地图中
        map.getContainer().appendChild(div);
        // 将DOM元素返回
        return div;
    }

    function GetTime() { //后面调整成数据库读取
        return ["2020-02-10", "2020-02-11", "2020-02-12"]
    }


    function UpdateInfos(time) {
        UpdateInfo(time, "医院");
        UpdateInfo(time, "小区");
        UpdateThings();
    }