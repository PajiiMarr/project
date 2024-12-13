(function () {
  $(document).ready(function () {
    let url = window.location.href;

    const handleLinkClick = function (e) {
      e.preventDefault();
      const request = this.dataset.id;
      requestUri(request, url);
    };

    $("#facilitator-dashboard-link").on("click", handleLinkClick);
    $("#facilitator-student-link").on("click", handleLinkClick);
    $("#facilitator-assign-officer").on("click", handleLinkClick);
    $("#facilitator-payment-link").on("click", handleLinkClick);
    $("#facilitator-organization-link").on("click", handleLinkClick);
    $("#facilitator-request-link").on("click", handleLinkClick);
    $("#request-payment").on("click", handleLinkClick);
    $("#student-dashboard-link").on("click", handleLinkClick);
    $("#student-payment-link").on("click", handleLinkClick);
    $("#student-organization-link").on("click", handleLinkClick);

    function requestUri(request, url) {
      $.ajax({
        type: 'POST', // Use POST method
        url: `../users/${url}`, // Dynamic URL
        data: { request_uri: request }, // Pass data dynamically
        datatype: 'html',
        success: function (response) {
          console.log(response);
        },
        error: function (xhr, status, error) {
          console.error("Request failed:", error);
        }
      });
    }
  });
})();
