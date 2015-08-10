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

    public Response clone() throws CloneNotSupportedException{
        Response obj = (Response)super.clone();

        obj.setIdCallback(getIdCallback());
        obj.setData(getData());
        obj.setStatus(getStatus());
        obj.setMessage(getMessage());
        obj.setBroadcast(getBroadcast());
        obj.setBroadcastName(getBroadcastName());

        return obj;
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

    public boolean getStatus() {
        return status;
    }

    public String getMessage() {
        return message;
    }

    public boolean getBroadcast() {
        return broadcast;
    }

    public String getBroadcastName() {
        return broadcastName;
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

    public Response setStatus(boolean status) {
        this.status = status;
        return this;
    }

    public Response setMessage(String message) {
        this.message = message;
        return this;
    }

    public Response setBroadcastName(String broadcastName) {
        this.broadcastName = broadcastName;
        return this;
    }
}
