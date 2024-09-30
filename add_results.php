<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/home.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="./css/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="./css/form.css">
    <title>Dashboard</title>
</head>
<body>
        
    <div class="title">
        <a href="dashboard.php"><img src="./images/photo1.jpeg" alt="" class="logo"></a>
        <span class="heading">Dashboard</span>
        <a href="logout.php" style="color: white"><span class="fa fa-sign-out fa-2x">Logout</span></a>
    </div>

    <div class="nav">
        <ul>
            <li class="dropdown" onclick="toggleDisplay('1')">
                <a href="" class="dropbtn">Subjects &nbsp
                    <span class="fa fa-angle-down"></span>
                </a>
                <div class="dropdown-content" id="1">
                    <a href="add_classes.php">Add Subject</a>
                    <a href="manage_classes.php">Manage Subjects</a>
                </div>
            </li>
            <li class="dropdown" onclick="toggleDisplay('2')">
                <a href="#" class="dropbtn">Students &nbsp
                    <span class="fa fa-angle-down"></span>
                </a>
                <div class="dropdown-content" id="2">
                    <a href="add_students.php">Add Students</a>
                    <a href="manage_students.php">Manage Students</a>
                </div>
            </li>
            <li class="dropdown" onclick="toggleDisplay('3')">
                <a href="#" class="dropbtn">Results &nbsp
                    <span class="fa fa-angle-down"></span>
                </a>
                <div class="dropdown-content" id="3">
                    <a href="add_results.php">Add Results</a>
                    <a href="manage_results.php">Manage Results</a>
                </div>
            </li>
        </ul>
    </div>

    <div class="main">
        <form action="" method="post">
            <fieldset>
            <legend>Enter Marks</legend>

                <?php
                    include("init.php");
                    include("session.php");

                    $select_class_query="SELECT `name` from `class`";
                    $class_result=mysqli_query($conn,$select_class_query);
                    //select class
                    echo '<select name="class_name">';
                    echo '<option selected disabled>Select Class</option>';
                    
                        while($row = mysqli_fetch_array($class_result)) {
                            $display=$row['name'];
                            echo '<option value="'.$display.'">'.$display.'</option>';
                        }
                    echo'</select>';                      
                ?>

                <input type="text" name="usn" placeholder="usn">
                <input type="text" name="cie1" id="" placeholder="cie1">
                <input type="text" name="cie2" id="" placeholder="cie2">
                <input type="text" name="cie3" id="" placeholder="cie3">
                <input type="text" name="aat" id="" placeholder="aat">
                <input type="text" name="assignment" id="" placeholder="assignment">
                <input type="submit" value="Submit">
            </fieldset>
        </form>
    </div>

</body>
</html>

<?php
    if(isset($_POST['usn'],$_POST['cie1'],$_POST['cie2'],$_POST['cie3'],$_POST['aat'],$_POST['assignment']))
    {
        $usn=$_POST['usn'];
        if(!isset($_POST['class_name']))
            $class_name=null;
        else
            $class_name=$_POST['class_name'];
        $cie1=(int)$_POST['cie1'];
        $cie2=(int)$_POST['cie2'];
        $cie3=(int)$_POST['cie3'];
        $aat=(int)$_POST['aat'];
        $assignment=(int)$_POST['assignment'];

        $marks=$cie1+$cie2+$cie3;
        $marks=$marks/5;
        $total=$marks+$aat+$assignment;

        // validation
        if (empty($class_name) or empty($usn) or $cie1>50 or  $cie2>50 or $cie3>50 or $aat>10 or $assignment>10 or $cie1<0 or  $cie2<0 or $cie3<0 or $aat<0 or $assignment<0 ) {
            if(empty($class_name))
                echo '<p class="error">Please select class</p>';
            if(empty($usn))
                echo '<p class="error">Please enter usn number</p>';
            if(preg_match("/[a-z]/i",$usn))
                echo '<p class="error">Please enter valid usn</p>';
            if(preg_match("/[a-z]/i",$marks))
                echo '<p class="error">Please enter valid marks</p>';
            if($cie1>50 or  $cie2>50 or $cie3>50 or $aat>10 or $assignment>10 or $cie1<0 or  $cie2<0 or $cie3<0 or $aat<0 or $assignment<0 )
                echo '<p class="error">Please enter valid marks</p>';
            exit();
        }

        $name=mysqli_query($conn,"SELECT `name` FROM `students` WHERE `usn`='$usn' and `class_name`='$class_name'");
        while($row = mysqli_fetch_array($name)) {
            $display=$row['name'];
            echo $display;
         }

        $sql="INSERT INTO `result` (`name`, `usn`, `class`, `cie1`, `cie2`, `cie3`, `aat`, `assignment`, `marks`, `total`) VALUES ('$display', '$usn', '$class_name', '$cie1', '$cie2', '$cie3', '$aat', '$assignment', '$marks', '$total')";
        $sql=mysqli_query($conn,$sql);

        if (!$sql) {
            echo '<script language="javascript">';
            echo 'alert("Invalid Details")';
            echo '</script>';
        }
        else{
            echo '<script language="javascript">';
            echo 'alert("Successful")';
            echo '</script>';
        }
    }
?>