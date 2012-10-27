<?php
/**
 * Модель персонажа
 *
 * @author ismd
 */

class CharacterMapper {

    /**
     * Возвращает персонажа по id
     *
     * @param int $id
     */
    public function getById($id) {
        $id = (int)$id;

        $result = mysql_query("SELECT id, idUser, name, level, money, idMap, coordinateX, coordinateY, "
                            . "strength, dexterity, endurance, hp, maxHp, minDamage, maxDamage, image, experience "
                            . "FROM `Character` WHERE id=$id LIMIT 1");

        if (mysql_num_rows($result) == 0) {
            return null;
        }

        return new Character(mysql_fetch_assoc($result));
    }

    /**
     * Возвращает персонажа по имени
     * Не рекомендуется использовать данный метод
     * Необходимо использовать только в случае проверки на занятость имени
     *
     * @param string $name
     */
    public function getByName($name) {
        $name = htmlspecialchars(mysql_real_escape_string($name));

        $query = mysql_query("SELECT id, idUser, name, level, money, idMap, coordinateX, coordinateY, "
                            . "strength, dexterity, endurance, hp, maxHp, minDamage, maxDamage, image, experience "
                            . "FROM `Character` WHERE name='$name' LIMIT 1");

        if (mysql_num_rows($query) == 0) {
            return null;
        }

        return new Character(mysql_fetch_assoc($query));
    }

    /**
     * Возвращает персонажей на клетке
     *
     * @param int $idMap
     * @param int $x
     * @param int $y
     */
    public function getOnCell($idMap, $x, $y) {
        $idMap   = (int)$idMap;
        $x       = (int)$x;
        $y       = (int)$y;

        $query = mysql_query("SELECT id, idUser, name, level, money, idMap, coordinateX, coordinateY, "
                           . "strength, dexterity, endurance, hp, maxHp, minDamage, maxDamage, image, experience "
                           . "FROM `Character` WHERE idMap=$idMap AND coordinateX=$x AND coordinateY=$y");

        $characters = array();
        while ($character = mysql_fetch_assoc($query)) {
            $characters[] = new Character($character);
        }

        return $characters;
    }

    /**
     * Перемещает персонажа на заданные координаты в базе
     *
     * @param int $idCharacter
     * @param int $x
     * @param int $y
     */
    public function move($idCharacter, $x, $y) {
        $idCharacter   = (int)$idCharacter;
        $x             = (int)$x;
        $y             = (int)$y;

        mysql_query("UPDATE `Character` SET coordinateX=$x, coordinateY=$y WHERE id=$idCharacter LIMIT 1");
    }

    public function save(Character $character) {
        // TODO: валидация

        if ( mb_strlen($character->name) > 30 ) {
            return Character::CREATE_ERR_NAME_LENGTH_MAX;
        }

        if ( mb_strlen($character->name) < 4 ) {
            return Character::CREATE_ERR_NAME_LENGTH_MIN;
        }

        // Проверяем, не занят ли логин
        if ( $this->getByName($character->name) != null ) {
            return Character::CREATE_ERR_NAME_EXISTS;
        }

        $character->name = htmlspecialchars(mysql_real_escape_string($character->name));

        if ( empty($character->id) ) {
            mysql_query("INSERT INTO `Character` (idUser, name, level, money, idMap, coordinateX, coordinateY, "
                      . "strength, dexterity, endurance, hp, maxHp, minDamage, maxDamage, image, experience) "
                      . "VALUES ($character->idUser, '$character->name', $character->level, $character->money, "
                      . "$character->idMap, $character->coordinateX, $character->coordinateY, $character->strength, "
                      . "$character->dexterity, $character->endurance, $character->hp, $character->maxHp, "
                      . "$character->minDamage, $character->maxDamage, '$character->image', $character->experience)");
        }
        // TODO: сделать update, чтобы сохранялся персонаж. но надо ли?

        return true;
    }
}
