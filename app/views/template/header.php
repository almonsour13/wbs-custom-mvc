<nav class="navbar navbar-expand navbar-light bg-light topbar mb-3 static-top">
                    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-2">
        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" fill="blue"/></svg>
    </button>
    <h1 class="h4 text-gray-800 font-weight-bold mt-2">
        <?php 
            $url = isset($_GET['url']) ? $_GET['url'] : 'consumer';
            if($url === 'consumer'){
                echo 'Consumer';
            }else if($url === 'add-consumer'){
                echo 'Add Consumer';
            }else if($url === 'edit-consumer'){
                echo 'Edit Consumer';
            } 
        ?>
    </h1>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-3 d-none d-lg-inline text-gray-600 small" id="accountName">Douglas McGee</span>
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#9FA6B2" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        Settings
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Activity Log
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

    </ul>
</nav>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function () {
    getLoggedAccount();
    $('#logout').on('click',function(e){
        //check credentials
        $.ajax({
            url: 'ajaxController.php',
            type: 'GET',
            data: 
                {
                    url:"logOut"
                },
            dataType: 'json',
            success: function (response) {
                if(response.status === "success"){
                    window.location.href = "login";
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });
    function getLoggedAccount() {
        $.ajax({
            url: 'ajaxController.php',
            type: 'GET',
            data: {
                url: 'getLoggedAccount'
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success' && response.account && response.account.length > 0) {
                    $('#accountName').text(response.account[0].aFName + ' ' + response.account[0].aMName);
                } else {
                    console.log('Session not set or account data not available.');
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
});

</script>
</script>