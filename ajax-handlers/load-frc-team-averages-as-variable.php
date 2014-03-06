<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of load-frc-team-averages-as-variable
 *
 * @author webster
 */
class Averages {

    /**
     * Returns a processed query
     * 
     * @param type $scoutedTeamNumber
     * @param type $onlyLoggedInTeam
     * @param type $onlyThisLocation
     * @return type
     */
    static function getAverages($scoutedTeamNumber, $onlyLoggedInTeam, $onlyThisLocation, $orderByTotalPoints) {
        
        $docRoot = $_SERVER['DOCUMENT_ROOT'];
        
// initialize $params as an empty array; fill it with the logged in team's number if they want to filter
        $params = array();

        require_once $docRoot . '/includes/setup-session.php';
        require_once $docRoot . '/includes/db-connect.php';

        $queryString = ('SELECT scouted_team, '
                . 'format(AVG((auto_high_goals * 15) + (auto_low_goals * 6) + (auto_hot_goals * 5) + (auto_moved_to_alliance_zone * 5)), 1) AS auto_points, '
                . 'format(AVG((tele_received_assists * 10) + (tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10) '
                . '+ (tele_truss_catches * 10)), 1) AS tele_points, '
                . 'format(AVG((auto_high_goals * 15) + (auto_low_goals * 6) + (auto_hot_goals * 5) + (auto_moved_to_alliance_zone * 5) + (tele_received_assists * 10) + '
                . '(tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10) + (tele_truss_catches * 10)), 1) AS total_points'
                . ' FROM `frc_match_data`');

//if the team wants to filter then do so
        if ($onlyLoggedInTeam) {
            //add filter to query string
            $queryString .= ' WHERE scouting_team=?';

            //this needs to be passed as an argument to the sql query
            array_push($params, $teamNumber);
            if ($onlyThisLocation) {
                $queryString .= ' AND ';
            }
        }

        if ($onlyThisLocation) {
            if (!$onlyLoggedInTeam) {
                $queryString .= ' WHERE ';
            }
            $queryString .= 'location=?';
            array_push($params, $location);
            if (isset($scoutedTeamNumber)) {
                $queryString .= ' AND ';
            }
        }

        if (isset($scoutedTeamNumber)) {
            if (!$onlyThisLocation) {
                $queryString .= ' WHERE ';
            }
            $queryString .= 'scouted_team=?';
            array_push($params, $scoutedTeamNumber);
        }


        $queryString .= ' GROUP BY `scouted_team`';

        if($orderByTotalPoints) {
            $queryString .= " ORDER BY `total_points`";
        }
        
        try {
            $query = $db->prepare($queryString);
            $query->execute($params);
        } catch (PDOException $e) {
            print_r($e->getMessage());
        }
        
        
        return $query;
    }

}

?>