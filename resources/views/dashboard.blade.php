<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Dashboard</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                  <a class="navbar-brand" href="#">My App</a>
                  <div class="d-flex">
                        <button id="logoutBtn" class="btn btn-outline-light">Logout</button>
                  </div>
            </div>
      </nav>

      <!-- Dashboard Content -->
      <div class="container mt-4">
            <div class="row">
                  <!-- Sidebar -->
                  <div class="col-md-3">
                        <div class="list-group shadow-sm">
                              <a href="#" class="list-group-item list-group-item-action active">Dashboard</a>
                              <a href="#" class="list-group-item list-group-item-action">Profile</a>
                              <a href="#" class="list-group-item list-group-item-action">Settings</a>
                        </div>
                  </div>

                  <!-- Main Content -->
                  <div class="col-md-9">
                        <div class="card shadow-sm">
                              <div class="card-header bg-primary text-white">
                                    <h5>Welcome to your Dashboard</h5>
                              </div>
                              <div class="card-body">
                                    <p>You are logged in successfully 🎉</p>
                                    <p id="user-email" class="fw-bold"></p>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

      {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
      <script>
            $(document).ready(function () {
        // Get token from localStorage
        let token = localStorage.getItem('auth_token');

        if (!token) {
            window.location.href = "/login"; // redirect if no token
        }

        // Example: Fetch user info (if your API provides /me or /user route)
        $.ajax({
            url: "/api/user",
            type: "GET",
            headers: {
                "Authorization": "Bearer " + token
            },
            success: function (response) {
                $('#user-email').text("Logged in as: " + response.email);
            },
            error: function () {
                // If token expired or invalid, redirect to login
                localStorage.removeItem('auth_token');
                window.location.href = "/login";
            }
        });

        // Logout Button
        $('#logoutBtn').click(function () {
            localStorage.removeItem('auth_token');
            window.location.href = "/login";
        });
    });
      </script> --}}
</body>

</html>