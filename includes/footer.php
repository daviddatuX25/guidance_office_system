        <p class="text-center p-1"> &copy; <?=date('Y')?> ICAT Website. All rights reserved. </p>
    </div>

    <script>
        // Function to show notification
        function showNotification(status, message) {
            let statusClass; // Declare statusClass
            const $notification = $('#notification');
            const $notifMessage = $('#notifMessage');

            // Set status class based on type
            switch(status) {
                case "success":
                    statusClass = "bg-success text-white";
                    break;
                case "error":
                    statusClass = "bg-danger text-white";
                    break;
                case "warning":
                    statusClass = "bg-warning text-dark";
                    break;
                default:
                    statusClass = "bg-light text-dark";
            }

            $notification
                .removeClass('d-none bg-light bg-success bg-danger bg-warning text-white text-dark')
                .addClass('d-block ' + statusClass);
            $notifMessage.text(message);

            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                $notification
                    .removeClass('d-block ' + statusClass)
                    .addClass('d-none bg-light text-dark');
            }, 5000); // 5000ms = 5 seconds
        }

        // Close button functionality
        $('#closeNotification').on('click', function() {
            $('#notification').removeClass('d-block').addClass('d-none');
        });

        $(document).ready(function() {
            $('#logout-button').click(function() {
                $.ajax({
                    url: 'logout.php',
                    success: ()=>{
                        window.location.href = 'index.php';
                    }
                });
            });

            // // Check if a nav item is saved in localStorage
            // const lastTab = localStorage.getItem('lastTab');
            // if (lastTab) {
            //     // Activate the saved tab
            //     $(`#${lastTab}-tab`).addClass('active');
            //     $(`#${lastTab}`).addClass('show active');
            //     $('.tab-pane').not(`#${lastTab}`).removeClass('show active');
            //     $('.nav-link').not(`#${lastTab}-tab`).removeClass('active');
            // }

            // // Save the selected nav item to localStorage on click
            // $('.nav-link').on('click', function () {
            //     const tabId = $(this).attr('id').replace('-tab', '');
            //     localStorage.setItem('lastTab', tabId);
            // });
            
            
        });
    </script>


</body>
</html>