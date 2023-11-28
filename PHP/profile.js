function displayProfile() {
    var profile = document.getElementById('profile');
    if (profile) {
      profile.innerHTML = `   
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
            </div>`;
            
    } else {
      console.error("Element with id 'profile' not found.");
    }
  }

function displayPage() {
    var page = document.getElementById('page');
    if (page) {
      page.innerHTML = `
      <div class="w3-col m9">
      <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
        <img src="https://yt3.googleusercontent.com/-CFTJHU7fEWb7BYEb6Jh9gm1EpetvVGQqtof0Rbh-VQRIznYYKJxCaqv_9HeBcmJmIsp2vOO9JU=s900-c-k-c0x00ffffff-no-rj" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px; display:inline-block">
        <span class="w3-right w3-opacity">1 min</span>
        <div style="vertical-align: middle;display:inline-block">
          <button type="button" class="w3-button w3-theme-d1" style="padding:0 5px 0 5px;margin: 0;display: inline-block;"> Tên nhóm</button>
          <a href="#" class="w3-hoverable" style="display: inline-block; margin-bottom: 0; font-size:2.5ch">Tên bài viết</a>
          <p style="margin:0; padding-bottom: 16px; font-style: italic;">Tên người đăng và ngày tháng</p>
        </div>
      </div>
      </div>`;
            
    } else {
      console.error("Element with id 'page' not found.");
    }
  }
