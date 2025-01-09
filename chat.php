<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>One-to-One Chat</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Add CSS for chat interface */
    </style>
</head>
<body>
    <div id="chat-box">
        <!-- Messages will be displayed here -->
    </div>
    
    <form id="chat-form">
        <input type="text" id="message" placeholder="Type a message" />
        <button type="submit">Send</button>
    </form>

    <script>
        $(document).ready(function() {
            // Load previous messages
            function loadMessages() {
                $.get('load_messages.php', function(data) {
                    $('#chat-box').html(data);
                });
            }

            // Send message
            $('#chat-form').submit(function(e) {
                e.preventDefault();
                var message = $('#message').val();
                $.post('send_message.php', { message: message }, function() {
                    loadMessages(); // Reload messages after sending
                });
                $('#message').val(''); // Clear input
            });

            // Refresh chat every few seconds
            setInterval(loadMessages, 3000);
            loadMessages();
        });
    </script>
</body>
</html>
