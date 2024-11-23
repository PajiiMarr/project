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
    $("#student-link").on("click", function(e){
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
      $("#student-link").trigger("click"); // Trigger the products click event
    } else if (url.endsWith("payments.php")) {
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
          console.log(response);
          
          if (response.status == "error") {
            Object.keys(response.errors).forEach(key => {
              $(`#${key}`).addClass("is-invalid");
              $(`#${key}`).next(".invalid-feedback").text(response.errors[key]).show(); // Show error message
            });
            exit;
          }

          $("#staticBackdrop").modal("hide");
          $("form")[0].reset(); // Reset the form
          // Optionally, reload products to show new entry
          viewOrganization();
        }
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
        url: "../admin_views/students-view.php",
        datatype: "html",
        success: function (response){
          $(".content-page").html(response);

          // var table = $("#table-student").DataTable({
          //   dom: "rtp"
          // });
          
          // $(document).on("keyup", "#search", function(){
          //   table.search(this.value).draw();
          // });

          // $("#form-sort-course").on("submit", function(e){
          //   e.preventDefault();
          //   sortCourse();
          // });

          $(document).on("click", "#enroll-student", function(e) {
            e.preventDefault();
            enrollStudent();
          });
        }
      });
    }

  //   function sortCourse() {
  //     $.ajax({
  //         type: "POST",
  //         url: "../admin_views/student_sorting.php",
  //         data: $("#form-sort-course").serialize(), // Ensure the correct form ID
  //         dataType: "json",
  //         success: function (response) {
  //             $("#table-student tbody tr").html(response); // Replace table content
              
              
  //         },
  //         error: function (xhr, status, error) {
  //             console.error("AJAX error:", status, error);
  //         }
  //     });
  // }
  

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


    // function saveStudent(){
    //   $.ajax({
    //     type: "POST",
    //     url: "../admin_views/enroll_students.php",
    //     data: $("#form-enroll-student").serialize(), // Serialize the form data for
    //     datatype: "json",
    //     success: function (response) {

    //       if (response.status == "error") {
    //         Object.keys(response.errors).forEach(key => {
    //           $(`#${key}`).addClass("is-invalid");
    //           $(`#${key}`).next(".invalid-feedback").text(response.errors[key]).show(); // Show error message
    //         });
    //         exit;
    //       }

    //       console.log(response.status);


    //       $("#staticBackdrop").modal("hide");
    //       $("form")[0].reset();
    //       viewStudent();
    //     }
    //   });
    // }

    function saveStudent() {
      $.ajax({
        type: "POST",
        url: "../admin_views/enroll_students.php",
        data: $("#form-enroll-student").serialize(),
        dataType: "json", // Ensure proper parsing of JSON response
        success: function (response) {
          console.log(response);
    
          if (response.status === "error") {
            Object.keys(response.errors).forEach(key => {
              $(`#${key}`).addClass("is-invalid");
              $(`#${key}`).next(".invalid-feedback").text(response.errors[key]).show();
            });
            return; // Stop further execution
          }
    
          // Reset modal and form on success
          $("#staticBackdrop").modal("hide");
          $("#form-enroll-student")[0].reset();
          viewStudent();
        },
        error: function (xhr, status, error) {
          console.error("AJAX error:", status, error);
        }
      });
    }
    


});