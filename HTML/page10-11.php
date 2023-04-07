<?php session_start(); ?>
<!DOCTYPE html>
<meta charset="UTF-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../CSS/style.css">
<html>
  <title>Cinevault+</title>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="javascript:void(0)">
                <img src="../Assets/Icon.png" style="width: 60px;">
            </a>
            <span class="navbar-text" style="color: white;">Cinevault+</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="collapse navbar-collapse" id="mynavbar">

                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0)" onclick="location.href ='Page10-11.php';" style="color: orange;">หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" onclick="location.href ='Page18.php';">ลงรอบภาพยนตร์</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" onclick="location.href ='Page20.php';">ค้นหาข้อมูลผู้ใช้งาน</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="text" placeholder="Search">
                    <button class="btn btn-secondary" type="button">Search</button>
                </form>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="">
                    <img src="../Assets/userIcon.png" style="width: 30px;">
                </a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            </div>
        </div>
    </nav>
    <br><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<?php
include("db.php");

$today = date("Y-m-d");
$yesterday = date("Y-m-d", strtotime("-1 day"));

$sql_today = "SELECT Summary FROM sales WHERE Date = '$today'";
$sql_yesterday = "SELECT Summary FROM sales WHERE Date = '$yesterday'";
$sql_cancel = "SELECT Cancel_count FROM sales WHERE Date = '$today'";

$result_today = mysqli_query($con, $sql_today);
$result_yesterday = mysqli_query($con, $sql_yesterday);
$result_cancel = mysqli_query($con, $sql_cancel);

$row_today = mysqli_fetch_assoc($result_today);
$row_yesterday = mysqli_fetch_assoc($result_yesterday);
$row_cancel = mysqli_fetch_assoc($result_cancel);

$summary_today = $row_today['Summary'];
$summary_yesterday = $row_yesterday['Summary'];
$cancel_count = $row_cancel['Cancel_count'];

// This month's profit
$curr_month = date('Y-m');
$curr_month_profit_sql = "SELECT SUM(Profit) as curr_month_profit FROM sales WHERE DATE_FORMAT(date, '%Y-%m') = '$curr_month'";
$curr_month_profit_result = mysqli_query($con, $curr_month_profit_sql);
$curr_month_profit_row = mysqli_fetch_assoc($curr_month_profit_result);
$curr_month_profit = $curr_month_profit_row['curr_month_profit'];

// Last month's profit
$last_month = date('Y-m', strtotime('-1 month'));
$last_month_profit_sql = "SELECT SUM(Profit) as last_month_profit FROM sales WHERE DATE_FORMAT(date, '%Y-%m') = '$last_month'";
$last_month_profit_result = mysqli_query($con, $last_month_profit_sql);
$last_month_profit_row = mysqli_fetch_assoc($last_month_profit_result);
$last_month_profit = $last_month_profit_row['last_month_profit'];

