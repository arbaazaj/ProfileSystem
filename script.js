function loginRedirect() {
    window.location = "login.php";
    return true;
}

function registerRedirect() {
    window.location = "register.php";
    return true;
}

function backRedirect() {
    window.location = "index.php";
    return true;
}

function logoutRedirect() {
    window.location = "logout.php";
    return true;
}

function aboutRedirect() {
    window.location = "about.php";
    return true;
}

function refresh() {
    $(document).ready(function () {
	$("#icon-update-space").click(function () {
	    document.location.reload();
	});
    });
}