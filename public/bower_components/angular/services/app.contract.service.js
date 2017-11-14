angular.module('app.contracts', [])

.service('Contracts', ['$http', function($http) {
    
    var api_url_list = '/master/contratos/get';
    
    return {
        all: all,
        getQ: getQ,
        getParticipations: getParticipations,
        destroyParticipation: destroyParticipation
    };
    
    
    function all() {
                
        return $http.get(api_url_list)
        
        .then(function(resp) {
            
            // return
            return resp.data;
            
        }) 
        
        .catch(function(resp) {
            
            throw new Error(resp);

        });
        
    }

    function getQ(number, _limit) {
                
        return $http.get('/master/contratos/getQ', {

            headers: {
                'Content-Type': 'application/json'
            },

            params: {
                number: number,
                _limit: _limit
            }

        })
        
        .then(function(resp) {
            
            // return
            return resp.data;
            
        }) 
        
        .catch(function(resp) {
            
            throw new Error(resp);

        });
        
    }


    function getParticipations(contract_id) {
                
        return $http.get('/master/contratos/' + contract_id + '/participations', {

            headers: {
                'Content-Type': 'application/json'
            }

        })
        
        .then(function(resp) {
            
            // return
            return resp.data;
            
        }) 
        
        .catch(function(resp) {
            
            throw new Error(resp);

        });
        
    }

    function destroyParticipation(id) {

        return $http.delete('/master/identificacao/' + id + '/delete', {

            headers: {
                'Content-Type': 'application/json'
            }

        })
        
        .then(function(resp) {
            
            // return
            return resp.data;
            
        }) 
        
        .catch(function(resp) {
            
            throw new Error(resp);

        });
    }

        
}])
