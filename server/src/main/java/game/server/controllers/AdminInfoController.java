package game.server.controllers;

import game.Online;
import game.character.Character;
import game.server.controllers.common.AbstractAdminController;
import game.server.request.Request;
import game.server.response.Response;
import game.user.User;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class AdminInfoController extends AbstractAdminController {

    public Response getInfoAction(Request request, User user) {
        List<Map<String, String>> characters = new ArrayList<>();

        for (Character ch : Online.characters) {
            Map<String, String> item = new HashMap<>();

            item.put("name", ch.getName());
            item.put("user_login", ch.getUser().getLogin());

            characters.add(item);
        }

        return new Response(true)
                .appendData("characters", characters);
    }
}
