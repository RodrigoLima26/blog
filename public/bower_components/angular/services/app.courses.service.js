angular.module('app.courses', [])

.service('Courses', ['$http', function($http) {
    
    var api_url_list = '/master/cursos/get';
    
    return {
        all: all,
    };
    
    
    function all() {
                
        return $http.get(api_url_list)
        
        .then(function(resp) {
            
            // return
            return resp.data;
            
        }) 
        
        .catch(function(resp) {
            
            return resp;

        });
        
    }

}])
