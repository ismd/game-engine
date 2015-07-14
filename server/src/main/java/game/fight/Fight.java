package game.fight;

import com.google.gson.GsonBuilder;
import game.Online;
import game.layout.Cell;
import game.server.response.Response;
import org.java_websocket.WebSocket;
import org.java_websocket.exceptions.WebsocketNotConnectedException;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class Fight extends Thread {

    protected FightMember initiator;
    protected WebSocket initiatorWs;
    protected FightMember enemy;
    protected ArrayList<Step> steps = new ArrayList<>();

    Fight(FightMember initiator, WebSocket ws, FightMember enemy) {
        this.initiator = initiator;
        this.initiatorWs = ws;
        this.enemy = enemy;

        initiator.setFight(this);
        enemy.setFight(this);
    }

    @Override
    public void run() {
        try {
            while (initiator.getHp() > 0 && enemy.getHp() > 0) {
                sleep(3000);
                sendResult(calculateStep());
                notifyCell();
            }

            initiator.setFight(null);
            enemy.setFight(null);

            afterFight();
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }

    private void sendResult(Step step) {
        Response response = new Response(true, true, "fight-step");

        Map<String, Object> data = new HashMap<>();
        data.put("initiator", initiator);
        data.put("enemy", enemy);

        Map<String, Object> stepData = new HashMap<>();
        stepData.put("messages", step.getMessages());
        data.put("step", stepData);

        response.setData(data);

        String message = new GsonBuilder()
                .excludeFieldsWithoutExposeAnnotation()
                .create()
                .toJson(response);

        try {
            initiatorWs.send(message);
        } catch (WebsocketNotConnectedException e) {
        }
    }

    private Step calculateStep() {
        int initiatorStrike = strike(initiator, enemy);
        int enemyStrike = strike(enemy, initiator);

        int initiatorHp = initiator.getHp() - enemyStrike;
        int enemyHp = enemy.getHp() - initiatorStrike;

        initiator.setHp(initiatorHp);
        enemy.setHp(enemyHp);

        Step step = new Step();
        step.addMessage(initiator.getName() + " ударил " + enemy.getName() + " на " + initiatorStrike + " hp");
        step.addMessage(enemy.getName() + " ударил " + initiator.getName() + " на " + enemyStrike + " hp");

        steps.add(step);
        return step;
    }

    private void notifyCell() {
        Cell cell = initiator.getCell();

        Online.notifier.notifyByCharacter(
                cell.getCharacters(),
                new Response(true, true, "cell-update").appendData("cell", cell));
    }

    private int strike(FightMember fm1, FightMember fm2) {
        return fm1 == initiator ? 1 : 0;
    }

    public FightMember getInitiator() {
        return initiator;
    }

    public FightMember getEnemy() {
        return enemy;
    }

    public ArrayList<Step> getSteps() {
        return steps;
    }

    void afterFight() {
    }
}
