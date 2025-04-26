<?php
// Include your database configuration file
include 'db.php';

// Declare variables and initialize them
$team1 = $team2 = $match_date = $venue = $status = "";
$team1_err = $team2_err = $match_date_err = $venue_err = $status_err = "";

// Process form submission when it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate team1
    if (empty(trim($_POST["team1"]))) {
        $team1_err = "Please enter Team 1.";
    } else {
        $team1 = trim($_POST["team1"]);
    }

    // Validate team2
    if (empty(trim($_POST["team2"]))) {
        $team2_err = "Please enter Team 2.";
    } else {
        $team2 = trim($_POST["team2"]);
    }

    // Validate match date
    if (empty($_POST["match_date"])) {
        $match_date_err = "Please select a match date.";
    } else {
        $match_date = $_POST["match_date"];
    }

    // Validate venue
    if (empty(trim($_POST["venue"]))) {
        $venue_err = "Please enter a venue.";
    } else {
        $venue = trim($_POST["venue"]);
    }

    // Validate status
    if (empty(trim($_POST["status"]))) {
        $status_err = "Please select a valid status.";
    } else {
        $status = trim($_POST["status"]);
        $allowed_statuses = ['Scheduled', 'Live', 'Completed'];
        if (!in_array($status, $allowed_statuses)) {
            $status_err = "Invalid status selected.";
        }
    }

    // If no errors, proceed with inserting the match into the database
    if (empty($team1_err) && empty($team2_err) && empty($match_date_err) && empty($venue_err) && empty($status_err)) {

        // Set initial scores
        $score_team1 = 0;
        $score_team2 = 0;

        // Prepare SQL query
        $sql = "INSERT INTO matches (team1, team2, match_date, venue, status, score_team1, score_team2) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssiii", $team1, $team2, $match_date, $venue, $status, $score_team1, $score_team2);

            // Execute the query
            if ($stmt->execute()) {
                // Redirect to dashboard
                header("Location: dashboard.php");

                
                exit(); // Always good to call exit after header redirect
            }
            else {
                echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Error preparing the SQL statement.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Match</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Create a New Match</h2>
    <form action="create_match.php" method="POST">
        <!-- Team 1 -->
        <div class="form-group">
            <label for="team1">Team 1</label>
            <input type="text" class="form-control <?php echo (!empty($team1_err)) ? 'is-invalid' : ''; ?>" id="team1" name="team1" value="<?php echo $team1; ?>" placeholder="Enter Team 1 name" required>
            <div class="invalid-feedback"><?php echo $team1_err; ?></div>
        </div>

        <!-- Team 2 -->
        <div class="form-group">
            <label for="team2">Team 2</label>
            <input type="text" class="form-control <?php echo (!empty($team2_err)) ? 'is-invalid' : ''; ?>" id="team2" name="team2" value="<?php echo $team2; ?>" placeholder="Enter Team 2 name" required>
            <div class="invalid-feedback"><?php echo $team2_err; ?></div>
        </div>

        <!-- Match Date -->
        <div class="form-group">
            <label for="match_date">Match Date</label>
            <input type="datetime-local" class="form-control <?php echo (!empty($match_date_err)) ? 'is-invalid' : ''; ?>" id="match_date" name="match_date" value="<?php echo $match_date; ?>" required>
            <div class="invalid-feedback"><?php echo $match_date_err; ?></div>
        </div>

        <!-- Venue -->
        <div class="form-group">
            <label for="venue">Venue</label>
            <input type="text" class="form-control <?php echo (!empty($venue_err)) ? 'is-invalid' : ''; ?>" id="venue" name="venue" value="<?php echo $venue; ?>" placeholder="Enter Venue" required>
            <div class="invalid-feedback"><?php echo $venue_err; ?></div>
        </div>

        <!-- Status -->
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control <?php echo (!empty($status_err)) ? 'is-invalid' : ''; ?>" id="status" name="status" required>
                <option value="">-- Select Status --</option>
                <option value="Scheduled" <?php echo ($status == 'Scheduled') ? 'selected' : ''; ?>>Scheduled</option>
                <option value="Live" <?php echo ($status == 'Live') ? 'selected' : ''; ?>>Live</option>
                <option value="Completed" <?php echo ($status == 'Completed') ? 'selected' : ''; ?>>Completed</option>
            </select>
            <div class="invalid-feedback"><?php echo $status_err; ?></div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Create Match</button>
    </form>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
