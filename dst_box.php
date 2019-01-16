<?php 
include('db.php');
include('box.php');
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Network Project (CNT4713)</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row header" style="text-align:center;color:green">
                <h1 id="home"><a href="index.php" style="text-decoration:none;">Network Analysis</a></h1>
            </div>
            <?php
            $ip = $_GET['src'];
            $count = $_GET['count'];
        
echo '<h2> Source IP: '.$ip.'</h2><hr><h3>'.$count.' different Addresses Scanned</h3>';
            
             $output= '<br><div id=myTable class="table-responsive">
                        <table class="table table-striped">
                        <thead>
                        <th>Destination IPs</th>
                        <th>Total Ports Scaned</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Duration (in Second)</th>
                        </thead>';
foreach ($data as $i){
    if ($i['src']==$ip)
    {       
        $output .= '<tr>
            <td>'.$i['dst'].'</td>
            <td align="center">' . $i['total']. '</td>
            <td>' . date("Y-m-d H:i:s", substr($i['start'], 0, 10)). '</td>
           <td>' .date("Y-m-d H:i:s", substr($i['end'], 0, 10)). '</td>
           <td>' . $i['duration']. '</td>
            </tr>';
    }
    
} $output.= "</table></div>";
                        echo $output;
    
?>
            
            </div>
    </body>
    
</html>