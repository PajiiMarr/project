$(document).ready(function () {
  $(".anchor-tag").on("click", function (e) {
      e.preventDefault(); // Prevent default anchor click behavior
      $(".anchor-tag").removeClass("bg-crimson"); // Remove active class from all links
      $(this).addClass("bg-crimson"); // Add active class to the clicked link
  
      let url = $(this).attr("href"); // Get the URL from the href attribute
      window.history.pushState({ path: url }, "", url); // Update the browser's URL without reloading
    });

    $("#dashboard-link").on("click", function(e){
      e.preventDefault();
      viewDashboard();
    });
    $("#org-overview-link").on("click", function(e){
      e.preventDefault();
      viewOrganization();
    });
    $("#students-link").on("click", function(e){
      e.preventDefault();
      viewStudent();
    });
    $("#payment-link").on("click", function(e){
      e.preventDefault();
      viewPayments();
    });

  //   $(document).ready(function() {
  //     $(".form-selector").on("submit", function(e) {
  //         e.preventDefault();
  //     });
  
  //     $("#search").on("keypress", function(event) {
  //         if (event.key === "Enter") {
  //             event.preventDefault();
  //         }
  //     });
  // });
  

    let url = window.location.href;
    if (url.endsWith("dashboard.php")) {
      $("#dashboard-link").trigger("click"); // Trigger the dashboard click event
    } else if (url.endsWith("organization.php")) {
      $("#org-overview-link").trigger("click"); // Trigger the products click event
    } else if (url.endsWith("student.php")) {
      $("#students-link").trigger("click"); // Trigger the products click event
    } else if (url.endsWith("payment.php")) {
      $("#payment-link").trigger("click"); // Trigger the products click event
    } else {
      $("#dashboard-link").trigger("click");
    }


    function viewOrganization(){
      $.ajax({
          type: "GET",
          url: "../admin_views/organization.php",
          datatype: "php",
          success: function (response) {
              $(".content-page").html(response);

              var table = $("#table-organization").DataTable({
                  dom: "rtp"  
              });

              $(document).on("keyup", "#search", function () {
                table.search(this.value).draw();
              });

              $("#add-organization").off("click").on("click", function(e) {
                e.preventDefault();
                addOrganization();
              });
          }
      }); 
    }

    function addOrganization() {
      $.ajax({
        type: 'GET',
        url: "../admin_views/add-organization.html" ,
        datatype: "html",
        success: function (response) {
          $(".modal-container").html(response);
          $("#staticBackdrop").modal('show');

          $("#form-add-organization").on("submit", function(e) {
            e.preventDefault();
            saveOrganization();
          });

        }
      })
    }

    function saveOrganization() {
      $.ajax({
        type: "POST", // Use POST request
        url: "../admin_views/add-organization.php ", // URL for saving product
        data: $("#form-add-organization").serialize(), // Serialize the form data for submission
        dataType: "json", // Expect JSON response
        success: function (response) {

          if (response.status === "error") {
            console.log(response.status);

            // Handle validation errors
            if (response.org_nameErr) {
              $("#org_name").addClass("is-invalid"); // Mark field as invalid
              $("#org_name").next(".invalid-feedback").text(response.org_nameErr).show(); // Show error message
            } else {
              $("#org_name").removeClass("is-invalid"); // Remove invalid class if no error
            }
            if (response.required_feeErr) {
              $("#required_fee").addClass("is-invalid");
              $("#required_fee").next(".invalid-feedback").text(response.required_feeErr).show();
            } else {
              $("#required_fee").removeClass("is-invalid");
            }
          } else if (response.status === "success") {
            $("#staticBackdrop").modal("hide");
            $("#form-add-organization")[0].reset(); // Reset the form
            viewOrganization();
          }
        },
      });
    }

    function viewDashboard(){
      $.ajax({
          type: "GET",
          url: "../admin_views/dashboard.php",
          datatype: "html",
          success: function (response) {
              $(".content-page").html(response);
          
          }
      });
    }

    function viewStudent(){
      $.ajax({
        type: "GET",
        url: "../admin_views/student.php",
        datatype: "php",
        success: function (response){
          $(".content-page").html(response);

          // var table = $("#table-student").DataTable({
          //   dom: "rtp"
          // });
          
          // $(document).on("keyup", "#search", function(){
          //   table.search(this.value).draw();
          // });

          $(document).on("click", "#enroll-student", function(e) {

            e.preventDefault();
            console.log("hi");
            enrollStudent();
          });
        }
      });
    }

    function viewPayments(){
      $.ajax({
        type: "GET",
        url: "../admin_views/payments.php",
        datatype: "html",
        success: function (response){
          $(".content-page").html(response);
        }
      });
    }

    function enrollStudent(){
      $.ajax({
        type: "GET",
        url: "../admin_views/enroll_students_form.php",
        datatype: "html",
        success: function (view){
          $(".modal-container").html(view);
          $("#staticBackdrop").modal("show");

          $("#form-enroll-student").on("submit", function (e){
            e.preventDefault();
            saveStudent();
          });
        }
      });
    }

    function saveStudent(){
      $.ajax({
        type: "POST",
        url: "../admin_views/enroll_students.php",
        data: $("form").serialize(), // Serialize the form data for
        datatype: "json",
        success: function (response) {
          if (response.status === "error") {
            if (response.error['email']) {
              $("#email").addClass("is-invalid"); // Mark field as invalid
              $("#email").next(".invalid-feedback").text(response.codeErr).show(); // Show error message
            } else {
              $("#email").removeClass("is-invalid"); // Remove invalid class if no error
            }
          } else {
            $("#staticBackdrop").modal("hide");
            $("form")[0].reset(); // Reset the form
            // Optionally, reload products to show new entry
            viewStudent();
          }
        }
      });
    }


});