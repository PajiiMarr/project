(function(){$(document).ready(function () {
      $("#facilitator-dashboard-link").on("click", function(e){
        e.preventDefault();
        request_uri(this.dataset.id)
      });
      $("#facilitator-student-link").on("click", function(e){
        e.preventDefault();
        request_uri(this.dataset.id)
      });
      $("#facilitator-assign-officer").on("click", function(e){
        e.preventDefault();
        request_uri(this.dataset.id)
      });
      $("#facilitator-payment-link").on("click", function(e){
        e.preventDefault();
        request_uri(this.dataset.id)
      });
      $("#facilitator-organization-link").on("click", function(e){
        e.preventDefault();
        request_uri(this.dataset.id);
      });
      $("#facilitator-request-link").on("click", function(e){
        e.preventDefault();
        request_uri(this.dataset.id)
      });
      $("#request-payment").on("click", function(e){
        e.preventDefault();
        request_uri(this.dataset.id)
      });

      $("#student-dashboard-link").on("click", function(e){
        e.preventDefault();
      });
      $("#student-payment-link").on("click", function(e){
        e.preventDefault();
        request_uri(this.dataset.id)
      });
      $("#student-organization-link").on("click", function(e){
        e.preventDefault();
        request_uri(this.dataset.id)
      });
      

      function request_uri(request){
        $.ajax({
            type: 'GET',
            url: `../utilities/__scripts.php?request_uri=${request}`,
            datatype: 'html',
            success: function(response){
                console.log(response)
            }
        });
      }
  });})()