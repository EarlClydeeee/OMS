<?php
/**
 * Progress Bar Helper for Applicator Outputs
 * 
 * PHP version of the progress bar system that calculates percentage progress
 * of applicator parts relative to their min and max lifespan values.
 */

// HP Model Specifications with min-max ranges for each part
$hpSpecs = [
    "HP-1354" => ["WC" => [500000, 1000000], "WA" => [500000, 1000000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1126" => ["WC" => [500000, 1000000], "WA" => [500000, 1000000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1460" => ["WC" => [500000, 1000000], "WA" => [500000, 1000000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1427" => ["WC" => [500000, 1000001], "WA" => [500000, 1000000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1426" => ["WC" => [500000, 1000002], "WA" => [500000, 1000000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1555" => ["WC" => [500000, 1000002], "WA" => [500000, 1000000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1511" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1540" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1512" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-323" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-796" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-848" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-617" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-97" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-213" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1402" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-892" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1302" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-133" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-193" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-608" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-931" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-340" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-70" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1342" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1030" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1428" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1429" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1513" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1442" => ["WC" => [500000, 1000000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1527" => ["WC" => [500000, 1000000], "WA" => [300000, 600000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1450" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-945" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-813" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-596" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1444" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1006" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1233" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1024" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-761" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-269" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-42" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-111" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1048" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1054" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1645" => ["WC" => [300000, 600000], "WA" => [300000, 600000], "IC" => [300000, 600000], "IA" => [300000, 600000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-773" => ["WC" => [250000, 500000], "WA" => [250000, 500000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-294" => ["WC" => [250000, 500000], "WA" => [250000, 500000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-405" => ["WC" => [250000, 500000], "WA" => [250000, 500000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-467" => ["WC" => [250000, 500000], "WA" => [250000, 500000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-263" => ["WC" => [250000, 500000], "WA" => [250000, 500000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-890" => ["WC" => [250000, 500000], "WA" => [250000, 500000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-314" => ["WC" => [250000, 500000], "WA" => [250000, 500000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-371" => ["WC" => [250000, 500000], "WA" => [250000, 500000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-486" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-835" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-518" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-330" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-509" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-889" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1343" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1211" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1607" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-606" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-896" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-901" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1391" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1606" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1415" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]],
    "HP-1416" => ["WC" => [150000, 300000], "WA" => [150000, 300000], "IC" => [500000, 1000000], "IA" => [500000, 1000000], "SC" => [0, 1000000], "CH" => [0, 1000000], "SB" => [0, 1000000], "CA" => [0, 1000000], "CB" => [0, 1000000]]
];

// Part type mapping for database columns
$partTypeMapping = [
    'WC' => 'wire_crimper',
    'WA' => 'wire_anvil', 
    'IC' => 'insulation_crimper',
    'IA' => 'insulation_anvil',
    'SC' => 'slide_cutter',
    'CH' => 'cutter_holder',
    'SB' => 'shear_blade',
    'CA' => 'cutter_a',
    'CB' => 'cutter_b'
];

/**
 * Calculate percentage progress for a part based on HP model specifications
 * 
 * @param string $hpCode HP model code (e.g., "HP-1354")
 * @param string $partType Part type code (e.g., "WC", "WA", "IC", "IA")
 * @param int $currentValue Current output value
 * @return float Percentage value between 0-100
 */
function calculateProgress($hpCode, $partType, $currentValue) {
    global $hpSpecs;
    
    // Get HP specifications
    if (!isset($hpSpecs[$hpCode])) {
        error_log("HP model {$hpCode} not found in specifications");
        return 0;
    }
    
    $hpModel = $hpSpecs[$hpCode];
    
    // Get part specifications
    if (!isset($hpModel[$partType])) {
        error_log("Part type {$partType} not found for HP model {$hpCode}");
        return 0;
    }
    
    $partSpecs = $hpModel[$partType];
    $min = $partSpecs[0];
    $max = $partSpecs[1];
    
    // Calculate percentage
    $percentage = (($currentValue - $min) / ($max - $min)) * 100;
    
    // Clamp value between 0-100
    $percentage = max(0, min(100, $percentage));
    
    return round($percentage, 2); // Round to 2 decimal places
}

/**
 * Create HTML progress bar element
 * 
 * @param float $percentage Percentage value (0-100)
 * @param string $partName Display name for the part
 * @param string $elementId Unique ID for the progress bar element
 * @return string HTML string for the progress bar
 */
function createProgressBar($percentage, $partName, $elementId) {
    $progressClass = $percentage >= 90 ? 'progress-danger' : 
                     ($percentage >= 75 ? 'progress-warning' : 
                     ($percentage >= 50 ? 'progress-info' : 'progress-success'));
    
    return '
    <div class="progress-item" id="' . htmlspecialchars($elementId) . '">
        <div class="progress-label">
            <span class="part-name">' . htmlspecialchars($partName) . '</span>
            <span class="percentage">' . number_format($percentage, 2) . '%</span>
        </div>
        <div class="progress-bar-container">
            <div class="progress-bar ' . $progressClass . '" style="width: ' . $percentage . '%"></div>
        </div>
    </div>';
}

/**
 * Calculate progress for custom parts (using default ranges)
 * 
 * @param int $value Current output value
 * @return float Percentage value
 */
function calculateCustomPartProgress($value) {
    // Default range for custom parts (can be adjusted)
    $min = 0;
    $max = 1000000;
    
    $percentage = (($value - $min) / ($max - $min)) * 100;
    $percentage = max(0, min(100, $percentage));
    
    return round($percentage, 2);
}

/**
 * Process applicator output data and create progress bars
 * 
 * @param array $applicatorData Data from applicator_outputs table
 * @param string $containerId ID of the container to append progress bars
 * @return string HTML string containing all progress bars
 */
function processApplicatorProgress($applicatorData, $containerId = 'progress-container') {
    $hpCode = $applicatorData['hp_no'];
    $applicatorId = $applicatorData['applicator_id'];
    
    $html = '<div id="' . htmlspecialchars($containerId) . '">';
    $html .= '<h3>Progress for ' . htmlspecialchars($hpCode) . ' (ID: ' . $applicatorId . ')</h3>';
    
    // Process standard parts
    $standardParts = [
        ['code' => 'WC', 'name' => 'Wire Crimper', 'value' => $applicatorData['wire_crimper_output'] ?? 0],
        ['code' => 'WA', 'name' => 'Wire Anvil', 'value' => $applicatorData['wire_anvil_output'] ?? 0],
        ['code' => 'IC', 'name' => 'Insulation Crimper', 'value' => $applicatorData['insulation_crimper_output'] ?? 0],
        ['code' => 'IA', 'name' => 'Insulation Anvil', 'value' => $applicatorData['insulation_anvil_output'] ?? 0],
        ['code' => 'SC', 'name' => 'Slide Cutter', 'value' => $applicatorData['slide_cutter_output'] ?? 0],
        ['code' => 'CH', 'name' => 'Cutter Holder', 'value' => $applicatorData['cutter_holder_output'] ?? 0],
        ['code' => 'SB', 'name' => 'Shear Blade', 'value' => $applicatorData['shear_blade_output'] ?? 0],
        ['code' => 'CA', 'name' => 'Cutter A', 'value' => $applicatorData['cutter_a_output'] ?? 0],
        ['code' => 'CB', 'name' => 'Cutter B', 'value' => $applicatorData['cutter_b_output'] ?? 0]
    ];
    
    foreach ($standardParts as $part) {
        $percentage = calculateProgress($hpCode, $part['code'], $part['value']);
        $elementId = 'progress-' . $applicatorId . '-' . $part['code'];
        $html .= createProgressBar($percentage, $part['name'], $elementId);
    }
    
    // Process custom parts if available
    if (!empty($applicatorData['custom_parts_output'])) {
        $customParts = json_decode($applicatorData['custom_parts_output'], true);
        if ($customParts && is_array($customParts)) {
            foreach ($customParts as $partName => $value) {
                $percentage = calculateCustomPartProgress($value);
                $elementId = 'progress-' . $applicatorId . '-custom-' . str_replace(' ', '-', $partName);
                $html .= createProgressBar($percentage, $partName, $elementId);
            }
        }
    }
    
    $html .= '</div>';
    return $html;
}

/**
 * Fetch applicator data from database and return progress bars
 * 
 * @param PDO $pdo Database connection
 * @param int $applicatorId ID of the applicator
 * @return string HTML string containing progress bars or error message
 */
function fetchAndDisplayProgress($pdo, $applicatorId) {
    try {
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
        
        $stmt->bindParam(':applicator_id', $applicatorId, PDO::PARAM_INT);
        $stmt->execute();
        
        $applicator = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$applicator) {
            return '<div class="error">Applicator not found or inactive</div>';
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
        
        return processApplicatorProgress($applicator);
        
    } catch (PDOException $e) {
        error_log("Database error in fetchAndDisplayProgress: " . $e->getMessage());
        return '<div class="error">Database error occurred</div>';
    } catch (Exception $e) {
        error_log("General error in fetchAndDisplayProgress: " . $e->getMessage());
        return '<div class="error">An error occurred while fetching data</div>';
    }
}
?>
