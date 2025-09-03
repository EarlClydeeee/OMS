<?php
/**
 * AJAX endpoint to fetch applicator data for progress bar calculations
 * 
 * This file fetches applicator output data from the monitor_applicator table
 * and returns it in JSON format for the progress bar system.
 */

// Include necessary files
require_once '../../app/includes/config.php';
require_once '../../app/includes/db.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if applicator_id is provided
if (!isset($_GET['applicator_id']) || !is_numeric($_GET['applicator_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid applicator ID provided'
    ]);
    exit;
}

$applicator_id = (int)$_GET['applicator_id'];

try {
    // Fetch applicator data with outputs from monitor_applicator table
    $stmt = $pdo->prepare("
        SELECT 
            a.applicator_id,
            a.hp_no,
            a.terminal_no,
            a.description,
            a.wire,
            a.terminal_maker,
            a.applicator_maker,
            ma.total_output,
            ma.wire_crimper_output,
            ma.wire_anvil_output,
            ma.insulation_crimper_output,
            ma.insulation_anvil_output,
            ma.slide_cutter_output,
            ma.cutter_holder_output,
            ma.shear_blade_output,
            ma.cutter_a_output,
            ma.cutter_b_output,
            ma.custom_parts_output,
            ma.last_updated
        FROM applicators a
        LEFT JOIN monitor_applicator ma ON a.applicator_id = ma.applicator_id
        WHERE a.applicator_id = :applicator_id 
        AND a.is_active = 1
    ");
    
    $stmt->bindParam(':applicator_id', $applicator_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $applicator = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$applicator) {
        echo json_encode([
            'success' => false,
            'message' => 'Applicator not found or inactive'
        ]);
        exit;
    }
    
    // Convert numeric values to integers
    $numericFields = [
        'total_output', 'wire_crimper_output', 'wire_anvil_output',
        'insulation_crimper_output', 'insulation_anvil_output',
        'slide_cutter_output', 'cutter_holder_output', 'shear_blade_output',
        'cutter_a_output', 'cutter_b_output'
    ];
    
    foreach ($numericFields as $field) {
        $applicator[$field] = (int)($applicator[$field] ?? 0);
    }
    
    // Return success response with applicator data
    echo json_encode([
        'success' => true,
        'applicator' => $applicator
    ]);
    
} catch (PDOException $e) {
    // Log error for debugging
    error_log("Database error in get_applicator_progress.php: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred'
    ]);
} catch (Exception $e) {
    // Log error for debugging
    error_log("General error in get_applicator_progress.php: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while fetching data'
    ]);
}
?>
