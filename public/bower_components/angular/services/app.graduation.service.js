angular.module('app.graduation', [])

.service('GraduationClothes', ['$http', function($http) {
    
    return {
        getGbs: getGbs,
        getGgs: getGgs
    };
    
    
    function getGbs() {
                
        return $http.get('/master/tamanhos-faixa/get')
        
        .then(function(resp) {
            
            // return
            return resp.data;
            
        }) 
        
        .catch(function(resp) {
            
            return resp;

        });
        
    }

    function getGgs() {
                
        return $http.get('/master/tamanhos-beca/get')
        
        .then(function(resp) {
            
            // return
            return resp.data;
            
        }) 
        
        .catch(function(resp) {
            
            return resp;

        });
        
    }

}])
