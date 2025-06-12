<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
            cursor: pointer;
        }
        th:hover {
            background-color: #e9ecef;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .search-box {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .error-message {
            color: #dc3545;
            text-align: center;
            margin: 20px 0;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        .success-status {
            color: #28a745;
            font-weight: bold;
        }
        .failed-status {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ url('/admin/dashboard') }}" class="back-button">Back to Dashboard</a>
        <h1>Login Logs</h1>

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        @if(!empty($logs))
            <input type="text" id="searchInput" class="search-box" placeholder="Search logs..." onkeyup="filterTable()">

            <table id="logsTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Username</th>
                        <th onclick="sortTable(1)">Email</th>
                        <th onclick="sortTable(2)">Role</th>
                        <th onclick="sortTable(3)">Login Time</th>
                        <th onclick="sortTable(4)">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $log['username'] ?? '-' }}</td>
                            <td>{{ $log['email'] ?? '-' }}</td>
                            <td>{{ $log['role'] ?? '-' }}</td>
                            <td>{{ $log['login_time'] ?? '-' }}</td>
                            <td>{{ $log['ip_address'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">No login logs available.</div>
        @endif
    </div>

    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('logsTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let match = false;
                
                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell) {
                        const text = cell.textContent || cell.innerText;
                        if (text.toLowerCase().indexOf(filter) > -1) {
                            match = true;
                            break;
                        }
                    }
                }
                
                rows[i].style.display = match ? '' : 'none';
            }
        }

        function sortTable(n) {
            const table = document.getElementById('logsTable');
            let rows, switching, i, x, y, shouldSwitch, dir = 'asc';
            let switchcount = 0;
            switching = true;

            while (switching) {
                switching = false;
                rows = table.rows;

                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName('td')[n];
                    y = rows[i + 1].getElementsByTagName('td')[n];

                    if (dir === 'asc') {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir === 'desc') {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }

                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount === 0 && dir === 'asc') {
                        dir = 'desc';
                        switching = true;
                    }
                }
            }

            // Update sort direction indicator
            const headers = table.getElementsByTagName('th');
            for (let i = 0; i < headers.length; i++) {
                headers[i].classList.remove('asc', 'desc');
            }
            headers[n].classList.add(dir);
        }
    </script>
</body>
</html> 