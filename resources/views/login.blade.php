<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
      <div class="container mt-5">
            <div class="row justify-content-center">
                  <div class="col-md-5">
                        <div class="card shadow">
                              <div class="card-header text-center bg-primary text-white">
                                    <h4>Login</h4>
                              </div>
                              <div class="card-body">
                                    <form id="loginForm">
                                          <div class="mb-3">
                                                <label>Email</label>
                                                <input type="email" id="email" class="form-control"
                                                      placeholder="Enter email" required>
                                          </div>
                                          <div class="mb-3">
                                                <label>Password</label>
                                                <input type="password" id="password" class="form-control"
                                                      placeholder="Enter password" required>
                                          </div>
                                          <button id="loginbtn" type="submit"
                                                class="btn btn-primary w-100">Login</button>
                                    </form>

                                    <div id="error-message" class="mt-3 text-danger text-center" style="display:none;">
                                    </div>
                                    <div id="success-message" class="mt-3 text-success text-center"
                                          style="display:none;"></div>

                                    @if ($errors->any())
                                    <div class="mt-3 text-danger text-center">
                                          {{ $errors->first() }}
                                    </div>
                                    @endif
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
      $(document).ready(function () {
      $('#loginForm').submit(function (e) {
      e.preventDefault();
      
      let email = $('#email').val();
      let password = $('#password').val();
      
      $.ajax({
      url: "/api/login",
      type: "POST",
      data: JSON.stringify({
      email: email,
      password: password
      }),
      contentType: "application/json",
      success: function (response) {
      $('#success-message').text("Login successful!").show();
      $('#error-message').hide();
      
      if (response.token) {
      localStorage.setItem('auth_token', response.token);
      }
      
      setTimeout(function () {
      window.location.href = "/dashboard";
      }, 1000);
      },
      error: function (xhr) {
      let errorMsg = "Login failed. Please check your credentials.";
      
      if (xhr.responseJSON) {
      if (xhr.responseJSON.message) {
      errorMsg = xhr.responseJSON.message;
      } else if (xhr.responseJSON.errors) {
      // If Laravel sends validation errors
      let firstError = Object.values(xhr.responseJSON.errors)[0][0];
      errorMsg = firstError;
      }
      }
      
      $('#error-message').text(errorMsg).show();
      $('#success-message').hide();
      }
      });
      });
      });
</script>


</script>

</html>