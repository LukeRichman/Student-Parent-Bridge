<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/student.css">
    <title>Result</title>
</head>
<body>
    <?php
        include("init.php");

        if(!isset($_GET['class']))
            $class=null;
        else
            $class=$_GET['class'];
        $usn=$_GET['usn'];

        // validation
        if (empty($class) or empty($usn) or preg_match("/[0-9]1,[A-Z]2,[0-9]2,[A-Z]2,[0-9]3/",$usn)) {
            if(empty($class))
                echo '<p class="error">Please select your class</p>';
            if(empty($usn))
                echo '<p class="error">Please enter your USN</p>';
            if(preg_match("/[0-9]1,[A-Z]2,[0-9]2,[A-Z]2,[0-9]3/",$usn))
                echo '<p class="error">Please enter valid USN</p>';
            exit();
        }

        $name_sql=mysqli_query($conn,"SELECT `name` FROM `students` WHERE `usn`='$usn' and `class_name`='$class'");
        while($row = mysqli_fetch_assoc($name_sql))
        {
        $name = $row['name'];
        }

        $result_sql=mysqli_query($conn,"SELECT `cie1`, `cie2`, `cie3`, `aat`, `assignment`, `marks`, `total` FROM `result` WHERE `usn`='$usn' and `class`='$class'");
        while($row = mysqli_fetch_assoc($result_sql))
        {
            $cie1 = $row['cie1'];
            $cie2 = $row['cie2'];
            $cie3 = $row['cie3'];
            $aat = $row['aat'];
            $assignment = $row['assignment'];
            $mark = $row['marks'];
            $total = $row['total'];
        }
        if(mysqli_num_rows($result_sql)==0){
            echo "no result";
            exit();
        }
        //eligiblity
        $x=20;
        $y=45;
        $check1=$total>$x;
        $check2=$total>$y;
        if($check1==1)
        $see='Yes';
        else
        $see='No';
        if($check2==1)
        $makeup='Yes';
        else
        $makeup='No';
    ?>

    <div class="container">
        <div class="details">
            <span>Name:</span> <?php echo $name ?> <br>
            <span>Class:</span> <?php echo $class; ?> <br>
            <span>USN:</span> <?php echo $usn; ?> <br>
        </div>

        <div class="main">
            <div class="s1">
                <p>Subjects</p>
                <p>CIE 1</p>
                <p>CIE 2</p>
                <p>CIE 3</p>
                <p>AAT</p>
                <p>Assignment</p>
            </div>
            <div class="s2">
                <p>Marks</p>
                <?php echo '<p>'.$cie1.'</p>';?>
                <?php echo '<p>'.$cie2.'</p>';?>
                <?php echo '<p>'.$cie3.'</p>';?>
                <?php echo '<p>'.$aat.'</p>';?>
                <?php echo '<p>'.$assignment.'</p>';?>
            </div>
        </div>

        <div class="result">
            <?php echo '<p>Marks of 3 CIEs:&nbsp'.$mark.'</p>';?>
            <?php echo '<p>Total:&nbsp'.$total.'</p>';?>
            <?php echo '<p>SEE Eligibility:&nbsp'.$see.'</p>';?>
            <?php echo '<p>MakeUp Eligibility:&nbsp'.$makeup.'</p>';?>

        </div>

        <div class="button">
            <button onclick="window.print()">Print Result</button>
        </div>
    </div>
</body>
</html>