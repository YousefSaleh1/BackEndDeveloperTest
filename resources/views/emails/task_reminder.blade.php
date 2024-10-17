<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #2c3e50;
            font-size: 24px;
            margin: 0;
        }
        .content {
            margin-top: 20px;
            font-size: 16px;
            line-height: 1.5;
        }
        .task-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #3498db;
            margin-top: 20px;
        }
        .task-info h2 {
            color: #2980b9;
            font-size: 20px;
            margin: 0 0 10px 0;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
        .due-date {
            font-weight: bold;
            color: #e74c3c;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Task Reminder</h1>
        </div>
        <div class="content">
            <p>Hello {{ $task->user->name }},</p>
            <p>This is a reminder that your task <strong>"{{ $task->title }}"</strong> is due in one hour.</p>

            <div class="task-info">
                <h2>Task Details</h2>
                <p><strong>Title:</strong> {{ $task->title }}</p>
                <p><strong>Description:</strong> {{ $task->description }}</p>
                <p><strong>Due Date:</strong> <span class="due-date">{{ $task->due_date->format('F j, Y, g:i a') }}</span></p>
            </div>

            <p>Please make sure to complete the task on time.</p>

        </div>
        <div class="footer">
            <p>Thank you for staying organized with our task management system.</p>
        </div>
    </div>
</body>
</html>
