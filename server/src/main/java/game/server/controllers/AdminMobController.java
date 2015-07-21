package game.server.controllers;

import game.server.request.Request;
import game.server.response.Response;
import game.user.User;

/**
 * Created by ismd on 7/17/15.
 */
public class AdminMobController {

    public Response moveAction(Request request, User user) {
        return new Response(true);
    }
}
