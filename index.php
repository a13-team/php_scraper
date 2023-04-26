<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Scraper</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item"><a href="preview.php">Preview</a></li>
  </ol>
</nav>
<div class="container">
        <h1 class="my-3">Web Scraper</h1>
        <form action="scraper.php" method="POST">
            <div class="form-group">
                <label for="url">URL:</label>
                <input type="url" class="form-control" id="url" name="url" required>
            </div>
            <div class="form-group">
                <label for="max_depth">Max Depth:</label>
                <input type="number" class="form-control" id="max_depth" name="max_depth" min="1" required>
            </div>
            <div class="form-group">
                <label for="user_agent">User Agent:</label>
                <input type="text" class="form-control" id="user_agent" name="user_agent">
            </div>
            <div class="form-group">
                <label for="proxy">Proxy:</label>
                <input type="text" class="form-control" id="proxy" name="proxy">
            </div>
            <input type="hidden" name="save_dir" value="websites">
            <button type="submit" class="btn btn-primary">Scrape</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>