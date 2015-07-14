package game.fight;

import java.util.ArrayList;

class Step {

    ArrayList<String> messages = new ArrayList<>();

    Step addMessage(String message) {
        messages.add(message);
        return this;
    }

    ArrayList<String> getMessages() {
        return messages;
    }
}
