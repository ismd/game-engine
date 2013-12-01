package game.dao;

/**
 * @author ismd
 */
public class DaoFactory {

    private static DaoFactory instance = null;

    public final CharacterDao characterDao;
    public final LayoutDao layoutDao;
    public final MobDao mobDao;
    public final NpcDao npcDao;
    public final UserDao userDao;
    public final ChatMessageDao chatMessageDao;

    private DaoFactory() {
        characterDao = new CharacterDao();
        layoutDao = new LayoutDao();
        mobDao = new MobDao();
        npcDao = new NpcDao();
        userDao = new UserDao();
        chatMessageDao = new ChatMessageDao();
    }

    public static synchronized DaoFactory getInstance() {
        if (null == instance) {
            instance = new DaoFactory();
        }

        return instance;
    }
}
