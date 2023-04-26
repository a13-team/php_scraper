<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Scrapped Websites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center mt-5">Preview Scrapped Websites</h1>
                <div class="row mt-4">
                    <?php
                    $dir = 'websites';
                    $files = scandir($dir);

                    foreach ($files as $file) {
                        if ($file == '.' || $file == '..') {
                            continue;
                        }
                        $path = $dir . '/' . $file;
                        echo '<div class="col-md-4 mb-3">';
                        echo '<div class="card h-100">';
                        echo '<img src="' . $path . '/preview.jpg" class="card-img-top" alt="Preview">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $file . '</h5>';
                        echo '<a href="' . $path . '" class="btn btn-primary">View</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.btn-primary').click(function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                axios.get(url + '/index.html')
                    .then(function(response) {
                        Swal.fire({
                            title: 'Preview',
                            html: response.data,
                            showCloseButton: true,
                            showCancelButton: false,
                            showConfirmButton: false,
                            focusConfirm: false,
                            width: '80%',
                            heightAuto: false,
                            padding: '3em',
                            backdrop: `
                                rgba(0,0,123,0.4)
                                url("https://sweetalert2.github.io/images/nyan-cat.gif")
                                left top
                                no-repeat
                            `
                        })
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            });
        });
        </script>
        <script>
            window.transitionToPage = function(href) {
    document.querySelector('body').style.opacity = 0
    setTimeout(function() { 
        window.location.href = href
    }, 500)
}

document.addEventListener('DOMContentLoaded', function(event) {
    document.querySelector('body').style.opacity = 1
})
        </script>
</body>
</html>