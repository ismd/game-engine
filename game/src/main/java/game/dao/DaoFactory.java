package game.dao;

/**
 * @author ismd
 */
public class DaoFactory {

    private static DaoFactory instance = null;

    private static CharacterDao characterDao = null;
    private static LayoutDao layoutDao = null;
    private static MobDao mobDao = null;
    private static NpcDao npcDao = null;
    private static UserDao userDao = null;
    private static ChatMessageDao chatMessageDao = null;

    private DaoFactory() {
    }

    public static synchronized DaoFactory getInstance() {
        if (null == instance) {
            instance = new DaoFactory();
        }

        return instance;
    }

    public CharacterDao getCharacterDao() {
        if (null == characterDao) {
            characterDao = new CharacterDao();
        }

        return characterDao;
    }

    public LayoutDao getLayoutDao() {
        if (null == layoutDao) {
            layoutDao = new LayoutDao();
        }

        return layoutDao;
    }

    public MobDao getMobDao() {
        if (null == mobDao) {
            mobDao = new MobDao();
        }

        return mobDao;
    }

    public NpcDao getNpcDao() {
        if (null == npcDao) {
            npcDao = new NpcDao();
        }

        return npcDao;
    }

    public UserDao getUserDao() {
        if (null == userDao) {
            userDao = new UserDao();
        }

        return userDao;
    }

    public ChatMessageDao getChatMessageDao() {
        if (null == chatMessageDao) {
            chatMessageDao = new ChatMessageDao();
        }

        return chatMessageDao;
    }
}
