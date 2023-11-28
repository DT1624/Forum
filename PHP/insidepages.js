displayNotifications();

function displayNotifications() {

}

function openPostModal() {
    document.getElementById("post-modal").style.display = "block";
}

function dangBai() {
    var title = document.getElementById("post-title-inp").value;
    var imagelink = document.getElementById("post-img-inp").value;
    var content = document.getElementById("post-content-inp").value;


    // Kiểm tra nếu chưa điền thông tin
    if (
        title == "" ||
        imagelink == "" ||
        content == ""
    ) {
        alert("Bạn chưa điền đủ thông tin");
        return; // thoát hàm
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "vietbaimoi.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
        }
    };
    xhr.send(
        "user=" +
        localStorage.getItem("phien_dang_nhap") +
        "&title=" +
        title +
        "&imagelink=" +
        imagelink +
        "&content=" +
        content
    );
    window.location.href = "forum.html";
}

function search() {
    input = document.getElementById("search-inp").value;
    var xhttp_posts = new XMLHttpRequest();

    xhttp_posts.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Đã nhận được dữ liệu từ máy chủ
            var dataFromPHP = JSON.parse(this.responseText); // Chuyển đổi JSON thành object JavaScript
            // Sử dụng dữ liệu ở đây
            console.log(dataFromPHP); // Log ra để xem console
            renderPosts(datafromPHP);
        }
    };

    // Gửi yêu cầu GET đến mã PHP
    xhttp_posts.open("GET", "search.php?keyword=" + input, true);
    xhttp_posts.send();
}

function renderPosts(dataObject) {

}

function logout() {
    localStorage.removeItem("phien_dang_nhap");
    window.location.href = "index.php";
}

function personalInfomationProcess() {
    var xhttp_userinfo = new XMLHttpRequest();
    xhttp_userinfo.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Đã nhận được dữ liệu từ máy chủ
            var dataFromPHP = JSON.parse(this.responseText); // Chuyển đổi JSON thành object JavaScript

            // Sử dụng dữ liệu ở đây
            console.log(dataFromPHP); // Log ra để xem console
            displayAva(dataFromPHP);
        }
    };

    // Gửi yêu cầu GET đến mã PHP
    var phien_dang_nhap = localStorage.getItem("phien_dang_nhap");
    xhttp_userinfo.open("GET", "laythongtinuser.php?username=" + phien_dang_nhap, true);
    xhttp_userinfo.send();

    function displayAva(dataObject) {
        if (dataObject.avaLink != null) {
            document.getElementById("nav-ava").src = dataObject.avaLink;
            if (window.location.href == "http://localhost/final/forum.html" || window.location.href == "http://localhost/final/admin.html") {
                document.getElementById("left-col-ava").src = dataObject.avaLink;
                document.getElementById("left-col-name").innerHTML = dataObject.username;
            }
        }
        if (dataObject.isAdmin == 1) {
            var divDuyetBai = document.createElement("div");
            divDuyetBai.innerHTML =
                `<a href="admin.html" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-grey" title="Logout">
        Duyệt bài
      </a>`;
            document.getElementById("navbar").appendChild(divDuyetBai);
        }
    }

}

function displayPersonalInformation() {

}

function clickProfile() {
    window.location.href = "profile.php";
}

function editprofile() {
    window.location.href = "editProfile.php";
}



// function signOut() {
//     window.location.href = "logout.php";
// }
// logout.js
function signOut() {
    var xhr = new XMLHttpRequest();
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Xử lý phản hồi từ máy chủ, có thể thêm xử lý tiếp theo tại đây
            window.location.href = "index.php"; // Chuyển hướng sau khi đăng xuất
        }
    };
    
    xhr.open("POST", "logout.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send();
}

function displayProfile() {
    var profile = document.getElementById('profile');
    if (profile) {
      profile.innerHTML = `
    <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    
        <div class="w3-row">
            <div class="w3-col m3">
                <div class="w3-card w3-round w3-white">
                <div class="w3-container">
                    <h4 class="w3-center">My Profile</h4>
                    <p class="w3-center"><img src="/w3images/avatar3.png" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></p>
                    <hr>
                    <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Designer, UI</p>
                    <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> London, UK</p>
                    <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> April 1, 1988</p>
                </div>
                </div>
                <br>
            </div>
        </div>
    </div>`;
            
    } else {
      console.error("Element with id 'profile' not found.");
    }
  }
