<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import CSV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .custom-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo {
            display: block;
            margin: 0 auto;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            font-size: 40px;
            text-align: center;
            line-height: 120px;
            font-weight: bold;
        }
        .form-container {
            padding: 30px;
        }
        .btn-upload {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-upload:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .message-container {
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .text-success {
            background-color: #e3f9e5;
            color: #28a745;
        }
        .text-danger {
            background-color: #f8d7da;
            color: #dc3545;
        }
    </style>
</head>
<body>

    <div class="custom-container mt-5">

        <div class="logo mb-4">
            <span>CSV</span>
        </div>

        <div class="card p-4 shadow">
            <h4 class="text-center mb-4">Import CSV File</h4>

            <form id="csvForm" action="<?= base_url('csv-import/upload') ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="csvFile" class="form-label">Select CSV File</label>
                    <input type="file" class="form-control" name="csv_file" id="csvFile" accept=".csv">
                </div>
                <button type="submit" class="btn btn-upload w-100">Upload</button>
            </form>
        </div>

        <div id="message-container" class="message-container"></div>
    </div>

    <script>
        $(document).ready(function() {
            $("#csvForm").submit(function(e) {
                e.preventDefault(); 
                var formData = new FormData(this);
                
                $.ajax({
                    url: '<?= base_url('csv-import/upload') ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false, 
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'error') {
                            var errorMessages = '';
                            $.each(response.validation_errors, function(index, error) {
                                errorMessages += '<li>' + error + '</li>';
                            });
                            $('#message-container').html('<div class="text-danger"><ul>' + errorMessages + '</ul></div>');
                        } else if (response.status === 'success') {
                            $('#message-container').html('<div class="text-success">' + response.message + '</div>');
                        }
                    },
                    error: function() {
                        $('#message-container').html('<div class="text-danger">An error occurred while uploading the file.</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>
