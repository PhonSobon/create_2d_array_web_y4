<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create 2D Array</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-custom {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #0b5ed7;
        }
        .table-custom {
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table-custom th, .table-custom td {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Create 2D Array</h1>
        <form method="post" class="bg-white p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="rows" class="form-label">Number of Rows:</label>
                <input type="number" id="rows" name="rows" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="cols" class="form-label">Number of Columns:</label>
                <input type="number" id="cols" name="cols" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="min" class="form-label">Minimum Value:</label>
                <input type="number" id="min" name="min" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="max" class="form-label">Maximum Value:</label>
                <input type="number" id="max" name="max" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Sort Rows:</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="asc" name="sort" value="asc" class="form-check-input" checked>
                        <label for="asc" class="form-check-label">Ascending</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="desc" name="sort" value="desc" class="form-check-input">
                        <label for="desc" class="form-check-label">Descending</label>
                    </div>
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" name="create" class="btn btn-custom">Create</button>
            </div>
        </form>

        <?php
        if (isset($_POST['create'])) {
            $rows = $_POST['rows'];
            $cols = $_POST['cols'];
            $min = $_POST['min'];
            $max = $_POST['max'];
            $sort = $_POST['sort'];

            // Function to generate a 2D array with random values
            function generate2DArray($rows, $cols, $min, $max) {
                $array = [];
                for ($i = 0; $i < $rows; $i++) {
                    for ($j = 0; $j < $cols; $j++) {
                        $array[$i][$j] = rand($min, $max);
                    }
                }
                return $array;
            }

            // Function to sort rows in a 2D array
            function sort2DArray(&$array, $sort) {
                foreach ($array as &$row) {
                    if ($sort == 'asc') {
                        sort($row);
                    } else {
                        rsort($row);
                    }
                }
            }

            // Generate the 2D array
            $array = generate2DArray($rows, $cols, $min, $max);

            // Sort the rows based on user selection
            sort2DArray($array, $sort);

            // Display the 2D array
            echo "<h2 class='mt-5 text-center'>Generated 2D Array:</h2>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-custom table-bordered'>";
            foreach ($array as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        }
        ?>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>