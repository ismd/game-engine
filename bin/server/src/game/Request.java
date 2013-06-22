package game;

import java.util.Map;

/**
 * @author ismd
 */
public class Request {

    private String controller;
    private String action;
    private Map<String, Object> args;

    public Request(String controller, String action, Map<String, Object> args) {
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
}
