
    <div class="container-fluid">
        <div class="card mt-4  mb-4 border-white col-lg  ">
            <div class="card-body rounded">
                <form>
                    <div class="form-row">
                        <div class="col-lg-3 mb-3">
                            <label >First name</label>
                            <input type="text" class="form-control input" id="firstName" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label >Middle name(Optional)</label>
                            <input type="text" class="form-control input" id="middleName">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label >Last name</label>
                            <input type="text" class="form-control input" id="lastName"  required>
                        </div>
                        <div class="form-group col-lg-3">
                        <label>Suffix</label>
                            <select id="suffix" class="form-control input">
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
                            <input type="text" class="form-control input" id="contactNo"  required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label >Email Address(Optional)</label>
                            <input type="text" class="form-control input" id="emailAd" >
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label >Purok</label>
                            <input type="text" class="form-control input" id="purok" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label s>Postal Code(Optional)</label>
                            <input type="text" class="form-control input" id="postalCode"s>
                        </div>
                    </div>
                    <div class="form-row d-flex justify-content-end input">
                        <a class="btn btn-light" type="button" href="consumer">Cancel</a>
                        <a class="btn btn-primary ml-2 add-btn disabled" role="button" aria-disabled="true" type="submit" data-bs-toggle="modal" data-target="#successModal">Save</a>
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
                Consumer Updated Successfully
            </div>
                <div class="modal-footer border-white">
                <a class="btn btn-primary" href="consumer" role="button">close</a>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function () {
    var myModal = new bootstrap.Modal(document.getElementById('successModal'));
    var id = getUrlParameter('id');
    var initialConsumerData; // Variable to store the initial consumer data

    if (id !== null) {
        console.log('Extracted ID:', id);
        getConsumerData(id, function (consumer) {
            initialConsumerData = consumer;
            updateFormFields(consumer);
        });
    } else {
        console.log('ID not found in the URL.');
    }

    $(".input").on("input", function () {
        checkForChanges();
    });
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
                    updateConsumer();
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });
    function updateConsumer() {
        var formData = {
            url: "updateConsumer",
            id,
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
            url: 'ajaxController.php?url=updateConsumer',
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
    function getConsumerData(id, callback) {
        $.ajax({
            url: 'ajaxController.php?url=getConsumerById',
            type: 'GET',
            data: {
                url: "getConsumerById",
                id: id
            },
            dataType: 'json',
            success: function (response) {
                var consumer = response.consumer[0];
                callback(consumer);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }

    function updateFormFields(consumer) {
        $("#firstName").val(consumer.cFName);
        $("#middleName").val(consumer.cMName);
        $("#lastName").val(consumer.cLName);
        $("#suffix").val(consumer.cSuffix);
        $("#contactNo").val(consumer.cContactNo);
        $("#emailAd").val(consumer.cEmailAd);
        $("#purok").val(consumer.purok);
        $("#postalCode").val(consumer.postalCode);
    }

    function checkForChanges() {
        var currentConsumerData = getCurrentConsumerData();
        
        // Compare each field for changes
        var fields = ["cFName", "cMName", "cLName", "cSuffix", "cContactNo", "cEmailAd", "purok", "postalCode"];
        var hasChanges = fields.some(function (field) {
            return currentConsumerData[field] !== initialConsumerData[field];
        });

        if (hasChanges) {
            $(".add-btn").removeClass("disabled");
        } else {
            $(".add-btn").addClass("disabled");
        }
    }

    function getCurrentConsumerData() {
        return {
            cFName: $("#firstName").val(),
            cMName: $("#middleName").val(),
            cLName: $("#lastName").val(),
            cSuffix: $("#suffix").val(),
            cContactNo: $("#contactNo").val(),
            cEmailAd: $("#emailAd").val(),
            purok: $("#purok").val(),
            postalCode: $("#postalCode").val()
        };
    }

    function getUrlParameter(name) {
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(window.location.href);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
});
</script>

