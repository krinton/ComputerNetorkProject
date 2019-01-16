
<?php  
//Box Scan Query
$b_query = "select src, dst, count(DISTINCT port) as total, min(time) as start, max(time) as end, (max(time)-min(time)) as duration, count(DISTINCT port)/(max(time)-min(time)) as rate from $table group by src, dst having count(distinct port) > 1 order by count(distinct port) desc";

$b_result = mysqli_query($db, $b_query);
$b_data=array();

if (mysqli_num_rows($b_result) > 0){
    while ($row = mysqli_fetch_assoc($b_result))
    {
        //Storing all the data from database to an array
        $data[] = $row;   
    }
}
    // code the print the values in array
   //  print_r($data);                
?>