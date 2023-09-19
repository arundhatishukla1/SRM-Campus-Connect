<?php
require 'config.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["submit"])) {
        // Process form data
        $event_name = mysqli_real_escape_string($connection, $_POST['name']);
        $event_description = mysqli_real_escape_string($connection, $_POST['description']);
        $event_date = $_POST['date'];
        $event_time = $_POST['time'];
        $event_venue = mysqli_real_escape_string($connection, $_POST['venue']);
        $event_requirement = mysqli_real_escape_string($connection, $_POST['requirement']);
        $od_provided = $_POST['odprovided'];

    // Process and move the uploaded image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $temp_file = $_FILES['image']['tmp_name'];
        $original_filename = $_FILES['image']['name'];

        // Generate a unique filename (e.g., using a timestamp)
        $unique_filename = time() . '_' . $original_filename;

        // Define the target directory to save the image
        $target_directory = 'uploads/';
        // Create the directory if it doesn't exist
        if (!is_dir($target_directory)) {
            mkdir($target_directory, 0777, true); // Create the directory with read, write, and execute permissions
        }

        // Create the full path to the target file
        $target_path = $target_directory . $unique_filename;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($temp_file, $target_path)) {
            // File was successfully uploaded and saved
            $query = "INSERT INTO events (event_name, event_description, event_date, event_time, event_venue, event_requirement, od_provided) VALUES ('$event_name', '$event_description', '$event_date', '$event_time', '$event_venue', '$event_requirement', '$od_provided')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "Event data and image uploaded and saved in the database.";
                $event_id = mysqli_insert_id($conn);

                // Insert image_path into the event_images table
                $insert_image_query = "INSERT INTO event_images (event_id, image_path) VALUES ('$event_id', '$target_path')";

                $image_result = mysqli_query($conn, $insert_image_query);
                if ($image_result) {
                    echo "Event data and image uploaded and saved in the database.";
                } 
                else {
                    echo "Error inserting image_path: " . mysqli_error($conn);
                }
            } 
            else {
                echo "Error inserting event data: " . mysqli_error($conn);
            }
        }
        else {
            echo "File upload failed.";
        }
    } 
    else {
        echo "Error: " . $_FILES['image']['error'];
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add an event</title>
    <link rel="stylesheet" href="processEvent.css">
</head>
<body>
    <form action="">
        <h1>Add an event!</h1>
        <h2>Event Details</h2>
        <p>Name: <input type="text" name="name" id="name" required size="30"></p>
        <p>Description: <textarea name="address" id="address" cols="50" rows="4"></textarea></p>
        <p>Date: <input type="date" name="date" id="date" required> </p>
        <p>Time: <input type="text" name="time" id="time" required> </p>
        <p>Venue: <input type="text" name="venue" id="venue" required size="30"> </p>
        <p>Requirements: <input type="text" name="requirement" id="requirement" required size="30" ></p>
        <p>OD Provided: </p>
        <p>
            Yes <input type="radio" name="odprovided" id="yes" required>
            No <input type="radio" name="odprovided" id="no" required>
        </p>
          <p>Upload Image: </p>
          <input type="file" name="image" id="image" accept="image/*" required>
          <p>Accepted formats: JPG, PNG, GIF</p>
          <br>
          <input type="submit" name = "submit" value="Upload">
    </form>
</body>
</html>