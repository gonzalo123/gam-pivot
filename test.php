<?php
//localhost:8082/tests/pivot/test.php
require('Pivot.php');

$recordset = array(
    array('host' => 1, 'country' => 'fr', 'year' => 2010, 'month' => 1, 'clicks' => 123, 'users' => 4),
    array('host' => 1, 'country' => 'fr', 'year' => 2010, 'month' => 2, 'clicks' => 134, 'users' => 5),
    array('host' => 1, 'country' => 'fr', 'year' => 2010, 'month' => 3, 'clicks' => 341, 'users' => 2),
    array('host' => 1, 'country' => 'es', 'year' => 2010, 'month' => 1, 'clicks' => 113, 'users' => 4),
    array('host' => 1, 'country' => 'es', 'year' => 2010, 'month' => 2, 'clicks' => 234, 'users' => 5),
    array('host' => 1, 'country' => 'es', 'year' => 2010, 'month' => 3, 'clicks' => 421, 'users' => 2),
    array('host' => 1, 'country' => 'es', 'year' => 2010, 'month' => 4, 'clicks' => 22,  'users' => 3),
    array('host' => 2, 'country' => 'es', 'year' => 2010, 'month' => 1, 'clicks' => 111, 'users' => 2),
    array('host' => 2, 'country' => 'es', 'year' => 2010, 'month' => 2, 'clicks' => 2,   'users' => 4),
    array('host' => 3, 'country' => 'es', 'year' => 2010, 'month' => 3, 'clicks' => 34,  'users' => 2),
    array('host' => 3, 'country' => 'es', 'year' => 2010, 'month' => 4, 'clicks' => 1,   'users' => 1),
);

$averageCbk = function($reg)
{
    return round($reg['clicks']/$reg['users'],2);
};

function simpleHtmlTable($data)
{
    // do you like spaghetti? 
    echo "<table border='1'>";
    echo "<thead>";
    foreach (array_keys($data[0]) as $item) {
        echo "<td><b>{$item}<b></td>";
    }
    echo "</thead>";
    foreach ($data as $row) {
        echo "<tr>";
        foreach ($row as $item) {
            echo "<td>{$item}</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

echo "<h2>original data</h2>";
simpleHtmlTable($recordset);

echo "<h2>pivot on 'host'</h2>";
$data = Pivot::factory($recordset)
    ->pivotOn(array('host'))
    ->addColumn(array('year', 'month'), array('users', 'clicks',))
    ->fetch();
simpleHtmlTable($data);

echo "<h2>pivot on 'host' with totals</h2>";
$data = Pivot::factory($recordset)
    ->pivotOn(array('host'))
    ->addColumn(array('year', 'month'), array('users', 'clicks',))
    ->fullTotal()
    ->lineTotal()
    ->fetch();
simpleHtmlTable($data);

echo "<h2>pivot on 'host' and 'country'</h2>";
$data = Pivot::factory($recordset)
    ->pivotOn(array('host', 'country'))
    ->addColumn(array('year', 'month'), array('users', 'clicks',))
    ->fullTotal()
    ->pivotTotal()
    ->lineTotal()
    ->fetch();
simpleHtmlTable($data);


echo "<h2>pivot on 'host' and 'country' with group count</h2>";
$data = Pivot::factory($recordset)
    ->pivotOn(array('host', 'country'))
    ->addColumn(array('year', 'month'), array('users', 'clicks', Pivot::count('count')))
    ->fullTotal()
    ->pivotTotal()
    ->lineTotal()
    ->fetch();
simpleHtmlTable($data);

echo "<h2>pivot on 'country' with group count</h2>";
$data = Pivot::factory($recordset)
    ->pivotOn(array('host'))
    ->addColumn(array('country'), array('year', Pivot::count('count')))
    ->lineTotal()
    ->fullTotal()
    ->fetch();
simpleHtmlTable($data);