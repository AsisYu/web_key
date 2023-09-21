// 验证cookie是否存在
function checkCookieExists(cookieName) {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim();

        if (cookie.indexOf(cookieName + "=") === 0) {
            return true;
        }
    }

    return false;
}

// 在页面加载时执行检查
window.onload = function() {
    var cookieName = "myCookie";
    var redirectUrl = "index.html";

    if (checkCookieExists(cookieName)) {
        window.location.href = redirectUrl;
    }
};