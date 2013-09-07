package game.server;

import java.io.FileNotFoundException;
import java.net.InetSocketAddress;
import java.net.UnknownHostException;
import java.util.concurrent.Executors;
import java.util.concurrent.ExecutorService;
import org.java_websocket.WebSocket;
import org.java_websocket.handshake.ClientHandshake;
import org.java_websocket.server.WebSocketServer;

/**
 * @author ismd
 */
class Server extends WebSocketServer {

    private final ExecutorService executor = Executors.newCachedThreadPool();
    private final RequestRouter requestRouter;

    Server(int port, String layoutsPath) throws UnknownHostException, FileNotFoundException {
        super(new InetSocketAddress(port));
        requestRouter = new RequestRouter(layoutsPath);
    }

    @Override
    public void onOpen(WebSocket ws, ClientHandshake ch) {
        System.out.println("Connected from "
            + ws.getRemoteSocketAddress().getAddress().getHostAddress());
    }

    @Override
    public void onClose(WebSocket ws, int i, String string, boolean bln) {
        //requestRouter.removeCharacter(ws);
        System.out.println("Disconnected from "
            + ws.getRemoteSocketAddress().getAddress().getHostAddress());
    }

    @Override
    public void onMessage(WebSocket ws, String message) {
        System.out.println("Message: " + message);
        executor.execute(new RequestHandler(ws, requestRouter, message));
    }

    @Override
    public void onError(WebSocket ws, Exception ex) {
        System.out.println(ex.getMessage());
    }
}
