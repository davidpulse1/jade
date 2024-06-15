<!DOCTYPE html>
<html>
<head>
    <title>Company Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, Company</h2>
        <div class="bookings">
            <h3>Pending Bookings</h3>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fetch and display bookings from company_bookings.php -->
                </tbody>
            </table>
        </div>
        <div class="messages">
            <h3>Inbox</h3>
            <div id="inbox">
                <!-- Fetch and display messages from inbox.php -->
            </div>
            <h3>Outbox</h3>
            <div id="outbox">
                <!-- Fetch and display messages from outbox.php -->
            </div>
        </div>
        <div class="verification-questions">
            <h3>Verification Questions</h3>
            <form method="POST" action="add_question.php">
                <input type="text" name="question" placeholder="Question" required>
                <select name="type" required>
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="date">Date</option>
                    <option value="choice">Choice</option>
                </select>
                <textarea name="options" placeholder="Options (JSON format)" required></textarea>
                <button type="submit">Add Question</button>
            </form>
        </div>
    </div>
</body>
</html>
