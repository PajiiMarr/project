$(document).ready(function () {
    // Load default dashboard
    viewDashboard();

    // Event listener for semester dropdown change
    $("#sy_sem").change(function () {
        let selectedSemester = $(this).val();
        viewDashboard(selectedSemester); // Pass the selected semester to the function
    });

    $(".anchor-tag").on("click", function (e) {
        e.preventDefault(); // Prevent default anchor click behavior
        $(".anchor-tag").removeClass("bg-crimson"); // Remove active class from all links
        $(this).addClass("bg-crimson"); // Add active class to the clicked link

        let url = $(this).attr("href"); // Get the URL from the href attribute
        window.history.pushState({ path: url }, "", url); // Update the browser's URL without reloading
    });

    $("#student-dashboard-link").on("click", function(e){
        e.preventDefault();
        viewDashboard();
    });
    $("#student-payment-link").on("click", function(e){
        e.preventDefault();
        viewPayments();
    });
    $("#student-organization-link").on("click", function(e){
        e.preventDefault();
        viewOrganization();
    });

    let url = window.location.href;
    if (url.endsWith("dashboard.php")) {
        $("#student-dashboard-link").trigger("click"); // Trigger the dashboard click event
    } else if (url.endsWith("payments.php")) {
        $("#student-payment-link").trigger("click"); // Trigger the products click event
    } else if (url.endsWith("organization.php")) {
        $("#student-organization-link").trigger("click"); // Trigger the products click event
    } else {
        $("#student-dashboard-link").trigger("click");
    }

    function viewOrganization(){
        $.ajax({
            type: "GET",
            url: "../student_views/organization.php",
            datatype: "html",
            success: function (response) {
                $(".content-page").html(response);
                $('.promisory').on("click", function(e){
                  e.preventDefault();
                  requestPromisory(this.dataset.id);
                });
            }
        });
    }

    function requestPromisory(userId){
        $.ajax({
            type: "GET",
            url: `../student_views/promisory_note_form.php?payment_id=${userId}`,
            datatype: "html",
            success: function (response) {
                $(".modal-container").empty().html(response);
                $("#promisoryNote").modal("show");
                
                $("#form-promisory-note").on("submit", function(e){
                  e.preventDefault();
                  promisoryNote();
                });

                $(".button-close").on("click", function(e){
                  e.preventDefault();
                  $("#promisoryNote").modal("hide");
                })
            }
        });
    }

    function promisoryNote() {
      $.ajax({
        type: "POST", // Use POST request
        url: "../student_views/promisory_note.php", // URL for saving organization
        data: $("#form-promisory-note").serialize(), // Serialize the form data for submission
        dataType: "json", // Expect JSON response
        success: function (response) {
          if (response.status === "error") {
            if (response.errors) {
              $("#note").addClass("is-invalid"); // Add invalid class
              $("#note").siblings(".invalid-feedback") // Correctly reference invalid-feedback
                .text(response.errors)
                .show(); // Show error message
            }
          }

          if(response.status == 'success'){
            $("#promisoryNote").modal("hide");
            $("#form-promisory-note")[0].reset();
            viewOrganization();
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX error:", status, error);
        },
      });
    }


    function viewDashboard(sy_sem = null) {
      $.ajax({
          type: "GET",
          url: "../student_views/dashboard.php",
          data: { sy_sem: sy_sem || 'current' }, // Default to 'current' if no specific semester is provided
          datatype: "html",
          success: function (response) {
              $(".content-page").html(response);
          }
      });
  }
b  

    function viewPayments(){
        $.ajax({
            type: "GET",
            url: "../student_views/payments.php",
            datatype: "html",
            success: function (response){
                $(".content-page").html(response);
            }
        });
    }
});