// Calculate percentage change
if ($last_month_profit != 0) {
  $percentage_change = (($curr_month_profit - $last_month_profit) / $last_month_profit) * 100;
} else {
  $percentage_change = 100; // If last month's profit is 0, consider this month's profit to be 100% increase
}
?>
<div class="page10">
  <br>
  <div class="Box1">
    ยอดขายตั๋ววันนี้
    <p id="today-sales"><?php echo $summary_today; ?> ที่นั่ง</p>
  </div>
  <br>
  <div class="Box2">
    ยอดขายตั๋ว(เมื่อวาน)
    <p id="yesterday-sales"><?php echo $summary_yesterday; ?> ที่นั่ง</p>
  </div>
  <br>
  <div class="Box3">
    ยอดยกเลิกตั๋ว(วันนี้)
    <p id = "today-cancellation"><?php echo $cancel_count; ?> ที่นั่ง</p>
  </div>
  <br>
      
  <div class="Box4">
    กำไร(เดือนนี้)
    <p id="profit-month"><?php echo number_format($percentage_change, 2) . '%'; ?></p>
  </div>
  <br>

      <div class="Box4">
        ดูตารางทั้งหมด<br>
        <a href="page14.php">ยอดขาย</a><br>
        <a href="page15.php" class="movie-ticket">ตั๋วภาพยนตร์</a><br>
        <a href="page24.php" class = "Canceled-tickets">ตั๋วภาพยนตร์ที่ถูกยกเลิก</a><br>
      </div>
      <?php
        // Retrieve data for the first pie chart (today's best-selling movies)
        $query1 = "SELECT MovieName, SUM(Summary) as TotalSales FROM sales_movie WHERE Date = CURDATE() GROUP BY MovieName ORDER BY TotalSales DESC LIMIT 5";
        $result1 = mysqli_query($con, $query1);
        $data1 = array();
        $data1[] = array('MovieName', 'Sales');
        while ($row = mysqli_fetch_assoc($result1)) {
          $data1[] = array($row['MovieName'], (int) $row['TotalSales']);
        }

        // Retrieve all data for the best-selling movies of the week
        $query2 = "SELECT MovieName, Summary, Date FROM sales_movie WHERE WEEK(Date) = WEEK(CURRENT_DATE()) AND YEAR(Date) = YEAR(CURRENT_DATE())";
        $result2 = mysqli_query($con, $query2);

        // Group all entries with the same movie title together
        $grouped_data = array();
        while ($row = mysqli_fetch_assoc($result2)) {
          $movie_name = $row['MovieName'];
          $summary = (int)$row['Summary'];
          $date = $row['Date'];

          // Check if movie title already exists in grouped data
          $movie_exists = false;
          foreach ($grouped_data as &$group) {
            if ($group[0] === $movie_name) {
              $group[1] += $summary;
              $group[2][] = $date;
              $movie_exists = true;
              break;
            }
          }

          // Add new movie title to grouped data if it doesn't exist yet
          if (!$movie_exists) {
            $grouped_data[] = array($movie_name, $summary, array($date));
          }
        }

        // Sort grouped data by summary
        usort($grouped_data, function($a, $b) {
          return $b[1] - $a[1];
        });

        // Get the top 5 movies by summary
        $top_movies = array_slice($grouped_data, 0, 5);

        // Calculate the number of receipts for each movie
        $receipt_counts = array();
        foreach ($top_movies as $movie) {
          $movie_name = $movie[0];
          $dates = $movie[2];

          $receipt_count = 0;
          foreach ($dates as $date) {
            $query_receipt_count = "SELECT COUNT(*) AS count FROM sales_movie WHERE MovieName = '$movie_name' AND Date = '$date'";
            $result_receipt_count = mysqli_query($con, $query_receipt_count);
            $row = mysqli_fetch_assoc($result_receipt_count);
            $receipt_count += $row['count'];
          }

          $receipt_counts[] = $receipt_count;
        }

        // Format data into Google Charts format
        $data2 = array();
        $data2[] = ['Movie', 'Summary', 'Receipts'];
        foreach ($top_movies as $key => $movie) {
          $data2[] = array($movie[0], $movie[1], $receipt_counts[$key]);
        }

        // Retrieve data for the third pie chart (best-selling movie genres of the week)
        $query3 = "SELECT MovieType FROM sales_movie WHERE Date >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        $result3 = mysqli_query($con, $query3);
        if (!$result3) {
          die("Query failed: " . mysqli_error($con));
        }
        $movieTypes = array();
        while ($row = mysqli_fetch_assoc($result3)) {
          $types = explode(",", $row['MovieType']);
          foreach($types as $type) {
            $type = trim($type);
            if(!empty($type)) {
              if(isset($movieTypes[$type])) {
                $movieTypes[$type]++;
              } else {
                $movieTypes[$type] = 1;
              }
            }
          }
        }
        $data3 = array();
        $data3[] = array('MovieType', 'TotalSales');
        foreach ($movieTypes as $type => $count) {
          $data3[] = array($type, (int) $count);
        }


        // Retrieve data for the best-selling movies of the year
        $query4 = "SELECT MovieName, SUM(Summary) AS Summary FROM sales_movie WHERE YEAR(Date) = YEAR(NOW()) GROUP BY MovieName ORDER BY Summary DESC, MovieName LIMIT 5";
        $result4 = mysqli_query($con, $query4);

        // Group all entries with the same movie title together
        $grouped_data = array();
        while ($row = mysqli_fetch_assoc($result4)) {
          $movie_name = $row['MovieName'];
          $summary = (int)$row['Summary'];

        // Check if movie title already exists in grouped data
        $movie_exists = false;
        foreach ($grouped_data as &$group) {
        if ($group[0] === $movie_name) {
          $group[1] += $summary;
          $movie_exists = true;
          break;
        }
        }

        // Add new movie title to grouped data if it doesn't exist yet
          if (!$movie_exists) {
            $grouped_data[] = array($movie_name, $summary);
          }
        }

        // Sort grouped data by summary
        usort($grouped_data, function($a, $b) {
          return $b[1] - $a[1];
        });

        // Format grouped data into Google Charts format
        $data4 = array();
        $data4[] = ['Movie', 'Summary'];
        foreach ($grouped_data as $data) {
          $data4[] = $data;
        }
      ?>
        <div class= "Graph">
          <!-- Draw the pie chart using JavaScript -->
          <div class="topmovieday">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart1);
            function drawChart1() {
              var data = google.visualization.arrayToDataTable(<?php echo json_encode($data1); ?>);
              var options = {
                title: 'Today\'s Best-Selling Movies',
                width: 400,
                height: 300
              };
              var chart = new google.visualization.PieChart(document.getElementById('topmovieday_chart_div'));
              chart.draw(data, options);
            }
            </script>
            <table class="columns">
            <tr>
            <td><div id="topmovieday_chart_div"></div></td>
            </tr>
            </table>
          </div>

          <div class="topmovieweek">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart2);
            function drawChart2() {
              var data = google.visualization.arrayToDataTable(<?php echo json_encode($data2); ?>);
              var options = {
                title: 'Best-Selling Movies of the Week',
                width: 400,
                height: 300
              };
              var chart = new google.visualization.PieChart(document.getElementById('topmovieweek_chart_div'));
              chart.draw(data, options);
            }
            </script>
            <table class="columns">
            <tr>
            <td><div id="topmovieweek_chart_div"></div></td>
            </tr>
            </table>
          </div>

          <div class="typemovie">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart3);
            function drawChart3() {
              var data = google.visualization.arrayToDataTable(<?php echo json_encode($data3); ?>);
              var options = {
                title: 'Best-Selling Movie Genres of the Week',
                width: 400,
                height: 300
              };
              var chart = new google.visualization.PieChart(document.getElementById('topmoviegenre_chart_div'));
              chart.draw(data, options);
            }
            </script>
            <table class="columns">
            <tr>
            <td><div id="topmoviegenre_chart_div"></div></td>
            </tr>
            </table>
          </div>

          <div class="topmovieyear">
            <!-- Draw the pie chart using JavaScript -->
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart4);
            function drawChart4() {
              var data = google.visualization.arrayToDataTable(<?php echo json_encode($data4); ?>);
              var options = {
                title: 'Best-Selling Movies of the Year',
                width: 400,
                height: 300
              };
              var chart = new google.visualization.PieChart(document.getElementById('topmovieyear_chart_div'));
              chart.draw(data, options);
            }
            </script>
                  <table class="columns">
                  <tr>
                  <td><div id="topmovieyear_chart_div"></div></td>
                  </tr>
                  </table>
          </div>
  
          <div class="search1">
            <a href="page12.php"><img src="../Assets/search.png" alt="searchpng1" style="width: 40px; height: 40px;"></a>
          </div>
  
          <div class="search2">
            <a href="page13.php"><img src="../Assets/search.png" alt="searchpng1" style="width: 40px; height: 40px;"></a>
          </div>
        </div>
      <div class="page11">
        <br>
          <h1>กราฟวิเคราะห์ยอดขาย</h1>
          <?php

