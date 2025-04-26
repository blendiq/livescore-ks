<?php
// index.php

include('db.php');  // Include database connection

// Query to fetch all the matches from the database
$sql = "SELECT * FROM matches ORDER BY match_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage - Matches</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Upcoming and Live Matches</h1>

        <!-- Links for login, registration, and admin login -->
        <div class="text-center">
            <a href="create_match.php" class="btn">Add Match</a>
            
        </div>

        <!-- Matches Table -->
<div class="matches-table">
    <table>
        <thead>
            <tr>
                <th>Match</th>
                <th>Date</th>
                <th>Venue</th>
                <th>Status</th>
                <th>Score</th>
                <th>Actions</th> <!-- New column for Edit and Delete buttons -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if matches are found
            if ($result->num_rows > 0) {
                // Loop through each match
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['team1'] . " " . $row['team2'] . "</td>";
                    echo "<td>" . date('F j, Y, g:i a', strtotime($row['match_date'])) . "</td>";
                    echo "<td>" . $row['venue'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";

                    // Show score only if the match is completed or live
                    if ($row['status'] == 'Completed' || $row['status'] == 'Live') {
                        echo "<td>" . $row['score_team1'] . " - " . $row['score_team2'] . "</td>";
                    } else {
                        echo "<td>-</td>";
                    }

                    // Actions: Edit and Delete buttons
                    echo "<td>";
                    echo "<a href='edit_match.php?id=" . $row['id'] . "' class='btn btn-edit'>Edit</a> | ";
                    echo "<a href='delete_match.php?id=" . $row['id'] . "' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this match?\")'>Delete</a>";
                    echo "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No matches available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


    <style>
/* General container styling */
.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
}

/* Centered heading */
h1.text-center {
    text-align: center;
    margin-bottom: 30px;
}

/* Button Styling */
.btn {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    margin: 10px;
    border-radius: 4px;
    text-align: center;
}

.btn:hover {
    background-color: #0056b3;
}

/* Matches Table Styling */
.matches-table {
    width: 100%;
    margin-top: 20px;
    overflow-x: auto;
}

.matches-table table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.matches-table th, .matches-table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

.matches-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.matches-table td {
    background-color: #fafafa;
}

.matches-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.matches-table tr:hover {
    background-color: #e9e9e9;
}




    </style>
</body>
</html>
