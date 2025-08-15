<?php
/*
    This section is for adding a new applicator or machine to the system.
    It includes a form for entering details and submitting them to the server.
*/


// Start session and check if user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


//include_once __DIR__ . '/../includes/header.php'; // Include the header file for the navigation and logo
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Machine or Applicator</title>4
    <link rel="stylesheet" href="../../public/assets/css/base/base.css">
    <link rel="stylesheet" href="../../public/assets/css/add_entry.css">
    <!-- Load machine infinite scroll logic -->
    <script src="../../public/assets/js/load_machines.js" defer></script>
    <!-- Load applicator infinite scroll logic -->
    <script src="../../public/assets/js/load_applicators.js" defer></script>
    <!-- Load modal logic for editing machines -->
    <script src="../../public/assets/js/edit_machine_modal.js" defer></script>
    <!-- Load modal logic for editing applicators -->
    <script src="../../public/assets/js/edit_applicator_modal.js" defer></script>
    <!-- Load cancel forms of add modals form -->
    <script scr="../../public/assets/js/cancel_add_modal_form.js" defer></script>
</head>
<body>
    <?php // include '../includes/side_bar.php'; ?>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <button class="back-btn" onclick="window.history.back()">
                    ←
                </button>
                <div>
                    <h1 class="title">Manage Entries</h1>
                    <p class="subtitle">Manage machines and applicators in the system</p>
                </div>
            </div>
            <div class="add-entry-buttons">
                <button class="add-entry-btn add-machine-btn" onclick="openMachineModal()">
                    🔧 Add Machine
                </button>

                <button class="add-entry-btn add-applicator-btn" onclick="openApplicatorModal()">
                    ⚡ Add Applicator
                </button>
            </div>
        </div>


        <!-- Filters -->
        <div class="filters-card">
            <div class="filters-grid">
                <div class="search-wrapper">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="searchInput" placeholder="Search entries..." class="search-input">
                </div>

                <select id="typeFilter" class="filter-select">
                    <option value="all">All Types</option>
                    <option value="AUTOMATIC">Automatic</option>
                    <option value="SEMI-AUTOMATIC">Semi-Automatic</option>
                    <option value="SIDE">Side</option>
                    <option value="END">End</option>
                </select>

                <select id="statusFilter" class="filter-select">
                    <option value="all">All Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>

                <button type="button" class="btn-secondary" onclick="exportData()">📥 Export</button>
                <button type="button" class="btn-secondary" onclick="refreshData()">🔄 Refresh</button>
            </div>
        </div>


        <!-- Tab Section -->
        <div class="tab-section">
            <button class="tab-btn active" onclick="switchTab('machines')">🔧 Machines</button>
            <button class="tab-btn" onclick="switchTab('applicators')">⚡ Applicators</button>
        </div>  

        <!-- Machine Table -->
        <div>
            <h3>Latest Machines Added</h3>


        <div id="machine-table" class="entries-table-card active" style="height: 600px; overflow-y: auto;">
            <table class="entries-table">
                <thead>
                    <tr>
                        <th>Control No</th>
                        <th>Description</th>
                        <th>Model</th>
                        <th>Maker</th>
                        <th>Serial No</th>
                        <th>Invoice No</th>
                        <th>Actions</th>
                    </tr>
                </thead>


                    <?php
                    // Include database connection and machine reader logic
                    require_once __DIR__ . '/../includes/db.php';
                    require_once __DIR__ . '/../models/read_machines.php';


                    // Fetch initial set of machines (first 10 entries)
                    $machines = getMachines($pdo, 10, 0);
                    ?>

                    <tbody id="machine-body">
                        <!-- Render fetched machine data as table rows -->
                        <?php foreach ($machines as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['control_no']) ?></td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                <td><?= htmlspecialchars($row['model']) ?></td>
                                <td><?= htmlspecialchars($row['maker']) ?></td>
                                <td><?= htmlspecialchars($row['serial_no']) ?></td>
                                <td><?= htmlspecialchars($row['invoice_no']) ?></td>
                                <td>

                                <!-- Edit link with data attributes -->
                                    <div class="actions">
                                        <button class="action-btn edit-btn"
                                            type="button"
                                            onclick="openEditModal(this)"
                                            data-id="<?= $row['machine_id'] ?>"
                                            data-control="<?= htmlspecialchars($row['control_no'], ENT_QUOTES) ?>"
                                            data-description="<?= $row['description'] ?>"
                                            data-model="<?= htmlspecialchars($row['model'], ENT_QUOTES) ?>"
                                            data-maker="<?= htmlspecialchars($row['maker'], ENT_QUOTES) ?>"
                                            data-serial="<?= htmlspecialchars($row['serial_no'], ENT_QUOTES) ?>"
                                            data-invoice="<?= htmlspecialchars($row['invoice_no'], ENT_QUOTES) ?>"
                                        >✏️</button>

                                <!-- Delete form -->
                                        <form action="/SOMS/app/controllers/delete_machine.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this machine?');">
                                            <input type="hidden" name="machine_id" value="<?= $row['machine_id'] ?>">
                                            <button class="action-btn delete-btn" type="submit">🗑️</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Applicator Table -->
        <div id="applicators-table" class="entries-table-card" style="height: 600px; overflow-y: auto;">
            <table class="entries-table">
                <thead>
                    <tr>
                        <th>HP No</th>
                        <th>Terminal No</th>
                        <th>Description</th>
                        <th>Wire Type</th>
                        <th>Terminal Maker</th>
                        <th>Applicator Maker</th>
                        <th>Serial No</th>
                        <th>Invoice No</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="applicator-body">
                    <?php
                        require_once __DIR__ . '/../includes/db.php';
                        require_once __DIR__ . '/../models/read_applicators.php';
                        $applicators = getApplicators($pdo, 10, 0);
                        foreach ($applicators as $row):
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($row['hp_no']) ?></td>
                            <td><?= htmlspecialchars($row['terminal_no']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= htmlspecialchars($row['wire']) ?></td>
                            <td><?= htmlspecialchars($row['terminal_maker']) ?></td>
                            <td><?= htmlspecialchars($row['applicator_maker']) ?></td>
                            <td><?= htmlspecialchars($row['serial_no']) ?></td>
                            <td><?= htmlspecialchars($row['invoice_no']) ?></td>
                            <td>
                            <!-- Edit link with data attributes -->
                            <div class="actions">
                                <button class="action-btn edit-btn"
                                    type="button"
                                    onclick="openApplicatorEditModal(this)"
                                    data-id="<?= $row['applicator_id'] ?>"
                                    data-control="<?= htmlspecialchars($row['hp_no']) ?>"
                                    data-terminal="<?= htmlspecialchars($row['terminal_no']) ?>"
                                    data-description="<?= htmlspecialchars($row['description']) ?>"
                                    data-wire="<?= htmlspecialchars($row['wire']) ?>"
                                    data-terminal-maker="<?= htmlspecialchars($row['terminal_maker']) ?>"
                                    data-applicator-maker="<?= htmlspecialchars($row['applicator_maker']) ?>"
                                    data-serial="<?= htmlspecialchars($row['serial_no']) ?>"
                                    data-invoice="<?= htmlspecialchars($row['invoice_no']) ?>"
                            >✏️</button>

                            <!-- Delete form -->
                            <form action="/SOMS/app/controllers/delete_applicator.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this applicator?');">
                                <input type="hidden" name="applicator_id" value="<?= htmlspecialchars($row['applicator_id']) ?>">
                                <button type="submit"class="action-btn delete-btn">🗑️</button>
                            </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Add Machine Form Modal-->
        <div id="addMachineModal" class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="machineModalTitle" class="modal-title">
                        <span class="modal-icon">🔧</span>
                        <span id="machineModalTitleText">Add Machine</span>
                    </h2>
                </div>
                    
                <div class="modal-body">
                    <form id="addMachineForm" action="../controllers/add_machine.php" method="POST">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="machine_ctrl_no">Control No <span class="required">*</span></label>
                                <input type="text" id="machine_ctrl_no" name="control_no" required placeholder="Enter control number"><br><br>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Description <span class="required">*</span></label>
                                <select id="description" name="description" class="form-select" required>
                                    <option value="">--Select--</option>
                                    <option value="AUTOMATIC">AUTOMATIC</option>
                                    <option value="SEMI-AUTOMATIC">SEMI-AUTOMATIC</option>
                                </select><br><br>
                            </div>

                            <div class="form-group">
                                <label for="model">Model<span class="required">*</span></label>
                                <input type="text" id="model" name="model" required placeholder="Enter model"><br><br>
                            </div>

                            <div class="form-group">
                                <label for="machine_maker">Machine Maker:</label>
                                <input type="text" id="machine_maker" name="machine_maker" required placeholder="Enter machine maker"><br><br>
                            </div>

                            <div class="form-group">
                                <label for="machine_serial_no">Serial No:</label>
                                <input type="text" id="machine_serial_no" name="serial_no" placeholder="Enter serial number"><br><br>
                            </div>

                            <div class="form-group">
                                <label for="machine_invoice_no">Invoice No:</label>
                                <input type="text" id="machine_invoice_no" name="invoice_no" placeholder="Enter invoice no."><br><br>
                            </div>
                        </div>
                    </form>
                </div>
                
                            <div class="modal-footer">
                                <button type="button" class="btn-secondary" onclick="closeAddMachineModal()">Cancel</button>
                                <button type="submit" id="machineActionBtn" class="btn-primary" onclick="saveMachine()">Add Machine</button>
                            </div>
            </div>
        </div>

        <!-- Add Applicator Form Modal -->
        <div id="addApplicatorModal" class="modal-overlay">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 id="applicatorModalTitle" class="modal-title">
                        <span class="modal-icon">⚡</span>
                        <span>Add Applicator</span>
                    </h2>
                </div>

                <div class="modal-body">
                    <form id="applicatorForm" action="../controllers/add_applicator.php" method="POST">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="applicator_ctrl_no">Control No:</label>
                                <input type="text" id="add_applicator_ctrl_no" name="control_no" required><br><br>
                            </div>
                            
                            <div class="form-group">
                                <label for="terminal_no">Terminal No:</label>
                                <input type="text" id="add_applicator_terminal_no" name="terminal_no" required><br><br>
                            </div>

                            <div class="form-group">
                                <label for="description">Description:</label>
                                <select id="add_applicator_description" name="description" required>
                                    <option value="">--Select--</option>
                                    <option value="SIDE">SIDE</option>
                                    <option value="END">END</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="wire_type">Wire Type:</label>
                                <select id="add_applicator_wire_type" name="wire_type" required>
                                    <option value="">--Select--</option>
                                    <option value="BIG">BIG</option>
                                    <option value="SMALL">SMALL</option>
                                </select><br><br>
                            </div>

                            <div class="form-group">
                                <label for="terminal_maker">Terminal Maker:</label>
                                <input type="text" id="add_terminal_maker" name="terminal_maker" required><br><br>
                            </div>

                            <div class="form-group">
                                <label for="applicator_maker">Applicator Maker:</label>
                                <input type="text" id="add_applicator_maker" name="applicator_maker" required><br><br>
                            </div>

                            <div class="form-group">
                                <label for="applicator_serial_no">Serial No:</label>
                                <input type="text" id="add_applicator_serial_no" name="serial_no"><br><br>
                            </div>

                            <div class="form-group">
                                <label for="applicator_invoice_no">Invoice No:</label>
                                <input type="text" id="add_applicator_invoice_no" name="invoice_no"><br><br>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeAddApplicatorModal()">Cancel</button>
                    <button type="submit" id="applicatorActionBtn" class="btn-primary" onclick="saveApplicator()">Add Applicator</button>
                </div>

            </div>
        </div>

            <!-- Edit Machine Modal -->
    <div id="editModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <span class="modal-icon">🔧</span>
                    Edit Machine
                </h2>
                <button class="close-btn" onclick="closeModal()">✖️</button>
            </div>

            <div class="modal-body">
                <form id="editMachineForm" action="../controllers/edit_machine.php" method="POST">
                    <input type="hidden" name="machine_id" id="edit_machine_id">

                    <div class="form-group">
                        <label>Control No:</label>
                        <input type="text" name="control_no" id="edit_control_no" required>
                    </div>

                    <div class="form-group">
                        <label>Description:</label>
                        <select name="description" id="edit_description" required>
                            <option value="">--Select--</option>
                            <option value="AUTOMATIC">AUTOMATIC</option>
                            <option value="SEMI-AUTOMATIC">SEMI-AUTOMATIC</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Model:</label>
                        <input type="text" name="model" id="edit_model" required>
                    </div>

                    <div class="form-group">
                        <label>Maker:</label>
                        <input type="text" name="machine_maker" id="edit_maker" required>
                    </div>

                    <div class="form-group">
                        <label>Serial No:</label>
                        <input type="text" name="serial_no" id="edit_serial_no">
                    </div>

                    <div class="form-group">
                        <label>Invoice No:</label>
                        <input type="text" name="invoice_no" id="edit_invoice_no">
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeMachineModal()">Cancel</button>
                <button type="submit" form="editMachineForm" class="btn-primary">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Edit Applicator Modal -->
    <div id="editApplicatorModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <span class="modal-icon">⚡</span>
                    Edit Applicator
                </h2>
                <button class="close-btn" onclick="closeModal()">✖️</button>
            </div>

            <div class="modal-body">
                <form id="editApplicatorForm" action="../controllers/edit_applicator.php" method="POST">
                    <!-- Hidden input to store applicator ID -->
                    <input type="hidden" name="applicator_id" id="edit_applicator_id">

                    <div class="form-group">
                        <label>HP No:</label>
                        <input type="text" name="control_no" id="edit_applicator_control" required>
                    </div>

                    <div class="form-group">
                        <label>Terminal No:</label>
                        <input type="text" name="terminal_no" id="edit_terminal_no" required>
                    </div>

                    <div class="form-group">
                        <label>Description:</label>
                        <select name="description" id="edit_applicator_description" required>
                            <option value="">--Select--</option>
                            <option value="SIDE">SIDE</option>
                            <option value="END">END</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Wire Type:</label>
                        <select name="wire_type" id="edit_wire_type" required>
                            <option value="">--Select--</option>
                            <option value="BIG">BIG</option>
                            <option value="SMALL">SMALL</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Terminal Maker:</label>
                        <input type="text" name="terminal_maker" id="edit_terminal_maker" required>
                    </div>

                    <div class="form-group">
                        <label>Applicator Maker:</label>
                        <input type="text" name="applicator_maker" id="edit_applicator_maker" required>
                    </div>

                    <div class="form-group">
                        <label>Serial No:</label>
                        <input type="text" name="serial_no" id="edit_applicator_serial_no">
                    </div>

                    <div class="form-group">
                        <label>Invoice No:</label>
                        <input type="text" name="invoice_no" id="edit_applicator_invoice_no">
                    </div>
                </form>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeApplicatorModal()">Cancel</button>
                <button type="submit" form="editApplicatorForm" class="btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
    <script src="../../public/assets/js/add_entry.js"></script>
    <script src="../../public/assets/js/export_entry.js"></script>
</body>
</html>