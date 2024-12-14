<section class="container-fluid w-100 h-100">
    <div class="modal-container"></div>
    <div class="h-18 w-100 border-bottom">
        <div class="h-50 w-100 position-relative custom-border-bottom d-flex align-items-center justify-content-center">
            <h1 class="ccs-green">College of Computing Studies</h1>
            <div class="dropdown text-end position-absolute" style="right: 5px;">
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-circle-user fs-4 crimson"></i>
                </a>
                <ul class="dropdown-menu text-small">
                    <li><a class="dropdown-item" href="../log_out.php">Sign out</a></li>
                </ul>
            </div>
        </div>
        <div class="h-50 w-100 custom-border-bottom container-fluid lh-1 py-3 px-5">
            <p class="text-secondary fs-5 m-0">Students/Payments</p>
            <h2 class="m-0">Student Payment Status</h2>
        </div>
    </div>

    <div class="container-fluid h-80 w-100 py-5 px-5">
        <div class="h-100 w-100 shadow rounded-large overflow-scroll">
            <div class="w-100 d-flex justify-content-between p-2">
                <form class="form-selector p-2 d-flex align-items-center justify-content-between w-100">
                    <div class="w-18 d-flex align-items-center justify-content-around">
                        <label for="search">
                            <i class="fa-solid fa-magnifying-glass fs-4"></i>
                        </label>
                        <input class="p-2 w-75" type="text" name="search" id="search" placeholder="Search...">
                    </div>
                </form>
            </div>
            <form class="form-selector d-flex w-50 pb-2">
                <label class="radio-label rounded-3 p-2 ms-2">
                    <input type="radio" name="organization_id" value="all" checked style="display:none;">
                    All Organizations
                </label>
                <!-- Add dynamic organization filter here if needed -->
            </form>

            <table id="table-student" class="max-h-100 w-100 table-hover position-relative">
                <thead>
                    <tr class="bg-light-crimson">
                        <th class="fs-4 text-white p-2">No.</th>
                        <th class="fs-4 text-white p-2">Organization</th>
                        <th class="fs-4 text-white p-2">Semester</th>
                        <th class="fs-4 text-white p-2">Amount to Pay</th>
                        <th class="fs-4 text-white p-2">Balance</th>
                        <th class="fs-4 text-white p-2">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Placeholder for dynamic data -->
                    <tr>
                        <td colspan="7" class="text-center py-2 fw-bold fs-5">No data available.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
