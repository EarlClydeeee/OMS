<div class="data-section" id="disabled-applicators-section">
    <div class="section-header">
        <div class="section-title">
            📤 Recently Deleted Applicators
            <span class="section-badge">3</span>
        </div>
        <div class="expand-icon">▼</div>
    </div>
    <div class="section-content expanded">
        <!-- Filters -->
        <div class="search-filter">
            <div class="search-filter">
                <input type="text" class="search-input" placeholder="Search here..." onkeyup="applyDisabledApplicatorFilters()">
            </div>
            <select id="applicatorDescription" class="filter-select" onchange="applyDisabledApplicatorFilters()">  
                <option value="ALL">All Types</option>
                <option value="SIDE">SIDE</option>
                <option value="END">END</option>
                <option value="CLAMP">CLAMP</option>
                <option value="STRIP AND CRIMP">STRIP AND CRIMP</option>
            </select>
            <select id="applicatorWireType" class="filter-select" onchange="applyDisabledApplicatorFilters()">  
                <option value="ALL">All Types</option>
                <option value="SMALL">Small</option>
                <option value="BIG">Big</option>
            </select>
        </div>
        <div class="table-container">
            <table class="data-table">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>HP Number</th>
                            <th>Description</th>
                            <th>Terminal Maker</th>
                            <th>Applicator Maker</th>
                            <th>Last Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($disabled_applicators as $applicator): ?>
                        <tr>
                            <td>
                                <button id="restore-applicator-<?= htmlspecialchars($applicator['applicator_id']) ?>"
                                        class="restore-btn restore-applicator-btn"
                                        data-applicator-id="<?= htmlspecialchars($applicator['applicator_id']) ?>">
                                    Restore
                                </button>
                            </td>
                            <td><?php echo htmlspecialchars($applicator['hp_no']); ?></td>
                            <td><?php echo htmlspecialchars($applicator['description']); ?></td>
                            <td><?php echo htmlspecialchars($applicator['terminal_maker']); ?></td>
                            <td><?php echo htmlspecialchars($applicator['applicator_maker']); ?></td>
                            <td><?php echo htmlspecialchars($applicator['last_encoded']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<div>