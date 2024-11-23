$(document).ready(function () {
    // Attach click event to table rows
    $('#table-organization').on('click', 'tr', function () {
        const orgId = $(this).data('org-id'); // Get organization ID

        if (orgId) {
            // Fetch and display organization details
            organizationDetails(orgId);
        }
    });

    function organizationDetails(orgId) {
        $.ajax({
            type: "GET",
            url: `../admin/organization-details.php`, // Backend script to fetch details
            data: { organization_id: orgId },
            dataType: "html", // Modal HTML content expected
            success: function (response) {
                // Insert response into modal container
                $(".modal-container").html(response);

                // Initialize and show the Bootstrap modal
                const modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
                modal.show();
            },
            error: function () {
                alert("Failed to load organization details. Please try again.");
            }
        });
    }
});
