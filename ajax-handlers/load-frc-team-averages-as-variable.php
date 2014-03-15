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
    static function getAverages($db, $scoutedTeamNumber, $onlyLoggedInTeam, $teamNumber, $onlyThisLocation, $location, $orderByTotalPoints) {


// initialize $params as an empty array; fill it with the logged in team's number if they want to filter
        $params = array();

        $queryString = ('
                        # scouted team

                        SELECT scouted_team, 

                        # POINT-BASED AVERAGES

                        # autonomous average for ALL MATCHES
                        AVG(`match_auto_average`) AS `auto_average`,

                        # teleop average for ALL MATCHES
                        AVG(`match_tele_average`) AS `teleop_average`,

                        # total average score for ALL MATCHES
                        AVG(`match_auto_average`) + AVG(`match_tele_average`) AS `total_average`,

                        # NON POINT-BASED AVERAGES

                        AVG(`match_tele_average_high_goals`) as `tele_average_high_goals`,
                        AVG(`match_tele_average_low_goals`) as `tele_average_low_goals`,
                        AVG(`match_tele_average_truss_throws`) as `tele_average_truss_throws`,
                        AVG(`match_tele_average_truss_catches`) as `tele_average_truss_catches`,
                        AVG(`match_tele_average_received_assists`) as `tele_average_received_assists`,
                        AVG(`match_tele_average_passed_assists`) as `tele_average_passed_assists`,
                        AVG(`match_total_match_points`) as `average_total_match_points`

                        # subset to derive individual matches
                        # this will average different recorded scores of the same match before averaging all matches together
                        FROM (
                            # average for a single match
                            SELECT 

                            # POINT-BASED AVERAGES

                            # autonomous 
                            AVG((auto_high_goals * 15) + (auto_low_goals * 6) + (auto_hot_goals * 5) + (auto_moved_to_alliance_zone 	* 5)) AS `match_auto_average`,

                            # teleop
                            AVG((tele_received_assists * 10)+ (tele_high_goals * 10) + tele_low_goals + (tele_truss_throws * 10) + (tele_truss_catches * 10)) AS `match_tele_average`, 

                            # NON POINT-BASED AVERAGES

                            AVG(`tele_high_goals`) as `match_tele_average_high_goals`,
                            AVG(`tele_low_goals`) as `match_tele_average_low_goals`,
                            AVG(`tele_truss_throws`) as `match_tele_average_truss_throws`,
                            AVG(`tele_truss_catches`) as `match_tele_average_truss_catches`,
                            AVG(`tele_received_assists`) as `match_tele_average_received_assists`,
                            AVG(`tele_passed_assists`) as `match_tele_average_passed_assists`,
                            AVG(`total_match_points`) as `match_total_match_points`,


                            # MISC THINGS

                            # scouted team number
                            `scouted_team`
                            
                            # table name
                            FROM `frc_match_data`
                            # GIANT SPACE HERE TO ADD WHERE CLAUSES AND WHATNOT
        ');

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

        # now finish it off with a bang!
        $queryString .= '    
                            # these averages are by match number
                            GROUP BY `scouted_team`, `match_number`, `location`
                        # then THOSE averages are averaged by team
                        ) as `not_sure_why_this_has_to_exist` GROUP BY `scouted_team`
        ';

        if ($orderByTotalPoints) {
            $queryString .= " ORDER BY `total_average` DESC;";
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