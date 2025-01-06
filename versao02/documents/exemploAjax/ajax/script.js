document.getElementById("loadData").addEventListener("click", function () {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "getData.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("result").innerText = xhr.responseText;
        }
    };
    xhr.send();
});
