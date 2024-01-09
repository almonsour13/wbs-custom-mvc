    <div class="container-fluid">
        <div class="card mt-3  mb-4 border-white">
            <div class="card-header bg-white  d-flex justify-content-between">
                <form
                    class=" d-sm-inline-block form-inline mr-auto ml-md-1 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group  d-flex gap-3 align-items-center justify-content-center">
                            Search:
                            <input id="search-consumer" type="text" class="ml-2 form-control bg-light border-1 small" placeholder="Type here.."
                                aria-label="Search" aria-describedby="basic-addon2">
                            
                    </div>
                </form>
                <div class="d-flex  align-items-center justify-content-center">
                    <a class="btn btn-primary" href="add-consumer" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="20" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" fill="white"/></svg>
                    </a>
                    </div>
            </div>
            <div class="card-body rounded border-white">
                <div class="table-responsive"> 
                    <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>First Name</th>
                                <th >Middle Name</th>
                                <th >Last Name</th>
                                <th >Contact No</th>
                                <th >Purok</th>
                                <th >Postal Code</th>
                                <th >Date Added</th>
                                <th >Status</th>
                                <th class="text-center">Actions</th>
                           </tr>
                        </thead>
                        <tfoot>
                                       
                        </tfoot>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item mr-2 mt-3">
                            <a class="btn btn-primary btn-sm prev-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path fill="white" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
                            </a>
                        </li>
                        <p class="page-link mr-1 mt-3 border-white" id="page-number" ></p>
                        <li class="page-item mr-1 mt-3">
                            <a class="btn btn-primary btn-sm next-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path fill="white" d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg>
                            </a  >
                        </li>
                    </ul>
                </nav>
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
                Consumer Moved Successfully
            </div>
                <div class="modal-footer border-white">
                <button class="btn btn-primary" role="button" data-dismiss="modal">close</button>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function () {
    var myModal = new bootstrap.Modal(document.getElementById('successModal'));

    let pageNumber = 1;
    let allPages;
    displayConsumer(1);
    $(".next-btn").on("click", function () {
        if (pageNumber < allPages) {
            displayConsumer(++pageNumber);
        }
    });

    $(".prev-btn").on("click", function () {
        if (pageNumber > 1) {
            displayConsumer(--pageNumber);
        }
    });
    $(document).on("click", ".delete-btn", function() {
        var id = $(this).attr("id");
        achiveConsumer(id);
    });

    $("#search-consumer").on("input", function () {
        displayConsumer(1); 
    });

    function achiveConsumer(id){
        $.ajax({
            url: 'ajaxController.php?url=archiveConsumer',
            type: 'POST',
            data: {
                url:"archiveConsumer",
                id:id
                },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                     myModal.show();
                     displayConsumer(pageNumber);
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
    function displayConsumer(pageNumber) {
        $('tbody').empty();

        var consumers = getData();
        let itemPerPage = 10;
        let allItem = consumers.length;
        allPages = Math.ceil(allItem / itemPerPage);
        let page = (pageNumber - 1) * itemPerPage;
        var row = '';
        $("#page-number").text(pageNumber);
        // Pagination logic
        $(".next-btn").toggleClass('disabled', pageNumber === allPages);
        $(".prev-btn").toggleClass('disabled', pageNumber === 1);

        // Filter data based on search criteria
        var myInput = $("#search-consumer");
        var inputValue = myInput.val().trim().toLowerCase();
        var filteredConsumers = consumers.filter(consumer =>
            consumer.cFName.toLowerCase().indexOf(inputValue) != -1 ||
            consumer.cMName.toLowerCase().indexOf(inputValue) != -1 ||
            consumer.cLName.toLowerCase().indexOf(inputValue) != -1 ||
            consumer.purok.toLowerCase().indexOf(inputValue) != -1
        );
        for (var a = page; a < Math.min(page + itemPerPage, filteredConsumers.length); a++) {
            var consumer = filteredConsumers[a];
            row += `
                    <tr data-id="${consumer.cID}" data-status="${consumer.cStatus}">
                        <td>${a + 1}</td>
                        <td >${consumer.cFName}</td>
                        <td>${consumer.cMName}</td>
                        <td>${consumer.cLName}</td>
                        <td>${consumer.cContactNo}</td>
                        <td>${consumer.purok}</td>
                        <td>${consumer.postalCode}</td>
                        <td>${consumer.dateAdded}</td>
                        <td class="text-center">
                            <select id="status" class="form-control border-white text-success ${consumer.cStatus == 1 ? "text-success" : "text-danger"}">
                                <option ${consumer.cStatus == 1 ? "selected" : ""} class="">Active</option>
                                <option ${consumer.cStatus == 2 ? "selected" : ""} class="${consumer.cStatus == 2 ? "text-success" : "text-danger"}">Inactive</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <a href="edit-consumer?id=${consumer.cID}" class="btn btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path fill="#3B71CA" d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                            </a>
                            <button class="btn btn-sm delete-btn" id = "${consumer.cID}">
                                <svg xmlns="http://www.w3.org/2000/svg" height="26" width="26" viewBox="0 -960 960 960"><path fill="#DC4C64" d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                            </button>
                        </td>
                    </tr>
                `;
        }

        $('tbody').append(row);
    }

    function getData() {
        var result;
        $.ajax({
            url: 'ajaxController.php?url=getConsumer',
            type: 'GET',
            dataType: 'json',
            async: false, // Ensure synchronous execution
            success: function (response) {
                if (response.hasOwnProperty('consumer')) {
                    result = response.consumer;
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
        return result;
    }
});

function deleteConsumer(id) {
    console.log('Delete consumer with ID:', id);
}


</script>
