document.getElementById("aContinue").onclick = function () {
    'use strict';
    try {
        location.href = "/~jbarrios2017/p7/login.php";
    } catch (ex) {
        console.log(ex.name + ": " + ex.message);
    }
};