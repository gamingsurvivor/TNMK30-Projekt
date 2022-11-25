<?php

 

    $connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");

 

    if ($conn->connect_error) {

        die("Connection failed: " . $conn->connect_error);

    }

 

    $SetID = $_POST['text'];

    $query = "SELECT * FROM sets WHERE SetID = '$SetID'";

    $result = mysqli_query($connection,  $query);

 

    if ($row   =  mysqli_fetch_array($result)){

        $setname = $row['Setname'];

 

        print("

        <h3> parts included in set $SetID ($setname):</h3>

        <table>

           <tr>

             <td>Image </td>

             <td> part name </td>

             <td> Color </td>

             <td> Quantity </td>

             <td> File name </td>

           </tr>

        </table>"

    );

}  

 

$query = "SELECT inventory.Quantity, inventory.SetID , inventory.ItemID, parts.Partname, images.ItemID, images.ItemtypeID,images.ColorID,

images.has_gif, images.has_jpg, images.has_largegif, images.has_largejpg, colors.Colorname FROM inventory, parts, colors, images WHERE

inventory.SetID =  '$SetID' AND parts.PartID = inventory.ItemID AND colors.ColorID = inventory.ColorID AND images.ItemID = inventory.ItemID

AND colors.ColorID = images.ColorID ORDER BY inventory.Quantity DESC";

 

$result = mysqli_query($connection, $query);

 

while   ($row =  mysqli_fetch_array($result)){

 

    $invpart = $row['Partname'];

    $invqual = $row['Quantity'];

    $colorsname = $row['Colorname'];

    $itemid = $row['ItemID'];

    $itemtype = $row['ItemtypeID'];

    $colorid = $row['ColorID'];

    $gif = $row['has_gif'];

    $jpg = $row['has_jpg'];

    $imagesrc = "";

    $file = "";

 

    if ($jpg){

        $imagesrc = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$itemtype/$colorid/$itemid.jpg";

        $file = "$itemtype/$colorid/$itemid.jpg";

 

    }

    else if ($gif){

        $imagesrc = "http://www.itn.liu.se/~stegu76/img.bricklink.com/$itemtype/$colorid/$itemid.gif";

        $file = "$itemtype/$colorid/$itemid.gif";

    }

 

    print (

     "<table >

         <tr>

            <td> <img src= $imagesrc> </td>

            <td> $invpart </td>

            <td> $colorsname </td>

            <td> $invqual </td>

            <td> $file </td>  

         </tr>

        <table>"

    ) ;

}

?>