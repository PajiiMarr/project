$(document).ready(function () {
    // Handle sidebar link clicks
    $(".anchor-tag").on("click", function (e) {
        e.preventDefault(); // Prevent default anchor click behavior
        $(".anchor-tag").removeClass("bg-crimson"); // Remove active class from all links
        $(this).addClass("bg-crimson"); // Add active class to the clicked link

        let url = $(this).attr("href"); // Get the URL from the href attribute
        window.history.pushState({ path: url }, "", url); // Update the browser's URL without reloading

        // Route to appropriate view loader based on URL
        if (url.includes("dashboard.php")) {
            viewDashboard();
        } else if (url.includes("students.php")) {
            viewStudent();
        } else if (url.includes("payments.php")) {
            viewPayments();
        } else if (url.includes("organization.php")) {
            viewOrganization();
        } else {
            alert("Unknown view. Please check the URL.");
        }
    });

    // Detect the current URL and trigger the corresponding link click
    let url = window.location.href;
    if (url.endsWith("dashboard.php")) {
        $("#dashboard-link").trigger("click");
    } else if (url.endsWith("organization.php")) {
        $("#org-overview-link").trigger("click");
    } else if (url.endsWith("students.php")) {
        $("#student-link").trigger("click");
    } else if (url.endsWith("payments.php")) {
        $("#payment-link").trigger("click");
    } else {
        $("#dashboard-link").trigger("click"); // Default to dashboard
    }

    // Function to load the dashboard view
    function viewDashboard() {
        $.ajax({
            type: "GET",
            url: "../facilitator-views/dashboard.php",
            dataType: "html",
            success: function (response) {
                $(".content-page").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Dashboard Load Error:", xhr.responseText);
                alert("Failed to load the dashboard. Please try again.");
            }
        });
    }

    // Function to load the organization view
    function viewOrganization() {
        $.ajax({
            type: "GET",
            url: "../facilitator-views/organization.php",
            dataType: "html",
            success: function (response) {
                $(".content-page").html(response);

                // Initialize DataTable
                var table = $("#table-organization").DataTable({
                    dom: "rtp"
                });

                // Add search functionality
                $(document).on("keyup", "#search", function () {
                    table.search(this.value).draw();
                });

                // Handle adding new organization
                $("#add-organization").off("click").on("click", function (e) {
                    e.preventDefault();
                    addOrganization();
                });
            },
            error: function (xhr, status, error) {
                console.error("Organization Load Error:", xhr.responseText);
                alert("Failed to load organizations. Please try again.");
            }
        });
    }

    // Function to load the students view
    function viewStudent() {
        $.ajax({
            type: "GET",
            url: "../facilitator-views/students.php",
            dataType: "html",
            success: function (response) {
                $(".content-page").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Students Load Error:", xhr.responseText);
                alert("Failed to load students. Please try again.");
            }
        });
    }

    // Function to load the payments view
    function viewPayments() {
        $.ajax({
            type: "GET",
            url: "../facilitator-views/payments.php",
            dataType: "html",
            success: function (response) {
                $(".content-page").html(response);
            },
            error: function (xhr, status, error) {
                console.error("Payments Load Error:", xhr.responseText);
                alert("Failed to load payments. Please try again.");
            }
        });
    }

    // Add organization functionality
    function addOrganization() {
        $.ajax({
            type: "GET",
            url: "../facilitator-views/add-organization.html",
            dataType: "html",
            success: function (response) {
                $(".modal-container").html(response);
                $("#staticBackdrop").modal("show");

                // Handle form submission
                $("#form-add-organization").on("submit", function (e) {
                    e.preventDefault();
                    saveOrganization();
                });
            },
            error: function (xhr, status, error) {
                console.error("Add Organization Load Error:", xhr.responseText);
                alert("Failed to load the add organization form. Please try again.");
            }
        });
    }

    // Save organization functionality
    function saveOrganization() {
        $.ajax({
            type: "POST",
            url: "../facilitator-views/add-organization.php",
            data: $("#form-add-organization").serialize(),
            dataType: "json",
            success: function (response) {
                if (response.status === "error") {
                    Object.keys(response.errors).forEach(key => {
                        $(`#${key}`).addClass("is-invalid");
                        $(`#${key}`).next(".invalid-feedback").text(response.errors[key]).show();
                    });
                } else {
                    alert("Organization added successfully.");
                    $("#staticBackdrop").modal("hide");
                    viewOrganization();
                }
            },
            error: function (xhr, status, error) {
                console.error("Save Organization Error:", xhr.responseText);
                alert("Failed to save the organization. Please try again.");
            }
        });
    }
});
