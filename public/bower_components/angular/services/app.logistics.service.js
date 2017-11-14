angular.module('app.logistics', [])

.service('Correios', ['$http', function($http) {
    
    return {
        getCEP: getCEP,
        getStates: getStates
    };
    
    
    function getCEP(cep) {
                
        return $http.get('/logistics/correios/cep/' + cep)
        
        .then(function(resp) {

            // return
            return resp.data;
            
        }) 
        
        .catch(function(resp) {
            
            throw new Error(resp);

        });
        
    }

    function getStates() {

        return $http.get('/logistics/correios/states/')
        
        .then(function(resp) {

            // return
            return resp.data;
            
        }) 
        
        .catch(function(resp) {
            
            return resp;

        });
    }
        
}])
