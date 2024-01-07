<div id="content">
    <div class="container-fluid">
        <div class="card mt-4  mb-4 border-white col-lg  ">
            <div class="card-body rounded">
                <form>
                    <div class="form-row">
                        <div class="col-lg-3 mb-3">
                            <label >First name</label>
                            <input type="text" class="form-control" id="firstName" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label >Middle name(Optional)</label>
                            <input type="text" class="form-control" id="middleName">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label >Last name</label>
                            <input type="text" class="form-control" id="lastName"  required>
                        </div>
                        <div class="form-group col-lg-3">
                        <label>Suffix</label>
                            <select id="suffix" class="form-control">
                                <option selected>Choose suffix</option>
                                <option>Jr</option>
                                <option>Sr</option>
                                <option>I</option>
                                <option>II</option>
                                <option>III</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-3 mb-3">
                            <label>Contact No</label>
                            <input type="text" class="form-control" id="contactNo"  required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label >Email Address(Optional)</label>
                            <input type="text" class="form-control" id="emailAd" >
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label >Purok</label>
                            <input type="text" class="form-control" id="purok" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label s>Postal Code(Optional)</label>
                            <input type="text" class="form-control" id="postalCode"s>
                        </div>
                    </div>
                    <div class="form-row d-flex justify-content-end">
                        <a class="btn btn-light" type="button" href="consumer">Cancel</a>
                        <button class="btn btn-primary ml-2 add-btn" type="submit" data-bs-toggle="modal" data-target="#successModal">Add</button>
                    </div>
                </form>
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
                Consumer Added Successfully
            </div>
                <div class="modal-footer border-white">
                    <a class="btn btn-primary" href="consumer" role="button" >close</a>
                </div>
            </div>
        </div>
    </div>
 </div>

<script>
$(document).ready(function () {
    var myModal = new bootstrap.Modal(document.getElementById('successModal'));

    // Click event for the "Add" button
    $(".add-btn").on("click", function (event) {
        // Prevent the default form submission
        event.preventDefault();
       // Check if required fields are not empty
        if (
            $("#firstName").val() === '' ||
            $("#lastName").val() === '' ||
            $("#contactNo").val() === '' ||
            $("#purok").val() === ''
        ) {
            alert('Please fill in all required fields.');
            return; // Exit the function
        }

        // Check if consumer exists
        var data = {
            url: "checkConsumer",
            firstName: $("#firstName").val(),
            middleName: $("#middleName").val(),
            lastName: $("#lastName").val(),
            suffix: $("#suffix").val() == "Choose suffix" ? "" : $("#suffix").val(),
        };

        $.ajax({
            url: 'ajaxController.php?url=checkConsumer',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.exists === true) {
                    alert('Consumer Already Exists');
                    return;
                } else {
                    addConsumer();
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });

    $(".btn-light").on("click", function () {
        console.log("Cancel button clicked");
    });

    function addConsumer() {
        var formData = {
            url: "addConsumer",
            firstName: $("#firstName").val(),
            middleName: $("#middleName").val(),
            lastName: $("#lastName").val(),
            suffix: $("#suffix").val() == "Choose suffix" ? "" : $("#suffix").val(),
            contactNo: $("#contactNo").val(),
            emailAddress: $("#emailAd").val(),
            purok: $("#purok").val(),
            postalCode: $("#postalCode").val(),
        };

        $.ajax({
            url: 'ajaxController.php?url=addConsumer',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    myModal.show();
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
});


</script>

