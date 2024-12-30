<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .header {
            position: relative;
            background-color: #000000;
            color: #ffffff;
            height: 103px;
        }
        .header .left {
            float: left;
            font-size: 20px;
            vertical-align: middle;
            font-weight: bold;
            padding: 40px 15px;
        }
        .header .right {
            position: absolute;
            top: 3px;
            right: -1px;
            width: 375px;
            height: 100px;
            background-color: white;
            color: #000000;
            border-top-left-radius: 150px;
            padding: 0px;
        }
        .header .right h2 {
            font-weight: bold;
            font-size: 18px;
            margin: 0px;
            position: relative;
            top: -50px;
            padding-left: 80px;
        }
        .content {
            margin-top: 20px;
        }
        .box p strong {
            display: inline-block;
            margin-bottom: 2px;
        }
        .box p {
            margin: 0px;
        }
        .box {
            border: 1px solid #000000;
            padding: 15px;
            border-radius: 18px;
            margin-bottom: 10px;
            min-height: 100px;
        }
        .flex-container .flex-item:first-child .box {
            margin-right: 10px;
        }
        .flex-container .flex-item:last-child .box {
            margin-left: 10px;
        }
        .flex-container {
            width: 100%;
            display: table;
            margin-bottom: 20px;
        }
        .flex-item {
            display: table-cell;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid black;
            padding: 8px 12px;
            text-align: left;
        }
        .table th {
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="left">Celergen International Limited</div>
        <div class="right"><h2>Delivery Order</h2></div>
    </div>
    <div class="content">
        <div class="flex-container">
            <div class="flex-item">
                <div class="box">
                    <p><strong>Luxroutage S.A</strong></p>
                    <p>11, rue Paul Rischard</p>
                    <p>Luxembourg</p>
                </div>
            </div>
            <div class="flex-item">
                <div class="box">
                    <p><strong>Ship To:</strong></p>
                    <p>Carlota</p>
                    <p>Av. Diagonal 490, 1º 1ª</p>
                    <p>Barcelona - 08006</p>
                    <p>Spain</p>
                    <p>Phone: +34932530282</p>
                </div>
            </div>
        </div>
        <div>
            <span style="display:inline-block;width: 50%;"><strong>ID:</strong> 25756</span>
            <span><strong>DATE:</strong> 12-12-2024</span>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Item No.</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Commercial</th>
                    <th>Sample</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Celergen</td>
                    <td>30</td>
                    <td>30</td>
                    <td>0</td>
                </tr>
            </tbody>
        </table>
        <div class="footer">
            <strong>Remarks:</strong>
            <p></p>
        </div>
    </div>
</body>
</html>