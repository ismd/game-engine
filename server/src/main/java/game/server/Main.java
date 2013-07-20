package game.server;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.UnknownHostException;

/**
 * @author ismd
 */
public class Main {

    public static void main(String[] args) throws IOException {
        if (1 != args.length) {
            System.out.println("Usage: server.jar <layoutsPath>");
            return;
        }

        try {
            Server server = new Server(8081, args[0]);
            server.start();
            System.out.println("Server started on port: " + server.getPort());
        } catch (UnknownHostException e) {
            System.out.println(e.getMessage());
        } finally {
            BufferedReader reader = new BufferedReader(new InputStreamReader(System.in));

            while (true) {
                String in = reader.readLine();
                System.out.println(in);
            }
        }
    }
}
