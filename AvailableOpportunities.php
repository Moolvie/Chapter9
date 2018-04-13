<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--
      PHP Programming With MySQL Second Edition
      

      Author: Doug Enos	
      Date:   Apr 11, 2018

      Filename: AvailableOpportunities.php
   -->
<title>Available Opportunities</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8849-1" />
</head>
<body>
<!-- 2. -->
<h1>College Internship</h1>
<h2>Available Opportunities</h2>
<?php
// 3.
if (isset($_REQUEST['internID']))
    $InternID = $_REQUEST['internID'];
else
    $InternID = −1;
// 4.
$errors = 0;
$DBConnect = @mysqli_connect("localhost", "root", "crumplebatverifytree");
if ($DBConnect === FALSE) {
    echo "<p>Unable to connect to the database server. " .
        "Error code " . mysqli_errno() . ": " .
        mysqli_error() . "</p>\n";
    ++$errors;
}
else {
    $DBName = "internships";
    $result = @mysqli_select_db($DBConnect, $DBName);
    if ($result === FALSE) {
        echo "<p>Unable to select the database. " .
        "Error code " . mysqli_errno($DBConnect) . ": " .
        mysqli_error($DBConnect) . "</p>\n";
    ++$errors;
    }
}
// 5.
$TableName = "interns";
if ($errors == 0) {
    $SQLstring = "SELECT * FROM $TableName WHERE " .
        " internID='$InternID'";
    $QueryResult = @mysqli_query($DBConnect, $SQLstring);
    if ($QueryResult === FALSE) {
        echo "<p>Unable to execute the query. " .
            "Error code " . mysqli_errno($DBConnect) . ": " .
            mysqli_error($DBConnect) . "</p>\n";
        ++$errors;
    }
    else {
        if (mysqli_num_rows($QueryResult) == 0) {
            echo "<p>Invalid Intern ID!</p>";
            ++$errors;
        }
    }
}
// 6.
if ($errors == 0) {
    $Row = mysqli_fetch_assoc($QueryResult);
    $InternName = $Row['first'] . " " . $Row['last'];
} else
    $InternName = "";
// 7.
$TableName = "assigned_opportunities";
$ApprovedOpportunities = 0;
$SQLstring = "SELECT COUNT(opportunityID) FROM
$TableName " .
    " WHERE internID='$InternID' " .
    " AND date_approved IS NOT NULL";
$QueryResult = @mysqli_query($DBConnect, $SQLstring);
if (mysqli_num_rows($QueryResult) > 0) {
    $Row = mysqli_fetch_row($QueryResult);
    $ApprovedOpportunities = $Row[0];
    mysqli_free_result($QueryResult);
}
// 8.
$SelectedOpportunities = array();
$SQLstring = "SELECT opportunityID FROM $TableName " .
    " WHERE internID='$InternID'";
$QueryResult = @mysqli_query($DBConnect, $SQLstring);
if (mysqli_num_rows($QueryResult) > 0) {
    while (($Row = mysqli_fetch_row($QueryResult)) !== FALSE)
        $SelectedOpportunities[] = $Row[0];
    mysqli_free_result($QueryResult);
}
// 9.
$AssignedOpportunities = array();
$SQLstring = "SELECT opportunityID FROM $TableName " .
        " WHERE date_approved IS NOT NULL";
$QueryResult = @mysqli_query($DBConnect, $SQLstring);
if (mysqli_num_rows($QueryResult) > 0) {
    while (($Row = mysqli_fetch_row($QueryResult)) !== FALSE)
        $AssignedOpportunities[] = $Row[0];
    mysqli_free_result($QueryResult);
}
// 10.
$TableName = "opportunities";
$Opportunities = array();
$SQLstring = "SELECT opportunityID, company, city, " .
    " start_date, end_date, position,
    description " .
    " FROM $TableName";
$QueryResult = @mysqli_query($DBConnect, $SQLstring);
if (mysqli_num_rows($QueryResult) > 0) {
    while ($Row = mysqli_fetch_assoc($QueryResult)){ 
        $Opportunities[] = $Row;
    }
        mysqli_free_result($QueryResult);
}
mysqli_close($DBConnect);
// 11.
echo "<table border='1' width='100%'>\n";
echo "<tr>\n";
echo " <th style='background-color:cyan'>Company</
th>\n";
echo " <th style='background-color:cyan'>City</th>\n";
echo " <th style='background-color:cyan'>Start
Date</th>\n";
echo " <th style='background-color:cyan'>End
Date</th>\n";
echo " <th style='background-color:cyan'>Position</
th>\n";
echo " <th style='background-color:cyan'>Description</
th>\n";
echo " <th style='background-color:cyan'>Status</
th>\n";
echo "</tr>\n";
foreach ($Opportunities as $Opportunity) {
    if (!in_array($Opportunity['opportunityID'],
            $AssignedOpportunities)) {
        echo "<tr>\n";
        echo " <td>" .
            htmlentities($Opportunity['company']) .
            "</td>\n";
        echo " <td>" .
            htmlentities($Opportunity['city']) .
            "</td>\n";
        echo " <td>" .
            htmlentities($Opportunity
            ['start_date']) .
            "</td>\n";
        echo " <td>" .
            htmlentities($Opportunity['end_date']) .
            "</td>\n";
        echo " <td>" .
            htmlentities($Opportunity['position']) .
            "</td>\n";
        echo " <td>" .
            htmlentities($Opportunity
            ['description']) .
            "</td>\n";
        echo " <td>";
        if (in_array($Opportunity['opportunityID'],
            $SelectedOpportunities))
            echo "Selected";
        else {
            if ($ApprovedOpportunities>0)
                echo "Open";
            else
                echo "<a href=
                'RequestOpportunity.php?" .
                    "internID=$InternID&" .
                    "opportunityID=" .
                    $Opportunity['opportunityID'] .
                    "'>Available</a>";
        }
        echo "</td>\n";
        echo "</tr>\n";
    }
}
echo "</table>\n";
echo "<p><a href='InternLogin.php'>Log Out</a></
p>\n";
?>
</body>
</html>
