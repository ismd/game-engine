package game.models.common;

/**
 * @author ismd
 */
abstract public class AbstractCharacter {

    private int _id;
    private int _idUser;
    private String _name;
    private int _level;
    private int _money;
    private int _hp;
    private int _maxHp;
    private int _minDamage;
    private int _maxDamage;
    private int _experience;
    private String _image;
    private int _strength;
    private int _dexterity;
    private int _endurance;
    private int _idMap;
    private int _x;
    private int _y;

    public int getId() {
        return _id;
    }

    public AbstractCharacter setId(int id) {
        _id = id;
        return this;
    }

    public int getIdUser() {
        return _idUser;
    }

    public AbstractCharacter setIdUser(int idUser) {
        _idUser = idUser;
        return this;
    }

    public String getName() {
        return _name;
    }

    public AbstractCharacter setName(String name) {
        _name = name;
        return this;
    }

    public int getLevel() {
        return _level;
    }

    public AbstractCharacter setLevel(int level) {
        _level = level;
        return this;
    }

    public int getMoney() {
        return _money;
    }

    public AbstractCharacter setMoney(int money) {
        _money = money;
        return this;
    }

    public int getHp() {
        return _hp;
    }

    public AbstractCharacter setHp(int hp) {
        _hp = hp;
        return this;
    }

    public int getMaxHp() {
        return _maxHp;
    }

    public AbstractCharacter setMaxHp(int maxHp) {
        _maxHp = maxHp;
        return this;
    }

    public int getMinDamage() {
        return _minDamage;
    }

    public AbstractCharacter setMinDamage(int minDamage) {
        _minDamage = minDamage;
        return this;
    }

    public int getMaxDamage() {
        return _maxDamage;
    }

    public AbstractCharacter setMaxDamage(int maxDamage) {
        _maxDamage = maxDamage;
        return this;
    }

    public int getExperience() {
        return _experience;
    }

    public AbstractCharacter setExperience(int experience) {
        _experience = experience;
        return this;
    }

    public String getImage() {
        return _image;
    }

    public AbstractCharacter setImage(String image) {
        _image = image;
        return this;
    }

    public int getStrength() {
        return _strength;
    }

    public AbstractCharacter setStrength(int strength) {
        _strength = strength;
        return this;
    }

    public int getDexterity() {
        return _dexterity;
    }

    public AbstractCharacter setDexterity(int dexterity) {
        _dexterity = dexterity;
        return this;
    }

    public int getEndurance() {
        return _endurance;
    }

    public AbstractCharacter setEndurance(int endurance) {
        _endurance = endurance;
        return this;
    }

    public int getIdMap() {
        return _idMap;
    }

    public AbstractCharacter setIdMap(int idMap) {
        _idMap = idMap;
        return this;
    }

    public int getX() {
        return _x;
    }

    public AbstractCharacter setX(int x) {
        _x = x;
        return this;
    }

    public int getY() {
        return _y;
    }

    public AbstractCharacter setY(int y) {
        _y = y;
        return this;
    }
}
