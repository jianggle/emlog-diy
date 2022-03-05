# comment-ajax

[emlog评论ajax提交方案](https://www.eqifei.net/post-465.html)，基于`emlog5.3.1`

推荐使用`方法二`，不用修改源代码，简单方便。

## 方法一：需要修改源代码

### 前端代码示例

```javascript
var data = {
  comname: $("#comname").val(),
  comment: $("#comment").val(),
  commail: $("#commail").val(),
  comurl: $("#comurl").val(),
  imgcode: $("input[name=imgcode]").val(),
  gid: $("#comment-gid").val(),
  pid: $("#comment-pid").val()
}
$.ajax({
  url: "index.php?action=addcom",
  type: "post",
  dataType: "json",
  data: data,
  success: function (data) {
    var tip = $("#commentTips")
    switch (data.status) {
      case "1":
        tip.text("主人已关闭此篇文章的评论功能啦！")
        break
      case "2":
        tip.text("已存在相同内容评论啦！");
        break;
      case "3":
        tip.text("您提交评论的速度太快了，请稍后再发表评论吧！")
        break
      case "4":
        tip.text("请填写昵称哦！")
        break;
      case "5":
        tip.text("昵称不超过6个汉字或者20个字符哦！")
        break
      case "6":
        tip.text("请填写正确的邮件地址哦！")
        break
      case "7":
        tip.text("不能使用管理员昵称或邮箱评论哦！")
        break
      case "8":
        tip.text("主页地址不符合规范哦！")
        break
      case "9":
        tip.text("请填写评论内容哦！")
        break
      case "10":
        tip.text("评论内容超出最大字数限制了哦！")
        break
      case "11":
        tip.text("评论内容需包含中文哦！")
        break
      case "12":
        tip.text("验证码不对哒！")
        break
      case "13":
        alert("评论发表成功！")
        location.reload()
        break
      case "14":
        alert("评论发表成功，请等待管理员审核吧！")
        location.reload()
        break
    }
  }
})
```

## 方法二（推荐使用）

正则式方案，无需更改源代码

```javascript
$("#comment_submit").click(function (event) {
  event.preventDefault()
  doSubmitComment()
})
function doSubmitComment() {
  var comname = $.trim($("#commentform input[name=comname]").val())
  var commail = $.trim($("#commentform input[name=commail]").val())
  var comurl = $.trim($("#commentform input[name=comurl]").val())
  var comment = $.trim($("#commentform textarea[name=comment]").val())
  var imgcode = $.trim($("#commentform input[name=imgcode]").val())
  var tip = $("#commentTips")
  var btn = $("#comment_submit")

  if ($("#commentform input[name=comname]").length > 0 && !comname) {
    tip.html("请填写您的昵称！")
  } else if ($("#commentform input[name=commail]").length > 0 && !commail) {
    tip.html("请填写您的邮箱！")
  } else if ($("#commentform input[name=commail]").length > 0 && !/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(commail)) {
    tip.html("请填写正确的邮箱！")
  } else if (!comment) {
    tip.html("请填写评论内容！")
  } else if ($("#commentform input[name=imgcode]").length > 0 && !imgcode) {
    tip.html("请填写验证码！")
  } else {
    $.ajax({
      url: $("#commentform").attr("action"),
      type: "post",
      data: $("#commentform").serialize(),
      cache: false,
      beforeSend: function () {
        tip.html("提交中...")
        btn.attr("disabled", true)
      },
      success: function (res) {
        btn.attr("disabled", false)
        var pattern = /<div class="main">[\r\n]+<p>(.*?)<\/p>/
        if (pattern.test(res)) {
          res = res.match(pattern)
          tip.html(res[1])
        } else {
          window.location.href = window.location.href.split("#")[0]
        }
      },
      error: function () {
        btn.attr("disabled", false)
      }
    })
  }
}
```