// Retrieve sales data from MySQL
$sql = "SELECT MovieName, Date, Summary FROM sales_movie";
$result = $con->query($sql);

// Prepare data for graph
$data = array();
while ($row = $result->fetch_assoc()) {
    $date = date("M j, Y", strtotime($row["Date"]));
    $data[$row["MovieName"]][$date] = $row["Summary"];
}

// Check which movies to show on graph
$selected_movie = isset($_GET['movie']) ? $_GET['movie'] : null;

// Update SQL query to retrieve data only for selected movie
if ($selected_movie) {
    $sql = "SELECT MovieName, Date, Summary FROM sales_movie WHERE MovieName = '$selected_movie'";
} else {
    $sql = "SELECT MovieName, Date, Summary FROM sales_movie";
}
$result = $con->query($sql);

// Update data array to include only selected movie
$data = array();
while ($row = $result->fetch_assoc()) {
    $date = date("M j, Y", strtotime($row["Date"]));
    if ($row["MovieName"] == $selected_movie || !$selected_movie) {
        $data[$row["MovieName"]][$date] = $row["Summary"];
    }
}

// Create graph using Google Charts API
?>
<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn({type: 'date', label: 'Date'});
            <?php foreach ($data as $movie => $summaryData) { ?>
                data.addColumn('number', '<?php echo $movie; ?>');
            <?php } ?>
            data.addRows([
                <?php
                $dates = array_keys(reset($data));
                foreach ($dates as $date) {
                    echo "[new Date('" . $date . "'), ";
                    foreach ($data as $movie => $summaryData) {
                        echo isset($summaryData[$date]) ? $summaryData[$date] : "null";
                        echo ", ";
                    }
                    echo "],";
                }
                ?>
            ]);

            var options = {
                title: 'Movie Sales Summary',
                curveType: 'function',
                legend: { position: 'bottom' },
                hAxis: {
                    format: 'MMM d, yyyy'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <form method="get">
        <select name="movie" onchange="this.form.submit()">
            <option value="">Select a movie</option>
            <?php foreach ($data as $movie => $summaryData) { ?>
                <option value="<?php echo $movie; ?>" <?php if ($selected_movie == $movie) echo 'selected'; ?>><?php echo $movie; ?></option>
            <?php } ?>
        </select>
    </form>
    <div id="chart_div" style="width: 100%; height: 750px;"></div>
    <div class="page16">
        <br>
        <h1 >วิเคราะห์ยอดโดยรวม</h1>
        <div class="secBot">
            <div class="secC">
                <div class="Cleft">
                  <?php
                  include("db.php");
                  $sql = "SELECT Date, SUM(Summary) AS Summary FROM sales_movie WHERE Date >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY Date";
                  $result = $con->query($sql);
                  // Display the summary information
                  if ($result->num_rows > 0) {
                    echo "<br>ยอดขายตั๋วย้อนหลัง 7 วัน<br><br>";
                    while ($row = $result->fetch_assoc()) {
                    echo "วันที่ " . date("d/m/Y", strtotime($row["Date"])) . " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; " . $row["Summary"] . " ที่นั่ง<br>";
                    }
                  } else {
                  echo "No sales data available.";
                  }
                  ?>
                </div>
                <div class="Cmid">
                  <?php
                  include("db.php");
                  $sql = "SELECT Date, COUNT(Receipt_number) AS NumCancellations FROM cancel_ticket WHERE Date >= DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY Date";
                  $result = $con->query($sql);
                  // Display the cancellation information
                  if ($result->num_rows > 0) {
                    echo "<br>ยกเลิกตั๋วย้อนหลัง 7 วัน<br><br>";
                    while ($row = $result->fetch_assoc()) {
                    echo "วันที่ " . date("d/m/Y", strtotime($row["Date"])) . " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; " . $row["NumCancellations"] . " ใบเสร็จ<br>";}
                    } else {
                    echo "No cancellation data available.";
                  }
                  ?>
                </div>
                <div class="Cright">
    <?php
    include("db.php");
    $sql = "SELECT Date, SUM(Summary) AS Summary FROM sales_movie WHERE Date >= DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY Date";
    $result = $con->query($sql);

    // Display the summary information
    if ($result->num_rows > 0) {
        echo "<br>ยอดขายตั๋วย้อนหลัง 30 วัน<br><br>";
        while ($row = $result->fetch_assoc()) {
            echo "วันที่ " . date("d/m/Y", strtotime($row["Date"])) . " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; " . $row["Summary"] . " ที่นั่ง<br>";
        }
    } else {
        echo "No sales data available.";
    }

    ?>
</div>

            </div>
        </div><br>
        <div class="box">
            <div class="a">
    <?php
    include("db.php");
    $sql = "SELECT YEAR(Date) AS Year, MONTH(Date) AS Month, SUM(Summary) AS Summary FROM sales_movie WHERE Date >= DATE_SUB(NOW(), INTERVAL 12 MONTH) GROUP BY YEAR(Date), MONTH(Date)";
    $result = $con->query($sql);

    // Display the summary information
    if ($result->num_rows > 0) {
        echo "<br>ยอดขายตั๋วย้อนหลัง 12 เดือน<br><br>";
        while ($row = $result->fetch_assoc()) {
            echo "เดือน " . date("F Y", mktime(0, 0, 0, $row["Month"], 1, $row["Year"])) . " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; " . $row["Summary"] . " ที่นั่ง<br>";
        }
    } else {
        echo "No sales data available.";
    }

    ?>
            </div>&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="b">
               <div class="b01">
                  <div class="c"><br>
    <?php
    include("db.php");
    $sql = "SELECT SUM(Profit) AS TotalProfit FROM sales_movie WHERE YEAR(Date) = YEAR(NOW())";
    $result = $con->query($sql);
    echo "รายได้ปีนี้<br><br>";
    // Display the profit information
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalProfit = $row["TotalProfit"];
        echo "<center><h3><font color='green'>" . number_format($totalProfit) . " ฿</font></h3></center><br>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    } else {
        echo "No profit data available.";
    }

    ?>
</div>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <div class="d"><br>
    <?php
    include("db.php");
    $currentYear = date('Y');
    $previousYear = $currentYear - 1;
    $sql = "SELECT SUM(Profit) AS CurrentYearProfit FROM sales_movie WHERE YEAR(Date) = $currentYear";
    $result = $con->query($sql);

    // Calculate the percentage increase/decrease
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentYearProfit = $row["CurrentYearProfit"];

        // Retrieve the profit for the previous year
        $sql = "SELECT SUM(Profit) AS PreviousYearProfit FROM sales_movie WHERE YEAR(Date) = $previousYear";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $previousYearProfit = $row["PreviousYearProfit"];

            // Calculate the percentage increase/decrease between the two years
            $percentIncrease = ($currentYearProfit - $previousYearProfit) / $previousYearProfit * 100;
            $percentIncrease = number_format($percentIncrease, 2);
            $percentSign = ($percentIncrease > 0) ? "+" : "";
            echo "กำไร(ปีนี้)<br><br>";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $percentSign . $percentIncrease . "% จากปีที่แล้ว";
        } else {
            echo "No profit data available for the previous year.";
        }
    } else {
        echo "No profit data available for the current year.";
    }
    ?>
</div>

               </div><br>
               <div class="b02"><br>
    <center><h4>รายได้ย้อนหลัง 5 ปี</h4><br>
    <?php
    include("db.php");
    $currentYear = date('Y');
    for ($i = 0; $i < 5; $i++) {
        $year = $currentYear - $i;
        $sql = "SELECT SUM(Profit) AS YearProfit FROM sales_movie WHERE YEAR(Date) = $year";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $yearProfit = number_format($row["YearProfit"]);
            echo "<p>ปีที่ " . $year . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $yearProfit . " บาท</p>";
        } else {
            echo "<p>ปีที่ " . $year . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ไม่มีข้อมูล</p>";
        }
    }
    ?>
    </center>
</div>

            </div>
</body>
</html>
