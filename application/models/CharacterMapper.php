<?php
/**
 * Модель персонажа
 *
 * @author ismd
 */

class CharacterMapperNotFoundException extends Exception {};
class CharacterMapperLongName extends Exception {};
class CharacterMapperShortName extends Exception {};
class CharacterMapperNameExists extends Exception {};
class CharacterMapperAlreadyHasId extends Exception {};

class CharacterMapper extends AbstractDbMapper {

    /**
     * Возвращает персонажа по id
     *
     * @param int $id
     * @return Character
     * @throws CharacterMapperNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $query = $this->db->query("SELECT id, idUser, name, level, money, "
            . "idMap, coordinateX, coordinateY, "
            . "strength, dexterity, endurance, hp, maxHp, minDamage, "
            . "maxDamage, image, experience "
            . "FROM `Character` WHERE id = $id LIMIT 1");

        if ($query->num_rows == 0) {
            throw new CharacterMapperNotFoundException;
        }

        return new Character($query->fetch_assoc());
    }

    /**
     * Возвращает персонажа по имени
     * Не рекомендуется использовать данный метод
     * Необходимо использовать только в случае проверки на занятость имени
     *
     * @param string $name
     * @return Character
     * @throws CharacterMapperNotFoundException
     */
    public function getByName($name) {
        $name = $this->db->real_escape_string($name);

        $query = $this->db->query("SELECT id, idUser, name, level, money, "
            . "idMap, coordinateX, coordinateY, "
            . "strength, dexterity, endurance, hp, maxHp, minDamage, "
            . "maxDamage, image, experience "
            . "FROM `Character` WHERE name = '$name' LIMIT 1");

        if ($query->num_rows == 0) {
            throw new CharacterMapperNotFoundException;
        }

        return new Character(mysql_fetch_assoc($query));
    }

    /**
     * Возвращает массив персонажей пользователя
     *
     * @param int $idUser id пользователя
     * @return array Массив объектов типа Character
     */
    public function getByUser($idUser) {
        $idUser = (int)$idUser;

        $query = $this->db->query("SELECT id, idUser, name, level, money, "
            . "idMap, coordinateX, coordinateY, strength, dexterity, "
            . "endurance, hp, maxHp, minDamage, maxDamage, image, experience "
            . "FROM `Character` WHERE idUser = $id");

        $characters = array();
        while ($character = mysql_fetch_assoc($query)) {
            $characters[] = new Character($character);
        }

        return $characters;
    }

    /**
     * Возвращает персонажей на клетке
     *
     * @param int $idMap
     * @param int $x
     * @param int $y
     * @return array Массив объектов класса Character
     */
    public function getOnCell($idMap, $x, $y) {
        $idMap = (int)$idMap;
        $x     = (int)$x;
        $y     = (int)$y;

        $query = $this->db->query("SELECT id, idUser, name, level, money, idMap, "
            . "coordinateX, coordinateY, strength, dexterity, endurance, "
            . "hp, maxHp, minDamage, maxDamage, image, experience "
            . "FROM `Character` "
            . "WHERE idMap = $idMap AND coordinateX = $x AND coordinateY = $y");

        $characters = array();
        while ($character = $query->fetch_assoc()) {
            $characters[] = new Character($character);
        }

        return $characters;
    }

    /**
     * Перемещает персонажа на заданные координаты в базе
     *
     * @param int $idCharacter
     * @param int $idMap
     * @param int $x
     * @param int $y
     */
    public function move($idCharacter, $idMap, $x, $y) {
        $idCharacter = (int)$idCharacter;
        $idMap       = (int)$idMap;
        $x           = (int)$x;
        $y           = (int)$y;

        $this->db->query("UPDATE `Character` "
            . "SET idMap = $idMap, coordinateX = $x, coordinateY = $y "
            . "WHERE id = $idCharacter LIMIT 1");
    }

    /**
     * Создаёт персонажа в базе
     *
     * @param Character $character
     * @throws CharacterMapperLongName
     * @throws CharacterMapperShortName
     * @throws CharacterMapperNameExists
     * @throws CharacterMapperAlreadyHasId
     */
    public function save(Character $character) {
        // TODO: валидация

        if (mb_strlen($character->name) > 30) {
            throw new CharacterMapperLongName;
        }

        if (mb_strlen($character->name) < 4) {
            throw new CharacterMapperShortName;
        }

        // Проверяем, не занят ли логин
        if ($this->getByName($character->name) != null) {
            throw new CharacterMapperNameExists;
        }

        if (null != $character->id) {
            throw new CharacterMapperAlreadyHasId;
        }

        $name = $this->db->real_escape_string($character->name);

        $this->db->query("INSERT INTO `Character` (idUser, name, level, money, idMap, "
            . "coordinateX, coordinateY, strength, dexterity, endurance, "
            . "hp, maxHp, minDamage, maxDamage, image, experience) "
            . "VALUES ($character->idUser, '$name', $character->level, "
            . "$character->money, $character->idMap, $character->coordinateX, "
            . "$character->coordinateY, $character->strength, $character->dexterity, "
            . "$character->endurance, $character->hp, $character->maxHp, "
            . "$character->minDamage, $character->maxDamage, '$character->image', "
            . "$character->experience)"
        );

        // TODO: сделать update, чтобы сохранялся персонаж. но надо ли?
    }
}
