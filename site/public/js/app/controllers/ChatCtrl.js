'use strict';

function ChatCtrl($scope, Chat) {
    $scope.chat = [];
    $scope.message = null;

    $scope.$on('chat-new-messages', function(e, data) {
        for (var i = 0; i < data.messages.length; i++) {
            $scope.chat.push(data.messages[i]);
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
