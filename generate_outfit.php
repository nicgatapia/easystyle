<!--For the sake of functionality, randomly generates an outfit with no regard to whether the items are
sensible in an outfit together.-->
<?php
session_start(); // Start the session

require_once 'db_connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// These function definitions aren't as small as they could be. This method is being used because the previous query
// would randomly return NULL values for the primary key on non-empty tables.
function generateTop($conn) {
    // Get the count of rows in the 'TOP' table
    $iidSql = "SELECT IID FROM TOP ORDER BY RAND() LIMIT 1";
    $iidResult = mysqli_query($conn, $iidSql);
    $iidRow = mysqli_fetch_assoc($iidResult);
    $iid = $iidRow['IID'];

    // Select the corresponding row from the 'view_wardrobe_table' view
    $topSql = "SELECT IID, COLOR, ATTIRE, TYPE FROM view_wardrobe_table WHERE IID = " . $iid;
    $topResult = mysqli_query($conn, $topSql);
    return mysqli_fetch_assoc($topResult);
}

function generateBottom($conn) {
    // Get the count of rows in the 'BOTTOM' table
    $iidSql = "SELECT IID FROM BOTTOM ORDER BY RAND() LIMIT 1";
    $iidResult = mysqli_query($conn, $iidSql);
    $iidRow = mysqli_fetch_assoc($iidResult);
    $iid = $iidRow['IID'];

    $bottomSql = "SELECT IID, COLOR, ATTIRE, TYPE FROM view_wardrobe_table WHERE IID = " . $iid;
    $bottomResult = mysqli_query($conn, $bottomSql);
    return mysqli_fetch_assoc($bottomResult);
}

function generateShoes($conn) {
    // Get the count of rows in the 'TOP' table
    $iidSql = "SELECT IID FROM SHOES ORDER BY RAND() LIMIT 1";
    $iidResult = mysqli_query($conn, $iidSql);
    $iidRow = mysqli_fetch_assoc($iidResult);
    $iid = $iidRow['IID'];

    $shoesSql = "SELECT IID, COLOR, ATTIRE, TYPE, BRAND FROM view_wardrobe_table WHERE IID = " . $iid;
    $shoesResult = mysqli_query($conn, $shoesSql);
    return mysqli_fetch_assoc($shoesResult);
}

function generateAccessory($conn) {
    // Get the count of rows in the 'TOP' table
    $iidSql = "SELECT IID FROM ACCESSORY ORDER BY RAND() LIMIT 1";
    $iidResult = mysqli_query($conn, $iidSql);
    $iidRow = mysqli_fetch_assoc($iidResult);
    $iid = $iidRow['IID'];

    $accessorySql = "SELECT IID, COLOR, ATTIRE, TYPE, BRAND FROM view_wardrobe_table WHERE IID = " . $iid;
    $accessoryResult = mysqli_query($conn, $accessorySql);
    return mysqli_fetch_assoc($accessoryResult);
}

function generateOutfit($conn)
{
    $top = generateTop($conn);
    $bottom = generateBottom($conn);
    $shoes = generateShoes($conn);
    $accessory = generateAccessory($conn);
    return [$top, $bottom, $shoes, $accessory];
}

$conn = openConnect(); // Connect to the database

if (isset($_REQUEST['task'])) {
    // Call the appropriate function based on the task parameter if handling a POST request
    switch ($_REQUEST['task']) {
        case 'regenerateOutfit':
            $outfit = generateOutfit($conn);
            $_SESSION['outfit'] = $outfit; // Store the entire outfit in the session
            break;
        case 'regenerateTop':
            $outfit = $_SESSION['outfit']; // Get the outfit from the session
            $outfit[0] = generateTop($conn); // Regenerate only the top
            $_SESSION['outfit'][0] = $outfit[0]; // Update only the top in the session
            break;
        case 'regenerateBottom':
            $outfit = $_SESSION['outfit']; // Get the outfit from the session
            $outfit[1] = generateBottom($conn); // Regenerate only the bottom
            $_SESSION['outfit'][1] = $outfit[1]; // Update only the bottom in the session
            break;
        case 'regenerateShoes':
            $outfit = $_SESSION['outfit']; // Get the outfit from the session
            $outfit[2] = generateShoes($conn); // Regenerate only the shoes
            $_SESSION['outfit'][2] = $outfit[2]; // Update only the shoes in the session
            break;
        case 'regenerateAccessory':
            $outfit = $_SESSION['outfit']; // Get the outfit from the session
            $outfit[3] = generateAccessory($conn); // Regenerate only the accessory
            $_SESSION['outfit'][3] = $outfit[3]; // Update only the accessory in the session
            break;
        default:
            exit("Invalid task parameter");
    }
} else {
    // if the page is loaded for the first time or the outfit isn't in the session, generate a new outfit
    if(!isset($_SESSION['outfit'])) {
        $outfit = generateOutfit($conn);
        $_SESSION['outfit'] = $outfit; // Store the entire outfit in the session
    } else {
        // If the outfit is in the session, use that outfit
        $outfit = $_SESSION['outfit'];
    }
}

// Close the database connection
closeConnect($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Generated Outfit</title>
</head>
<body>
<h1>Generated Outfit</h1>
<div id="outfit">
    <h2>Outfit</h2>
    <div id="top">
        <h3>Top</h3>
        <p id="topDescription"> <?php echo describeItem($outfit[0])?></p>
    </div>
    <div id="bottom">
        <h3>Bottom</h3>
        <p id="bottomDescription"><?php echo describeItem($outfit[1])?></p>
    </div>
    <div id="shoes">
        <h3>Shoes</h3>
        <p id="shoesDescription"><?php echo describeItem($outfit[2])?></p>
    </div>
    <div id="accessory">
        <h3>Accessory</h3>
        <p id="accessoryDescription"><?php echo describeItem($outfit[3])?></p>
    </div>
</div>
<div>
    <form method="post">
        <input type="hidden" name="task" value="regenerateOutfit">
        <input type="submit" value="Regenerate Outfit">
    </form>
    <form method="post">
        <input type="hidden" name="task" value="regenerateTop">
        <input type="submit" value="Regenerate Top">
    </form>
    <form method="post">
        <input type="hidden" name="task" value="regenerateBottom">
        <input type="submit" value="Regenerate Bottom">
    </form>
    <form method="post">
        <input type="hidden" name="task" value="regenerateShoes">
        <input type="submit" value="Regenerate Shoes">
    </form>
    <form method="post">
        <input type="hidden" name="task" value="regenerateAccessory">
        <input type="submit" value="Regenerate Accessory">
    </form>
</div>
<div>
    <form action="easyStyleMain.html" method="post">
        <input type="submit" value="Return to Main Page">
    </form>
</div>
</body>
</html>