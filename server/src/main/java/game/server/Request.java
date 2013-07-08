package game.server;

import java.util.Map;

/**
 * @author ismd
 */
class Request {

    private String controller;
    private String action;
    private Map<String, Object> args;
    private int idCallback;

    Request(String controller, String action, Map<String, Object> args) {
        this.controller = controller;
        this.action = action;
        this.args = args;
    }

    public String getController() {
        return controller;
    }

    public String getAction() {
        return action;
    }

    public Map<String, Object> getArgs() {
        return args;
    }

    public int getIdCallback() {
        return idCallback;
    }
}
