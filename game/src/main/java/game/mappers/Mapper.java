package game.mappers;

import javax.persistence.EntityManager;
import javax.persistence.Persistence;

/**
 * @author ismd
 */
abstract class Mapper {

    protected final static EntityManager em = Persistence.createEntityManagerFactory("game").createEntityManager();
}
