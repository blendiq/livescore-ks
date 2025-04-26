<?php
// Include your database connection
include('db.php'); // Assuming db_connection.php has your connection code

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the query to get match data
    $sql = "SELECT * FROM matches WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $match = $result->fetch_assoc();
    } else {
        die("Match not found.");
    }
} else {
    die("No match ID specified.");
}

// Update the match if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team1 = $_POST['team1'];
    $team2 = $_POST['team2'];
    $match_date = $_POST['match_date'];
    $venue = $_POST['venue'];
    $status = $_POST['status'];
    $score_team1 = $_POST['score_team1'];
    $score_team2 = $_POST['score_team2'];

    // Prepare the update query
    $update_sql = "UPDATE matches SET team1 = ?, team2 = ?, match_date = ?, venue = ?, status = ?, score_team1 = ?, score_team2 = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssssi", $team1, $team2, $match_date, $venue, $status, $score_team1, $score_team2, $id);
    $stmt->execute();

    // Redirect to the matches table or another page after updating
    header("Location: dashboard.php");
    exit();
}
?>

<!-- Match Edit Form -->
<form method="POST" class="update-form">
    <h2>Update Match Details</h2>
    
    <label for="team1">Team 1:</label>
    <input type="text" name="team1" value="<?php echo $match['team1']; ?>" required class="input-field"><br>

    <label for="team2">Team 2:</label>
    <input type="text" name="team2" value="<?php echo $match['team2']; ?>" required class="input-field"><br>

    <label for="match_date">Match Date:</label>
    <input type="datetime-local" name="match_date" value="<?php echo date('Y-m-d\TH:i', strtotime($match['match_date'])); ?>" required class="input-field"><br>

    <label for="venue">Venue:</label>
    <input type="text" name="venue" value="<?php echo $match['venue']; ?>" required class="input-field"><br>

    <label for="status">Status:</label>
    <select name="status" class="input-field">
        <option value="Live" <?php echo ($match['status'] == 'Live') ? 'selected' : ''; ?>>Live</option>
        <option value="Completed" <?php echo ($match['status'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
    </select><br>

    <label for="score_team1">Score Team 1:</label>
    <input type="number" name="score_team1" value="<?php echo $match['score_team1']; ?>" class="input-field"><br>

    <label for="score_team2">Score Team 2:</label>
    <input type="number" name="score_team2" value="<?php echo $match['score_team2']; ?>" class="input-field"><br>

    <button type="submit" class="btn-submit">Update Match</button>
</form>

<!-- Add this to the <head> of your HTML for styling -->
<style>
    /* Styling the Form Container */
    .update-form {
        width: 100%;
        max-width: 600px;
        margin: 30px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-family: 'Arial', sans-serif;
    }

    .update-form h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    /* Styling the Input Fields */
    .input-field {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        box-sizing: border-box;
    }

    .input-field:focus {
        border-color: #4CAF50;
        outline: none;
    }

    /* Styling the Submit Button */
    .btn-submit {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #45a049;
    }

    /* Optional: Responsive design for smaller screens */
    @media (max-width: 600px) {
        .update-form {
            width: 90%;
        }

        .btn-submit {
            font-size: 16px;
        }
    }
</style>

