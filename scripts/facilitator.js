(function(){$(document).ready(function () {
  $(".anchor-tag").on("click", function (e) {
      e.preventDefault(); // Prevent default anchor click behavior
      $(".anchor-tag").removeClass("bg-crimson"); // Remove active class from all links
      $(this).addClass("bg-crimson"); // Add active class to the clicked link
  
      let url = $(this).attr("href"); // Get the URL from the href attribute
      window.history.pushState({ path: url }, "", url); // Update the browser's URL without reloading
    });

    $("#facilitator-dashboard-link").on("click", function(e){
      e.preventDefault();
      viewDashboard();
    });
    $("#facilitator-student-link").on("click", function(e){
      e.preventDefault();
      viewStudent();
    });
    $("#facilitator-assign-officer").on("click", function(e){
      e.preventDefault();
      assign();
    });
    $("#facilitator-payment-link").on("click", function(e){
      e.preventDefault();
      viewPayments();
    });
    $("#facilitator-request-link").on("click", function(e){
      e.preventDefault();
      requests();
    });
    $("#request-payment").on("click", function(e){
      e.preventDefault();
      addPayment();
    });

    let url = window.location.href;
    if (url.endsWith("dashboard.php")) {
      $("#facilitator-dashboard-link").trigger("click"); // Trigger the dashboard click event
    } else if (url.endsWith("student.php")) {
      $("#facilitator-student-link").trigger("click"); // Trigger the products click event
    } else if (url.endsWith("payments.php")) {
      $("#facilitator-payment-link").trigger("click"); // Trigger the products click event
    } else if (url.endsWith("request.php")) {
      $("#facilitator-request-link").trigger("click"); // Trigger the products click event
    } else if (url.endsWith("assign.php")) {
      $("#facilitator-assign-officer").trigger("click"); // Trigger the products click event
    } else {
      $("#facilitator-dashboard-link").trigger("click");
    }

    function requests(){
      $.ajax({
        type: "GET",
        url: "../facilitator-views/request.php",
        datatype: "html",
        success: function (response) {
            $(".content-page").html(response);

            var table = $("#table-request").DataTable({
              dom: "rtp",
            });
            
            $("#search").on("keyup", function(){
              table.search(this.value).draw();
            });
        }
    });
    }

    function viewDashboard(){
      $.ajax({
          type: "GET",
          url: "../facilitator-views/facilitator-dashboard.php",
          datatype: "html",
          success: function (response) {
              $(".content-page").html(response);

              $("#see-more").on("click", function(e){
                e.preventDefault();
                $("#facilitator-payment-link").trigger("click");
              })
          
          }
      });
    }

    function addPayment() {
      $.ajax({
        type: "GET",
        url: `../facilitator-views/add-payment-form.php`,
        datatype: "html",
        success: function (response){
          $(".modal-container").empty().html(response);
          $("#add-payment-modal").modal('show');

          $("#form-request-payment").on("submit", function(e){
            e.preventDefault(e);
            savePendingPayment();
          });


        }
      });
    }

    function savePendingPayment() {
      $.ajax({
          type: "POST",
          url: `../facilitator-views/add-payment.php`,
          data: $("#form-request-payment").serialize(),
          dataType: "json", // Expect JSON response
          success: function(response) {
              // Clear any previous error messages
              $(".invalid-feedback").text("").hide();
              $(".form-control").removeClass("is-invalid");
              
              if (response.status === "error") {
                Object.keys(response.errors).forEach(key => {
                  $(`#${key}`).addClass("is-invalid");
                  $(`#${key}`).next(".invalid-feedback").text(response.errors[key]).show();
                });
                return; // Stop further execution
              } else if (response.status === "success") {
                  $("#add-payment-modal").modal('hide');
                  alert("Payment request submitted successfully!");
              }
          }
      });
  }
  





    function viewStudent(){
      $.ajax({
        type: "GET",
        url: "../facilitator-views/facilitator-students.php",
        datatype: "html",
        success: function (response){
          console.log(response);
          $(".content-page").html(response);

          var table = $("#table-student").DataTable({
            dom: "rtp",
          });
          
          $("#search").on("keyup", function(){
            table.search(this.value).draw();
          });

          $("#course").on("change", function(){
            if (this.value !== "choose-course") {
              table.column(3).search(this.value).draw();
            }
          });

          $(".create-payment").on("click", function(e) {
            e.preventDefault();
            console.log("clicked")
            createPayment(this.dataset.id);
          });


          $(".resign-head").off("click").on("click", function(e){
            e.preventDefault();
            resignOrganizationHead(this.dataset.id);
          });
        }
      });
    }

    function assign(){
      $.ajax({
        type: "GET",
        url: "../facilitator-views/assign.php",
        datatype: "html",
        success: function (response){
          $(".content-page").empty().html(response);

          var table = $("#table-student").DataTable({
            dom: "rtp",
          });
          
          $("#search").on("keyup", function(){
            table.search(this.value).draw();
          });

          $("#course").on("change", function(){
            if (this.value !== "choose-course") {
              table.column(3).search(this.value).draw();
            }
          });


          $(".assign-officer").on("click", function(e){
            e.preventDefault();
            assignOfficer(this.dataset.id)
          });
        }
      });
    }

    function assignOfficer(studentId) {
      $.ajax({
        type: "GET",
        url: `../facilitator-views/assign_officer_form.php?student_id=${studentId}`,
        datatype: "html",
        success: function (response){
          $(".modal-container").empty().html(response);
          $("#assignOfficer").modal('show');

          $("#form-assign-officer").on("click", function(e){
            e.preventDefault(e);
            saveOfficer();
          });
        }
      });
    }

    function assignOfficer(studentId) {
      $.ajax({
        type: "GET",
        url: `../facilitator-views/assign_officer_form.php?student_id=${studentId}`,
        datatype: "html",
        success: function (response){
          $(".modal-container").empty().html(response);
          $("#assignOfficer").modal('show');

          $("#form-assign-officer").on("submit", function(e){
            e.preventDefault(e);
            saveOfficer();
          });
        }
      });
    }

    function saveOfficer() {
      $.ajax({
        type: "POST",
        url: `../facilitator-views/assign_officer.php`,
        data: $("#form-assign-officer").serialize(),
        dataType: "json",
        success: function (response) {
          if (response.status === "error") {
            // Handle validation errors
            if (response.error.position) {
              // Show the error in the invalid-feedback div for #position
              $("#position").addClass("is-invalid");
              $("#position").next(".invalid-feedback").text(response.error.position).show();
            }
            return; // Stop further execution on validation error
          }
    
          // If the request is successful, clear errors and proceed
          $("#position").removeClass("is-invalid");
          $("#position").next(".invalid-feedback").hide();
    
          // Close the modal, refresh data, or provide success feedback
          $("#assignOfficer").modal("hide");
          assign();
          // Optionally refresh the list or UI
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", error);
        },
      });
    }
    


    function viewPayments(){
      $.ajax({
        type: "GET",
        url: "../facilitator-views/facilitator-payments.php",
        datatype: "html",
        success: function (response){
          $(".content-page").empty().html(response);

          var table = $("#table-payment-history").DataTable({
            dom: "rtp"  
        });
        
        $(document).on("keyup", "#search", function () {
          table.search(this.value).draw();
        });

        }
      });
    }

    function createPayment(paymentId) {
      $.ajax({
        type: "GET",
        url: `../facilitator-views/create-payment.php?payment_id=${paymentId}`,
        datatype: "html",
        success: function (response){
          $(".modal-container").empty().html(response);
          $("#staticBackdrop").modal('show');

          $("#form-create-payment").on("submit", function (e){
            e.preventDefault();
            savePayment();
          });
          // ${"#form-create-payment"}.on("submit", function(e) {

          // });
        }
      });
    }

    function savePayment() {
      $.ajax({
        type: "POST",
        url: "../facilitator-views/verify-payment.php",
        data: $("#form-create-payment").serialize(),
        dataType: "json", // Ensure proper parsing of JSON response
        success: function (response) {
          if (response.status === "error") {
            Object.keys(response.errors).forEach(key => {
              $(`#${key}`).addClass("is-invalid");
              $(`#${key}`).next(".invalid-feedback").text(response.errors[key]).show();
            });
            return; // Stop further execution
          }
    

          $("#form-create-payment")[0].reset();
          $("#staticBackdrop").modal("hide");
          viewStudent();
        },
        error: function (error) {
          console.error("AJAX error:", error);
        }
      });
    }

});})()