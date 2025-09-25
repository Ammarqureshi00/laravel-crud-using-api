<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>All Posts</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

      <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                  <h4 id="user-email" class="mb-0">Loading user...</h4>
                  <button id="logoutBtn" class="btn btn-danger btn-sm">Logout</button>
            </div>
            <h2 class="mb-4">All Posts</h2>

            <!-- Success Message -->
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Add Post Form -->
            <div class="card mb-4">
                  <div class="card-header">Add New Post</div>
                  <div class="card-body">
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              <div class="mb-3">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" required>
                              </div>
                              <div class="mb-3">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" required></textarea>
                              </div>
                              <div class="mb-3">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control" required>
                              </div>
                              <button type="submit" class="btn btn-primary">Add Post</button>
                        </form>
                  </div>
            </div>

            <!-- Posts Table -->
            <div class="card">
                  <div class="card-header">Posts List</div>
                  <div class="card-body">
                        <table class="table table-bordered">
                              <thead>
                                    <tr>
                                          <th>ID</th>
                                          <th>Title</th>
                                          <th>Description</th>
                                          <th>Image</th>
                                          <th>Action</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    @forelse($posts as $post)
                                    <tr>
                                          <td>{{ $post->id }}</td>
                                          <td>{{ $post->title }}</td>
                                          <td>{{ $post->description }}</td>
                                          <td>
                                                @if($post->image)
                                                <img src="{{ asset('uploads/'.$post->image) }}" width="80" height="60"
                                                      alt="Image">
                                                @endif
                                          </td>
                                          <td>
                                                <!-- Edit Button -->
                                                <a href="{{ route('posts.edit', $post->id) }}"
                                                      class="btn btn-warning btn-sm">Edit</a>

                                                <!-- Delete Form -->
                                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                                      class="d-inline">
                                                      @csrf
                                                      @method('DELETE')
                                                      <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Delete this post?')">Delete</button>
                                                </form>
                                          </td>
                                    </tr>
                                    @empty
                                    <tr>
                                          <td colspan="5" class="text-center">No posts available</td>
                                    </tr>
                                    @endforelse
                              </tbody>
                        </table>
                  </div>
            </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
      document.addEventListener('DOMContentLoaded', function () {
    let token = localStorage.getItem('auth_token');

    if (!token) {
        window.location.href = "/login"; // redirect if no token
        return;
    }

    // Fetch user info if you have a /user route in your API
    fetch("/api/user", {
        method: "GET",
        headers: {
            "Authorization": "Bearer " + token,
            "Content-Type": "application/json"
        }
    })
    .then(response => {
        if (response.status === 401) {
            window.location.href = "/login";
        }
        return response.json();
    })
    .then(data => {
        if (data && data.email) {
            document.getElementById('user-email').innerText = "Logged in as: " + data.email;
        }
    })
    .catch(() => {
        window.location.href = "/login";
    });

    // Logout functionality
    document.getElementById('logoutBtn').addEventListener('click', function () {
        fetch("/api/logout", {
            method:: "Post",
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json"
            }
        }).then(() => {
            localStorage.removeItem('auth_token');
            window.location.href = "/login";
        });
    });
});
</script>

</html>