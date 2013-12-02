package game.server;

import game.Online;
import game.server.request.RequestHandler;
import game.server.request.RequestRouter;
import game.world.World;
import java.io.FileNotFoundException;
import java.net.InetSocketAddress;
import java.net.UnknownHostException;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import org.java_websocket.WebSocket;
import org.java_websocket.handshake.ClientHandshake;
import org.java_websocket.server.WebSocketServer;

/**
 * @author ismd
 */
class Server extends WebSocketServer {

    private final ExecutorService executor = Executors.newCachedThreadPool();

    Server(int port, String layoutsPath) throws UnknownHostException, FileNotFoundException {
        super(new InetSocketAddress(port));

        RequestRouter.init();
        Online.world = new World(layoutsPath);
    }

    @Override
    public void onOpen(WebSocket ws, ClientHandshake ch) {
        System.out.println("Connected from "
            + ws.getRemoteSocketAddress().getAddress().getHostAddress());
    }

    @Override
    public void onClose(WebSocket ws, int i, String string, boolean bln) {
        executor.execute(new Disconnector(ws));
    }

    @Override
    public void onMessage(WebSocket ws, String message) {
        System.out.println("Message: " + message);
        executor.execute(new RequestHandler(ws, message));
    }

    @Override
    public void onError(WebSocket ws, Exception ex) {
        System.out.println(ex.getMessage());
    }
}
