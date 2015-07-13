(function() {
    'use strict';

    window.mainModule.controller('ChatCtrl', ['$scope', '$timeout', 'Chat', function($scope, $timeout, Chat) {
        $scope.chat = {
            messages: [],
            members: [],
            message: null
        };

        var TIMEZONE_OFFSET      = new Date().getTimezoneOffset(),
            MAX_MESSAGES_IN_CHAT = 100;

        Chat.focus();

        Chat.init().then(function(data) {
            setMessages(data.messages);
            $scope.chat.members = data.members;

            $timeout(function() {
                Chat.scrollMessages();
            });
        });

        $scope.$on('chat-new-messages', function(e, data) {
            setMessages(data.messages);
            $scope.$apply();

            $timeout(function() {
                Chat.scrollMessages();
            });
        });

        $scope.$on('chat-add-new-messages', function(e, messages) {
            for (var i = 0; i < messages.length; i++) {
                var message = messages[i];

                messages[i] = {
                    message: message,
                    sended: Date.now(),
                    sender: {
                        type: 'system'
                    }
                };
            }

            setMessages(messages);
        });

        $scope.$on('chat-update-members', function(e, data) {
            $scope.chat.members = data.members;
            $scope.$apply();
        });

        $scope.sendMessage = function(message) {
            if (null === message) {
                return;
            }

            Chat.send(message).then(function() {
                $scope.chat.message = null;
                Chat.focus();
            });
        };

        function setMessages(messages) {
            for (var i = 0; i < messages.length; i++) {
                var message = messages[i];

                message.sended = new Date(message.sended);
                message.sended = message.sended.setMinutes(message.sended.getMinutes() - TIMEZONE_OFFSET);

                $scope.chat.messages.push(message);
            }

            while ($scope.chat.messages.length > MAX_MESSAGES_IN_CHAT) {
                $scope.chat.messages.shift();
            }
        }

        $scope.answerMember = function(character) {
            Chat.focus(character.name + ', ');
        };
    }]);
})();
