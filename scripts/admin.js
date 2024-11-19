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
    $(".form-selector").on("submit", function(e){
      e.preventDefault();
    })

    let url = window.location.href;
    if (url.endsWith("dashboard.php")) {
      $("#dashboard-link").trigger("click"); // Trigger the dashboard click event
    } else if (url.endsWith("organization.php")) {
      $("#org-overview-link").trigger("click"); // Trigger the products click event
    } else if (url.endsWith("student.php")) {
      $("#students-link").trigger("click"); // Trigger the products click event
    } else if (url.endsWith("payment.php")) {
      $("#payment-link").trigger("click"); // Trigger the products click event
    }


    function viewOrganization(){
      $.ajax({
          type: "POST",
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
        url: "../admin_views/student.php",
        datatype: "html",
        success: function (response){
          $(".content-page").html(response);
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
});