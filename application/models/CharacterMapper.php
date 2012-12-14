<?php
/**
 * Модель персонажа
 *
 * @author ismd
 */

class CharacterMapperNotFoundException extends Exception {
    protected $message = 'Персонаж не найден';
};

class CharacterMapperLongName extends Exception {
    protected $message = 'Имя слишком длинное';
};

class CharacterMapperShortName extends Exception {
    protected $message = 'Имя слишком короткое';
};

class CharacterMapperNameExists extends Exception {
    protected $message = 'Персонаж с таким именем уже существует';
};

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
            . "idMap, x, y, "
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
            . "idMap, x, y, "
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
     * @param User $user
     * @return Character[]
     */
    public function getByUser(User $user) {
        $query = $this->db->query("SELECT id, idUser, name, level, money, "
            . "idMap, x, y, strength, dexterity, "
            . "endurance, hp, maxHp, minDamage, maxDamage, image, experience "
            . "FROM `Character` "
            . "WHERE idUser = $user->id");

        $characters = array();
        while ($character = $query->fetch_assoc()) {
            $characters[] = new Character($character);
        }

        return $characters;
    }

    /**
     * Возвращает персонажей на клетке
     *
     * @param Cell $cell
     * @return Character[]
     */
    public function getByCell(Cell $cell) {
        $query = $this->db->query("SELECT id, idUser, name, level, money, idMap, "
            . "x, y, strength, dexterity, endurance, "
            . "hp, maxHp, minDamage, maxDamage, image, experience "
            . "FROM `Character` "
            . "WHERE idMap = " . $cell->map->id . " "
            . "AND x = $cell->x AND y = $cell->y");

        $characters = array();
        while ($character = $query->fetch_assoc()) {
            $characters[] = new Character($character);
        }

        return $characters;
    }

    /**
     * Перемещает персонажа на клетку в базе
     *
     * @param Character $character
     * @param Cell $cell
     */
    public function move(Character $character, Cell $cell) {
        $this->db->query("UPDATE `Character` "
            . "SET idMap = " . $cell->map->id . ", x = $cell->x, "
            . "y = $cell->y "
            . "WHERE id = $character->id "
            . "LIMIT 1");
    }

    /**
     * Создаёт персонажа в базе
     *
     * @param Character $character
     * @throws CharacterMapperLongName
     * @throws CharacterMapperShortName
     * @throws CharacterMapperNameExists
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
            throw new Exception("CharacterMapper currently can't update rows");
        }

        $name = $this->db->real_escape_string($character->name);

        $this->db->query("INSERT INTO `Character` (idUser, name, level, money, idMap, "
            . "x, y, strength, dexterity, endurance, "
            . "hp, maxHp, minDamage, maxDamage, image, experience) "
            . "VALUES ($character->idUser, '$name', $character->level, "
            . "$character->money, $character->idMap, $character->x, "
            . "$character->y, $character->strength, $character->dexterity, "
            . "$character->endurance, $character->hp, $character->maxHp, "
            . "$character->minDamage, $character->maxDamage, '$character->image', "
            . "$character->experience)"
        );

        // TODO: сделать update, чтобы сохранялся персонаж. но надо ли?
    }
}
