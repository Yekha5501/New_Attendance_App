<!DOCTYPE html>
<html>
<head>
    <title>Student Attendance</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Student Attendance</h2>
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Surname</th>
                <th>Registration Number</th>
                @foreach($worshipSessions as $session)
                    <th>{{ $session->created_at->format('Y-m-d') }}</th>
                @endforeach
                <th>Average Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $student)
                <tr>
                    <td>{{ $student['first_name'] }}</td>
                    <td>{{ $student['surname'] }}</td>
                    <td>{{ $student['registration_number'] }}</td>
                    @foreach($student['attendance'] as $attendance)
                        <td>{{ $attendance }}</td>
                    @endforeach
                    <td>{{ $student['average_grade'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
