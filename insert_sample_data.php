<?php
require_once 'config/database.php';

try {
    $conn = getDBConnection();

    // Read and execute the sample data SQL file
    $sql = file_get_contents('sample_data.sql');

    if ($sql === false) {
        throw new Exception("Could not read sample_data.sql file");
    }

    // Split the SQL file into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));

    foreach ($statements as $statement) {
        if (!empty($statement)) {
            $conn->exec($statement);
        }
    }

    echo "Sample data inserted successfully!\n";

    // Verify the data was inserted
    $tables = ['menu_categories', 'menu_items', 'restaurant_tables', 'reservations'];

    foreach ($tables as $table) {
        $stmt = $conn->query("SELECT COUNT(*) as count FROM $table");
        $result = $stmt->fetch();
        echo "Table $table: {$result['count']} records\n";
    }

} catch (Exception $e) {
    echo "Error inserting sample data: " . $e->getMessage() . "\n";
}
?>
