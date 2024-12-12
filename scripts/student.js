$(document).ready(function () {
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
            
            }
        });
      }

      function viewDashboard(){
        $.ajax({
            type: "GET",
            url: "../student_views/dashboard.php",
            datatype: "html",
            success: function (response) {
                $(".content-page").html(response);
            
            }
        });
      }

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