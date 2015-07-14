package game.server.response;

import com.google.gson.annotations.Expose;
import java.util.HashMap;
import java.util.Map;

/**
 * @author ismd
 */
public class Response {

    @Expose
    private int idCallback;
    @Expose
    private Map<String, Object> data = new HashMap();
    @Expose
    private boolean status;
    @Expose
    private String message;
    @Expose
    private boolean broadcast = false;
    @Expose
    private String broadcastName;

    public Response(boolean status, String message, boolean broadcast, String broadcastName) {
        this.status = status;
        this.message = message;
        this.broadcast = broadcast;
        this.broadcastName = broadcastName;
    }

    public Response(boolean status) {
        this(status, null, false, null);
    }

    public Response(boolean status, boolean broadcast, String broadcastName) {
        this(status, null, broadcast, broadcastName);
    }

    public Response(boolean status, String message) {
        this(status, message, false, null);
    }

    public int getIdCallback() {
        return idCallback;
    }

    public Response setIdCallback(int idCallback) {
        this.idCallback = idCallback;
        return this;
    }

    public Map<String, Object> getData() {
        return data;
    }

    public Response setData(Map<String, Object> data) {
        this.data = data;
        return this;
    }

    public Response appendData(String key, Object value) {
        data.put(key, value);
        return this;
    }

    public Response setBroadcast(boolean broadcast) {
        this.broadcast = broadcast;
        return this;
    }
}
