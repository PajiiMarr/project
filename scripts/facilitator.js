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
    $("#facilitator-payment-link").on("click", function(e){
      e.preventDefault();
      viewPayments();
    });

    let url = window.location.href;
    if (url.endsWith("dashboard.php")) {
      $("#facilitator-dashboard-link").trigger("click"); // Trigger the dashboard click event
    } else if (url.endsWith("students.php")) {
      $("#facilitator-student-link").trigger("click"); // Trigger the products click event
    } else if (url.endsWith("payments.php")) {
      $("#facilitator-payment-link").trigger("click"); // Trigger the products click event
    } else {
      $("#facilitator-dashboard-link").trigger("click");
    }

    function viewDashboard(){
      $.ajax({
          type: "GET",
          url: "../facilitator-views/facilitator-dashboard.php",
          datatype: "html",
          success: function (response) {
              $(".content-page").html(response);
          
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

    function viewPayments(){
      $.ajax({
        type: "GET",
        url: "../facilitator-views/facilitator-payments.php",
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

});})()