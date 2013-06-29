<?php

class FightModel extends AbstractModel {

    public function init($character, $type, $id) {
        $id = (int)$id;

        if ($type == 'mob') {
            $query = mysql_query("SELECT MobMap.id, MobMap.hp, Mob.name, Mob.maxHp, Mob.minDamage, Mob.maxDamage, Mob.experience, Mob.strength, Mob.dexterity, Mob.endurance, Mob.level FROM MobMap INNER JOIN Mob ON MobMap.idMob=Mob.id WHERE MobMap.id=$id AND MobMap.idMap=" . $character['idMap'] . " AND MobMap.coordinateX=" . $character['coordinateX'] . " AND MobMap.coordinateY=" . $character['coordinateY'] . " LIMIT 1");
        } else {
            return false;
        }

        if (mysql_num_rows($query) == 0) {
            return false;
        }

        return $this->createXmlFile($character, mysql_fetch_assoc($query), $type);
    }

    private function createXmlFile($character, $enemy, $enemyType) {
        $string = '<?xml version="1.0" encoding="utf-8"?><fight status="processing"></fight>';

        $xml = new SimpleXMLElement($string);

        $fighters = $xml->addChild('fighters');
        $fighter = $fighters->addChild('fighter');
        $fighter->addAttribute('group', 1);
        $fighter->addAttribute('id', 1);
        $fighter->addAttribute('status', 'inFight');
        $fighter->addChild('type', 'player');
        $fighter->addChild('idInDb', $character['id']);
        $fighter->addChild('name', $character['name']);
        $fighter->addChild('level', $character['level']);
        $fighter->addChild('hp', $character['hp']);
        $fighter->addChild('maxHp', $character['maxHp']);
        $fighter->addChild('strength', $character['strength']);
        $fighter->addChild('dexterity', $character['dexterity']);
        $fighter->addChild('endurance', $character['endurance']);
        $fighter->addChild('minDamage', $character['minDamage']);
        $fighter->addChild('maxDamage', $character['maxDamage']);
        $fighter->addChild('target', 2);
        $fighter->addChild('stepsViewed', 0);

        $fighter = $fighters->addChild('fighter');
        $fighter->addAttribute('group', 2);
        $fighter->addAttribute('id', 2);
        $fighter->addAttribute('status', 'inFight');
        $fighter->addChild('type', $enemyType);
        $fighter->addChild('idInDb', $enemy['id']);
        $fighter->addChild('name', $enemy['name']);
        $fighter->addChild('level', $enemy['level']);
        $fighter->addChild('hp', $enemy['hp']);
        $fighter->addChild('maxHp', $enemy['maxHp']);
        $fighter->addChild('strength', $enemy['strength']);
        $fighter->addChild('dexterity', $enemy['dexterity']);
        $fighter->addChild('endurance', $enemy['endurance']);
        $fighter->addChild('minDamage', $enemy['minDamage']);
        $fighter->addChild('maxDamage', $enemy['maxDamage']);
        $fighter->addChild('target', 1);
        $fighter->addChild('stepsViewed', 0);

        $events = $xml->addChild('events');
        $events->addAttribute('steps', 0);

        $filename = time() . '_' . $character['id'];
        $xml->asXML(SITEPATH . 'fights/' . $filename . '.xml');

        return array('filename' => $filename, 'id' => 1);
    }

    public function status($fight, $character) {
        $filename = SITEPATH . 'fights/' . $fight['filename'] . '.xml';

        if (!is_readable($filename)) {
            unset($_SESSION['user']['character']['fight']);
            die;
        }

        $status      = array('character' => array(), 'events' => array());
        $idInFight   = $fight['id'];

        $xml = simplexml_load_file($filename);

        $xmlCharacter   = $xml->xpath('/fight/fighters/fighter[@id=' . $idInFight . ']');
        $xmlCharacter   = $xmlCharacter[0];
        $stepsViewed    = (int)$xmlCharacter->stepsViewed;

        $events   = $xml->xpath('/fight/events');
        $events   = $events[0];
        $steps    = (int)$events->attributes()->steps;

        if ($stepsViewed >= $steps) {
            return $status;
        }

        $events                      = $xml->xpath('/fight/events/step[@id=' . $stepsViewed . ']/event');
        $xmlCharacter->stepsViewed   = $stepsViewed + 1;

        if ($xml->attributes()->status == 'finished') {
            unset($_SESSION['user']['character']['fight']);
        }

        $xml->asXML($filename);

        $status['character']['hp']   = (int)$xmlCharacter->hp;
        $status['events']            = $events;

        return $status;
    }
}
