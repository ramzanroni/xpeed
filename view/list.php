<?php 
 $currentDate=date('d/m/Y');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="~/../libs/fontawesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="~/../libs/bootstrap.css">
    <script src="~/../libs/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="~/../libs/bootstrap.js"></script>
    <style type="text/css">
        .wrapper {
            width: 650px;
            margin: 0 auto;
        }

        .page-header h2 {
            margin-top: 0;
        }

        table tr td:last-child a {
            margin-right: 15px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <a href="index.php" class="btn btn-success pull-left">Home</a>
                    <h2 class="pull-left">Xpeed Details</h2>
                    <a href="view/insert.php" class="btn btn-success pull-right">Add New Xpeed</a>
                </div>
                <div class="page-header clearfix">
                   <div class="form-group col-md-2">
                        <label for="">ID</label>
                        <input type="text" id="id" value="" class="form-control">
                   </div>
                   <div class="form-group col-md-2">
                        <label for="">Start Date</label>
                        <input type="date" id="startDate" value="<?php echo $currentDate ?>" class="form-control date">
                   </div>
                   <div class="form-group col-md-2">
                        <label for="">End Date</label>
                        <input type="date" id="endDate" value="<?php echo $currentDate ?>" class="form-control">
                   </div>
                   <div class="form-group col-md-2">
                        <input type="button" class="btn btn-success mt-5" value="Search" onclick="searchDate()" style="margin-top: 24px;">
                   </div>
                </div>
                <div id="">
                    <?php
                    if ($result->num_rows > 0) {
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Amount</th>";
                        echo "<th>Buyer</th>";
                        echo "<th>Receipt Id</th>";
                        echo "<th>Items</th>";
                        echo "<th>Buyer Email</th>";
                        echo "<th>Buyer IP</th>";
                        echo "<th>Note</th>";
                        echo "<th>City</th>";
                        echo "<th>Phone</th>";
                        echo "<th>Create At</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody id='record'>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['amount'] . "</td>";
                            echo "<td>" . $row['buyer'] . "</td>";
                            echo "<td>" . $row['receipt_id'] . "</td>";
                            echo "<td>" . $row['items'] . "</td>";
                            echo "<td>" . $row['buyer_email'] . "</td>";
                            echo "<td>" . $row['buyer_ip'] . "</td>";
                            echo "<td>" . $row['note'] . "</td>";
                            echo "<td>" . $row['city'] . "</td>";
                            echo "<td>" . $row['phone'] . "</td>";
                            echo "<td>" . $row['entry_at'] . "</td>";

                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo "<p class='lead'><em>No records were found.</em></p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function searchDate(){
        let startDate=$("#startDate").val();
        let endDate=$("#endDate").val();
        let id=$("#id").val();
        let check='datewise';
        $.ajax({
                url: "/xpeedstudio/",
                type: "POST",

                data: {
                    check: check,
                    startDate:startDate,
                    endDate:endDate,
                    id:id
                },
                success: function(response) {
                    console.log(response);
                       $("#record").html(response);
                },
            });
    }
</script>

</html>