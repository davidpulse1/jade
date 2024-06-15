<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link href='fullcalendar/main.css' rel='stylesheet' />
    <script src='fullcalendar/main.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                select: function(info) {
                    var startDate = info.startStr;
                    var endDate = info.endStr;
                    // Send selected dates to server
                    fetch('save_dates.php', {
                        method: 'POST',
                        body: JSON.stringify({ start: startDate, end: endDate }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }).then(response => response.json())
                      .then(data => {
                          alert(data.message);
                      });
                }
            });

            calendar.render();
        });
    </script>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, User</h2>
        <div id='calendar'></div>
        <div class="messages">
            <h3>Inbox</h3>
            <!-- Inbox messages will be loaded here -->
            <div id="inbox">
                <!-- Fetch and display messages from inbox.php -->
            </div>
            <h3>Outbox</h3>
            <!-- Outbox messages will be loaded here -->
            <div id="outbox">
                <!-- Fetch and display messages from outbox.php -->
            </div>
        </div>
    </div>
</body>
</html>
