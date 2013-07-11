<?php
/**
 * Модель персонажа
 * @author ismd
 */

class CharacterNotFoundException extends Exception {
    protected $message = 'Персонаж не найден';
};

class CharacterLongNameException extends Exception {
    protected $message = 'Имя не может быть длиннее 30 символов';
};

class CharacterShortNameException extends Exception {
    protected $message = 'Имя не может быть короче 4 символов';
};

class CharacterNameExistsException extends Exception {
    protected $message = 'Введённое имя уже занято';
};

class CharacterMapper extends PsDbMapper {

    /**
     * Возвращает персонажа по id
     * @param int $id
     * @return Character
     * @throws CharacterNotFoundException
     */
    public function getById($id) {
        $id = (int)$id;

        $stmt = $this->db->prepare("SELECT id, idUser, name, lvl, money, "
            . "idLayout, x, y, "
            . "strength, dexterity, endurance, hp, maxHp, minDamage, "
            . "maxDamage, image, experience "
            . "FROM `Character` "
            . "WHERE id = ? "
            . "LIMIT 1");

        $stmt->bind_param('d', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (0 == $result->num_rows) {
            throw new CharacterNotFoundException;
        }

        return new Character($result->fetch_assoc());
    }

    /**
     * Возвращает персонажа по имени
     * Не рекомендуется использовать данный метод
     * Необходимо использовать только в случае проверки на занятость имени
     * @param string $name
     * @return Character
     * @throws CharacterNotFoundException
     */
    public function getByName($name) {
        $stmt = $this->db->prepare("SELECT id, idUser, name, lvl, money, "
            . "idLayout, x, y, strength, dexterity, endurance, hp, maxHp, "
            . "minDamage, maxDamage, image, experience "
            . "FROM `Character` "
            . "WHERE name = ? "
            . "LIMIT 1");

        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if (0 == $result->num_rows) {
            throw new CharacterNotFoundException;
        }

        return new Character($result->fetch_assoc());
    }

    /**
     * Возвращает массив персонажей пользователя
     * @param User $user
     * @return Character[]
     */
    public function getByUser(User $user) {
        $stmt = $this->db->prepare("SELECT id, idUser, name, lvl, money, "
            . "idLayout, x, y, strength, dexterity, "
            . "endurance, hp, maxHp, minDamage, maxDamage, image, experience "
            . "FROM `Character` "
            . "WHERE idUser = ?");

        $stmt->bind_param('d', $user->getId());
        $stmt->execute();
        $result = $stmt->get_result();

        $characters = array();
        while ($character = $result->fetch_assoc()) {
            $characters[] = new Character($character);
        }

        return $characters;
    }

    /**
     * Возвращает персонажей на клетке
     * @param Cell $cell
     * @return Character[]
     */
    public function getByCell(Cell $cell) {
        $stmt = $this->db->prepare("SELECT id, idUser, name, lvl, money, idLayout, "
            . "x, y, strength, dexterity, endurance, "
            . "hp, maxHp, minDamage, maxDamage, image, experience "
            . "FROM `Character` "
            . "WHERE idLayout = ? AND x = ? AND y = ?");

        $stmt->bind_param('ddd',
            $cell->getLayout()->getId(),
            $cell->getX(),
            $cell->getY());
        $stmt->execute();
        $result = $stmt->get_result();

        $characters = array();
        while ($character = $result->fetch_assoc()) {
            $characters[] = new Character($character);
        }

        return $characters;
    }

    /**
     * Перемещает персонажа на клетку в базе
     * @param Character $character
     * @param Cell $cell
     */
    public function move(Character $character, Cell $cell) {
        $stmt = $this->db->prepare("UPDATE Character "
            . "SET idLayout = ?, x = ?, y = ? "
            . "WHERE id = ? "
            . "LIMIT 1");

        $stmt->bind_param('dddd',
            $cell->getLayout()->getId(),
            $cell->getX(),
            $cell->getY(),
            $character->getId());

        $stmt->execute();
    }

    /**
     * Создаёт персонажа в базе
     * @param Character $character
     * @return int id персонажа
     * @throws CharacterLongNameException
     * @throws CharacterShortNameException
     * @throws CharacterNameExistsException
     */
    public function save(Character $character) {
        // TODO: валидация

        $name = $character->getName();

        if (mb_strlen($name) > 30) {
            throw new CharacterLongNameException;
        }

        if (mb_strlen($name) < 4) {
            throw new CharacterShortNameException;
        }

        // Проверяем, не занят ли логин
        try {
            // Выбросит исключение, если персонаж с таким именем не найден
            $this->getByName($name);
            throw new CharacterNameExistsException;
        } catch (CharacterNotFoundException $e) {
        }

        // TODO: сделать update, чтобы сохранялся персонаж. но надо ли?
        if (null != $character->getId()) {
            throw new Exception("CharacterMapper currently can't update rows");
        }

        $stmt = $this->db->prepare("INSERT INTO `Character` "
            . "(idUser, name, lvl, money, idLayout, x, y, strength, dexterity, "
            . "endurance, hp, maxHp, minDamage, maxDamage, image, experience) "
            . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param('dsddddddddddddsd',
            $character->getIdUser(),
            $name,
            $character->getLevel(),
            $character->getMoney(),
            $character->getIdLayout(),
            $character->getX(),
            $character->getY(),
            $character->getStrength(),
            $character->getDexterity(),
            $character->getEndurance(),
            $character->getHp(),
            $character->getMaxHp(),
            $character->getMinDamage(),
            $character->getMaxDamage(),
            $character->getImage(),
            $character->getExperience());

        $stmt->execute();
        return $stmt->insert_id;
    }
}
