<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Edit Post</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

      <div class="container mt-5">
            <h2 class="mb-4">Edit Post</h2>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                  <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                  </ul>
            </div>
            @endif

            <div class="card">
                  <div class="card-header">Update Post</div>
                  <div class="card-body">
                        <form action="{{ route('posts.update', $post->id) }}" method="POST"
                              enctype="multipart/form-data">
                              @csrf
                              @method('PUT')

                              <div class="mb-3">
                                    <label>Title</label>
                                    <input type="text" name="title" value="{{ old('title', $post->title) }}"
                                          class="form-control" required>
                              </div>

                              <div class="mb-3">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control"
                                          required>{{ old('description', $post->description) }}</textarea>
                              </div>

                              <div class="mb-3">
                                    <label>Current Image</label><br>
                                    @if($post->image)
                                    <img src="{{ asset('uploads/'.$post->image) }}" width="100" height="80"
                                          class="mb-2">
                                    @else
                                    <p>No image uploaded</p>
                                    @endif
                              </div>

                              <div class="mb-3">
                                    <label>Upload New Image (optional)</label>
                                    <input type="file" name="image" class="form-control">
                              </div>

                              <button type="submit" class="btn btn-primary">Update Post</button>
                              <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                  </div>
            </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>