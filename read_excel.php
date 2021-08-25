<html>

<head>
<style type="text/css">
  td,th {
    border: 1px solid rgb(190, 190, 190);
    padding: 10px;
  }

  td {
    text-align: center;
  }

  tr:nth-child(even) {
    background-color: #eee;
  }

  table {
    border-collapse: collapse;
    border: 2px solid rgb(200, 200, 200);
    letter-spacing: 1px;
    font-family: sans-serif;
    font-size: .8rem;
  }
</style>
</head>

<body>

<?php

  include "simplexlsx/src/SimpleXLSX.php";
  echo '<h1>READ XLSX</h1><pre>';

  if ( $xlsx = SimpleXLSX::parse('UPLOADED/MARCH 22 2021.xlsx') ) {
    echo '<table><tbody>';
    $i = 0;

    foreach ($xlsx->rows(1) as $elt) {
      if ($i == 0) {
        echo "<tr><th>".$elt[0]."</th><th>".$elt[15]."</th><th>".$elt[17]."</th><th>".$elt[18]."</th><th>".$elt[23]."</th><th>".$elt[24]."</th></tr>";
      } else {
        echo "<tr><td>".$elt[0]."</td><td>".$elt[15]."</td><td>".$elt[17]."</td><td>".$elt[18]."</td><td>".$elt[23]."</td><td>".$elt[24]."</td></tr>";
      }
      $i++;
    }

    echo "</tbody></table>";

  } else {
    echo SimpleXLSX::parseError();
  }

?>

</body>
</html>	