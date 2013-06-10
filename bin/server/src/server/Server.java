package server;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.UnknownHostException;

/**
 * @author ismd
 */
public class Server {

    public static void main(String[] args) throws UnknownHostException, IOException {
        ServerImpl server = new ServerImpl(8887);
        server.start();

        System.out.println("Server started on port: " + server.getPort());

        BufferedReader reader = new  BufferedReader(new InputStreamReader(System.in));
        while (true) {
            String in = reader.readLine();
            System.out.println(in);
        }
    }
}
