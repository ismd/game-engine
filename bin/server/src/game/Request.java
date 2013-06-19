package game;

import java.util.Map;

/**
 * @author ismd
 */
public class Request {

    private String command;
    private Map<String, String> args;

    public Request(String command, Map<String, String> args) {
        this.command = command;
        this.args = args;
    }

    public String getCommand() {
        return command;
    }

    public Map<String, String> getArgs() {
        return args;
    }
}
