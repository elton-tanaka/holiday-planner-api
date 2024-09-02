<!DOCTYPE html>
<html>
<head>
    <title>PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        p {
            color: #555;
            line-height: 1.6;
        }
        .participants {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Date: {{ $date }}</p>
    <p>Description: {{ $description }}</p>
    <p>Location: {{ $location }}</p>
    @if ($participants)
        <p>Participants: </p>
        @foreach ($participants as $participant)
            <p class="participants">- {{ $participant }}</p>
        @endforeach
    @endif
</body>
</html>