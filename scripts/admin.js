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


    $("#enroll-student").on("click", function(e) {
      e.preventDefault();
      enrollStudent();
    });

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

              $(".view").on("click", function(e){
                e.preventDefault();
                organizationDetails(this.dataset.id);
              });
              $(".remove").on("click", function(e){
                e.preventDefault();
                deactivateOrganization(this.dataset.id);
              });
              $(".activate").on("click", function(e){
                e.preventDefault();
                activateOrganization(this.dataset.id);
              });
          }
      });
    }

    function activateOrganization(organizationId){
      $.ajax({
        type: "GET",
        url: `../admin_views/activate_form.php?organization_id=${organizationId}`, // Backend script to fetch details
        dataType: "html", // Modal HTML content expected
        success: function(response){
          $(".modal-container").empty().html(response);
          $("#activateOrg").modal("show");

          $("#form-activate-org").on("submit", function(e){
            e.preventDefault();
            updateActive();
          })
        }
    });
  }

    function deactivateOrganization(organizationId){
      $.ajax({
        type: "GET",
        url: `../admin_views/deactivate_form.php?organization_id=${organizationId}`, // Backend script to fetch details
        dataType: "html", // Modal HTML content expected
        success: function(response){
          $(".modal-container").empty().html(response);
          $("#deactivateOrg").modal("show");

          $("#form-deactivate-org").on("submit", function(e){
            e.preventDefault();
            updateDeactivate();
          })
        }
    });
    }

    function updateActive(){
      $.ajax({
        type: "POST",
        url: `../admin_views/activate.php`,
        data: $("#form-activate-org").serialize(), // Modal HTML content expected
        dataType: "html", // Modal HTML content expected
        success: function(){
          $("#activateOrg").modal("hide");
          viewOrganization();
        }
    });
    }
    
    function updateDeactivate(){
      $.ajax({
        type: "POST",
        url: `../admin_views/deactivate.php`,
        data: $("#form-deactivate-org").serialize(), // Modal HTML content expected
        dataType: "html", // Modal HTML content expected
        success: function(){
          $("#deactivateOrg").modal("hide");
          viewOrganization();
        }
    });
    }

    function organizationDetails(orgId) {
      $.ajax({
          type: "GET",
          url: `../admin_views/organization-details.php`, // Backend script to fetch details
          data: { organization_id: orgId },
          dataType: "html", // Modal HTML content expected
          success: function (response) {
              // Insert response into modal container
              $(".modal-container").html(response);

              // Initialize and show the Bootstrap modal
              const modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
              modal.show();

              $(".approve-request").on('click', function (e){
                  e.preventDefault();
                  approveRequest(this.dataset.id, orgId);
              });
              $(".decline-request").on('click', function (e){
                  e.preventDefault();
                  declineRequest(this.dataset.id, orgId);
              });
              $("#edit-organization").on('click', function (e){
                  e.preventDefault();
                  editOrganization(this.dataset.id)
              });
          },
          error: function () {
              alert("Failed to load organization details. Please try again.");
          }
      });
    }

    function approveRequest(collectionId, orgId) {
        $.ajax({
            type: "GET",
            url: `../admin_views/approve-modal.php?collection_id=${collectionId}`,
            dataType: "html",
            success: function (e) {
                $(".request-container").html(e);
                
                // Add blur effect to the background
                $("#staticBackdrop").addClass("blur-effect");

                // Show the modal
                $("#approveFee").modal("show");

                $("#form-approve-request").on("submit", function(e){
                  e.preventDefault();
                  saveApprove(orgId);
                });

                // Remove blur effect when modal is closed
                $("#approveFee").on("hidden.bs.modal", function () {
                    $("#staticBackdrop").removeClass("blur-effect");
                });
            }
        });
    }  

    function saveApprove(orgId) {
      $.ajax({
        type: "POST", // Use POST request
        url: "../admin_views/approve.php", // URL for saving organization
        data: $("#form-approve-request").serialize(), // Serialize the form data for submission
        dataType: "json", // Expect JSON response
        success: function (response) {
          if(response.status == 'success'){
            $("#approveFee").modal("hide");
            $("#form-approve-request")[0].reset();
            $("#staticBackdrop").removeClass("blur-effect");
            $("#staticBackdrop").modal("hide");
            organizationDetails(orgId);
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX error:", status, error);
        },
      });
    }

    function saveDecline(orgId) {
      $.ajax({
        type: "POST", // Use POST request
        url: "../admin_views/decline.php", // URL for saving organization
        data: $("#form-decline-request").serialize(), // Serialize the form data for submission
        dataType: "json", // Expect JSON response
        success: function (response) {
          if(response.status == 'success'){
            $("#declineFee").modal("hide");
            $("#form-decline-request")[0].reset();
            $("#staticBackdrop").removeClass("blur-effect");
            $("#staticBackdrop").modal("hide");
            organizationDetails(orgId);
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX error:", status, error);
        },
      });
    }

    function declineRequest(collectionId, orgId) {
        $.ajax({
            type: "GET",
            url: `../admin_views/decline-modal.php?collection_id=${collectionId}`,
            dataType: "html",
            success: function (e) {
                $(".request-container").html(e);
                
                // Add blur effect to the background
                $("#staticBackdrop").addClass("blur-effect");

                // Show the modal
                $("#declineFee").modal("show");

                $("#form-decline-request").on("submit", function(e){
                  e.preventDefault();
                  saveDecline(orgId);
                });

                // Remove blur effect when modal is closed
                $("#declineFee").on("hidden.bs.modal", function () {
                    $("#staticBackdrop").removeClass("blur-effect");
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
        url: "../admin_views/add-organization.php", // URL for saving organization
        data: $("#form-add-organization").serialize(), // Serialize the form data for submission
        dataType: "json", // Expect JSON response
        success: function (response) {
          console.log(response);
    
          if (response.status === "success") {
            // Hide the modal and reset the form
            $("#staticBackdrop").modal("hide");
            $("#form-add-organization")[0].reset();
    
            viewOrganization();
          }
          else if (response.status === "error") {
            // Clear previous validation
            $(".is-invalid").removeClass("is-invalid");
            $(".invalid-feedback").hide();
    
            // Handle validation errors
            Object.keys(response.errors).forEach((key) => {
              $(`#${key}`).addClass("is-invalid");
              $(`#${key}`).next(".invalid-feedback").text(response.errors[key]).show();
            });
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX error:", status, error);
        },
      });
    }


    function viewStudent(){
      $.ajax({
        type: "GET",
        url: "../admin_views/students-view.php",
        datatype: "html",
        success: function (response){
          $(".content-page").html(response);

          var table = $("#table-student").DataTable({
            dom: "rtp"
          });
          
          $("#search").on("keyup", function(){
            table.search(this.value).draw();
          });

          $("#course").on("change", function(){
            if (this.value !== "choose-course") {
              table.column(3).search(this.value).draw();
            }
          });

          $(".assign-head").off("click").on("click", function(e){
            e.preventDefault();
            assignOrganizationHead(this.dataset.id);
          });

          $(".resign-head").off("click").on("click", function(e){
            e.preventDefault();
            resignOrganizationHead(this.dataset.id);
          });
          $(".edit-student").off("click").on("click", function(e){
            e.preventDefault();
            editStudent(this.dataset.id);
          });

          $(".remove-student").off("click").on("click", function(e){
            e.preventDefault();
            removeStudent(this.dataset.id);
          });
          $(".enroll-undefined-student").off("click").on("click", function(e){
            e.preventDefault();
            enrollUndefinedStudent(this.dataset.id);
          });
        }
      });
    }

    function enrollUndefinedStudent(studentId){
      $.ajax({
        type: 'GET',
        url: `../admin_views/enroll_undefined_student_form.php?student-id=${studentId}` ,
        datatype: "html",
        success: function (view) {
          $(".modal-container").empty().html(view);
          $("#enrollUndefinedStudent").modal('show');

          $("#form-enroll-undefined-student").on("submit", function(e) {
            e.preventDefault();
            saveUndefinedStudent();
          });
        }
      });
    }

    function saveUndefinedStudent(){
      $.ajax({
        type: 'POST',
        url: `../admin_views/enroll_undefined_student.php`,
        data: $(`#form-enroll-undefined-student`).serialize(),
        dataType: "json",
        success: function (response) {
          $("#enrollUndefinedStudent").modal("hide");
          $("#form-enroll-undefined-student")[0].reset();
          viewStudent();
        }
      });
    }

    

    function removeStudent(studentId){
      $.ajax({
        type: 'GET',
        url: `../admin_views/remove_student_confirmation.php?student-id=${studentId}` ,
        datatype: "html",
        success: function (view) {
          $(".modal-container").empty().html(view);
          $("#removeStudent").modal('show');

          $("#form-remove-student").on("submit", function(e) {
            e.preventDefault();
            saveRemovedStudent();
          });
        }
      });
    }

    function saveRemovedStudent(){
      $.ajax({
        type: 'POST',
        url: `../admin_views/remove_student.php`,
        data: $(`#form-remove-student`).serialize(),
        dataType: "json",
        success: function (response) {
          if (response.status === "error") {
            if (response.errors) {
              $("#reason").addClass("is-invalid"); // Add invalid class
              $("#reason").siblings(".invalid-feedback") // Correctly reference invalid-feedback
                .text(response.errors)
                .show(); // Show error message
            }
          } else {
            $("#reason").removeClass("is-invalid"); // Clear invalid class
            $("#reason").siblings(".invalid-feedback").hide(); // Hide error message

          $("#removeStudent").modal("hide");
          $("#form-remove-student")[0].reset();
          viewStudent();
          }
        }
      });
    }

    function editStudent(studentId){
      $.ajax({
        type: 'GET',
        url: `../admin_views/edit_student_form.php?student-id=${studentId}` ,
        datatype: "html",
        success: function (view) {
          $(".modal-container").empty().html(view);
          $("#editStudent").modal('show');

          $("#form-edit-head").on("submit", function(e) {
            e.preventDefault();
            saveOrganizationHead();
          });
        }
      });
    }

    
    function assignOrganizationHead(studentId) {
      $.ajax({
        type: 'GET',
        url: `../admin_views/assign_head_form.php?student-id=${studentId}` ,
        datatype: "html",
        success: function (view) {
          $(".modal-container").empty().html(view);
          $("#assignHead").modal('show');

          $("#form-assign-head").on("submit", function(e) {
            e.preventDefault();
            saveOrganizationHead();
          });
        }
      });
    }
    
    function saveOrganizationHead(){
      $.ajax({
        type: 'POST',
        url: `../admin_views/assign_head.php`,
        data: $(`#form-assign-head`).serialize(),
        dataType: "json",
        success: function (response) {
          if (response.status === "error") {
            if (response.errors) {
              $("#organization_id").addClass("is-invalid"); // Add invalid class
              $("#organization_id").siblings(".invalid-feedback") // Correctly reference invalid-feedback
                .text(response.errors)
                .show(); // Show error message
            }
          } else {
            $("#organization_id").removeClass("is-invalid"); // Clear invalid class
            $("#organization_id").siblings(".invalid-feedback").hide(); // Hide error message

          $("#assignHead").modal("hide");
          $("#form-assign-head")[0].reset();
          viewStudent();
          }
        }
      });
    }

    function resignOrganizationHead(studentId) {
      $.ajax({
        type: 'GET',
        url: `../admin_views/resign_head_modal.php?student-id=${studentId}` ,
        datatype: "html",
        success: function (view) {
          $(".modal-container").empty().html(view);
          $("#resignHead").modal('show');

          $("#form-resign-head").on("submit", function(e) {
            e.preventDefault();
            saveResignOrganizationHead();
          });
        }
      });
    }
    
    function saveResignOrganizationHead(){
      $.ajax({
        type: 'POST',
        url: `../admin_views/resign_head.php`,
        data: $(`#form-resign-head`).serialize(),
        dataType: "json",
        success: function (response) {
          if (response.status === "error") {
            if (response.errors) {
              $("#reason").addClass("is-invalid"); // Add invalid class
              $("#reason").siblings(".invalid-feedback") // Correctly reference invalid-feedback
                .text(response.errors)
                .show(); // Show error message
            }
          } else {
            $("#reason").removeClass("is-invalid"); // Clear invalid class
            $("#reason").siblings(".invalid-feedback").hide(); // Hide error message

          $("#resignHead").modal("hide");
          $("#form-resign-head")[0].reset();
          viewStudent();
          }
        }
      });
    }
    

    function enrollStudent(){
      $.ajax({
        type: "GET",
        url: "../admin_views/enroll_students_form.php",
        datatype: "html",
        success: function (view){
          // $(".modal-container").html(view);
          // $("#staticBackdrop").modal("show");

          $(".modal-container").empty().html(view); // Load the modal view
          $("#staticBackdrop").modal("show"); // Show the modal
  
          $(".close").on("click", function(e){
            $("#staticBackdrop").modal("hide");
            $("#form-enroll-student")[0].reset();
          });

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

          var table = $("#table-payment-history").DataTable({
            dom: "rtp"  
        });
        
        $(document).on("keyup", "#search", function () {
          table.search(this.value).draw();
        });

        }
      });
    }

    function saveStudent() {
      $.ajax({
        type: "POST",
        url: "../admin_views/enroll_students.php",
        data: $("#form-enroll-student").serialize(),
        dataType: "json", // Ensure proper parsing of JSON response
        success: function (response) {
    
          if (response.status === "error") {
            Object.keys(response.errors).forEach(key => {
              $(`#${key}`).addClass("is-invalid");
              $(`#${key}`).next(".invalid-feedback").text(response.errors[key]).show();
            });
          } else {
            $("#staticBackdrop").modal("hide");
            $("#form-enroll-student")[0].reset();
            $("#student-link").trigger("click"); // Trigger the products click event
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX error:", status, error);
        }
      });
    }

    function editOrganization(organizationId){
      $.ajax({
          type: "GET",
          url: `../admin_views/edit_organization_form.php?organization_id=${organizationId}`,
          datatype: "html",
          success: function (response) {
              $(".request-container").empty().html(response);
              $("#staticBackdrop").addClass("blur-effect");
              $("#editOrganization").modal('show');
              
              $("#form-edit-organization").on("submit", function(e){
                e.preventDefault();
                updateOrganization(organizationId);
              });

              $("#editOrganization").on("hidden.bs.modal", function () {
                $("#staticBackdrop").removeClass("blur-effect");
            });
          }
      });
    }

    function updateOrganization(organizationId) {
      $.ajax({
        type: "POST", // Use POST request
        url: "../admin_views/edit_organization.php", // URL for saving organization
        data: $("#form-edit-organization").serialize(), // Serialize the form data for submission
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
              $("#editOrganization").modal('hide');
              alert("Organization editted successfully!");
              $("#staticBackdrop").removeClass("blur-effect");
              $("#staticBackdrop").modal("hide");
              organizationDetails(organizationId);
          }
      },
        error: function (xhr, status, error) {
          console.error("AJAX error:", status, error);
        },
      });
    }
});