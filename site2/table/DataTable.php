<?php include 'common.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL ?>/DataTable.css">
    <title>Document</title>
</head>

<body>
    <div class="table-title">
        <h3>Data Table</h3>
    </div>
    <table class="table-fill">
        <thead>
            <tr>
                <th class="text-left">Month</th>
                <th class="text-left">Sales</th>
            </tr>
        </thead>
        <tbody class="table-hover">
            <tr>
                <td class="text-left">January</td>
                <td class="text-left">$ 50,000.00</td>
            </tr>
            <tr>
                <td class="text-left">February</td>
                <td class="text-left">$ 10,000.00</td>
            </tr>
            <tr>
                <td class="text-left">March</td>
                <td class="text-left">$ 85,000.00</td>
            </tr>
            <tr>
                <td class="text-left">April</td>
                <td class="text-left">$ 56,000.00</td>
            </tr>
            <tr>
                <td class="text-left">May</td>
                <td class="text-left">$ 98,000.00</td>
            </tr>
        </tbody>
    </table>
</body>

</html>