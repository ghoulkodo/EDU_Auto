$(document).ready(function(){
    $("#username").focus();
    $("#username").keyup(function()
    {
        name= $("#username").val();//val()方法返回或设置被选元素的值。
        if(len(name)< 4)//调用下面的自定义len函数
            $("#username1").html("<font color=red>注册名称必须大于等于2位</font>");
        else
            $("#username1").html("<font color=red>符合要求</font>");//html() 方法返回或设置被选元素的内容 (inner HTML)。
    });
    $("#username").blur(function(){
        name= $("#username").val();
        $.get("t1.php", { username:name } ,function(data){//判断数据库中是否存在此用户名 重点$.get,$.post t1.php在下面
            if(data==1) {$("#username1").html("<font color=green>符合要求</font>");}
            else {$("#username1").html("<font color=green>已被占用</font>");}
        });
    });
});
function len(s) {//若为汉字之类的字符则占两个
    var l = 0;
    var a = s.split("");
    for (var i=0;i<a.length;i++) {
        if (a[i].charCodeAt(0)<299) {
            l++;
        } else {
            l+=2;
        }
    }
    return l;
}