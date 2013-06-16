package game;

import java.net.InetSocketAddress;
import java.net.UnknownHostException;
import org.java_websocket.WebSocket;
import org.java_websocket.handshake.ClientHandshake;
import org.java_websocket.server.WebSocketServer;

/**
 * @author ismd
 */
class Server extends WebSocketServer {

    Server(int port) throws UnknownHostException {
        super(new InetSocketAddress(port));
    }

    @Override
    public void onOpen(WebSocket ws, ClientHandshake ch) {
        System.out.println("Connected from "
            + ws.getRemoteSocketAddress().getAddress().getHostAddress());
    }

    @Override
    public void onClose(WebSocket ws, int i, String string, boolean bln) {
        System.out.println("Disconnected from "
            + ws.getRemoteSocketAddress().getAddress().getHostAddress());
    }

    @Override
    public void onMessage(WebSocket ws, String string) {
        System.out.println("Message: " + string);
        ws.send(string);
    }

    @Override
    public void onError(WebSocket ws, Exception ex) {
        System.out.println(ex.getMessage());
    }
}
