angular.module('app.agenda', [])

.service('Agenda', ['$http', function($http) {
    
    var api_url_list = '/master/agenda/get';
    
    return {
        all: all,
    };
    
    
    function all(contract_id) {
        
        var config = {
            params: {
                'contract_id': contract_id
            }
        }

        return $http.get(api_url_list, config)
        
        .then(function(resp) {
            
            // return
            return resp.data;
            
        }) 
        
        .catch(function(resp) {
            
            return resp;

        });
        
    }
        
}])
