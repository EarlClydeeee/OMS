<?php
/*
    This file contains functions that updaates the monitoring data for applicators.
*/


function monitorApplicatorOutput($applicator_data, $applicator_output, $direction = "increment") {
    /*
        Updates or inserts applicator monitoring data into the `monitor_applicator` table.
        Automatically handles both SIDE-type and END/CLAMP/STRIP AND CRIMP-type applicators,
        including increment or decrement logic for outputs and updating custom parts.
    */

    global $pdo;

    try {
        // Extract type and ID (handles if $applicator_data is just an ID or full array)
        $type = $applicator_data['description'];
        $applicator_id = is_array($applicator_data) ? $applicator_data['applicator_id'] : $applicator_data;

        // Convert to negative if decrementing
        if (strtolower($direction) === "decrement") {
            $applicator_output = -abs($applicator_output);
        }

        // Load custom parts for applicators
        require_once __DIR__ . '/read_custom_parts.php';
        $custom_parts = getCustomParts('APPLICATOR');

        // If custom parts retrieval failed (string message returned), pass it back
        if (is_string($custom_parts)) {
            return $custom_parts; 
        }

        // Build an array of part => output
        $new_parts = [];
        foreach ($custom_parts as $part) {
            $new_parts[$part['part_name']] = $applicator_output;
        }

        // Check if there’s an existing record for this applicator
        $stmt_check = $pdo->prepare("
            SELECT custom_parts_output 
            FROM monitor_applicator 
            WHERE applicator_id = :id 
            LIMIT 1
        ");
        $stmt_check->execute([':id' => $applicator_id]);
        $existing = $stmt_check->fetchColumn();

        // Merge with existing custom parts data if it exists
        if ($existing) {
            $existing_parts = json_decode($existing, true) ?? [];
            foreach ($new_parts as $key => $val) {
                $existing_parts[$key] = ($existing_parts[$key] ?? 0) + $val;
            }
            $custom_parts_json = json_encode($existing_parts);
        } else {
            $custom_parts_json = json_encode($new_parts);
        }

        // Prepare SQL depending on applicator type
        switch (true) {
            // SIDE-type applicators
            case $type === "SIDE":
                $stmt = $pdo->prepare("
                    INSERT INTO monitor_applicator (
                        applicator_id, total_output, wire_crimper_output, wire_anvil_output, 
                        insulation_crimper_output, insulation_anvil_output, slide_cutter_output, 
                        cutter_holder_output, custom_parts_output, last_updated
                    ) VALUES (
                        :applicator_id, :val, :val, :val,
                        :val, :val, :val,
                        :val, :custom_json, CURRENT_TIMESTAMP
                    )
                    ON DUPLICATE KEY UPDATE
                        total_output = total_output + :val,
                        wire_crimper_output = wire_crimper_output + :val,
                        wire_anvil_output = wire_anvil_output + :val,
                        insulation_crimper_output = insulation_crimper_output + :val,
                        insulation_anvil_output = insulation_anvil_output + :val,
                        slide_cutter_output = slide_cutter_output + :val,
                        cutter_holder_output = cutter_holder_output + :val,
                        custom_parts_output = :custom_json,
                        last_updated = CURRENT_TIMESTAMP
                ");
                break;

            // END, CLAMP, and STRIP AND CRIMP-type applicators
            case in_array($type, ["END", "CLAMP", "STRIP AND CRIMP"], true):
                $stmt = $pdo->prepare("
                    INSERT INTO monitor_applicator (
                        applicator_id, total_output, wire_crimper_output, wire_anvil_output, 
                        insulation_crimper_output, insulation_anvil_output, shear_blade_output, 
                        cutter_a_output, cutter_b_output, custom_parts_output, last_updated
                    ) VALUES (
                        :applicator_id, :val, :val, :val,
                        :val, :val, :val, :val,
                        :val, :custom_json, CURRENT_TIMESTAMP
                    )
                    ON DUPLICATE KEY UPDATE
                        total_output = total_output + :val,
                        wire_crimper_output = wire_crimper_output + :val,
                        wire_anvil_output = wire_anvil_output + :val,
                        insulation_crimper_output = insulation_crimper_output + :val,
                        cutter_a_output = cutter_a_output + :val,
                        cutter_b_output = cutter_b_output + :val,
                        custom_parts_output = :custom_json,
                        last_updated = CURRENT_TIMESTAMP
                ");
                break;

            // Unknown applicator type
            default:
                return "Invalid applicator type: " . htmlspecialchars($type, ENT_QUOTES);
        }

        // Bind parameters
        $stmt->bindParam(':applicator_id', $applicator_id, PDO::PARAM_INT);
        $stmt->bindParam(':val', $applicator_output, PDO::PARAM_INT);
        $stmt->bindParam(':custom_json', $custom_parts_json, PDO::PARAM_STR);

        // Execute query
        $stmt->execute();
        return true;

    } catch (PDOException $e) {
        // Log and return a sanitized error
        error_log("DB Error in monitorApplicatorOutput(): " . $e->getMessage());
        return "Database error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES);
    }
}



function resetApplicatorOutput($applicator_id, $part_name) {
    /*
        Resets the output for a specific part of an applicator in the monitor_applicator table.
        Includes part reset for defined and custom parts.

        Returns:
        - true on success 
        - error string
    */

    global $pdo;
    
    $accepted_part_names = [
        'wire_crimper_output',
        'wire_anvil_output',
        'insulation_crimper_output',
        'insulation_anvil_output',
        'slide_cutter_output',
        'cutter_holder_output',
        'shear_blade_output',
        'cutter_a_output',
        'cutter_b_output'];
    
    // Get custom applicator parts 
    require_once "read_custom_parts.php";
    $custom_parts = getCustomParts("APPLICATOR");

    // Return error message if any issue occurs
    if (is_string($custom_parts)) {
        return $custom_parts;
    }

    foreach ($custom_parts as $row) {
        $accepted_part_names[] = $row["part_name"];
    }

    // Check if given part_name is accepted 
    if (!in_array($accepted_part_names)) {
        return "Reset cancelled: invalid part name!"
    }

    // Execute main logic 
    try {
        $stmt = $pdo->prepare("
            UPDATE monitor applicators
            SET $part_name = 0,
            WHERE applicator_id = :applicator_id
        ")

        $stmt->bindParam(':applicator_id', $applicator_id);
        $stmt->execute();

        return true;

    } catch (PDOException $e) {
        // Log error and return an error message on failure
        error_log("Database Error in resetApplicatorOutput: " . $e->getMessage());
        return "Database error in resetApplicatorOutput: " . htmlspecialchars($e->getMessage(), ENT_QUOTES);
    }
}