<div class="container">
    <div class="row justify-content-center vh-100 align-items-center">
        <div class="card col-11 col-sm-9 col-md-7 col-lg-5 shadow">
            <div class="card-header bg-white border-white d-flex align-items-center justify-content-center flex-column">
                <img src="assets/img/logo.png" class="img-fluid h-25 w-25" alt="">
                <h1 class="h3 text-center text-gray-800 font-weight-bold p-2">Water Billing System</h1>
                <h1 class="h6 text-center text-gray-500 font-weight-bold">Enter to login your credentials:</h1>
            </div>
            <div class="card-body">
                <div class="form">
                    <div class="form-group ">
                        <label for="inputEmail4">Username</label>
                        <input type="email" class="form-control" id="username" value = "admin">
                    </div>
                    <div class="form-group ">
                        <label for="inputPassword4">Password</label>
                        <input type="password" class="form-control" id="password" value = "admin">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Show Password
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm">
                            <button type="submit" id="login-btn" class="btn btn-primary btn-block">Log in</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header border-white">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body border-white text-center">
               invalid credentials
            </div>
                <div class="modal-footer border-white">
                <button class="btn btn-primary" role="button" data-dismiss="modal">close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    $('#login-btn').on('click',function(e){
        var userName = $('#username').val();
        var passWord = $('#password').val();
        if(userName === '' || passWord === ''){
            alert('Empty fields is not accepted');
            return;
        }
        //check credentials
        $.ajax({
            url: 'ajaxController.php?url=checkUserCredentials',
            type: 'POST',
            data: 
                {
                    url:"checkUserCredentials",
                    userName:userName,
                    passWord:passWord
                },
            dataType: 'json',
            success: function (response) {
                if (response.status === "success") {
                    window.location.href = "dashboard";
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });
});
</script>