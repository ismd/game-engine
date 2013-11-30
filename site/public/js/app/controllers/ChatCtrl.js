'use strict';

function ChatCtrl($scope, Chat) {
    $scope.chat = [];
    $scope.message = null;

    var offset = new Date().getTimezoneOffset();

    $scope.$on('chat-new-messages', function(e, data) {
        for (var i = 0; i < data.messages.length; i++) {
            var message = data.messages[i];

            message.sended = new Date(message.sended);
            message.sended = message.sended.setMinutes(message.sended.getMinutes() - offset);

            $scope.chat.push(message);
            $scope.$apply();
        }
    });

    $scope.sendMessage = function(message) {
        Chat.send(message).then(function() {
            $scope.message = null;
        });
    };
}

ChatCtrl.$inject = ['$scope', 'Chat'];
