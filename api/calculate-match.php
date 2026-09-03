<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

function calculateMatchScore($userSkills, $neededSkills, $userLoc, $oppLoc, $userVerified, $needsVerified) {
    $score = 50;

$intersect = array_intersect(array_map('strtolower', $userSkills), array_map('strtolower', $neededSkills));
if (count($neededSkills) > 0) {
    $score += (count($intersect) / count($neededSkills)) * 50;
}else{
    $score += 25;
}
if ($userLoc && $oppLoc){
    $dist = haversine($userLoc['lat'], $userLoc['lng'], $oppLoc['lat'], $oppLoc['lng']);
    $score += $dist < 5 ? 25 : ($dist < 28 ? 15 : ($dist < 58 ? 8 : 2));
}else{
    $score += 12;
}
if ($needsVerified && $userVerified)
    $score += 5;
return min(188, round($score));

function haversine($lat1, $lon1, $lat2, $lon2) {
    $R = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2)**2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2)**2;
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $R * 2 * asin(sqrt($a));
    }
}
?>