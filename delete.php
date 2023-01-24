<?php 
include('config/db.php');
function AddPlayTime($times) {
    $minutes = 0; //declare minutes either it gives Notice: Undefined variable
    // loop throught all the times
    foreach ($times as $time) {
        list($hour, $minute) = explode(':', $time);
        $minutes += $hour * 60;
        $minutes += $minute;
    }

    $hours = floor($minutes / 60);
    $minutes -= $hours * 60;

    // returns the time already formatted
    return sprintf('%02d:%02d', $hours, $minutes);
}
if($_GET){
// sql to delete a record
    if($_GET['type'] == 'c'){

        $sql = "DELETE FROM calls WHERE id=".$_GET['id'];
        if (mysqli_query($con, $sql)) {
            $calls_sql = "SELECT * FROM calls";
            if ($result = mysqli_query($con, $calls_sql)) {
                $unique_id_counter = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $update_sql = "UPDATE `calls` SET `unique_id`=".$unique_id_counter." WHERE `id` = ".$row['id'];
                    mysqli_query($con, $update_sql);
                    $unique_id_counter++;
                }
                $callDetSql = "DELETE FROM call_details WHERE call_id=".$_GET['id'];
                mysqli_query($con, $callDetSql);
                
                header("Location: index.php?success=1");
                die();
            }
        } else {
            header("Location: index.php?error=1");
            die();
        }

    }   
    if($_GET['type'] == 'cl'){

        $sql = "DELETE FROM call_details WHERE id=".$_GET['id'];
        if (mysqli_query($con, $sql)) {

            $sql = "SELECT * FROM call_details WHERE call_id = ".$_GET['call_id'];
            $times = array();
            $result = mysqli_query($con, $sql);
            while ($roww = mysqli_fetch_assoc($result)) {
                $time_in_24_hour_format  = date("H:i", strtotime($roww['hours'].":".$roww['minutes']." ".$roww['meridian']));
                array_push($times,$time_in_24_hour_format);
            }
            $total_time =  AddPlayTime($times);

            $update_sql = "UPDATE `calls` SET `total_time`='".$total_time."' WHERE `id` = ".$_GET['call_id'];
            mysqli_query($con, $update_sql);


            header("Location: call_details.php?call_id=".$_GET['call_id']);
            die();
        }

    }



}
?>