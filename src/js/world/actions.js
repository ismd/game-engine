$(document).ready(function() {
    $('button#move-left').click(function() {
        Map.move(-1, 0);
    });

    $('button#move-right').click(function() {
        Map.move(1, 0);
    });

    $('button#move-top').click(function() {
        Map.move(0, -1);
    });

    $('button#move-bottom').click(function() {
        Map.move(0, 1);
    });
});
