'use strict';

function ChatCtrl($scope, Chat) {
    $scope.chat = {
        messages: [],
        members: [],
        message: null
    };

    var offset = new Date().getTimezoneOffset();

    Chat.focus();

    Chat.init().then(function(data) {
        setMessages(data.messages);
        $scope.chat.members = data.members;
    });

    $scope.$on('chat-new-messages', function(e, data) {
        setMessages(data.messages);
        $scope.$apply();
    });

    $scope.$on('chat-update-members', function(e, data) {
        $scope.chat.members = data.members;
        $scope.$apply();
    });

    $scope.sendMessage = function(message) {
        Chat.send(message).then(function() {
            $scope.chat.message = null;
        });
    };

    function setMessages(messages) {
        for (var i = 0; i < messages.length; i++) {
            var message = messages[i];

            message.sended = new Date(message.sended);
            message.sended = message.sended.setMinutes(message.sended.getMinutes() - offset);

            $scope.chat.messages.push(message);
        }
    }

    $scope.answerMember = function(character) {
        //$scope.chat.message = character.name + ', ';
        Chat.focus(character.name + ', ');
    };
}

ChatCtrl.$inject = ['$scope', 'Chat'];
