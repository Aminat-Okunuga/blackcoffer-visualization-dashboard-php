<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$databaseName = "blackcoffer_db";

// Connect to the existing database
$conn = new mysqli($servername, $username, $password, $databaseName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a table based on the CSV structure (if it doesn't exist)
$sql = "CREATE TABLE IF NOT EXISTS data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    end_year INT,
    citylng VARCHAR(191),
    citylat VARCHAR(191),
    intensity INT,
    sector VARCHAR(191),
    topic VARCHAR(191),
    insight TEXT,
    swot VARCHAR(191),
    url TEXT,
    region VARCHAR(191),
    start_year VARCHAR(191),
    impact VARCHAR(191),
    added VARCHAR(191),
    published VARCHAR(191),
    city VARCHAR(191),
    country VARCHAR(191),
    relevance INT,
    pestle VARCHAR(191),
    source TEXT,
    title TEXT,
    likelihood INT
)";
$conn->query($sql);

// Read the CSV file and insert data into the table
if (($handle = fopen("Data.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // Assign values to variables
        $end_year = $data[0];
        $citylng = $data[1];
        $citylat = $data[2];
        $intensity = $data[3];
        $sector = $data[4];
        $topic = $data[5];
        $insight = $data[6];
        $swot = $data[7];
        $url = $data[8];
        $region = $data[9];
        $start_year = $data[10];
        $impact = $data[11];
        $added = $data[12];
        $published = $data[13];
        $city = $data[14];
        $country = $data[15];
        $relevance = $data[16];
        $pestle = $data[17];
        $source = $data[18];
        $title = $data[19];
        $likelihood = $data[20];

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO data (
            end_year, citylng, citylat, intensity, sector, topic, insight, swot, url, region, start_year, impact, added, published, city, country, relevance, pestle, source, title, likelihood
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === FALSE) {
            echo "Error in preparing SQL statement: " . $conn->error;
        } else {
            $stmt->bind_param("iissississssssssssssi", $end_year, $citylng, $citylat, $intensity, $sector, $topic, $insight, $swot, $url, $region, $start_year, $impact, $added, $published, $city, $country, $relevance, $pestle, $source, $title, $likelihood);

            if ($stmt->execute() === FALSE) {
                echo "Error in executing SQL statement: " . $stmt->error;
            }
            $stmt->close();
        }
    }
    fclose($handle);
}

$conn->close();
?>
