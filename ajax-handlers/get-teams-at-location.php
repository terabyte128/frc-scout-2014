<?php

class Teams {

    /**
     * 
     * @param type $location
     * @returns a query object
     */
    public static function getPitScoutedAtLocation($location) {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/setup-session.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php';

        try {
            $query = $db->prepare("SELECT `scouted_team` FROM `frc_pit_scouting_data` WHERE `location`=? GROUP BY `scouted_team` ORDER BY `scouted_team`");
            $query->execute(array($location));
            return $query;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}

?>
