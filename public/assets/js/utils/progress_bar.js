/**
 * Progress Bar System for Applicator Outputs
 * 
 * This module calculates percentage progress of applicator parts relative to their
 * min and max lifespan values based on HP model specifications.
 */

// HP Model Specifications with min-max ranges for each part
const hpSpecs = {
  "HP-1354": { WC: [500000, 1000000], WA: [500000, 1000000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1126": { WC: [500000, 1000000], WA: [500000, 1000000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1460": { WC: [500000, 1000000], WA: [500000, 1000000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1427": { WC: [500000, 1000001], WA: [500000, 1000000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1426": { WC: [500000, 1000002], WA: [500000, 1000000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1555": { WC: [500000, 1000002], WA: [500000, 1000000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1511": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1540": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1512": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-323": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-796": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-848": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-617": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-97": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-213": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1402": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-892": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1302": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-133": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-193": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-608": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-931": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-340": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-70": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1342": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1030": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1428": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1429": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1513": { WC: [300000, 600000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1442": { WC: [500000, 1000000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1527": { WC: [500000, 1000000], WA: [300000, 600000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1450": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-945": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-813": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-596": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1444": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1006": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1233": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1024": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-761": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-269": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-42": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-111": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1048": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1054": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1645": { WC: [300000, 600000], WA: [300000, 600000], IC: [300000, 600000], IA: [300000, 600000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-773": { WC: [250000, 500000], WA: [250000, 500000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-294": { WC: [250000, 500000], WA: [250000, 500000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-405": { WC: [250000, 500000], WA: [250000, 500000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-467": { WC: [250000, 500000], WA: [250000, 500000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-263": { WC: [250000, 500000], WA: [250000, 500000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-890": { WC: [250000, 500000], WA: [250000, 500000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-314": { WC: [250000, 500000], WA: [250000, 500000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-371": { WC: [250000, 500000], WA: [250000, 500000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-486": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-835": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-518": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-330": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-509": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-889": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1343": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1211": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1607": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-606": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-896": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-901": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1391": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1606": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1415": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] },
  "HP-1416": { WC: [150000, 300000], WA: [150000, 300000], IC: [500000, 1000000], IA: [500000, 1000000], SC: [0, 1000000], CH: [0, 1000000], SB: [0, 1000000], CA: [0, 1000000], CB: [0, 1000000] }
};

// Part type mapping for database columns
const partTypeMapping = {
  'WC': 'wire_crimper',
  'WA': 'wire_anvil', 
  'IC': 'insulation_crimper',
  'IA': 'insulation_anvil',
  'SC': 'slide_cutter',
  'CH': 'cutter_holder',
  'SB': 'shear_blade',
  'CA': 'cutter_a',
  'CB': 'cutter_b'
};

/**
 * Calculate percentage progress for a part based on HP model specifications
 * @param {string} hpCode - HP model code (e.g., "HP-1354")
 * @param {string} partType - Part type code (e.g., "WC", "WA", "IC", "IA")
 * @param {number} currentValue - Current output value
 * @returns {number} Percentage value between 0-100
 */
function calculateProgress(hpCode, partType, currentValue) {
  // Get HP specifications
  const hpModel = hpSpecs[hpCode];
  if (!hpModel) {
    console.warn(`HP model ${hpCode} not found in specifications`);
    return 0;
  }

  // Get part specifications
  const partSpecs = hpModel[partType];
  if (!partSpecs) {
    console.warn(`Part type ${partType} not found for HP model ${hpCode}`);
    return 0;
  }

  const [min, max] = partSpecs;
  
  // Calculate percentage
  let percentage = ((currentValue - min) / (max - min)) * 100;
  
  // Clamp value between 0-100
  percentage = Math.max(0, Math.min(100, percentage));
  
  return Math.round(percentage * 100) / 100; // Round to 2 decimal places
}

/**
 * Create HTML progress bar element
 * @param {number} percentage - Percentage value (0-100)
 * @param {string} partName - Display name for the part
 * @param {string} elementId - Unique ID for the progress bar element
 * @returns {string} HTML string for the progress bar
 */
function createProgressBar(percentage, partName, elementId) {
  const progressClass = percentage >= 90 ? 'progress-danger' : 
                       percentage >= 75 ? 'progress-warning' : 
                       percentage >= 50 ? 'progress-info' : 'progress-success';
  
  return `
    <div class="progress-item" id="${elementId}">
      <div class="progress-label">
        <span class="part-name">${partName}</span>
        <span class="percentage">${percentage}%</span>
      </div>
      <div class="progress-bar-container">
        <div class="progress-bar ${progressClass}" style="width: ${percentage}%"></div>
      </div>
    </div>
  `;
}

/**
 * Update progress bar display
 * @param {string} elementId - ID of the progress bar element
 * @param {number} percentage - New percentage value
 */
function updateProgressBar(elementId, percentage) {
  const element = document.getElementById(elementId);
  if (!element) return;

  const progressBar = element.querySelector('.progress-bar');
  const percentageText = element.querySelector('.percentage');
  
  if (progressBar) {
    progressBar.style.width = `${percentage}%`;
    
    // Update progress bar class based on percentage
    progressBar.className = 'progress-bar ' + 
      (percentage >= 90 ? 'progress-danger' : 
       percentage >= 75 ? 'progress-warning' : 
       percentage >= 50 ? 'progress-info' : 'progress-success');
  }
  
  if (percentageText) {
    percentageText.textContent = `${percentage}%`;
  }
}

/**
 * Process applicator output data and create progress bars
 * @param {Object} applicatorData - Data from applicator_outputs table
 * @param {string} containerId - ID of the container to append progress bars
 */
function processApplicatorProgress(applicatorData, containerId) {
  const container = document.getElementById(containerId);
  if (!container) {
    console.error(`Container with ID '${containerId}' not found`);
    return;
  }

  const hpCode = applicatorData.hp_no;
  const applicatorId = applicatorData.applicator_id;
  
  // Clear existing content
  container.innerHTML = '';
  
  // Add header
  const header = document.createElement('h3');
  header.textContent = `Progress for ${hpCode} (ID: ${applicatorId})`;
  container.appendChild(header);

  // Process standard parts
  const standardParts = [
    { code: 'WC', name: 'Wire Crimper', value: applicatorData.wire_crimper_output || 0 },
    { code: 'WA', name: 'Wire Anvil', value: applicatorData.wire_anvil_output || 0 },
    { code: 'IC', name: 'Insulation Crimper', value: applicatorData.insulation_crimper_output || 0 },
    { code: 'IA', name: 'Insulation Anvil', value: applicatorData.insulation_anvil_output || 0 },
    { code: 'SC', name: 'Slide Cutter', value: applicatorData.slide_cutter_output || 0 },
    { code: 'CH', name: 'Cutter Holder', value: applicatorData.cutter_holder_output || 0 },
    { code: 'SB', name: 'Shear Blade', value: applicatorData.shear_blade_output || 0 },
    { code: 'CA', name: 'Cutter A', value: applicatorData.cutter_a_output || 0 },
    { code: 'CB', name: 'Cutter B', value: applicatorData.cutter_b_output || 0 }
  ];

  standardParts.forEach(part => {
    const percentage = calculateProgress(hpCode, part.code, part.value);
    const elementId = `progress-${applicatorId}-${part.code}`;
    const progressBarHtml = createProgressBar(percentage, part.name, elementId);
    
    const wrapper = document.createElement('div');
    wrapper.innerHTML = progressBarHtml;
    container.appendChild(wrapper.firstElementChild);
  });

  // Process custom parts if available
  if (applicatorData.custom_parts_output) {
    try {
      const customParts = JSON.parse(applicatorData.custom_parts_output);
      Object.entries(customParts).forEach(([partName, value]) => {
        // For custom parts, we'll use a default range or skip if no specs available
        const percentage = calculateCustomPartProgress(value);
        const elementId = `progress-${applicatorId}-custom-${partName.replace(/\s+/g, '-')}`;
        const progressBarHtml = createProgressBar(percentage, partName, elementId);
        
        const wrapper = document.createElement('div');
        wrapper.innerHTML = progressBarHtml;
        container.appendChild(wrapper.firstElementChild);
      });
    } catch (error) {
      console.error('Error parsing custom parts JSON:', error);
    }
  }
}

/**
 * Calculate progress for custom parts (using default ranges)
 * @param {number} value - Current output value
 * @returns {number} Percentage value
 */
function calculateCustomPartProgress(value) {
  // Default range for custom parts (can be adjusted)
  const min = 0;
  const max = 1000000;
  
  let percentage = ((value - min) / (max - min)) * 100;
  percentage = Math.max(0, Math.min(100, percentage));
  
  return Math.round(percentage * 100) / 100;
}

/**
 * Fetch applicator data and display progress bars
 * @param {number} applicatorId - ID of the applicator
 * @param {string} containerId - ID of the container to display progress bars
 */
async function fetchAndDisplayProgress(applicatorId, containerId) {
  try {
    const response = await fetch(`/ajax/get_applicator_progress.php?applicator_id=${applicatorId}`);
    const data = await response.json();
    
    if (data.success) {
      processApplicatorProgress(data.applicator, containerId);
    } else {
      console.error('Failed to fetch applicator data:', data.message);
    }
  } catch (error) {
    console.error('Error fetching applicator data:', error);
  }
}

// Export functions for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = {
    calculateProgress,
    createProgressBar,
    updateProgressBar,
    processApplicatorProgress,
    fetchAndDisplayProgress,
    hpSpecs,
    partTypeMapping
  };
}
