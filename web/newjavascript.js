var app = angular.module('Marsupilami', ['ngResource', 'angular-oauth2']);
app.controller('Marsupilami', function ($scope, $resource) {
    $scope.loading = false;

    $scope.removeFriend = function (id) {
        var token = "Bearer " + $scope.token;
        var url = "http://localhost/appartoo-back/web/app_dev.php/remove";
        var postaction = $resource(url, null, {
            'get': {
                method: 'GET',
                headers: {
                    'Authorization': token
                },
                params: {'id': id}
            }
        });
        postaction.get({
            'id': id
        },
        function (data) {
            $scope.getuser();
        },
                function (error) {
                });
    };

    $scope.addFriend = function (id) {
        var token = "Bearer " + $scope.token;
        var url = "http://localhost/appartoo-back/web/app_dev.php/add";
        var postaction = $resource(url, null, {
            'get': {
                method: 'GET',
                headers: {
                    'Authorization': token
                },
                params: {'id': id}
            }
        });
        postaction.get({
            'id': id
        },
        function (data) {
            console.log(data);
            $scope.getuser();
        },
                function (error) {
                });
    };

    $scope.invit = function () {
        var url = "http://localhost/appartoo-back/web/app_dev.php/invit";
        var postaction = $resource(url, null, {
            'post': {
                method: 'POST'
            }
        });
        postaction.post(null, {
            'email': $scope.invitation
        },
        function (data) {
            console.log(data);
            $("#btn_close_search_friend").click();
            $scope.init();
        },
                function (error) {
                });
    };
    $scope.token = '';

    $scope.login = function (id)
    {
        var url = "http://localhost/appartoo-back/web/app_dev.php/login";
        $scope.data = $scope.userlogin;
        console.log($scope.userlogin);
        var postaction = $resource(url, null,
                {
                    'post': {method: 'POST'}
                });
        postaction.post(null, $scope.data,
                function (data) {
                    var tokenn = data.token;
                    $scope.token = data.token;

                    $scope.getuser(data.token);
                },
                function (error) {
                    console.log("error");
                });
    };


    $scope.register = function (id)
    {
        var url = "http://localhost/appartoo-back/web/app_dev.php/register";
        formData = JSON.stringify($scope.registerUser);
        var postaction = $resource(url, null,
                {
                    'post': {method: 'POST'}
                });
        postaction.post(null, formData,
                function (data) {
                    if (data.msg == "The user has been created successfully")
                        alert("Votre nouveau compte a été créé avec succès ! Nous sommes heureux de vous accueillir ")
                    var tokenn = data.token;
                    $scope.token = data.token;

                    $scope.getuser(data.token);
                },
                function (error) {
                    console.log("error");
                });
    };

    $scope.search = function (token) {
        var token = "Bearer " + $scope.token;
        var url = "http://localhost/appartoo-back/web/app_dev.php/search";
        var postaction = $resource(url, null, {
            'get': {
                method: 'GET',
                headers: {
                    'Authorization': token
                },
                params: '$scope.keyword'
            }
        });
        postaction.get({
            'keyword': $scope.keyword
        },
        function (data) {
            console.log(data);
            if (data.users)
                console.log(data);
            $scope.searchFriends = data.users;
        },
                function (error) {
                });
    };

    $scope.getuser = function (token) {
        var token = "Bearer " + $scope.token;
        var url = "http://localhost/appartoo-back/web/app_dev.php/list";
        var postaction = $resource(url, null, {
            'get': {
                method: 'GET',
                headers: {
                    'Authorization': token
                },
                params: '$scope.keyword'
            }
        });
        postaction.get({
            'keyword': $scope.keyword
        },
        function (data) {
            console.log(data);
            $scope.users = data.users;
            $scope.user = data.user;
            $scope.editUser = angular.copy($scope.user);
            $scope.friends = data.user.friends;
        },
                function (error) {
                });
    };

    $scope.updateUser = function (id)
    {
        var token = "Bearer " + $scope.token;
        console.log("updateUser");
        var url = "http://localhost/appartoo-back/web/app_dev.php/profile/" + $scope.editUser.id;
        formData = JSON.stringify($scope.editUser);
        console.log(formData);
        console.log($scope.editUser);

        var postaction = $resource(url, null, {
            'put': {
                method: 'PUT',
                headers: {
                    'Authorization': token
                },
                params: formData
            }
        });
        postaction.put(
                
              formData
       
        
        ,
        function (data) {
            $scope.getuser();
        },
                function (error) {
                });
    };
});

app.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

app.run(['OAuth', function (OAuth) {
        OAuth.configure({
            baseUrl: 'http://localhost/appartoo-back/web/app_dev.php/login',
            clientId: '1_3bcbxd9e24g0gk4swg0kwgcwg4o8k8g4g888kwc44gcc0gwwk4',
            clientSecret: '4ok2x70rlfokc8g0wws8c8kwcokw80k44sg48goc0ok4w0so0k'
        });
    }]);