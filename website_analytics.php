<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Analytics Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            margin-top: 30px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #0b5ed7;
        }
        .chart-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Data Analytics Dashboard</h1>

        <!-- Input Form -->
        <div class="card p-4 mb-4">
            <form method="post">
                <div class="row">
                    <div class="col-md-3">
                        <label for="rows" class="form-label">Number of Rows:</label>
                        <input type="number" id="rows" name="rows" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="cols" class="form-label">Number of Columns:</label>
                        <input type="number" id="cols" name="cols" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="min" class="form-label">Minimum Value:</label>
                        <input type="number" id="min" name="min" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="max" class="form-label">Maximum Value:</label>
                        <input type="number" id="max" name="max" class="form-control" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="form-label">Sort Rows:</label>
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
                <div class="d-grid mt-3">
                    <button type="submit" name="create" class="btn btn-custom">Generate Data</button>
                </div>
            </form>
        </div>

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
            echo "<div class='card p-4 mb-4'>";
            echo "<h2 class='mb-3'>Generated 2D Array:</h2>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered'>";
            foreach ($array as $row) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
            echo "</div>";

            // Prepare data for Chart.js
            $labels = range(1, $cols);
            $datasets = [];
            foreach ($array as $index => $row) {
                $datasets[] = [
                    'label' => "Row " . ($index + 1),
                    'data' => $row,
                    'borderColor' => sprintf('rgba(%d, %d, %d, 0.8)', rand(0, 255), rand(0, 255), rand(0, 255)),
                    'fill' => false,
                ];
            }
        }
        ?>

        <!-- Chart Section -->
        <?php if (isset($datasets)) : ?>
            <div class="chart-container">
                <h2 class="mb-3">Data Visualization</h2>
                <canvas id="dataChart"></canvas>
            </div>

            <script>
                // Chart.js Configuration
                const ctx = document.getElementById('dataChart').getContext('2d');
                const dataChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($labels); ?>,
                        datasets: <?php echo json_encode($datasets); ?>
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: '2D Array Data Visualization'
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Columns'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Values'
                                }
                            }
                        }
                    }
                });
            </script>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>