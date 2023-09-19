<?php
require 'config.php';
$message = '';

if (isset($_POST["submit"])) {
    // Process form data
    $event_name = mysqli_real_escape_string($conn, $_POST['name']);
    $event_description = mysqli_real_escape_string($conn, $_POST['address']);
    $event_date = $_POST['date'];
    $event_time = $_POST['time'];
    $event_venue = mysqli_real_escape_string($conn, $_POST['venue']);
    $event_requirement = mysqli_real_escape_string($conn, $_POST['requirement']);
    $od_provided = $_POST['odprovided'];

    // Process and validate the uploaded image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $temp_file = $_FILES['image']['tmp_name'];
        $original_filename = $_FILES['image']['name'];
        $fileSize = $_FILES["image"]["size"];

        $validImageExtensions = ['jpg', 'jpeg', 'png'];
        $imageExtension = pathinfo($original_filename, PATHINFO_EXTENSION);
        $imageExtension = strtolower($imageExtension);

        if (!in_array($imageExtension, $validImageExtensions)) {
            echo "<script> alert('Invalid Image Extension'); </script>";
        } elseif ($fileSize > 1000000) { // 1 MB (adjust this value as needed)
            echo "<script> alert('Image Size is too Large'); </script>";
        } else {
            $newImageName = uniqid() . '.' . $imageExtension;
            $target_directory = 'uploads/';

            if (!is_dir($target_directory)) {
                mkdir($target_directory, 0777, true); // Create the directory with read, write, and execute permissions
            }

            $target_path = $target_directory . $newImageName;

            if (move_uploaded_file($temp_file, $target_path)) {
                // File was successfully uploaded and saved
                $query = "INSERT INTO events (event_name, event_description, event_date, event_time, event_venue, event_requirement, od_provided) VALUES ('$event_name', '$event_description', '$event_date', '$event_time', '$event_venue', '$event_requirement', '$od_provided')";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    $event_id = mysqli_insert_id($conn);

                    // Insert image_path into the event_images table
                    $insert_image_query = "INSERT INTO event_images (event_id, image_path) VALUES ('$event_id', '$target_path')";

                    $image_result = mysqli_query($conn, $insert_image_query);
                    if ($image_result) {
                        echo "<script>
                            alert('Event data and image uploaded and saved in the database.');
                            document.location.href = 'home.php';
                        </script>";
                    } else {
                        echo "Error inserting image_path: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error inserting event data: " . mysqli_error($conn);
                }
            } else {
                echo "File upload failed.";
            }
        }
    } else {
        echo "Error: " . $_FILES['image']['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="processEvent.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
</head>

<body>
    <div class="wrapper">
        <h2>Add An Event!</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <h4>Event Details</h4>
            <div class="input_group">
                <div class="input_box">
                    <input type="text" placeholder="Event Name" name="name" required class="name">
                    <i class="fa fa-chevron-circle-right icon"></i>
                </div>
            </div>
            <div class="input_group">
                <div class="input_box">
                    <input type="text" placeholder="Description" name="address" required class="name">
                    <i class="fa fa-book icon"></i>
                </div>
            </div>
            <div class="input_group">
                <div class="input_box">
                    <input type="text" placeholder="Venue" name="venue" required class="name">
                    <i class="fa fa-map-marker icon" aria-hidden="true"></i>
                </div>
            </div>
            <div class="input_group">
                <div class="input_box">
                    <input type="text" placeholder="Requirements" name="requirement" required class="name">
                    <i class="fa fa-align-justify icon"></i>
                </div>
            </div>
 
            <div class="input_group">
                <div class="input_box">
                    <h4>Date Of Event</h4>
                    <p><input type="date" name="date" id="date" required class="fa-2x"> </p>
                </div>
                <div class="input_box">
                    <h4>OD Provided</h4>
                    <input type="radio" name="odprovided" class="radio" id="b1" checked>
                    <label for="b1">Yes</label>
                    <input type="radio" name="odprovided" class="radio" id="b2">
                    <label for="b2">No</label>
                </div>
            </div>
            <div class="input_box">
                <input type="text" placeholder="Time of event" name="time" required class="name">
                <i class="fa fa-clock-o icon" aria-hidden="true"></i>
            </div>
            <div>
                <h4>Upload Image</h4>
                <input type="file" name="image" id="image" accept="image/*" required>
                <br>
            </div>

            <div class="input_group">
                <div class="input_box">
                    <input type="submit" name="submit" value="Submit">
                </div>
            </div>
        </form>
    </div>
</body>

</html>
