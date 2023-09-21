function addKeys() {
    var noOfKeys = $("#numOfKeys").val();

    if (noOfKeys === "" || noOfKeys <= 0) {
        alert("请输入有效的密钥数！");
        return;
    }

    $.post("../addKey.php", {keyCount: noOfKeys}, function(response) {
        alert(response);
    });
}

function exportKeys() {
    window.location.href = "../exportKeys.php";
}
