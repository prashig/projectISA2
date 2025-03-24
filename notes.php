<?php
include 'server.php'; 

if (!isset($_GET['classCode'])) {
    die(" Error: Class Code is missing from the URL!");
}

$classCode = $_GET['classCode'];

// fetch corresponding class ID
$stmt = $conn->prepare("SELECT c_id FROM classes WHERE classCode = ?");
$stmt->bind_param("s", $classCode);
$stmt->execute();
$result = $stmt->get_result();
$classRow = $result->fetch_assoc();
$classId = $classRow ? $classRow['c_id'] : null;

if (!$classId) {
    die(" Error: No class found for this Class Code!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
    <link rel="stylesheet" href="style1.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       $(document).ready(function () {
            $("#uploadNoteForm").submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("classId", $("#classId").val());

                $.ajax({
                    url: "uploadNotes.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log("Upload Response:", response);
                        try {
                            var res = JSON.parse(response);
                            if (res.success) {
                                $("#message").html('<p style="color: green; font-size: 18px;">File uploaded successfully!</p>');
                                $("#uploadNoteForm")[0].reset();
                                setTimeout(function () {
                                    $("#message").html(""); // clear message after 2 sec
                                }, 2000);
                            } else {
                                $("#message").html('<p style="color: red;"> ' + res.message + '</p>');
                            }
                        } catch (error) {
                            console.log("JSON Parse Error:", error);
                            $("#message").html('<p style="color: red;"> Error processing request.</p>');
                        }
                    },
                    error: function () {
                        $("#message").html('<p style="color: red;"> Upload failed! Please try again.</p>');
                    }
                });
            });
        });
    </script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #e4caa4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h2 {
            color: #455763;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #455763;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            transition: background 0.3s ease-in-out;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #2e3f4c;
        }
        .dashboard-btn {
            display: block;
            width: fit-content;
            margin: 20px auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload Notes</h2>
        <input type="hidden" id="classId" value="<?php echo htmlspecialchars($classId); ?>">
        <form id="uploadNoteForm" enctype="multipart/form-data">
            <label for="noteTitle">Note Title:</label>
            <input type="text" id="noteTitle" name="noteTitle" required>

            <label for="noteFile">Upload File:</label>
            <input type="file" id="noteFile" name="noteFile" required>

            <button type="submit" class="btn">Upload Note</button>
        </form>
        <div id="message"></div>
        <a href="dashboard.php" class="btn dashboard-btn">Back to Dashboard</a>
    </div>
</body>
</html>
