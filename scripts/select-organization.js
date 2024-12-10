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
                    approveRequest(this.dataset.id);
                });
                $(".decline-request").on('click', function (e){
                    e.preventDefault();

                    declineRequest(this.dataset.id);
                });
            },
            error: function () {
                alert("Failed to load organization details. Please try again.");
            }
        });
    }

    function approveRequest(collectionId) {
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

                // Remove blur effect when modal is closed
                $("#approveFee").on("hidden.bs.modal", function () {
                    $("#staticBackdrop").removeClass("blur-effect");
                });
            }
        });
    }  

    // function assignFacilitators() {
    //     $.ajax({
    //         type: "GET",
    //         url: `../admin/assign_facilitator.php`, // Backend script to fetch details
    //         dataType: "html", // Modal HTML content expected
    //         success: function (response) {
    //             $(".modal-assign-facilitator").html(response);
    //             $("#staticBackdrop .modal-content").addClass("blur-effect");
    //             // Initialize and show the Bootstrap modal
    //             const modal = new bootstrap.Modal(document.getElementById('staticBackdropFacilitator'));
    //             modal.show();

    //             const assignFacilitator = document.getElementById('staticBackdropFacilitator');
    //             assignFacilitator.addEventListener('hidden.bs.modal', function () {
    //                 $("#staticBackdrop .modal-content").removeClass("blur-effect");
    //             });
    //         },
    //         error: function () {
    //             alert("Failed to load organization details. Please try again.");
    //         }
    //     });
    // }

});
