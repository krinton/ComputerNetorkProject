
<?php 
include('db.php');
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
            <!-- Form to validate the queries-->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
                <input type="radio" id="vscan" name="scan" value="hscan"> Horizontal Scan
                <input type="radio" name="scan" value="vscan"> Vertical Scan
                <input type="radio" id="hscan" name="scan" value="bscan" > Strobe<br>
                <input type="submit" name="Submit" value="Submit">
            </form>  
            <?php
            if (isset($_POST['Submit'])){
                //If any of the radiobutton is selected or not
                if(isset($_POST['scan']))
                {
                    //For the Horizontal Scan
                    if($_POST['scan'] == "hscan"){
                        //query for horizontal scan
                        echo "Horizontal Scan Results.";
                    $query = "select src, count(*) as num, min(time) as start, max(time) as end, 
                    max(time) - min(time) as duration, 
                    count(*)/(max(time) - min(time)) as rate from $table 
                    group by src having count(*) > 15 order by rate desc";
                        
                    $result = mysqli_query($db, $query);
                    if (mysqli_num_rows($result) > 0){
                        
                        $output= '<br><div id=myTable class="table-responsive">
                        <table class="table table-striped">
                        <tr>
                        <th>Source IP</th>
                        <th>Total Packets</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Duration (in Second)</th>
                        <th>Rate (Ports/sec)</th>
                        
                        </tr>';
                        while($row = mysqli_fetch_array($result)){
                            if ($row["rate"]>9){
                                
                            
                            $output.= 
                                '<tr>
                                <td>' . $row["src"] . '</td>
                                <td>' . $row["num"] . '</td>
                                <td>' . date("Y-m-d H:i:s", substr($row["start"], 0, 10)) . '</td>
                                <td>' . date("Y-m-d H:i:s", substr($row["end"], 0, 10)) . '</td>
                                <td>' . $row["duration"] . '</td>
                                <td>' . $row["rate"] . '</td>
                                </tr>';
                        }}
                        $output.= "</table></div>";
                        echo $output;
                        
                    }
                    }
                    
                    //Veritical Scan
                    elseif (($_POST['scan'] == "vscan")){
                        echo "Vertical Scan Results.";
                   
                        $output= '<br><div id=myTable class="table-responsive">
                        <table class="table table-striped">
                        <tr>
                        <th>Source IP</th>
                        <th>Destination IP</th>
                        <th>Total Ports Scanned</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Duration (in Second)</th>
                        <th>Rate (Packets/sec)</th>    
                        </tr>';
                        
                        include('box.php');
                        $tmp = '';
                        $count = 0;
                        foreach ($data as $k){
                            $src = $k['src'];
                            //$dst = $k['dst'];
                            foreach ($data as $x)
                            {
                             
                            if($src != $tmp){
                                $count++;
                                 
                                if($count < 3 && $k['rate']>0.5){
                                    //echo $count;
                                     $output.= 
                                '<tr>
                                <td>' . $k['src'] . '</td>
                                <td>' . $k["dst"] . '</td>
                                <td>' . $k['total']. '</td>
                                <td>' . date("Y-m-d H:i:s", substr($k['start'], 0, 10)). '</td>
                                <td>' . date("Y-m-d H:i:s", substr($k['end'], 0, 10)). '</td>
                                <td>' . $k["duration"] . '</td>
                                <td>' . $k["rate"] . '</td>
                                </tr>';
                                  $tmp = $src;  
                                    
                                }}   
                            }$count = 1;}
                        $output.= "</table></div>";
                        echo $output;
                    }
                    
                    //Strobe Scan
                    elseif (($_POST['scan'] == "bscan")){
                        include('box.php');
                        $tmp = '';
                        foreach ($data as $i){
                            $src = $i['src'];
                            $dst = $i['dst'];
                            if($src != $tmp){
                                $count = 1;
                                //$temp = '';
                                foreach ($data as $j)
                                {
                                    if($src == $j["src"]){
                                        
                                        if($dst != $j['dst']){
                                            $count++;
                                        }
                                    }       
                                }
                                if($count>2){
                               echo '<div class="col-md-2">    <div class="thumbnail">
                                <a href="dst_box.php?src='.$i['src'].'&count='.$count.'" style="text-decoration:none;" >'.$i['src'].'</a>
                                </div></div>';
                                $tmp = $i['src'];}
                            }
                        }
                    }
                    }
                    else
                        echo "Data Not Found";
                }
               ?>  
        </div>
    </body>
    
</html>